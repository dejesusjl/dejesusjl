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


$tipossssss = $_REQUEST['type_vn_per'];
$vn_personalsssssssss = $_REQUEST['vn_personal'];

$tipo = base64_decode($tipossssss);
$vin = base64_decode($vn_personalsssssssss);


$var_personal_vin = ($tipo == "Personal") ? "<a href='liberar_personal.php'>Personal</a>" : "<a href='detalle_utilitarias.php'>U. Utilitarios</a>" ;


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
	<link rel="stylesheet" href="../../assets/css/mod_style_datatables.css">
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
	<title>CCP | Liberar <?php echo $tipo; ?></title>
	<style>
		#enviar_form{
			cursor: pointer;
		}
	</style>
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
							<?php 
							echo ($tipo == "Personal")? "<li><a class='text-white' href='liberar_personal.php'>Resumen Colaboradores</a></li>" : "<li><a class='text-white' href='liberar_personal.php'>Resumen Unidades Utilitarias</a></li>";
							echo "<span class='text-white'> &nbsp;/&nbsp; </span>";
							echo ($tipo == "Personal")? "<li class='active text-white'><strong>Liberar Personal</strong></li>" : "<li class='active text-white'><strong>Liberar Unidad</strong></li>" ;
							?>

							
							
						</ol>

						<br>

						<?php 
						date_default_timezone_set('America/Mexico_City');
						$fecha_creacion = date("Y-m-d H:i:s");
						?>

						<form id="form_liberacion" method="POST" action="show_table_balance_gastos.php">

							<div class="row">

								<div class="col-sm-12">
									<div class="container-bg-1 p-3">
										<div class="row">
											<div class="col-sm-12">
												<label for="tipo">Tipo</label> 
												<input type="text" id="tipo" class="form-control" readonly="" value="<?php echo $tipo; ?>">
											</div>
											<div class="col-sm-12">
												<label for="valor">Nombre</label> 
												<input type="text" id="valor" class="form-control" readonly="" value="<?php echo $vin; ?>">
											</div>
										</div>									
									</div>								
								</div>

								<div class="col-sm-12 mt-4">
									<div class="container-bg-1 p-3">
										<div class="row">
											<div class="col-sm-12">
												<label for="acciones_personal_vin">Acciones</label>
												<div class="content-select">
													<select name="acciones_personal_vin" id="acciones_personal_vin" class="form-control">
													</select>
													<i></i>
												</div>
											</div>										
										</div>								
									</div>								
								</div>													

								

								<input type="hidden" name="type" id="type" value="<?php echo $tipossssss ?>">
								<input type="hidden" name="vn_personal" id="vn_personal" value="<?php echo $vn_personalsssssssss ?>">



								<div class="col-sm-12">
									<br>
									<center>
										<button type="button" class="btn-lg btn-primary" id="enviar_form" >Actualizar</button>
									</center>
								</div>

							</div>
						</form>


						<div class="col-sm-12">
							<div id="succes_ruta" style="display: none;">
								<div class="alert alert-success" role="alert">
									Se ha guardado Correctamente

								</div>
							</div>
						</div>

						<div class="col-sm-12">
							<div id="fail_ruta" style="display: none;">
								<div class="alert alert-danger" role="alert">
									Se ha Producido un error
								</div>
							</div>
						</div>



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

	$(document).ready(function() {


		if ($("#tipo").val() == "Personal") {

			var action_personal = `
			<option value="Disponible">Disponible</option>
			<option value="En Ruta">En Ruta</option>
			<option value="Descanso">Descanso</option>
			<option value="Permiso">Permiso</option>
			`;

			$('#acciones_personal_vin').html(action_personal).fadeIn();

		}else if ($("#tipo").val() == "vin") {

			var action_personal = `
			<option value="Disponible">Disponible</option>
			<option value="En Ruta">En Ruta</option>
			<option value="Taller">Taller</option>
			<option value="Prestamo">Prestamo</option>
			<option value="Descontinuado">Descontinuado</option>
			`;

			$('#acciones_personal_vin').html(action_personal).fadeIn();

		}




		$("#tipo").val();



		$("#enviar_form").click(function(){
			var tipo_valor = '<?php echo $tipo; ?>'


			var direccionador = (tipo_valor == "vin") ? "detalle_utilitarias.php" : "liberar_personal.php";



			var datos = $("#form_liberacion").serialize(); 


			$.ajax({
				type: "POST",
				url: "guardar_liberar_vin_personal.php",
				data: datos,
				success: function(msg){


					if (msg.trim() == "1") {

						$('#succes_ruta').show();                   
						$("#succes_ruta").delay(500).fadeIn("slow");
						location.replace(direccionador);
						
					}else{

						$('#fail_ruta').show();  
						$("#fail_ruta").delay(6000).fadeIn("slow");
						location.replace(direccionador);
					}
				}
			});
			return false;

		});




	});
</script>





</body>
</html>