<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado=date("Y-m-d H:i:s");
$usuario_creador=$_SESSION['usuario_clave'];
$usuario_loguin=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

$random = rand(5, 15);
?>

<!doctype html>
	<html lang="es"> 

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Guardar Documentación</title>

		<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
		<link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="../../css/animate.css" rel="stylesheet">
		<link href="../../css/style.css" rel="stylesheet">
		<link rel="stylesheet" href="../../assets/css/styles_neumorphism_alert.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
		<link href="../../css/tics.css" rel="stylesheet">

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
		<link rel="icon" type="image/png" sizes="192x192"  href="../../img/favicon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="../../img/favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="../../img/favicon/favicon-16x16.png">
		<link rel="manifest" href="../../img/favicon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="../../img/favicon/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">

		<!-- DataTables CSS -->
		<link href="../../plugins/datatables/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

		<!-- DataTables Responsive CSS -->
		<link href="../../plugins/datatables/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="../../plugins/datatables/dist/css/sb-admin-2.css" rel="stylesheet">

		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

	</head>

	<body>

		<div class="neu-container-page" style="overflow: auto;">
			<div>   

				<div class="neu-container-general neu-animation-container">

					<div class="d-flex justify-content-center">
						<img class="neu-logo" src="../../img/GRUPOPANAMOTORSPLATA.png" alt="">
					</div>

					<div class="d-flex justify-content-center">
						<div id="success_alert" class="neu-container-alert mt-4" style="display: none;">
							<div class="d-flex justify-content-center align-items-center neu-alert neu-alert-correcto">
								<h1 class="text-center text-white mb-0">Documentación agregada exitosamente</h1>
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-center">
						<div id="fail_alert" class="neu-container-alert mt-4" style="display: none;">
							<div class="d-flex justify-content-center align-items-center neu-alert neu-alert-error">		
								<h1 class="text-center text-white mb-0">Se ha producido un error al guardar la información</h1>
							</div>
						</div>			
					</div>

					<div class="d-flex justify-content-center">
						<div id="alert_alert" class="neu-container-alert mt-4" style="display: none;">
							<div class="neu-alert neu-alert-error-tipo">
								<h4 class="text-center text-white mb-0">Error al: </h4>
							</div>
						</div>
					</div>

					<div id="content-contador" class="mt-4">
						<div class="content-contador d-flex justify-content-center align-items-center">
							<div class="contador text-center">
								<p class="text-redirigir mb-0">Seras redirigido en</p>
								<span class="numero-contador">0</span>
							</div>
						</div>				
					</div>

				</div> 



				<!-- <center>
					<div class="alert alert-success" role="alert" id="success_alert" style="display: none;">
						<h1>Documentación Agregada EXITOSAMENTE</h1>
					</div>

					<div class="alert alert-info" role="alert" id="alert_alert" style="display: none;">
						<h4>Error al:</h4>
					</div>
				</center>   -->

			</div>
		</div>
		<?php 

		$idorden_logistica = base64_decode($_POST['idorden_logistica']);
		$idlogistica_encriptada = $_POST['idorden_logistica'];
		$vin_documentacion = trim($_POST['vin_documentacion']);

		$monto_entrada = trim($_POST['monto_entrada_documentacion']);
		$tipo_moneda = (trim($_POST['tipo_moneda_documentacion']) == "") ? "MXN" : trim($_POST['tipo_moneda_documentacion']);
		$tipo_cambio = (trim($_POST['tipo_cambio_documentacion']) == "") ? "1" : trim($_POST['tipo_cambio_documentacion']);
		$gran_total = (trim($_POST['gran_total_documentacion']) == "") ? $monto_entrada : trim($_POST['gran_total_documentacion']);		


		$id_contacto_documentacion = trim($_POST['id_contacto_documentacion']);
		$tipo_contacto_documentacion = trim($_POST['tipo_contacto_documentacion']);

		$idempleado_documentacion = trim($_POST['idempleado_documentacion']);
		$tipoempleado_documentacion = trim($_POST['tipoempleado_documentacion']);

		$tipo = $_POST['tipo'];
		$otro_tipo = $_POST['otro_tipo'];

		if ($_POST['tipo'] == "Otro Tipo") {
			$tipo = $otro_tipo;
		}else{
			$tipo = $tipo;
		}


		$documento = $_POST['documento'];
		$otro_tipo_documento = $_POST['otro_tipo_documento'];

		if ($_POST['documento'] == "Otro Documento") {
			$documento = $otro_tipo_documento;
		}else{
			$documento = $documento; 
		}

		$valor = $_POST['valor'];
		$coordenadas = $_POST['coordenadas_documentacion'];


		date_default_timezone_set('America/Mexico_City');  

		$fecha_creacion = $_POST['fecha_creacion'];
		$fecha_guardado = date("Y-m-d H:i:s"); 


		$fecha_movimiento = date("Y-m-d");
		$fecha_Referencia = date("YmdHis");

		$buscar_name_completo = nombres_datos($id_contacto_documentacion, $tipo_contacto_documentacion);
		$porciones_name_complete = explode("|", $buscar_name_completo);

		$nombre_completo = $porciones_name_complete[10];


#----------------------------------------------------------  -------------------------------------------------------------------------------------------

		$query_repetir_documentacion = "SELECT * FROM orden_logistica_documentacion where tipo = '$tipo' and documento = '$documento' and fecha_creacion = '$fecha_creacion' and usuario_creador = '$usuario_creador'";
		$result_repetir_documentacion = mysql_query($query_repetir_documentacion);


		if (mysql_num_rows($result_repetir_documentacion) == 0) {

			$sql0 = "INSERT INTO orden_logistica_documentacion (tipo, documento, valor, idorden_logistica, usuario_creador, fecha_creacion, fecha_guardado, vin, id_responsable, tipo_responsable, monto_rembolso) VALUES ('$tipo', '$documento', '$valor', '$idorden_logistica', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$vin_documentacion', '$id_contacto_documentacion', '$tipo_contacto_documentacion', '$monto_entrada')";

			$result0 = mysql_query($sql0);

		}else {

			$result0 = 0;
		}

		if ($result0 == 1) {

			$rs = mysql_query("SELECT @@identity AS id");

			if ($row = mysql_fetch_row($rs)) {
				$idorden_logistica_documentacion = trim($row[0]);
			}

			$result_insert =  agregarBitacora("Se Agregó Documentación de tipo <b>$tipo</b> contiene <b>$documento</b>", "Documentación", $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, "5", "$valor", $documento);

			if ($result_insert == "") {
#----------------------------------------------------------  -------------------------------------------------------------------------------------------
				if ($documento == "Contratos" and $tipo == "Entrega") {

					$nomenclatura = "LDE";
					$whatsapp = "52".trim("");

					$agregar_contratos = agregarBitacora ("<b>$nomenclatura</b> Como parte de la logistica No. <b>$idorden_logistica</b>, Se solicita de tu apoyo para : <b>$tipo</b>, de <b>$documento</b> del Cliente <b>$nombre_completo</b>, para el VIN: <b>$vin_documentacion</b> entregar a Coordinación de Logística. Agradecemos tú atención.", "Notificación", $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, "2", $comentarios_bitacora, $documento);

					$ver_errores .= ($agregar_contratos == "") ? "Sin Errores" : $agregar_contratos ;

					$whatsapp_colaboradores = "https://api.whatsapp.com/send?phone=$whatsapp&text=$descripcion_bitacora";

#----------------------------------------------------------  -------------------------------------------------------------------------------------------
				}elseif ($documento == "Pagares" and $tipo == "Entrega") {

					$nomenclatura = "MPB";
					$whatsapp = "52".trim("7222452441");
					$tipo_bitacora = "Notificación";
					$valor_bitacora = "2";

					$descripcion_bitacora_sistema = "<b>$nomenclatura</b> Como parte de la logistica No. <b>$idorden_logistica</b>, Se solicita de tu apoyo para : <b>$tipo</b>, de <b>$documento</b> del Cliente <b>$nombre_completo</b>, entregar a Coordinación de Logística. Agradecemos tú atención.";

					$descripcion_bitacora = "*$nomenclatura* Como parte de la logistica No. *$idorden_logistica*, Se solicita de tu apoyo para: *$tipo*, de *$documento* del Cliente *$nombre_completo*, entregar a Coordinación de Logística. Agradecemos tú atención.";

					$agregar_pagares = agregarBitacora ($descripcion_bitacora_sistema, $tipo_bitacora, $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, $valor_bitacora, $comentarios_bitacora, $documento);

					$ver_errores .= ($agregar_pagares == "") ? "Sin Errores" : $agregar_pagares ;

					$whatsapp_colaboradores = "https://api.whatsapp.com/send?phone=$whatsapp&text=$descripcion_bitacora";

#----------------------------------------------------------  -------------------------------------------------------------------------------------------
				}elseif ($documento == "Documentos" and $tipo == "Entrega" || $documento == "Duplicado" and $tipo == "Entrega" || $documento == "Accesorios" and $tipo == "Entrega") {

					$nomenclatura = "YRS";
					$whatsapp = "52".trim("7227508802");
					$tipo_bitacora = "Notificación";
					$valor_bitacora = "2";

					$descripcion_bitacora_sistema = "<b>$nomenclatura</b> Como parte de la logistica No. <b>$idorden_logistica</b>, Se solicita de tu apoyo para : <b>$tipo</b>, de <b>$documento</b> del Cliente <b>$nombre_completo</b>, para el VIN: <b>$vin_documentacion</b> entregar a Coordinación de Logística. Agradecemos tú atención.";

					$descripcion_bitacora = "*$nomenclatura* Como parte de la logistica No. *$idorden_logistica*, Se solicita de tu apoyo para: *$tipo*, de *$documento* del Cliente *$nombre_completo*, para el VIN: *$vin_documentacion* entregar a Coordinación de Logística. Agradecemos tú atención.";

					$agregar_documentos = agregarBitacora ($descripcion_bitacora_sistema, $tipo_bitacora, $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, $valor_bitacora, $comentarios_bitacora, $documento);

					$ver_errores .= ($agregar_documentos == "") ? "Sin Errores" : $agregar_documentos ;

					$whatsapp_colaboradores = "https://api.whatsapp.com/send?phone=$whatsapp&text=$descripcion_bitacora";

#----------------------------------------------------------  -------------------------------------------------------------------------------------------
				}else if ($documento == "Placas" and $tipo == "Entrega") {

					$nomenclatura = "";
					$whatsapp = "52".trim("5543191603");
					$tipo_bitacora = "Notificación";
					$valor_bitacora = "2";

					$descripcion_bitacora_sistema = "<b>$nomenclatura</b> Como parte de la logistica No. <b>$idorden_logistica</b>, Se solicita de tu apoyo para : <b>$tipo</b>, de <b>$documento</b> del Cliente <b>$nombre_completo</b>, para el VIN: <b>$vin_documentacion</b> entregar a Coordinación de Logística. Agradecemos tú atención.";

					$descripcion_bitacora = "*$nomenclatura* Como parte de la logistica No. *$idorden_logistica*, Se solicita de tu apoyo para: *$tipo*, de *$documento* del Cliente *$nombre_completo*, para el VIN: *$vin_documentacion* entregar a Coordinación de Logística. Agradecemos tú atención.";

					$agregar_placas = agregarBitacora ($descripcion_bitacora_sistema, $tipo_bitacora, $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, $valor_bitacora, $comentarios_bitacora, $documento);

					$ver_errores .= ($agregar_placas == "") ? "Sin Errores" : $agregar_placas ;

					$whatsapp_colaboradores = "https://api.whatsapp.com/send?phone=$whatsapp&text=$descripcion_bitacora";
#----------------------------------------------------------  -------------------------------------------------------------------------------------------
				}else if ($documento == "Permiso" and $tipo == "Entrega") {

					$nomenclatura = "LDE";
					$whatsapp = "52".trim("7222011423");
					$tipo_bitacora = "Notificación";
					$valor_bitacora = "2";

					$descripcion_bitacora_sistema = "<b>$nomenclatura</b> Como parte de la logistica No. <b>$idorden_logistica</b>, Se solicita de tu apoyo para : <b>$tipo</b>, de <b>$documento</b> del Cliente <b>$nombre_completo</b>, para el VIN: <b>$vin_documentacion</b> entregar a Coordinación de Logística. Agradecemos tú atención.";

					$descripcion_bitacora = "*$nomenclatura* Como parte de la logistica No. *$idorden_logistica*, Se solicita de tu apoyo para: *$tipo*, de *$documento* del Cliente *$nombre_completo*, para el VIN: *$vin_documentacion* entregar a Coordinación de Logística. Agradecemos tú atención.";

					$agregar_permiso = agregarBitacora ($descripcion_bitacora_sistema, $tipo_bitacora, $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, $valor_bitacora, $comentarios_bitacora, $documento);

					$ver_errores .= ($agregar_permiso == "") ? "Sin Errores" : $agregar_permiso ;

					$whatsapp_colaboradores = "https://api.whatsapp.com/send?phone=$whatsapp&text=$descripcion_bitacora";

#----------------------------------------------------------  -------------------------------------------------------------------------------------------
				}else if ($documento == "Recurso" and $tipo == "Entrega") {

					$verificar_entrega = Verificar_Recurso ($tipo, $documento, $idorden_logistica, $idorden_logistica_documentacion);

					if ($verificar_entrega == 1) {

						$lleva_recusrso = insertarRecurso ($tipo, $fecha_movimiento, $monto_entrada, $nombre_completo, $referencia, $valor, $idorden_logistica, $usuario_creador, $fecha_guardado, $idorden_logistica_documentacion,$tipo_moneda, $tipo_cambio, $gran_total,$idempleado_documentacion, $tipoempleado_documentacion, $id_contacto_documentacion, $tipo_contacto_documentacion, $fecha_creacion, $coordenadas, $fecha_Referencia, $empleados);

						$nomenclatura = "MAMM";
						$whatsapp = "52".trim("7227507535");
						$tipo_bitacora = "Notificación";
						$valor_bitacora = "2";

						$descripcion_bitacora_sistema = "<b>$nomenclatura</b> Como parte de la logistica No. <b>$idorden_logistica</b>, Se solicita de tu apoyo para : <b>$tipo</b>, de <b>$documento</b> del Cliente <b>$nombre_completo</b>, entregar a Coordinación de Logística. Agradecemos tú atención.";

						$descripcion_bitacora = "*$nomenclatura* Como parte de la logistica No. *$idorden_logistica*, Se solicita de tu apoyo para: *$tipo*, de *$documento* del Cliente *$nombre_completo*, entregar a Coordinación de Logística. Agradecemos tú atención.";

						$agregar_recurso = agregarBitacora ($descripcion_bitacora_sistema, $tipo_bitacora, $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, $valor_bitacora, $comentarios_bitacora, $documento);

						$ver_errores .= ($agregar_recurso == "") ? "Sin Errores" : $agregar_recurso ;

						if ($lleva_recusrso == "" and $agregar_recurso == "") {

							$ver_errores = "Sin Errores";

						}elseif ($lleva_recusrso == "" and $agregar_recurso != "") {

							$ver_errores = $agregar_recurso;

						}elseif ($lleva_recusrso != "" and $agregar_recurso == "") {

							$ver_errores = $lleva_recusrso;

						}else{

							$ver_errores = $lleva_recusrso;

						}

						$whatsapp_colaboradores = "https://api.whatsapp.com/send?phone=$whatsapp&text=$descripcion_bitacora";
						
					}else {
						

						$query_baja_entrega = "UPDATE orden_logistica_documentacion SET visible = 'NO' WHERE idorden_logistica_documentacion = '$idorden_logistica_documentacion'";
						$result_baja_entrega = mysql_query($query_baja_entrega);

						$ver_errores .= "<br> -Por el momento solo puedes Ingresar una <b>$tipo</b> de <b>$documento</b> por Logística.";

					}


#----------------------------------------------------------  -------------------------------------------------------------------------------------------
				}else{

					if ($documento == "Recurso" and $tipo == "Recepción") {

						$verificar_recepcion = Verificar_Recurso ($tipo, $documento, $idorden_logistica, $idorden_logistica_documentacion);

						if ($verificar_recepcion == 1) {

							$recibe_recurso = insertarRecurso ($tipo, $fecha_movimiento, $monto_entrada, $nombre_completo, $referencia, $valor, $idorden_logistica, $usuario_creador, $fecha_guardado, $idorden_logistica_documentacion,$tipo_moneda, $tipo_cambio, $gran_total,$idempleado_documentacion, $tipoempleado_documentacion, $id_contacto_documentacion, $tipo_contacto_documentacion, $fecha_creacion, $coordenadas, $fecha_Referencia, $empleados);

							$ver_errores .= ($recibe_recurso == "") ? "Sin Errores" : $recibe_recurso ;

							$whatsapp_colaboradores = "";

							
						} else {

							$query_baja_recibe = "UPDATE orden_logistica_documentacion SET visible = 'NO' WHERE idorden_logistica_documentacion = '$idorden_logistica_documentacion'";
							$result_baja_recibe = mysql_query($query_baja_recibe);
							$ver_errores .= "<br> - Por el momento solo puedes Ingresar una <b>$tipo</b> de <b>$documento</b> por Logística.";

						}




					}else{
						$ver_errores = "Sin Errores";
					}

				}

			}else{

				$ver_errores .= "<br> - Error al guardar Bitácora"; 

			}


		}else{

			$ver_errores = "Fallo"; 

		}

#----------------------------------------------------------  Funcion Bitacora Logistica -------------------------------------------------------------------------------------------
		function agregarBitacora($descripcion, $tipo, $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, $valor, $comentarios_bitacora, $documento){

			$descripcion = trim($descripcion);
			$tipo = trim($tipo);
			$idorden_logistica = trim($idorden_logistica);
			$usuario_creador = trim($usuario_creador);
			$fecha_creacion = trim($fecha_creacion);
			$fecha_guardado = trim($fecha_guardado);
			$coordenadas = trim($coordenadas);
			$valor = trim($valor);
			$comentarios_bitacora = trim($comentarios_bitacora);
			$documento = trim($documento);

			$query_bitacora_repetida = "SELECT * FROM orden_logistica_bitacora WHERE visible = 'SI' AND tipo = '$tipo' AND idorden_logistica = '$idorden_logistica' and fecha_creacion = '$fecha_creacion' ";	
			$result_bitacora_repetida = mysql_query($query_bitacora_repetida);

			if (mysql_num_rows($result_bitacora_repetida) == 0) {

				$insert_bitacora_logistica = "INSERT INTO orden_logistica_bitacora (descripcion, tipo, idorden_logistica, usuario_creador, fecha_creacion, fecha_guardado, visible, coordenadas, valor, comentarios) VALUES ('$descripcion', '$tipo', '$idorden_logistica', '$usuario_creador','$fecha_creacion','$fecha_guardado','SI', '$coordenadas', '$valor', '$comentarios_bitacora')";
				$result_bitacora_logistica = mysql_query($insert_bitacora_logistica);

				$respuesta_bitacora = ($result_bitacora_logistica == 1) ? "" : "- Error al Insertar $documento a Bitácora <br>";

			}else{
				$respuesta_bitacora = "";
			}

			return $respuesta_bitacora;
		}

#---------------------------------------------------------- Funcion Insertar Entrega y Recepcion de Recurso -------------------------------------------------------------------------------------------

		function insertarRecurso ($tipo, $fecha_movimiento, $monto_entrada, $nombre_completo, $referencia, $valor, $idorden_logistica, $usuario_creador, $fecha_guardado, $idorden_logistica_documentacion,$tipo_moneda, $tipo_cambio, $gran_total,$idempleado_documentacion, $tipoempleado_documentacion, $id_contacto_documentacion, $tipo_contacto_documentacion, $fecha_creacion, $coordenadas, $fecha_Referencia, $empleados){


			$referencia = "$idorden_logistica/$fecha_Referencia/$usuario_creador/$empleados/";
			$id_emisor_wallet = $id_contacto_documentacion;
			$tipo_emisor_wallet = $tipo_contacto_documentacion;


			$tipo_contacto_documentacion = $tipoempleado_documentacion;
			$id_contacto_documentacion = $idempleado_documentacion;

			$buscar_name_empleado = nombres_datos($id_contacto_documentacion, $tipo_contacto_documentacion);
			$porcion_name_empleado = explode("|", $buscar_name_empleado);

			$name_empleado = $porcion_name_empleado[10];

			$emisora_institucion = ($tipo == "Entrega") ? "PANAMOTORS CENTER, S.A. DE C.V." : $nombre_completo ;
			$emisora_agente = ($tipo == "Entrega") ? "Logística" : $nombre_completo ;
			$receptora_institucion = ($tipo == "Entrega") ? $nombre_completo : "Logística" ;
			$receptora_agente = ($tipo == "Entrega") ? $nombre_completo : $name_empleado ;
			$comentarios = ($tipo == "Entrega") ? $valor : "Abono"; 
			$txt_comentarios = $valor;

			$query_recurso_repetido = "SELECT * FROM orden_logistica_recurso WHERE fecha = '$fecha_movimiento' AND idorden_logistica = '$idorden_logistica' AND gran_total = '$gran_total' and monto = '$monto_entrada' AND usuario_creador = '$usuario_creador' and estatus <> 'Cancelado' and concepto = '$tipo' ";
			$result_recurso_repetido = mysql_query($query_recurso_repetido);

			if (mysql_num_rows($result_recurso_repetido) == 0) {

				$referencia = "$idorden_logistica/$fecha_Referencia/$usuario_creador/$empleados/";

				$insert_recurso = "INSERT INTO orden_logistica_recurso (fecha, monto, emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, concepto, metodo_pago, referencia, comentarios, idorden_logistica_documentacion, idorden_logistica, id_tesoreria, usuario_creador, departamento, fecha_guardado, tipo_moneda, tipo_cambio, gran_total, estatus) VALUES ('$fecha_movimiento', '$monto_entrada', '$emisora_institucion', '$emisora_agente', '$receptora_institucion', '$receptora_agente', '$tipo', '1', '$referencia', '$comentarios', '$idorden_logistica_documentacion', '$idorden_logistica', 'P/D', '$usuario_creador', '5', '$fecha_guardado', '$tipo_moneda', '$tipo_cambio', '$gran_total', 'Pendiente')";
				$result_recurso = mysql_query($insert_recurso);

				if ($result_recurso == 1) {

					$result_olr = mysql_query("SELECT @@identity AS id");

					if ($row_olr = mysql_fetch_row($result_olr)) {

						$orden_logistica_recurso_id = trim($row_olr[0]);
						$referencia = "";
						$referencia = "$idorden_logistica/$fecha_Referencia/$usuario_creador/$empleados/$orden_logistica_recurso_id/$id_emisor_wallet";

						$query_update_recurso = "UPDATE orden_logistica_recurso SET referencia = '$referencia' WHERE idorden_logistica_recurso = '$orden_logistica_recurso_id' ";
						$result_update_recurso = mysql_query($query_update_recurso);
					}


					$insert_recepcion_wallet = RecursoWallet($tipo, $fecha_movimiento, $monto_entrada, $nombre_completo, $referencia, $valor, $idorden_logistica, $usuario_creador, $fecha_guardado, $idorden_logistica_documentacion, $tipo_moneda, $tipo_cambio, $gran_total, $idempleado_documentacion, $tipoempleado_documentacion, $id_contacto_documentacion, $tipo_contacto_documentacion, $fecha_creacion, $id_emisor_wallet ,$tipo_emisor_wallet, $coordenadas, $empleados, $txt_comentarios);

					if ($insert_recepcion_wallet == "") {

						$resultado_recurso = "";

					}else {

						$resultado_recurso = $insert_recepcion_wallet;

					}

				}else {

					$resultado_recurso = "<br> - Error al Insertar el Recurso";
				}
			}


			return $resultado_recurso;

		}
#---------------------------------------------------------- Funcion Insertar la Entrega de Recurso -------------------------------------------------------------------------------------------

		function RecursoWallet ($tipo, $fecha_movimiento, $monto_entrada, $nombre_completo, $referencia, $valor, $idorden_logistica, $usuario_creador, $fecha_guardado, $idorden_logistica_documentacion,$tipo_moneda, $tipo_cambio, $gran_total,$idempleado_documentacion, $tipoempleado_documentacion, $id_contacto_documentacion, $tipo_contacto_documentacion, $fecha_creacion, $id_emisor_wallet ,$tipo_emisor_wallet, $coordenadas, $empleados, $txt_comentarios) {

			$tipo_movimiento = "abono";

# Condiciones TIPO DE TABLA EMPLEADOS WALLET




			if ($tipo_emisor_wallet == "Cliente") {

				$tabla = "estado_cuenta";

			}else if ($tipo_emisor_wallet == "Proveedor") {

				$consulta_nombre = nombres_datos($id_emisor_wallet, $tipo_emisor_wallet);
				$porciones_nombre = explode("|", $consulta_nombre);

				$tabla = (trim($porciones_nombre[12]) == "8")? "estado_cuenta_proveedores" : "estado_cuenta_requisicion" ;

			}else if ($tipo_emisor_wallet == "Proveedor Info" || $tipo_emisor_wallet == "Transacciones") {	
				

				$consulta_nombre = nombres_datos($id_emisor_wallet, $tipo_emisor_wallet);
				$porciones_nombre = explode("|", $consulta_nombre);


				if (trim($porciones_nombre[12]) == "Bienes Raices") {
					$tipo_emisor_wallet = "Bienes Raices";

					$tabla = "proveedores_bienes_raices_estado_cuenta";

				}else if (trim($porciones_nombre[12]) == "Prestamos") {
					$tipo_emisor_wallet = "Prestamos";
					$tabla = "proveedores_prestamos_estado_cuenta";

				}else if (trim($porciones_nombre[12]) == "Transacciones") {
					$tipo_emisor_wallet = "Transacciones";
					$tabla = "proveedores_transacciones_estado_cuenta";

				}else{
					$tabla = "Pendiente";
				}

			}else if ($tipo_emisor_wallet == "Colaborador") {

				$tabla = "Pendiente";

			}else if ($tipo_emisor_wallet == "Proveedor Temporal") {

				$tabla = "Pendiente";

			}else{

				$tabla = "Pendiente";

			}




			if ($tipo == "Entrega") {

				#$emisor = $idempleado_documentacion;
				$emisor = "TP1";
				#$tipo_emisor = $tipoempleado_documentacion;
				$tipo_emisor = "Tesoreria";

				#$receptor = $id_emisor_wallet;
				#$tipo_receptor = $tipo_emisor_wallet;
				$receptor = $idempleado_documentacion;
				$tipo_receptor = $tipoempleado_documentacion;

				$tipo_egreso_ingreso =  "Egreso";
				$valor_bitacora_wallet = "1";




			}elseif($tipo == "Recepción") {

				$emisor = $id_emisor_wallet;
				$tipo_emisor = $tipo_emisor_wallet;

				$receptor = $idempleado_documentacion;
				$tipo_receptor = $tipoempleado_documentacion;

				$tipo_egreso_ingreso =  "Ingreso";
				$valor_bitacora_wallet = "2";
			}


			$tesoreria = "L0001";
			$estatus = "Pendiente";

			$fecha_wallet = date("YmdHis"); 
			$inicio_wallet = rand(1, 1000000);
			$fin_wallet = rand(10000000, 999999999999);
			$final_rnd_wallet = rand($inicio_wallet, $fin_wallet);
			$password_completa_wallet = $final_rnd_wallet.$fecha_wallet;
			$token = substr($password_completa_wallet, -15);

			$query_wallet_repetido = "SELECT * FROM empleados_wallet WHERE visible = 'SI' gran_total = '$gran_total' AND idlogistica = '$idorden_logistica' and usuario_creador = '$usuario_creador' AND fecha_creacion = '$fecha_creacion'";
			$result_wallet_repetido = mysql_query($query_wallet_repetido);

			if (mysql_num_rows($result_wallet_repetido) == 0) {

				$insert_wallet = "INSERT INTO empleados_wallet (fecha_movimiento, tipo_movimiento, monto, tipo_moneda, tipo_cambio, gran_total, id, tipo_id, tabla, tesoreria, idlogistica, estatus, emisor, tipo_emisor, receptor, tipo_receptor, referencia, token, visible, usuario_creador, empleado_creador, fecha_creacion, fecha_guardado, referencia_seguimiento, metodo_pago, tipo) VALUES ('$fecha_movimiento', '$tipo_movimiento', '$monto_entrada', '$tipo_moneda', '$tipo_cambio', '$gran_total', '$id_emisor_wallet', '$tipo_emisor_wallet', '$tabla', '$tesoreria', '$idorden_logistica', '$estatus', '$emisor', '$tipo_emisor', '$receptor', '$tipo_receptor', '$referencia', '$token', 'SI', '$usuario_creador', '$empleados', '$fecha_creacion', '$fecha_guardado' ,'$referencia', '1', '$tipo_egreso_ingreso')";
				$result_wallet = mysql_query($insert_wallet);

				$result_emw = mysql_query("SELECT @@identity AS id");

				if ($rowempw = mysql_fetch_row($result_emw)) {
					$empleados_wallet_id = trim($rowempw[0]);
				}



				if ($result_wallet == 1) {

					$wallet_bitacora = agregarBitacora ("Token $tipo de recurso", "Token", $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, '13', "$token");

					if ($wallet_bitacora == "") {

						$bitacora_wallet = insertarBitacoraWallet($empleados_wallet_id, $referencia, "Token Recurso", "Se crea token para $tipo de recurso", "$valor_bitacora_wallet", "SI", $fecha_creacion, $fecha_guardado, $idorden_logistica, "Logistica", $usuario_creador, $token, $tipo_egreso_ingreso, $txt_comentarios);

						if ($bitacora_wallet == 1) {

							$resultado_wallet = ""; 

						}else{
							$resultado_wallet = $bitacora_wallet; 
						}

					}else{
						$resultado_wallet = "<br> - Error al insertar la bitácora";
					}

				}else{

					$resultado_wallet = "<br> - Error al Insertar el WALLET";

				}



			}else{
				$resultado_wallet = "";
			}



			return $resultado_wallet;

		}

#----------------------------------------------------------INSERTAR BITACORA WALLET-------------------------------------------------------------------------------------------

		function insertarBitacoraWallet($idempleados_wallet, $referencia, $tipo, $descripcion, $valor, $visible, $fecha_creacion, $fecha_guardado, $id_id, $tipo_type, $usuario_creador,$columna_a, $tipo_egreso_ingreso, $txt_comentarios) {

			$query_repetir_wallet = "SELECT * FROM wallet_bitacora WHERE visible = 'SI' and tipo = '$tipo' and fecha_creacion = '$fecha_creacion'";
			$result_repetir_wallet = mysql_query($query_repetir_wallet);

			if (mysql_num_rows($result_repetir_wallet) >=1 ) {

				$respuesta_bitacora_wallet = 0;

			}else {

				$valor_bitacora = ($tipo_egreso_ingreso == "Egreso") ? 1 : 2;

				$insert_bitacora_wallet = "INSERT INTO wallet_bitacora (idempleados_wallet, referencia, tipo, descripcion, valor, visible, fecha_creacion, fecha_guardado, id_id, tipo_type, usuario_creador, columna_a, columna_b, columna_c) VALUES ('$idempleados_wallet', '$referencia', '$tipo', '$descripcion', '$valor_bitacora', '$visible', '$fecha_creacion', '$fecha_guardado', '$id_id', '$tipo_type', '$usuario_creador', '$columna_a', '$tipo_egreso_ingreso', '$txt_comentarios')";
				$result_bitacora_wallet = mysql_query($insert_bitacora_wallet);

				$respuesta_bitacora_wallet = ($result_bitacora_wallet == 1) ? "1" : "0";

			}

			return $respuesta_bitacora_wallet;
		}

#----------------------------------------------------------Verificar que solo este una vez el recurso -------------------------------------------------------------------------------------------

		function Verificar_Recurso ($tipo, $documento, $idorden_logistica, $idorden_logistica_documentacion) {

			$query_recurso_una_vez = "SELECT * FROM orden_logistica_documentacion WHERE visible = 'SI' AND tipo = '$tipo' AND documento = '$documento' and idorden_logistica = '$idorden_logistica' and idorden_logistica_documentacion <> '$idorden_logistica_documentacion'";
			$result_recurso_una_vez = mysql_query($query_recurso_una_vez);

			$var_recurso_una_vez = (mysql_num_rows($result_recurso_una_vez) == 0) ? 1 : 0;

			return $var_recurso_una_vez;

		}



		?>
		<script>

			var si_error_no = '<?php echo $ver_errores; ?>'
			var numeros_whats ='<?php echo $whatsapp_colaboradores;?>'
			var idlogistica = '<?php  echo $idlogistica_encriptada;?>'

			if (si_error_no == "Sin Errores") {
				$('#success_alert').show(); 
				$("#content-contador").show();
				if (numeros_whats == "") {

					redireccionPagina();
				}else{
					open(numeros_whats, `whatsapp`,`width=600, height=600, left=300, top=300`); 

					redireccionPagina();
				}


			}else if (si_error_no == "Fallo") {
				$('#fail_alert').show();  

				$("#content-contador").show();
				redireccionPagina();

			}else{
				$('#alert_alert').show(); 
				$("#content-contador").hide();
				$(".neu-alert-error-tipo").append("<p class='text-white mb-0' style='position: relative; z-index: 2;'>"+ si_error_no+ "</p>");


				var create = `
				<div class="d-flex justify-content-center mt-4">
				<button class="btn btn-lg btn-primary" id="continuar">Continuar</button>
				</div>
				`;

				$("#alert_alert").append(create);
			}



			$(document).ready(function(){
				$("#continuar").click(function(){
					location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#verdocumentacion`);
				}); 

				$("#yes").click(function(){
					location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#verdocumentacion`);
				}); 

				$("#nel").click(function(){

					location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#verdocumentacion`);

				});
			});

			function redireccionPagina(){
				delayPagina();
				contadorRedirigir();
			}

			function delayPagina(){
				var delay = 1000;
				setTimeout(() => {
					location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#verdocumentacion`);
				}, delay);
			}

			function contadorRedirigir(){
				$('.numero-contador').each(function () { 
					$(this).prop('Counter', 1).animate(
					{ 
						Counter: $(this).text() 
					}, 
					{ 
						duration: 1000, 
						easing: 'swing', 
						step: function (now) { 
							$(this).text(Math.ceil(now)); 
						} 
					}
					); 
				});
			}

			const neu_animation_container = document.querySelector(".neu-animation-container");
			neu_animation_container.classList.add("add-neu-animation-container");

		</script>

	</body>
	</html>




