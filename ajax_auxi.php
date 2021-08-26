<?php 
session_start();  
include_once "../../config.php";




$sql = "SELECT nombre FROM balance_gastos_auxiliares 
WHERE nombre LIKE '%".$_GET['query']."%' group by nombre LIMIT 10"; 


$result = mysql_query($sql);


$json = [];
while ($fila = mysql_fetch_array($result)) {
	$json[] =$fila['nombre'];
}




echo json_encode($json);


?>