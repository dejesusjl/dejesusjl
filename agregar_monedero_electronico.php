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


$options_tipo = "
<optgroup label='Peajes'>
<option value='CasetasAgregado'>Con Logística</option>
<option value='CasetasPendiente'>Pendiente</option>
<option value='CasetasOtros'>Exepciones</option>
<option value='CasetasALL'>Todos</option>
</optgroup>
<optgroup label='Combustible BROXEL'>
<option value='CombustibleAgregadoBroxel'>Con Logística</option>
<option value='CombustiblePendienteBroxel'>Pendiente</option>
<option value='CombustibleOtrosBroxel'>Exepciones</option>
<option value='CombustibleALLBroxel'>Todos</option>
</optgroup>
<optgroup label='Combustible Si Vale'>
<option value='CombustibleAgregadoSiVale'>Con Logística</option>
<option value='CombustiblePendienteSiVale'>Pendiente</option>
<option value='CombustibleOtrosSiVale'>Exepciones</option>
<option value='CombustibleALLSiVale'>Todos</option>
</optgroup>
";

#---------------------------------------------------------------------------------------------------------------------------
$query_auxiliares = "SELECT nombre FROM balance_gastos_auxiliares WHERE visible = 'SI' GROUP BY nombre";
$result_auxiliares = mysql_query($query_auxiliares);

while ($row_auxiliares = mysql_fetch_array($result_auxiliares)) {
	$show_auxiliares_general .= "<option>$row_auxiliares[nombre]</option>";
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
	<script src='funciones_js_global.js'></script>
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


	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.date.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.time.css">
	<title>CCP | Combustible, Peajes</title>
	<style>
		#show_date {
			cursor: pointer;
		}

		/*Scroll de tablas*/
		#columna {
			overflow: auto;
			margin: 5px;
			width: 100%;
			height: 500px;
			/*establece la altura máxima, lo que no entre quedará por debajo y saldra la barra de scroll*/
		}

		.spelling-error {
			text-decoration-line: underline;
			text-decoration-color: #882439;
		}

		.color-div {

			border: 1.5px solid #882439;
			padding: 1%;


		}

		.picker__holder {

			overflow: hidden !important;
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


		<div class="error-form" style="background: rgba(255, 255, 255, 0.4); width: 100%; height: 100vh; position: fixed; z-index: 9999; top: 0px; display: none;">
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

						<ul class="sidebar-menu mb-4 breadcrumb fondo-encabezados">

							<li class="parent">

								<a href="#" onclick="toggle_menu('archivos_combustible_tag'); return false" class="text-white"><i class="fas fa-folder-open mr-3"></i>
									<span class="none">Archivos</span>
								</a>

								<ul class="children" id="archivos_combustible_tag">

									<li class="child"><a href="#" class="ml-4" onclick="ModalArchivos();"><i class="fas fa-upload mr-2"></i> Cargar Nuevo Archivo</a></li>
									<li class="child"><a href="#" class="ml-4" onclick="MostrarArchivos();"><i class="fas fa-database mr-2"></i> Historial de Archivos</a></li>

								</ul>

							</li>


							<li class="parent">

								<a href="#" onclick="toggle_menu('add_new_supplier'); return false" class="text-white"><i class="far fa-id-card mr-3"></i>
									<span class="none">Proveedor</span>
								</a>

								<ul class="children" id="add_new_supplier">

									<li class="child"><a href="#" class="ml-4" onclick="AddNEwSupplier();"><i class="fas fa-user-plus mr-2"></i>Agregar Nuevo Proveedor</a></li>
									<li class="child"><a href="buscar_proveedor_requisicion.php" target="_BLANK" class="ml-4"><i class="far fa-address-book mr-2"></i>Visualizar Proveedor</a></li>
									<li class="child"><a href="../../Documentacion_Logistica/Plantillas/Plantilla_Proveedores.csv" class="ml-4"><i class="fas fa-download mr-2"></i>Descargar Plantilla Actualizacion Masiva</a></li>
									<li class="child"><a href="#" class="ml-4" onclick="ModalArchivos();"><i class="fas fa-file-csv mr-2"></i>Cargar Plantilla Actualizacion Masiva</a></li>



								</ul>
							</li>

							<li class="parent">

								<a href="#" onclick="toggle_menu('solo_casetas'); return false" class="text-white"><i class="fas fa-road mr-3"></i>
									<span class="none">Casetas</span>
								</a>

								<ul class="children" id="solo_casetas">

									<li class="child"><a href="#" class="ml-4" onclick="PrepocesarArchivos('Casetas');"><i class="fas fa-cog fa-spin mr-2"></i>Procesar Valores Casetas</a></li>

								</ul>
							</li>

							<li class="parent">

								<a href="#" onclick="toggle_menu('solo_combustible'); return false" class="text-white"><i class="fas fa-gas-pump mr-3"></i>
									<span class="none">Combustible</span>
								</a>

								<ul class="children" id="solo_combustible">

									<li class="child"><a href="#" class="ml-4" onclick="PrepocesarArchivos('Combustible');"><i class="fas fa-cog fa-spin mr-2"></i>Procesar Valores Combustible</a></li>

								</ul>
							</li>


						</ul>



						<!-- Modal Info ModalArchivos-->
						<div class="modal fade" id="modal_actions_wallet" tabindex="-1" aria-labelledby="title_modal_actions" aria-hidden="true">
							<div class="modal-dialog modal-lg overflow-hidden">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="title_modal_actions"></h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<div class="modal-body" id="add_opciones_modal_options">



									</div>

									<div class="modal-footer">

										<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>

									</div>
								</div>
							</div>
						</div>

						<form id="form_archivos_combustible_casetas" method="POST">

							<div class="row">

								<div class="col-sm-12">
									<div class="container-bg-1 p-3">
										<div class="row">

											<div class="col-sm-6">
												<label>*Fecha de Inicio:</label>
												<input class="form-control" type="text" id="fecha_inicio" name="fecha_inicio" readonly="" onclick="AddFecha('fecha_inicio');">
											</div>

											<div class="col-sm-6">
												<label>*Fecha de Fin:</label>
												<input class="form-control" type="text" id="fecha_fin" name="fecha_fin" readonly="" onclick="AddFecha('fecha_fin');">
											</div>

											<div class="col-sm-12">
												<label for="tipo_vista">Mostrar Tipo de Tabla</label>
												<div class="content-select">
													<select name="tipo_vista" id="tipo_vista" class="form-control">
														<option value="">Selecciona una opción ...</option>
														<?php echo $options_tipo; ?>
													</select>
													<i></i>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-12">
									<br>
									<center>

										<button class="btn-lg btn-primary" id="show_date" type="button" onclick="MostrarContenido();">Buscar</button>

									</center>
								</div>


							</div>
						</form>


						<div>
							<div id="show_table" class="mt-4">

							</div>
						</div>
					</div>
				</div>
			</div>


			<br>
			<div class="col-sm-12" id="BitacoraArchivos">

			</div>

			<br>
			<div class="col-sm-12" id="BitacoraCard">

			</div>








			<?php
			include_once '../footer.php';
			?>

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
		window.addEventListener("load", MostrarBitacora);

		function AddFecha(valor) {

			$('#' + valor).pickadate({
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

				// Date limits
				max: +1,

			});

			$("#" + valor).data('pickadate').open();

			event.stopPropagation();
			event.preventDefault();
		}

		function MostrarContenido() {

			var datos_balance = $("#form_archivos_combustible_casetas").serialize();


			$.ajax({
				url: 'asignar_reasignar_tag.php',
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

		//------------------------------------------- Bitacora Total Gastos Bitacora --------------------------------------------------------------------------------

		function MostrarBitacora() {

			var tipo_tabla = "Bitacora";

			$.ajax({

				url: 'bitacora_combustible_tag.php',
				data: {
					tipo_tabla: tipo_tabla
				},
				type: 'POST',

				beforeSend: function() {

					$(".container-loading-ajax").show();

				},

				success: function(mensajebitacora) {

					$("#BitacoraCard").addClass("sec-datos");
					$("#BitacoraCard").html(mensajebitacora);
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

		//------------------------------------------- Bitacora Archivos Bitacora --------------------------------------------------------------------------------

		function MostrarArchivos() {

			$("#BitacoraArchivos").empty();

			var tipo_tabla = "Archivos";

			$.ajax({

				url: 'ActualizaDatosRoot.php',
				data: {
					tipo_tabla: tipo_tabla
				},
				type: 'POST',

				beforeSend: function() {

					$(".container-loading-ajax").show();

				},

				success: function(mensajebitacora) {

					$("#BitacoraArchivos").addClass("sec-datos");
					$("#BitacoraArchivos").html(mensajebitacora);
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

		function copiar_info(valor) {

			var aux = document.createElement("input");
			aux.setAttribute("value", valor);
			document.body.appendChild(aux);
			aux.select();
			document.execCommand("copy");
			document.body.removeChild(aux);

			$(".listo-form").show();
			$(".text-listo").html("<b>Copiado</b>");

			setTimeout(function() {
				$(".listo-form").fadeOut(250);
			}, 450);

		}


		function CorroborarRFC(valor) {

			copiar_info(valor);
			window.open("https://portalsat.plataforma.sat.gob.mx/RecuperacionDeCertificados/faces/consultaCertificados.xhtml", "Pagina_RFC", "");

		}

		//------------------------------------------- Formulario Procesador de Archivos --------------------------------------------------------------------------------

		function ModalArchivos(actionswallet) {

			$('#modal_actions_wallet').modal('toggle');
			$('#title_modal_actions').empty();
			$('#title_modal_actions').html("Cargar Archivos Combustible | Casetas");

			$("#add_opciones_modal_options").empty();

			$("#guardar_actions").show();

			var agregar_formulario = `
			<div class="col-sm-12">

				<label>*Seleccionar tipo de archivo</label>
				<select name="tipo_archivo" id="tipo_archivo" class="form-control vaciar_input">
					<option value="">Selecciona una Opción...</option>

					<optgroup label='Peaje'>
						<option value='Casetas Cierres'>Casetas Cierres</option>
						<option value='Casetas Cargos'>Casetas Cargos</option>
					</optgroup>

					<optgroup label='Combustible BROXEL'>
						<option value='Movimientos Diarios Broxel'>Movimientos Diarios</option>
						<option value='Factura Broxel'>Facturas</option>
					</optgroup>

					<optgroup label='Combustible SI VALE'>
						<option value='Factura Si Vale'>Facturas</option>
					</optgroup>

					<optgroup label='Plantilla Proveedores'>
						<option value='Plantilla Proveedores'>Proveedores</option>
					</optgroup>

				</select>

				</div>

				<div class="col-sm-12">
				<label>*Evidencia</label>
				<input type="file" name="archivo" id="archivo" class="form-control vaciar_input" accept=".csv">
				</div>

				<br>
				<div class="col-sm-12">
				<center>
					<button type="button" class="btn btn-primary btn-lg" data-dismiss="modal" id="guardar_actions" onclick="ConfirmarActions();">Procesar Archivo</button>
				</center>
				</div>
			`;

			$("#add_opciones_modal_options").html(agregar_formulario);


			$(".vaciar_input").val("");

		}

		//------------------------------------------- Guardar Procesador de Archivos --------------------------------------------------------------------------------

		function ConfirmarActions() {

			var tipo_archivo = $("#tipo_archivo").val();
			var archivo = $("#archivo")[0].files[0];
			var fecha_creacion = TiempoAhora();

			var formData = new FormData();

			formData.append('tipo_archivo', tipo_archivo);
			formData.append('archivo', archivo);
			formData.append('fecha_creacion', fecha_creacion);

			var link_ajax = "asignar_reasignar_card.php";

			$('#modal_actions_wallet').modal('hide');
			$('#title_modal_actions').empty();
			$("#add_opciones_modal_options").empty();

			$.ajax({

				type: "POST",
				url: link_ajax,
				data: formData,
				processData: false,
				contentType: false,
				cache: false,
				beforeSend: function() {
					$(".container-loading-ajax").show();
				},
				success: function(json) {

					var porciones = json.split('|');
					// console.log("|" + porciones[0].trim() + "|");
					// console.log("|" + porciones[1].trim() + "|");
					// console.log("|" + porciones[2].trim() + "|");

					if (porciones[0].trim() == 1) {
						//console.log("ok ok");
						$(".listo-form").show();
						$(".text-listo").html("<b>Datos Guardados Correctamente</b>" + porciones[2]);

						setTimeout(function() {
							$(".listo-form").fadeOut(2000);
						}, 1500);


					} else if (porciones[0].trim() == 0) {
						//console.log("modal si");
						$('#modal_actions_wallet').modal('show');
						$('#title_modal_actions').empty();
						$('#title_modal_actions').html("<b>Errores del archivo procesado</b>");

						$("#add_opciones_modal_options").empty();
						$("#guardar_actions").hide();


						$("#add_opciones_modal_options").html(porciones[2]);


						$(".vaciar_input").val("");

					} else {

						//console.log("modal no");
						$(".error-form").show();
						$(".text-error").html(porciones[2]);

						setTimeout(function() {
							$(".error-form").fadeOut(1000);
						}, 1500);
					}

					$(".container-loading-ajax").hide();
					//MostrarContenido();
					MostrarBitacora();
					MostrarArchivos();
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

		//------------------------------------------- Formulario Balance de Gastos Formulario --------------------------------------------------------------------------------

		function ActionsModalWallet(options) {

			$('#modal_actions_wallet').modal('toggle');
			$('#title_modal_actions').empty();
			$('#title_modal_actions').html("Enviar Movimiento a Logística");

			$("#add_opciones_modal_options").empty();

			var porciones = options.split("|");

			if (porciones[3].trim() == "OK") {

				var proveedor_input = `
				<div class="col-sm-12">
				<label>Proveedor</label>
				<input type="text" class="form-control" value="${porciones[4]}" id="nombre_catalogo_proveedores" readonly>
				<input type="hidden" value="${porciones[5]}" name="idcatalogo_provedores" id="idcatalogo_provedores">
				</div>
				`;

				var instituciones = `
				<div class="col-sm-6">
					<label>*Institución Emisora</label>
					<input class="form-control" type="text" id="emisor_venta" name="emisor_venta" readonly value="${porciones[4]}">
				</div>

				<div class="col-sm-6">
					<label>*Agente Emisor</label>
					<input class="form-control" type="text" id="agente_emisor_venta" name="agente_emisor_venta" readonly value="${porciones[9]}">
				</div>

				<div class="col-sm-6">
					<label>*Institución Receptora</label>
					<input class="form-control" type="text" id="receptor_venta" name="receptor_venta" readonly value="Panamotors Center, S.A. de C.V.">
				</div>

				<div class="col-sm-6">
					<label>*Agente Emisor</label>
					<input class="form-control" type="text" id="agente_receptor_venta" name="agente_receptor_venta" readonly value="${porciones[9]}">
				</div>
				`;


			} else if (porciones[3].trim() == "Muchos") {

				var proveedor_input = `
				<div class="col-sm-12">
				<div class="alert alert-danger" role="alert">
				<p>
				Se debe de verificar el <b>Proveedor</b> ya que hay +1 con el mismo <b>RFC.</b><br>
				</p

				<label>Proveedor</label>
				<input type="text" class="form-control" value="${porciones[4]}" id="nombre_catalogo_proveedores" readonly>
				<input type="hidden" value="${porciones[5]}" name="idcatalogo_provedores" id="idcatalogo_provedores">
				</div>
				</div>
				`;

				var instituciones = `
				<div class="col-sm-12">

					<div class="row alert alert-danger" role="alert">
						<center>
							<p>
								Se debe de verificar el <b>Proveedor</b> para poder guardar la información.
							</p>
						</center>

						<div class="col-sm-6">
							<label>*Institución Emisora</label>
							<input class="form-control" type="text" id="emisor_venta" name="emisor_venta" readonly value="PENDIENTE">
						</div>

						<div class="col-sm-6">
							<label>*Agente Emisor</label>
							<input class="form-control" type="text" id="agente_emisor_venta" name="agente_emisor_venta" readonly value="PENDIENTE">
						</div>

						<div class="col-sm-6">
							<label>*Institución Receptora</label>
							<input class="form-control" type="text" id="receptor_venta" name="receptor_venta" readonly value="PENDIENTE">
						</div>

						<div class="col-sm-6">
							<label>*Agente Emisor</label>
							<input class="form-control" type="text" id="agente_receptor_venta" name="agente_receptor_venta" readonly 				value="PENDIENTE">
						</div>

					</div>

				</div>
				`;

			} else if (porciones[3].trim() == "Agregar") {

				var proveedor_input = `
				<div class="col-sm-12">
				<div class="alert alert-danger" role="alert">
				<p>
				Se debe de Agregar el <b>Proveedor</b> al parecer no se encontro en la Base de Datos.<br>

				</p

				<label>Proveedor</label>
				<input type="text" class="form-control" value="${porciones[4]}" id="nombre_catalogo_proveedores" readonly>
				<input type="hidden" value="${porciones[5]}" name="idcatalogo_provedores" id="idcatalogo_provedores">
				</div>
				</div>
				`;

				var instituciones = `
				<div class="col-sm-12">

					<div class="row alert alert-danger" role="alert">
						<center>
							<p>
								Se debe de verificar el <b>Proveedor</b> para poder guardar la información.
							</p>
						</center>

						<div class="col-sm-6">
							<label>*Institución Emisora</label>
							<input class="form-control" type="text" id="emisor_venta" name="emisor_venta" readonly value="PENDIENTE">
						</div>

						<div class="col-sm-6">
							<label>*Agente Emisor</label>
							<input class="form-control" type="text" id="agente_emisor_venta" name="agente_emisor_venta" readonly value="PENDIENTE">
						</div>

						<div class="col-sm-6">
							<label>*Institución Receptora</label>
							<input class="form-control" type="text" id="receptor_venta" name="receptor_venta" readonly value="PENDIENTE">
						</div>

						<div class="col-sm-6">
							<label>*Agente Emisor</label>
							<input class="form-control" type="text" id="agente_receptor_venta" name="agente_receptor_venta" readonly value="PENDIENTE">
						</div>

					</div>

				</div>
				`;

			} else {

				var proveedor_input = `
				<div class="col-sm-12">
				<div class="alert alert-danger" role="alert">
				<p>
				Se debe de verificar el <b>Proveedor</b> para poder guardar la información, puedes realizar lo siguiente:<br>
				- Procesar valores para ver si ya se encuentra el proveedor.<br>
				- Agregar como nuevo proveedor.
				</p

				<label>Proveedor</label>
				<input type="text" class="form-control" value="${porciones[4]}" id="nombre_catalogo_proveedores" readonly>
				<input type="hidden" value="${porciones[5]}" name="idcatalogo_provedores" id="idcatalogo_provedores">
				</div>
				</div>
				`;

				var instituciones = `

				<div class="col-sm-12">

					<div class="row alert alert-danger" role="alert">
						<center>
							<p>
								Se debe de verificar el <b>Proveedor</b> para poder guardar la información.
							</p>
						</center>

						<div class="col-sm-6">
							<label>*Institución Emisora</label>
							<input class="form-control" type="text" id="emisor_venta" name="emisor_venta" readonly value="PENDIENTE">
						</div>

						<div class="col-sm-6">
							<label>*Agente Emisor</label>
							<input class="form-control" type="text" id="agente_emisor_venta" name="agente_emisor_venta" readonly value="PENDIENTE">
						</div>

						<div class="col-sm-6">
							<label>*Institución Receptora</label>
							<input class="form-control" type="text" id="receptor_venta" name="receptor_venta" readonly value="PENDIENTE">
						</div>

						<div class="col-sm-6">
							<label>*Agente Emisor</label>
							<input class="form-control" type="text" id="agente_receptor_venta" name="agente_receptor_venta" readonly value="PENDIENTE">
						</div>

					</div>

				</div>
				`;

			}



			var form_combustible = `

			<div class="row mx-0">
			
				<div class="col-sm-12  mb-4 container-title-line" style="padding-bottom: 10px;">
					<span class="badge badge-light">1</span>
					<label>Buscar Orden</label>
					<input placeholder="Buscar Logistica" class="form-control" type="number" name="buscaridorden" id="buscaridorden" value="" autocomplete="off" onKeyUp="SearchNumberLogistic();" size="19" width="300%">
					<center>
						<div id="resultadoSearchLogistic" class="container-busquedas-1 mt-4 efecto-busqueda" style="display: none;"></div>
					</center>
				</div>

				<div class="col-sm-12">
					<label>Número de orden logística</label>
					<input type="text" class="form-control" name="numberlogistic" id="numberlogistic" readonly>
					<input type="hidden" name="idorden_logistica_requisicion" id="idorden_logistica_requisicion">
				</div>

				<div class="col-sm-12">
					<label for="idauxiliar_principales">Auxiliar Principal</label>
					<input type="text" class="form-control" value="B2 BANORTE" id="nombre_auxiliar_principal" readonly>
					<input type="hidden" name="idauxiliar_principales" id="idauxiliar_principales" value="7" readonly>
				</div>

				<div class="col-sm-12">
					<label for="concepto">*Concepto</label>
					<input type="text" name="concepto" id="concepto" class="form-control" value="${porciones[1]}" readonly>
				</div>

				<div class="col-sm-4">
					<label>*Tipo</label>
					<input type="text" class="form-control" id="tipo_movimiento" name="tipo_movimiento" value="cargo" readonly>
				</div>

				<div class="col-sm-4">
					<label for="efecto_movimiento">Efecto</label>
					<input type="text" id="efecto_venta" name="efecto_venta" class="form-control" readonly="" value="suma">
				</div>

				<div class="col-sm-4">
					<label class="mb-0 mr-2" for="fecha_movimiento">*Fecha</label>
					<input class="form-control" type="text" id="fecha_movimiento" name="fecha_movimiento" required="" readonly value="${porciones[2]}">
				</div>
				<br>
				<br>

				${proveedor_input}

				<div class="col-sm-12" id="ResponsableBalanceGastos" style="padding-bottom: 10px;">
				</div>

				<div class="col-sm-12 my-4 container-title-line" style="padding-bottom: 10px;" >
				<span class="badge badge-light">3</span>
					<label for="auxiliar">¿ Agregar Nuevo auxiliar ?</label> <br>
					<label>SI</label>
					<input type="radio" class="radio1" name="nuevo_auxiliar" value="SI" onclick="AgregarAuxiliares('SI');" required=""> <br>
					<label>NO</label>
					<input type="radio" class="radio1" name="nuevo_auxiliar" value="NO" onclick="AgregarAuxiliares('NO');" required="">
				</div>

				<div id="show_auxiliares_balance" class="col-sm-12" style="display: none;">

					<div class="col-sm-12 field_add_auxiliar_individual" id="nuevosauxiliares">

					</div>

					<div class="col-sm-12 mt-4">
						<center>
							<a style='width: 180px;height: 90px;' class="icon-DOrden" class="" title="Add field"><i class='fa fa-plus-circle fa-5x zoom font-iconr' aria-hidden='true' onclick="ActionsAuxiliares()"></i></a>
							<div class="tooltipDetalleOrden mb-3">
								<p>Agregar Auxiliar</p>
							</div>
						</center>
					</div>

					<input id="indivudualauxiliar" type="hidden" value="0" readonly>
					<input id="count_input_aux" type="hidden" value="0" readonly>

				</div>

				<div class="col-sm-6">
					<label>*Departamento</label>
					<input type="text" class="form-control" id="nombre_departamento" readonly>
					<input type="hidden" id="iddepartamento_balance" name="iddepartamento_balance">
				</div>

				<div class="col-sm-6">
					<label>*Método de pago</label>
					<input type="text" class="form-control" id="nombre_metodo_pago" value="Panamotors Center, S.A. de C.V." readonly>
					<input type="hidden" id="metodo_pago" name="metodo_pago" value="3">
				</div>

				<div class="col-sm-4">
					<label>*Tipo de Moneda</label>
					<input class="form-control" type="text" id="tipo_moneda1" name="tipo_moneda1" readonly value="MXN">
				</div>

				<div class="col-sm-4">
					<label>*Tipo de Cambio</label>
					<input class="form-control" type="text" id="tipo_cambio2" name="tipo_cambio2" readonly value="1">
				</div>

				<div class="col-sm-4">
					<label>*Monto Total</label>
					<input class="form-control" type="text" id="monto_entrada" name="monto_entrada" readonly value="${porciones[6]}">
					<input type="hidden" name="monto_abono" value="${porciones[6]}">
				</div>

				<div class="col-sm-12 my-4 container-title-line" style="padding-bottom: 10px;">
				<span class="badge badge-light">4</span>
					<div class="row">

						<div class="col-sm-6">
							<label>*Precio Unitario</label>
							<input class="form-control" type="text" id="precio_unitario" name="precio_unitario" value="${porciones[7]}" onkeypress="return SoloNumeros(event);" />
						</div>

						<div class="col-sm-6">
							<label>*Litros</label>
							<input class="form-control" type="text" id="total_litros" name="total_litros" value="${porciones[8]}" onkeypress="return SoloNumeros(event);" />
						</div>
					</div>
				</div>

				<div class="col-sm-12" id="VINBalanceGastos" style="padding-bottom: 10px;">
				</div>

				<br>

				${instituciones}

				<div class="col-sm-12">
					<label>*Número de Tarjeta</label>
					<input class="form-control" type="text" id="optionnumbercard" name="optionnumbercard" readonly value="${porciones[10]}">
				</div>

				<div class="col-sm-12">
					<label>*Tipo de Comprobante</label>
					<input class="form-control" type="text" id="comprobante_venta" name="comprobante_venta" readonly value="Ticket">
				</div>


				<div class="col-sm-12">
					<label>*Factura Ticket</label>
					<input class="form-control" type="text" id="factura" name="factura" readonly value="${porciones[11]}">
				</div>

				<div class="col-sm-12">
					<label>*Referencia Ticket</label>
					<input class="form-control" type="text" id="n_referencia_venta" name="n_referencia_venta" readonly>
				</div>

				<div class="col-sm-12 my-4 container-title-line" style="padding-bottom: 10px;">
					<div class="row">
						<div class="col-sm-12">
						<span class="badge badge-light">6</span>
						<label>*Comentarios</label>
						<textarea class="form-control" rows="3" id="descripcion_venta" name="descripcion_venta" maxlength="8950" required></textarea>
						</div>
					</div>
				</div>

				<div class="col-sm-12">
				<center>
				<input type="hidden" name="idorden_logistica_combustible_archivo" id='idorden_logistica_combustible_archivo' value="${porciones[12]}">
				<button type="button" class="btn btn-primary btn-lg" id="guardar_actions" onclick="GuardarBalanceGastos();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
				</center>
				</div>

			</div>
			`;

			$("#add_opciones_modal_options").html(form_combustible);

		}

		//------------------------------------------- Guardar Balance de Gastos de Operacion --------------------------------------------------------------------------------

		function GuardarBalanceGastos() {

			var idorden_logistica_requisicion = $("#idorden_logistica_requisicion").val();
			var idauxiliar_principales = $("#idauxiliar_principales").val();
			var concepto = $("#concepto").val();
			var tipo_movimiento = $("#tipo_movimiento").val();
			var efecto_venta = $("#efecto_venta").val();
			var fecha_movimiento = $("#fecha_movimiento").val();
			var idcatalogo_provedores = $("#idcatalogo_provedores").val();
			var resp_balance_gastos = $("#resp_balance_gastos").val();
			var iddepartamento_balance = $("#iddepartamento_balance").val();
			var metodo_pago = $("#metodo_pago").val();
			var tipo_moneda1 = $("#tipo_moneda1").val();
			var tipo_cambio2 = $("#tipo_cambio2").val();
			var monto_entrada = $("#monto_entrada").val();
			var vin_venta = $("#vin_venta").val();
			var emisor_venta = $("#emisor_venta").val();
			var agente_emisor_venta = $("#agente_emisor_venta").val();
			var receptor_venta = $("#receptor_venta").val();
			var agente_receptor_venta = $("#agente_receptor_venta").val();
			var optionnumbercard = $("#optionnumbercard").val();
			var comprobante_venta = $("#comprobante_venta").val();
			var factura = $("#factura").val();
			var precio_unitario = $("#precio_unitario").val();
			var total_litros = $("#total_litros").val();
			var n_referencia_venta = $("#n_referencia_venta").val();
			var descripcion_venta = $("#descripcion_venta").val();
			var idorden_logistica_combustible_archivo = $("#idorden_logistica_combustible_archivo").val();

			var input = document.getElementsByName('auxiliares_balance_gastos[]');
			var auxiliares = [];

			for (var i = 0; i < input.length; i++) {
				var a = input[i];
				a.value;

				auxiliares.push(a.value);

			}

			var fecha_creacion = TiempoAhora();

			if (idorden_logistica_requisicion.trim() == "") {

				$("#idorden_logistica_requisicion").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Debes de buscar un número de orden");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#buscaridorden").focus();
				return false;

			}
			if (idauxiliar_principales.trim() == "") {

				$("#nombre_auxiliar_principal").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("No existe el auxiliar principal");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#nombre_auxiliar_principal").focus();
				return false;

			}
			if (concepto.trim() == "") {

				$("#concepto").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("No hay concepto");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#concepto").focus();
				return false;

			}
			if (tipo_movimiento.trim() == "") {

				$("#tipo_movimiento").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("No hay tipo de movimiento");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#tipo_movimiento").focus();
				return false;

			}
			if (efecto_venta.trim() == "") {

				$("#efecto_venta").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("No hay efecto");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#efecto_venta").focus();
				return false;


			}
			if (fecha_movimiento.trim() == "") {

				$("#fecha_movimiento").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("No hay fecha de movimiento");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#fecha_movimiento").focus();
				return false;

			}
			if (idcatalogo_provedores.trim() == "" || idcatalogo_provedores.trim() == "Agregar" || idcatalogo_provedores.trim() == "Muchos") {

				$("#nombre_catalogo_proveedores").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Se debe de verificar el estatus del proveedor");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#nombre_catalogo_proveedores").focus();
				return false;

			}
			if (resp_balance_gastos.trim() == "" || typeof resp_balance_gastos === 'undefined') {

				$("#resp_balance_gastos").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Debes de agregar responsables en logistica detalles");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#resp_balance_gastos").focus();
				return false;

			}
			if (iddepartamento_balance.trim() == "") {

				$("#nombre_departamento").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("No esta definido el departamento");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#nombre_departamento").focus();
				return false;

			}
			if (metodo_pago.trim() == "") {

				$("#nombre_metodo_pago").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("No esta definido el método de pago");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#nombre_metodo_pago").focus();
				return false;

			}
			if (tipo_moneda1.trim() == "") {

				$("#tipo_moneda1").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("No esta definido el tipo de moneda");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#tipo_moneda1").focus();
				return false;

			}
			if (tipo_cambio2.trim() == "") {

				$("#tipo_cambio2").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("No esta definido el tipo de cambio");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#tipo_cambio2").focus();
				return false;

			}
			if (monto_entrada.trim() == "") {

				$("#monto_entrada").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("No esta definido el tipo de monto total");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#monto_entrada").focus();
				return false;

			}
			if (vin_venta.trim() == "" || typeof vin_venta === 'undefined') {

				$("#vin_venta").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("No esta definido el VIN");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#vin_venta").focus();
				return false;

			}
			if (emisor_venta.trim() == "" || emisor_venta.trim() == "PENDIENTE") {

				$("#emisor_venta").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Se debe de verificar el estatus del proveedor");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#emisor_venta").focus();
				return false;

			}
			if (agente_emisor_venta.trim() == "" || agente_emisor_venta.trim() == "PENDIENTE") {

				$("#agente_emisor_venta").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Se debe de verificar el estatus del proveedor");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#agente_emisor_venta").focus();
				return false;

			}
			if (receptor_venta.trim() == "" || receptor_venta.trim() == "PENDIENTE") {

				$("#receptor_venta").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Se debe de verificar el estatus del proveedor");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#receptor_venta").focus();
				return false;

			}
			if (agente_receptor_venta.trim() == "" || agente_receptor_venta.trim() == "PENDIENTE") {

				$("#agente_receptor_venta").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Se debe de verificar el estatus del proveedor");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#agente_receptor_venta").focus();
				return false;

			}
			if (optionnumbercard.trim() == "") {

				$("#optionnumbercard").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Se debe de verificar el número de tarjeta");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#optionnumbercard").focus();
				return false;

			}
			if (comprobante_venta.trim() == "") {

				$("#comprobante_venta").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Se debe de verificar comprobante");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#comprobante_venta").focus();
				return false;

			}
			if (factura.trim() == "") {

				$("#factura").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Se debe de verificar el número de ticket");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#factura").focus();
				return false;

			}
			if (n_referencia_venta.trim() == "") {

				$("#factura").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Se debe de verificar el número de ticket");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#factura").focus();
				return false;

			}
			if (descripcion_venta.trim() == "") {

				$("#descripcion_venta").css("border-color", "#882439");

				$(".error-form").show();
				$(".text-error").html("Debes de agreagar un comentario");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#descripcion_venta").focus();
				return false;

			}


			var formData = new FormData();

			formData.append('idorden_logistica_requisicion', idorden_logistica_requisicion);
			formData.append('idauxiliar_principales', idauxiliar_principales);
			formData.append('concepto', concepto);
			formData.append('tipo_movimiento', tipo_movimiento);
			formData.append('efecto_venta', efecto_venta);
			formData.append('fecha_movimiento', fecha_movimiento);
			formData.append('idcatalogo_provedores', idcatalogo_provedores);
			formData.append('resp_balance_gastos', resp_balance_gastos);
			formData.append('iddepartamento_balance', iddepartamento_balance);
			formData.append('metodo_pago', metodo_pago);
			formData.append('tipo_moneda1', tipo_moneda1);
			formData.append('tipo_cambio2', tipo_cambio2);
			formData.append('monto_entrada', monto_entrada);
			formData.append('monto_abono', monto_entrada);
			formData.append('saldo_nuevo', monto_entrada);
			formData.append('vin_venta', vin_venta);
			formData.append('emisor_venta', emisor_venta);
			formData.append('agente_emisor_venta', agente_emisor_venta);
			formData.append('receptor_venta', receptor_venta);
			formData.append('agente_receptor_venta', agente_receptor_venta);
			formData.append('number_card', optionnumbercard);
			formData.append('comprobante_venta', comprobante_venta);
			formData.append('factura', factura);
			formData.append('n_referencia_venta', n_referencia_venta);
			formData.append('descripcion_venta', descripcion_venta);
			formData.append('fecha_creacion_balance', fecha_creacion);
			formData.append('precio_unitario', precio_unitario);
			formData.append('total_litros', total_litros);
			formData.append('idorden_logistica_combustible_archivo', idorden_logistica_combustible_archivo);
			formData.append('auxiliares_balance_gastos', auxiliares);


			// Display the values
			// for (var value of formData.values()) {
			// 	console.log(value);
			// }

			$('#modal_actions_wallet').modal('hide');
			$.ajax({
				type: "POST",
				url: "guardar_balance_gastos_operacion.php",
				data: formData,
				processData: false,
				contentType: false,
				cache: false,
				type: "POST",
				beforeSend: function() {

					$(".container-loading-ajax").show();
				},
				success: function(mensaje_balance_gastos) {

					console.log(mensaje_balance_gastos);

					if (mensaje_balance_gastos.trim() == 1) {

						$(".listo-form").show();
						$(".text-listo").html("<b>Agregado a Logística Correctamente</b>");

						setTimeout(function() {
							$(".listo-form").fadeOut(1000);
						}, 1500);


					} else {

						$('#modal_actions_wallet').modal('toggle');
						$('#title_modal_actions').empty();
						$('#title_modal_actions').html("<b>Error Balance de Gastos Logística</b>");

						$("#add_opciones_modal_options").empty();
						//$("#guardar_actions").hide();


						$("#add_opciones_modal_options").html(mensaje_balance_gastos);


						$(".vaciar_input").val("");

					}

					$(".container-loading-ajax").hide();
					MostrarContenido();
					MostrarBitacora();

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


		//------------------------------------------- Buscar Numero de Orden de Logistica --------------------------------------------------------------------------------

		function SearchNumberLogistic() {

			var txtSearchLogistic = $("#buscaridorden").val();
			var tipoBusqueda = "BusquedaLogistica";
			var name_sugerencia = "LogisticaSearch";

			$.post("buscar_id_colaborador_completo.php", {

				valorBusqueda: txtSearchLogistic,
				tipoBusqueda: tipoBusqueda,
				name_sugerencia: name_sugerencia
			}, function(mensaje_responsable) {

				$("#resultadoSearchLogistic").html(mensaje_responsable);
				$("#resultadoSearchLogistic").show();

			});

			$(document).on('click', '.' + name_sugerencia, function(event) {
				event.preventDefault();
				aux_recibido = $(this).val();
				var porcion = aux_recibido.split(';');

				$("#buscaridorden").val("");
				$("#numberlogistic").val(porcion[0]);
				$("#idorden_logistica_requisicion").val(porcion[4]);

				// Opciones para select responsables
				OptionsResponsables(porcion[0]);

				// Opciones Vines
				OptionsVines(porcion[0]);

				// Departamento
				$("#iddepartamento_balance").val(porcion[1]);
				$("#nombre_departamento").val(porcion[2]);

				// Referencia logistica
				$("#n_referencia_venta").val(porcion[3]);
				//console.log(porcion[1]);
				//console.log(porcion[2]);

				//


				$("#resultadoSearchLogistic").html("");
				$("#resultadoSearchLogistic").hide();
			});

		}

		//------------------------------------------- Select Responsables Balance de Gastos --------------------------------------------------------------------------------

		function OptionsResponsables(valor) {

			$("#ResponsableBalanceGastos").empty();
			var tipoBusqueda = "ResponsablesOptions";
			$.post("buscar_id_colaborador_completo.php", {

				valorBusqueda: valor,
				tipoBusqueda: tipoBusqueda,

			}, function(opcionesresponsable) {

				if (opcionesresponsable.trim() == "Pendiente" || opcionesresponsable == " Pendiente") {

					var optionresponsable = `
					<div class="alert alert-danger" role="alert">
					<p>
					Se deben de agregar <b>Responsable(s) en la logística ${valor}</b> para poder guardar la información.
					</p
					</div>
					`;

				} else {

					var optionresponsable = `
					<span class="badge badge-light">2</span>
					<label>*Responsable</label>
					<select name="resp_balance_gastos" class="form-control" id="resp_balance_gastos">
					${opcionesresponsable}
					</select>
					`;
				}

				$("#ResponsableBalanceGastos").addClass("my-4 container-title-line");
				$("#ResponsableBalanceGastos").html(optionresponsable);

			});
		}

		//------------------------------------------- Select Vines Balance de Gastos --------------------------------------------------------------------------------

		function OptionsVines(valor) {

			$("#VINBalanceGastos").empty();
			var tipoBusqueda = "VINOptions";
			$.post("buscar_id_colaborador_completo.php", {

				valorBusqueda: valor,
				tipoBusqueda: tipoBusqueda,

			}, function(opcionesvin) {

				if (opcionesvin.trim() == "Pendiente" || opcionesvin == " Pendiente") {

					var optionresponsable = `
					<div class="alert alert-danger" role="alert">
					<p>
					Se deben de agregar el <b>VIN en la logística ${valor}</b> Son raras las ocaciones en que no lleva VIN se debe de corroborar.
					</p
					<br>
					<label>*VIN</label>
					<select name="vin_venta" class="form-control" id="vin_venta">
					<option value="N/A">N/A</option>
					</select>
					</div>
					`;

				} else {

					var optionresponsable = `
					<span class="badge badge-light">5</span>
					<label>*VIN</label>
					<select name="vin_venta" class="form-control" id="vin_venta">
					${opcionesvin}
					<option value="N/A">N/A</option>
					</select>
					`;
				}
				$("#VINBalanceGastos").addClass("my-4 container-title-line");
				$("#VINBalanceGastos").html(optionresponsable);

			});

		}

		//------------------------------------------- Visulaizar Agregar N Auxiliares --------------------------------------------------------------------------------	

		function AgregarAuxiliares(valor) {

			if (valor === "SI") {

				$("#nuevosauxiliares").empty();
				$("#show_auxiliares_balance").show();
				$("#indivudualauxiliar").val("0");
				$("#count_input_aux").val("0");

			} else {

				$("#nuevosauxiliares").empty();
				$("#show_auxiliares_balance").hide();
				$("#indivudualauxiliar").val("0");
				$("#count_input_aux").val("0");

			}
		}

		//------------------------------------------- Agregar N Auxiliares --------------------------------------------------------------------------------

		function ActionsAuxiliares() {


			var addButtonAuxiliar = $('.create_aux_individual');
			var wrapper_auxiliar_individual = $('.field_add_auxiliar_individual');

			var obtener_count_aux_individual = $("#count_input_aux").val();


			var add_coun_aux_individual = parseInt(obtener_count_aux_individual, 10) + 1;
			$("#count_input_aux").val(add_coun_aux_individual);

			var obtener_aux_individual = $("#indivudualauxiliar").val();

			if (obtener_aux_individual == 0) {

				var contador_aux = 1;

			} else {

				if ($.isNumeric(obtener_aux_individual) == true) {

					var contador_aux = parseInt(obtener_aux_individual, 10) + 1;

				} else {

					var cortar = obtener_aux_individual.substr(0, 1);

					var contador_aux = parseInt(obtener_aux_individual, 10) + 1;

				}
			}



			$("#indivudualauxiliar").val(contador_aux);

			var fieldHTMLAuxIndividual = `
							<div class="row mt-4 mb-4 container-title-line">

							<div class="col-sm-12">
							<label class="col-form-label">*Auxiliar:</label>
							<input type="text" class="form-control" name="auxiliares_balance_gastos[]" required list="show_auxiliares">
							<datalist id="show_auxiliares">
							<?php echo $show_auxiliares_general; ?>
							</datalist>
							</div>

							<a class="button-eliminar remove_button mt-4 mb-4">
							<span>Eliminar</span><i class="fas fa-trash"></i>
							</a>


							</div>

							`;

			$(wrapper_auxiliar_individual).append(fieldHTMLAuxIndividual);

			$(wrapper_auxiliar_individual).on('click', '.remove_button', function(e) {
				e.preventDefault();
				$(this).parent('div').remove();

				var obteneroriginalaux = $("#indivudualauxiliar").val();

				$("#indivudualauxiliar").val(obteneroriginalaux);

				var disminuir_count_aux = $("#count_input_aux").val();
				var nuewcount_individual_aux = parseInt(disminuir_count_aux, 10) - 1;
				$("#count_input_aux").val(nuewcount_individual_aux);

				if (nuewcount_individual_aux == 0) {
					$("#indivudualauxiliar").val("0");
				}

			});

		}






		// function BuscadorAll() {

		// <div class="col-sm-12">
		// <label>Buscar Responsable</label>
		// <input placeholder="Buscar" class="form-control" type="text" name="buscar_responsable_logistica" id="buscar_responsable_logistica" value="" autocomplete="off" onKeyUp="BuscadorAll();" size="19" width="300%"  />
		// <center>
		// <div id="resultadoBusquedaResponsable" class="container-busquedas-1 mt-4 efecto-busqueda" style="display: none;"></div>
		// </center>
		// </div>

		// <div class="col-sm-12">
		// <label>Responsable</label>
		// <input type="text" class="form-control" id="responsabletxt" readonly>
		// <input type="hidden" id="resp_balance_gastos" name="resp_balance_gastos">
		// </div>

		// 	var txtSearchResponsable = $("#buscar_responsable_logistica").val();
		// 	var tipoBusqueda = "ColaboraboradorSI";
		// 	var name_sugerencia = "ResponsableLogistica";

		// 	if (txtSearchResponsable != "") {

		// 		$.post("buscar_id_colaborador_completo.php", {
		// 			valorBusqueda: txtSearchResponsable,
		// 			tipoBusqueda: tipoBusqueda,
		// 			name_sugerencia: name_sugerencia
		// 		}, function(mensaje_responsable) {

		// 			$("#resultadoBusquedaResponsable").html(mensaje_responsable);
		// 			$("#resultadoBusquedaResponsable").show();

		// 		});

		// 	} else {
		// 		$("#resultadoBusquedaResponsable").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
		// 	};

		// 	$(document).on('click', '.' + name_sugerencia, function(event) {
		// 		event.preventDefault();
		// 		aux_recibido = $(this).val();
		// 		var porcion = aux_recibido.split(';');

		// 		$("#buscar_responsable_logistica").val("");
		// 		$("#responsabletxt").val(porcion[2] + " - " + porcion[3] + " " + porcion[4] + " - " + porcion[5]);
		// 		$("#resp_balance_gastos").val(porcion[0] + "|" + porcion[1]);
		// 		$("#resultadoBusquedaResponsable").html("");
		// 		$("#resultadoBusquedaResponsable").hide();
		// 	});

		// }

		//------------------------------------------- Procesador de Archivos --------------------------------------------------------------------------------

		function PrepocesarArchivos(valor, event) {



			$('#modal_actions_wallet').modal('toggle');
			$('#title_modal_actions').empty();
			$('#title_modal_actions').html("Rango de Fechas Para Procesar Archivos de <b>" + valor + "</b>");

			$("#add_opciones_modal_options").empty();

			var form_prepocesar = `
			<div class="row">
				<div class="col-sm-12">
				<label>Fecha Inicio</label>
				<input type="text" name="fecha_inicio_prepocesar" class="form-control" id="fecha_inicio_prepocesar" onclick="AddFecha('fecha_inicio_prepocesar');" readonly>
				</div>

				<div class="col-sm-12">
				<label>Fecha Fin</label>
				<input type="text" name="fecha_fin_prepocesar" class="form-control" id="fecha_fin_prepocesar" onclick="AddFecha('fecha_fin_prepocesar');" readonly>
				</div>
			<br>
			<br>
			
				<div class="col-sm-12">
					<center>
					<button type="button" class="btn btn-primary btn-lg" data-dismiss="modal" id="save_prepocesar" onclick="ProcesarValores('${valor}');">Procesar ${valor}</button>
					</center>
				</div>

			</div>
			`;

			$("#add_opciones_modal_options").html(form_prepocesar);


		}

		function ProcesarValores(valor) {

			var formData = new FormData();

			var fecha_inicio_prepocesar = $("#fecha_inicio_prepocesar").val();
			var fecha_fin_prepocesar = $("#fecha_fin_prepocesar").val();

			formData.append('tipo_procesador', valor);
			formData.append('fecha_inicio_prepocesar', fecha_inicio_prepocesar);
			formData.append('fecha_fin_prepocesar', fecha_fin_prepocesar);

			var link_ajax = "guardar_requisicion.php";

			$.ajax({

				type: "POST",
				url: link_ajax,
				data: formData,
				processData: false,
				contentType: false,
				cache: false,
				beforeSend: function() {
					$(".container-loading-ajax").show();
				},
				success: function(mensajeprocesarinfo) {
					console.log(mensajeprocesarinfo);

					if (mensajeprocesarinfo.trim() == 1) {

						$(".listo-form").show();
						$(".text-listo").html("<b>Datos Procesados Correctamente</b>");

						setTimeout(function() {
							$(".listo-form").fadeOut(5000);
						}, 1500);


					} else if (mensajeprocesarinfo.trim() == "Movimiento no Disponible <b>" + valor + "</b>") {

						$(".error-form").show();
						$(".text-error").html(mensajeprocesarinfo);

						setTimeout(function() {
							$(".error-form").fadeOut(8000);
						}, 1500);


					} else {

						$('#modal_actions_wallet').modal('toggle');
						$('#title_modal_actions').empty();
						$('#title_modal_actions').html("<b>Errores de movimientos procesados</b>");

						$("#add_opciones_modal_options").empty();
						$("#guardar_actions").hide();


						$("#add_opciones_modal_options").html(mensajeprocesarinfo);


						$(".vaciar_input").val("");

					}

					$(".container-loading-ajax").hide();
					MostrarContenido();
					MostrarBitacora();

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

		//------------------------------------------- Agregar Nuevo Proveedor --------------------------------------------------------------------------------

		function AddNEwSupplier() {

			$('#modal_actions_wallet').modal('toggle');
			$('#title_modal_actions').empty();
			$('#title_modal_actions').html("Agregar Nuevo Proveedor");

			$("#add_opciones_modal_options").empty();


			var newsupplier = `
			<div class="row">

			<div class="col-sm-12">
				<label><b>Tipo de Proveedor</b></label>
				<select name="tipo_proveedor" class="form-control" id="tipo_proveedor_new_supplier">
					<option value="">Selecciona una opción</option>
					<option value="Proveedor">Proveedor</option>
					<option value="Proveedor Temporal">Proveedor Temporal</option>
				</select>
			</div>

			<div class="col-sm-12">
				<label>Nombre</label>
				<input class="form-control" type="text" id="name_new_supplier" name="nombre_proveedor">
			</div>

			<div class="col-sm-12">
				<label>Apellidos</label>
				<input class="form-control" type="text" id="apellidos_new_supplier" name="apellidos_proveedor">
			</div>

			<div class="col-sm-12">
				<label>Alias</label>
				<textarea name='alias_proveedor' id='alias_new_supplier' class='form-control' rows='3'></textarea>
			</div>

			<div class="col-sm-12">
				<label>Teléfono</label>
				<input class="form-control" type="text" id="telefono_new_supplier" name="telefono_celular_proveedor" onkeypress="return SoloNumeros(event);">
			</div>

			<div class="col-sm-12">
				<label><b>*RFC</b></label>
				<input class="form-control" type="text" id="rfc_new_supplier" name="rfc_proveedor" onKeyUp="mayus(this);">
			</div>

			<div class="col-sm-12">
				<label>Estado</label>
				<select class="form-control" name="estado_proveedor" id="estado_new_supplier">
				<option value="">Selecciona una entidad ...</option>
				<?php
				$query_entidades = "SELECT * FROM catalogo_entidates WHERE visible = 'SI'";
				$result_entidades = mysql_query($query_entidades);
				while ($row_entidades = mysql_fetch_array($result_entidades)) {
					echo "<option value='$row_entidades[nombre_entidad]'>$row_entidades[nombre_entidad]</option>";
				}
				?>
				</select>
			</div>
			
			<div class="col-sm-12">
				<label>Delegación | Municipio</label>
				<input class="form-control" type="text" id="calle_new_supplier" name="delmuni_proveedor">
			</div>
			
			<div class="col-sm-12">
				<label>Colonia</label>
				<input class="form-control" type="text" id="colonia_proveedor_new_supplier" name="colonia_proveedor">
			</div>
			
			<div class="col-sm-12">
				<label>Calle</label>
				<input class="form-control" type="text" id="calle_new_supplier" name="calle_proveedor">
			</div>
			
			<br>
			<br>

			<div class="col-sm-12">
				<center>
					<button type="button" class="btn btn-primary btn-lg" onclick="SaveNewSupplier();">Guardar Nuevo Proveedor</button>
				</center>
			</div>
			
			</div>
			`;

			$("#add_opciones_modal_options").html(newsupplier);

		}


		function SaveNewSupplier() {

			var tipo_proveedor = $("#tipo_proveedor_new_supplier").val();
			var nombre_proveedor = $("#name_new_supplier").val();
			var apellidos_proveedor = $("#apellidos_new_supplier").val();
			var alias_proveedor = $("#alias_new_supplier").val();
			var telefono_celular_proveedor = $("#telefono_new_supplier").val();
			var rfc_proveedor = $("#rfc_new_supplier").val();
			var estado_proveedor = $("#estado_new_supplier").val();
			var delmuni_proveedor = $("#calle_new_supplier").val();
			var colonia_proveedor = $("#colonia_proveedor_new_supplier").val();
			var calle_proveedor = $("#calle_new_supplier").val();
			var fecha_creacion = TiempoAhora();


			var formData = new FormData();


			formData.append('tipo_proveedor', tipo_proveedor);
			formData.append('nombre_proveedor', nombre_proveedor);
			formData.append('apellidos_proveedor', apellidos_proveedor);
			formData.append('alias_proveedor', alias_proveedor);
			formData.append('telefono_celular_proveedor', telefono_celular_proveedor);
			formData.append('rfc_proveedor', rfc_proveedor);
			formData.append('estado_proveedor', estado_proveedor);
			formData.append('delmuni_proveedor', delmuni_proveedor);
			formData.append('colonia_proveedor', colonia_proveedor);
			formData.append('calle_proveedor', calle_proveedor);
			formData.append('fecha_creacion_proveedor', fecha_creacion);



			// for (var value of formData.values()) {
			// 	console.log(value);
			// }

			if (tipo_proveedor == "") {
				$("#tipo_proveedor_new_supplier").css("border-color", "#882439");
				$(".error-form").show();
				$(".text-error").html("Debes de seleccionar una opción");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);

				$("#tipo_proveedor_new_supplier").focus();
				return false;
			}

			if (nombre_proveedor == "") {
				$("#name_new_supplier").css("border-color", "#882439");
				$(".error-form").show();
				$(".text-error").html("Debes de colocar el nombre");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);

				$("#name_new_supplier").focus();
				return false;
			}
			$('#modal_actions_wallet').modal('hide');
			$('#title_modal_actions').empty();
			$("#add_opciones_modal_options").empty();

			$.ajax({
				type: "POST",
				url: "agregar_proveedor.php",
				data: formData,
				processData: false,
				contentType: false,
				cache: false,
				beforeSend: function() {
					$(".container-loading-ajax").show();
				},
				success: function(mensaje_proveedor) {
					console.log(mensaje_proveedor);
					if (mensaje_proveedor.trim() == "- No Hay Nombre <br>" || mensaje_proveedor.trim() == "- Proximamente <br>" || mensaje_proveedor.trim() == "- Error al Agregar Proveedor <br>" || mensaje_proveedor.trim() == "" || mensaje_proveedor.trim() == "- Nada que hacer <br>" || mensaje_proveedor.trim() == "- Ya Existe<br>") {

						$(".error-form").show();
						$(".text-error").html(mensaje_proveedor);

						setTimeout(function() {
							$(".error-form").fadeOut(1000);
						}, 1500);

					} else {

						$(".listo-form").show();
						$(".text-listo").html("<b>Proveedor Guardado Correctamente</b>");

						setTimeout(function() {
							$(".listo-form").fadeOut(2000);
						}, 1500);

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

		}


		//------------------------------------------- Solo Numeros --------------------------------------------------------------------------------

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

		function mayus(e) {
			e.value = e.value.toUpperCase();
		}
	</script>





</body>

</html>