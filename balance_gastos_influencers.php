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

#1 ----------Consulta | Costo Minimo
$query_min_costo = "SELECT min(gran_total) FROM balance_gastos_operacion WHERE visible = 'SI'";
$result_min_costo = mysql_query($query_min_costo);
while ( $row_min_costo = mysql_fetch_array($result_min_costo)) {
	$min_costo = intval($row_min_costo[0]);
}

#2 ----------Consulta | Costo Maximo
$query_max_costo = "SELECT max(gran_total) FROM balance_gastos_operacion WHERE visible = 'SI'";
$result_max_costo = mysql_query($query_max_costo);
while ( $row_max_costo = mysql_fetch_array($result_max_costo)) {
	$max_costo = floatval ($row_max_costo[0]);
}



$fecha_inicio_mes = date("Y-m-")."01";

$fecha_actual_mes = date("Y-m-d"); 








function name_responsable($id_responsable){

	$query_empleado = (is_numeric($id_responsable)) ? "SELECT * FROM empleados where idempleados = '$id_responsable'" : "SELECT * FROM empleados where columna_b = '$id_responsable'" ;
	$result_empleado = mysql_query($query_empleado);

	if (mysql_num_rows($result_empleado) >=1) {

		while ($row_empleado = mysql_fetch_array($result_empleado)) {
			$name = $row_empleado[columna_b];
			$id_name = $row_empleado[idempleados];
		}
	}else{
		$name;
	}



	$tipo_return = (is_numeric($id_responsable)) ? $name : $id_name ; 

	return $tipo_return;
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
	<title>CCP | Reportes Balance Influencers</title>
	<style>
		#show_date{
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
								<a class="text-white" href="orden_logistica_influencers.php">Resumen Ordenes Logística</a>
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
						
						<form id="form_balance" method="POST" action="show_table_balance_gastos.php">

							<div class="row">

								<div class="col-sm-12">
									<div class="container-bg-1 p-3">
										<div class="row">
											<div class="col-sm-12">
												<div class="d-flex justify-content-center">
													<div id="clean_dates" class="container-iconos-1">
														<i class="fas fa-trash"></i>
													</div>
												</div>										
											</div>
											<div class="col-sm-6">
												<label for="fecha_inicio">*Fecha de Inicio:</label>
												<input class="form-control" type="text" id="fecha_inicio" name="fecha_inicio" readonly=""  />
											</div>
											<div class="col-sm-6">
												<label for="fecha_fin">*Fecha de Fin:</label>
												<input class="form-control" type="text" id="fecha_fin" name="fecha_fin" readonly=""  />
											</div>
										</div>					
									</div>
								</div>																											

								<div class="col-sm-12">
									<br>
									<center>
										<button class="btn-lg btn-primary" id="show_date" type="button">Buscar</button>
									</center>
								</div>

							</div>
						</form>

						<div class="filtrados-tabla" style="display: none;">
							<div class='d-flex justify-content-center'>
								<div>

									<div class="container-checks-1 mt-4">
										<div class="d-flex justify-content-center align-items-center text-secundario-1">
											<i class='fas fa-filter'></i>
											<b>Concepto:</b>										
										</div>
										<div class="d-flex justify-content-center align-items-center flex-wrap">
											<?php 
											$query_concepto_sinotruck = "SELECT concepto FROM balance_gastos_operacion WHERE idcatalogo_departamento = '18' and visible = 'SI' and fecha_movimiento between '2021-01-01' and '2021-01-31' GROUP BY concepto "; 
											$result_concepto_sinotruck = mysql_query($query_concepto_sinotruck);

											while ($row_concepto_sinotruck = mysql_fetch_array($result_concepto_sinotruck)) {
												echo "
												<div class='m-2'>
													<input onchange='filterme()' type='checkbox' class='filtros' name='concepto_sinotruck' value='$row_concepto_sinotruck[concepto]'>
													<span>$row_concepto_sinotruck[concepto]&nbsp;</span>
												</div>											
												";
											}
											?>
										</div>								
									</div>

									<div class="container-checks-1 mt-4">
										<div class="d-flex justify-content-center align-items-center text-secundario-1">
											<i class="fas fa-filter"></i>
											<b>Responsable:</b>
										</div>
										<div class="d-flex justify-content-center align-items-center flex-wrap">
											<?php 
											$query_responsable_sinotruck = "SELECT responsable FROM balance_gastos_operacion WHERE idcatalogo_departamento = '18' and visible = 'SI' and fecha_movimiento between '2021-01-01' and '2021-01-31' GROUP BY responsable "; 
											$result_responsable_sinotruck = mysql_query($query_responsable_sinotruck);

											while ($row_responsable_sinotruck = mysql_fetch_array($result_responsable_sinotruck)) {

												$name_responsable_sinotruck = name_responsable($row_responsable_sinotruck[responsable]);

												echo "
												<div class='m-2'>
													<input onchange='filterme()' type='checkbox' class='filtros' name='responsable_sinotruck' value='$name_responsable_sinotruck'>
													<span>$name_responsable_sinotruck&nbsp;</span>
												</div>											
												";
											}
											?>
										</div>						
									</div>

									<div class="container-checks-1 mt-4">
										<div class="d-flex justify-content-center align-items-center text-secundario-1">
											<i class="fas fa-filter"></i>
											<b>Tipo de movimiento:</b>
										</div>
										<div class="d-flex justify-content-center align-items-center flex-wrap">
											<?php 
											$query_tmovimiento_sinotruck = "SELECT tipo_movimiento FROM balance_gastos_operacion WHERE idcatalogo_departamento = '18' and visible = 'SI' and fecha_movimiento between '2021-01-01' and '2021-01-31' GROUP BY tipo_movimiento "; 
											$result_tmovimiento_sinotruck = mysql_query($query_tmovimiento_sinotruck);

											while ($row_tmovimiento_sinotruck = mysql_fetch_array($result_tmovimiento_sinotruck)) {
												echo "
												<div class='m-2'>							
													<input onchange='filterme()' type='checkbox' class='filtros' name='tmovimientp_sinotruck' value='$row_tmovimiento_sinotruck[tipo_movimiento]'>
													<span>$row_tmovimiento_sinotruck[tipo_movimiento]&nbsp;</span>
												</div>
												";
											}
											?>
										</div>
									</div>

								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12 p-0">
								<div class="table-responsive p-4" id="show_table">

								</div>
							</div>						

						</div>


						<div class="row" id="fechas_footer" style="display: none;">
							
							<div class="col-sm-12">
								<div class="container-bg-1 p-3">
									<div class="row">
										<div class="col-sm-6">
											<label for="fecha_a">*Fecha de Inicio:</label>
											<input class="form-control" type="text" id="fecha_a" name="fecha_a" readonly=""  />
										</div>
										<div class="col-sm-6">
											<label for="fecha_b">*Fecha de Fin:</label>
											<input class="form-control" type="text" id="fecha_b" name="fecha_b" readonly=""  />
										</div>									
									</div>
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

<script  type="text/javascript" class="init">
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
        max: true
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
        max: true
        // disable: [
        // 1,2,3, 4,5,6
        // ]
    });

	$(document).ready(function() {

		$("#show_date").click(function(){

			var datos_balance = $("#form_balance").serialize();
			console.log(datos_balance);

			var date_a = $("#fecha_inicio").val();
			var date_b = $("#fecha_fin").val();

			$.ajax({
				url : 'show_table_balance_gastos_influencers.php',
				data : datos_balance,
				type : 'POST',
				beforeSend: function(){
					$(".container-loading-ajax").show();
				},
				success : function(json) {
					$("#show_table").html(json);
					$(".container-loading-ajax").hide();
					$("#fechas_footer").show();
					$("#fecha_a").val(date_a);
					$("#fecha_b").val(date_b);

					$(".filtrados-tabla").show();
				},

				error : function(xhr, status) {
					// alert('Disculpe, existió un problema');
					$(".error-form").show();
					$(".text-error").html("Disculpe, existió un problema");

					setTimeout(function(){
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

			$("#id_colaborador").val("");
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
			$.post("buscar_id_colaborador_provedor_temporal_general.php", {valorBusqueda: textoBusquedaColaborador}, function(mensaje_trasladista) {
				$("#resultadoBusquedaColaborador").html(mensaje_trasladista);

				if (mensaje_trasladista==" <b>Trasladista NO Encontrado</b>") {
					$("#name_colaborador").attr("readonly","readonly");
					$("#resultadoBusquedaColaborador").show();
				}else{    
					$("#name_colaborador").attr("readonly","readonly");   
					$("#resultadoBusquedaColaborador").show();      
				}
			});
		} else { 
			$("#resultadoBusquedaColaborador").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
		};
	};

	$(document).on('click', '.sugerencias_colaborador', function (event) {
		event.preventDefault();            
		aux_recibido=$(this).val();
		var porcion = aux_recibido.split(';');
		unidad_id_trasladista=porcion[0];
		unidad_nomenclatura_trasladista=porcion[1];
		tipo_trasladista=porcion[2];
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
		$.post("buscar_vin_herramienta.php", {valorHerramienta: textoBusquedaherramienta}, function(mensaje_herramienta) {
			$("#resultadoBusquedaherramienta").html(mensaje_herramienta);
			if (mensaje_herramienta==" <b>VIN NO Encontrado</b>") {
				$("#vin_herramienta").removeAttr("readonly","readonly");
				$("#resultadoBusquedaherramienta").show();

			}else{    
				$("#resultadoBusquedaherramienta").show();
				$("#vin_herramienta").attr("readonly","readonly");      
				$("#marca_herramienta").attr("readonly","readonly");      
				$("#version_herramienta").attr("readonly","readonly");      
				$("#color_herramienta").attr("readonly","readonly");      
				$("#modelo_herramienta").attr("readonly","readonly");      
			}
		});
	} else { 
		$("#resultadoBusquedaherramienta").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
	};
};
$(document).on('click', '.sugerencias_herramienta', function (event) {
	event.preventDefault();            
	aux_recibido=$(this).val();
	var porcion = aux_recibido.split(';');
	unidad_herramientavin=porcion[0];
	unidad_htvin=porcion[1];
	unidad_htmarca=porcion[2];
	unidad_htversion=porcion[3];
	unidad_htcolor=porcion[4];
	unidad_htmodelo=porcion[5];
	unidad_httipo=porcion[6];

	if (unidad_httipo == "Indefinido") {
		
		$("#vin_herramienta").removeAttr("readonly","readonly");
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
		$.post("busqueda_monedero_electronico.php", {valorBusqueda: textoBusquedaCard}, function(mensaje_card) {
			$("#resultadoBusquedatarjeta").html(mensaje_card);
			if (mensaje_card == "<b>Tarjeta Tag NO Encontrada</b>") {
				$("#tarjeta").removeAttr("readonly","readonly");
				$("#resultadoBusquedatarjeta").show();
			}else{    
				$("#resultadoBusquedatarjeta").show();
				$("#tarjeta").attr("readonly","readonly");   

			}
		});
	} else { 
		$("#resultadoBusquedatarjeta").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
	};
};

$(document).on('click', '.sugerencias_tarjeta', function (event) {
	event.preventDefault();            
	aux_recibido=$(this).val();
	var porcion = aux_recibido.split(';');
	unidad_tarjeta=porcion[0];
	unidad_tipo=porcion[1];
	unidad_responsable=porcion[2];
	
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

clean_dates.onclick = function(){
	fecha_inicio.value = "";
	fecha_fin.value = "";
}

$("#clean_responsable").click(function(){
	$("#busqueda_colaborador").val("");
	$("#id_colaborador").val("");
	$("#name_colaborador").val("");

});

$("#clean_vin").click(function(){
	$("#fecha_inicio").val("");
	
});

$("#clean_idlogistica").click(function(){
	$("#idlogistica").val("");
	
});

$("#clean_card").click(function(){
	$("#busqueda_card").val("");
	$("#tarjeta").val("");
	$("#tipo_tarjeta").val("");
	$("#responsable_tarjeta").val("");

});

function mayus(e) {
	e.value = e.value.toUpperCase();
}

function valideKey(evt){

    // code is the decimal ASCII representation of the pressed key.
    var code = (evt.which) ? evt.which : evt.keyCode;
    
    if(code==8) { // backspace.
    	return true;
    } else if(code>=48 && code<=57) { // is a number.
    	return true;
    } else{ // other keys.
    	return false;
    }
}

</script>






</body>
</html>