<?php
session_start();  
include_once "../../config.php";  
include_once "../../recuperar_usuario.php";

$usuario_creador = $_SESSION['usuario_clave'];
date_default_timezone_set('America/Mexico_City');
$fecha_guardado= date("Y-m-d H:i:s");   

$query_usuarios = "SELECT * FROM usuarios WHERE idusuario = '$usuario_creador'";
$result_usuario = mysql_query($query_usuarios);

while ($row_usuarios = mysql_fetch_array($result_usuario)) {
	$name_usuario = row_usuarios[sigla_ccp];
}

$idcliente = trim($_REQUEST['idcliente']);
$tipo_contacto_id = trim($_REQUEST['tipo_contacto_id']);
$id_logisticapasar = base64_decode($_REQUEST['id_logistica_id']);
$coordenadas = $_REQUEST['coordenadas_id'];

$fecha_creacion = $_REQUEST['fecha_creacion_id'];
$id_anterior = $_REQUEST['id_anterior'];

$porciones = explode("|", $id_anterior);

$idlogistica_encriptada = base64_encode($id_logisticapasar);



$update_logistica = "UPDATE orden_logistica SET idcontacto = '$idcliente', tipo_contacto = '$tipo_contacto_id' WHERE idorden_logistica = '$id_logisticapasar'";
$result_logistica = mysql_query($update_logistica);

if ($result_logistica == 1) {

	if ($porciones[0] == "0" || $porciones[0] == "") {

		$tipo_mensaje = "0";

		$ver_completo_id = nombres_datos($idcliente, $tipo_contacto_id);
		$nombre_completo_id = explode("|", $ver_completo_id);

		$bitacora_descripcion = mensaje($tipo_mensaje, $nombre_completo_id[10], $nombre_completo_id1);

		$bitacora_tipo = "Datos del ID";
		$bitacora_valor = "11";

		$pasar_bitacora = insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador);

		$ver_errores = ($pasar_bitacora == "1") ? "Sin Errores" : $pasar_bitacora ;

	}else{

		$tipo_mensaje = "1";

		$ver_completo_id = nombres_datos($porciones[0], $porciones[1]);
		$nombre_completo_id = explode("|", $ver_completo_id);
		

		$ver_completo_id1 = nombres_datos($idcliente, $tipo_contacto_id);
		$nombre_completo_id1 = explode("|", $ver_completo_id1);



		$bitacora_descripcion = mensaje($tipo_mensaje, $nombre_completo_id[10], $nombre_completo_id1[10]);
		$bitacora_tipo = "Cambio del ID";
		$bitacora_valor = "11";


		$pasar_bitacora = insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador);

		$ver_errores = ($pasar_bitacora == "1") ? "Sin Errores" : $pasar_bitacora ;

	}
	
}else{
	$ver_errores = "Fallo";
}


function insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador) {


	$insert_bitacora = "INSERT INTO orden_logistica_bitacora (descripcion, tipo, idorden_logistica, usuario_creador, fecha_creacion, fecha_guardado, visible, coordenadas, valor) VALUES ('$bitacora_descripcion', '$bitacora_tipo', '$id_logisticapasar', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', 'SI', '$coordenadas', '$bitacora_valor')";
	$result_bitacora = mysql_query($insert_bitacora);

	$respuesta_bitacora = ($result_bitacora == 1) ? "1" : "ERROR en bitacora de tipo: $bitacora_tipo";


	return $respuesta_bitacora;

}


#-----------------------------------------------------------------------------------------------------------------------------------------------------


function nombres_datos($id_id, $type_type) {

	$id_id = trim($id_id);
	$type_type = trim($type_type);

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
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Cliente|Pendiente";
		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Cliente|Pendiente";
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
				$condicion_proveedor = trim("$row_proveedor[col10]");
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor|$condicion_proveedor";
		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor|Pendiente";
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
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor Temporal|Pendiente";
		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor Temporal|Pendiente";
		}

	}elseif ($type_type == "Colaborador") {

		$query_colaborador = "SELECT * FROM empleados WHERE idempleados = '$id_id'";
		$result_colaborador = mysql_query($query_colaborador);

		if (mysql_num_rows($result_colaborador) >= 1) {

			while ($row_colaborador = mysql_fetch_array($result_colaborador)) {
				$nombre = "$row_colaborador[nombre]";
				$apellidos = trim("$row_colaborador[apellido_paterno]")." ".trim("$row_colaborador[apellido_materno]"); 
				$alias = trim("$row_colaborador[columna_b]");
				$telefono = trim("$row_colaborador[telefono_empresa]");
				$telefono_otro = trim("$row_colaborador[telefono_emergencia]");
				$estado_cliente = trim("$row_colaborador[estado]");
				$municipio_cliente = trim("$row_colaborador[municipio]");
				$calle_cliente = trim("$row_colaborador[calle_numero]");
				$colonia_cliente = trim("$row_colaborador[colonia]");
				$cp_cliente = trim("$row_colaborador[cp]");
				$nomenclatura_co = trim("$row_colaborador[columna_b]");
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Colaborador|Pendiente";
		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Colaborador|Pendiente";
		}

	}elseif ($type_type == "Proveedor Info") {

		$query_proveedor_info = "SELECT * FROM proveedores_info WHERE idproveedores_info = '$id_id'";
		$result_proveedor_info = mysql_query($query_proveedor_info);

		if (mysql_num_rows($result_proveedor_info) >= 1) {

			while ($row_proveedor_info = mysql_fetch_array($result_proveedor_info)) {
				$nombre = "$row_proveedor_info[nombre]";
				$apellidos = trim("$row_proveedor_info[apellidos]"); 
				$alias = trim("$row_proveedor_info[alias]");
				$telefono = trim("$row_proveedor_info[telefono_celular]");
				$telefono_otro = trim("$row_proveedor_info[telefono_otro]");
				$estado_cliente = trim("$row_proveedor_info[estado]");
				$municipio_cliente = trim("$row_proveedor_info[delmuni]");
				$calle_cliente = trim("$row_proveedor_info[colonia]");
				$colonia_cliente = trim("$row_proveedor_info[calle]");
				$cp_cliente = trim("$row_proveedor_info[codigo_postal]");
				$condicion_proveedor_info = trim("$row_proveedor_info[tipo]");

			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor Info|$condicion_proveedor_info";
		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor Info|Pendiente";
		}

	}else{
		$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor Info|Pendiente";
	}

	return $concatenacion;

}










function mensaje($tipo_mensaje, $nombre_completo_id, $nombre_completo_id1){

	$valor_mensaje = ($tipo_mensaje == 0) ? "Se Agregó a <b>$nombre_completo_id</b> a Datos del ID" : "El ID cambio de <b>$nombre_completo_id</b> por <b>$nombre_completo_id1</b>";

	return $valor_mensaje;

}


?>


<!doctype html>
<html lang="es" class="no-js"> 

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>CCP</title>

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

	
	<link href="../../plugins/datatables/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

	<link href="../../plugins/datatables/datatables-responsive/dataTables.responsive.css" rel="stylesheet">


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
							<h1 class="text-center text-white mb-0">ID agregado exitosamente</h1>
						</div>
					</div>
				</div>

				<div class="d-flex justify-content-center">
					<div id="fail_alert" class="neu-container-alert mt-4" style="display: none;">
						<div class="d-flex justify-content-center align-items-center neu-alert neu-alert-error">		
							<h1 class="text-center text-white mb-0">Se ha producido un error al guardar el ID: </h1>
						</div>
					</div>			
				</div>

				<div class="d-flex justify-content-center">
					<div id="alert_alert" class="neu-container-alert mt-4" style="display: none;">
						<div class="neu-alert neu-alert-error-tipo">
							<h4 class="text-center text-white">Error al guardar: </h4>
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

	<script>

		var si_error_no = '<?php echo $ver_errores; ?>'
		var idlogistica = '<?php  echo $idlogistica_encriptada;?>'
		

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
				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
			});	

			// $("#yes").click(function(){
			// 	location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#verdocumentacion`);
			// });	

			// $("#nel").click(function(){
			// 	location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
			// });
		});

		function redireccionPagina(){
			delayPagina();
			contadorRedirigir();		
		}

		function delayPagina(){
			var delay = 3000;
			setTimeout(() => {
				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
			}, delay);
		}

		function contadorRedirigir(){
			$('.numero-contador').each(function () { 
				$(this).prop('Counter', 3).animate(
					{ 
						Counter: $(this).text() 
					}, 
					{ 
						duration: 3000, 
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