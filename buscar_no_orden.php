<?php 
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
date_default_timezone_set('America/Mexico_City');
$q = $_POST['valorBusqueda'];


$query_orden = "SELECT * FROM atencion_clientes WHERE idatencion_clientes = '$q' and (estatus <> 'Resuelto' and estatus <> 'Cancelado')";
$result_orden = mysql_query($query_orden); 

if (mysql_num_rows($result_orden) >=1) {

	while ($row_orden = mysql_fetch_array($result_orden)) {

		echo $row_orden[caso];

	}

}else{
	echo "0";
}


?>