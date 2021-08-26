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
	<title>CCP | Agregar Tipo Rol del VIN</title>

</head>
<body>
	<div class="container-fluid p-0">
		<?php 
		include_once "menu.php"; 
		?>
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
								<a class="text-white" href="catalogo_tipo_rol_vin.php">Resumen Rol del VIN</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li class="text-white" class="active">
								<strong>Agregar Tipo Rol del VIN</strong>
							</li>
						</ol>

						<br>
						
						<?php 
						date_default_timezone_set('America/Mexico_City');
						$fecha_creacion = date("Y-m-d H:i:s");
						?>
						
						<form id="form_balance" method="POST" action="guardar_tipo_rol_vin.php">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group row">

										<div id="button_principal_orden" class="col-sm-12" >
											<center>
												<a id='create_rol_vin' style='width: 180px;height: 90px;' class="create_rol_vin icon-DOrden" class="" title="Add field"><i class='fa fa-plus-circle fa-5x zoom font-iconr' aria-hidden='true' ></i></a>
												<div class="tooltipDetalleOrden mb-3">
													<p>Agregar Tipo Rol del VIN</p>
												</div>
											</center>

										</div>


										<div class="col-sm-12">
											<div class="col-sm-12 field_wrapperrolvin">

											</div>
										</div>

										<div class="col-sm-12 Aqui">

											
										</div>

										<input type="hidden" name="contador_rol_vin" value="0" required="" class="contador_rol_vin">

										<input type="hidden" name="fecha_creacion" id="fecha_creacion" value="<?php echo $fecha_creacion; ?>">


										

										<script type="text/javascript">
											$(document).ready(function(){




												var addButtonVIN = $('#create_rol_vin');
												var wrapper_vin = $('.field_wrapperrolvin');
												var valor_vin = 0;

												$(addButtonVIN).click(function(){ 
													valor_vin ++;


													var new_array_ayudante =`
													<div class="row mt-2 mb-2 container-border-1">

													<div class="col-sm-6">
													<label>*Rol del VIN</label>
													<input type="text" class="form-control" name="nombre[]" list="nombre_rol_vin" >
													<datalist id="nombre_rol_vin">
													<?php 
													$query_nombre_rol = "SELECT nombre FROM orden_logistica_rol_vin WHERE visible = 'SI' ";
													$result_nombre_rol = mysql_query($query_nombre_rol);

													while ($row_nombre_rol = mysql_fetch_array($result_nombre_rol)) {
														
														echo "<option value='$row_nombre_rol[nombre]'>$row_nombre_rol[nombre]</option>";
													}
													?>
													</datalist>

													</div>



													<div class="col-sm-6">
													<label>*Nombre Funcion</label>
													<div class="content-select">
													<select name="name_funcion[]" class="form-control">

													<option value='entrega_vin'>Entrega VIN ya debe de estar cargado en estado de cuenta</option>
													<option value='recepcion_vin'>Recepcion VIN ya debe de estar cargado cargado como compra</option>
													<option value='unidades_inventario'>Solo Vines que estan en Inventario VIN</option>
													<option value='unidades_utilitarias'>Solo unidades Utilitarias</option>
													<option value=''>Solo crear el ROL del VIN</option>

													<?php 

													// $create_array = array();

													// $query_nombre_funcion = "SELECT columna_a FROM orden_logistica_rol_vin WHERE visible = 'SI' ";
													// $result_nombre_funcion = mysql_query($query_nombre_funcion);

													// while ($row_nombre_rol = mysql_fetch_array($result_nombre_funcion)) {

													// 	$name_funtion_array = explode("|", $row_nombre_rol[columna_a]);

													// 	foreach ($name_funtion_array as $key => $value) {

													// 		if ($value != "") {
													// 			array_push($create_array, $value);
													// 		}
													// 	}
													// }


													// $array_unique = array_unique($create_array);

													// foreach ($array_unique as $key_function => $name_function) {
													// 	echo "<option value='$name_function'>$name_function</option>";
													// }

													?>

													</select>
													<i></i>
													</div>

													</div>




													<a class="button-eliminar remove_vin mt-4 mb-4">
													<span>Eliminar</span><i class="fas fa-trash"></i>
													</a>

													</div>
													`;



													$(wrapper_vin).append(new_array_ayudante); 
													$(".contador_rol_vin").val(valor_vin);



													if (valor_vin == 0) {
														$(".contador_rol_vin").val("0");
														
													}
													
													
												});

												$(wrapper_vin).on('click', '.remove_vin', function(e){
													valor_vin--; 
													e.preventDefault();
													$(this).parent('div').remove();
													$(".contador_rol_vin").val(valor_vin);


												});

											});



										</script>







										<div class="col-sm-12">
											<center>
												<button class="btn-lg btn-primary" id="show_date" type="submit">Guardar</button>
											</center>
										</div>

									</div>
								</div>
							</div>
						</form>

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

	




</body>
</html>