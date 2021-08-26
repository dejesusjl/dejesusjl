<?php
include_once "../../config.php";  

$q = $_POST['valorBusqueda'];

$sql = "SELECT * from contactos WHERE  nombre LIKE '%".$q."%' ||  apellidos LIKE '%".$q."%' ||  alias LIKE '%".$q."%' ||  telefono_celular LIKE '%".$q."%'  ||  telefono_otro LIKE '%".$q."%' || concat_ws(' ', nombre, apellidos) like '%".$q."%' || concat_ws(' ', apellidos, nombre) LIKE '%".$q."%' || idcontacto = '$q' limit 10";
$res=mysql_query($sql);

if(mysql_num_rows($res) >= 1){

	while($fila=mysql_fetch_array($res)){

		$tipo = "Cliente";
		$mensaje.="
		<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='sugerencias_id_documentacion efecto-sugerencia' value='$fila[idcontacto];$fila[nombre];$fila[apellidos];$fila[alias];$fila[telefono_celular];$fila[telefono_otro];$fila[estado];$fila[delmuni];$fila[colonia];$fila[calle];$fila[codigo_postal];$tipo'>$fila[nombre] - $fila[apellidos] - $fila[alias]</option>
		</div>
		";
	}

}else{

	$sql1 = "SELECT * from proveedores WHERE nombre LIKE '%".$q."%' or apellidos LIKE '%".$q."%' or alias LIKE '%".$q."%' or concat_ws(' ', nombre, apellidos) like '%".$q."%' or concat_ws(' ', apellidos, nombre) like '%".$q."%' LIMIT 10";
	$res1 = mysql_query($sql1);

	if (mysql_num_rows($res1) >= 1) {
		
		while ($fila1 = mysql_fetch_array($res1)) {
			$tipo = "Proveedor";
			$mensaje.="
			<div class='content-op-busqueda-2'>
				<i class='fas fa-user icon-busqueda'></i>
				<option class='sugerencias_id_documentacion efecto-sugerencia' value='$fila1[idproveedores];$fila1[nombre];$fila1[apellidos];$fila1[alias];$fila1[telefono_celular];$fila1[telefono_otro];$fila1[estado];$fila1[delmuni];$fila1[colonia];$fila1[calle];$fila1[codigo_postal];$tipo'>$fila1[nombre] - $fila1[apellidos] - $fila1[alias]</option>
			</div>
			";		
		}

	}else{

		$sql2 = "SELECT * FROM empleados WHERE visible = 'SI' AND columna_a = 'Disponible' and (nombre LIKE '%".$q."%' || apellido_paterno LIKE '%".$q."%' || apellido_materno LIKE '%".$q."%' || columna_b LIKE '%".$q."%' || concat_ws(' ', nombre, apellido_paterno, apellido_materno) LIKE '%".$q."%' ) LIMIT 5";
		$res2 = mysql_query($sql2);

		if (mysql_num_rows($res2) >= 1) {

			while ($fila2 = mysql_fetch_array($res2)) {
				$tipo = "Colaborador";
				$apellidos = $fila2[apellido_paterno]." ".$fila2[apellido_materno];

				$mensaje.="<div class='content-op-busqueda-2'>
				<i class='fas fa-user icon-busqueda'></i>
				<option class='sugerencias_id_documentacion efecto-sugerencia' value='$fila2[idempleados];$fila2[nombre];$apellidos;$fila2[columna_b];$fila2[telefono_celular];$fila2[telefono_otro];$fila2[estado];$fila2[delmuni];$fila2[colonia];$fila2[calle];$fila2[codigo_postal];$tipo'>$fila2[nombre] - $apellidos - $fila2[columna_b]</option>
				</div>";		
			}
			
		}else{


			$sql3 = "SELECT * from orden_logistica_proveedores WHERE nombre LIKE '%".$q."%' or apellidos LIKE '%".$q."%' or alias LIKE '%".$q."%' or concat_ws(' ', nombre, apellidos) like '%".$q."%' or concat_ws(' ', apellidos, nombre) like '%".$q."%' LIMIT 10";
			$res3 = mysql_query($sql3);

			if (mysql_num_rows($res3) >= 1) {


				while ($fila3 = mysql_fetch_array($res3)) {
					$tipo = "Proveedor Temporal";
					$mensaje.="<div class='content-op-busqueda-2'>
					<i class='fas fa-user icon-busqueda'></i>
					<option class='sugerencias_id_documentacion efecto-sugerencia' value='$fila3[idorden_logistica_proveedores];$fila3[nombre];$fila3[apellidos];$fila3[alias];$fila3[telefono_celular];$fila3[telefono_otro];$fila3[estado];$fila3[delmuni];$fila3[colonia];$fila3[calle];$fila3[codigo_postal];$tipo'>$fila3[nombre] - $fila3[apellidos] - $fila3[alias]</option>
					<div>";		
				}


			}else{



				echo '<b>ID NO Encontrado</b>';

			}





		}

	}



	

}

echo $mensaje;
?>
