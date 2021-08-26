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

$type = base64_decode($_REQUEST['type']);
$vn_personal = base64_decode($_REQUEST['vn_personal']);
$acciones_personal_vin = trim($_REQUEST['acciones_personal_vin']);
$tipo = trim($type);
$vin_personal = trim($vn_personal);




if ($tipo == "vin") {

  $query_vine = "SELECT * FROM catalogo_unidades_utilitarios WHERE TRIM(vin) = '$vin_personal'";
  $result_vine = mysql_query($query_vine);

  while ($row_vine = mysql_fetch_array($result_vine)) {
   $id_vin = "$row_vine[idcatalogo_unidades_utilitarios]";
 }
 $update_vin = "UPDATE catalogo_unidades_utilitarios SET estatus_unidad = '$acciones_personal_vin' WHERE idcatalogo_unidades_utilitarios = '$id_vin'";
 $result_vin = mysql_query($update_vin);

 if ($result_vin == 1) {
  echo "1";
}else{
  echo "0";
}

}elseif ($tipo == "Personal") {

  $update_personal = "UPDATE empleados SET columna_a = '$acciones_personal_vin' WHERE idempleados = '$vin_personal'";
  $result_personal = mysql_query($update_personal);

  if ($result_personal == 1) {
    echo "1";
  }else{
    echo "0";
  }

}else{
  echo "pocajontas";
}
