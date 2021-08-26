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


$options_tipo .="
<optgroup label='Todas las Tarjetas (Combustible, Despensa, Tag, Viajes y Negocios)'>
<option value='Activos'>Activos</option>
<option value='Eliminados'>Eliminados</option>
<option value='ALL'>Todos</option>
</optgroup>
";

$query_tipo_card = "SELECT tipo FROM catalogo_monederos_electronicos GROUP BY tipo";
$result_tipo_card = mysql_query($query_tipo_card);

while ($row_tipo_card = mysql_fetch_array($result_tipo_card)) {

	$options_tipo .="
	<optgroup label='$row_tipo_card[0]'>
	<option value='$row_tipo_card[tipo]SI'>$row_tipo_card[tipo] - Activos</option>
	<option value='$row_tipo_card[tipo]NO'>$row_tipo_card[tipo] - Eliminados</option>
	<option value='$row_tipo_card[tipo]ALL'>$row_tipo_card[tipo] - Todos	</option>
	</optgroup>
	";
}


$query_name_card = "SELECT nombre_tarjeta FROM catalogo_monederos_electronicos GROUP BY nombre_tarjeta";
$result_name_card = mysql_query($query_name_card);

while ($row_name_card = mysql_fetch_array($result_name_card)) {

	$options_tipo .="
	<optgroup label='$row_name_card[0]'>
	<option value='$row_name_card[nombre_tarjeta]SI'>$row_name_card[nombre_tarjeta] - Activos</option>
	<option value='$row_name_card[nombre_tarjeta]NO'>$row_name_card[nombre_tarjeta] - Eliminados</option>
	<option value='$row_name_card[nombre_tarjeta]ALL'>$row_name_card[nombre_tarjeta] - Todos	</option>
	</optgroup>
	";
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
	<title>CCP | Resumen Tarjetas</title>
	<style>
	#show_date{
		cursor: pointer;
	}
</style>
<style>
/*Scroll de tablas*/
#columna{
	overflow: auto;
	margin: 5px;
	width: 100%;
	height: 500px; /*establece la altura máxima, lo que no entre quedará por debajo y saldra la barra de scroll*/
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

						<ol class="breadcrumb fondo-encabezados">
							<li>
								<a class="text-white" href="index.php">Inicio</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li class="active text-white">
								<a class="text-white" href="#" onclick="ActionsModalWallet('Create');">Agregar Tarjeta</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li class="active text-white">
								<strong>Resumen monedero electrónico</strong>
							</li>
						</ol>

						<br>


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

									<div class="modal-body" id="add_opciones_modal_options">

									</div>

									<div class="col-sm-12" id="comentarios_actions" style="display: block; ">
										<div class="col-sm-12">
											<label>*Comentarios&nbsp;&nbsp;<span class="contador_span" id="contador_span_wallet">20 caracteres restantes</label>
												<textarea name="comentarios" id="comentarios" class="form-control vaciar_input" rows="2" required="" onkeypress="cancelar_enter()" onkeyup="RangeComentarios(this,'contador_span_wallet','guardar_actions');"></textarea>
											</div>
										</div>

										<input type="hidden" class="vaciar_input" name="tipo_crud" id="tipo_crud">
										<input type="hidden" class="vaciar_input" name="idcatalogo_monederos_electronicos_encriptado" id="idcatalogo_monederos_electronicos_encriptado">


										
										<br>
										<div class="modal-footer">

											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
											<button type="button" class="btn btn-primary" data-dismiss="modal" id="guardar_actions" style="display: none;" onclick="ConfirmarActions();">Guardar</button>

										</div>
									</div>
								</div>
							</div>

							<form id="form_electronic_card" method="POST" >

								<div class="row">

									<div class="col-sm-12">
										<div class="container-bg-1 p-3">
											<div class="row">
												<div class="col-sm-12">
													<label for="tipo_tabla_card">Mostrar Tipo de Tabla</label>
													<div class="content-select">
														<select name="tipo_tabla_card" id="tipo_tabla_card" class="form-control">
															<?php 
															echo $options_tipo;
															?>
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
											<input type="hidden" name="tipo_crud" value="Read">
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

				<div class="sec-datos col-sm-12" id="BitacoraCard">

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

		<script  type="text/javascript" class="init">

			window.addEventListener("load", MostrarBitacora);

			function MostrarContenido () {

				var datos_balance = $("#form_electronic_card").serialize();

				$.ajax({
					url : 'show_electronic_card.php',
					data : datos_balance,
					type : 'POST',
					beforeSend: function(){
						$(".container-loading-ajax").show();
					},
					success : function(json) {			
						$("#show_table").html(json);
						$(".container-loading-ajax").hide();
					},

					error : function(xhr, status) {

						$(".error-form").show();
						$(".text-error").html("Disculpe, existió un problema");

						setTimeout(function(){
							$(".error-form").fadeOut(1000);
						}, 1500);
					}

				});

			}

			function MostrarBitacora () {

				var tipo_movimiento = "BitacoraALL";

				$.ajax({
					url : 'actualizaCodigosTarjeta.php',
					data : {tipo_movimiento : tipo_movimiento},
					type : 'POST',

					beforeSend: function(){

						$(".container-loading-ajax").show();

					},

					success : function(mensajebitacora) {

						$("#BitacoraCard").html(mensajebitacora);
						$(".container-loading-ajax").hide();

					},

					error : function(xhr, status) {

						$(".error-form").show();
						$(".text-error").html("Disculpe, existió un problema");

						setTimeout(function(){
							$(".error-form").fadeOut(1000);
						}, 1500);
					}

				});

			}

			function BuscarResponsableMonederoElectronico () {

				var textoBusquedaAsesor = $("#busqueda_asesor").val();

				if (textoBusquedaAsesor != "") {

					$.post("buscar_responsable_monedero.php", {valorBusqueda: textoBusquedaAsesor}, function(mensaje_asesor) {

						$("#resultadoBusquedaAsesor").html(mensaje_asesor);
						$("#resultadoBusquedaAsesor").show();

					});

				} else { 

					$("#resultadoBusquedaAsesor").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');

				};

				$(document).on('click', '.sugerencias_asesor', function (event) {

					event.preventDefault();            
					aux_recibido=$(this).val();

					var porcion = aux_recibido.split(';');

					unidad_id_asesor=porcion[0];
					unidad_nomenclatura=porcion[1];

					$("#solicitante").val(unidad_nomenclatura);
					$("#idempleados").val(unidad_id_asesor);
					

					$("#resultadoBusquedaAsesor").hide();  
					$("#busqueda_asesor").val("");
					
					$("#resultadoBusquedaAsesor").html("");

				});

			}


			function EventosTarjeta () {

				var nombre_tarjeta = $("#name_tarjeta").val();

				if (nombre_tarjeta == "BROXEL") {

					$("#type_tarjeta").empty();

					var options_card = `
					<option value="Combustible">Combustible</option>
					<option value="Despensa">Despensa</option>
					<option value="Viajes y Negocios">Viajes y Negocios</option>
					`;

					$("#cvv").removeAttr("readonly","readonly");
					$("#mes").removeAttr("readonly","readonly");
					$("#anio").removeAttr("readonly","readonly");
					$("#nip").removeAttr("readonly","readonly");

				}else if (nombre_tarjeta == "TAG ID DE MEXICO SA DE CV") {

					$("#type_tarjeta").empty();

					var options_card = `<option value="Tag">Tag</option>`;

					$("#cvv").attr("readonly","readonly");
					$("#cvv").val("");

					$("#mes").attr("readonly","readonly");
					$("#mes").val("");

					$("#anio").attr("readonly","readonly");
					$("#anio").val("");

					$("#nip").attr("readonly","readonly");
					$("#nip").val("");

				}

				$('#type_tarjeta').append(options_card);
			}

			function EventosTipo () {

				var tipo_tarjeta = $("#type_tarjeta").val();

				if (tipo_tarjeta == "Combustible" || tipo_tarjeta == "Despensa" || tipo_tarjeta == "Viajes y Negocios") {

					$("#cvv").removeAttr("readonly","readonly");
					$("#mes").removeAttr("readonly","readonly");
					$("#anio").removeAttr("readonly","readonly");
					$("#nip").removeAttr("readonly","readonly");

				}else if (tipo_tarjeta == "Tag") {

					$("#cvv").attr("readonly","readonly");
					$("#cvv").val("");

					$("#mes").attr("readonly","readonly");
					$("#mes").val("");

					$("#anio").attr("readonly","readonly");
					$("#anio").val("");

					$("#nip").attr("readonly","readonly");
					$("#nip").val("");

				}
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

				setTimeout(function(){
					$(".listo-form").fadeOut(250);
				}, 450);

			}


			function ActionsModalWallet (actionswallet) {

				$('#modal_actions_wallet').modal('toggle');
				$("#comentarios_actions").show();

				$("#title_modal_actions").val("");
				$(".vaciar_input").val("");

				$("#add_opciones_modal_options").empty();


				var porciones_actions = actionswallet.split("|") ;



				if (porciones_actions[0] == "InfoB") {

					$("#title_modal_actions").html("Bitácora de Seguimiento en: <b>" + porciones_actions[2] + "</b>");
					$("#comentarios_actions").hide();

					var link = "actualizaCodigosTarjeta.php";
					var tipo_movimiento = "BitacoraIndividual";

					$.ajax({
						type: "POST",
						url: link,
						data: {tipo_movimiento : tipo_movimiento, id : porciones_actions[1]},
						success: function(modal_result_recurso){

							$("#add_opciones_modal_options").html(modal_result_recurso);

						}
					});

				}else if (porciones_actions[0] == "Update") {


					$("#title_modal_actions").html("Editar: <b>" + porciones_actions[2] + "</b>");

					
					$("#tipo_crud").val(porciones_actions[0]);
					$("#idcatalogo_monederos_electronicos_encriptado").val(porciones_actions[1]);

					var mes_anio = porciones_actions[7].split("/");
					var mes = mes_anio[0];
					var anio = mes_anio[1];

					var agregar_inputs = `

					<div class="col-sm-12 mt-4">
					<div class="container-bg-1 p-3">
					<div class="row">

					<div class="col-sm-12">
					<label for="responsable_actual">Responsable Actual</label>
					<input type="text" class="form-control" readonly="" value="${porciones_actions[3]}">

					</div>


					<div class="col-sm-12">
					<label for="busqueda_asesor">Buscar Nuevo Responsable</label>
					<input placeholder="Buscar" class="form-control" type="text" name="busqueda_asesor" id="busqueda_asesor" value="" maxlength="25" autocomplete="off" onKeyUp="BuscarResponsableMonederoElectronico();" size="19" width="300%"  />
					<center>
					<div id="resultadoBusquedaAsesor" style="display: none;" class="container-busquedas-1 mt-4 efecto-busqueda"></div>
					</center>
					</div>

					<div class="col-sm-12">
					<label for="solicitante">Nuevo Responsable</label>
					<input class="form-control" type="text" name="solicitante" id="solicitante" readonly="" />
					<input type="hidden" name="idempleados" id="idempleados" readonly="" value="${porciones_actions[10]}">
					</div>

					</div>
					</div>
					</div>

					<hr>

					<div class="col-sm-12">
					<div class="container-bg-1 p-3">
					<div class="row">

					<div class="col-sm-12">
					<div class="content-select">
					<label for="name_tarjeta">Tarjeta</label> 
					<select name="nombre_tarjeta" id="name_tarjeta" class="form-control" onchange="EventosTarjeta();">
					<option value='${porciones_actions[4]}'>${porciones_actions[4]}</option>
					<?php
					$query_card = "SELECT nombre_tarjeta FROM catalogo_monederos_electronicos WHERE visible = 'SI' and nombre_tarjeta <> 'EFECTICARD SA DE CV' and nombre_tarjeta <> 'EFECTIVALE SA DE CV' and nombre_tarjeta <> 'SI VALE SA DE CV' GROUP BY nombre_tarjeta order by nombre_tarjeta ASC";
					$result_card = mysql_query($query_card);

					while ($row_card = mysql_fetch_array($result_card)) {
						echo "<option value='$row_card[nombre_tarjeta]'>$row_card[nombre_tarjeta]</option>";
						
					}

					?>
					</select>
					</div>
					</div>

					<div class="col-sm-12">
					<label for="tipo">Tipo</label> 
					<div class="content-select">
					<select name="type_tarjeta" id="type_tarjeta" class="form-control" onchange="EventosTipo();">
					<option value='${porciones_actions[5]}'>${porciones_actions[5]}</option>

					</select>
					</div>							
					</div>

					<div class="col-sm-12">
					<label for="nip">NIP</label>
					<input type="number" id="nip" name="nip" class="form-control" min="0" max="999" onkeypress="return SoloNumeros(event);" onkeyup="SoloCuatro('nip|NIP');" value="${porciones_actions[6]}">
					</div>

					<div class="col-sm-12" >
					<label for="vigencia">Fecha de Vigencia</label> 												
					<div class="input-group mb-3">
					<label>Mes</label>
					<input type="number" class="form-control" placeholder="Mes" aria-label="Mes" id="mes" min="0" max="12" onkeypress="return SoloNumeros(event);" onkeyup="SoloMes('mes');" value="${mes}">
					<span class="input-group-text">/</span>
					<input type="number" class="form-control" placeholder="Año" aria-label="Año" id="anio" min="20" max="30" onkeypress="return SoloNumeros(event);" onkeyup="SoloDos('anio|Año');" value="${anio}">
					<label>Año</label>&nbsp;&nbsp;
					</div>
					</div>

					<div class="col-sm-12">
					<label for="name_tarjeta">CVV</label> 
					<input type="number" id="cvv" name="cvv" class="form-control" min="0" max="999" onkeypress="return SoloNumeros(event);" onkeyup="SoloTres('cvv');" value="${porciones_actions[8]}">
					</div>

					</div>
					</div>
					</div>

					<hr>

					<label>Actualmente <b>${porciones_actions[9]}</b> Hay Evidencia</label>
					<div class="col-sm-12">
					<label>Agregar | Cambiar Evidencia</label>
					<input type="file" id="evidencia" name="evidencia" class="form-control" >
					</div>

					<hr>
					`;

					$("#comentarios_actions").show();

				}else if (porciones_actions[0] == "Create") {

					$("#title_modal_actions").html("Agregar Nueva : <b> Tarjeta | Tag");
					$("#tipo_crud").val(porciones_actions[0]);

					$("#comentarios_actions").hide();
					$("#guardar_actions").show();

					$("#tipo_crud").val(porciones_actions[0]);
					$("#idcatalogo_monederos_electronicos_encriptado").val(porciones_actions[1]);

					var agregar_inputs = `
					<div class="col-sm-12">

					<div class="col-sm-12">
					<label for="valor" class="col-form-label">Número de Tarjeta</label>
					<input type="text" id="valor" name="valor" class="form-control" onkeypress="return SoloNumeros(event);" maxlength="16">
					</div>

					<hr>

					<div class="col-sm-12">
					<div class="content-select">
					<label for="name_tarjeta">Tarjeta</label> 
					<select name="nombre_tarjeta" id="name_tarjeta" class="form-control" onchange="EventosTarjeta();">
					<option value=''>Selecciona una opción ...</option>
					<?php
					$query_card = "SELECT nombre_tarjeta FROM catalogo_monederos_electronicos WHERE visible = 'SI' and nombre_tarjeta <> 'EFECTICARD SA DE CV' and nombre_tarjeta <> 'EFECTIVALE SA DE CV' and nombre_tarjeta <> 'SI VALE SA DE CV' GROUP BY nombre_tarjeta order by nombre_tarjeta ASC";
					$result_card = mysql_query($query_card);

					while ($row_card = mysql_fetch_array($result_card)) {
						echo "<option value='$row_card[nombre_tarjeta]'>$row_card[nombre_tarjeta]</option>";

					}

					?>
					</select>
					</div>
					</div>

					<div class="col-sm-12">
					<label for="tipo">Tipo</label> 
					<div class="content-select">
					<select name="type_tarjeta" id="type_tarjeta" class="form-control" onchange="EventosTipo();">

					</select>
					</div>							
					</div>

					<hr>

					<div class="col-sm-12">
					<label for="nip">NIP</label>
					<input type="number" id="nip" name="nip" class="form-control" min="0" max="999" onkeypress="return SoloNumeros(event);" onkeyup="SoloCuatro('nip|NIP');">
					</div>

					<div class="col-sm-12" >
					<label for="vigencia">Fecha de Vigencia</label> 												
					<div class="input-group mb-3">
					<label>Mes</label>
					<input type="number" class="form-control" placeholder="Mes" aria-label="Mes" id="mes" min="0" max="12" onkeypress="return SoloNumeros(event);" onkeyup="SoloMes('mes');">
					<span class="input-group-text">/</span>
					<input type="number" class="form-control" placeholder="Año" aria-label="Año" id="anio" min="20" max="30" onkeypress="return SoloNumeros(event);" onkeyup="SoloDos('anio|Año');">
					<label>Año</label>&nbsp;&nbsp;
					</div>
					</div>

					<div class="col-sm-12">
					<label for="name_tarjeta">CVV</label> 
					<input type="number" id="cvv" name="cvv" class="form-control" min="0" max="999" onkeypress="return SoloNumeros(event);" onkeyup="SoloTres('cvv');" >
					</div>

					<hr>

					<div class="col-sm-12">
					<label for="busqueda_asesor">Buscar Nuevo Responsable</label>
					<input placeholder="Buscar" class="form-control" type="text" name="busqueda_asesor" id="busqueda_asesor" value="" maxlength="25" autocomplete="off" onKeyUp="BuscarResponsableMonederoElectronico();" size="19" width="300%"  />
					<center>
					<div id="resultadoBusquedaAsesor" style="display: none;" class="container-busquedas-1 mt-4 efecto-busqueda"></div>
					</center>
					</div>

					<div class="col-sm-12">
					<label for="solicitante">Nuevo Responsable</label>
					<input class="form-control" type="text" name="solicitante" id="solicitante" readonly="" />
					<input type="hidden" name="idempleados" id="idempleados">
					</div>



					</div>
					`;


				}else if (porciones_actions[0] == "Delete") {

					var mensaje_activar_desactivar = (porciones_actions[4] == "SI") ? "Activar" : "Eliminar";

					$("#title_modal_actions").html(mensaje_activar_desactivar + ": <b> Tarjeta | Tag");
					$("#tipo_crud").val(porciones_actions[0]);
					$("#idcatalogo_monederos_electronicos_encriptado").val(porciones_actions[1]);

					var agregar_inputs = `
					<input type="hidden" name="valor" id="valor" value="${porciones_actions[2]}">
					<input type="hidden" name="name_tarjeta" id="name_tarjeta" value="${porciones_actions[3]}">
					<input type="hidden" name="activar_desactivar" id="activar_desactivar" value="${porciones_actions[4]}">
					`;


				}

				

				$("#add_opciones_modal_options").html(agregar_inputs);

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

			function SoloTres(valor){

				var idinput = $("#"+valor).val();

				if (idinput.length > 3) {

					$("#"+valor).focus();

					$(".error-form").show();
					$(".text-error").html("Solo Tres Números");

					setTimeout(function(){
						$(".error-form").fadeOut(1000);
						$("#"+valor).val("");
					}, 1500);


				}else {

				}

			}

			function SoloMes (valor) {

				var idinput = $("#"+valor).val();

				if (idinput.length > 2) {

					$("#"+valor).focus();

					$(".error-form").show();
					$(".text-error").html("Ingresa un mes <b>Valido</b>");

					setTimeout(function(){
						$(".error-form").fadeOut(1000);
						$("#"+valor).val("");
					}, 1500);

				}else {

				}

			}

			function SoloDos (valor) {

				var porciones = valor.split("|");
				
				var idinput = $("#"+porciones[0]).val();
				
				if (idinput.length > 2) {

					$("#"+porciones[0]).focus();

					$(".error-form").show();
					$(".text-error").html("Ingresa un " + porciones[1] +"<b> Valido</b>");

					setTimeout(function(){
						$(".error-form").fadeOut(1000);
						$("#"+porciones[0]).val("");
					}, 1500);


				}else {

				}

			}

			function SoloCuatro (valor) {

				var porciones = valor.split("|");
				
				var idinput = $("#"+porciones[0]).val();
				
				if (idinput.length > 4) {

					$("#"+porciones[0]).focus();

					$(".error-form").show();
					$(".text-error").html("Ingresa un " + porciones[1] +"<b> Valido</b>");

					setTimeout(function(){
						$(".error-form").fadeOut(1000);
						$("#"+porciones[0]).val("");
					}, 1500);


				}else {

				}

			}


			function ConfirmarActions (){

				$("#guardar_actions").hide();


				$('#modal_actions_wallet').modal('hide');



				var tipo_crud = $("#tipo_crud").val();

				var valor = $("#valor").val();

				var idcatalogo_monederos_electronicos_encriptado = $("#idcatalogo_monederos_electronicos_encriptado").val();
				var name_tarjeta = $("#name_tarjeta").val();
				var type_tarjeta = $("#type_tarjeta").val();
				var nip = $("#nip").val();
				var idempleados = $("#idempleados").val();
				var mes = $("#mes").val();
				var anio = $("#anio").val();
				var cvv = $("#cvv").val();
				var activar_desactivar = $("#activar_desactivar").val();
				

				var comentarios = $("#comentarios").val();
				var fecha_creacion = TiempoAhora();

				var formData = new FormData();

				if (tipo_crud == "Create" || tipo_crud == "Delete") {

					var link_ajax = "guardar_monedero_electronico.php";

				}else if (tipo_crud == "Update") {

					var evidencia = $("#evidencia")[0].files[0];
					formData.append('evidencia',evidencia);

					var link_ajax = "guardar_monedero_electronico.php";

				}else {

					$(".error-form").show();
					$(".text-error").html("Movimiento no Disponible");

					setTimeout(function(){
						$(".error-form").fadeOut(3000);
					}, 1500);

					return false;	
				}

				formData.append('tipo_crud', tipo_crud);
				formData.append('valor', valor);
				formData.append('idcatalogo_monederos_electronicos_encriptado', idcatalogo_monederos_electronicos_encriptado);
				formData.append('name_tarjeta', name_tarjeta);
				formData.append('type_tarjeta', type_tarjeta);
				formData.append('nip', nip);
				formData.append('idempleados', idempleados);
				formData.append('mes', mes);
				formData.append('anio', anio);
				formData.append('cvv', cvv);
				formData.append('activar_desactivar', activar_desactivar);
				formData.append('comentarios', comentarios);
				formData.append('fecha_creacion', fecha_creacion);


				/*				for (var value of formData.values()) {
					console.log(value);
				}*/

				//return false;
				
				$.ajax({

					type: "POST",
					url: link_ajax,
					data: formData,
					processData: false,
					contentType: false,
					cache: false,
					beforeSend: function(){
						$(".container-loading-ajax").show();
					},
					success : function(json) {

						console.log(json);

						if (json.trim() == 1) {

							$(".listo-form").show();
							$(".text-listo").html("<b>Datos Guardados Correctamente</b>");

							setTimeout(function(){
								$(".listo-form").fadeOut(1000);
							}, 1500);


						}else {

							$(".error-form").show();
							$(".text-error").html(json);

							setTimeout(function(){
								$(".error-form").fadeOut(3000);
							}, 1500);
						}

						$(".container-loading-ajax").hide();
						MostrarContenido();
						MostrarBitacora();

					},
					error : function(xhr, status) {

						$(".error-form").show();
						$(".text-error").html("Disculpe, existió un problema");

						setTimeout(function(){
							$(".error-form").fadeOut(1000);
						}, 1500);
					}

				});





			}



		</script>






	</body>
	</html>