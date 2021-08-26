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
						<h1>Datos Guardados EXITOSAMENTE</h1>
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
	$id_colaborador_nuevo = $_POST['id_colaborador_nuevo'];

	$porciones_asigndo = explode("|", $id_colaborador_nuevo);


	$id_logistica = base64_decode($_POST['idlogistica_encriptada']);
	$idorden_logistica_unidades = base64_decode($_POST['idmovimiento_encriptada']);


	$query_dublicados = "SELECT * FROM orden_logistica_unidades WHERE idpersona_asignada = '$porciones_asigndo[0]' AND tipopersona_asignada = '$porciones_asigndo[1]' AND idorden_logistica_unidades = '$idorden_logistica_unidades' and idorden_logistica = '$id_logistica'";
	$result_duplicados = mysql_query($query_dublicados);

	if (mysql_num_rows($result_duplicados) == 0) {

		$update_vin = "UPDATE orden_logistica_unidades set idpersona_asignada = '$porciones_asigndo[0]', tipopersona_asignada = '$porciones_asigndo[1]' WHERE idorden_logistica_unidades = '$idorden_logistica_unidades' and idorden_logistica = '$id_logistica' ";
		$result_vin = mysql_query($update_vin);


		if ($result_vin == 1 and $id_logistica != "" and $idorden_logistica_unidades != "" and $vin != "" and $comentario_eliminar_vin != "" ) {

			$array_name = nombres_datos($porciones_asigndo[0], $porciones_asigndo[1]);
			$nombres_asignado = explode("|", $array_name);

			$nombre_asignado_table = ($nombres_asignado[11] == "Colaborador") ? $nombres_asignado[2] : "$nombres_asignado[0] $nombres_asignado[1]" ;

			$bitacora1 = "El VIN <b>$vin</b> fue Asignado a <b>$nombre_asignado_table</b>";

			$insert_bitacora_ayudante = insertarBitacora($bitacora1, "Acompañante", $id_logistica, $fecha_creacion, $fecha_guardado, $coordenadas, "4", $usuario_creador, $comentario_eliminar_vin);

			$ver_errores .= $insert_bitacora_ayudante."|";



		}else{
			$ver_errores = "Fallo";
		}
		
	}else {
		$ver_errores = "Fallo";
	}

	


	$resultado = explode("|", $ver_errores);

	foreach ($resultado as $key => $value) {
		
		if (trim($value) != "1") {
			$result_final .= $value;
		}
	}

	$ver_errores = (trim($result_final) == "") ? "Sin Errores": $result_final ;


#-------------------------------------------Funcion Nombres y Tipo--------------------------------------------------------------------------------

	function nombres_datos($id_id, $type_type){

		if ($type_type == "Cliente") {

			$query_cliente = "SELECT * FROM contactos WHERE idcontacto = '$id_id'";
			$result_cliente = mysql_query($query_cliente);

			if (mysql_num_rows($result_cliente) >= 1) {

				while ($row_cliente = mysql_fetch_array($result_cliente)) {
					$nombre = "$row_cliente[nombre]"; 
					$apellidos = "$row_cliente[apellidos]"; 
					$alias = "$row_cliente[alias]"; 
					$telefono = "$row_cliente[telefono_celular]"; 
					$telefono_otro = "$row_cliente[telefono_otro]"; 
					$estado_cliente = "$row_cliente[estado]"; 
					$municipio_cliente = "$row_cliente[delmuni]"; 
					$calle_cliente = "$row_cliente[calle]"; 
					$colonia_cliente = "$row_cliente[colonia]"; 
					$cp_cliente = "$row_cliente[cp_cliente]";
				}
				$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Cliente";
			}else{
				$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Cliente";
			}

		}elseif ($type_type == "Proveedor") {

			$query_proveedor = "SELECT * FROM proveedores WHERE idproveedores = '$id_id'";
			$result_proveedor = mysql_query($query_proveedor);

			if (mysql_num_rows($result_proveedor) >= 1) {

				while ($row_proveedor = mysql_fetch_array($result_proveedor)) {
					$nombre = trim("$row_proveedor[nombre]");
					$apellidos = trim("$row_proveedor[apellidos]");
					$alias = trim("$row_proveedor[alias]");
					$telefono = trim("$row_proveedor[telefono_celular]");
					$telefono_otro = trim("$row_proveedor[telefono_otro]");
					$estado_cliente = trim("$row_proveedor[estado]");
					$municipio_cliente = trim("$row_proveedor[delmuni]");
					$calle_cliente = trim("$row_proveedor[calle]");
					$colonia_cliente = trim("$row_proveedor[colonia]");
					$cp_cliente = trim("$row_proveedor[cp_cliente]");
				}
				$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor";
			}else{
				$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor";
			}


		}elseif ($type_type == "Proveedor Temporal") {

			$query_proveedor_tem = "SELECT * FROM orden_logistica_proveedores WHERE idorden_logistica_proveedores = '$id_id'";
			$result_proveedor_tem = mysql_query($query_proveedor_tem);

			if (mysql_num_rows($result_proveedor_tem) >= 1) {

				while ($row_proveedor_tem = mysql_fetch_array($result_proveedor_tem)) {
					$nombre = trim("$row_proveedor_tem[nombre]");
					$apellidos = trim("$row_proveedor_tem[apellidos]");
					$alias = trim("$row_proveedor_tem[alias]");
					$telefono = trim("$row_proveedor_tem[telefono_celular]");
					$telefono_otro = trim("$row_proveedor_tem[telefono_otro]");
					$estado_cliente = trim("$row_proveedor_tem[estado]");
					$municipio_cliente = trim("$row_proveedor_tem[delmuni]");
					$calle_cliente = trim("$row_proveedor_tem[calle]");
					$colonia_cliente = trim("$row_proveedor_tem[colonia]");
					$cp_cliente = trim("$row_proveedor_tem[codigo_postal]");
				}
				$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor Temporal";
			}else{
				$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor Temporal";
			}

		}elseif ($type_type == "Colaborador") {

			$query_colaborador = "SELECT * FROM empleados WHERE idempleados = '$id_id'";
			$result_colaborador = mysql_query($query_colaborador);

			if (mysql_num_rows($result_colaborador) >= 1) {

				while ($row_colaborador = mysql_fetch_array($result_colaborador)) {
					$nombre = "$row_colaborador[nombre]";
					$apellidos = trim("$row_colaborador[apellido_paterno]")." ".trim("$row_colaborador[apellido_materno]"); 
					$alias = trim("$row_colaborador[columna_b]");
					$telefono = trim("$row_colaborador[telefono_personal]");
					$telefono_otro = trim("$row_colaborador[telefono_emergencia]");
					$estado_cliente = trim("$row_colaborador[estado]");
					$municipio_cliente = trim("$row_colaborador[municipio]");
					$calle_cliente = trim("$row_colaborador[calle_numero]");
					$colonia_cliente = trim("$row_colaborador[colonia]");
					$cp_cliente = trim("$row_colaborador[cp]");
					$nomenclatura_co = trim("$row_colaborador[columna_b]");
				}
				$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nomenclatura_co|Colaborador";
			}else{
				$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Colaborador";
			}

		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente";
		}

		return $concatenacion;

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