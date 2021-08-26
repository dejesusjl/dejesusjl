<?php
session_start();  
include_once "../../config.php";  

$query_inventario = "SELECT * FROM inventario WHERE estatus_unidad = 'Utilitaria'";
$result_inventario = mysql_query($query_inventario);

unset($marca_utilitarioss);
unset($version_utilitarioss);
unset($color_utilitarioss);
unset($modelo_utilitarioss);
unset($vin_numero_serie_utilitarioss);
unset($transmicion_utilitarioss);
unset($matricula_utilitarioss);
unset($entidad_utilitarioss);

while ($row_inventario = mysql_fetch_array($result_inventario)) {

	$marca_utilitarioss = trim($row_inventario[marca]);
	$version_utilitarioss = trim($row_inventario[version]);
	$color_utilitarioss = trim($row_inventario[color]);
	$modelo_utilitarioss = trim($row_inventario[modelo]);
	$vin_numero_serie_utilitarioss = trim($row_inventario[vin_numero_serie]);
	$transmicion_utilitarioss = trim($row_inventario[transmision]);
	$matricula_utilitarioss = trim($row_inventario[matricula]);
	$entidad_utilitarioss = trim($row_inventario[entidad]);

	$query_utilitarias = "SELECT * FROM catalogo_unidades_utilitarios WHERE TRIM(vin) = '$vin_numero_serie_utilitarioss'";
	$result_utilitarias = mysql_query($query_utilitarias);
	if (mysql_num_rows($result_utilitarias) == 0) {	
		agregarUtilitario($marca_utilitarioss,$version_utilitarioss,$color_utilitarioss,$modelo_utilitarioss,$vin_numero_serie_utilitarioss,$transmicion_utilitarioss,$matricula_utilitarioss,$entidad_utilitarioss);
	}
	
}



$query_inventario_trucks = "SELECT * FROM inventario_trucks WHERE estatus_unidad = 'Utilitaria'";
$result_inventario_trucks = mysql_query($query_inventario_trucks);

unset($marca_utilitarioss);
unset($version_utilitarioss);
unset($color_utilitarioss);
unset($modelo_utilitarioss);
unset($vin_numero_serie_utilitarioss);
unset($transmicion_utilitarioss);
unset($matricula_utilitarioss);
unset($entidad_utilitarioss);

while ($row_inventario_truscks = mysql_fetch_array($result_inventario_trucks)) {
	
	$marca_utilitarioss = trim($row_inventario_truscks[marca]);
	$version_utilitarioss = trim($row_inventario_truscks[version]);
	$color_utilitarioss = trim($row_inventario_truscks[color]);
	$modelo_utilitarioss = trim($row_inventario_truscks[modelo]);
	$vin_numero_serie_utilitarioss = trim($row_inventario_truscks[vin_numero_serie]);
	$transmicion_utilitarioss = trim($row_inventario_truscks[transmicion]);
	$matricula_utilitarioss = trim($row_inventario_truscks[matricula]);
	$entidad_utilitarioss = trim($row_inventario_truscks[entidad]);

	$query_utilitarias_truks = "SELECT * FROM catalogo_unidades_utilitarios WHERE TRIM(vin) = '$vin_numero_serie_utilitarioss'";
	$result_utilitarias_truks = mysql_query($query_utilitarias_truks);

	if (mysql_num_rows($result_utilitarias_truks) == 0) {	
		
		agregarUtilitario($marca_utilitarioss,$version_utilitarioss,$color_utilitarioss,$modelo_utilitarioss,$vin_numero_serie_utilitarioss,$transmicion_utilitarioss,$matricula_utilitarioss,$entidad_utilitarioss);

	}
	
}

$query_empleados_cambiar_estatus = "SELECT * FROM empleados WHERE columna_a = 'En Ruta'";
$result_empleados_cambiar_estatus = mysql_query($query_empleados_cambiar_estatus);


while ($row_empleados_cambiar_estatus = mysql_fetch_array($result_empleados_cambiar_estatus)) {

	if ($row_empleados_cambiar_estatus[puesto_actual] != "Ejecutivo de Traslado") {

		$update_cambiar_estatus = "UPDATE empleados SET columna_a = 'Disponible' WHERE idempleados = '$row_empleados_cambiar_estatus[idempleados]' ";
		$result_cambiar_estatus = mysql_query($update_cambiar_estatus);


	}
}


function agregarUtilitario($marca_utilitarioss,$version_utilitarioss,$color_utilitarioss,$modelo_utilitarioss,$vin_numero_serie_utilitarioss,$transmicion_utilitarioss,$matricula_utilitarioss,$entidad_utilitarioss) {

	$insert_utilitario = "INSERT INTO catalogo_unidades_utilitarios (marca, version, color, modelo, transmicion, vin, matricula, entidad,  visible, estatus_unidad) VALUES ('$marca_utilitarioss', '$version_utilitarioss', '$color_utilitarioss', '$modelo_utilitarioss', '$transmicion_utilitarioss', '$vin_numero_serie_utilitarioss', '$matricula_utilitarioss', '$entidad_utilitarioss', 'SI', 'Disponible')";
	$result_insert_utilitario = mysql_query($insert_utilitario);

}


?>
