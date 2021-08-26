<?php 
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
date_default_timezone_set('America/Mexico_City');
$fecha_guardado=date("Y-m-d H:i:s"); 
$usuario_creador=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);

// Start Querys


$idmovimiento_encriptada = $_REQUEST['id_mov'];
$idorden_logistica_unidades = base64_decode($idmovimiento_encriptada);

$query_id = "SELECT * FROM orden_logistica_unidades WHERE idorden_logistica_unidades = '$idorden_logistica_unidades'";
$result_id = mysql_query($query_id);

while ($row_id = mysql_fetch_array($result_id)) {
	
	$idorden_logistica = $row_id[idorden_logistica];
	
	$idlogistica_encriptada = base64_encode($idorden_logistica);

	$porciones_vin = date_vin($row_id[vin]);
	$date_vin = explode("|", $porciones_vin);

}



Function date_vin($vin) {

	$buscar_vin = trim($vin);


	$query_logistica_unidades = "SELECT * from inventario where TRIM(vin_numero_serie) = '$buscar_vin' and TRIM(estatus_unidad) <> 'Utilitaria' and TRIM(estatus_unidad) <> 'Utilitario'";
	$result_query_logistica_unidades = mysql_query($query_logistica_unidades);

	if (mysql_num_rows($result_query_logistica_unidades) >= 1) {

		while ($row_query_logistica_unidades = mysql_fetch_array($result_query_logistica_unidades)) {
			$marca_logistica = trim("$row_query_logistica_unidades[marca]");
			$version_logistica = trim("$row_query_logistica_unidades[version]");
			$color_logistica = trim("$row_query_logistica_unidades[color]");
			$modelo_logistica = trim("$row_query_logistica_unidades[modelo]");
			$ver_vin = trim("$row_query_logistica_unidades[vin_numero_serie]");
			$id_unidad = trim($row_query_logistica_unidades[idinventario]);
		}

		$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Unidad|$id_unidad";

	}else{

		$query_logistica_trucks = "SELECT * from inventario_trucks where TRIM(vin_numero_serie) = '$buscar_vin' and TRIM(estatus_unidad) <> 'Utilitaria' and TRIM(estatus_unidad) <> 'Utilitario'";
		$result_query_logistica_trucks = mysql_query($query_logistica_trucks);

		if (mysql_num_rows($result_query_logistica_trucks) >= 1) {
			while ($row_query_logistica_trucks = mysql_fetch_array($result_query_logistica_trucks)) {

				$marca_logistica = trim("$row_query_logistica_trucks[marca]");
				$version_logistica = trim("$row_query_logistica_trucks[version]");
				$color_logistica = trim("$row_query_logistica_trucks[color]");
				$modelo_logistica = trim("$row_query_logistica_trucks[modelo]");
				$ver_vin = trim("$row_query_logistica_trucks[vin_numero_serie]");
				$id_unidad = trim($row_query_logistica_trucks[idinventario]);
			}

			$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Trucks|$id_unidad";

		}else{

			$query_logistica_utilitario = "SELECT * from catalogo_unidades_utilitarios where TRIM(vin) = '$buscar_vin'";
			$result_query_logistica_utilitario = mysql_query($query_logistica_utilitario);

			if (mysql_num_rows($result_query_logistica_utilitario) >= 1) {

				while ($row_query_logistica_utilitario = mysql_fetch_array($result_query_logistica_utilitario)) {

					$marca_logistica = trim("$row_query_logistica_utilitario[marca]");
					$version_logistica = trim("$row_query_logistica_utilitario[version]");
					$color_logistica = trim("$row_query_logistica_utilitario[color]");
					$modelo_logistica = trim("$row_query_logistica_utilitario[modelo]");
					$ver_vin = trim("$row_query_logistica_utilitario[vin]");
					$id_unidad = trim($row_query_logistica_utilitario[idcatalogo_unidades_utilitarios]);
					
				}	

				$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Utilitario|$id_unidad";

			}else{

				$query_logistica_inventario = "SELECT * FROM orden_logistica_inventario WHERE TRIM(vin) = '$buscar_vin' and visible = 'SI'";
				$result_logistica_inventario = mysql_query($query_logistica_inventario);

				if (mysql_num_rows($result_logistica_inventario) >= 1) {

					while ($row_logistica_inventario = mysql_fetch_array($result_logistica_inventario)) {
						$marca_logistica = trim("$row_logistica_inventario[marca]");
						$version_logistica = trim("$row_logistica_inventario[version]");
						$color_logistica = trim("$row_logistica_inventario[color]");
						$modelo_logistica = trim("$row_logistica_inventario[modelo]");
						$ver_vin = trim("$row_logistica_inventario[vin]");
						$id_unidad = trim($row_logistica_inventario[idorden_logistica_inventario]);
					}

					$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Indefinido|$id_unidad";

				}else{
					
					$marca_logistica = trim("Por definir");
					$version_logistica = trim("Por definir");
					$color_logistica = trim("Por definir");
					$modelo_logistica = trim("Por definir");
					$ver_vin = trim("Por definir");
					$id_unidad = trim("Por definir");


					$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Por Definir|$id_unidad";
				}						
			}
		}
	}

	return $result_vin;

}





?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="" >
	<meta name="author" content="">
	<meta name="keywords" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="./style2.css">
	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/quicksand.css">
	<link rel="stylesheet" href="../../assets/css/style.css">
	<link rel="stylesheet" href="../../assets/css/alert_popup.css">
	<link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css">
	<link rel="stylesheet" href="../../assets/css/fontawesome.css">
	<link rel="stylesheet" href="../../assets/css/slick/slick.css">
	<link rel="stylesheet" href="../../assets/css/slick/slick-theme.css">
	<link rel="stylesheet" href="../../assets/css/fontawesome-stars.css">
	<link rel="stylesheet" href="../../assets/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../../assets/js/calendar/bootstrap_calendar.css">
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

	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
	
	<!-- DataTables CSS -->
	<link href="../../plugins/datatables/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

	<!-- DataTables Responsive CSS -->
	<link href="../../plugins/datatables/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

	<script src="./script.js"></script>
	<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
	<script src="../../js/jquery-1.10.2.js"></script>
	<script src="../../js/jquery-ui.js"></script>

	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
	-->
	

	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.date.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.time.css">
	<title>CCP | Eliminar VIN</title>
</head>
<body>
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
		<div class="col-sm-9 col-xs-12 content pt-3 p-0">
			<div class="row mt-3 m-0">
				<div class="col-sm-12">
					<div class="mt-1 mb-3 p-3 button-container fondo-container">

						<ol class="breadcrumb fondo-encabezados">
							<li>
								<a class="text-white" href="index.php">Inicio</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li>
								<a class="text-white" href="orden_logistica_detalles.php?idib=<?php echo "$idlogistica_encriptada"; ?>"> Regresar a Logística <b><?php echo "$idorden_logistica" ?></b></a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li  class="active text-white">
								<strong>Eliminar VIN</strong>
							</li>
						</ol>

						<br>
						
						<?php 
						date_default_timezone_set('America/Mexico_City');
						$fecha_creacion = date("Y-m-d H:i:s");
						?>

						<form action="baja_vin_logistica.php" method="POST" onsubmit="return validar_vin();">
							<div class="col-sm-12">
								<div class="form-group row">

									<div class="col-sm-12">
										<div class="container-bg-1 p-3">
											<div class="row">										
												<div class="col-sm-6">
													<label for="vin">VIN:</label>
													<input type="text" class="form-control" id="vin" name="vin" readonly="" value="<?php echo $date_vin[0]; ?>">
												</div>
												<div class="col-sm-6">
													<label for="marca">*Marca:</label>
													<input class="form-control" type="text" id="marca" name="marca" readonly="" value="<?php echo $date_vin[1] ?>" />
												</div>
												<div class="col-sm-6">
													<label for="version">*Versión:</label>
													<input class="form-control" type="text" id="version" name="version" readonly="" value="<?php echo $date_vin[2] ?>" />
												</div>
												<div class="col-sm-6">
													<label for="color">*Color:</label>
													<input class="form-control" type="text" id="color" name="color" readonly="" value="<?php echo $date_vin[3] ?>" />
												</div>
												<div class="col-sm-6">
													<label for="modelo">*Modelo:</label>
													<input class="form-control" type="text" id="modelo" name="modelo" readonly="" value="<?php echo $date_vin[4] ?>" />
												</div>
												<div class="col-sm-6">
													<label for="tipo_unidad">*Tipo Unidad:</label>
													<input class="form-control" type="text" id="tipo_unidad" name="tipo_unidad" readonly="" value="<?php echo $date_vin[5] ?>" />
												</div>
											</div>
										</div>

									</div>																		

									<div class="col-sm-12 mt-4">
										<div class="container-bg-1 p-3">
											<label for="comentario_eliminar_vin">*Comentarios Eliminar:</label>
											<textarea class="form-control" name="comentario_eliminar_vin" id="comentario_eliminar_vin" cols="30" rows="3"></textarea>   
										</div>										  
									</div>

									<input type="hidden" name="fecha_creacion" value="<?php echo $fecha_creacion; ?>">
									<input type="hidden" name="coordenadas" id="coordenadas">
									<input type="hidden" name="idlogistica_encriptada" id="idlogistica_encriptada"  value ="<?php echo $idlogistica_encriptada; ?>">
									<input type="hidden" name="idmovimiento_encriptada" id="idmovimiento_encriptada"  value ="<?php echo $idmovimiento_encriptada; ?>">
									<input type="hidden" name="id_unidad" id="id_unidad"  value ="<?php echo $date_vin[6]; ?>">







									<div class="col-sm-12">
										<center>
											<br>	
											<button class="btn-lg btn-primary" id="show_date" type="submit">Guardar</button>
										</center>
									</div>














								</div>
							</div>
						</form>




					</div>


				</div>



			</div>

			<?php 
			include_once '../footer.php';
			?>

		</div>
	</div>
</div>
<script src="../../datapicker_moder/lib/compressed/picker.js"></script>
<script src="../../datapicker_moder/lib/compressed/picker.date.js"></script>
<script src="../../datapicker_moder/lib/compressed/picker.time.js"></script>
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
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script src="../../assets/js/custom.js"></script>



<script type="text/javascript">


	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var latitud = position.coords.latitude;
			var longitud = position.coords.longitude;
			var coordenadas = latitud + " " + longitud;
			$("#coordenadas").val(coordenadas);

		}, function() {
			handleLocationError(true);
		});
	} else {

		handleLocationError(false);
	}






	function validar_vin(){

		
		var txtvin = $("#vin").val();
		var txtmarca = $("#marca").val();
		var txtversion = $("#version").val();
		var txtcolor = $("#color").val();
		var txtmodelo = $("#modelo").val();
		var txttipo = $("#tipo_unidad").val();
		var txteliminarvin = $("#comentario_eliminar_vin").val();


		if(txtvin == null || txtvin.length == 0 || /^\s+$/.test(txtvin)){

			$(".error-form").show();
			$(".text-error").html("ERROR: de VIN");

			setTimeout(function(){
				$(".error-form").fadeOut(1000);
			}, 1500);
			$("#vin").focus();
			return false;
		}


		if(txteliminarvin == null || txteliminarvin.length == 0 || txteliminarvin.length <= 10 || /^\s+$/.test(txteliminarvin)){

			$(".error-form").show();
			$(".text-error").html("ERROR: Comentario debe de contener al menos 10 caracteres");

			setTimeout(function(){
				$(".error-form").fadeOut(1000);
			}, 1500);
			$("#comentario_eliminar_vin").focus();
			return false;
		}

		return true;
	}



</script>


<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKNm5FUjlIYRpuH8aquS6q-7NzQdlAwgc">
</script>





</body>
</html>