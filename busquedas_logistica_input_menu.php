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

//---------Inicia Logística -------------------------------------------------

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="" >
	<meta name="author" content="">
	<meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    <title>Busquedas Logistica</title>

    <style>
        body{
            background: #fff;
        }
        .card-busquedas{
            border: 1px solid #efefef;
            padding: 5px;
        }
        .busquedas-text-1{
            background: #B03C54; 
            padding: 5px; 
            border-radius: 5px; 
            width: 100px; 
            color: #fff;
        }
        .busquedas-text-2{
            font-weight: bold;
        }
        .text-num-results{
            color: #dddddd;
        }
    </style>
</head>
<body>

<div style="position: fixed; overflow: auto; height: 100vh; width: 100vw;">
    <div>
        <div class="text-center">
            <h1>Busquedas Logistica</h1>
            <h2 class="text-num-results">6 Resultados relacionados con</h2>
        </div>

        <div class="my-2">
            <a href="" class="card-busquedas d-flex align-items-center">
                <p class="busquedas-text-1 mb-0 text-center">8078</p>
                <h6 class="busquedas-text-2 mb-0">Alejo Jacinto Dominguez</h4>
            </a>
        </div>
        <div class="my-2">
            <a href="" class="card-busquedas d-flex align-items-center">
                <p class="busquedas-text-1 mb-0 text-center">7569</p>
                <h6 class="busquedas-text-2 mb-0">César Domingo Monroy Carreño</h6>
            </a>
        </div>
        <div class="my-2">
            <a href="" class="card-busquedas d-flex align-items-center">
                <p class="busquedas-text-1 mb-0 text-center">6841</p>
                <h6 class="busquedas-text-2 mb-0">Ignacio García Sánchez</h6>
            </a>
        </div>
        <div class="my-2">
            <a href="" class="card-busquedas d-flex align-items-center">
                <p class="busquedas-text-1 mb-0 text-center">8078</p>
                <h6 class="busquedas-text-2 mb-0">Alejo Jacinto Dominguez</h4>
            </a>
        </div>
        <div class="my-2">
            <a href="" class="card-busquedas d-flex align-items-center">
                <p class="busquedas-text-1 mb-0 text-center">7569</p>
                <h6 class="busquedas-text-2 mb-0">César Domingo Monroy Carreño</h6>
            </a>
        </div>
        <div class="my-2">
            <a href="" class="card-busquedas d-flex align-items-center">
                <p class="busquedas-text-1 mb-0 text-center">6841</p>
                <h6 class="busquedas-text-2 mb-0">Ignacio García Sánchez</h6>
            </a>
        </div>
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

</body>
</html>