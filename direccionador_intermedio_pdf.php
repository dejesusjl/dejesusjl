<?php 
session_start();  
require_once('../../bdd.php');
require_once('../../config.php');
include_once "../../recuperar_usuario.php";


$encript_id_contacto = $_REQUEST['idcliente']; 
$encript_type_contacto = $_REQUEST['tipo_contacto_id'];
$fecha_a = $_REQUEST['fecha_a'];
$fecha_b = $_REQUEST['fecha_b'];
$direccionador = $_REQUEST['direccionador'];


$idcliente = base64_encode($encript_id_contacto);
$tipo_contacto_id = base64_encode($encript_type_contacto);
$fecha_a = base64_encode($fecha_a);
$fecha_b = base64_encode($fecha_b);



?>

<!DOCTYPE html>
<html lang="en">
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


	<script src="../../js/jquery-1.10.2.js"></script>
	<script src="../../js/jquery-ui.js"></script>


	<title>CCP | Direccionador</title>
</head>
<body>
	<div class="container-loading-ajax">
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
</body>
</html>



<script type="text/javascript">
	var id = '<?php echo $idcliente; ?>'
	var tipo = '<?php echo $tipo_contacto_id; ?>'
	var fecha_a = '<?php echo $fecha_a; ?>'
	var fecha_b = '<?php echo $fecha_b; ?>'
	var direccionador = '<?php echo $direccionador; ?>'

	window.addEventListener("load", showForm);

	function showForm() {

		if (direccionador == "id") {

			let url = `resumen_logistica_id_pdf.php?idcliente=${id}&tipo_contacto_id=${tipo}&fecha_a=${fecha_a}&fecha_b=${fecha_b}`;

			$("#container-loading-ajax").hide();
			window.open(url);
			window.location=document.referrer;

		}else if (direccionador == "trasladista") {

			let url = `resumen_logistica_trasladista_pdf.php?idcliente=${id}&tipo_contacto_id=${tipo}&fecha_a=${fecha_a}&fecha_b=${fecha_b}`;

			$("#container-loading-ajax").hide();
			window.open(url);
			window.location=document.referrer;

		}else {
			
			let url = `index.php`;

			$("#container-loading-ajax").hide();
			window.open(url);
			window.location=document.referrer;
		}



	}

	

	

</script>
