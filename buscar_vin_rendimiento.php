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

$limite=80;

$q=$_POST['valorHerramienta'];
$mensaje="";

$count=0;
$autos=0;

$cons1="select * from inventario WHERE  TRIM(vin_numero_serie) LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' ||  TRIM(marca) LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' ||  TRIM(version) LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' ||  TRIM(modelo) LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' LIMIT $limite";
$res1=mysql_query($cons1);
$tipo1 = "Unidad";
$count+=mysql_num_rows($res1);

while ($row1=mysql_fetch_array($res1)) {
	$cons11= "select * from inventario_dinamico where idinventario=$row1[idinventario] && columna='rendimiento'";//consultar sobre el idinventario de la dinamica
	$res11=mysql_query($cons11);

	while ( $row11=mysql_fetch_array($res11)) {		
		$mensaje.=  "<div class='content-op-busqueda-2'>
						<i class='fas fa-car icon-busqueda'></i>
						<option href='#origen' class='sugerencias_herramienta efecto-sugerencia' value='$row1[idinventario];$row1[vin_numero_serie];$row1[marca];$row1[version];$row1[color];$row1[modelo];$tipo1;$row11[contenido]'>$row1[vin_numero_serie] - $row1[marca]- $row1[version]- $row1[color]- $row1[modelo]</option>
					</div>";
					$autos++;
	}
}


$cons2="select * from inventario_trucks WHERE  vin_numero_serie LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' ||  marca LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' ||  version LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' ||  modelo LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' LIMIT $limite";
$res2=mysql_query($cons2);
$tipo2 = "Trucks";
$count+=mysql_num_rows($res2);

while ($row2=mysql_fetch_array($res2)) {
	$cons21= "select * from inventario_dinamico where idinventario=$row2[idinventario_trucks] && columna='rendimiento'";//consultar sobre el idinventario de la dinamica
	$res21=mysql_query($cons21);

	while ( $row21=mysql_fetch_array($res21)) {	

		$mensaje.=  "<div class='content-op-busqueda-2'>
						<i class='fas fa-truck icon-busqueda'></i>
						<option href='#origen' class='sugerencias_herramienta efecto-sugerencia' value='$row2[idinventario_trucks];$row2[vin_numero_serie];$row2[marca];$row2[version];$row2[color];$row2[modelo];$tipo2;$row11[contenido]'>$row2[vin_numero_serie] - $row2[marca]- $row2[version]- $row2[color]- $row2[modelo]</option>
					</div>";
					$autos++;
	}
}

$cons3 = "select * from catalogo_unidades_utilitarios WHERE  TRIM(vin) LIKE '%".$q."%' ||  TRIM(marca) LIKE '%".$q."%' ||  TRIM(version) LIKE '%".$q."%' ||  TRIM(modelo) LIKE '%".$q."%' || TRIM(comentario) = '%".$q."%' LIMIT $limite";
$res3=mysql_query($cons3);
$tipo3 = "Utilitario";
$count+=mysql_num_rows($res3);

while ($row3=mysql_fetch_array($res3)) {
	

	if ( $row3[rendimiento_combustible]!= null ) {	
		$mensaje.=  "<div class='content-op-busqueda-2'>
						<i class='fas fa-car icon-busqueda'></i>
						<option  href='#origen' class='sugerencias_herramienta efecto-sugerencia' value='$row3[idcatalogo_unidades_utilitarios];$row3[vin];$row3[marca];$row3[version];$row3[color];$row3[modelo];$tipo3;$row3[rendimiento_combustible]'>$row3[vin] - $row3[marca]- $row3[version]- $row3[color]- $row3[modelo]</option>
					</div>";
					$autos++;
	}
}


if ($autos==0) {
	$mensaje.="<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>
				";
}else{

}

echo $mensaje;
?>
