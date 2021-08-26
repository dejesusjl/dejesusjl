<?php
session_start();
include_once "../../config.php";
include_once "../../recuperar_usuario.php";
include_once "../../recuperar_usuario.php";
include_once "funciones_principales_insert.php";
$usuario_creador = $_SESSION['usuario_clave'];
date_default_timezone_set('America/Mexico_City');


?>

<!doctype html>
<html lang="en-gb" class="no-js">

<head>
	<title>CCP | Guardar Herramientas </title>

	<link href="../../css/bootstrap.min.css" rel="stylesheet">
	<link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="../../css/animate.css" rel="stylesheet">
	<link href="../../css/style.css" rel="stylesheet">
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

<body class="category-page construccion">

	<div class="columns-container">
		<div class="container" id="columns">
			<div class="row">
				<br><br>
				<center><span class="image-construccion"><img src="../../img/300X300.png" alt=""></span></center>

				<br><br><br><br><br>

				<center>
					<div class="alert alert-success" role="alert" id="success_alert" style="display: none;">
						<h1>Datos Gardados EXITOSAMENTE</h1>
					</div>

					<div class="alert alert-danger" role="alert" id="fail_alert" style="display: none;">
						<h1>Se ha producido un ERROR al guardar la información</h1>



					</div>

					<div class="alert alert-info" role="alert" id="alert_alert" style="display: none;">

						<h4>Error al:</h4>


					</div>

				</center>


			</div>
		</div>
	</div>
	<?php

	$fecha_creacion = $_POST['fecha_creacion'];
	$vin_array = $_POST['soy_vin'];
	$tipo_array = $_POST['tipo'];
	$descripcion_array = $_POST['descripcion'];
	$idorden_array = $_POST['idorden'];
	$tipo_orden_array = $_POST['tipo_orden'];
	$fecha_a_array = $_POST['fecha_a'];
	$fecha_vencimiento_array = $_POST['fecha_vencimiento'];
	$columna_a_array = $_POST['columna_a'];
	$columna_b_array = $_POST['columna_b'];
	$columna_c_array = $_POST['columna_c'];
	$columna_d_array = $_POST['columna_d'];
	$estatus_array = $_POST['estatus'];
	$evidencia_array = $_POST['evidencia'];
	$comentarios_array = $_POST['comentarios'];
	







	for ($i=0; $i < count($vin_array); $i++) {

		$vin = trim($vin_array[$i]);
		$tipo = trim($tipo_array[$i]);
		$descripcion = trim($descripcion_array[$i]);
		$idorden = trim($idorden_array[$i]);
		$tipo_orden = trim($tipo_orden_array[$i]);
		$fecha_a = trim($fecha_a_array[$i]);
		$fecha_vencimiento = trim($fecha_vencimiento_array[$i]);
		$columna_a = trim($columna_a_array[$i]);
		$columna_b = trim($columna_b_array[$i]);
		$columna_c = trim($columna_c_array[$i]);
		$columna_d = str_replace(",","",trim($columna_d_array[$i]));
		$estatus = trim($estatus_array[$i]);
		$comentarios = trim($comentarios_array[$i]);
		$fecha_guardado = date("Y-m-d H:i:s");
		$visible = "SI";


		if ($vin != "") {

			$fecha_vencimiento = ($fecha_vencimiento == "") ? "0001-01-01" : $fecha_vencimiento ;
			$fecha_a = ($fecha_a == "") ? "0001-01-01" : $fecha_a ;
			$fecha_b = ($fecha_b == "") ? "0001-01-01" : $fecha_b ;

			$query_herramientas_old = "SELECT * FROM unidades_utilitarios_herramientas WHERE trim(vin) = '$vin' and tipo = '$tipo' and visible = 'SI' and fecha_creacion = '$fecha_creacion'";
			$result_herramientas_old = mysql_query($query_herramientas_old);

			if (mysql_num_rows($result_herramientas_old) == 0) {

				$ruta_archivo = "../../Documentacion_Logistica/Poliza_GPS_Utilitarias/";
				$nomenclatura_archivo_name = $tipo."_".$vin."_Usr_".$usuario_creador;
				$name_input_file = "evidencia";

				$file_ruta = ($_FILES[$name_input_file]['name'][$i] != "") ? CargarImagenEvidenciaArray ($ruta_archivo, $nomenclatura_archivo_name, $name_input_file, $i) : "";

				$pasar_ruta = ($file_ruta == "- Ocurrio un error al mover la Evidencia <br>" || $file_ruta == "La carpeta $ruta_archivo no existe" || $file_ruta == "" ) ? "" : $file_ruta;



				$query_insert_herramientas = "INSERT INTO unidades_utilitarios_herramientas (vin, valor, tipo, descripcion, idorden, tipo_orden, estatus, comentarios, fecha_vencimiento, visible, usuario_creador, fecha_creacion, fecha_guardado, columna_a, columna_b, columna_c, columna_d, columna_e, columna_f, columna_g, columna_h, columna_i, columna_j, columna_k, columna_l, fecha_a, fecha_b) VALUES ('$vin', '$pasar_ruta', '$tipo', '$descripcion', '$idorden', '$tipo_orden', '$estatus', '$comentarios', '$fecha_vencimiento', '$visible', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$columna_a', '$columna_b', '$columna_c', '$columna_d', '$columna_e', '$columna_f', '$columna_g', '$columna_h', '$columna_i', '$columna_j', '$columna_k', '$columna_l', '$fecha_a', '$fecha_b')";
				$result_query_insert_herramientas = mysql_query($query_insert_herramientas);


				if ($result_query_insert_herramientas == 1) {
					$insert_bitacora = UtilitariasInsertarBitacora ("Se agrego <b>$tipo</b> a el vin <b>$vin</b> con <b>$descripcion</b>", $tipo, $vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, "3", "", "", "", $visible);
					$valor_mensajes ++;
				}else {

					$valor_mensajes .= "-Insertar el VIN: <b>$vin</b> de tipo: <b>$tipo</b> en $descripcion<br>";
				}

			}else{

				$valor_mensajes .= "- Intentas duplicar el VIN: <b>$vin</b> de tipo: <b>$tipo</b> en $descripcion<br>";

			}


		}
	}



	if ($valor_mensajes == "") {

		$ver_errores = "Fallo";

	}elseif (is_numeric($valor_mensajes)) {

		$ver_errores = "Sin Errores";

	}else {
		$ver_errores = $valor_mensajes;
	}




	?>
	<script>

		var si_error_no = '<?php echo $ver_errores; ?>'
		var idlogistica = '<?php  echo $idlogistica_encriptada;?>'


		if (si_error_no == "Sin Errores") {

			$("#success_alert").show();
			setInterval(ordenLogistica(idlogistica), 1000);

		}else if (si_error_no == "Fallo") {
			$("#fail_alert").show();

			setInterval(salir, 1000);


		}else{
			$("#alert_alert").show();

			$("#alert_alert").append(si_error_no);


			var create = `
			<div class="col-sm-12">
			<div class="form-group">
			<div class="col-lg-12">
			<br>
			<center>
			<button class="btn btn-lg btn-primary" id="continuar">Continuar</button>
			</center>
			<br>
			</div>
			</div>
			</div>
			`;

			$("#alert_alert").append(create);
		}


		function salir(){
			location.replace(`detalle_utilitarias.php`);
		}

		function ordenLogistica(idlogistica){
			location.replace(`detalle_utilitarias.php`);
		}

		$(document).ready(function(){
			$("#continuar").click(function(){
				location.replace(`detalle_utilitarias.php`);
			});

			$("#yes").click(function(){
				location.replace(`detalle_utilitarias.php`);
			});

			$("#nel").click(function(){
				location.replace(`detalle_utilitarias.php`);
			});
		});


	</script>




</body>
</html>
