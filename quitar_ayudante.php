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

// Start Querys

$id_ayudante_baja = trim($_REQUEST['id_ayudante_baja']);
$tipo_ayudante_baja = trim($_REQUEST['tipo_ayudante_baja']);

$idlogistica = $_REQUEST['idorden_logistica_ayudante'];
$idorden_logistica_ayudante_encript = $_REQUEST['numberid'];


$funcion_nombres = nombres_datos(base64_decode($id_ayudante_baja), base64_decode($tipo_ayudante_baja));
$name_eliminar = explode("|", $funcion_nombres);


$nombre_ayudante_table = "$name_eliminar[0] $name_eliminar[1]";


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
				$nombre = "$row_proveedor[nombre]"; 
				$apellidos = "$row_proveedor[apellidos]"; 
				$alias = "$row_proveedor[alias]"; 
				$telefono = "$row_proveedor[telefono_celular]"; 
				$telefono_otro = "$row_proveedor[telefono_otro]"; 
				$estado_cliente = "$row_proveedor[estado]"; 
				$municipio_cliente = "$row_proveedor[delmuni]"; 
				$calle_cliente = "$row_proveedor[calle]"; 
				$colonia_cliente = "$row_proveedor[colonia]"; 
				$cp_cliente = "$row_proveedor[cp_cliente]";
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
				$nombre = "$row_proveedor_tem[nombre]"; 
				$apellidos = "$row_proveedor_tem[apellidos]"; 
				$alias = "$row_proveedor_tem[alias]"; 
				$telefono = "$row_proveedor_tem[telefono_celular]"; 
				$telefono_otro = "$row_proveedor_tem[telefono_otro]"; 
				$estado_cliente = "$row_proveedor_tem[estado]"; 
				$municipio_cliente = "$row_proveedor_tem[delmuni]"; 
				$calle_cliente = "$row_proveedor_tem[calle]"; 
				$colonia_cliente = "$row_proveedor_tem[colonia]"; 
				$cp_cliente = "$row_proveedor_tem[codigo_postal]";
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
				$apellidos = "$row_colaborador[apellido_paterno]"." "."$row_colaborador[apellido_materno]"; 
				$alias = "$row_colaborador[columna_b]"; 
				$telefono = "$row_colaborador[telefono_personal]"; 
				$telefono_otro = "$row_colaborador[telefono_emergencia]"; 
				$estado_cliente = "$row_colaborador[estado]"; 
				$municipio_cliente = "$row_colaborador[municipio]"; 
				$calle_cliente = "$row_colaborador[calle_numero]"; 
				$colonia_cliente = "$row_colaborador[colonia]"; 
				$cp_cliente = "$row_colaborador[cp]";
				$nomenclatura_co = "$row_colaborador[columna_b]";
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


?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="" >
	<meta name="author" content="">
	<meta name="keywords" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="./style2.css">
	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/quicksand.css">
	<link rel="stylesheet" href="../../assets/css/style.css">
	<link rel="stylesheet" href="../../assets/css/alert_popup.css">
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
	<title>CCP | Eliminar Acompañante</title>
	<style>

		.sugerencias_colaborador:hover{
			background-color: #adadad;
			cursor:default; 
		}

		.sugerencias_herramienta:hover{
			background-color: #adadad;
			cursor:default; 
		}

		.sugerencias_tarjeta:hover{
			background-color: #adadad;
			cursor:default; 
		}
	</style>
</head>
<body>
	<div class="container-fluid p-0">
		<?php 
		include_once "menu.php"; 
		?>
		<div class="error-form" style="background: rgba(255, 255, 255, 1); width: 100%; height: 100vh; position: fixed; z-index: 9999; top: 0px; display: none;">
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
		<div class="col-sm-9 col-xs-12 content pt-3 p-0">
			<div class="row mt-3 m-0">
				<div class="col-sm-12">
					<div class="mt-1 mb-3 p-3 button-container fondo-container">

						<ol class="breadcrumb fondo-encabezados">
							<li>
								<a href="index.php" class="text-white">Inicio</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li>
								<a class="text-white" href="orden_logistica_detalles.php?idib=<?php echo $idlogistica; ?>">Regresar a Logística <b><?php echo base64_decode($idlogistica); ?></b></a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li  class="active text-white">
								<strong>Eliminar Acompañante</strong>
							</li>
						</ol>

						<br>
						
						<?php 
						date_default_timezone_set('America/Mexico_City');
						$fecha_creacion = date("Y-m-d H:i:s");
						?>

						<form action="baja_ayudante_logistica.php" method="POST" onsubmit="return validar_ayudante();">
							<div class="col-sm-12">
								<div class="form-group row">


									<div class="col-sm-12">
										<label for="nombre_ayudante_name">Nombre Acompañante:</label>
										<input type="text" class="form-control" id="nombre_ayudante_name" name="nombre_ayudante_name" readonly="" value="<?php echo $nombre_ayudante_table; ?>">
									</div>

									<div class="col-sm-6">
										<label for="id_ayudante_baja">*ID:</label>
										<input class="form-control" type="text" id="id_ayudante_baja" name="id_ayudante_baja" readonly="" value="<?php echo base64_decode($id_ayudante_baja) ?>" />
									</div>


									<div class="col-sm-6">
										<label for="tipo_ayudante_baja">*Tipo Ayudante:</label>
										<input class="form-control" type="text" id="tipo_ayudante_baja" name="tipo_ayudante_baja" readonly="" value="<?php echo base64_decode($tipo_ayudante_baja) ?>" />
									</div>


									<div class="col-sm-12">
										<label for="comentario_baja_ayudante">*Comentario:</label>
										<textarea class="form-control" name="comentario_baja_ayudante" id="comentario_baja_ayudante" cols="30" rows="3"></textarea>     
									</div>

									<input type="hidden" name="fecha_creacion_ayudante_baja" value="<?php echo $fecha_creacion; ?>">
									<input type="hidden" name="coordenadas" id="coordenadas" >
									<input type="hidden" name="logistica" value="<?php echo $idlogistica ?>" >
									<input type="hidden" name="idorden_logistica_ayudante_encript" id="idorden_logistica_ayudante_encript"  value ="<?php echo $idorden_logistica_ayudante_encript; ?>">







									<div class="col-sm-12">
										<center>
											<br>	
											<button class="btn-lg btn-primary" id="show_date" type="submit">Guardar</button>
										</center>
									</div>














								</div>
							</div>
						</form>




					</div>


				</div>



			</div>

			<?php 
			include_once '../footer.php';
			?>

		</div>
	</div>
</div>
<script src="../../datapicker_moder/lib/compressed/picker.js"></script>
<script src="../../datapicker_moder/lib/compressed/picker.date.js"></script>
<script src="../../datapicker_moder/lib/compressed/picker.time.js"></script>
<script src="../../assets/js/popper.min.js"></script>
<!--Bootstrap-->
<script src="../../assets/js/bootstrap.min.js"></script>
<!--Sweet alert JS-->
<script src="../../assets/js/sweetalert.js"></script>
<!--Progressbar JS-->
<script src="../../assets/js/progressbar.min.js"></script>
<!--Charts-->
<!--Canvas JS-->
<script src="../../assets/js/charts/canvas.min.js"></script>
<!--Bootstrap Calendar JS-->
<script src="../../assets/js/calendar/bootstrap_calendar.js"></script>
<script src="../../assets/js/calendar/demo.js"></script>
<!--Bootstrap Calendar-->
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


	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var latitud = position.coords.latitude;
			var longitud = position.coords.longitude;
			var coordenadas = latitud + " " + longitud;
			$("#coordenadas").val(coordenadas);

		}, function() {
			handleLocationError(true);
		});
	} else {

		handleLocationError(false);
	}






	function validar_ayudante(){

		
		var txtid_colaborador_ayudante = $("#id_ayudante_baja").val();
		var txttipo_ayu_prov = $("#tipo_ayudante_baja").val();
		var txtcomentarios_ayudante = $("#comentario_baja_ayudante").val();


		if(txtcomentarios_ayudante == null || txtcomentarios_ayudante.length == 0 || /^\s+$/.test(txtcomentarios_ayudante)){
			// alert('ERROR: Debes ingresar un comentario');
			$(".error-form").show();
			$(".text-error").html("ERROR: Debes ingresar un comentario");

			setTimeout(function(){
				$(".error-form").fadeOut(1000);
			}, 1500);
			$("#comentario_ayudante").focus();
			return false;
		}

		if(txtid_colaborador_ayudante == null || txtid_colaborador_ayudante.length == 0 || /^\s+$/.test(txtid_colaborador_ayudante)){
			// alert('ERROR: Con el Acompañante');
			$(".error-form").show();
			$(".text-error").html("ERROR: Con el Acompañante");

			setTimeout(function(){
				$(".error-form").fadeOut(1000);
			}, 1500);
			return false;
		}

		if(txttipo_ayu_prov == null || txttipo_ayu_prov.length == 0 || /^\s+$/.test(txttipo_ayu_prov)){
			// alert('ERROR: Con el Acompañante');
			$(".error-form").show();
			$(".text-error").html("ERROR: Con el Acompañante");

			setTimeout(function(){
				$(".error-form").fadeOut(1000);
			}, 1500);
			return false;
		}

		return true;
	}



</script>


<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKNm5FUjlIYRpuH8aquS6q-7NzQdlAwgc">
</script>





</body>
</html>