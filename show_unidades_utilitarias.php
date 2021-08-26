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
header("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);

?>



<script>
	var formatNumber = {
		separador: ",", // separador para los miles
		sepDecimal: '.', // separador para los decimales
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

		$('#table_utilitarias').DataTable({

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

		var table = $('#table_utilitarias').DataTable();

		table
			.order([0, 'asc'])
			.draw();

		/////////////////////////////////////////////

		$('#table_herramientas').DataTable({
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

				// Remove the formatting to get integer data for summation
				var intVal = function(i) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '') * 1 :
						typeof i === 'number' ?
						i : 0;
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


		var table = $('#table_herramientas').DataTable();

		table
			.order([0, 'asc'])
			.draw();

		$(function() {
			otable = $('#table_herramientas').dataTable();
		})













	});
</script>


<?php




$tipo_tabla = trim($_POST['tipo_tabla']);

$encabezado_tenencias = "";

if ($tipo_tabla == "unidades" || $tipo_tabla == "uvisibles" || $tipo_tabla == "Todo") {

	for ($i = date("Y"); $i >= (date("Y") + 1) - 5; $i--) {

		array_push($array_encabezados, "<th>Tenencia $i<th>");

		$encabezado_tenencias .= "
		<th>Tenencia $i<th>
		";
	}


	$mensaje = "
	<div class='container-bg-1 p-3'>
	<div class='table-responsive'>
	<table class='table table-striped table-bordered table-hover panel-body-center-table' id='table_utilitarias' style='width: 100%;'>
	<thead>
	<tr>
	<th>#</th>
	<th>VIN</th>                                        
	<th>Marca</th>   
	<th>Version</th>  
	<th>Color</th> 
	<th>Modelo</th>
	<th>Matrícula</th>
	<th>Engomado</th>
	<th>Hoy Circula</th>
	$encabezado_tenencias
	<th>Próxima Verificación</th>
	<th>Verificaciones</th>
	<th>Última Logística</th>
	<th>Responsable</th>
	<th>Estatus</th>
	<th>Liberar</th>
	</tr>
	</thead>
	<tbody>
	";

	if ($tipo_tabla == "unidades") {

		$query_utilitarias = "SELECT * FROM  catalogo_unidades_utilitarios WHERE visible ='SI'";
	} elseif ($tipo_tabla == "uvisibles") {

		$query_utilitarias = "SELECT * FROM  catalogo_unidades_utilitarios WHERE visible ='NO'";
	} else {

		$query_utilitarias = "SELECT * FROM  catalogo_unidades_utilitarios";
	}

	$con = 0;
	$lista_tenencias = "";
	$contador_tenencias = 0;
	$verificacion_actual = "";


	$result_utilitarias = mysql_query($query_utilitarias);

	while ($row_utilitarias = mysql_fetch_array($result_utilitarias)) {

		$con++;

		#------------------------------------------- VIN --------------------------------------------------------------------------------

		$vines = base64_encode($row_utilitarias[vin]);
		$vine = "<a href='unidades_utilitarias_detalles.php?vn=$vines'>$row_utilitarias[vin]</a>";

		#------------------------------------------- hoy circulas hoy --------------------------------------------------------------------------------

		$hoy_circula = (HoyCirculasCDMX($row_utilitarias[matricula], $row_utilitarias[tipo_uso]) == "") ? "SI" : HoyCirculasCDMX($row_utilitarias[matricula], $row_utilitarias[tipo_uso]);

		#------------------------------------------- Color Movimiento color --------------------------------------------------------------------------------

		$style_row = (HoyCirculasCDMX($row_utilitarias[matricula], $row_utilitarias[tipo_uso]) == "") ? "class='alineacion'" : "class='color_movimiento alineacion'";

		#------------------------------------------- orden Compra orden --------------------------------------------------------------------------------

		$query_orden_compra = "SELECT * FROM orden_compra_unidades WHERE visible = 'SI' AND trim(vin) like '" . trim($row_utilitarias[vin]) . "' ORDER by idorden_compra_unidades DESC LIMIT 1";
		$result_orden_compra = mysql_query($query_orden_compra);

		while ($row_orden_compra = mysql_fetch_array($result_orden_compra)) {

			$idorden_compra_unidades = $row_orden_compra[idorden_compra_unidades];
		}

		#------------------------------------------- Ultima tenencia ultima --------------------------------------------------------------------------------

		if (is_numeric($row_utilitarias[modelo])) {

			for ($i = date("Y"); $i >= (date("Y") + 1) - 5; $i--) {

				$query_checklist = "SELECT * FROM check_list_expediente_original WHERE idorden_compra_unidades = '$idorden_compra_unidades' AND visible = 'SI' AND tipo_check_list = 'Ingreso' AND (trim(tipo) LIKE '%Tenencia $i%' || CONCAT_WS (' ',tipo_check_list, descripcion) like '%Tenencia $i%') ";
				$result_checklist = mysql_query($query_checklist);

				if (mysql_num_rows($result_checklist) >= 1) {

					$columna_tenencia .= "<td $style_row>SI<td>";
				} else {

					$columna_tenencia .= "<td $style_row>NO<td>";
				}
			}
		} else {

			for ($i = date("Y"); $i >= (date("Y") + 1) - 5; $i--) {

				$columna_tenencia .= "<td $style_row>No aplica<td>";
			}
		}

		//$columna_tenencia .= "<td $style_row>Tenencia $i<td>";



		if (is_numeric($row_utilitarias[modelo]) and $row_utilitarias[modelo] != 0) {

			$cinco_tenencias = (date("Y") + 1) - 5;


			if ($row_utilitarias[modelo] > $cinco_tenencias) {

				$total_tenencias = (date("Y") + 1) - $row_utilitarias[modelo];
			} else {

				$total_tenencias = 5;
			}







			$query_checklist = "SELECT * FROM check_list_expediente_original WHERE idorden_compra_unidades = '$row_orden_compra[idorden_compra_unidades]' AND visible = 'SI' AND tipo_check_list = 'Ingreso' AND tipo LIKE '%Tenencia%' ";
			$result_checklist = mysql_query($query_checklist);

			if (mysql_num_rows($result_checklist) >= 1) {

				while ($row_checklist = mysql_fetch_array($result_checklist)) {

					$contador_tenencias++;

					$concat_tipo_descripcion = (trim($row_checklist[descripcion]) == "") ?  trim($row_checklist[tipo]) : trim($row_checklist[tipo]) . " " . trim($row_checklist[descripcion]);

					$lista_tenencias .= (file_exists($row_checklist[archivo])) ? "<a href='$row_checklist[archivo]' target='_blank'>$concat_tipo_descripcion</a>," : "$concat_tipo_descripcion,";
				}

				$tenencias_restantes = $total_tenencias - $contador_tenencias;

				$tenencias_actuales = "Total de tenencias : <b>$total_tenencias</b> <hr>" . substr($lista_tenencias, 0, -1) . "<hr>Tenencias pagadas: <b>$contador_tenencias</b><br> Tenencias restantes: <b>$tenencias_restantes</b>";
			} else {

				$tenencias_restantes = $total_tenencias - $contador_tenencias;
				$tenencias_actuales = "Total de tenencias : <b>$total_tenencias</b><hr>Tenencias pagadas: <b>$contador_tenencias</b><br> Tenencias restantes: <b>$tenencias_restantes</b>";
			}
		}

		#------------------------------------------- Ultima Verificacion ultima --------------------------------------------------------------------------------

		$proxima_verificacion = VerificacionVehicular($row_utilitarias[tipo_uso]);

		if ($row_utilitarias[tipo_uso] == "N/A" || $row_utilitarias[tipo_uso] == "NA") {

			$verificacion_actual = "No aplica verificación";
		} else {

			$query_orden_verificacion = "SELECT * FROM orden_compra_unidades WHERE visible = 'SI' AND trim(vin) like '" . trim($row_utilitarias[vin]) . "'";
			$result_orden_verificacion = mysql_query($query_orden_verificacion);

			if (mysql_num_rows($result_orden_verificacion) >= 1) {

				while ($row_orden_verificacion = mysql_fetch_array($result_orden_verificacion)) {

					$query_verificacion_checklist = "SELECT * FROM check_list_expediente_original WHERE idorden_compra_unidades = '$row_orden_verificacion[idorden_compra_unidades]' AND visible = 'SI' AND tipo_check_list = 'Ingreso' AND (tipo LIKE '%Verificación vehicular%' || tipo LIKE '%Verificación vehicular%') ";
					$result_verificacion_checklist = mysql_query($query_verificacion_checklist);

					if (mysql_num_rows($result_verificacion_checklist) >= 1) {

						while ($row_verificacion_checklist = mysql_fetch_array($result_verificacion_checklist)) {

							$concat_tipo_descripcion = (trim($row_verificacion_checklist[descripcion]) == "") ?  trim($row_verificacion_checklist[tipo]) : trim($row_verificacion_checklist[tipo]) . " " . trim($row_verificacion_checklist[descripcion]);

							$lista_verificacion .= (file_exists($row_verificacion_checklist[archivo])) ? "<a href='$row_verificacion_checklist[archivo]' target='_blank'>$concat_tipo_descripcion</a>," : "$concat_tipo_descripcion,";
						}

						$verificacion_actual = substr($lista_verificacion, 0, -1);
					} else {

						$verificacion_actual = "Sin Verificación";
					}
				}
			} else {

				$verificacion_actual = "Sin Verificación";
			}
		}

		#------------------------------------------- Ultima Logistica ultima --------------------------------------------------------------------------------

		$query_logistica_unidades = "SELECT * FROM orden_logistica_unidades WHERE trim(vin) = '" . trim($row_utilitarias[vin]) . "' AND visible = 'SI' order by idorden_logistica_unidades desc limit 1";

		$result_logistica_unidades = mysql_query($query_logistica_unidades);
		while ($row_logistica_unidades = mysql_fetch_array($result_logistica_unidades)) {
			$idorden_logistica = $row_logistica_unidades[idorden_logistica];
		}

		#------------------------------------------- Responsable Unidad Responsables --------------------------------------------------------------------------------

		if (is_numeric($row_utilitarias[comentario])) {

			$buscar_responsable = explode("|", nombres_datos($row_utilitarias[comentario], "Colaborador"));
			$responsable = "$buscar_responsable[10]($buscar_responsable[2])";
		} else {

			$responsable = $row_utilitarias[comentario];
		}

		#------------------------------------------- Estatus Unidad Estatus --------------------------------------------------------------------------------


		if ($row_utilitarias[estatus_unidad] == "Disponible") {

			$ver_estatus = "<td $style_row><i class='far fa-check-circle fa-2x'></i></td>";
		} elseif ($row_utilitarias[estatus_unidad] == "En Ruta") {

			$ver_estatus = "<td $style_row><i class='fas fa-road fa-2x'></i></td>";
		} elseif ($row_utilitarias[estatus_unidad] == "Taller") {

			$ver_estatus = "<td $style_row><i class='fas fa-wrench fa-2x'></i></td>";
		} elseif ($row_utilitarias[estatus_unidad] == "Prestamo") {

			$ver_estatus = "<td $style_row><i class='fas fa-handshake fa-2x'></i></td>";
		} elseif ($row_utilitarias[estatus_unidad] == "Descontinuado") {

			$ver_estatus = "<td $style_row><i class='fas fa-car-crash fa-2x'></i></td>";
		} else {
			$ver_estatus = "<td $style_row>$row_utilitarias[estatus_unidad]</td>";
		}



		$tipo_vn_p = base64_encode("vin");

		$liberar = "<td $style_row><a href='liberar_vin_personal.php?type_vn_per=$tipo_vn_p&vn_personal=$vines'><i class='fa fa-check fa-2x' aria-hidden='true'></i></a></td>";

		//$verificar_hoy_circula_unidad = HoyCirculasCDMX ($matricula, $engomado);

		$mensaje .= "<tr class='odd gradeX'>
		<td $style_row>$con</td>
		<td $style_row>$vine</td>
		<td $style_row>$row_utilitarias[marca]</td>
		<td $style_row>$row_utilitarias[version]</td>
		<td $style_row>$row_utilitarias[color]</td>
		<td $style_row>$row_utilitarias[modelo]</td>
		<td $style_row>$row_utilitarias[matricula] <hr> $row_utilitarias[entidad]</td>
		<td $style_row>$row_utilitarias[tipo_uso]</td>
		<td $style_row>$hoy_circula</td>
		$columna_tenencia
		<td $style_row>$proxima_verificacion</td>
		<td $style_row>$verificacion_actual</td>
		<td $style_row>$idorden_logistica</td>
		<td $style_row>$responsable</td>
		$ver_estatus
		$liberar
		</tr>";

		$columna_tenencia = "";
	}


	$mensaje .= "
	</tbody>
	</table>
	</div>
	</div>";
} else {

	$query_group_herramientas = "SELECT tipo FROM unidades_utilitarios_herramientas WHERE visible = 'SI' GROUP BY tipo";
	$result_group_herramientas = mysql_query($query_group_herramientas);

	while ($row_group_herramientas = mysql_fetch_array($result_group_herramientas)) {

		$activos = trim($row_group_herramientas[0]);
		$deletes = trim($row_group_herramientas[0]) . "no";
		$todosss = trim($row_group_herramientas[0]) . "all";



		if ($tipo_tabla == $activos) {

			$query_herramientas = "SELECT * FROM unidades_utilitarios_herramientas WHERE visible = 'SI' and tipo = '$row_group_herramientas[0]' ORDER BY idorden DESC";
			$tipo_th = ($tipo_tabla == "GPS" || $tipo_tabla == "GPSno" || $tipo_tabla == "GPSall") ? "<th>IMEI</th>" : "<th>Póliza</th>";
		} else if ($tipo_tabla == $deletes) {

			$query_herramientas = "SELECT * FROM unidades_utilitarios_herramientas WHERE visible = 'NO' and tipo = '$row_group_herramientas[0]' ORDER BY idorden DESC";
			$tipo_th = ($tipo_tabla == "GPS" || $tipo_tabla == "GPSno" || $tipo_tabla == "GPSall") ? "<th>IMEI</th>" : "<th>Póliza</th>";
		} else if ($tipo_tabla == $todosss) {

			$query_herramientas = "SELECT * FROM unidades_utilitarios_herramientas WHERE tipo = '$row_group_herramientas[0]' ORDER BY idorden DESC";
			$tipo_th = ($tipo_tabla == "GPS" || $tipo_tabla == "GPSno" || $tipo_tabla == "GPSall") ? "<th>IMEI</th>" : "<th>Póliza</th>";
		} elseif ($tipo_tabla == "si_tools") {

			$query_herramientas = "SELECT * FROM unidades_utilitarios_herramientas WHERE visible = 'SI' ORDER BY idorden DESC";
			$tipo_th = "<th>IMEI | Póliza</th>";
		} elseif ($tipo_tabla == "no_tools") {

			$query_herramientas = "SELECT * FROM unidades_utilitarios_herramientas WHERE visible = 'NO' ORDER BY idorden DESC";
			$tipo_th = "<th>IMEI | Póliza</th>";
		} elseif ($tipo_tabla == "all_tools") {

			$query_herramientas = "SELECT * FROM unidades_utilitarios_herramientas ORDER BY idorden DESC";
			$tipo_th = "<th>IMEI | Póliza</th>";
		}
	}




	$mensaje = "
	<div class='container-bg-1 p-3'>
	<div class='table-responsive'>
	<table width='100%'' class='table table-striped table-bordered table-hover panel-body-center-table' id='table_herramientas' style='width: 100%;'>
	<thead>
	<tr>
	<th>#</th>
	<th>Tipo</th>
	<th>Descripción</th>
	<th>Costo Total&nbsp;&nbsp;</th>
	<th>Próxima Fecha de Pago&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th>No. Orden</th>
	<th>Vin</th>                                    
	<th>Marca</th>
	<th>Versión</th>
	<th>Color</th>
	<th>Modelo</th>
	$tipo_th
	<th>Teléfono</th>
	<th>Periodo</th>
	<th>Contratación</th>
	<th>Vencimiento</th>
	<th>Estatus</th>
	<th>Acciones</th>
	</tr>
	</thead>
	<tbody>
	";

	$con = 0;
	$costo_total = "";
	$fecha_contratacion = "";
	$fecha_vencimiento = "";
	$td_time = "";
	$concatenar_acciones = "";
	$evidencia = "";
	$concepto_change = "";
	$monto_change = "";
	$periodo_change = "";
	$change_date = "";
	$show_detail_vin = "";
	$add_orden = "";
	$show_hide_mov = "";

	$result_herramientas = mysql_query($query_herramientas);

	while ($row_herramientas = mysql_fetch_array($result_herramientas)) {

		$con++;
		#ID encriptado para generaracciones
		$idorden_logistica_unidades_utilitarias_encriptado = base64_encode($row_herramientas[idunidades_utilitarios_herramientas]);
		$concepto_encriptado = base64_encode($row_herramientas[tipo]);
		#Buscar Vin

		$porciones_vin = explode("|", date_vin($row_herramientas[vin]));
		$tratar_marca = str_replace(",", "", $porciones_vin[1]);
		$tratar_version = str_replace(",", "", $porciones_vin[2]);
		$tratar_color = str_replace(",", "", $porciones_vin[3]);
		$tratar_modelo = str_replace(",", "", $porciones_vin[4]);
		$tratar_tipo = str_replace(",", "", $porciones_vin[5]);

		$concatenar_vin = "<b>$porciones_vin[0]</b> - $tratar_marca - $tratar_version - $tratar_color - $tratar_modelo -$tratar_tipo";
		# costo total
		$costo_total = (trim($row_herramientas[columna_d]) == "") ? number_format(0, 2) : number_format($row_herramientas[columna_d], 2);
		# Fecha de Pago

		$fecha_inicia_poliza = date_format(date_create($row_herramientas[fecha_a]), 'd');

		// dia HOy

		$hoy_dia = date("d");


		if ($fecha_inicia_poliza < $hoy_dia) {

			$convertir_a_fecha_actual = date("Y-m-$fecha_inicia_poliza");

			$dt = new DateTime($convertir_a_fecha_actual);
			$dt->modify('next month');
			$fecha_recordatorio = $dt->format('d-m-Y');
		} else {

			$fecha_recordatorio = date("$fecha_inicia_poliza-m-Y");
		}

		# no roden

		$query_orden_vin = "SELECT * FROM atencion_clientes WHERE idatencion_clientes = '$row_herramientas[idorden]'";
		$result_orden_vin = mysql_query($query_orden_vin);

		$idorden_encode = base64_encode($row_herramientas[idorden]);
		if (mysql_num_rows($result_orden_vin) >= 1) {

			while ($row_orden_vin = mysql_fetch_array($result_orden_vin)) {

				$orden_vin = "<a href='../Ordenes_Proveedores_Clientes/detalle_orden_pdf.php?val=$idorden_encode' target='_blank'>$row_herramientas[idorden]</a>";
			}
		} else {

			$orden_vin = $row_herramientas[idorden];
		}

		# nueva pestaña con detalles de unidad
		$vin_encriptado = base64_encode($porciones_vin[0]);
		$vine = "<a href='unidades_utilitarias_detalles.php?vn=$vin_encriptado' target='_blank' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Mostrar detalles de unidad'>$porciones_vin[0]</a>";
		#
		$fecha_act = date("Y-m-d H:i:s");

		$f_a = date_create($row_herramientas[fecha_a]);
		$fecha_contratacion = date_format($f_a, "d-m-Y");

		$f_v = date_create($row_herramientas[fecha_vencimiento]);
		$fecha_vencimiento = date_format($f_v, "d-m-Y");

		$datetime1 = date_create($fecha_act);
		$datetime2 = date_create($row_herramientas[fecha_vencimiento]);

		$interval = date_diff($datetime2, $datetime1);

		if ($datetime1 >= $datetime2) {

			$estatus_fecha = "Vencido hace ";

			$color_td = "#F8D7DA;";

			$td_time = ShowMessageIntervalos($interval, $estatus_fecha, $color_td);
		} else {

			$estatus_fecha = "Aun tienes ";

			$color_td = "#CFF4FC;";

			$td_time = ShowMessageIntervalos($interval, $estatus_fecha, $color_td);
		}

		#separador

		$espacio = '<i class="fas fa-minus fa-rotate-90 fa-3x"></i>';

		# Cambiar monto

		$monto_change = "<i class='fas fa-dollar-sign fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar el monto Actual' onclick=\"mostrarModalForm('Monto,$idorden_logistica_unidades_utilitarias_encriptado');\"></i> $espacio ";

		#Cambiar concepto

		$concepto_change = "<i class='fas fa-signature fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar el Concepto' onclick=\"mostrarModalForm('Concepto,$idorden_logistica_unidades_utilitarias_encriptado');\"></i> $espacio ";

		# Agregar Cambiar Archivo

		if (file_exists($row_herramientas[valor])) {

			$evidencia = "
			<a href='$row_herramientas[valor]' target='_blank' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Ver Evidencia'><i class='far fa-image fa-2x'></i></a>&nbsp;
			<i class='fas fa-exchange-alt fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Agregar Evidencia' onclick=\"mostrarModalForm('Evidencia,$idorden_logistica_unidades_utilitarias_encriptado');\"></i>
			$espacio
			";
		} else {

			$evidencia = "<i class='fas fa-upload fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Agregar Evidencia' onclick=\"mostrarModalForm('Evidencia,$idorden_logistica_unidades_utilitarias_encriptado');\"></i>$espacio";
		}

		# Cambiar modalidad de pago

		$periodo_change = "<i class='fas fa-money-check-alt fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar modalidad de pago' onclick=\"mostrarModalForm('Pago,$idorden_logistica_unidades_utilitarias_encriptado');\"></i>$espacio";

		# Cambiar fechas

		$change_date = "<i class='far fa-calendar-alt fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar Fecha Inicio | Vencimiento' onclick=\"mostrarModalForm('Fechas,$idorden_logistica_unidades_utilitarias_encriptado');\"></i>$espacio";

		#eliminar ver movimiento

		$show_hide_mov = ($row_herramientas[visible] == "SI") ?
			"<i class='far fas fa-eye-slash fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Eliminar movimiento' onclick=\"mostrarModalForm('Visible,$idorden_logistica_unidades_utilitarias_encriptado,Eliminar movimiento');\"></i>$espacio" :
			"<i class='fas fa-eye fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Recuperar movimiento' onclick=\"mostrarModalForm('Visible,$idorden_logistica_unidades_utilitarias_encriptado,Recuperar movimiento');\"></i>$espacio";

		# Mostrar PDF detallado de lo que se le ha estado haciendo

		$show_detail_vin = "<a href='show_detalles_herramientas_pdf.php?idmov=$idorden_logistica_unidades_utilitarias_encriptado' target='_blank' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Ver detalles del VIN'><i class='fas fa-file-pdf fa-2x'></i></a>$espacio";

		#agregar numero de orden

		$add_orden = "<i class='fas fa-bezier-curve fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Agregar | Cambiar Tipo de Orden' onclick=\"mostrarModalForm('Orden,$idorden_logistica_unidades_utilitarias_encriptado,$porciones_vin[0]');\"></i>$espacio";

		# editar orden

		$tratar_descripcion = str_replace(",", "", $row_herramientas[descripcion]);
		$tratar_comentarios = str_replace(",", "", $row_herramientas[comentarios]);

		if (trim($row_herramientas[tipo]) == "GPS") {

			$label = "IMEI";
		} else if (trim($row_herramientas[tipo]) == "Póliza de Seguro") {

			$label = "Número de Póliza";
		} else {
			$label = "Columna a";
		}

		$editar_orden = "<i class='fas fa-edit fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Editar Orden' onclick=\"mostrarModalForm('EditarOrden,$idorden_logistica_unidades_utilitarias_encriptado,$concatenar_vin,$row_herramientas[tipo],$tratar_descripcion,$porciones_vin[0],$row_herramientas[idorden],$row_herramientas[tipo_orden],$row_herramientas[estatus],$label,$row_herramientas[columna_a],$row_herramientas[columna_b],$row_herramientas[columna_c],$row_herramientas[fecha_a],$row_herramientas[fecha_vencimiento]');\"></i>$espacio";


		#concatenar inputs

		//$concatenar_acciones = ($row_herramientas[visible] == 'SI') ? "$evidencia $concepto_change $monto_change $periodo_change $change_date $show_detail_vin $add_orden $show_hide_mov $editar_orden" : "$show_hide_mov";
		$concatenar_acciones = ($row_herramientas[visible] == 'SI') ? "$evidencia $show_detail_vin  $editar_orden $show_hide_mov" : "$show_hide_mov";






		$mensaje .= "<tr class='odd gradeX'>
		<td>$con</td>
		<td>$row_herramientas[tipo]</td>
		<td>$row_herramientas[descripcion]</td>
		<td>$$costo_total</td>
		<td>$fecha_recordatorio</td>
		<td>$orden_vin</td>
		<td>$vine</td>                    
		<td>$porciones_vin[1]</td>                    
		<td>$porciones_vin[2]</td>                                              
		<td>$porciones_vin[3]</td>                                              
		<td>$porciones_vin[4]</td> 
		<td>$row_herramientas[columna_a]</td>
		<td>$row_herramientas[columna_b]</td>
		<td>$row_herramientas[columna_c]</td>
		<td>$fecha_contratacion</td>
		<td>$fecha_vencimiento</td>
		$td_time
		<td>$concatenar_acciones</td>
		</tr>";
	}


	$mensaje .= "
	</tbody>
	<tfoot>

	<th colspan='3' style='text-align:right'>Total:</th>
	<th colspan='15' style='text-align:left;' class='cantidad_total2'></th>

	</tfoot>
	</table>
	</div>
	</div>";
}



function ShowMessageIntervalos($interval, $estatus_fecha, $color_td)
{

	if ($interval->format("%y") >= "1") {

		$ver_tiempo_bitacora = $interval->format("%y año con %m mes(es) y %d día(s) con %H hora(s) y %I minuto(s)");

		return $td_time = "<td style='background: $color_td'>$estatus_fecha $ver_tiempo_bitacora</td>";
	} else if ($interval->format("%m") >= "1") {

		$ver_tiempo_bitacora = $interval->format("%m mes(es) y %d día(s) con %H hora(s) y %I minuto(s)");

		return $td_time = "<td style='background: $color_td'>$estatus_fecha $ver_tiempo_bitacora</td>";
	} else if ($interval->format("%d") >= "1") {

		$ver_tiempo_bitacora = $interval->format("%d día(s) con %H hora(s) y %I minuto(s)");

		return $td_time = "<td style='background: $color_td'>$estatus_fecha $ver_tiempo_bitacora</td>";
	} else if ($interval->format("%H") >= "1") {

		$ver_tiempo_bitacora = $interval->format("%H hora(s) y %I minuto(s)");

		return $td_time = "<td style='background: $color_td'>$estatus_fecha $ver_tiempo_bitacora</td>";
	} else {

		$ver_tiempo_bitacora = $interval->format("Apenas %I minuto(s)");

		return $td_time = "<td style='background: $color_td'>$estatus_fecha $ver_tiempo_bitacora</td>";
	}
}








echo $mensaje;
?>