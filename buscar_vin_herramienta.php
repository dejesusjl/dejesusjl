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

$q = trim($_POST['valorHerramienta']);
$okkk = trim($_POST['contador_nuevo_vin']);

$okkk = ($okkk == "" || $okkk == null ) ? "0" : $okkk;

$query_utilitarios = "SELECT * from catalogo_unidades_utilitarios WHERE trim(vin) LIKE '%".$q."%' ||  marca LIKE '%".$q."%' ||  version LIKE '%".$q."%' ||  modelo LIKE '%".$q."%' || comentario = '%".$q."%' LIMIT 5";
$result_utilitarios = mysql_query($query_utilitarios);

if(mysql_num_rows($result_utilitarios) >=1){

	$tipo = "Utilitario";
	while($row_utilitario = mysql_fetch_array($result_utilitarios)){

		if ($okkk > 0) {

			$mensaje.="
			<div class='content-op-busqueda-2'>
			<i class='fas fa-car icon-busqueda'></i>
			<option class='sugerencias_herramienta$okkk efecto-sugerencia' value='$row_utilitario[idcatalogo_unidades_utilitarios];$row_utilitario[vin];$row_utilitario[marca];$row_utilitario[version];$row_utilitario[color];$row_utilitario[modelo];$tipo'>$row_utilitario[vin] - $row_utilitario[marca]- $row_utilitario[version]- $row_utilitario[color]- $row_utilitario[modelo]</option>
			</div>
			";

		}else {

			$mensaje.="
			<div class='content-op-busqueda-2'>
			<i class='fas fa-car icon-busqueda'></i>
			<option class='sugerencias_herramienta efecto-sugerencia' value='$row_utilitario[idcatalogo_unidades_utilitarios];$row_utilitario[vin];$row_utilitario[marca];$row_utilitario[version];$row_utilitario[color];$row_utilitario[modelo];$tipo'>$row_utilitario[vin] - $row_utilitario[marca]- $row_utilitario[version]- $row_utilitario[color]- $row_utilitario[modelo]</option>
			</div>
			";
		}
	}
	
}else {

	$tipo1 = "Unidad";
	$query_unidad = "SELECT * from inventario WHERE  vin_numero_serie LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' ||  marca LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' ||  version LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' ||  modelo LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' LIMIT 5";
	$result_unidad = mysql_query($query_unidad);

	if(mysql_num_rows($result_unidad) >=1){
		
		while($row_unidad = mysql_fetch_array($result_unidad)){

			if ($okkk > 0) {

				$mensaje.="
				<div class='content-op-busqueda-2'>
				<i class='fas fa-car icon-busqueda'></i>
				<option class='sugerencias_herramienta$okkk efecto-sugerencia' value='$row_unidad[idinventario];$row_unidad[vin_numero_serie];$row_unidad[marca];$row_unidad[version];$row_unidad[color];$row_unidad[modelo];$tipo1'>$row_unidad[vin_numero_serie] - $row_unidad[marca]- $row_unidad[version]- $row_unidad[color]- $row_unidad[modelo]</option>
				</div>
				";

			}else{

				$mensaje.="
				<div class='content-op-busqueda-2'>
				<i class='fas fa-car icon-busqueda'></i>
				<option class='sugerencias_herramienta efecto-sugerencia' value='$row_unidad[idinventario];$row_unidad[vin_numero_serie];$row_unidad[marca];$row_unidad[version];$row_unidad[color];$row_unidad[modelo];$tipo1'>$row_unidad[vin_numero_serie] - $row_unidad[marca]- $row_unidad[version]- $row_unidad[color]- $row_unidad[modelo]</option>
				</div>
				";
			}


		}

	}else{

		$tipo2 = "Trucks";
		$query_trucks = "SELECT * from inventario_trucks WHERE  vin_numero_serie LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' ||  marca LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' ||  version LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' ||  modelo LIKE '%".$q."%' and estatus_unidad <> 'Utilitaria' LIMIT 5";
		$result_trucks = mysql_query($query_trucks);

		if(mysql_num_rows($result_trucks) >= 1){
			
			while($row_trucks = mysql_fetch_array($result_trucks)){

				if ($okkk > 0) {

					$mensaje.="
					<div class='content-op-busqueda-2'>
					<i class='fas fa-truck icon-busqueda'></i>
					<option class='sugerencias_herramienta$okkk efecto-sugerencia' value='$row_trucks[idinventario_trucks];$row_trucks[vin_numero_serie];$row_trucks[marca];$row_trucks[version];$row_trucks[color];$row_trucks[modelo];$tipo2'>$row_trucks[vin_numero_serie] - $row_trucks[marca]- $row_trucks[version]- $row_trucks[color]- $row_trucks[modelo]</option>
					</div>
					";

				}else {

					$mensaje.="
					<div class='content-op-busqueda-2'>
					<i class='fas fa-truck icon-busqueda'></i>
					<option class='sugerencias_herramienta efecto-sugerencia' value='$row_trucks[idinventario_trucks];$row_trucks[vin_numero_serie];$row_trucks[marca];$row_trucks[version];$row_trucks[color];$row_trucks[modelo];$tipo2'>$row_trucks[vin_numero_serie] - $row_trucks[marca]- $row_trucks[version]- $row_trucks[color]- $row_trucks[modelo]</option>
					</div>
					";
				}


			}

		}else{

			$indefinido = "Indefinido";
			$query_indefinido = "SELECT * from orden_logistica_inventario where vin like '%".$q."%' and visible ='SI' || marca like '%".$q."%' and visible ='SI' || version like '%".$q."%' and visible ='SI' || color like '%".$q."%' and visible ='SI'";
			$result_indefinido = mysql_query($query_indefinido);

			if (mysql_num_rows($result_indefinido) >= 1) {
				
				while ($row_indefinido = mysql_fetch_array($result_indefinido)) {

					if ($okkk > 0) {

						$mensaje.="
						<div class='content-op-busqueda-2'>
						<i class='fas fa-car icon-busqueda'></i>
						<option class='sugerencias_herramienta$okkk efecto-sugerencia' value='$row_indefinido[idorden_logistica_inventario];$row_indefinido[vin];$row_indefinido[marca];$row_indefinido[version];$row_indefinido[color];$row_indefinido[modelo];$indefinido'>$row_indefinido[vin_numero_serie] - $row_indefinido[marca]- $row_indefinido[version]- $row_indefinido[color]- $row_indefinido[modelo]</option>
						</div>
						";

					}else {
						$mensaje.="
						<div class='content-op-busqueda-2'>
						<i class='fas fa-car icon-busqueda'></i>
						<option class='sugerencias_herramienta efecto-sugerencia' value='$row_indefinido[idorden_logistica_inventario];$row_indefinido[vin];$row_indefinido[marca];$row_indefinido[version];$row_indefinido[color];$row_indefinido[modelo];$indefinido'>$row_indefinido[vin_numero_serie] - $row_indefinido[marca]- $row_indefinido[version]- $row_indefinido[color]- $row_indefinido[modelo]</option>
						</div>
						";
					}

				}

			}else{

				$indefinido = "Indefinido";
				echo '<b>VIN NO Encontrado</b>';
				$mensaje.="
				<div class='content-op-busqueda-2'>
				<i class='fas fa-car icon-busqueda'></i>
				<option class='sugerencias_herramienta efecto-sugerencia' value=';;;;;;$indefinido'>Click Aquí Para Habilitar Formulario</option>
				</div>
				";

			}
		}
	}
}



























echo $mensaje;
?>
