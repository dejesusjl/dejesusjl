<?php
include_once "../../config.php";
$q = $_POST['valorBusqueda'];


$query = "SELECT * FROM empleados WHERE visible = 'SI' AND (trim(nombre) LIKE '%$q%' || trim(apellido_paterno) LIKE '%$q%' || trim(apellido_materno) LIKE '%$q%' || trim(columna_b) LIKE '%$q%' || trim(concat_ws(' ', nombre, apellido_paterno, apellido_materno)) LIKE '%$q%' || trim(concat_ws(' ', apellido_paterno, apellido_materno, nombre)) LIKE '%$q%' ) LIMIT 5";
$result = mysql_query($query);

if (mysql_num_rows($result) >= 1) {
	$colaborador = "Colaborador";
	while ($row = mysql_fetch_array($result)) {
		$mensaje.="
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='sugerencias_trasladista efecto-sugerencia' value='$row[idempleados];$row[nombre] $row[apellido_paterno] $row[apellido_materno];$colaborador'>$row[nombre] - $row[apellido_paterno] - $row[apellido_materno] $colaborador </option>
		</div>
		";
	}
}else{

	$contacto = "Cliente";
	$query1 = "SELECT * FROM contactos WHERE trim(nombre) LIKE '%$q%' ||  trim(apellidos) LIKE '%$q%' ||  trim(alias) LIKE '%$q%' ||  trim(telefono_celular) LIKE '%$q%'  ||  trim(telefono_otro) LIKE '%$q%' || trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' || trim(concat_ws(' ', trim(apellidos), trim(nombre))) LIKE '%$q%' || idcontacto = '$q' limit 5";
	$result1 = mysql_query($query1);

	if (mysql_num_rows($result1) >= 1) {

		while ($row1 = mysql_fetch_array($result1)) {
			$mensaje.="
			<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='sugerencias_trasladista efecto-sugerencia' value='$row1[idcontacto];$row1[nombre] $row1[apellidos];$contacto'>$row1[nombre] - $row1[apellidos] - <b>$contacto</b> </option>
			</div>
			";
		}

	}else{

		$proveedor = "Proveedor";
		$query2 = "SELECT * FROM proveedores WHERE visible = 'SI' and (trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(telefono_otro) LIKE '%$q%' or trim(telefono_celular) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', trim(apellidos), trim(nombre))) like '%$q%' or idproveedores = '$q') LIMIT 5";
		$result2 = mysql_query($query2);

		if (mysql_num_rows($result2) >= 1) {

			while ($row2 = mysql_fetch_array($result2)) {
				$mensaje.="
				<div class='content-op-busqueda-2'>
				<i class='fas fa-user icon-busqueda'></i>
				<option class='sugerencias_trasladista efecto-sugerencia' value='$row2[idproveedores];$row2[nombre] $row2[apellidos];$proveedor'>$row2[nombre] - $row2[apellidos] - <b>$proveedor</b> </option>
				</div>
				";
			}

		}else{

			$proveedor_temporal = "Proveedor Temporal";
			$query3 = "SELECT * FROM orden_logistica_proveedores WHERE visible = 'SI' AND (trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', trim(apellidos), trim(nombre))) like '%$q%' or trim(telefono_otro) LIKE '%$q%' or trim(telefono_celular) LIKE '%$q%' or trim(idorden_logistica_proveedores) = '$q' ) LIMIT 5";
			$result3 = mysql_query($query3);

			if (mysql_num_rows($result3)) {


				while ($row3 = mysql_fetch_array($result3)) {
					$mensaje.="
					<div class='content-op-busqueda-2'>
					<i class='fas fa-user icon-busqueda'></i>
					<option class='sugerencias_trasladista efecto-sugerencia' value='$row3[idorden_logistica_proveedores];$row3[nombre] $row3[apellidos];$proveedor_temporal'>$row3[nombre] - $row3[apellidos] - <b>$proveedor_temporal</b> </option>
					</div>
					";
				}

			}else{
				echo "<b>NO Encontrado</b>";
			}


			
		}





		
	}	
}




echo $mensaje;


?>
