<?php
session_start(); 
include_once "../../config.php"; 
include_once "../../recuperar_usuario.php";


if (isset($_COOKIE['727ef72b3185358e1425e7d37e9a81b4'])) { 
	// $_SESSION['usuario_clave'] = base64_decode($_COOKIE['727ef72b3185358e1425e7d37e9a81b4']); 
	$usuario_creador = $_SESSION['usuario_clave']; 
	$sql3= "SELECT * FROM usuarios where idusuario = '$usuario_creador'";
	$result3=mysql_query($sql3);
	while ( $fila3 = mysql_fetch_array($result3)) {
		$nombre_usuario = $fila3[nombre_usuario];
		
	}

	$lat_long = $_REQUEST['x'];
	date_default_timezone_set('America/Mexico_City');
	$actual= date("Y-m-d H:i:s");
	$ip = $_SERVER['REMOTE_ADDR'];		

	$sql="INSERT INTO datos_inicio_sesion (fecha_acceso, ip, lat_lgn, usuario,tipo) VALUES ('$actual', '$ip', '$lat_long', '$usuario_creador','Usuario')";
	$result=mysql_query($sql);
	
}else{



	if (strlen($_COOKIE['727ef72b3185358e1425e7d37e9a81b4']) === 0) {
		$_SESSION['usuario_clave']=null;
		echo "
		<script language='javascript' type='text/javascript'> 
		alert('Sesión caducada. Ingresa nuevamente para continuar…');
		document.location.replace('../../logout.php');
		</script>
		";
	}else{
		// $_SESSION['usuario_clave'] = base64_decode($_COOKIE['727ef72b3185358e1425e7d37e9a81b4']); 

		if (isset($_SESSION['usuario_clave'])) { 
			$empleado_creador = $_SESSION['usuario_clave']; 
			$sql3= "SELECT * FROM usuarios where idusuario = '$empleado_creador'";
			$result3=mysql_query($sql3);
			while ( $fila3 = mysql_fetch_array($result3)) {
				$nombre_usuario = $fila3[nombre_usuario];
			}
			$lat_long = $_REQUEST['x'];
			date_default_timezone_set('America/Mexico_City');
			$actual= date("Y-m-d H:i:s");
			$ip = $_SERVER['REMOTE_ADDR'];		

			$sql="INSERT INTO datos_inicio_sesion (fecha_acceso, ip, lat_lgn, usuario,tipo) VALUES ('$actual', '$ip', '$lat_long', '$usuario_creador','Usuario')";
			$result=mysql_query($sql);
		}else{
			echo "
			<script language='javascript' type='text/javascript'> 
			alert('Sesión caducada. Ingresa nuevamente para continuar…');
			document.location.replace('../logout.php');
			</script>
			";
		}
	}


}
?>



<?php 

session_start();  
include_once "config.php"; 
date_default_timezone_set('America/Mexico_City');


$vallogin = $_REQUEST['vallogin'];


$actual= date("Y-m-d H:i:s");




$sql0= "SELECT * FROM home_work_trello where password = '$vallogin' and visible = 'SI'";
$result0=mysql_query($sql0);
while ( $fila0 = mysql_fetch_array($result0)) {
	$fecha_caducidad="$fila0[fecha_caducidad]";	
	$idempleados=base64_encode("$fila0[idempleados]");	
}

$fecha_caducidad = date_create($fecha_caducidad);
$fecha_caducidad = date_format($fecha_caducidad, 'Y-m-d H:i:s');

if ($fecha_caducidad < $actual) {
	echo "Contrasenia caduca";
}else{
	if (strlen($_REQUEST['vallogin'])===0) {
		setcookie("ba9ba1694891e2b3bf8684a45a9e64cf","",time() + 0);
		echo "Nada";
	} else{
		if (mysql_num_rows($result0) === 1) {	
			$new_cad = strtotime($fecha_caducidad);
			$cook_compuesta = 'ce774d9cab3ae0bdf522cd0839bed364'.'.'.$vallogin.'.'.$idempleados;
			$x = $_REQUEST['x'];
			if ($x == 'SI') {		
				setcookie("ba9ba1694891e2b3bf8684a45a9e64cf",$cook_compuesta, $new_cad);
				echo "Cookie OK";
			}else if ($x === 'NO') {
				setcookie("ba9ba1694891e2b3bf8684a45a9e64cf","",time() + 0);
				echo "Cookie NO";
			}
		}else{	
			if ($x === 'NO') {
				setcookie("ba9ba1694891e2b3bf8684a45a9e64cf","",time() + 0);
				echo "Cookie NO";
			}
		}
	}
}

















?>