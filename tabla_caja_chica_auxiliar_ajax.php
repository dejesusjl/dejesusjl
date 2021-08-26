
<script>

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

	$(document).ready(function() {

		$('#table_pagar_gastos').DataTable({
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
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;


				var intVal = function ( i ) {

					var ok = i;

					if (typeof i === 'string') {

						let uno = ok.replace('$', '');
						uno = uno.replace('MXN', '');
						uno = uno.replace(',', '');
						uno = uno.replace('USD', '');
						uno = uno.replace('CAD', '');

						return uno = parseFloat(uno);

					}else if (typeof i === 'number') {

						return typeof i === 'number' ? i : 0;

					}
				};



            // Total over all pages
            total = api
            .column( 6 )
            .data()
            .reduce( function (a, b) {
            	return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotal = api
            .column( 6, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
            	return intVal(a) + intVal(b);
            }, 0 );

            // Update footer
            

            $( api.column( 6 ).footer() ).html(
            	'$ '+formatNumber.new(pageTotal.toFixed(2))+' (Saldo Total: $ '+formatNumber.new(total.toFixed(2))+' )'
            	);

            var cantidad_total = $(".cantidad_total2").html();
            $(".m-cantidad-total-2").html(cantidad_total);

        },



        responsive: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        dom: 'Blfrtip',
        buttons: [
        'copy', 'excel'
        ]


    });


		var table = $('#table_pagar_gastos').DataTable();

		table
		.order([ 0, 'asc' ])
		.draw();  

		$(function() {
			otable = $('#table_pagar_gastos').dataTable();
		})

	});



	$(function() {
		otable = $('#table_pagar_gastos').dataTable();

	});        


</script>


<?php 
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";

date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s"); 
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];

$idlogistica = $_REQUEST['idlogistica'];
$idcolaborador = $_REQUEST['idcolaborador'];

$idlogistica = trim($idlogistica);
$idcolaborador = trim($idcolaborador);



$mensaje .= "
<div class='container-bg-1 p-3'>
<div class='table-responsive'>
<table width='100%' class='table table-striped table-bordered table-hover panel-body-center-table' id='table_pagar_gastos'>
<thead>

<tr>
<th>#</th>
<th>ID</th>
<th>Concepto</th>
<th>Tipo Movimiento</th>
<th>Fecha_movimiento</th>
<th>Responsable</th>
<th>Monto Total</th>
<th>VIN</th>
</tr>

</thead>
<tbody>

";


$count = 0;

$query_balance = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' AND trim(columna2) = '$idlogistica' AND trim(tipo_movimiento) = 'cargo' AND trim(comision) = 'N/A' and trim(responsable) = '$idcolaborador' and (columna7 <> 'Pagado'  OR columna7 IS NULL)";
$result_balance = mysql_query($query_balance);

while ($row_balance = mysql_fetch_array($result_balance)) {
	$count ++;
	$valores .= $row_balance[idbalance_gastos_operacion]."|";

	$fecha_movimiento = date_create($row_balance[fecha_movimiento]);
	$fecha_movimiento = date_format($fecha_movimiento, 'd-m-Y');

	if (is_numeric($row_balance[responsable])) {

		$show_responsable_select = nombres_datos($row_balance[responsable], "Colaborador");
		$porciones_responsable_select = explode("|", $show_responsable_select);

		$name_responsable_select = $porciones_responsable_select[10];

	}else {

		$name_responsable_select = $row_balance[responsable];

	}

	$gran_total = "$".number_format($row_balance[gran_total],2);
	$monto_comparar += $row_balance[gran_total];

	$mensaje .= "
	<tr>
	<td>$count</td>
	<td>$row_balance[idbalance_gastos_operacion]</td>
	<td>$row_balance[concepto]</td>
	<td>$row_balance[tipo_movimiento]</td>
	<td>$fecha_movimiento</td>
	<td>$name_responsable_select</td>
	<td>$gran_total</td>
	<td>$row_balance[datos_vin]</td>
	</tr>
	";

}

$mensaje .= "
</tbody>
<tfoot>

<th colspan='6' style='text-align:right'>Total:</th>
<th colspan='2' style='text-align:left;' class='cantidad_total'></th>

</tfoot>
</table>
<input type='hidden' name='valores' id='valores' value='$valores'>
<input type='hidden' name='monto_comparar' id='monto_comparar' value='$monto_comparar'>
</div>
</div>";


echo $mensaje;
?>