<?php 
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
//date_default_timezone_set('America/Mexico_City');
$fecha_guardado=date("Y-m-d H:i:s"); 
$usuario_creador=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);

?>

<!doctype html>
<html lang="es" class="no-js"> 

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Guardar Departamento ID</title>
	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="../../css/animate.css" rel="stylesheet">
	<link href="../../css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="../../assets/css/styles_neumorphism_alert.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
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
	<meta name="theme-color" content="#ffffff">

	<!-- DataTables CSS -->
	<link href="../../plugins/datatables/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

	<!-- DataTables Responsive CSS -->
	<link href="../../plugins/datatables/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="../../plugins/datatables/dist/css/sb-admin-2.css" rel="stylesheet">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

</head>

<body>

	<div class="neu-container-page" style="overflow: auto;">
		<div>
			<div class="neu-container-general neu-animation-container">

				<div class="d-flex justify-content-center">
					<img class="neu-logo" src="../../img/GRUPOPANAMOTORSPLATA.png" alt="">
				</div>

				<div class="d-flex justify-content-center">
					<div id="success_alert" class="neu-container-alert mt-4" style="display: none;">
						<div class="d-flex justify-content-center align-items-center neu-alert neu-alert-correcto">
							<h1 class="text-center text-white mb-0">Búsqueda departamento ID agregado exitosamente</h1>
						</div>
					</div>
				</div>

				<div class="d-flex justify-content-center">
					<div id="fail_alert" class="neu-container-alert mt-4" style="display: none;">
						<div class="d-flex justify-content-center align-items-center neu-alert neu-alert-error">		
							<h1 class="text-center text-white mb-0">Se ha producido un error al guardar la información</h1>
						</div>
					</div>			
				</div>

				<div class="d-flex justify-content-center">
					<div id="alert_alert" class="neu-container-alert mt-4" style="display: none;">
						<div class="neu-alert neu-alert-error-tipo">
							<h4 class="text-center text-white mb-0">Error al: </h4>
						</div>
					</div>
				</div>

				<div id="content-contador" class="mt-4">
					<div class="content-contador d-flex justify-content-center align-items-center">
						<div class="contador text-center">
							<p class="text-redirigir mb-0">Seras redirigido en</p>
							<span class="numero-contador">0</span>
						</div>
					</div>				
				</div>

			</div>
		</div>
	</div>					

	<?php 

	$array_nombre = $_POST['nombre']; 
	$iddepartamento = $_POST['iddepartamento']; 
	$fecha_creacion = $_POST['fecha_creacion']; 

	$nombre = "";
	$var_id_depa = "";
	for ($i=0; $i < count($array_nombre); $i++) { 

		if ($array_nombre[$i] != "") {

			$nombre = trim(ucfirst($array_nombre[$i]));

			$query_repetido = "SELECT * FROM orden_logistica_departamento_id where trim(iddepeartamento) = '$iddepartamento[$i]' AND trim(nombre_tabla) = '$nombre' ";
			$result_repetido = mysql_query($query_repetido); 

			if (mysql_num_rows($result_repetido) == 0) {

				$query_insert = "INSERT INTO orden_logistica_departamento_id (iddepeartamento, nombre_tabla, visible, usuario_creador, fecha_creacion, fecha_guardado) values ('$iddepartamento[$i]', '$nombre', 'SI', '$usuario_creador', '$fecha_creacion', '$fecha_guardado')";
				$result_insert = mysql_query($query_insert);

				if ($result_insert == 1) {

					$ver_errores = "";

				}else{
					$ver_errores .= "- Error al guardar <b>$nombre</b> <br>";
				}

			}else{

				$ver_errores .= "- Error al guardar <b>$nombre</b> ya se encuentra registrado<br>";


			}

		}
	}


	if (count($array_nombre) >= 1) {
		$ver_errores = ($ver_errores == "")? "Sin Errores" : $ver_errores;
	}else {
		$ver_errores = "Fallo";
	}

	?>
	<script>

		var si_error_no = '<?php echo $ver_errores; ?>'

		if (si_error_no == "Sin Errores") {
			$('#success_alert').show();
			$("#content-contador").show();
			redireccionPagina();

		}else if (si_error_no == "Fallo") {
			$('#fail_alert').show(); 
			$("#content-contador").show();
			redireccionPagina();

		}else{
			$('#alert_alert').show(); 
			$("#content-contador").hide();
			$(".neu-alert-error-tipo").append("<p class='text-white mb-0' style='position: relative; z-index: 2;'>"+ si_error_no +"</p>");


			var create = `
			<div class="d-flex justify-content-center mt-4">
			<button class="btn btn-lg btn-primary" id="continuar">Continuar</button>
			</div>
			`;

			$("#alert_alert").append(create);
		}




		$(document).ready(function(){
			$("#continuar").click(function(){
				location.replace(`catalogo_departamento_busqueda_id.php`);
			}); 


		});

		function redireccionPagina(){
			delayPagina();
			contadorRedirigir();
		}

		function delayPagina(){
			var delay = 1500;
			setTimeout(() => {
				location.replace('catalogo_departamento_busqueda_id.php');
			}, delay);
		}

		function contadorRedirigir(){
			$('.numero-contador').each(function () { 
				$(this).prop('Counter', 3).animate(
				{ 
					Counter: $(this).text() 
				}, 
				{ 
					duration: 1500, 
					easing: 'swing', 
					step: function (now) { 
						$(this).text(Math.ceil(now)); 
					} 
				}
				); 
			});
		}

		const neu_animation_container = document.querySelector(".neu-animation-container");
		neu_animation_container.classList.add("add-neu-animation-container");

	</script>


</body>
</html>







