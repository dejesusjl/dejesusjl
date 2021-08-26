<?php
session_start();
include_once "../../config.php";
include_once "../../recuperar_usuario.php";
date_default_timezone_set('America/Mexico_City');
$hoy_validar_fecha_caducidad_cookie = date("Y-m-d H:i:s");
$_SESSION['usuario_clave'] = base64_decode($_COOKIE['ser']);
$_SESSION['empleados'] = base64_decode($_COOKIE['727ef72b3185358e1425e7d37e9a81b4']);

$rol_global = "100";

if (isset($_COOKIE['727ef72b3185358e1425e7d37e9a81b4'])) {
	$_SESSION['usuario_clave'] = base64_decode($_COOKIE['ser']);
	$usuario_creador = $_SESSION['usuario_clave'];
	$_SESSION['empleados'] = base64_decode($_COOKIE['727ef72b3185358e1425e7d37e9a81b4']);
	$empleados = $_SESSION['empleados'];
	$sql3 = "SELECT * FROM usuarios where visible='SI' AND rol='$rol_global' AND idempleados='$empleados' AND idusuario='$usuario_creador'";
	$result3 = mysql_query($sql3);
	if (mysql_num_rows($result3) == 0) {
		$_SESSION['usuario_clave'] = null;
		$_SESSION['empleados'] = null;
		$_SESSION['usuario_clave'] = "";
		$_SESSION['empleados'] = "";
		setcookie("727ef72b3185358e1425e7d37e9a81b4", "", time() + 0);
		setcookie("ser", "", time() + 0);
		echo "
		<script language='javascript' type='text/javascript'> 
		alert('Usuario no encontrado');
		document.location.replace('../../direcionador_perfiles.php');
		</script>
		";
	} else {
		while ($fila3 = mysql_fetch_array($result3)) {
			$nombre_usuario = "$fila3[nombre_usuario]";
			$rol = "$fila3[rol]";
		}
	}

	$sql1 = "SELECT *FROM usuarios_empleados WHERE idempleados='$empleados' AND visible='SI'";
	$result1 = mysql_query($sql1);
	if (mysql_num_rows($result1) == 0) {
		$_SESSION['usuario_clave'] = null;
		$_SESSION['empleados'] = null;
		$_SESSION['usuario_clave'] = "";
		$_SESSION['empleados'] = "";
		setcookie("727ef72b3185358e1425e7d37e9a81b4", "", time() + 0);
		setcookie("ser", "", time() + 0);
		echo "
		<script language='javascript' type='text/javascript'> 
		alert('Usuario no encontrado');
		document.location.replace('../../logout.php');
		</script>
		";
	} else {
		while ($fila1 = mysql_fetch_array($result1)) {
			$fecha_caducidad_password = "$fila1[fecha_caducidad_password]";
		}
	}
} else {
	if (strlen($_SESSION['usuario_clave']) === 0) {
		$_SESSION['usuario_clave'] = null;
		$_SESSION['empleados'] = null;
		echo "
		<script language='javascript' type='text/javascript'> 
		alert('Sesión caducada. Ingresa nuevamente para continuar…');
		document.location.replace('../../direcionador_perfiles.php');
		</script>
		";
	} else {
		$_SESSION['usuario_clave'] = base64_decode($_COOKIE['ser']);
		$_SESSION['empleados'] = base64_decode($_COOKIE['727ef72b3185358e1425e7d37e9a81b4']);
		$empleados = $_SESSION['empleados'];
		$usuario_creador = $_SESSION['usuario_clave'];
		if (isset($_SESSION['usuario_clave'])) {

			$sql3 = "SELECT * FROM usuarios where visible='SI' AND rol='$rol_global' AND idempleados='$empleados' AND idusuario='$usuario_creador'";
			$result3 = mysql_query($sql3);
			if (mysql_num_rows($result3) == 0) {
				$_SESSION['usuario_clave'] = null;
				$_SESSION['empleados'] = null;
				$_SESSION['usuario_clave'] = "";
				$_SESSION['empleados'] = "";
				setcookie("727ef72b3185358e1425e7d37e9a81b4", "", time() + 0);
				setcookie("ser", "", time() + 0);
				echo "
				<script language='javascript' type='text/javascript'> 
				alert('Sesión caducada. Ingresa nuevamente para continuar…');
				document.location.replace('../../direcionador_perfiles.php');
				</script>
				";
			} else {
				while ($fila3 = mysql_fetch_array($result3)) {
					$rol = "$fila3[rol]";
				}
			}

			$sql1 = "SELECT *FROM usuarios_empleados WHERE idempleados='$empleados' AND visible='SI'";
			$result1 = mysql_query($sql1);
			if (mysql_num_rows($result1) == 0) {
				$_SESSION['usuario_clave'] = null;
				$_SESSION['empleados'] = null;
				$_SESSION['usuario_clave'] = "";
				$_SESSION['empleados'] = "";
				setcookie("727ef72b3185358e1425e7d37e9a81b4", "", time() + 0);
				setcookie("ser", "", time() + 0);
				echo "
				<script language='javascript' type='text/javascript'> 
				alert('Sesión caducada. Ingresa nuevamente para continuar…');
				document.location.replace('../../logout.php');
				</script>
				";
			} else {
				while ($fila1 = mysql_fetch_array($result1)) {
					$fecha_caducidad_password = $fila1[fecha_caducidad_password];
				}
			}
		} else {
			echo "
			<script language='javascript' type='text/javascript'> 
			alert('Sesión caducada. Ingresa nuevamente para continuar…');
			document.location.replace('../../direcionador_perfiles.php');
			</script>
			";
		}
	}
}



function minutos_transcurridos($fecha_i, $fecha_f)
{
	$minutos = (strtotime($fecha_i) - strtotime($fecha_f)) / 60;
	$minutos = abs($minutos);
	$minutos = floor($minutos);
	return $minutos;
}



$tiempo_restante = minutos_transcurridos($hoy_validar_fecha_caducidad_cookie, $fecha_caducidad_password);

if ($tiempo_restante <= 0) {
	$_SESSION['usuario_clave'] = null;
	$_SESSION['empleados'] = null;
	$_SESSION['usuario_clave'] = "";
	$_SESSION['empleados'] = "";
	setcookie("727ef72b3185358e1425e7d37e9a81b4", "", time() + 0);
	setcookie("ser", "", time() + 0);
	echo "
	<script language='javascript' type='text/javascript'> 
	alert('Sesión caducada. Ingresa nuevamente para continuar…');
	document.location.replace('../../logout.php');
	</script>
	";
}

$usuario_creador = $_SESSION['usuario_clave'];
$sql2 = "SELECT *FROM usuarios WHERE visible='SI' AND rol='$rol_global' AND idempleados='$empleados' AND idusuario='$usuario_creador'";
$result2 = mysql_query($sql2);
if (mysql_num_rows($result2) == 0) {
	$_SESSION['usuario_clave'] = null;
	$_SESSION['empleados'] = null;
	$_SESSION['usuario_clave'] = "";
	$_SESSION['empleados'] = "";
	setcookie("727ef72b3185358e1425e7d37e9a81b4", "", time() + 0);
	setcookie("ser", "", time() + 0);
	echo "
	<script language='javascript' type='text/javascript'> 
	alert('Usuario no encontrado');
	document.location.replace('../../direcionador_perfiles.php');
	</script>
	";
} else {
	while ($fila2 = mysql_fetch_array($result2)) {
		$noma = "$fila2[nombre_usuario]";
		$foto_perfil = "$fila2[foto_perfil]";
		$rol = "$fila2[rol]";
		$usuario_logueado = "$fila2[usuario]";
	}
}



$coordenadas = $_POST['lat_long'];




if ($rol == "100") {

	$sql6 = "SELECT * FROM usuarios WHERE visible='SI' AND rol='$rol_global' AND idempleados='$empleados' AND idusuario='$usuario_creador'";
	$result6 = mysql_query($sql6);
	if (mysql_num_rows($result6) == 0) {
		echo "<script language='javascript' type='text/javascript'> 
		alert('Cierra tus demas ventanas Por Favor');
		document.location.replace('../../direcionador_perfiles.php');
		</script>";
	} else {
		while ($fila6 = mysql_fetch_array($result6)) {
			$rol_obten = "$fila6[rol]";
		}
		if ($rol != $rol_obten) {
			echo "<script language='javascript' type='text/javascript'> 
			alert('Cierra tus demas ventanas Por Favor');
			document.location.replace('../../direcionador_perfiles.php');
			</script>";
		}
	}
} else {
	echo "<script language='javascript' type='text/javascript'> 
	alert('Estas Ingresando a un Perfil Diferente al asignado... Imposible darte Acceso');
	document.location.replace('../../direcionador_perfiles.php');
	</script>";
}






$sql = "SELECT * FROM empleados WHERE idempleados='$empleados' AND visible='SI'";
$resultado = mysql_query($sql);
while ($fila = mysql_fetch_array($resultado)) {

	$nombre_em = "$fila[nombre] $fila[apellido_paterno] $fila[apellido_materno]";
}

#-----------------------------------Logisticas Pendientes----------------------------------------------------------------

$query_logistica = "SELECT * FROM orden_logistica WHERE visible = 'SI' and idasigna =''";
$result_logistica = mysql_query($query_logistica);

$total_pendientes = mysql_num_rows($result_logistica);

#----------------------------------Actualizar Personal para poder asignarlos por los que no cierran logisticas-----------------------------------------------------------------

$query_empleados = "SELECT * FROM empleados WHERE visible = 'SI' and columna_a = 'En Ruta' and puesto_actual <> 'Ejecutivo de Traslado'";
$result_empleados = mysql_query($query_empleados);

if (mysql_num_rows($result_empleados) >= 1) {

	while ($row_empleados = mysql_fetch_array($result_empleados)) {

		$update_empleados = "UPDATE empleados SET columna_a = 'Disponible' WHERE idempleados = '$row_empleados[idempleados]'";
		$result_update = mysql_query(update_empleados);
	}
}
#-----------------------------------Verificamos si hay nuevas unidades utilitarias desde Inventario----------------------------------------------------------------
include_once "agregar_nuevo_utilitario.php";


?>

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

<style>
	.sugerencias {
		padding: 0px;
	}

	.sugerencias a {
		color: white;
	}

	.resultadoBusqueda {
		color: white;
	}

	.sugerencias:hover {
		background-color: #B6B5B5;
		cursor: default;
	}

	#contenedor-busqueda {
		position: absolute;
		left: 50%;
		transform: translateX(-50%);
		background: rgb(47, 47, 47);
		width: 50%;
		z-index: 1000;
	}

	#resultadoBusqueda {
		border: 0px outset gray;
		background-color: rgb(47, 47, 47);
		text-align: center;
		position: absolute;
		width: 100%;
		left: 50%;
		transform: translateX(-50%);

	}

	.text-noresults {
		color: #fff;
	}

	#resultadoBusqueda .sugerencias a {
		display: block;
		width: 100%;
		height: 100%;
		padding: 5px 0px;
		padding-left: 20px;
		text-align: left;
	}

	.icon-plus {
		color: #fff;
		cursor: pointer;
		width: 30px;
		height: 30px;
		border-radius: 50%;
		border: 1px solid #fff;
		line-height: 30px;
	}

	.icon-plus:hover {
		background: #882439;
		border: none;
	}

	@media screen and (max-width: 3500px) and (min-width: 900px) {
		#resultadoBusqueda {
			position: absolute;
		}
	}

	@media screen and (max-width: 900px) and (min-width: 750px) {
		#resultadoBusqueda {
			position: absolute;
		}
	}

	@media screen and (max-width: 750px) and (min-width: 20px) {
		#resultadoBusqueda {
			position: absolute;
		}
	}

	span.blue {
		background: #9B0009;
		border-radius: 0.8em;
		-moz-border-radius: 0.8em;
		-webkit-border-radius: 0.8em;
		color: #ffffff;
		display: inline-block;
		font-weight: bold;
		line-height: 1.6em;
		margin-right: 15px;
		text-align: center;
		width: 1.6em;
	}

	@media (max-width: 991px) {
		#contenedor-busqueda {
			width: 80%;
		}
	}

	@media (max-width: 480px) {
		#contenedor-busqueda {
			width: 100%;
		}
	}

	.card-busquedas {
		border: 1px solid #efefef;
		padding: 5px;
	}

	.busquedas-text-1 {
		/* background: #B03C54;  */
		padding: 5px;
		font-weight: bold;
		/* border-radius: 5px; 
		width: 100px; 
		color: #fff; */
	}

	/* .busquedas-text-2{
		font-weight: bold;
		} */
	.text-num-results {
		color: #dddddd;
	}

	/* .animation-busquedas-logistica{
			width: 100%; 
			height: 100%; 
			overflow: auto;
			background: #fff;
			position: fixed;
			z-index: -1;
			animation: animatebusquedaslogistica .5s linear;
		}
		@keyframes animatebusquedaslogistica{
			0%{
				height: 0%;
			} 100%{
				height: 100%;
			}
			} */
	/* #busquedas-logistica{
			animation: animatebusquedaslogistica .5s linear;
		}
		@keyframes animatebusquedaslogistica{
			0%{
				top: -100%;
			} 100%{
				top: 0;
			}
			} */
	#busquedas-logistica {
		top: -100vh;
		transition: .5s;
	}

	.mostrar-busquedas-logistica {
		top: 0 !important;
	}
</style>
<!--Header-->

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

<div id="busquedas-logistica" style="position: fixed; overflow: auto; height: 100vh; width: 100%; background: #fff; z-index: 9999; display: block;">
	<!-- <div class="animation-busquedas-logistica"></div> -->
	<div class="d-flex justify-content-end pr-4 py-2">
		<span class="icon-cerrarBusqueda2" style="font-size: 24px; cursor: pointer;"><i class="fas fa-times"></i></span>
	</div>
	<div>
		<div class="text-center">
			<h1 style="border-bottom: 1px solid #dadada;">Búsquedas Logística</h1>
			<h2 class="text-num-results" style="color: #fff; width: 300px; background: #2b2b2b; margin: auto; border-radius: 10px;"><span class="num-results"></span> Resultados</h2>
		</div>

		<div class="container">
			<div id="resultado-busqueda-logistica"></div>
		</div>
	</div>
</div>

<div class="row header shadow-sm m-0">

	<!--Logo-->
	<div class="col-sm-3 pl-0 text-center header-logo" style="display: flex;">
		<div style="width: 50%;">
			<div class="bg-theme pt-3 pb-2 mb-0">
				<h3 class="logo">
					<a href="#" class="text-secondary logo">
						<img src="../../img/logo_gran_pana.png" alt="" style="width: 80px;height: 80px;display: inline;">
						<br>
						CCP
					</a>
				</h3>
			</div>
		</div>
		<div class="mr-3" style="width: 50%; background: #333;">
			<div class="avatar text-center">
				<img src="<?php echo $foto_perfil; ?>" alt="" class="rounded-circle" />
				<p><?php echo ucwords("$usuario_logueado"); ?></p>
				<span class=" small" style="color:white;"><strong><?php echo $nombre_em; ?> </strong></span>
			</div>
		</div>
	</div>
	<!--Fin Logo-->

	<!--Header Menu-->
	<div class="col-sm-9 header-menu pt-2 pb-0">
		<div class="row m-0">

			<!--Menu Icons-->
			<div class="col-xl-2 col-lg-3 col-sm-4 col-8 pl-0">
				<!--Toggle sidebar-->
				<span class="menu-icon" onclick="toggle_sidebar()">
					<span id="sidebar-toggle-btn"></span>
				</span>
				<!--Toggle sidebar-->
				<!--Notification icon-->
				<div class="menu-icon">
					<a class="" href="#" onclick="toggle_dropdown(this); return false" role="button" class="dropdown-toggle">
						<i class="fa fa-bell"></i>
						<span class="badge">0</span>
					</a>
					<div class="dropdown dropdown-left bg-white shadow border">
						<a class="dropdown-item" href="#"><strong>Notificaciones</strong></a>
						<div class="dropdown-divider"></div>


						<div class="dropdown-divider"></div>
						<a class="dropdown-item text-center link-all" href="#">Ver Notificaciones</a>
					</div>
				</div>
				<!--Notication icon-->

				<!--Inbox icon-->
				<span class="menu-icon inbox">
					<a class="" href="#" role="button" id="dropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php if ($tiempo_restante <= 2880) : ?>
							<i class="fas fa-key fa-2x"></i>
							<span class="badge badge-danger">1</span>
						<?php else : ?>
							<i class="fas fa-key"></i>
							<span class="badge">0</span>
						<?php endif ?>
					</a>
					<div class="dropdown-menu dropdown-menu-left mt-10 animated zoomInDown" aria-labelledby="dropdownMenuLink3">
						<a class="dropdown-item" href="#"><strong>Key Acces</strong></a>

						<div class="dropdown-divider"></div>
						<?php if ($tiempo_restante <= 2880) : ?>
							<a href="generar_nueva_contrasenia.php" class="dropdown-item">
								<div class="media">
									<i class="fas fa-key fa-4x"></i>
									<div class="media-body">
										<h6 class="mt-0"><strong>Tu Key Access esta por expirar, favor de renovarla.</strong></h6>
										<p>Ver</p>
										<small class="text-success">Tiempo Restante: <?php echo $tiempo_restante; ?> minutos</small>
									</div>
								</div>
							</a>
						<?php endif ?>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item text-center link-all" href="#">Actualizar Contraseña</a>
					</div>
				</span>
				<!--Inbox icon-->
				<span class="menu-icon">
					<i class="fa fa-th-large"></i>
				</span>
			</div>
			<!--Menu Icons-->

			<!--Search box and avatar-->
			<div class="col-xl-10 col-lg-9 col-sm-12 text-right flex-header-menu justify-content-end p-0">

				<div class="col-xl-10 col-lg-8 col-sm-9 form-group mr-3">
					<input type="text" class="form-control" placeholder="Buscar" id="busqueda" onKeyUp="buscar();" />
				</div>
				<div class="col-xl-2 col-lg-4 col-sm-3 form-group mr-1 icon-select">
					<select class="form-control" name="buscador" id="buscador">
						<option value="logistica">Logística</option>
						<option value="Cliente">ID</option>
						<option value="vin">VIN</option>
						<option value="ejecutivo">Ejecutivo</option>
					</select>
				</div>

			</div>
		</div>

		<center>
			<div id="contenedor-busqueda" style="display: none;">
				<div style="text-align: right; padding-right: 10px; padding-top: 10px;"><i style="color: #fff; cursor: pointer;" class="fas fa-times" id="icon-cerrarBusqueda"></i></div>
				<div id="resultadoBusqueda" style="z-index:3; opacity:1; display: none;"></div>
			</div>
		</center>

	</div>
	<!--Header Menu-->
</div>
<!--Header-->


<!--Main Content-->

<div class="row main-content m-0">
	<!--Sidebar left-->
	<div class="col-sm-3 col-xs-6 sidebar pl-0">
		<div class="inner-sidebar mr-3">
			<!--Image Avatar-->

			<!--Image Avatar-->

			<!--Sidebar Navigation Menu-->




			<div class="sidebar-menu-container">
				<ul class="sidebar-menu mb-4">

					<li class="parent">
						<a href="index.php" class=""><i class="fa fa-home mr-3"></i>
							<span class="none">Inicio </span>
						</a>
					</li>

					<li class="parent">
						<a href="#" onclick="toggle_menu('logistic'); return false" class=""><i class="fas fa-map-marked-alt mr-3"> </i>
							<span class="none">Logística <i class="fas fa-route pull-right align-bottom"></i></span>
						</a>
						<ul class="children" id="logistic">

							<li class="child"><a href="orden_logistica_resumen_pendientes.php" class="ml-4"><i class="fas fa-calendar mr-2"></i> Programadas &nbsp;&nbsp;<span class="blue"><?php echo "$total_pendientes"; ?></span></a></li>
							<li class="child"><a href="buscador_logistica.php" class="ml-4"><i class="fas fa-list-ol mr-2"></i> Resumen Logísticas</a></li>
							<li class="child"><a href="agregar_orden_logistica.php" class="ml-4"><i class="fas fa-file-text mr-2"></i> Agregar Nueva Orden</a></li>

						</ul>
					</li>

					<li class="parent">
						<a href="#" onclick="toggle_menu('personal_logistica'); return false" class=""><i class="fas fa-users mr-3"></i>
							<span class="none">Colaboradores <i class="far fa-address-card pull-right align-bottom"></i></span>
						</a>
						<ul class="children" id="personal_logistica">

							<li class="child"><a href="liberar_personal.php" class="ml-4"><i class="fas fa-user-edit mr-2"></i> Liberar Personal</a></li>


						</ul>
					</li>

					<li class="parent">
						<a href="#" onclick="toggle_menu('unidades_utilitarias'); return false" class=""><i class="fas fa-car mr-3"></i>
							<span class="none">Unidades Utilitarias <i class="fas fa-cogs pull-right align-bottom"></i></span>
						</a>
						<ul class="children" id="unidades_utilitarias">

							<li class="child"><a href="detalle_utilitarias.php" class="ml-4"><i class="fas fa-truck-pickup mr-2"></i> Unidades</a></li>
							<li class="child"><a href="detalle_km_fuel.php" class="ml-4"><i class="fas fa-gas-pump mr-2"></i>KM | Combustible</a></li>


						</ul>
					</li>

					<li class="parent">
						<a href="#" onclick="toggle_menu('wallet_logistica'); return false" class=""><i class="fas fa-wallet mr-3"></i>
							<span class="none">Wallet por Logística <i class="fas fa-hand-holding-usd pull-right align-bottom"></i></span>
						</a>
						<ul class="children" id="wallet_logistica">

							<li class="child"><a href="entrega_recepcion_recurso.php" class="ml-4"><i class="fas fa-funnel-dollar mr-2"></i> Entrega Recepción de Recurso</a></li>
						</ul>
					</li>



					<li class="parent">
						<a href="#" onclick="toggle_menu('rend'); return false" class=""><i class="fas fa-tachometer-alt mr-3"> </i>
							<span class="none">Monitoreo del Rendimiento <i class="fas fa-route pull-right align-bottom"></i></span>
						</a>

						<ul class="children" id="rend">
							<li class="child"><a href="cotizador.php" class="ml-4"><i class="fas fa-hand-holding-usd"></i> Cotizador</a></li>
							<li class="child"><a href="monitoreo.php" class="ml-4"><i class="fas fa-tachometer-alt"></i> Monitoreo</a></li>

						</ul>
					</li>

					<li class="parent">
						<a href="#" onclick="toggle_menu('search_avanced'); return false" class=""><i class="fas fa-line-chart mr-3"> </i>
							<span class="none">Reportes <i class="fa fa-bar-chart pull-right align-bottom"></i></span>
						</a>

						<ul class="children" id="search_avanced">

							<li class="child"><a href="balance_gastos.php" class="ml-4"><i class="fas fa-money mr-2"></i> Balance de Gastos de Operación</a></li>
							<li class="child"><a href="buscador_vin.php" class="ml-4"><i class="fas fa-car mr-2"></i> Búsqueda de VIN</a></li>
							<li class="child"><a href="buscador_fecha_vin.php" class="ml-4"><i class="fas fa-file-signature mr-2"></i></i> Monitoreo de VIN</a></li>
							<li class="child"><a href="orden_logistica_id_pdf.php" class="ml-4"><i class="far fa-file-pdf mr-2"></i></i> Reportes ID PDF</a></li>
							<li class="child"><a href="orden_logistica_trasladistas_pdf.php" class="ml-4"><i class="fas fa-user-secret mr-2"></i></i> Reportes Trasladistas</a></li>



						</ul>
					</li>

					<li class="parent">
						<a href="#" onclick="toggle_menu('search_sinotruck'); return false" class=""><i class="fas fa-signal mr-3"> </i>
							<span class="none">Reportes Sinotruck <i class="fab fa-accusoft pull-right align-bottom"></i></span>
						</a>

						<ul class="children" id="search_sinotruck">

							<li class="child"><a href="orden_logistica_sinotruck.php" class="ml-4"><i class="fas fa-map"></i> Logisticas SINOTRUCK</a></li>
							<li class="child"><a href="balance_gastos_sinotruck.php" class="ml-4"><i class="fas fa-money mr-2"></i> Balance de Gastos de Operación SINOTRUCK</a></li>

						</ul>
					</li>

					<li class="parent">
						<a href="#" onclick="toggle_menu('search_influencer'); return false" class=""><i class="fab fa-facebook mr-3"> </i>
							<span class="none">Reportes Influncers <i class="fab fa-instagram pull-right align-bottom"></i></span>
						</a>

						<ul class="children" id="search_influencer">

							<li class="child"><a href="orden_logistica_influencers.php" class="ml-4"><i class="fas fa-map"></i> Logisticas Influnencers</a></li>
							<li class="child"><a href="balance_gastos_influencers.php" class="ml-4"><i class="fas fa-money mr-2"></i> Balance de Gastos de Operación Influncers</a></li>

						</ul>
					</li>

					<li class="parent">
						<a href="#" onclick="toggle_menu('search_admin'); return false" class=""><i class="fas fa-chart-line mr-3"> </i>
							<span class="none">Reportes Actividades Administrativas <i class="fas fa-chess-king pull-right align-bottom"></i></span>
						</a>

						<ul class="children" id="search_admin">

							<li class="child"><a href="orden_logistica_direccion.php" class="ml-4"><i class="fas fa-map"></i> Logisticas Dirección General</a></li>

						</ul>
					</li>

					<li class="parent">
						<a href="#" onclick="toggle_menu('search_newspaper'); return false" class=""><i class="far fa-newspaper mr-3"> </i>
							<span class="none">Catálogos<i class="fas fa-ad pull-right align-bottom"></i></span>
						</a>

						<ul class="children" id="search_newspaper">

							<li class="child"><a href="catalogo_tipo_orden_resumen.php" class="ml-4"><i class="fas fa-tags mr-2"></i>Tipo de Orden</a></li>
							<li class="child"><a href="catalogo_departamento_busqueda_id.php" class="ml-4"><i class="fas fa-diagnoses mr-2"></i>Búsqueda Departamento ID</a></li>
							<li class="child"><a href="catalogo_tipo_rol_vin.php" class="ml-4"><i class="fas fa-dolly mr-2"></i>Rol del VIN</a></li>
							<li class="child"><a href="catalogo_colaborador_departamento.php" class="ml-4"><i class="far fa-id-badge mr-2"></i>Rol Colaborador Departamento</a></li>
							<li class="child"><a href="catalogo_rolvin_departamento_resumen.php" class="ml-4"><i class="fas fa-dolly-flatbed mr-2"></i>Rol VIN Departamento</a></li>
							<li class="child"><a href="agregar_mas_auxiliares.php" class="ml-4"><i class="fas fa-search mr-2"></i>Búsqueda Tipo de Orden | Orden Logistica</a></li>
							<li class="child"><a href="guardar_trasladista_logistica.php" class="ml-4"><i class="fas fa-exclamation mr-2"></i>Excepciones | Token</a></li>
						</ul>


					</li>

					<li class="parent">
						<a href="#" onclick="toggle_menu('electronico_tarjeta'); return false" class=""><i class="far fa-credit-card mr-3"></i>
							<span class="none">Monedero Electrónico<i class="fab fa-cc-visa pull-right align-bottom"></i></span>
						</a>

						<ul class="children" id="electronico_tarjeta">
							<li class="child"><a href="electronic_card.php" class="ml-4"><i class="fab fa-cc-mastercard mr-2"></i> Resumen de Tarjetas</a></li>
						</ul>
					</li>

					<li class="parent">
						<a href="#" onclick="toggle_menu('carga_archivos'); return false" class=""><i class="fab fa-cc-visa mr-3"></i>
							<span class="none">Datos Combustible | Tag<i class="fas fa-gas-pump pull-right align-bottom"></i></span>
						</a>

						<ul class="children" id="carga_archivos">
							<li class="child"><a href="agregar_monedero_electronico.php" class="ml-4"><i class="fab fa-cc-mastercard mr-2"></i> Información de Archivos</a></li>
						</ul>
					</li>
					</li>

					<li class="parent">
						<a href="#" onclick="toggle_menu('proveedores'); return false" class=""><i class="far fa-address-book mr-3"></i>
							<span class="none">Proveedor | Proveedor Temporal<i class="fas fa-users pull-right align-bottom"></i></span>
						</a>

						<ul class="children" id="proveedores">
							<li class="child"><a href="buscar_proveedor_requisicion.php" class="ml-4"><i class="fas fa-user-cog mr-2"></i>Resumen de Proveedores</a></li>
						</ul>
					</li>


					<li class="parent">
						<a href="../../direcionador_perfiles.php" class=""><i class="fas fa-exchange-alt mr-3"></i>
							<span class="none">Cambiar de Módulo </span>
						</a>
					</li>

					<li class="parent">
						<a href="../../logout.php" class=""><i class="fas fa-door-open mr-3"></i>
							<span class="none">Salir</span>
						</a>
					</li>
					</li>
				</ul>
			</div>
			<!--Sidebar Naigation Menu-->
		</div>
	</div>

	<!--Sidebar left-->

	<style>
		/*a:hover {
        color:#2196f3;
        font-size: 15px;
        cursor: pointer;
        }*/
		.c-datos a:hover i {
			color: #2196f3;
		}


		.tooltip-inner {
			background-color: #882439;
			color: white;
		}

		.tooltip.bs-tooltip-right .arrow:before {
			border-right-color: #882439 !important;
			color: white;
		}

		.tooltip.bs-tooltip-left .arrow:before {
			border-right-color: #882439 !important;
			color: white;
		}

		.tooltip.bs-tooltip-bottom .arrow:before {
			border-right-color: #882439 !important;
			color: white;
		}

		.tooltip.bs-tooltip-top .arrow:before {
			border-right-color: #882439 !important;
			color: white;
		}
	</style>

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

	<script type="text/javascript">
		$(document).ready(function() {
			$("#icon-cerrarBusqueda").click(function() {
				$("#resultadoBusqueda").hide();
				$("#contenedor-busqueda").hide();
			});
		});




		function buscar() {
			var textoBusqueda = $("#busqueda").val();
			var textoSelect = $("#buscador option:selected").val();
			console.log(textoBusqueda + " " + textoSelect);

			var valueBusqueda = $.trim(textoBusqueda);

			if (valueBusqueda != "" && textoSelect != "" && textoSelect != "undefined") {
				$.post("buscar.php", {
					valorBusqueda: valueBusqueda,
					valorSelect: textoSelect
				}, function(mensaje) {
					$("#resultadoBusqueda").html(mensaje);
					$("#resultadoBusqueda").show();
					$("#contenedor-busqueda").show();

					$('#resultadoBusqueda .sugerencias').each(function(indice, elemento) {
						// console.log('El elemento con el índice '+indice+' contiene '+$(elemento).text());

						// $(elemento).addClass("sugerencias")

						if (indice == 4) {
							$('#resultadoBusqueda').append('<div class="contenedor-icon" style="display: none;"> <i class="fas fa-plus icon-plus" id="icon-desplegar"></i><p style="color: #fff;" class="textB">Ver Todo</p></div>');
						}
						if (indice <= 4) {
							$(elemento).addClass("sugerenciaver");
							$(".contenedor-icon").hide();
						} else {
							$(elemento).addClass("sugerenciaoculta");
							$(".contenedor-icon").show();
						}

						$(".sugerenciaoculta").hide();


					});

					$('#icon-desplegar').on('click', function() {

						$(".container-loading-ajax").show();
						if (valueBusqueda != "" && textoSelect != "" && textoSelect != "undefined") {
							$.post("buscar2.php", {
								valorBusqueda: valueBusqueda,
								valorSelect: textoSelect
							}, function(mensaje2) {

								$(".container-loading-ajax").hide();
								// $("#busquedas-logistica").show();
								$("#busquedas-logistica").addClass("mostrar-busquedas-logistica");
								$("#resultado-busqueda-logistica").html(mensaje2);


								var selBuscador = $("#buscador").val();

								if (selBuscador == "vin") {
									var table = $('#table-busquedas').dataTable();
									// alert(table.fnGetData().length);
								} else if (selBuscador == "ejecutivo") {
									var table = $('#table-busquedas2').dataTable();
									// alert(table.fnGetData().length);
								} else if (selBuscador == "Cliente") {
									var table = $('#table-busquedas3').dataTable();
									// alert(table.fnGetData().length);
								}

								var resultados = table.fnGetData().length;
								$(".num-results").html(resultados);


								$(".icon-cerrarBusqueda2").click(function() {
									// $("#busquedas-logistica").hide();
									$("#busquedas-logistica").removeClass("mostrar-busquedas-logistica");
									$("#busqueda").val("");
								});

							});
						}
						// $('.sugerenciaoculta').slideToggle(500);
						// $(this).toggleClass('fa-plus').toggleClass('fa-minus');

						// var claseT = $('.textB');
						// var texto = claseT.html(); 

						// if(texto  == 'Ver Más') {    
						// 	claseT.html('Ver Menos');     
						// } else {
						// 	claseT.html('Ver Más'); 
						// }
					});

				});
			} else {
				$("#resultadoBusqueda").html('');
				$("#resultadoBusqueda").hide();
				$("#contenedor-busqueda").hide();
			};
		};
	</script>
	<script>
		$(document).on("click", function(e) {
			var container = $("#contenedor-busqueda");

			if (!container.is(e.target) && container.has(e.target).length === 0) {
				container.hide();
			}
		});
	</script>