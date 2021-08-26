<?php
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s"); 
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 


$q = $_POST['valorBusqueda'];
$type_id = $_POST['type_id'];

$concatenar_resultados = array();

if ($empleados == 88 || $empleados == 3 || $empleados == 91 || $empleados == 136 || $empleados == 65) {
	
	$type_id = "Todos";
	
} else {

	$query_tipo = "SELECT * FROM orden_logistica_departamento_id WHERE iddepeartamento = '$type_id' AND visible = 'SI' ";
	$result_tipo = mysql_query($query_tipo);

	while ($row_tipo = mysql_fetch_array($result_tipo)) {

		if ($row_tipo[nombre_tabla] == "Cliente") {

			$ver_cliente = name_cliente($q);
			array_push($concatenar_resultados, $ver_cliente);

		}else if ($row_tipo[nombre_tabla] == "Proveedor") {

			$ver_proveedor = name_proveedor($q);
			array_push($concatenar_resultados, $ver_proveedor);

		}else if ($row_tipo[nombre_tabla] == "Colaborador") {

			$ver_colaborador = name_colaborador($q);
			array_push($concatenar_resultados, $ver_colaborador);

		}else if ($row_tipo[nombre_tabla] == "Proveedor Temporal") {

			$ver_proveedor_temporal = name_proveedor_temporal($q);
			array_push($concatenar_resultados, $ver_proveedor_temporal);

		}else if ($row_tipo[nombre_tabla] == "Proveedor Info") {

			$ver_proveedor_info = name_proveedor_info($q);
			array_push($concatenar_resultados, $ver_proveedor_info);

		}else if ($row_tipo[nombre_tabla] == "Prospectos") {

			$ver_prospectos = name_prospectos($q);
			array_push($concatenar_resultados, $ver_prospectos);

		} else{

			$ver_nada = "<b>ID NO Encontrado</b>";
			array_push($concatenar_resultados, $ver_nada);

		}
	}
}

$new_array = array();
foreach ($concatenar_resultados as $key => $value) {

	if ($value != "" and $value != null) {
		array_push($new_array, $value);
	}
}

if (count($new_array) == 0 ) {

	echo "<b>ID NO Encontrado</b>";

}else {

	foreach ($new_array as $key1 => $value1) {

		echo $value1;

	}
}






if ($type_id == "Todos") {



	if (trim($q) != "") {

#------------------------------------------------- CLIENTE ------------------------------------------------- ------------------------------------------------- -------------------------------------------------  
		$sql = "SELECT * FROM contactos WHERE trim(nombre) LIKE '%$q%' ||  trim(apellidos) LIKE '%$q%' ||  trim(alias) LIKE '%$q%' ||  trim(telefono_celular) LIKE '%$q%'  ||  trim(telefono_otro) LIKE '%$q%' || trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' || trim(concat_ws(' ', apellidos, nombre)) LIKE '%$q%' || idcontacto = '$q' limit 5";
		$res = mysql_query($sql);

		while($fila=mysql_fetch_array($res)){

			$tipo = "Cliente";
			$mensaje.="
			<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='option_id_logistica_generar efecto-sugerencia' value='$fila[idcontacto];$fila[nombre];$fila[apellidos];$fila[alias];$fila[telefono_celular];$fila[telefono_otro];$fila[estado];$fila[delmuni];$fila[colonia];$fila[calle];$fila[codigo_postal];$tipo;Crédito y Cobranza'>$fila[idcontacto] $fila[nombre] - $fila[apellidos] - $fila[alias] $tipo</option>
			</div>
			";
		}

#------------------------------------------------- PROVEEDOR ------------------------------------------------- ------------------------------------------------- -------------------------------------------------  
		$sql1 = "SELECT * FROM proveedores WHERE visible = 'SI' and (trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(telefono_otro) LIKE '%$q%' or trim(telefono_celular) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', apellidos, nombre)) like '%$q%' or idproveedores = '$q') LIMIT 5";
		$res1 = mysql_query($sql1);

		while ($fila1 = mysql_fetch_array($res1)) {

			$contenedor_final = ($fila1[col10] == "8") ? "Compras" : "Balance de Gastos" ;

			$tipo = "Proveedor";
			$mensaje.="
			<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='option_id_logistica_generar efecto-sugerencia' value='$fila1[idproveedores];$fila1[nombre];$fila1[apellidos];$fila1[alias];$fila1[telefono_celular];$fila1[telefono_otro];$fila1[estado];$fila1[delmuni];$fila1[colonia];$fila1[calle];$fila1[codigo_postal];$tipo;$contenedor_final'>$fila1[idproveedores] $fila1[nombre] - $fila1[apellidos] - $fila1[alias] $tipo</option>
			</div>
			";	
		}
#------------------------------------------------- COLABORADOR ------------------------------------------------- ------------------------------------------------- -------------------------------------------------  
		$sql2 = "SELECT * FROM empleados WHERE visible = 'SI' AND (trim(nombre) LIKE '%$q%' || trim(apellido_paterno) LIKE '%$q%' || trim(apellido_materno) LIKE '%$q%' || trim(columna_b) LIKE '%$q%' || trim(concat_ws(' ', nombre, apellido_paterno, apellido_materno)) LIKE '%$q%' || trim(concat_ws(' ', apellido_paterno, apellido_materno, nombre)) LIKE '%$q%' ) LIMIT 5";
		$res2 = mysql_query($sql2);

		while ($fila2 = mysql_fetch_array($res2)) {
			$tipo = "Colaborador";
			$apellidos = $fila2[apellido_paterno]." ".$fila2[apellido_materno];

			$mensaje.="
			<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='option_id_logistica_generar efecto-sugerencia' value='$fila2[idempleados];$fila2[nombre];$apellidos;$fila2[columna_b];$fila2[telefono_personal];$fila2[telefono_otro];$fila2[estado];$fila2[municipio];$fila2[colonia];$fila2[calle_numero];$fila2[cp];$tipo;Posible Error'>$fila2[idempleados] $fila2[nombre] - $apellidos - $fila2[columna_b] $tipo</option>
			</div>
			";		
		}
#------------------------------------------------- PROVEEDOR TEMPORAL ------------------------------------------------- ------------------------------------------------- ------------------------------------------------- 

		$sql3 = "SELECT * FROM orden_logistica_proveedores WHERE visible = 'SI' AND (trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', apellidos, nombre)) like '%$q%' or trim(telefono_otro) LIKE '%$q%' or trim(telefono_celular) LIKE '%$q%' or trim(idorden_logistica_proveedores) = '$q' ) LIMIT 5";
		$res3 = mysql_query($sql3);

		while ($fila3 = mysql_fetch_array($res3)) {
			$tipo = "Proveedor Temporal";
			$mensaje.="
			<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='option_id_logistica_generar efecto-sugerencia' value='$fila3[idorden_logistica_proveedores];$fila3[nombre];$fila3[apellidos];$fila3[alias];$fila3[telefono_celular];$fila3[telefono_otro];$fila3[estado];$fila3[delmuni];$fila3[colonia];$fila3[calle];$fila3[codigo_postal];$tipo;Posible Error'>$fila3[idorden_logistica_proveedores] $fila3[nombre] - $fila3[apellidos] - $fila3[alias] $tipo</option>
			</div>
			";		
		}
#------------------------------------------------- PROVEEDOR INFO ------------------------------------------------- ------------------------------------------------- ------------------------------------------------- 

		$sql4 = "SELECT * FROM proveedores_info WHERE trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', apellidos, nombre)) like '%$q%' or idproveedores_info = '$q' OR trim(telefono_otro) LIKE '%$q%' OR trim(telefono_celular) LIKE '%$q%' LIMIT 5";
		$res4 = mysql_query($sql4);

		while ($fila4 = mysql_fetch_array($res4)) {

			if (trim($fila4[tipo]) == "Bienes Raices") {

				$contenedor_final = "Bienes Raíces";

			}else if (trim($fila4[tipo]) == "Prestamos") {

				$contenedor_final = "Préstamos";

			}else if (trim($fila4[tipo]) == "Transacciones") {

				$contenedor_final = "Transacciones";

			}else{

				$contenedor_final = "Posible Error";

			}

			$tipo = "Proveedor Info";
			$mensaje.="
			<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='option_id_logistica_generar efecto-sugerencia' value='$fila4[idproveedores_info];$fila4[nombre];$fila4[apellidos];$fila4[alias];$fila4[telefono_celular];$fila4[telefono_otro];$fila4[estado];$fila4[delmuni];$fila4[colonia];$fila4[calle];$fila4[codigo_postal];$tipo;$contenedor_final'>$fila4[idproveedores_info] $fila4[nombre] - $fila4[apellidos] - $fila4[alias] $tipo - $fila4[moneda]</option>
			</div>
			";		
		}
#------------------------------------------------- PROSPECTOS ------------------------------------------------- ------------------------------------------------- ------------------------------------------------- 
		
		$sql5 = "SELECT * FROM prospectos WHERE trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', apellidos, nombre)) like '%$q%' or idprospectos = '$q' OR trim(telefono_otro) LIKE '%$q%' OR trim(telefono_celular) LIKE '%$q%' LIMIT 5";
		$res5 = mysql_query($sql5);

		while ($fila5 = mysql_fetch_array($res5)) {
			$tipo = "Prospectos";
			$mensaje.="
			<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='option_id_logistica_generar efecto-sugerencia' value='$fila5[idprospectos];$fila5[nombre];$fila5[apellidos];$fila5[alias];$fila5[telefono_celular];$fila5[telefono_otro];$fila5[estado];$fila5[delmuni];$fila5[colonia];$fila5[calle];$fila5[codigo_postal];$tipo;Posible Error'>$fila5[idprospectos] $fila5[nombre] - $fila5[apellidos] - $fila5[alias] $tipo</option>
			</div>
			";		
		}






	}else{
		echo "<b>ID NO Encontrado</b>";
	}

	echo $mensaje;

}else{
	
	$mensaje = "<b>ID NO Encontrado</b>";
}

function name_cliente($q) {

	$query_cliente = "SELECT * FROM contactos WHERE trim(nombre) LIKE '%$q%' ||  trim(apellidos) LIKE '%$q%' ||  trim(alias) LIKE '%$q%' ||  trim(telefono_celular) LIKE '%$q%'  ||  trim(telefono_otro) LIKE '%$q%' || trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' || trim(concat_ws(' ', apellidos, nombre)) LIKE '%$q%' || idcontacto = '$q' limit 5";
	$result_cliente = mysql_query($query_cliente);
	
	// if(mysql_num_rows($result_cliente) >= 1){

	while($row_cliente = mysql_fetch_array($result_cliente)){

		$tipo = "Cliente";
		$mensaje_cliente.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='option_id_logistica_generar efecto-sugerencia' value='$row_cliente[idcontacto];$row_cliente[nombre];$row_cliente[apellidos];$row_cliente[alias];$row_cliente[telefono_celular];$row_cliente[telefono_otro];$row_cliente[estado];$row_cliente[delmuni];$row_cliente[colonia];$row_cliente[calle];$row_cliente[codigo_postal];$tipo'>$row_cliente[idcontacto] $row_cliente[nombre] - $row_cliente[apellidos] - $row_cliente[alias] $tipo</option>
		</div>
		";
	}

	// }else{

	// 	$mensaje_cliente = "<b>ID NO Encontrado</b>";
	// }

	return $mensaje_cliente;
}

function name_proveedor($q) {

	$query_proveedor = "SELECT * FROM proveedores WHERE visible = 'SI' and (trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(telefono_otro) LIKE '%$q%' or trim(telefono_celular) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', apellidos, nombre)) like '%$q%' or idproveedores = '$q') LIMIT 5";
	$result_proveedor = mysql_query($query_proveedor);

	// if (mysql_num_rows($result_proveedor) >= 1) {

	while ($row_proveedor = mysql_fetch_array($result_proveedor)) {
		$tipo = "Proveedor";
		$mensaje_proveedor.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='option_id_logistica_generar efecto-sugerencia' value='$row_proveedor[idproveedores];$row_proveedor[nombre];$row_proveedor[apellidos];$row_proveedor[alias];$row_proveedor[telefono_celular];$row_proveedor[telefono_otro];$row_proveedor[estado];$row_proveedor[delmuni];$row_proveedor[colonia];$row_proveedor[calle];$row_proveedor[codigo_postal];$tipo'>$row_proveedor[idproveedores] $row_proveedor[nombre] - $row_proveedor[apellidos] - $row_proveedor[alias] $tipo</option>
		</div>
		";		
	}

	// }else{

	// 	$mensaje_proveedor = "<b>ID NO Encontrado</b>";
	// }

	return $mensaje_proveedor;
}

function name_colaborador($q){

	$sql2 = "SELECT * FROM empleados WHERE visible = 'SI' AND (trim(nombre) LIKE '%$q%' || trim(apellido_paterno) LIKE '%$q%' || trim(apellido_materno) LIKE '%$q%' || trim(columna_b) LIKE '%$q%' || trim(concat_ws(' ', nombre, apellido_paterno, apellido_materno)) LIKE '%$q%' || trim(concat_ws(' ', apellido_paterno, apellido_materno, nombre)) LIKE '%$q%' ) LIMIT 5";
	$res2 = mysql_query($sql2);

	// if (mysql_num_rows($res2) >= 1) {

	while ($fila2 = mysql_fetch_array($res2)) {
		$tipo = "Colaborador";
		$apellidos = $fila2[apellido_paterno]." ".$fila2[apellido_materno];

		$mensaje_colaborador.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='option_id_logistica_generar efecto-sugerencia' value='$fila2[idempleados];$fila2[nombre];$apellidos;$fila2[columna_b];$fila2[telefono_personal];$fila2[telefono_otro];$fila2[estado];$fila2[municipio];$fila2[colonia];$fila2[calle_numero];$fila2[cp];$tipo'>$fila2[idempleados] $fila2[nombre] - $apellidos - $fila2[columna_b] $tipo</option>
		</div>
		";		
	}

	// }else{
	// 	$mensaje_colaborador = "<b>ID NO Encontrado</b>";
	// }

	return $mensaje_colaborador;
}

function name_proveedor_temporal($q){

	$query_temporal = "SELECT * FROM orden_logistica_proveedores WHERE visible = 'SI' AND (trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', apellidos, nombre)) like '%$q%' or trim(telefono_otro) LIKE '%$q%' or trim(telefono_celular) LIKE '%$q%' or trim(idorden_logistica_proveedores) = '$q' ) LIMIT 5";
	$result_temporal = mysql_query($query_temporal);

	// if (mysql_num_rows($result_temporal) >= 1) {

	while ($fila3 = mysql_fetch_array($result_temporal)) {
		$tipo = "Proveedor Temporal";
		$mensaje_proveedor_temporal.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='option_id_logistica_generar efecto-sugerencia' value='$fila3[idorden_logistica_proveedores];$fila3[nombre];$fila3[apellidos];$fila3[alias];$fila3[telefono_celular];$fila3[telefono_otro];$fila3[estado];$fila3[delmuni];$fila3[colonia];$fila3[calle];$fila3[codigo_postal];$tipo'>$fila3[idorden_logistica_proveedores] $fila3[nombre] - $fila3[apellidos] - $fila3[alias] $tipo</option>
		</div>
		";		
	}

	// }else{

	// 	$mensaje_proveedor_temporal = "<b>ID NO Encontrado</b>";
	// }

	return $mensaje_proveedor_temporal;
}

function name_proveedor_info($q) {

	$query_proveedor_info = "SELECT * FROM proveedores_info WHERE trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', apellidos, nombre)) like '%$q%' or idproveedores_info = '$q' OR trim(telefono_otro) LIKE '%$q%' OR trim(telefono_celular) LIKE '%$q%' LIMIT 5";
	$result_proveedor_info = mysql_query($query_proveedor_info);

	// if (mysql_num_rows($result_proveedor_info) >= 1) {

	while ($row_proveedor_info = mysql_fetch_array($result_proveedor_info)) {
		$tipo = "Proveedor Info";
		$mensaje_proveedor.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='option_id_logistica_generar efecto-sugerencia' value='$row_proveedor_info[idproveedores_info];$row_proveedor_info[nombre];$row_proveedor_info[apellidos];$row_proveedor_info[alias];$row_proveedor_info[telefono_celular];$row_proveedor_info[telefono_otro];$row_proveedor_info[estado];$row_proveedor_info[delmuni];$row_proveedor_info[colonia];$row_proveedor_info[calle];$row_proveedor_info[codigo_postal];$tipo'>$row_proveedor_info[idproveedores_info] $row_proveedor_info[nombre] - $row_proveedor_info[apellidos] - $row_proveedor_info[alias] $tipo - $row_proveedor_info[moneda]</option>
		</div>
		";		
	}

	// }else{

	// 	$mensaje_proveedor = "<b>ID NO Encontrado</b>";
	// }

	return $mensaje_proveedor;
}


function name_prospectos($q) {

	$query_prospectos = "SELECT * FROM prospectos WHERE trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', apellidos, nombre)) like '%$q%' or idprospectos = '$q' OR trim(telefono_otro) LIKE '%$q%' OR trim(telefono_celular) LIKE '%$q%' LIMIT 5";
	$result_prospectos = mysql_query($query_prospectos);

	while ($row_prospectos = mysql_fetch_array($result_prospectos)) {
		$tipo = "Prospectos";
		$mensaje.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='option_id_logistica_generar efecto-sugerencia' value='$row_prospectos[idprospectos];$row_prospectos[nombre];$row_prospectos[apellidos];$row_prospectos[alias];$row_prospectos[telefono_celular];$row_prospectos[telefono_otro];$row_prospectos[estado];$row_prospectos[delmuni];$row_prospectos[colonia];$row_prospectos[calle];$row_prospectos[codigo_postal];$tipo'>$row_prospectos[idprospectos] $row_prospectos[nombre] - $row_prospectos[apellidos] - $row_prospectos[alias] $tipo</option>
		</div>
		";		
	}
}



?>
