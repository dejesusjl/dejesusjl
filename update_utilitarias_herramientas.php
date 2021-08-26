<?php
session_start();
include_once "../../config.php";
include_once "../../recuperar_usuario.php";
$usuario_creador = $_SESSION['usuario_clave'];

date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");

?>

<!doctype html>
<html lang="en-gb" class="no-js">

<head>
	<title>CCP | Actualizar Herramientas </title>

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
						<h1>Utilitaria Actualizada EXITOSAMENTE</h1>
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



	$vin = trim($_POST['vin']);
	$valor = trim($_POST['valor']);
	$tipo = trim($_POST['tipo']);
	$descripcion = trim($_POST['descripcion']);
	$idorden = trim($_POST['idorden']);
	$tipo_orden = trim($_POST['tipo_orden']);
	$fecha_a = trim($_POST['fecha_a']);
	$columna_a = trim($_POST['columna_a']);
	$columna_b = trim($_POST['columna_b']);
	$fecha_vencimiento = trim($_POST['fecha_vencimiento']);
	$comentarios = trim($_POST['comentarios']);
	$fecha_creacion = trim($_POST['fecha_creacion']);
	$estatus = trim($_POST['estatus']);


	$fecha_vencimiento = ($_POST['fecha_vencimiento'] == "") ? "0001-01-01" : $_POST['fecha_vencimiento'] ;
	$fecha_a = ($_POST['fecha_a'] == "") ? "0001-01-01" : $_POST['fecha_a'] ;

	$idlogistica_encriptada = base64_encode($vin);


	$id_colaborador = $id_trasladista;



	$query_herramientas_old = "SELECT * FROM unidades_utilitarios_herramientas WHERE vin = '$vin' and tipo = '$tipo' and visible = 'SI'";
	$result_herramientas_old = mysql_query($query_herramientas_old);

	if (mysql_num_rows($result_herramientas_old) == 0) {


		$insert_herramientas = "INSERT INTO unidades_utilitarios_herramientas (vin, valor, tipo, descripcion, idorden, tipo_orden, fecha_a, columna_a, columna_b, fecha_vencimiento, comentarios, fecha_creacion, estatus, fecha_guardado) VALUES ('$vin','$valor','$tipo','$descripcion','$idorden','$tipo_orden','$fecha_a','$columna_a','$columna_b','$fecha_vencimiento','$comentarios','$fecha_creacion', '$estatus', '$fecha_guardado')";
		$result_insert_herramientas = mysql_query($insert_herramientas);

		if ($result_insert_herramientas == 1) {
			$ver_errores = "Sin Errores";
		}else{
			$ver_errores = "Fallo";
		}

	}else{
		$ver_errores = "<h1>Ya hay datos</h1>";
	}





	?>
	<script>

		var si_error_no = '<?php echo $ver_errores; ?>'
		var idlogistica = '<?php  echo $idlogistica_encriptada;?>'


		if (si_error_no == "Sin Errores") {

			$("#success_alert").show();
			setInterval(ordenLogistica(idlogistica), 5000);

		}else if (si_error_no == "Fallo") {
			$("#fail_alert").show();

			setInterval(salir, 5000);


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
			location.replace(`unidades_utilitarias_detalles.php?vn=${idlogistica}`);
		}

		function ordenLogistica(idlogistica){
			location.replace(`unidades_utilitarias_detalles.php?vn=${idlogistica}`);
		}

		$(document).ready(function(){
			$("#continuar").click(function(){
				location.replace(`unidades_utilitarias_detalles.php?vn=${idlogistica}`);
			});

			$("#yes").click(function(){
				location.replace(`unidades_utilitarias_detalles.php?vn=${idlogistica}`);
			});

			$("#nel").click(function(){
				location.replace(`unidades_utilitarias_detalles.php?vn=${idlogistica}`);
			});
		});


	</script>




</body>
</html>
