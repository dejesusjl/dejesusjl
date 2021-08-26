<script>
	$(document).ready(function(){
		$("#table-busquedas").DataTable({
			language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
				"infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
				"infoFiltered": "(Filtrado de _MAX_ total entradas)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ Entradas",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar:",
				"zeroRecords": "Sin resultados encontrados",
				"paginate": {
					"first": "Primero",
					"last": "Ultimo",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			},
			responsive: true,
			"order": [ 0, 'desc' ],
		});

		$("#table-busquedas2").DataTable({
			language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
				"infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
				"infoFiltered": "(Filtrado de _MAX_ total entradas)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ Entradas",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar:",
				"zeroRecords": "Sin resultados encontrados",
				"paginate": {
					"first": "Primero",
					"last": "Ultimo",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			},
			responsive: true,
			"order": [ 0, 'desc' ],
		});
		$("#table-busquedas3").DataTable({
			language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
				"infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
				"infoFiltered": "(Filtrado de _MAX_ total entradas)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ Entradas",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar:",
				"zeroRecords": "Sin resultados encontrados",
				"paginate": {
					"first": "Primero",
					"last": "Ultimo",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			},
			responsive: true,
			"order": [ 0, 'desc' ],
		});

	});
</script>

<?php
include_once "../../config.php";  


$q = $_POST['valorBusqueda'];
$consulta_tipo = $_POST['valorSelect'];

/*$q = "ljj";
$consulta_tipo = "ejecutivo";
*/

if ($consulta_tipo == "logistica") {


	$query_orden = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$q' order by idorden_logistica desc";
	
	$result_orden = mysql_query($query_orden);

	if(mysql_num_rows($result_orden) == 0){

		echo '<b class="text-noresults">Logística NO Encontrada</b>';

	}else{


		while($fila=mysql_fetch_array($result_orden)){

			$idl=base64_encode($fila['idorden_logistica']);
			$id_contacto = $fila[idcontacto];
			$tipo_contacto = trim($fila[tipo_contacto]);

			$ver_contacto = nameCliente($id_contacto, $tipo_contacto);

			$mensaje.="
            <div class='my-2'>
                <a href='orden_logistica_detalles.php?idib=$idl' class='card-busquedas d-flex align-items-center' style='background: #f3f3f3;'>
                    <p class='busquedas-text-1 mb-0 text-center' style='color: #d43759;'>$fila[idorden_logistica]</p>
                    <h6 class='busquedas-text-2 mb-0'>$ver_contacto</h6>
                </a>
            </div>
            ";

		}

	}

}elseif ($consulta_tipo == "vin") {

	$mensaje .= "

	<div class='container-bg-1 p-3'>
		<div class='table-responsive'>
			<table id='table-busquedas' class='table table-striped table-hover responsive' style='width: 100%;'>
				<thead>
					<tr>
						<th>VIN</th>
						<th>Número de logística</th>
						<th>Cliente</th>
					</tr>
				</thead>
				<tbody>
	";
	
	$query_vin = "SELECT * FROM orden_logistica_unidades WHERE visible = 'SI' and vin LIKE '%$q%' order by idorden_logistica desc";
	$result_vin = mysql_query($query_vin);

	if(mysql_num_rows($result_vin) == 0){
		echo '<b class="text-noresults">VIN no encontrado</b>';
	} else {
		
		while ($row_vin = mysql_fetch_array($result_vin)) {

			$query_orden_vin = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$row_vin[idorden_logistica]'";
			$result_orden_vin = mysql_query($query_orden_vin);
	
			while ($row_orden_vin = mysql_fetch_array($result_orden_vin)) {
	
				$idl = base64_encode($row_orden_vin['idorden_logistica']);
				$id_contacto = $row_orden_vin[idcontacto];
				$tipo_contacto = trim($row_orden_vin[tipo_contacto]);
	
				$ver_contacto = nameCliente($id_contacto, $tipo_contacto);
	
				$mensaje.="
				<tr class='single-result'>
					<td><a href='orden_logistica_detalles.php?idib=$idl'>$row_vin[vin]</a></td>
					<td><a href='orden_logistica_detalles.php?idib=$idl'>$row_orden_vin[idorden_logistica]</a></td>
					<td><a href='orden_logistica_detalles.php?idib=$idl'>$ver_contacto</a></td>
				</tr>
                ";
	
			}
		}
	} 

	$mensaje .= "
	</tbody>
	</table>
	</div>
	</div>
	";

}elseif ($consulta_tipo == "ejecutivo"){

	$mensaje .= "

	<div class='container-bg-1 p-3'>
		<div class='table-responsive'>
			<table id='table-busquedas2' class='table table-striped table-hover responsive' style='width: 100%;'>
				<thead>
					<tr>
						<th>Número de logística</th>
						<th>Responsable</th>
					</tr>
				</thead>
				<tbody>
	
	";

	$query_trasladista = "SELECT * FROM empleados where visible = 'SI' and (nombre LIKE '%$q%' || apellido_materno LIKE '%$q%' || apellido_paterno LIKE '%$q%' || columna_b LIKE '%$q%')";
	$result_trasladista = mysql_query($query_trasladista);


	if(mysql_num_rows($result_trasladista) == 0){
		echo '<b class="text-noresults">Ejecutivo no encontrado</b>';
	} else {
		while ($row_trasladista = mysql_fetch_array($result_trasladista)) {
		
			$query_ejecutivo = " SELECT * FROM orden_logistica where (idasigna LIKE '$row_trasladista[idempleados]'  || idorden_logistica IN (SELECT idorden_logistica From orden_logistica_ayudante WHERE (id_colaborador_proveedor LIKE '$row_trasladista[idempleados]') and visible = 'SI' and tipo = 'Colaborador' )) and tipo_asignante = 'Colaborador' order by idorden_logistica desc";
	
			$result_ejecutivo = mysql_query($query_ejecutivo);

			while ($row_ejecutivo =mysql_fetch_array($result_ejecutivo)) {

				$idl = base64_encode($row_ejecutivo['idorden_logistica']);
				$id_contacto = $row_ejecutivo[idasigna];
				$tipo_contacto = trim($row_ejecutivo[tipo_asignante]);
	
				$ver_contacto = nameCliente($id_contacto, $tipo_contacto);

				$mensaje.="
				<tr class='single-result'>
					<td><a href='orden_logistica_detalles.php?idib=$idl'>$row_ejecutivo[idorden_logistica]</a></td>
					<td><a href='orden_logistica_detalles.php?idib=$idl'>$ver_contacto</a></td>
				</tr>
                ";
	
			}
	
		}
	}

	$mensaje .= "
		</tbody>
		</table>
	</div>
	</div>
	";

}elseif ($consulta_tipo == "Cliente") {

	$mensaje .= "
		<div class='container-bg-1 p-3'>
			<div class='table-responsive'>
				<table id='table-busquedas3' class='table table-striped table-hover responsive' style='width: 100%;'>
					<thead>
					 	<tr>
					 		<th>Número de logística</th>
							<th>Cliente</th>
					 	</tr>
					</thead>
					<tbody>
	";
	
	$query_id = "SELECT * from contactos WHERE TRIM(nombre) LIKE '%".$q."%' or  TRIM(apellidos) LIKE '%".$q."%' or  TRIM(alias) LIKE '%".$q."%' or  TRIM(telefono_celular) LIKE '%".$q."%'  or  TRIM(telefono_otro) LIKE '%".$q."%' or concat_ws(' ', nombre, apellidos) like '%".$q."%'";
	$result_id = mysql_query($query_id);

	if(mysql_num_rows($result_id) >= 1){

		while($row_id = mysql_fetch_array($result_id)){

			$query_cliente_logistica = "SELECT * FROM orden_logistica where TRIM(idcontacto) = '$row_id[idcontacto]' and TRIM(tipo_contacto) = 'Cliente' order by idorden_logistica desc";
			$result_cliente_logistica = mysql_query($query_cliente_logistica);

			while ($row_cliente_logistica = mysql_fetch_array($result_cliente_logistica)) {

				$idl = base64_encode($row_cliente_logistica['idorden_logistica']);
				$id_contacto = $row_cliente_logistica[idcontacto];
				$tipo_contacto = trim("Cliente");

				$ver_contacto = nameCliente($id_contacto, $tipo_contacto);

				$mensaje.= "
				<tr class='single-result'>
					<td><a href='orden_logistica_detalles.php?idib=$idl'>$row_cliente_logistica[idorden_logistica]</a></td>
					<td><a href='orden_logistica_detalles.php?idib=$idl'>$ver_contacto</a></td>
				</tr>
                ";
			}

		}

	}else{

		$query_prov = "SELECT * from proveedores WHERE nombre LIKE '%".$q."%' or apellidos LIKE '%".$q."%' or alias LIKE '%".$q."%'";
		$result_prov = mysql_query($query_prov);

		if (mysql_num_rows($result_prov) >= 1) {

			while ($row_prov = mysql_fetch_array($result_prov)) {

				$query_prov_logistica = "SELECT * FROM orden_logistica where TRIM(idcontacto) = '$row_prov[idproveedores]' and TRIM(tipo_contacto) = 'Proveedor' order by idorden_logistica desc";
				$result_prov_logistica = mysql_query($query_prov_logistica);

				while ($row_proveedor_logistica = mysql_fetch_array($result_prov_logistica)) {

					$idl = base64_encode($row_proveedor_logistica['idorden_logistica']);
					$id_contacto = $row_proveedor_logistica[idcontacto];
					$tipo_contacto = trim("Proveedor");

					$ver_contacto = nameCliente($id_contacto, $tipo_contacto);

					$mensaje.= "
					<tr class='single-result'>
						<td><a href='orden_logistica_detalles.php?idib=$idl'>$row_proveedor_logistica[idorden_logistica]</a></td>
						<td><a href='orden_logistica_detalles.php?idib=$idl'>$ver_contacto</a></td>
					</tr>
                    ";
				}
			}
		}else{

			$query_emp = "SELECT * from empleados WHERE nombre LIKE '%".$q."%' or apellido_paterno LIKE '%".$q."%' or apellido_materno LIKE '%".$q."%' or columna_b LIKE '%".$q."%' or concat_ws(' ', nombre, apellido_paterno, apellido_materno) LIKE '%".$q."%'";
			$result_emp = mysql_query($query_emp);

			if (mysql_num_rows($result_emp) >= 1) {

				while ($row_emp = mysql_fetch_array($result_emp)) {

					$query_emp_logistica = "SELECT * FROM orden_logistica where TRIM(idcontacto) = '$row_emp[idempleados]' and TRIM(tipo_contacto) = 'Colaborador' order by idorden_logistica desc";
					$result_emp_logistica = mysql_query($query_emp_logistica);

					while ($row_emp_logistica = mysql_fetch_array($result_emp_logistica)) {

						$idl = base64_encode($row_emp_logistica['idorden_logistica']);
						$id_contacto = $row_emp_logistica[idcontacto];
						$tipo_contacto = trim("Colaborador");

						$ver_contacto = nameCliente($id_contacto, $tipo_contacto);

						$mensaje.= "
						<tr class='single-result'>
							<td><a href='orden_logistica_detalles.php?idib=$idl'>$row_emp_logistica[idorden_logistica]</a></td>
							<td><a href='orden_logistica_detalles.php?idib=$idl'>$ver_contacto</a></td>
						</tr>
                        ";
					}
				}
				

			}else{


				$query_prov_tem = "SELECT * from orden_logistica_proveedores WHERE nombre LIKE '%".$q."%' or apellidos LIKE '%".$q."%' or alias LIKE '%".$q."%'";
				$result_prov_tem = mysql_query($query_prov_tem);

				if (mysql_num_rows($result_prov_tem) >= 1) {

					while ($row_prov_te = mysql_fetch_array($result_prov_tem)) {

						$query_prov_tem_logistica = "SELECT * FROM orden_logistica where TRIM(tipo_contacto) = 'Proveedor Temporal' and (TRIM(idcontacto) = '$row_prov_te[idorden_logistica_proveedores]' || TRIM(idcontacto) = '$row_prov_te[idprovedores_compuesto]') order by idorden_logistica desc";
						$result_prov_tem_logistica = mysql_query($query_prov_tem_logistica);

						while ($row_prov_tem_logistica = mysql_fetch_array($result_prov_tem_logistica)) {

							$idl = base64_encode($row_prov_tem_logistica['idorden_logistica']);
							$id_contacto = $row_prov_te[idorden_logistica_proveedores];
							$tipo_contacto = trim("Proveedor Temporal");

							$ver_contacto = nameCliente($id_contacto, $tipo_contacto);

							$mensaje.= "
							<tr class='single-result'>
								<td><a href='orden_logistica_detalles.php?idib=$idl'>$row_prov_tem_logistica[idorden_logistica]</a></td>
								<td><a href='orden_logistica_detalles.php?idib=$idl'>$ver_contacto</a></td>
							</tr>
                            ";
						}
					}


				}else{
					echo '<b class="text-noresults">ID NO Encontrado</b>';
				}


			}

		}

	}

	$mensaje .= "
				</tbody>
			</table>
		</div>
	</div>
	";
}





function nameCliente($id_contacto, $tipo_contacto){


	if ($tipo_contacto == "Cliente") {

		$query_cliente = "SELECT * FROM contactos WHERE idcontacto = '$id_contacto'";
		$result_cliente = mysql_query($query_cliente);

		while ($row_cliente = mysql_fetch_array($result_cliente)) {

			$name_contacto = $row_cliente[nombre]." ".$row_cliente[apellidos]; 

		}
	}elseif ($tipo_contacto == "Proveedor") {

		$query_cliente = "SELECT * FROM proveedores WHERE idproveedores = '$id_contacto'";
		$result_cliente = mysql_query($query_cliente);

		while ($row_cliente = mysql_fetch_array($result_cliente)) {

			$name_contacto = $row_cliente[nombre]." ".$row_cliente[apellidos]; 

		}


	}elseif ($tipo_contacto == "Proveedor Temporal") {

		$query_proveedor_tem = "SELECT * FROM orden_logistica_proveedores WHERE idorden_logistica_proveedores = '$id_contacto'";
		$result_proveedor_tem = mysql_query($query_proveedor_tem);

		while ($row_proveedor_tem = mysql_fetch_array($result_proveedor_tem)) {

			$name_contacto = $row_proveedor_tem[nombre]." ".$row_proveedor_tem[apellidos]; 

		}

	}elseif ($tipo_contacto == "Colaborador") {

		$query_colaborador = "SELECT * FROM empleados WHERE idempleados = '$id_contacto'";
		$result_colaborador = mysql_query($query_colaborador);

		while ($row_colaborador = mysql_fetch_array($result_colaborador)) {
			$name_contacto = "$row_colaborador[nombre]"." "."$row_colaborador[apellido_paterno]"." "."$row_colaborador[apellido_materno]";

		}
	}else {
		$name_contacto = "N/A";
	}

	return $name_contacto;
}

echo $mensaje;
?>

