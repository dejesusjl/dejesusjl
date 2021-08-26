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
	var formatNumber = {
		separador: ",",
		sepDecimal: '.',
		formatear: function(num) {
			num += '';
			var splitStr = num.split('.');
			var splitLeft = splitStr[0];
			var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
			var regx = /(\d+)(\d{3})/;
			while (regx.test(splitLeft)) {
				splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
			}
			return this.simbol + splitLeft + splitRight;
		},
		new: function(num, simbol) {
			this.simbol = simbol || '';
			return this.formatear(num);
		}
	}

	$(document).ready(function() {

		$('#table_combustible_tag').DataTable({

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

			"footerCallback": function(row, data, start, end, display) {
				var api = this.api(),
					data;


				var intVal = function(i) {

					var ok = i;

					if (typeof i === 'string') {

						let uno = ok.replace('$', '');
						uno = uno.replace('MXN', '');
						uno = uno.replace(',', '');
						uno = uno.replace('USD', '');
						uno = uno.replace('CAD', '');

						return uno = parseFloat(uno);

					} else if (typeof i === 'number') {

						return typeof i === 'number' ? i : 0;

					}
				};




				total = api
					.column(6)
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);


				pageTotal = api
					.column(6, {
						page: 'current'
					})
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				$(api.column(6).footer()).html(
					'$ ' + formatNumber.new(pageTotal.toFixed(2)) + ' (Saldo Total: $ ' + formatNumber.new(total.toFixed(2)) + ' )'
				);

				var cantidad_total = $(".cantidad_total2").html();
				$(".m-cantidad-total-2").html(cantidad_total);

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

		var table = $('#table_combustible_tag').DataTable();

		table
			.order([0, 'asc'])
			.draw();

	});
</script>


<?php

#------------------------------- Tipo Vista ------

$tipo_vista = trim($_POST['tipo_vista']);

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];


// $tipo_vista = "CasetasALL";
// $fecha_inicio = "2021-07-01 00:00:00";
// $fecha_fin = "2021-08-03 23:59:59";

if ($fecha_inicio == "" and $fecha_fin != "") {

	$fecha_a = $fecha_fin . " 00:00:00";
	$fecha_b = $fecha_fin . " 23:59:59";
	#
} elseif ($fecha_inicio != "" and $fecha_fin == "") {

	$fecha_a = $fecha_inicio . " 00:00:00";
	$fecha_b = $fecha_inicio . " 23:59:59";
	#
} elseif ($fecha_inicio != "" and $fecha_fin != "") {

	$fecha_a = $fecha_inicio . " 00:00:00";
	$fecha_b = $fecha_fin . " 23:59:59";
	#
} elseif ($fecha_inicio == "" and $fecha_fin == "") {

	$fecha_a = date("Y-m-01 00:00:00");
	$fecha_b = date("Y-m-d 23:59:59");
	#
}

$array_combustible_broxel = ['CasetasAgregado', 'CasetasPendiente', 'CasetasOtros', 'CasetasALL', 'CombustibleAgregadoBroxel', 'CombustiblePendienteBroxel', 'CombustibleOtrosBroxel', 'CombustibleALLBroxel', 'CombustibleAgregadoSiVale', 'CombustiblePendienteSiVale', 'CombustibleOtrosSiVale', 'CombustibleALLSiVale'];

if (in_array($tipo_vista, $array_combustible_broxel)) {

	$mensaje .= EncabezadosCombustible($tipo_vista);

	if ($tipo_vista == "CasetasAgregado") {

		$query_casetas = "SELECT * FROM orden_logistica_casetas WHERE visible = 'SI' AND concepto = 'TAG' AND estatus = 'Agregado' and idorden_logistica <> '' AND fecha_movimiento between '$fecha_a' AND '$fecha_b' order by fecha_movimiento ASC";
		$mensaje .= CasetasQuery($query_casetas);
		#
	} elseif ($tipo_vista == "CasetasPendiente") {

		$query_casetas = "SELECT * FROM orden_logistica_casetas WHERE visible = 'SI' AND concepto = 'TAG' AND estatus = 'Pendiente' and idorden_logistica = '' AND fecha_movimiento between '$fecha_a' AND '$fecha_b' order by fecha_movimiento ASC";
		$mensaje .= CasetasQuery($query_casetas);
		#
	} elseif ($tipo_vista == "CasetasOtros") {

		$query_casetas = "SELECT * FROM orden_logistica_casetas WHERE visible = 'SI' AND concepto = 'TAG' AND estatus <> 'Pendiente' and estatus <> 'Agregado' AND estatus <> '' AND fecha_movimiento between '$fecha_a' AND '$fecha_b' order by fecha_movimiento ASC";
		$mensaje .= CasetasQuery($query_casetas);
		#
	} elseif ($tipo_vista == "CasetasALL") {

		$query_casetas = "SELECT * FROM orden_logistica_casetas WHERE visible = 'SI' AND concepto = 'TAG' AND fecha_movimiento between '$fecha_a' AND '$fecha_b' order by fecha_movimiento ASC";
		$mensaje .= CasetasQuery($query_casetas);
		#
	} elseif ($tipo_vista == "CombustibleAgregadoBroxel") {

		$query_combustible = "SELECT * FROM orden_logistica_combustible WHERE visible = 'SI' AND concepto = 'Broxel' AND estatus = 'Agregado' and idorden_logistica <> '' AND fecha_movimiento between '$fecha_a' AND '$fecha_b' AND establecimiento <> 'Su pago gracias' order by fecha_movimiento ASC";
		$mensaje .= CombustibleQuery($query_combustible);
		#
	} elseif ($tipo_vista == "CombustiblePendienteBroxel") {

		$query_combustible = "SELECT * FROM orden_logistica_combustible WHERE visible = 'SI' AND concepto = 'Broxel' AND estatus = 'Pendiente' and idorden_logistica = '' AND fecha_movimiento between '$fecha_a' AND '$fecha_b' AND establecimiento <> 'Su pago gracias' order by fecha_movimiento ASC";
		$mensaje .= CombustibleQuery($query_combustible);
		#
	} elseif ($tipo_vista == "CombustibleOtrosBroxel") {

		$query_combustible = "SELECT * FROM orden_logistica_combustible WHERE visible = 'SI' AND concepto = 'Broxel' AND estatus <> 'Pendiente' and estatus <> 'Agregado' AND estatus <> '' AND fecha_movimiento between '$fecha_a' AND '$fecha_b' AND establecimiento <> 'Su pago gracias' order by fecha_movimiento ASC";
		$mensaje .= CombustibleQuery($query_combustible);
		#
	} elseif ($tipo_vista == "CombustibleALLBroxel") {

		$query_combustible = "SELECT * FROM orden_logistica_combustible WHERE visible = 'SI' AND concepto = 'Broxel' AND fecha_movimiento between '$fecha_a' AND '$fecha_b' AND establecimiento <> 'Su pago gracias' order by fecha_movimiento ASC";
		$mensaje .= CombustibleQuery($query_combustible);
		#
	} else 	if ($tipo_vista == "CombustibleAgregadoSiVale") {

		$query_combustible = "SELECT * FROM orden_logistica_combustible WHERE visible = 'SI' AND concepto = 'Si Vale' AND estatus = 'Agregado' and idorden_logistica <> '' AND fecha_movimiento between '$fecha_a' AND '$fecha_b' AND establecimiento <> 'TRANSFERENCIA A TERCEROS' order by fecha_movimiento ASC";
		$mensaje .= CombustibleQuery($query_combustible);
		#
	} elseif ($tipo_vista == "CombustiblePendienteSiVale") {

		$query_combustible = "SELECT * FROM orden_logistica_combustible WHERE visible = 'SI' AND concepto = 'Si Vale' AND estatus = 'Pendiente' and idorden_logistica = '' AND fecha_movimiento between '$fecha_a' AND '$fecha_b' AND establecimiento <> 'TRANSFERENCIA A TERCEROS' order by fecha_movimiento ASC";
		$mensaje .= CombustibleQuery($query_combustible);
		#
	} elseif ($tipo_vista == "CombustibleOtrosSiVale") {

		$query_combustible = "SELECT * FROM orden_logistica_combustible WHERE visible = 'SI' AND concepto = 'Si Vale' AND estatus <> 'Pendiente' and estatus <> 'Agregado' AND estatus <> '' AND fecha_movimiento between '$fecha_a' AND '$fecha_b' AND establecimiento <> 'TRANSFERENCIA A TERCEROS' order by fecha_movimiento ASC";
		$mensaje .= CombustibleQuery($query_combustible);
		#
	} elseif ($tipo_vista == "CombustibleALLSiVale") {

		$query_combustible = "SELECT * FROM orden_logistica_combustible WHERE visible = 'SI' AND concepto = 'Si Vale' AND fecha_movimiento between '$fecha_a' AND '$fecha_b' AND establecimiento <> 'TRANSFERENCIA A TERCEROS' order by fecha_movimiento ASC";
		$mensaje .= CombustibleQuery($query_combustible);
		#
	} else {
		$mensaje = "";
	}

	$mensaje .= FooterTable($tipo_vista);
}


echo $mensaje;

function EncabezadosCombustible($tipo_vista)
{

	if ($tipo_vista == 'CasetasAgregado' || $tipo_vista == 'CasetasPendiente' || $tipo_vista == 'CasetasOtros' || $tipo_vista == 'CasetasALL') {

		$tipo_encabezado = "
		<div class='container-bg-1 p-3'>
		<div class='table-responsive'>
		<table class='table table-striped table-bordered table-hover panel-body-center-table' id='table_combustible_tag' style='width: 100%;'>
		<thead>
		<tr>
		<th>#</th>
		<th>Concepto</th>
		<th>Número de Tarjeta</th>
		<th>Titular</th>
		<th>Fecha de Movimiento</th>
		<th>Establecimiento</th>
		<th>Costo Total</th>
		<th>Estatus</th>
		<th>Acciones</th>
		</tr>
		</thead>
		<tbody>
		";
		#
	} else if ($tipo_vista == 'CombustibleAgregadoBroxel' || $tipo_vista == 'CombustiblePendienteBroxel' || $tipo_vista == 'CombustibleOtrosBroxel' || $tipo_vista == 'CombustibleALLBroxel' || $tipo_vista == 'CombustibleAgregadoSiVale' || $tipo_vista == 'CombustiblePendienteSiVale' || $tipo_vista == 'CombustibleOtrosSiVale' || $tipo_vista == 'CombustibleALLSiVale') {

		$tipo_encabezado = "
		<div class='container-bg-1 p-3'>
		<div class='table-responsive'>
		<table class='table table-striped table-bordered table-hover panel-body-center-table' id='table_combustible_tag' style='width: 100%;'>
		<thead>
		<tr>
		<th>#</th>
		<th>Concepto</th>
		<th>Número de Tarjeta</th>
		<th>Titular</th>
		<th>Fecha de Movimiento</th>
		<th>Establecimiento</th>
		<th>Costo Total</th>
		<th>Costo Unitario</th>
		<th>Total Litros</th>
		<th>Estatus</th>
		<th>Acciones</th>
		</tr>
		</thead>
		<tbody>
		";
	}


	return $tipo_encabezado;
}

#------------------------------------------- Casetas  --------------------------------------------------------------------------------

function CasetasQuery($query_casetas)
{
	$result_caseta_tarjeta = mysql_query($query_casetas);
	//echo  mysql_num_rows($result_caseta_tarjeta);
	$num = 0;
	$costo_total = 0;

	while ($row_caseta_tarjeta = mysql_fetch_array($result_caseta_tarjeta)) {

		#------------------------------------------- Espacio --------------------------------------------------------------------------------

		$espacio = '<i class="fas fa-minus fa-rotate-90 fa-3x"></i>';

		#------------------------------------------- Id codificado ------------------------------------------------------------------------------

		$idorden_logistica_casetas_encriptada = base64_encode(trim($row_caseta_tarjeta[idorden_logistica_casetas]));

		#------------------------------------------- Increment ------------------------------------------------------------------------------

		$num++;

		#------------------------------------------- Numero Tarjeta --------------------------------------------------------------------------------

		$btnCopiar = '<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Copiar Número de tarjeta"><i class="far fa-copy fa-2x" aria-hidden="true" id="copy_info" onclick="copiar_info(' . $row_caseta_tarjeta[tag] . ');" ></i></span>';

		$buscar_tag_casetas = explode("|", BuscarMonederoElectronico($row_caseta_tarjeta[tag]));

		$num_tarjeta = ($buscar_tag_casetas[0] == "Pendiente") ? $row_caseta_tarjeta[tag] : chunk_split($row_caseta_tarjeta[tag], 4, " ") . "<hr> $btnCopiar";

		#------------------------------------------- Titular Tarjeta --------------------------------------------------------------------------------

		$titular_tarjeta = ($buscar_tag_casetas[0] == "Pendiente") ? $row_caseta_tarjeta[tag] : $buscar_tag_casetas[3];

		#------------------------------------------- fecha movimiento --------------------------------------------------------------------------------

		$fecha_movimiento = date_format(date_create($row_caseta_tarjeta[fecha_movimiento]), 'd-m-Y H:i:s');
		$fecha_form = date_format(date_create($row_caseta_tarjeta[fecha_movimiento]), 'Y-m-d');

		#------------------------------------------- proveedor --------------------------------------------------------------------------------

		$search_proveedor = explode("|", SearchProveedorRFC($row_caseta_tarjeta[rfc], $row_caseta_tarjeta[establecimiento]));
		// $name_proveedor = $search_proveedor[0];
		$name_proveedor = "$row_caseta_tarjeta[caseta] <hr> $row_caseta_tarjeta[carril]";
		#------------------------------------------- Costo Total --------------------------------------------------------------------------------

		$costo_total = number_format($row_caseta_tarjeta[gran_total], 2);

		#------------------------------------------- Estatus  --------------------------------------------------------------------------------

		$estatus = ($row_caseta_tarjeta[estatus] == "") ? "Pendiente" : $row_caseta_tarjeta[estatus];

		#------------------------------------------- Acciones DB --------------------------------------------------------------------------------

		$establecimiento_modal = ($search_proveedor[1] == "OK") ? $search_proveedor[0] : $row_caseta_tarjeta[establecimiento];

		// Referencia

		$fecha_referencia = date_format(date_create($row_caseta_tarjeta[fecha_movimiento]), 'dmY');
		$fecha_create = date("dmYHis");

		$referencia = (trim($row_caseta_tarjeta[consecar]) == "") ? "$row_caseta_tarjeta[gran_total]-$fecha_referencia-$usuario_creador-$fecha_create" : trim($row_caseta_tarjeta[consecar]);

		$acciones = ($row_caseta_tarjeta[visible] == "SI" and $estatus == "Pendiente") ? "<i class='fas fa-edit fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Actualizar Movimiento Logística' onclick=\"ActionsModalWallet('Update|Caseta|$fecha_form|$search_proveedor[1]|$establecimiento_modal|$search_proveedor[3]|$row_caseta_tarjeta[gran_total]|$row_caseta_tarjeta[precio_unitario]|$row_caseta_tarjeta[litros]|TAG ID DE MEXICO SA DE CV|$row_caseta_tarjeta[tag]|$referencia|$row_caseta_tarjeta[idorden_logistica_casetas]');\"></i>$espacio" : "";


		$fila_caseta .= "<tr>
		<td>$num</td>
		<td>$row_caseta_tarjeta[concepto]</td>
		<td>$num_tarjeta</td>
		<td>$titular_tarjeta</td>
		<td>$fecha_movimiento</td>
		<td>$name_proveedor<hr>$row_caseta_tarjeta[rfc]</td>
		<td>$$costo_total</td>
		<td>$estatus</td>
		<td>$acciones</td>
		</tr>";
	}

	return $fila_caseta;
}


#------------------------------------------- Combustible  --------------------------------------------------------------------------------
function CombustibleQuery($query_combustible)
{

	$result_combustible_tarjeta = mysql_query($query_combustible);

	$num = 0;
	$costo_total = 0;
	$costo_individual = 0;
	$litros = 0;

	while ($row_combustible_tarjeta = mysql_fetch_array($result_combustible_tarjeta)) {

		#------------------------------------------- Espacio --------------------------------------------------------------------------------

		$espacio = '<i class="fas fa-minus fa-rotate-90 fa-3x"></i>';

		#------------------------------------------- Id codificado ------------------------------------------------------------------------------

		$idorden_logistica_combustible_encriptada = base64_encode(trim($row_combustible_tarjeta[idorden_logistica_combustible]));

		#------------------------------------------- Increment ------------------------------------------------------------------------------

		$num++;

		#------------------------------------------- Numero Tarjeta --------------------------------------------------------------------------------

		$btnCopiar = '<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Copiar Número de tarjeta"><i class="far fa-copy fa-2x" aria-hidden="true" id="copy_info" onclick="copiar_info(' . $row_combustible_tarjeta[tarjeta] . ');" ></i></span>';

		$buscar_combustible_broxel = explode("|", BuscarMonederoElectronico($row_combustible_tarjeta[tarjeta]));

		$num_tarjeta = ($buscar_combustible_broxel[0] == "Pendiente") ? $row_combustible_tarjeta[tarjeta] : chunk_split($row_combustible_tarjeta[tarjeta], 4, " ") . "<hr> $btnCopiar";

		#------------------------------------------- Titular Tarjeta --------------------------------------------------------------------------------

		$titular_tarjeta = ($buscar_combustible_broxel[0] == "Pendiente") ? $row_combustible_tarjeta[tarjeta] : $buscar_combustible_broxel[3];

		#------------------------------------------- fecha movimiento --------------------------------------------------------------------------------

		$fecha_movimiento = date_format(date_create($row_combustible_tarjeta[fecha_movimiento]), 'd-m-Y H:i:s');
		$fecha_form = date_format(date_create($row_combustible_tarjeta[fecha_movimiento]), 'Y-m-d');

		#------------------------------------------- proveedor --------------------------------------------------------------------------------

		$search_proveedor = explode("|", SearchProveedorRFC($row_combustible_tarjeta[rfc], $row_combustible_tarjeta[establecimiento]));
		$name_proveedor = $search_proveedor[0];
		#------------------------------------------- Costo Total --------------------------------------------------------------------------------

		$costo_total = number_format($row_combustible_tarjeta[gran_total], 2);

		#------------------------------------------- Costo Unitario --------------------------------------------------------------------------------

		$costo_individual = number_format($row_combustible_tarjeta[precio_unitario], 2);

		#------------------------------------------- Litros --------------------------------------------------------------------------------

		$litros = number_format($row_combustible_tarjeta[litros], 2);

		#------------------------------------------- Estatus  --------------------------------------------------------------------------------

		$estatus = ($row_combustible_tarjeta[estatus] == "") ? "Pendiente" : $row_combustible_tarjeta[estatus];

		#------------------------------------------- Acciones DB --------------------------------------------------------------------------------

		$establecimiento_modal = ($search_proveedor[1] == "OK") ? $search_proveedor[0] : $row_combustible_tarjeta[establecimiento];

		// Referencia

		$fecha_referencia = date_format(date_create($row_combustible_tarjeta[fecha_movimiento]), 'dmY');
		$fecha_create = date("dmYHis");

		$referencia = (trim($row_combustible_tarjeta[referencia]) == "") ? "$row_combustible_tarjeta[gran_total]-$fecha_referencia-$usuario_creador-$fecha_create" : trim($row_combustible_tarjeta[referencia]);

		$acciones = ($row_combustible_tarjeta[visible] == "SI" and $estatus == "Pendiente") ? "<i class='fas fa-edit fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Actualizar Movimiento Logística' onclick=\"ActionsModalWallet('Update|Carga de combustible|$fecha_form|$search_proveedor[1]|$establecimiento_modal|$search_proveedor[3]|$row_combustible_tarjeta[gran_total]|$row_combustible_tarjeta[precio_unitario]|$row_combustible_tarjeta[litros]|BROXEL|$row_combustible_tarjeta[tarjeta]|$referencia|$row_combustible_tarjeta[idorden_logistica_combustible]');\"></i>$espacio" : "";


		$fila_tarjeta .= "<tr>
		<td>$num</td>
		<td>$row_combustible_tarjeta[concepto]</td>
		<td>$num_tarjeta</td>
		<td>$titular_tarjeta</td>
		<td>$fecha_movimiento</td>
		<td>$name_proveedor<hr>$row_combustible_tarjeta[rfc]</td>
		<td>$$costo_total</td>
		<td>$$costo_individual</td>
		<td>$litros</td>
		<td>$estatus</td>
		<td>$acciones</td>
		</tr>";
	}

	return $fila_tarjeta;
}

function FooterTable($tipo_vista)
{
	if ($tipo_vista == 'CasetasAgregado' || $tipo_vista == 'CasetasPendiente' || $tipo_vista == 'CasetasOtros' || $tipo_vista == 'CasetasALL') {

		$pie_pagina = "
		</tbody>
		<tfoot>
	
		<th colspan='4' style='text-align:right'>Total:</th>
		<th colspan='3' style='text-align:left;' class='cantidad_total'></th>
	
		</tfoot>
		</table>
		</div>
		</div>";
		#
	} else {
		$pie_pagina = "
		</tbody>
		<tfoot>
	
		<th colspan='4' style='text-align:right'>Total:</th>
		<th colspan='3' style='text-align:left;' class='cantidad_total'></th>
	
		</tfoot>
		</table>
		</div>
		</div>";
	}
	return $pie_pagina;
}

function SearchProveedorRFC($rfc, $establecimiento)
{
	$rfc = trim($rfc);

	if ($rfc == "") {

		$datos_proveedor_rfc = "<u class='spelling-error'>$establecimiento</u>|Agregar|$establecimiento|Pendiente";
	} else {

		$query_proveedor_rfc = "SELECT * FROM proveedores WHERE trim(rfc) = '$rfc'";
		$result_proveedor_rfc = mysql_query($query_proveedor_rfc);

		if (mysql_num_rows($result_proveedor_rfc) == 1) {

			while ($row_proveedor_rfc = mysql_fetch_array($result_proveedor_rfc)) {

				$datos_proveedor_rfc = trim($row_proveedor_rfc[nombre]) . " " . trim($row_proveedor_rfc[apellidos]) . " " . trim($row_proveedor_rfc[alias]) . "|OK|" . trim($row_proveedor_rfc[nombre]) . " " . trim($row_proveedor_rfc[apellidos]) . " " . trim($row_proveedor_rfc[alias]) . "|" . trim($row_proveedor_rfc[idprovedores_compuesto]);
			}
		} elseif (mysql_num_rows($result_proveedor_rfc) >= 2) {

			while ($row_proveedor_rfc = mysql_fetch_array($result_proveedor_rfc)) {

				$concatenar_proveedor .= trim($row_proveedor_rfc[nombre]) . " " . trim($row_proveedor_rfc[apellidos]) . " " . trim($row_proveedor_rfc[alias]) . "<br>";
			}

			$datos_proveedor_rfc = substr($concatenar_proveedor, 0, -4) . "|Muchos|$establecimiento|Pendiente";
		} else {

			$query_proveedor_temporal_rfc = "SELECT * FROM orden_logistica_proveedores WHERE trim(rfc) = '$rfc' ";
			$result_proveedor_temporal_rfc = mysql_query($query_proveedor_temporal_rfc);

			if (mysql_num_rows($result_proveedor_temporal_rfc) == 1) {

				while ($row_proveedor_temporal_rfc = mysql_fetch_array($result_proveedor_temporal_rfc)) {

					$datos_proveedor_rfc = trim($row_proveedor_temporal_rfc[nombre]) . " " . trim($row_proveedor_temporal_rfc[apellidos]) . " " . trim($row_proveedor_temporal_rfc[alias]) . "|OK|" . trim($row_proveedor_temporal_rfc[nombre]) . " " . trim($row_proveedor_temporal_rfc[apellidos]) . " " . trim($row_proveedor_temporal_rfc[alias]) . "|" . trim($row_proveedor_temporal_rfc[idprovedores_compuesto]);
				}
			} elseif (mysql_num_rows($result_proveedor_temporal_rfc) >= 2) {

				while ($row_proveedor_temporal_rfc = mysql_fetch_array($result_proveedor_temporal_rfc)) {
					$concatenar_proveedor_temporal .= trim($row_proveedor_temporal_rfc[nombre]) . " " . trim($row_proveedor_temporal_rfc[apellidos]) . " " . trim($row_proveedor_temporal_rfc[alias]) . "<br>";
				}

				$datos_proveedor_rfc = substr($concatenar_proveedor_temporal, 0, -4) . "|Muchos|$establecimiento|Pendiente";
			} else {

				$datos_proveedor_rfc = "<u class='spelling-error' onclick=\"CorroborarRFC('$rfc');\">$establecimiento</u>|Agregar|$establecimiento|Pendiente";
			}
		}
	}

	return $datos_proveedor_rfc;
}

























?>