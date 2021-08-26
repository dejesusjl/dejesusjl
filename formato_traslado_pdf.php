<?php

$reci=$_REQUEST['idc'];
$id_recibo=base64_decode($reci);

$vin_ver = base64_decode($_REQUEST['vin_ver']);

$n1=strlen($id_recibo);
$n1_aux=10-$n1;
$mat="";

for ($i=0; $i <$n1_aux ; $i++) { 
  $mat.="0";
}

$id_recibo_completo=$mat.$id_recibo;


include_once "../../config.php"; 


$query_logistica = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$id_recibo'";
$result_logistica = mysql_query($query_logistica);
while ($row_logistica = mysql_fetch_array($result_logistica)) {
  $origen_logistica = "$row_logistica[municipio_origen]".", "."$row_logistica[estado_origen]";
  $destino_logistica = "$row_logistica[municipio_destino]".", "."$row_logistica[estado_destino]";
  $fecha_recibo = "$row_logistica[fecha_solicitud]";
}

$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
date_default_timezone_set('America/Mexico_City');

$date = date_create($fecha_recibo);
$dia=date_format($date, 'd');
$mes_aux=date_format($date, 'm');
$mes=ucfirst($meses[$mes_aux-1]);
$ano=date_format($date, 'Y');
$hora=date_format($date, 'H:i:s');

$n2=strlen($id_recibo);
$n2_aux=6-$n1;
$mat2="";

for ($i2=0; $i2 <$n2_aux ; $i2++) { 
  $mat2.="0";
}

$id_contacto_completo = "L".$mat2.$id_recibo;

$query_unidades = "SELECT * FROM orden_logistica_unidades WHERE idorden_logistica = '$id_recibo' and visible = 'SI' and vin = '$vin_ver'";
$result_unidades = mysql_query($query_unidades);
while ($row_unidades = mysql_fetch_array($result_unidades)) {
  $unidad_logistca ++;
  $idorden_logistica_unidades = "$row_unidades[idorden_logistica_unidades]";
  $tipo_orden = "$row_unidades[tipo_orden]";
  $vin_logistica_unidades = "$row_unidades[vin]";
  $cadena = "$row_unidades[vin]";
  $tipo_unidad = "$row_unidades[tipo_unidad]";
  $idresponsable = "$row_unidades[idresponsable]";
  $tipo_responsable = "$row_unidades[tipo_responsable]";
  $idpersona_asignada = "$row_unidades[idpersona_asignada]";
  $tipopersona_asignada = "$row_unidades[tipopersona_asignada]";
  $idorden_logistica = "$row_unidades[idorden_logistica]";

  if ($tipo_responsable == "Colaborador") {
    $query_responsable = "SELECT * FROM empleados where idempleados = '$idresponsable'";
    $result_responsable = mysql_query($query_responsable);
    while ($row_responsable = mysql_fetch_array($result_responsable)) {
      $nomenclatura_responsable = "$row_responsable[columna_b]";
    }

  }else{
    $nomenclatura_responsable = ""; 
  }

  if ($tipopersona_asignada == "Colaborador") {
    $query_asignado = "SELECT * FROM empleados where idempleados = '$idpersona_asignada'";
    $result_asignado = mysql_query($query_asignado);
    while ($row_asignado = mysql_fetch_array($result_asignado)) {
     $trasladista = "$row_asignado[nombre]"." "."$row_asignado[apellido_paterno]"." "."$row_asignado[apellido_materno]";
     $clase_licencia = "$row_asignado[clase_licencia]";
     $numero_licencia = "$row_asignado[numero_licencia]";
     $estado_licencia = "$row_asignado[estado_licencia]";
     $vigencia_licencia = "$row_asignado[vigencia_licencia]";
     if ($vigencia_licencia == "0001-01-01") {
       $vigencia_licenciassss = "Permanente";
     }else{
      $date = date_create($vigencia_licencia);
      $vigencia_licenciassss = date_format($date, 'd-m-Y');
    }
  }
}elseif ($tipopersona_asignada == "Proveedor") {
  $query_asignado_proveedor = "SELECT * FROM proveedores where idproveedores = '$idpersona_asignada'";
  $result_asignado_proveedor = mysql_query($query_asignado_proveedor);
  while ($row_asignado_proveedor = mysql_fetch_array($result_asignado_proveedor)) {
    $nomenclatura_asignado = "$row_asignado_proveedor[nombre]"." "."$row_asignado_proveedor[apellidos]";
  }
}else{
  $nomenclatura_asignado = ""; 
}


$query_logistica_unidades = "SELECT * from inventario where vin_numero_serie = '$vin_logistica_unidades'";
$result_query_logistica_unidades = mysql_query($query_logistica_unidades);

if (mysql_num_rows($result_query_logistica_unidades) >= 1) {

  while ($row_query_logistica_unidades = mysql_fetch_array($result_query_logistica_unidades)) {
    $marca_logistica = "$row_query_logistica_unidades[marca]";
    $version_logistica = "$row_query_logistica_unidades[version]";
    $color_logistica = "$row_query_logistica_unidades[color]";
    $modelo_logistica = "$row_query_logistica_unidades[modelo]";
    $ver_vin = "$row_query_logistica_unidades[vin_numero_serie]";
  }

}else{

  $query_logistica_trucks = "SELECT * from inventario_trucks where vin_numero_serie = '$vin_logistica_unidades'";
  $result_query_logistica_trucks = mysql_query($query_logistica_trucks);

  if (mysql_num_rows($result_query_logistica_trucks) >= 1) {
    while ($row_query_logistica_trucks = mysql_fetch_array($result_query_logistica_trucks)) {

      $marca_logistica = "$row_query_logistica_trucks[marca]";
      $version_logistica = "$row_query_logistica_trucks[version]";
      $color_logistica = "$row_query_logistica_trucks[color]";
      $modelo_logistica = "$row_query_logistica_trucks[modelo]";
      $ver_vin = "$row_query_logistica_trucks[vin_numero_serie]";
    }

  }else{

    $query_logistica_utilitario = "SELECT * from catalogo_unidades_utilitarios where vin like '%$vin_logistica_unidades%'";
    $result_query_logistica_utilitario = mysql_query($query_logistica_utilitario);

    if (mysql_num_rows($result_query_logistica_utilitario) >= 1) {

      while ($row_query_logistica_utilitario = mysql_fetch_array($result_query_logistica_utilitario)) {

        $marca_logistica = "$row_query_logistica_utilitario[marca]";
        $version_logistica = "$row_query_logistica_utilitario[version]";
        $color_logistica = "$row_query_logistica_utilitario[color]";
        $modelo_logistica = "$row_query_logistica_utilitario[modelo]";
        $ver_vin = "$row_query_logistica_utilitario[vin]";
      }           
    }else{

      $query_logistica_inventario = "SELECT * FROM orden_logistica_inventario WHERE vin = '$vin_logistica_unidades' and visible = 'SI'";
      $result_logistica_inventario = mysql_query($query_logistica_inventario);

      if (mysql_num_rows($result_logistica_inventario) >= 1) {

        while ($row_logistica_inventario = mysql_fetch_array($result_logistica_inventario)) {
          $marca_logistica = "$row_logistica_inventario[marca]";
          $version_logistica = "$row_logistica_inventario[version]";
          $color_logistica = "$row_logistica_inventario[color]";
          $modelo_logistica = "$row_logistica_inventario[modelo]";
          $ver_vin = "$row_logistica_inventario[vin]";
        }
      }else{
        $ver_vin = "";
        $marca_logistica = "";
        $version_logistica = "";
        $color_logistica = "";
        $modelo_logistica = "";  
      }           
    }
  }
}




$unidades_logistica ="<tr>
<td style='width: 15%; text-align: right;'><b>VIN:</b></td>
<td style='width: 85%;'>$ver_vin</td>
</tr>
<tr>
<td style='text-align: right;'><b>Marca:</b></td>
<td>$marca_logistica</td>
</tr>

<tr>
<td style='text-align: right;'><b>Versión</b></td>
<td>$version_logistica</td>
</tr>

<tr>
<td style='text-align: right;'><b>Color:</b></td>
<td>$color_logistica</td>
</tr>

<tr>
<td style='text-align: right;'><b>Modelo:</b></td>
<td>$modelo_logistica</td>
</tr>

";

#-----------------


















}



$parrafo_0 = "A QUIEN CORRESPONDA. <br> Presente.";

$parrafo_1 = "<b>Asunto: CARTA RESPONSIVA DE TRASLADO</b>";

$parrafo_2 = "El motivo de la presente es informar que el C. <b>$trasladista</b> persona responsable y honesta que pertenece a nuestros ejecutivos de traslado, quien cuenta con el número de licencia: <b>$numero_licencia</b> del estado de: $estado_licencia con fecha de vencimiento $vigencia_licenciassss tiene como destino $destino_logistica a entregar la unidad que acontinuación se describe.";

$parrafo_4 = "Sin más por el momento, reciba un cordial saludo. <br><br><br> ";


$contenido ='
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PANAMOTORS | Recibo</title>
<style type="text/css">
body{
  margin: 0;
  font-family: "geometric";
}

.content-pedido{
  width:50%;
  display:block;
  float:left;
  padding: 10px 0px 0 0;
}

/*fecha*/

.content-fecha{
  width:50%;
  display:block;
  padding: 10px 0 0 0;
}

.tabla-fecha {
  border-collapse: collapse;
  width: 100%;
  margin: 0px 0 0 0;
  font-size: 11px;
}

.tabla-fecha td, .tabla-fecha th {
  border: 0px solid #dddddd;
  text-align: left;
  padding: 0px;
  text-align: center;
}

.tabla-fecha tr:nth-child(even) {
  border: 0px solid #dddddd;
  text-align: left;
  padding: 0px;
  text-align: center;
}


.both{
  clear: both;
}




.pleca-margin-top{

}

.container{
  width: 1024px;
  height: 400px;
  margin: 0;
}

/*Content-datos*/
.content-datos{
  margin: 10px 0 0 0;
}

.cliente-img{
  width: 100px;
  margin: -15px 0 0 0;
}

table.tabla-datos {
  margin: 0px 0 0 0;
  height: 100px;
  display: block;
  background-color: red;
}

.invisible{
  display:block;
  margin:-29px 0 0 0;
}

/*Content-datos-facturar*/

p.titulo-datos-facturar-titulo{
  font-size: 11px;
  font-weight: bold;
  height: 18px;
  display: block;
  padding:0 0px -10px 0;
}

p.titulo-datos-facturar {
  font-size: 11px;
  font-weight: bold;
  display: block;
  text-align: right;
  padding:0 0px 0px 0;
}

p.text-datos-facturar {
  font-size: 11px;
  display: block;
}

.tabla-datos-facturar td, .tabla-datos-facturar th {
  padding: 8px;
}

/*Content-datos-observaciones*/

.content-datos-obs{
  margin:-5px 0 -5 0;
  padding:-5px 0 -5 0;
}

p.titulo-datos-obs {
  font-size: 11px;
  font-weight: bold;
  height: 18px;
  display: block;
  padding:0 20px 0 0;
}

p.text-datos-obs {
  font-size: 11px;
  height: 18px;
  display: block;
  text-align: right;
  color:gray;
}

p.text-datos-obs-2 {
  font-size: 7px;
  height: 18px;
  display: block;
  color:gray;
}

p.titulo-datos {
  font-size: 11px;
  font-weight: bold;
  display: block;
  text-align: right;
  padding:0 20px 0 0;
}

p.text-datos {
  font-size: 11px;
  display: block;
}

.tabla-datos td, .tabla-datos th {
  padding: 8px;
}

p.parrafo-1 {
  font-size: 12px;
  font-weight: bold;
  display: block;
  text-align: right;
  padding:20 20px 10 0;
}

p.parrafo-2 {
  font-size: 12px;
  font-weight: normal;
  display: block;
  text-align: justify;

  padding:40 20px 20 0;
}

p.parrafo-0 {
  font-size: 12px;
  font-weight: normal;
  display: block;
  text-align: justify;
  padding:0 20px 30 0;
}

/* Tabla 1*/

.tabla-1 {
  width: 100%;
  margin: -10px 0 0 0;
  font-size: 11px;
  background-image: url(../../img/estado-cuenta-panamotors/fondo_recibo.png);
  background-repeat: no-repeat;
  background-position: center;
}

.tabla-1 td {
  /*border: 1px solid #dddddd;*/
  text-align: left;
  padding: 4px;
      //text-align: center;
}

.tabla-1 th {
  padding: 6px;
  text-align: left;
}

.tabla-1 tr:nth-child(even) {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
  text-align: center;
}


.tabla-2 {
  border-collapse: collapse;
  width: 100%;
  margin: 20px 0 30px 0;
  font-size: 11px;
}

.tabla-2 td, .tabla-2 th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
  text-align: center;
}

.tabla-2 tr:nth-child(even) {
  background-color: #dddddd;
  text-align: center;
}

.logo-edo-cot{
  width: 100px;
  display: block;
  margin: -20px 0 0 0;
}

/*Credito y cobranza*/
.tabla-credito {
  border-collapse: collapse;
  width: 100%;
  margin: -10px 0 0 0;
  font-size: 11px;
  color: #696969;
}

.tabla-credito td, .tabla-credito th {
  border: 0px solid #dddddd;
  text-align: left;
  padding: 8px;
  text-align: center;
}

.tabla-credito tr:nth-child(even) {
  border: 0px solid #dddddd;
  text-align: left;
  padding: 8px;
  text-align: center;
}

.tabla-datos-entrega{
  margin: 20px 0 0 0;
}

p.titulo-datos-entrega {
  font-size: 11px;
  font-weight: bold;
  height: 18px;
  margin: 0px 0 -20px 0;
}



/*total-1*/

.content-total-1{
  width:50%;
  display:block;
  float:left;
}

/*total-2*/

.content-total-2{
  width:50%;
  display:block;
  float:right;
}

.titulo-total-final {
  font-size: 22px;
  font-weight: bold;
  display: block;
  text-align: center;
  padding:0 0px 0px 0;
  color:#3f0f2d;
}

.titulos-total-final-text{
  font-size: 14px;
  font-weight: bold;
  display: block;
  text-align: center;
  padding:0 0px 0px 0;

}

p.titulo-datos-total {
  font-size: 11px;
  font-weight: bold;
  display: block;
  text-align: right;
  padding:0 0px 0px 0;
}

p.text-datos-total {
  font-size: 11px;
  display: block;
}

.tabla-datos-total td, .tabla-datos-total th {
  padding: 8px;
}

.estatus-abono-positivo{
  background-color: #52ef90;
  color:black;
}


.estatus-abono-negativo{
  background-color: #ef5353;
  color:black;
}

.estatus-abono-neutro{
  background-color: white;
  color: black;
}

.datos-textos-grande{
  text-align: right;
}

.header-segundo {
  margin-top: 35px;
}
</style>
</head>
<body style=" margin: 0; background-image: url(../../img/estado-cuenta-panamotors/fondo.png); background-repeat: no-repeat; background-position: center;">

<div class="container">

<!--fin-header-->

<!--pedido-->
<div class="content-pedido">

<table class="tabla-datos-facturar">
<tr>
<td style="width: 100px;">
<p class="titulo-datos-facturar">No. Logística:</p>
</td>
<td style="width: 100%;">
<p class="text-datos-facturar">'.$id_contacto_completo.'</p>
</td>
</tr>
</table>


</div>
<!--fin-pedido-->

<!--table-fecha-->
<div class="content-fecha">
<table class="tabla-fecha">
<tr>
<td></td>
<td>'.$dia.'</td>
<td>'.$mes.'</td>
<td>'.$ano.'</td>        
</tr>
<tr>
<th>FECHA</th>
<th>DÍA</th>
<th>MES</th>
<th>AÑO</th>
</tr>
</table>
</div>
<!--fin-table-fecha-->


<div class="both">

</div>




<!--pleca-->
<!--<div class="header">
<img src="../../img/estado-cuenta-panamotors/pleca.png" alt="">
</div> -->
<!--fin-pleca-->



<div class="invisible">

</div>
<br>


<p class="parrafo-1">'.$parrafo_1.'</p>
<p class=""parrafo-0>'.$parrafo_0.'</p>
<p class="parrafo-2">'.$parrafo_2.'</p>

<div>
<table class="tabla-1">
'.$unidades_logistica.'
</table>
</div>

<p>'.$parrafo_3.'</p>
<p>'.$parrafo_4.'</p>

<div class="content-datos-obs"><br>
<p class="text-datos-obs" align="center">______________________________________________</p>
<p class="text-datos-obs" align="center">Coordinador de Logística</p>
<p class="text-datos-obs" align="center">María de los Angeles Munguia Munguia</p>
<p class="text-datos-obs" align="center">(712 ) 114 4002</p>
<p class="text-datos-obs" align="center">(722) 750 7535</p>
</div>

<!--table-entrega-->

<div class="content-datos-obs">
<!--
<p class="text-datos-obs" align="center">INFORMACIÓN CONFIDENCIAL Y RESTRINGIDA PROPIEDAD DE PANAMOTORS CENTER SA DE CV.</p>

<p class="text-datos-obs-2" align="center">Estimado cliente, con el fin de darle un mejor servicio, solicitamos a usted el presente Recibo Original ya que de lo contrario no nos haremos responsables de anticipos o pagos previos quedando invalidados. Vigencia 90 días naturales. <b>NO es valido este recibo sino lleva sello.</b></p>
-->
</div>


<!--fin-table-entrega-->


<!--
<div class="footer">
<img src="../../img/estado-cuenta-panamotors/footer.png" alt="">
</div>-->
<!--fin-footer-->

<br>




</body>
</html>';

//echo $contenido;

include("../../MPDF57/mpdf.php");
$mpdf=new mPDF('s','Letter','','','10','10','28','30');

$mpdf->SetHTMLHeader('<img src="../../img/estado-cuenta-panamotors/header-orden-traslado.png" class="img_header" alt=""><br>');
$mpdf->SetHTMLFooter('
  <p class="text-datos-obs"><img src="../../img/estado-cuenta-panamotors/footer2.png" alt="">{PAGENO} de {nb}</p>
  ');



$mpdf->WriteHTML($contenido);


$mpdf->Output();

exit;

?>