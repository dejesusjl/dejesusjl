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

$query_tipo_orden = "SELECT tipo FROM unidades_utilitarios_herramientas WHERE visible = 'SI' and tipo <> '' group by tipo order by tipo ASC";
$result_tipo_orden = mysql_query($query_tipo_orden);

while ($row_tipo_orden = mysql_fetch_array($result_tipo_orden)) {

	$options .= "<optgroup label='$row_tipo_orden[0]'>
	<option value='$row_tipo_orden[0]'>$row_tipo_orden[0] - Activos</option>
	<option value='$row_tipo_orden[0]no'>$row_tipo_orden[0] - Eliminados</option>
	<option value='$row_tipo_orden[0]all'>$row_tipo_orden[0] - Todo</option>
	</optgroup>";

	$options_form .= "<option value='$row_tipo_orden[0]'>$row_tipo_orden[0]</option>";
	$separado_options .= "$row_tipo_orden[0], ";
}

$separado_options = substr($separado_options, 0, -2);


if (mysql_num_rows($result_tipo_orden) >= 2) {

	$options .= "<optgroup label='Mostrar Todo ($separado_options)'>
	<option value='si_tools'>Activos</option>
	<option value='no_tools'>Eliminados</option>
	<option value='all_tools'>Todo</option>
	</optgroup>";
}

$query_unidades_herramientas = "SELECT * FROM unidades_utilitarios_herramientas WHERE visible = 'SI' AND idorden > 0";
$result_unidades_herramientas = mysql_query($query_unidades_herramientas);

while ($row_unidades_herramientas = mysql_fetch_array($result_unidades_herramientas)) {

	$query_relacional = "SELECT * FROM relacional_AtnCl_edoCtaReq WHERE visible = 'SI' AND idatencion_clientes = '$row_unidades_herramientas[idorden]' ";
	$result_relacional = mysql_query($query_relacional);

	if (mysql_num_rows($result_relacional) >= 1) {

		while ($row_relacional = mysql_fetch_array($result_relacional)) {

			$query_requisicion = "SELECT * FROM estado_cuenta_requisicion WHERE visible = 'SI' AND trim(datos_vin) = '$row_unidades_herramientas[vin]' and idestado_cuenta_requisicion = '$row_relacional[idestado_cuenta_requisicion]'";
			$result_requisicion = mysql_query($query_requisicion);

			if (mysql_num_rows($result_requisicion) >= 1) {

				while ($row_requisicion = mysql_fetch_array($result_requisicion)) {

					$query_update_herramientas = "UPDATE unidades_utilitarios_herramientas SET columna_d = '$row_requisicion[gran_total]' WHERE idunidades_utilitarios_herramientas = '$row_unidades_herramientas[idunidades_utilitarios_herramientas]' ";
					$result_update_herramientas = mysql_query($query_update_herramientas);
				}
			}
		}
	}
}


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

	<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
	<script src="../../js/jquery-1.10.2.js"></script>
	<script src="../../js/jquery-ui.js"></script>

	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
	-->

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
	<title>CCP | Unidades Utilitarias</title>

	<style>
		#show_date {
			cursor: pointer;
		}

		.dtp-picker-days thead,
		.dtp-picker-days thead th {
			background: transparent !important;
			color: #757575 !important;
			text-transform: uppercase;
		}

		.dtp-actual-day {
			text-transform: capitalize;
		}


		.dtp-btn-ok {
			margin-left: 10px;
		}

		.dtp-picker-days tbody tr td a {
			z-index: 1;
		}

		.dtp-picker-days tbody tr td a:hover {
			color: #FFF !important;
		}

		.dtp-picker-days tbody tr td a:before {
			content: '';
			position: absolute;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
			transform: scale(0);
			background: #4b4b4b;
			border-radius: 50%;
			transition: .3s;
			z-index: -1;
		}

		.dtp-picker-days tbody tr td a:hover:before {
			transform: scale(1);
		}

		.contador_span {
			float: right;
			color: #882439;
			font-style: italic;
		}

		.color_movimiento {

			background-color: #F8D7DA !important;
		}


		.alineacion {

			text-align: center !important;
			vertical-align: middle !important;
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

						<ol class="breadcrumb fondo-encabezados">
							<li>
								<a class="text-white" href="index.php">Inicio</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li class="active text-white">
								<a class="text-white" href="agregar_polizas_gps_utilitarias.php">Agregar Herramientas Unidades Utilitarias</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li class="active text-white">
								<strong>Resumen Unidades Utilitarias</strong>
							</li>
						</ol>

						<br>

						<?php
						date_default_timezone_set('America/Mexico_City');
						$fecha_hoy = date("Y-m-d");

						?>


						<form id="form_utilitaria" method="POST">

							<div class="row">

								<div class="col-sm-12">
									<label for="cars">Mostrar Tipo de Tabla</label>
									<select name="tipo_tabla" id="tipo_tabla" class="form-control">
										<optgroup label="Unidades Utilitarias">
											<option value="unidades">Inventario utilitarias activos</option>
											<option value="uvisibles">Inventario utilitarias eliminados</option>
											<option value="Todo">Inventario utilitarias activos y eliminados</option>
										</optgroup>
										<?php
										echo $options;
										?>
									</select>
								</div>


								<div class="col-sm-12">
									<br>
									<center>
										<button class="btn-lg btn-primary" id="show_date" type="button">Buscar</button>
									</center>
								</div>


							</div>
						</form>

						<div>
							<div id="show_table" class="mt-4">

							</div>
						</div>



						<!-- Modal Filtros-->
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


						<!-- 	<a href='#'><i class="fas fa-filter fa-5x" onclick="mostrarModalForm('concepto')"></i></a> -->

						<!-- Modal -->
						<div class="modal fade" id="modal_formulario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel"> Modificar Datos </h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>



									<div id="add_inputs_form">

									</div>

									<div id="mostrar_fechas" style="display: none;">

										<div class="col-sm-12">
											<div class="d-flex align-items-center mb-2">
												<label class="mb-0 mr-2">*Fecha Instalación</label>&nbsp;
												<div id="clean_fecha_a" class="container-iconos-1">
													<i class="fa fa-trash-o" aria-hidden="true"></i>
												</div>
											</div>
											<input class="form-control" type="text" id="fecha_a" name="fecha_a" onclick="fecha_a();" readonly>
										</div>
										<br>


										<div class="col-sm-12">
											<div class="d-flex align-items-center mb-2">
												<label class="mb-0 mr-2">Fecha Vencimiento</label>&nbsp;
												<div id="clean_fecha_vencimiento" class="container-iconos-1">
													<i class="fa fa-trash-o" aria-hidden="true"></i>
												</div>
											</div>
											<input class="form-control" type="text" id="fecha_vencimiento" name="fecha_vencimiento" onclick="fecha_vencimiento();" readonly>

										</div>

									</div>

									<div class="col-sm-12">
										<label>*Comentarios Editar Movimiento&nbsp;&nbsp;<span class="contador_span" id="contador_espan">20 caracteres restantes</label>
										<textarea name="comentarios" id="comentarios" class="form-control" rows="2" required="" onkeypress="cancelar_enter()" onkeyup="RangeComentarios();"></textarea>
									</div>

									<input type="hidden" name="iduuh" id="iduuh">
									<input type="hidden" name="tipo_formulario" id="tipo_formulario">
									<input type="hidden" name="fecha_creacion" id="fecha_creacion" value="<?php echo $fecha_guardado; ?>">





									<center>
										<div class="modal-footer col-sm-12">
											<br>
											<button class="btn btn-lg btn-primary" type="button" id="button_actualizar" style="display: none;">Guardar</button>
										</div>
									</center>

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

	<script src="../../plugins/Datepicker/bootstrap-material-datetimepicker.js"></script>
	<script src="../../plugins/Datepicker/es-mx.min.js"></script>


	<script type="text/javascript" class="init">
		$(document).ready(function() {

			$("#show_date").click(function() {

				var datos_balance = $("#form_utilitaria").serialize();

				ShowTableGeneral(datos_balance);

			});



			$("#clean_fecha_a").click(function() {
				$("#fecha_a").val("");
			});

			$("#clean_fecha_vencimiento").click(function() {
				$("#fecha_vencimiento").val("");
			});


			$("#button_actualizar").click(function() {

				$('#modal_formulario').modal('hide');

				var formData = new FormData();

				//Tipo de Formulario
				var tipo_formulario = $("#tipo_formulario").val();
				formData.append('tipo_formulario', tipo_formulario);

				//idunidades_utilitarios_herramientas
				var iduuh = $("#iduuh").val();
				formData.append('iduuh', iduuh);

				//Valor
				if (tipo_formulario == "Evidencia") {

					var files = $("#formFile")[0].files[0];
					formData.append('evidencia', files);
				}

				//tipo
				var tipo = $("#tipo").val();
				formData.append('tipo', tipo);

				//descripcion
				var descripcion = $("#descripcion").val();
				formData.append('descripcion', descripcion);

				//idorden
				var idorden = $("#buscar_o_d201").val();
				formData.append('idorden', idorden);

				//tipo_orden
				var tipo_orden = $("#tipo_orden").val();
				formData.append('tipo_orden', tipo_orden);

				//estatus
				var estatus = $("#estatus").val();
				formData.append('estatus', estatus);

				//columna_a
				var columna_a = $("#columna_a").val();
				formData.append('columna_a', columna_a);

				//columna_b
				var columna_b = $("#columna_b").val();
				formData.append('columna_b', columna_b);

				//columna_c
				var columna_c = $("#columna_c").val();
				formData.append('columna_c', columna_c);

				//fecha_a
				var fecha_a = $("#fecha_a").val();
				formData.append('fecha_a', fecha_a);

				//fecha_vencimiento
				var fecha_vencimiento = $("#fecha_vencimiento").val();
				formData.append('fecha_vencimiento', fecha_vencimiento);


				var comentarios = $("#comentarios").val();
				formData.append('comentarios', comentarios);

				var fecha_creacion = $("#fecha_creacion").val();
				formData.append('fecha_creacion', fecha_creacion);



				$.ajax({

					data: formData,
					url: 'actualizar_utilitarias_herramientas.php',
					type: 'POST',
					processData: false,
					contentType: false,
					cache: false,
					beforeSend: function() {
						$(".container-loading-ajax").show();
					},
					success: function(json) {


						if (json.trim() == "1") {

							$(".listo-form").show();
							$(".text-listo").html("Datos Guardados Correctamente");

							setTimeout(function() {
								$(".listo-form").fadeOut(1000);
							}, 1500);

							var datos_balance = $("#form_utilitaria").serialize();

							ShowTableGeneral(datos_balance);


						} else {

							$(".error-form").show();
							$(".text-error").html(json);

							setTimeout(function() {
								$(".error-form").fadeOut(3000);
							}, 1500);

							var datos_balance = $("#form_utilitaria").serialize();

							ShowTableGeneral(datos_balance);

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

			});




		});


		function ShowTableGeneral(datos_balance) {


			$.ajax({
				url: 'show_unidades_utilitarias.php',
				data: datos_balance,
				type: 'POST',
				beforeSend: function() {
					$(".container-loading-ajax").show();
				},
				success: function(json) {

					$("#show_table").html(json);
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


		$(document).on('change', 'input[type="file"]', function() {

			var fileName = this.files[0].name;
			var fileSize = this.files[0].size;

			if (fileSize > 9216000) {

				$(".error-form").show();
				$(".text-error").html("El archivo no debe superar los 9MB");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);

				this.value = '';


				return false;

			} else {

				return true;
			}

		});


		function fecha_a(valor) {

			$('#fecha_a').bootstrapMaterialDatePicker({
				date: true,
				time: false,
				shortTime: true,
				format: 'YYYY-MM-DD',
				lang: "es",
				cancelText: 'Cancelar',
				okText: 'Definir'

			});

		}



		function fecha_vencimiento(valor) {

			$('#fecha_vencimiento').bootstrapMaterialDatePicker({
				date: true,
				time: false,
				shortTime: true,
				format: 'YYYY-MM-DD',
				lang: "es",
				cancelText: 'Cancelar',
				okText: 'Definir'

			});

		}


		function mostrarModalForm(modal_valor) {


			var porciones = modal_valor.split(",");

			fecha_a();
			fecha_vencimiento();


			$("#formFile").val("");

			$("#fecha_a").val("");
			$("#fecha_vencimiento").val("");

			$("#iduuh").val("");
			$("#tipo_formulario").val("");

			$("#concepto").val("");

			$("#columna_d").val("");

			$("#columna_c").val("");

			$("#mostrar_fechas").hide();
			$("#comentarios").val("");


			$("#add_inputs_form").empty();
			$("#comentarios").removeAttr("readonly", "readonly");
			//----------ADD----------------



			$("#tipo_formulario").val(porciones[0]);
			$("#iduuh").val(porciones[1]);


			RangeComentarios();

			if (porciones[0].trim() == "Evidencia") {

				$("#mostrar_fechas").hide();

				var create_modal_form = `
		<div class="col-sm-12">
		<label for="formFile" class="form-label">Agregar Evidencia</label>
		<input class="form-control" type="file" id="formFile" name="evidencia" required="">
		</div>
		`;

			} else if (porciones[0].trim() == "Concepto") {

				var create_modal_form = `
		<div class="col-sm-12">
		<label>Concepto</label>
		<select name="concepto" id="concepto" class="form-control" required="">
		<?php echo $options_form ?>
		</select>
		</div>
		`;

			} else if (porciones[0].trim() == "Monto") {

				var create_modal_form = `
		<div class="col-sm-12">
		<label>Costo Total</label>
		<input type="text" class="form-control" name="columna_d" id="columna_d" required onkeypress="return SoloNumeros(event);">
		</div>
		`;

			} else if (porciones[0].trim() == "Pago") {

				var create_modal_form = `
		<div class="col-sm-12">
		<label>Modalidad de Pago</label>
		<select name="columna_c" id="columna_c" class="form-control" required="">
		<option value='Anual'>Anual</option>
		<option value='Semestral'>Semestral</option>
		<option value='Trimestral'>Trimestral</option> 
		<option value='Traslado'>Traslado</option>
		</select>
		</div>
		`;

			} else if (porciones[0].trim() == "Fechas") {

				$("#mostrar_fechas").show();

			} else if (porciones[0].trim() == "Visible") {



				var create_modal_form = `
		<div class="col-sm-12">
		<h3>${porciones[2]}</h3>
		</div>
		`;

			} else if (porciones[0].trim() == "Orden") {

				var create_modal_form = `

		<div class="col-sm-12">
		<label>*Buscar número de orden</label>
		<input type="number" class="form-control" id="buscar_o_d201" name="idordenvin" onkeypress="return SoloNumeros(event);" onKeyUp="buscar_documentation_orden();">
		<input type="hidden" name="vin" id="vin_atencionclientes" value="${porciones[2]}">
		<input type="hidden" name="interuptor" id="interuptor" value="">
		</div>
		<br>
		<div class="col-sm-12 alert alert-info" role="alert" id="alert_entrega_documentacion" style="display: none;">

		</div>

		`;

			} else if (porciones[0].trim() == "EditarOrden") {

				$("#mostrar_fechas").show();
				$("#fecha_a").val(porciones[13]);
				$("#fecha_vencimiento").val(porciones[14]);


				var create_modal_form = `

		<div class="col-sm-12">
		<div class="alert alert-info" role="alert" >
		<span>${porciones[2]}</span>
		</div>
		</div>

		<div class='col-sm-12'>
		<label>Tipo</label>
		<input type="text" class="form-control" name='tipo' id='tipo' value='${porciones[3]}' list="tipo_search">

		<datalist id="tipo_search">
		<option value="GPS">
		<option value="Póliza de Seguro">
		</datalist>
		</div>

		<div class='col-sm-12'>
		<label>Descripción</label>
		<input type="text" class="form-control" name='descripcion' id='descripcion' value='${porciones[4]}'>

		</div>

		<div class="col-sm-12">
		<label>*Buscar número de orden</label>
		<input type="number" class="form-control" id="buscar_o_d201" name="idorden" onkeypress="return SoloNumeros(event);" onKeyUp="buscar_documentation_orden();" value="${porciones[6]}">
		<input type="hidden" name="vin" id="vin_atencionclientes" value="${porciones[5]}">
		<input type="hidden" name="interuptor" id="interuptor" value="">
		</div>
		<br>

		<div class="col-sm-12">
		<div class="col-sm-12 alert alert-success" role="alert" id="alert_entrega_documentacion" style="display: none;">

		</div>
		</div>

		<div class='col-sm-12'>
		<label>Tipo de Orden</label>
		<input type="text" class="form-control" name='tipo_orden' id='tipo_orden' value='${porciones[7]}'>
		</div>

		<div class='col-sm-12'>
		<label>Estatus</label>
		<input type="text" class="form-control" name='estatus' id='estatus' value='${porciones[8]}'>
		</div>

		<div class='col-sm-12'>
		<label>${porciones[9]}</label>
		<input type="text" class="form-control" name='columna_a' id="columna_a" value='${porciones[10]}'>
		</div>

		<div class='col-sm-12'>
		<label>Teléfono</label>
		<input type="text" class="form-control" name='columna_b' id="columna_b" value='${porciones[11]}'>
		</div>

		<div class="col-sm-12">
		<label>Modalidad de Pago</label>
		<select name="columna_c" id="columna_c" class="form-control" required="">
		<option value='${porciones[12]}'>${porciones[12]}</option>
		<option value='Mensual'>Mensual</option>
		<option value='Trimestral'>Trimestral</option>
		<option value='Semestral'>Semestral</option>
		<option value='Anual'>Anual</option>
		<option value='Traslado'>Traslado</option>
		</select>
		</div>

		`;

			}





			$("#add_inputs_form").html(create_modal_form);

			$('#modal_formulario').modal('toggle');

		}

		function cancelar_enter() {

			var key = event.keyCode;

			if (key === 13) {
				event.preventDefault();
			}

		}

		function RangeComentarios() {

			var obtener_id = $("#comentarios").val();
			var obtener_idtrim = obtener_id.trim();
			var porciones = obtener_idtrim.split(" ");
			var ultimate = "";

			porciones.forEach(function(elemento, indice, array) {
				let ook = elemento.trim();

				if (ook != "") {
					ultimate += elemento.trim() + " ";
				}

			});

			var obtener_trime = ultimate.trim();

			var obtener_id_tamanio = obtener_trime.length;

			var min_character = parseInt(20 - obtener_id_tamanio);

			(min_character <= 0) ? $('#contador_espan').html("<i class='fas fa-check-double'></i>"): $('#contador_espan').html(min_character + " caracteres restantes");

			(min_character <= 0) ? $('#button_actualizar').show(): $('#button_actualizar').hide();


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


		function buscar_documentation_orden(valor) {

			var buscar_o_d = $("#buscar_o_d201").val();
			var vin = $("#vin_atencionclientes").val();
			var idorden_logistica_tipo_orden = "Root_atc_vin";

			$.post("buscar_ordenes.php", {
				valorBusqueda: buscar_o_d,
				vin: vin,
				idorden_logistica_tipo_orden: idorden_logistica_tipo_orden
			}, function(mensaje_orden) {

				console.log("--->" + mensaje_orden + "<---");

				var porciones_orden = mensaje_orden.split('|');

				if (porciones_orden[0].trim() == "0") {

					$("#comentarios").attr("readonly", "readonly");
					$("#alert_entrega_documentacion").show();
					$("#alert_entrega_documentacion").html(porciones_orden[1]);

					$("#interuptor").val("0");


				} else if (porciones_orden[0].trim() == 1) {

					$("#comentarios").removeAttr("readonly", "readonly");

					$("#alert_entrega_documentacion").show();
					$("#alert_entrega_documentacion").html(porciones_orden[1]);

					$("#interuptor").val("1");

				}


			});


		}
	</script>




</body>

</html>