<?php
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
date_default_timezone_set('America/Mexico_City');

include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";

$reci=$_REQUEST['idc'];
$idorden_logistica = base64_decode($reci);

$n1=strlen($idc);
$n1_aux=6-$n1;
$mat="";

for ($i=0; $i <$n1_aux ; $i++) { 
	$mat.="0";
}

$idorden_logistica_completo = $mat.$idorden_logistica;


#------------------------------------------- Inicia Logistica --------------------------------------------------------------------------------

$query_logistica = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$idorden_logistica'";
$result_logistica = mysql_query($query_logistica);

while ($row_logistica = mysql_fetch_array($result_logistica)) {

	$idorden_logistica = trim($row_logistica[idorden_logistica]);

	$fecha_solicitud = trim($row_logistica[fecha_solicitud]);
	$fecha_programada = trim($row_logistica[fecha_programada]);
	$fecha_salida = trim($row_logistica[fecha_salida]);
	$fecha_retorno = trim($row_logistica[fecha_retorno]);
	$fecha_llega_destino = trim($row_logistica[fecha_llega_destino]);
	$hora_real_solucion = trim($row_logistica[hora_real_solucion]);

	$tiempo_estimado = trim($row_logistica[tiempo_estimado]);
	$fecha_estimada_solucion = trim($row_logistica[fecha_estimada_solucion]);
	
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
	$coordenadas_destino = trim($row_logistica[ubicacion_destino]);
	
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

	$ver_orden_atc = trim($row_logistica[presupuesto]);
	$cantidad_presupuesto = number_format("$row_logistica[cantidad_presupuesto]", 2);
	$reembolso = trim($row_logistica[reembolso]);
	$cantidad_reembolso = number_format("$row_logistica[cantidad_reembolso]", 2);

	$comentario_general = trim($row_logistica[comentario_general]);
	$iddepartamento = trim($row_logistica[iddepartamento]);
	$idcatalogo_orden_logistica = trim($row_logistica[idcatalogo_orden_logistica]);
	$visible = trim($row_logistica[visible]);
	$usuario_creador = trim($row_logistica[usuario_creador]);
	$fecha_creacion = trim($row_logistica[fecha_creacion]);
	$fecha_guardado = trim($row_logistica[fecha_guardado]);
}

#-------------------------------------------Fecha--------------------------------------------------------------------------------


$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
date_default_timezone_set('America/Mexico_City');

$date = date_create();
$dia = date_format($date, 'd');
$mes_aux = date_format($date, 'm');
$mes = ucfirst($meses[$mes_aux-1]);
$ano = date_format($date, 'Y');
$hora = date_format($date, 'H:i:s');

#------------------------------------------- Departamento Orden --------------------------------------------------------------------------------

$nombre_departamento = DepartamentoName ($iddepartamento);

$nombre_orden = OrdenName ($idcatalogo_orden_logistica);

$encabezado = "
<br>
<table class='tabla-1'>
<tr>
<td><b>Departamento:</b></td>
<td>$nombre_departamento</td>
<td><b>Tipo de Orden:</b></td>
<td>$nombre_orden</td>
</tr>
</table>
";

#------------------------------------------- Datos del ID --------------------------------------------------------------------------------

$porciones_id = explode("|", nombres_datos($idcontacto, $tipo_contacto));


$cli=strlen($idcontacto);
$cli_aux=6-$cli;
$mate="";

for ($i=0; $i <$cli_aux ; $i++) { 
	$mate.="0";
}

$id_client = $mate.$idcontacto;

$datos_cliente = "
<div style='text-align: center; color: #882439;'>
<h5>Datos del ID</h5>
</div>

<div>
<table class='tabla-1'>
<tbody>

<tr>
<td style='width: 25%; text-align: right;'><b>Nombre</b></td>
<td style='width: 25%;'>$porciones_id[0]</td>
<td style='width: 25%; text-align: right;'><b>Apellidos</b></td>
<td style='width: 25%;'>$porciones_id[1]</td>
</tr>

<tr>
<td style='text-align: right;'><b>ID</b></td>
<td>$id_client</td> 
<td style='text-align: right;'><b>Alias</b></td>
<td>$porciones_id[2]</td>  
</tr>

<tr>
<td style='text-align: right;'><b>Celular</b></td>
<td>$porciones_id[3]</td>
<td style='text-align: right;'><b>Télefono Fijo</b></td>
<td>$porciones_id[4]</td>
</tr> 

<tr>
<td style='text-align: right;'><b>Estado</b></td>
<td>$porciones_id[5]</td>
<td style='text-align: right;'><b>Municipio</b></td>
<td>$porciones_id[6]</td>
<tr>

<tr>
<td style='text-align: right;'><b>Colonia</b></td>
<td>$porciones_id[8]</td>
<td style='text-align: right;'><b>Calle y Número</b></td>
<td>$porciones_id[7]</td>                                   
</tr> 

<tr>
<td style='text-align: right;' collspan='2'><b>Tipo ID</b></td>
<td collspan='2'>$porciones_id[11]</td>                                
</tr> 

</tbody>
</table>
</div>";

#------------------------------------------- Domicilio --------------------------------------------------------------------------------

$domicilio_logistica ="
<div style='text-align: center; color: #882439;'>
<h5>Domicilio </h5>
</div>

<div>
<table class='tabla-1'>
<tbody>
<tr>
<td class='c-gradiant' colspan='2' style='text-align: center;'><h5>Origen</h5></td>
<td class='c-gradiant' colspan='2' style='text-align: center;'><h5>Destino</h5> </td>
</tr>
<tr>
<td style='width: 25%; text-align: right;'><b>Estado</b></td>
<td style='width: 25%;'>$estado_origen</td>
<td style='width: 25%; text-align: right;'><b>Estado</b></td>
<td style='width: 25%;'>$estado_destino</td>
</tr>

<tr>
<td style='text-align: right;'><b>Municipio</b></td>
<td>$municipio_origen</td>
<td style='text-align: right;'><b>Municipio</b></td>
<td>$municipio_destino</td>
</tr>

<tr>
<td style='text-align: right;'><b>Colonia</b></td>
<td>$colonia_origen</td>
<td style='text-align: right;'><b>Colonia</b></td>
<td>$colonia_destino</td>
</tr>
<tr>
<td style='text-align: right;'><b>Calle</b></td>
<td>$calle_origen</td>
<td style='text-align: right;'><b>Calle</b></td>
<td>$calle_destino</td>
</tr>

<tr>
<td style='text-align: right;'><b>Código Postal</b></td>
<td>$cp_origen</td>
<td style='text-align: right;'><b>Código Postal</b></td>
<td>$cp_destino</td>
</tr>

<tr>
<td style='text-align: right;'><b>Coordenadas Origen</b></td>
<td>$coordenadas_origen</td>
<td style='text-align: right;'><b>Coordenadas Destino</b></td>
<td>$coordenadas_destino</td>
</tr>

</tbody>
</table>
</div>
";

#------------------------------------------- Acompañantes --------------------------------------------------------------------------------

$query_ayudante = "SELECT * FROM orden_logistica_ayudante WHERE idorden_logistica = '$idorden_logistica' and visible = 'SI'";
$result_ayudante = mysql_query($query_ayudante);

if (mysql_num_rows($result_ayudante) >= 1) {

	while ($row_ayudante = mysql_fetch_array($result_ayudante)) {

		$porciones_ayudantes = explode("|", nombres_datos($row_ayudante[id_colaborador_proveedor], $row_ayudante[tipo]));

		$nombre_ayudante_table = ($porciones_ayudantes[11] == "Colaborador") ? "$porciones_ayudantes[10]($porciones_ayudantes[2])" : $porciones_ayudantes[10] ;

		$tabla_movimiento_ayudante .="<tr>
		<td>$nombre_ayudante_table</td>
		<td>$row_ayudante[comentarios]</td>
		</tr>";
	}

	$ayudante_logistica ="
	<div style='text-align: center; color: #882439;'>
	<h5>Acompañantes</h5>
	</div>
	<div>
	<table class='tabla-1'>
	<tbody>
	<tr>
	<th class='c-gradiant'>Nomenclatura</th>
	<th class='c-gradiant'>Descripción</th>
	</tr>
	$tabla_movimiento_ayudante 
	</tbody>
	</table>
	</div>
	";
	
}

#------------------------------------------- Unidades de Logística --------------------------------------------------------------------------------

$query_unidades = "SELECT * FROM orden_logistica_unidades WHERE idorden_logistica = '$idorden_logistica' and visible = 'SI'";
$result_unidades = mysql_query($query_unidades);

if (mysql_num_rows($result_unidades) >=1) {

	while ($row_unidades = mysql_fetch_array($result_unidades)) {

		$porciones_asignado_vin = explode("|",  nombres_datos($row_unidades[idpersona_asignada], $row_unidades[tipopersona_asignada]));
		$nombre_asignado_table = ($porciones_asignado_vin[11] == "Colaborador") ? "$porciones_asignado_vin[10]($porciones_asignado_vin[2])" : "$porciones_asignado_vin[10]($row_unidades[tipopersona_asignada])" ;

		$porciones_unidades = explode("|", date_vin(trim($row_unidades[vin])));

		$unidades_logistica .="<tr>
		<td>$row_unidades[tipo_orden]</td>
		<td>$porciones_unidades[0]</td>
		<td>$porciones_unidades[1]</td>
		<td>$porciones_unidades[2]</td>
		<td>$porciones_unidades[3]</td>
		<td>$porciones_unidades[4]</td>
		<td>$nombre_asignado_table</td>
		</tr>";
	}

	$detalle_unidades = "
	<div style='text-align: center; color: #882439;'>
	<h5>Unidades de Logística</h5>
	</div>
	<div>
	<table class='tabla-1'>
	<tbody>
	<tr>
	<th class='c-gradiant'>Rol</th>
	<th class='c-gradiant'>VIN</th>
	<th class='c-gradiant'>Marca</th>
	<th class='c-gradiant'>Versión</th>
	<th class='c-gradiant'>Color</th>
	<th class='c-gradiant'>Modelo</th>
	<th class='c-gradiant'>Persona Asignada</th>
	</tr>
	$unidades_logistica
	</tbody>
	</table>
	</div>
	";
}

#------------------------------------------- Documentación --------------------------------------------------------------------------------

$query_documentacion = "SELECT * FROM orden_logistica_documentacion WHERE idorden_logistica='$idorden_logistica' AND visible='SI'";
$result_documentacion = mysql_query($query_documentacion);

if (mysql_num_rows($result_documentacion)>= 1) {
	
	while ($row_documentacion = mysql_fetch_array($result_documentacion)) {

		$movimiento_fila_documentos .="
		<tr>
		<td>$row_documentacion[tipo]</td>
		<td>$row_documentacion[documento]</td>
		<td>$row_documentacion[valor]</td>
		</tr>
		";


		
	}

	$documentos_logistica = "
	<div style='text-align: center; color: #882439;'>
	<h5>Documentación</h5>
	</div>
	<div>
	<table class='tabla-1'>
	<tbody>
	<tr>
	<th class='c-gradiant'>Tipo</th>
	<th class='c-gradiant'>Documento</th>
	<th class='c-gradiant'>Comentarios</th>
	</tr>
	$movimiento_fila_documentos
	</tbody>
	</table>
	</div>";
}

#------------------------------------------- Orden Atención a Clientes --------------------------------------------------------------------------------

if ($ver_orden_atc != "" || $ver_orden_atc != null) {
	
	$query_atc = "SELECT * FROM atencion_clientes WHERE idatencion_clientes = '$ver_orden_atc'";
	$result_atc = mysql_query($query_atc);

	while ($row_atc = mysql_fetch_array($result_atc)) {

		$ver_vin_atc = explode("|", date_vin(trim($row_atc[datos_vin])));

		$vin_atc = ($ver_vin_atc[0] != "Por definir") ? "<b>$ver_vin_atc[0]</b> - " : "" ;
		$marca_atc = ($ver_vin_atc[1] != "Por definir") ? "$ver_vin_atc[1] - " : "" ;
		$version_atc = ($ver_vin_atc[2] != "Por definir") ? "$ver_vin_atc[2] - " : "" ;
		$color_atc = ($ver_vin_atc[3] != "Por definir") ? "$ver_vin_atc[3] - " : "" ;
		$modelo_atc = ($ver_vin_atc[4] != "Por definir") ? $ver_vin_atc[4] : "" ;


		$movimiento_row_atc .= "
		<tr>
		<td>$row_atc[idatencion_clientes]</td>
		<td>$vin_atc$marca_atc$version_atc$color_atc$modelo_atc</td>
		<td>$row_atc[comentarios]</td>
		</tr>
		";
	}

	$orden_atc = "
	<div style='text-align: center; color: #882439;'>
	<h5>Orden Atención a Clientes</h5>
	</div>
	<div>
	<table class='tabla-1'>
	<tbody>
	<tr>
	<th class='c-gradiant'>Orden</th>
	<th class='c-gradiant'>Datos VIN</th>
	<th class='c-gradiant'>Descripción</th>
	</tr>
	$movimiento_row_atc
	</tbody>
	</table>
	</div>";
}


#------------------------------------------- Autorizaciones Logística --------------------------------------------------------------------------------

$query_autorizaciones = "SELECT * FROM orden_logistica_autorizaciones WHERE visible = 'SI' AND idorden_logistica = '$idorden_logistica'";
$result_autorizaciones = mysql_query($query_autorizaciones);

if (mysql_num_rows($result_autorizaciones) >= 1) {

	while ($row_autorizaciones = mysql_fetch_array($result_autorizaciones)) {

		$autorizo_autorizacion = explode("|", nombres_datos($row_autorizaciones[idcolaborador], $row_autorizaciones[tipo_colaborador]));
		$solicito_autorizacion = explode("|", NameUsuarioCreador ($row_autorizaciones[usuario_creador]));

		$movimiento_row_autorizaciones .= "
		<tr>
		<td>$autorizo_autorizacion[2]</td>
		<td>$solicito_autorizacion[1]</td>
		<td>$row_autorizaciones[comentarios]</td>
		</tr>
		";
	}

	$autorizaciones_logistica = "
	<div style='text-align: center; color: #882439;'>
	<h5>Autorizaciones Logística</h5>
	</div>
	<div>
	<table class='tabla-1'>
	<tbody>
	<tr>
	<th class='c-gradiant'>Autorizó</th>
	<th class='c-gradiant'>Responsable</th>
	<th class='c-gradiant'>Descripción</th>
	</tr>
	$movimiento_row_autorizaciones
	</tbody>
	</table>
	</div>
	";
}

#------------------------------------------- Detalle de Solicitud --------------------------------------------------------------------------------

$porciones_solicitante = explode("|", nombres_datos($idsolicitante,$tipo_solicitante));
$nombre_solicitante = (trim($tipo_solicitante) == "Colaborador") ? "$porciones_solicitante[10]($porciones_solicitante[2])" : "$porciones_solicitante[10]($tipo_solicitante)";

$porciones_finformacion = explode("|", nombres_datos($idfuente_inf,$tipo_fuente_inf));
$nombre_fuente_inf = (trim($tipo_fuente_inf) == "Colaborador" ) ? "$porciones_finformacion[10]($porciones_finformacion[2])" : "$porciones_finformacion[10]($tipo_fuente_inf)";

$porciones_trasladista = explode("|", nombres_datos($idasigna,$tipo_asignante));
$nombre_asignante = (trim($tipo_asignante) == "Colaborador") ? "$porciones_trasladista[10]($porciones_trasladista[2])" : "$porciones_trasladista[10]($tipo_asignante)";


$detalle_solicitud = "
<div style='text-align: center; color: #882439;'>
<h5>Detalle de Solicitud</h5>
</div>

<div>
<table class='tabla-1'> 
<tr>
<td style='width: 25%; text-align: right;'><b>Solicitante</b></td>
<td style='width: 75%;'>$nombre_solicitante</td>
</tr>
<tr>
<td style='text-align: right;'><b>Fuente Informante</b></td>
<td>$nombre_fuente_inf</td> 

</tr>
<tr>
<td style='text-align: right;'><b>Trasladista</b></td>
<td>$nombre_asignante</td>

</tr>                                         
</tbody>
</table>
</div>
";

#------------------------------------------- Detalle de Actividad --------------------------------------------------------------------------------

$coment_actividad = "
<div style='text-align: center; color: #882439;'>
<h5>Detalle de Actividad</h5>
</div>
<div>
<table class='tabla-1'>
<tbody>
<tr>
<td><b>$comentario_general</b></td>                             
</tr>                                      
</tbody>
</table>
</div>
";

#------------------------------------------- Detalle de Actividad Ejecutivo de Traslado --------------------------------------------------------------------------------

$query_bitacora = "SELECT * FROM orden_logistica_bitacora WHERE idorden_logistica = '$idorden_logistica' and visible = 'SI' and tipo = 'Manejo Finalizado'";
$result_bitacora = mysql_query($query_bitacora);

if (mysql_num_rows($result_bitacora) >=1) {

	while ($row_bitacora = mysql_fetch_array($result_bitacora)) {

		$nomenclatura_usuarios = explode("|", NameUsuarioCreador ($row_bitacora[usuario_creador]));

		$agregar_comentario_ayudante .= "<tr>
		<td style='text-align: justify;'><b>$row_bitacora[comentarios]</b></td>
		<td style='text-align: left;'>$nomenclatura_usuarios[0]($nomenclatura_usuarios[1])</td>
		</tr>";

	}

	$coment_trastadista = "
	<div style='text-align: center; color: #882439;'>
	<h5>Detalle de Actividad Ejecutivo de Traslado</h5>
	</div>
	<div>
	<table class='tabla-1'>

	<tr>
	<th class='c-gradiant'>Descripción</th>
	<th class='c-gradiant'>Responsable</th>
	</tr>

	<tbody> 

	$agregar_comentario_ayudante

	</tbody>
	</table>
	</div>
	";

}

#------------------------------------------- Balance de Gastos de Operación --------------------------------------------------------------------------------

$query_monto_inicial = "SELECT sum(cargo) FROM balance_gastos_operacion where columna2 = '$idorden_logistica' and visible = 'SI' and concepto <> 'REEMBOLSO' ";
$result_monto_inicial = mysql_query($query_monto_inicial);

while ($row_monto_inicial = mysql_fetch_array($result_monto_inicial)) {

	$cargos_balance = (trim($row_monto_inicial[0]) == null || trim($row_monto_inicial[0]) == "") ? "$".number_format(0 , 2) : "$".number_format($row_monto_inicial[0],2) ;

}


$detalle_gastos_operacion = "
<div style='text-align: center; color: #882439; margin-top: 50px;'>
<h5>Balance de Gastos de Operación</h5>
</div>
<div>
<table class='tabla-1'>
<tbody>
<tr>
<td style='width: 25%; text-align: right;'><b>Cargos:</b></td>
<td style='width: 75%;'>$cargos_balance</td>
</tr>
</tbody>
</table>
</div>
";

#------------------------------------------- Detalle de Entrega --------------------------------------------------------------------------------

$detalle_logistica ="
<div style='text-align: center; color: #882439;'>
<h5>Detalle de Entrega </h5>
</div>

<div>
<table class='tabla-1'>
<tbody>
<tr>
<td style='width: 25%; text-align: right;'><span><b>Fecha y Hora Programada</b></span></td>
<td style='width: 25%;'><span>$fecha_programada</span></td>
<td style='width: 25%; text-align: right;'><span><b>Tiempo Estimado <q>Google Maps</q></b></span></td>
<td style='width: 25%;'><span>$tiempo_estimado</span></td>
</tr>

<tr>
<td style='text-align: right;'><b>Kilómetros de Distancia</b></td>
<td>$kilometros</td>
</tr>

</tbody>
</table>
</div>
";





$contenido='
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PANAMOTORS | REQUISICIÓN DE COMPRA</title>
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




.pleca-margin-top{

}

.container{
	width: 1024px;
	height: 400px;
	margin: 0;
}


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



p.titulo-datos-facturar-titulo{
	font-size: 10px;
	font-weight: bold;
	height: 18px;
	display: block;
	padding:0 0px -10px 0;
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



.content-datos-obs{
	margin:0px 0 0 0;
}

p.titulo-datos-obs {
	font-size: 10px;
	font-weight: bold;
	height: 18px;
	display: block;
	padding:0 20px 0 0;
}

p.text-datos-obs {
	font-size: 10px;
	height: 18px;
	display: block;
	text-align: right;
	color:gray;
}

p.titulo-datos {
	font-size: 10px;
	font-weight: bold;
	display: block;
	text-align: right;
	padding:0 20px 0 0;
}

p.text-datos {
	font-size: 10px;
	display: block;
}

.tabla-datos td, .tabla-datos th {
	padding: 8px;
}



.tabla-1 {
	border-collapse: none;
	width: 100%;
	font-size: 9px;
}

.tabla-1 td, .tabla-1 th {
	text-align: left;
	padding: 3px;
		//text-align: center;
}

.tabla-1 tr:nth-child(even) {
	text-align: left;
	padding: 8px;
	text-align: center;
}

.c-gradiant{
	background: linear-gradient(0deg,#c3c7cc, #ffffff, #c3c7cc);
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

.tabla-2 {
	border-collapse: collapse;
	width: 100%;
	margin: 20px 0 30px 0;
	font-size: 10px;
}

.tabla-2 td, .tabla-2 th {
		//border: 1px solid #dddddd;
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
	font-size: 10px;
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
	font-size: 10px;
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
	font-size: 10px;
	font-weight: bold;
	display: block;
	text-align: right;
	padding:0 0px 0px 0;
}

p.text-datos-total {
	font-size: 10px;
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
	background-color: transparent;
	color: black;
}

.datos-textos-grande{
	text-align: right;
}

.tabla_seguimientos {
		//border-collapse: collapse;
	width: 100%;
	margin: -1px 0 0 0;
	font-size: 9px;
}
.tabla_seguimientos td, .tabla_seguimientos th {
		// border: 1px solid #dddddd;
		// text-align: left;
	padding: 3px 40px 3px 3px;
	text-align: center;
}
.tabla_seguimientos tr:nth-child(even) {
		//border: 1px solid #dddddd;
		//text-align: left;
	padding: 3px 40px 3px 3px;
	text-align: center;
}

</style>
</head>

<body style=" margin: 0; background-image: url(../../img/estado-cuenta-panamotors/fondo2.png); background-repeat: no-repeat; background-position: center;">

<div class="container">

<div class="header">
<img src="../../img/estado-cuenta-panamotors/header_orden_logistica.png" class="img_header" alt="">
</div>

<div class="content-pedido">

<table class="tabla-datos-facturar">
<tr>
<td style="width: 20px;">
<p class="titulo-datos-facturar">ID: </p>
</td>
<td style="width: 257px;">
<p class="text-datos-facturar">'.$idorden_logistica_completo.'</p>
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
<th>FECHA:</th>
<th>DÍA</th>
<th>MES</th>
<th>AÑO</th>
</tr>
</table>
</div>


<div class="both">

</div>


<br>
<div class="invisible">

</div>
'.$encabezado.'
'.$datos_cliente.'
'.$domicilio_logistica.'
'.$ayudante_logistica.'
'.$detalle_unidades.'
'.$presupuesto_log.'
'.$documentos_logistica.'
'.$orden_atc.'
'.$autorizaciones_logistica.'
'.$detalle_solicitud.'
'.$coment_actividad.'
'.$coment_trastadista.'
'.$detalle_gastos_operacion.'
'.$detalle_logistica.'


<br> 

<table class="tabla-2">
<tr>
<td align="center">_____________________________________ <br> '.$nombre_asignante.' <br> Responsable</td>


<td align="center">________________________________ <br>Encargado de Logística <br> Autorizó </td>

</tr>



</table>


<div class="content-total-1">

</div>



<br>

<div class="both">

</div>


</div>


</body>
</html>
';

$query_seguimientos = "SELECT * FROM orden_logistica_bitacora WHERE idorden_logistica = '$idorden_logistica' and visible = 'SI' order by idorden_logistica_bitacora desc";
$result_seguimientos = mysql_query($query_seguimientos);

while ($row_seguimientos = mysql_fetch_array($result_seguimientos)) {

	$fecha_bitacora = date_format(date_create($row_seguimientos[fecha_guardado]), 'd-m-Y H:i');

	$name_bitacora_user = explode("|", NameUsuarioCreador ($row_seguimientos[usuario_creador]));

	$tabla_bitacora .= "
	<tr>
	<td style='text-align: right; font-size: 10px; width: 15%;'><b>Fecha/Usuario: </b></td>
	<td style='font-size: 10px; width: 67%;'> $fecha_bitacora - $name_bitacora_user[0]($name_bitacora_user[1])</td>
	<td style='width: 5%;'></td>
	<td style='width: 13%;'></td>
	</tr>
	<tr>
	<td style='text-align: right; font-size: 10px;'><b>Comentarios: </b></td>
	<td style='font-size: 10px;'>".$row_seguimientos[descripcion]."</td>
	<td style='text-align: right; font-size: 10px;'><b>Tipo: </b></td>
	<td style='font-size: 10px; padding-top: 14px;'>".$row_seguimientos[tipo]."</td>
	</tr>
	<br>
	<br>";
}


$kmjnhbgvf = '
<!DOCTYPE html>
<html>
<head>;
<title></title>
<style>
body{
	margin: 0;
}

.img_header2{
	width: 100%;
	height: 70px;
	margin-top: -70px;
}

.tabla-bitacora {
	border-collapse: collapse;
	width: 100%;
	font-size: 9px;
}
.tabla-bitacora td, .tabla-bitacora th {
	border: 1px solid #dddddd;
	text-align: left;
	padding: 3px;
}
.tabla-bitacora tr:nth-child(even) {
	border: 1px solid #dddddd;
	text-align: left;
	padding: 3px;
	background: #F3F3F3;
}
</style>
</head>
<body style=" margin: 0; background-image: url(../../img/estado-cuenta-panamotors/fondo2.png); background-repeat: no-repeat; background-position: center;">

<div class="container">

<div class="header">
<img src="../../img/estado-cuenta-panamotors/seguimientoordenlogistica.png" class="img_header2" alt="">
</div>
<br>
<br>

<table class="tabla-bitacora">
<tr>
<th colspan="4" style="color: #882439; padding: 10px 0px; text-align: center;"><font size="6"><b>Seguimientos</b></font></th>
</tr>

'.$tabla_bitacora.'
</table>
</body>
</html>
';










$monto_total_logistica = 0;
$metodo_pago_array = array();

$monto_total_efectivo = 0;
$monto_total_transferencia = 0;
$total_efectivo_transferencia = 0;

$contador_balance = 0;
$monto_row = 0;
$responsable = "";


$query_balance_gastos = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' AND tipo_movimiento = 'cargo' AND columna2 = '$idorden_logistica' ORDER BY fecha_movimiento,concepto,gran_total  ASC";
$result_balance_gastos = mysql_query($query_balance_gastos);

while ($row_balance_gastos = mysql_fetch_array($result_balance_gastos)) {

	$contador_balance ++;

	$fecha_movimiento = date_format(date_create($row_balance_gastos[fecha_movimiento]), "d-m-Y");


	$concepto = ucfirst(strtolower($row_balance_gastos[concepto]));

	$monto_total_logistica += $row_balance_gastos[gran_total];

	$monto_row = number_format($row_balance_gastos[gran_total],2);

	if (is_numeric($row_balance_gastos[responsable])) {

		$show_responsable = explode("|", nombres_datos($row_balance_gastos[responsable], "Colaborador"));
		$responsable = $show_responsable[2];

	}else {

		$responsable = $row_balance_gastos[responsable];

	}

	if (trim($row_balance_gastos[comision]) == "N/A" ) {

		$valor_metodo_pago = 1;

		$monto_total_efectivo += $row_balance_gastos[gran_total];

	}else {

		$valor_metodo_pago = 3;
		$total_efectivo_transferencia += $row_balance_gastos[gran_total];

	}

	array_push($metodo_pago_array, $valor_metodo_pago);

	$movimientos_balance_tabla .= "
	<tr>
	<td><span>$contador_balance</span></td>
	<td><span>$fecha_movimiento</span></td>
	<td><span>$concepto</span></td>
	<td><span>$$monto_row</span></td>
	<td><span>$responsable</span></td>
	</tr>
	";
}

$monto_total_logistica = number_format($monto_total_logistica,2);

$monto_total_efectivo = number_format($monto_total_efectivo,2);

if (count($metodo_pago_array) == 0) {

	$total_metodo_pago = "N/A";

}else {

	$tratar_metodo_pago = Tratar_Array ($metodo_pago_array);
	$total_metodo_pago = implode(",", $tratar_metodo_pago);

}

$total_efectivo_transferencia = number_format($total_efectivo_transferencia,2);




$tabla_encabezados_balance = "

<div class='content-facturar' style='margin-top: 20px;'>

<table class='tabla-1-1'>

<tr>
<td style='width: 25%; text-align: right;'><b>MONTO TOTAL LOGÍSTICA:</b></td>
<td style='width: 25%;'>$$monto_total_logistica</td>
<td style='width: 25%; text-align: right;'><b>MONTO TOTAL EFECTIVO:</b></td>
<td style='width: 25%;'>$$monto_total_efectivo</td>
</tr>

<tr>
<td style='text-align: right;'><b>MÉTODO DE PAGO:</b></td>
<td>$total_metodo_pago</td>
<td style='text-align: right;'><b>MONTO TOTAL TRANSFERENCIA:</b></td>
<td>$$total_efectivo_transferencia</td>
</tr>

</table>
</div>
";


$tabla_movimientos_balance = "
<table class='tabla-1 tabla-sn-borde'>
<tr>
<th class='c-gradiant-v' style='width: 5%;'>#</th>
<th class='c-gradiant-v' style='width: 10%;'>FECHA</th>
<th class='c-gradiant-v' style='width: 60%;'>CONCEPTO</th>
<th class='c-gradiant-v' style='width: 15%;'>MONTO</th>
<th class='c-gradiant-v' style='width: 10%;'>RESPONSABLE</th>
</tr>

$movimientos_balance_tabla

</table>
";







$contenido_balance='<!DOCTYPE html>
<html lang="es">
<head>
<meta charset = "utf-8">
<title>PANAMOTORS | Logística</title>
<style type="text/css">
body{
	margin: 0;
	font-family: "geometric";
}
.img_header{
	height: 70px;
	width: 100%;
	margin-top: -70px;	
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

	padding: 0px;

}
.tabla-datos-facturar tr{
	margin:0;
}
.tabla-datos-facturar tr:nth-child(even) {
	margin:0;
}


p.text-datos-obs {
	font-size: 10px;
	height: 18px;
	display: block;
	color:gray;
	text-align: right;
}
p.titulo-datos {
	font-size: 10px;
	font-weight: bold;
	display: block;
	text-align: right;
	padding:0 20px 0 0;
}
p.text-datos {
	font-size: 10px;
	display: block;
}
.tabla-datos td, .tabla-datos th {
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
.c-gradiant{
	background: linear-gradient(0deg,#c3c7cc, #ffffff, #c3c7cc);
}	
.tabla-2 {
	border-collapse: collapse;
	width: 100%;
	margin: 20px 0 30px 0;
	font-size: 10px;
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
	font-size: 10px;
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
	font-size: 10px;
	font-weight: bold;
	height: 18px;
	margin: 0px 0 -20px 0;
}

.content-total-1{
	width:50%;
	display:block;
	float:left;
}

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
	font-size: 10px;
	font-weight: bold;
	display: block;
	text-align: right;
	padding:0 0px 0px 0;
}
p.text-datos-total {
	font-size: 10px;
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
	background-color: transparent;
	color: black;
}
.datos-textos-grande{
	text-align: right;
}
.tabla-1-1 {
	border-collapse: collapse;
	width: 100%;
	margin: 0;
	font-size: 8px;
}
.tabla-1-1 td, .tabla-1-1 th {
	//border: 1px solid #dddddd;
	text-align: left;
	padding: 3px;
	margin: 0;
            //text-align: center;
}
.tabla-1-1 tr:nth-child(even) {
	//border: 1px solid #dddddd;
	text-align: center;
	padding: 0;
	//text-align: center;
}
.c-gradiant-v{
	background: linear-gradient(0deg, #882439, #A51D3A, #882439);
	color: #fff;
}	
</style>
</head>
<body style=" margin: 0; background-image: url(../../img/estado-cuenta-panamotors/fondo2.png); background-repeat: no-repeat; background-position: center;">
<div class="container">

<div class="header">

<img src="../../img/estado-cuenta-panamotors/header_balance_operacion.png" class="img_header" alt="">

</div>

<div class="content-pedido">
<table class="tabla-datos-facturar">
<tr>
<td style="width: 20px;">
<p class="titulo-datos-facturar">Logística:</p>
</td>
<td style="width: 257px;">
<p class="text-datos-facturar">'." "."L".$idorden_logistica_completo.'</p>


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
<td>'.$hora.'</td>
</tr>
<tr>
<th>FECHA CORTE:</th>
<th>DÍA</th>
<th>MES</th>
<th>AÑO</th>
<th>HORA</th>
</tr>
</table>
</div>

<div class="both"></div>

<div class="header">
<img src="../../img/estado-cuenta-panamotors/pleca.png" alt="">
</div>


'.$tabla_encabezados_balance.'

<br>
<div class="invisible"></div>

<br>
<br>

'.$tabla_movimientos_balance.'



</body>
</html>';



#echo $contenido;
#echo $seguimientos;
#echo $contenido_balance;
include("../../MPDF57/mpdf.php");

$mpdf=new mPDF('s','Letter','','','10','10','28','30'); 

$mpdf->SetHTMLFooter('
	<p class="text-datos-obs"><img src="../../img/estado-cuenta-panamotors/footer2.png" alt="">{PAGENO} de {nb}</p>
	');

$mpdf->WriteHTML($contenido);
$mpdf->AddPage();
$mpdf->WriteHTML($kmjnhbgvf);
$mpdf->AddPage();
$mpdf->WriteHTML($contenido_balance);

$nombre_archivo = "L".$idorden_logistica_completo.".pdf";
$mpdf->Output($nombre_archivo, 'I');

exit;

?>
