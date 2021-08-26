<?php
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
$q = $_POST['valorBusqueda'];



$query = "SELECT * FROM empleados WHERE visible = 'SI' AND (nombre LIKE '%".$q."%' || apellido_paterno LIKE '%".$q."%'  ||  apellido_materno LIKE '%".$q."%'  ||  columna_b LIKE '%".$q."%'  ||  concat_ws(' ', nombre, apellido_paterno, apellido_materno)  LIKE '%".$q."%')LIMIT  10";
$result = mysql_query($query);

if (mysql_num_rows($result) >= 1) {
	$colaborador = "Colaborador";

	while ($row = mysql_fetch_array($result)) {

		$mensaje.="<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='sugerencias_colaborador efecto-sugerencia' value='$row[idempleados];$row[nombre] $row[apellido_paterno] $row[apellido_materno];$colaborador'>$row[nombre] - $row[apellido_paterno] - $row[apellido_materno]</option>
		</div>";
	}
}else{

	$query_nomenclatura = "SELECT responsable FROM balance_gastos_operacion where visible = 'SI' group by responsable";
	$result_nomenclatura = mysql_query($query_nomenclatura);

	while ($row_momenclatura = mysql_fetch_array($result_nomenclatura)) {
		$mensaje .= (is_numeric($row_momenclatura[0])) ? "" : "<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='sugerencias_colaborador efecto-sugerencia' value='$row_momenclatura[0];$row_momenclatura[0];$row_momenclatura[0]'> $row_momenclatura[0] </option>
		</div>"; ;
	}

	//echo "<b>NO Encontrado</b>";
}

echo $mensaje;

?>
