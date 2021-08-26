<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";
include_once "../../recuperar_usuario.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$fecha_actual_day_now = date("Y-m-d H:i:s");
$usuario_creador = $_SESSION['usuario_clave'];
$usuario_loguin = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
header("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

$random = rand(5, 15);

#------------------------------------------Num Logistica---------------------------------------------------------------------------------
$recibido = $_REQUEST["idib"];

$idc = base64_decode($recibido);

$n1 = strlen($idc);
$n1_aux = 6 - $n1;
$mat = "";

for ($i = 0; $i < $n1_aux; $i++) {
	$mat .= "0";
}

$id_contacto_completo = $mat . $idc;


#-------------------------------------------Inicia Logistica--------------------------------------------------------------------------------
$sql0 = "SELECT * FROM orden_logistica WHERE idorden_logistica='$idc'";
$result0 = mysql_query($sql0);
while ($fila0 = mysql_fetch_array($result0)) {

	$idorden_logistica = trim("$fila0[idorden_logistica]");
	$fecha_solicitud = trim("$fila0[fecha_solicitud]");
	$fecha_programada = trim("$fila0[fecha_programada]");
	$fecha_salida = trim("$fila0[fecha_salida]");
	$fecha_retorno = trim("$fila0[fecha_retorno]");
	$fecha_llega_destino = trim("$fila0[fecha_llega_destino]");
	$hora_real_solucion = trim("$fila0[hora_real_solucion]");
	$tiempo_estimado = trim("$fila0[tiempo_estimado]");
	$fecha_estimada_solucion = trim("$fila0[fecha_estimada_solucion]");
	$estado_origen = trim("$fila0[estado_origen]");
	$municipio_origen = trim("$fila0[municipio_origen]");
	$colonia_origen = trim("$fila0[colonia_origen]");
	$calle_origen = trim("$fila0[calle_origen]");
	$coordenadas_origen = trim("$fila0[coordenadas_origen]");
	$cp_origen = trim("$fila0[cp_origen]");
	$estado_destino = trim("$fila0[estado_destino]");
	$municipio_destino = trim("$fila0[municipio_destino]");
	$colonia_destino = trim("$fila0[colonia_destino]");
	$calle_destino = trim("$fila0[calle_destino]");
	$cp_destino = trim("$fila0[cp_destino]");
	$ubicacion_destino = trim("$fila0[ubicacion_destino]");
	$idcontacto = trim("$fila0[idcontacto]");
	$tipo_contacto = trim("$fila0[tipo_contacto]");
	$kilometros = trim("$fila0[kilometros]");
	$rendimiento = trim("$fila0[rendimiento]");


	$idsolicitante = trim("$fila0[idsolicitante]");
	$tipo_solicitante = trim("$fila0[tipo_solicitante]");

	$idfuente_inf = trim("$fila0[idfuente_inf]");
	$tipo_fuente_inf = trim("$fila0[tipo_fuente_inf]");

	$idasigna = trim("$fila0[idasigna]");
	$tipo_asignante = trim("$fila0[tipo_asignante]");

	$presupuesto = trim("$fila0[presupuesto]");
	$cantidad_presupuesto = number_format("$fila0[cantidad_presupuesto]", 2);
	$reembolso = trim("$fila0[reembolso]");
	$cantidad_reembolso = number_format("$fila0[cantidad_reembolso]", 2);

	$comentario_general = trim("$fila0[comentario_general]");
	$iddepartamento = trim("$fila0[iddepartamento]");
	$idcatalogo_orden_logistica = trim("$fila0[idcatalogo_orden_logistica]");
	$visible = trim("$fila0[visible]");
	$usuario_creador_logistica = trim("$fila0[usuario_creador]");
	$fecha_creacion = trim("$fila0[fecha_creacion]");
	$fecha_guardado = trim("$fila0[fecha_guardado]");
}
#-------------------------------------------Array trasladista y ayudantes para balance de gastos--------------------------------------------------------------------------------
$array_responsable_balance = array();

#-------------------------------------------Id--------------------------------------------------------------------------------

$nombre_id = nombres_datos($idcontacto, $tipo_contacto);
$porciones_id = explode("|", $nombre_id);
$nombre = $porciones_id[0];
$apellidos = $porciones_id[1];
$alias = $porciones_id[2];
$telefono = $porciones_id[3];
$telefono_otro = $porciones_id[4];
$estado_cliente = $porciones_id[5];
$municipio_cliente = $porciones_id[6];
$calle_cliente = $porciones_id[7];
$colonia_cliente = $porciones_id[8];
$cp_cliente = $porciones_id[9];
$tipo_id_contacto = $porciones_id[11];

$cli = strlen($idcontacto);
$cli_aux = 6 - $cli;
$mate = "";

for ($i = 0; $i < $cli_aux; $i++) {
	$mate .= "0";
}

$id_client = $mate . $idcontacto;

#-------------------------------------------Solicitante--------------------------------------------------------------------------------

$buscar_solicitante = nombres_datos($idsolicitante, $tipo_solicitante);
$porciones_solicitante = explode("|", $buscar_solicitante);
$nombre_solicitante = (trim($tipo_solicitante) == "Colaborador") ? "$porciones_solicitante[10]($porciones_solicitante[2])" : "$porciones_solicitante[10]($tipo_solicitante)";

#-------------------------------------------F. Informacion--------------------------------------------------------------------------------
$buscar_finformacion = nombres_datos($idfuente_inf, $tipo_fuente_inf);
$porciones_finformacion = explode("|", $buscar_finformacion);
$nombre_fuente_inf = (trim($tipo_fuente_inf) == "Colaborador") ? "$porciones_finformacion[10]($porciones_finformacion[2])" : "$porciones_finformacion[10]($tipo_fuente_inf)";

#-------------------------------------------Trasladista--------------------------------------------------------------------------------

$buscar_trasladista = nombres_datos($idasigna, $tipo_asignante);
$porciones_trasladista = explode("|", $buscar_trasladista);
$nombre_asignante = (trim($tipo_asignante) == "Colaborador") ? "$porciones_trasladista[10]($porciones_trasladista[2])" : "$porciones_trasladista[10]($tipo_asignante)";

if ($porciones_trasladista[10] != "Pendiente" and $idasigna != "" and $tipo_asignante != "") {
	array_push($array_responsable_balance, "$idasigna|$tipo_asignante|$porciones_trasladista[10]");
}

if ($tipo_asignante == "Colaborador") {

	$query_picture = "SELECT * FROM empleados  WHERE idempleados = '$idasigna'";
	$result_picture = mysql_query($query_picture);

	if (mysql_num_rows($result_picture) == 0) {

		$foto_ejecutivo = "../../Foto_Colaboradores/ejecutivo.png";
	} else {

		while ($row_picture = mysql_fetch_array($result_picture)) {

			$foto_ejecutivo = (file_exists($$row_picture[foto_reciente])) ?  $row_picture[foto_reciente] : "../../Foto_Colaboradores/ejecutivo.png";
		}
	}
} else {
	$foto_ejecutivo = "../../Foto_Colaboradores/ejecutivo.png";
}

#-------------------------------------------departamento--------------------------------------------------------------------------------
$sqld = "SELECT * FROM catalogo_departamento WHERE idcatalogo_departamento = '$iddepartamento'";
$resultd = mysql_query($sqld);
while ($filad = mysql_fetch_array($resultd)) {
	$nombre_departamento = "$filad[nombre]";
	$id_departamento = "$filad[idcatalogo_departamento]";
}

$sql1 = "SELECT * FROM orden_logistica_tipo_orden WHERE idorden_logistica_tipo_orden = '$idcatalogo_orden_logistica'";
$result1 = mysql_query($sql1);
while ($fila1 = mysql_fetch_array($result1)) {
	$nombre_orden = "$fila1[nombre]";
}

#-------------------------------------------Nombre Usuario Creador de Logistica--------------------------------------------------------------------------------

$buscar_nombre_usuario_creador = explode("|", NameUsuarioCreador($usuario_creador_logistica));

$nombre_usuario_creador = $buscar_nombre_usuario_creador[1];

#-------------------------------------------Bitacora--------------------------------------------------------------------------------
$sql3 = "SELECT * FROM orden_logistica_bitacora WHERE idorden_logistica = '$idc' and visible = 'SI' and valor = '1' order by idorden_logistica_bitacora desc limit 1";
$result3 = mysql_query($sql3);

if (mysql_num_rows($result3) == 0) {
	$tipo_estado_nuevo = "Solicitud";
	$tipo_estado = "Solicitud";

	$estatus_logistica = $tipo_estado;
} else {

	while ($row2 = mysql_fetch_array($result3)) {

		$tipo_estado_nuevo = "$row2[tipo]";

		$tipo_estado = $tipo_estado_nuevo;

		$estatus_logistica = $row2[tipo];
	}
}


#-------------------------------------------Estados--------------------------------------------------------------------------------

$estado = $tipo_estado;
///Barra
if ($estado == "Solicitud") {
	$barra = "6";
	$pStatus = "20";
}
if ($estado == "Enterado") {
	$barra = "17";
	$pStatus = "25";
}
if ($estado == "Inicia Recorrido") {
	$barra = "28";
	$pStatus = "35";
}
if ($estado == "Destino Alcanzado") {
	$barra = "50";
	$pStatus = "60";
}
if ($estado == "Retorno Origen") {
	$barra = "61";
	$pStatus = "70";
}
if ($estado == "Manejo Finalizado") {
	$barra = "72";
	$pStatus = "80";
}
if ($estado == "Cuentas") {
	$barra = "83";
	$pStatus = "90";
}
if ($estado == "Resuelto") {
	$barra = "94";
	$pStatus = "100";
}
if ($estado == "Cancelado") {
	$barra = "94";
	$pStatus = "100";
}
if ($estado == "Sin Disponibilidad") {
	$barra = "39";
	$pStatus = "50";
}

#---------------------------------------------------------------------------------------------------------------------------
$anterior = $idc - 1;
$back = base64_encode($anterior);
$siguiente = $idc + 1;
$next = base64_encode($siguiente);

$query_max = "SELECT * FROM orden_logistica";
$result_max = mysql_query($query_max);

$ok = mysql_num_rows($result_max);

if ($idc > 1) {

	$back_back = "
	<a href='orden_logistica_detalles.php?idib=$back' class='d-flex align-items-center' style='font-size: 12px;'>
	<i class='fas fa-chevron-circle-left fa-2x' style='color: #4e4e4e;'></i>
	<span class='text-white'>Orden Anterior</span>
	</a>";

	$back_back2 = "
	<a href='orden_logistica_detalles.php?idib=$back' class='d-flex align-items-center' style='font-size: 12px;'>
	<i class='fas fa-chevron-circle-left fa-2x' style='color: #DD2E5E;'></i>
	<span>Orden Anterior</span>
	</a>";
}

if ($idc < $ok) {

	$next_next = "
	<a href='orden_logistica_detalles.php?idib=$next' class='d-flex align-items-center' style='font-size: 12px;'>
	<span class='text-white'>Orden Siguiente</span>
	<i class='fas fa-chevron-circle-right fa-2x' style='color: #4e4e4e;'></i>
	</a>";

	$next_next2 = "
	<a href='orden_logistica_detalles.php?idib=$next' class='d-flex align-items-center' style='font-size: 12px;'>
	<span>Orden Siguiente</span>
	<i class='fas fa-chevron-circle-right fa-2x' style='color: #DD2E5E;'></i>
	</a>";
}

#---------------------------------------------------------------------------------------------------------------------------
$query_concepto_balance = "SELECT concepto FROM balance_gastos_operacion WHERE visible = 'SI' GROUP BY concepto";
$result_concepto_balance = mysql_query($query_concepto_balance);

while ($row_concepto_balance = mysql_fetch_array($result_concepto_balance)) {

	$options_form_balance .= "<option value='$row_concepto_balance[concepto]'>$row_concepto_balance[concepto]</option>";
}


#---------------------------------------------------------------------------------------------------------------------------
$query_auxiliares = "SELECT nombre FROM balance_gastos_auxiliares WHERE visible = 'SI' GROUP BY nombre";
$result_auxiliares = mysql_query($query_auxiliares);

while ($row_auxiliares = mysql_fetch_array($result_auxiliares)) {
	$show_auxiliares .= "<option>$row_auxiliares[nombre]</option>";
}


#---------------------------------------------------------------------------------------------------------------------------




?>
<!DOCTYPE html>
<html lang="es">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keywords" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keywords" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!--Meta Responsive tag-->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



	<!--Bootstrap CSS-->
	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<!--Custom style.css-->
	<link rel="stylesheet" href="../../assets/css/quicksand.css">
	<link rel="stylesheet" href="../../assets/css/style.css">
	<link rel="stylesheet" href="../../assets/css/alert_popup.css">
	<link rel="stylesheet" href="../../assets/css/mod_style_datatables.css">
	<!--Font Awesome-->
	<link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css">
	<link rel="stylesheet" href="../../assets/css/fontawesome.css">
	<!-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.14.0/css/all.css"> -->
	<!--Slick Carousel CSS-->
	<link rel="stylesheet" href="../../assets/css/slick/slick.css">
	<link rel="stylesheet" href="../../assets/css/slick/slick-theme.css">
	<!--Rating Bars-->
	<link rel="stylesheet" href="../../assets/css/fontawesome-stars.css">
	<!--Datatable-->
	<link rel="stylesheet" href="../../assets/css/dataTables.bootstrap4.min.css">
	<!--Bootstrap Calendar-->
	<link rel="stylesheet" href="../../assets/js/calendar/bootstrap_calendar.css">

	<link rel="stylesheet" href="../../assets/css/themify-icons.css">
	<link rel="stylesheet" href="../../assets/css/paper-bootstrap-wizard.css">


	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="57x57" href="../../img/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="../../img/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../../img/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="../../img/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../../img/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="../../img/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="../../img/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="../../img/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="../../img/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="../../img/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../../img/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../../img/favicon/favicon-16x16.png">
	<link rel="manifest" href="../../img/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="../../img/favicon/ms-icon-144x144.png">


	<!-- DataTables CSS -->
	<link href="../../plugins/datatables/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

	<!-- DataTables Responsive CSS -->
	<link href="../../plugins/datatables/datatables-responsive/dataTables.responsive.css" rel="stylesheet">


	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="../../js/jquery-1.10.2.js"></script>
	<script src="../../js/jquery-ui.js"></script>

	<!-- Bootstrap Material DatePicker CSS-->
	<link rel="stylesheet" href="../../plugins/Datepicker/jquery.datetimepicker.css">
	<link rel="stylesheet" href="../../plugins/Datepicker/bootstrap-material-datetimepicker.css">
	<!-- Bootstrap Material DatePicker JS-->
	<script src="../../plugins/Datepicker/material.min.js"></script>
	<script src="../../plugins/Datepicker/moment-with-locales.min.js"></script>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.date.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.time.css">


	<script src="funciones_js_global.js"></script>

	<title>CCP | Orden de Logística</title>

	<style type="text/css">
		#rcorners2error {
			-webkit-box-shadow: 0px 0px 100px -15px rgba(164, 30, 54, 1);
			-moz-box-shadow: 0px 0px 100px -15px rgba(164, 30, 54, 1);
			box-shadow: 0px 0px 100px -15px rgba(164, 30, 54, 1);
		}

		#rcorners2bien {
			-webkit-box-shadow: 0px 0px 100px -15px rgba(57, 178, 38, 1);
			-moz-box-shadow: 0px 0px 100px -15px rgba(57, 178, 38, 1);
			box-shadow: 0px 0px 100px -15px rgba(57, 178, 38, 1);
		}

		/* i {
    color: #882439;
    } */
	</style>

	<style>
		#res_p {
			font-size: 1.3em;
		}

		#res_span {
			font-size: .8em;
		}



		.en_medio {
			text-align: center;
			vertical-align: middle;
		}
	</style>
	<style>
		/*Scroll de tablas*/
		#columna {
			overflow: auto;
			margin: 5px;
			width: 100%;
			height: 500px;
			/*establece la altura máxima, lo que no entre quedará por debajo y saldra la barra de scroll*/
		}
	</style>
	<style>
		/* Always set the map height explicitly to define the size of the div
  * element that contains the map. */
		#map {
			height: 400px;
			/* The height is 400 pixels */
			width: 100%;
			/* The width is the width of the web page */
		}


		#floating-panel {
			position: absolute;
			top: 10px;
			left: 25%;
			z-index: 5;
			background-color: #fff;
			padding: 5px;
			border: 1px solid #999;
			text-align: center;
			font-family: 'Roboto', 'sans-serif';
			line-height: 30px;
			padding-left: 10px;
		}

		#floating-panel {
			position: absolute;
			top: 5px;
			left: 50%;
			margin-left: -180px;
			width: 350px;
			z-index: 5;
			background-color: #fff;
			padding: 5px;
			border: 1px solid #999;
		}

		/* #latlng {
  width: 225px;
  } */


		.stilo_border {
			width: 100%;
			margin: 20px 0;
			box-sizing: border-box;
			border: 2px solid #ff9900;
			border-radius: 4px;
		}

		.wizard-card {
			min-height: 120px;
		}

		.wizard-card .icon-circle {
			color: #161616;
		}

		.wizard-card[data-color="theme"] .nav-pills>li.active>a:after,
		.wizard-card[data-color="theme"] .nav-pills>li a.active:after {
			background: #882439;
		}

		.wizard-card .icon-circle [class*="fa-"] {
			position: absolute;
			z-index: 500;
			left: -3px;
			right: 0;
			width: 70px;
			text-align: center;
			top: 23px;
			background: #fff !important;
		}

		.nav-pills>li.active>a [class*="fa-"],
		.nav-pills>li.active>a:hover [class*="fa-"],
		.nav-pills>li.active>a:focus [class*="fa-"],
		.nav-pills>li a.active [class*="fa-"],
		.nav-pills>li a.active:hover [class*="fa-"],
		.nav-pills>li a.active:focus [class*="fa-"] {
			background: transparent !important;
			color: #fff;
		}

		.nav-pills>li:last-child a.active:after {
			left: -35px;
		}

		.nav-pills>li.active>a:after,
		.nav-pills>li a.active:after {
			content: '';
			width: 70px;
			height: 70px;
			border-radius: 50%;
			display: inline-block;
			position: absolute;
			right: auto;
			left: -35px;
			top: -2px;
			transform: scale(1);
		}

		.wizard-card[data-color="theme"] .nav-pills .icon-circle.checked {
			border-color: #882439;
			background-color: #ffffff !important;
		}

		.progress-bar:before,
		.progress-bar:after {
			animation: none;
			display: none;
		}

		.wizard-card[data-color="theme"] .nav-pills>li.active>a:after,
		.wizard-card[data-color="theme"] .nav-pills>li a.desactive:after {
			background: none;
		}

		.nav-pills>li>a {
			font-size: 10px;
		}

		.wizard-card[data-color="theme"] .nav-pills>li.active>a,
		.wizard-card[data-color="theme"] .nav-pills>li a.active {
			font-size: 10px;
		}

		.textPorcentage,
		.textEstatus {
			font-size: 10px !important;
		}

		.tooltipEstatus {
			position: absolute;
			left: 50%;
			top: -50px;
			transform: translateX(-50%);
			width: 200px;
			background: #444;
			color: #ccc;
			transition: .5s;
			border-radius: 10px;
			display: none;
		}

		.tooltipEstatus:before {
			content: '';
			position: absolute;
			width: 14px;
			height: 14px;
			background: #444;
			left: 50%;
			transform: translateX(-50%) rotate(45deg);
			bottom: -7px;
		}

		/* .wizard-navigation ul li a{
	cursor: default !important;
	} */
		@media only screen and (max-width: 868px) {
			.wizard-card {
				min-height: 100px;
			}

			.wizard-card .icon-circle {
				width: 40px;
				height: 40px;
				margin-top: 15px;
			}

			.nav-pills>li.active>a:after,
			.nav-pills>li a.active:after {
				width: 40px;
				height: 40px;
				left: -20px;
				top: 13px;
			}

			.nav-pills>li:last-child a.active:after {
				left: -20px;
			}

			.wizard-card .icon-circle [class*="fa-"] {
				top: 10px;
				width: 40px;
				font-size: 16px;
			}

			.tooltipEstatus {
				display: block;
			}

			.textEstatus {
				display: none;
			}
		}

		@media only screen and (max-width: 580px) {
			.wizard-card .icon-circle {
				width: 30px;
				height: 30px;
				margin-top: 21px;
			}

			.nav-pills>li.active>a:after,
			.nav-pills>li a.active:after {
				width: 30px;
				height: 30px;
				left: -15px;
				top: 19px;
			}

			.nav-pills>li:last-child a.active:after {
				left: -15px;
			}

			.wizard-card .icon-circle [class*="fa-"] {
				top: 7px;
				width: 30px;
				font-size: 12px;
			}
		}

		.txt-balance {
			text-align: center;
		}

		.picker__holder {

			overflow: hidden !important;
		}

		.picker--opened .picker__frame {

			transform: translateY(0) !important;
			top: 0 !important;

		}

		.contador_span {
			float: right;
			color: #882439;
			font-style: italic;
		}
	</style>

</head>

<body onload="LoadingFunctions()">

	<!--Page Wrapper-->

	<div class="container-fluid p-0">

		<?php
		include_once "menu.php";
		?>

		<div class="error-form" style="background: rgba(255, 255, 255, 1); width: 100%; height: 100vh; position: fixed; z-index: 9999; top: 0px; display: none;">
			<div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%);">
				<div class="popup-mensaje popuperror animatepopup">
					<div style="padding: 10px 20px; background: #F13154;">
						<div class="error">
							<span class="icono-error"></span>
						</div>
					</div>
					<div class="text-center mt-2" style="padding: 10px 20px;">
						<h1 style="font-size: 22px;" class="text-error"></h1>
					</div>
				</div>
			</div>
		</div>

		<div class='listo-form' style="background: rgba(255, 255, 255, 1); width: 100%; height: 100vh; position: fixed; z-index: 9999; top: 0px; display: none;">
			<div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%);">
				<div class="popup-mensaje popuplisto animate-popup">
					<div style="padding: 10px 20px; background: #25E28C;">
						<div class="listo">
							<span class="icono-listo"></span>
						</div>
					</div>
					<div class="text-center mt-2" style="padding: 10px 20px;">
						<h1 style="font-size: 22px;" class="text-listo"></h1>
					</div>
				</div>
			</div>
		</div>


		<div class="col-sm-9 col-xs-12 content pt-3 p-0">
			<div class="row mt-3 m-0">
				<div class="col-sm-12">
					<div class="mt-1 mb-3 p-3 button-container fondo-container">
						<div class="ibox-title">
							<?php
							echo "$nombre_departamento / $nombre_orden / ";
							?>
							<a href='#' data-toggle='modal' data-target='#modal_change_dep_orden' data-bs-toggle="tooltip" data-bs-placement="top" title="Cambiar departamento | tipo de orden"><i class='fas fa-bezier-curve fa-1.5x' aria-hidden='true'></i></a>
						</div>


						<div class="modal fade" id="modal_change_dep_orden" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Cambiar Departamento / Tipo Orden</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">

										<form name="form_dep" method="POST" action="guardar_change_dep_orden.php">
											<?php date_default_timezone_set('America/Mexico_City');
											$fecha_creacion_dep_orden = date("Y-m-d H:i:s"); ?>
											<div class="container">

												<div class="row">
													<div class="col-sm-12">
														<label for="departamento">*Departamento</label>
														<div class="content-select">
															<select name="departamento" id="departamento" class="form-control" required="">
																<option value="">Selecciona departamento ...</option>
																<?php

																$query1 = "SELECT * FROM catalogo_departamento where visible_logistica = 'SI' order by nombre asc";
																$result1 = mysql_query($query1);

																while ($row1 = mysql_fetch_array($result1)) {

																	if ($row1[nombre] == "Admon. de Compras") {
																		$name_departamento = "Administración de Compras";
																	} else {
																		$name_departamento = $row1[nombre];
																	}
																	echo "<option value=$row1[idcatalogo_departamento]>$name_departamento</option>";
																}

																?>
															</select>
															<i></i>
														</div>
													</div>

													<div class="col-sm-12">
														<label for="tipo_orden">*Tipo de Orden</label>
														<div class="content-select">
															<select name="tipo_orden" id="tipo_orden" class="form-control">
																<option value="">Selecciona una opción...</option>
															</select>
															<i></i>
														</div>
													</div>


													<div class="col-sm-12">
														<label for="comentario_dep_orden">*Detalles del Cambio</label>
														<textarea class="form-control" rows="3" id="comentario_dep_orden" name="comentario_dep_orden" maxlength="8950" required=""></textarea>
													</div>


													<input type="hidden" name="id_logistica_dep_orden" value='<?php echo "$recibido"; ?>'>
													<input type="hidden" name="fecha_creacion_dep_orden" value='<?php echo "$fecha_creacion_dep_orden"; ?>'>
													<input type="hidden" name="coordenadas_dep_orden" class="coordenadas">


												</div>


											</div>

											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
												<button class="btn btn-lg btn-primary" type="submit">Guardar</button>
											</div>

										</form>
									</div>

								</div>
							</div>
						</div>


						<div class="col-lg-12 p-0">
							<!-- ***************Sub-menu****************************** -->
							<ol class="breadcrumb fondo-encabezados d-flex align-items-center">
								<li>
									<a class="text-white" href="index.php">Inicio</a>
								</li>
								<span class="text-white"> &nbsp;/&nbsp; </span>
								<li>
									<a class="text-white" href="agregar_orden_logistica.php"> Agregar Nueva orden</a>
								</li>
								<span class="text-white"> &nbsp;/&nbsp; </span>
								<li>
									<a class="text-white" href="orden_logistica_resumen.php">Resúmen Ordenes Logística</a>
								</li>
								<span class="text-white"> &nbsp;/&nbsp; </span>
								<li class="active">
									<?php

									echo "<a class='text-white d-flex align-items-center' href='requisicion_compra_pdfV2.php?idc=$recibido' target='_blank'><strong class='mr-2'>Detalle Orden Logística </strong><i class='fa fa-file-pdf-o fa-2x' aria-hidden='true'></i></a>";
									?>
								</li>

								<span class="text-white"> &nbsp;/&nbsp; </span>
								<li class="active">
									<strong></strong>
									<?php
									echo "<a class='text-white d-flex align-items-center' href='balance_gastos_operacion_pdf.php?idc=$recibido' target='_blank'><strong class='mr-2'>Balance de Gastos de Operación </strong><i class='fa fa-file-pdf-o fa-2x' aria-hidden='true'></i></a>";
									?>
								</li>

								<span class="text-white"> &nbsp;/&nbsp; </span>
								<li class="active">

									<div class="d-flex justify-content-center">
										<?php echo $back_back; ?>
										<a href="orden_logistica_detalles.php?idib=<?php echo $recibido; ?>" class="d-flex align-items-center" style="font-size: 12px; margin: 0px 10px"><i class="fa fa-play fa-2x" aria-hidden="true" style="color: #4e4e4e;"></i></a>
										<?php echo $next_next; ?>
									</div>

								</li>
							</ol>
							<!-- ***************Imagen - Foto****************************** -->



							<div class="col-lg-12 imagen-perfil">
								<center>
									<?php
									echo "<h2 class='text-ids-1'><strong>L$id_contacto_completo</strong></h2>";

									echo "<div class='col-sm-12 d-flex justify-content-center'>
									<img src='$foto_ejecutivo' alt='' style='width: 100px; height: 100px; border-radius: 50%;'>
									</div>";

									if ($tipo_estado == "Enterado" || $tipo_estado == "Inicia Recorrido" || $tipo_estado == "Enterado" || $tipo_estado == "Destino Alcanzado" || $tipo_estado == "Retorno Origen" || $tipo_estado == "Manejo Finalizado" || $tipo_estado == "Resuelto") {
										echo "<p id='res_p' class='mt-3'>Ejecutivo Asignado: <span id='res_span'> $nombre_asignante</span></p>";
									} else {
										echo "<p id='res_p' class='mt-3'>Ejecutivo Solicitado: <span id='res_span'> $nombre_asignante</span></p>";
									}

									?>
								</center>
							</div>


							<ul class="lista-iconos">
								<center>
									<?php
									date_default_timezone_set('America/Mexico_City');
									$fechainicio = date("Y-m-d H:i:s");
									$fecha = base64_encode($fechainicio);

									if ($estatus_logistica == "Resuelto" || $estatus_logistica == "Cancelado") {

										//echo "<li class='iconos-estatus'><i id='estados_icono' class='fa fa-hourglass-start fa-2x' aria-hidden='true' style='color: gray;''></i></li>";
										//echo "<li class='iconos-estatus'><i id='estados_icono' class='fas fa-gavel fa-4x'></i></li>";

									} else {
										//echo "<li class='iconos-estatus'><i id='estados_icono' class='fa fa-hourglass-start fa-2x' aria-hidden='true' style='color: gray;''></i></li>";
										echo "<li class='iconos-estatus'><i id='estados_icono' class='fas fa-gavel fa-4x' style='color: #882439;'></i></li>";
									}

									?>

								</center>
							</ul>

							<div class="col-lg-12">
								<div id="estados" class="bg-white">
									<div class="d-flex justify-content-between mb-4">
										<h3>Estatus</h3>
										<i id="ocultar" class="fa fa-times fa-3x der-cerrar" aria-hidden="true"></i>
									</div>



									<div class="form-group">
										<div class="content-select">
											<select name="EstatusPrincipal" class="form-control" id="EstatusPrincipal" required>
												<option value="">Elige una opción…</option>
												<option value="Resuelto">Resuelto</option>
												<option value="Cancelado">Cancelado</option>
											</select>
											<i></i>
										</div>
									</div>

									<div id="desc_comentarios_logistica" style="display: none;">

										<label for="comentarios_cancelacion">*Comentarios</label>
										<textarea name="comentarios_cancelacion" class="form-control" id="comentarios_cancelacion" rows="3"></textarea>
									</div>
									<br>
									<center>
										<button class="btn btn-lg btn-primary" onclick="GuardarEstatusPrincipal();">Guardar Estatus</button>
									</center>

								</div>
							</div>


							<div class="col-sm-12" style="margin-top: 70px;">
								<div class="tooltipEstatus text-center">Cuentas</div>
							</div>

							<div class='row mt-3'>
								<div class='col-sm-12'>
									<!--Form wizard-->
									<div class='mt-1 mb-3 p-3 button-container bg-white border shadow-sm'>

										<div class='wizard-container'>
											<div class='card wizard-card' data-color='theme' id='wizardProfile'>
												<div class='wizard-navigation'>
													<div class="progress-with-circle">
														<div class='progress-bar' id="progress-bar-circle" role='progressbar' aria-valuenow='<?php echo "$barra"; ?>' aria-valuemin='5' aria-valuemax='95' style="width:<?php echo "$barra"; ?>%">
															<p class="textEstatusPrimero" style="display: none;"><?php echo "$estado"; ?></p>
														</div>
													</div>
													<ul>
														<li>
															<a class="p6">
																<div class='icon-circle'><i class='fa fa-hourglass-start'></i></div>
																<p class="textPorcentage">20%</p>
																<p class="textEstatus">Solicitud</p>
															</a>
														</li>
														<li>
															<a class="p17">
																<div class='icon-circle'><i class='fa fa-check-square-o'></i></div>
																<p class="textPorcentage">25%</p>
																<p class="textEstatus">Enterado</p>
															</a>
														</li>
														<li>
															<a class="p28">
																<div class='icon-circle'><i class='fa fa-road'></i></div>
																<p class="textPorcentage">35%</p>
																<p class="textEstatus">Inicia Recorrido</p>
															</a>
														</li>
														<li>
															<a class="p39">
																<div class='icon-circle'><i class='fa fa-user'></i></div>
																<p class="textPorcentage">50%</p>
																<p class="textEstatus">Sin Disponibilidad</p>
															</a>
														</li>
														<li>
															<a class="p50">
																<div class='icon-circle'><i class='fa fa-map-marker'></i></div>
																<p class="textPorcentage">60%</p>
																<p class="textEstatus">Destino Alcanzado</p>
															</a>
														</li>
														<li>
															<a class="p61">
																<div class='icon-circle'><i class='fa fa-undo'></i></div>
																<p class="textPorcentage">70%</p>
																<p class="textEstatus">Retorno Origen</p>
															</a>
														</li>
														<li>
															<a class="p72">
																<div class='icon-circle'><i class='fa fa-home'></i></div>
																<p class="textPorcentage">80%</p>
																<p class="textEstatus">Manejo Finalizado</p>
															</a>
														</li>
														<li>
															<a class="p83">
																<div class='icon-circle'><i class='fa fa-money'></i></div>
																<p class="textPorcentage">90%</p>
																<p class="textEstatus">Cuentas</p>
															</a>
														</li>
														<li>
															<a class="p94">
																<div class='icon-circle'><i class='fa fa-thumbs-up'></i></div>
																<p class="textPorcentage">100%</p>
																<p class="textEstatus textCambio">Resuelto</p>
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div> <!-- wizard container -->

									</div>
									<!--/Form wizard-->
								</div>
							</div>
							<br>




							<!-- *************** Detalle Logistica****************************** -->
							<div>
								<h3 class="my-4 text-titulos-1">Detalle de Logística</h3>
							</div>

							<div class="container-bg-1 p-3">
								<div class="table-responsive">
									<table class="table table-striped">
										<tbody>

											<tr>
												<td>Fecha de Solicitud</td>
												<td>
													<b>
														<?php
														if ($fecha_solicitud == null) {
															echo $fs = "Sin Fecha";
														} else {
															$frs = date_create($fecha_solicitud);
															echo $fs = date_format($frs, 'd-m-Y H:i:s');
														}
														?>
													</b>
												</td>

												<td>Fecha y Hora Programada</td>
												<td>
													<b>
														<?php
														if ($fecha_programada == null) {
															echo $fp = "Sin Fecha";
														} else {
															$fhp = date_create($fecha_programada);
															echo $fp = date_format($fhp, 'd-m-Y H:i');

															echo ($tipo_estado == "Solicitud" || $tipo_estado == "Enterado") ? "&nbsp;&nbsp; <a href='#' data-toggle='modal' data-target='#modal_fecha_programada'><i class='fa fa-pencil-square-o fa-2x' aria-hidden='true'></i></a>" : "";
														}
														?>
													</b>
												</td>
											</tr>

											<tr>
												<td>Fecha de Salida</td>
												<td>
													<b>
														<?php
														if ($fecha_salida == null) {
															echo $fsalida = "Sin Fecha";
														} else {
															$fsa = date_create($fecha_salida);
															echo $fsalida = date_format($fsa, 'd-m-Y H:i:s');
														}
														?>
													</b>
												</td>
												<td>Fecha llegada Destino</td>
												<td>
													<b>
														<?php
														if ($fecha_llega_destino == null) {
															echo $hes = "Sin Fecha";
														} else {
															$hora_es = date_create($fecha_llega_destino);
															echo $hes = date_format($hora_es, 'd-m-Y H:i:s');
														}
														?>
													</b>
												</td>

											</tr>



											<tr>
												<td>Fecha de Retorno</td>
												<td>
													<b>
														<?php
														if ($fecha_retorno == null) {
															echo $fre = "Sin Fecha";
														} else {
															$fret = date_create($fecha_retorno);
															echo $fre = date_format($fret, 'd-m-Y H:i:s');
														}
														?>
													</b>
												</td>

												<td>Hora Real de Solución</td>
												<td>
													<b>
														<?php
														if ($hora_real_solucion == null) {
															echo $hrs = "Pendiente";
														} else {
															$hora_r = date_create($hora_real_solucion);
															echo $hrs = date_format($hora_r, 'd-m-Y H:i:s');
														}
														?>
													</b>
												</td>
											</tr>

											<?php

											echo "<tr>	
											<td>Tiempo estimado Google Maps</td>
											<td><b>$tiempo_estimado</b></td>
											<td>Kilómetros de Distancia</td>
											<td><b>$kilometros</b></td> 
											</tr>
											";
											?>



											<tr>
												<td colspan="2">Duración Real de Trayecto</td>
												<td colspan="2">
													<b>
														<?php
														if ($hora_real_solucion == null) {
															echo $hrs = "Pendiente";
														} else {
															$f1 = new DateTime($fecha_salida);
															$f2 = new DateTime($hora_real_solucion);
															$interval_fecha = date_diff($f1, $f2);

															if ($interval_fecha->format("%D") >= 1) {
																echo  $interval_fecha->format('%d Día(s)  %H:%i Minutos');
															} else if ($interval_fecha->format("%H") >= "01") {
																echo  $interval_fecha->format('%H:%i Minutos');
																$xd = $interval_fecha->format('%H:%i');
															} else {
																echo  $interval_fecha->format('%H:%i Minutos');
																$xd = $interval_fecha->format('%H:%i');
															}
														}

														?>
													</b>
												</td>

											</tr>


										</tbody>



										<div class="modal fade" id="modal_fecha_programada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Cambiar Fecha / Hora Programada</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<form id="form_programada">
															<?php date_default_timezone_set('America/Mexico_City');
															$fecha_creacion_programada = date("Y-m-d H:i:s"); ?>
															<div class="container">
																<div class="row">
																	<div class='col-sm-12'>
																		<div class="form-group">
																			<label>*Fecha y Hora Programada&nbsp;&nbsp;&nbsp;<span><i id="clean_hora_programada" class="fa fa-trash-o fa-1.5x" aria-hidden="true"></i></span></label>
																			<input type="text" id="fecha_hora_programada" placeholder="0001-01-01 00:00:00" name="fecha_hora_programada" class="form-control" readonly="" required="" />
																		</div>
																	</div>

																	<div class="col-sm-12">
																		<div class="form-group col-sm-12">
																			<label for="comentario_programada">*Detalles del Cambio</label>
																			<textarea class="form-control" rows="3" id="comentario_programada" name="comentario_programada" maxlength="8950" required=""></textarea>
																		</div>
																	</div>



																	<input type="hidden" id="id_logistica_cambio" name="id_logistica_cambio" value='<?php echo "$recibido"; ?>'>
																	<input type="hidden" id="fecha_creacion_programada" name="fecha_creacion_programada" value='<?php echo "$fecha_creacion_programada"; ?>'>
																	<input type="hidden" id="coordenadas_programada" name="coordenadas_programada" value='<?php echo "$coordenadas_programada"; ?>'>


																</div>
															</div>



														</form>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
														<button type="button" class="btn btn-primary" id="enviar_programada">Guardar</button>
													</div>
												</div>
											</div>
										</div>

										</tbody>
									</table>
								</div>
							</div>
							<!-- *************** Domicilio Logistica****************************** -->
							<br>

							<div class="sec-datos">
								<div>
									<h3 class="my-4 text-titulos-1">Domicilio </h3>
								</div>
								<div class="container-bg-1 p-3">
									<div class="table-responsive">

										<table class="table table-striped">
											<tbody>

												<tr>
													<td colspan="2" align="left">
														<h4>Origen</h4>
													</td>
													<td colspan="2" align="left">
														<h4>Destino</h4>
													</td>
												</tr>

												<tr>
													<td>Estado</td>
													<td><b><?php echo $estado_origen; ?></b></td>
													<td>Estado</td>
													<td><b><?php echo $estado_destino; ?></b></td>
												</tr>

												<tr>
													<td>Municipio</td>
													<td><b><?php echo $municipio_origen; ?></b></td>
													<td>Municipio</td>
													<td><b><?php echo $municipio_destino; ?></b></td>
												</tr>

												<tr>
													<td>Colonia</td>
													<td><b><?php echo ($colonia_origen != "undefined") ? $colonia_origen : "S/N Colonia"; ?> </b>
													</td>
													<td>Colonia</td>
													<td><b><?php echo ($colonia_destino != "undefined") ? $colonia_destino : "S/N Colonia"; ?></b>
													</td>
												</tr>

												<tr>
													<td>Calle</td>
													<td><b><?php echo $calle_origen; ?></b></td>
													<td>Calle</td>
													<td><b><?php echo $calle_destino; ?></b></td>
												</tr>

												<tr>
													<td>Código Postal</td>
													<td><b> <?php echo ($cp_origen != "undefined") ? $cp_origen : "S/N CP"; ?> </b>
													</td>
													<td>Código Postal</td>
													<td><b><?php echo ($cp_destino != "undefined") ? $cp_destino : "S/N CP"; ?>
														</b>
													</td>
												</tr>

												<tr>
													<td>Coordenadas</td>

													<td><b><?php echo $coordenadas_origen; ?></b>&nbsp;&nbsp;</i></td>
													<td>Coordenadas</td>
													<td><b><?php echo $ubicacion_destino; ?></b>&nbsp;&nbsp;</i></td>
												</tr>

												<tr>
													<td>Como Llegar</td>
													<td colspan="3"><?php echo "<a href='https://maps.google.com/?q=$ubicacion_destino' target='_blank'><i class='fa fa-map-marker fa-3x' aria-hidden='true' style='color: red'></i></a>"; ?></td>
												</tr>

											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- *************** ID Logistica****************************** -->
							<br>
							<div class="sec-datos">
								<div>
									<h3 class="text-titulos-1 my-4 d-flex align-items-center flex-wrap">Datos del ID&nbsp;&nbsp;
										<?php
										if ($id_client == "0" || $id_client == "") {

											echo "<span><a href='#' data-toggle='modal' data-target='#agregar_cliente' class='container-iconos-1'><i class='fa fa-user-plus' aria-hidden='true'></i></a></span>";
										} else {
											echo "<span><a href='#' data-toggle='modal' data-target='#agregar_cliente' class='container-iconos-1'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a></span>";
										}


										?>
									</h3>
								</div>

								<div class="modal fade" id="agregar_cliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Agregar ID</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<form id="formagregar" method="POST" action="guardar_agregar_id.php">
													<?php date_default_timezone_set('America/Mexico_City');
													$fecha_creacion_id = date("Y-m-d H:i:s"); ?>
													<div class="col-sm-12">

														<div class="col-sm-12">
															<div class="form-group">
																<h3 class="m-t-none m-b">Datos del ID</h3><br>
															</div>
														</div>

													</div>



													<div class="col-sm-12">
														<div class="form-group">
															<label for="busqueda_id">Buscar ID</label>
															<input placeholder="Buscar" class="form-control" type="text" name="busqueda_id" id="busqueda_id" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_cliente();" size="19" width="300%" />
															<center>
																<div id="resultadoBusquedaId" class="container-busquedas-1 mt-4 efecto-busqueda" style="display: none;"></div>
															</center>
														</div>
													</div>

													<div class="col-sm-12 form-group" id="show_add_id" style="display: none;">
														<div class="alert alert-info" role="alert">
															A continuación se habilitara el formulario para que agregue <b>ID</b> de forma temporal.
														</div>
													</div>


													<div class="col-sm-12">
														<div class="form-group row">

															<div class="col-sm-4">
																<label>*ID</label>
																<input class="form-control" type="text" name="idcliente" id="idcliente" required="" readonly="" />
															</div>

															<div class="col-sm-4">
																<label>*Nombre</label>
																<input class="form-control" type="text" name="nombre" id="nombre" required="" readonly="" />
															</div>

															<div class="col-sm-4">
																<label>*Apellidos</label>
																<input class="form-control" type="text" name="apellidos" id="apellidos" required="" readonly="" />
															</div>

															<div class="col-sm-4">
																<label>*Alias</label>
																<input class="form-control" type="text" name="alias" id="alias" readonly="" />
															</div>

															<div class="col-sm-4">
																<label>*Telefono Celular</label>
																<input class="form-control" type="text" name="celular" id="celular" readonly="" />
															</div>

															<div class="col-sm-4">
																<label>*Telefono Fijo</label>
																<input class="form-control" type="text" name="fijo" id="fijo" readonly="" />
															</div>

															<div class="col-sm-4">
																<label>*Estado</label>
																<input class="form-control" type="text" name="estado" id="estado" readonly="" />
															</div>

															<div class="col-sm-4">
																<label>*Municipio</label>
																<input class="form-control" type="text" name="municipio" id="municipio" readonly="" />
															</div>

															<div class="col-sm-4">
																<label>*Colonia</label>
																<input class="form-control" type="text" name="colonia" id="colonia" readonly="" />
															</div>

															<div class="col-sm-4">
																<label>*Calle y Número</label>
																<input class="form-control" type="text" name="calle" id="calle" readonly="" />
															</div>

															<div class="col-sm-4">
																<label>*Código Postal</label>
																<input class="form-control" type="text" name="codigo_postal_cliente" id="codigo_postal_cliente" readonly="" />
															</div>


															<div class="col-sm-4">
																<label>*Tipo Contacto</label>
																<input class="form-control" type="text" name="tipo_contacto_id" id="tipo_contacto_id" readonly="" />
															</div>

														</div>
													</div>

													<div id="create_button" style="display: none;">

														<div class="form-group delete_buton">
															<div class="col-lg-12">
																<br>
																<center>
																	<input type="button" class="btn btn-lg btn-primary" value="Agregar Nuevo ID" onclick="guardar_temporal();">
																</center>
																<br>
															</div>
														</div>

													</div>


													<input type="hidden" id="id_logistica_id" name="id_logistica_id" value='<?php echo "$recibido"; ?>'>
													<input type="hidden" class="coordenadas" name="coordenadas_id">
													<input type="hidden" id="nomenclatura_no_hay_trasladista" name="nomenclatura_no_hay_trasladista" value='<?php echo "$nomenclatura_no_hay_trasladista"; ?>'>
													<input type="hidden" id="fecha_creacion_id" name="fecha_creacion_id" value='<?php echo "$fecha_creacion_id"; ?>'>
													<input type="hidden" id="id_anterior" name="id_anterior" value="<?php echo $idcontacto . "|" . $tipo_contacto; ?>">

													<center>
														<input type="submit" class="btn btn-primary submitBtn" id="guardar_id_temporal" style="display: none;" value="Agregar">
													</center>

												</form>
											</div>
											<center>
												<div class="modal-footer">

													<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
												</div>
											</center>
										</div>
									</div>
								</div>

								<div class="container-bg-1 p-3">
									<div class="table-responsive">
										<table class="table table-striped">
											<tbody>

												<tr>
													<td>Nombre</td>
													<td><b><?php echo $nombre; ?></b></td>
													<td>Apellidos</td>
													<td><b><?php echo $apellidos; ?></b></td>
												</tr>
												<tr>
													<td>ID</td>
													<td><b><?php echo $id_client; ?></b></td>
													<td>Alias</td>
													<td><b><?php echo $alias; ?></b></td>
												</tr>
												<tr>
													<td>Celular <?php
																if ($telefono != "") {
																	echo "<a title='Llamar' href='tel:+52$telefono'><i class='fa fa-mobile fa-2x' aria-hidden='true'></i></a>";
																}
																?></td>
													<td><b><?php if ($telefono != "") {
																echo $telefono;
															} else {
																echo "S/N";
															} ?></b></td>

													<td>Télefono Fijo <?php
																		if ($telefono_otro != "") {
																			echo "<a title='Llamar' href='tel:+52$telefono_otro'><i class='fa fa-mobile fa-2x' aria-hidden='true'></i></a>";
																		}
																		?></td>
													<td><b><?php if ($telefono_otro != "") {
																echo $telefono_otro;
															} else {
																echo "S/N";
															} ?></b></td>

												</tr>
												<tr>
													<td>Estado</td>
													<td><b><?php echo $estado_cliente; ?></b></td>
													<td>Municipio</td>
													<td><b><?php echo $municipio_cliente; ?></b></td>
												<tr>

												</tr>
												<td>Colonia</td>
												<td><b><?php
														if ($colonia_cliente == 0) {
															echo "S/N Colonia";
														} else {
															echo $colonia_cliente;
														}
														?></b></td>
												<td>Calle y Número</td>
												<td><b><?php
														if ($calle_cliente == "") {
															echo "S/N Calle";
														} else {
															echo $calle_cliente;
														}
														?></b></td>
												</tr>
												<tr>
													<td colspan="2">Tipo ID:</td>
													<td colspan="2"><?php echo $tipo_id_contacto; ?> </td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- *************** Solicitud Logistica****************************** -->

							<br>

							<div class="sec-datos">
								<div>
									<h3 class="text-titulos-1 my-4">Detalle de Solicitud</h3>
								</div>

								<div class="container-bg-1 p-3">
									<div class="table-responsive">
										<table class="table table-striped">
											<tr>
												<td>Solicitante</td>
												<td align="left"><b><?php echo $nombre_solicitante; ?></b></td>
											</tr>
											<tr>
												<td>Fuente Informante</td>
												<td align="left"><b><?php echo $nombre_fuente_inf; ?></b></td>

											</tr>
											<tr>
												<td>Trasladista</td>
												<td align="left">
													<b>
														<?php
														echo ($estatus_logistica == "Resuelto" || $estatus_logistica == "Cancelado") ? $nombre_asignante : $nombre_asignante . "&nbsp;&nbsp;<i class='fas fa-user-plus fa-2x' onclick=\"AddTrasladistaPrincipal('$nombre_asignante');\"></i>";
														?>
													</b>
												</td>

											</tr>
										</table>
									</div>
								</div>
							</div>




							<!-- Modal Logistica-->
							<div class="modal fade" id="modal_logistica" tabindex="-1" aria-labelledby="examplelogisticatitle" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="examplelogisticatitle"></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body" id="add_logistica_modal">


										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
										</div>
									</div>
								</div>
							</div>



							<!-- *************** Actividad Logistica****************************** -->
							<div class="col-sm-12" style="display: none;" id="desc_trae_orden">
								<br>
								<div class="sec-datos">
									<br>
									<div class="alert alert-info" role="alert">
										<?php
										$query_orden = "SELECT * FROM atencion_clientes where idatencion_clientes = '$presupuesto'";
										$result_orden = mysql_query($query_orden);

										while ($row_orden = mysql_fetch_array($result_orden)) {
											$comentarios_orden = $row_orden[comentarios];
										}

										echo "La orden número <b>$presupuesto</b> contiene lo siguiente: <br>" . $comentarios_orden;
										?>
									</div>
								</div>
							</div>

							<!---------------------------->
							<br>
							<div class="sec-datos">
								<div>
									<h3 class="text-titulos-1 my-4">Comentario de Actividad</h3>
								</div>
								<div class="container-bg-1 p-3">
									<div class="table-responsive">
										<table class="table table-striped mb-0">
											<tbody>
												<tr>
													<td><b><?php echo $comentario_general; ?></b></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<?php

							$query_comentarios = "SELECT * FROM orden_logistica_bitacora WHERE idorden_logistica = '$idc' and visible = 'SI' and tipo = 'Manejo Finalizado'";
							$result_comentarios = mysql_query($query_comentarios);

							if (mysql_num_rows($result_comentarios) >= 1) {
								echo "<div>
								<h3 class='text-titulos-1 my-4'>Comentario Ejecutivos</h3>
								</div>
								<div class='container-bg-1 p-3'>
								<div class='table-responsive'>
								<table class='table table-striped mb-0'>
								<tbody>";

								while ($row_comemtarios = mysql_fetch_array($result_comentarios)) {

									$query_user_comentario = "SELECT * FROM usuarios WHERE idusuario = '$row_comemtarios[usuario_creador]' ";
									$result_user_comentario = mysql_query($query_user_comentario);

									while ($row_user_comentario = mysql_fetch_array($result_user_comentario)) {

										$usuario_responsable_comentario = explode("|", nombres_datos($row_user_comentario[idempleados], "Colaborador"));


										echo "<tr>
										<td><b>$row_comemtarios[comentarios]</b></td>
										<td><b>$usuario_responsable_comentario[10]($usuario_responsable_comentario[2])</b></td>
										</tr>";
									}
								}

								echo "</tbody>
								</table>
								</div>
								</div>";
							}

							if ($estado == 'Cancelado') {

								echo "	<div>
								<h1 class='text-titulos-1 my-4'>Comentario Cancelación</h1>
								</div>
								<div class='container-bg-1 p-3'>
								<div class='table-responsive'>
								<table class='table table-striped mb-0'>
								<tbody>
								<tr>
								<td><b>$comentarios_cancelacion</b></td>                             
								</tr>                                      
								</tbody>
								</table>
								</div>
								</div>'";
							}

							?>

							<div class="col-sm-12">
								<div id="succes_ayudante" style="display: none;">
									<div class="alert alert-success" role="alert">
										Se ha guardado Correctamente

									</div>
								</div>
							</div>

							<div class="col-sm-12">
								<div id="fail_ayudante" style="display: none;">
									<div class="alert alert-danger" role="alert">
										Se ha Producido un error
									</div>
								</div>
							</div>

							<!-- *************** Autorizaciones Logistica****************************** -->
							<div class="sec-datos">

								<div>
									<h3 class="text-titulos-1 my-4">Autorizaciones Logística</h3>
								</div>

							</div>
							<div class="container-bg-1 p-3">
								<div class="table-responsive">
									<table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="table_autorizaciones">
										<thead>
											<tr>
												<th># </th>
												<th>Autoriza</th>
												<th>Responsable</th>
												<th>Comentarios</th>
												<th>Tipo</th>
												<th>Evidencia</th>
											</tr>
										</thead>
										<tbody>

											<?php

											$aut_increment = 0;
											$query_autorizaciones = "SELECT * FROM orden_logistica_autorizaciones WHERE visible = 'SI' AND idorden_logistica = '$idc'";
											$result_autorizaciones = mysql_query($query_autorizaciones);

											while ($row_autorizaciones = mysql_fetch_array($result_autorizaciones)) {
												$aut_increment++;


												$name_datos_autorizacion = nombres_datos($row_autorizaciones[idcolaborador], $row_autorizaciones[tipo_colaborador]);
												$porciones_autorizacion = explode("|", $name_datos_autorizacion);

												$query_create_aut = "SELECT * FROM usuarios WHERE idusuario = '$row_autorizaciones[usuario_creador]'";
												$result_create_aut = mysql_query($query_create_aut);

												while ($row_user_aut = mysql_fetch_array($result_create_aut)) {
													$name_usser_autorization = nombres_datos($row_user_aut[idempleados], "Colaborador");
													$porciones_usser_aut = explode("|", $name_usser_autorization);
												}



												if (file_exists($row_autorizaciones[evidencia])) {

													$evidencia_autorizacion = "<td><a href='$row_autorizaciones[evidencia]' target='_blank'><i class='far fa-image fa-2x'></i></a></td>";
												} else {
													$evidencia_autorizacion = "<td>N/A</td>";
												}

												echo "<tr class='odd gradeX'>
												<td>$aut_increment</td>
												<td>$porciones_autorizacion[2]</td>
												<td>$porciones_usser_aut[2]</td>					
												<td>$row_autorizaciones[comentarios]</td>					
												<td>$row_autorizaciones[tipo]</td>					
												$evidencia_autorizacion     
												</tr>";

												$cadena .= $nomenclatura_ayudante_empleado . "*";
												date_default_timezone_set('America/Mexico_City');
												$fecha_creacion_ayudante_baja = date('Y-m-d H:i:s');



												$nomenclatura_ayudante_empleado = "";
											}
											?>

										</tbody>
									</table>
								</div>
							</div>
							<!-- *************** Ayudantes Logistica****************************** -->
							<br>

							<div class="sec-datos">
								<div>
									<h3 class="text-titulos-1 my-4 d-flex align-items-center flex-wrap">Acompañantes&nbsp;&nbsp;
										<?php
										if ($estado != "Cancelado" || $estado != "Resuelto") {
											echo "<a data-toggle= 'collapse' href='#collapseExample5' role='button'	aria-expanded='false' aria-controls='collapseExample5' class='container-iconos-1'><i class='fa fa-plus'></i></a>";
										}

										?>
									</h3>
								</div>

								<div class="collapse" id="collapseExample5">
									<div class="container-bg-1 p-3 mb-4">
										<div class="card card-body">
											<form name="ayudante" action="guardar_ayudante.php" onsubmit="return validar_ayudante();" method="POST">
												<?php
												date_default_timezone_set('America/Mexico_City');
												$fecha_creacion_ayudantes1 = date("Y-m-d H:i:s"); ?>

												<div class="col-sm-12">
													<center>
														<a id='create_ayudante' style='width: 180px;height: 90px;' class="create_ayudante icon-DOrden" class="" title="Add field"><i class='fa fa-plus-circle fa-5x zoom font-iconr' aria-hidden='true'></i></a>
														<div class="tooltipDetalleOrden mb-3">
															<p>Agregar Acompañante</p>
														</div>
													</center>

												</div>


												<div class="col-sm-12 field_wrapper_ayudante" id="show_ayudante_adicional">

												</div>

												<input id="aux_ayudante" type="hidden" value="0" readonly>
												<input id="count_ayudante" type="hidden" value="0" readonly>

												<input type="hidden" name="id_logistica_ayudantes" value="<?php echo $recibido ?>" required="">
												<input type="hidden" name="fecha_creacion_ayudantes1" value="<?php echo $fecha_creacion_ayudantes1 ?>" required="">
												<input type="hidden" name="coordenadas_ayudante" class="coordenadas">

												<script type="text/javascript">
													$(document).ready(function() {


														var addButtonAyudante = $('#create_ayudante');
														var wrapper_ayudante = $('.field_wrapper_ayudante');

														$(addButtonAyudante).click(function() {

															var obtener_count_ayudante = $("#count_ayudante").val();

															var add_coun_ayudante = parseInt(obtener_count_ayudante, 10) + 1;
															$("#count_ayudante").val(add_coun_ayudante);

															var obtener_aux_ayudante = $("#aux_ayudante").val();

															if (obtener_aux_ayudante == 0) {

																var contador_ayudante = 1;

															} else {

																if ($.isNumeric(obtener_aux_ayudante) == true) {

																	var contador_ayudante = parseInt(obtener_aux_ayudante, 10) + 1;

																} else {

																	var cortar = obtener_aux_ayudante.substr(0, 1);

																	var contador_ayudante = parseInt(obtener_aux_ayudante, 10) + 1;

																}
															}



															$("#aux_ayudante").val(contador_ayudante);

															var fieldHTMLAyudante = `
															<div class="row mt-4 mb-4 container-title-line">
																						
															<div class="col-sm-12">
															<h3 class="m-t-none m-b"><strong>Agregar Acompañante ${contador_ayudante}</strong></h3>
															</div>
																						
															<div class="col-sm-12">
															<label>Buscar Acompañante</label>
															<input placeholder="Buscar Acompañante" class="form-control" type="text" name="busqueda_ayudante[]" id="busqueda_ayudante${contador_ayudante}" value="" autocomplete="off" onkeyup="verificarayudante(${contador_ayudante});" size="19" width="300%" />
															<center>
															<div id="resultadoBusquedaAyudante${contador_ayudante}" class="container-busquedas-1 mt-4 efecto-busqueda" style="display: none;"></div>
															</center>
															</div>
																						
															<div class="col-sm-12">
															<label>ID</label>
															<input type="text" id="id_ayudante${contador_ayudante}"  class="form-control" name="id_ayudante[]" readonly="">
															</div>
																						
															<div class="col-sm-12">
															<label>Tipo</label>
															<input type="text" id="tipo_ayudante${contador_ayudante}" class="form-control" name="tipo_ayudante[]" readonly="">
															</div>
																						
															<div class="col-sm-12">
															<label for="comentario_ayudante${contador_ayudante}">Detalle de Actividad</label>
															<textarea class="form-control" id="comentario_ayudante${contador_ayudante}" name="comentario_ayudante[]" rows="3" required""></textarea>
															</div>
																						
																						
															<a class="button-eliminar remove_buttonAyudante mt-4 mb-4">
															<span>Eliminar</span><i class="fas fa-trash"></i>
															</a>
																						
															</div>`;



															$(wrapper_ayudante).append(fieldHTMLAyudante);





														});


														$(wrapper_ayudante).on('click', '.remove_buttonAyudante', function(e) {
															e.preventDefault();
															$(this).parent('div').remove();

															var obtener_aux_ayudantesin_tocar = $("#aux_ayudante").val();
															$("#aux_ayudante").val(obtener_aux_ayudantesin_tocar + "|");

															var disminuir_count_ayudante = $("#count_ayudante").val();
															var nuevo_contador_ayudante = parseInt(disminuir_count_ayudante, 10) - 1;
															$("#count_ayudante").val(nuevo_contador_ayudante);

															if (nuevo_contador_ayudante == 0) {
																$("#aux_ayudante").val("0");
															}


														});

														$('#departamento').on('change', function() {

															var form_data_valor = $("#departamento").val()

															$.ajax({
																type: "POST",
																url: "buscar_departamento_logistica.php",
																data: {
																	id_d: form_data_valor
																},
																success: function(response) {

																	$('#tipo_orden').html(response);
																}
															});

														});



													});

													function verificarayudante(contador_nuevo_ayudante) {


														var ayudante_nomenclatura = $("#busqueda_ayudante" + contador_nuevo_ayudante).val();

														$.post("buscar_ayudante_generar_logistica.php", {
															valorBusqueda: ayudante_nomenclatura,
															contador_nuevo_ayudante: contador_nuevo_ayudante
														}, function(mensaje_ayudante2) {

															$("#resultadoBusquedaAyudante" + contador_nuevo_ayudante).html(mensaje_ayudante2);
															$("#resultadoBusquedaAyudante" + contador_nuevo_ayudante).show();


														});


														$(document).on('click', '.sugerencias_asesor' + contador_nuevo_ayudante, function(event_adicional) {
															event_adicional.preventDefault();
															aux_recibido_adicional = $(this).val();
															var porcion_adicional = aux_recibido_adicional.split(';');

															unidad_id_ayudante_adicional = porcion_adicional[0];
															unidad_nomenclatura_ayudante_adicional = porcion_adicional[1];
															unidad_tipo_ayudante_adicional = porcion_adicional[2];

															$("#busqueda_ayudante" + contador_nuevo_ayudante).val(unidad_nomenclatura_ayudante_adicional);
															$("#id_ayudante" + contador_nuevo_ayudante).val(unidad_id_ayudante_adicional);
															$("#tipo_ayudante" + contador_nuevo_ayudante).val(unidad_tipo_ayudante_adicional);
															$("#resultadoBusquedaAyudante" + contador_nuevo_ayudante).html("");
															$("#resultadoBusquedaAyudante" + contador_nuevo_ayudante).hide();

														});


													}
												</script>
												<center>
													<button class="btn btn-lg btn-primary mt-4">Guardar</button>
												</center>
											</form>
											<hr>
										</div>
									</div>
								</div>
							</div>

							<div class="container-bg-1 p-3">
								<div class="table-responsive">
									<table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="tableayudantes">
										<thead>
											<tr>
												<th># </th>
												<th>Responsable</th>
												<th>Comentarios</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody>

											<?php
											$ayudante = 1;
											$nomenclatura_ayudante_empleado = "";

											$query_ayudante = "SELECT * FROM orden_logistica_ayudante WHERE idorden_logistica = '$idc' and visible = 'SI'";
											$result_ayudante = mysql_query($query_ayudante);

											while ($row_ayudante = mysql_fetch_array($result_ayudante)) {
												$ayudante++;
												$comentarios_ayudante = "$row_ayudante[comentarios]";

												$nombres_ayudantes = nombres_datos($row_ayudante[id_colaborador_proveedor], $row_ayudante[tipo]);
												$porciones_ayudantes = explode("|", $nombres_ayudantes);

												$nombre_ayudante_table = ($porciones_ayudantes[11] == "Colaborador") ? $porciones_ayudantes[2] : "$porciones_ayudantes[0] $porciones_ayudantes[1]";

												if ($porciones_ayudantes != "Pendiente" and $row_ayudante[id_colaborador_proveedor] != "" and $row_ayudante[tipo] != "") {
													array_push($array_responsable_balance, "$row_ayudante[id_colaborador_proveedor]|$row_ayudante[tipo]|$nombre_ayudante_table");
												}

												$id_ayudante_encript = base64_encode($row_ayudante[id_colaborador_proveedor]);
												$tipo_ayudante_encript = base64_encode($row_ayudante[tipo]);
												$idorden_logistica_ayudante_encript = base64_encode($row_ayudante[idorden_logistica_ayudante]);

												if ($acciones_estatus != "Resuelto") {

													$ayudante_nombre = "<td><a href='quitar_ayudante.php?id_ayudante_baja=$id_ayudante_encript&tipo_ayudante_baja=$tipo_ayudante_encript&idorden_logistica_ayudante=$recibido&numberid=$idorden_logistica_ayudante_encript'><i class='fa fa-trash fa-2x'></i></a></td>";
												} else {
													$ayudante_nombre = "<td>$nombre_ayudante_table</td>";
												}

												echo "<tr class='odd gradeX'>
												<td>$ayudante</td>
												<td>$nombre_ayudante_table</td>
												<td>$comentarios_ayudante</td>						
												$ayudante_nombre     
												</tr>";

												$cadena .= $nomenclatura_ayudante_empleado . "*";
												date_default_timezone_set('America/Mexico_City');
												$fecha_creacion_ayudante_baja = date('Y-m-d H:i:s');



												$nomenclatura_ayudante_empleado = "";
											}
											?>

										</tbody>
									</table>
								</div>
							</div>
							<input type="hidden" id="ayuda_trasladista" name="ayuda_trasladista" value="<?php echo $cadena; ?>">

							<!-- *************** Unidades Logistica****************************** -->

							<br>
							<div class="sec-datos">
								<div>
									<h3 class="text-titulos-1 my-4 d-flex align-items-center flex-wrap">Unidades Logística&nbsp;&nbsp;
										<?php
										if ($estado != "Cancelado" || $estado != "Resuelto") {
											echo "<a data-toggle= 'collapse' href='#collapseExample1' role='button'	aria-expanded='false' aria-controls='collapseExample1' class='container-iconos-1'><i class='fa fa-plus'></i></a>";
										}

										?>
									</h3>
								</div>

								<div class="collapse" id="collapseExample1">
									<div class="container-bg-1 p-3 mb-4">
										<div class="card card-body">
											<form name="herramienta_trabajo" action="guardar_unidades_herramienta.php" method="POST" onsubmit="return validar_unidades_logistica();" enctype="multipart/form-data">
												<?php
												date_default_timezone_set('America/Mexico_City');
												$fecha_creacion_herramienta_trabajo = date("Y-m-d H:i:s"); ?>





												<div class="col-sm-12 field_wrapper_vin" id="show_vin_adicional">

												</div>

												<div class="col-sm-12 mt-4">
													<center>
														<a id='create_vin' style='width: 180px;height: 90px;' class="create_vin icon-DOrden" class="" title="Add field"><i class='fa fa-plus-circle fa-5x zoom font-iconr' aria-hidden='true'></i></a>
														<div class="tooltipDetalleOrden mb-3">
															<p>Agregar VIN</p>
														</div>
													</center>
												</div>

												<input id="aux_vin" type="hidden" value="0" readonly>
												<input id="count_vin" type="hidden" value="0" readonly>
												<input id="count_principal_vin" type="hidden" value="0" readonly>


												<input type="hidden" name="idorden_logisticaht" value="<?php echo $recibido; ?>">
												<input type="hidden" name="fecha_creacion_herramienta_trabajo" id="fecha_creacion_herramienta_trabajo" value="<?php echo $fecha_creacion_herramienta_trabajo; ?>">
												<input type="hidden" name="coordenadas_vin" class="coordenadas">

												<input type="hidden" name="id_responsable_vin_logistica" id="id_responsable_vin_logistica" value="<?php echo $idasigna; ?>">
												<input type="hidden" name="tipo_responsable_vin_logistica" id="tipo_responsable_vin_logistica" value="<?php echo $tipo_asignante; ?>">


												<script type="text/javascript">
													$(document).ready(function() {


														var addButtonVIN = $('.create_vin');
														var wrapper_vin = $('.field_wrapper_vin');

														$(addButtonVIN).click(function() {


															var obtener_count_vin = $("#count_vin").val();


															var add_coun_vin = parseInt(obtener_count_vin, 10) + 1;
															$("#count_vin").val(add_coun_vin);



															var obtener_aux_vin = $("#aux_vin").val();

															if (obtener_aux_vin == 0) {

																var contador_vin = 1;

															} else {

																if ($.isNumeric(obtener_aux_vin) == true) {

																	var contador_vin = parseInt(obtener_aux_vin, 10) + 1;

																} else {

																	var cortar = obtener_aux_vin.substr(0, 1);

																	var contador_vin = parseInt(obtener_aux_vin, 10) + 1;

																}
															}






															$("#aux_vin").val(contador_vin);

															var fieldHTMLVIN = `
															<div class="row mt-4 mb-4 container-title-line">
																						
															<div class="col-sm-12">
															<div class="form-group">
															<h3 class="m-t-none m-b"><strong>Agregar Unidad</strong></h3>
															</div>
															</div>
																						
															<div class="col-sm-12">
															<label>Rol del VIN ${contador_vin}</label>
															<div class='content-select'>
															<select name="rol_vin[]" id="rol_vin${contador_vin}" class="form-control stilo_border" required="" onchange="changeRolAdicionalVIN(${contador_vin})">
															<option value="">Seleccionar Rol ...</option>
															<?php
															$query_rol_vin = "SELECT * FROM orden_logistica_rol_vin WHERE visible = 'SI' ";
															$result_rol_vin = mysql_query($query_rol_vin);

															while ($row_rol_vin = mysql_fetch_array($result_rol_vin)) {

																echo "<option value='$row_rol_vin[nombre]'>$row_rol_vin[nombre]</option>";
															}

															?>

															</select>
																						
															</div>
															</div>
																						
															<div class="col-sm-12 row" id="vin_autorizacion_entrega${contador_vin}" style="display: none;">
																						
															<div class="col-sm-12">
															<label>*¿Quién autoriza?</label>   
															<div class="content-select">
															<select class="form-control borrar_vin" id="idem_au_vin${contador_vin}" name="idcolaboradorautoriza[]">
															<option value="">Elige una opción…</option>
															<option value="118">EDFM</option>
															<option value="116">JFR</option>
															<option value="88">JAH</option>
															<option value="55">AAGH</option>
															</select>
															</div>            
															</div>
																						
															<div class="col-sm-12">
															<label>*Comentarios</label>
															<textarea class="form-control borrar_vin" id="comentarios${contador_vin}" name="comentarios_autorizacion[]" rows="3"></textarea>
															</div>
																						
															<div class="col-sm-12">
															<label>Cargar Archivo</label>
															<input type="file" class="form-control-file borrar_vin" name="archivoautorizacion[]" id="evidencia_archivo_vin${contador_vin}" onchange="change_file_vin_adicional(${contador_vin})">
															</div>
																						
																						
															</div>
																						
															<div id="show_rol_vin_adicional${contador_vin}" style="display: none;" class="col-sm-12">
																						
															<div class="row">
															<div class="col-sm-12">
															<label>Buscar VIN</label>
															<input placeholder="Buscar VIN" class="form-control vin_adicional borrar_vin" type="text" name="busqueda_herramienta[]" id="busqueda_herramienta_adicional${contador_vin}" autocomplete="off" 								onkeyup="verificarVIN(${contador_vin});" size="19" width="300%"  >
																						
															<center>
															<div id="resultadoBusquedaherramienta_adicional${contador_vin}" class="mt-4" style="display: none;">
															</div>
															</center>
															</div>
																						
																						
															<div class="col-sm-6">
															<label>VIN</label>
															<input type="text" id="soy_vin${contador_vin}" name="soy_vin[]" class="form-control borrar_vin" readonly minlength="8" maxlength="8" onKeyUp="mayus(this);">
															</div>
																						
															<div class="col-sm-6">
															<label>Marca</label>
															<input type="text" id="marca_vin${contador_vin}" name="soy_marca[]" class="form-control borrar_vin" readonly onKeyUp="mayus(this);">
															</div>
																						
															<div class="col-sm-6">
															<label>Version</label>
															<input type="text" id="version_vin${contador_vin}" name="soy_version[]" class="form-control borrar_vin" readonly list="search_version${contador_vin}"  onKeyUp="mayus(this);" />
															</div>
																						
															<div class="col-sm-6">
															<label>Color</label>
															<input type="text" id="color_vin${contador_vin}" name="soy_color[]" class="form-control borrar_vin" readonly list="search_color${contador_vin}"  onKeyUp="mayus(this);" />
															</div>
																						
															<div class="col-sm-6">
															<label>Modelo</label>
															<input type="number" id="modelo_vin${contador_vin}" name="soy_modelo[]" class="form-control borrar_vin" readonly min="1900" max="2050">
															</div>
																						
															<div class="col-sm-6"><label>Tipo Unidad</label>
															<input type="text" id="tipo_vin${contador_vin}" name="tipo_vin[]" class="form-control borrar_vin" readonly >
															</div> 
																						
																						
																						
															</div>      
															</div>  
																						
															<div class="col-sm-12">
															<label >Persona Asignada de la unidad</label>
															<div class="content-select">
															<select class="form-control" name="idpersona_asignada_ht[]" id="idpersona_asignada_ht${contador_vin}"  required="">
															<?php
															echo "<option value='$idasigna;$tipo_asignante'>$nombre_asignante</option>";

															$herramienta_trabajo = "SELECT * FROM orden_logistica_ayudante where idorden_logistica = '$idc' and visible = 'SI'";
															$result_herramienta_trabajo = mysql_query($herramienta_trabajo);


															if (mysql_num_rows($result_herramienta_trabajo) >= 1) {

																while ($row_query_herramienta = mysql_fetch_array($result_herramienta_trabajo)) {

																	$ver_id_tipo_ht = trim($row_query_herramienta[id_colaborador_proveedor]);
																	$ver_tipo_ht = trim($row_query_herramienta[tipo]);

																	$nombres_ayudantes_vin = nombres_datos($ver_id_tipo_ht, $ver_tipo_ht);
																	$porciones_ayudantes_vin = explode("|", $nombres_ayudantes_vin);

																	$nombre_ayudante_unidad = ($porciones_ayudantes_vin[11] == "Colaborador") ? $porciones_ayudantes_vin[2] : "$porciones_ayudantes_vin[0] $porciones_ayudantes_vin[1]";




																	echo "<option value='$ver_id_tipo_ht;$ver_tipo_ht'>$nombre_ayudante_unidad</option>";
																}
															} else {
																echo "<option value='$idasigna;$tipo_asignante'>$nombre_asignante</option>";
															}
															?>
															</select>
															<i></i>
															</div>
														
															</div>    
														
															<a class="button-eliminar remove_button mt-4 mb-4">
															<span>Eliminar</span><i class="fas fa-trash"></i>
															</a>
														
														
															</div>
															`;


															$(wrapper_vin).append(fieldHTMLVIN);

														});


														$(wrapper_vin).on('click', '.remove_button', function(e) {
															e.preventDefault();
															$(this).parent('div').remove();

															var obtener_aux_vinsin_tocar = $("#aux_vin").val();
															$("#aux_vin").val(obtener_aux_vinsin_tocar + "|");

															var disminuir_count_vin = $("#count_vin").val();
															var nuevo_contador_vin = parseInt(disminuir_count_vin, 10) - 1;
															$("#count_vin").val(nuevo_contador_vin);

															if (nuevo_contador_vin == 0) {
																$("#aux_vin").val("0");
															}


														});


													});





													function changeRolAdicionalVIN(valorVIN) {


														var ver_rol_unidad_adicional = $("#rol_vin" + valorVIN).val();

														if (ver_rol_unidad_adicional == "") {
															console.log("Rol del VIN Vacio " + ver_rol_unidad_adicional + " " + valorVIN);
															$("#show_rol_vin_adicional" + valorVIN).hide();
															$("#busqueda_herramienta_adicional" + valorVIN).val("");
															$("#soy_vin" + valorVIN).val("");
															$("#marca_vin" + valorVIN).val("");
															$("#version_vin" + valorVIN).val("");
															$("#color_vin" + valorVIN).val("");
															$("#modelo_vin" + valorVIN).val("");
															$("#tipo_vin" + valorVIN).val("");
															$("#responsable_unidad" + valorVIN).val("");
															$("#vin_autorizacion_entrega" + valorVIN).hide();


														} else {
															console.log("Rol del VIN Vacio " + ver_rol_unidad_adicional + " " + valorVIN);
															$("#show_rol_vin_adicional" + valorVIN).show();
															$("#vin_autorizacion_entrega" + valorVIN).hide();
															$("#busqueda_herramienta_adicional" + valorVIN).val("");
															$("#soy_vin" + valorVIN).val("");
															$("#marca_vin" + valorVIN).val("");
															$("#version_vin" + valorVIN).val("");
															$("#color_vin" + valorVIN).val("");
															$("#modelo_vin" + valorVIN).val("");
															$("#tipo_vin" + valorVIN).val("");
															$("#responsable_unidad" + valorVIN).val("");
														}


													}




													function verificarVIN(contador_nuevo_vin) {


														var vin_nomenclatura = $("#busqueda_herramienta_adicional" + contador_nuevo_vin).val();

														var id_id_cliente_adicional = $("#idcliente").val();
														var id_id_departamento_adicional = $("#departamento").val();
														var type_orden_adicional = $("#tipo_orden").val();
														var rol_adicional_vin = $("#rol_vin" + contador_nuevo_vin).val();


														$.post("buscar_vin_general_logistica.php", {
															valorHerramienta: vin_nomenclatura,
															contador_nuevo_vin: contador_nuevo_vin,
															id_id_cliente: id_id_cliente_adicional,
															id_id_departamento: id_id_departamento_adicional,
															type_orden: type_orden_adicional,
															rol_rol_vin: rol_adicional_vin
														}, function(mensaje_vin2) {

															$("#resultadoBusquedaherramienta_adicional" + contador_nuevo_vin).html(mensaje_vin2);
															$("#resultadoBusquedaherramienta_adicional" + contador_nuevo_vin).show();


														});


														$(document).on('click', '.sugerencias_herramienta' + contador_nuevo_vin, function(event_adicional) {
															event_adicional.preventDefault();
															aux_recibido_adicional = $(this).val();
															var porcion_adicional = aux_recibido_adicional.split(';');
															unidad_herramientavin_adicional = porcion_adicional[0];
															unidad_htvin_adicional = porcion_adicional[1];
															unidad_htmarca_adicional = porcion_adicional[2];
															unidad_htversion_adicional = porcion_adicional[3];
															unidad_htcolor_adicional = porcion_adicional[4];
															unidad_htmodelo_adicional = porcion_adicional[5];
															unidad_httipo_adicional = porcion_adicional[6];



															$("#busqueda_herramienta_adicional" + contador_nuevo_vin).val(unidad_htvin_adicional);
															$("#soy_vin" + contador_nuevo_vin).val(unidad_htvin_adicional);
															$("#marca_vin" + contador_nuevo_vin).val(unidad_htmarca_adicional);
															$("#version_vin" + contador_nuevo_vin).val(unidad_htversion_adicional);
															$("#color_vin" + contador_nuevo_vin).val(unidad_htcolor_adicional);
															$("#modelo_vin" + contador_nuevo_vin).val(unidad_htmodelo_adicional);
															$("#tipo_vin" + contador_nuevo_vin).val(unidad_httipo_adicional);
															$("#resultadoBusquedaherramienta_adicional" + contador_nuevo_vin).html("");
															$("#resultadoBusquedaherramienta_adicional" + contador_nuevo_vin).hide();




														});



													}
												</script>

												<center>

													<div class="col-sm-12">
														<button class="btn btn-lg btn-primary mt-4" id="enviar_herramienta" type="submit">Guardar</button>
													</div>


												</center>


											</form>
											<hr>
										</div>
									</div>

								</div>

								<div class="container-bg-1 p-3">
									<div class="table-responsive">
										<table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="tableunidades">
											<thead>
												<tr>
													<th># </th>
													<th>Rol</th>
													<th>VIN</th>
													<th>Marca</th>
													<th>Versión</th>
													<th>Color</th>
													<th>Modelo</th>
													<th>Responsable</th>
													<th>Persona Asignada</th>
													<th>F. Traslado</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$unidad_logistca = 0;

												$query_unidades = "SELECT * FROM orden_logistica_unidades WHERE idorden_logistica = '$idc' and visible = 'SI'";
												$result_unidades = mysql_query($query_unidades);

												while ($row_unidades = mysql_fetch_array($result_unidades)) {

													$unidad_logistca++;
													$idorden_logistica_unidades_code = base64_encode($row_unidades[idorden_logistica_unidades]);

													$nombre_responsable_vin = nombres_datos($row_unidades[idresponsable], $row_unidades[tipo_responsable]);
													$porciones_responsable_vin = explode("|", $nombre_responsable_vin);
													$nombre_responsable_table = ($porciones_responsable_vin[11] == "Colaborador") ? "$porciones_responsable_vin[10]($porciones_responsable_vin[2])" : "$porciones_responsable_vin[10]($row_unidades[tipo_responsable])";

													$nombre_asignado_vin = nombres_datos($row_unidades[idpersona_asignada], $row_unidades[tipopersona_asignada]);
													$porciones_asignado_vin = explode("|", $nombre_asignado_vin);
													$nombre_asignado_table = ($porciones_asignado_vin[11] == "Colaborador") ? "$porciones_asignado_vin[10]($porciones_asignado_vin[2])" : "$porciones_asignado_vin[10]($row_unidades[tipopersona_asignada])";

													$vin_encriptado = base64_encode(trim($row_unidades[vin]));

													$array_unidades = date_vin(trim($row_unidades[vin]));
													$porciones_unidades = explode("|", $array_unidades);

													$formato_traslado = ($porciones_asignado_vin[11] == "Colaborador") ? "<a href='formato_traslado_pdf.php?idc=$recibido&vin_ver=$vin_encriptado' target='_blank'><strong></strong><i class='fa fa-file-pdf-o fa-2x' aria-hidden='true' data-toggle='tooltip' data-placement='bottom' title='Formato de Traslado $nombre_asignado_table'></i></a>" : "<span class='fa-stack fa-lg'><i class='fa fa-file-pdf-o fa-2x'></i><i class='fa fa-ban fa-stack-2x text-danger' data-toggle='tooltip' data-placement='bottom' title='Solo Colaboradores'></i></span></i>";


													if ($acciones_estatus != "Resuelto") {

														$acciones_vin = "<a href='eliminar_vin.php?id_mov=$idorden_logistica_unidades_code'><i class='fa fa-trash fa-2x' data-toggle='tooltip' data-placement='bottom' title='Eliminar VIN'></i></a>";

														$acciones_edit = "<a href='cambiar_asignante.php?id_mov=$idorden_logistica_unidades_code'><i class='fa fa-pencil-square-o fa-2x' data-toggle='tooltip' data-placement='bottom' title='Asignar | Reasignar VIN'></i></a>";
													}

													echo "<tr class='odd gradeX'>
													<td>$unidad_logistca</td>
													<td>$row_unidades[tipo_orden]</td>
													<td>$porciones_unidades[0]</td>
													<td>$porciones_unidades[1]</td>
													<td>$porciones_unidades[2]</td>
													<td>$porciones_unidades[3]</td>
													<td>$porciones_unidades[4]</td>
													<td>$nombre_responsable_table</td>
													<td style='text-align: center;'>$nombre_asignado_table <hr> $acciones_vin <hr> $acciones_edit</td> 
													<td>$formato_traslado</td>       			
													</tr>";
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
								<br>



								<!-- *************** Balance de Gastos de Operación****************************** -->
								<div class="sec-datos">
									<div id="ver_balance_gastos">
										<h3 class="text-titulos-1 my-4 d-flex align-items-center flex-wrap">Balance de Gastos de Operación&nbsp;&nbsp;
											<?php
											if ($estado == "Cancelado" || $estado == "Resuelto") {
											} else {


												echo "<i class='fas fa-plus' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Agregar Nuevo Balande de Gastos' onclick='AgregarNuevoBalance();'></i>&nbsp;&nbsp;
												<i class='fas fa-sync fa-spin' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Actualizar Tabla' onclick='CallTableBalanceGastos();'></i>&nbsp;&nbsp;
												<a href='cambio_vin_general.php?idl=$recibido' class='container-iconos-1'><i class='fas fa-truck-pickup'></i></a> &nbsp;&nbsp;
												<a href='cambio_responsable_general.php?idl=$recibido' class='container-iconos-1'><i class='fas fa-people-carry'></i></a> &nbsp;&nbsp;
												<a href='agregar_auxiliar_general.php?idl=$recibido' class='container-iconos-1'><i class='fas fa-folder-plus'></i></a> &nbsp;&nbsp;
												<a href='pagar_caja_chica_auxiliar.php?idl=$recibido' class='container-iconos-1'><i class='fas fa-hand-holding-usd'></i></a>&nbsp;&nbsp;
												";
											}

											?>
										</h3>
									</div>


								</div>


								<!-- Modal -->
								<div class="modal fade" id="modal_balance_concepto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel"> Filtros balance de gastos de operación </h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body" id="add_opciones_modal_dinamico">

												<div class="ocultar_filters" id="show_concepto_balance" style="display: none;"></div>
												<div class="ocultar_filters" id="show_concepto_movimiento" style="display: none;"></div>
												<div class="ocultar_filters" id="show_fecha_balance" style="display: none;"></div>
												<div class="ocultar_filters" id="show_responsable_balance" style="display: none;"></div>
												<div class="ocultar_filters" id="show_datos_vin_balance" style="display: none;"></div>
												<div class="ocultar_filters" id="show_metodo_pago_balance" style="display: none;"></div>
												<div class="ocultar_filters" id="show_comision_balance" style="display: none;"></div>
												<div class="ocultar_filters" id="show_idcatalogo_provedores_balance" style="display: none;"></div>


											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
											</div>
										</div>
									</div>
								</div>







								<div class='container-bg-1 p-3 mt-4' id="AddTableBalance">



								</div>
							</div>


							<!-- <a href='#'><i class="fas fa-filter fa-5x" onclick=\"ModalFormActionsBalance('concepto')\"></i></a> -->


							<div class="modal fade" id="modal_formulario_balance" tabindex="-1" aria-labelledby="TitlaBalance" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="TitlaBalance"></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>

										<div class="modal-body">

											<form method="POST" id="form_edit_actions_balance" enctype="multipart/form-data" class="was-validated">

												<div id="add_inputs_form_actions_balance">

												</div>

												<div id="show_auxiliares_balance" style="display: none;">

													<div class="col-sm-12 field_add_auxiliar_individual">

													</div>

													<div class="col-sm-12 mt-4">
														<center>
															<a id='create_aux_individual' style='width: 180px;height: 90px;' class="create_aux_individual icon-DOrden" class="" title="Add field"><i class='fa fa-plus-circle fa-5x zoom font-iconr' aria-hidden='true'></i></a>
															<div class="tooltipDetalleOrden mb-3">
																<p>Agregar Auxiliar</p>
															</div>
														</center>
													</div>

													<input id="indivudualauxiliar" type="hidden" value="0" readonly>
													<input id="count_input_aux" type="hidden" value="0" readonly>


													<script type="text/javascript">
														$(document).ready(function() {


															var addButtonAuxiliar = $('.create_aux_individual');
															var wrapper_auxiliar_individual = $('.field_add_auxiliar_individual');

															$(addButtonAuxiliar).click(function() {


																var obtener_count_aux_individual = $("#count_input_aux").val();


																var add_coun_aux_individual = parseInt(obtener_count_aux_individual, 10) + 1;
																$("#count_input_aux").val(add_coun_aux_individual);

																var obtener_aux_individual = $("#indivudualauxiliar").val();

																if (obtener_aux_individual == 0) {

																	var contador_aux = 1;

																} else {

																	if ($.isNumeric(obtener_aux_individual) == true) {

																		var contador_aux = parseInt(obtener_aux_individual, 10) + 1;

																	} else {

																		var cortar = obtener_aux_individual.substr(0, 1);

																		var contador_aux = parseInt(obtener_aux_individual, 10) + 1;

																	}
																}



																$("#indivudualauxiliar").val(contador_aux);

																var fieldHTMLAuxIndividual = `
																<div class="row mt-4 mb-4 container-title-line">

																<div class="col-sm-12">
																<label class="col-form-label">*Auxiliar:</label>
																<input type="text" class="form-control" id="auxiliares_balance" name="auxiliares_balance[]" required list="show_auxiliares">

																<datalist id="show_auxiliares">
																<?php echo $show_auxiliares; ?>
																</datalist>
																</div>

																<a class="button-eliminar remove_button mt-4 mb-4">
																<span>Eliminar</span><i class="fas fa-trash"></i>
																</a>
																</div>

																`;


																$(wrapper_auxiliar_individual).append(fieldHTMLAuxIndividual);

															});


															$(wrapper_auxiliar_individual).on('click', '.remove_button', function(e) {
																e.preventDefault();
																$(this).parent('div').remove();

																var obteneroriginalaux = $("#indivudualauxiliar").val();
																$("#indivudualauxiliar").val(obteneroriginalaux + "|");

																var disminuir_count_aux = $("#count_input_aux").val();
																var nuewcount_individual_aux = parseInt(disminuir_count_aux, 10) - 1;
																$("#count_input_aux").val(nuewcount_individual_aux);

																if (nuewcount_individual_aux == 0) {
																	$("#indivudualauxiliar").val("0");
																}

															});
														});
													</script>



												</div>

												<div id="mostrar_fechas_balance" class="col-sm-12" style="display: none;">
													<div class="d-flex align-items-center mb-2">
														<label class="mb-0 mr-2">*Fecha movimiento</label>&nbsp;
														<div id="clean_fecha_balance" class="container-iconos-1">
															<i class="fa fa-trash-o" aria-hidden="true"></i>
														</div>
													</div>
													<input class="form-control" type="text" id="fecha_balance" name="fecha_balance" onclick="fecha_balance();" readonly>
												</div>

												<div class="col-sm-12" id="show_comentarios_balance">
													<label>*Comentarios&nbsp;&nbsp;<span class="contador_span" id="contador_espan_balance">20 caracteres restantes</label>
													<textarea name="comentarios_balance" id="comentarios_balance" class="form-control" rows="2" required="" onkeypress="cancelar_enter()" onkeyup="RangeComentarios(this,'contador_espan_balance','button_actualizar_balance');"></textarea>
												</div>


												<input type="hidden" name="idbalance_gastos_operacion" id="idbalance_gastos_operacion">
												<input type="hidden" name="balance_tipo_formulario" id="balance_tipo_formulario">
												<input type="hidden" name="fecha_creacion_balance" id="fecha_creacion_balance" value="<?php echo $fecha_actual_day_now; ?>">
												<input type="hidden" name="coordenadas" class="coordenadas" id="coordenadas_balance">
											</form>

											<center>
												<div class="modal-footer col-sm-12">
													<br>
													<button class="btn btn-lg btn-primary" type="button" id="button_actualizar_balance" style="display: none;" onclick="actualizar_balance_options();">Guardar</button>
												</div>
											</center>

										</div>

									</div>
								</div>
							</div>


							<div class="modal fade" id="modal_actions_clean" tabindex="-1" aria-labelledby="title_modal_actions_clean" aria-hidden="true">
								<div class="modal-dialog modal-lg modal-dialog-scrollable">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="title_modal_actions_clean"></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>

										<div class="modal-body" id="add_opciones_modal_options">



										</div>

										<div class="modal-footer">

											<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>

										</div>
									</div>
								</div>
							</div>




							<br>
							<!-- *************** Documentacion Logistica****************************** -->
							<div class="sec-datos">
								<div>
									<h3 class="text-titulos-1 my-4 d-flex align-items-center flex-wrap">Documentación&nbsp;&nbsp;
										<?php
										if ($estado == "Cancelado" || $estado == "Resuelto") {
										} else {
											echo "<a data-toggle= 'collapse' href='#collapseExample3' role='button'	aria-expanded='false' aria-controls='collapseExample3' class='container-iconos-1'><i class='fa fa-plus'></i></a>";
										}

										?>
									</h3>

								</div>

								<div class="collapse" id="collapseExample3">
									<div class="container-bg-1 p-3 mb-4">
										<div class="card card-body">
											<form name="form_documentacion" action="guardar_documentacion.php" method="POST" enctype="multipart/form-data" onsubmit="return validardoc()">
												<?php
												date_default_timezone_set('America/Mexico_City');
												$fecha_creacion = date("Y-m-d H:i:s"); ?>
												<div class="col-sm-12 p-0">
													<div class="form-group row">

														<div class="col-sm-12">
															<label>Tipo</label>
															<div class="content-select">
																<select class="form-control" id="tipo_documentacion" name="tipo" required="" />
																<option value="">Selecciona una opción</option>
																<option value="Entrega">Entrega</option>
																<option value="Recepción">Recepción</option>
																<option value="Otro Tipo">Otro</option>
																</select>
																<i></i>
															</div>
														</div>

														<div id="desc_otro_tipo" style="display: none;" class="col-sm-12">
															<label for="rol">Tipo</label>
															<input id="otro_tipo" name="otro_tipo" class="form-control">

														</div>

														<div class="col-sm-12 form-group">
															<label>Tipo de Documento</label>
															<div class="content-select">
																<select class="form-control" id="documento_tipo" name="documento" required="" />
																<option value="">Selecciona una opción</option>
																<option value="Contratos">Contratos</option>
																<option value="Pagares">Pagares</option>
																<option value="Documentos">Documentos</option>
																<option value="Duplicado">Duplicado</option>
																<option value="Accesorios">Accesorios</option>
																<option value="Placas">Placas</option>
																<option value="Permiso">Permiso</option>
																<option value="Recurso">Recurso</option>
																<option value="Souvenir">Souvenir</option>
																<option value="Otro Documento">Otro</option>
																</select>
																<i></i>
															</div>
														</div>

														<div id="desc_otro_tipo_doc" style="display: none;" class="col-sm-12">
															<label for="rol">Tipo de Documento</label>
															<input id="otro_tipo_documento" name="otro_tipo_documento" class="form-control">
														</div>

														<div id="desribe_vin_documentacion" style="display: none;" class="col-sm-12 sec-datos">

															<div class="col-sm-12">
																<label for="busqueda_vin_documentacion">Buscar VIN</label>
																<input placeholder="Buscar VIN" class="form-control" type="text" name="busqueda_vin_documentacion" id="busqueda_vin_documentacion" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_vin_documentacion();" size="19" width="300%" />
																<center>
																	<div id="resultadoBusquedavinDocumentacion" style="display: none;" class="container-busquedas-1 mt-4 efecto-busqueda"></div>
																</center>
															</div>

															<div class="col-sm-12">
																<label>VIN</label>
																<input class="form-control" type="text" id="vin_documentacion" name="vin_documentacion" readonly="" minlength="8" maxlength="8" onKeyUp="mayus(this);" />
															</div>

															<div class="col-sm-12">
																<label>Marca</label>
																<input class="form-control" type="text" id="marca_documentacion" name="marca_documentacion" readonly="" onKeyUp="mayus(this);" />
															</div>

															<div class="col-sm-12">
																<label>Versión</label>
																<input class="form-control" type="text" id="version_documentacion" name="version_documentacion" readonly="" onKeyUp="mayus(this);" />
															</div>

															<div class="col-sm-12">
																<label>Color</label>
																<input class="form-control" type="text" id="color_documentacion" name="color_documentacion" required="" readonly="" onKeyUp="mayus(this);" />
															</div>

															<div class="col-sm-12">
																<label>Modelo</label>
																<input class="form-control" type="text" id="modelo_documentacion" name="modelo_documentacion" readonly="" />
															</div>

															<div class="col-sm-12">
																<label>Tipo de Unidad</label>
																<input class="form-control" type="text" id="tipo_vin_documentacion" name="tipo_vin_documentacion" readonly="" />
															</div>
															<br>
														</div>

														<div class="col-sm-12 sec-datos" id="describe_id" style="display: none;">
															<br>
															<div class="col-sm-12">
																<label for="busqueda_id_documentacion">Buscar ID</label>
																<input placeholder="Buscar" class="form-control" type="text" name="busqueda_id_documentacion" id="busqueda_id_documentacion" value="" maxlength="25" autocomplete="off" onKeyUp="buscarIdDocumentacion();" size="19" width="300%" />
																<center>
																	<div id="resultadoBusquedaDocumentacionID" style="display: none;" class="container-busquedas-1 mt-4 efecto-busqueda"></div>
																</center>
															</div>

															<div class="col-sm-12">
																<label for="nombre_id">Nombre Completo</label>
																<input type="text" id="nombre_id" class="form-control" value="<?php echo $porciones_id[10]; ?>" readonly="">
															</div>

															<div class="col-sm-12">
																<label for="id_contacto_documentacion">ID</label>
																<input type="text" id="id_contacto_documentacion" name="id_contacto_documentacion" class="form-control" readonly="" value="<?php echo $idcontacto; ?>">
															</div>

															<div class="col-sm-12">
																<label for="tipo_contacto_documentacion">Tipo de Contacto</label>
																<input type="text" id="tipo_contacto_documentacion" name="tipo_contacto_documentacion" class="form-control" readonly="" value="<?php echo $tipo_id_contacto; ?>">
															</div>
															<br>
														</div>

														<div class="col-sm-12 sec-datos" id="desribe_recurso" style="display: none;">
															<br>
															<div class="col-sm-12">
																<div class="form-group">
																	<label>*Tipo de Moneda</label>
																	<div class="content-select">
																		<select class="form-control" id="tipo_moneda_documentacion" name="tipo_moneda_documentacion" onchange="buscar_letras2();">
																			<option value="">Elige una opción…</option>
																			<option value="USD">USD</option>
																			<option value="CAD">CAD</option>
																			<option value="MXN">MXN</option>
																		</select>
																		<i></i>
																	</div>
																</div>
															</div>

															<div class="col-sm-12">
																<div class="form-group">
																	<label>*Tipo de Cambio</label>
																	<input class="form-control" type="text" id="tipo_cambio_documentacion" name="tipo_cambio_documentacion" onchange="cal()" onkeyup="cal()" onkeypress="return SoloNumeros(event);" readonly>
																</div>
															</div>

															<div class="col-sm-12 form-group">
																<label>*Monto</label>
																<input class="form-control" type="text" id="monto_entrada_documentacion" name="monto_entrada_documentacion" onchange="cal()" onkeyup="cal();buscar_letras2();" onkeypress="return SoloNumeros(event);" />
															</div>

															<div class="col-sm-12 form-group">
																<label>Monto Letra</label>
																<input type="text" class="form-control" id="letradocumentacion" name="letra_entrada" readonly>
															</div>


															<div class="col-sm-12 form-group">
																<label>Monto MXN</label>
																<input type="text" class="form-control" id="gran_total_documentacion" name="gran_total_documentacion" readonly>
															</div>

														</div>

														<div class="col-sm-12">
															<label>*Comentarios</label>
															<textarea name="valor" class="form-control" id="valor_comentario" cols="30" rows="3"></textarea>
															<input type="hidden" name="idorden_logistica" value="<?php echo $recibido; ?>">
															<input type="hidden" name="fecha_creacion" value="<?php echo $fecha_creacion; ?>">
															<input type="hidden" name="coordenadas_documentacion" class="coordenadas">
															<input type="hidden" name="idempleado_documentacion" id="idempleado_documentacion" value="<?php echo $idasigna; ?>">
															<input type="hidden" name="tipoempleado_documentacion" id="tipoempleado_documentacion" value="<?php echo $tipo_asignante; ?>">

														</div>

														<div class="col-sm-12">
															<br>
															<center>
																<button class="btn btn-lg btn-primary " id="enviar_documentacion" type="submit">Guardar</button>
															</center>
														</div>


													</div>
												</div>








											</form>
											<hr>
										</div>
									</div>
								</div>


								<div class="container-bg-1 p-3">
									<div class="table-responsive">
										<table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="tabledocumentacion">
											<thead>
												<tr>
													<th># </th>
													<th>VIN</th>
													<th>Tipo</th>
													<th>Documento</th>
													<th>ID</th>
													<th>Recurso</th>
													<th>Comentarios</th>
													<th>Recibo</th>
													<th>Evidencia</th>
													<th>Acciones</th>
												</tr>
											</thead>
											<tbody>

												<?php
												$query_documentacion = "SELECT * FROM orden_logistica_documentacion WHERE idorden_logistica ='$idc' and visible = 'SI'";
												$result_documentacion = mysql_query($query_documentacion);
												while ($registro4 = mysql_fetch_array($result_documentacion)) {
													$t_documento = "$registro4[tipo]";
													$evidencia_documentacion = "$registro4[evidencia]";
													$idorden_logistica_documentacion = base64_encode("$registro4[idorden_logistica_documentacion]");
													$documento++;

													if ($registro4[vin] == "" || $registro4[vin] == null) {

														$mostrar_vin = "N/A";
													} else {

														$array_unidades = date_vin(trim($registro4[vin]));
														$porciones_unidades = explode("|", $array_unidades);

														$mostrar_vin = "<b>$porciones_unidades[0]</b> - $porciones_unidades[1] - $porciones_unidades[2] - $porciones_unidades[3] - $porciones_unidades[4]";
													}


													if ($registro4[tipo_responsable] == "" || $registro4[tipo_responsable] == null) {

														$nombre_completo = "N/A";
													} else {

														$buscar_name_documentacion = nombres_datos($registro4[id_responsable], $registro4[tipo_responsable]);
														$porcion_name_documentation = explode("|", $buscar_name_documentacion);
														$nombre_completo = $porcion_name_documentation[10];
													}

													$mostrar_recurso = ($registro4[monto_rembolso] == "" || $registro4[monto_rembolso] == null) ? "N/A" : "$" . number_format($registro4[monto_rembolso], 2);

													if ($evidencia_documentacion == null || $evidencia_documentacion == "") {
														$subir_documento_evidencia = "<a href='subir_evidencia_documentos.php?idlo=$recibido&ider=$idorden_logistica_documentacion'><i class='fa fa-upload' aria-hidden='true'></i></a>";
													} else {
														$subir_documento_evidencia = "<a href='$evidencia_documentacion' target='_blank'><i class='fa fa-picture-o' aria-hidden='true'></i></a>";
													}


													// if ($registro4[documento] == "Recurso" and $registro4[tipo] == "Recepción") {
													if ($registro4[documento] == "Recurso") {

														$query_recibo = "SELECT * FROM orden_logistica_recurso WHERE idorden_logistica_documentacion = '$registro4[idorden_logistica_documentacion]'";
														$result_recibo = mysql_query($query_recibo);

														while ($row_recibo = mysql_fetch_array($result_recibo)) {
															#$recibo_recurso = "<a href='recibo_recurso_pdf.php?idrb=$idorden_logistica_documentacion' target='_blank'><i class='fa fa-file-pdf-o fa-2x' aria-hidden='true'></i></a>";
															$recibo_recurso = "<a href='recibo_wallet_pdf.php?idrb=$idorden_logistica_documentacion' target='_blank'><i class='fa fa-file-pdf-o fa-2x' aria-hidden='true'></i></a>";
														}
													} else {
														$recibo_recurso = "<span class='fa-stack fa-lg'><i class='fa fa-file-pdf-o fa-2x'></i><i class='fa fa-ban fa-stack-2x text-danger'></i></span>";
													}



													/*if ($registro4[documento] == "Recurso" and $registro4[tipo] == "Recepción") {*/
													if ($registro4[documento] == "Recurso") {

														$eliminar_recurso = "<a href='eliminar_recurso.php?idold=$idorden_logistica_documentacion' ><i class='fa fa-pencil-square-o fa-2x' aria-hidden='true'></i></a>";
													} else {

														$eliminar_recurso = "<span class='fa-stack fa-lg'><i class='fa fa-pencil-square-o fa-2x'></i><i class='fa fa-ban fa-stack-2x text-danger'></i></span>";
													}


													echo "<tr class='odd gradeX'>
						<td>$documento</td>
						<td>$mostrar_vin</td>
						<td>$t_documento</td>
						<td>$registro4[documento]</td>
						<td>$nombre_completo</td>
						<td>$mostrar_recurso</td>
						<td>$registro4[valor]</td>
						<td style='text-align: center'>$recibo_recurso</td>
						<td style='text-align: center'>$subir_documento_evidencia</td>
						<td>$eliminar_recurso</td>
						</tr>";
												}
												?>
											</tbody>
										</table>
									</div>
								</div>

								<div class="d-flex justify-content-center mt-4" style="background: #ececec; border-top: 1px solid #cdcdcd; border-bottom: 1px solid #cdcdcd;">
									<?php echo $back_back2; ?>
									<a href="orden_logistica_detalles.php?idib=<?php echo $recibido; ?>" class="d-flex align-items-center" style="font-size: 12px; margin: 0px 10px;"><i class="fa fa-play fa-2x" aria-hidden="true" style="color: #DD2E5E;"></i></a>
									<?php echo $next_next2; ?>
								</div>

							</div>
							<!-- *************** Seguimientos Logistica****************************** -->
							<br>
							<div class="sec-datos col-sm-12">
								<br>
								<h6 class="mb-3">Seguimientos:

									<?php

									if ($usuario_loguin == "99" || $usuario_loguin == "10023") {

										echo "&nbsp; <a href='delete_bitacora.php?value=$recibido'><i class='fa fa-trash-o fa-2x' aria-hidden='true' id='delete_bitacora'></i></a> ";
									}
									?>
								</h6>

								<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border" id="columna">



									<hr>
									<div class="feed-single mb-3">
										<?php

										date_default_timezone_set('America/Mexico_City');
										$fecha_act = date("Y-m-d H:i:s");

										$count_bitacora = 0;

										$sql20 = "SELECT * FROM orden_logistica_bitacora WHERE idorden_logistica='$idc' and visible = 'SI' ORDER BY idorden_logistica_bitacora DESC";
										$result20 = mysql_query($sql20);

										while ($row_seguimientos = mysql_fetch_array($result20)) {

											$count_bitacora++;
											$tipo = $row_seguimientos[tipo];
											$descripcion = $row_seguimientos[descripcion];

											$f_olb = date_create($row_seguimientos[fecha_guardado]);
											$fecha_bitacora = date_format($f_olb, 'd-m-Y H:i');
											$user = "$row_seguimientos[usuario_creador]";

											$comentarios_bitacora = (trim($row_seguimientos[comentarios]) == "" || null) ? "" : "<br> $row_seguimientos[comentarios]";

											$sql22 = "SELECT *FROM usuarios WHERE idusuario='$user' ";
											$result22 = mysql_query($sql22);
											while ($fila22 = mysql_fetch_array($result22)) {
												$nombre_usuario = "$fila22[nombre_usuario]";
												$sigla_ccp = "$fila22[sigla_ccp]";
												$foto_perfil = "$fila22[foto_perfil]";
											}

											$direccion_archivo = null;

											if ($tipo == "Solicitud") {
												$color = "color:#ff7514;";
												$icono_chat = "fa fa-hourglass-start";
											} else if ($tipo == "Enterado") {
												$color = "color:green;";
												$icono_chat = "fa fa-check-square-o";
											} else if ($tipo == "Denegado") {
												$color = "color:red;";
												$icono_chat = "fa fa-times";
											} else if ($tipo == "Pendiente") {
												$color = "color:#ff520b;";
												$icono_chat = "fa fa-refresh fa-spin fa-2x fa-fw";
											} elseif ($tipo == "Trabajando") {
												$color = "color:2F4F4F;";
												$icono_chat = "fa fa-wrench";
											} elseif ($tipo == "Inicia Recorrido") {
												$color = "color:2F4F4F;";
												$icono_chat = "fa fa-road";
											} elseif ($tipo == "Destino Alcanzado") {
												$color = "color:red;";
												$icono_chat = "fa fa-map-marker";
											} elseif ($tipo == "Retorno Origen") {
												$color = "color:orange;";
												$icono_chat = "fa fa-undo";
											} elseif ($tipo == "Manejo Finalizado") {
												$color = "color:green;";
												$icono_chat = "fa fa-home";
											} elseif ($tipo == "Resuelto") {
												$color = "color:blue;";
												$icono_chat = "fa fa-thumbs-up";
											} elseif ($tipo == "Notificación") {
												$color = "color:green;";
												$icono_chat = "fa fa-whatsapp";
											} elseif ($tipo == "Cuentas") {
												$color = "color:green;";
												$icono_chat = "fa fa-money";
											} elseif ($tipo == "VIN") {
												$color = "color:#2F4F4F;";
												$icono_chat = "fa fa-car";
											} elseif ($tipo == "Acompañante") {
												$color = "color:#2F4F4F;";
												$icono_chat = "fa fa-user-plus";
											} elseif ($tipo == "Documentación") {
												$color = "color:#2F4F4F;";
												$icono_chat = "fa fa-folder-open";
											} elseif ($tipo == "Cambio de Ejecutivo de Traslado") {
												$color = "color:#2F4F4F;";
												$icono_chat = "fa fa-users";
											} elseif ($tipo == "Fecha Programada") {
												$color = "color:#2F4F4F;";
												$icono_chat = "fa fa-calendar-check-o";
											} elseif ($tipo == "Datos del ID") {
												$color = "color:#64d149;";
												$icono_chat = "fa fa fa-user";
											} elseif ($tipo == "Entrega de Recurso") {
												$color = "color:#000000;";
												$icono_chat = "fa fa-usd";
											} elseif ($tipo == "Token") {
												$color = "color:#000000;";
												$icono_chat = "fas fa-key";

												if ($row_seguimientos[usuario_creador] == $usuario_creador) {
													$comentarios_bitacora = "<br>
													$row_seguimientos[comentarios]";
												}
											} else {
												$icono_chat = "fa fa-question-circle-o";
												$color = "color:red;";
											}
											$idcn = base64_encode($idcontacto);
											if ($archivo == "") {
												$icono_evidencia = "fa fa-upload";
												$direccion_archivo_ = "<br>Evidencias: <a href='subir_archivo_evidencia.php?idev=$idactividades&idse=$idactividades_seguimiento'><i class='$icono_evidencia'></a></i>";
											} else {
												$direccion_archivo_ = "<br>Evidencias: <a href='$archivo' target='_blank'><i class='$icono_evidencia'></a></i>";
											}



											echo "
											<div class='media'>
											<img class='mr-3 rounded-circle' height='40px' width='40px' src='$foto_perfil'>
											<div class='media-body'>
											<h6 class='mt-1'><i class='$icono_chat'></i> $tipo
											<small class='text-muted small pull-right'><i class='fa fa-clock'></i>$fecha_bitacora</small>
											
											<br>
											$descripcion
											$comentarios_bitacora

											<p class='clearfix'></p>
											</h6>
											<p>$nombre_usuario</p>

											<div class='feed-footer'>


											<span class='pr-3'>$fecha_bitacora</span>
											<span class='pr-3'>$direccion_archivo</span>

											</div>
											</div>
											</div> <hr>";
										}
										?>


									</div>
								</div>
							</div>



						</div>
					</div>
					<!--Footer-->
					<?php
					include_once '../footer.php';
					?>
					<!--Footer-->
				</div>
			</div>
			<!--Main Content-->
		</div>
	</div>

	<script src="../../datapicker_moder/lib/compressed/picker.js"></script>
	<script src="../../datapicker_moder/lib/compressed/picker.date.js"></script>
	<script src="../../datapicker_moder/lib/compressed/picker.time.js"></script>

	<!--Page Wrapper-->
	<link rel="stylesheet" type="text/css" href="../../js/jquery.datetimepicker.css" />
	<script src="../../js/jquery.datetimepicker.full.js"></script>

	<!-- Page JavaScript Files-->
	<!-- <script src="../../assets/js/jquery.min.js"></script>
							<script src="../../assets/js/jquery-1.12.4.min.js"></script> -->
	<!--Popper JS-->
	<script src="../../assets/js/popper.min.js"></script>
	<!--Bootstrap-->
	<script src="../../assets/js/bootstrap.min.js"></script>
	<!--Sweet alert JS-->
	<script src="../../assets/js/sweetalert.js"></script>
	<!--Progressbar JS-->
	<script src="../../assets/js/progressbar.min.js"></script>
	<!--Charts-->
	<!--Canvas JS-->
	<script src="../../assets/js/charts/canvas.min.js"></script>
	<!--Bootstrap Calendar JS-->
	<script src="../../assets/js/calendar/bootstrap_calendar.js"></script>
	<script src="../../assets/js/calendar/demo.js"></script>
	<!--Bootstrap Calendar-->
	<!--Datatable-->
	<script src="../../assets/js/jquery.dataTables.min.js"></script>
	<script src="../../assets/js/dataTables.bootstrap4.min.js"></script>
	<script src="../../plugins/datatables/datatables-responsive/dataTables.responsive.js?<?php echo $random; ?>"></script>

	<!--Custom Js Script-->
	<script src="../../assets/js/custom.js"></script>
	<!--Custom Js Script-->
	<script src="../../assets/js/jquery.bootstrap.wizard.js"></script>
	<!-- <script src="../../assets/js/paper-bootstrap-wizard.js"></script> -->
	<script src="../../assets/js/jquery.validate.min.js"></script>

	<script src="../../plugins/Datepicker/bootstrap-material-datetimepicker.js"></script>
	<script src="../../plugins/Datepicker/es-mx.min.js"></script>




	<script>
		$(document).ready(function() {



			$('#fecha_hora_programada').bootstrapMaterialDatePicker({
				date: true,
				time: true,
				shortTime: true,
				format: 'YYYY-MM-DD HH:mm',
				lang: "es",
				cancelText: 'Cancelar',
				okText: 'Definir'

			});


			$("#enviar_programada").click(function() {


				var ver_comentario = $("#comentario_programada").val()

				if (ver_comentario == null || ver_comentario.length == 0 || /^\s+$/.test(ver_comentario)) {
					$("#comentario_trasladista").focus();

					$(".error-form").show();
					$(".text-error").html("Debes de Ingresar Detalles del cambio de Fecha");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
					return false;

				} else {

					var datos = $("#form_programada").serialize();

					$.ajax({
						type: "POST",
						url: "guardar_fecha_programada.php",
						data: datos,
						success: function(programada) {

							var porciones = programada.split('|');

							if (porciones[0].trim() == "Sin Errores") {

								$('#succes_ruta').show();
								$("#succes_ruta").delay(500).fadeIn("slow");

								open(porciones[1], 'Whats', `width=600, height=600, left=300, top=300`);
								location.reload();

							} else if (porciones[0].trim() == "Fallo") {

								$('#fail_ruta').show();
								$("#fail_ruta").delay(500).fadeIn("slow");
								location.reload();


							} else {

								$('#recibir_variables').html(programada);
								$('#fail_ruta').show();
								$("#fail_ruta").delay(6000).fadeIn();
								location.reload();
							}
						}
					});
					return false;
				}



			});


			var hay_orden = '<?php echo $presupuesto; ?>'

			var mostrar = (hay_orden == "" || hay_orden == null) ? $("#desc_trae_orden").hide() : $("#desc_trae_orden").show();




			$('#tableayudantes').DataTable({
				language: {
					"decimal": "",
					"emptyTable": "No hay información",
					"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
					"infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
					"infoFiltered": "(Filtrado de _MAX_ total entradas)",
					"infoPostFix": "",
					"thousands": ",",
					"lengthMenu": "Mostrar _MENU_ Entradas",
					"loadingRecords": "Cargando...",
					"processing": "Procesando...",
					"search": "Buscar:",
					"zeroRecords": "Sin resultados encontrados",
					"paginate": {
						"first": "Primero",
						"last": "Ultimo",
						"next": "Siguiente",
						"previous": "Anterior"
					}
				},
				responsive: true,
				lengthMenu: [
					[10, 25, 50, -1],
					[10, 25, 50, "All"]
				],
				dom: 'Blfrtip',
				buttons: [
					'copy', 'excel'
				],

			});
			var table = $('#tableayudantes').DataTable();

			table
				.order([0, 'asc'])
				.draw();

			$('#tableunidades').DataTable({
				language: {
					"decimal": "",
					"emptyTable": "No hay información",
					"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
					"infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
					"infoFiltered": "(Filtrado de _MAX_ total entradas)",
					"infoPostFix": "",
					"thousands": ",",
					"lengthMenu": "Mostrar _MENU_ Entradas",
					"loadingRecords": "Cargando...",
					"processing": "Procesando...",
					"search": "Buscar:",
					"zeroRecords": "Sin resultados encontrados",
					"paginate": {
						"first": "Primero",
						"last": "Ultimo",
						"next": "Siguiente",
						"previous": "Anterior"
					}
				},
				responsive: true,
				lengthMenu: [
					[10, 25, 50, -1],
					[10, 25, 50, "All"]
				],
				dom: 'Blfrtip',
				buttons: [
					'copy', 'excel'
				],

			});
			var table = $('#tableunidades').DataTable();

			table
				.order([0, 'asc'])
				.draw();

			$('#tabledocumentacion').DataTable({
				language: {
					"decimal": "",
					"emptyTable": "No hay información",
					"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
					"infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
					"infoFiltered": "(Filtrado de _MAX_ total entradas)",
					"infoPostFix": "",
					"thousands": ",",
					"lengthMenu": "Mostrar _MENU_ Entradas",
					"loadingRecords": "Cargando...",
					"processing": "Procesando...",
					"search": "Buscar:",
					"zeroRecords": "Sin resultados encontrados",
					"paginate": {
						"first": "Primero",
						"last": "Ultimo",
						"next": "Siguiente",
						"previous": "Anterior"
					}
				},
				responsive: true,
				lengthMenu: [
					[10, 25, 50, -1],
					[10, 25, 50, "All"]
				],
				dom: 'Blfrtip',
				buttons: [
					'copy', 'excel'
				],

			});
			var table = $('#tabledocumentacion').DataTable();

			table
				.order([0, 'asc'])
				.draw();


		});


		searchVisible = 0;
		transparent = true;

		$(document).ready(function() {

			$('[rel="tooltip"]').tooltip();

			$('.wizard-card').bootstrapWizard({
				'tabClass': 'nav nav-pills',
				'nextSelector': '.btn-next',
				'previousSelector': '.btn-previous',

				onNext: function(tab, navigation, index) {
					var $valid = $('.wizard-card form').valid();
					if (!$valid) {
						$validator.focusInvalid();
						return false;
					}
				},

				onInit: function(tab, navigation, index) {


					var $total = navigation.find('li').length;
					$width = 100 / $total;

					navigation.find('li').css('width', $width + '%');

				},


			});

			var tProgress = $("#progress-bar-circle").width();
			var wPorcentage = (tProgress / $('#progress-bar-circle').parent().width()) * 100;
			$('#progress-bar-circle').width(wPorcentage + '%');

			if (wPorcentage >= 93 && wPorcentage <= 95) {
				$(".p94").addClass("active");
				$(".p83").removeClass("active");
				$(".p72").removeClass("active");
				$(".p61").removeClass("active");
				$(".p50").removeClass("active");
				$(".p39").removeClass("active");
				$(".p28").removeClass("active");
				$(".p17").removeClass("active");
				$(".p6").removeClass("active");

				$(".tooltipEstatus").text('Resuelto');
			} else
			if (wPorcentage >= 82 && wPorcentage <= 84) {
				$(".p83").addClass("active");
				$(".p72").removeClass("active");
				$(".p61").removeClass("active");
				$(".p50").removeClass("active");
				$(".p39").removeClass("active");
				$(".p28").removeClass("active");
				$(".p17").removeClass("active");
				$(".p6").removeClass("active");

				$(".tooltipEstatus").text('Cuentas');
			} else
			if (wPorcentage >= 71 && wPorcentage <= 73) {
				$(".p72").addClass("active");
				$(".p61").removeClass("active");
				$(".p50").removeClass("active");
				$(".p39").removeClass("active");
				$(".p28").removeClass("active");
				$(".p17").removeClass("active");
				$(".p6").removeClass("active");

				$(".tooltipEstatus").text('Manejo Finalizado');
			} else
			if (wPorcentage >= 60 && wPorcentage <= 62) {
				$(".p61").addClass("active");
				$(".p50").removeClass("active");
				$(".p39").removeClass("active");
				$(".p28").removeClass("active");
				$(".p17").removeClass("active");
				$(".p6").removeClass("active");

				$(".tooltipEstatus").text('Retorno Origen');
			} else
			if (wPorcentage >= 49 && wPorcentage <= 51) {
				$(".p50").addClass("active");
				$(".p39").removeClass("active");
				$(".p28").removeClass("active");
				$(".p17").removeClass("active");
				$(".p6").removeClass("active");

				$(".tooltipEstatus").text('Destino Alcanzado');
			} else
			if (wPorcentage >= 38 && wPorcentage <= 40) {
				$(".p39").addClass("active");
				$(".p28").removeClass("active");
				$(".p17").removeClass("active");
				$(".p6").removeClass("active");

				$(".tooltipEstatus").text('Sin Disponibilidad');
			} else
			if (wPorcentage >= 27 && wPorcentage <= 29) {
				$(".p28").addClass("active");
				$(".p17").removeClass("active");
				$(".p6").removeClass("active");

				$(".tooltipEstatus").text('Inicia Recorrido');
			} else
			if (wPorcentage >= 16 && wPorcentage <= 18) {

				$(".p17").addClass("active");
				$(".p6").removeClass("active");

				$(".tooltipEstatus").text('Enterado');
			} else
			if (wPorcentage >= 5 && wPorcentage <= 7) {

				$(".p6").addClass("active");

				$(".tooltipEstatus").text('Solicitud');
			}



			var claseT = $(".textEstatusPrimero");
			var texto = $(".textEstatusPrimero").html();
			if (texto == "Cancelado") {
				$(".textCambio").text("Cancelado");
			} else {
				$(".textCambio").text("Resuelto");
			}

			var claseTooltip = $(".textCambio");
			var texto2 = $(".textCambio").html();
			if (texto2 == "Cancelado") {
				$(".tooltipEstatus").text('Cancelado');
			}

		});

		// -------------------------------------------------- Estatus Principal Status ---------------------------------------------------------------------

		function GuardarEstatusPrincipal() {

			var EstatusPrincipal = $("#EstatusPrincipal").val();
			var comentarios_cancelacion = $("#comentarios_cancelacion").val();

			console.log(EstatusPrincipal);
			console.log(comentarios_cancelacion);

			if (EstatusPrincipal.trim() == "") {

				$("#EstatusPrincipal").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Selecciona una opción");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#EstatusPrincipal").focus();
				return false;

			}

			if (EstatusPrincipal.trim() == "Cancelado" && comentarios_cancelacion == "") {

				$("#comentarios_cancelacion").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Debes de Agregar un comentario");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#comentarios_cancelacion").focus();
				return false;

			}



		}


		// -------------------------------------------------- Inicia trasladita Principal Agregar Trasladista Principal ---------------------------------------------------------------------

		function AddTrasladistaPrincipal(name_trasladista_principal) {
			console.log(name_trasladista_principal);
			var idlogistica = '<?php echo $idc;	?>'
			var ComprobarVIN = 'ComprobarVIN';

			$.ajax({

				type: "POST",
				url: "buscar_trasladista_principal_actualizar.php",
				data: {
					tipo_accion: "ComprobarVIN",
					idlogistica: idlogistica
				},
				beforeSend: function() {

					$(".container-loading-ajax").show();

				},
				success: function(mensaje) {

					var resultado = mensaje.trim();
					console.log(mensaje);


					if (resultado == 1) {


						if (name_trasladista_principal != "Pendiente()" && name_trasladista_principal != "Pendiente(Pendiente)" && name_trasladista_principal.trim() != "Pendiente") {

							var comentarios_trasldista_principal = `
							<div class="col-sm-12">
								<label>Descripción Cambio de Ejecutivo</label>
								<textarea class="form-control" rows="3" name="comentario_update_trasladista" id="comentario_update_trasladista" maxlength="8950" required=""></textarea>
							</div>
							`;

						} else {

							var comentarios_trasldista_principal = '<input type="hidden" id="comentario_update_trasladista" name="comentario_update_trasladista">';

						}

						$('#modal_logistica').modal('toggle');
						$("#examplelogisticatitle").empty();
						$("#add_logistica_modal").empty();

						$("#examplelogisticatitle").html("Agregar | Actualizar Trasladista Principal");

						var form_trasladista_principal = `

						<div class="col-sm-12">
							<label>Buscar Trasladista</label>
							<input placeholder="Buscar" class="form-control" type="text" name="busqueda_trasladista_principal" id="busqueda_trasladista_principal" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_trasladista_principal();" size="19" width="300%" />
							<center>
								<div id="resultadoBusquedaTrasladistaPrincipal" style="display: none;" class="mt-4 efecto-busqueda"></div>
							</center>
						</div>

						<div class="col-sm-12">
							<label form="nombre_trasladista_principal">*Trasladista </label>
							<input class="form-control" type="text" name="nombre_trasladista_principal" id="nombre_trasladista_principal" readonly="" />
						</div>

						${comentarios_trasldista_principal}

						<input type="hidden" class="cleantokentrasladistaPrincipal" id="id_trasladista_principal" name="id_trasladista_principal">
						<input type="hidden" class="cleantokentrasladistaPrincipal" id="tipo_trasladista_principal" name="tipo_trasladista_principal">
						<input type="hidden" class="coordenadas" id="coordenadas_trasladista_principal">
						<br>
						<div class="col-sm-12">
							<center>
						<button type="button" class="btn btn-primary btn-lg" id="guardar_actions" onclick="GuardarActualizarTrasladista();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</center>
						</div>
						
						`;

						$("#add_logistica_modal").html(form_trasladista_principal);
						ObtenerCoordenadas();


					} else if (resultado == 0) {


						$('#modal_logistica').modal('toggle');
						$("#examplelogisticatitle").empty();
						$("#add_logistica_modal").empty();

						$("#examplelogisticatitle").html("Agregar Trasladista con Excepción");

						var form_trasladistaExeption = `

					

						<input type="hidden" class="cleantokentrasladistaPrincipal" id="id_trasladista_principal" name="id_trasladista_principal">
						<input type="hidden" class="cleantokentrasladistaPrincipal" id="tipo_trasladista_principal" name="tipo_trasladista_principal">
						<input type="hidden" class="coordenadas" id="coordenadas_trasladista_principal">
						<br>
						<div class="col-sm-12" id="buttonTrasladistaException" style="display: none;">
							<center>
						<button type="button" class="btn btn-primary btn-lg" id="guardar_actions" onclick="GuardarActualizarTrasladista();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</center>
						</div>
						
						`;
						TrasladistaPrincipalException(form_trasladistaExeption);





					} else {
						$(".error-form").show();
						$(".text-error").html(mensaje);

						setTimeout(function() {
							$(".error-form").fadeOut(1000);
						}, 1500);
					}

					$(".container-loading-ajax").hide();


				},
				error: function(xhr, status) {

					$(".error-form").show();
					$(".text-error").html("Disculpe, existió un problema");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);

				}

			});
		}

		// Busqueda trasladista principal
		function buscar_trasladista_principal() {

			var textoBusquedaTrasladista = $("#busqueda_trasladista_principal").val();
			var name_sugerencia = 'sugerencias_trasladista';

			if (textoBusquedaTrasladista != "") {

				$.post("buscar_id_colaborador_completo.php", {
					valorBusqueda: textoBusquedaTrasladista,
					tipoBusqueda: "TrasladistaAyudantesSI",
					name_sugerencia: name_sugerencia

				}, function(mensaje_trasladista) {

					$("#resultadoBusquedaTrasladistaPrincipal").show();
					$("#resultadoBusquedaTrasladistaPrincipal").html(mensaje_trasladista);


				});
			} else {
				$("#resultadoBusquedaTrasladistaPrincipal").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
			}

			$(document).on('click', '.sugerencias_trasladista', function(event) {
				event.preventDefault();
				aux_recibido = $(this).val();
				var porcion = aux_recibido.split(';');
				unidad_id_trasladista_principal = porcion[0];
				unidad_nomenclatura_trasladista = porcion[1];
				tipo_trasladista_principal = porcion[2];
				tipo_nomenclatura = porcion[3];
				$("#busqueda_trasladista_principal").val("");
				$("#id_trasladista_principal").val(unidad_id_trasladista_principal);
				$("#nombre_trasladista_principal").val(unidad_nomenclatura_trasladista);
				$("#tipo_trasladista_principal").val(tipo_trasladista_principal);
				$("#nomenclatura_no_hay_trasladista").val(tipo_nomenclatura);
				$("#resultadoBusquedaTrasladistaPrincipal").html("");
				$("#resultadoBusquedaTrasladistaPrincipal").hide();
			});

		}

		// Guardar Actualizar Trasladista

		function GuardarActualizarTrasladista() {

			var idlogistica = '<?php echo $idc; ?>'

			var idtrasladista_principal = $("#id_trasladista_principal").val();
			var tipo_trasladista_principal = $("#tipo_trasladista_principal").val();

			var condicion_comentarios = '<?php echo $nombre_asignante; ?>'
			var comentarios = $("#comentario_update_trasladista").val();

			var coordenadas = $("#coordenadas_trasladista_principal").val();
			var fecha_creacion = TiempoAhora()


			if (idtrasladista_principal.trim() == "" || tipo_trasladista_principal.trim() == "") {

				$("#nombre_trasladista_principal").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Debes de agregar un trasladista");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#busqueda_trasladista_principal").focus();
				return false;

			}

			if (condicion_comentarios.trim() != "Pendiente()" && comentarios == "" && condicion_comentarios != "Pendiente(Pendiente)") {

				$("#comentario_update_trasladista").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Debes de agregar un comentario");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#comentario_update_trasladista").focus();
				return false;

			}

			var formData = new FormData();

			formData.append('id_trasladista', idtrasladista_principal);
			formData.append('tipo_trasladista', tipo_trasladista_principal);
			formData.append('id_log', idlogistica);
			formData.append('fecha_creacion', fecha_creacion);
			formData.append('ubicacion_real_no_update_trasladista', coordenadas);
			formData.append('comentario_update_trasladista', comentarios);


			$.ajax({
				type: "POST",
				url: "guardar_actualizar_trasladista.php",
				data: formData,
				processData: false,
				contentType: false,
				cache: false,
				type: "POST",
				beforeSend: function() {

					$(".container-loading-ajax").show();
				},
				success: function(mensaje_update_trasladista) {

					var porciones_update = mensaje_update_trasladista.trim();
					var mensaje_update_trasladista = porciones_update.split("|");


					if (mensaje_update_trasladista[0].trim() == 1) {

						$('#modal_logistica').modal('hide');
						$("#examplelogisticatitle").empty();
						$("#add_logistica_modal").empty();

						$(".listo-form").show();
						$(".text-listo").html("<b>Datos Guardados Correctamente</b>");

						if (mensaje_update_trasladista[1] != "") {
							open(mensaje_update_trasladista[1], "Trasladista Anterior", "width=600, height=600, left=300, top=300");
						}

						if (mensaje_update_trasladista[2] != "") {
							open(mensaje_update_trasladista[2], "Trasladista Nuevo", "width=600, height=600, left=300, top=300");
						}

						if (mensaje_update_trasladista[3] != "") {
							open(mensaje_update_trasladista[3], "Entrega", "width=600, height=600, left=300, top=300");
						}

						if (mensaje_update_trasladista[4] != "") {
							open(mensaje_update_trasladista[4], "Recepcion", "width=600, height=600, left=300, top=300");
						}

						if (mensaje_update_trasladista[5] != "") {
							open(mensaje_update_trasladista[5], "Programada", "width=600, height=600, left=300, top=300");
						}

						setTimeout(function() {
							$(".listo-form").fadeOut(1000);
						}, 1500);

						location.reload();
					} else {

						$('#modal_logistica').modal('show');
						$("#examplelogisticatitle").empty();
						$("#add_logistica_modal").empty();

						$("#examplelogisticatitle").html("Error");
						$("#add_logistica_modal").html(mensaje_update_trasladista[0]);

					}

					$(".container-loading-ajax").hide();


				},
				error: function(xhr, status) {

					$(".error-form").show();
					$(".text-error").html("Disculpe, existió un problema");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
				}


			});

		}

		// Buscar Trasladista en la parte de exepciones

		function TrasladistaPrincipalException(valor) {

			$.ajax({

				type: "POST",
				url: "buscar_trasladista_principal_actualizar.php",
				data: {
					tipo_accion: "TrasladistaPrincipal"
				},
				beforeSend: function() {
					$(".container-loading-ajax").show();
				},
				success: function(mensajeTprincipal) {
					$("#add_logistica_modal").html(mensajeTprincipal + valor);
					ObtenerCoordenadas();
				},
				error: function(xhr, status) {
					$(".error-form").show();
					$(".text-error").html("Disculpe, existió un problema");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
				}

			});
		}

		// tratar select trasladista excepcion

		function ExceptionTrasladistaP() {

			var trasladistaexeption = $("#trasladistaexeption").val();

			if (trasladistaexeption.trim() == "" || trasladistaexeption == "OptionToken") {

				$(".cleantokentrasladistaPrincipal").val("");
				$("#buttonTrasladistaException").hide();


				$("#FormSolicitarTokenTPrincipal").show();

				$("#AsignarTPLSI").attr('checked', false);
				$("#AsignarTPLNO").attr('checked', false);

				$("#showSolicitarTokenTPrincipal").hide();
				$("#YategoTokenTrasladistaPrincipal").hide();




			} else {

				$(".cleantokentrasladistaPrincipal").val("");
				var porciones = trasladistaexeption.split("|");
				$("#id_trasladista_principal").val(porciones[0]);
				$("#tipo_trasladista_principal").val(porciones[1]);
				$("#buttonTrasladistaException").show("");


				$("#FormSolicitarTokenTPrincipal").hide();

				$("#AsignarTPLSI").attr('checked', false);
				$("#AsignarTPLNO").attr('checked', false);

				$("#showSolicitarTokenTPrincipal").hide();
				$("#YategoTokenTrasladistaPrincipal").hide();


			}
		}

		//Solicitar Token

		function SolicitarTokenDesbloqueo(valor) {

			var valor_porciones = valor.split('|');

			if (valor_porciones[0].trim() == "AsignarTPL") {

				if (valor_porciones[1].trim() == "SI") {

					$("#AsignarTPLNO").attr('checked', false);

					$("#showSolicitarTokenTPrincipal").show();
					$(".cleantokentrasladistaPrincipal").val("");

					$("#YategoTokenTrasladistaPrincipal").hide();


				} else {

					$("#AsignarTPLSI").attr('checked', false);

					$("#showSolicitarTokenTPrincipal").hide();
					$(".cleantokentrasladistaPrincipal").val("");

					$("#YategoTokenTrasladistaPrincipal").show();


				}


			}
		}

		// Guardar Solicitud Token
		function EnviarSolicitudDesbloqueo(valor) {

			var idlogistica = '<?php echo $idc; ?>'
			var value = $("#" + valor).val();
			var fecha_creacion = TiempoAhora();
			var coordenadas = $(".coordenadas").val();

			if (value.trim() == "") {

				$("#" + valor).css("border-color", "#882439");
				$(".error-form").show();
				$(".text-error").html("Debes de Agregar un <b>COMENTARIO RAZONABLE !</b>");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);

				$("#" + valor).focus();
				return false;

			}

			$.ajax({

				type: "POST",
				url: "buscar_trasladista_principal_actualizar.php",
				data: {
					tipo_accion: "Solicitud de Token",
					idlogistica: idlogistica,
					valorBusqueda: value,
					fecha_creacion: fecha_creacion,
					coordenadas: coordenadas
				},
				beforeSend: function() {
					$(".container-loading-ajax").show();
				},
				success: function(respuestaToken) {

					var respuestaToken = respuestaToken.trim();
					var porciones = respuestaToken.split('|');

					if (porciones[0].trim() == 1 || porciones[0].trim() == " 1") {

						$(".listo-form").show();
						$(".text-listo").html("<b>Solicitud Exitosa!</b>");

						setTimeout(function() {
							$(".listo-form").fadeOut(2000);
						}, 1500);

						open(porciones[1], 'Whats', `width=600, height=600, left=300, top=300`);

						$('#modal_logistica').modal('hide');
						$("#examplelogisticatitle").empty();
						$("#add_logistica_modal").empty();


					} else {

						$(".error-form").show();
						$(".text-error").html(porciones[0]);

						setTimeout(function() {
							$(".error-form").fadeOut(3000);
						}, 1500);

					}

					$(".container-loading-ajax").hide();
					location.reload();
				},
				error: function(xhr, status) {
					$(".error-form").show();
					$(".text-error").html("Disculpe, existió un problema");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);


				}

			});
		}

		// Confirmar nuevo token logistica

		function AjaxVerificarTokenTP(valor) {

			var value = $("#" + valor).val();
			var idlogistica = '<?php echo $idc;	?>'
			var name_trasladista_principal = "<?php echo $nombre_asignante; ?>";

			if (value.trim() == "") {

				$("#" + valor).css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Por favor ingresa el <b>Token!</b>");

				setTimeout(function() {
					$(".error-form").fadeOut(3000);
				}, 1500);
				return false;
				$("#" + valor).focus();
			}

			$.ajax({

				type: "POST",
				url: "buscar_trasladista_principal_actualizar.php",
				data: {
					tipo_accion: "ComprobarTokenLogisticaTPrincipal",
					idlogistica: idlogistica,
					valorBusqueda: value
				},
				beforeSend: function() {

					$(".container-loading-ajax").show();

				},
				success: function(resultTokenTP) {

					var resultado = resultTokenTP.trim();
					console.log(resultTokenTP);


					if (name_trasladista_principal != "Pendiente()" && name_trasladista_principal != "Pendiente(Pendiente)") {

						var comentarios_trasldista_principal = `
						<div class="col-sm-12">
							<label>Descripción Cambio de Ejecutivo</label>
							<textarea class="form-control" rows="3" name="comentario_update_trasladista" id="comentario_update_trasladista" maxlength="8950" required=""></textarea>
						</div>
						`;

					} else {

						var comentarios_trasldista_principal = '<input type="hidden" id="comentario_update_trasladista" name="comentario_update_trasladista">';

					}

					if (resultado == 1) {

						//$('#modal_logistica').modal('toggle');
						$("#examplelogisticatitle").empty();
						$("#add_logistica_modal").empty();

						$("#examplelogisticatitle").html("Agregar | Actualizar Trasladista Principal");

						var form_trasladista_principal = `

						<div class="col-sm-12">
							<label>Buscar Trasladista</label>
							<input placeholder="Buscar" class="form-control" type="text" name="busqueda_trasladista_principal" id="busqueda_trasladista_principal" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_trasladista_principal();" size="19" width="300%" />
							<center>
								<div id="resultadoBusquedaTrasladistaPrincipal" style="display: none;" class="mt-4 efecto-busqueda"></div>
							</center>
						</div>

						<div class="col-sm-12">
							<label form="nombre_trasladista_principal">*Trasladista </label>
							<input class="form-control" type="text" name="nombre_trasladista_principal" id="nombre_trasladista_principal" readonly="" />
						</div>

						${comentarios_trasldista_principal}

						<input type="hidden" class="cleantokentrasladistaPrincipal" id="id_trasladista_principal" name="id_trasladista_principal">
						<input type="hidden" class="cleantokentrasladistaPrincipal" id="tipo_trasladista_principal" name="tipo_trasladista_principal">
						<input type="hidden" class="coordenadas" id="coordenadas_trasladista_principal">
						<br>
						<div class="col-sm-12">
							<center>
						<button type="button" class="btn btn-primary btn-lg" id="guardar_actions" onclick="GuardarActualizarTrasladista();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</center>
						</div>

						`;

						$("#add_logistica_modal").html(form_trasladista_principal);
						ObtenerCoordenadas();


					} else {

						$(".error-form").show();
						$(".text-error").html(resultTokenTP);

						setTimeout(function() {
							$(".error-form").fadeOut(4000);
						}, 1500);
					}

					$(".container-loading-ajax").hide();


				},
				error: function(xhr, status) {

					$(".error-form").show();
					$(".text-error").html("Disculpe, existió un problema");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);

				}

			});


		}




		function SoloNumeros(evt) {
			if (window.event) {
				keynum = evt.keyCode;
			} else {
				keynum = evt.which;
			}

			if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 || keynum == 47) {
				return true;
			} else {
				return false;
			}
		}


		$(document).ready(function() {

			// --------- Aprobar Cancelar Logistica
			$('#estados').hide("fast");

			$("#estados_icono").click(function() {
				$('#estados').toggle("slow");
			});


			$("#ocultar").click(function() {

				$('#comentarios').hide("fast");
				$('#estados').hide("fast");
			});


			$('#EstatusPrincipal').on('change', function() {

				if ($("#EstatusPrincipal").val() == "Resuelto" || $("#EstatusPrincipal").val() == "") {

					$("#comentarios_cancelacion").val("");
					$("#desc_comentarios_logistica").hide();

				} else {

					$("#desc_comentarios_logistica").show();
					$("#comentarios_cancelacion").val("");

					var comentarios_cancelar = '<?php echo "<b>$nombre_usuario_creador<b> Se te informa que logística número <b>$idc<b> ha sido cancelada; por lo tanto cualquier gasto generado con esta orden, puede aplicar una sanción así mismo el gasto total generado debido a: "; ?>'

					$("#comentarios_cancelacion").val(comentarios_cancelar);
					$("#comentarios_cancelacion").attr("required", "required");
				}
			});

		});

		function validar_ayudante() {

			var txtcomentarios_ayudante = document.getElementById('comentario_ayudante').value;
			var txtid_colaborador_ayudante = document.getElementById('id_colaborador_ayudante').value;
			var txttipo_ayu_prov = document.getElementById('tipo_ayu_prov').value;
			if (txtcomentarios_ayudante == null || txtcomentarios_ayudante.length == 0 || /^\s+$/.test(txtcomentarios_ayudante)) {

				$(".error-form").show();
				$(".text-error").html("ERROR: Debes ingresar un comentario");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#comentario_ayudante").focus();
				return false;
			}

			if (txtid_colaborador_ayudante == null || txtid_colaborador_ayudante.length == 0 || /^\s+$/.test(txtid_colaborador_ayudante)) {

				$(".error-form").show();
				$(".text-error").html("ERROR: Con el Acompañante");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				return false;
			}

			if (txttipo_ayu_prov == null || txttipo_ayu_prov.length == 0 || /^\s+$/.test(txttipo_ayu_prov)) {

				$(".error-form").show();
				$(".text-error").html("ERROR: Con el Acompañante");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				return false;
			}

			return true;
		}

		function validardoc() {

			var tipo_documentacion = document.getElementById('tipo_documentacion').selectedIndex;
			var documento_tipo = document.getElementById('documento_tipo').selectedIndex;
			var valor_comentario = $("#valor_comentario").val();
			var vin_documentacion = $("#vin_documentacion").val();
			var nombre_id = $("#nombre_id").val();
			var tipo_moneda_documentacion = document.getElementById('tipo_moneda_documentacion').selectedIndex;
			var tipo_cambio_documentacion = $("#tipo_cambio_documentacion").val();
			var monto_entrada_documentacion = $("#monto_entrada_documentacion").val();
			var documento_tipo_select = $("#documento_tipo").val();


			var ver_comentario = valor_comentario.trim();

			if (tipo_documentacion == null || tipo_documentacion == 0) {

				$(".error-form").show();
				$(".text-error").html("ERROR: Debes seleccionar una opción");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				return false;
			}

			if (documento_tipo == null || documento_tipo == 0) {

				$(".error-form").show();
				$(".text-error").html("ERROR: Debes seleccionar una opción");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				return false;
			}


			if (documento_tipo_select == "Contratos" || documento_tipo_select == "Documentos" || documento_tipo_select == "Permiso") {

				if (vin_documentacion == null || vin_documentacion.length == 0 || /^\s+$/.test(vin_documentacion)) {

					$(".error-form").show();
					$(".text-error").html("ERROR: Debes de agregar un vin");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
					$("#busqueda_vin_documentacion").focus();
					return false;
				}

				if (nombre_id == null || nombre_id.length == 0 || /^\s+$/.test(nombre_id)) {

					$(".error-form").show();
					$(".text-error").html("ERROR: Debes de agregar un ID");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
					$("#busqueda_id_documentacion").focus();
					return false;
				}



			} else if (documento_tipo_select == "Pagares" || documento_tipo_select == "Recurso") {

				if (nombre_id == null || nombre_id.length == 0 || /^\s+$/.test(nombre_id)) {

					$(".error-form").show();
					$(".text-error").html("ERROR: Debes de agregar un ID");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
					$("#busqueda_id_documentacion").focus();
					return false;
				}

				if (tipo_moneda_documentacion == null || tipo_moneda_documentacion == 0) {

					$(".error-form").show();
					$(".text-error").html("ERROR: Debes seleccionar una opción");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
					$("#tipo_moneda_documentacion").focus();
					return false;
				}

				if (tipo_cambio_documentacion == null || tipo_cambio_documentacion.length == 0 || /^\s+$/.test(tipo_cambio_documentacion)) {

					$(".error-form").show();
					$(".text-error").html("ERROR: Debes de agregar un ID");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
					$("#busqueda_id_documentacion").focus();
					return false;
				}

				if (monto_entrada_documentacion == null || monto_entrada_documentacion.length == 0 || /^\s+$/.test(monto_entrada_documentacion)) {

					$(".error-form").show();
					$(".text-error").html("ERROR: Debes de agregar un ID");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
					$("#busqueda_id_documentacion").focus();
					return false;
				}




			} else if (documento_tipo_select == "Duplicado" || documento_tipo_select == "Accesorios" || documento_tipo_select == "Placas") {

				if (vin_documentacion == null || vin_documentacion.length == 0 || /^\s+$/.test(vin_documentacion)) {

					$(".error-form").show();
					$(".text-error").html("ERROR: Debes de agregar un VIN");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
					$("#busqueda_vin_documentacion").focus();
					return false;
				}

			}


			if (ver_comentario == null || ver_comentario.length == 0 || /^\s+$/.test(ver_comentario)) {

				$(".error-form").show();
				$(".text-error").html("ERROR: El comentario no debe ir vacío o lleno de solamente espacios en blanco");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#valor_comentario").focus();
				return false;
			}

		}

		function mayus(e) {
			e.value = e.value.toUpperCase();
		}


		function buscar_tarjeta() {

			var valorTarjeta = $("#busqueda_tarjeta").val();

			if (valorTarjeta != "") {

				$.post("buscar_tarjeta.php", {
					valorTarjeta: valorTarjeta
				}, function(mensaje_tarjeta) {

					$("#resultadoBusquedaTarjeta").html(mensaje_tarjeta);

					if (mensaje_tarjeta.trim() == "<b>Tarjeta Tag NO Encontrada</b>") {

						$("#resultadoBusquedaTarjeta").show();

					} else {
						$("#resultadoBusquedaTarjeta").show();
						$("#resultadoBusquedaTarjeta").html(mensaje_tarjeta);
					}

				});

			} else {
				$("#resultadoBusquedaTarjeta").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
			}

			$(document).on('click', '.sugerencias_tarjetas', function(event) {
				event.preventDefault();

				aux_recibido = $(this).val();
				var porcion = aux_recibido.split(';');
				numero = porcion[0];
				tarjeta = porcion[1];


				$("#resultadoBusquedaTarjeta").hide();
				$("#number_card").prepend(`<option value="${numero}" class="optionnumbercard"> ${tarjeta} ${numero}</option>`);

				$('#number_card').prop('selectedIndex', 0);

				$("#resultadoBusquedaTarjeta").html("");

			});

		}

		$(document).ready(function() {


			$.datetimepicker.setLocale('es');
			$('#hora_estimada_solucion').datetimepicker({
				format: 'Y-m-d H:i',
				//minDate:'0',
				//minTime:new Date(),
				//closeOnDateSelect:true,
				step: 10

			});

			$("#clean_hora_estimada").click(function() {
				$("#hora_estimada_solucion").val("");
			});


		});


		function ObtenerCoordenadas() {

			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {

					var latitud = position.coords.latitude;
					var longitud = position.coords.longitude;
					var coordenadas = latitud + " " + longitud;

					$(".coordenadas").val(coordenadas);


				}, function() {
					handleLocationError(true);
				});
			} else {

				handleLocationError(false);
			}

		}

		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {

				var latitud = position.coords.latitude;
				var longitud = position.coords.longitude;
				var coordenadas = latitud + " " + longitud;

				$(".coordenadas").val(coordenadas);


			}, function() {
				handleLocationError(true);
			});
		} else {

			handleLocationError(false);
		}
	</script>


	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKNm5FUjlIYRpuH8aquS6q-7NzQdlAwgc">
	</script>



	<script>
		function mayus(e) {
			e.value = e.value.toUpperCase();
		}

		function submitContactForm() {
			var datos = $("#form_baja_ayudante").serialize();

			$.ajax({
				type: "POST",
				url: "baja_ayudante_logistica.php",
				data: datos,
				success: function(msj) {
					if (msj == " 1") {
						alert(msj);
						$("#succes_ayudante").show();
						$("#succes_ayudante").delay(500).fadeIn("slow");
						location.reload();
					} else {
						alert(msj);
						$("#fail_ayudante").show();
						$("#fail_ayudante").delay(500).fadeIn("slow");
						location.reload();
					}
				}
			});
			return false;
		}

		$(document).ready(function() {

			$("#tipo_documentacion").change(function() {

				var documentacion = $("#tipo_documentacion").val();

				if (documentacion == "Otro Tipo") {
					$("#desc_otro_tipo").show();
					$("#otro_tipo").val("");
					$("#otro_tipo").attr("required", "required");

				} else {
					$("#desc_otro_tipo").hide();
					$("#otro_tipo").val("");
					$("#otro_tipo").removeAttr("required", "required");
				}
			});






			$("#documento_tipo").change(function() {

				var documento_tipo = $("#documento_tipo").val();

				if (documento_tipo == "Contratos" || documento_tipo == "Documentos" || documento_tipo == "Permiso" || documento_tipo == "Souvenir") {

					$("#desribe_vin_documentacion").show();
					$("#busqueda_vin_documentacion").val("");
					$("#vin_documentacion").val("");
					$("#marca_documentacion").val("");
					$("#version_documentacion").val("");
					$("#color_documentacion").val("");
					$("#modelo_documentacion").val("");
					$("#tipo_vin_documentacion").val("");
					//----------------------------------
					$("#describe_id").show();
					$("#busqueda_id_documentacion").val("");
					$("#busqueda_id_documentacion").show();
					//$("#nombre_id").val("");
					//$("#id_contacto_documentacion").val("");
					//$("#tipo_contacto_documentacion").val("");
					//----------------------------------
					$("#desribe_recurso").hide();
					$("#tipo_moneda_documentacion").val("");
					$("#tipo_cambio_documentacion").val("");
					$("#monto_entrada_documentacion").val("");
					$("#letradocumentacion").val("");
					$("#gran_total_documentacion").val("");


				} else if (documento_tipo == "Pagares") {
					$("#desribe_vin_documentacion").hide();
					$("#busqueda_vin_documentacion").val("");
					$("#vin_documentacion").val("");
					$("#marca_documentacion").val("");
					$("#version_documentacion").val("");
					$("#color_documentacion").val("");
					$("#modelo_documentacion").val("");
					$("#tipo_vin_documentacion").val("");
					//----------------------------------
					$("#describe_id").show();
					$("#busqueda_id_documentacion").val("");
					$("#busqueda_id_documentacion").show();
					//$("#nombre_id").val("");
					//$("#id_contacto_documentacion").val("");
					//$("#tipo_contacto_documentacion").val("");
					//----------------------------------
					$("#desribe_recurso").show();
					$("#tipo_moneda_documentacion").val("");
					$("#tipo_cambio_documentacion").val("");
					$("#monto_entrada_documentacion").val("");
					$("#letradocumentacion").val("");
					$("#gran_total_documentacion").val("");

				} else if (documento_tipo == "Recurso") {
					$("#desribe_vin_documentacion").hide();
					$("#busqueda_vin_documentacion").val("");
					$("#vin_documentacion").val("");
					$("#marca_documentacion").val("");
					$("#version_documentacion").val("");
					$("#color_documentacion").val("");
					$("#modelo_documentacion").val("");
					$("#tipo_vin_documentacion").val("");
					//----------------------------------
					$("#describe_id").show();
					$("#busqueda_id_documentacion").val("");
					$("#busqueda_id_documentacion").hide();
					//$("#nombre_id").val("");
					//$("#id_contacto_documentacion").val("");
					//$("#tipo_contacto_documentacion").val("");
					//----------------------------------
					$("#desribe_recurso").show();
					$("#tipo_moneda_documentacion").val("");
					$("#tipo_cambio_documentacion").val("");
					$("#monto_entrada_documentacion").val("");
					$("#letradocumentacion").val("");
					$("#gran_total_documentacion").val("");

				} else if (documento_tipo == "Duplicado" || documento_tipo == "Accesorios" || documento_tipo == "Placas") {
					$("#desribe_vin_documentacion").show();
					$("#busqueda_vin_documentacion").val("");
					$("#vin_documentacion").val("");
					$("#marca_documentacion").val("");
					$("#version_documentacion").val("");
					$("#color_documentacion").val("");
					$("#modelo_documentacion").val("");
					$("#tipo_vin_documentacion").val("");
					//----------------------------------
					$("#describe_id").hide();
					$("#busqueda_id_documentacion").val("");
					$("#busqueda_id_documentacion").show();
					$("#nombre_id").val("");
					$("#id_contacto_documentacion").val("");
					$("#tipo_contacto_documentacion").val("");
					//----------------------------------
					$("#desribe_recurso").hide();
					$("#tipo_moneda_documentacion").val("");
					$("#tipo_cambio_documentacion").val("");
					$("#monto_entrada_documentacion").val("");
					$("#letradocumentacion").val("");
					$("#gran_total_documentacion").val("");

				} else if (documento_tipo == "Otro Documento") {
					$("#desc_otro_tipo_doc").show();
					$("#otro_tipo_documento").val("");
					$("#otro_tipo_documento").attr("required", "required");
					//----------------------------------
					$("#desribe_vin_documentacion").show();
					$("#busqueda_vin_documentacion").val("");
					$("#vin_documentacion").val("");
					$("#marca_documentacion").val("");
					$("#version_documentacion").val("");
					$("#color_documentacion").val("");
					$("#modelo_documentacion").val("");
					$("#tipo_vin_documentacion").val("");
					//----------------------------------
					$("#describe_id").show();
					$("#busqueda_id_documentacion").val("");
					$("#busqueda_id_documentacion").show();
					//$("#nombre_id").val("");
					//$("#id_contacto_documentacion").val("");
					//$("#tipo_contacto_documentacion").val("");
					//----------------------------------
					$("#desribe_recurso").show();
					$("#tipo_moneda_documentacion").val("");
					$("#tipo_cambio_documentacion").val("");
					$("#monto_entrada_documentacion").val("");
					$("#letradocumentacion").val("");
					$("#gran_total_documentacion").val("");

				} else {

					$("#desc_otro_tipo_doc").hide();
					$("#otro_tipo_documento").val("");
					$("#otro_tipo_documento").removeAttr("required", "required");
					//----------------------------------
					$("#desribe_vin_documentacion").hide();
					$("#busqueda_vin_documentacion").val("");
					$("#vin_documentacion").val("");
					$("#marca_documentacion").val("");
					$("#version_documentacion").val("");
					$("#color_documentacion").val("");
					$("#modelo_documentacion").val("");
					$("#tipo_vin_documentacion").val("");
					//----------------------------------
					$("#describe_id").hide();
					$("#busqueda_id_documentacion").val("");
					$("#busqueda_id_documentacion").show();
					//$("#nombre_id").val("");
					$("#id_contacto_documentacion").val("");
					$("#tipo_contacto_documentacion").val("");
					//----------------------------------
					$("#desribe_recurso").hide();
					$("#tipo_moneda_documentacion").val("");
					$("#tipo_cambio_documentacion").val("");
					$("#monto_entrada_documentacion").val("");
					$("#letradocumentacion").val("");
					$("#gran_total_documentacion").val("");
				}


			});



			$('select#tipo_moneda_documentacion').change(function() {

				var cambio1 = "1";
				var cambio2 = "1";
				var cambio3 = "1";
				var nada = "0";
				var valor = $(this).val();

				if (valor == 'USD') {

					$("#tipo_cambio_documentacion").val(cambio1);
					$('#tipo_cambio_documentacion').prop('readonly', true);

				} else if (valor == 'CAD') {

					$("#tipo_cambio_documentacion").val(parseFloat(cambio2));
					$('#tipo_cambio_documentacion').prop('readonly', true);

				} else if (valor == 'MXN') {

					$("#tipo_cambio_documentacion").val(parseFloat(cambio3));
					$('#tipo_cambio_documentacion').prop('readonly', true);

				} else if (valor == '') {
					$("#tipo_cambio_documentacion").val(parseFloat(0));

				}

			});




		});



		function buscar_vin_documentacion() {
			var textoBusquedaherramienta = $("#busqueda_vin_documentacion").val();
			if (textoBusquedaherramienta != "") {
				$.post("buscar_vin_documentacion.php", {
					valorHerramienta: textoBusquedaherramienta
				}, function(mensaje_herramienta) {
					$("#resultadoBusquedavinDocumentacion").html(mensaje_herramienta);

					if (mensaje_herramienta.trim() == "<b>VIN NO Encontrado</b>") {
						$("#resultadoBusquedavinDocumentacion").show();

						$("#vin_documentacion").attr("readonly", "readonly");
						$("#marca_documentacion").attr("readonly", "readonly");
						$("#version_documentacion").attr("readonly", "readonly");
						$("#color_documentacion").attr("readonly", "readonly");
						$("#modelo_documentacion").attr("readonly", "readonly");

					} else {
						$("#vin_documentacion").attr("readonly", "readonly");
						$("#marca_documentacion").attr("readonly", "readonly");
						$("#version_documentacion").attr("readonly", "readonly");
						$("#color_documentacion").attr("readonly", "readonly");
						$("#modelo_documentacion").attr("readonly", "readonly");
						$("#resultadoBusquedavinDocumentacion").show();
					}
				});
			} else {
				$("#resultadoBusquedavinDocumentacion").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
			};
		};
		$(document).on('click', '.sugerencias_vin_documentacion', function(event) {
			event.preventDefault();
			aux_recibido = $(this).val();
			var porcion = aux_recibido.split(';');
			vin_doc = porcion[1];
			marca_doc = porcion[2];
			version_doc = porcion[3];
			color_doc = porcion[4];
			modelo_doc = porcion[5];
			tipo_doc = porcion[6];

			$("#resultadoBusquedavinDocumentacion").hide();
			$("#busqueda_vin_documentacion").val("");
			$("#tipo_vin_documentacion").val(tipo_doc);
			$("#vin_documentacion").val(vin_doc);
			$("#marca_documentacion").val(marca_doc);
			$("#version_documentacion").val(version_doc);
			$("#color_documentacion").val(color_doc);
			$("#modelo_documentacion").val(modelo_doc);
			$("#resultadoBusquedavinDocumentacion").html("");


		});




		function buscarIdDocumentacion() {
			var textoBusquedaCliente = $("#busqueda_id_documentacion").val();

			if (textoBusquedaCliente != "") {

				$.post("buscar_id_documentacion.php", {
					valorBusqueda: textoBusquedaCliente
				}, function(mensaje_cliente) {
					$("#resultadoBusquedaDocumentacionID").html(mensaje_cliente);

					if (mensaje_cliente == " <b>ID NO Encontrado</b>") {

						$("#resultadoBusquedaDocumentacionID").show();
						$("#nombre_id").attr("readonly", "readonly");
						$("#id_contacto_documentacion").attr("readonly", "readonly");
						$("#tipo_contacto_documentacion").attr("readonly", "readonly");

					} else {
						$("#resultadoBusquedaDocumentacionID").show();
						$("#nombre_id").attr("readonly", "readonly");
						$("#id_contacto_documentacion").attr("readonly", "readonly");
						$("#tipo_contacto_documentacion").attr("readonly", "readonly");
					}
				});
			} else {
				$("#resultadoBusquedaDocumentacionID").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
			};
		};
		$(document).on('click', '.sugerencias_id_documentacion', function(event) {
			event.preventDefault();
			aux_recibido = $(this).val();
			var porcion = aux_recibido.split(';');
			unidad_id = porcion[0];
			unidad_nombre = porcion[1];
			unidad_apellidos = porcion[2];
			unidad_alias = porcion[3];
			unidad_telefono_celular = porcion[4];
			unidad_telefono_otro = porcion[5];
			unidad_estado = porcion[6];
			unidad_municipio = porcion[7];
			unidad_colonia = porcion[8];
			unidad_calle = porcion[9];
			unidad_cp = porcion[10];
			unidad_tipo_id = porcion[11];
			$("#resultadoBusquedaDocumentacionID").hide();
			$("#busqueda_id").val("");
			//$("#nombre_id").val(unidad_nombre + " " + unidad_apellidos);
			$("#id_contacto_documentacion").val(unidad_id);
			$("#tipo_contacto_documentacion").val(unidad_tipo_id);
			$("#resultadoBusquedaDocumentacionID").html("");
		});









		function buscar_letras2() {
			var textoletras = $("#monto_entrada_documentacion").val();
			var tipo = $("#tipo_moneda_documentacion").val();


			if (textoletras != "") {
				$.post("buscar_letras_documentacion.php", {
					valorBusqueda: textoletras,
					valortipo: tipo
				}, function(mensaje_letras) {

					$("#letradocumentacion").val(mensaje_letras);


				});
			} else {
				$("#letradocumentacion").val('');
			};
		};




		function cal() {
			try {
				var a = parseFloat(document.form_documentacion.tipo_cambio_documentacion.value),
					b = parseFloat(document.form_documentacion.monto_entrada_documentacion.value);
				document.form_documentacion.gran_total_documentacion.value = a * b;
			} catch (e) {}
		}


		function buscar_cliente() {
			var textoBusquedaID = $("#busqueda_id").val();
			var id_departamento = '<?php echo $iddepartamento; ?>';

			if (textoBusquedaID != "") {

				$.post("buscar_cliente_logostica.php", {
						valorBusqueda: textoBusquedaID,
						type_id: id_departamento
					},

					function(mensaje_id) {

						$("#resultadoBusquedaId").show();
						$("#resultadoBusquedaId").html(mensaje_id);


						if (mensaje_id.trim() == "<b>ID NO Encontrado</b>") {

							//$("#show_add_id").show();
							$("#idcliente").val("");
							$("#nombre").val("");
							$("#apellidos").val("");
							$("#alias").val("");
							$("#celular").val("");
							$("#fijo").val("");
							$("#estado").val("");
							$("#municipio").val("");
							$("#colonia").val("");
							$("#calle").val("");
							$("#codigo_postal_cliente").val("");
							$("#tipo_contacto_id").val("");
							//$("#create_button").show();

						} else {

							$("#guardar_id_temporal").show();
							$("#idcliente").attr("readonly", "readonly");
							$("#nombre").attr("readonly", "readonly");
							$("#apellidos").attr("readonly", "readonly");
							$("#alias").attr("readonly", "readonly");
							$("#celular").attr("readonly", "readonly");
							$("#fijo").attr("readonly", "readonly");
							$("#estado").attr("readonly", "readonly");
							$("#municipio").attr("readonly", "readonly");
							$("#colonia").attr("readonly", "readonly");
							$("#calle").attr("readonly", "readonly");
							$("#codigo_postal_cliente").attr("readonly", "readonly");
							$("#codigo_postal_cliente").attr("readonly", "readonly");
							$("#create_button").hide();
							$("#show_add_id").hide();

						}
					});
			} else {
				$("#resultadoBusquedaId").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
			};
		};


		$(document).on('click', '.option_id_logistica_generar', function(event) {

			event.preventDefault();
			aux_recibido = $(this).val();
			var porcion = aux_recibido.split(';');
			unidad_id = porcion[0];
			unidad_nombre = porcion[1];
			unidad_apellidos = porcion[2];
			unidad_alias = porcion[3];
			unidad_telefono_celular = porcion[4];
			unidad_telefono_otro = porcion[5];
			unidad_estado = porcion[6];
			unidad_municipio = porcion[7];
			unidad_colonia = porcion[8];
			unidad_calle = porcion[9];
			unidad_cp = porcion[10];
			unidad_tipo_id = porcion[11];
			$("#busqueda_colaborador").val("");
			$("#idcliente").val(unidad_id);
			$("#nombre").val(unidad_nombre);
			$("#apellidos").val(unidad_apellidos);
			$("#alias").val(unidad_alias);
			$("#celular").val(unidad_telefono_celular);
			$("#fijo").val(unidad_telefono_otro);
			$("#estado").val(unidad_estado);
			$("#estado_destino").val(unidad_estado);
			$("#municipio").val(unidad_municipio);
			$("#municipio_destino").val(unidad_municipio);
			$("#colonia").val(unidad_colonia);
			$("#colonia_destino").val(unidad_colonia);
			$("#calle").val(unidad_calle);
			$("#calle_destino").val(unidad_calle);
			$("#codigo_postal_cliente").val(unidad_cp);
			$("#tipo_contacto_id").val(unidad_tipo_id);
			$("#resultadoBusquedaId").html("");
			$("#resultadoBusquedaId").hide();


		});


		function guardar_temporal() {


			var nombre_cliente = $("#nombre").val();
			var apellidos_cliente = $("#apellidos").val();
			var alias_cliente = $("#alias").val();
			var celular_cliente = $("#celular").val();
			var fijo_cliente = $("#fijo").val();
			var estado_cliente = $("#estado").val();
			var municipio_cliente = $("#municipio").val();
			var colonia_cliente = $("#colonia").val();
			var calle_cliente = $("#calle").val();
			var codigo_postal_cliente_cliente = $("#codigo_postal_cliente").val();


			$.ajax({
				url: 'agregar_proveedor.php',
				data: {
					nombre_cliente: nombre_cliente,
					apellidos_cliente: apellidos_cliente,
					alias_cliente: alias_cliente,
					celular_cliente: celular_cliente,
					fijo_cliente: fijo_cliente,
					estado_cliente: estado_cliente,
					municipio_cliente: municipio_cliente,
					colonia_cliente: colonia_cliente,
					calle_cliente: calle_cliente,
					codigo_postal_cliente_cliente: codigo_postal_cliente_cliente
				},
				type: 'POST',
				success: function(json) {
					var porcionestemporal = json.split('|');

					if (porcionestemporal[0] >= 0) {
						$("#create_button").hide();
						$("#idcliente").attr("readonly", "readonly");
						$("#nombre").attr("readonly", "readonly");
						$("#apellidos").attr("readonly", "readonly");
						$("#alias").attr("readonly", "readonly");
						$("#celular").attr("readonly", "readonly");
						$("#fijo").attr("readonly", "readonly");
						$("#estado").attr("readonly", "readonly");
						$("#municipio").attr("readonly", "readonly");
						$("#colonia").attr("readonly", "readonly");
						$("#calle").attr("readonly", "readonly");
						$("#codigo_postal_cliente").attr("readonly", "readonly");

						$("#idcliente").val(porcionestemporal[0]);
						$("#nombre").val(porcionestemporal[1]);
						$("#apellidos").val(porcionestemporal[2]);
						$("#alias").val(porcionestemporal[3]);
						$("#celular").val(porcionestemporal[4]);
						$("#fijo").val(porcionestemporal[5]);
						$("#estado").val(porcionestemporal[6]);
						$("#municipio").val(porcionestemporal[7]);
						$("#colonia").val(porcionestemporal[8]);
						$("#calle").val(porcionestemporal[9]);
						$("#codigo_postal_cliente").val(porcionestemporal[10]);
						$("#tipo_contacto_id").val(porcionestemporal[11]);



					} else {

						console.log(json);

					}




				},


				error: function(xhr, status) {
					// alert('Disculpe, existió un problema');
					$(".error-form").show();
					$(".text-error").html("Disculpe, existio un problema");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
				}
			});




		}














		function mostrarModalbalance(modal_valor) {



			var tabla = "balance";
			var ok = "<?php echo $idc; ?>"
			let idl = ok;



			if (modal_valor == "concepto") {

				($('#show_concepto_balance').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_concepto_balance"): $('#modal_balance_concepto').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_concepto_balance").show();

			} else if (modal_valor == "tmovimineto") {

				($('#show_concepto_movimiento').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_concepto_movimiento"): $('#modal_balance_concepto').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_concepto_movimiento").show();

			} else if (modal_valor == "fecha") {

				($('#show_fecha_balance').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_fecha_balance"): $('#modal_balance_concepto').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_fecha_balance").show();

			} else if (modal_valor == "responsable") {

				($('#show_responsable_balance').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_responsable_balance"): $('#modal_balance_concepto').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_responsable_balance").show();

			} else if (modal_valor == "vin") {

				($('#show_datos_vin_balance').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_datos_vin_balance"): $('#modal_balance_concepto').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_datos_vin_balance").show();

			} else if (modal_valor == "mpago") {

				($('#show_metodo_pago_balance').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_metodo_pago_balance"): $('#modal_balance_concepto').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_metodo_pago_balance").show();

			} else if (modal_valor == "tarjeta") {

				($('#show_comision_balance').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_comision_balance"): $('#modal_balance_concepto').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_comision_balance").show();

			} else if (modal_valor == "proveedor") {

				($('#show_idcatalogo_provedores_balance').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_idcatalogo_provedores_balance"): $('#modal_balance_concepto').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_idcatalogo_provedores_balance").show();

			} else {

			}


		}


		function modal_ajax(tabla, modal_valor, idc, viewdiv) {

			$.ajax({
				type: "POST",
				url: "show_datos_modal.php",
				data: {
					valorBusqueda: tabla,
					valorSelect: modal_valor,
					idc: idc
				},
				success: function(modal_balance_gastos) {

					$("#" + viewdiv).html(modal_balance_gastos);
					$('#modal_balance_concepto').modal('toggle');
					$("#" + viewdiv).show();

				}
			});
			return false;


		}

		function filterme_balance() {


			var types = $('input:checkbox[name="filter_concepto_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 1, true, false, false, false);


			var types = $('input:checkbox[name="filter_concepto_movimiento"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 2, true, false, false, false);


			var types = $('input:checkbox[name="filter_fecha_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 3, true, false, false, false);


			var types = $('input:checkbox[name="filter_responsable_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 6, true, false, false, false);


			var types = $('input:checkbox[name="filter_datos_vin_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 7, true, false, false, false);


			var types = $('input:checkbox[name="filter_metodo_pago_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 8, true, false, false, false);


			var types = $('input:checkbox[name="filter_comision_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 9, true, false, false, false);


			var types = $('input:checkbox[name="filter_idcatalogo_provedores_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 10, true, false, false, false);


		}



		function ModalFormActionsBalance(modal_valor_balance) {

			$('#modal_formulario_balance').modal('show');

			RangeComentarios();
			fecha_balance();

			var porciones_balance = modal_valor_balance.split(",");

			$("#button_actualizar_balance").hide();
			$("#comentarios_balance").val("");
			$("#idbalance_gastos_operacion").val("");
			$("#balance_tipo_formulario").val("");
			$("#TitlaBalance").val("");


			$("#add_inputs_form_actions_balance").empty();

			$(".field_add_auxiliar_individual").empty();

			$("#indivudualauxiliar").val("0");
			$("#count_input_aux").val("0");

			//----------ADD----------------

			$("#idbalance_gastos_operacion").val(porciones_balance[0]);
			$("#balance_tipo_formulario").val(porciones_balance[1]);
			console.log(porciones_balance[1]);
			console.log(porciones_balance[2]);

			if (porciones_balance[1].trim() == "Evidencia") {

				$("#show_auxiliares_balance").hide();
				$("#mostrar_fechas_balance").hide();

				if (porciones_balance[2] == "NO") {

					$("#TitlaBalance").html("<i class='fas fa-images fa-1.5x'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agregar Evidencia");

					$("#show_comentarios_balance").hide();
					$("#comentarios_balance").removeAttr("required", "required");
					$("#button_actualizar_balance").show();

				} else {

					$("#TitlaBalance").html("<i class='fas fa-images fa-1.5x'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cambiar Evidencia");

					$("#show_comentarios_balance").show();
					$("#comentarios_balance").attr("required", "required");
					$("#button_actualizar_balance").hide();

				}

				var create_form_balance = `
				<div class="col-sm-12">
				<label for="evidencia_balance" class="form-label">Agregar Evidencia</label>
				<input class="form-control" type="file" id="evidencia_balance" name="evidencia_balance" required="" size='9216000'>
				</div>
				`;



			} else if (porciones_balance[1].trim() == "Concepto") {

				$("#TitlaBalance").html("<i class='fas fa-keyboard fa-1.5x'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cambiar Concepto");

				$("#show_auxiliares_balance").hide();
				$("#mostrar_fechas_balance").hide();

				var create_form_balance = `
				<div class="col-sm-12">
				<label>Concepto</label>
				<select name="concepto_balance" id="concepto_balance" class="form-control" required="">
				<?php echo $options_form_balance ?>
				</select>
				</div>
				`;

			} else if (porciones_balance[1].trim() == "AuxiliarIndividual") {

				$("#TitlaBalance").html("<i class='fas fa-file-contract fa-1.5x'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Agregar Auxiliares");

				$("#show_auxiliares_balance").show();
				$("#mostrar_fechas_balance").hide();

			} else if (porciones_balance[1].trim() == "Fechas") {

				$("#TitlaBalance").html("<i class='far fa-calendar-alt fa-1.5x'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cambiar Fecha");

				$("#show_auxiliares_balance").hide();

				$("#mostrar_fechas_balance").show();



			} else if (porciones_balance[1].trim() == "MontoBalance") {

				$("#TitlaBalance").html("<i class='fas fa-dollar-sign fa-1.5x'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cambiar Monto");

				$("#show_auxiliares_balance").hide();
				$("#mostrar_fechas_balance").hide();

				var create_form_balance = `
				<div class="col-sm-12">
				<label>Costo Total</label>
				<input type="text" class="form-control" name="gran_total_balance" id="gran_total_balance" required onkeypress="return SoloNumeros(event);">
				</div>
				`;

			} else if (porciones_balance[1].trim() == "ResponsableIndividual") {

				$("#TitlaBalance").html("<i class='fas fa-user-friends fa-1.5x'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cambiar Responsable");

				$("#show_auxiliares_balance").hide();
				$("#mostrar_fechas_balance").hide();

				var create_form_balance = `
				<div class="col-sm-12">
				<label>Responsbale</label>
				<select name="responsable_individual" id="responsable_individual" class="form-control" required>
				<?php
				foreach ($array_responsable_balance as $key => $options_responsable) {
					$options_array_responsable = explode("|", $options_responsable);
					echo "<option value='$options_array_responsable[0]|$options_array_responsable[1]'>$options_array_responsable[2]</option>";
				} ?>
				</select>
				</div>
				`;

			} else if (porciones_balance[1].trim() == "VINIndividual") {

				$("#TitlaBalance").html("<i class='fas fa-car fa-1.5x'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cambiar VIN");

				$("#show_auxiliares_balance").hide();
				$("#mostrar_fechas_balance").hide();


				var create_form_balance = `
				<div class="col-sm-12">
				<label>Buscar VIN</label>
				<input placeholder="Buscar VIN" class="form-control" type="text" name="busqueda_vin_balance" id="busqueda_vin_balance" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_vin_dinamico('balance');" size="19" 		width="300%" />
				<center>
				<div id="resultadoBusquedaVin_balance" style="display: none;" class="container-busquedas-1 mt-4"></div>
				</center>
				</div>

				<div class="col-sm-12">
				<label>VIN </label>                                          
				<input class="form-control" type="text" id="search_vin_balance" name="search_vin_balance"  readonly="" minlength="8" maxlength="8" onKeyUp="mayus(this);"  />
				</div>

				<div class="col-sm-12">
				<label>Marca</label>
				<input class="form-control" type="text" id="search_marca_balance" name="search_marca_balance" readonly="" onKeyUp="mayus(this);" />

				</div> 

				<div class="col-sm-12">
				<label>Versión</label>
				<input class="form-control" type="text" id="search_version_balance" name="search_version_balance"  readonly="" onKeyUp="mayus(this);" />

				</div> 

				<div class="col-sm-12">
				<label>Color</label>                                          
				<input class="form-control" type="text" id="search_color_balance" name="search_color_balance"  required="" readonly="" onKeyUp="mayus(this);" />

				</div>

				<div class="col-sm-12">
				<label>Modelo</label>                                          
				<input class="form-control" type="text" id="search_modelo_balance" name="search_modelo_balance" readonly="" />

				</div>

				<div class="col-sm-12">
				<label>Tipo de Unidad </label>                                          
				<input class="form-control" type="text" id="search_tipo_vin_balance" name="search_tipo_vin_balance"  readonly="" minlength="8" maxlength="8" onKeyUp="mayus(this);"  />
				</div>

				`;



			} else if (porciones_balance[1].trim() == "Visible") {

				$("#TitlaBalance").html("<i class='fas fa-trash fa-1.5x'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Eliminar Movimientos");

				$("#show_auxiliares_balance").hide();
				$("#mostrar_fechas_balance").hide();

			}





			$("#add_inputs_form_actions_balance").html(create_form_balance);

			$('#modal_formulario').modal('toggle');

		}



		function fecha_balance() {

			$('#fecha_balance').bootstrapMaterialDatePicker({
				date: true,
				time: false,
				shortTime: true,
				format: 'YYYY-MM-DD',
				lang: "es",
				cancelText: 'Cancelar',
				okText: 'Definir',
				maxDate: moment()

			});

		}



		function buscar_vin_dinamico(name_imput) {


			var textoBusquedaherramienta = $("#busqueda_vin_" + name_imput).val();

			let name_select = 'sugerencias_herramienta' + name_imput;

			if (textoBusquedaherramienta != "") {

				$.post("busqueda_vin_general_dinamico.php",

					{
						valorHerramienta: textoBusquedaherramienta,
						name_select: name_select
					},

					function(mensaje_herramienta) {

						$("#resultadoBusquedaVin_" + name_imput).show();
						$("#resultadoBusquedaVin_" + name_imput).html(mensaje_herramienta);


						if (mensaje_herramienta == " <b>VIN NO Encontrado</b>") {

							$("#search_vin_" + name_imput).attr("readonly", "readonly");
							$("#search_marca_" + name_imput).attr("readonly", "readonly");
							$("#search_version_" + name_imput).attr("readonly", "readonly");
							$("#search_color_" + name_imput).attr("readonly", "readonly");
							$("#search_modelo_" + name_imput).attr("readonly", "readonly");

						} else {

							$("#resultadoBusquedaVin" + name_imput).show();
							$("#search_vin_" + name_imput).attr("readonly", "readonly");
							$("#search_marca_" + name_imput).attr("readonly", "readonly");
							$("#search_version_" + name_imput).attr("readonly", "readonly");
							$("#search_color_" + name_imput).attr("readonly", "readonly");
							$("#search_modelo_" + name_imput).attr("readonly", "readonly");
						}

					});

			} else {

				$("#resultadoBusquedaVin_" + name_imput).html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');

			};


			$(document).on('click', '.sugerencias_herramienta' + name_imput, function(event) {
				event.preventDefault();
				aux_recibido = $(this).val();
				var porcion = aux_recibido.split(';');
				unidad_herramientavin = porcion[0];
				unidad_htvin = porcion[1];
				unidad_htmarca = porcion[2];
				unidad_htversion = porcion[3];
				unidad_htcolor = porcion[4];
				unidad_htmodelo = porcion[5];
				unidad_httipo = porcion[6];

				$("#resultadoBusquedaVin_" + name_imput).html("");
				$("#resultadoBusquedaVin_" + name_imput).hide();
				$("#busqueda_vin_" + name_imput).val("");
				$("#search_vin_" + name_imput).val(unidad_htvin);
				$("#search_marca_" + name_imput).val(unidad_htmarca);
				$("#search_version_" + name_imput).val(unidad_htversion);
				$("#search_color_" + name_imput).val(unidad_htcolor);
				$("#search_modelo_" + name_imput).val(unidad_htmodelo);
				$("#search_tipo_vin_" + name_imput).val(unidad_httipo);


			});

		}




		function LoadingFunctions() {


			//Balnce de Gastos de Operacion
			mostrarModalbalance();
			CallTableBalanceGastos();


		}



		function CallTableBalanceGastos() {

			var idl = '<?php echo $idc; ?>'

			$.ajax({

				type: "POST",
				url: "guardar_delete_balance_gastos.php",
				data: {
					idc: idl
				},
				success: function(datosbalancetable) {

					$("#AddTableBalance").html(datosbalancetable);

				}
			});
		}

		//------------------------------------------- INICIA agregar balance Gastos de Operacion --------------------------------------------------------------------------------	

		function AgregarNuevoBalance() {

			$('#modal_actions_clean').modal('toggle');
			$('#title_modal_actions_clean').empty();
			$('#title_modal_actions_clean').html("Agregar Nuevo Balance de Gastos de Operación");

			$("#add_opciones_modal_options").empty();

			var form_new_balance = `
			<form id="formBalanceGastosOperacion" action="#">

				<?php
				date_default_timezone_set('America/Mexico_City');
				$fecha_creacion_balance = date("Y-m-d H:i:s");
				?>

				<div class="row ">

					<div class="col-sm-12">
						<label>Auxiliar Principal</label>
						<div class="content-select">
							<select name="idauxiliar_principales" id="idauxiliar_principales" class="form-control">
								<option value="6">CCH Caja Chica</option>
								<option value="7">B2 BANORTE</option>
								<?php

								/*$query_aux_principal = "SELECT * FROM auxiliar_principales WHERE visible = 'SI'";
								$result_aux_principal = mysql_query($query_aux_principal);
								while ($row_aux_principal = mysql_fetch_array($result_aux_principal)) {
									echo "<option value='$row_aux_principal[idauxiliar_principales]'>$row_aux_principal[concepto]</option>";
								}*/

								?>
							</select>
							<i></i>
						</div>
							
					</div>
							
					<div class="col-sm-12">
						<label for="concepto">*Concepto</label>
						<div class="content-select">
							<select name="concepto" id="concepto" class="form-control" onchange="AccionesConceptoBalance();" required="">
								<?php
								$query_balance_concepto = "SELECT concepto FROM balance_gastos_operacion GROUP BY concepto order by concepto ASC";
								$result_balance_concepto = mysql_query($query_balance_concepto);
								while ($row_balance_concepto = mysql_fetch_array($result_balance_concepto)) {
									$concepto_minusculas = ucfirst(mb_strtolower($row_balance_concepto[concepto]));
									echo "<option value='$concepto_minusculas'>$concepto_minusculas</option>";
								}

								?>
							</select>
							<i></i>
						</div>
							
					</div>
							
					<div class="col-sm-4">
						<label>*Tipo</label>
						<div class="content-select">
							<select class="form-control" id="tipo_movimiento" name="tipo_movimiento" onchange="TipoMovimientoBalance();" required="">
								<option value="">Selecciona una opción ...</option>
								<option value="cargo">Cargo</option>
								<option value="abono">Abono</option>
							</select>
							
						</div>
					</div>
							
					<div class="col-sm-4">
						<label for="efecto_movimiento">Efecto</label>
						<input type="text" id="efecto_venta" name="efecto_venta" class="form-control" readonly="">
					</div>
					
					<div class="col-sm-4">
						<fieldset>
							<label class="mb-0 mr-2" for="fecha_movimiento">*Fecha</label>
							<input class="form-control" type="text" id="fecha_movimiento" name="fecha_movimiento" onclick="FechaBalanceMovimiento('fecha_movimiento');" required="" readonly >						
							</fieldset>
					</div>
					
				

					<div class="col-sm-12">
						<label for="busqueda_proveedor_requisicion">*Buscar Proveedor</label>
						<input placeholder="Buscar" class="form-control" type="text" name="busqueda_proveedor_requisicion" id="busqueda_proveedor_requisicion" value="" autocomplete="off" onKeyUp="buscar_proveedor_requisicion();" size="19" width="300%">
						<input type="hidden" name="idcatalogo_provedores" id="idcatalogo_provedores">
						<center>
							<div id="resultadoBusquedaProveedor_Requisicion" style="display: none;" class="container-busquedas-1 mt-4 efecto-busqueda"></div>
						</center>
					</div>
							
					<div class="col-sm-12 form-group" id="show_add_id_temporal" style="display: none;">
						<div class="alert alert-info" role="alert">
							A continuación se habilitara el formulario para que de de alta el <b>Proveedor</b>.
						</div>
					</div>
							
					<div class="col-sm-6">
						<label>Nombre</label>
						<input class="form-control" type="text" id="nombre_proveedor" name="nombre_proveedor" required="" readonly="" />
					</div>
							
					<div class="col-sm-6">
						<label>Apellidos</label>
						<input class="form-control" type="text" id="apellidos_proveedor" name="apellidos_proveedor" required="" readonly="" />
					</div>
							
					<div class="col-sm-12">
						<label>Alias</label>
						<textarea name="alias_proveedor" id="alias_proveedor" class="form-control" rows="3" readonly=""></textarea>
						<!-- <input class="form-control" type="text" id="alias_proveedor" name="alias_proveedor" required="" readonly="" /> -->
					</div>
							
					<div class="col-sm-6">
						<label>Teléfono</label>
						<input class="form-control" type="text" id="telefono_proveedor" name="telefono_proveedor" required="" readonly="" />
					</div>
							
					<div class="col-sm-6">
						<label>RFC</label>
						<input type="text" name="rfc_proveedor" class="form-control" id="rfc_proveedor" readonly="">
					</div>

					<div class="col-sm-12" id="ProveedorSelect" style="display: none;">
					<label><b>Guardar en :</b></label>
					<select id="SelectProveedor" class="form-control">
					<option value="Proveedor Temporal">Proveedor Temporal</option>
					<option value="Proveedor">Proveedor</option>
					</select>
					</div>
					
					<div class="col-sm-12">
						<label>Tipo</label>
						<input class="form-control" type="text" id="tipo_proveedor" name="tipo_proveedor" required="" readonly="" />
					</div>
					
					<div class="col-sm-12" id="show_guardar_temporal" style="display: none;">
					
						<center>
							<input type="button" class="btn btn-lg btn-primary" value="Guardar Temporal" onclick="guardar_temporal_balance();">
						</center>
						<br>
					</div>
							
				</div>
							
				<div class="row">
							
					<div class="col-sm-12">
						<label for="resp_balance_gastos">*Responsable</label>
						<div class="content-select">
							<select name="resp_balance_gastos" id="resp_balance_gastos" class="form-control" required="">
								<?php
								foreach ($array_responsable_balance as $key => $value_responsable) {
									$porciones_array_responsable = explode("|", $value_responsable);
									echo "<option value='$porciones_array_responsable[0]|$porciones_array_responsable[1]'>$porciones_array_responsable[2]</option>";
								}
								?>
							</select>
							<i></i>
						</div>
					</div>
							
					<div class="col-sm-12 my-4">
							
						<label for="auxiliar">¿ Agregar Nuevo auxiliar ?</label> <br>
						<label>SI</label>
						<input type="radio" class="radio1" name="nuevo_auxiliar" value="SI" onclick="AgregarAuxiliares('SI');" required=""> <br>
						<label>NO</label>
						<input type="radio" class="radio1" name="nuevo_auxiliar" value="NO" onclick="AgregarAuxiliares('NO');" required="">
					</div>
							
					<div id="show_balance_auxiliares" class="col-sm-12" style="display: none;">
							
						<div class="col-sm-12 field_add_auxiliar_individual" id="nuevosauxiliares">
							
						</div>
							
						<div class="col-sm-12 mt-4">
							<center>
								<a style='width: 180px;height: 90px;' class="icon-DOrden" class="" title="Add field"><i class='fa fa-plus-circle fa-5x zoom font-iconr' aria-hidden='true' onclick="ActionsAuxiliares()"></i></a>
								<div class="tooltipDetalleOrden mb-3">
									<p>Agregar Auxiliar</p>
								</div>
							</center>
						</div>
							
						<input id="indivudualauxiliar" type="hidden" value="0" readonly>
						<input id="count_input_aux" type="hidden" value="0" readonly>
							
					</div>
							
					<div class="col-sm-12">
						<label for="iddepartamento_balance">*Departamento</label>
						<div class="content-select">
							<select id="iddepartamento_balance" class="form-control" name="iddepartamento_balance" required="">
								<?php
								$sql4 = "SELECT * FROM catalogo_departamento WHERE idcatalogo_departamento = '$iddepartamento'";
								$result4 = mysql_query($sql4);

								while ($fila4 = mysql_fetch_array($result4)) {
									echo "<option value='" . "$fila4[idcatalogo_departamento]" . "'>" . "$fila4[nombre]" . "</option>";
								}
								?>
							</select>
							<i></i>
						</div>
							
					</div>
							
					<div class="col-sm-12">
						<label>*Método de pago</label>
						<div class="content-select">
							<select name="metodo_pago" id="metodo_pago" class="form-control">
								<option value="">Elige una opción…</option>
								<?php
								$sqlMdoPago = mysql_query("SELECT * FROM catalogo_metodos_pago");
								while ($mdoPago = mysql_fetch_row($sqlMdoPago)) {
									echo "<option value='" . $mdoPago[0] . "'>" . $mdoPago[1] . "</option>";
								}
								?>
							</select>
							<i></i>
						</div>
					</div>
							
					<div class="col-sm-4">
						<label>Saldo</label>
						<input class="form-control" type="text" id="saldo" name="saldo" value="0" readonly required="" />
					</div>
							
							
					<div class="col-sm-4">
						<label>Cantidad</label>
						<input class="form-control" type="text" id="monto_abono" name="monto_abono" onkeypress="return SoloNumeros(event);" required="" readonly="" />
					</div>
							
					<div class="col-sm-4">
						<label>Nuevo Saldo</label>
						<input class="form-control" type="text" id="saldo_nuevo" name="saldo_nuevo" readonly required="" />
					</div>
							
					<div class="col-lg-4">
						<label>*Tipo de Moneda</label>
						<div class="content-select">
							<select class="form-control" id="tipo_moneda1" name="tipo_moneda1" onchange="buscar_letras1();" required>
								<option value="">Elige una opción…</option>
								<option value="USD">USD</option>
								<option value="CAD">CAD</option>
								<option value="MXN">MXN</option>
							</select>
							<i></i>
						</div>
					</div>
							
					<div class="col-lg-4">
						<label>*Tipo de Cambio</label>
						<input class="form-control" type="text" id="tipo_cambio2" name="tipo_cambio2" required="" onkeypress="return SoloNumeros(event); TipoCambioBalance();" readonly>
					</div>
							
					<div class="col-lg-4">
						<label>*Monto Total</label>
						<input class="form-control" type="text" id="monto_entrada" name="monto_entrada" required="" onkeypress="return SoloNumeros(event);" onKeyUp="buscar_letras1();" onchange="MontototalBalance();">
					</div>
							
					<div class="col-lg-6" id="show_precio_unitario" style="display: none;">
						<label>*Precio Unitario</label>
						<input class="form-control" type="text" id="precio_unitario" name="precio_unitario" onkeypress="return SoloNumeros(event);" />
					</div>
							
					<div class="col-lg-6" id="show_precio_total_litros" style="display: none;">
						<label>*Litros</label>
						<input class="form-control" type="text" id="total_litros" name="total_litros" onkeypress="return SoloNumeros(event);" />
					</div>
							
							
							
					<div class="col-sm-12">
						<label>Monto Letra</label>
						<input type="text" class="form-control" id="letra1" name="letra" required readonly>
					</div>
							
					<div class="col-sm-12">
						<label>VIN</label>
						<div class="content-select">
							<select name="vin_venta" id="vin_venta" class="form-control">
							
								<?php

								$query_vin = "SELECT * FROM orden_logistica_unidades WHERE idorden_logistica = '$idc' and visible = 'SI'";
								$result_query_vin = mysql_query($query_vin);
								while ($row_query_vin = mysql_fetch_array($result_query_vin)) {
									$vin_result_query_vin = CutterVin($row_query_vin[vin]);


									echo "<option value='$vin_result_query_vin'>$vin_result_query_vin</option>";
								}

								?>
								<option value="N/A">N/A</option>
							</select>
							<i></i>
						</div>
					</div>
							
					<div class="col-sm-6">
						<label>*Institución Emisora</label>
						<div class="content-select">
							<select class="form-control" id="emisor_venta" name="emisor_venta" required>

								<option value="">Elige una opción…</option>
								<?php

								$consulta2 = mysql_query("SELECT nombre FROM bancos_emisores");
								while ($registro2 = mysql_fetch_row($consulta2)) {
									echo "<option value='" . $registro2[0] . "'>" . $registro2[0] . "</option>";
								}
								?>
								<option value="BROXEL">BROXEL</option>
								<option value="SI VALE SA DE CV">SI VALE SA DE CV</option>
								<option value="TAG ID DE MEXICO SA DE CV">TAG ID DE MEXICO SA DE CV</option>
							</select>
							<i></i>
						</div>
					</div>
							
					<div class="col-sm-6">
						<label>*Agente Emisor</label>
						<div class="content-select">
							<select class="form-control" id="agente_emisor_venta" name="agente_emisor_venta" required>
								<option value="">Elige una opción…</option>
							
								<div id="te">
									<?php

									$consulta2 = mysql_query("SELECT nombre,nomeclatura FROM catalogo_tesorerias");
									while ($registro2 = mysql_fetch_row($consulta2)) {
										echo "<option value='" . $registro2[1] . "'>" . $registro2[1] . " " . $registro2[0] . "</option>";
									}
									?>
									<option value="BROXEL">BROXEL</option>
								
									<option value="SI VALE SA DE CV">SI VALE SA DE CV</option>
								
									<option value="TAG ID DE MEXICO SA DE CV">TAG ID DE MEXICO SA DE CV</option>
								</div>
							</select>
							<i></i>
						</div>
					</div>
								
					<div class="col-sm-6">
						<label>*Institución Receptora</label>
						<div class="content-select">
							<select class="form-control" id="receptor_venta" name="receptor_venta" required>
								<option value="">Elige una opción…</option>
								
								<?php

								$consulta2 = mysql_query("SELECT nombre FROM bancos_emisores");
								while ($registro2 = mysql_fetch_row($consulta2)) {
									echo "<option value='" . $registro2[0] . "'>" . $registro2[0] . "</option>";
								}
								?>
								<option value="BROXEL">BROXEL</option>
								<option value="SI VALE SA DE CV">SI VALE SA DE CV</option>
								<option value="TAG ID DE MEXICO SA DE CV">TAG ID DE MEXICO SA DE CV</option>
							</select>
							<i></i>
						</div>
					</div>
							
					<div class="col-sm-6">
						<label>*Agente Receptor</label>
						<div class="content-select">
							<select class="form-control" id="agente_receptor_venta" name="agente_receptor_venta" required>
								<option value="">Elige una opción…</option>
							
								<?php

								$consulta2 = mysql_query("SELECT nombre,nomeclatura FROM catalogo_tesorerias");
								while ($registro2 = mysql_fetch_row($consulta2)) {
									echo "<option value='" . $registro2[1] . "'>" . $registro2[1] . " " . $registro2[0] . "</option>";
								}
								?>
								<option value="BROXEL">BROXEL</option>
								<option value="SI VALE SA DE CV">SI VALE SA DE CV</option>
								<option value="TAG ID DE MEXICO SA DE CV">TAG ID DE MEXICO SA DE CV</option>
							</select>
							<i></i>
						</div>
					</div>
							
					<div class="col-sm-12">
						<label>¿Cuenta con Tarjeta ? </label><label id="respuesta_tarjeta"></label>
						<label>SI</label>
						<input type="radio" class="radio1" name="lleva_vin" required="" onclick="card_show('SI');">
						<label>NO</label>
						<input type="radio" class="radio1" name="lleva_vin" required="" onclick="card_show('NO');">
					</div>
							
					<div class="col-sm-12" style="display: none;" id="search_card">
						<label>Buscar Tarjeta</label>
							
						<input placeholder="Buscar" class="form-control" type="text" name="busqueda_tarjeta" id="busqueda_tarjeta" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_tarjeta();" size="19" width="300%">
						<center>
							<div id="resultadoBusquedaTarjeta" style="display: none" class="mt-4"></div>
						</center>
					</div>
							
					<div class="col-sm-12">
						<label for="number_card">Número de Tarjeta</label>
						<div class="content-select">
							<select name="number_card" class="form-control" id="number_card">
								<option value="N/A">N/A</option>
							</select>
							<i></i>
						</div>
					</div>
							
					<div class="col-sm-4">
						<label>Tipo de Comprobante</label>
						<div class="content-select">
							<select class="form-control" id="comprobante_venta" name="comprobante_venta" required>
								<option value="">Elige una opción…</option>
								<?php

								$consulta2 = mysql_query("SELECT nombre FROM catalogo_comprobantes where  nombre = 'Recibo Automático' || nombre = 'Factura' || nombre = 'N/A' || nombre = 'Boucher' || nombre = 'Nota de Remisión' || nombre = 'Ticket'");
								while ($registro2 = mysql_fetch_row($consulta2)) {
									echo "<option value='" . $registro2[0] . "'>" . $registro2[0] . "</option>";
								}
								?>
							</select>
							<i></i>
						</div>
							
					</div>
							
					<div class="col-sm-4">
						<label>Factura/Nota de Remisión</label>
						<input class="form-control" type="text" id="factura" onKeyUp=" mayus(this);" name="factura" required="" />
					</div>
							
					<div class="col-sm-4">
						<label>Número de Referencia</label>
						<input class="form-control" type="text" id="n_referencia_venta" name="n_referencia_venta" onKeyUp=" mayus(this);" required="" readonly="" value="<?php echo "L" . $id_contacto_completo ?>" />
					</div>
							
					<div class="col-sm-12">
						<label>Comentarios:</label>
						<textarea class="form-control" rows="2" id="descripcion_venta" name="descripcion_venta" maxlength="8950" required=""></textarea>
					</div>
							
					<div class="col-sm-12">
						<label>¿Quieres Agregar el Abono Automáticamente ? </label><label id="respuesta_tarjeta"></label>
						<label>SI</label>
						<input type="radio" class="radio1" name="abono_automatico" value="SI" onclick="abono1();" required="">
						<label">NO</label>
						<input type="radio" class="radio1" name="abono_automatico" value="NO" onclick="abono2();" required="">
					</div>
							
					<div class="col-sm-12" id="show_recibo" style="display: none;">
							
						<label>¿Quieres Agregar Recibo Automático ?</label>
						<label for="reciboautomatico1">SI</label>
						<input type="radio" class="reciboautomatico1 radio1" id="reciboautomatico1" name="recibo_automatico" value="SI" required="">
						<label for="reciboautomatico2">NO</label>
						<input type="radio" class="reciboautomatico2 radio1" id="reciboautomatico2" name="recibo_automatico" value="NO" required="">
							
					</div>
							
					<input type="hidden" name="idorden_logistica_requisicion" id="idorden_logistica_requisicion" value='<?php echo "$recibido"; ?>'>
					<input type="hidden" name="fecha_creacion_balance" value='<?php echo "$fecha_creacion_balance"; ?>'>
					<input type="hidden" name="fols" id="fols" value='<?php echo "$fol"; ?>'>
							
				</div>
							
				<div class="col-sm-12">
					<center>
						<button type="button" class="btn btn-primary btn-lg" id="guardar_actions" onclick="enviar_balance_gastos();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
					</center>
				</div>
							
				</form>
			
			`;

			$("#add_opciones_modal_options").html(form_new_balance);


		}


		//------------------------------------------- Inician las Funciones de Balance de gastos --------------------------------------------------------------------------------	

		function AccionesConceptoBalance() {

			var valor_concepto = $("#concepto").val();

			if (valor_concepto == "CARGA DE COMBUSTIBLE" || valor_concepto == "Carga de combustible") {

				$("#show_precio_unitario").show();
				$("#precio_unitario").val("");
				$("#precio_unitario").attr("required", "required");

				$("#show_precio_total_litros").show();
				$("#total_litros").val("");
				$("#total_litros").attr("required", "required");


			} else {

				$("#show_precio_unitario").hide();
				$("#precio_unitario").val("");
				$("#precio_unitario").removeAttr("required", "required");

				$("#show_precio_total_litros").hide();
				$("#total_litros").val("");
				$("#total_litros").removeAttr("required", "required");

			}
		}

		//------------------------------------------- Inician las Funciones de Balance de gastos --------------------------------------------------------------------------------	

		function TipoMovimientoBalance() {

			if ($("#tipo_movimiento").val() == "cargo") {

				$("#efecto_venta").val("suma");

			} else if ($("#tipo_movimiento").val() == "abono") {

				$("#efecto_venta").val("resta");

			} else {

				$("#efecto_venta").val("");
			}

		}

		//------------------------------------------- Fecha de Movimiento --------------------------------------------------------------------------------



		function FechaBalanceMovimiento(valor) {


			$('#' + valor).pickadate({
				// Strings and translations
				monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Otu', 'Nov', 'Dic'],
				weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
				weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
				showMonthsShort: false,
				showWeekdaysFull: false,
				// Buttons
				today: 'Hoy',
				clear: 'Limpiar',
				close: 'Cerrar',
				// Accessibility labels
				labelMonthNext: 'Siguiente Mes',
				labelMonthPrev: 'Anterior Mes',
				labelMonthSelect: 'Selecciona un mes',
				labelYearSelect: 'Selecciona un año',
				// Formats
				format: 'yyyy-mm-dd',
				selectMonths: true,
				selectYears: true,

				// Date limits
				max: +1,



			});


			$("#" + valor).data('pickadate').open();

			event.stopPropagation();
			event.preventDefault();


		}

		$('#fecha_movimiento').pickadate({
			containerHidden: '#hidden-input-outlet'
		});


		//------------------------------------------- Buscar Proveedor --------------------------------------------------------------------------------

		function buscar_proveedor_requisicion() {

			var textoBusquedaProveedor = $("#busqueda_proveedor_requisicion").val();
			var name_sugerencia = "sugerencias_proveedor_balance";

			if (textoBusquedaProveedor != "") {

				$.post("buscar_id_colaborador_completo.php", {
					valorBusqueda: textoBusquedaProveedor,
					tipoBusqueda: "ProveedorSI",
					name_sugerencia: name_sugerencia
				}, function(mensaje_proveedor_balance) {

					$("#resultadoBusquedaProveedor_Requisicion").show();
					$("#resultadoBusquedaProveedor_Requisicion").html(mensaje_proveedor_balance);

					if (mensaje_proveedor_balance.trim() == "<b>ID NO Encontrado</b>") {

						$("#show_add_id_temporal").show();
						$("#show_guardar_temporal").show();

						$("#idcatalogo_provedores").val("");

						$("#nombre_proveedor").val("");
						$("#nombre_proveedor").removeAttr("readonly", "readonly");

						$("#apellidos_proveedor").val("");
						$("#apellidos_proveedor").removeAttr("readonly", "readonly");

						$("#rfc_proveedor").val("");
						$("#rfc_proveedor").removeAttr("readonly", "readonly");

						$("#alias_proveedor").val("");
						$("#alias_proveedor").removeAttr("readonly", "readonly");

						$("#telefono_proveedor").val("");
						$("#telefono_proveedor").removeAttr("readonly", "readonly");
						$("#ProveedorSelect").show();

					} else {


						$("#show_add_id_temporal").hide();
						$("#show_guardar_temporal").hide();

						$("#idcatalogo_provedores").val("");

						$("#nombre_proveedor").val("");
						$("#nombre_proveedor").attr("readonly", "readonly");

						$("#apellidos_proveedor").val("");
						$("#apellidos_proveedor").attr("readonly", "readonly");

						$("#rfc_proveedor").val("");
						$("#rfc_proveedor").attr("readonly", "readonly");

						$("#alias_proveedor").val("");
						$("#alias_proveedor").attr("readonly", "readonly");

						$("#telefono_proveedor").val("");
						$("#telefono_proveedor").attr("readonly", "readonly");
						$("#ProveedorSelect").hide();

					}
				});
			} else {
				$("#resultadoBusquedaProveedor_Requisicion").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
			};
		}

		$(document).on('click', '.sugerencias_proveedor_balance', function(event) {
			event.preventDefault();
			aux_recibido = $(this).val();
			var porcion = aux_recibido.split(';');
			var name_prov = porcion[1].trim();
			var last_prov = porcion[2].trim();
			var name_last = name_prov + " " + last_prov;
			var name_concat = name_last.trim();

			$("#busqueda_proveedor_requisicion").val("");
			$("#idcatalogo_provedores").val(porcion[0]);
			$("#nombre_proveedor").val(porcion[1]);
			$("#apellidos_proveedor").val(porcion[2]);
			$("#alias_proveedor").val(porcion[3]);
			$("#tipo_proveedor").val(porcion[4]);
			$("#rfc_proveedor").val(porcion[5]);
			$("#resultadoBusquedaProveedor_Requisicion").html("");
			$("#resultadoBusquedaProveedor_Requisicion").hide();

			if (name_concat != "CCH" && name_concat != "Caja Chica" && name_concat != "TP1" && name_concat != "CAJA CHICA" && name_concat != "PANAMOTORS CENTER SA DE CV" && name_concat != "") {

				$("#emisor_venta").prepend(`<option value="${name_concat}"> ${name_concat}</option>`);
				$("#agente_emisor_venta").prepend(`<option value="${name_concat}">${name_concat}</option>`);
				$("#receptor_venta").prepend(`<option value="${name_concat}">${name_concat}</option>`);
				$("#agente_receptor_venta").prepend(`<option value="${name_concat}">${name_concat}</option>`);

			}
		});
		//------------------------------------------- Guardar  Proveedor --------------------------------------------------------------------------------	

		function guardar_temporal_balance() {

			var nombre_proveedor = $("#nombre_proveedor").val();
			var apellidos_proveedor = $("#apellidos_proveedor").val();
			var rfc_proveedor = $("#rfc_proveedor").val();
			var alias_proveedor = $("#alias_proveedor").val();
			var telefono_proveedor = $("#telefono_proveedor").val();
			var tipo_proveedor = $("#SelectProveedor").val();

			var fecha_creacion_proveedor = TiempoAhora();

			$.ajax({
				url: 'agregar_proveedor.php',
				data: {
					nombre_proveedor: nombre_proveedor,
					apellidos_proveedor: apellidos_proveedor,
					rfc_proveedor: rfc_proveedor,
					alias_proveedor: alias_proveedor,
					telefono_celular_proveedor: telefono_proveedor,
					tipo_proveedor: tipo_proveedor,
					fecha_creacion_proveedor
				},
				type: 'POST',
				success: function(json) {
					console.log(json);
					var porcionestemporal = json.split('|');

					if (porcionestemporal[0] >= 0) {

						$("#show_add_id_temporal").hide();
						$("#show_guardar_temporal").hide();
						$("#busqueda_proveedor_requisicion").val("");

						$("#nombre_proveedor").attr("readonly", "readonly");
						$("#apellidos_proveedor").attr("readonly", "readonly");
						$("#rfc_proveedor").attr("readonly", "readonly");
						$("#alias_proveedor").attr("readonly", "readonly");
						$("#telefono_proveedor").attr("readonly", "readonly");
						$("#ProveedorSelect").show();

						$("#idcatalogo_provedores").val(porcionestemporal[12]);
						$("#nombre_proveedor").val(porcionestemporal[1]);
						$("#apellidos_proveedor").val(porcionestemporal[2]);
						$("#alias_proveedor").val(porcionestemporal[3]);
						$("#telefono_proveedor").val(porcionestemporal[4]);
						$("#tipo_proveedor").val(porcionestemporal[11]);
						$("#rfc_proveedor").val(porcionestemporal[13]);

						var res_sin = porcionestemporal[1] + " " + porcionestemporal[2];
						var res = res_sin.trim();

						$("#emisor_venta").prepend(`<option value="${res}"> ${res}</option>`);
						$("#agente_emisor_venta").prepend(`<option value="${res}">${res}</option>`);
						$("#receptor_venta").prepend(`<option value="${res}">${res}</option>`);
						$("#agente_receptor_venta").prepend(`<option value="${res}">${res}</option>`);

						$("#emisor_venta").append("<option value='" + res + "' >" + res + "</option>");
						$("#agente_emisor_venta").append("<option value='" + res + "' >" + res + "</option>");
						$("#receptor_venta").append("<option value='" + res + "' >" + res + "</option>");
						$("#agente_receptor_venta").append("<option value='" + res + "' >" + res + "</option>");




					} else {

						$(".error-form").show();
						$(".text-error").html(json);

						setTimeout(function() {
							$(".error-form").fadeOut(1000);
						}, 1500);
					}

				},


				error: function(xhr, status) {
					// alert('Disculpe, existió un problema');
					$(".error-form").show();
					$(".text-error").html("Disculpe, existió un problema");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
				}
			});


		}



		//------------------------------------------- Visulaizar Agregar N Auxiliares --------------------------------------------------------------------------------	

		function AgregarAuxiliares(valor) {

			if (valor === "SI") {

				$("#nuevosauxiliares").empty();
				$("#show_balance_auxiliares").show();
				$("#indivudualauxiliar").val("0");
				$("#count_input_aux").val("0");

			} else {

				$("#nuevosauxiliares").empty();
				$("#show_balance_auxiliares").hide();
				$("#indivudualauxiliar").val("0");
				$("#count_input_aux").val("0");

			}
		}

		//------------------------------------------- Agregar N Auxiliares --------------------------------------------------------------------------------

		function ActionsAuxiliares() {


			var addButtonAuxiliar = $('.create_aux_individual');
			var wrapper_auxiliar_individual = $('.field_add_auxiliar_individual');

			var obtener_count_aux_individual = $("#count_input_aux").val();


			var add_coun_aux_individual = parseInt(obtener_count_aux_individual, 10) + 1;
			$("#count_input_aux").val(add_coun_aux_individual);

			var obtener_aux_individual = $("#indivudualauxiliar").val();

			if (obtener_aux_individual == 0) {

				var contador_aux = 1;

			} else {

				if ($.isNumeric(obtener_aux_individual) == true) {

					var contador_aux = parseInt(obtener_aux_individual, 10) + 1;

				} else {

					var cortar = obtener_aux_individual.substr(0, 1);

					var contador_aux = parseInt(obtener_aux_individual, 10) + 1;

				}
			}

			$("#indivudualauxiliar").val(contador_aux);

			var fieldHTMLAuxIndividual = `
				<div class="row mt-4 mb-4 container-title-line">

				<div class="col-sm-12">
				<label class="col-form-label">*Auxiliar:</label>
				<input type="text" class="form-control" name="auxiliares_balance_gastos[]" required list="show_balance_gastos_auxiliares">

				<datalist id="show_balance_gastos_auxiliares">
				<?php echo $show_auxiliares; ?>
				</datalist>
				</div>

				<a class="button-eliminar remove_button mt-4 mb-4">
				<span>Eliminar</span><i class="fas fa-trash"></i>
				</a>


				</div>

				`;

			$(wrapper_auxiliar_individual).append(fieldHTMLAuxIndividual);

			$(wrapper_auxiliar_individual).on('click', '.remove_button', function(e) {
				e.preventDefault();
				$(this).parent('div').remove();

				var obteneroriginalaux = $("#indivudualauxiliar").val();

				$("#indivudualauxiliar").val(obteneroriginalaux);

				var disminuir_count_aux = $("#count_input_aux").val();
				var nuewcount_individual_aux = parseInt(disminuir_count_aux, 10) - 1;
				$("#count_input_aux").val(nuewcount_individual_aux);

				if (nuewcount_individual_aux == 0) {
					$("#indivudualauxiliar").val("0");
				}

			});

		}


		//------------------------------------------- Operacions Balance de gastos --------------------------------------------------------------------------------
		function buscar_letras1() {

			var cambio1 = "19.50";
			var cambio2 = "15.20";
			var cambio3 = "1";
			var nada = "0";

			var valor = $("#tipo_moneda1").val();

			if (valor == 'USD') {

				$("#tipo_cambio2").val(parseFloat(cambio1));
				$('#tipo_cambio2').prop('readonly', false);

			} else if (valor == 'CAD') {
				$("#tipo_cambio2").val(parseFloat(cambio2));
				$('#tipo_cambio2').prop('readonly', false);

			} else if (valor == 'MXN') {
				$("#tipo_cambio2").val(parseFloat(cambio3));
				$('#tipo_cambio2').prop('readonly', true);

			} else if (valor == '') {
				$("#tipo_cambio2").val(parseFloat(0));

			}
			///
			var textoletras = $("#monto_entrada").val();
			var tipo = $("#tipo_moneda1").val();

			if (textoletras != "") {
				$.post("buscar_letras_documentacion.php", {
					valorBusqueda: textoletras,
					valortipo: tipo
				}, function(mensaje_letras) {

					$("#letra1").val(mensaje_letras);

				});
			} else {
				$("#letra1").val('');
			}
			///////////////////////////////////
			tipo_cambio = $("#tipo_cambio2").val();
			monto_entrada = $("#monto_entrada").val();

			monto_entrada = parseFloat(monto_entrada);
			tipo_cambio = parseFloat(tipo_cambio);
			total = monto_entrada * tipo_cambio;


			$("#monto_abono").val(total);
			//////////

			monto_capturado = $("#monto_abono").val();
			saldo_pendiente = $("#saldo").val();
			operacion = $("#efecto_venta").val();
			var calculo = "";
			monto_genereral_cifra = $("#monto_general").val(monto_capturado);




			if (operacion == "") {


				$(".error-form").show();
				$(".text-error").html("No se ha definido un efecto para la operación (Positivo, Negativo), imposible hacer el cálculo");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#monto_abono").val("");
				$("#saldo_nuevo").val("");
			}

			if (operacion == "suma") {
				calculo = parseFloat(saldo_pendiente) + parseFloat(monto_capturado);

				$("#saldo_nuevo").val(calculo);
			}

			if (operacion == "resta") {
				calculo = parseFloat(saldo_pendiente) - parseFloat(monto_capturado);

				$("#saldo_nuevo").val(calculo);
			}



		}

		function MontototalBalance() {

			tipo_cambio = $("#tipo_cambio2").val();
			monto_entrada = $("#monto_entrada").val();

			monto_entrada = parseFloat(monto_entrada);
			tipo_cambio = parseFloat(tipo_cambio);
			total = monto_entrada * tipo_cambio;


			$("#monto_abono").val(total);

			monto_capturado = $("#monto_abono").val();
			saldo_pendiente = $("#saldo").val();
			operacion = $("#efecto_venta").val();

			monto_genereral_cifra = $("#monto_general").val(monto_capturado);




			if (operacion == "") {

				$(".error-form").show();
				$(".text-error").html("No se ha definido un efecto para la operación (Positivo, Negativo), imposible hacer el cálculo");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#monto_abono").val("");
				$("#saldo_nuevo").val("");
			} else if (operacion == "suma") {
				calculo = parseFloat(saldo_pendiente) + parseFloat(monto_capturado);
			} else if (operacion == "resta") {
				calculo = parseFloat(saldo_pendiente) - parseFloat(monto_capturado);
			}



			saldo_calculo = $("#saldo_nuevo").val(calculo);
		}

		function TipoCambioBalance() {

			tipo_cambio = $("#tipo_cambio2").val();
			monto_entrada = $("#monto_entrada").val();

			monto_entrada = parseFloat(monto_entrada);
			tipo_cambio = parseFloat(tipo_cambio);
			total = monto_entrada * tipo_cambio;


			$("#monto_abono").val(total);

		}

		// Tarjeta
		function card_show(valor) {

			if (valor == "SI") {

				$("#search_card").show();

			} else if (valor == "NO") {

				$("#search_card").hide();
				$(".optionnumbercard").remove();
			}

		}

		function abono1() {

			if ($(".abono1").is(':checked')) {
				$("#show_recibo").show();
				$("#reciboautomatico1").attr('checked', false);
				$("#reciboautomatico2").attr('checked', false);
			}

		}

		function abono2() {

			if ($(".abono2").is(':checked')) {
				$("#show_recibo").hide();
				$("#reciboautomatico2").attr('checked', true);
			}

		}



		function enviar_balance_gastos() {

			//Auxiliar principal auxiliar
			if ($("#idauxiliar_principales").val() == "") {

				$("#idauxiliar_principales").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El Auxiliar Principal encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#idauxiliar_principales").focus();
				return false;
			} else {

				$("#idauxiliar_principales").css("border-color", "#e5e6e7");
			}

			// Concepto
			if ($("#concepto").val() == "") {
				$("#concepto").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Concepto se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#concepto").focus();
				return false;
			} else {
				$("#concepto").css("border-color", "#e5e6e7");
			}



			if ($("#tipo_movimiento").val() == "") {
				$("#tipo_movimiento").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Tipo se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#tipo_movimiento").focus();
				return false;
			} else {
				$("#tipo_movimiento").css("border-color", "#e5e6e7");
			}

			if ($("#fecha_movimiento").val() == "") {
				$("#fecha_movimiento").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Fecha se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#fecha_movimiento").focus();
				return false;
			} else {
				$("#fecha_movimiento").css("border-color", "#e5e6e7");
			}

			if ($("#idcatalogo_provedores").val() == "") {
				$("#busqueda_proveedor_requisicion").css("border-color", "red");
				$("#nombre_proveedor").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("Se debe de agregar el <b>Proveedor</b>");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#busqueda_proveedor_requisicion").focus();
				return false;
			} else {
				$("#nombre_proveedor").css("border-color", "#e5e6e7");
			}


			if ($("#iddepartamento_balance").val() == "") {
				$("#iddepartamento_balance").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Departamento se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#iddepartamento_balance").focus();
				return false;
			} else {
				$("#iddepartamento_balance").css("border-color", "#e5e6e7");
			}

			if ($("#metodo_pago").val() == "") {
				$("#metodo_pago").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Método de pago se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#metodo_pago").focus();
				return false;
			} else {
				$("#metodo_pago").css("border-color", "#e5e6e7");
			}

			if ($("#tipo_moneda1").val() == "") {
				$("#tipo_moneda1").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Tipo de Moneda se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#tipo_moneda1").focus();
				return false;
			} else {
				$("#tipo_moneda1").css("border-color", "#e5e6e7");
			}

			if ($("#monto_entrada").val() == "") {
				$("#monto_entrada").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Monto se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#monto_entrada").focus();
				return false;
			} else {
				$("#monto_entrada").css("border-color", "#e5e6e7");
			}

			if ($("#emisor_venta").val() == "") {
				$("#emisor_venta").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Institución Emisora se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#emisor_venta").focus();
				return false;
			} else {
				$("#emisor_venta").css("border-color", "#e5e6e7");
			}

			if ($("#agente_emisor_venta").val() == "") {
				$("#agente_emisor_venta").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Agente Emisor se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#agente_emisor_venta").focus();
				return false;
			} else {
				$("#agente_emisor_venta").css("border-color", "#e5e6e7");
			}

			if ($("#receptor_venta").val() == "") {
				$("#receptor_venta").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Institución Receptora se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#receptor_venta").focus();
				return false;
			} else {
				$("#receptor_venta").css("border-color", "#e5e6e7");
			}

			if ($("#agente_receptor_venta").val() == "") {
				$("#agente_receptor_venta").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Agente Receptor se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#agente_receptor_venta").focus();
				return false;
			} else {
				$("#agente_receptor_venta").css("border-color", "#e5e6e7");
			}

			if ($("#comprobante_venta").val() == "") {
				$("#comprobante_venta").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Tipo de Comprobante se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#comprobante_venta").focus();
				return false;
			} else {
				$("#comprobante_venta").css("border-color", "#e5e6e7");
			}

			if ($("#comprobante_venta").val() == "") {
				$("#comprobante_venta").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Tipo de Comprobante se encueentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#comprobante_venta").focus();
				return false;
			} else {
				$("#comprobante_venta").css("border-color", "#e5e6e7");
			}

			if ($("#n_referencia_venta").val() == "") {
				$("#n_referencia_venta").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Número de Referencia se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#n_referencia_venta").focus();
				return false;
			} else {
				$("#n_referencia_venta").css("border-color", "#e5e6e7");
			}

			if ($("#factura").val() == "") {
				$("#factura").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Factura se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#factura").focus();
				return false;
			} else {
				$("#factura").css("border-color", "#e5e6e7");
			}

			if ($("#descripcion_venta").val() == "") {
				$("#descripcion_venta").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("El campo Comentarios se encuentra vacío");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#descripcion_venta");
				return false;
			} else {
				$("#descripcion_venta").css("border-color", "#e5e6e7");
			}

			var idorden_logistica_requisicion = $("#idorden_logistica_requisicion").val();
			var idauxiliar_principales = $("#idauxiliar_principales").val();
			var concepto = $("#concepto").val();
			var tipo_movimiento = $("#tipo_movimiento").val();
			var efecto_venta = $("#efecto_venta").val();
			var fecha_movimiento = $("#fecha_movimiento").val();
			var idcatalogo_provedores = $("#idcatalogo_provedores").val();
			var resp_balance_gastos = $("#resp_balance_gastos").val();


			var input = document.getElementsByName('auxiliares_balance_gastos[]');
			var auxiliares = [];

			for (var i = 0; i < input.length; i++) {
				var a = input[i];
				a.value;

				auxiliares.push(a.value);

			}




			var iddepartamento_balance = $("#iddepartamento_balance").val();
			var metodo_pago = $("#metodo_pago").val();
			var tipo_moneda1 = $("#tipo_moneda1").val();
			var tipo_cambio2 = $("#tipo_cambio2").val();
			var monto_entrada = $("#monto_entrada").val();
			var saldo = $("#saldo").val();
			var saldo_nuevo = $("#saldo_nuevo").val();
			var monto_abono = $("#monto_abono").val();
			var vin_venta = $("#vin_venta").val();
			var emisor_venta = $("#emisor_venta").val();
			var agente_emisor_venta = $("#agente_emisor_venta").val();
			var receptor_venta = $("#receptor_venta").val();
			var agente_receptor_venta = $("#agente_receptor_venta").val();
			var number_card = $("#number_card").val();
			var comprobante_venta = $("#comprobante_venta").val();
			var factura = $("#factura").val();
			var n_referencia_venta = $("#n_referencia_venta").val();
			var descripcion_venta = $("#descripcion_venta").val();
			var fecha_creacion = TiempoAhora();
			var precio_unitario = $("#precio_unitario").val();
			var total_litros = $("#total_litros").val();
			var idorden_logistica_combustible_archivo = $("#idorden_logistica_combustible_archivo").val();
			var abono_automatico = $('input[name="abono_automatico"]:checked').val();
			var recibo_automatico = $('input[name="recibo_automatico"]:checked').val();

			//console.log(auxiliares);

			var formData = new FormData();

			formData.append('idorden_logistica_requisicion', idorden_logistica_requisicion);
			formData.append('idauxiliar_principales', idauxiliar_principales);
			formData.append('concepto', concepto);
			formData.append('tipo_movimiento', tipo_movimiento);
			formData.append('efecto_venta', efecto_venta);
			formData.append('fecha_movimiento', fecha_movimiento);
			formData.append('idcatalogo_provedores', idcatalogo_provedores);
			formData.append('resp_balance_gastos', resp_balance_gastos);

			formData.append('auxiliares_balance_gastos', auxiliares);

			formData.append('iddepartamento_balance', iddepartamento_balance);
			formData.append('metodo_pago', metodo_pago);
			formData.append('tipo_moneda1', tipo_moneda1);
			formData.append('tipo_cambio2', tipo_cambio2);
			formData.append('monto_entrada', monto_entrada);
			formData.append('saldo', saldo);
			formData.append('saldo_nuevo', saldo_nuevo);
			formData.append('monto_abono', monto_abono);
			formData.append('vin_venta', vin_venta);
			formData.append('emisor_venta', emisor_venta);
			formData.append('agente_emisor_venta', agente_emisor_venta);
			formData.append('receptor_venta', receptor_venta);
			formData.append('agente_receptor_venta', agente_receptor_venta);
			formData.append('number_card', number_card);
			formData.append('comprobante_venta', comprobante_venta);
			formData.append('factura', factura);
			formData.append('n_referencia_venta', n_referencia_venta);
			formData.append('descripcion_venta', descripcion_venta);
			formData.append('fecha_creacion_balance', fecha_creacion);
			formData.append('precio_unitario', precio_unitario);
			formData.append('total_litros', total_litros);
			formData.append('idorden_logistica_combustible_archivo', idorden_logistica_combustible_archivo);
			formData.append('abono_automatico', abono_automatico);
			formData.append('recibo_automatico', recibo_automatico);







			//Display the values
			// for (var value of formData.values()) {
			// 	console.log(value);
			// }


			//return false;

			$.ajax({

				type: "POST",
				url: "guardar_balance_gastos_operacion.php",
				data: formData,
				processData: false,
				contentType: false,
				cache: false,
				beforeSend: function() {
					$(".container-loading-ajax").show();
				},
				success: function(mensaje_balance_gastos) {


					if (mensaje_balance_gastos.trim() == "1") {

						$('#modal_actions_clean').modal('hide');
						$('#title_modal_actions_clean').empty();
						$("#add_opciones_modal_options").empty();

						$(".listo-form").show();
						$(".text-listo").html("<b>Datos Guardados Correctamente</b>");

						setTimeout(function() {
							$(".listo-form").fadeOut(2000);
						}, 1500);

					} else {

						$(".error-form").show();
						$(".text-error").html(mensaje_balance_gastos);

						setTimeout(function() {
							$(".error-form").fadeOut(1000);
						}, 1500);

					}

					$(".container-loading-ajax").hide();

					CallTableBalanceGastos();
				},
				error: function(xhr, status) {

					$(".error-form").show();
					$(".text-error").html("Disculpe, existió un problema");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);

				}
			});

		}
	</script>





</body>

</html>