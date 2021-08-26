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



$q = $_POST['valorBusqueda'];

$query = "SELECT * FROM empleados WHERE visible = 'SI' AND (nombre LIKE '%".$q."%' || apellido_paterno LIKE '%".$q."%' ||  apellido_materno LIKE '%".$q."%' ||  columna_b LIKE '%".$q."%' ||  concat_ws(' ', nombre, apellido_paterno, apellido_materno) LIKE '%".$q."%' ) LIMIT 5";
$result = mysql_query($query);

if (mysql_num_rows($result) >= 1) {

	$colaborador = "Colaborador";
	while ($row = mysql_fetch_array($result)) {
		$mensaje.="<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='sugerencias_asesor efecto-sugerencia' value='$row[idempleados];$row[nombre] $row[apellido_paterno] $row[apellido_materno];$colaborador'>$row[nombre] - $row[apellido_paterno] - $row[apellido_materno]</option>
		</div>
		";
	}
}else{

	$mensaje.="<div class=''>
	<option class='sugerencias_asesor' value='$q;$q;$q'>$q </option>
	</div>
	";

}


echo $mensaje;


?>
