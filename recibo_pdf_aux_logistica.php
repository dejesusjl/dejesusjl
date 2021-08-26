<?php

session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "funciones_principales.php";
include_once "../../recuperar_usuario.php";

$reci=$_REQUEST['idrb'];
$id_recibo=base64_decode($reci);


$sql93= "SELECT * FROM balance_gastos_recibos WHERE idbalance_gastos_operacion='$id_recibo'";
$result93=mysql_query($sql93);

while ( $fila93 = mysql_fetch_array($result93)) {
	$idbalance_gastos_recibos="$fila93[idbalance_gastos_recibos]";
	$fecha_recibo="$fila93[fecha]";
	$id_contacto="$fila93[idauxiliar_principales]";
	$monto=number_format("$fila93[monto]",2);
	$monto_letras = convertir($fila93['monto'], "MXN");
	$emisora_institucion="$fila93[emisora_institucion]";
	$emisora_agente="$fila93[emisora_agente]";
	$receptora_institucion="$fila93[receptora_institucion]";
	$receptora_agente="$fila93[receptora_agente]";
	$metodo_pago="$fila93[metodo_pago]";
	$referencia="$fila93[referencia]";
	$comentarios="$fila93[comentarios]";
	$concepto="$fila93[concepto]";
	$idbalance_gastos_operacion ="$fila93[idbalance_gastos_operacion]";

	$sql34 = "SELECT * FROM balance_gastos_operacion where idbalance_gastos_operacion  =' $idbalance_gastos_operacion'";
	$result34 = mysql_query($sql34);

	while ($fila34 = mysql_fetch_array($result34)) {
		$factura="$fila34[factura]";
		$referencia ="$fila34[referencia]";
		$responsable  ="$fila34[responsable]";
		$responsable_logistica = "$fila34[idcatalogo_provedores]";
		$columna2  ="$fila34[columna2]";

	}


	$query_recibo = "SELECT * FROM proveedores WHERE idprovedores_compuesto = '$responsable_logistica'";
	$result_recibo = mysql_query($query_recibo);

	while ($row_recibo = mysql_fetch_array($result_recibo)) {
		$usuario_recibio = "$row_recibo[nombre]"."$row_recibo[apellidos]";
	}


	if (is_numeric($responsable)) {
		$sql21= "SELECT * FROM empleados WHERE idempleados='$responsable'";
		$result21=mysql_query($sql21);
		while ( $fila21 = mysql_fetch_array($result21)) {
			$usuario_recibio="$fila21[nombre]"." "."$fila21[apellido_paterno]"." "."$fila21[apellido_materno]";

		}
	}else{
		$usuario_recibio = $responsable;
	}


	$query_logistica = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$columna2'";
	$result_logistica = mysql_query($query_logistica);
	while ($row_logistica = mysql_fetch_array($result_logistica)) {
		$origen_logistica = "$row_logistica[municipio_origen]".", "."$row_logistica[estado_origen]";
		$destino_logistica = "$row_logistica[municipio_destino]".", "."$row_logistica[estado_destino]";
	}

} 


$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
date_default_timezone_set('America/Mexico_City');

$date = date_create($fecha_recibo);
$dia=date_format($date, 'd');
$mes_aux=date_format($date, 'm');
$mes=ucfirst($meses[$mes_aux-1]);
$ano=date_format($date, 'Y');
$hora=date_format($date, 'H:i:s');



if ($calle!="") {
	$calle_v=$calle.", ";
}

if ($colonia!="") {
	$colonia_v=$colonia.", ";
}

$domicilio_completo=ucfirst($calle.$colonia.$municipio.", ".$estado);


$n2=strlen($id_contacto);
$n2_aux=6-$n1;
$mat2="";

for ($i2=0; $i2 <$n2_aux ; $i2++) { 
	$mat2.="0";
}

$id_recibo = "RL".$mat2.$idbalance_gastos_recibos;





$contenido='
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CCP | Recibo Logística</title>
<style type="text/css">
body{
	margin: 0;
}

.img_header{
	margin: -30px 0 0 0;
	padding -10px 0 0 0;
}

.content-pedido{
	width:50%;
	display:block;
	float:left;
	padding: 10px 0px 0 0;
}



.content-fecha{
	width:50%;
	display:block;
	float:right;
	padding: 10px 0 0 0;
}

.tabla-fecha {
	font-family: arial, sans-serif;
	border-collapse: collapse;
	width: 100%;
	margin: 0px 0 0 0;
	font-size: 8px;
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





.container{
	width: 1024px;
	height: 400px;
	margin: 0;
}






.invisible{
	display:block;
	margin:-29px 0 0 0;
}





p.titulo-datos-facturar {
	font-size: 8px;
	font-weight: bold;
	font-family: Arial;
	display: block;
	text-align: right;
	padding:0 0px 0px 0;
}

p.text-datos-facturar {
	font-size: 8px;
	font-family: Arial;
	display: block;
}

.tabla-datos-facturar td, .tabla-datos-facturar th {
	padding: 8px;
}



.content-datos-obs{
	margin:-5px 0 -5 0;
	padding:-5px 0 -5 0;
}



p.text-datos-obs {
	font-size: 8px;
	font-family: Arial;
	height: 18px;
	display: block;
	color:gray;
}

.tabla-1 {
	font-family: arial, sans-serif;

	width: 100%;
	margin: -10px 0 0 0;
	font-size: 11px;
	background-image: url(../../img/estado-cuenta-panamotors/fondo_recibo.png);
	background-repeat: no-repeat;
	background-position: center;
}

.tabla-1 td {
	border: 1px solid #dddddd;
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

</style>
</head>
<body>

<div class="container">
<br>
<br>
<div class="header">
<img src="../../img/estado-cuenta-panamotors/header_nombre_recibo.png" class="img_header" alt="">
</div>

<div class="content-pedido">

<table class="tabla-datos-facturar">
<tr>
<td style="width: 100px;">
<p class="titulo-datos-facturar">No. Recibo:</p>
</td>
<td style="width: 157px;">
<p class="text-datos-facturar">'.$id_recibo.'</p>
</td>
</tr>
</table>


</div>

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



<div class="both">

</div>







<div class="invisible">

</div>
<br>
<div>
<table class="tabla-1">

<tr>
<th>Origen:</th>
<td colspan="3" align="center">'.$origen_logistica.'</td>
</tr>

<tr>
<th>Destino:</th>
<td colspan="3" align="center">'.$destino_logistica.'</td>
</tr>


<tr>
<th>Factura:</th>
<td align="center" colspan="3">'.$factura.'</td>
</tr>

<tr>
<th>Concepto: </th>
<td colspan="3" align="center">'.$concepto.'</td>
</tr>

<tr>
<th>Monto: </th>
<td colspan="3" align="center"> $ '.$monto.'</td>
</tr>

<tr>
<th>Monto en letra: </th>
<td colspan="3" align="center">'.$monto_letras.'</td>
</tr>
<tr>
<th>Método de pago: </th>
<td align="center">'.$metodo_pago.'</td>
<th>Referencia: </th>
<td align="center">'.$referencia.'</td>
</tr>

<tr>
<th>I. Emisora: </th>
<td align="center">'.$emisora_institucion.'</td>
<th>A. Emisor: </th>
<td align="center">'.$emisora_agente.'</td>
</tr>

<tr>
<th>I. Receptora: </th>
<td align="center">'.$receptora_institucion.'</td>
<th>A. Receptor: </th>
<td align="center">'.$receptora_agente.'</td>
</tr>

<tr>
<th>Comentarios: </th>
<td colspan="3" align="center">'.$comentarios.'</td>
</tr>
</table>
</div>


<div class="content-datos-obs"><br>
<p class="text-datos-obs" align="center">______________________________________________</p>
<p class="text-datos-obs" align="center">'.$usuario_recibio.'</p>
</div>


<div class="content-datos-obs">
<p class="text-datos-obs" align="center">INFORMACIÓN CONFIDENCIAL Y RESTRINGIDA PROPIEDAD DE PANAMOTORS CENTER SA DE CV.</p>

</div>

<br>

<div class="header">
<img src="../../img/estado-cuenta-panamotors/pleca.png" alt="">
</div>




<br>




</body>
</html>';

  #echo $contenido;

include("../../MPDF57/mpdf.php");

/*

$mpdf->SetHTMLHeader('<img src="../../img/estado-cuenta-panamotors/header.png" class="img_header" alt=""><br>');
$mpdf->SetHTMLFooter('
  <p class="text-datos-obs">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; INFORMACIÓN CONFIDENCIAL Y RESTRINGIDA PROPIEDAD DE PANAMOTORS CENTER S.A. DE C.V. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; {PAGENO} de {nb}</p>
  ');
*/

  $mpdf=new mPDF('c','A4','','','10','10','10','3');
  $mpdf->WriteHTML($contenido);
  $mpdf->WriteHTML($contenido);


  $nombre_archivo = "RL ".$usuario_recibio.".pdf";
  $mpdf->Output($nombre_archivo, 'I');

  
  exit;

  ?>