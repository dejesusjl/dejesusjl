<?php
session_start();
include_once "../../config.php";
include_once "../../recuperar_usuario.php";
$usuario_creador=$_SESSION['usuario_clave'];
?>

<!doctype html>
<html lang="en-gb" class="no-js">

<head>
	<title>CCP | Actualizar VIN </title>

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
	$matricula = trim($_POST['matricula']);
	$entidad = trim($_POST['entidad']);
	$engomado = trim($_POST['engomado']);
	$id_trasladista = trim($_POST['id_trasladista']);
	$tipo_trasladista = trim($_POST['tipo_trasladista']);
	$comentarios = trim($_POST['comentarios']);
	$fecha_creacion = $_POST['fecha_creacion'];
	$valor_bitacora = 0;

	$idlogistica_encriptada = base64_encode($vin);

	date_default_timezone_set('America/Mexico_City');
	$fecha_guardado = date("Y-m-d H:i:s");
	$usuario_creador = $_SESSION['usuario_clave'];

	$id_colaborador = $id_trasladista;
	$nombre_nuevo = name_colaborador ($id_colaborador);


	$query_utilitario = "SELECT * FROM catalogo_unidades_utilitarios WHERE TRIM(vin) = '$vin'";
	$result_utilitario = mysql_query($query_utilitario);

	while ($row_utilitario = mysql_fetch_array($result_utilitario)) {
		$idcatalogo_unidades_utilitarios = $row_utilitario[idcatalogo_unidades_utilitarios];
		$vin_bd = trim($row_utilitario[vin]);
		$matricula_bd = trim($row_utilitario[matricula]);
		$entidad_bd = trim($row_utilitario[entidad]);
		$engomado_bd = trim($row_utilitario[tipo_uso]);
		$id_trasladista_bd = trim($row_utilitario[comentario]);

		if ($matricula_bd != $matricula) {
			$descripcion = "La matrícula cambio de <b>$matricula_bd</b> por <b>$matricula</b>";
			$tipo = "Matrícula";
			$valor = 1;
			$ver_insert = inserBitacora ($descripcion, $tipo, $vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $valor);
			$valor_bitacora .= (is_numeric($ver_insert)) ?  $valor_bitacora ++ : $ver_insert ;

		}

		if ($entidad_bd != $entidad) {
			$descripcion = "La entidad cambio de <b>$entidad_bd</b> por <b>$entidad</b>";
			$tipo = "Entidad";
			$valor = 1;
			$ver_insert = inserBitacora ($descripcion, $tipo, $vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $valor);
			$valor_bitacora .= (is_numeric($ver_insert)) ?  $valor_bitacora ++ : $ver_insert ;

		}

		if ($engomado_bd != $engomado) {
			$descripcion = "El engomado cambio de <b>$engomado_bd</b> por <b>$engomado</b>";
			$tipo = "Engomado";
			$valor = 1;
			$ver_insert = inserBitacora ($descripcion, $tipo, $vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $valor);
			$valor_bitacora .= (is_numeric($ver_insert)) ?  $valor_bitacora ++ : $ver_insert ;

		}

		if ($id_trasladista_bd != $id_trasladista) {

			if (is_numeric($id_trasladista_bd)) {

				$id_colaborador = trim($row_utilitario[comentario]);
				$name_old = name_colaborador ($id_colaborador);

			}else{
				$name_old = trim($row_utilitario[comentario]);
			}


			$descripcion = "El VIN cambio de propietario de <b>$name_old</b> por <b>$nombre_nuevo</b>";
			$tipo = "Propietario";
			$valor = 1;
			$ver_insert = inserBitacora ($descripcion, $tipo, $vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $valor);
			$valor_bitacora .= (is_numeric($ver_insert)) ?  $valor_bitacora ++ : $ver_insert ;

		}


	}

	$sumatoria = $valor_bitacora;


	 $update_utilitarias = "UPDATE catalogo_unidades_utilitarios SET matricula = '$matricula', entidad='$entidad', tipo_uso = '$engomado', comentario = '$id_trasladista' WHERE idcatalogo_unidades_utilitarios = '$idcatalogo_unidades_utilitarios'";
	$res_update_utilitario = mysql_query($update_utilitarias);

	if ($res_update_utilitario == 1) {

		$ver_errores = (is_numeric($sumatoria)) ? "Sin Errores" : $sumatoria ;


	}else{
		$ver_errores = "Fallo";
	}


	function inserBitacora ($descripcion, $tipo, $vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $valor) {
		$num = 0;

		$insert_bitacora = "INSERT catalogo_unidades_utilitarios_bitacora (descripcion, tipo, vin, comentarios, usuario_creador, fecha_creacion, fecha_guardado, valor, visible) VALUES ('$descripcion', '$tipo', '$vin', '$comentarios', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$valor','SI') ";
		$result_insert = mysql_query($insert_bitacora);

		if ($result_insert == 1) {
			$num ++;
		}else{
			$num = "- Error al cambiar $insert_bitacora <br>";
		}

		return $num;

	}

	function name_colaborador ($id_colaborador) {

		$query_empleados = "SELECT * FROM empleados WHERE idempleados = '$id_colaborador'";
		$result_empleados = mysql_query($query_empleados);

		while ($row_empleados = mysql_fetch_array($result_empleados)) {
			$nomenclatura = $row_empleados[columna_b];
		}
		return $nomenclatura;

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
