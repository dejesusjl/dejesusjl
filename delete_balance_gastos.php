<?php 
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
date_default_timezone_set('America/Mexico_City');
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];


$query_usuario_creador = "SELECT * FROM usuarios WHERE idusuario = '$usuario_creador'";
$result_usuario_creador = mysql_query($query_usuario_creador);

while ($row_usuario_creador = mysql_fetch_array($result_usuario_creador)) {

    $rol_loguin = trim($row_usuario_creador[rol]);
}

include_once ($rol_loguin == "100" ) ?  "funciones_principales.php" : "../Logistica/funciones_principales.php";
include_once ($rol_loguin == "100" ) ?  "funciones_principales_insert.php" : "../Logistica/funciones_principales_insert.php";


$referencia = trim($_POST['pasar_referencia']);
$tipo = trim($_POST['tipo']);

$mensaje = "";

$query_bitacora_wallet = "SELECT * FROM wallet_bitacora WHERE visible = 'SI' AND referencia = '$referencia'";
$result_bitacora_wallet = mysql_query($query_bitacora_wallet);

while ($row_bitacora_wallet = mysql_fetch_array($result_bitacora_wallet)) {

    $buscar_name = NameUsuarioCreador($row_bitacora_wallet[usuario_creador]);
    $nombre_usuario_creador = explode("|", $buscar_name);


    $fecha_bitacora = date_create($row_bitacora_wallet[fecha_guardado]);
    $fecha_bitacora = date_format($fecha_bitacora, "d-m-Y H:i");

    $mensaje .= "
    <div class='media' style='text-align: justify;'>

    <i class='fas fa-user-tie fa-2x'></i>

    <div class='media-body'>

    <h4>$row_bitacora_wallet[tipo]</h4>
    <h5>$row_bitacora_wallet[descripcion]</h5>
    <h6>$row_bitacora_wallet[columna_c]</h6>

    <p>$nombre_usuario_creador[0]</p>

    <div class='feed-footer'>
    <span><b>$fecha_bitacora</b></span>
    </div>

    </div>
    </div>
    <hr>
    ";


}

echo $mensaje

?>