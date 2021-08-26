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
	<title>CCP| Guardar Eliminar Ayudante</title>

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
						<h1>Acompañante(s) Eliminado(s) EXITOSAMENTE</h1>
					</div>

					<div class="alert alert-danger" role="alert" id="fail_alert" style="display: none;">
						<h1>Se ha producido un ERROR al guardar la información</h1>
					</div>

				</center>   


			</div>   
		</div>
	</div>

	<?php 


	$id_ayudante_baja = trim($_POST['id_ayudante_baja']);
	$tipo_ayudante_baja = trim($_POST['tipo_ayudante_baja']);
	$comentario_baja_ayudante = trim($_POST['comentario_baja_ayudante']);
	$fecha_creacion = $_POST['fecha_creacion_ayudante_baja'];
	$coordenadas = $_POST['coordenadas'];
	$id_logistica = base64_decode($_POST['logistica']);
	$idlogistica_encriptada = $_POST['logistica'];
	$idorden_logistica_ayudante_encript = base64_decode($_POST['idorden_logistica_ayudante_encript']);


	$update_ayudantes = "UPDATE orden_logistica_ayudante set visible = 'NO' WHERE idorden_logistica_ayudante = '$idorden_logistica_ayudante_encript' and idorden_logistica = '$id_logistica' ";
	$result_ayudante = mysql_query($update_ayudantes);


	if ($result_ayudante == 1 and $id_logistica != "" and $idorden_logistica_ayudante_encript != "" and $id_ayudante_baja != "" and $tipo_ayudante_baja != "" and $comentario_baja_ayudante != "") {

		$name_ayudante =  name_usuario ($id_ayudante_baja, $tipo_ayudante_baja);
		$nombre_ayudante = explode("/", $name_ayudante);


		if ($tipo_ayudante_baja == "Colaborador") {

			$actualizacion_colaborador = updateColaboradores($id_ayudante_baja);

			
			
			$bitacora1 = "<b>$nombre_ayudante[1]</b> fue Asignado a otra Actividad";
			$insert_bitacora_ayudante = insertarBitacora($bitacora1, "Acompañante", $id_logistica, $fecha_creacion, $fecha_guardado, $coordenadas, "4", $usuario_creador, $comentario_baja_ayudante);

			$notificaccion1_bd = "<b>$nombre_ayudante[1]</b> has sido asignado a otra actividad. Favor de esperar nuevas indicaciones";
			$notificaccion1_whats = "*$nombre_ayudante[1]* has sido asignado a otra actividad. Favor de esperar nuevas indicaciones";

			$insert_notificcion = insertarBitacora($notificaccion1_whats, "Notificación", $id_logistica, $fecha_creacion, $fecha_guardado, $coordenadas, "2", $usuario_creador, $comentario_baja_ayudante);

			$whatsapp_ayudante = "https://api.whatsapp.com/send?phone=$nombre_ayudante[3]&text=$notificaccion1_whats";

			



			


		} else{


			$bitacora1 = "<b>$nombre_ayudante[1]</b> fue Asignado a otra Actividad";
			$insert_bitacora_ayudante = insertarBitacora($bitacora1, "Acompañante", $id_logistica, $fecha_creacion, $fecha_guardado, $coordenadas, "4", $usuario_creador, $comentario_baja_ayudante);

			$notificaccion1_bd = "<b>$nombre_ayudante[1]</b> La Logística No. <b>$id_logistica</b> fue reasignada a alguien mas.";
			$notificaccion1_whats = "*$nombre_ayudante[1]* La logística No. *$id_logistica* fue reasignada a alguien mas.";

			$insert_notificcion = insertarBitacora($notificaccion1_whats, "Notificación", $id_logistica, $fecha_creacion, $fecha_guardado, $coordenadas, "2", $usuario_creador, $comentario_baja_ayudante);

			$whatsapp_ayudante = "https://api.whatsapp.com/send?phone=$nombre_ayudante[3]&text=$notificaccion1_whats";

		}

		$ver_errores = $whatsapp_ayudante;


	}else{
		$ver_errores = "Fallo";
	}


  #----------------------------------------------------------UPDATE COLABORADORES-------------------------------------------------------------------------------------------

	function updateColaboradores($id_colaborador_actualizar) {

		$update_empleados = "UPDATE empleados SET columna_a = 'Disponible' WHERE idempleados = '$id_colaborador_actualizar'";
		$result_update_empleado = mysql_query($update_empleados);

		$solicito_nombre = name_usuario($id_colaborador_actualizar, "Colaborador");

		$trim_name = explode("/", $solicito_nombre);

		$result_update_colaborador .= ($result_update_empleado == 1) ? "1" : "- Error de Estatus con $trim_name[1] <br>";

		return $result_update_colaborador;

	}


  #----------------------------------------------------------INSERTAR BITACORA-------------------------------------------------------------------------------------------

	function insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador, $comentarios) {


		$insert_bitacora = "INSERT INTO orden_logistica_bitacora (descripcion, tipo, idorden_logistica, usuario_creador, fecha_creacion, fecha_guardado, visible, coordenadas, valor, comentarios) VALUES ('$bitacora_descripcion', '$bitacora_tipo', '$id_logisticapasar', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', 'SI', '$coordenadas', '$bitacora_valor', '$comentarios')";
		$result_bitacora = mysql_query($insert_bitacora);

		$respuesta_bitacora = ($result_bitacora == 1) ? "1" : "; ERROR en bitacora de tipo: $bitacora_tipo ;";


		return $respuesta_bitacora;

	}


    #----------------------------------------------------------CONSULTAS Nombres-------------------------------------------------------------------------------------------


	function name_usuario ($id_id, $id_type){

		$id_id = trim($id_id);
		$id_type = trim($id_type);

		if ($id_type == "Colaborador") {

			$query_name_colaborador = "SELECT * FROM empleados where idempleados = '$id_id'";
			$result_name_colaborador = mysql_query($query_name_colaborador);

			if (mysql_num_rows($result_name_colaborador) >= 1) {

				while ($row_colaborador = mysql_fetch_array($result_name_colaborador)) {

					if (is_numeric($row_colaborador[telefono_empresa]) and $row_colaborador[telefono_empresa] != "" and $row_colaborador[telefono_empresa] != null) {

						$phone_number =  "52$row_colaborador[telefono_empresa]";

					} elseif (is_numeric($row_colaborador[telefono_personal]) and $row_colaborador[telefono_personal] != "" and $row_colaborador[telefono_personal] != null) {

						$phone_number =  "52$row_colaborador[telefono_personal]";

					} else {

						$phone_number = "520000000000";
					}

					$name_name = "$row_colaborador[idempleados]/$row_colaborador[columna_b]/Colaborador/$phone_number/$row_colaborador[puesto_actual]"; 
				}

			} else {

				$name_name = "Colaborador/Colaborador/Colaborador/Colaborador";
			}


		}elseif ($id_type == "Cliente") {

			$query_name_cliente = "SELECT * FROM contactos WHERE idcontacto = '$id_id'";
			$result_name_cliente = mysql_query($query_name_cliente);

			if (mysql_num_rows($result_name_cliente) >= 1) {

				while ($row_cliente = mysql_fetch_array($result_name_cliente)) {

					if (is_numeric($row_cliente[telefono_celular]) and $row_cliente[telefono_celular] != "" and $row_cliente[telefono_celular] != null) {

						$phone_number =  "52$row_cliente[telefono_celular]";

					} elseif (is_numeric($row_cliente[telefono_otro]) and $row_cliente[telefono_otro] != "" and $row_cliente[telefono_otro] != null) {

						$phone_number =  "52$row_cliente[telefono_otro]";

					} else {

						$phone_number = "520000000000";
					}

					$name_name = "$row_cliente[idcontacto]/$row_cliente[nombre] $row_cliente[apellidos]/Cliente/$phone_number"; 

				}

			}else{

				$name_name = "Cliente/Cliente/Cliente/Cliente";
			}

		}elseif ($id_type == "Proveedor") {

			$query_name_proveedor = "SELECT * FROM proveedores WHERE idproveedores = '$id_id'";
			$result_name_proveedor = mysql_query($query_name_proveedor);

			if (mysql_num_rows($result_name_proveedor) >= 1) {

				while ($row_proveedor = mysql_fetch_array($result_name_proveedor)) {

					if (is_numeric($row_proveedor[telefono_celular]) and $row_proveedor[telefono_celular] != "" and $row_proveedor[telefono_celular] != null) {

						$phone_number =  "52$row_proveedor[telefono_celular]";

					} elseif (is_numeric($row_proveedor[telefono_otro]) and $row_proveedor[telefono_otro] != "" and $row_proveedor[telefono_otro] != null) {

						$phone_number =  "52$row_proveedor[telefono_otro]";

					} else {

						$phone_number = "520000000000";
					}

					$name_name = "$row_proveedor[idproveedores]/$row_proveedor[nombre] $row_proveedor[apellidos]/Proveedor/$phone_number"; 

				}

			}else{

				$name_name = "Proveedor/Proveedor/Proveedor/Proveedor";
			}

		}elseif ($id_type == "Proveedor Temporal") {

			$query_name_proveedor_temporal = "SELECT * FROM orden_logistica_proveedores WHERE idorden_logistica_proveedores = '$id_id'";
			$result_name_proveedor_temporal = mysql_query($query_name_proveedor_temporal);

			if (mysql_num_rows($result_name_proveedor_temporal) >= 1) {

				while ($row_proveedor_temporal = mysql_fetch_array($result_name_proveedor_temporal)) {

					if (is_numeric($row_proveedor_temporal[telefono_celular]) and $row_proveedor_temporal[telefono_celular] != "" and $row_proveedor_temporal[telefono_celular] != null) {

						$phone_number =  "52$row_proveedor_temporal[telefono_celular]";

					} elseif (is_numeric($row_proveedor_temporal[telefono_otro]) and $row_proveedor_temporal[telefono_otro] != "" and $row_proveedor_temporal[telefono_otro] != null) {

						$phone_number =  "52$row_proveedor_temporal[telefono_otro]";

					} else {

						$phone_number = "520000000000";
					}

					$name_name = "$row_proveedor_temporal[idorden_logistica_proveedores]/$row_proveedor_temporal[nombre] $row_proveedor_temporal[apellidos]/Proveedor Temporal/$phone_number"; 

				}

			}else{

				$name_name = "Proveedor Temporal/Proveedor Temporal/Proveedor Temporal/Proveedor Temporal";
			}

		} else {

			$name_name = "Pendiente/Pendiente/Pendiente/Pendiente";
		}

		return $name_name;

	}

	?>

	<script>

		var si_error_no = '<?php echo $ver_errores; ?>'
		var numeros_whats ='<?php echo $ver_errores;?>'
		var idlogistica = '<?php  echo $idlogistica_encriptada;?>'


		if (si_error_no != "Fallo") {
			$('#success_alert').show(); 

			var porciones = numeros_whats.split('|');
			var contador = porciones.length;


			if (contador > 0) {

				porciones.forEach(myFunction);
				var sumar = 0;
				function myFunction(item, index) {

					if (item != "") {

						open(item, index,`width=600, height=600, left=${sumar}, top=300`); 
						var sumar = sumar + 300; 
						setInterval(ordenLogistica(idlogistica), 9000);


					}else{
						setInterval(ordenLogistica(idlogistica), 9000);

					}


				}



			}else{
				setInterval(ordenLogistica(idlogistica), 9000);
			}







		}else if (si_error_no == "Fallo") {
			$('#fail_alert').show();  

			setInterval(salir, 5000);


		}else{
			$('#alert_alert').show(); 

			var extraer_warnings = si_error_no.split('|');

			extraer_warnings.forEach(agregarWarnings);
			var sumar = 0;
			function agregarWarnings(val, contador) {

				$("#alert_alert").append(val);

			}

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