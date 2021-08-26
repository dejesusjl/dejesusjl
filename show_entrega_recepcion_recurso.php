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

		$('#table_entrega_recepcion_recurso').DataTable({
			language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
				"infoEmpty": "Mostrando 0 de 0 de 0 Entradas",
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



				// Total over all pages
				total = api
					.column(3)
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Total over this page
				pageTotal = api
					.column(3, {
						page: 'current'
					})
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Update footer


				$(api.column(3).footer()).html(
					'$ ' + formatNumber.new(pageTotal.toFixed(2)) + ' (Saldo Total: $ ' + formatNumber.new(total.toFixed(2)) + ' )'
				);

				var cantidad_total = $(".cantidad_total2").html();
				$(".m-cantidad-total-2").html(cantidad_total);

			},



			responsive: true,
			lengthMenu: [
				[10, 25, 50, 100, -1],
				[10, 25, 50, 100, "All"]
			],
			dom: 'Blfrtip',
			buttons: [
				'copy', 'excel'
			]


		});


		var table = $('#table_entrega_recepcion_recurso').DataTable();

		table
			.order([0, 'asc'])
			.draw();

		$(function() {
			otable = $('#table_entrega_recepcion_recurso').dataTable();
		})

	});

	function filter_recurso() {


		var types = $('input:checkbox[name="filter_tipo_movimiento"]:checked').map(function() {
			return '^' + this.value + '\$';
		}).get().join('|');

		otable.fnFilter(types, 1, true, false, false, false);


		var types = $('input:checkbox[name="filter_id"]:checked').map(function() {
			return '^' + this.value + '\$';
		}).get().join('|');

		otable.fnFilter(types, 2, true, false, false, false);


		var types = $('input:checkbox[name="filter_responsable"]:checked').map(function() {
			return '^' + this.value + '\$';
		}).get().join('|');

		otable.fnFilter(types, 5, true, false, false, false);


		var types = $('input:checkbox[name="filter_status_recurso"]:checked').map(function() {
			return '^' + this.value + '\$';
		}).get().join('|');

		otable.fnFilter(types, 9, true, false, false, false);


		var types = $('input:checkbox[name="filter_status_logistica"]:checked').map(function() {
			return '^' + this.value + '\$';
		}).get().join('|');

		otable.fnFilter(types, 10, true, false, false, false);


		var types = $('input:checkbox[name="filter_status_tesoreria"]:checked').map(function() {
			return '^' + this.value + '\$';
		}).get().join('|');

		otable.fnFilter(types, 11, true, false, false, false);


		var types = $('input:checkbox[name="filter_status_cobranza"]:checked').map(function() {
			return '^' + this.value + '\$';
		}).get().join('|');

		otable.fnFilter(types, 12, true, false, false, false);

	}



	$(function() {
		otable = $('#table_entrega_recepcion_recurso').dataTable();

	});
</script>






<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
date_default_timezone_set('America/Mexico_City');

$usuario_creador = $_SESSION['usuario_clave'];

$query_usuario_creador = "SELECT * FROM usuarios WHERE idusuario = '$usuario_creador'";
$result_usuario_creador = mysql_query($query_usuario_creador);

while ($row_usuario_creador = mysql_fetch_array($result_usuario_creador)) {

	$rol_loguin = trim($row_usuario_creador[rol]);
}

include_once ($rol_loguin == "100") ?  "funciones_principales.php" : "../Logistica/funciones_principales.php";



$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$idcolaboradorloguin = trim($_POST['idcolaboradorloguin']);


if ($fecha_inicio != "" and $fecha_fin != "") {

	$fecha_a = $fecha_inicio;
	$fecha_b = $fecha_fin;
} elseif ($fecha_inicio != "" and $fecha_fin == "") {

	$fecha_a = $fecha_inicio;
	$fecha_b = $fecha_inicio;
} elseif ($fecha_inicio == "" and $fecha_fin != "") {

	$fecha_a = $fecha_fin;
	$fecha_b = $fecha_fin;
} else {

	$fecha_a = date("Y-m-01 ");
	$fecha_b = date("Y-m-d");
}






$filter_entrega_recepcion_tipo = '<hr><i class="fas fa-filter fa-1.5x" onclick="mostrarModalrecurso(\'tipo_movimiento\')" class="filter-center"></a>';
$filter_nombre_id = '<hr><i class="fas fa-filter fa-1.5x" onclick="mostrarModalrecurso(\'id\')" class="filter-center"></a>';
$filter_responsable = '<hr><i class="fas fa-filter fa-1.5x" onclick="mostrarModalrecurso(\'responsable\')" class="filter-center"></a>';
$filter_estatus_recurso = '<hr><i class="fas fa-filter fa-1.5x" onclick="mostrarModalrecurso(\'status_recurso\')" class="filter-center"></a>';
$filter_estatus_logistica = '<hr><i class="fas fa-filter fa-1.5x" onclick="mostrarModalrecurso(\'status_logistica\')" class="filter-center"></a>';
$filter_estatus_tesoreria = '<hr><i class="fas fa-filter fa-1.5x" onclick="mostrarModalrecurso(\'status_tesoreria\')" class="filter-center"></a>';
$filter_estatus_cobranza = '<hr><i class="fas fa-filter fa-1.5x" onclick="mostrarModalrecurso(\'status_cobranza\')" class="filter-center"></a>';
$filter_block = '<hr><i class="fas fa-times-circle fa-1.5 filter-center"></i>';



if ($idcolaboradorloguin == "") {

	$valor_consulta = "Error";
} else if ($idcolaboradorloguin == "3" || $idcolaboradorloguin == "88" || $idcolaboradorloguin == "91" || $idcolaboradorloguin == "136") {

	$valor_consulta = "";
} elseif ($idcolaboradorloguin == "65") {

	$valor_consulta = "AND concepto = 'Recepción'";
} else {

	$valor_consulta = "Error";
}


$mensaje .= "
<div class='container-bg-1 p-3'>
<div class='table-responsive'>
<table width='100%' class='table table-striped table-bordered table-hover panel-body-center-table' id='table_entrega_recepcion_recurso'>
<thead>

<tr>
<th>#</th>
<th>Movimiento$filter_entrega_recepcion_tipo</th>
<th>ID$filter_nombre_id</th>
<th>Monto Total$filter_block</th>
<th>Contenedor Final$filter_block</th>
<th>Responsable$filter_responsable</th>
<th>Logística$filter_block</th>
<th>Fecha&nbsp;&nbsp;</th>
<th>Referencia$filter_block</th>
<th>Estatus Recurso$filter_estatus_recurso</th>
<th>Estatus Logística$filter_estatus_logistica</th>
<th>Estatus Tesorería$filter_estatus_tesoreria</th>
<th>Estatus Cobranza$filter_estatus_cobranza</th>
<th>Token$filter_block</th>
<th>Acciones$filter_block</th>
<th>Editar$filter_block</th>
</tr>

</thead>
<tbody>

";


$count_money = 0;
$count_money = "";
$tipo_recurso = "";
$nombre_id_recurso = "";
$monto_entregado_recolectado = "";
$nombre_responsable_recurso = "";
$logistica = "";
$fecha_movimiento = "";
$referencia_recibo = "";
$estatus_recurso = "";
$estatus_logistica = "";
$estatus_tesoreria = "";
$estatus_cobranza = "";
$token = "";
$recibo_recurso = "";
$bitacora_wallet = "";
$evidencia_recibo = "";
$token_1_recibo = "";
$aplicar_recurso_wallet = "";
$aplicar_recurso_trasladista = "";
$ver_sin_confirmar_tesoreria = "";
$recibo_tesoreria = "";
$contenedor_final = "";
$change_id = "";
$change_type_cambio = "";
$delete_mov = "";

$query_recurso = "SELECT * FROM orden_logistica_recurso WHERE fecha BETWEEN '$fecha_a' AND '$fecha_b' $valor_consulta ORDER BY idorden_logistica DESC";
$result_recurso = mysql_query($query_recurso);

while ($row_recurso = mysql_fetch_array($result_recurso)) {

	#------------------------------------------- AutoIncrementable --------------------------------------------------------------------------------

	$count_money++;

	#------------------------------------------- Movimiento --------------------------------------------------------------------------------

	$tipo_recurso = trim($row_recurso[concepto]);
	$tipo_entrada_salida = ($tipo_recurso == "Recepción") ? "Ingreso" : "Egreso";

	#------------------------------------------- ID --------------------------------------------------------------------------------

	$query_documentacion = "SELECT * FROM orden_logistica_documentacion WHERE idorden_logistica_documentacion = '$row_recurso[idorden_logistica_documentacion]'";
	$result_documentacion = mysql_query($query_documentacion);

	while ($row_documentacion = mysql_fetch_array($result_documentacion)) {

		$id_id = trim($row_documentacion[id_responsable]);
		$tipo_tabla_id = ($row_documentacion[tipo_responsable] == "Proveedor Info") ? "Transacciones" : $row_documentacion[tipo_responsable];

		$name_id = explode("|", nombres_datos($row_documentacion[id_responsable], $row_documentacion[tipo_responsable]));

		$search_evidencia = $row_documentacion[evidencia];
	}

	$nombre_id_recurso = "$id_id.$name_id[10] - $tipo_tabla_id";

	#------------------------------------------- Monto Total --------------------------------------------------------------------------------

	$gran_total = number_format($row_recurso[gran_total], 2);

	$monto_entregado_recolectado = "$$gran_total $row_recurso[tipo_moneda]";

	#------------------------------------------- Responsable --------------------------------------------------------------------------------

	$query_logistica = "SELECT * FROM orden_logistica WHERE idorden_logistica = $row_recurso[idorden_logistica]";
	$result_logistica = mysql_query($query_logistica);

	while ($row_logistica = mysql_fetch_array($result_logistica)) {

		$name_responsable = explode("|", nombres_datos($row_logistica[idasigna], $row_logistica[tipo_asignante]));

		$nombre_responsable_recurso = "$name_responsable[10]-$name_responsable[2]";
	}


	#------------------------------------------- Id Logistica --------------------------------------------------------------------------------

	$logistica_encriptada = base64_encode($row_recurso[idorden_logistica]);
	$logistica = ($rol_loguin == "100" || $rol_loguin == "101" || $rol_loguin == "102") ? "<a href='orden_logistica_detalles.php?idib=$logistica_encriptada' target='_blank'><b>$row_recurso[idorden_logistica]</b></a>" : $row_recurso[idorden_logistica];

	#------------------------------------------- Fecha --------------------------------------------------------------------------------

	$fecha_movimiento = date_create($row_recurso[fecha]);
	$fecha_movimiento = date_format($fecha_movimiento, "d-m-Y");

	#------------------------------------------- Referencia --------------------------------------------------------------------------------

	$referencia_recibo = ReferenciaVisiblesWallet($row_recurso[referencia]);
	$copy_and_paste_referencia = "<hr><i class='far fa-copy fa-2x' onclick=\"CopyAndPaste('$referencia_recibo')\"></i>";


	#------------------------------------------- Estatus Recurso --------------------------------------------------------------------------------

	$estatus_recurso = (trim($row_recurso[estatus]) == "Cancelado") ? "Cancelado" : EstatusRecursoFuncion($referencia_recibo, $row_recurso[idorden_logistica_recurso]);

	#------------------------------------------- Estatus Logistica --------------------------------------------------------------------------------

	$estatus_logistica = EstatusPrincipalLogistica($row_recurso[idorden_logistica]);

	#------------------------------------------- Estatus Tesoreria --------------------------------------------------------------------------------

	$estatus_tesoreria = (trim($row_recurso[estatus]) == "Cancelado") ? "Cancelado" : ConsultarReferenciaSeguimiento($referencia_recibo);

	#------------------------------------------- Estatus Cobranza --------------------------------------------------------------------------------

	$estatus_cobranza = (trim($row_recurso[estatus]) == "Cancelado") ? "Cancelado" : Estatus_CobranzaFuncion($referencia_recibo);

	#------------------------------------------- Token --------------------------------------------------------------------------------

	$token = TokenWalletUltimo($referencia_recibo);

	#------------------------------------------- Color Movimiento --------------------------------------------------------------------------------
	$style_row = ($estatus_cobranza == "Pendiente") ? "class='color_movimiento alineacion'" : "class='alineacion'";
	$espacio = '<i class="fas fa-minus fa-rotate-90 fa-3x"></i>';

	#------------------------------------------- Contenedor Final --------------------------------------------------------------------------------


	if ($name_id[11] == "Cliente") {

		$contenedor_final = "<td $style_row ><font size='3' color='#c2185b'><b>Crédito y Cobranza<b></font></td>";
	} else if ($name_id[11] == "Proveedor") {

		$contenedor_final = ($name_id[12] == "8") ? "<td $style_row><font size='3' color='#3498db'><b>Compras</b></font></td>" : "<td $style_row><font size='3' color='#f9a822'><b>Balance de Gastos</b></font></td>";
	} elseif ($name_id[11] == "Proveedor Info" || $name_id[11] == "Transacciones") {

		if (trim($name_id[12]) == "Bienes Raices") {

			$contenedor_final = "<td $style_row><font size='3' color='#d7df23'><b>Bienes Raíces</b></font></td>";
		} else if (trim($name_id[12]) == "Prestamos") {

			$contenedor_final = "<td $style_row><font size='3' color='#e74c3c'><b>Préstamos</b></font></td>";
		} else if (trim($name_id[12]) == "Transacciones") {

			$contenedor_final = "<td $style_row><font size='3' color='#008388'><b>Transacciones</b></font></td>";
		} else {

			$contenedor_final = "<td $style_row><font size='3' color='#c62828'><b>Posible Error</b></font></td>";
		}
	} elseif ($name_id[11] == "Colaborador" || $name_id[11] == "Proveedor Temporal") {

		$contenedor_final = "<td $style_row><font size='3' color='#c62828'><b>Posible Error</b></font></td>";
	} else {

		$contenedor_final = "<td $style_row><font size='3' color='#c62828'><b>Posible Error</b></font></td>";
	}

	#------------------------------------------- Recibo Recurso --------------------------------------------------------------------------------

	$idorden_logistica_documentacion_encriptado = base64_encode($row_recurso[idorden_logistica_documentacion]);

	$recibo_recurso = ReciboRecurso($referencia_recibo, $idorden_logistica_documentacion_encriptado, $rol_loguin, $espacio);

	#------------------------------------------- Bitacora --------------------------------------------------------------------------------

	$bitacora_wallet = "<i class='fas fa-info-circle fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Bitácora de Movimientos' onclick=\"ActionsModalWallet('InfoB|$referencia_recibo|$tipo_entrada_salida');\"></i>$espacio";

	#------------------------------------------- Recibo Recurso --------------------------------------------------------------------------------

	#$evidencia_recibo = (file_exists($search_evidencia)) ? "<a href='$search_evidencia' target='_blank' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Visualizar evidencia'><i class='far fa-images fa-2x' aria-hidden='true'></i></a>$espacio" : "<i class='fas fa-eye-slash fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Evidencia Pendiente'></i>$espacio";

	if (file_exists($search_evidencia)) {

		$evidencia_recibo = "
		<a href='$search_evidencia' target='_blank' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Visualizar evidencia'><i class='far fa-images fa-2x' aria-hidden='true'></i></a>&nbsp;&nbsp;
		<i class='fas fa-exchange-alt fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar Evidencia' onclick=\"ActionsModalWallet('SubirEvidencia|$tipo_entrada_salida|$logistica_encriptada|$referencia_recibo|$row_recurso[idorden_logistica_documentacion]');\"></i>$espacio
		";
	} else {

		$evidencia_recibo = "<i class='fas fa-upload fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Subir Evidencia' onclick=\"ActionsModalWallet('SubirEvidencia|$tipo_entrada_salida|$logistica_encriptada|$referencia_recibo|$row_recurso[idorden_logistica_documentacion]');\"></i>$espacio";
	}

	#------------------------------------------- Token Recibo --------------------------------------------------------------------------------

	$ver_sin_confirmar_recibo = ConsultarBitacoraWallet("Confirmar Recibo", $tipo_entrada_salida, $referencia_recibo);

	$token_1_recibo = ($ver_sin_confirmar_recibo == 0 and $estatus_recurso == "Pendiente" and $nombre_responsable_recurso != "Pendiente-Pendiente") ? "<i class='fas fa-key fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Confirmar Token Inicial' onclick=\"ActionsModalWallet('TokenRecibo|$tipo_entrada_salida|$token|$logistica_encriptada|$referencia_recibo');\"></i>$espacio" : "";

	#------------------------------------------- Token Confirmar Recurso --------------------------------------------------------------------------------

	if (trim($row_recurso[estatus]) != "Cancelado") {

		if ($tipo_entrada_salida == "Egreso") {

			$aplicar_recurso = ConsultarBitacoraWallet("Validación Recurso", $tipo_entrada_salida, $referencia_recibo);

			$aplicar_recurso_wallet = ($aplicar_recurso == 0 and $ver_sin_confirmar_recibo == 1) ? "<i class='fas fa-gavel fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Confirmar $tipo_entrada_salida de Recurso' onclick=\"ActionsModalWallet('ConfirmarRecurso|$tipo_entrada_salida|$row_recurso[gran_total]|$logistica_encriptada|$referencia_recibo');\"></i>$espacio" : "";
		} else {

			$ver_sin_confirmar_recurso = ConsultarBitacoraWallet("Validación Recurso", $tipo_entrada_salida, $referencia_recibo);

			$aplicar_recurso_wallet = ($ver_sin_confirmar_recurso == 0 and $ver_sin_confirmar_recibo == 1) ? "<i class='fas fa-gavel fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Confirmar $tipo_entrada_salida de Recurso' onclick=\"ActionsModalWallet('ConfirmarRecurso|$tipo_entrada_salida|$row_recurso[gran_total]|$logistica_encriptada|$referencia_recibo');\"></i>$espacio" : "";
		}
	}

	#------------------------------------------- Token Confirmar Tesoreria --------------------------------------------------------------------------------

	if ($tipo_entrada_salida == "Ingreso") {

		$ver_sin_confirmar_trasladista = ConsultarReferenciaSeguimiento($referencia_recibo);
		$ver_sin_confirmar_traspaso = ConsultarBitacoraWallet("Traspaso Recurso", $tipo_entrada_salida, $referencia_recibo);

		$aplicar_recurso_trasladista = ($ver_sin_confirmar_trasladista == "Pendiente" and $estatus_recurso == "Confirmado" and $ver_sin_confirmar_traspaso == 0) ? "<i class='fas fa-hand-holding-usd fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Aplicar $tipo_entrada_salida de Recurso desde Tesorería' onclick=\"ActionsModalWallet('ConfirmarTrasladista|$tipo_entrada_salida|$token|$logistica_encriptada|$referencia_recibo');\"></i>$espacio" : "";
	} else {

		$aplicar_recurso_trasladista = "";
	}

	$query_tesoreria = "SELECT * FROM empleados_wallet WHERE visible = 'SI' and tipo_movimiento = 'abono' AND estatus = 'Pendiente' AND referencia_seguimiento = '$referencia_recibo' AND (receptor = 'TP1' || receptor = 'TEDFM' ||  receptor = 'TJFR' || receptor = 'TP3')";
	$result_tesoreria = mysql_query($query_tesoreria);

	while ($row_tesoreria = mysql_fetch_array($result_tesoreria)) {

		$tokentesoreria = $row_tesoreria[token];
		$idempleadoswallettesoreria = $row_tesoreria[idempleados_wallet];
	}

	$ver_sin_confirmar_tesoreria = (mysql_num_rows($result_tesoreria) == 1 and trim($row_recurso[estatus]) != "Cancelado") ? "<i class='fas fa-money-check-alt fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Aplicar $tipo_entrada_salida de Recurso desde Tesorería' onclick=\"ActionsModalWallet('ConfirmarTesoreria|$tipo_entrada_salida|$tokentesoreria|$logistica_encriptada|$idempleadoswallettesoreria|$referencia_recibo');\"></i>$espacio" : "";

	#------------------------------------------- Recibo Tesoreria --------------------------------------------------------------------------------

	$recibo_tesoreria = ReciboTesoreria($referencia_recibo, $rol_loguin, $espacio);

	#------------------------------------------- Cambiar ID --------------------------------------------------------------------------------

	$change_id = ($estatus_cobranza == "Pendiente" and $estatus_tesoreria == "Pendiente") ? "<i class='fas fa-user-edit fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar ID' onclick=\"ActionsModalWallet('CambiarID|$referencia_recibo|$tipo_entrada_salida');\"></i> $espacio" : "";

	#------------------------------------------- Cambiar Fecha --------------------------------------------------------------------------------

	$change_date = (trim($row_recurso[estatus]) != "Cancelado") ? "<i class='fas fa-calendar-alt fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar Fecha de Movimiento' onclick=\"ActionsModalWallet('CambiarDate|$referencia_recibo|$tipo_entrada_salida|$logistica_encriptada');\"></i>$espacio" : "";

	#------------------------------------------- Agregar Tipo de Cambio --------------------------------------------------------------------------------

	$query_change_cambio = "SELECT * FROM estado_cunta_tesorerias_traspasos WHERE visible = 'SI' AND trim(referencia_seguimiento) = '$referencia_recibo' ";
	$result_change_cambio = mysql_query($query_change_cambio);
	$si_change_cambio = mysql_num_rows($result_change_cambio);

	while ($row_monto_traspaso = mysql_fetch_array($result_change_cambio)) {

		$monto_traspaso_tesorerias = $row_monto_traspaso[monto_precio];
	}

	$change_type_cambio = ($si_change_cambio >= 1 and trim($row_recurso[tipo_moneda]) != "MXN" and $estatus_cobranza == "Pendiente" and trim($row_recurso[estatus]) != "Cancelado") ? "<i class='fas fa-funnel-dollar fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Asignar Tipo de Cambio' onclick=\"ActionsModalWallet('TipoCambio|$referencia_recibo|$tipo_entrada_salida|$monto_entregado_recolectado|$monto_traspaso_tesorerias|$row_recurso[tipo_moneda]|$logistica_encriptada');\"></i>$espacio" : "";

	#------------------------------------------- Eliminar Movimiento --------------------------------------------------------------------------------

	if ($idcolaboradorloguin == "3" || $idcolaboradorloguin == "88" || $idcolaboradorloguin == "91") {

		$delete_mov = ($estatus_cobranza == "Pendiente" and $estatus_tesoreria != "Aplicado") ? "<i class='fas fa-trash fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar Fecha de Movimiento' onclick=\"ActionsModalWallet('DeleteMov|$referencia_recibo|$tipo_entrada_salida');\"></i>$espacio" : "";
	} else {

		$delete_mov = "";
	}
	#------------------------------------------- Imprimir Recurso --------------------------------------------------------------------------------


	$mensaje .= "<tr>
	<td $style_row>$count_money</td>
	<td $style_row>$tipo_recurso</td>
	<td $style_row>$nombre_id_recurso</td>
	<td $style_row>$monto_entregado_recolectado</td>
	$contenedor_final
	<td $style_row>$nombre_responsable_recurso</td>
	<td $style_row>$logistica</td>
	<td $style_row>$fecha_movimiento</td>
	<td $style_row>$referencia_recibo $copy_and_paste_referencia</td>
	<td $style_row>$estatus_recurso</td>
	<td $style_row>$estatus_logistica</td>
	<td $style_row>$estatus_tesoreria</td>
	<td $style_row>$estatus_cobranza</td>
	<td $style_row>$token</td>
	<td $style_row>$recibo_recurso$bitacora_wallet$evidencia_recibo$token_1_recibo$aplicar_recurso_wallet$aplicar_recurso_trasladista$ver_sin_confirmar_tesoreria$recibo_tesoreria</td>
	<td $style_row>$change_id$change_date$change_type_cambio$delete_mov</td>
	</tr>";
}


$mensaje .= "
</tbody>
<tfoot>

<th colspan='3' style='text-align:right'>Total:</th>
<th colspan='13' style='text-align:left;' class='cantidad_total'></th>

</tfoot>
</table>

</div>
</div>";

echo $mensaje;


#------------------------------------------- Recibo Recurso Recibo --------------------------------------------------------------------------------

function ReciboRecurso($referencia_seguimiento, $idorden_logistica_documentacion_encriptado, $rol_loguin, $espacio)
{

	$referencia_seguimiento = trim($referencia_seguimiento);
	$idorden_logistica_documentacion_encriptado = trim($idorden_logistica_documentacion_encriptado);
	$rol_loguin = trim($rol_loguin);

	$query_referencia_visibles = "SELECT * FROM empleados_wallet WHERE visible = 'SI' AND trim(referencia_seguimiento) = '$referencia_seguimiento' LIMIT 1";
	$result_referencia_visibles = mysql_query($query_referencia_visibles);

	if (mysql_num_rows($result_referencia_visibles) == 1) {

		if ($rol_loguin == "") {

			$recibo_recurso = "<a href='#'  data-bs-toggle='tooltip' data-bs-placement='bottom' title='Sin Acceso'><i class='fas fa-file-pdf fa-2x' aria-hidden='true'></i></a>$espacio";
		} elseif ($rol_loguin == "100" || $rol_loguin == "101" || $rol_loguin == "102") {

			$recibo_recurso = "<a href='recibo_wallet_pdf.php?idrb=$idorden_logistica_documentacion_encriptado' target='_blank' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Mostrar Recibo Recurso'><i class='fas fa-file-pdf fa-2x' aria-hidden='true'></i></a>$espacio";
		} else {

			$recibo_recurso = "<a href='../Logistica/recibo_wallet_pdf.php?idrb=$idorden_logistica_documentacion_encriptado' target='_blank' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Mostrar Recibo Recurso'><i class='fas fa-file-pdf fa-2x' aria-hidden='true'></i></a>$espacio";
		}
	} else {

		if ($rol_loguin == "") {

			$recibo_recurso = "<a href='#'  data-bs-toggle='tooltip' data-bs-placement='bottom' title='Sin Acceso'><i class='fas fa-file-pdf fa-2x' aria-hidden='true'></i></a>$espacio";
		} elseif ($rol_loguin == "100" || $rol_loguin == "101" || $rol_loguin == "102") {

			$recibo_recurso = "<a href='recibo_recurso_pdf.php?idrb=$idorden_logistica_documentacion_encriptado' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Mostrar Recibo Recurso' target='_blank'><i class='far fa-file-pdf fa-2x' aria-hidden='true'></i></a>$espacio";
		} else {

			$recibo_recurso = "<a href='../Logistica/recibo_recurso_pdf.php?idrb=$idorden_logistica_documentacion_encriptado' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Mostrar Recibo Recurso' target='_blank'><i class='far fa-file-pdf fa-2x' aria-hidden='true'></i></a>$espacio";
		}
	}

	return $recibo_recurso;
}

#------------------------------------------- Recibo Tesoreria Recibo --------------------------------------------------------------------------------


function ReciboTesoreria($referencia_seguimiento, $rol_loguin, $espacio)
{

	$referencia_seguimiento = trim($referencia_seguimiento);
	$rol_loguin = trim($rol_loguin);

	$query_referencia_tesoreria = "SELECT * FROM estado_cuenta_tesorerias_egresos_ingresos WHERE visible = 'SI' AND trim(referencia_seguimiento) = '$referencia_seguimiento'";
	$result_referencia_tesoreria = mysql_query($query_referencia_tesoreria);

	if (mysql_num_rows($result_referencia_tesoreria) >= 1) {

		while ($row_referencia_tesoreria = mysql_fetch_array($result_referencia_tesoreria)) {

			$id_tesoreria_encriptado = base64_encode($row_referencia_tesoreria[idestado_cuenta_tesorerias_egresos_ingresos]);
		}

		if ($rol_loguin == "") {

			$recibo_tesoreria = "<a href='#'  data-bs-toggle='tooltip' data-bs-placement='bottom' title='Sin Acceso'><i class='far fa-file-pdf fa-2x' aria-hidden='true'></i></a>$espacio";
		} elseif ($rol_loguin == "Tesorerias") {

			$recibo_tesoreria = "<a href='recibo_tesoreria_egresos_pdf.php?id=$id_tesoreria_encriptado' target='_blank' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Mostrar Recibo Tesorería'><i class='far fa-file-pdf fa-2x' aria-hidden='true'></i></a>$espacio";
		} else {

			$recibo_tesoreria = "<a href='../Tesorerias/recibo_tesoreria_egresos_pdf.php?id=$id_tesoreria_encriptado' target='_blank' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Mostrar Recibo Tesorería'><i class='far fa-file-pdf fa-2x' aria-hidden='true'></i></a>$espacio";
		}
	}

	return $recibo_tesoreria;
}



?>