<?php
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
date_default_timezone_set('America/Mexico_City');
$fecha_guardado=date("Y-m-d H:i:s"); 
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);


?>

<!doctype html>
<html lang="en-gb" class="no-js"> 

<head>
	<title>CCP| Guardar Eliminar VIN</title>

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
						<h1>VIN(s) Eliminado(s) EXITOSAMENTE</h1>
					</div>

					<div class="alert alert-danger" role="alert" id="fail_alert" style="display: none;">
						<h1>Se ha producido un ERROR al guardar la información</h1>
					</div>

				</center>   


			</div>   
		</div>
	</div>

	<?php 


	$vin = $_POST['vin'];
	$tipo_unidad = $_POST['tipo_unidad'];
	$id_unidad = $_POST['id_unidad'];
	$fecha_creacion = $_POST['fecha_creacion'];
	$coordenadas = $_POST['coordenadas'];
	$idlogistica_encriptada = $_POST['idlogistica_encriptada'];
	$idmovimiento_encriptada = $_POST['idmovimiento_encriptada'];
	$comentario_eliminar_vin = $_POST['comentario_eliminar_vin'];


	$id_logistica = base64_decode($_POST['idlogistica_encriptada']);
	$idorden_logistica_unidades = base64_decode($_POST['idmovimiento_encriptada']);


	$update_vin = "UPDATE orden_logistica_unidades set visible = 'NO' WHERE idorden_logistica_unidades = '$idorden_logistica_unidades' and idorden_logistica = '$id_logistica' ";
	$result_vin = mysql_query($update_vin);


	if ($result_vin == 1 and $id_logistica != "" and $idorden_logistica_unidades != "" and $vin != "" and $comentario_eliminar_vin != "") {


		if ($tipo_unidad == "Utilitario") {

			$actualizacion_colaborador = updateVIN($id_unidad, $vin);

			
			$bitacora1 = "El VIN: <b>$vin</b> fue Asignado a otra Actividad";
			$insert_bitacora_ayudante = insertarBitacora($bitacora1, "VIN", $id_logistica, $fecha_creacion, $fecha_guardado, $coordenadas, "7", $usuario_creador, $comentario_eliminar_vin);

			$ver_errores .= $insert_bitacora_ayudante."|";


		} else{

			$bitacora1 = "El VIN: <b>$vin</b> fue Asignado a otra Actividad";
			$insert_bitacora_ayudante = insertarBitacora($bitacora1, "VIN", $id_logistica, $fecha_creacion, $fecha_guardado, $coordenadas, "7", $usuario_creador, $comentario_eliminar_vin);

			$ver_errores .= $insert_bitacora_ayudante."|";

		}


	}else{
		$ver_errores = "Fallo";
	}


	$resultado = explode("|", $ver_errores);

	foreach ($resultado as $key => $value) {
		
		if (trim($value) != "1") {
			$result_final .= $value;
		}
	}

	$ver_errores = (trim($result_final) == "") ? "Sin Errores": $result_final ;

  #----------------------------------------------------------UPDATE COLABORADORES-------------------------------------------------------------------------------------------

	function updateVIN($idcatalogo_unidades_utilitarios, $insertvin) {

		$update_vin = "UPDATE catalogo_unidades_utilitarios SET estatus_unidad = 'Disponible' WHERE idcatalogo_unidades_utilitarios = '$idcatalogo_unidades_utilitarios'";
		$result_update_vin = mysql_query($update_vin);


		$result_update_vin .= ($result_update_vin == 1) ? "1" : "- Error de Estatus con $insertvin <br>|";

		return $result_update_vin;

	}


  #----------------------------------------------------------INSERTAR BITACORA-------------------------------------------------------------------------------------------

	function insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador, $comentarios) {


		$insert_bitacora = "INSERT INTO orden_logistica_bitacora (descripcion, tipo, idorden_logistica, usuario_creador, fecha_creacion, fecha_guardado, visible, coordenadas, valor, comentarios) VALUES ('$bitacora_descripcion', '$bitacora_tipo', '$id_logisticapasar', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', 'SI', '$coordenadas', '$bitacora_valor', '$comentarios')";
		$result_bitacora = mysql_query($insert_bitacora);

		$respuesta_bitacora = ($result_bitacora == 1) ? "1" : "|ERROR en bitacora de tipo: $bitacora_tipo <br>|";


		return $respuesta_bitacora;

	}


    #----------------------------------------------------------CONSULTAS Nombres-------------------------------------------------------------------------------------------

	?>

	<script>

		var si_error_no = '<?php echo $ver_errores; ?>'

		var idlogistica = '<?php  echo $idlogistica_encriptada;?>'


		if (si_error_no == "Sin Errores") {
			$('#success_alert').show(); 

			setInterval(ordenLogistica(idlogistica), 5000);


		}else if (si_error_no == "Fallo") {
			$('#fail_alert').show();  

			setInterval(ordenLogistica(idlogistica), 9000);


		}else{
			$('#alert_alert').show(); 
			$("#alert_alert").append(si_error_no);

		}


		function salir(){
			location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`); 
		}

		function ordenLogistica(idlogistica){
			location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
		}

		$(document).ready(function(){
			$("#continuar").click(function(){
				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
			}); 

			$("#yes").click(function(){
				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
			}); 

			$("#nel").click(function(){
				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
			});
		});


	</script>




</body>
</html>