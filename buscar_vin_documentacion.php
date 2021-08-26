<?php
include_once "../../config.php";  

$q = $_POST['valorHerramienta'];

$query_unidades = "SELECT * FROM inventario WHERE estatus_unidad <> 'Utilitaria' and (vin_numero_serie LIKE '%".$q."%' || marca LIKE '%".$q."%' || version LIKE '%".$q."%' || modelo LIKE '%".$q."%') LIMIT 5";
$result_unidades = mysql_query($query_unidades);

if(mysql_num_rows($result_unidades)>=1){

	while($row_unidad = mysql_fetch_array($result_unidades)){

		$mensaje.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-car icon-busqueda'></i>
			<option class='sugerencias_vin_documentacion efecto-sugerencia' value='$row_unidad[idinventario];$row_unidad[vin_numero_serie];$row_unidad[marca];$row_unidad[version];$row_unidad[color];$row_unidad[modelo];Unidad'>$row_unidad[vin_numero_serie] - $row_unidad[marca]- $row_unidad[version]- $row_unidad[color]- $row_unidad[modelo] Unidad</option>
		</div>
		";
	}

}else{
	
	$query_trucks = "SELECT * FROM inventario_trucks WHERE estatus_unidad <> 'Utilitaria' AND (vin_numero_serie LIKE '%".$q."%' || marca LIKE '%".$q."%' || version LIKE '%".$q."%' || modelo LIKE '%".$q."%') LIMIT 5";
	$result_trucks = mysql_query($query_trucks);

	if(mysql_num_rows($result_trucks) >=1){

		while($row_trucks = mysql_fetch_array($result_trucks)){

			$mensaje.="
			<div class='content-op-busqueda-2'>
			<i class='fas fa-truck icon-busqueda'></i>
				<option class='sugerencias_vin_documentacion efecto-sugerencia' value='$row_trucks[idinventario_trucks];$row_trucks[vin_numero_serie];$row_trucks[marca];$row_trucks[version];$row_trucks[color];$row_trucks[modelo];Trucks'>$row_trucks[vin_numero_serie] - $row_trucks[marca]- $row_trucks[version]- $row_trucks[color]- $row_trucks[modelo] Trucks</option>
			</div>
			";
		}

	}else{
		$indefinido = "";

		$query_indefinido = "SELECT * FROM orden_logistica_inventario where vin like '%".$q."%' and visible ='SI' || marca like '%".$q."%' and visible ='SI' || version like '%".$q."%' and visible ='SI' || color like '%".$q."%' and visible ='SI'";
		$result_indefinido = mysql_query($query_indefinido);

		if (mysql_num_rows($result_indefinido) >= 1) {

			while ($row_indefinido = mysql_fetch_array($result_indefinido)) {

				$mensaje.="
				<div class='content-op-busqueda-2'>
					<i class='fas fa-car icon-busqueda'></i>
					<option class='sugerencias_vin_documentacion efecto-sugerencia' value='$row_indefinido[idorden_logistica_inventario];$row_indefinido[vin];$row_indefinido[marca];$row_indefinido[version];$row_indefinido[color];$row_indefinido[modelo];Indefinido'>$row_indefinido[vin] - $row_indefinido[marca]- $row_indefinido[version]- $row_indefinido[color]- $row_indefinido[modelo] Indefinido</option>
				</div>
				";
			}
		}else{
			
			$mensaje.="<b>VIN NO Encontrado</b>";
		}

	}
}



echo $mensaje;
?>
