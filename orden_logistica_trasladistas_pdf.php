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
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="description" content="">
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
	<link rel="stylesheet" href="../../assets/css/styles_loading_ajax.css">
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
	<link rel="icon" type="image/png" sizes="192x192" href="../../img/favicon/android-icon-192x192.png">
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
	<title>CCP | Reportes Trasladista </title>
	<style>
		#show_date {
			cursor: pointer;
		}
	</style>
</head>

<body>
	<div class="container-fluid p-0">
		<?php
		include_once "menu.php";
		?>
		<div class="container-loading-ajax" style="display: none;">
			<div class="content-loading-ajax">
				<div class="content-form-1">
					<span class="circle-uno"></span>
					<span class="circle-dos"></span>
				</div>
				<div class="content-form-2">
					<span class="circle-tres"></span>
					<span class="circle-cuatro"></span>
					<span class="circle-cinco"></span>
					<span class="circle-seis"></span>
				</div>
			</div>
		</div>
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
								<a class="text-white" href="buscador_logistica.php">Resumen Ordenes Logística</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li class="active text-white">
								<strong>Buscar Logística Trasladista</strong>
							</li>
						</ol>

						<br>

						<?php
						date_default_timezone_set('America/Mexico_City');
						$fecha_creacion = date("Y-m-d H:i:s");
						?>

						<form id="form_logisticas_id" method="POST" action="direccionador_intermedio_pdf.php">
							<div class="row">
								<div class="col-sm-12">
									<div class="row">

										<div class="col-sm-12">

											<div class="container-bg-1 p-3">
												<div class="row">
													<div class="col-sm-12">
														<div class="d-flex justify-content-center">
															<div id="clean_dates" class="container-iconos-1">
																<i class="fa fa-trash-o" aria-hidden="true" id="clean_dates"></i>
															</div>
														</div>
													</div>
													<div class="col-sm-6">
														<label>*Fecha de Inicio:</label>
														<input class="form-control" type="text" id="fecha_inicio" name="fecha_a" readonly="" />
													</div>
													<div class="col-sm-6">
														<label>*Fecha de Fin:</label>
														<input class="form-control" type="text" id="fecha_fin" name="fecha_b" readonly="" />
													</div>
												</div>
											</div>

										</div>


										<div class="col-sm-12 mt-4">

											<div class="container-bg-1 p-3">
												<div class="row">

													<div class="col-sm-12">
														<div class="d-flex align-items-center mb-2 mt-2">
															<label class="mb-0 mr-2" for="busqueda_id">Buscar ID</label>
															<div id="clean_id" class="container-iconos-1">
																<i class="fa fa-trash-o" aria-hidden="true"></i>
															</div>
														</div>
														<input placeholder="Buscar" class="form-control" type="text" name="busqueda_id" id="busqueda_id" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_cliente();" size="19" width="300%" />
														<center>
															<div id="resultadoBusquedaCliente" class="container-busquedas-1 mt-4 efecto-busqueda" style="display: none;"></div>
														</center>
													</div>

													<div class="col-sm-4 show_items_id" style="display: none;">
														<label>*ID</label>
														<input class="form-control limpiar_id" type="text" name="idcliente" id="idcliente" required="" readonly="" />
													</div>

													<div class="col-sm-4 show_items_id" style="display: none;">
														<label>*Nombre</label>
														<input class="form-control limpiar_id" type="text" name="nombre" id="nombre" required="" readonly="" />
													</div>

													<div class="col-sm-4 show_items_id" style="display: none;">
														<label>*Apellidos</label>
														<input class="form-control limpiar_id" type="text" name="apellidos" id="apellidos" required="" readonly="" />
													</div>


													<div class="col-sm-4 show_items_id" style="display: none;">
														<label>*Alias</label>
														<input class="form-control limpiar_id" type="text" name="alias" id="alias" readonly="" />
													</div>

													<div class="col-sm-4 show_items_id" style="display: none;">
														<label>*Telefono Celular</label>
														<input class="form-control limpiar_id" type="text" name="celular" id="celular" readonly="" />
													</div>

													<div class="col-sm-4 show_items_id" style="display: none;">
														<label>*Telefono Fijo</label>
														<input class="form-control limpiar_id" type="text" name="fijo" id="fijo" readonly="" />
													</div>

													<div class="col-sm-12 show_items_id" style="display: none;">
														<label>*Tipo Contacto</label>
														<input class="form-control limpiar_id" type="text" name="tipo_contacto_id" id="tipo_contacto_id" readonly="" />
													</div>

												</div>
											</div>

										</div>


										<div class="col-sm-12">
											<br>
											<center>
												<button class="btn-lg btn-primary" id="show_date" type="submit">Buscar</button>
												<input type="hidden" id="direccionador" name="direccionador" value="trasladista">
											</center>
										</div>

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

	<script type="text/javascript" class="init">
		$('#fecha_inicio').pickadate({
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
			max: +1,
			// disable: [
			// 1,2,3, 4,5,6
			// ]
		});



		$('#fecha_fin').pickadate({
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
			max: +1,
			// disable: [
			// 1,2,3, 4,5,6
			// ]
		});




		//Clean inputs

		$("#clean_dates").click(function() {
			$("#fecha_inicio").val("");
			$("#fecha_fin").val("");

		});

		$("#clean_id").click(function() {
			$(".limpiar_id").val("");
			$("#busqueda_id").val("");
			$(".show_items_id").hide();

		});


		// busqueda ID


		function buscar_cliente() {
			var textoBusquedaCliente = $("#busqueda_id").val();
			console.log(textoBusquedaCliente)
			if (textoBusquedaCliente != "") {
				$.post("search_id_type.php", {
					valorBusqueda: textoBusquedaCliente
				}, function(mensaje_cliente) {
					console.log(mensaje_cliente);
					$("#resultadoBusquedaCliente").html(mensaje_cliente);

					if (mensaje_cliente == " <b>ID NO Encontrado</b>") {
						$("#resultadoBusquedaCliente").show();
						$(".show_items_id").hide();
						$(".limpiar_id").val("");

						$("#idcliente").attr("readonly", "readonly");
						$("#idcliente").val("");
						$("#nombre").removeAttr("readonly", "readonly");
						$("#nombre").val("");
						$("#apellidos").removeAttr("readonly", "readonly");
						$("#apellidos").val("");
						$("#alias").removeAttr("readonly", "readonly");
						$("#alias").val("");
						$("#celular").removeAttr("readonly", "readonly");
						$("#celular").val("");
						$("#fijo").removeAttr("readonly", "readonly");
						$("#fijo").val("");
						$("#estado").removeAttr("readonly", "readonly");
						$("#estado").val("");
						$("#municipio").removeAttr("readonly", "readonly");
						$("#municipio").val("");
						$("#colonia").removeAttr("readonly", "readonly");
						$("#colonia").val("");
						$("#calle").removeAttr("readonly", "readonly");
						$("#calle").val("");
						$("#codigo_postal_cliente").removeAttr("readonly", "readonly");
						$("#codigo_postal_cliente").val("");
						$("#codigo_postal_cliente").removeAttr("readonly", "readonly");
						$("#tipo_contacto_id").val("Proveedor Temporal");
						$("#create_button").show();
						$("#guardar_id_temporal").hide();
					} else {
						$("#resultadoBusquedaCliente").show();
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
						$("#guardar_id_temporal").show();

					}
				});
			} else {
				$("#resultadoBusquedaCliente").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
			};
		};

		$(document).on('click', '.sugerencias_cliente', function(event) {
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

			$(".show_items_id").show();
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
			$("#resultadoBusquedaCliente").html("");
			$("#resultadoBusquedaCliente").hide();
		});
	</script>






</body>

</html>