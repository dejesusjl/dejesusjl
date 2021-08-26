	<?php 
		session_start();  
		include_once "../../config.php"; 
		require_once('../../bdd.php');
		include_once('../../funciones_principales.php');
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
		//---------Inicia Logística -------------------------------------------------
	?>

	<!DOCTYPE html>
	<html lang="es">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="description" content="" >
		<meta name="author" content="">
		<meta name="keywords" content="">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta charset="utf-8">
		<meta name="description" content="" >
		<meta name="author" content="">
		<meta name="keywords" content="">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!--Meta Responsive tag-->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!--Bootstrap CSS-->
		<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
		<!--Custom style.css-->
		<link rel="stylesheet" href="../../assets/css/quicksand.css">
		<link rel="stylesheet" href="../../assets/css/alert_popup.css">
		<link rel="stylesheet" href="../../assets/css/style.css">
		<!--Font Awesome-->
		<link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css">
		<link rel="stylesheet" href="../../assets/css/fontawesome.css">
		<!--Slick Carousel CSS-->
		<link rel="stylesheet" href="../../assets/css/slick/slick.css">
		<link rel="stylesheet" href="../../assets/css/slick/slick-theme.css">
		<!--Rating Bars-->
		<link rel="stylesheet" href="../../assets/css/fontawesome-stars.css">
		<!--Datatable-->
		<link rel="stylesheet" href="../../assets/css/dataTables.bootstrap4.min.css">
		<!--Bootstrap Calendar-->
		<link rel="stylesheet" href="../../assets/js/calendar/bootstrap_calendar.css">
		<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
		<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
		<script src="../../js/jquery-3.1.1.min.js"></script>
		<link href="../../css/tics.css" rel="stylesheet">
		<!-- Favicon -->
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
		<script src="../../js/jquery-3.1.1.min.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

		<!-- DataTables CSS -->
		<link href="../../plugins/datatables/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

		<!-- DataTables Responsive CSS -->
		<link href="../../plugins/datatables/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="../../js/jquery-1.10.2.js"></script>
		<script src="../../js/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="../../js/jquery.datetimepicker.css"/>

		<!-- Bootstrap Material DatePicker CSS-->
		<link rel="stylesheet" href="../../plugins/Datepicker/jquery.datetimepicker.css">
		<link rel="stylesheet" href="../../plugins/Datepicker/bootstrap-material-datetimepicker.css">

		<!-- Bootstrap Material DatePicker JS-->
		<script src="../../plugins/Datepicker/material.min.js"></script>
		<script src="../../plugins/Datepicker/moment-with-locales.min.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" type="text/css" href="estilos_Generar_Logistica.css">

		<title>CCP | Generar Orden</title>

		<style>			
			.sugerencias_vin:hover{
				background-color: #adadad;
				cursor:default; 
			}
			.option_id_logistica_generar:hover{
				background-color: #adadad;
				cursor:default; 
			}

			.sugerencias_tarjetas:hover{
				background-color: #adadad;
				cursor:default; 
			}

			.c-iconos-ubicacion{
				margin-top: 160px;
			}
			.c-perfilT{
				position: relative;
			}
			.c-perfilT .icon{
				position: relative;
				text-align: center;
				z-index: 2;
			}
			.c-perfilT .icon:before{
				content: '';
				position: absolute;
				width: 100px;
				height: 20px;
				border-radius: 50%;
				background: #3a3a3a;
				left: 50%;
				transform: translateX(-50%);
				bottom: -20px;
				z-index: 1;
			}
			.c-perfilT .icon i.iubicacion{
				text-align: center;
				font-size: 100px;
				transform: translateY(0px) rotateY(0deg);
			}
			.c-perfilT:hover .icon i.iubicacion{
				animation: animateiUbicacion 2s linear infinite;
			}
			@keyframes animateiUbicacion{
				0%{
				transform: translateY(-20px) rotateY(0deg);
				}100%{
					transform: translateY(-20px) rotateY(360deg);
				}
			}
			.c-perfilT .icon .imgT{
				position: absolute;
				width: 45px;
				height: 45px;
				left: 50%;
				top: 15px;
				transform: translateX(-50%);
				border-radius: 50%;
			}
			.c-perfilT:hover .icon .imgT{
				animation: animateiUbicacion2 2s linear infinite;
			}
			@keyframes animateiUbicacion2{
				0%{
					transform: translateX(-50%) translateY(-20px) rotateY(0deg);
				}
				100%{
					transform: translateX(-50%) translateY(-20px) rotateY(360deg);
				}
			}
			.c-perfilT .icon .tDestino{
				position: absolute;
				top: -140px;
				left: 50%;
				transform: translateX(-50%) scale(0);
				background: #3a3a3a;
				padding: 10px 20px;
				color: #fff;
				font-size: 12px;
				transition: .5s;
				width: 140px;
			}
			.c-perfilT .icon .tDestino:before{
				content: '';
				position: absolute;
				width: 10px;
				height: 10px;
				transform: rotate(45deg) translateX(-50%);
				background: #3a3a3a;
				bottom: -8px;
				left: 50%;
			}
			.c-perfilT:hover .icon .tDestino{
				transform: translateX(-50%) scale(1);
			}
			.c-perfilT .nombreT p{
				color: #fff;
				position: relative;
				z-index: 3;
			}
			.c-perfilT .ondasT{
				position: absolute;
				width: 40px;
				height: 10px;
				border-radius: 50%;
				border: 1px solid #000;
				bottom: 25px;
				left: 50%;
				opacity: 0;
				visibility: hidden;
				transform: translateX(-50%);
			}
			.c-perfilT:hover .ondasT{
				bottom: 40px;
				opacity: 1;
				visibility: visible;
				animation: animateOndas 1s linear infinite alternate;
			}
			@keyframes animateOndas{
				0%{
					bottom: 25px;
					opacity: 0;
					visibility: hidden;
					}
				100%{
						bottom: 40px;
						opacity: 1;
						visibility: visible;
				}
			}
			.c-perfilT .ondasT:before, .c-perfilT .ondasT:after{
				content: '';
				position: absolute;
				border-radius: 50%;
				border: 1px solid #000;
				left: 50%;
				transform: translateX(-50%);
			}
			.c-perfilT .ondasT:before{
				width: 30px;
				height: 7px;
				bottom: -5px;
			}
			.c-perfilT .ondasT:after{
				width: 20px;
				height: 4px;
				bottom: -8px;
			}
			.iubicacionR{
				background: linear-gradient(#F00B0B,#9D0606);					
			}
			.iubicacionV{
				background: linear-gradient(#15bf88,#154c36);
			}
			.iubicacionD{
				background: linear-gradient(#828282,#1f1f1f); 
			}
			.iubicacionR, .iubicacionV, .iubicacionD{
				-webkit-background-clip: text;
				-webkit-text-fill-color: transparent;
			}
			.imganimada{
				position: relative;
			}
			#imgCarretera{
				width: 100%;
				position: absolute;
				top: 0px;
				height: 120px;
			}
			.content-imgCarro{
				position: relative;
				left: 0;
				width: 200px;
				transition: 2s;
			}
			.content-imgCarro #imgCar{
				margin-left: 0px;
				transition: 2s;
				width: 250px;
				/* transform: scaleX(-1); */
				transform: scaleX(1);
			}
			.content-imgCarro #imgCarL1{
				position: absolute;
				left: 38px;
				top: 50px;
				width: 48px;
				transition: 2s;			
			}
			#imgCarL1.animateL, #imgCarL2.animateL{
				animation: animatellanta 1.5s linear;
			}
			@keyframes animatellanta{
				0%{
					transform: rotate(0deg);
					}100%{
						transform: rotate(360deg);
					}
			}
			.content-imgCarro #imgCarL2{
				position: absolute;
				left: 184px; 
				top: 52px;
				width: 48px;
				transition: 2s;
			}
			#imgCarL1.animateL2, #imgCarL2.animateL2{
				animation: animatellanta2 1.5s linear;
			}
			@keyframes animatellanta2{
				0%{
					transform: rotate(0deg);
				}
				100%{
					transform: rotate(-360deg);
				}
			}

			@media only screen and (max-width: 991px){
				.content-c-perfilT:nth-child(5), .content-c-perfilT:nth-child(6), .content-c-perfilT:nth-child(7), .content-c-perfilT:nth-child(8){
					margin-top: 150px;
				}
				.c-perfilT .icon .tDestino{
					transform: translateX(-50%) scale(1);
				}
				.c-perfilT .ondasT{
					animation: animateOndas 1s linear infinite alternate;
				}
				.c-perfilT .icon i.iubicacion{
					animation: animateiUbicacion 2s linear infinite;
				}
				.c-perfilT .icon .imgT{
					animation: animateiUbicacion2 2s linear infinite;
				}
			}

			@media only screen and (max-width: 767px){
				.content-c-perfilT:nth-child(4){
					margin-top: 150px;
				}
			}
			@media only screen and (max-width: 575px){
				.content-c-perfilT:nth-child(4), .content-c-perfilT:nth-child(5), .content-c-perfilT:nth-child(6), .content-c-perfilT:nth-child(7), .content-c-perfilT:nth-child(8){
					margin-top: auto;
				}
				#imgCarretera{
					height: 90px;
				}
				.content-imgCarro #imgCar{
					width: 200px;
				}
				.content-imgCarro #imgCarL1{
					left: 30px;
					top: 42px;
					width: 40px;	
				}
				.content-imgCarro #imgCarL2{
					left: 146px; 
					top: 44px;
					width: 40px;
				}
			}
			@media only screen and (max-width: 575px){
				.c-iconos-ubicacion{
					margin-top: 20px;
				}
				.c-perfilT{
					margin-top: 100px;
				}
				.c-perfilT .icon .tDestino{
					top: -90px;
				}

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
			.alert-success{
				background: #08a25a;
				border: none;
				color: #FFFFFF;
			}
			.alert-danger{
				background: #b13249;
				border: none;
				color: #FFFFFF;
			}
			
			.contador_span {
				float: right;
				color: #882439;
				font-style: italic;
			}
		</style>


	</head>


	<body>
		<div class="container-fluid p-0">
			<?php include_once "menu.php"; 	?>

			<a href="#origen" id="regresa"></a>
			<a href="#traza" id="recorrido" ></a>

			<div class="error-form" style="background: rgba(255, 255, 255, 0.8); width: 100%; height: 100vh; position: fixed; z-index: 9999; top: 0; display: none;">
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

							<a name="vehiculo"></a>

							<ol class="breadcrumb fondo-encabezados">
								<li>
									<a href="index.php" class="text-white">Inicio</a>
								</li>
								<span class="text-white"> &nbsp;/&nbsp; </span>
								<li>
									<a href="orden_logistica_resumen.php" class="text-white">Resúmen Ordenes Logística</a>
								</li>
								<span class="text-white"> &nbsp;/&nbsp; </span>
								<li  class="active text-white">
									<strong>Agregar Nueva Orden</strong>
								</li>
							</ol>

							
							<div class="col-sm-12" id="search_vehicle"  > 
								<h3 class="mt-4 m-b" style="font-size: 20px; border-bottom: 2px solid #882439; color: #d43759;"><strong>Vehículo</strong></h3>

								<div class="container-bg-1 p-3">
									<div class="row">
										<div class="col-sm-12">	
											<div class="d-flex align-items-center flex-wrap mb-2" >
												<label class="mb-0 mr-2" for="busqueda_herramienta">Buscar VIN</label>
												<div id="clean_vin" class="container-iconos-1" href="#vehiculo">
													<i class="fa fa-trash-o" aria-hidden="true" id="clean_vin"></i>
												</div>
											</div>												
											<input placeholder="Buscar VIN" class="form-control" type="text" name="busqueda_herramienta" id="busqueda_herramienta" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_herramienta();" size="19" width="300%"/>
											<center>
												<div id="resultadoBusquedaherramienta" class="container-busquedas-1 mt-4 efecto-busqueda" style="display: none;" ></div>
											</center>
										</div>

										<div class="col-sm-4" >
											<a  id="origen"></a>
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
											
										</div>	
										<div class="col-sm-4">
											<label>Tipo</label>                                          
											<input class="form-control" type="text" id="tipo_herramienta" name="tipo_herramienta" readonly="" />
										</div>	
										<div class="col-sm-4">
											<label>Rendimiento</label>                                          
											<input class="form-control" type="text" id="Rendimiento" name="Rendimiento" readonly="" />
											
										</div>											
									</div>								
								</div>

<!--------
								<div class="col-sm-12" id="show_rol_vin_adicional" >

													<div class="col-sm-12 mt-4">
														<center>
															<a id='create_vin' style='width: 180px;height: 90px;' class="create_vin icon-DOrden" class="" title="Add field"><i class='fa fa-plus-circle fa-5x zoom font-iconr' aria-hidden='true' ></i></a>
															<div class="tooltipDetalleOrden mb-3">
																<p>Agregar VIN</p>
															</div>
														</center>
													</div>

													<div class="col-sm-12 field_wrapper_vin" id="show_vin_adicional">

													</div>

											<input id="aux_vin" type="hidden" value="0" readonly>
											<input id="count_vin" type="hidden" value="0" readonly>
											<input id="count_principal_vin" type="hidden" value="0" readonly>

								</div>
---->





							</div>
							
							<div class="col-sm-12" id="show_origen_id"  style="display: none;"> 

								<h3 class="mt-4 m-b" style="font-size: 20px; border-bottom: 2px solid #882439; color: #d43759;"><strong>Datos Logística</strong></h3>

								<div class="col-sm-12 container-bg-1 p-3">
									<div class="d-flex align-items-center flex-wrap mb-2">
										<label class="mb-0 mr-2" for="">*Buscar Origen</label>
										<div id="clean_start" class="container-iconos-1">
											<i class="fa fa-trash-o" aria-hidden="true"></i>
										</div>
									</div>

									<p class="d-flex flex-wrap align-items-center">
										<?php 
											$query_puntos_origen = "SELECT * FROM orden_logistica_puntos where visible = 'SI' ";
											$result_puntos_origen = mysql_query($query_puntos_origen);

											while ($row_puntos_origen = mysql_fetch_array($result_puntos_origen)) {

												if (trim($row_puntos_origen[columna_a]) == "Todos") {

													echo "
													<b class='mr-1'>$row_puntos_origen[nombre_punto]</b>
													<input type='radio' class='$row_puntos_origen[nombre_punto]_origen radio1 mr-4' name='punto_origen'>
													";

													echo "	<script>
																$('.$row_puntos_origen[nombre_punto]_origen').click(function() {
																	if ($('.$row_puntos_origen[nombre_punto]_origen').is(':checked')) {
																		$('#start').val('$row_puntos_origen[ubicacion]');
																	}
																});
															</script>";
												}else{
													$porcion_origen = explode(";", trim($row_puntos_origen[columna_a]));
													foreach ($porcion_origen as $key_origen => $autorizado_origen) {
														if ($autorizado_origen == $empleados) {
															echo "
																<b class='mr-1'>$row_puntos_origen[nombre_punto]</b>
																<input type='radio' class='$row_puntos_origen[nombre_punto]_origen radio1 mr-4' name='punto_origen'>";

															echo "	<script>
																		$('.$row_puntos_origen[nombre_punto]_origen').click(function() {
																			if ($('.$row_puntos_origen[nombre_punto]_origen').is(':checked')) {
																				$('#start').val('$row_puntos_origen[ubicacion]');
																			}
																		});
																	</script>";
														}
													}
												}
											}

											echo "	<b>Mi Ubicación</b>
													<input type='radio' class='miubicacionorigen radio1' name='punto_origen'> &nbsp;&nbsp;";
										?>

									</p>
									<input type="text" id="start" name="start" class="form-control">
								</div>
							</div>

							<div class="col-sm-12 mt-2" id="show_destino_id" style="display: none;">

								<div class="col-sm-12 container-bg-1 p-3">
									<div class="d-flex align-items-center flex-wrap mb-2">
										<label class="mb-0 mr-2" for="">*Buscar Destino</label>
										<div id="clean_end" class="container-iconos-1">
											<i class="fa fa-trash-o" aria-hidden="true"></i>
										</div>
									</div>
									<p class="d-flex flex-wrap align-items-center">
										<?php 
											$query_puntos_destino = "SELECT * FROM orden_logistica_puntos where visible = 'SI' ";
											$result_puntos_destino = mysql_query($query_puntos_destino);

											while ($row_puntos_destino = mysql_fetch_array($result_puntos_destino)) {

												if (trim($row_puntos_destino[columna_a]) == "Todos") {

													echo "
														<b class='mr-1'>$row_puntos_destino[nombre_punto]</b>
														<input type='radio' class='$row_puntos_destino[nombre_punto]_destino radio1 mr-4' name='punto_destino'>";

													echo "	<script>
																$('.$row_puntos_destino[nombre_punto]_destino').click(function() {
																	if ($('.$row_puntos_destino[nombre_punto]_destino').is(':checked')) {
																			$('#end').val('$row_puntos_destino[ubicacion]');
																	}
																});
															</script>";

												}else{
													$porcion_destino = explode(";", trim($row_puntos_destino[columna_a]));

													foreach ($porcion_destino as $key_destino => $autorizado_destino) {
														if ($autorizado_destino == $empleados) {
															echo "
																<b class='mr-1'>$row_puntos_destino[nombre_punto]</b>
																<input type='radio' class='$row_puntos_destino[nombre_punto]_destino radio1 mr-4' name='punto_destino'> ";

															echo "	<script>

																		$('.$row_puntos_destino[nombre_punto]_destino').click(function() {
																			if ($('.$row_puntos_destino[nombre_punto]_destino').is(':checked')) {
																				$('#end').val('$row_puntos_destino[ubicacion]');
																			}
																		});
																	</script>";
														}
													}
												}
											}

											echo "<b>Mi Ubicación</b>
											<input type='radio' class='miubicaciondestino radio1' name='punto_destino'> &nbsp;&nbsp;";
										?>

									</p>
									<input type="text" id="end" name="end" class="form-control">
								</div>
							</div>

							<div class="col-sm-12 mt-4 mb-4" id="button_origen_destino" style="display: none;">

								<div class="col-sm-12 p-0">
									<center>
										<input type="button" class="btn btn-lg btn-primary" id="sencilla" value="Calcula Distancia" onclick="validarRuta(1); ">
										<input type="hidden" id="search" onclick="validarFormulario();">
									</center>
								</div>
							</div>

							<a id="traza"></a>
						<div id="ruta">
							

							<div class="col-sm-12 mt-4 mb-4" id="show_datos_recorrido" style="display: none;">								
								<div class="col-sm-12 container-bg-1 p-3">
										<div class="row">											
											<?php
													$data = file_get_contents("http://www.gasolinamx.com/precio-gasolina");
													 
													if ( preg_match('|<td>Magna</td>\s+<td>(.*?)</td>|is' , $data , $cap ) )
													{
													    echo "
													    <div class='col-sm-2'>
														    <label>Combustible:</label>
															<input  type='number' name='precio_gas' id='precio_gas' value='$cap[1]' onKeyUp='calculayrefresca(0);' class='form-control'>
														</div>
													    <div class='col-sm-3' name='Magna' ><label>Magna: ".$cap[1]."</label>
													    		<input type='radio' class='gasolina1 radio1' name='combustible'  checked='checked' required='' value='$cap[1]'>
													    		<input type='hidden' value='$cap[1]' id='Magna' >

													    </div>";

													}
													if ( preg_match('|<td>Premium</td>\s+<td>(.*?)</td>|is' , $data , $cap ) )
													{
													    echo "<div class='col-sm-3' name='Premium'><label>Premium: ".$cap[1]."</label>
													    	<input type='radio' class='gasolina2 radio1' name='combustible'   required='' value='$cap[1]'>

													    	<input type='hidden' value='$cap[1]' id='Premium' >

													    </div>";
													}
													if ( preg_match('|<td>Diésel</td>\s+<td>(.*?)</td>|is' , $data , $cap ) )
													{
													    echo "<div class='col-sm-3' name='Diesel'><label>Diésel: ".$cap[1]."</label>
													    		<input type='radio' class='gasolina3 radio1' name='combustible'   required='' value='$cap[1]'>

													    		<input type='hidden' value='$cap[1]' id='Diesel' >

													    </div>";
													}
												?>
											
										
									</div>
									<div class="row">
										<div class="col-sm-2">
											<label>Distancia:</label>
											<input type="text" class="form-control" name="kilometros" id="kilometros" readonly="" >
										</div>
										<div class="col-sm-2">
											<label>Tiempo Estimado:</label>
											<input type="text" class="form-control" name="timeall" id="timeall" readonly="" >
										</div>

										<div class="col-sm-2">
											<label>Rendimiento del Vehiculo:</label>
											<input type="text" class="form-control" name="kml" id="kml" readonly="" >
										</div>

										<div class="col-sm-2">
											<label>
												Litros Estimados:
											</label>
											<input type="text" class="form-control" name="gas" id="gas" readonly="" >
										</div>

										<div class="col-sm-2">
											<label>Costo Total:</label>
											<input type="text" class="form-control" name="costo" id="costo" readonly="" >
										</div>

										<div class="col-sm-2">
											<label>Velocidad Constante Sugerida:</label>
											<input type="text" class="form-control" name="velocidad" id="velocidad" readonly="" >
										</div>
									</div>
								</div>
							</div>

<!-------------------------------------->


<!--------------------------------------------->
	<div class="col-sm-12" id="map_id" >

	<iframe id="frameMapa"
    title="Inline Frame Example"
    	width="100%" 
    	style="border:none;
    	display:block;
    	height:100vh;    	
    	"
    	scrolling="yes"
    	seamless="seamless"
    src="mi_mapa.php"
    ></iframe>
    <!--height:100vh;-->
    </div>


							<div class="col-sm-12" id="map_id" style="display: none;">
								<div class="col-sm-12 p-0">
									<div id="map"></div>
								</div>
							</div>


							<div class="col-sm-12 mt-4" id="cuerpo_origen_id" style="display: none;">

								<div class="col-sm-12">
									<h3 class="m-t-none m-b" style="font-size: 20px; border-bottom: 2px solid #882439; color: #d43759;"><strong>Domicilio Origen</strong></h3>
								</div>

								<div class="row m-0 container-bg-1 p-1 mb-3">
									<div class="col-sm-4">										
										<label>Estado</label>
										<input type="text" class="form-control" name="estado_o" id="estado_o" readonly="" />
									</div>								

									<div class="col-sm-4">
										<label>Municipio</label>
										<input type="text" id="municipio_o" name="municipio_o" class="form-control" readonly="" />
									</div>

									<div class="col-sm-4">
										<label>Colonia</label>
										<input type="text" id="colonia_o" name="colonia_o" class="form-control" readonly="" />

									</div>

									<div class="col-sm-4">									
										<label>Calle y Número</label>
										<input type="text" id="calle_o" name="calle_o" class="form-control" readonly="" />									
									</div>

									<div class="col-sm-4">
										<label>Código Postal</label>
										<input type="text" class="form-control" name="cpo" id="cpo" readonly="" />
									</div>

									<div class="col-sm-4">
										<label>Coordenadas Origen</label>
										<input type="text" id="coordenadas_origen" name="coordenadas_origen" class="form-control" readonly="" />
									</div>
								</div>															
							</div>


							<div class="col-sm-12" id="cuerpo_destino_id" style="display: none;">

								<div class="col-sm-12"  style="display: none;">
									<h3 class="m-t-none m-b" style="font-size: 20px; border-bottom: 2px solid #882439; color: #d43759;"><strong>Domicilio Destino</strong></h3>
								</div>

								<div class="row m-0 container-bg-1 p-1 mb-3">
									<div class="col-sm-4">
										<label>Estado</label>
										<input type="text" class="form-control" name="estado_d" id="estado_d" readonly="" />
									</div>

									<div class="col-sm-4">
										<label>Municipio</label>
										<input type="text" id="municipio_d" name="municipio_d" class="form-control" readonly="" />
									</div>

									<div class="col-sm-4">
										<label>Colonia</label>
										<input type="text" id="colonia_d" name="colonia_d" class="form-control" readonly="" />
									</div>

									<div class="col-sm-4">
										<label>Calle y Número</label>
										<input type="text" id="calle_d" name="calle_d" class="form-control" readonly="" />
									</div>

									<div class="col-sm-4">
										<label>Código Postal</label>
										<input type="text" class="form-control" name="cpd" id="cpd" readonly="" />
									</div>

									<div class="col-sm-4">
										<label>Coordenadas Origen</label>
										<input type="text" id="coordenadas_destino" name="coordenadas_destino" class="form-control" readonly="" />
									</div>
								</div>
							</div>

							<input type="hidden" name="fecha_solicitud" id="fecha_solicitud" value="<?php echo "$fecha_solicitud"; ?>">
							<input type="hidden" id="id_asesor" name="id_asesor" >
							<input type="hidden" id="tipo_solicitante" name="tipo_solicitante" > 
							<input type="hidden" id="id_informante" name="id_informante" > 
							<input type="hidden" id="tipo_informante" name="tipo_informante" > 
							<input type="hidden" id="ubicacion_real" name="ubicacion_real"> 
						</div>


						<?php 
							include_once '../footer.php';
						?>


					</div>
				</div>


				<script src="../../assets/js/popper.min.js"></script>
				<script src="../../assets/js/bootstrap.min.js"></script>
				<script src="../../assets/js/sweetalert.js"></script>
				<script src="../../assets/js/progressbar.min.js"></script>
				<script src="../../assets/js/charts/canvas.min.js"></script>
				<script src="../../assets/js/calendar/bootstrap_calendar.js"></script>
				<script src="../../assets/js/calendar/demo.js"></script>
				<script src="../../assets/js/jquery.dataTables.min.js"></script>
				<script src="../../assets/js/dataTables.bootstrap4.min.js"></script>
				<script src="../../plugins/datatables/datatables-responsive/dataTables.responsive.js?<?php echo $random; ?>"></script>
				<script src="../../assets/js/custom.js"></script>
				<script src="../../js/jquery.datetimepicker.full.js"></script>
				<script>
					
				function initMap() {
					var directionsService = new google.maps.DirectionsService;
					var directionsDisplay = new google.maps.DirectionsRenderer;
					var geocoder = new google.maps.Geocoder;
					var iniciolatlong;
					var map = new google.maps.Map(document.getElementById('map'), {
						zoom: 13,
						center: {lat: 19.933038, lng: -99.842245},
						styles: [
							{ elementType: "geometry", stylers: [{ color: "#242f3e" }] },
							{ elementType: "labels.text.stroke", stylers: [{ color: "#242f3e" }] },
							{ elementType: "labels.text.fill", stylers: [{ color: "#746855" }] },
							{
								featureType: "administrative.locality",
								elementType: "labels.text.fill",
								stylers: [{ color: "#d59563" }],
							},
							{
								featureType: "poi",
								elementType: "labels.text.fill",
								stylers: [{ color: "#d59563" }],
							},
							{
								featureType: "poi.park",
								elementType: "geometry",
								stylers: [{ color: "#263c3f" }],
							},
							{
								featureType: "poi.park",
								elementType: "labels.text.fill",
								stylers: [{ color: "#6b9a76" }],
							},
							{
								featureType: "road",
								elementType: "geometry",
								stylers: [{ color: "#38414e" }],
							},
							{
								featureType: "road",
								elementType: "geometry.stroke",
								stylers: [{ color: "#212a37" }],
							},
							{
								featureType: "road",
								elementType: "labels.text.fill",
								stylers: [{ color: "#9ca5b3" }],
							},
							{
								featureType: "road.highway",
								elementType: "geometry",
								stylers: [{ color: "#746855" }],
							},
							{
								featureType: "road.highway",
								elementType: "geometry.stroke",
								stylers: [{ color: "#1f2835" }],
							},
							{
								featureType: "road.highway",
								elementType: "labels.text.fill",
								stylers: [{ color: "#f3d19c" }],
							},
							{
								featureType: "transit",
								elementType: "geometry",
								stylers: [{ color: "#2f3948" }],
							},
							{
								featureType: "transit.station",
								elementType: "labels.text.fill",
								stylers: [{ color: "#d59563" }],
							},
							{
								featureType: "water",
								elementType: "geometry",
								stylers: [{ color: "#17263c" }],
							},
							{
								featureType: "water",
								elementType: "labels.text.fill",
								stylers: [{ color: "#515c6d" }],
							},
							{
								featureType: "water",
								elementType: "labels.text.stroke",
								stylers: [{ color: "#17263c" }],
							},
						],
					});

					//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					var originInput = document.getElementById('start');
					var destinationInput = document.getElementById('end');
					var originAutocomplete = new google.maps.places.Autocomplete(originInput);
					originAutocomplete.setFields(['place_id']);
					var destinationAutocomplete = new google.maps.places.Autocomplete(destinationInput);
					destinationAutocomplete.setFields(['place_id']);
					//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

					var iniciolatlong;
					var finlatlong;
					directionsDisplay.setMap(map);


						

					document.getElementById('search').addEventListener('click', function() {
						$("#recorrido").get(0).click();
						$("#show_datos_recorrido").show();
						$("#ruta").show();

						calculateAndDisplayRoute(directionsService, directionsDisplay);

						var start = $("#start").val();
						var end = $("#end").val();

						if(start != "" && end != ""){
							$("#fecha_hora_programada").focus(2000);
							$("#imgCar, #imgCarL1, #imgCarL2, #imgCarretera").show();
							$(".content-imgCarro").css("left","80%");	
							$("#imgCarL1, #imgCarL2").addClass("animateL");
							$("#imgCarL1, #imgCarL2").removeClass("animateL2");

							function myFunction(m360) {
								if(m360.matches){
									$(".content-imgCarro").css("left","32%");
								} else if(m480.matches){
									$(".content-imgCarro").css("left","38%");
								} else if (m688.matches){
									$(".content-imgCarro").css("left","56%");
								} else if (m767.matches){
									$(".content-imgCarro").css("left","60%");
								} else if (m1024.matches){
									$(".content-imgCarro").css("left","60%");
								} else if (m1280.matches){
									$(".content-imgCarro").css("left","65%");
								}
							}

							var m360 = window.matchMedia("(max-width: 360px)");
							var m480 = window.matchMedia("(max-width: 480px)");
							var m688 = window.matchMedia("(max-width: 688px)");
							var m767 = window.matchMedia("(max-width: 767px)");
							var m1024 = window.matchMedia("(max-width: 1024)");
							var m1280 = window.matchMedia("(max-width: 1280px)");

							myFunction(m360); // Se llama a la funcion y se ejecuta
							m360.addListener(myFunction); // Adjunta la funcion para cambios de estado

							$("#map_id").show();


							$("#cuerpo_origen_id").show();


							$("#cuerpo_destino_id").show();

						} else {
							$("#imgCar, #imgCarL1, #imgCarL2, #imgCarretera").hide();
						}
					});
					/*/
					document.getElementById('search2').addEventListener('click', function() {
						$("#recorrido").get(0).click();
						$("#show_datos_recorrido").show();
						$("#ruta").show();

						calculateAndDisplayRoute(directionsService, directionsDisplay);

						var start = $("#start").val();
						var end = $("#end").val();

						if(start != "" && end != ""){
							$("#fecha_hora_programada").focus(2000);
							$("#imgCar, #imgCarL1, #imgCarL2, #imgCarretera").show();
							$(".content-imgCarro").css("left","80%");	
							$("#imgCarL1, #imgCarL2").addClass("animateL");
							$("#imgCarL1, #imgCarL2").removeClass("animateL2");

							function myFunction(m360) {
								if(m360.matches){
									$(".content-imgCarro").css("left","32%");
								} else if(m480.matches){
									$(".content-imgCarro").css("left","38%");
								} else if (m688.matches){
									$(".content-imgCarro").css("left","56%");
								} else if (m767.matches){
									$(".content-imgCarro").css("left","60%");
								} else if (m1024.matches){
									$(".content-imgCarro").css("left","60%");
								} else if (m1280.matches){
									$(".content-imgCarro").css("left","65%");
								}
							}

							var m360 = window.matchMedia("(max-width: 360px)");
							var m480 = window.matchMedia("(max-width: 480px)");
							var m688 = window.matchMedia("(max-width: 688px)");
							var m767 = window.matchMedia("(max-width: 767px)");
							var m1024 = window.matchMedia("(max-width: 1024)");
							var m1280 = window.matchMedia("(max-width: 1280px)");

							myFunction(m360); // Se llama a la funcion y se ejecuta
							m360.addListener(myFunction); // Adjunta la funcion para cambios de estado

							$("#map_id").show();


							$("#cuerpo_origen_id").show();


							$("#cuerpo_destino_id").show();

							$("#show_detalle_solicitud").show();

						} else {
							$("#imgCar, #imgCarL1, #imgCarL2, #imgCarretera").hide();
						}
					});/*/
				}

				//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function(position) {

						var latitud_1 = position.coords.latitude;
						var longitud_1 = position.coords.longitude;
						var coordenadas_1 = latitud_1 + " " + longitud_1;

						$("#ubicacion_real").val(coordenadas_1);

						$(".miubicacionorigen").click(function(){
							console.log("ubicacion origen");

							if ($(".miubicacionorigen").is(':checked')) {
								$("#start").val(coordenadas_1);
							}
						});

						$(".miubicaciondestino").click(function(){

							if ($(".miubicaciondestino").is(':checked')) {
								$("#end").val(coordenadas_1);
							}
						});

					}, function() {
						handleLocationError(true, infoWindow, map.getCenter());
					});
				} else {

					handleLocationError(false, infoWindow, map.getCenter());
				}
				var km = 0;
				var dur = 0;
				var dur2 =0;
				var kml=0;
				var vel=0;
				var gas=0;
				var cost=0;

				var redondo=1;



				function calculayrefresca(desactiva) {
					kml=unidad_rendimiento;
					gas=(km/kml).toFixed(2);
					cost=((document.getElementById("precio_gas").value)*gas).toFixed(2);
					if (desactiva==0){
						$('.gasolina1').removeAttr('checked');
						$('.gasolina2').removeAttr('checked');
						$('.gasolina3').removeAttr('checked');	
						document.getElementById("gas").value = gas + " lts";
						document.getElementById("costo").value ="$ " + cost  ;


						inicio=document.getElementById("coordenadas_origen").value ;
						fin=document.getElementById("coordenadas_destino").value;
						url=document.getElementById("frameMapa").src;
						document.getElementById("frameMapa").src=url+"&inicio="+inicio+"&fin="+fin;

						url=document.getElementById("frameMapa").src;
						document.getElementById("frameMapa").src=url+"&precio="+(document.getElementById("precio_gas").value);
						alert(document.getElementById("frameMapa").src);
						//document.getElementById("frameMapa").location.reload();
					}else{	

										
						document.getElementById("gas").value = gas + " lts";
						document.getElementById("costo").value ="$ " + cost  ;
						url=document.getElementById("frameMapa").src;
						document.getElementById("frameMapa").src=url+"&precio="+(document.getElementById("precio_gas").value);

						inicio=document.getElementById("coordenadas_origen").value ;
						fin=document.getElementById("coordenadas_destino").value;
						url=document.getElementById("frameMapa").src;
						document.getElementById("frameMapa").src=url+"&inicio="+inicio+"&fin="+fin;
						alert(document.getElementById("frameMapa").src);
						//document.getElementById("frameMapa").location.reload();
					}
				}


				function calculateAndDisplayRoute(directionsService, directionsDisplay) {
					const waypts = [];
					var inicio="";
					var fin="";
					if (redondo==2) {
							inicio=document.getElementById('start').value
							fin=document.getElementById('start').value
							waypts.push({
					            location: document.getElementById('end').value,
					            stopover: false,
				            });
					}else{
						inicio=document.getElementById('start').value
						fin=document.getElementById('end').value
					}
					
					var geocoder = new google.maps.Geocoder;
					directionsService.route({
						origin: inicio,
						destination: fin,
						waypoints: waypts,
      					optimizeWaypoints: false,
						travelMode: 'DRIVING'
					}, function(response, status, results) {
						if (status === 'OK') {
							directionsDisplay.setDirections(response);
							var route = response.routes[0];

							// For each route, display summary information.
							for (var i = 0; i < route.legs.length; i++) {
								var routeSegment = i + 1;
								//direccion_inicial.innerHTML += routeSegment;

								km = parseFloat(route.legs[i].distance.text);
								dur = route.legs[i].duration.text;
								dur2 =route.legs[i].duration.value;
								kml=unidad_rendimiento;
								vel=(km/(dur2/3600)).toFixed(0);
								gas=(km/kml).toFixed(2);
								cost=((document.getElementById("precio_gas").value)*gas).toFixed(2);

								var iniciolatlong = route.legs[route.legs.length-1].start_location.lat() + ", " + route.legs[route.legs.length-1].start_location.lng();								
								var finlatlong = route.legs[route.legs.length-1].end_location.lat() + ", " + route.legs[route.legs.length-1].end_location.lng();

								var startadd =route.legs[i].start_address;
								var endadd =route.legs[i].end_address;


								document.getElementById("timeall").value = dur  ;     
								document.getElementById("kilometros").value = km  + " km";
								document.getElementById("kml").value = kml + " km/l";
								document.getElementById("velocidad").value = vel  + " km/h";
								document.getElementById("gas").value = gas + " lts";
								document.getElementById("costo").value ="$ " + cost  ; 
								document.getElementById("coordenadas_origen").value = iniciolatlong  ;
								document.getElementById("coordenadas_destino").value = finlatlong  ;
								//document.getElementById("frameMapa").src="mi_mapa.php?inicio="+iniciolatlong+"&fin="+finlatlong;

								//inicio de dirección 

								var latlngStr = iniciolatlong.split(',', 2);
								var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};

								var latlngStrd = finlatlong.split(',', 2);
								var latlngd = {lat: parseFloat(latlngStrd[0]), lng: parseFloat(latlngStrd[1])};

								var country, postal_code, locality, sublocality, routex, long_name, political, street_number;
								var countryd, postal_coded, localityd, sublocalityd, routexd, long_named, politicald, street_numberd;

								geocoder.geocode({'location': latlng }, function(results, status) {
									if (status === 'OK') {
										if (results[0]) {

											for (i = 0; i < results[0].address_components.length; ++i) {
												var component = results[0].address_components[i];


												if (!country && component.types.indexOf("country") > -1)
													country = component.long_name;

												else if (!sublocality && component.types.indexOf("sublocality") > -1)
													sublocality = component.long_name;

												else if (!locality && component.types.indexOf("locality") > -1)
													locality = component.long_name;

												else if (!postal_code && component.types.indexOf("postal_code") > -1)
													postal_code = component.long_name;

												else if (!routex && component.types.indexOf("route") > -1)
													routex = component.long_name;

												else if (!political && component.types.indexOf("political") > -1)
													political = component.long_name;

												else if (!street_number && component.types.indexOf("street_number") > -1)
													street_number = component.long_name;
											}


											if (political !=undefined) {

												document.getElementById("estado_o").value = political  ;
												$("#estado_o").css("border-color","#e5e6e7");
												$("#estado_o").attr("readonly","readonly");
											}else{
												document.getElementById("estado_o").value = political  ;
												$("#estado_o").removeAttr("readonly","readonly");
												$("#estado_o").css("border-color","red");
											}


											if (locality !=undefined) {


												document.getElementById("municipio_o").value = locality  ;
												$("#municipio_o").css("border-color","#e5e6e7");
												$("#municipio_o").attr("readonly","readonly");

											}else{

												document.getElementById("municipio_o").value = locality  ;
												$("#municipio_o").removeAttr("readonly","readonly");
												$("#municipio_o").css("border-color","red");
											}
											var inici = iniciolatlong.toString();

											if (postal_code !=undefined) {

												document.getElementById("cpo").value = postal_code  ;

												$("#cpo").css("border-color","#e5e6e7");
												$("#cpo").attr("readonly","readonly");
											}else{
												var cordenadas_o =$("#coordenadas_origen").val();




												if (inici == "19.9330005, -99.84209720000001") {
													document.getElementById("cpo").value ="50333";
													$("#cpo").css("border-color","#e5e6e7");
													$("#cpo").attr("readonly","readonly");

												}else if(inici == "19.9330716, -99.84209779999999"){
													document.getElementById("cpo").value ="50333 ";
													$("#cpo").css("border-color","#e5e6e7");
													$("#cpo").attr("readonly","readonly");
												}else if(inici == "19.8150689, -99.8715253"){
													document.getElementById("cpo").value ="50457 ";
													$("#cpo").css("border-color","#e5e6e7");
													$("#cpo").attr("readonly","readonly");
												}else if(inici == "19.8150689, -99.87152530000003"){
													document.getElementById("cpo").value ="50450 ";
													$("#cpo").css("border-color","#e5e6e7");
													$("#cpo").attr("readonly","readonly");
												}else{
													document.getElementById("cpo").value = postal_code  ;
													$("#cpo").removeAttr("readonly","readonly");
													$("#cpo").css("border-color","red");
												}
											}

											if (sublocality !=undefined) {

												document.getElementById("colonia_o").value = sublocality  ;
												$("#colonia_o").css("border-color","#e5e6e7");
												$("#colonia_o").attr("readonly","readonly");

											}else{

												if (inici == "19.7937884, -99.86803079999999") {
													document.getElementById("colonia_o").value = "El Calvario";
													$("#colonia_o").css("border-color","#e5e6e7");
													$("#colonia_o").attr("readonly","readonly");
												}else if(inici == "19.8150689, -99.87152530000003"){
													document.getElementById("colonia_o").value = "Atlacomulco";
													$("#colonia_o").css("border-color","#e5e6e7");
													$("#colonia_o").attr("readonly","readonly");
												}else{
													document.getElementById("colonia_o").value = sublocality  ;
													$("#colonia_o").removeAttr("readonly","readonly");
													$("#colonia_o").css("border-color","red");
												}
											}

											if (street_number !=undefined) {

												document.getElementById("calle_o").value = routex + " Núm " + street_number ;
												$("#calle_o").css("border-color","#e5e6e7");
												$("#calle_o").attr("readonly","readonly");

											}else{
												document.getElementById("calle_o").value = routex + " Núm " + street_number ;
												$("#calle_o").removeAttr("readonly","readonly");
												$("#calle_o").css("border-color","red");
											}

										} else {

											$(".error-form").show();
											$(".text-error").html("No results found");

											setTimeout( function(){
												$(".error-form").fadeOut(1000);
											}, 1500);
										}
									} else {

										$(".error-form").show();
										$(".text-error").html("Geocoder failed due to: " + status);

										setTimeout( function(){
											$(".error-form").fadeOut(1000);
										}, 1500);
									}
													});

		geocoder.geocode({'location': latlngd }, function(results, status) {
			if (status === 'OK') {
				if (results[0]) {

					for (i = 0; i < results[0].address_components.length; ++i) {
						var component = results[0].address_components[i];


						if (!countryd && component.types.indexOf("country") > -1)
							countryd = component.long_name;

						else if (!sublocalityd && component.types.indexOf("sublocality") > -1)
							sublocalityd = component.long_name;

						else if (!localityd && component.types.indexOf("locality") > -1)
							localityd = component.long_name;

						else if (!postal_coded && component.types.indexOf("postal_code") > -1)
							postal_coded = component.long_name;

						else if (!routexd && component.types.indexOf("route") > -1)
							routexd = component.long_name;

						else if (!politicald && component.types.indexOf("political") > -1)
							politicald = component.long_name;

						else if (!street_numberd && component.types.indexOf("street_number") > -1)
							street_numberd = component.long_name;

					}

					if (politicald !=undefined) {
						document.getElementById("estado_d").value = politicald  ;
						$("#estado_d").css("border-color","#e5e6e7");
						$("#estado_d").attr("readonly","readonly");

					}else{
						$("#estado_d").removeAttr("readonly","readonly");
						$("#estado_d").css("border-color","red");
						document.getElementById("estado_d").value = politicald  ;
					}

					if (localityd !=undefined) {
						document.getElementById("municipio_d").value = localityd  ;
						$("#municipio_d").css("border-color","#e5e6e7");
						$("#municipio_d").attr("readonly","readonly");

					}else{
						$("#municipio_d").removeAttr("readonly","readonly");
						$("#municipio_d").css("border-color","red");
						document.getElementById("municipio_d").value = localityd  ;
					}


					var inici2 = finlatlong.toString();
					if (postal_coded !=undefined) {
						document.getElementById("cpd").value = postal_coded  ;
						$("#cpd").css("border-color","#e5e6e7");
						$("#cpd").attr("readonly","readonly");
					}else{

						if (inici2 == "19.9330005, -99.84209720000001") {
							document.getElementById("cpd").value = "50333";
							$("#cpd").css("border-color","#e5e6e7");
							$("#cpd").attr("readonly","readonly");
						}else if(inici2 == "19.9330716, -99.84209779999999"){

							document.getElementById("cpd").value = "50333";
							$("#cpd").css("border-color","#e5e6e7");
							$("#cpd").attr("readonly","readonly"); 
						}else if(inici2 == "19.8150689, -99.87152530000003"){

							document.getElementById("cpd").value = "50450";
							$("#cpd").css("border-color","#e5e6e7");
							$("#cpd").attr("readonly","readonly"); 
						}else{
							$("#cpd").removeAttr("readonly","readonly");
							$("#cpd").css("border-color","red");
							document.getElementById("cpd").value = postal_coded  ;
						}

					}
					if (sublocalityd !=undefined) {
						document.getElementById("colonia_d").value = sublocalityd  ;
						$("#colonia_d").css("border-color","#e5e6e7");
						$("#colonia_d").attr("readonly","readonly"); 

					}else{

						if (inici2 == "19.7937884, -99.86803079999999") {
							document.getElementById("colonia_d").value = "El Calvario";
							$("#colonia_d").css("border-color","#e5e6e7");
							$("#colonia_d").attr("readonly","readonly"); 
						}else if(inici2 == "19.8150689, -99.87152530000003"){
							document.getElementById("colonia_d").value = "Atlacomulco";
							$("#colonia_d").css("border-color","#e5e6e7");
							$("#colonia_d").attr("readonly","readonly"); 
						}else{
							$("#colonia_d").removeAttr("readonly","readonly");
							$("#colonia_d").css("border-color","red");
							document.getElementById("colonia_d").value = sublocalityd  ;
						}

					}
					if (street_numberd !=undefined) {
						document.getElementById("calle_d").value = routexd + " Núm " + street_numberd ;
						$("#calle_d").css("border-color","#e5e6e7");
						$("#calle_d").attr("readonly","readonly"); 

					}else{
						$("#calle_d").removeAttr("readonly","readonly");
						$("#calle_d").css("border-color","red");
						document.getElementById("calle_d").value = routexd + " Núm " + street_numberd ;
					}

				} else {

					$(".error-form").show();
					$(".text-error").html("No se han encontrado resultados");

					setTimeout( function(){
						$(".error-form").fadeOut(1000);
					}, 1500);
				}
			}else {

				$(".error-form").show();
				$(".text-error").html("El geocodificador falló debido a: " + status);

				setTimeout( function(){
					$(".error-form").fadeOut(1000);
				}, 1500);
			}
		});

		}
		} else {	

			$("#imgCar, #imgCarL1, #imgCarL2, #imgCarretera").hide();


		}
		});

		}
		</script>

		<script async defer	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKNm5FUjlIYRpuH8aquS6q-7NzQdlAwgc&libraries=places&callback=initMap"></script>
		<script src="generar_logistica.js"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
		<script src="../../plugins/Datepicker/bootstrap-material-datetimepicker.js"></script>
		<script src="../../plugins/Datepicker/es-mx.min.js"></script>
		<script>

			function habilitar_form() {

				var count_vin = $("#soy_vin").val();

				if (count_vin.length == 8) {

					$("#show_rol_vin_adicional").show();
					$("#show_origen_id").show();
					$("#show_destino_id").show();
					$("#button_origen_destino").show();
					var cadena = count_vin.toUpperCase();
					$("#soy_vin").val(cadena);

				}else {

					$("#show_rol_vin_adicional").hide();
					$("#show_origen_id").hide();
					$("#show_destino_id").hide();
					$("#button_origen_destino").hide();

				}
			}
			function validarRuta(tipo_viaje){
			    	if (tipo_viaje==1){
			    		redondo=1;
			    		
			    		$("#search").get(0).click();
			    		ini=$("#start").val();
			    		fin=$("#end").val();
			    		consumo = $("#Rendimiento").val();
			    		precio = document.getElementById("precio_gas").value;
			    		document.getElementById("frameMapa").src="mi_mapa.php?inicio="+ini+"&fin="+fin+"&consumo="+consumo+"&precio="+precio;
			    		
			    		//
			    		
			    		
			    		
			    		//alert(document.getElementById("frameMapa").src);
			    	//	document.getElementById("frameMapa").location.reload();
			    	}else{
			    		redondo=2;
			    		 $("#search").get(0).click();

			    	}
			    }

			function buscar_herramienta() {
				var textoBusquedaherramienta = $("#busqueda_herramienta").val();
				if (textoBusquedaherramienta != "") {
					$.post("buscar_vin_rendimiento.php", {valorHerramienta: textoBusquedaherramienta}, function(mensaje_herramienta) {
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
				unidad_rendimiento=porcion[7];

				if (unidad_httipo == "Indefinido") {
					
					$("#vin_herramienta").removeAttr("readonly","readonly");
				}

				$("#busqueda_herramienta").val("");
				$("#busqueda_herramienta").attr("href='#origen'");
				$("#tipo_herramienta").val(unidad_httipo);
				$("#vin_herramienta").val(unidad_htvin);
				$("#marca_herramienta").val(unidad_htmarca);
				$("#version_herramienta").val(unidad_htversion);
				$("#color_herramienta").val(unidad_htcolor);
				$("#modelo_herramienta").val(unidad_htmodelo);
				$("#Rendimiento").val(unidad_rendimiento);
				$("#resultadoBusquedaherramienta").hide();
				
				$("#show_origen_id").show();				
				$("#show_destino_id").show();
				$("#button_origen_destino").show();
						
					$("#regresa").get(0).click();
					//


			});

			$(document).ready(function(){

				$('#clean_vin').click(function(){
					$("#busqueda_herramienta").val("");
					$("#tipo_herramienta").val("");
					$("#vin_herramienta").val("");
					$("#marca_herramienta").val("");
					$("#version_herramienta").val("");
					$("#color_herramienta").val("");
					$("#modelo_herramienta").val("");
					$("#Rendimiento").val("");					
					$("#show_origen_id").hide();				
					$("#show_destino_id").hide();
					$("#button_origen_destino").hide();
					$("#button_origen_destino").hide();
					$("#ruta").hide();
					//alert($(this).attr('id'))
				})



			 	$(".gasolina1").click(function() {

			        if ($(".gasolina1").is(':checked')) {
			        	//magna
			        	var comb=document.getElementById('Magna').value;

			        	//alert(comb);
			        	document.getElementById("precio_gas").value=comb;
			        	calculayrefresca(1);
			        }

			    });
			    $(".gasolina2").click(function() {

			        if ($(".gasolina2").is(':checked')) {
			        	//premium
			        	var comb=document.getElementById('Premium').value;
			        	//alert(comb);
						document.getElementById("precio_gas").value=comb;
			        	calculayrefresca(2);

			        }

			    });
			    $(".gasolina3").click(function() {

			        if ($(".gasolina3").is(':checked')) {
			        	//diesel
			        	 var comb=document.getElementById('Diesel').value;
			        	//alert(comb);
						document.getElementById("precio_gas").value=comb;
			        	calculayrefresca(3);

			        }

			    });

			    

					
				
			})
			// your custom function
var routeReadyHandler = function () {
    console.log("length=" + this.totalDistance);
    console.log("minutes=" + this.totalTime);
    console.log("fuelAmount=" + this.fuelAmount);
    console.log("fuelCost=" + this.fuelCost);
    console.log("fuelPrice=" + this.fuelPrice);
    console.log("fuelConsumption=" + this.fuelConsumption);
    console.log("customizedCost=" + this.customizedCost);
};

// assign function to widget
if (typeof RoutePlannerWidget === "undefined") {
    var allScriptTags = document.getElementsByTagName("script");
    for (var i = 0; i < allScriptTags.length; i++) {
        if (
            allScriptTags[i].hasAttribute("src")
            &&
            allScriptTags[i].getAttribute("src").endsWith("/widget/v1/client.js")
        ) {
            allScriptTags[i].addEventListener('load', function(){
                RoutePlannerWidget.prototype.routeReady = routeReadyHandler;
            });
        }
    }
} else {
    RoutePlannerWidget.prototype.routeReady = routeReadyHandler;
}
	
		</script>

	</body>
</html>