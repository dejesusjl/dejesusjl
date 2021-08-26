<?php
session_start();
require_once('../../bdd.php');
require_once('../../config.php');
include_once('funciones_principales.php');

#------------------------------------------- Recepcion de Variables --------------------------------------------------------------------------------

$encript_id_contacto = base64_decode($_REQUEST['idcliente']);
$encript_type_contacto = base64_decode($_REQUEST['tipo_contacto_id']);

$idcontacto = trim($encript_id_contacto);
$tipo_contacto = trim($encript_type_contacto);


$idtrasladista = trim($encript_id_contacto);
$tipo_trasladista = trim($encript_type_contacto);

$fecha_a = base64_decode($_REQUEST['fecha_a']);
$fecha_b = base64_decode($_REQUEST['fecha_b']);

if ($fecha_a != "" and $fecha_b == "") {

	$query_logistica = "
	SELECT 
    *
	FROM
	orden_logistica
	WHERE
	trim(idasigna) = '$idcontacto'
	AND trim(tipo_asignante) = '$tipo_contacto'
	AND (DATE_FORMAT(fecha_solicitud, '%Y-%m-%d') = '$fecha_a'
	|| DATE_FORMAT(fecha_programada, '%Y-%m-%d') = '$fecha_a'
	|| DATE_FORMAT(fecha_salida, '%Y-%m-%d') = '$fecha_a'
	|| DATE_FORMAT(fecha_llega_destino, '%Y-%m-%d') = '$fecha_a'
	|| DATE_FORMAT(fecha_retorno, '%Y-%m-%d') = '$fecha_a'
	|| DATE_FORMAT(hora_real_solucion, '%Y-%m-%d') = '$fecha_a');";

	$valores = "AND (DATE_FORMAT(fecha_solicitud, '%Y-%m-%d') = '$fecha_a' || DATE_FORMAT(fecha_programada, '%Y-%m-%d') = '$fecha_a' || DATE_FORMAT(fecha_salida, '%Y-%m-%d') = '$fecha_a' || DATE_FORMAT(fecha_llega_destino, '%Y-%m-%d') = '$fecha_a' || DATE_FORMAT(fecha_retorno, '%Y-%m-%d') = '$fecha_a' || DATE_FORMAT(hora_real_solucion, '%Y-%m-%d') = '$fecha_a')";
} elseif ($fecha_a == "" and $fecha_b != "") {

	$query_logistica = "SELECT 
    *
	FROM
	orden_logistica
	WHERE
	trim(idasigna) = '$idcontacto'
	AND trim(tipo_asignante) = '$tipo_contacto'
	AND (DATE_FORMAT(fecha_solicitud, '%Y-%m-%d') = '$fecha_b'
	|| DATE_FORMAT(fecha_programada, '%Y-%m-%d') = '$fecha_b'
	|| DATE_FORMAT(fecha_salida, '%Y-%m-%d') = '$fecha_b'
	|| DATE_FORMAT(fecha_llega_destino, '%Y-%m-%d') = '$fecha_b'
	|| DATE_FORMAT(fecha_retorno, '%Y-%m-%d') = '$fecha_b'
	|| DATE_FORMAT(hora_real_solucion, '%Y-%m-%d') = '$fecha_b');";

	$valores = "AND (DATE_FORMAT(fecha_solicitud, '%Y-%m-%d') = '$fecha_b' || DATE_FORMAT(fecha_programada, '%Y-%m-%d') = '$fecha_b' || DATE_FORMAT(fecha_salida, '%Y-%m-%d') = '$fecha_b' || DATE_FORMAT(fecha_llega_destino, '%Y-%m-%d') = '$fecha_b' || DATE_FORMAT(fecha_retorno, '%Y-%m-%d') = '$fecha_b' || DATE_FORMAT(hora_real_solucion, '%Y-%m-%d') = '$fecha_b')";
} else if ($fecha_a != "" and $fecha_b != "") {

	$query_logistica = "SELECT 
    *
	FROM
	orden_logistica
	WHERE
	trim(idasigna) = '$idcontacto'
	AND trim(tipo_asignante) = '$tipo_contacto'
	AND (DATE_FORMAT(fecha_solicitud, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'
	|| DATE_FORMAT(fecha_programada, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'
	|| DATE_FORMAT(fecha_salida, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'
	|| DATE_FORMAT(fecha_llega_destino, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'
	|| DATE_FORMAT(fecha_retorno, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'
	|| DATE_FORMAT(hora_real_solucion, '%Y-%m-%d') between '$fecha_a' and '$fecha_b');";

	$valores = "AND (DATE_FORMAT(fecha_solicitud, '%Y-%m-%d') between '$fecha_a' and '$fecha_b' || DATE_FORMAT(fecha_programada, '%Y-%m-%d') between '$fecha_a' and '$fecha_b' || DATE_FORMAT(fecha_salida, '%Y-%m-%d') between '$fecha_a' and '$fecha_b' || DATE_FORMAT(fecha_llega_destino, '%Y-%m-%d') between '$fecha_a' and '$fecha_b' || DATE_FORMAT(fecha_retorno, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'	|| DATE_FORMAT(hora_real_solucion, '%Y-%m-%d') between '$fecha_a' and '$fecha_b')";
} else {

	$query_logistica = "SELECT * FROM orden_logistica WHERE trim(idasigna) = '$idcontacto' AND trim(tipo_asignante) = '$tipo_contacto'";

	$valores = "";
}

#-------------------------------------------Hora Impresion --------------------------------------------------------------------------------

$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
date_default_timezone_set('America/Mexico_City');

$date = date_create();
$dia = date_format($date, 'd');
$mes_aux = date_format($date, 'm');
$mes = ucfirst($meses[$mes_aux - 1]);
$ano = date_format($date, 'Y');
$hora = date_format($date, 'H:i:s');

#-------------------------------------------Datos ID --------------------------------------------------------------------------------

$show_principal = nombres_datos($idcontacto, $tipo_contacto);
$porciones_principal = explode("|", $show_principal);
$name_principal = $porciones_principal[10];
$name_replace = str_replace(" ", "_", $name_principal);

$name_archivo = $idcontacto . "_" . $name_replace . "_" . $tipo_contacto;



#-------------------------------------------Consulta Logistica--------------------------------------------------------------------------------

$contador = 0;
$total_logistica_gastos = 0;

$result_logistica = mysql_query($query_logistica);

$consulta_general_total_logistica = 0;

while ($row_logistica = mysql_fetch_array($result_logistica)) {
	$contador++;
	$idorden_logistica = trim($row_logistica[idorden_logistica]);
	$fecha_solicitud = date_create($row_logistica[fecha_solicitud]);
	$fecha_solicitud = date_format($fecha_solicitud, 'd-m-Y');
	$fecha_programada = trim($row_logistica[fecha_programada]);
	$fecha_estimada_solucion = trim($row_logistica[fecha_estimada_solucion]);
	$fecha_salida = trim($row_logistica[fecha_salida]);
	$fecha_llega_destino = trim($row_logistica[fecha_llega_destino]);
	$fecha_retorno = trim($row_logistica[fecha_retorno]);
	$hora_real_solucion = trim($row_logistica[hora_real_solucion]);
	$tiempo_estimado = trim($row_logistica[tiempo_estimado]);

	$estado_origen = trim($row_logistica[estado_origen]);
	$municipio_origen = trim($row_logistica[municipio_origen]);
	$colonia_origen = trim($row_logistica[colonia_origen]);
	$calle_origen = trim($row_logistica[calle_origen]);
	$coordenadas_origen = trim($row_logistica[coordenadas_origen]);
	$cp_origen = trim($row_logistica[cp_origen]);

	$estado_destino = trim($row_logistica[estado_destino]);
	$municipio_destino = trim($row_logistica[municipio_destino]);
	$colonia_destino = trim($row_logistica[colonia_destino]);
	$calle_destino = trim($row_logistica[calle_destino]);
	$cp_destino = trim($row_logistica[cp_destino]);
	$ubicacion_destino = trim($row_logistica[ubicacion_destino]);


	$municipio_origen_logistica = ($municipio_origen == "" || $municipio_origen == "undefined") ? "" : $municipio_origen;
	$municipio_destino_logistica = ($municipio_destino == "" || $municipio_destino == "undefined") ? "" : $municipio_destino;

	$estado_origen_logistica = ($estado_origen == "" || $estado_origen == "undefined") ? "" : $estado_origen;
	$estado_destino_logistica = ($estado_destino == "" || $estado_destino == "undefined") ? "" : $estado_destino;

	$juntar_origen = "$municipio_origen_logistica, $estado_origen_logistica";
	$juntar_destino = "$municipio_destino_logistica, $estado_destino_logistica";



	$idcontacto = trim($row_logistica[idcontacto]);
	$tipo_contacto = trim($row_logistica[tipo_contacto]);

	$kilometros = trim($row_logistica[kilometros]);
	$rendimiento = trim($row_logistica[rendimiento]);

	$idsolicitante = trim($row_logistica[idsolicitante]);
	$tipo_solicitante = trim($row_logistica[tipo_solicitante]);

	$idfuente_inf = trim($row_logistica[idfuente_inf]);
	$tipo_fuente_inf = trim($row_logistica[tipo_fuente_inf]);

	$idasigna = trim($row_logistica[idasigna]);
	$tipo_asignante = trim($row_logistica[tipo_asignante]);

	$buscar_trasladista = nombres_datos($idasigna, $tipo_asignante);
	$porciones_trasladista = explode("|", $buscar_trasladista);


	$presupuesto = trim($row_logistica[presupuesto]);
	$cantidad_presupuesto = trim($row_logistica[cantidad_presupuesto]);
	$reembolso = trim($row_logistica[reembolso]);
	$cantidad_reembolso = trim($row_logistica[cantidad_reembolso]);
	$estatus = trim($row_logistica[estatus]);
	$comentario_general = trim($row_logistica[comentario_general]);


	$name_departamento =  DepartamentoName($row_logistica[iddepartamento]);

	$name_orden = OrdenName($row_logistica[idcatalogo_orden_logistica]);



	$columna_a = trim($row_logistica[columna_a]);
	$columna_b = trim($row_logistica[columna_b]);
	$columna_c = trim($row_logistica[columna_c]);
	$columna_d = trim($row_logistica[columna_d]);
	$columna_e = trim($row_logistica[columna_e]);
	$columna_f = trim($row_logistica[columna_f]);
	$columna_g = trim($row_logistica[columna_g]);
	$coluna_h = trim($row_logistica[coluna_h]);
	$coluna_i = trim($row_logistica[coluna_i]);
	$visible = trim($row_logistica[visible]);
	$usuario_creador = trim($row_logistica[usuario_creador]);
	$fecha_creacion = trim($row_logistica[fecha_creacion]);
	$fecha_guardado = trim($row_logistica[fecha_guardado]);


	$total_gastos_logistica = BalanceTotalCosto("sum(monto_total) as monto_total", "columna2 = '$idorden_logistica' and visible = 'SI' and tipo_movimiento = 'cargo'");
	$total_logistica_gastos += BalanceTotalCosto("sum(monto_total) as monto_total", "columna2 = '$idorden_logistica' and visible = 'SI' and tipo_movimiento = 'cargo'");
	$consulta_gastos_total_logistica = number_format($total_gastos_logistica, 2);

	//echo "<br>";
	$tabla_movimientos_balance .= "
	<tr>
	<td><span>$contador</span></td>
	<td><span>$name_orden</span></td>
	<td><span>$idorden_logistica <br> $fecha_solicitud</span></td>
	<td><span>$$consulta_gastos_total_logistica</span></td>
	<td><span>$name_departamento</span></td>
	<td><span>$juntar_origen</span></td>
	<td><span>$juntar_destino</span></td>
	<td><span>$porciones_trasladista[10]</span></td>
	</tr>
	";
}
#------------------------------------------- Total Generar Logistica --------------------------------------------------------------------------------
$consulta_general_total_logistica = number_format($total_logistica_gastos, 2);

#------------------------------------------- Total Tipo orden --------------------------------------------------------------------------------


$count_type_orden = 0;
$count_general_type_orden = 0;

$query_type_orden_count = "
SELECT 
orden_logistica_tipo_orden.nombre AS name_type_orden,
COUNT(orden_logistica_tipo_orden.nombre) AS contador_type_orden
FROM
orden_logistica
INNER JOIN
orden_logistica_tipo_orden
WHERE
orden_logistica.idcatalogo_orden_logistica = orden_logistica_tipo_orden.idorden_logistica_tipo_orden
AND orden_logistica.idasigna = '$idtrasladista'
AND orden_logistica.tipo_asignante = '$tipo_trasladista' $valores
GROUP BY name_type_orden";
$result_type_orden_count = mysql_query($query_type_orden_count);

while ($row_type_orden_count = mysql_fetch_array($result_type_orden_count)) {

	$count_type_orden++;
	$count_general_type_orden += $row_type_orden_count[contador_type_orden];
	$tabla_movimientos_tipo_orden .= "
	<tr>
	<td><span>$count_type_orden</span></td>
	<td><span>$row_type_orden_count[name_type_orden]</span></td>
	<td><span>$row_type_orden_count[contador_type_orden]</span></td>
	</tr>
	";
}

#------------------------------------------- Total General Departamento --------------------------------------------------------------------------------

$count_departamento = 0;
$count_general_departamento = 0;

$query_departamento_count = "
SELECT 
catalogo_departamento.nombre as name_departamento,
COUNT(catalogo_departamento.nombre) as contador_departamento
FROM
orden_logistica
INNER JOIN
catalogo_departamento
WHERE
orden_logistica.iddepartamento = catalogo_departamento.idcatalogo_departamento
AND orden_logistica.idasigna = '$idtrasladista'
AND orden_logistica.tipo_asignante = '$tipo_trasladista' $valores
GROUP BY catalogo_departamento.nombre";
$result_departamento_count = mysql_query($query_departamento_count);

while ($row_departamento_count = mysql_fetch_array($result_departamento_count)) {

	$count_departamento++;
	$count_general_departamento += $row_departamento_count[contador_departamento];
	$tabla_movimientos_tipo_departamento .= "
	<tr>
	<td><span>$count_departamento</span></td>
	<td><span>$row_departamento_count[name_departamento]</span></td>
	<td><span>$row_departamento_count[contador_departamento]</span></td>
	</tr>
	";
}

#------------------------------------------- Total General Trasladista --------------------------------------------------------------------------------

$count_trasladista = 0;
$count_general_trasladista = 0;

$query_trasladista_count = "
SELECT 
idasigna, COUNT(idasigna) AS contador_trasladista, tipo_asignante
FROM
orden_logistica
WHERE
idasigna = '$idtrasladista'
AND tipo_asignante = '$tipo_trasladista' $valores
GROUP BY idasigna, tipo_asignante;";
$result_trasladista_count = mysql_query($query_trasladista_count);

while ($row_trasladista_count = mysql_fetch_array($result_trasladista_count)) {

	$count_trasladista++;
	$count_general_trasladista += $row_trasladista_count[contador_trasladista];

	$search_trasladista = nombres_datos($row_trasladista_count[idasigna], $row_trasladista_count[tipo_asignante]);
	$array_trasladista = explode("|", $search_trasladista);


	$tabla_movimientos_trasladista .= "
	<tr>
	<td><span>$count_trasladista</span></td>
	<td><span>$array_trasladista[10]</span></td>
	<td><span>$row_trasladista_count[contador_trasladista]</span></td>
	</tr>
	";
}

#-------------------------------------------  --------------------------------------------------------------------------------

$contenido = '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CCP | Resumen Logística ID</title>
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
<img src="../../Documentacion_Logistica/header/Resumen_logistica_id.png" class="img_header" alt="">
</div>

<div class="content-pedido">

<table class="tabla-datos-facturar">
<tr>
<td style="width: 20px;">
<p class="titulo-datos-facturar">ID: </p>
</td>
<td style="width: 257px;">
<p class="text-datos-facturar">' . $name_principal . '</p>
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
<td>' . $dia . '</td>
<td>' . $mes . '</td>
<td>' . $ano . '</td>
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
<table class="tabla-1 tabla-sn-borde">
<tr>
<th class="c-gradiant-v" style="width: 10%;">#</th>
<th class="c-gradiant-v" style="width: 10%;">Tipo de Orden</th>
<th class="c-gradiant-v" style="width: 10%;">No. Logística</th>
<th class="c-gradiant-v" style="width: 15%;">Costo Total</th>
<th class="c-gradiant-v" style="width: 10%;">Departamento</th>
<th class="c-gradiant-v" style="width: 15%;">Origen</th>
<th class="c-gradiant-v" style="width: 15%;">Destino</th>
<th class="c-gradiant-v" style="width: 15%;">Trasladista</th>
</tr>
' . $tabla_movimientos_balance . '
<tfoot>
<tr>
<td colspan="3" id="monto_total_style">Monto Total</td>
<td colspan="5"><b>$' . $consulta_general_total_logistica . '</b></td>
</tr>
</tfoot>
</table>
</div>

<br>
<br>

<table class="tabla-1 tabla-sn-borde">
<tr>
<th class="c-gradiant-v" style="width: 10%;">#</th>
<th class="c-gradiant-v" style="width: 10%;">Tipo</th>
<th class="c-gradiant-v" style="width: 10%;">Cantidad</th>
</tr>
' . $tabla_movimientos_tipo_orden . '
<tfoot>
<tr>
<td colspan="2" id="monto_total_style">Total</td>
<td colspan="1"><b>' . $count_general_type_orden . '</b></td>
</tr>
</tfoot>
</table>

<br>
<br>

<table class="tabla-1 tabla-sn-borde">
<tr>
<th class="c-gradiant-v" style="width: 10%;">#</th>
<th class="c-gradiant-v" style="width: 10%;">Departamento</th>
<th class="c-gradiant-v" style="width: 10%;">Cantidad</th>
</tr>
' . $tabla_movimientos_tipo_departamento . '
<tfoot>
<tr>
<td colspan="2" id="monto_total_style">Total</td>
<td colspan="1"><b>' . $count_general_departamento . '</b></td>
</tr>
</tfoot>
</table>
<br>
<br>

<table class="tabla-1 tabla-sn-borde">
<tr>
<th class="c-gradiant-v" style="width: 10%;">#</th>
<th class="c-gradiant-v" style="width: 10%;">Trasladista</th>
<th class="c-gradiant-v" style="width: 10%;">Cantidad</th>
</tr>
' . $tabla_movimientos_trasladista . '
<tfoot>
<tr>
<td colspan="2" id="monto_total_style">Total</td>
<td colspan="1"><b>' . $count_general_trasladista . '</b></td>
</tr>
</tfoot>
</table>




</body>
</html>';




//echo "$contenido";


include("../../MPDF57/mpdf.php");

$mpdf = new mPDF('s', 'Letter', '', '', '10', '10', '28', '30');

$mpdf->SetHTMLFooter('
	<p class="text-datos-obs"><img src="../../img/estado-cuenta-panamotors/footer2.png" alt="">{PAGENO} de {nb}</p>
	');

$mpdf->WriteHTML($contenido);

$nombre_archivo = $name_archivo . ".pdf";
$mpdf->Output($nombre_archivo, 'I');

exit;
