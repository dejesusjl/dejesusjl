<?php
include_once "../../config.php";

$q = $_POST['valorBusqueda'];
$okkk = $_POST['contador_nuevo_ayudante'];

$okkk = ($okkk == "" || $okkk == null ) ? "0" : $okkk;

$query = "SELECT * FROM empleados WHERE visible = 'SI' AND columna_a = 'Disponible' and (nombre LIKE '%".$q."%' || apellido_paterno LIKE '%".$q."%' || apellido_materno LIKE '%".$q."%' || columna_b LIKE '%".$q."%' || concat_ws(' ', nombre, apellido_paterno, apellido_materno) LIKE '%".$q."%' ) LIMIT 5";
$result = mysql_query($query);

if (mysql_num_rows($result) >= 1) {

	$colaborador = "Colaborador";

	while ($row = mysql_fetch_array($result)) {

		if ($okkk > 0) {
			$mensaje.="
			<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='sugerencias_asesor$okkk efecto-sugerencia' value='$row[idempleados];$row[columna_b];$colaborador'>$row[nombre] - $row[apellido_paterno] - $row[apellido_materno] $colaborador</option>
			</div>
			";
		}else{
			$mensaje.="
			<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='sugerencias_asesor efecto-sugerencia' value='$row[idempleados];$row[columna_b];$colaborador'>$row[nombre] - $row[apellido_paterno] - $row[apellido_materno] $colaborador</option>
			</div>
			";
		}

	}
}else{

	$contacto = "Cliente";
	$query1 = "SELECT * from contactos WHERE  nombre LIKE '%".$q."%' ||  apellidos LIKE '%".$q."%' ||  alias LIKE '%".$q."%' ||  telefono_celular LIKE '%".$q."%'  ||  telefono_otro LIKE '%".$q."%' || concat_ws(' ', nombre, apellidos) like '%".$q."%' || concat_ws(' ', apellidos, nombre) LIKE '%".$q."%' || idcontacto = '$q' ";
	$result1 = mysql_query($query1);

	if (mysql_num_rows($result1) >= 1) {

		while ($row1 = mysql_fetch_array($result1)) {

			if ($okkk > 0) {
				$mensaje.="
				<div class='content-op-busqueda-2'>
				<i class='fas fa-user icon-busqueda'></i>
				<option class='sugerencias_asesor$okkk efecto-sugerencia' value='$row1[idcontacto];$row1[nombre] $row1[apellidos];$contacto'>$row1[nombre] - $row1[apellidos] - $contacto</option>
				</div>
				";
			}else{
				$mensaje.="
				<div class='content-op-busqueda-2'>
				<i class='fas fa-user icon-busqueda'></i>
				<option class='sugerencias_asesor efecto-sugerencia' value='$row1[idcontacto];$row1[nombre] $row1[apellidos];$contacto'>$row1[nombre] - $row1[apellidos] - $contacto</option>
				</div>
				";
			}
		}

	}else{

		$proveedor = "Proveedor";
		$query2 = "SELECT * from proveedores WHERE nombre LIKE '%".$q."%' or apellidos LIKE '%".$q."%' or alias LIKE '%".$q."%' or concat_ws(' ', nombre, apellidos) like '%".$q."%' or concat_ws(' ', apellidos, nombre) like '%".$q."%' LIMIT 10";
		$result2 = mysql_query($query2);

		if (mysql_num_rows($result2) >= 1) {

			while ($row2 = mysql_fetch_array($result2)) {

				if ($okkk > 0) {
					$mensaje.="
					<div class='content-op-busqueda-2'>
					<i class='fas fa-user icon-busqueda'></i>
					<option class='sugerencias_asesor$okkk efecto-sugerencia' value='$row2[idproveedores];$row2[nombre] $row2[apellidos];$proveedor'>$row2[nombre] - $row2[apellidos] - $proveedor</option>
					</div>
					";
				}else{
					$mensaje.="
					<div class='content-op-busqueda-2'>
					<i class='fas fa-user icon-busqueda'></i>
					<option class='sugerencias_asesor efecto-sugerencia' value='$row2[idproveedores];$row2[nombre] $row2[apellidos];$proveedor'>$row2[nombre] - $row2[apellidos] - $proveedor</option>
					</div>
					";
				}

			}

		}else{

			$proveedor_temporal = "Proveedor Temporal";
			$query3 = "SELECT * from orden_logistica_proveedores WHERE nombre LIKE '%".$q."%' or apellidos LIKE '%".$q."%' or alias LIKE '%".$q."%' or concat_ws(' ', nombre, apellidos) like '%".$q."%' or concat_ws(' ', apellidos, nombre) like '%".$q."%' LIMIT 10";
			$result3 = mysql_query($query3);

			if (mysql_num_rows($result3)) {

				while ($row3 = mysql_fetch_array($result3)) {

					if ($okkk > 0) {
						$mensaje.="
						<div class='content-op-busqueda-2'>
						<i class='fas fa-user icon-busqueda'></i>
						<option class='sugerencias_asesor$okkk efecto-sugerencia' value='$row3[idorden_logistica_proveedores];$row3[nombre] $row3[apellidos];$proveedor_temporal'>$row3[nombre] - $row3[apellidos] - $proveedor_temporal</option>
						</div>
						";
					}else{
						$mensaje.="
						<div class='content-op-busqueda-2'>
						<i class='fas fa-user icon-busqueda'></i>
						<option class='sugerencias_asesor efecto-sugerencia' value='$row3[idorden_logistica_proveedores];$row3[nombre] $row3[apellidos];$proveedor_temporal'>$row3[nombre] - $row3[apellidos] - $proveedor_temporal</option>
						</div>
						";
					}
				}
			}else{
				echo "<b>Colaborador NO Disponible</b>";
			}	
		}	
	}
}

echo $mensaje;

?>