<?php

session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";
$usuario_creador = $_SESSION['usuario_clave'];

date_default_timezone_set('America/Mexico_City');

$fecha_creacion = date("Y-m-d H:i:s"); 

$idcatalogo_monederos_electronicos = base64_decode($_REQUEST['card']);

$query_tarjetas = "SELECT * FROM catalogo_monederos_electronicos WHERE idcatalogo_monederos_electronicos = '$idcatalogo_monederos_electronicos'";
$result_tarjetas = mysql_query($query_tarjetas);

while ($row_tarjeta = mysql_fetch_array($result_tarjetas)) {
  $fecha_guardado = date("Y-m-d H:i:s"); 

  #------------------------------------------- Nombre Responsable --------------------------------------------------------------------------------

  if (trim($row_tarjeta[idempleados]) == "" || trim($row_tarjeta[idempleados]) == null || trim($row_tarjeta[idempleados]) == "N/A") {

    $nomenclatura_responsable_tarjeta = "N/A";

  }elseif (is_numeric($row_tarjeta[idempleados])) {

    $buscar_responsable = explode("|", nombres_datos($row_tarjeta[idempleados], "Colaborador"));
    $nomenclatura_responsable_tarjeta = $buscar_responsable[10];

  }else{

    $nomenclatura_responsable_tarjeta = $row_tarjeta[idempleados];

  }

  #-------------------------------------------  --------------------------------------------------------------------------------

  if ($row_tarjeta[tipo] == "Despensa" || $row_tarjeta[tipo] == "Combustible") {

    $tipo_tarjeta = "de ".$row_tarjeta[tipo].":";
    $nip = ($row_tarjeta[nip] == "" || $row_tarjeta[nip] == null) ? "****" : $row_tarjeta[nip] ;

    $lleva_nip = " con NIP: <b>$nip</b>,";
    $header_type = "<img src='../../img/estado-cuenta-panamotors/ASIGNACION DE TARJETAS.png' class='img_header' alt=''>";

  }elseif ($row_tarjeta[tipo] == "Tag") {

    $tipo_tarjeta = $row_tarjeta[tipo].":";
    $lleva_nip = "";
    $header_type = "<img src='../../img/estado-cuenta-panamotors/header_asignacion_tag.png' class='img_header' alt=''>";

  }else{

    $tipo_tarjeta = "de ".$row_tarjeta[tipo].":";
    $nip = ($row_tarjeta[nip] == "" || $row_tarjeta[nip] == null) ? "****" : $row_tarjeta[nip] ;
    $lleva_nip = "con NIP: <b>$nip</b>,";
    $header_type = "<img src='../../img/estado-cuenta-panamotors/ASIGNACION DE TARJETAS.png' class='img_header' alt=''>";

  }

 #-------------------------------------------  --------------------------------------------------------------------------------

  $nip = ($row_tarjeta[nip] == "" || $row_tarjeta[nip] == null) ? "****" : $row_tarjeta[nip] ;

 #-------------------------------------------  --------------------------------------------------------------------------------

  $nombre_tarjeta = $row_tarjeta[nombre_tarjeta];

 #-------------------------------------------  --------------------------------------------------------------------------------

  $num_tarjeta = chunk_split($row_tarjeta[no_tarjeta],4," "); 

}


$parrafo_0 = "C. $nomenclatura_responsable_tarjeta";

$parrafo_1 = "<b>Asunto: CARTA RESPONSIVA</b>";

$parrafo_2 = "Por este medio se hace entrega de tarjeta $tipo_tarjeta <b>$num_tarjeta</b> del proveedor: $nombre_tarjeta,$lleva_nip responsabilidad del usuario; de la misma manera se explica cuál es el proceso de la herramienta proporcionada. <br><br>
En caso de extravío de tarjeta se hace acreedor a una sanción respectiva, así como también el pago del dispositivo. <br><br> Se le invita a realizar el uso correcto de la tarjeta proporcionada a fin de evitar una sanción que afecte ambas partes. <br><br> Sin más por el momento agradezco su atención quedo de usted. <br><br><br>
";


$contenido='Se Abrio Formato de Carta Responsiva <br /> Tarjeta: <b>'.$nombre_tarjeta.'</b> No: <b>'.$num_tarjeta.'</b> <br />Responsable: <b>'.$nomenclatura_responsable_tarjeta.'</b>';
monederoInsertaBitacora($idcatalogo_monederos_electronicos, $contenido, "Carta Responsiva", "", $usuario_creador, $fecha_creacion, $fecha_guardado, "SI");













$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
date_default_timezone_set('America/Mexico_City');

$date = date_create($fecha_recibo);
$dia=date_format($date, 'd');
$mes_aux=date_format($date, 'm');
$mes=ucfirst($meses[$mes_aux-1]);
$ano=date_format($date, 'Y');
$hora=date_format($date, 'H:i:s');


$contenido ='
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PANAMOTORS | CARTA RESPONSIVA</title>
<style type="text/css">
body{
  font-family: "geometric" !important;
}

.img_header{
  margin: 0px 0 0 0;
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
  font-size: 9px;
  height: 18px;
  display: block;
  color: gray;
  text-align: right;
  margin-top: -40px; 
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
  font-size: 14px;
  font-weight: normal;
  display: block;
  text-align: justify;

  padding:40 20px 20 0;
}

p.parrafo-3 {
  font-size: 14px;
  font-weight: normal;
  display: block;
  text-align: justify;

  padding:40 20px 20 0;
}

p.parrafo-4 {
  font-size: 14px;
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
  font-size: 13px;
  background-image: url(../../img/estado-cuenta-panamotors/fondo_recibo.png);
  background-repeat: no-repeat;
  background-position: center;
}

.tabla-1 td {
  /*border: 1px solid #dddddd;*/
  text-align: center;
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
<body style=" margin: 0; background-image: url(../../img/estado-cuenta-panamotors/fondo2.png); background-repeat: no-repeat; background-position: center;">
<br>
<div class="container">

<!--fin-header-->

<!--pedido-->
<div class="content-pedido">

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


<br><br><br>

<div class="content-datos-obs"><br>
<p class="text-datos-obs" align="center">______________________________________________</p>

<p class="text-datos-obs" align="center" style="font-size: 10px;">'.$nomenclatura_responsable_tarjeta.'</p>

</div>






<br>




</body>
</html>';

//echo $contenido;

include("../../MPDF57/mpdf.php");
$mpdf=new mPDF('s','Letter','','','10','10','30','30');

$mpdf->SetHTMLHeader(''.$header_type.'');

$mpdf->SetHTMLFooter('
  <p class="text-datos-obs" style="color: black;"><img src="../../img/estado-cuenta-panamotors/footer2.png" alt="">{PAGENO} de {nb}</p>
  ');

$mpdf->WriteHTML($contenido);



$nombre_archivo = "Tarjeta ".$responsable.".pdf";
$mpdf->Output($nombre_archivo, 'I');

exit;

?>