<?php
session_start();  
require_once('../../bdd.php');
require_once('../../config.php');
include_once "../../recuperar_usuario.php";
include_once "../../phpqrcode/qrlib.php";
include_once "funciones_principales.php";

#-------------------------------------------  --------------------------------------------------------------------------------
$reci = $_REQUEST['idrb'];
$id_recibo = base64_decode($reci);

$url = "https://www.panamotorscenter.com/Prod/CCP/Perfiles2/Logistica/vista_web_wallet_recibo.php?idrb=$reci"; 
$filename = "../../Codigos_qr_recibos_wallet/codigoqridrb=$reci.png";
$level = 'H'; 
$tamaniopixel = 10;
$tamaniomargen = 1; 

QRcode::png($url,$filename,$level,$tamaniopixel,$tamaniomargen);

$query_recurso = "SELECT * FROM orden_logistica_recurso WHERE idorden_logistica_documentacion = '$id_recibo'";
$result_recurso = mysql_query($query_recurso);

while ($row_recurso = mysql_fetch_array($result_recurso)) {

 $idorden_logistica_recurso = $row_recurso[idorden_logistica_recurso];


 $fecha = date_create($row_recurso[fecha]);
 $fecha_movimiento = date_format($fecha, "d-m-Y");

 $monto = number_format($row_recurso[monto],2);
 $comentarios = $row_recurso[comentarios];
 $comentarios = ucwords(strtolower($comentarios));

 $metodo_pago = $row_recurso[metodo_pago];
 $tipo_cambio = $row_recurso[tipo_cambio];

 $monto_recurso = number_format($row_recurso[monto], 2)." $row_recurso[tipo_moneda]";

 $monto_letras = convertir($row_recurso[monto], $row_recurso[tipo_moneda]);

 $referencia = $row_recurso[referencia];

 $query_documentacion = "SELECT * FROM orden_logistica_documentacion WHERE idorden_logistica_documentacion ='$id_recibo'";
 $result_documentacion = mysql_query($query_documentacion);

 while ($row_documentacion = mysql_fetch_array($result_documentacion)) {

  $id_contacto = $row_documentacion[id_responsable];

  $ahow_id = nombres_datos($row_documentacion[id_responsable], $row_documentacion[tipo_responsable]);
  $porciones_id = explode("|", $ahow_id);

  $calle = ($porciones_id[7] == "") ? "Sin calle" : $porciones_id[7];
  $colonia = ($porciones_id[8] == "") ? "Sin colonia" : $porciones_id[8];
  $municipio = ($porciones_id[6] == "") ? "Sin municipio" : $porciones_id[6];
  $estado = ($porciones_id[5] == "") ? "Sin estado" : $porciones_id[5];





  $query_logistica = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$row_recurso[idorden_logistica]'";
  $result_logistica = mysql_query($query_logistica);

  while ($row_logistica = mysql_fetch_array($result_logistica)) {

    $show_responsble_logistica = nombres_datos($row_logistica[idasigna], $row_logistica[tipo_asignante]);
    $porciones_responsble_logistica = explode("|", $show_responsble_logistica);


  }


  $tipo_entrega_recepcion = ($row_documentacion[tipo] == "Entrega") ? "Entregado por:" : "Recibido por:";

}

}






$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
date_default_timezone_set('America/Mexico_City');

$date = date_create($fecha_recibo);
$dia = date_format($date, 'd');
$mes_aux = date_format($date, 'm');
$mes = ucfirst($meses[$mes_aux-1]);
$ano = date_format($date, 'Y');
$hora = date_format($date, 'H:i:s');

$fecha_impresion = "$dia $mes $ano $hora";

#-------------------------------------------  --------------------------------------------------------------------------------



$contenido='
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PANAMOTORS | Recibo</title>
<style type="text/css">
body{
  margin: 0;
  font-family: "geometric" !important;
}
p.text-datos-obs {
  font-size: 10px;
  height: 18px;
  display: block;
  color:gray;
  text-align: right;
  margin-top: -40px;
}
.tit1{
  font-size: 12px;
} 
.tit2{
  font-size: 10px;
}    
.tit3{
  font-size: 10px;
} 
.text-blanco{
  color: #fff;
} 
.text-vino{
  color: #882439;
}  
.text-derechos{
  line-height: 2px; 
  text-align: center;
} 
.text-dato-base{
  text-align: left; 
  color: #4E4043;
}
.tabla-1{
  width: 100%; 
        // border-top: 2px solid #cdcdcd; 
        // border-bottom: 2px solid #cdcdcd;
  border: 2px solid #cdcdcd;
  border-collapse: none;
} 
.tabla-1 tr td{
  padding: 10px;
}
.tabla-1 tr:nth-child(even){
  background: #F3F3F3;
} 
.c-dato-personal h6{
  font-size: 12px;
}
.m-t-100{
  margin-top: 100px;
}
</style>
</head>
<body>


<!--<div style="width: 100%;">
<div style="width: 60%; margin: auto;">
<div style="width: 150px; margin: auto;">
<img src="../../img/mercadotecnia/grupopanamotors.png" alt="" style="width: 150px;">
</div>
<div style="width: 300px; margin: auto;">
<img src="../../img/estado-cuenta-panamotors/logo_grupos2.png" alt="" style="width: 300px;">
</div>
</div>
</div>-->




<div style="width: 100%;">
<br>
<br>
<div class="c-dato-personal" style="width: 64%; float: left;">
<!--<h6 class="tit1">Acambay de Ruíz Castañeda</h6>-->
<h6 class="tit1" style="width: 100%;">
<div style="width: 16%; float: left; text-align: right; padding-right: 5px;">ID: </div>
<div style="width: 75%; float: left; font-weight: normal; color: #616161;">'.$id_contacto.'</div>
</h6>
<h6 class="tit1" style="width: 100%;">
<div style="width: 16%; float: left; text-align: right; padding-right: 5px;">Nombre: </div>
<div style="width: 75%; float: left; font-weight: normal; color: #616161;">'.$porciones_id[10].'</div>
</h6>
<h6 class="tit1" style="width: 100%;">
<div style="width: 16%; float: left; text-align: right; padding-right: 5px;">Calle: </div>
<div style="width: 75%; float: left; font-weight: normal; color: #616161;">'.$calle.'</div>
</h6>
<h6 class="tit1" style="width: 100%;">
<div style="width: 16%; float: left; text-align: right; padding-right: 5px;">Colonia: </div>
<div style="width: 75%; float: left; font-weight: normal; color: #616161;">'.$colonia.'</div>
</h6>
<h6 class="tit1" style="width: 100%;">
<div style="width: 16%; float: left; text-align: right; padding-right: 5px;">Municipio: </div>
<div style="width: 75%; float: left; font-weight: normal; color: #616161;">'.$municipio.'</div>
</h6>
<h6 class="tit1" style="width: 100%;">
<div style="width: 16%; float: left; text-align: right; padding-right: 5px;">Estado: </div>
<div style="width: 75%; float: left; font-weight: normal; color: #616161;">'.$estado.'</div>
</h6>


</div>
<div style="width: 35%; float: left;">
<h6 class="tit1" style="text-align: right;">Fecha: <span style="color: #616161;">'.$fecha_movimiento.'</span></h6>
<h6 class="tit1" style="text-align: right;">Recibo: <span style="color: #616161;">'.$referencia.'</span></h6>
</div>
</div>

<div style="margin-top: 20px;">
<table class="tabla-1">
<tr>
<td class="tit1" style="width: 33%; background: #ECECEC;"><b>Movimiento</b></td>
<td class="tit1" style="width: 33%; background: #ECECEC;"><b>Forma de pago</b></td>
<td class="tit1" style="width: 33%; background: #ECECEC;"><b>Tipo de cambio</b></td>
</tr>
<tr>
<td class="tit1">'.$comentarios.'</td>
<td class="tit1">'.$metodo_pago.'</td>
<td class="tit1">'.$tipo_cambio.'</td>
</tr>
</table>
</div>


<div style="margin-top: 20px;">
<table class="tabla-1">
<tr>
<td class="tit1" style="width: 20%;">TOTAL: </td>
<td class="tit1 text-dato-base" style="width: 80%;"> $ '.$monto_recurso.'</td>
</tr>

<tr>
<td></td>
<td class="tit1">'.$monto_letras.'</td>
</tr>
</table>
</div>




<div style="margin-top: 20px;">
<p class="tit1">'.$tipo_entrega_recepcion.' <span style="color: #616161;">'.$porciones_responsble_logistica[10].'</span></p>
<p style="font-size: 12px; margin-top: 20px;">Fecha impresión: <span style="color: #616161;">'.$fecha_impresion.'</span></p>
</div>

<div style="margin-top: 120px;">

</div>

</body>
</html>';

include("../../MPDF57/mpdf.php");
$mpdf=new mPDF('s','Letter','','','10','10','28','30'); 

$mpdf->SetHTMLHeader('<img src="../../img/estado-cuenta-panamotors/header_nombre_recibo.png" alt=""><br>');
$mpdf->SetHTMLFooter('
  <p class="text-datos-obs">
  <div style="width: 100%;">
  <div style="width: 80%; float: left;">
  <p class="tit3" style="text-align: center; color: #AFAEAE; margin-top: 80px; margin-left: 40px;">El presente recibo no es válido si los datos desplegados con la lectura del QR son diferentes al impreso. Valide la información y asegúrese de recibir un comprobante válido.</p>
  </div>
  <div style="width: 19%; float: left;">
  <div style="width: 100px; float: right;">
  <img src="'.$filename.'" style="width: 100px;">
  </div>
  </div>
  </div>
  <img src="../../img/estado-cuenta-panamotors/footer2.png" alt=""><p style="text-align: right; font-size: 10px; color: gray;">{PAGENO} de {nb}</p></p>
  ');

$mpdf->WriteHTML($contenido);

$mpdf->Output("Folio_".$referencia.".pdf", 'I');

exit;

?>