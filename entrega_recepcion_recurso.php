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

$query_usuario_creador = "SELECT * FROM usuarios WHERE idusuario = '$usuario_creador'";
$result_usuario_creador = mysql_query($query_usuario_creador);

while ($row_usuario_creador = mysql_fetch_array($result_usuario_creador)) {

	$rol_usuario_creador = trim($row_usuario_creador[rol]);
}

include_once ($rol_usuario_creador == "100") ?  "funciones_principales.php" : "../Logistica/funciones_principales.php";
include_once ($rol_usuario_creador == "Credito_Cobranza") ?  "seguimiento_usuario.php" : "../Credito_Cobranza/seguimiento_usuario.php";
include_once ($rol_usuario_creador == "100") ?  "../Credito_Cobranza/seguimiento_usuario.php" : "../Credito_Cobranza/seguimiento_usuario.php";



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

	<?php
	echo ($rol_usuario_creador == "100") ?  "<script src='funciones_js_global.js'></script>" : "<script src='funciones_js_global.js'></script>";
	?>
	<!-- <script src='funciones_js_global.js'></script> -->

	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/quicksand.css">
	<link rel="stylesheet" href="../../assets/css/style.css">
	<link rel="stylesheet" href="../../assets/css/alert_popup.css">
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

	<!-- time line -->
	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/themify-icons.css">
	<link rel="stylesheet" href="../../assets/css/paper-bootstrap-wizard.css">
	<!-- time line -->


	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.date.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.time.css">

	<!-- Bootstrap Material DatePicker CSS-->
	<link rel="stylesheet" href="../../plugins/Datepicker/jquery.datetimepicker.css">
	<link rel="stylesheet" href="../../plugins/Datepicker/bootstrap-material-datetimepicker.css">



	<!-- Bootstrap Material DatePicker JS-->
	<script src="../../plugins/Datepicker/material.min.js"></script>
	<script src="../../plugins/Datepicker/moment-with-locales.min.js"></script>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">





	<title>CCP | Reportes Recurso ID</title>
	<style>
		#show_date {
			cursor: pointer;
		}

		th {
			text-align: center !important;
		}

		.filter-center {

			display: block;
			width: 100%;
			text-align: center !important;

		}

		.color_movimiento {

			background-color: #F8D7DA !important;
		}


		.alineacion {

			text-align: center !important;
			vertical-align: middle !important;
		}


		.wizard-card {
			min-height: 120px;
		}

		.wizard-card .icon-circle {
			color: #161616;
		}

		.wizard-card[data-color="theme"] .nav-pills>li.active>a:after,
		.wizard-card[data-color="theme"] .nav-pills>li a.active:after {
			background: #882439;
		}

		.wizard-card .icon-circle [class*="fa-"] {
			position: absolute;
			z-index: 500;
			left: -3px;
			right: 0;
			width: 70px;
			text-align: center;
			top: 23px;
			background: #fff !important;
		}

		.nav-pills>li.active>a [class*="fa-"],
		.nav-pills>li.active>a:hover [class*="fa-"],
		.nav-pills>li.active>a:focus [class*="fa-"],
		.nav-pills>li a.active [class*="fa-"],
		.nav-pills>li a.active:hover [class*="fa-"],
		.nav-pills>li a.active:focus [class*="fa-"] {
			background: transparent !important;
			color: #fff;
		}

		.nav-pills>li:last-child a.active:after {
			left: -35px;
		}

		.nav-pills>li.active>a:after,
		.nav-pills>li a.active:after {
			content: '';
			width: 70px;
			height: 70px;
			border-radius: 50%;
			display: inline-block;
			position: absolute;
			right: auto;
			left: -35px;
			top: -2px;
			transform: scale(1);
		}

		.wizard-card[data-color="theme"] .nav-pills .icon-circle.checked {
			border-color: #882439;
			background-color: #ffffff !important;
		}

		.progress-bar:before,
		.progress-bar:after {
			animation: none;
			display: none;
		}

		.wizard-card[data-color="theme"] .nav-pills>li.active>a:after,
		.wizard-card[data-color="theme"] .nav-pills>li a.desactive:after {
			background: none;
		}

		.nav-pills>li>a {
			font-size: 10px;
		}

		.wizard-card[data-color="theme"] .nav-pills>li.active>a,
		.wizard-card[data-color="theme"] .nav-pills>li a.active {
			font-size: 10px;
		}

		.textPorcentage,
		.textEstatus {
			font-size: 10px !important;
		}

		.tooltipEstatus {
			position: absolute;
			left: 50%;
			top: -50px;
			transform: translateX(-50%);
			width: 200px;
			background: #444;
			color: #ccc;
			transition: .5s;
			border-radius: 10px;
			display: none;
		}

		.tooltipEstatus:before {
			content: '';
			position: absolute;
			width: 14px;
			height: 14px;
			background: #444;
			left: 50%;
			transform: translateX(-50%) rotate(45deg);
			bottom: -7px;
		}

		/* .wizard-navigation ul li a{
	cursor: default !important;
	} */
		@media only screen and (max-width: 868px) {
			.wizard-card {
				min-height: 100px;
			}

			.wizard-card .icon-circle {
				width: 40px;
				height: 40px;
				margin-top: 15px;
			}

			.nav-pills>li.active>a:after,
			.nav-pills>li a.active:after {
				width: 40px;
				height: 40px;
				left: -20px;
				top: 13px;
			}

			.nav-pills>li:last-child a.active:after {
				left: -20px;
			}

			.wizard-card .icon-circle [class*="fa-"] {
				top: 10px;
				width: 40px;
				font-size: 16px;
			}

			.tooltipEstatus {
				display: block;
			}

			.textEstatus {
				display: block;

			}

			.tamanio_div {
				height: 910px;
			}
		}

		@media only screen and (max-width: 580px) {
			.wizard-card .icon-circle {
				width: 30px;
				height: 30px;
				margin-top: 21px;
			}

			.nav-pills>li.active>a:after,
			.nav-pills>li a.active:after {
				width: 30px;
				height: 30px;
				left: -15px;
				top: 19px;
			}

			.nav-pills>li:last-child a.active:after {
				left: -15px;
			}

			.wizard-card .icon-circle [class*="fa-"] {
				top: 7px;
				width: 30px;
				font-size: 12px;
			}
		}
	</style>



</head>

<body>
	<div class="container-fluid p-0">
		<?php

		$ver_menu = explode("|", CarpetasRol($rol_usuario_creador));
		include_once ($rol_usuario_creador == "100") ?  "menu.php" : $ver_menu[0];

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
								<?php
								$ver_index = explode("|", CarpetasRol($rol_usuario_creador));
								echo ($rol_usuario_creador == "100") ? "<a class='text-white' href='index.php'>Inicio</a>" : "<a class='text-white' href='$ver_index[1]'>Inicio</a>";
								?>
							</li>

							<span class="text-white"> &nbsp;/&nbsp; </span>

							<li class="active text-white">
								<strong>Resumen Egresos | Ingresos de Recurso</strong>
							</li>

							<?php

							if ($empleados === "3" || $empleados === "78" || $empleados === "88" || $empleados === "91") {

								echo "<span class='text-white'> &nbsp;/&nbsp; </span>
								<li class='active text-white'>
								<strong><i class='fas fa-key fa-2x' onclick='GenerateToken();' data-bs-toggle=\"tooltip\" data-bs-placement=\"bottom\" title=\"Generar Token Recurso\"></i></strong>
								</li>
								";
							}

							?>

						</ol>

						<br>


						<!-- Modal Filtros mostrarModalrecurso-->
						<div class="modal fade" id="modal_recurso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel"> Filtros entrega y recepción de recurso </h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body" id="add_opciones_modal_dinamico">

										<div class="ocultar_filters vaciar_filters" id="show_tipo_entrega_recepcion" style="display: none;"></div>
										<div class="ocultar_filters vaciar_filters" id="show_id" style="display: none;"></div>
										<div class="ocultar_filters vaciar_filters" id="show_responsable" style="display: none;"></div>
										<div class="ocultar_filters vaciar_filters" id="show_status_recurso" style="display: none;"></div>
										<div class="ocultar_filters vaciar_filters" id="show_status_logistica" style="display: none;"></div>
										<div class="ocultar_filters vaciar_filters" id="show_status_tesoreria" style="display: none;"></div>
										<div class="ocultar_filters vaciar_filters" id="show_status_cobranza" style="display: none;"></div>


									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
									</div>
								</div>
							</div>
						</div>


						<!-- Modal Info ActionsModalWallet-->
						<div class="modal fade" id="modal_actions_wallet" tabindex="-1" aria-labelledby="title_modal_actions" aria-hidden="true">
							<div class="modal-dialog modal-lg modal-dialog-scrollable">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="title_modal_actions"></h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<div class="col-sm-12" id="show_fecha_movimiento" style="display: none;">

										<div class="col-sm-12">
											<div class="d-flex align-items-center mb-2" onclick="clean_fecha_movimiento();">
												<label class="mb-0 mr-2">*Fecha Movimiento</label>&nbsp;
												<div class="container-iconos-1">
													<i class="fa fa-trash-o" aria-hidden="true"></i>
												</div>
											</div>
											<input class="form-control vaciar_input" type="text" id="fecha_movimiento" name="fecha_movimiento" readonly>
										</div>

									</div>

									<div class="modal-body" id="add_opciones_modal_options">

									</div>

									<div class="col-sm-12" id="comentarios_actions" style="display: block; ">
										<div class="col-sm-12">
											<label>*Comentarios&nbsp;&nbsp;<span class="contador_span" id="contador_span_wallet">20 caracteres restantes</label>
											<textarea name="comentarios_recurso" id="comentarios_recurso" class="form-control vaciar_input" rows="2" required="" onkeypress="cancelar_enter()" onkeyup="RangeComentarios(this,'contador_span_wallet','guardar_actions');"></textarea>
										</div>
									</div>

									<input type="hidden" class="vaciar_input" name="tipo_fomulario_option" id="tipo_fomulario_option">
									<input type="hidden" class="vaciar_input" name="idlogistica" id="idlogistica">
									<input type="hidden" name="fecha_creacion" id="fecha_creacion_actions" value="<?php echo $fecha_guardado; ?>">
									<input type="hidden" name="coordenadas_token" id="coordenadas_token" class="coordenadas">
									<input type="hidden" class="vaciar_input" name="tipo_entrega_recepcion" id="tipo_entrega_recepcion">
									<br>
									<div class="modal-footer">

										<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
										<button type="button" class="btn btn-primary" data-dismiss="modal" id="guardar_actions" style="display: none;" onclick="ConfirmarActions();">Guardar</button>

									</div>
								</div>
							</div>
						</div>


						<div class='row m-0 mt-3'>
							<div class='col-sm-12'>
								<div class='mt-1 mb-3 p-3 button-container bg-white border shadow-sm tamanio_div'>
									<center>
										<h1>Iconos Informativos</h1>
									</center>

									<div class='wizard-container'>
										<div class='card wizard-card' data-color='theme' id='wizardProfile'>
											<div class='wizard-navigation'>
												<div class="progress-with-circle">
													<div class='progress-bar' id="progress-bar-circle" role='progressbar' aria-valuenow='<?php echo "$barra"; ?>' aria-valuemin='5' aria-valuemax='95' style="width:<?php echo "$barra"; ?>%">
														<p class="textEstatusPrimero" style="display: none;"><?php echo "$estado"; ?></p>
													</div>
												</div>
												<ul class="nav nav-pills">

													<li style="width: 25%;">
														<a class="p6">
															<div class='icon-circle'><i class="fas fa-file-pdf"></i></div>
															<p class="textPorcentage">Visualizar</p>
															<p class="textEstatus">Recibo Recurso</p>
														</a>
													</li>

													<li style="width: 25%;">
														<a class="p17">
															<div class='icon-circle'><i class="fas fa-info-circle"></i></div>
															<p class="textPorcentage">Visualizar</p>
															<p class="textEstatus">Bitácora</p>
														</a>
													</li>

													<li style="width: 25%;">
														<a class="p28">
															<div class='icon-circle'><i class="far fa-images"></i></div>
															<p class="textPorcentage">Visualizar</p>
															<p class="textEstatus">Evidencia Ingreso | Egreso</p>
														</a>
													</li>

													<li style="width: 25%;">
														<a class="p94">
															<div class='icon-circle'><i class="far fa-file-pdf"></i></div>
															<p class="textPorcentage">Visualizar</p>
															<p class="textEstatus textCambio">Recibo Tesoreria</p>
														</a>
													</li>

												</ul>
											</div>
										</div>
									</div>

									<br>

									<center>
										<h1>Ejecutar Acciones</h1>
									</center>

									<div class='wizard-container'>
										<div class='card wizard-card' data-color='theme' id='wizardProfile'>

											<div class='wizard-navigation'>
												<div class="progress-with-circle">
													<div class='progress-bar' id="progress-bar-circle" role='progressbar' aria-valuenow='<?php echo "$barra"; ?>' aria-valuemin='5' aria-valuemax='95' style="width:<?php echo "$barra"; ?>%">
														<p class="textEstatusPrimero" style="display: none;"><?php echo "$estado"; ?></p>
													</div>
												</div>

												<ul class="nav nav-pills">

													<li style="width: 20%;">
														<a class="p50">
															<div class='icon-circle'><i class="fas fa-filter"></i></div>
															<p class="textPorcentage">Filtros</p>
														</a>
													</li>

													<li style="width: 20%;">
														<a class="p50">
															<div class='icon-circle'><i class="fas fa-key"></i></div>
															<p class="textPorcentage">Aplicar Token</p>
															<p class="textEstatus"><b>El trasladista no tiene token</b></p>
														</a>
													</li>

													<li style="width: 20%;">
														<a class="p61">
															<div class='icon-circle'><i class="fas fa-gavel"></i></div>
															<p class="textPorcentage">Confirmar</p>
															<p class="textEstatus">Entrega | Recepción de Recurso</p>
														</a>
													</li>

													<li style="width: 20%;">
														<a class="p72">
															<div class='icon-circle'><i class="fas fa-hand-holding-usd"></i></div>
															<p class="textPorcentage">Solo <b>INGRESO</b></p>
															<p class="textEstatus">Enviar Recurso a Tesorería</p>
														</a>
													</li>

													<li style="width: 20%;">
														<a class="p83">
															<div class='icon-circle'><i class="fas fa-money-check-alt"></i></div>
															<p class="textPorcentage">Tesorería</p>
															<p class="textEstatus">Aplicar Recurso</p>
														</a>
													</li>

												</ul>
											</div>
										</div>
									</div>

									<br>
									<br>

									<center>
										<h1>Editar Movimientos</h1>
									</center>

									<div class='wizard-container'>
										<div class='card wizard-card' data-color='theme' id='wizardProfile'>

											<div class='wizard-navigation'>
												<div class="progress-with-circle">
													<div class='progress-bar' id="progress-bar-circle" role='progressbar' aria-valuenow='<?php echo "$barra"; ?>' aria-valuemin='5' aria-valuemax='95' style="width:<?php echo "$barra"; ?>%">
														<p class="textEstatusPrimero" style="display: none;"><?php echo "$estado"; ?></p>
													</div>
												</div>

												<ul class="nav nav-pills">

													<li style="width: 16.66%;">
														<a class="p50">
															<div class='icon-circle'><i class="fas fa-funnel-dollar"></i></div>
															<p class="textPorcentage">Modificar</p>
															<p class="textEstatus">Tipo de Cambio</p>
														</a>
													</li>

													<li style="width: 16.66%;">
														<a class="p50">
															<div class='icon-circle'><i class="fas fa-user-edit"></i></div>
															<p class="textPorcentage">Editar ID</p>
															<p class="textEstatus">Antes de que se aplique en <b>TESORERÍA</b></p>
														</a>
													</li>

													<li style="width: 16.66%;">
														<a class="p50">
															<div class='icon-circle'><i class="far fa-calendar-alt"></i></div>
															<p class="textPorcentage">Fecha de Movimiento</p>
															<p class="textEstatus">Aplicar de forma <b>General</b></p>
														</a>
													</li>

													<li style="width: 16.66%;">
														<a class="p50">
															<div class='icon-circle'><i class="fas fa-upload"></i></div>
															<p class="textPorcentage">Agregar Evidencia</p>

														</a>
													</li>

													<li style="width: 16.66%;">
														<a class="p61">
															<div class='icon-circle'><i class="fas fa-exchange-alt"></i>></i></div>
															<p class="textPorcentage">Cambiar Evidencia</p>
														</a>
													</li>

													<li style="width: 16.66%;">
														<a class="p50">
															<div class='icon-circle'><i class="fas fa-trash"></i></div>
															<p class="textPorcentage">Eliminar Movimiento</p>
															<p class="textEstatus">Solo cambia el estatus</p>
														</a>
													</li>

												</ul>
											</div>
										</div>
									</div>

								</div>

							</div>
						</div>

						<!-- Modal Logistica-->
						<div class="modal fade" id="modalClean" tabindex="-1" aria-labelledby="titlemodallimpio" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="titlemodallimpio"></h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body" id="add_limpio_modal">


									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
									</div>
								</div>
							</div>
						</div>

						<form id="form_entrega_recepcion" method="POST">

							<div class="row col-sm-12">

								<div class="col-sm-12" id="range_fechas" style="display: block;">

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
												<input class="form-control" type="text" id="fecha_inicio" name="fecha_inicio" readonly="" />
											</div>
											<div class="col-sm-6">
												<label>*Fecha de Fin:</label>
												<input class="form-control" type="text" id="fecha_fin" name="fecha_fin" readonly="" />
											</div>
										</div>
									</div>

								</div>

								<input type="hidden" name="idcolaboradorloguin" value="<?php echo $empleados; ?>">

							</div>
						</form>

						<div class="col-sm-12">
							<br>
							<center>
								<button class="btn-lg btn-primary" id="show_date" type="button">Buscar</button>
							</center>
						</div>


						<div class="col-sm-12 p-0">
							<div class="table-responsive" id="show_table">

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

	<!-- time line -->
	<script src="../../assets/js/jquery.bootstrap.wizard.js"></script>
	<script src="../../assets/js/jquery.validate.min.js"></script>
	<!-- time line -->

	<script src="../../plugins/Datepicker/bootstrap-material-datetimepicker.js"></script>
	<script src="../../plugins/Datepicker/es-mx.min.js"></script>


	<script type="text/javascript">
		function CoordenadasUbicacion() {

			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {

					var latitud = position.coords.latitude;
					var longitud = position.coords.longitude;
					var coordenadas = latitud + " " + longitud;

					$(".coordenadas").val(coordenadas);


				}, function() {
					handleLocationError(true);
				});
			} else {

				handleLocationError(false);
			}


		}
	</script>


	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKNm5FUjlIYRpuH8aquS6q-7NzQdlAwgc">
	</script>




	<script type="text/javascript" class="init">
		$(document).ready(function() {

			$("#show_date").click(function() {

				$(".vaciar_filters").empty();

				ShowEntregaRecepcionRecurso();

				$("#dictionary_icons").show();

			});


			$(document).on('change', 'input[type="file"]', function() {

				var fileSize = this.files[0].size;
				let obtener_id_input = $(this).attr("id");

				if (fileSize > 9216000) {

					$("#" + obtener_id_input).val("")

					$(".error-form").show();
					$(".text-error").html("El archivo no debe superar los 9MB");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);

					return false;

				} else {

					return true;
				}

			});


		});





		function ShowEntregaRecepcionRecurso() {

			var datos_balance = $("#form_entrega_recepcion").serialize();

			var rol_usuario_creador = '<?php echo $rol_usuario_creador; ?>'
			var link = (rol_usuario_creador == 100) ? "show_entrega_recepcion_recurso.php" : "../Logistica/show_entrega_recepcion_recurso.php";

			$.ajax({
				url: link,
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
			// disable: [
			// 1,2,3, 4,5,6
			// ]
		});


		$('#fecha_movimiento').bootstrapMaterialDatePicker({
			date: true,
			time: false,
			shortTime: true,
			format: 'YYYY-MM-DD',
			lang: "es",
			cancelText: 'Cancelar',
			okText: 'Definir',
			maxDate: moment().add(01, 'days')
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


		function mostrarModalrecurso(modal_valor) {

			let tabla = "recurso";
			let ok = "<?php echo $idc; ?>"
			let idl = ok;
			let fecha_inicio = $("#fecha_inicio").val();
			let fecha_fin = $("#fecha_fin").val();


			if (modal_valor == "tipo_movimiento") {

				($('#show_tipo_entrega_recepcion').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_tipo_entrega_recepcion", fecha_inicio, fecha_fin): $('#modal_recurso').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_tipo_entrega_recepcion").show();

			} else if (modal_valor == "id") {

				($('#show_id').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_id", fecha_inicio, fecha_fin): $('#modal_recurso').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_id").show();

			} else if (modal_valor == "responsable") {

				($('#show_responsable').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_responsable", fecha_inicio, fecha_fin): $('#modal_recurso').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_responsable").show();

			} else if (modal_valor == "status_recurso") {

				($('#show_status_recurso').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_status_recurso", fecha_inicio, fecha_fin): $('#modal_recurso').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_status_recurso").show();

			} else if (modal_valor == "status_logistica") {

				($('#show_status_logistica').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_status_logistica", fecha_inicio, fecha_fin): $('#modal_recurso').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_status_logistica").show();

			} else if (modal_valor == "status_tesoreria") {

				($('#show_status_tesoreria').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_status_tesoreria", fecha_inicio, fecha_fin): $('#modal_recurso').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_status_tesoreria").show();

			} else if (modal_valor == "status_cobranza") {

				($('#show_status_cobranza').contents().length == 0) ? modal_ajax(tabla, modal_valor, idl, "show_status_cobranza", fecha_inicio, fecha_fin): $('#modal_recurso').modal('toggle');

				$(".ocultar_filters").hide();
				$("#show_status_cobranza").show();

			}



		}


		function modal_ajax(tabla, modal_valor, idc, viewdiv, fecha_inicio, fecha_fin) {

			var rol_usuario_creador = '<?php echo $rol_usuario_creador; ?>'
			var link = (rol_usuario_creador == 100) ? "show_datos_modal.php" : "../Logistica/show_datos_modal.php";

			$.ajax({
				type: "POST",
				url: link,
				data: {
					valorBusqueda: tabla,
					valorSelect: modal_valor,
					idc: idc,
					fecha_inicio: fecha_inicio,
					fecha_fin: fecha_fin
				},
				success: function(modal_result_recurso) {

					$("#" + viewdiv).html(modal_result_recurso);
					$('#modal_recurso').modal('toggle');
					$("#" + viewdiv).show();

				}
			});

			return false;


		}




		function ActionsModalWallet(actionswallet) {

			$('#modal_actions_wallet').modal('toggle');

			$("#title_modal_actions").val("");
			$(".vaciar_input").val("");

			$("#add_opciones_modal_options").empty();
			$("#show_fecha_movimiento").hide();

			$("#resultado_operacion").empty();

			TiempoAhora();


			var porciones_actions = actionswallet.split("|");

			var rol_usuario_creador = '<?php echo $rol_usuario_creador; ?>'

			if (porciones_actions[0] == "InfoB") {

				$("#title_modal_actions").html("Bitácora de Seguimiento en: <b>" + porciones_actions[2] + "</b>");
				$("#comentarios_actions").hide();


				var link = (rol_usuario_creador == 100) ? "delete_balance_gastos.php" : "../Logistica/delete_balance_gastos.php";


				$.ajax({
					type: "POST",
					url: link,
					data: {
						pasar_referencia: porciones_actions[1],
						tipo: porciones_actions[2]
					},
					success: function(modal_result_recurso) {

						$("#add_opciones_modal_options").html(modal_result_recurso);

					}
				});

			} else if (porciones_actions[0] == "TokenRecibo") {


				$("#title_modal_actions").html("Confirmar Token de Recibo en: <b>" + porciones_actions[1] + "</b>");

				var tipo_movimiento = porciones_actions[1];
				$("#idlogistica").val(porciones_actions[3]);
				$("#tipo_entrega_recepcion").val(tipo_movimiento);
				$("#tipo_fomulario_option").val(porciones_actions[0]);

				var agregar_inputs = `
				<div class="col-sm-12">
					<label>*Token</label>
					<input type="hidden" name="tipo_token" id="tipo_token" value="Recibo">
					<input type="text" name="search_token" id="search_token" class="form-control" readonly value="${porciones_actions[2]}">
					<input type="hidden" name="referencia_movimiento" id="referencia_movimiento" class="form-control" readonly value="${porciones_actions[4]}">
				</div>
				`;

				$("#comentarios_actions").show();

			} else if (porciones_actions[0] == "ConfirmarRecurso") {


				$("#title_modal_actions").html("Confirmar Recurso en: <b>" + porciones_actions[1] + "</b>");

				var tipo_movimiento = porciones_actions[1];
				$("#idlogistica").val(porciones_actions[3]);
				$("#tipo_entrega_recepcion").val(tipo_movimiento);
				$("#tipo_fomulario_option").val(porciones_actions[0]);

				$("#comentarios_actions").show();
				if (tipo_movimiento == "Egreso") {

					var agregar_inputs = `
					<div class="col-sm-12">
						<label>Tipo de movimiento</label>
						<select name="tipo_confirmacion_entrega" id="tipo_confirmacion_entrega" class="form-control" onchange="ChangeEntregaRecurso(${porciones_actions[2]});">
							<option value="Completo">Recurso Completo</option>
							<option value="Modificar">Recurso Incompleto</option>
							<option value="Cancelado">No se Entrega Recurso</option>
						</select>
					</div>
						
					<div class="col-sm-12">
						<label>Monto Logística</label>
						<input type="text" id="monto_total_entrega_recurso_wallet" name="monto_total_entrega_recurso_wallet" class="form-control" readonly="readonly" value = '${porciones_actions[2]}' onkeypress="return SoloNumeros(event);">
						<input type="hidden" name="referencia_movimiento" id="referencia_movimiento" value="${porciones_actions[4]}">
					</div>
						
					`;

				} else {

					var agregar_inputs = `
					<div class="col-sm-12">
						<label>Tipo de movimiento</label>
						<select name="search_token" id="search_token" class="form-control" onchange="ChangeRecepcionRecurso(${porciones_actions[2]});">
							<option value="SI">Recurso Completo</option>
							<option value="modificar">Recurso Incompleto</option>
							<option value="NO">SIN Recurso</option>
							<option value="Cheque">Recepción de Cheque</option>
						</select>
					</div>
					<input type="hidden" name="tipo_token" id="tipo_token" value="Confirmar Recurso">
					<div class="col-sm-12">
						<label>Monto Logística</label>
						<input type="text" id="monto_total_recepcion_recurso_wallet" name="monto_total_recepcion_recurso_wallet" class="form-control" readonly="readonly" value = '${porciones_actions[2]}' onkeypress="return SoloNumeros(event);">
						<input type="hidden" name="referencia_movimiento" id="referencia_movimiento" value="${porciones_actions[4]}">
					</div>

					`;

				}

			} else if (porciones_actions[0] == "ConfirmarTesoreria") {


				$("#title_modal_actions").html("Confirmar Tesorería en: <b>" + porciones_actions[1] + "</b>");
				var tipo_movimiento = porciones_actions[1];
				$("#idlogistica").val(porciones_actions[3]);
				$("#tipo_entrega_recepcion").val(tipo_movimiento);
				$("#tipo_fomulario_option").val(porciones_actions[0]);

				var agregar_inputs = `
				<div class="col-sm-12">
					<label>Token</label>
					<input type="text" name="search_token" id="search_token" class="form-control" readonly value="${porciones_actions[2]}">
					<input type="hidden" name="id" id="idemwa" value="${porciones_actions[4]}">
					<input type="hidden" name="codigo" id="codigo" value="0">
					<input type="hidden" name="referencia_movimiento" id="referencia_movimiento" value="${porciones_actions[5]}">
				</div>
				`;
				$("#comentarios_actions").show();

			} else if (porciones_actions[0] == "ConfirmarTrasladista") {

				$("#comentarios_actions").show();
				$("#title_modal_actions").html("Confirmar Recurso a Tesorería en: <b>" + porciones_actions[1] + "</b>");
				var tipo_movimiento = porciones_actions[1];
				$("#idlogistica").val(porciones_actions[3]);
				$("#tipo_entrega_recepcion").val(tipo_movimiento);
				$("#tipo_fomulario_option").val(porciones_actions[0]);


				var agregar_inputs = `
				<div class="col-sm-12">
					<label>Tesorería Recibe Recurso</label>
					<select name="id_colaborador" id="id_colaborador" class="form-control" >
						<option value="TP1">TP1</option>
						<option value="TJFR">JFR</option>
						<option value="TEDFM">EDFM</option>
						<option value="TP3">TP3</option>
					</select>
				</div>
				<input type="hidden" name="type_colaborador" id="type_colaborador" value="Tesoreria">
				<input type="hidden" name="referencia_seguimiento" id="referencia_movimiento" value="${porciones_actions[4]}">
				<input type="hidden" name="tipo_token" id="tipo_token" value="ConfirmarTrasladista">
				`;
				$("#comentarios_actions").show();

			} else if (porciones_actions[0] == "CambiarID") {

				$("#title_modal_actions").html("Cambiar ID en: <b>" + porciones_actions[2] + "</b>");
				$("#comentarios_actions").show();

				$("#tipo_fomulario_option").val(porciones_actions[0]);

				var agregar_inputs = `
				<div class="col-sm-12">
					<label for="busqueda_id">Buscar ID</label>
					<input placeholder="Buscar" class="form-control" type="text" name="busqueda_id" id="busqueda_id" value="" maxlength="50" autocomplete="off" onKeyUp="buscar_cliente();" size="19" width="300%"  />
					<center>
						<div id="resultadoBusquedaId" class="container-busquedas-1 mt-4 efecto-busqueda" style="display: none;"></div>
					</center>
				</div>

				<div class="col-sm-12">
					<label>*ID</label>
					<input class="form-control" type="text"  name="idcliente" id="idcliente" required="" readonly="" />
				</div>

				<div class="col-sm-12">
					<label>*Nombre</label>
					<input class="form-control" type="text"  name="nombre" id="nombre" required="" readonly="" />
				</div>

				<div class="col-sm-12">
					<label>*Apellidos</label>
					<input class="form-control" type="text"  name="apellidos" id="apellidos" required="" readonly="" />
				</div>

				<div class="col-sm-12">
					<label>*Alias</label>
					<input class="form-control" type="text"  name="alias" id="alias"  readonly="" />
				</div>

				<div class="col-sm-12">
					<label>*Tipo Contacto</label>
					<input class="form-control" type="text"  name="tipo_contacto_id" id="tipo_contacto_id"  readonly="" />
				</div>
				<br>
				<div class="col-sm-12" style="display: none;" id="show_contenedor">
				<div class="alert alert-success" role="alert" id="tipo_tabla_contacto">

				</div>
				</div>


				<input type="hidden" name="referencia_movimiento" id="referencia_movimiento" value="${porciones_actions[1]}">

				`;

			} else if (porciones_actions[0] == "CambiarDate") {

				$("#title_modal_actions").html("Cambiar Fecha de Movimiento en: <b>" + porciones_actions[2] + "</b>");
				$("#comentarios_actions").show();

				$("#show_fecha_movimiento").show();

				$("#tipo_fomulario_option").val(porciones_actions[0]);
				$("#tipo_entrega_recepcion").val(porciones_actions[2]);
				$("#idlogistica").val(porciones_actions[3]);

				var agregar_inputs = `
				<input type="hidden" name="referencia_movimiento" id="referencia_movimiento" value="${porciones_actions[1]}">
				`;

			} else if (porciones_actions[0] == "SubirEvidencia") {

				$("#title_modal_actions").html("Subir | Cambiar Evidencia: <b>" + porciones_actions[1] + "</b>");
				$("#comentarios_actions").show();

				$("#tipo_fomulario_option").val(porciones_actions[0]);
				$("#tipo_entrega_recepcion").val(porciones_actions[1]);
				$("#idlogistica").val(porciones_actions[2]);

				var agregar_inputs = `
				<div class="col-sm-12">
					<label class="form-label">Subir Evidencia</label>
					<input class="form-control" type="file" id="evidencia" name="evidencia" >
				</div>
				<input type="hidden" name="referencia_movimiento" id="referencia_movimiento" value="${porciones_actions[3]}">
				<input type="hidden" name="idorden_logistica_documentacion" id="idorden_logistica_documentacion" value="${porciones_actions[4]}">
				`;

			} else if (porciones_actions[0] == "TipoCambio") {

				$("#title_modal_actions").html("Agregar Tipo de Cambio: <b>" + porciones_actions[2] + "</b>");
				$("#comentarios_actions").show();

				$("#tipo_fomulario_option").val(porciones_actions[0]);
				$("#tipo_entrega_recepcion").val(porciones_actions[2]);


				var agregar_inputs = `
				<div class="col-sm-12">
					<label>Monto Actual</label>
					<input class="form-control" type="text"  name="monto_actual" value="${porciones_actions[3]}" readonly>
					<input type="hidden" name="monto_operacion" id="monto_operacion" value="${porciones_actions[4]}">
					<input type="hidden" name="moneda_operacion" id="moneda_operacion" value="${porciones_actions[5]}">
				</div>

				<div class="col-sm-12">
					<label>Tipo de Cambio</label>
					<input class="form-control" type="number" id="t_cambio" name="t_cambio" onkeyup="operaciones();" onkeypress="return SoloNumeros(event);">
				</div>
				<input type="hidden" name="referencia_movimiento" id="referencia_movimiento" value="${porciones_actions[1]}">

				<div class="col-sm-12" style='display: none;' id='letras_resultado'>

				<div class="col-sm-12 alert alert-info" role="alert" id="resultado_operacion">

				</div>

				</div>
				`;

			} else if (porciones_actions[0] == "DeleteMov") {

				$("#title_modal_actions").html("Eliminar Movimiento: <b>" + porciones_actions[2] + "</b>");
				$("#comentarios_actions").show();

				$("#tipo_fomulario_option").val(porciones_actions[0]);
				$("#tipo_entrega_recepcion").val(porciones_actions[2]);

				var agregar_inputs = `
				<input type="hidden" name="referencia_movimiento" id="referencia_movimiento" value="${porciones_actions[1]}">
				`;

			}

			CoordenadasUbicacion();

			$("#add_opciones_modal_options").html(agregar_inputs);

		}



		function ConfirmarActions() {

			$("#guardar_actions").hide();
			var rol_usuario_creador = '<?php echo $rol_usuario_creador; ?>'

			$('#modal_actions_wallet').modal('hide');

			var tipo_fomulario_option = $("#tipo_fomulario_option").val();

			var idlogistica = $("#idlogistica").val();
			var comentarios_recurso = $("#comentarios_recurso").val();
			var coordenadas_token = $("#coordenadas_token").val();
			var fecha_creacion = TiempoAhora();
			var tipo_entrega_recepcion = $("#tipo_entrega_recepcion").val();

			var formData = new FormData();

			if (tipo_fomulario_option == "TokenRecibo") {

				var tipo_token = $("#tipo_token").val();
				var search_token = $("#search_token").val();
				var referencia_movimiento = $("#referencia_movimiento").val();

				formData.append('tipo_token', tipo_token);
				formData.append('search_token', search_token);
				formData.append('referencia_movimiento', referencia_movimiento);


				var link_ajax = (tipo_entrega_recepcion == "Egreso") ? "../Ejecutivos_Traslado/buscar_token_entrega.php" : "../Ejecutivos_Traslado/buscar_token.php";

			} else if (tipo_fomulario_option == "ConfirmarRecurso") {

				if (tipo_entrega_recepcion == "Egreso") {

					var monto_total_entrega_recurso_wallet = $("#monto_total_entrega_recurso_wallet").val();
					var tipo_confirmacion_entrega = $("#tipo_confirmacion_entrega").val();
					var referencia_movimiento = $("#referencia_movimiento").val();

					formData.append('monto_total_entrega_recurso_wallet', monto_total_entrega_recurso_wallet);
					formData.append('tipo_confirmacion_entrega', tipo_confirmacion_entrega);
					formData.append('referencia_movimiento', referencia_movimiento);

					var link_ajax = (rol_usuario_creador == "102") ? "guardar_evidencia_entrega_recurso.php" : "../Ejecutivos_Traslado/guardar_evidencia_entrega_recurso.php";

				} else {

					var tipo_token = $("#tipo_token").val();
					var search_token = $("#search_token").val();
					var monto_total_recepcion_recurso_wallet = $("#monto_total_recepcion_recurso_wallet").val();
					var referencia_movimiento = $("#referencia_movimiento").val();

					formData.append('tipo_token', tipo_token);
					formData.append('search_token', search_token);
					formData.append('monto_total_recepcion_recurso_wallet', monto_total_recepcion_recurso_wallet);
					formData.append('referencia_movimiento', referencia_movimiento);

					var link_ajax = (rol_usuario_creador == "102") ? "guardar_evidencia_recepcion_recurso.php" : "../Ejecutivos_Traslado/guardar_evidencia_recepcion_recurso.php";

				}

			} else if (tipo_fomulario_option == "ConfirmarTesoreria") {

				var search_token = $("#search_token").val();
				var idemwa = $("#idemwa").val();
				var codigo = $("#codigo").val();
				var referencia_movimiento = $("#referencia_movimiento").val();

				formData.append('token', search_token);
				formData.append('id', idemwa);
				formData.append('codigo', codigo);

				var link_ajax = (rol_usuario_creador == "Tesorerias") ? "confirmacion_token_wallet_tesoreria.php" : "../Tesorerias/confirmacion_token_wallet_tesoreria.php";


			} else if (tipo_fomulario_option == "ConfirmarTrasladista") {

				var id_colaborador = $("#id_colaborador").val();
				var type_colaborador = $("#type_colaborador").val();
				var referencia_movimiento = $("#referencia_movimiento").val();
				var tipo_token = $("#tipo_token").val();

				formData.append('id_colaborador', id_colaborador);
				formData.append('type_colaborador', type_colaborador);
				formData.append('referencia_movimiento', referencia_movimiento);
				formData.append('tipo_token', tipo_token);

				var link_ajax = (rol_usuario_creador == "102") ? "guardar_entrega_recurso.php" : "../Ejecutivos_Traslado/guardar_entrega_recurso.php";


			} else if (tipo_fomulario_option == "CambiarID") {

				var idcliente = $("#idcliente").val();
				var tipo_contacto_id = $("#tipo_contacto_id").val();
				var referencia_movimiento = $("#referencia_movimiento").val();
				var tipo_fomulario_option = $("#tipo_fomulario_option").val();

				formData.append('idcliente', idcliente);
				formData.append('tipo_contacto_id', tipo_contacto_id);
				formData.append('referencia_movimiento', referencia_movimiento);
				formData.append('tipo_fomulario_option', tipo_fomulario_option);

				var link_ajax = (rol_usuario_creador == "100") ? "guardar_cambio_vin_individual.php" : "../Logistica/guardar_cambio_vin_individual.php";


			} else if (tipo_fomulario_option == "CambiarDate") {

				var fecha_movimiento = $("#fecha_movimiento").val();
				var referencia_movimiento = $("#referencia_movimiento").val();
				var tipo_fomulario_option = $("#tipo_fomulario_option").val();


				formData.append('fecha_movimiento', fecha_movimiento);
				formData.append('referencia_movimiento', referencia_movimiento);
				formData.append('tipo_fomulario_option', tipo_fomulario_option);

				var link_ajax = (rol_usuario_creador == "100") ? "guardar_cambio_vin_individual.php" : "../Logistica/guardar_cambio_vin_individual.php";


			} else if (tipo_fomulario_option == "SubirEvidencia") {

				var files = $("#evidencia")[0].files[0];
				formData.append('evidencia', files);

				var idorden_logistica_documentacion = $("#idorden_logistica_documentacion").val();
				var tipo_fomulario_option = $("#tipo_fomulario_option").val();
				var referencia_movimiento = $("#referencia_movimiento").val();


				formData.append('idorden_logistica_documentacion', idorden_logistica_documentacion);
				formData.append('tipo_fomulario_option', tipo_fomulario_option);
				formData.append('referencia_movimiento', referencia_movimiento);

				var link_ajax = (rol_usuario_creador == "100") ? "guardar_cambio_vin_individual.php" : "../Logistica/guardar_cambio_vin_individual.php";

			} else if (tipo_fomulario_option == "TipoCambio") {

				var tipo_fomulario_option = $("#tipo_fomulario_option").val();
				var referencia_movimiento = $("#referencia_movimiento").val();
				var t_cambio = $("#t_cambio").val();
				tipo_entrega_recepcion
				var tipo_entrega_recepcion = $("#tipo_entrega_recepcion").val();

				formData.append('tipo_fomulario_option', tipo_fomulario_option);
				formData.append('referencia_movimiento', referencia_movimiento);
				formData.append('t_cambio', t_cambio);
				formData.append('tipo_entrega_recepcion', tipo_entrega_recepcion);

				var link_ajax = (rol_usuario_creador == "100") ? "guardar_cambio_vin_individual.php" : "../Logistica/guardar_cambio_vin_individual.php";

			} else if (tipo_fomulario_option == "DeleteMov") {

				var tipo_fomulario_option = $("#tipo_fomulario_option").val();
				var referencia_movimiento = $("#referencia_movimiento").val();
				var tipo_entrega_recepcion = $("#tipo_entrega_recepcion").val();

				formData.append('tipo_fomulario_option', tipo_fomulario_option);
				formData.append('referencia_movimiento', referencia_movimiento);
				formData.append('tipo_entrega_recepcion', tipo_entrega_recepcion);

				var link_ajax = (rol_usuario_creador == "100") ? "guardar_cambio_vin_individual.php" : "../Logistica/guardar_cambio_vin_individual.php";



			} else {

				$(".error-form").show();
				$(".text-error").html("Movimiento no Disponible");

				setTimeout(function() {
					$(".error-form").fadeOut(3000);
				}, 1500);

				return false;
			}

			formData.append('idlogistica', idlogistica);
			formData.append('columna_c', comentarios_recurso);
			formData.append('coordenadas_token', coordenadas_token);
			formData.append('fecha_creacion', fecha_creacion);
			formData.append('tipo_entrega_recepcion', tipo_entrega_recepcion);



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



					if (tipo_fomulario_option == "ConfirmarTesoreria") {

						let por = json.split("*");


						if (por[0].trim() == "Guardado") {

							if (por[1].trim() == "Se encontró un pago igual") {
								$(".error-form").show();
								$(".text-error").html(por[1]);
								setTimeout(function() {
									$(".error-form").fadeOut(1000);
								}, 1500);

								OptionsModalLimpio('toggle|Solicitar Ingresar Token');

								var FormTokenExepcion = `
								
									<label>¿ Solicitar Token ?</label><br>
									<label>SI</label>
									<input type='radio' class='radio1 AsignarTR' id='AsignarTRSI' name='tokenrecursomodal' onclick=\"SolicitarTokenDesbloqueo('Solicitar');\"> &nbsp;&nbsp;&nbsp;&nbsp;
									<label>Ya Tengo token</label>
									<input type='radio' class='radio1 AsignarTR' id='AsignarTRNO' name='tokenrecursomodal' onclick=\"SolicitarTokenDesbloqueo('Ya tengo');\">

									<div class="col-sm-12" id="solicitar_token" style="display: none;">
										<label>Solicitar token a: </label>
										<select id='idcolaboratorsolicitartoken' class="form-control" name="idcolaboratorsolicitartoken">
											<option value='78'>MAMM</option>
											<option value='88'>JAH</option>
										</select>
										<br>
										<center>
											<button type="button" class="btn btn-primary" onclick="TokenSolicitud('${referencia_movimiento}');">Solicitar Token</button>
										</center>

									</div>

									<div id='MostrarYatengoToken' style='display:none'>

										<div class="col-sm-12">
											<label>Token</label>
											<input type="text" name="search_desbloqueo_token" id="search_desbloqueo_token" class="form-control" readonly value="${search_token}">
											<label>Ingresar Token</label>
											<input type="hidden" name="id" id="id_wallet_recurso_desbloqueo" value="${idemwa}">
											<input type="text" class='form-control' name="codigo_token_desbloqueo" id="codigo_token_desbloqueo" >
										</div>
										<br>
										<center>
											<button type="button" class="btn btn-primary" onclick="TengoToken('${referencia_movimiento}');">Guardar Movimiento</button>
										</center>

									</div>

								`;

								$("#add_limpio_modal").html(FormTokenExepcion);


							} else if (por[1].trim() == "No se encontró código de autorización") {

								$(".error-form").show();
								$(".text-error").html(por[1]);
								setTimeout(function() {
									$(".error-form").fadeOut(1000);
								}, 1500);

							} else {

								$(".listo-form").show();
								$(".text-listo").html("<b>Datos Guardados Correctamente</b>");

								setTimeout(function() {
									$(".listo-form").fadeOut(1000);
								}, 1500);

								(rol_usuario_creador == "Tesorerias") ? window.open('recibo_tesoreria_pdf.php?id=' + por[1].trim()): window.open('../Tesorerias/recibo_tesoreria_pdf.php?id=' + por[1].trim());


							}

						} else {

							$(".error-form").show();
							$(".text-error").html(por[0].trim());
							setTimeout(function() {
								$(".error-form").fadeOut(1000);
							}, 1500);
						}

					} else {

						if (json.trim() == 1) {

							$(".listo-form").show();
							$(".text-listo").html("<b>Datos Guardados Correctamente</b>");

							setTimeout(function() {
								$(".listo-form").fadeOut(1000);
							}, 1500);


						} else {

							$(".error-form").show();
							$(".text-error").html(json);

							setTimeout(function() {
								$(".error-form").fadeOut(3000);
							}, 1500);
						}



					}

					$(".container-loading-ajax").hide();
					ShowEntregaRecepcionRecurso();

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


		function TengoToken(valor) {

			var rol_usuario_creador = '<?php echo $rol_usuario_creador; ?>'

			var search_token = $("#search_desbloqueo_token").val();
			var idemwa = $("#id_wallet_recurso_desbloqueo").val();
			var codigo = $("#codigo_token_desbloqueo").val();
			var referencia_movimiento = valor;
			var fecha_creacion = TiempoAhora();

			var formData = new FormData();

			formData.append('token', search_token);
			formData.append('id', idemwa);
			formData.append('codigo', codigo);
			formData.append('fecha_creacion', fecha_creacion);

			var link_ajax = (rol_usuario_creador == "Tesorerias") ? "confirmacion_token_wallet_tesoreria.php" : "../Tesorerias/confirmacion_token_wallet_tesoreria.php";


			//return false;

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

					let por = json.split("*");


					if (por[0].trim() == "Guardado") {

						if (por[1].trim() == "Se encontró un pago igual") {
							$(".error-form").show();
							$(".text-error").html(por[1]);
							setTimeout(function() {
								$(".error-form").fadeOut(1000);
							}, 1500);

						} else if (por[1].trim() == "No se encontró código de autorización") {

							$(".error-form").show();
							$(".text-error").html(por[1]);
							setTimeout(function() {
								$(".error-form").fadeOut(1000);
							}, 1500);

						} else {

							$(".listo-form").show();
							$(".text-listo").html("<b>Datos Guardados Correctamente</b>");

							setTimeout(function() {
								$(".listo-form").fadeOut(1000);
							}, 1500);

							(rol_usuario_creador == "Tesorerias") ? window.open('recibo_tesoreria_pdf.php?id=' + por[1].trim()): window.open('../Tesorerias/recibo_tesoreria_pdf.php?id=' + por[1].trim());

						}

					} else {

						$(".error-form").show();
						$(".text-error").html(por[0].trim());
						setTimeout(function() {
							$(".error-form").fadeOut(1000);
						}, 1500);
					}
					ShowEntregaRecepcionRecurso();
					OptionsModalLimpio('hide|');
					$(".container-loading-ajax").hide();
				},
				error: function(xhr, status) {

					$(".error-form").show();
					$(".text-error").html("Disculpe, existió un problema");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
					$(".container-loading-ajax").hide();
				}

			});

		}


		function ChangeEntregaRecurso(monto_original) {

			var valor_entrega_recurso = $("#tipo_confirmacion_entrega").val();

			if (valor_entrega_recurso == "Modificar") {

				$("#monto_total_entrega_recurso_wallet").val("");
				$("#monto_total_entrega_recurso_wallet").removeAttr("readonly", "readonly");

			} else if (valor_entrega_recurso == "Cancelado") {

				$("#monto_total_entrega_recurso_wallet").val("0.00");
				$("#monto_total_entrega_recurso_wallet").attr("readonly", "readonly");

			} else {
				$("#monto_total_entrega_recurso_wallet").val(monto_original);
				$("#monto_total_entrega_recurso_wallet").attr("readonly", "readonly");
			}


		}

		function ChangeRecepcionRecurso(monto_original) {

			var valor_entrega_recurso = $("#search_token").val();

			if (valor_entrega_recurso == "modificar") {

				$("#monto_total_recepcion_recurso_wallet").val("");
				$("#monto_total_recepcion_recurso_wallet").removeAttr("readonly", "readonly");

			} else if (valor_entrega_recurso == "NO") {

				$("#monto_total_recepcion_recurso_wallet").val("0.00");
				$("#monto_total_recepcion_recurso_wallet").attr("readonly", "readonly");

			} else {
				$("#monto_total_recepcion_recurso_wallet").val(monto_original);
				$("#monto_total_recepcion_recurso_wallet").attr("readonly", "readonly");
			}


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



		function buscar_cliente() {

			var textoBusquedaID = $("#busqueda_id").val();
			var id_departamento = '<?php echo $iddepartamento; ?>';

			var rol_usuario_creador = '<?php echo $rol_usuario_creador; ?>'

			var link = (rol_usuario_creador == 100) ? "buscar_cliente_logostica.php" : "../Logistica/buscar_cliente_logostica.php";

			if (textoBusquedaID != "") {

				$.post(link, {
						valorBusqueda: textoBusquedaID,
						type_id: id_departamento
					},

					function(mensaje_id) {

						$("#resultadoBusquedaId").show();
						$("#resultadoBusquedaId").html(mensaje_id);


						if (mensaje_id.trim() == "<b>ID NO Encontrado</b>") {


							$("#idcliente").val("");
							$("#nombre").val("");
							$("#apellidos").val("");
							$("#alias").val("");
							$("#celular").val("");
							$("#fijo").val("");
							$("#estado").val("");
							$("#municipio").val("");
							$("#colonia").val("");
							$("#calle").val("");
							$("#codigo_postal_cliente").val("");
							$("#tipo_contacto_id").val("");
							$("#show_contenedor").hide();
							$("#tipo_tabla_contacto").empty();

						} else {

							$("#guardar_id_temporal").show();
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
							$("#show_contenedor").hide();
							$("#tipo_tabla_contacto").empty();


						}
					});
			} else {
				$("#resultadoBusquedaId").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
			};

			$(document).on('click', '.option_id_logistica_generar', function(event) {

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
				unidad_contenedor = porcion[12];
				$("#busqueda_id").val("");
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
				$("#resultadoBusquedaId").html("");
				$("#resultadoBusquedaId").hide();

				$("#show_contenedor").show();
				$("#tipo_tabla_contacto").html(`<center> <h3>Contenedor Final</h3> <h4>${unidad_contenedor}</h4> </center>`);


			});

		}


		function clean_fecha_movimiento() {

			$("#fecha_movimiento").val("");

		}

		function operaciones() {

			var monto_bd = $("#monto_operacion").val();
			var moneda_bd = "MXN"; //$("#moneda_operacion").val();
			var type_cambio = $("#t_cambio").val();

			if (t_cambio != "") {

				$("#letras_resultado").show();

				var operacion = parseFloat(monto_bd) * parseFloat(type_cambio);
				var resultado = parseFloat(operacion);

				$.post("buscar_letras_documentacion.php", {
					valorBusqueda: resultado,
					valortipo: moneda_bd
				}, function(mensaje_letras) {

					$("#resultado_operacion").html('<center>' + operacion + mensaje_letras + '</center>');

				});

			} else {

				$("#letras_resultado").hide();
				$("#resultado_operacion").empty();

			}
		}

		function OptionsModalLimpio(valor) {

			var porciones = valor.trim();
			var valor = porciones.split('|');

			$("#modalClean").modal(valor[0]);
			$("#titlemodallimpio").empty();
			$("#titlemodallimpio").html(valor[1]);
			$("#add_limpio_modal").empty();
		}

		function SolicitarTokenDesbloqueo(condicion) {

			if (condicion == "Solicitar") {

				$("#solicitar_token").show();
				$("#MostrarYatengoToken").hide();

			} else if (condicion == "Ya tengo") {

				$("#MostrarYatengoToken").show();
				$("#solicitar_token").hide();

			} else {

				$("#MostrarYatengoToken").show();
				$("#solicitar_token").hide();

				$(".error-form").show();
				$(".text-error").html("No existe esta opción");
				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);

				OptionsModalLimpio('hide|');

			}


		}

		function TokenSolicitud(referencia_movimiento) {

			var fecha_creacion = TiempoAhora();

			var idcolaboratorsolicitartoken = $("#idcolaboratorsolicitartoken").val();

			if (idcolaboratorsolicitartoken == "") {

				$("#idcolaboratorsolicitartoken").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("Selecciona una opción");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#idcolaboratorsolicitartoken").focus();
				return false;
			}

			if (referencia_movimiento == "" || referencia_movimiento.trim() == "undefined") {

				$(".error-form").show();
				$(".text-error").html("Error con la referencia");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);

				return false;
			}




			$.ajax({
				url: "guardar_cambio_vin_individual.php",
				type: "POST",
				data: {
					fecha_creacion: fecha_creacion,
					idcolaboratorsolicitartoken: idcolaboratorsolicitartoken,
					referencia_movimiento: referencia_movimiento,
					tipo_fomulario_option: "SolicitarToken"
				},
				beforeSend: function() {

					$(".container-loading-ajax").show();
				},
				success: function(msj_solicitud_token) {

					var porciones = msj_solicitud_token.split('|');

					if (porciones[0].trim() == "1") {

						$(".listo-form").show();
						$(".text-listo").html("Solicitud Enviada");

						setTimeout(function() {
							$(".listo-form").fadeOut(1000);
						}, 1500);

					} else {

						$(".error-form").show();
						$(".text-error").html(msj_solicitud_token);

						setTimeout(function() {
							$(".error-form").fadeOut(5000);
						}, 1500);

					}

					if (porciones[1] != "") {
						open(porciones[1], "New Window", "width=600, height=600, left=300, top=300");
					}

					$(".container-loading-ajax").hide();
				},
				error: function(xhr, status) {

					$(".error-form").show();
					$(".text-error").html("Disculpe, existió un problema");

					setTimeout(function() {
						$(".error-form").fadeOut(1000);
					}, 1500);
					$(".container-loading-ajax").hide();
				}

			});


		}


		//--------- Modulo de Asignacion de Token ---------

		function GenerateToken() {

			OptionsModalLimpio('toggle|Generar Token Desbloqueo de Movimiento');

			var FormGenerateToken = `

				<div class="col-sm-12">
					<label>Buscar Colaborador Asignación de Token</label>
                    <input placeholder="Buscar" class="form-control" type="text" name="buscar_responsable_asignacion_token" id="buscar_responsable_asignacion_token" value="" autocomplete="off" onKeyUp="BuscarResponsableAsignarToken();" size="19" width="300%" />
                    <center>
						<div id="resultadoBusquedaResponsableAsignacionToken" class="container-busquedas-1 mt-4 efecto-busqueda" style="display: none;"></div>
                    </center>
					
				</div>
				
				<div class="col-sm-12">
				<label>Asignación de Token a: </label>
				<input type="text" class="form-control" id="responsabletxt" readonly>
				<input type="hidden" id="idcolaborador_token" name="idcolaborador_token">
				<input type="hidden" id="tipocolaborador_token" name="tipocolaborador_token">
                </div>

				<div class="col-sm-12">
				<label>Referencia</label>
				<input placeholder="Buscar Referencia" class="form-control" name="folio" value="" id="folio" autocomplete="off" onKeyUp="SearchReferenciaLogistica();" >
				</div>

				<div class="col-sm-12">
				<div class="" role="alert" id="ResultadoExixteToken">
				
				</div>
				</div>

				<div class='col-sm-12'>
					<label>Token:</label>
					<input type='text' class="form-control cleangeneratetoken" name="codigo" id='codigo' readonly>
				</div>

				<div class='col-sm-12'>
					<label>ID:</label>
					<input type='text' class="form-control cleangeneratetoken" name="idcontacto" id='idcontacto' readonly>
				</div>

				<div class='col-sm-12'>
					<label>Monto:</label>
					<input type='text' class="form-control cleangeneratetoken" name='monto_mx' id='monto_mx' readonly>
				</div>

				<div id="ReferenciaTokenBusqueda" style="display: none;">
					<center>
						<button type="button" class="btn btn-primary" onclick="GenerateTokenMovimiento();">Generar Token</button>
					</center>
				</div>
			`;

			$("#add_limpio_modal").html(FormGenerateToken);



		}



		function BuscarResponsableAsignarToken() {

			var txtSearchResponsable = $("#buscar_responsable_asignacion_token").val();
			var tipoBusqueda = "ColaboraboradorSI";
			var name_sugerencia = "ListRespToken";

			if (txtSearchResponsable != "") {

				$.post("buscar_id_colaborador_completo.php", {
					valorBusqueda: txtSearchResponsable,
					tipoBusqueda: tipoBusqueda,
					name_sugerencia: name_sugerencia
				}, function(mensaje_responsable) {

					$("#resultadoBusquedaResponsableAsignacionToken").html(mensaje_responsable);
					$("#resultadoBusquedaResponsableAsignacionToken").show();

				});

			} else {
				$("#resultadoBusquedaResponsableAsignacionToken").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
			};

			$(document).on('click', '.' + name_sugerencia, function(event) {
				event.preventDefault();
				aux_recibido = $(this).val();
				var porcion = aux_recibido.split(';');

				$("#buscar_responsable_asignacion_token").val("");
				$("#responsabletxt").val(porcion[2] + " - " + porcion[3] + " " + porcion[4] + " - " + porcion[5]);
				$("#idcolaborador_token").val(porcion[0]);
				$("#tipocolaborador_token").val(porcion[1]);
				$("#resultadoBusquedaResponsableAsignacionToken").html("");
				$("#resultadoBusquedaResponsableAsignacionToken").hide();
			});

		}

		function SearchReferenciaLogistica() {

			var txtSearchReferencia = $("#folio").val();


			if (txtSearchReferencia != "") {

				$.post("guardar_cambio_vin_individual.php", {
					referencia_movimiento: txtSearchReferencia,
					tipo_fomulario_option: "BusquedaReferenciaToken",


				}, function(mensaje_responsable) {

					var porciones = mensaje_responsable.trim();
					var mensaje_responsable = porciones.split('|');

					if (mensaje_responsable[0].trim() == "1") {

						$("#ResultadoExixteToken").removeClass("alert alert-danger");
						$("#ResultadoExixteToken").removeClass("alert alert-success");
						$("#ResultadoExixteToken").addClass("alert alert-success");
						$("#ResultadoExixteToken").html('<p><b>Adelante.</b></p>');

						$("#cleangeneratetoken").val("");

						$("#codigo").val(mensaje_responsable[1])
						$("#idcontacto").val(mensaje_responsable[2])
						$("#monto_mx").val(mensaje_responsable[3])

						$("#ReferenciaTokenBusqueda").show();

					} else {

						$("#cleangeneratetoken").val("");

						$("#ResultadoExixteToken").removeClass("alert alert-danger");
						$("#ResultadoExixteToken").removeClass("alert alert-success");
						$("#ResultadoExixteToken").addClass("alert alert-danger");
						$("#ResultadoExixteToken").html(`<p><b>${mensaje_responsable[1]}.</b></p>`);

						$("#ReferenciaTokenBusqueda").hide();

					}


				});

			} else {
				$("#cleangeneratetoken").val("");
				$("#ResultadoExixteToken").removeClass("alert alert-danger");
				$("#ResultadoExixteToken").removeClass("alert alert-success");
				$("#ResultadoExixteToken").addClass("alert alert-danger");
				$("#ResultadoExixteToken").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
				$("#ReferenciaTokenBusqueda").hide();

			}

		}

		function GenerateTokenMovimiento() {

			var folio = $("#folio").val();
			var idcolaborador_token = $("#idcolaborador_token").val();
			var codigo = $("#codigo").val();
			var idcontacto = $("#idcontacto").val();
			var monto_mx = $("#monto_mx").val();
			var fecha_creacion = TiempoAhora();

			if (folio == "") {

				$("#folio").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("Debes de Agregar una Referencia");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#folio").focus();
				return false;
			}

			if (idcolaborador_token == "") {

				$("#responsabletxt").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("Debes de Asignar el Colaborador");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#buscar_responsable_asignacion_token").focus();
				return false;
			}

			if (codigo == "") {

				$("#codigo").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("No debe de ir vacio");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#codigo").focus();
				return false;
			}

			if (idcontacto == "") {

				$("#idcontacto").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("No debe de ir vacio");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#idcontacto").focus();
				return false;
			}

			if (monto_mx == "") {

				$("#monto_mx").css("border-color", "red");
				$(".error-form").show();
				$(".text-error").html("No debe de ir vacio");

				setTimeout(function() {
					$(".error-form").fadeOut(1000);
				}, 1500);
				$("#monto_mx").focus();
				return false;
			}


			$.ajax({

				url: "guardar_cambio_vin_individual.php",
				method: "POST",
				data: {
					tipo_fomulario_option: "GenerarTokenDesbloqueo",
					folio: folio,
					idcolaborador_token: idcolaborador_token,
					codigo: codigo,
					idcontacto: idcontacto,
					monto_mx: monto_mx,
					fecha_creacion: fecha_creacion

				},
				beforeSend: function() {

					$(".container-loading-ajax").show();

				},
				success: function(MensajeGenerateToken) {

					var porciones = MensajeGenerateToken.trim();
					var MensajeGenerateToken = porciones.split('|');

					if (MensajeGenerateToken[0].trim() == "1") {

						$(".listo-form").show();
						$(".text-listo").html("Token Generado Correctamente");

						setTimeout(function() {
							$(".listo-form").fadeOut(1000);
						}, 1500);

					} else {

						$(".error-form").show();
						$(".text-error").html(MensajeGenerateToken[0]);

						setTimeout(function() {
							$(".error-form").fadeOut(3000);
						}, 1500);

					}

					if (MensajeGenerateToken[1] != "") {
						open(MensajeGenerateToken[1], "New Ventana", "width=600, height=600, left=300, top=300");
					}

					OptionsModalLimpio('hide|');

					$(".container-loading-ajax").hide();

				},
				error: function() {

					$(".error-form").show();
					$(".text-error").html("Disculpe, existió un problema");

					setTimeout(function() {
						$(".error-form").fadeOut(2000);
					}, 1500);

					$(".container-loading-ajax").hide();

				}

			});



		}

		function CopyAndPaste(valor) {

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

		//
	</script>






</body>

</html>