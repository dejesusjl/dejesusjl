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


$array_tipo_orden = array("<option value='GPS'>GPS</option>","<option value='Póliza de Seguro'>Póliza de Seguro</option>", "<option value='Póliza de Traslado'>Póliza de Traslado</option>");

$query_tipo_orden = "SELECT tipo FROM unidades_utilitarios_herramientas WHERE visible = 'SI' group by tipo ";
$result_tipo_orden = mysql_query($query_tipo_orden);

while ($row_tipo_orden = mysql_fetch_array($result_tipo_orden)) {

	$tipo_orden_trim = trim($row_tipo_orden[0]);


	array_push($array_tipo_orden, "<option value='$tipo_orden_trim'>$tipo_orden_trim</option>");

}

$tipo_orden_unique = array_unique($array_tipo_orden);
unset($options);
$options = implode("", $tipo_orden_unique);

#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


$array_descripcion = array();

$query_descripcion = "SELECT descripcion FROM unidades_utilitarios_herramientas WHERE visible = 'SI' group by descripcion ";
$result_descripcion = mysql_query($query_descripcion);

while ($row_descripcion = mysql_fetch_array($result_descripcion)) {
	
	$descriptions_trim = trim($row_descripcion[0]);

	array_push($array_descripcion, "<option value='$descriptions_trim'>$descriptions_trim</option>");

}

$descripcion_unique = array_unique($array_descripcion);
unset($descriptions);
$descriptions = implode("", $descripcion_unique);

#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

$array_pago = ["<option value='Anual'>Anual</option>", "<option value='Semestral'>Semestral</option>", "<option value='Trimestral'>Trimestral</option>", "<option value='Traslado'>Traslado</option>"];

$query_pago = "SELECT columna_c FROM unidades_utilitarios_herramientas WHERE visible = 'SI' group by columna_c";
$result_pago = mysql_query($query_pago);

while ($row_pago = mysql_fetch_array($result_pago)) {

	$periodo_pago_trim = trim($row_pago[0]);

	array_push($array_pago, "<option value='$periodo_pago_trim'>$periodo_pago_trim</option>");

}

$pago_unique = array_unique($array_pago);
unset($periodo_pago);
$periodo_pago = implode("", $pago_unique);



#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------





?>
<!DOCTYPE html>
<html lang="es">
<head>
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
	<title>CCP | Agregar Herramientas Unidades</title>
	<style>
		#show_date{
			cursor: pointer;
		}
		.dtp-picker-days thead, .dtp-picker-days thead th{
			background: transparent !important;
			color: #757575 !important;
			text-transform: uppercase;
		}

		.dtp-actual-day{
			text-transform: capitalize;
		}



		.dtp-btn-ok{
			margin-left: 10px;
		}

		.dtp-picker-days tbody tr td a{
			z-index: 1;
		}

		.dtp-picker-days tbody tr td a:hover{
			color: #FFF !important;
		}

		.dtp-picker-days tbody tr td a:before{
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
		.dtp-picker-days tbody tr td a:hover:before{
			transform: scale(1);
		}
	</style>
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
								<a class="text-white" href="detalle_utilitarias.php">Resumen Unidades Utilitarias</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li class="text-white" class="active">
								<strong> Agregar Pólizas GPS</strong>
							</li>
						</ol>

						<br>

						<?php 
						date_default_timezone_set('America/Mexico_City');
						$fecha_creacion = date("Y-m-d H:i:s");
						?>

						<form id="form_balance" method="POST" action="agregar_herramientas_utilitarias.php" enctype="multipart/form-data">
							<div class="row col-sm-12">

								<div class="col-sm-12 field_wrapper_vin" id="show_vin_adicional">

								</div>

								<div class="col-sm-12 mt-4">
									<center>
										<a id='create_vin' style='width: 180px;height: 90px;' class="create_vin icon-DOrden" class="" title="Add field"><i class='fa fa-plus-circle fa-5x zoom font-iconr' aria-hidden='true' ></i></a>
										<div class="tooltipDetalleOrden mb-3">
											<p>Agregar</p>
										</div>
									</center>
								</div>



								<input id="aux_vin" type="hidden" value="0" readonly>
								<input id="count_vin" type="hidden" value="0" readonly>
								<input id="count_principal_vin" type="hidden" value="0" readonly>








								<script type="text/javascript">
									$(document).ready(function(){


										var addButtonVIN = $('.create_vin');
										var wrapper_vin = $('.field_wrapper_vin');

										$(addButtonVIN).click(function() {


											var obtener_count_vin = $("#count_vin").val();


											var add_coun_vin = parseInt(obtener_count_vin, 10) + 1;
											$("#count_vin").val(add_coun_vin);



											var obtener_aux_vin = $("#aux_vin").val();

											if (obtener_aux_vin == 0) {

												var contador_vin = 1;

											} else {

												if ($.isNumeric(obtener_aux_vin) == true) {

													var contador_vin = parseInt(obtener_aux_vin, 10) + 1;

												} else {

													var cortar = obtener_aux_vin.substr(0, 1);

													var contador_vin = parseInt(obtener_aux_vin, 10) + 1;

												}
											}






											fechaspicker(contador_vin);

											$("#aux_vin").val(contador_vin);

											var fieldHTMLVIN = `
											<div class="row mt-4 mb-4 container-title-line">

											<div class="col-sm-12">
											<label>Buscar VIN</label>
											<input placeholder="Buscar VIN" class="form-control vin_adicional borrar_vin" type="text" name="busqueda_herramienta[]" id="busqueda_herramienta_adicional${contador_vin}" autocomplete="off" onkeyup="verificarVIN(${contador_vin});" size="19" width="300%"  >

											<center>
											<div id="resultadoBusquedaherramienta_adicional${contador_vin}" class="container-busquedas-1 mt-4" style="display: none;">
											</div>
											</center>
											</div>

											<div class="col-sm-6">
											<label>VIN</label>
											<input type="text" id="soy_vin${contador_vin}" name="soy_vin[]" class="form-control borrar_vin" readonly minlength="8" maxlength="8" onKeyUp="mayus(this);">
											</div>

											<div class="col-sm-6">
											<label>Marca</label>
											<input type="text" id="marca_vin${contador_vin}" name="soy_marca[]" class="form-control borrar_vin" readonly onKeyUp="mayus(this);">
											</div>

											<div class="col-sm-6">
											<label>Version</label>
											<input type="text" id="version_vin${contador_vin}" name="soy_version[]" class="form-control borrar_vin" readonly list="search_version${contador_vin}"  onKeyUp="mayus(this);" />
											</div>

											<div class="col-sm-6">
											<label>Color</label>
											<input type="text" id="color_vin${contador_vin}" name="soy_color[]" class="form-control borrar_vin" readonly list="search_color${contador_vin}"  onKeyUp="mayus(this);" />
											</div>

											<div class="col-sm-6">
											<label>Modelo</label>
											<input type="number" id="modelo_vin${contador_vin}" name="soy_modelo[]" class="form-control borrar_vin" readonly min="1900" max="2050">
											</div>

											<div class="col-sm-6"><label>Tipo Unidad</label>
											<input type="text" id="tipo_vin${contador_vin}" name="tipo_vin[]" class="form-control borrar_vin" readonly >
											</div> 

											<div class="col-sm-6">
											<label for="idorden" class="col-form-label">No Orden:</label>
											<input type="text" class="form-control" name="idorden[]" id="idorden${contador_vin}" value="<?php echo "0"; ?>" >
											</div>

											<div class="col-sm-6">
											<label for="tipo_orden" class="col-form-label">Tipo Orden:</label>
											<input type="text" class="form-control" name="tipo_orden[]" id="tipo_orden${contador_vin}" value="<?php echo "N/A"; ?>" >
											</div>

											<div class="col-sm-4">
											<label for="tipo" class="col-form-label">Tipo:</label>
											<input type="text" class="form-control" name="tipo[]" id="tipo${contador_vin}" list="optionsherraminetas" required>

											<datalist id="optionsherraminetas">
											<?php echo $options; ?>
											</datalist>

											</div>

											<div class="col-sm-8">
											<label for="descripcion" class="col-form-label">Descripción:</label>
											<input type="text" class="form-control" name="descripcion[]" id="descripcion${contador_vin}" list="descripcion_herramientas" required>

											<datalist id="descripcion_herramientas">
											<?php echo $descriptions; ?>
											</datalist>
											</div>

											<div class="col-sm-6">  
											<div class="d-flex align-items-center mb-2">
											<label class="mb-0 mr-2" for="fecha_a">*Fecha Inicio</label>
											<div id="clean_fecha_a" class="container-iconos-1">
											<i class="fa fa-trash-o" aria-hidden="true"></i>
											</div>
											</div>
											<input class="form-control" type="text" id="fecha_a${contador_vin}" name="fecha_a[]" readonly onclick="fechasa(${contador_vin})" >
											</div>


											<div class="col-sm-6">     
											<div class="d-flex align-items-center mb-2">
											<label class="mb-0 mr-2">Fecha Vencimiento</label>
											<div id="clean_fecha_vencimiento" class="container-iconos-1">
											<i class="fa fa-trash-o" aria-hidden="true"></i>
											</div>
											</div>
											<input class="form-control" type="text" id="fecha_vencimiento${contador_vin}" name="fecha_vencimiento[]" onclick="fechaspicker(${contador_vin})" readonly />
											</div>


											<div class="col-sm-4">
											<label for="columna_c" class="col-form-label">Períodos de pago:</label>
											<input type="text" class="form-control" name="columna_c[]" id="columna_c${contador_vin}" list="periodos_pagos" required>

											<datalist id="periodos_pagos">
											<?php echo $periodo_pago; ?>
											</datalist>
											</div>

											<div class="col-sm-4">
											<label for="columna_d" class="col-form-label">Costo Total</label>
											<input type="text" class="form-control" name="columna_d[]" id="columna_d${contador_vin}" required onkeypress="return SoloNumeros(event);">
											</div>

											<div class="col-sm-4">
											<label for="columna_a" class="col-form-label">IMEI | Poliza</label>
											<input type="text" class="form-control" name="columna_a[]" id="columna_a${contador_vin}" required>
											</div>

											<div class="col-sm-6">
											<label for="columna_b" class="col-form-label">Teléfono:</label>
											<input type="text" class="form-control" name="columna_b[]" id="columna_b${contador_vin}" maxlength="10" onkeypress="return SoloNumeros(event);">
											</div>


											<div class="col-sm-6">                      
											<label>Estatus:</label>
											<div class="content-select">
											<select name="estatus[]" id="estatus${contador_vin}" class="form-control">
											<option value="Activo">Activo</option>
											<option value="Pendiente">Pendiente</option>
											</select>
											<i></i>
											</div>											
											</div>



											<div class="col-sm-12">
											<label for="formFile" class="form-label">Subir Evidencia</label>
											<input class="form-control" type="file" id="formFile" name="evidencia[]">
											</div>

											

											<div class="col-sm-12">
											<label for="comentarios" class="col-form-label">Comentarios:</label>
											<textarea class="form-control" id="comentarios${contador_vin}" name="comentarios[]" required></textarea>
											</div>


											<a class="button-eliminar remove_button mt-4 mb-4">
											<span>Eliminar</span><i class="fas fa-trash"></i>
											</a>


											</div>

											`;


											$(wrapper_vin).append(fieldHTMLVIN);

										});


$(wrapper_vin).on('click', '.remove_button', function(e) {
	e.preventDefault();
	$(this).parent('div').remove();

	var obtener_aux_vinsin_tocar = $("#aux_vin").val();
	$("#aux_vin").val(obtener_aux_vinsin_tocar + "|");

	var disminuir_count_vin = $("#count_vin").val();
	var nuevo_contador_vin = parseInt(disminuir_count_vin, 10) - 1;
	$("#count_vin").val(nuevo_contador_vin);

	if (nuevo_contador_vin == 0) {
		$("#aux_vin").val("0");
	}


});



});


function verificarVIN(contador_nuevo_vin) {

	fechaspicker(contador_nuevo_vin);
	fechasa(contador_nuevo_vin);
	var vin_nomenclatura = $("#busqueda_herramienta_adicional" + contador_nuevo_vin).val();



	$.post("buscar_vin_herramienta.php", { valorHerramienta: vin_nomenclatura, contador_nuevo_vin: contador_nuevo_vin }, function(mensaje_vin2) {

		$("#resultadoBusquedaherramienta_adicional" + contador_nuevo_vin).html(mensaje_vin2);
		$("#resultadoBusquedaherramienta_adicional" + contador_nuevo_vin).show();


	});


	$(document).on('click', '.sugerencias_herramienta' + contador_nuevo_vin, function(event_adicional) {
		event_adicional.preventDefault();
		aux_recibido_adicional = $(this).val();
		var porcion_adicional = aux_recibido_adicional.split(';');
		unidad_herramientavin_adicional = porcion_adicional[0];
		unidad_htvin_adicional = porcion_adicional[1];
		unidad_htmarca_adicional = porcion_adicional[2];
		unidad_htversion_adicional = porcion_adicional[3];
		unidad_htcolor_adicional = porcion_adicional[4];
		unidad_htmodelo_adicional = porcion_adicional[5];
		unidad_httipo_adicional = porcion_adicional[6];
		unidad_autorizacion_adicional = porcion_adicional[7]


		$("#busqueda_herramienta_adicional" + contador_nuevo_vin).val(unidad_htvin_adicional);
		$("#soy_vin" + contador_nuevo_vin).val(unidad_htvin_adicional);
		$("#marca_vin" + contador_nuevo_vin).val(unidad_htmarca_adicional);
		$("#version_vin" + contador_nuevo_vin).val(unidad_htversion_adicional);
		$("#color_vin" + contador_nuevo_vin).val(unidad_htcolor_adicional);
		$("#modelo_vin" + contador_nuevo_vin).val(unidad_htmodelo_adicional);
		$("#tipo_vin" + contador_nuevo_vin).val(unidad_httipo_adicional);
		$("#resultadoBusquedaherramienta_adicional" + contador_nuevo_vin).html("");
		$("#resultadoBusquedaherramienta_adicional" + contador_nuevo_vin).hide();

		console.log(unidad_autorizacion_adicional);

		if (typeof unidad_autorizacion_adicional === 'undefined') {

			console.log(`Vin sin Autorizacion ${contador_nuevo_vin}`);
			$("#vin_autorizacion"+contador_nuevo_vin).hide();

			if (unidad_htvin_adicional == "") {

				$("#show_autorizacion"+contador_nuevo_vin).show();
				$("#show_rol_vin_adicional"+contador_nuevo_vin).hide();

			} else {

				$("#show_autorizacion"+contador_nuevo_vin).show();
				$("#show_rol_vin_adicional"+contador_nuevo_vin).hide();
			}

		}else {
			console.log("activando autorizaciones " + contador_nuevo_vin);
			$("#vin_autorizacion"+contador_nuevo_vin).show();
		}



	});



}


</script>





<input type="hidden" id="fecha_creacion" name="fecha_creacion" value='<?php echo "$fecha_creacion"; ?>'>

<div class="col-sm-12">
	<center>
		<button class="btn-lg btn-primary" id="show_date" type="submit">Guardar</button>
	</center>
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


<script src="../../plugins/Datepicker/bootstrap-material-datetimepicker.js"></script>
<script src="../../plugins/Datepicker/es-mx.min.js"></script>


<script>

	function fechaspicker(valor){

		$('#fecha_vencimiento'+valor).bootstrapMaterialDatePicker({ 
			date : true,
			time : false,
			shortTime: true,
			format : 'YYYY-MM-DD',
			lang : "es",
			cancelText: 'Cancelar',
			okText: 'Definir'
			
		});

	}

	function fechasa(valor){

		$('#fecha_a'+valor).bootstrapMaterialDatePicker({ 
			date : true,
			time : false,
			shortTime: true,
			format : 'YYYY-MM-DD',
			lang : "es",
			cancelText: 'Cancelar',
			okText: 'Definir'
			
		});

	}

	function SoloNumeros(evt){
		if(window.event){ 
			keynum = evt.keyCode; 
		}
		else{
			keynum = evt.which; 
		}

		if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 || keynum == 47 ){
			return true;
		}
		else{
			return false;
		}
	}

</script>





</body>
</html>