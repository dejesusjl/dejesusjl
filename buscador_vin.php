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

	<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
	<script src="../../js/jquery-1.10.2.js"></script>
	<script src="../../js/jquery-ui.js"></script>

	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
	-->
	

	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.date.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.time.css">
	<title>CCP | Reportes Búsqueda VIN</title>
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
								<a class="text-white" href="agregar_orden_logistica.php">Resumen Balance Gastos</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li class="active text-white">
								<strong>Resumen Ordenes Logística</strong>
							</li>
						</ol>

						<br>
						
						<?php 
						date_default_timezone_set('America/Mexico_City');
						$fecha_creacion = date("Y-m-d H:i:s");
						?>
						<div class="row">
							<form id="form_logisticas" method="POST" action="show_table_logisticas.php">

								<div class="col-sm-12">
									<div class="form-group row">

										<div class="col-sm-12">
											<div class="container-bg-1 p-3">
												<div class="d-flex align-items-center flex-wrap mb-2">
													<label class="mb-0 mr-2" for="idlogistica">Número de Logística</label>
													<div id="clean_idlogistica" class="container-iconos-1">
														<i class="fa fa-trash-o" aria-hidden="true"></i>
													</div>
												</div>
												<input type="number" class="form-control" id="idlogistica" name="idlogistica" onkeypress="return valideKey(event);">
											</div>
										</div>


										<div class="col-sm-12 mt-4">
										
											<div class="container-bg-1 p-3">
												<div class="row">
													<div class="col-sm-12 form-group">
														<div class="d-flex justify-content-center">
															<div id="clean_dates" class="container-iconos-1">
																<i class="fa fa-trash-o" aria-hidden="true"></i>
															</div>															
														</div>														
													</div>
													<div class="col-sm-6 form-group">
														<label>*Fecha de Inicio:</label>
														<input class="form-control" type="text" id="fecha_inicio" name="fecha_inicio" readonly="">
													</div>
													<div class="col-sm-6 form-group">
														<label>*Fecha de Fin:</label>
														<input class="form-control" type="text" id="fecha_fin" name="fecha_fin" readonly="">
													</div>												
												</div>										
											</div>
										
										</div>
									
										
										<div class="col-sm-12 mt-4">
										
											<div class="container-bg-1 p-3">
												<div class="row">												
													<div class="col-sm-12">	
														<div class="d-flex align-items-center flex-wrap mb-2">
															<label class="mb-0 mr-2" for="busqueda_colaborador">*Buscar Colaborador</label>
															<div id="clean_responsable" class="container-iconos-1">
																<i class="fa fa-trash-o" aria-hidden="true"></i>
															</div>
														</div>													
														<input placeholder="Buscar" class="form-control" type="text" name="busqueda_colaborador" id="busqueda_colaborador" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_ColaboradorIdLo();" size="19" width="300%"  />
														<center>
															<div id="resultadoBusquedaColaboradorID" class="container-busquedas-1 mt-4 efecto-busqueda " style="display: none;"></div>
														</center>
													</div>	
													<div class="col-sm-12">
														<div class="form-group">
															<label>*Colaborador </label>
															<input type="hidden" id="id_em_prov_provt" name="id_em_prov_provt" >
															<input type="hidden" id="type_em_prov_provt" name="type_em_prov_provt" >
															<input class="form-control" type="text"  name="name_colaborador" id="name_colaborador" readonly="" />
														</div>
													</div>
												</div>																					
											</div>

										</div>									

										<div class="col-sm-12 mt-4">
										
											<div class="container-bg-1 p-3">
												<div class="row">											
													<div class="col-sm-12">
														<label>*Tipo Orden: </label>
														<div class="content-select">
															<select name="nombre_orden" id="nombre_orden" class="form-control" >
																<option value="">Selecciona una opción ...</option>
																<?php 
																$query_type_orden = "SELECT tipo_orden FROM orden_logistica_unidades GROUP BY tipo_orden";
																$result_type_orden = mysql_query($query_type_orden);

																while ($row_type_orden = mysql_fetch_array($result_type_orden)) {
																	echo "<option value='$row_type_orden[0]'>$row_type_orden[0]</option>";
																}
																?>
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
														<input class="form-control" type="text" id="vin_herramienta" name="vin_herramienta"  readonly="" minlength="8" maxlength="8" onKeyUp="mayus(this);"  />
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
														<br>
													</div>												
												</div>
											
											</div>
										
										</div>
																													

										<div class="col-sm-12">
											<br>
											<center>
												<button class="btn-lg btn-primary" id="show_date" type="button">Buscar</button>
												<!-- <button class="btn-lg btn-primary" id="show_date" type="submit">Guardar</button> -->
											</center>
										</div>

									</div>
								</div>
							</form>


							<div class="col-sm-12" >
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
        min: new Date(2019,12,1),
        max: new Date()
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
        min: new Date(2019,12,1),
        max: new Date()
        // disable: [
        // 1,2,3, 4,5,6
        // ]
    });

	$(document).ready(function() {

		$("#show_date").click(function(){

			var datos_balance = $("#form_logisticas").serialize();
			console.log(datos_balance);		

			$.ajax({
				url : 'show_table_vin.php',
				data : datos_balance,
				type : 'POST',
				beforeSend: function(){
					$(".container-loading-ajax").show();
				},
				success : function(json) {
					$(".container-loading-ajax").hide();
					$("#show_table").html(json);
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

		/////////

	});



	function buscar_ColaboradorIdLo() {
		var textoBusquedaColaborador = $("#busqueda_colaborador").val();
	
		if (textoBusquedaColaborador != "") {
			$.post("buscar_id_unidades.php", {valorBusqueda: textoBusquedaColaborador}, function(mensaje_trasladista) {
				$("#resultadoBusquedaColaboradorID").html(mensaje_trasladista);

				if (mensaje_trasladista==" <b>Trasladista NO Encontrado</b>") {
					$("#name_colaborador").attr("readonly","readonly");
					$("#resultadoBusquedaColaboradorID").show();
				}else{    
					$("#name_colaborador").attr("readonly","readonly");   
					$("#resultadoBusquedaColaboradorID").show();      
				}
			});
		} else { 
			$("#resultadoBusquedaColaboradorID").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
		};
	};

	$(document).on('click', '.sugerencias_id_vin_logisticaaaaaaa', function (event) {
		event.preventDefault();            
		aux_recibido=$(this).val();
		var porcion = aux_recibido.split(';');
		unidad_id_trasladista=porcion[0];
		unidad_nomenclatura_trasladista=porcion[1];
		tipo_trasladista=porcion[2];
		$("#resultadoBusquedaColaboradorID").hide();  
		$("#busqueda_colaborador").val("");
		$("#id_em_prov_provt").val(unidad_id_trasladista);
		$("#name_colaborador").val(unidad_nomenclatura_trasladista);
		$("#type_em_prov_provt").val(tipo_trasladista);
		$("#resultadoBusquedaColaboradorID").html("");
		$("#resultadoBusquedaColaboradorID").hide();





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

// busqueda ID



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

// $("#clean_responsable").click(function(){
// 	$("#busqueda_colaborador").val("");
// 	$("#id_em_prov_provt").val("");
// 	$("#name_colaborador").val("");
// 	$("#type_em_prov_provt").val("");
// });

const clean_responsable = document.getElementById("clean_responsable");
const busqueda_colaborador = document.getElementById("busqueda_colaborador");
const id_em_prov_provt = document.getElementById("id_em_prov_provt");
const name_colaborador = document.getElementById("name_colaborador");
const type_em_prov_provt = document.getElementById("type_em_prov_provt");

clean_responsable.onclick = function(){
	busqueda_colaborador.value = "";
	id_em_prov_provt.value = "";
	name_colaborador.value = "";
	type_em_prov_provt.value = "";
}

// $("#clean_vin").click(function(){
// 	$("#fecha_inicio").val("");		
// });

const clean_vin = document.getElementById("clean_vin");
const vin_herramienta = document.getElementById("vin_herramienta");
const marca_herramienta = document.getElementById("marca_herramienta");
const version_herramienta = document.getElementById("version_herramienta");
const color_herramienta = document.getElementById("color_herramienta");
const modelo_herramienta = document.getElementById("modelo_herramienta");

clean_vin.onclick = function(){
	vin_herramienta.value = "";
	marca_herramienta.value = "";
	version_herramienta.value = "";
	color_herramienta.value = "";
	modelo_herramienta.value = "";
}

// $("#clean_idlogistica").click(function(){
// 	$("#idlogistica").val("");	
// });

const clean_idlogistica = document.getElementById("clean_idlogistica");
const idlogistica = document.getElementById("idlogistica");

clean_idlogistica.onclick = function(){
	idlogistica.value = "";
}

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