<?php
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
$q = $_POST['valorBusqueda'];

//$q = "dewdewd";

$query = "SELECT * FROM empleados WHERE visible = 'SI' AND nombre LIKE '%".$q."%' || apellido_paterno LIKE '%".$q."%'  ||  apellido_materno LIKE '%".$q."%'  ||  columna_b LIKE '%".$q."%'  ||  concat_ws(' ', nombre, apellido_paterno, apellido_materno)  LIKE '%".$q."%' LIMIT  10";
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

	$query_trasladista = "SELECT idasigna,tipo_asignante FROM orden_logistica where trim(tipo_asignante) <> 'Colaborador' and trim(tipo_asignante) <> '' ";
	$result_trasladista = mysql_query($query_trasladista);

	while ($row_trasladista = mysql_fetch_array($result_trasladista)) {
		$id = $row_trasladista[0];
		$tipo = $row_trasladista[1];

		$nombres = name_trasladista($id, $tipo);  

		$mensaje .= $nombres;

		
	}
}


function name_trasladista($id, $tipo) {

	if ($tipo == "Cliente") {
		
		$query_cliente = "SELECT * FROM contactos WHERE idcontacto = '$id'";
		//echo "<br>";
		$result_cliente = mysql_query($query_cliente);

		while ($row_cliente = mysql_fetch_array($result_cliente)) {

			$option = "<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='sugerencias_colaborador efecto-sugerencia' value='$row_cliente[idcontacto];$row_cliente[nombre] $row_cliente[apellidos];Cliente'>$row_cliente[nombre] - $row_cliente[apellidos] - Cliente</option>
			</div>";
		}

	}elseif ($tipo == "Proveedor") {
		
		$query_proveedor = "SELECT * FROM proveedores WHERE idproveedores = '$id'";
		//echo "<br>";
		$result_proveedor = mysql_query($query_proveedor);

		while ($row_proveedor = mysql_fetch_array($result_proveedor)) {
			
			$option = "<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='sugerencias_colaborador efecto-sugerencia' value='$row_proveedor[idcontacto];$row_proveedor[nombre] $row_proveedor[apellidos];Proveedor'>$row_proveedor[nombre] - $row_proveedor[apellidos] - Proveedor</option>
			</div>";

		}

	}elseif ($tipo == "Proveedor Temporal") {
		
		$query_proveedor_temporal = "SELECT * FROM orden_logistica_proveedores WHERE idorden_logistica_proveedores = '$id'";
		//echo "<br>";
		$result_proveedor_temporal = mysql_query($query_proveedor_temporal);

		while ($row_proveedor_temporal = mysql_fetch_array($result_proveedor_temporal)) {
			
			$option = "<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='sugerencias_colaborador efecto-sugerencia' value='$row_proveedor_temporal[idcontacto];$row_proveedor_temporal[nombre] $row_proveedor_temporal[apellidos];Proveedor Temporal'>$row_proveedor_temporal[nombre] - $row_proveedor_temporal[apellidos] - Proveedor Temporal</option>
			</div>";

		}
	}else{
		echo "<b>NO Encontrado</b>";
	}
	return $option;
}


echo $mensaje;

?>
