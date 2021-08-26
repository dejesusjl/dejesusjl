<?php 
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
date_default_timezone_set('America/Mexico_City');
$fecha_guardado=date("Y-m-d H:i:s"); 
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);

?>
<script>
	$(document).ready(function() {
		$('#example').DataTable({
			<?php if ($empleados == 2 || $empleados == 88 || $empleados == 91): ?>
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
				lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
				dom: 'Blfrtip',
				buttons: [
				
				{
					extend: 'excel',
					text: 'Excel'

				}, {
					extend: 'pdf',
					text: 'PDF',
					orientation: 'landscape',
					pageSize: 'LEGAL'

				}
				]
				<?php else: ?>
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
					lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
					dom: 'Blfrtip',
					buttons: [          
					]
				<?php endif ?>

			});

		var table = $('#example').DataTable();

		table
		.order([ 0, 'desc' ])
		.draw();
	});
</script>

<?php 


$mensaje .= "
<div class='container-bg-1 p-3'>
<div class='table-responsive'>
<table id='example' class='table table-striped table-bordered' style='width: 100%;'>
<thead>

<tr>
<th>ID Logística</th>
<th>Tipo Orden</th>
<th>VIN</th>
<th>Marca</th>
<th>Versión</th>
<th>Color</th>
<th>Modelo</th>
<th>Tipo Unidad</th>
<th>Trasladista Principal</th>
<th>Responsable Unidad</th>
<th>Fecha</th>
</tr>
</thead>
<tbody>
";



$idlogistica = $_POST['idlogistica'];

$fecha_inicio = $_POST['fecha_inicio'];

$fecha_fin = $_POST['fecha_fin'];



if ($fecha_inicio != "" and $fecha_fin != "") {
	
	$fecha_a = $fecha_inicio;
	$fecha_b = $fecha_fin;

}elseif ($fecha_inicio != "" and $fecha_fin == "") {
	
	$fecha_a = $fecha_inicio;
	$fecha_b = $fecha_inicio;

}elseif ($fecha_inicio == "" and $fecha_fin != "") {
	
	$fecha_a = $fecha_fin;
	$fecha_b = $fecha_fin;

} else{
	
	$fecha_a = date("Y-m-d");
	$fecha_b = date("Y-m-d");
}

$id_em_prov_provt = trim($_POST['id_em_prov_provt']);
$type_em_prov_provt = trim($_POST['type_em_prov_provt']);


$tipo_orden = trim($_POST['nombre_orden']);
$vin = trim($_POST['vin_herramienta']);



if ($idlogistica != "" and $fecha_a == "" and $fecha_b == "" and $id_em_prov_provt == "" || $type_em_prov_provt == "" and $tipo_orden == "" and $vin == "") {

	$query_vin = "SELECT * FROM orden_logistica_unidades WHERE visible = 'SI' and idorden_logistica = '$idlogistica'";

}elseif ($idlogistica == "" and $fecha_a != "" and $fecha_b != "" and $id_em_prov_provt == "" || $type_em_prov_provt == "" and $tipo_orden == "" and $vin == "") {

	$query_vin = "SELECT * FROM orden_logistica_unidades WHERE visible = 'SI' and DATE_FORMAT(fecha_creacion, '%Y-%m-%d') between '$fecha_a' and '$fecha_b' ";

}elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $id_em_prov_provt != "" || $type_em_prov_provt != "" and $tipo_orden == "" and $vin == "") {

	$query_vin = "SELECT * FROM orden_logistica_unidades WHERE visible = 'SI' and (idresponsable = '$id_em_prov_provt' and tipo_responsable = '$type_em_prov_provt' || idpersona_asignada = '$id_em_prov_provt' and tipopersona_asignada = '$type_em_prov_provt' )";

}elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $id_em_prov_provt == "" || $type_em_prov_provt == "" and $tipo_orden != "" and $vin == "") {

	$query_vin = "SELECT * FROM orden_logistica_unidades WHERE visible = 'SI' and TRIM(tipo_orden) = '$tipo_orden'";

}elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $id_em_prov_provt == "" || $type_em_prov_provt == "" and $tipo_orden == "" and $vin != "") {

	$query_vin = "SELECT * FROM orden_logistica_unidades WHERE visible = 'SI' and TRIM(vin) = '$vin'";

} else{
	$query_vin = "SELECT * FROM orden_logistica_unidades WHERE visible = 'SI'";
}



$result_vin = mysql_query($query_vin);

$count = 0;
while ($row_vin = mysql_fetch_array($result_vin)) {

	$idlogistica_encriptada = base64_encode($row_vin[idorden_logistica]);

	$link = "<a href='orden_logistica_detalles.php?idib=$idlogistica_encriptada' target='_blank'>$row_vin[idorden_logistica]</a>";

	$array_vin = date_vin($row_vin[vin]);
	$porciones_vin = explode("|", $array_vin);

	$vin = $porciones_vin[0];
	$marca = $porciones_vin[1];
	$version = $porciones_vin[2];
	$color = $porciones_vin[3];
	$modelo = $porciones_vin[4];
	$tipo = $porciones_vin[5];


	$array_principal = nombres_datos($row_vin[idresponsable], $row_vin[tipo_responsable]);
	$result_nombre = explode("|", $array_principal);

	$nombre_principal_table = ($result_nombre[11] == "Colaborador") ? $result_nombre[2] : "$result_nombre[0] $result_nombre[1]" ;


	$array_secundario = nombres_datos($row_vin[idpersona_asignada], $row_vin[tipopersona_asignada]);
	$result_nombre_asignado = explode("|", $array_secundario);

	$nombre_secundario_table = ($result_nombre_asignado[11] == "Colaborador") ? $result_nombre_asignado[2] : "$result_nombre_asignado[0] $result_nombre_asignado[1]" ;

	$fecha_create = date_create($row_vin[fecha_creacion]);
	$fecha_tabla =  date_format($fecha_create, 'Y-m-d');

	$mensaje .= "<tr>
	<td>$link</td>
	<td>$row_vin[tipo_orden]</td>
	<td>$vin</td>
	<td>$marca</td>
	<td>$version</td>
	<td>$color</td>
	<td>$modelo</td>
	<td>$tipo</td>
	<td>$nombre_principal_table</td>
	<td>$nombre_secundario_table</td>
	<td>$fecha_tabla</td>
	</tr>";



}





$mensaje .= "
</tbody>
</table>
</div>
</div>";






#-------------------------------------------Funcion VIN y Tipo--------------------------------------------------------------------------------
function date_vin($vin) {

	$buscar_vin = trim($vin);


	$query_logistica_unidades = "SELECT * from inventario where TRIM(vin_numero_serie) = '$buscar_vin' and TRIM(estatus_unidad) <> 'Utilitaria' and TRIM(estatus_unidad) <> 'Utilitario'";
	$result_query_logistica_unidades = mysql_query($query_logistica_unidades);

	if (mysql_num_rows($result_query_logistica_unidades) >= 1) {

		while ($row_query_logistica_unidades = mysql_fetch_array($result_query_logistica_unidades)) {
			$marca_logistica = trim("$row_query_logistica_unidades[marca]");
			$version_logistica = trim("$row_query_logistica_unidades[version]");
			$color_logistica = trim("$row_query_logistica_unidades[color]");
			$modelo_logistica = trim("$row_query_logistica_unidades[modelo]");
			$ver_vin = trim("$row_query_logistica_unidades[vin_numero_serie]");
			$id_unidad = trim($row_query_logistica_unidades[idinventario]);
		}

		$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Unidad|$id_unidad";

	}else{

		$query_logistica_trucks = "SELECT * from inventario_trucks where TRIM(vin_numero_serie) = '$buscar_vin' and TRIM(estatus_unidad) <> 'Utilitaria' and TRIM(estatus_unidad) <> 'Utilitario'";
		$result_query_logistica_trucks = mysql_query($query_logistica_trucks);

		if (mysql_num_rows($result_query_logistica_trucks) >= 1) {
			while ($row_query_logistica_trucks = mysql_fetch_array($result_query_logistica_trucks)) {

				$marca_logistica = trim("$row_query_logistica_trucks[marca]");
				$version_logistica = trim("$row_query_logistica_trucks[version]");
				$color_logistica = trim("$row_query_logistica_trucks[color]");
				$modelo_logistica = trim("$row_query_logistica_trucks[modelo]");
				$ver_vin = trim("$row_query_logistica_trucks[vin_numero_serie]");
				$id_unidad = trim($row_query_logistica_trucks[idinventario]);
			}

			$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Trucks|$id_unidad";

		}else{

			$query_logistica_utilitario = "SELECT * from catalogo_unidades_utilitarios where TRIM(vin) = '$buscar_vin'";
			$result_query_logistica_utilitario = mysql_query($query_logistica_utilitario);

			if (mysql_num_rows($result_query_logistica_utilitario) >= 1) {

				while ($row_query_logistica_utilitario = mysql_fetch_array($result_query_logistica_utilitario)) {

					$marca_logistica = trim("$row_query_logistica_utilitario[marca]");
					$version_logistica = trim("$row_query_logistica_utilitario[version]");
					$color_logistica = trim("$row_query_logistica_utilitario[color]");
					$modelo_logistica = trim("$row_query_logistica_utilitario[modelo]");
					$ver_vin = trim("$row_query_logistica_utilitario[vin]");
					$id_unidad = trim($row_query_logistica_utilitario[idcatalogo_unidades_utilitarios]);
					
				}	

				$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Utilitario|$id_unidad";

			}else{

				$query_logistica_inventario = "SELECT * FROM orden_logistica_inventario WHERE TRIM(vin) = '$buscar_vin' and visible = 'SI'";
				$result_logistica_inventario = mysql_query($query_logistica_inventario);

				if (mysql_num_rows($result_logistica_inventario) >= 1) {

					while ($row_logistica_inventario = mysql_fetch_array($result_logistica_inventario)) {
						$marca_logistica = trim("$row_logistica_inventario[marca]");
						$version_logistica = trim("$row_logistica_inventario[version]");
						$color_logistica = trim("$row_logistica_inventario[color]");
						$modelo_logistica = trim("$row_logistica_inventario[modelo]");
						$ver_vin = trim("$row_logistica_inventario[vin]");
						$id_unidad = trim($row_logistica_inventario[idorden_logistica_inventario]);
					}

					$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Indefinido|$id_unidad";

				}else{
					
					$marca_logistica = trim("Por definir");
					$version_logistica = trim("Por definir");
					$color_logistica = trim("Por definir");
					$modelo_logistica = trim("Por definir");
					$ver_vin = trim("Por definir");
					$id_unidad = trim("Por definir");


					$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Por Definir|$id_unidad";
				}						
			}
		}
	}

	return $result_vin;

}

#-------------------------------------------Funcion Nombres y Tipo--------------------------------------------------------------------------------

function nombres_datos($id_id, $type_type){

	$id_id = trim($id_id);
	$type_type = trim($type_type);


	if ($type_type == "Cliente") {

		$query_cliente = "SELECT * FROM contactos WHERE idcontacto = '$id_id'";
		$result_cliente = mysql_query($query_cliente);

		if (mysql_num_rows($result_cliente) >= 1) {

			while ($row_cliente = mysql_fetch_array($result_cliente)) {
				$nombre = "$row_cliente[nombre]"; 
				$apellidos = "$row_cliente[apellidos]"; 
				$alias = "$row_cliente[alias]"; 
				$telefono = "$row_cliente[telefono_celular]"; 
				$telefono_otro = "$row_cliente[telefono_otro]"; 
				$estado_cliente = "$row_cliente[estado]"; 
				$municipio_cliente = "$row_cliente[delmuni]"; 
				$calle_cliente = "$row_cliente[calle]"; 
				$colonia_cliente = "$row_cliente[colonia]"; 
				$cp_cliente = "$row_cliente[cp_cliente]";
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Cliente";
		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Cliente";
		}

	}elseif ($type_type == "Proveedor") {

		$query_proveedor = "SELECT * FROM proveedores WHERE idproveedores = '$id_id'";
		$result_proveedor = mysql_query($query_proveedor);

		if (mysql_num_rows($result_proveedor) >= 1) {
			
			while ($row_proveedor = mysql_fetch_array($result_proveedor)) {
				$nombre = "$row_proveedor[nombre]"; 
				$apellidos = "$row_proveedor[apellidos]"; 
				$alias = "$row_proveedor[alias]"; 
				$telefono = "$row_proveedor[telefono_celular]"; 
				$telefono_otro = "$row_proveedor[telefono_otro]"; 
				$estado_cliente = "$row_proveedor[estado]"; 
				$municipio_cliente = "$row_proveedor[delmuni]"; 
				$calle_cliente = "$row_proveedor[calle]"; 
				$colonia_cliente = "$row_proveedor[colonia]"; 
				$cp_cliente = "$row_proveedor[cp_cliente]";
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor";
		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor";
		}


	}elseif ($type_type == "Proveedor Temporal") {

		$query_proveedor_tem = "SELECT * FROM orden_logistica_proveedores WHERE idorden_logistica_proveedores = '$id_id'";
		$result_proveedor_tem = mysql_query($query_proveedor_tem);

		if (mysql_num_rows($result_proveedor_tem) >= 1) {

			while ($row_proveedor_tem = mysql_fetch_array($result_proveedor_tem)) {
				$nombre = "$row_proveedor_tem[nombre]"; 
				$apellidos = "$row_proveedor_tem[apellidos]"; 
				$alias = "$row_proveedor_tem[alias]"; 
				$telefono = "$row_proveedor_tem[telefono_celular]"; 
				$telefono_otro = "$row_proveedor_tem[telefono_otro]"; 
				$estado_cliente = "$row_proveedor_tem[estado]"; 
				$municipio_cliente = "$row_proveedor_tem[delmuni]"; 
				$calle_cliente = "$row_proveedor_tem[calle]"; 
				$colonia_cliente = "$row_proveedor_tem[colonia]"; 
				$cp_cliente = "$row_proveedor_tem[codigo_postal]";
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor Temporal";
		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor Temporal";
		}

	}elseif ($type_type == "Colaborador") {

		$query_colaborador = "SELECT * FROM empleados WHERE idempleados = '$id_id'";
		$result_colaborador = mysql_query($query_colaborador);

		if (mysql_num_rows($result_colaborador) >= 1) {

			while ($row_colaborador = mysql_fetch_array($result_colaborador)) {
				$nombre = "$row_colaborador[nombre]"; 
				$apellidos = "$row_colaborador[apellido_paterno]"." "."$row_colaborador[apellido_materno]"; 
				$alias = "$row_colaborador[columna_b]"; 
				$telefono = "$row_colaborador[telefono_personal]"; 
				$telefono_otro = "$row_colaborador[telefono_emergencia]"; 
				$estado_cliente = "$row_colaborador[estado]"; 
				$municipio_cliente = "$row_colaborador[municipio]"; 
				$calle_cliente = "$row_colaborador[calle_numero]"; 
				$colonia_cliente = "$row_colaborador[colonia]"; 
				$cp_cliente = "$row_colaborador[cp]";
				$nomenclatura_co = "$row_colaborador[columna_b]";
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nomenclatura_co|Colaborador";
		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Colaborador";
		}

	}else{
		$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente";
	}

	return $concatenacion;

}






echo $mensaje;
?>