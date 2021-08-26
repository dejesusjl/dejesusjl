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
<html lang="en-gb" class="no-js"> 

<head>
	<title>Guardar Responsable General</title>

	<link href="../../css/bootstrap.min.css" rel="stylesheet">
	<link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="../../css/animate.css" rel="stylesheet">
	<link href="../../css/style.css" rel="stylesheet">
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

<body class="category-page construccion">

	<div class="columns-container">
		<div class="container" id="columns">    
			<div class="row">
				<br><br>
				<center><span class="image-construccion"><img src="../../img/300X300.png" alt=""></span></center>

				<br><br><br><br><br>

				<center>
					<div class="alert alert-success" role="alert" id="success_alert" style="display: none;">
						<h1>Tipo de orden agregado EXITOSAMENTE</h1>
					</div>

					<div class="alert alert-danger" role="alert" id="fail_alert" style="display: none;">
						<h1>Se ha producido un ERROR al guardar la información</h1>



					</div>

					<div class="alert alert-info" role="alert" id="alert_alert" style="display: none;">

						<h4>Error al:</h4>


					</div>

				</center>   


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
			
			$query_repetido = "SELECT * FROM orden_logistica_tipo_orden where trim(nombre) = '$nombre'";
			$result_repetido = mysql_query($query_repetido); echo "<br>";

			if (mysql_num_rows($result_repetido) == 0) {

				$query_insert = "INSERT INTO orden_logistica_tipo_orden (nombre, visible, usuario_creador, fecha_creacion, fecha_guardado) values ('$nombre', 'SI', '$usuario_creador', '$fecha_creacion', '$fecha_guardado')";
				$result_insert = mysql_query($query_insert);

				if ($result_insert == 1) {
					
					$rs = mysql_query("SELECT @@identity AS id");
					if ($row_ultimo_insert = mysql_fetch_row($rs)) {
						$id_orden = trim($row_ultimo_insert[0]);

						if ($iddepartamento[$i] != "") {

							$insert_orde_departamento = "INSERT INTO orden_logistica_tipo_orden_departamento (idtipo_orden, iddepartamento, visible, fecha_creacion, fecha_guardado,usuario_creador) values ('$id_orden', $iddepartamento[$i], 'SI', '$fecha_creacion', '$fecha_guardado', '$usuario_creador')";
							$result_departamento = mysql_query($insert_orde_departamento);

							if ($result_departamento == 0) {
								$ver_errores .= "- Error al insertar $nombre en la tabla orden departamento <br>";
							}//verificamos si no hay error al asociar el departamento y el concepto
						}//verificamos que el departamento no venga vacio si no no se realiza nada
					}// obtenemos el id del nuevo concepto
				}else{//se inserto el nuevo concepto si no mandamos error
					$ver_errores .= "- Error al guardar $nombre <br>";
				}
			}else{//el ya se encuentra en la base solo lo asociamos

				while ($row_tipo_orden = mysql_fetch_array($result_repetido)) {
					$var_id_depa = trim($iddepartamento[$i]); 

					if ($var_id_depa != "") {

						$query_orden_departamento = "SELECT * FROM orden_logistica_tipo_orden_departamento WHERE trim(idtipo_orden) = '$row_tipo_orden[idorden_logistica_tipo_orden]' AND trim(iddepartamento) = '$var_id_depa'";
						$result_orden_departamento = mysql_query($query_orden_departamento);

						if (mysql_num_rows($result_orden_departamento) == 0) {
							$insert_departamento_orden = "INSERT INTO orden_logistica_tipo_orden_departamento (idtipo_orden, iddepartamento, visible, fecha_creacion, fecha_guardado, usuario_creador) values ('$row_tipo_orden[idorden_logistica_tipo_orden]', $var_id_depa, 'SI', '$fecha_creacion', '$fecha_guardado', '$usuario_creador')";
							$result_departamento_orden = mysql_query($insert_departamento_orden);

							if ($result_departamento_orden == 0) {
								$ver_errores .= "- Error al insertar $row_tipo_orden[nombre] en la tabla orden departamento <br>";
							}
						}
					}
				}


			}

		}//Array diferente de Vacio
	}//For


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

			setInterval(ordenLogistica, 5000);




		}else if (si_error_no == "Fallo") {
			$('#fail_alert').show();  

			setInterval(ordenLogistica, 5000);


		}else{
			$('#alert_alert').show(); 

			$("#alert_alert").append(si_error_no);


			var create = `
			<div class="col-sm-12">
			<div class="form-group">
			<div class="col-lg-12">
			<br>
			<center>
			<button class="btn btn-lg btn-primary" id="continuar">Continuar</button>
			</center>
			<br>
			</div>
			</div>
			</div>
			`;

			$("#alert_alert").append(create);
		}




		function ordenLogistica(){
			location.replace(`catalogo_tipo_orden_agregar.php`);
		}

		$(document).ready(function(){
			$("#continuar").click(function(){
				location.replace(`catalogo_tipo_orden_agregar.php`);
			}); 

			$("#yes").click(function(){
				location.replace(`catalogo_tipo_orden_agregar.php`);
			}); 

			$("#nel").click(function(){
				location.replace(`catalogo_tipo_orden_agregar.php`);
			});
		});


	</script>




</body>
</html>







