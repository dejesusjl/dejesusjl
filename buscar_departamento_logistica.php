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


$id_departamento = trim($_REQUEST['id_d']);

//$id_departamento = "22";

$query = "SELECT * FROM orden_logistica_tipo_orden_departamento WHERE visible = 'SI' and iddepartamento = '$id_departamento' ";
$result	= mysql_query($query);

while ($row = mysql_fetch_array($result)) {
	
	$name_orden = "SELECT * FROM orden_logistica_tipo_orden WHERE idorden_logistica_tipo_orden = '$row[idtipo_orden]' ";
	$result_name = mysql_query($name_orden);

	while ($row_name = mysql_fetch_array($result_name)) {
		$tipo .= "<option value='$row_name[idorden_logistica_tipo_orden]'>$row_name[nombre]</option>";
	}


}

$uno = "<option value=''>Selecciona una opción...</option>";

echo $uno.$tipo;

?>