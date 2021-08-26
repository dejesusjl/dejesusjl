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

// Start Querys

#1 ----------Consulta | Costo Minimo
$query_min_costo = "SELECT min(gran_total) FROM balance_gastos_operacion WHERE visible = 'SI'";
$result_min_costo = mysql_query($query_min_costo);
while ($row_min_costo = mysql_fetch_array($result_min_costo)) {
	$min_costo = intval($row_min_costo[0]);
}

#2 ----------Consulta | Costo Maximo
$query_max_costo = "SELECT max(gran_total) FROM balance_gastos_operacion WHERE visible = 'SI'";
$result_max_costo = mysql_query($query_max_costo);
while ($row_max_costo = mysql_fetch_array($result_max_costo)) {
	$max_costo = floatval($row_max_costo[0]);
}


// BalanceGastosAuxiliar("FKD23319", "2021-01-25", "2021-08-25");

// function BalanceGastosAuxiliar($auxiliar, $fecha_a, $fecha_b)
// {

// 	$auxiliar = trim($auxiliar);

// 	$resultado_monto_total = 0;

// 	$array_final = array();


// 	$query = "SELECT referencia,gran_total FROM balance_gastos_operacion WHERE idbalance_gastos_operacion IN (SELECT idlogistica FROM balance_gastos_auxiliares WHERE visible = 'SI' AND trim(nombre) = '$auxiliar' AND fecha_movimiento between '$fecha_a' AND '$fecha_b') AND visible = 'SI' AND tipo_movimiento = 'cargo'";
// 	$result = mysql_query($query);



// 	if (mysql_num_rows($result) >= 1) {

// 		while ($row = mysql_fetch_array($result)) {

// 			array_push($array_final, "$row[referencia]|$row[gran_total]");
// 		}
// 	}


// 	var_dump($array_final);

// 	for ($i = 0; $i < count($array_final); $i++) {

// 		$variable = explode('|', $array_final[$i]); // separa las variables que vienen amarrados como cadena:

// 		$variable[0]; //valores de variable1
// 		$variable[1]; //valores de variable2

// 		if (!isset($sumas[$variable[0]])) {
// 			$sumas[$variable[0]] = $variable[1];
// 		} else {
// 			$sumas[$variable[0]] += $variable[1];
// 		}
// 	}
// 	foreach ($sumas as $key => $value) {
// 		echo $key . ': ' . number_format($value, 2) . '<br/>';
// 	}
// 	#
// }






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
	<title>CCP | Reportes Balance Gastos</title>
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
								<a class="text-white" href="agregar_orden_logistica.php">Resumen Ordenes Logística</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li class="active text-white">
								<strong>Resumen Balance Gastos</strong>
							</li>
						</ol>

						<br>

						<?php
						date_default_timezone_set('America/Mexico_City');
						$fecha_creacion = date("Y-m-d H:i:s");
						?>
						<div class="row">
							<form id="form_balance" method="POST" action="show_table_balance_gastos.php">

								<div class="col-sm-12">
									<div class="form-group row">


										<div class="col-sm-12">
											<div class="d-flex justify-content-center">
												<div class="container-checks-1 d-flex align-items-center">
													<div>
														<label class="mb-0 mr-2">Limpiar Todo</label>
													</div>
													<div class="d-flex align-items-center">
														<div id="clean_all" class="container-iconos-1">
															<i class="fas fa-trash"></i>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="col-sm-12 mt-4">
											<div class="col-sm-12 container-bg-1 p-3">
												<div class="d-flex align-items-center flex-wrap mb-2">
													<label class="mb-0 mr-2" for="idlogistica">Número de Logística</label>
													<div id="clean_idlogistica" class="container-iconos-1">
														<i class="fa fa-trash-o" aria-hidden="true" id="clean_idlogistica"></i>
													</div>
												</div>
												<input type="number" class="form-control" id="idlogistica" name="idlogistica" onkeypress="return valideKey(event);">
											</div>
										</div>

										<div class="col-sm-12 mt-4">

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

										<div class="col-sm-12 mt-4">

											<div class="container-bg-1 p-3">

												<div class="row">

													<div class="col-sm-12">
														<label>*Concepto: </label>
														<div class="content-select">
															<select name="concepto" id="concepto" class="form-control">
																<option value="">Selecciona una opción ...</option>
																<?php
																$query_concepto = "SELECT concepto FROM balance_gastos_operacion WHERE visible = 'SI' GROUP BY concepto";
																$result_concepto = mysql_query($query_concepto);

																while ($row_concepto = mysql_fetch_array($result_concepto)) {
																	echo "<option value='$row_concepto[0]'>$row_concepto[0]</option>";
																}
																?>
															</select>
															<i></i>
														</div>
													</div>
													<div class="col-sm-12">
														<label>*Proveedor: </label>
														<div class="content-select">
															<select name="proveedor" id="proveedor" class="form-control">
																<option value="">Selecciona una opción ...</option>
																<?php
																$query_proveedor = "SELECT emisora_institucion FROM balance_gastos_operacion WHERE visible = 'SI' and tipo_movimiento = 'cargo' GROUP BY emisora_institucion";
																$result_proveedor = mysql_query($query_proveedor);

																while ($row_proveedor = mysql_fetch_array($result_proveedor)) {
																	echo "<option value='$row_proveedor[0]'>$row_proveedor[0]</option>";
																}
																?>
															</select>
															<i></i>
														</div>
													</div>
													<div class="col-sm-12">
														<label>*Departamento: </label>
														<div class="content-select">
															<select name="departamento" id="departamento" class="form-control">
																<option value="">Selecciona una opción ...</option>
																<?php
																$query_iddep = "SELECT idcatalogo_departamento FROM balance_gastos_operacion WHERE visible = 'SI' GROUP BY idcatalogo_departamento";
																$result_iddep = mysql_query($query_iddep);

																while ($row_iddep = mysql_fetch_array($result_iddep)) {

																	$query_departamento = "SELECT * FROM catalogo_departamento WHERE idcatalogo_departamento = '$row_iddep[0]'";
																	$result_departamento = mysql_query($query_departamento);

																	while ($row_name_departamento = mysql_fetch_array($result_departamento)) {
																		echo "<option value='$row_name_departamento[idcatalogo_departamento]'>$row_name_departamento[nombre]</option>";
																	}
																}
																?>
															</select>
															<i></i>
														</div>
													</div>
													<div class="col-sm-12">
														<label>*Método de Pago: </label>
														<div class="content-select">
															<select name="metodopago" id="metodopago" class="form-control">
																<option value="">Selecciona una opción ...</option>
																<option value="Efectivo">Efectivo</option>
																<option value="Panamotors">Panamotors</option>
															</select>
															<i></i>
														</div>
													</div>

												</div>

											</div>

										</div>


										<div class="col-sm-12 mt-4">

											<div class="container-bg-1 p-3">
												<div class="row">
													<div class="col-sm-6">
														<div class="d-flex align-items-center flex-wrap mb-2">
															<label class="mb-0 mr-2" for="busqueda_colaborador">*Buscar Colaborador</label>
															<div id="clean_responsable" class="container-iconos-1">
																<i class="fa fa-trash-o" aria-hidden="true"></i>
															</div>
														</div>
														<input placeholder="Buscar" class="form-control" type="text" name="busqueda_colaborador" id="busqueda_colaborador" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_Colaborador();" size="19" width="300%" />
														<center>
															<div id="resultadoBusquedaColaborador" class="mt-4 efecto-busqueda" style="display: none;"></div>
														</center>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>*Colaborador </label>
															<input type="hidden" id="id_colaborador" name="id_colaborador">
															<input class="form-control" type="text" name="name_colaborador" id="name_colaborador" readonly="" />
														</div>
													</div>
												</div>
											</div>

										</div>

										<div class="col-sm-12 mt-4">

											<div class="container-bg-1 p-3">
												<div class="row">
													<div class="col-sm-12">
														<div class="d-flex align-items-center flex-wrap mb-2">
															<label class="mb-0 mr-2" for="busqueda_herramienta">Buscar VIN</label>
															<div id="clean_vin" class="container-iconos-1">
																<i class="fa fa-trash-o" aria-hidden="true" id="clean_vin"></i>
															</div>
														</div>
														<input placeholder="Buscar VIN" class="form-control" type="text" name="busqueda_herramienta" id="busqueda_herramienta" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_herramienta();" size="19" width="300%" />
														<center>
															<div id="resultadoBusquedaherramienta" class="container-busquedas-1 mt-4 efecto-busqueda" style="display: none;"></div>
														</center>
													</div>
													<div class="col-sm-4">
														<label>VIN </label>
														<input class="form-control" type="text" id="vin_herramienta" name="vin_herramienta" readonly="" minlength="8" maxlength="8" onKeyUp="mayus(this);" />
													</div>
													<div class="col-sm-4">
														<label>Marca</label>
														<input class="form-control" type="text" id="marca_herramienta" name="marca_herramienta" readonly="" onKeyUp="mayus(this);" />
													</div>
													<div class="col-sm-4">
														<label>Versión</label>
														<input class="form-control" type="text" id="version_herramienta" name="version_herramienta" readonly="" onKeyUp="mayus(this);" />
													</div>
													<div class="col-sm-4">
														<label>Color</label>
														<input class="form-control" type="text" id="color_herramienta" name="color_herramienta" readonly="" onKeyUp="mayus(this);" />
													</div>
													<div class="col-sm-4">
														<label>Modelo</label>
														<input class="form-control" type="text" id="modelo_herramienta" name="modelo_herramienta" readonly="" />
													</div>
												</div>
											</div>

										</div>

										<div class="col-sm-12 mt-4">

											<div class="container-bg-1 p-3">
												<div class="row">
													<div class="col-sm-12">
														<div class="d-flex align-items-center flex-wrap mb-2">
															<label class="mb-0 mr-2" for="busqueda_car">Buscar Tarjeta | Tag</label>
															<div id="clean_card" class="container-iconos-1">
																<i class="fa fa-trash-o" aria-hidden="true" id="clean_card"></i>
															</div>
														</div>
														<input placeholder="Buscar Tarjeta | Tag..." class="form-control" type="text" name="busqueda_card" id="busqueda_card" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_card();" size="19" width="300%" />
														<center>
															<div id="resultadoBusquedatarjeta" class="container-busquedas-1 mt-4 efecto-busqueda" style="display: none;"></div>
														</center>
													</div>
													<div class="col-sm-4">
														<label>Número Tarjeta | Tag</label>
														<input class="form-control" type="text" id="tarjeta" name="tarjeta" readonly="" />
													</div>
													<div class="col-sm-4">
														<label>Tipo</label>
														<input class="form-control" type="text" id="tipo_tarjeta" name="tipo_tarjeta" readonly="" />
													</div>
													<div class="col-sm-4">
														<label>Responsable</label>
														<input class="form-control" type="text" id="responsable_tarjeta" name="responsable_tarjeta" readonly="" />
													</div>
												</div>
											</div>

										</div>


										<div class="col-sm-12 mt-4">
											<div class="container-bg-1 p-3">
												<label>*Rango Monto Total</label>
												<div class="slider-wrapper slider-ghost">
													<input class="input-range" data-slider-id='ex12cSlider' type="text" data-slider-step="1" data-slider-value="0, 0" data-slider-min="0" data-slider-max="<?php echo $max_costo; ?>" data-slider-range="true" data-slider-tooltip_split="true" name="range_gastos" id="rangos" />
												</div>
											</div>
										</div>


										<div class="col-sm-12">
											<center>
												<button class="btn-lg btn-primary" id="show_date" type="button">Buscar</button>
												<!-- <button class="btn-lg btn-primary" id="show_date" type="submit">Guardar</button> -->
											</center>
										</div>

									</div>
								</div>
							</form>


							<div class="col-sm-12">
								<div id="show_table">

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

		$(document).ready(function() {

			$("#show_date").click(function() {

				var datos_balance = $("#form_balance").serialize();
				console.log(datos_balance);

				$.ajax({
					url: '../Logistica/show_table_balance_gastos.php',
					data: datos_balance,
					type: 'POST',
					beforeSend: function() {
						$(".container-loading-ajax").show();
					},
					success: function(json) {
						$(".container-loading-ajax").hide();
						$("#show_table").html(json);
					},

					error: function(xhr, status) {
						// alert('Disculpe, existió un problema');
						$(".error-form").show();
						$(".text-error").html("Disculpe, existió un problema");

						setTimeout(function() {
							$(".error-form").fadeOut(1000);
						}, 1500);
					}
				});
			});



			$("#clean_all").click(function() {

				$("#idlogistica").val("");

				$("#fecha_inicio").val("");
				$("#fecha_fin").val("");

				$("#concepto").val("");
				$("#proveedor").val("");
				$("#departamento").val("");
				$("#metodopago").val("");

				$("#busqueda_colaborador").val("");
				$("#name_colaborador").val("");

				$("#busqueda_herramienta").val("");
				$("#vin_herramienta").val("");
				$("#marca_herramienta").val("");
				$("#version_herramienta").val("");
				$("#color_herramienta").val("");
				$("#modelo_herramienta").val("");

				$("#busqueda_card").val("");
				$("#tarjeta").val("");
				$("#tipo_tarjeta").val("");
				$("#responsable_tarjeta").val("");


			});

		});


		function buscar_Colaborador() {
			var textoBusquedaColaborador = $("#busqueda_colaborador").val();
			console.log(textoBusquedaColaborador);
			if (textoBusquedaColaborador != "") {
				$.post("buscar_id_colaborador_provedor_temporal_general.php", {
					valorBusqueda: textoBusquedaColaborador
				}, function(mensaje_trasladista) {
					$("#resultadoBusquedaColaborador").html(mensaje_trasladista);

					if (mensaje_trasladista == " <b>Trasladista NO Encontrado</b>") {
						$("#name_colaborador").attr("readonly", "readonly");
						$("#resultadoBusquedaColaborador").show();
					} else {
						$("#name_colaborador").attr("readonly", "readonly");
						$("#resultadoBusquedaColaborador").show();
					}
				});
			} else {
				$("#resultadoBusquedaColaborador").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
			};
		};

		$(document).on('click', '.sugerencias_colaborador', function(event) {
			event.preventDefault();
			aux_recibido = $(this).val();
			var porcion = aux_recibido.split(';');
			unidad_id_trasladista = porcion[0];
			unidad_nomenclatura_trasladista = porcion[1];
			tipo_trasladista = porcion[2];
			$("#resultadoBusquedaColaborador").hide();
			$("#busqueda_colaborador").val("");
			$("#id_colaborador").val(unidad_id_trasladista);
			$("#name_colaborador").val(unidad_nomenclatura_trasladista);
			$("#resultadoBusquedaColaborador").html("");
			$("#resultadoBusquedaColaborador").hide();
		});

		// buscador de VIN

		function buscar_herramienta() {
			var textoBusquedaherramienta = $("#busqueda_herramienta").val();
			if (textoBusquedaherramienta != "") {
				$.post("buscar_vin_herramienta.php", {
					valorHerramienta: textoBusquedaherramienta
				}, function(mensaje_herramienta) {
					$("#resultadoBusquedaherramienta").html(mensaje_herramienta);
					if (mensaje_herramienta == " <b>VIN NO Encontrado</b>") {
						$("#vin_herramienta").removeAttr("readonly", "readonly");
						$("#resultadoBusquedaherramienta").show();

					} else {
						$("#resultadoBusquedaherramienta").show();
						$("#vin_herramienta").attr("readonly", "readonly");
						$("#marca_herramienta").attr("readonly", "readonly");
						$("#version_herramienta").attr("readonly", "readonly");
						$("#color_herramienta").attr("readonly", "readonly");
						$("#modelo_herramienta").attr("readonly", "readonly");
					}
				});
			} else {
				$("#resultadoBusquedaherramienta").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
			};
		};
		$(document).on('click', '.sugerencias_herramienta', function(event) {
			event.preventDefault();
			aux_recibido = $(this).val();
			var porcion = aux_recibido.split(';');
			unidad_herramientavin = porcion[0];
			unidad_htvin = porcion[1];
			unidad_htmarca = porcion[2];
			unidad_htversion = porcion[3];
			unidad_htcolor = porcion[4];
			unidad_htmodelo = porcion[5];
			unidad_httipo = porcion[6];

			if (unidad_httipo == "Indefinido") {

				$("#vin_herramienta").removeAttr("readonly", "readonly");
			}

			$("#busqueda_herramienta").val("");
			$("#tipo_herramienta").val(unidad_httipo);
			$("#vin_herramienta").val(unidad_htvin);
			$("#marca_herramienta").val(unidad_htmarca);
			$("#version_herramienta").val(unidad_htversion);
			$("#color_herramienta").val(unidad_htcolor);
			$("#modelo_herramienta").val(unidad_htmodelo);
			$("#resultadoBusquedaherramienta").hide();


		});

		// busqueda tarjeta

		function buscar_card() {
			var textoBusquedaCard = $("#busqueda_card").val();
			if (textoBusquedaCard != "") {
				$.post("busqueda_monedero_electronico.php", {
					valorBusqueda: textoBusquedaCard
				}, function(mensaje_card) {
					$("#resultadoBusquedatarjeta").html(mensaje_card);
					if (mensaje_card == "<b>Tarjeta Tag NO Encontrada</b>") {
						$("#tarjeta").removeAttr("readonly", "readonly");
						$("#resultadoBusquedatarjeta").show();
					} else {
						$("#resultadoBusquedatarjeta").show();
						$("#tarjeta").attr("readonly", "readonly");

					}
				});
			} else {
				$("#resultadoBusquedatarjeta").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
			};
		};

		$(document).on('click', '.sugerencias_tarjeta', function(event) {
			event.preventDefault();
			aux_recibido = $(this).val();
			var porcion = aux_recibido.split(';');
			unidad_tarjeta = porcion[0];
			unidad_tipo = porcion[1];
			unidad_responsable = porcion[2];

			$("#busqueda_card").val("");
			$("#tarjeta").val(unidad_tarjeta);
			$("#tipo_tarjeta").val(unidad_tipo);
			$("#responsable_tarjeta").val(unidad_responsable);
			$("#resultadoBusquedatarjeta").hide();
		});


		//Clean inputs

		// $("#clean_dates").click(function(){
		// 	$("#fecha_inicio").val("");
		// 	$("#fecha_fin").val("");
		// });

		const clean_dates = document.getElementById("clean_dates");
		const fecha_inicio = document.getElementById("fecha_inicio");
		const fecha_fin = document.getElementById("fecha_fin");

		clean_dates.onclick = function() {
			fecha_inicio.value = "";
			fecha_fin.value = "";
		}

		// $("#clean_responsable").click(function(){
		// 	$("#busqueda_colaborador").val("");
		// 	$("#id_colaborador").val("");
		// 	$("#name_colaborador").val("");
		// });

		const clean_responsable = document.getElementById("clean_responsable");
		const busqueda_colaborador = document.getElementById("busqueda_colaborador");
		const id_colaborador = document.getElementById("id_colaborador");
		const name_colaborador = document.getElementById("name_colaborador");

		clean_responsable.onclick = function() {
			busqueda_colaborador.value = "";
			id_colaborador.value = "";
			name_colaborador.value = "";
		}


		// $("#clean_vin").click(function(){
		// 	$("#fecha_inicio").val("");
		// 	document.getElementById("vin_herramienta").value = "";
		// 	document.getElementById("marca_herramienta").value = "";
		// 	document.getElementById("version_herramienta").value = "";
		// 	document.getElementById("color_herramienta").value = "";
		// 	document.getElementById("modelo_herramienta").value = "";	
		// });

		const clean_vin = document.getElementById("clean_vin");
		const vin_herramienta = document.getElementById("vin_herramienta");
		const marca_herramienta = document.getElementById("marca_herramienta");
		const version_herramienta = document.getElementById("version_herramienta");
		const color_herramienta = document.getElementById("color_herramienta");
		const modelo_herramienta = document.getElementById("modelo_herramienta");

		clean_vin.onclick = function() {
			vin_herramienta.value = "";
			marca_herramienta.value = "";
			version_herramienta.value = "";
			color_herramienta.value = "";
			modelo_herramienta.value = "";
		}


		// $("#clean_idlogistica").click(function(){
		// 	// $("#idlogistica").val("");
		// 	document.getElementById("idlogistica").value = "";
		// });

		const clean_idlogistica = document.getElementById("clean_idlogistica");
		const idlogistica = document.getElementById("idlogistica");

		clean_idlogistica.onclick = function() {
			idlogistica.value = "";
		}

		// $("#clean_card").click(function(){
		// 	$("#busqueda_card").val("");
		// 	$("#tarjeta").val("");
		// 	$("#tipo_tarjeta").val("");
		// 	$("#responsable_tarjeta").val("");
		// });

		const clean_card = document.getElementById("clean_card");
		const busqueda_card = document.getElementById("busqueda_card");
		const tarjeta = document.getElementById("tarjeta");
		const tipo_tarjeta = document.getElementById("tipo_tarjeta");
		const responsable_tarjeta = document.getElementById("responsable_tarjeta");

		clean_card.onclick = function() {
			busqueda_card.value = "";
			tarjeta.value = "";
			tipo_tarjeta.value = "";
			responsable_tarjeta.value = "";
		}



		function mayus(e) {
			e.value = e.value.toUpperCase();
		}

		function valideKey(evt) {

			// code is the decimal ASCII representation of the pressed key.
			var code = (evt.which) ? evt.which : evt.keyCode;

			if (code == 8) { // backspace.
				return true;
			} else if (code >= 48 && code <= 57) { // is a number.
				return true;
			} else { // other keys.
				return false;
			}
		}
	</script>






</body>

</html>