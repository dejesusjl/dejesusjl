<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
header("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);


?>

<!doctype html>
<html lang="es" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>CCP| Guardar Orden</title>

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
	<link rel="icon" type="image/png" sizes="192x192" href="../../img/favicon/android-icon-192x192.png">
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
						<div class="neu-alert neu-alert-correcto">
							<div style="position: relative; z-index: 2;">
								<h1 class="text-center text-white mb-0">Logística agregada exitosamente</h1>
								<h3 class="text-white text-center">¿Deseas agregar documentación?</h3>
								<div class="d-flex justify-content-center">
									<button class="btn btn-success mx-2" id="yes" style="width: 80px; background: #24c78b; border: none;">SI</button>
									<button class="btn btn-warning mx-2" id="nel" style="width: 80px; background: #bb1148; border: none;">NO</button>
								</div>
							</div>
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
							<div style="position: relative; z-index: 2;">
								<h3 class="text-white text-center">¿Deseas agregar documentación?</h3>
								<div class="d-flex justify-content-center">
									<button class="btn btn-success mx-2" id="yes" style="width: 80px; background: #24c78b; border: none;">SI</button>
									<button class="btn btn-warning mx-2" id="nel" style="width: 80px; background: #bb1148; border: none;">NO</button>
								</div>
							</div>
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
		</div>
	</div>

	<?php
	#----------------------------------------------------------Departamento-------------------------------------------------------------------------------------------
	$iddepartamento = trim($_POST['departamento']);
	$idcatalogo_orden_logistica = trim($_POST['tipo_orden']);
	#----------------------------------------------------------Numero de orden-------------------------------------------------------------------------------------------
	$presupuesto = trim($_POST['num_orden']);
	#----------------------------------------------------------Datos logistica-------------------------------------------------------------------------------------------
	$kilometros = trim($_POST['kilometros']);
	$tiempo_estimado = trim($_POST['timeall']);
	#----------------------------------------------------------Datos Origen-------------------------------------------------------------------------------------------
	$estado_origen = trim($_POST['estado_o']);
	$municipio_origen = trim($_POST['municipio_o']);
	$colonia_origen = trim($_POST['colonia_o']);
	$calle_origen = trim($_POST['calle_o']);
	$coordenadas_origen = trim($_POST['coordenadas_origen']);
	$cp_origen = trim($_POST['cpo']);
	#----------------------------------------------------------Datos Destino-------------------------------------------------------------------------------------------
	$estado_destino = trim($_POST['estado_d']);
	$municipio_destino = trim($_POST['municipio_d']);
	$colonia_destino = trim($_POST['colonia_d']);
	$calle_destino = trim($_POST['calle_d']);
	$cp_destino = trim($_POST['cpd']);
	$ubicacion_destino = trim($_POST['coordenadas_destino']);
	#----------------------------------------------------------Fechas -------------------------------------------------------------------------------------------
	$fecha_solicitud = $_POST['fecha_solicitud'];
	$fecha_programada = $_POST['fecha_hora_programada'];
	$visible = "SI";
	$usuario_creador = $_SESSION['usuario_clave'];
	$fecha_creacion = $_POST['fecha_solicitud'];
	$fecha_guardado = date("Y-m-d H:i:s");
	$fecha_actual = date("l");
	#----------------------------------------------------------ID-------------------------------------------------------------------------------------------
	$idcontacto = trim($_POST['idcliente']);
	$tipo_contacto = trim($_POST['tipo_contacto_id']);
	#----------------------------------------------------------Solicitante-------------------------------------------------------------------------------------------
	$idsolicitante = trim($_POST['id_asesor']);
	$tipo_solicitante = trim($_POST['tipo_solicitante']);
	#----------------------------------------------------------Fuente Informacion-------------------------------------------------------------------------------------------
	$idfuente_inf = trim($_POST['id_informante']);
	$tipo_fuente_inf = trim($_POST['tipo_informante']);
	#----------------------------------------------------------Trasladista-------------------------------------------------------------------------------------------
	$idasigna = trim($_POST['ejecutivo_traslado']);
	$tipo_asignante = trim($_POST['tipo_trasladista']);
	#----------------------------------------------------------Adicional-------------------------------------------------------------------------------------------
	$comentario_general = trim($_POST['comentario']);
	$columna_b = $_POST['integridad'];
	$coordenadas = $_POST['ubicacion_real'];
	$estatus = "Solicitud";
	#----------------------------------------------------------Ayudantes-------------------------------------------------------------------------------------------
	$id_ayudante_recibir = $_POST['id_ayudante'];
	$tipo_ayudante_recibir = $_POST['tipo_ayudante'];
	$comentario_ayudante_recibir = $_POST['comentario_ayudante'];

	$agrupar_ayudantes = array();

	for ($i = 0; $i < count($id_ayudante_recibir); $i++) {

		array_push($agrupar_ayudantes, trim($id_ayudante_recibir[$i]) . ";" . trim($tipo_ayudante_recibir[$i]) . ";" . trim($comentario_ayudante_recibir[$i]) . "/");
	}

	$eliminar_ayudantes_duplicados = array_unique($agrupar_ayudantes);

	$agrupar_ayudantes_eliminados = substr(implode($eliminar_ayudantes_duplicados), 0, -1);

	$nuevo_array_ayudantes = explode("/", $agrupar_ayudantes_eliminados);
	$id_ayudante = array();
	$tipo_ayudante = array();
	$comentario_ayudante = array();

	for ($j = 0; $j < count($nuevo_array_ayudantes); $j++) {

		$particion_ayudantes = explode(";", $nuevo_array_ayudantes[$j]);

		array_push($id_ayudante, trim($particion_ayudantes[0]));
		array_push($tipo_ayudante, trim($particion_ayudantes[1]));
		array_push($comentario_ayudante, trim($particion_ayudantes[2]));
	}

	#----------------------------------------------------------Vines-------------------------------------------------------------------------------------------
	$vin_recibir = $_POST['soy_vin'];
	$marca_recibir = $_POST['soy_marca'];
	$version_recibir = $_POST['soy_version'];
	$color_recibir = $_POST['soy_color'];
	$modelo_recibir = $_POST['soy_modelo'];

	$tipo_orden_recibir = $_POST['rol_vin'];
	$tipo_unidad_recibir = $_POST['tipo_vin'];
	$id_asignado_recibir = $_POST['responsable_unidad'];

	$agrupar_vines = array();


	for ($i = 0; $i < count($vin_recibir); $i++) {

		if ($vin_recibir[$i] != "") {

			$porcion_responsable_tipo = explode("*", $id_asignado_recibir[$i]);



			array_push($agrupar_vines, trim($vin_recibir[$i]) . "@" . trim($tipo_orden_recibir[$i]) . "@" . trim($marca_recibir[$i]) . "@" . trim($version_recibir[$i]) . "@" . trim($color_recibir[$i]) . "@" . trim($modelo_recibir[$i]) . "@" . trim($tipo_unidad_recibir[$i]) . "@" . trim($porcion_responsable_tipo[0]) . "@" . trim($porcion_responsable_tipo[1]) . "|");
		}
	}


	$eliminar_vines_duplicados = array_unique($agrupar_vines);

	$agrupar_vines_eliminados = substr(implode($eliminar_vines_duplicados), 0, -1);

	$nuevo_array_ayudantes = explode("|", $agrupar_vines_eliminados);

	$tipo_orden = array();
	$vin = array();
	$marca = array();
	$version = array();
	$color = array();
	$modelo = array();
	$tipo_unidad = array();
	$idpersona_asignada = array();
	$tipopersona_asignada = array();

	for ($j = 0; $j < count($nuevo_array_ayudantes); $j++) {

		$particion_vines = explode("@", $nuevo_array_ayudantes[$j]);

		array_push($vin, trim($particion_vines[0]));
		array_push($tipo_orden, trim($particion_vines[1]));
		array_push($marca, trim($particion_vines[2]));
		array_push($version, trim($particion_vines[3]));
		array_push($color, trim($particion_vines[4]));
		array_push($modelo, trim($particion_vines[5]));
		array_push($tipo_unidad, trim($particion_vines[6]));
		array_push($idpersona_asignada, trim($particion_vines[7]));
		array_push($tipopersona_asignada, trim($particion_vines[8]));
	}

	#----------------------------------------------------------Validaciones-------------------------------------------------------------------------------------------



	if ($colonia_origen == "" && $colonia_origen_select == "") {
		$colonia_origen_insert = "Sin Colonia";
	} elseif ($colonia_origen_select != "") {
		$colonia_origen_insert = $colonia_origen_select;
	} elseif ($colonia_origen != "") {
		$colonia_origen_insert = $colonia_origen;
	}


	if ($colonia_destino == "" && $colonia_destino_select == "") {
		$colonia_destino_insert = "Sin Colonia";
	} elseif ($colonia_destino_select != "") {
		$colonia_destino_insert = $colonia_destino_select;
	} elseif ($colonia_destino != "") {
		$colonia_destino_insert = $colonia_destino;
	}



	if ($colonia == "") {
		$colonia = "Sin Colonia";
	} else {
		$colonia = $colonia;
	}


	if ($calle == "") {
		$calle = "Sin calle";
	} else {
		$calle = $calle;
	}


	if ($apellidos == "") {
		$apellidos = "Sin apellidos";
	} else {
		$apellidos = $apellidos;
	}


	if ($alias == "") {
		$alias = "Sin alias";
	} else {
		$alias = $alias;
	}


	if ($celular == "") {
		$telefono = "Sin teléfono";
	} else {
		$telefono = $celular;
	}



	if ($fijo == "") {
		$telefono_otro = "Sin teléfono";
	} else {
		$telefono_otro = $fijo;
	}

	if ($rendimiento == "") {
		$rendimiento = "Sin rendimiento";
	} else {
		$rendimiento = $rendimiento;
	}


	if ($ubicacion_destino == "") {
		$ubicacion_destino = "Sin Coordenadas";
	} else {
		$ubicacion_destino = $ubicacion_destino;
	}

	if ($coordenadas_origen == "") {
		$coordenadas_origen = "Sin Coordenadas";
	} else {
		$coordenadas_origen = $coordenadas_origen;
	}

	if ($calle_cliente == "") {
		$calle_cliente = "Sin Calle";
	} else {
		$calle_cliente = $calle;
	}


	$query_duplicada = "SELECT * FROM orden_logistica WHERE fecha_solicitud = '$fecha_creacion' and usuario_creador = '$usuario_creador'";
	$result_duplicada = mysql_query($query_duplicada);

	$insert_logistic_ok = "INSERT INTO orden_logistica (fecha_solicitud, fecha_programada, tiempo_estimado, estado_origen, municipio_origen, colonia_origen, calle_origen, coordenadas_origen, cp_origen, estado_destino, municipio_destino, colonia_destino, calle_destino, cp_destino, ubicacion_destino, idcontacto, tipo_contacto, kilometros, idsolicitante, tipo_solicitante, idfuente_inf, tipo_fuente_inf, idasigna, tipo_asignante, presupuesto, estatus, comentario_general, iddepartamento, idcatalogo_orden_logistica, visible, usuario_creador, fecha_creacion, fecha_guardado) VALUES ('$fecha_solicitud','$fecha_programada','$tiempo_estimado','$estado_origen','$municipio_origen','$colonia_origen','$calle_origen','$coordenadas_origen','$cp_origen','$estado_destino','$municipio_destino','$colonia_destino','$calle_destino','$cp_destino','$ubicacion_destino','$idcontacto','$tipo_contacto','$kilometros','$idsolicitante','$tipo_solicitante','$idfuente_inf','$tipo_fuente_inf','$idasigna','$tipo_asignante','$presupuesto','$estatus','$comentario_general','$iddepartamento','$idcatalogo_orden_logistica','$visible','$usuario_creador','$fecha_creacion','$fecha_guardado')";

	$result_orden_logistica = (mysql_num_rows($result_duplicada) >= 1) ? "0" : mysql_query($insert_logistic_ok);
	//$result_orden_logistica = mysql_query($insert_logistic_ok);
	if ($result_orden_logistica == 1) {
		#----------------------------------------------------------Obtenemos el ID de logistica-------------------------------------------------------------------------------------------
		$rs = mysql_query("SELECT @@identity AS id");
		if ($row_ultimo_insert = mysql_fetch_row($rs)) {
			$id_logisticapasar = trim($row_ultimo_insert[0]);
			$encript_logistic = base64_encode($id_logisticapasar);
		}

		$idlogistica_encriptada = base64_encode($id_logisticapasar);
		#----------------------------------------------------------Bitacora Orden de logistica-------------------------------------------------------------------------------------------
		$bitacora_descripcion = "Solicita Logística";
		$bitacora_tipo = "Solicitud";
		$bitacora_valor = "1";
		$insert_logistica_bitacora = insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador);
		#----------------------------------------------------------Trasladista Principal-------------------------------------------------------------------------------------------
		if ($idasigna == "") {

			$bitacora_tipo = "Notificación";
			$bitacora_valor = "2";

			$nomenclatura = name_usuario($empleados, "Colaborador");
			$porcion_nomenclatura_uno = explode("/", $nomenclatura);

			$bitacora_descripcion = "<b>$porcion_nomenclatura_uno[1]</b> Realizó una nueva logística Programada No. <b>$id_logisticapasar</b>, con origen: <b>$municipio_origen</b>, <b>$estado_origen</b> y Destino: <b>$municipio_destino</b>, <b>$estado_destino</b> conoce los detalles consultando CCP";


			$logistica_programada = insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador);

			$result_count_trasladista = ";";
		} else {

			$nombre_trasladista = nombres_datos($idasigna, $tipo_asignante);
			$trim_name_trasladista = explode("|", $nombre_trasladista);

			$nombre_trasladista_principal = $trim_name_trasladista[2];
			$numero_trasladista = $trim_name_trasladista[3];

			#----------------------------------------------------------Verificamos Tipo de Mensaje de Whats-------------------------------------------------------------------------------------------

			if ($tipo_asignante == "Colaborador") {

				$ruta = ($trim_name_trasladista[13] == "Ejecutivo de Traslado") ? "Ejecutivos_Traslado" : "Generar_Logistica";

				$mensaje_trasladista = "*$trim_name_trasladista[2]* Tienes una nueva logística por atender No. *$id_logisticapasar*, Tu origen: *$municipio_origen*, *$estado_origen* tu Destino: *$municipio_destino*, *$estado_destino* conoce los detalles consultando CCP https://www.panamotorscenter.com/Prod/CCP/Perfiles2/$ruta/orden_logistica_detalles.php?idib=$encript_logistic";
				$bitacora_descripcion =	"<b>$trim_name_trasladista[2]</b> Tienes una nueva logística por atender No. <b>$id_logisticapasar</b>, Tu origen: <b>$municipio_origen</b>, <b>$estado_origen</b> tu Destino: <b>$municipio_destino</b>, <b>$estado_destino</b> conoce los detalles consultando CCP";
			} else {

				$mensaje_trasladista = "*$trim_name_trasladista[10]* usted tiene un número de orden. *$id_logisticapasar*, de logística para cualquier duda o aclaración";
				$bitacora_descripcion =  "<b>$trim_name_trasladista[10]</b> usted tiene un número de orden. <b>$id_logisticapasar<b>, de logística para cualquier duda o aclaración.";
			}

			$whatsapp_trasladista = "https://api.whatsapp.com/send?phone=$numero_trasladista&text=$mensaje_trasladista" . "|";

			#----------------------------------------------------------Verificamos Tipo de Mensaje de Bitacora-------------------------------------------------------------------------------------------


			$bitacora_tipo = "Notificación";
			$bitacora_valor = "2";

			$insert_trasladista_bitacora = insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador);

			$result_update_trasladista = ($tipo_asignante == "Colaborador") ? updateColaboradores($id_colaborador_name) : ";";

			$result_count_trasladista = $insert_trasladista_bitacora . " " . $result_update_trasladista;


			/*			$type_colaborador_name = $tipo_asignante;
			$nombre_trasladista = name_usuario($idasigna, $type_colaborador_name);
			$trim_name_trasladista = explode("/", $nombre_trasladista);

			$nombre_trasladista_principal = $trim_name_trasladista[1];
			$numero_trasladista = $trim_name_trasladista[3];
#----------------------------------------------------------Verificamos Tipo de Mensaje de Whats-------------------------------------------------------------------------------------------
			$mensaje_trasladista = ($type_colaborador_name == "Colaborador") ? "*$nombre_trasladista_principal* Tienes una nueva logística por atender No. *$id_logisticapasar*, Tu origen: *$municipio_origen*, *$estado_origen* tu Destino: *$municipio_destino*, *$estado_destino* conoce los detalles consultando CCP https://www.panamotorscenter.com/Des/CCP/Perfiles2/Logistica/orden_logistica_detalles.php?idib=$encript_logistic" : "*$nombre_trasladista_principal* usted tiene un número de orden. *$id_logisticapasar*, de logística para cualquier duda o aclaración" ;

			$whatsapp_trasladista = "https://api.whatsapp.com/send?phone=$numero_trasladista&text=$mensaje_trasladista"."|";

#----------------------------------------------------------Verificamos Tipo de Mensaje de Bitacora-------------------------------------------------------------------------------------------
			$bitacora_descripcion = ($type_colaborador_name == "Colaborador") ? "<b>$nombre_trasladista_principal</b> Tienes una nueva logística por atender No. <b>$id_logisticapasar</b>, Tu origen: <b>$municipio_origen</b>, <b>$estado_origen</b> tu Destino: <b>$municipio_destino</b>, <b>$estado_destino</b> conoce los detalles consultando CCP" : "<b>$nombre_trasladista_principal</b> usted tiene un número de orden. <b>$id_logisticapasar<b>, de logística para cualquier duda o aclaración." ;

			$bitacora_tipo = "Notificación";
			$bitacora_valor = "2";

			$insert_trasladista_bitacora = insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador);

			$result_update_trasladista = ($type_colaborador_name == "Colaborador") ? updateColaboradores($id_colaborador_name) : ";" ;

			$result_count_trasladista = $insert_trasladista_bitacora." ".$result_update_trasladista;
*/
		}
		#----------------------------------------------------------Verificamos si hay Ayudantes	-------------------------------------------------------------------------------------------	
		$result_count_ayudantes = (sizeof($id_ayudante) > 0) ? $respuesta_insert_ayudantes = insertAyudantes($id_ayudante, $tipo_ayudante, $comentario_ayudante, $id_logisticapasar, $usuario_creador, $fecha_creacion,  $fecha_guardado, $coordenadas, $municipio_origen, $estado_origen, $municipio_destino, $estado_destino, $idasigna, $tipo_asignante) : ";";

		#----------------------------------------------------------Obtenemos el ID de logistica-------------------------------------------------------------------------------------------
		#verificamos si hay Unidades
		$result_count_unidades = (sizeof($vin) > 0) ? $respuesta_inser_vin = insertVIN($tipo_orden, $vin, $marca, $version, $color, $tipo_unidad, $idasigna, $tipo_asignante,  $idpersona_asignada, $tipopersona_asignada, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $usuario_creador) : ";";

		$concatenacion_total = $insert_logistica_bitacora . ";" . $result_count_trasladista . ";" . $result_count_ayudantes . ";" . $result_count_unidades;

		$porciones_errores = explode(";", $concatenacion_total);


		foreach ($porciones_errores as $errorrr) {
			if (trim($errorrr) != "") {
				$nuevo .= "<p>$errorrr</p>|";
			}
		}

		$quitar_ultimo = substr($nuevo, 0, -1);


		$ver_errores =  (sizeof($quitar_ultimo) == 0 || $quitar_ultimo == null) ? "Sin Errores" : $quitar_ultimo;


		$traer_whats_ayudantes = whatsappAyudantes($id_logisticapasar, $idasigna, $tipo_asignante, $nombre_trasladista_principal, $municipio_origen, $estado_origen, $municipio_destino, $estado_destino, $encript_logistic);

		$concatenar_whatsapp = $whatsapp_trasladista . "|" . $traer_whats_ayudantes . "|" . $whatsapp_programadas;

		$concatenar_whatsapp_explode = explode("|", $concatenar_whatsapp);




		foreach ($concatenar_whatsapp_explode as $value) {

			if ($value != "") {
				$numeros_whats .= $value . "|";
			}
		}

		$whatsapp_colaboradores = substr($numeros_whats, 0, -1);
	} else {

		$ver_errores = "Fallo";
		// $result_orden_logistica = "<br>".mysql_query($insert_orden_logistica) or die("Error<br> MySQL dice: ".mysql_error().'<br>');

	}


	# inician las Funciones 

	#----------------------------------------------------------INSERTAR AYUDANTES-------------------------------------------------------------------------------------------

	function insertAyudantes($id_ayudante, $tipo_ayudante, $comentario_ayudante, $id_logisticapasar, $usuario_creador, $fecha_creacion,  $fecha_guardado, $coordenadas, $municipio_origen, $estado_origen, $municipio_destino, $estado_destino, $idasigna, $tipo_asignante)
	{

		for ($i = 0; $i < sizeof($id_ayudante); $i++) {

			$ver_insert_vin = buscar_principal_ayudantes($id_ayudante[$i], $tipo_ayudante[$i], $id_logisticapasar);

			if ($ver_insert_vin == 1) {
				if (trim($id_ayudante[$i]) != "") {

					$insert_ayudantes = "INSERT orden_logistica_ayudante (id_colaborador_proveedor, tipo, idorden_logistica, comentarios, visible, usuario_creador, fecha_creacion, fecha_guardado) VALUES ('" . $id_ayudante[$i] . "', '" . $tipo_ayudante[$i] . "', '$id_logisticapasar', '" . $comentario_ayudante[$i] . "', 'SI', '$usuario_creador', '$fecha_creacion', '$fecha_guardado')";
					$result_insert_ayudantes = mysql_query($insert_ayudantes);

					if ($result_insert_ayudantes == 1) {

						if ($tipo_ayudante[$i] == "Colaborador") {

							#----------------------------------------------------------colocar en Ruta a los ayudantes-------------------------------------------------------------------------------------------
							$result_update_colaborador = updateColaboradores($id_ayudante[$i]);

							#----------------------------------------------------------obtener su nomenclatura y su nombre de el ayudante-------------------------------------------------------------------------------------------				
							$nombre_colaborador = name_usuario($id_ayudante[$i], $tipo_ayudante[$i]);
							$esplite_name = explode("/", $nombre_colaborador);

							#----------------------------------------------------------Insertar Ayudante a bitacora-------------------------------------------------------------------------------------------

							$bitacora_descripcion = "Se Agregó a <b>$esplite_name[1]</b> como Acompañante";
							$bitacora_tipo = "Acompañante";
							$bitacora_valor = "4";
							$insert_ayudante_bitacora = insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador);

							#----------------------------------------------------------(obtener el nombre de el trasladista principal)-------------------------------------------------------------------------------------------

							if ($idasigna == "") {

								$si_lleva_traslatista = "(Trasladista Pendiente)";
							} else {

								$obtener_name_tras_principal = name_usuario($idasigna, $tipo_asignante);
								$trim_lleva_trasladista = explode("/", $obtener_name_tras_principal);
								$si_lleva_traslatista = $trim_lleva_trasladista[1];
							}

							#----------------------------------------------------------insertar notificacion de tipo ayudante a la bitacora-------------------------------------------------------------------------------------------
							$bitacora_descripcion_notificacion = "<b>$esplite_name[1]</b> Acompañaras a <b>$si_lleva_traslatista</b> a un traslado de <b>$municipio_origen, $estado_origen</b> a <b>$municipio_destino, $estado_destino</b> Orden No. <b>$id_logisticapasar</b>";
							$bitacora_tipo = "Notificación";
							$bitacora_valor = "2";

							echo $insert_bitacora_ayudante_notificacion = insertarBitacora($bitacora_descripcion_notificacion, "Notificación", $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, "2", $usuario_creador);
							echo "<br>";

							$respuesta_insert_ayudantes .= ($result_insert_ayudantes == 1) ? ";" : ";" . " Error con el Ayudante " . $esplite_name[1] . ";";
						} else {

							#----------------------------------------------------------obtener su nomenclatura y su nombre de el ayudante-------------------------------------------------------------------------------------------				
							$nombre_colaborador = name_usuario($id_ayudante[$i], $tipo_ayudante[$i]);
							$esplite_name = explode("/", $nombre_colaborador);
							$whatsapp = trim($esplite_name[3]);

							#----------------------------------------------------------Insertar Ayudante a bitacora-------------------------------------------------------------------------------------------

							$bitacora_descripcion = "Se Agregó a <b>$esplite_name[1]</b> como Acompañante";
							$bitacora_tipo = "Acompañante";
							$bitacora_valor = "4";
							$insert_ayudante_bitacora = insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador);

							$respuesta_insert_ayudantes .= ($insert_ayudante_bitacora == ";") ? ";" : ";" . "Error con el $tipo_ayudante[$i]  " . $esplite_name[1] . ";";

							#----------------------------------------------------------insertar notificacion de tipo ayudante a la bitacora-------------------------------------------------------------------------------------------

							$bitacora_descripcion = "<b>$esplite_name[1]</b> usted tiene un número de orden. <b>$id_logisticapasar<b>, de logística para cualquier duda o aclaración.";
							$bitacora_tipo = "Notificación";
							$bitacora_valor = "2";

							$insert_bitacora_ayudante_notificacion = insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador);


							$respuesta_insert_ayudantes .= ($result_insert_ayudantes == 1) ? ";" : ";" . " Error con el Ayudante " . $esplite_name[1] . ";";
						}

						$respuesta_insert_ayudantes = $respuesta_insert_ayudantes . $result_update_colaborador . $insert_bitacora_ayudante_notificacion . $insert_ayudante_bitacora;
					} else {
						$respuesta_insert_ayudantes = ";";
					}
				} #vacio
			} #duplicado  
		} #for  

		return $respuesta_insert_ayudantes;
	}


	#----------------------------------------------------------UPDATE COLABORADORES-------------------------------------------------------------------------------------------

	function updateColaboradores($id_colaborador_actualizar)
	{

		$update_empleados = "UPDATE empleados SET columna_a = 'En Ruta' WHERE idempleados = '$id_colaborador_actualizar'";
		$result_update_empleado = mysql_query($update_empleados);

		$solicito_nombre = name_usuario($id_colaborador_actualizar, "Colaborador");

		$trim_name = explode("/", $solicito_nombre);

		$result_update_colaborador .= ($result_update_empleado == 1) ? "" : ";" . "Error de Estatus con " . $trim_name[1] . ";";

		return $result_update_colaborador;
	}

	#----------------------------------------------------------INSERTAR BITACORA-------------------------------------------------------------------------------------------

	function insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador)
	{


		$insert_bitacora = "INSERT INTO orden_logistica_bitacora (descripcion, tipo, idorden_logistica, usuario_creador, fecha_creacion, fecha_guardado, visible, coordenadas, valor) VALUES ('$bitacora_descripcion', '$bitacora_tipo', '$id_logisticapasar', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', 'SI', '$coordenadas', '$bitacora_valor')";
		$result_bitacora = mysql_query($insert_bitacora);

		$respuesta_bitacora = ($result_bitacora == 1) ? ";" : "; ERROR en bitacora de tipo: $bitacora_tipo ;";


		return $respuesta_bitacora;
	}


	#----------------------------------------------------------INSERTAR VIN-------------------------------------------------------------------------------------------

	function insertVIN($tipo_orden, $vin, $marca, $version, $color, $tipo_unidad, $idasigna, $tipo_asignante,  $idpersona_asignada, $tipopersona_asignada, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $usuario_creador)
	{

		for ($i = 0; $i < sizeof($vin); $i++) {

			$ver_inset_vin = buscar_vin($vin[$i], $id_logisticapasar);


			if ($ver_inset_vin == 1) {

				if (trim($vin[$i]) != "") {

					$id_ejecutivo = ($ejecutivo_traslado == "") ? "" : $ejecutivo_traslado;
					$vertipo_vin_isert = ($tipo_unidad[$i] == "Indefinido") ? "Pendiente" : $tipo_unidad[$i];

					$insert_vin = "INSERT INTO orden_logistica_unidades (tipo_orden, vin, tipo_unidad, idresponsable, tipo_responsable, idpersona_asignada, tipopersona_asignada, idorden_logistica, visible, usuario_creador, fecha_creacion, fecha_guardado) VALUES ('" . $tipo_orden[$i] . "', '" . $vin[$i] . "', '$vertipo_vin_isert', '$idasigna', '$tipo_asignante', '" . $idpersona_asignada[$i] . "', '" . $tipopersona_asignada[$i] . "', '$id_logisticapasar', 'SI','$usuario_creador','$fecha_creacion','$fecha_guardado')";
					$result_vin = mysql_query($insert_vin);





					$vine = $vin[$i];
					$respuesta_vin .= ($result_vin == 1) ? ";" : "- ERROR al insertar $vine ";
					$tipo_vine = $tipo_unidad[$i];
					$tipo_responsable_unidad_vine = $tipo_responsable_unidad[$i];



					$recibir_vin = $vin[$i];

					if ($tipo_unidad[$i] == "Utilitario") {
						$es_utilitaria .= unidadesUtilitarias($recibir_vin);
						$bitacora_descripcion = "Se Asignó La Unidad Utilitaria con el VIN <b>" . $recibir_vin . "</b>";
					} else {
						$es_utilitaria = ";";
						$bitacora_descripcion = "Se Asignó La Unidad con el VIN <b>" . $recibir_vin . "</b>";
					}


					$bitacora_tipo = "VIN";
					$bitacora_valor = "7";
					$insert_bitacora_ayudante_notificacion = insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador);

					if ($tipo_unidad[$i] == "Indefinido") {

						$insert_inventario = "INSERT INTO orden_logistica_inventario (tipo_unidad_inventario, vin, marca, version, color, modelo, idorden_logistia, estatus_unidad, tipo, visible, fecha_creacion, fecha_guardado) VALUES ('" . $tipo_unidad[$i] . "', '" . $vin[$i] . "', '" . $marca[$i] . "', '" . $version[$i] . "', '" . $color[$i] . "', '" . $modelo[$i] . "', '" . $id_logisticapasar . "', 'NO', 'Logistica', 'SI', '$fecha_creacion', '$fecha_guardado')";
						$result_inventario = mysql_query($insert_inventario);

						$respuesta_vin .= ($result_inventario == 1) ? ";" : " ERROR al insertar $vin[$i] a Nuevo inventario";
					}
				} //vin vacio
			} //vin duplicado
		} //for

		$vines_insertados = $respuesta_vin . $es_utilitaria . $insert_bitacora_ayudante_notificacion;

		return $vines_insertados;
	}

	#----------------------------------------------------------ACTUALIZAR UNIDADES UTILITARIAS-------------------------------------------------------------------------------------------
	function unidadesUtilitarias($recibir_vin)
	{

		$query_vin = "SELECT * FROM catalogo_unidades_utilitarios WHERE vin like '%$recibir_vin%'";
		$result_vin = mysql_query($query_vin);


		while ($row_vin = mysql_fetch_array($result_vin)) {
			$idcatalogo_unidades_utilitarios = "$row_vin[idcatalogo_unidades_utilitarios]";


			$query_update_unidades = "UPDATE catalogo_unidades_utilitarios SET estatus_unidad = 'En Ruta' WHERE idcatalogo_unidades_utilitarios = '$idcatalogo_unidades_utilitarios'";
			$result_update_unidades = mysql_query($query_update_unidades);

			$result_update_vin .= ($result_update_unidades == 1) ? ";" : "Error al actualizar $vin";
		}


		return $result_update_vin;
	}


	#----------------------------------------------------------CONSULTAS-------------------------------------------------------------------------------------------
	function whatsappAyudantes($id_logisticapasar, $idasigna, $tipo_asignante, $nombre_trasladista_principal, $municipio_origen, $estado_origen, $municipio_destino, $estado_destino, $encript_logistic)
	{


		$query_ayudantes = "SELECT * FROM orden_logistica_ayudante WHERE visible = 'SI' and idorden_logistica = '$id_logisticapasar'";
		$result_ayudantes = mysql_query($query_ayudantes);

		if (mysql_num_rows($result_ayudantes) == 0) {
			$whatsapp_ayudantes = "|";
		} else {

			while ($row_ayudantes = mysql_fetch_array($result_ayudantes)) {
				#recuperar numero de Ayudantes si trae	

				$id_colaborador_name = trim("$row_ayudantes[id_colaborador_proveedor]");
				$tipo_colaborador_name = trim("$row_ayudantes[tipo]");

				$recuperar_numero = name_usuario($id_colaborador_name, $tipo_colaborador_name);
				$porciones_trim = explode("/", $recuperar_numero);

				$nomenclatura_ayudante = $porciones_trim[1];
				$tipo_ayudante = $porciones_trim[2];
				$numero_ayudante = trim($porciones_trim[3]);
				#traer la nomenclatura de trasladista principal

				$nomenclatura_trasladista_principal = ($idasigna == "") ? "(Trasladista Pendiente)" : $nombre_trasladista_principal;


				$mensaje = ($tipo_ayudante == "Colaborador") ? "*$nomenclatura_ayudante* Acompañaras a *$nomenclatura_trasladista_principal* a un traslado de *$municipio_origen, $estado_origen* a *$municipio_destino, $estado_destino* Orden No. *$id_logisticapasar* https://www.panamotorscenter.com/Des/CCP/Perfiles2/Logistica/orden_logistica_detalles.php?idib=$encript_logistic" : "*$nomenclatura_ayudante* usted tiene un número de orden. *$id_logisticapasar*, de logística para cualquier duda o aclaración";



				$whatsapp_ayudantes .= "https://api.whatsapp.com/send?phone=$numero_ayudante&text=$mensaje" . "|";
			}
		}
		return $whatsapp_ayudantes;
	}

	#----------------------------------------------------------CONSULTAS Nombres-------------------------------------------------------------------------------------------


	function name_usuario($id_id, $id_type)
	{

		$id_id = trim($id_id);
		$id_type = trim($id_type);

		if ($id_type == "Colaborador") {

			$query_name_colaborador = "SELECT * FROM empleados where idempleados = '$id_id'";
			$result_name_colaborador = mysql_query($query_name_colaborador);

			if (mysql_num_rows($result_name_colaborador) >= 1) {

				while ($row_colaborador = mysql_fetch_array($result_name_colaborador)) {

					if (is_numeric($row_colaborador[telefono_empresa]) and $row_colaborador[telefono_empresa] != "" and $row_colaborador[telefono_empresa] != null) {

						$phone_number =  "521$row_colaborador[telefono_empresa]";
					} elseif (is_numeric($row_colaborador[telefono_personal]) and $row_colaborador[telefono_personal] != "" and $row_colaborador[telefono_personal] != null) {

						$phone_number =  "521$row_colaborador[telefono_personal]";
					} else {

						$phone_number = "520000000000";
					}

					$name_name = "$row_colaborador[idempleados]/$row_colaborador[columna_b]/Colaborador/$phone_number";
				}
			} else {

				$name_name = "Colaborador/Colaborador/Colaborador/Colaborador";
			}
		} elseif ($id_type == "Cliente") {

			$query_name_cliente = "SELECT * FROM contactos WHERE idcontacto = '$id_id'";
			$result_name_cliente = mysql_query($query_name_cliente);

			if (mysql_num_rows($result_name_cliente) >= 1) {

				while ($row_cliente = mysql_fetch_array($result_name_cliente)) {

					if (is_numeric($row_cliente[telefono_celular]) and $row_cliente[telefono_celular] != "" and $row_cliente[telefono_celular] != null) {

						$phone_number =  "521$row_cliente[telefono_celular]";
					} elseif (is_numeric($row_cliente[telefono_otro]) and $row_cliente[telefono_otro] != "" and $row_cliente[telefono_otro] != null) {

						$phone_number =  "521$row_cliente[telefono_otro]";
					} else {

						$phone_number = "520000000000";
					}

					$name_name = "$row_cliente[idcontacto]/$row_cliente[nombre] $row_cliente[apellidos]/Cliente/$phone_number";
				}
			} else {

				$name_name = "Cliente/Cliente/Cliente/Cliente";
			}
		} elseif ($id_type == "Proveedor") {

			$query_name_proveedor = "SELECT * FROM proveedores WHERE idproveedores = '$id_id'";
			$result_name_proveedor = mysql_query($query_name_proveedor);

			if (mysql_num_rows($result_name_proveedor) >= 1) {

				while ($row_proveedor = mysql_fetch_array($result_name_proveedor)) {

					if (is_numeric($row_proveedor[telefono_celular]) and $row_proveedor[telefono_celular] != "" and $row_proveedor[telefono_celular] != null) {

						$phone_number =  "521$row_proveedor[telefono_celular]";
					} elseif (is_numeric($row_proveedor[telefono_otro]) and $row_proveedor[telefono_otro] != "" and $row_proveedor[telefono_otro] != null) {

						$phone_number =  "521$row_proveedor[telefono_otro]";
					} else {

						$phone_number = "520000000000";
					}

					$name_name = "$row_proveedor[idproveedores]/$row_proveedor[nombre] $row_proveedor[apellidos]/Proveedor/$phone_number";
				}
			} else {

				$name_name = "Proveedor/Proveedor/Proveedor/Proveedor";
			}
		} elseif ($id_type == "Proveedor Temporal") {

			$query_name_proveedor_temporal = "SELECT * FROM orden_logistica_proveedores WHERE idorden_logistica_proveedores = '$id_id'";
			$result_name_proveedor_temporal = mysql_query($query_name_proveedor_temporal);

			if (mysql_num_rows($result_name_proveedor_temporal) >= 1) {

				while ($row_proveedor_temporal = mysql_fetch_array($result_name_proveedor_temporal)) {

					if (is_numeric($row_proveedor_temporal[telefono_celular]) and $row_proveedor_temporal[telefono_celular] != "" and $row_proveedor_temporal[telefono_celular] != null) {

						$phone_number =  "521$row_proveedor_temporal[telefono_celular]";
					} elseif (is_numeric($row_proveedor_temporal[telefono_otro]) and $row_proveedor_temporal[telefono_otro] != "" and $row_proveedor_temporal[telefono_otro] != null) {

						$phone_number =  "521$row_proveedor_temporal[telefono_otro]";
					} else {

						$phone_number = "520000000000";
					}

					$name_name = "$row_proveedor_temporal[idorden_logistica_proveedores]/$row_proveedor_temporal[nombre] $row_proveedor_temporal[apellidos]/Proveedor Temporal/$phone_number";
				}
			} else {

				$name_name = "Proveedor Temporal/Proveedor Temporal/Proveedor Temporal/Proveedor Temporal";
			}
		} else {

			$name_name = "Nada/Nada/Nada/Nada";
		}

		return $name_name;
	}
	#----------------------------------------------------------Funcion Verificar duplicidad de VIN-------------------------------------------------------------------------------------------

	function buscar_principal_ayudantes($idtrasladista_ayudante, $tipo_trasladista_ayudante, $pasar_id_logistica)
	{

		$idtrasladista_ayudante = trim($idtrasladista_ayudante);
		$tipo_trasladista_ayudante = trim($tipo_trasladista_ayudante);
		$pasar_id_logistica = trim($pasar_id_logistica);

		$query_trasladista = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$pasar_id_logistica' and trim(idasigna) = '$idtrasladista_ayudante' and trim(tipo_asignante) = '$tipo_trasladista_ayudante'";
		$result_trasladista = mysql_query($query_trasladista);

		if (mysql_num_rows($result_trasladista) >= 1) {

			$resultado_ayudante = "0";
		} else {

			$query_buscar_ayudante = "SELECT * FROM orden_logistica_ayudante WHERE idorden_logistica = '$pasar_id_logistica' AND id_colaborador_proveedor = '$idtrasladista_ayudante' and trim(tipo) = '$tipo_trasladista_ayudante'";
			$result_buscar_ayudante = mysql_query($query_buscar_ayudante);

			if (mysql_num_rows($result_buscar_ayudante) >= 1) {

				$resultado_ayudante = "0";
			} else {

				$resultado_ayudante = "1";
			}
		}

		return $resultado_ayudante;
	}
	#----------------------------------------------------------Funcion Verificar duplicidad de Personal dentro de logistica------------------------------------------------------------------------------------------

	function buscar_vin($vin_search, $id_search_logistica)
	{

		$vin_search = trim($vin_search);
		$id_search_logistica = trim($id_search_logistica);

		$query_search_vin = "SELECT * FROM orden_logistica_unidades WHERE trim(vin) = '$vin_search' and idorden_logistica = '$id_search_logistica' ";
		$result_search_vin = mysql_query($query_search_vin);

		$resultado_vin = (mysql_num_rows($result_search_vin) >= 1) ? "0" : "1";

		return $resultado_vin;
	}
	#-------------------------------------------Funcion Nombres y Tipo--------------------------------------------------------------------------------

	function nombres_datos($id_id, $type_type)
	{

		$id_id = trim($id_id);
		$type_type = trim($type_type);

		if ($type_type == "Cliente") {

			$query_cliente = "SELECT * FROM contactos WHERE idcontacto = '$id_id'";
			$result_cliente = mysql_query($query_cliente);

			if (mysql_num_rows($result_cliente) >= 1) {

				while ($row_cliente = mysql_fetch_array($result_cliente)) {
					$nombre = "$row_cliente[nombre]";
					$apellidos = "$row_cliente[apellidos]";
					$alias = "$row_cliente[alias]";
					$telefono = "$row_cliente[telefono_celular]";
					$telefono_otro = "$row_cliente[telefono_otro]";
					$estado_cliente = "$row_cliente[estado]";
					$municipio_cliente = "$row_cliente[delmuni]";
					$calle_cliente = "$row_cliente[calle]";
					$colonia_cliente = "$row_cliente[colonia]";
					$cp_cliente = "$row_cliente[cp_cliente]";
				}
				$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Cliente|Pendiente";
			} else {
				$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Cliente|Pendiente";
			}
		} elseif ($type_type == "Proveedor") {

			$query_proveedor = "SELECT * FROM proveedores WHERE idproveedores = '$id_id'";
			$result_proveedor = mysql_query($query_proveedor);

			if (mysql_num_rows($result_proveedor) >= 1) {

				while ($row_proveedor = mysql_fetch_array($result_proveedor)) {
					$nombre = trim("$row_proveedor[nombre]");
					$apellidos = trim("$row_proveedor[apellidos]");
					$alias = trim("$row_proveedor[alias]");
					$telefono = trim("$row_proveedor[telefono_celular]");
					$telefono_otro = trim("$row_proveedor[telefono_otro]");
					$estado_cliente = trim("$row_proveedor[estado]");
					$municipio_cliente = trim("$row_proveedor[delmuni]");
					$calle_cliente = trim("$row_proveedor[calle]");
					$colonia_cliente = trim("$row_proveedor[colonia]");
					$cp_cliente = trim("$row_proveedor[cp_cliente]");
					$condicion_proveedor = trim("$row_proveedor[col10]");
				}
				$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor|$condicion_proveedor";
			} else {
				$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor|Pendiente";
			}
		} elseif ($type_type == "Proveedor Temporal") {

			$query_proveedor_tem = "SELECT * FROM orden_logistica_proveedores WHERE idorden_logistica_proveedores = '$id_id'";
			$result_proveedor_tem = mysql_query($query_proveedor_tem);

			if (mysql_num_rows($result_proveedor_tem) >= 1) {

				while ($row_proveedor_tem = mysql_fetch_array($result_proveedor_tem)) {
					$nombre = trim("$row_proveedor_tem[nombre]");
					$apellidos = trim("$row_proveedor_tem[apellidos]");
					$alias = trim("$row_proveedor_tem[alias]");
					$telefono = trim("$row_proveedor_tem[telefono_celular]");
					$telefono_otro = trim("$row_proveedor_tem[telefono_otro]");
					$estado_cliente = trim("$row_proveedor_tem[estado]");
					$municipio_cliente = trim("$row_proveedor_tem[delmuni]");
					$calle_cliente = trim("$row_proveedor_tem[calle]");
					$colonia_cliente = trim("$row_proveedor_tem[colonia]");
					$cp_cliente = trim("$row_proveedor_tem[codigo_postal]");
				}
				$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor Temporal|Pendiente";
			} else {
				$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor Temporal|Pendiente";
			}
		} elseif ($type_type == "Colaborador") {

			$query_colaborador = "SELECT * FROM empleados WHERE idempleados = '$id_id'";
			$result_colaborador = mysql_query($query_colaborador);

			if (mysql_num_rows($result_colaborador) >= 1) {

				while ($row_colaborador = mysql_fetch_array($result_colaborador)) {
					$nombre = "$row_colaborador[nombre]";
					$apellidos = trim("$row_colaborador[apellido_paterno]") . " " . trim("$row_colaborador[apellido_materno]");
					$alias = trim("$row_colaborador[columna_b]");
					$telefono = trim("$row_colaborador[telefono_empresa]");
					$telefono_otro = trim("$row_colaborador[telefono_emergencia]");
					$estado_cliente = trim("$row_colaborador[estado]");
					$municipio_cliente = trim("$row_colaborador[municipio]");
					$calle_cliente = trim("$row_colaborador[calle_numero]");
					$colonia_cliente = trim("$row_colaborador[colonia]");
					$cp_cliente = trim("$row_colaborador[cp]");
					$nomenclatura_co = trim("$row_colaborador[columna_b]");
					$puesto_actual = trim("$row_colaborador[puesto_actual]");
				}
				$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Colaborador|Pendiente|$puesto_actual";
			} else {
				$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Colaborador|Pendiente|Pendiente";
			}
		} elseif ($type_type == "Proveedor Info") {

			$query_proveedor_info = "SELECT * FROM proveedores_info WHERE idproveedores_info = '$id_id'";
			$result_proveedor_info = mysql_query($query_proveedor_info);

			if (mysql_num_rows($result_proveedor_info) >= 1) {

				while ($row_proveedor_info = mysql_fetch_array($result_proveedor_info)) {
					$nombre = "$row_proveedor_info[nombre]";
					$apellidos = trim("$row_proveedor_info[apellidos]");
					$alias = trim("$row_proveedor_info[alias]");
					$telefono = trim("$row_proveedor_info[telefono_celular]");
					$telefono_otro = trim("$row_proveedor_info[telefono_otro]");
					$estado_cliente = trim("$row_proveedor_info[estado]");
					$municipio_cliente = trim("$row_proveedor_info[delmuni]");
					$calle_cliente = trim("$row_proveedor_info[colonia]");
					$colonia_cliente = trim("$row_proveedor_info[calle]");
					$cp_cliente = trim("$row_proveedor_info[codigo_postal]");
					$condicion_proveedor_info = trim("$row_proveedor_info[tipo]");
				}
				$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor Info|$condicion_proveedor_info";
			} else {
				$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor Info|Pendiente";
			}
		} elseif ($type_type == "Prospectos") {

			$query_prospectos = "SELECT * FROM proveedores_info WHERE idproveedores_info = '$id_id'";
			$result_prospectos = mysql_query($query_prospectos);

			if (mysql_num_rows($result_prospectos) >= 1) {

				while ($row_prospectos = mysql_fetch_array($result_prospectos)) {
					$nombre = "$row_prospectos[nombre]";
					$apellidos = trim("$row_prospectos[apellidos]");
					$alias = trim("$row_prospectos[alias]");
					$telefono = trim("$row_prospectos[telefono_celular]");
					$telefono_otro = trim("$row_prospectos[telefono_otro]");
					$estado_cliente = trim("$row_prospectos[estado]");
					$municipio_cliente = trim("$row_prospectos[delmuni]");
					$calle_cliente = trim("$row_prospectos[colonia]");
					$colonia_cliente = trim("$row_prospectos[calle]");
					$cp_cliente = trim("$row_prospectos[codigo_postal]");
				}
				$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Prospectos|Pendiente";
			} else {
				$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Prospectos|Pendiente";
			}
		} else {
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente";
		}

		return $concatenacion;
	}

	#----------------------------------------------------------  -------------------------------------------------------------------------------------------




	?>

	<script>
		var si_error_no = '<?php echo $ver_errores; ?>'
		var numeros_whats = '<?php echo $whatsapp_colaboradores; ?>'
		var idlogistica = '<?php echo $idlogistica_encriptada; ?>'

		if (si_error_no == "Sin Errores") {
			$('#success_alert').show();
			$("#content-contador").show();
			var porciones = numeros_whats.split('|');
			var contador = porciones.length;


			if (contador > 0) {

				porciones.forEach(myFunction);
				var sumar = 0;

				function myFunction(item, index) {

					if (item != "") {

						open(item, index, `width=600, height=600, left=${sumar}, top=300`);
						var sumar = sumar + 300;
						// setInterval(ordenLogistica(idlogistica), 9000);
						redireccionPagina();

					} else {
						// setInterval(ordenLogistica(idlogistica), 9000);
						redireccionPagina();
					}


				}



			} else {
				// setInterval(ordenLogistica(idlogistica), 9000);
				redireccionPagina();
			}







		} else if (si_error_no == "Fallo") {
			$('#fail_alert').show();
			$("#content-contador").show();
			redireccionPagina();

		} else {
			$('#alert_alert').show();
			$("#content-contador").hide();

			var extraer_warnings = si_error_no.split('|');

			extraer_warnings.forEach(agregarWarnings);
			var sumar = 0;

			function agregarWarnings(val, contador) {

				$(".neu-alert-error-tipo").prepend("<p class='text-white text-center mb-0' style='position: relative; z-index: 2;'>" + val + "</p>");

			}

		}


		$(document).ready(function() {
			$("#continuar").click(function() {
				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
			});

			$("#yes").click(function() {
				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#example`);
			});

			$("#nel").click(function() {
				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
			});
		});

		function redireccionPagina() {
			delayPagina();
			contadorRedirigir();
		}

		function delayPagina() {
			var delay = 3000;
			setTimeout(() => {
				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
			}, delay);
		}

		function contadorRedirigir() {
			$('.numero-contador').each(function() {
				$(this).prop('Counter', 3).animate({
					Counter: $(this).text()
				}, {
					duration: 3000,
					easing: 'swing',
					step: function(now) {
						$(this).text(Math.ceil(now));
					}
				});
			});
		}

		const neu_animation_container = document.querySelector(".neu-animation-container");
		neu_animation_container.classList.add("add-neu-animation-container");
	</script>




</body>

</html>