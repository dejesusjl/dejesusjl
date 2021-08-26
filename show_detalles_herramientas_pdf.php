<?php
session_start();  
require_once('../../bdd.php');
require_once('../../config.php');
include_once('funciones_principales.php');

#------------------------------------------- Recepcion de Variables --------------------------------------------------------------------------------

$idunidades_utilitarios_herramientas_desencript = base64_decode($_REQUEST['idmov']);
$idunidades_utilitarios_herramientas = trim($idunidades_utilitarios_herramientas_desencript); 


$query_herramientas = "SELECT * FROM unidades_utilitarios_herramientas WHERE idunidades_utilitarios_herramientas = '$idunidades_utilitarios_herramientas' ";
$result_herramientas = mysql_query($query_herramientas);

while ($row_herramientas = mysql_fetch_array($result_herramientas)) {
	
	$concepto = trim($row_herramientas[tipo]);

	$search_vin = date_vin($row_herramientas[vin]);
	$porciones_vin = explode("|", $search_vin);

	$fecha_inicio = date_create($row_herramientas[fecha_a]);
	$fecha_inicio = date_format($fecha_inicio, "d-m-Y");

	$fecha_vencimiento = date_create($row_herramientas[fecha_vencimiento]);
	$fecha_vencimiento = date_format($fecha_vencimiento, "d-m-Y");

	$num_poliza = trim($row_herramientas[columna_a]);

	$modalida_pago = trim($row_herramientas[columna_c]);

	$total_poliza = trim($row_herramientas[columna_d]);
	$idorden = trim($row_herramientas[idorden]);


	$count_concepto = 0;


	if ($concepto == "GPS") {

		$header_principal = "../../Documentacion_Logistica/header/resumen_general_gps.png";
		$concepto_row = "Gps";
		$concepto_table_encabezados = "IMEI";
		$concepto_poliza_imei = "Total GPS";

		$query_concepto = "SELECT * FROM estado_cuenta_requisicion WHERE visible = 'SI' and trim(datos_vin) = '$porciones_vin[0]' and tipo_movimiento = 'abono' and ( concepto like '%$concepto%' || apartado_usado like '%$concepto%' ) order by fecha_movimiento ASC";


	}elseif ($concepto == "Póliza de Seguro" || $concepto == "Póliza de Traslado" ) {

		$header_principal = ($concepto == "Póliza de Seguro") ? "../../Documentacion_Logistica/header/resumen_general_poliza_seguro.png" : "../../Documentacion_Logistica/header/resumen_general_poliza_traslado.png";
		$concepto_row = "Seguro";
		$concepto_table_encabezados = "No. de Póliza:";
		$concepto_poliza_imei = "Total Póliza";







		$consultaCostoEstadoRequisicion=mysql_query("SELECT AB.cantidad_pago, AB.fecha_pago, AB.receptora_institucion FROM estado_cuenta_requisicion EC JOIN abonos_estado_cuenta_requisicion AB ON AB.idestado_cuenta_requisicion_movimineto=EC.idestado_cuenta_requisicion WHERE EC.referencia='$idorden' and EC.visible='SI' and AB.visible='SI' ORDER BY AB.fecha_pago ASC");

		while($filaEC = mysql_fetch_array($consultaCostoEstadoRequisicion)){

			if (is_numeric($filaEC[cantidad_pago])) {

				$count_concepto ++;

				$fecha_movimiento = date_create($filaEC[fecha_pago]);
				$fecha_movimiento = date_format($fecha_movimiento, "d-m-Y");
				$gran_total = number_format($filaEC[cantidad_pago], 2);
				$total_gran += $filaEC[cantidad_pago];


				$query_orden_vin = "SELECT * FROM atencion_clientes WHERE idatencion_clientes = '$idorden'";
				$result_orden_vin = mysql_query($query_orden_vin);


				if (mysql_num_rows($result_orden_vin) >= 1) {

					while ($row_orden_vin = mysql_fetch_array($result_orden_vin)) {

						$concepto_principal =  NombreProveedorBalance ($row_orden_vin[idcontacto]);
					}

				}else {

					$concepto_principal = $filaEC[receptora_institucion];
				}


				


				$conceptos_info .= "
				<tr>
				<td><span>$count_concepto</span></td>
				<td><span>$concepto_row</span></td>
				<td><span>$fecha_movimiento</span></td>
				<td><span>$$gran_total</span></td>
				</tr>
				";
			}			
		}









	}




}

$name_archivo = $concepto."_".$porciones_vin[0];
#------------------------------------------- VIN --------------------------------------------------------------------------------

$tabla_vin = "
<br>
<table class='tabla-1 tabla-sn-borde'>
<tbody>

<tr>
<td> <b>VIN: </b> $porciones_vin[0]</td>
<td><b>Marca:</b> $porciones_vin[1]</td>
</tr>

<tr>
<td><b>Versión:</b> $porciones_vin[2]</td>
<td><b>Color:  </b> $porciones_vin[3]</td>
</tr>

<tr>
<td><b>Modelo:       </b> $porciones_vin[4]</td>
<td><b>Tipo unidad:  </b> $porciones_vin[5]</td>
</tr>



</tbody>

</table>
<br>
";

#------------------------------------------- ENCABEZADOS --------------------------------------------------------------------------------

$tabla_encabezados = "
<br>
<table class='tabla-1 tabla-sn-borde'>
<tbody>

<tr>
<td colspan='2'><span><b>$concepto_table_encabezados</b></span></td>
<td colspan='2'><span>$num_poliza</span></td>
<tr>

<tr>
<td colspan='2'><span><b>Modalidad de Pago:</b></span></td>
<td colspan='2'><span>$modalida_pago</span></td>
</tr>

<tr>
<td><span><b>Fecha Inicio:</b></span></td>
<td><span>$fecha_inicio</span></td>
<td><span><b>Fecha Vencimiento:</b></span></td>
<td><span>$fecha_vencimiento</span></td>
</tr>


</tbody>

</table>
<br>

";

#-------------------------------------------- Tabla de conceptos --------------------------------------------------------------------------------
$diferencia_clacular = $total_poliza - $total_gran;
$diferencia_montos = ($diferencia_clacular < 0) ? number_format($diferencia_clacular * -1, 2) : number_format($diferencia_clacular, 2);

$total_gran = number_format($total_gran,2);
$total_poliza = ($total_poliza == "") ? number_format(0, 2) : number_format($total_poliza, 2);



$tabla_concepto = "

<table class='tabla-1 tabla-sn-borde'>

<tr>
<th class='c-gradiant-v' style='width: 10%;'>#</th>
<th class='c-gradiant-v' style='width: 25%;'>Concepto</th>
<th class='c-gradiant-v' style='width: 20%;'>Fecha</th>
<th class='c-gradiant-v' style='width: 20%;'>Monto total</th>
</tr>

$conceptos_info

<tfoot>

<tr>
<td colspan='3' id='monto_total_style'>Total Abonos</td>
<td><b>$$total_gran</b></td>
</tr>

<tr>
<td colspan='3' id='monto_total_style'>$concepto_poliza_imei</td>
<td><b>$$total_poliza</b></td>
</tr>

<tr>
<td colspan='3' id='monto_total_style'>Diferencia</td>
<td><b>$$diferencia_montos</b></td>
</tr>

</tfoot>
</table>

<br>

";


#-------------------------------------------Hora Impresion --------------------------------------------------------------------------------

$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
date_default_timezone_set('America/Mexico_City');

$date = date_create();
$dia=date_format($date, 'd');
$mes_aux=date_format($date, 'm');
$mes=ucfirst($meses[$mes_aux-1]);
$ano=date_format($date, 'Y');
$hora=date_format($date, 'H:i:s');





#-------------------------------------------  --------------------------------------------------------------------------------

$contenido='
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Detalles | VIN</title>
<style type="text/css">

body{
	margin: 0;
	font-family: "geometric" !important;
}

.img_header{
	width: 100%;
	height: 70px;
	margin-top: -70px;
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
	float:right;
	padding: 10px 0 0 0;
}

.tabla-fecha {
	border-collapse: collapse;
	width: 100%;
	margin: 0px 0 0 0;
	font-size: 10px;
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
	font-size: 10px;
	font-weight: bold;
	display: block;
	text-align: right;
	padding:0 0px 0px 0;
}

p.text-datos-facturar {
	font-size: 10px;
	display: block;
}

.tabla-datos-facturar td, .tabla-datos-facturar th {
	padding: 8px;
}
/* Tabla 1*/

.tabla-1 {
	width: 100%;
	font-size: 9px;
}
.tabla-1 td, .tabla-1 th {
	text-align: left;
	padding: 8px;
					//text-align: center;
}
.tabla-1 tr:nth-child(even) {
	text-align: left;
	padding: 8px;
	text-align: center;
}

.c-gradiant-v{
	background: linear-gradient(0deg, #882439, #A51D3A, #882439);
	color: #fff;
}	

.tabla-sn-borde{
	border-collapse: none;
}
.tabla-sn-borde td, .tabla-sn-borde th{
	border: none;
}	
.tabla-sn-borde tr td{
	border-bottom: 1px solid #dddddd;
}

p.text-datos-obs {
	font-size: 11px;
	height: 18px;
	display: block;
	text-align: right;
	color:gray;
}


</style>
</head>

<body style=" margin: 0; background-image: url(../../img/estado-cuenta-panamotors/fondo2.png); background-repeat: no-repeat; background-position: center;">


<div class="header">
<img src="'.$header_principal.'" class="img_header" alt="">
</div>

<div class="content-pedido">

<table class="tabla-datos-facturar">
<tr>
<td style="width: 20px;">
<p class="titulo-datos-facturar">Proveedor: </p>
</td>
<td style="width: 257px;">
<p class="text-datos-facturar">'.$concepto_principal.'</p>
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
<th>FECHA:</th>
<th>DÍA</th>
<th>MES</th>
<th>AÑO</th>
</tr>
</table>

</div>
</div>


<div style="margin-top: 20px;">

'.$tabla_vin.'

</div>




'.$tabla_encabezados.'
'.$tabla_concepto.'







</body>
</html>';




//echo "$contenido";


include("../../MPDF57/mpdf.php");

$mpdf = new mPDF('s','Letter','','','10','10','28','30');

$mpdf->SetHTMLFooter('
	<p class="text-datos-obs"><img src="../../img/estado-cuenta-panamotors/footer2.png" alt="">{PAGENO} de {nb}</p>
	');

$mpdf->WriteHTML($contenido);

$nombre_archivo = $name_archivo.".pdf";
$mpdf->Output($nombre_archivo, 'I');

exit;

?>
