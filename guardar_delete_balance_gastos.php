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


?>



<script>




	$(document).ready(function() {

		var formatNumber = {
			separador: ",", 
			sepDecimal: '.', 
			formatear:function (num){
				num +='';
				var splitStr = num.split('.');
				var splitLeft = splitStr[0];
				var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
				var regx = /(\d+)(\d{3})/;
				while (regx.test(splitLeft)) {
					splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
				}
				return this.simbol + splitLeft  +splitRight;
			},
			new:function(num, simbol){
				this.simbol = simbol ||'';
				return this.formatear(num);
			}
		}


		$('#table_balance').DataTable({
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
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;


				var intVal = function ( i ) {
					return typeof i === 'string' ?
					i.replace(/[\$,]/g, '')*1 :
					typeof i === 'number' ?
					i : 0;
				};


				total = api
				.column( 4 )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );

				
				pageTotal = api
				.column( 4, { page: 'current'} )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );

				


				$( api.column( 4 ).footer() ).html(
					'$ '+formatNumber.new(pageTotal.toFixed(2))+' (Saldo Total: $ '+formatNumber.new(total.toFixed(2))+' )'
					);
			},
			responsive: true,
			lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
			dom: 'Blfrtip',
			buttons: [
			'copy', 'excel'
			],

		});

		var table = $('#table_balance').DataTable();

		table
		.order([ 0, 'asc' ])
		.draw();


		function filterme_balance() {


			var types = $('input:checkbox[name="filter_concepto_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 1, true, false, false, false);


			var types = $('input:checkbox[name="filter_concepto_movimiento"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 2, true, false, false, false);


			var types = $('input:checkbox[name="filter_fecha_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 3, true, false, false, false);


			var types = $('input:checkbox[name="filter_responsable_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 6, true, false, false, false);


			var types = $('input:checkbox[name="filter_datos_vin_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 7, true, false, false, false);


			var types = $('input:checkbox[name="filter_metodo_pago_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 8, true, false, false, false);


			var types = $('input:checkbox[name="filter_comision_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 9, true, false, false, false);


			var types = $('input:checkbox[name="filter_idcatalogo_provedores_balance"]:checked').map(function() {
				return '^' + this.value + '\$';
			}).get().join('|');

			otable.fnFilter(types, 10, true, false, false, false);


		}



		$(function() {
			otable = $('#table_balance').dataTable();

		});        


	});





	

</script>



<?php 


$idc = trim($_POST['idc']);


$mensaje = "
<div class='table-responsive'>
<table width='100%' class='table table-striped table-bordered table-hover panel-body-center-table' id='table_balance'>
<thead>
<tr>
<th class='txt-balance'>#<hr><span class='fa-stack fa-1x'><i class='fas fa-filter fa-stack-1x'></i><i class='fas fa-ban fa-stack-1x' style='color: #882439;'></i></span></th>
<th class='txt-balance'>Concepto<hr><i class='fas fa-filter' onclick=\"mostrarModalbalance('concepto')\"></i></th>
<th class='txt-balance'>T.Movimiento<hr><i class='fas fa-filter' onclick=\"mostrarModalbalance('tmovimineto')\"></i></th>
<th class='txt-balance'>Fecha Movimiento<hr><i class='fas fa-filter' onclick=\"mostrarModalbalance('fecha')\"></i></th>
<th class='txt-balance'>Monto Cargo<hr><span class='fa-stack fa-1x'><i class='fas fa-filter fa-stack-1x'></i><i class='fas fa-ban fa-stack-1x' style='color: #882439;'></i></span></th>
<th class='txt-balance'>Monto Abono<hr><span class='fa-stack fa-1x'><i class='fas fa-filter fa-stack-1x'></i><i class='fas fa-ban fa-stack-1x' style='color: #882439;'></i></span></th>
<th class='txt-balance'>Responsable<hr><i class='fas fa-filter' onclick=\"mostrarModalbalance('responsable')\"></i></th>
<th class='txt-balance'>VIN<hr><i class='fas fa-filter' onclick=\"mostrarModalbalance('vin')\"></i></th>
<th class='txt-balance'>Método de Pago<hr><i class='fas fa-filter' onclick=\"mostrarModalbalance('mpago')\"></i></th>
<th class='txt-balance'>Tarjeta<hr><i class='fas fa-filter' onclick=\"mostrarModalbalance('tarjeta')\"></i></th>
<th class='txt-balance'>Proveedor<hr><i class='fas fa-filter' onclick=\"mostrarModalbalance('proveedor')\"></i></th>
<th class='txt-balance'>Acciones<hr><span class='fa-stack fa-1x'><i class='fas fa-filter fa-stack-1x'></i><i class='fas fa-ban fa-stack-1x' style='color: #882439;'></i></span></th>
</tr>
</thead>

<tbody>

";



$count_requisiscion = 0;
$query_requisicion = "SELECT * FROM balance_gastos_operacion WHERE columna2 = '$idc' and visible = 'SI'";
$result_query_requisicion =  mysql_query($query_requisicion);

while($row_requisicion = mysql_fetch_array($result_query_requisicion)){
	# idbalance_gastos_operacion encriptado ---
	$idesre = base64_encode($row_requisicion[idbalance_gastos_operacion]);
	# contador ---
	$count_requisiscion++;
	# Fecha Movimiento ---
	$date_r = date_create($row_requisicion[fecha_movimiento]);
	$fecha_balance_movimiento = date_format($date_r,'d-m-Y'); 
	# Monto Cargo ---
	$monto_requisicion_cargo = (trim($row_requisicion[tipo_movimiento]) == "cargo") ? number_format($row_requisicion[gran_total], 2) : number_format("0",2);
	# Monto Abono ---
	$monto_requisicion_abono = (trim($row_requisicion[tipo_movimiento]) == "abono") ? number_format($row_requisicion[gran_total], 2) : number_format("0",2);
	# Responsable ---
	if (is_numeric(trim($row_requisicion[responsable]))) {

		$show_balance_responsable = nombres_datos($row_requisicion[responsable], "Colaborador");
		$show_balance_responsable_porciones = explode("|", $show_balance_responsable);
		$responsable_requisicion = $show_balance_responsable_porciones[2];

	}else{

		$responsable_requisicion = trim($row_requisicion[responsable]);

	}
	# Metodo de pago ---
	$balance_metodo_pago = (trim($row_requisicion[comision]) == "N/A") ? "Efectivo" : "Tarjeta";
	# Nombre proveedor ---
	$proveedor_nombre_balance = NombreProveedorBalance ($row_requisicion[idcatalogo_provedores]);

    #--- Inician las Acciones ---
	# Recibo ---
	$recibido_pdf_aux = (trim($row_requisicion[tipo_movimiento]) == "abono" and trim($row_requisicion[tipo_comprobante]) == "RECIBO AUTOMáTICO") ? "<a href='recibo_pdf_aux_logistica.php?idrb=$idesre' target='_blank' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Visualizar recibo'><i class='fa fa-file-pdf-o fa-2x' aria-hidden='true'></i></a>" : "<span class='fa-stack fa-lg'><i class='fa fa-file-pdf-o fa-stack-1x fa-2x'></i><i class='fa fa-ban fa-stack-2x text-danger fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Sin recibo'></i></span>";
	# Evidencia ---
	$ver_archivo_requisicion = (file_exists($row_requisicion[archivo])) ? 
	"<a href='$row_requisicion[archivo]' target='_blank' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Mostrar evidencia $row_requisicion[tipo_movimiento]'><i class='fa fa-picture-o fa-2x' aria-hidden='true'></i></a>
	<i class='fas fa-exchange-alt fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Reemplazar evidencia $row_requisicion[tipo_movimiento]' onclick=\"ModalFormActionsBalance('$idesre,Evidencia,SI')\"></i>" : 
	"<i class='fa fa-upload fa-2x' aria-hidden='true' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cargar Evidencia $row_requisicion[tipo_movimiento]' onclick=\"ModalFormActionsBalance('$idesre,Evidencia,NO')\"></i>";

	$concepto_change_balance = "<i class='fas fa-keyboard fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar Concepto: $row_requisicion[concepto]' onclick=\"ModalFormActionsBalance('$idesre,Concepto')\"></i>";

	$ver_tipo_movimiento = "<i class='fas fa-file-contract fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Agregar un auxiliar INDIVIDUAL' onclick=\"ModalFormActionsBalance('$idesre,AuxiliarIndividual')\"></i>";
	# Cambiar fecha ---
	$fecha_change_balance = "<i class='far fa-calendar-alt fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar fecha' onclick=\"ModalFormActionsBalance('$idesre,Fechas')\"></i>";
	# Cambiar monto
	$monto_change_balance = "<i class='fas fa-dollar-sign fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar monto' onclick=\"ModalFormActionsBalance('$idesre,MontoBalance')\"></i>";
	# Cambiar responsable ---
	$change_resp = "<i class='fas fa-user-friends fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar responsable' onclick=\"ModalFormActionsBalance('$idesre,ResponsableIndividual')\"></i>";
	# Cambiar VIN ---
	$change_vin	= "<i class='fas fa-car fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar eliminar VIN' onclick=\"ModalFormActionsBalance('$idesre,VINIndividual')\"></i>";
	# Rendimiento ---
	$change_rendimiento = (trim($row_requisicion[concepto]) == "CARGA DE COMBUSTIBLE") ? "<a href='cambio_gasolina.php?idbgo=$idesre&clm2=$recibido' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Cambiar Rendimiento'> <i class='fas fa-gas-pump fa-2x'></i> </a>" : "";
	# Eliminar Movimiento ---
	$delete_balance = "<i class='fas fa-trash fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Eliminar Movimiento' onclick=\"ModalFormActionsBalance('$idesre,Visible')\"></i>";

	$mensaje .= "<tr class='odd gradeX'>
	<td>$count_requisiscion</td>
	<td>".trim($row_requisicion[concepto])."</td>
	<td>".trim($row_requisicion[tipo_movimiento])."</td>
	<td>$fecha_balance_movimiento</td>
	<td>$ $monto_requisicion_cargo</td>
	<td>$ $monto_requisicion_abono</td>
	<td>$responsable_requisicion</td>
	<td>".trim($row_requisicion[datos_vin])."</td>
	<td>$balance_metodo_pago</td>
	<td>".trim($row_requisicion[comision])."</td>
	<td>$proveedor_nombre_balance</td>
	<td>$recibido_pdf_aux&nbsp;&nbsp;$ver_archivo_requisicion&nbsp;&nbsp;$concepto_change_balance&nbsp;&nbsp;$ver_tipo_movimiento&nbsp;&nbsp;$fecha_change_balance&nbsp;&nbsp;$monto_change_balance&nbsp;&nbsp;$change_resp&nbsp;&nbsp;$change_vin&nbsp;&nbsp;$delete_balance&nbsp;&nbsp;$change_rendimiento</td>
	</tr>
	";

}





$mensaje.="
</tbody>
<tfoot>
<tr>
<th colspan='4' style='text-align:right'>Total:</th>
<th colspan='8' style='text-align:left;'></th>
</tr>
</tfoot>
</table>
</div>
";











echo $mensaje;
?>