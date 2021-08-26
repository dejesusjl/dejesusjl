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
		
		<!-- Bootstrap Material DatePicker CSS
			<link rel="stylesheet" type="text/css" href="../../js/jquery.datetimepicker.css"/>
		<link rel="stylesheet" href="../../plugins/Datepicker/jquery.datetimepicker.css">
		<link rel="stylesheet" href="../../plugins/Datepicker/bootstrap-material-datetimepicker.css">-->

		<!-- Bootstrap Material DatePicker JS-->
		<script src="../../plugins/Datepicker/material.min.js"></script>
		<script src="../../plugins/Datepicker/moment-with-locales.min.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" type="text/css" href="estilos_Generar_Logistica.css">

		<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/classic.css">
		<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/classic.date.css">
		<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/classic.time.css">

		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
  
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

		<style>			
			input[type=number]::-webkit-inner-spin-button, 
			input[type=number]::-webkit-outer-spin-button { 
			  -webkit-appearance: none; 
			  margin: 0; 
			}
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
			/*/ Mi Radio Button/*/
			.content-input input,
			.content-select select{
				appearance: none;
				-webkit-appearance: none;
				-moz-appearance: none;
			}
			 
			.content-input input{
				visibility: hidden;
				position: absolute;
				right: 0;
			}
			.content-input{
				position: relative;
				margin-bottom: 10px;
				padding:12px 5px 1px 5px; /* Damos un padding de 60px para posicionar 
			        el elemento <i> en este espacio*/
				display: block;
			}
			 
			/* Estas reglas se aplicarán a todos las elementos i 
			después de cualquier input*/
			.content-input input + i{
			       background: #f0f0f0;
			       border:2px solid rgba(0,0,0,0.2);
			       position: absolute; 
			       left: 50;
			}
			 
			/* Estas reglas se aplicarán a todos los i despues 
			de un input de tipo checkbox*/
			.content-input input[type=checkbox ] + i{
				width: 35px;
				height: 20px;
				border-radius: 10px;
			}

			/*
			Creamos el círculo que aparece encima de los checkbox
			con la etqieta before. Importante aunque no haya contenido
			debemos poner definir este valor.
			*/
			.content-input input[type=checkbox] + i:before{
				content: ''; /* No hay contenido */
				width: 17px;
				height: 17px;
				background: #fff;
				border-radius: 75%;
				position: absolute;
				z-index: 1;
				left: 0px;
				top: 0px;
				-webkit-box-shadow: 3px 0 3px 0 rgba(0,0,0,0.2);
				box-shadow: 3px 0 3px 0 rgba(0,0,0,0.2);
			}
			.content-input input[type=checkbox]:checked + i:before{
				left: 15px;
				-webkit-box-shadow: -3px 0 3px 0 rgba(0,0,0,0.2);
				box-shadow: 3px 0 -3px 0 rgba(0,0,0,0.2);
			}
			 
			.content-input input[type=checkbox]:checked + i{
			 background: #2AC176;
			}
			.content-input input[type=checkbox] + i:after{
				content: 'SI';
				position: absolute;
				font-size: 10px;
				color: rgba(255,255,255,0.6);
				top: 0px;
				left: 1px;
				opacity: 0 /* Ocultamos este elemento */;
				transition: all 0.25s ease 0.25s;
			}
			 
			/* Cuando esté checkeado cambiamos la opacidad a 1 y lo mostramos */
			.content-input input[type=checkbox]:checked + i:after{
			 opacity: 1;
			}
		</style>

	<title>CCP | Monitoreo</title>
	<script src="monitoreo_logistica.js"></script>
	</head>
	<body>
		<div class="container-fluid p-0">
			<?php include_once "menu.php";?>

			<div class="error-form" style="background: rgba(255, 255, 255, 0.4); width: 100%; height: 100vh; position: fixed; z-index: 9999; top: 0; display: none;">
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
			<a href="#inicio" id="inicioRef"></a>
			<a href="#buscador" id="buscadorRef"></a>
			<a  id="inicio"></a>

			<div class="col-sm-9 col-xs-12 content pt-3 p-0"><div class="row mt-3 m-0"><div class="col-sm-12">
				<div class="mt-1 mb-3 p-3 button-container fondo-container">
					<ol class="breadcrumb fondo-encabezados">
						<li><a href="index.php" class="text-white">Inicio</a></li><span class="text-white"> &nbsp;/&nbsp; </span>
						<li><a href="agregar_orden_logistica.php" class="text-white">Agregar Nueva Orden</a></li><span class="text-white"> &nbsp;/&nbsp; </span>
						<li  class="active text-white"><strong>Monitoreo</strong></li>
					</ol>
					<div class="col-sm-12" id="search_vehicle"><a  id="buscador"></a> 
						<h3 class="mt-4 m-b" style="font-size: 20px; border-bottom: 2px solid #882439; color: #d43759;"><strong>Vehículo</strong></h3>

						<div class="container-bg-1 p-3"><div class="row"><div class="col-sm-12">							
							<div class="d-flex align-items-center flex-wrap mb-2" >
								<label class="mb-0 mr-2">Buscar VIN</label>
								<div id="clean_vin" class="container-iconos-1" href="#inicio">
									<i class="fa fa-trash-o" aria-hidden="true" id="clean_vin"></i>
								</div>
							</div>												
							<input placeholder="Buscar VIN" class="form-control" type="text" name="busqueda_herramienta" id="busqueda_herramienta" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_vin();" size="19" width="300%"/>
							<center>
								<div id="resultadoBusquedaherramienta" class="container-busquedas-1 mt-4 efecto-busqueda" style="display : none" >
									
								</div>
							</center>
						</div></div></div>
					</div>


					<div class="col-sm-12" id="search_vehicle"><a  id="buscador"></a> 
						<div class="container-bg-1 p-3"><div class="col-sm-12" ><div class="row">
							<div class="col-sm-2" >
								<label>VIN </label>                                          
								<input class="form-control" type="text" id="vin_box" name="vin_herramienta"  readonly="" minlength="8" maxlength="8" onKeyUp="mayus(this);"  />
							</div>

							<div class="col-sm-3">
								<label>Marca</label>
								<input class="form-control" type="text" id="marca_box" name="marca_herramienta" readonly="" onKeyUp="mayus(this);" />
							</div> 

							<div class="col-sm-5">
								<label>Versión</label>
								<input class="form-control" type="text" id="version_box" name="version_herramienta" readonly="" onKeyUp="mayus(this);" />

							</div>  

							<div class="col-sm-2">
								<label>Color</label>                                          
								<input class="form-control" type="text" id="color_box" name="color_herramienta" readonly="" onKeyUp="mayus(this);" />

							</div>

							<div class="col-sm-2">
								<label>Modelo</label>                                          
								<input class="form-control" type="text" id="modelo_box" name="modelo_herramienta" readonly="" />
								
							</div>	
							<div class="col-sm-2">
								<label>Tipo</label>                                          
								<input class="form-control" type="text" id="estatus_box" name="tipo_herramienta" readonly="" />
							</div>	
							<div class="col-sm-2">
								<label>Responsable</label>                                          
								<input class="form-control" type="text" id="responsable_box" name="tipo_herramienta" readonly="" />
							</div>	
							<div class=" col-sm-4">
								<label class="content-input">Rendimiento: <span><a href="https://www.gob.mx/conuee/documentos/rendimiento-de-combustible-en-vehiculos-ligeros-de-venta-en-mexico"  target="_blank" title="Consulta rendimientos"><i class="fas fa-external-link-alt"></i></a>&nbsp;</span>Modificar?<input type="checkbox" name="Vehiculo" id="modSi" value="modSi"><i></i> </label> 
									
									<!--<input class="radio1" name="mod" id="modSi"  required="">-->
								<input class="form-control" type="text" id="Rendimiento" name="Rendimiento" onKeyUp='Refresh();'  readonly="" />
								
							</div>
							

							<div class='col-sm-2'>
							    <label>Combustible: &nbsp; <a href='http://www.gasolinamx.com/estado/estado-de-mexico/acambay-de-ruiz-castaneda'  target='_blank' title='Consulta el precio de la gasolina'><i class='fas fa-gas-pump'></i></a>
							    </label>
								<input  type='number' name='precio_gas' id='precio_gas' onKeyUp='Refresh();' min="1" class='form-control' readonly="">
							</div>

						</div></div></div></div>
						<div class="col-sm-12" id="muestraDatos">
						<div class="col-sm-4" id="FechasSepara"></div>
						<div class="container-bg-1 p-3"><div class="col-sm-12" ><div class="row">
							<div class="col-sm-12" id='FechasSelect' style='display: none'>
								<label>Carga de Combustible:</label>
									<span><select id="autosRuta" name="autosRuta" class="col-sm-2 form-control">
										<option selected="true">Fecha De Carga</option>
									</select></span>

							</div>	
									
							<div class="col-sm-12">
								<table id="rellename" class="display">
							    <thead>
							        <tr>
							            <th></th>
							            <th></th>
							        </tr>
							    </thead>
							    <tbody>
							        <tr>
							            <td></td>
							            <td></td>
							        </tr>
							        <tr>
							            <td></td>
							            <td></td>
							        </tr>
							    </tbody>
							</table>
								<!--<input type='text' class="form-control" id="fecha_hora_programada" />-->
							</div>		

						</div></div></div>

					</div>

				</div>
			</div></div></div>

			<?php include_once '../footer.php';?>
		</div>


				<!--ESTILOS DEL FIN-->
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
		<!--<script src="../../js/jquery.datetimepicker.full.js"></script><script async defer	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKNm5FUjlIYRpuH8aquS6q-7NzQdlAwgc&libraries=places&callback=initMap"></script>-------------------------------------
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
		<script src="../../plugins/Datepicker/bootstrap-material-datetimepicker.js"></script>
		<script src="../../plugins/Datepicker/es-mx.min.js"></script>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">


<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>



<script src="../../plugins/Datepicker/bootstrap-material-datetimepicker.js"></script>-->
<script src="../../plugins/Datepicker/es-mx.min.js"></script>



<script src="../../datapicker_moder/lib/compressed/picker.js"></script>
<script src="../../datapicker_moder/lib/compressed/picker.date.js"></script>
<script src="../../datapicker_moder/lib/compressed/picker.time.js"></script>
	</body>

</html>
<!--
//9319
//1207.55
//08:19
//km 141759

-------------------------------------------------------

--------------------------------------------------------// start Logica PseudoCodigo ///

	->Buscar VIN = que tenga: | balance_gastos_operacion = CARGA DE COMBUSTIBLE && tipo_movimiento=cargo order by fecha_guardado desc [monto_total, columna2(buscarFecha->orden_logistica),datos_vin]

	////->buscarFecha= | fecha_llegada_destino desde orden_logistica

	->buscarProximaFechaCarga = | Busca en balane de gastos todas las CARGAS y ordena por fecha -> busca la fecha seleccionada donde [tipo_movimiento=cargo] regresa la siguiente si hay, si no hay tomar la del dia de hoy

	->buscar todas las logisticas del NIV en orden_logistica_unidades

	-> Busca Ordenes de Logistica en el intervalo de FechaInicio y FechaFin con el VIN seleccionado  en orden_logistica_unidades
		->Por cada ordenLogistica encontrada verifica que ya tenga hora_real_resolucion
			->sacar los km que ha recorrido en cada ordenLogistica[]
			->sumar km, calcular km que se cargaron, comparar.

---------------------------------------------------------// end PseudoCodigo   ///

-------------           seleccionar las ordenes de las fechas que se ocupen         -------- 
				ya son todas las ordenes de un VIN en deacuerdo a una carga de combustible

SELECT * FROM 
inventario i JOIN balance_gastos_operacion bg ON i.vin_numero_serie=bg.datos_vin JOIN orden_logistica_unidades olu ON bg.datos_vin=olu.vin JOIN orden_logistica ol ON olu.idorden_logistica=ol.idorden_logistica 
WHERE i.visible='SI' and 
bg.concepto='CARGA DE COMBUSTIBLE' and 
bg.tipo_movimiento='cargo' and
bg.datos_vin='JB115595' and bg.columna2='8417';

------------------------------------------metodo en bruto-------
select i.marca, i.version, i.color, i.vin_numero_serie, i.estatus_unidad, bg.monto_total, bg.columna2, ol.fecha_llega_destino
from inventario i, balance_gastos_operacion bg, orden_logistica_unidades olu, orden_logistica ol
where 
bg.datos_vin=i.vin_numero_serie and 
bg.datos_vin=olu.vin and 
bg.columna2=ol.idorden_logistica and
i.visible='SI' and 
bg.concepto='CARGA DE COMBUSTIBLE' and 
bg.tipo_movimiento='cargo' and
bg.datos_vin='JB115595' and bg.columna2='8417' ;

---------------------------  //   -------------------------------------------------
Obtener VIN  y todas las ordenes de logistica que haya cargado combustible
al selecionar una obten la orden de logistica de carga, monto y vin del vehiculo


VIN=JB115595				
ordenLogistica=8417
monto=1170.7
---------------
SELECT 
	i.vin_numero_serie, i.marca, i.version, i.modelo, i.color, i.estatus_unidad,
	bg.monto_total, bg.columna2 as 'idordenlogistica', bg.fecha_creacion,
	ol.idorden_logistica, ol.fecha_salida, ol.fecha_llega_destino, ol.coordenadas_origen, ol.ubicacion_destino, ol.kilometros
FROM 
	inventario i JOIN balance_gastos_operacion bg ON i.vin_numero_serie=bg.datos_vin JOIN orden_logistica ol ON bg.columna2=ol.idorden_logistica 
WHERE 
	i.visible='SI' and 
	bg.concepto='CARGA DE COMBUSTIBLE' and bg.visible='SI' and
	bg.tipo_movimiento='cargo' and ol.fecha_salida <> 'null'
	order by fecha_salida desc ;

---------------------------------------------------------------------------------
Teniendo todas las ordenes de un vin que haya cargado combistuble
	pide la fecha que quieres buscar cuando cargo
	ordena la consulta anterior y selecciona unicamente la fecha siguiente, si no hay toma la del dia de la consulta guardalas en:
	 fechaCarga & fechaCargaProx.

	 Hacer siguiente consulta ya teniendo datos del vehiculo, orden de logistica de carga y fechas
--------------------
SELECT 
	i.vin_numero_serie, i.marca, i.version, i.modelo, i.color, i.estatus_unidad,
	bg.monto_total, bg.columna2 as 'idordenlogistica', bg.fecha_creacion,
	ol.idorden_logistica, ol.fecha_salida, ol.fecha_llega_destino, ol.coordenadas_origen, ol.ubicacion_destino, ol.kilometros
FROM 
	inventario i JOIN balance_gastos_operacion bg ON i.vin_numero_serie=bg.datos_vin JOIN orden_logistica_unidades olu ON bg.datos_vin=olu.vin 
	JOIN orden_logistica ol ON olu.idorden_logistica=ol.idorden_logistica 
WHERE 
	i.visible='SI' and 
	bg.concepto='CARGA DE COMBUSTIBLE' and bg.visible='SI' and
	bg.tipo_movimiento='cargo' and
	bg.datos_vin='JB115595' and bg.columna2='8417' and
	ol.fecha_llega_destino between '2021-03-08 14:31:39' and '2021-03-12 12:14:43' and
	olu.visible='SI' order by fecha_salida asc;
-------------------------------------------------
FechaCarga= 2021-03-08 14:31:39 	
	idorden_logistica				kilometros
O1= 	8417
/O2= 	8489						->88.1
/O3= 	8491						->130
/O4= 	8558						->83.6
/O5= 	8562						->5.6
/O6= 	8564						->5.6
O7= 	8575						->146
/O8= 	8557						->16.5
O9= 	8579						->146 	->estatus=solicitud
O10 = 	8587						->2.9
FechaProxCarga= 2021-03-12 12:14:43

PrecioGas=22;
rendimiento=16.2 km/l
totalGastados= 624.3km 	->	38.53 lts
totalCargados= 858.6km	->	53 lts

-----------------------------------------------------------------\\
-----------------------------------------------------------------//
idinv / Rendimiento km/l
1826 - 17.10
2228 - 9.4
2426 - 7.21 -> 13.87l/100km
2566 - 10.4
2609 - 10.4
2617 - 9.4
2632 - 9.62 -> 10.4l/100km
2677 - 5.81 -> 22km/g
2717 - 15.3
2773 - 19.1
2822 - 10.4
2832 - 17.4
2921 - 18.4
2930 - 18.4
3027 - 14.5
3080 - 16.7
3174 - 14.5
3224 - 8.08  -> 12.38 l/100 kms
3279 - 17.4
3288 - 9.4 
3300 - 9
3302 - 9
3415 - 16.7
3516 - 6.36 -> 15.73 l/100 km
3524 - 17.8
3588 - 17.5
3811 - 7.69 -> 13,0 l/100 km



INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '7.21', '2426', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '10.4', '2566', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '10.4', '2609', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '9.4', '2617', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '9.62', '2632', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '5.81', '2677', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '15.3', '2717', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '19.1', '2773', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '10.4', '2822', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '17.4', '2832', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '18.4', '2921', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '18.4', '2930', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '14.5', '3027', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '16.7', '3080', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '14.5', '3174', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '8.08', '3224', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '17.4', '3279', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '9.4', '3288', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '9', '3300', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '9', '3302', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '16.7', '3415', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '6.36', '3516', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '17.8', '3524', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '17.5', '3588', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '7.69', '3811', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '9.4', '2228', 'utilitaria', 'SI');
INSERT INTO `panamotors_des`.`inventario_dinamico` (`columna`, `contenido`, `idinventario`, `tipo_unidad`, `visible`) VALUES ('rendimiento', '9.4', '2228', 'utilitaria', 'SI');-->