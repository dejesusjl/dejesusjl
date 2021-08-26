<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
header("Expires: Fri, 14 Mar 1980 20:53:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$random = rand(5, 15);

?>
<script>
	$(document).ready(function() {

		$('#table_proveedores_general').DataTable({

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

			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
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


		});

		var table = $('#table_proveedores_general').DataTable();

		table
			.order([0, 'desc'])
			.draw();


	});
</script>



<?php

#------------------------------- Tipo Vista ------

$tipo_vista = trim($_POST['tipo_vista']);

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

//$tipo_vista = "ProveedorSI";
#$fecha_inicio = "2021-07-01 00:00:00";
#$fecha_fin = "2021-08-03 23:59:59";

if ($fecha_inicio == "" and $fecha_fin != "") {
	$fecha_a = $fecha_fin;
	$fecha_b = $fecha_fin;
} elseif ($fecha_inicio != "" and $fecha_fin == "") {
	$fecha_a = $fecha_inicio;
	$fecha_b = $fecha_inicio;
} elseif ($fecha_inicio != "" and $fecha_fin != "") {
	$fecha_a = $fecha_inicio;
	$fecha_b = $fecha_fin;
} elseif ($fecha_inicio == "" and $fecha_fin == "") {
	$fecha_a = date("Y-m-01 00:00:00");
	$fecha_b = date("Y-m-d 23:59:59");
}

$array_proveedores = ['ProveedorSI', 'ProveedorNO', 'ProveedorALL', 'ProveedorTSI', 'ProveedorTNO', 'ProveedorTALL'];

if (in_array($tipo_vista, $array_proveedores)) {

	$title = ($tipo_vista == "ProveedorSI" || $tipo_vista == "ProveedorNO" || $tipo_vista == "ProveedorALL") ? "<center><h1>Proveedor</h1></center>" : "<center><h1>Proveedor Temporal</h1></center>";

	$mensaje .= "
	<div class='container-bg-1 p-3'>
	$title
	<div class='table-responsive'>
	<table class='table table-striped table-bordered table-hover panel-body-center-table' id='table_proveedores_general' style='width: 100%;'>
	<thead>
	<tr>
	<th>#</th>
	<th>ID Compuesto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th>Nombre</th>
	<th>Alias</th>
	<th>RFC</th>
	<th>Direccion</th>
	<th>Contacto</th>
	<th>Estatus</th>
	<th>Usuario | Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th>Acciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	";

	if ($tipo_vista == "ProveedorSI") {

		$query_proveedor = "SELECT * FROM proveedores WHERE visible = 'SI' || visible is null ";
		$mensaje .= Proveedor($query_proveedor);
		#
	} elseif ($tipo_vista == "ProveedorNO") {

		$query_proveedor = "SELECT * FROM proveedores WHERE visible <> 'SI' ";
		$mensaje .= Proveedor($query_proveedor);
		#
	} elseif ($tipo_vista == "ProveedorALL") {

		$query_proveedor = "SELECT * FROM proveedores";
		$mensaje .= Proveedor($query_proveedor);
		#
	} elseif ($tipo_vista == "ProveedorTSI") {

		$query_temporal = "SELECT * FROM orden_logistica_proveedores WHERE visible = 'SI'";
		$mensaje .= TemporalProveedor($query_temporal);
		#
	} elseif ($tipo_vista == "ProveedorTNO") {

		$query_temporal = "SELECT * FROM orden_logistica_proveedores WHERE visible = 'NO'";
		$mensaje .= TemporalProveedor($query_temporal);
		#
	} elseif ($tipo_vista == "ProveedorTALL") {

		$query_temporal = "SELECT * FROM orden_logistica_proveedores";
		$mensaje .= TemporalProveedor($query_temporal);
		#
	} else {

		$mensaje = "";
	}




	$mensaje .= "
	</tbody>

	</table>
	</div>
	</div>";
}


echo $mensaje;


function Proveedor($query_proveedor)
{
	$bitacora_proveedor_normal = "";
	unset($bitacora_proveedor_normal);

	$fila_proveedor = '';
	unset($fila_proveedor);

	$usuario_bitacora_proveedor = '';
	unset($usuario_bitacora_proveedor);

	$result_proveedor = mysql_query($query_proveedor);


	while ($row_proveedor = mysql_fetch_array($result_proveedor)) {

		$nombre_completo = (trim($row_proveedor[apellidos]) == "") ? trim($row_proveedor[nombre]) : trim($row_proveedor[nombre]) . " " . trim($row_proveedor[apellidos]);

		#separador

		$espacio = '<i class="fas fa-minus fa-rotate-90 fa-3x"></i>';

		$alias = (trim($row_proveedor[alias]) == "") ? "N/A" : trim($row_proveedor[alias]);

		$rfc = (trim($row_proveedor[rfc]) == "") ? "N/A" : trim($row_proveedor[rfc]);

		$estado = (trim($row_proveedor[estado]) == "") ? "N/A, " : trim($row_proveedor[estado] . ", ");

		$delmuni = (trim($row_proveedor[delmuni]) == "") ? " N/A, " : trim($row_proveedor[delmuni] . ", ");

		$colonia = (trim($row_proveedor[colonia]) == "") ? " N/A, " : trim($row_proveedor[colonia] . ", ");

		$calle = (trim($row_proveedor[calle]) == "") ? " N/A " : trim($row_proveedor[calle]);

		$direccion = $estado . $delmuni . $colonia . $calle;

		if (trim($row_proveedor[telefono_celular]) == "" and trim($row_proveedor[telefono_otro]) == "") {

			$contacto = "N/A";
			#
		} elseif (trim($row_proveedor[telefono_celular]) != "" and trim($row_proveedor[telefono_otro]) == "") {

			$contacto = trim($row_proveedor[telefono_celular]);
			#
		} elseif (trim($row_proveedor[telefono_celular]) == "" and trim($row_proveedor[telefono_otro]) != "") {

			$contacto = trim($row_proveedor[telefono_otro]);
			#
		} elseif (trim($row_proveedor[telefono_celular]) != "" and trim($row_proveedor[telefono_otro]) != "") {

			$contacto = trim($row_proveedor[telefono_celular]) . "<hr>" . trim($row_proveedor[telefono_otro]);
			#
		}

		$estatus = (trim($row_proveedor[visible]) == "SI") ? "Activo" : "Inactivo";

		$search_usser = explode("|", NameUsuarioCreador($row_proveedor[usuario_creador]));

		$informacion = "$search_usser[0] - $search_usser[1] <hr>" . date_format(date_create($row_proveedor[fecha_creacion]), 'd-m-Y H:i:s');


		$query_proveedor_bitacora = "SELECT * FROM proveedores_cambios WHERE idproveedores = '$row_proveedor[idproveedores]'";
		$result_proveedor_proveedor = mysql_query($query_proveedor_bitacora);

		if (mysql_num_rows($result_proveedor_proveedor) >= 1) {

			while ($row_bitacora_proveedor = mysql_fetch_array($result_proveedor_proveedor)) {

				$usuario_bitacora_proveedor = explode("|", NameUsuarioCreador($row_bitacora_proveedor[usuario]));
				$fecha_bitacora = date_create($row_bitacora_proveedor[fecha]);
				$fecha_bitacora = date_format($fecha_bitacora, 'd-m-Y H:i:s');

				//$bitacora_proveedor_normal .= "$row_bitacora_proveedor[descripcion_cambio] <br> <b>$usuario_bitacora_proveedor[0] - $usuario_bitacora_proveedor[1]</b> <br><b>" . date_format(date_create($row_bitacora_proveedor[fecha]), 'd-m-Y H:i:s') . "</b><hr>";
				$bitacora_proveedor_normal .= "$row_bitacora_proveedor[descripcion_cambio] <br> <b>$usuario_bitacora_proveedor[0] - $usuario_bitacora_proveedor[1]</b> <br><b> $fecha_bitacora </b><hr>";
			}

			#
		} else {
			$bitacora_proveedor_temporal = "";
		}


		$acciones = ($row_proveedor[visible] == "SI") ? "<i class='fas fa-edit fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Actualizar Proveedor' onclick=\"ActionsEditProveedor('Update|$row_proveedor[idproveedores]|$row_proveedor[idprovedores_compuesto]|$row_proveedor[nomeclatura]|$row_proveedor[nombre]|$row_proveedor[apellidos]|$row_proveedor[sexo]|$row_proveedor[rfc]|$row_proveedor[alias]|$row_proveedor[trato]|$row_proveedor[telefono_otro]|$row_proveedor[telefono_celular]|$row_proveedor[email]|$row_proveedor[referencia_nombre]|$row_proveedor[referencia_celular]|$row_proveedor[referencia_fijo]|$row_proveedor[referencia_nombre2]|$row_proveedor[referencia_celular2]|$row_proveedor[referencia_fijo2]|$row_proveedor[referencia_nombre3]|$row_proveedor[referencia_celular3]|$row_proveedor[referencia_fijo3]|$row_proveedor[tipo_registro]|$row_proveedor[recomendado]|$row_proveedor[entrada]|$row_proveedor[asesor]|$row_proveedor[tipo_cliente]|$row_proveedor[tipo_credito]|$row_proveedor[linea_credito]|$row_proveedor[codigo_postal]|$row_proveedor[estado]|$row_proveedor[delmuni]|$row_proveedor[colonia]|$row_proveedor[calle]|$row_proveedor[foto_perfil]|$row_proveedor[metodo_pago]|$row_proveedor[col1]|$row_proveedor[col2]|$row_proveedor[col3]|$row_proveedor[col4]|$row_proveedor[col5]|$row_proveedor[col6]|$row_proveedor[col7]|$row_proveedor[col8]|$row_proveedor[col9]|$row_proveedor[col10]|$row_proveedor[archivo_ine]|$row_proveedor[archivo_comprobante]');\"></i>$espacio" : "";


		$show_bitacora_proveedor = ($bitacora_proveedor_normal != "") ? "<i class='fas fa-info-circle fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Actualizar Proveedor' onclick=\"ShowBitacora('$bitacora_proveedor_normal');\"></i>$espacio" : "";


		$fila_proveedor .= "<tr>
		<td>$row_proveedor[idproveedores]</td>
		<td>$row_proveedor[idprovedores_compuesto]</td>
		<td>$nombre_completo</td>
		<td>$alias</td>
		<td>$rfc</td>
		<td>$direccion</td>
		<td>$contacto</td>
		<td>$estatus</td>
		<td>$informacion</td>
		<td>$acciones $show_bitacora_proveedor</td>
		</tr>";

		unset($bitacora_proveedor_normal);
	}

	return $fila_proveedor;
}


function TemporalProveedor($query_temporal)
{

	$bitacora_proveedor_temporal = '';
	unset($bitacora_proveedor_temporal);


	$fila_proveedor_temporal = '';
	unset($fila_proveedor_temporal);

	$result_proveedorT = mysql_query($query_temporal);

	while ($row_proveedorT = mysql_fetch_array($result_proveedorT)) {

		$nombre_completo = (trim($row_proveedorT[apellidos]) == "") ? trim($row_proveedorT[nombre]) : trim($row_proveedorT[nombre]) . " " . trim($row_proveedorT[apellidos]);

		#separador

		$espacio = '<i class="fas fa-minus fa-rotate-90 fa-3x"></i>';

		$alias = (trim($row_proveedorT[alias]) == "") ? "N/A" : trim($row_proveedorT[alias]);

		$rfc = (trim($row_proveedorT[rfc]) == "") ? "N/A" : trim($row_proveedorT[rfc]);

		$estado = (trim($row_proveedorT[estado]) == "") ? "N/A, " : trim($row_proveedorT[estado] . ", ");

		$delmuni = (trim($row_proveedorT[delmuni]) == "") ? " N/A, " : trim($row_proveedorT[delmuni] . ", ");

		$colonia = (trim($row_proveedorT[colonia]) == "") ? " N/A, " : trim($row_proveedorT[colonia] . ", ");

		$calle = (trim($row_proveedorT[calle]) == "") ? " N/A " : trim($row_proveedorT[calle]);

		$direccion = $estado . $delmuni . $colonia . $calle;

		if (trim($row_proveedorT[telefono_celular]) == "" and trim($row_proveedorT[telefono_otro]) == "") {

			$contacto = "N/A";
			#
		} elseif (trim($row_proveedorT[telefono_celular]) != "" and trim($row_proveedorT[telefono_otro]) == "") {

			$contacto = trim($row_proveedorT[telefono_celular]);
			#
		} elseif (trim($row_proveedorT[telefono_celular]) == "" and trim($row_proveedorT[telefono_otro]) != "") {

			$contacto = trim($row_proveedorT[telefono_otro]);
			#
		} elseif (trim($row_proveedorT[telefono_celular]) != "" and trim($row_proveedorT[telefono_otro]) != "") {

			$contacto = trim($row_proveedorT[telefono_celular]) . "<hr>" . trim($row_proveedorT[telefono_otro]);
			#
		}

		$estatus = (trim($row_proveedorT[visible]) == "SI") ? "Activo" : "Inactivo";

		$search_usser = explode("|", NameUsuarioCreador($row_proveedorT[usuario_creador]));

		$informacion = "$search_usser[0] - $search_usser[1] <hr>" . date_format(date_create($row_proveedorT[fecha_creacion]), 'd-m-Y H:i:s');


		$query_bitacora_proveedor = "SELECT * FROM orden_logistica_proveedores_bitacora WHERE idproveedores = '$row_proveedorT[idorden_logistica_proveedores]'";
		$result_bitacora_proveedor = mysql_query($query_bitacora_proveedor);

		if (mysql_num_rows($result_bitacora_proveedor) >= 1) {

			while ($row_bitacora_proveedor_temporal = mysql_fetch_array($result_bitacora_proveedor)) {

				$usuario_bitacora_temporal = explode("|", NameUsuarioCreador($row_bitacora_proveedor_temporal[usuario]));

				$bitacora_proveedor_temporal .= "$row_bitacora_proveedor_temporal[descripcion_cambio] <br> <b>$usuario_bitacora_temporal[0] - $usuario_bitacora_temporal[1]</b> <br><b>" . date_format(date_create($row_bitacora_proveedor_temporal[fecha]), 'd-m-Y H:i:s') . "</b><hr>";
			}

			#
		} else {
			$bitacora_proveedor_temporal = "";
		}


		$acciones = ($row_proveedorT[visible] == "SI") ? "<i class='fas fa-edit fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Actualizar Proveedor' onclick=\"ActionsEditProveedor('Update|$row_proveedorT[idorden_logistica_proveedores]|$row_proveedorT[idprovedores_compuesto]|$row_proveedorT[nomeclatura]|$row_proveedorT[nombre]|$row_proveedorT[apellidos]|$row_proveedorT[sexo]|$row_proveedorT[rfc]|$row_proveedorT[alias]|$row_proveedorT[trato]|$row_proveedorT[telefono_otro]|$row_proveedorT[telefono_celular]|$row_proveedorT[email]|$row_proveedorT[referencia_nombre]|$row_proveedorT[referencia_celular]|$row_proveedorT[referencia_fijo]|$row_proveedorT[referencia_nombre2]|$row_proveedorT[referencia_celular2]|$row_proveedorT[referencia_fijo2]|$row_proveedorT[referencia_nombre3]|$row_proveedorT[referencia_celular3]|$row_proveedorT[referencia_fijo3]|$row_proveedorT[tipo_registro]|$row_proveedorT[recomendado]|$row_proveedorT[entrada]|$row_proveedorT[asesor]|$row_proveedorT[tipo_cliente]|$row_proveedorT[tipo_credito]|$row_proveedorT[linea_credito]|$row_proveedorT[codigo_postal]|$row_proveedorT[estado]|$row_proveedorT[delmuni]|$row_proveedorT[colonia]|$row_proveedorT[calle]|$row_proveedorT[foto_perfil]|$row_proveedorT[metodo_pago]|$row_proveedorT[col1]|$row_proveedorT[col2]|$row_proveedorT[col3]|$row_proveedorT[col4]|$row_proveedorT[col5]|$row_proveedorT[col6]|$row_proveedorT[col7]|$row_proveedorT[col8]|$row_proveedorT[col9]|$row_proveedorT[col10]|$row_proveedorT[archivo_ine]|$row_proveedorT[archivo_comprobante]');\"></i>$espacio" : "";

		$show_bitacora_proveedor = ($bitacora_proveedor_temporal != "") ? "<i class='fas fa-info-circle fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Visualizar Bitácora' onclick=\"ShowBitacora('$bitacora_proveedor_temporal');\"></i>$espacio" : "";

		$fila_proveedor_temporal .= "<tr>
		<td>$row_proveedorT[idorden_logistica_proveedores]</td>
		<td>$row_proveedorT[idprovedores_compuesto]</td>
		<td>$nombre_completo</td>
		<td>$alias</td>
		<td>$rfc</td>
		<td>$direccion</td>
		<td>$contacto</td>
		<td>$estatus</td>
		<td>$informacion</td>
		<td>$acciones $show_bitacora_proveedor</td>
		</tr>";
	}

	return $fila_proveedor_temporal;
}



?>