<link rel='stylesheet' href='../../assets/css/style.css'>
<link rel='stylesheet' href='../../assets/css/alert_popup.css'>
<script src='../../js/jquery-1.10.2.js'></script>
<div class='error-form' style='background: rgba(255, 255, 255, 1); width: 100%; height: 100vh; position: fixed; z-index: 9999; top: 0px; display: none;'>
	<div style='position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%);'>
		<div class='popup-mensaje popuperror animatepopup'>
			<div style='padding: 10px 20px; background: #F13154;'>
				<div class='error'>
					<span class='icono-error'></span>
				</div>
			</div>
			<div class='text-center mt-2' style='padding: 10px 20px;'>
				<h1 style='font-size: 22px;' class='text-error'></h1>
			</div>
		</div>
	</div>
</div>
<div class="listo-form" style="display: none; background: rgba(255,255,255,.9); width: 100%; height: 100vh; position: fixed; z-index: 9999; top: 0;">
	<div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%);">
		<div class="popup-mensaje popuplisto">
			<div style="padding: 10px 20px; background: #25E28C;">
				<div class="listo">
					<span class="icono-listo"></span>
				</div>
			</div>
			<div class="text-center mt-2" style="padding: 10px 20px;">
				<h1 style="font-size: 22px;" class="text-listo"></h1>
			</div>
		</div>
	</div>
</div>
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


$idbitacora = $_REQUEST['idbitacora'];
$id_logistica = $_REQUEST['id_logistica'];

if (sizeof($idbitacora) != 0 || $idbitacora != null) {
	$count = 0;
	foreach ($idbitacora as $value) {
		$update_bitacora = "UPDATE orden_logistica_bitacora SET visible = 'NO' WHERE idorden_logistica_bitacora = '$value'";
		$result = mysql_query($update_bitacora);
		if ($result == 1) {
			$count ++;
		}else{
			$count .= $value." ";
		}
		
	}

	if (sizeof($idbitacora) == $count) {
		echo "
		<script language='javascript' type='text/javascript'>
		// alert('Datos Guardados Exitosamente');
		$('.listo-form').show();
		$('.text-listo').html('Datos Guardados Exitosamente');

		setTimeout(function(){
			$('.listo-form').fadeOut(1000);
			document.location.replace('delete_bitacora.php?value=$id_logistica');
		}, 1500);
		</script>
		";
	}else{
		echo "
		<script language='javascript' type='text/javascript'>
		// alert('ERROR con el movimiento: $count');
		$('.error-form').show();
		$('.text-error').html('ERROR con el movimiento: $count');

		setTimeout(function(){
			$('.error-form').fadeOut(1000);
			document.location.replace('delete_bitacora.php?value=$id_logistica');
		}, 1500);
		</script>
		";
	}


}else{
	echo "
	<script language='javascript' type='text/javascript'>
	// alert('No hay nada que hacer, No seleccionaste algun movimiento');
	$('.error-form').show();
	$('.text-error').html('No hay nada que hacer, No seleccionaste algún movimiento');

	setTimeout(function(){
		$('.error-form').fadeOut(1000);
		document.location.replace('delete_bitacora.php?value=$id_logistica'); 
	}, 1500);
	</script>
	";
}

?>