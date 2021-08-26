<?php
include_once "../../config.php";  


$q = $_POST['valorBusqueda'];


//$q  = "OXXO GAS ATLACOMULCO SA DE CV";



#------------------------------------------- Cliente --------------------------------------------------------------------------------

$sql = "SELECT * from contactos WHERE  nombre LIKE '%$q%' ||  apellidos LIKE '%$q%' ||  alias LIKE '%$q%' ||  telefono_celular LIKE '%$q%'  ||  telefono_otro LIKE '%$q%' || concat_ws(' ', nombre, apellidos) like '%$q%' || concat_ws(' ', apellidos, nombre) LIKE '%$q%' || idcontacto = '$q' LIMIT 5 ";
$res = mysql_query($sql);


if (mysql_num_rows($res) >= 1) {

	while($fila=mysql_fetch_array($res)){

		$tipo = "Cliente";
		$mensaje.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='sugerencias_cliente efecto-sugerencia' value='$fila[idcontacto];$fila[nombre];$fila[apellidos];$fila[alias];$fila[telefono_celular];$fila[telefono_otro];$fila[estado];$fila[delmuni];$fila[colonia];$fila[calle];$fila[codigo_postal];$tipo'>$fila[nombre] - $fila[apellidos] - $fila[alias] $tipo</option>
		</div>
		";
	}
	
}else {

	$contador_cliente = 1;

}

#------------------------------------------- Proveedor --------------------------------------------------------------------------------


$sql1 = "SELECT * from proveedores WHERE nombre LIKE '%$q%' || apellidos LIKE '%$q%' || alias LIKE '%$q%' || concat_ws(' ', nombre, apellidos) like '%$q%' || concat_ws(' ', apellidos, nombre) like '%$q%' || idproveedores = '$q'LIMIT 5";
$res1 = mysql_query($sql1);

if (mysql_num_rows($res1) >= 1) {

	while ($fila1 = mysql_fetch_array($res1)) {
		$tipo = "Proveedor";
		$mensaje.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='sugerencias_cliente efecto-sugerencia' value='$fila1[idproveedores];$fila1[nombre];$fila1[apellidos];$fila1[alias];$fila1[telefono_celular];$fila1[telefono_otro];$fila1[estado];$fila1[delmuni];$fila1[colonia];$fila1[calle];$fila1[codigo_postal];$tipo'>$fila1[nombre] - $fila1[apellidos] - $tipo</option>
		</div>
		";		
	}
	
}else {
	$contador_proveedor = 1;
}

#------------------------------------------- Proveedor Temporal --------------------------------------------------------------------------------

$sql3 = "SELECT * from orden_logistica_proveedores WHERE nombre LIKE '%$q%' || apellidos LIKE '%$q%' || alias LIKE '%$q%' || concat_ws(' ', nombre, apellidos) like '%$q%' || idorden_logistica_proveedores = '$q' LIMIT 5";
$res3 = mysql_query($sql3);

if (mysql_num_rows($res3) >= 1) {

	while ($fila3 = mysql_fetch_array($res3)) {
		$tipo = "Proveedor Temporal";
		$mensaje.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='sugerencias_cliente efecto-sugerencia' value='$fila3[idorden_logistica_proveedores];$fila3[nombre];$fila3[apellidos];$fila3[alias];$fila3[telefono_celular];$fila3[telefono_otro];$fila3[estado];$fila3[delmuni];$fila3[colonia];$fila3[calle];$fila3[codigo_postal];$tipo'>$fila3[nombre] - $fila3[apellidos] - $tipo</option></div>
		";		
	}
}else {
	$contador_temporal = 1;
}
#------------------------------------------- Colaborador --------------------------------------------------------------------------------

$sql2 = "SELECT * from empleados WHERE nombre LIKE '%$q%' || apellido_paterno LIKE '%$q%' || apellido_materno LIKE '%$q%' || columna_b LIKE '%$q%' || concat_ws(' ', nombre, apellido_paterno, apellido_materno) LIKE '%$q%' || idempleados = '$q' LIMIT 5";
$res2 = mysql_query($sql2);

if (mysql_num_rows($res2) >= 1) {

	while ($fila2 = mysql_fetch_array($res2)) {
		$tipo = "Colaborador";
		$apellidos = $fila2[apellido_paterno]." ".$fila2[apellido_materno];

		$mensaje.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='sugerencias_cliente efecto-sugerencia' value='$fila2[idempleados];$fila2[nombre];$apellidos;$fila2[columna_b];$fila2[telefono_personal];$fila2[telefono_otro];$fila2[estado];$fila2[municipio];$fila2[colonia];$fila2[calle_numero];$fila2[cp];$tipo'>$fila2[nombre] - $apellidos - $fila2[columna_b] $tipo</option>
		</div>
		";		
	}
}else{
	$contador_colaborador = '1';
}

#------------------------------------------- Proveedores INFO --------------------------------------------------------------------------------

$query_info = "SELECT * from proveedores_info WHERE nombre LIKE '%$q%' || apellidos LIKE '%$q%' || alias LIKE '%$q%' || concat_ws(' ', nombre, apellidos) like '%$q%' || concat_ws(' ', apellidos, nombre) like '%$q%' || idproveedores_info = '$q' LIMIT 5";
$result_info = mysql_query($query_info);

if (mysql_num_rows($result_info) >= 1) {

	while ($row_proveedor_info = mysql_fetch_array($result_info)) {
		$tipo = "Proveedor Info";
		$mensaje.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='sugerencias_cliente efecto-sugerencia' value='$row_proveedor_info[idproveedores_info];$row_proveedor_info[nombre];$row_proveedor_info[apellidos];$row_proveedor_info[alias];$row_proveedor_info[telefono_celular];$row_proveedor_info[telefono_otro];$row_proveedor_info[estado];$row_proveedor_info[delmuni];$row_proveedor_info[colonia];$row_proveedor_info[calle];$row_proveedor_info[codigo_postal];$tipo'>$row_proveedor_info[nombre] - $row_proveedor_info[apellidos] - $row_proveedor_info[moneda] - $tipo</option>
		</div>
		";		
	}
	
}else {
	$contador_proveedor = 1;
}

#------------------------------------------- Prospectos --------------------------------------------------------------------------------

$query_prospectos = "SELECT * from prospectos WHERE nombre LIKE '%$q%' || apellidos LIKE '%$q%' || alias LIKE '%$q%' || concat_ws(' ', nombre, apellidos) like '%$q%' || concat_ws(' ', apellidos, nombre) like '%$q%' || idprospectos = '$q' LIMIT 5";
$result_prospectos = mysql_query($query_prospectos);

if (mysql_num_rows($result_prospectos) >= 1) {
	
	while ($row_prospectos = mysql_fetch_array($result_prospectos)) {
		$tipo = "Prospectos";
		$mensaje.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='sugerencias_cliente efecto-sugerencia' value='$row_prospectos[idprospectos];$row_prospectos[nombre];$row_prospectos[apellidos];$row_prospectos[alias];$row_prospectos[telefono_celular];$row_prospectos[telefono_otro];$row_prospectos[estado];$row_prospectos[delmuni];$row_prospectos[colonia];$row_prospectos[calle];$row_prospectos[codigo_postal];$tipo'>$row_prospectos[nombre] - $row_prospectos[apellidos] - $tipo</option>
		</div>
		";		
	}
}else {
	$contador_prospectos = 1;
}


$sumatoria = $contador_cliente + $contador_proveedor + $contador_temporal + $contador_colaborador + $contador_proveedor + $contador_prospectos;

$mensaje .= ($sumatoria >= 6) ? "<b>ID NO Encontrado</b>" : "";







echo $mensaje;
?>
