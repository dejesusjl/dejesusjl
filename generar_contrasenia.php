<?php 

session_start();  
include_once "../../config.php"; 
include_once "../../recuperar_usuario.php"; 


date_default_timezone_set('America/Mexico_City');
$fecha_generacion= date("Y-m-d H:i:s");
$now= date("Y-m-d");



$mod_date = strtotime($now."+ 30 days");
$fecha_caducidad = date("Y-m-d 23:59:59",$mod_date);


$usuario_creador=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];

// $nombre_usuario=$_REQUEST['usser']; 
// $sigla_ccp=$_POST['ccp']; 




$inicio = rand(1, 1000000);
$fin = rand(10000000, 999999999999);

$final_rnd = rand($inicio, $fin);



$mensaje = 'INI: '.$inicio." FN: ".$fin." gen: ".$final_rnd;

$sql10= "SELECT *FROM usuarios WHERE idusuario='$usuario_creador'";
$result10=mysql_query($sql10);
while ( $fila10 = mysql_fetch_array($result10)) {
	$nombre_usuario="$fila10[usuario]";
	$sigla_ccp="$fila10[sigla_ccp]";
}


$sql1= "SELECT *FROM usuarios_empleados WHERE idempleados='$empleados'";
$result1=mysql_query($sql1);
while ( $fila1 = mysql_fetch_array($result1)) {
	$password_anterior="$fila1[password]";
}

$password_completa = $nombre_usuario.''.$sigla_ccp.''.$final_rnd;

$password_nueva = md5($password_completa);





$sql0= "INSERT INTO bitacora_passwords (password_anterior, password_nueva, password_completa, usuario_creador, fecha_generacion, fecha_caducidad) VALUES (
'$password_anterior', 
'$password_nueva', 
'$password_completa', 
'$usuario_creador', 
'$fecha_generacion', 
'$fecha_caducidad'

)";
$result0=mysql_query($sql0);



if ($result0 == 1) {
	$sql3= "UPDATE usuarios_empleados SET password = '$password_nueva', fecha_caducidad_password = '$fecha_caducidad', fecha_creacion_password = '$fecha_generacion' WHERE idempleados='$empleados'";
	$result3=mysql_query($sql3);
	$new_cad = strtotime($fecha_caducidad);
	$cook_compuesta = base64_encode($usuario_creador);

	setcookie("727ef72b3185358e1425e7d37e9a81b4",$empleados, $new_cad);
	echo $password_nueva;
}else{
	echo "Ocurrio un error. Favor de notificarlo";
}









?>