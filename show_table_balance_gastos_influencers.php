<script>

	var formatNumber = {
 separador: ",", // separador para los miles
 sepDecimal: '.', // separador para los decimales
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

	$('#example').DataTable({
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

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
            	return typeof i === 'string' ?
            	i.replace(/[\$,]/g, '')*1 :
            	typeof i === 'number' ?
            	i : 0;
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

            var cantidad_total = $(".cantidad_total").html();
            $(".m-cantidad-total").html(cantidad_total);

        },
        responsive: true,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        dom: 'Blfrtip',
        buttons: [
        'copy', 'excel'
        ]


    });


	var table = $('#example').DataTable();

	table
	.order([ 0, 'asc' ])
	.draw();  

	$(function() {
		otable = $('#example').dataTable();
	})




	$('#tableresults').DataTable({
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

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
            	return typeof i === 'string' ?
            	i.replace(/[\$,]/g, '')*1 :
            	typeof i === 'number' ?
            	i : 0;
            };

            // Total over all pages
            total = api
            .column( 4 )
            .data()
            .reduce( function (a, b) {
            	return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotal = api
            .column( 4, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
            	return intVal(a) + intVal(b);
            }, 0 );

            // Update footer
            

            $( api.column( 4 ).footer() ).html(
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


	var table = $('#tableresults').DataTable();

	table
	.order([ 0, 'asc' ])
	.draw();  

	$(function() {
		otable = $('#tableresults').dataTable();
	})

});



</script>


<script type="text/javascript">


	function filterme() {
  //build a regex filter string with an or(|) condition
  var types = $('input:checkbox[name="concepto_sinotruck"]:checked').map(function() {
  	return '^' + this.value + '\$';
  }).get().join('|');
  //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
  otable.fnFilter(types, 1, true, false, false, false);

  //build a regex filter string with an or(|) condition
  var types = $('input:checkbox[name="responsable_sinotruck"]:checked').map(function() {
  	return '^' + this.value + '\$';
  }).get().join('|');
  //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
  otable.fnFilter(types, 3, true, false, false, false);

  //build a regex filter string with an or(|) condition
  var types = $('input:checkbox[name="tmovimientp_sinotruck"]:checked').map(function() {
  	return '^' + this.value + '\$';
  }).get().join('|');
  //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
  otable.fnFilter(types, 5, true, false, false, false);

}

$(function() {
	otable = $('#example').dataTable();
	
});        


</script>


<?php
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
date_default_timezone_set('America/Mexico_City');


$usuario_creador=$_SESSION['usuario_clave'];

$fecha_inicio = $_POST['fecha_a'];
$fecha_fin = $_POST['fecha_b'];


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
	
	$fecha_a = date("Y-m-01 ");
	$fecha_b = date("Y-m-d");  
}



$nueva_table .= "
<div class='container-bg-1 p-3'>
<div class='table-responsive'>
<table width='100%'' class='table table-striped table-bordered table-hover panel-body-center-table' id='tableresults'>
<thead>

<tr>
<th>Responsable</th>
<th>Concepto</th>
<th>Monto Total</th>
<th>Monto Panamotors</th>
<th>Monto Sinotruck</th>
</tr>
</thead>
<tbody>
";

$query_logisticas_concepto = "SELECT * FROM orden_logistica where columna_c = 'Influencers' and DATE_FORMAT(fecha_solicitud, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'";
$result_logisticas_concepto = mysql_query($query_logisticas_concepto);

$array_conceptos = array();
while ($row_logisticas_concepto = mysql_fetch_array($result_logisticas_concepto)) {

	$query_concepto_ver = "SELECT concepto FROM balance_gastos_operacion where visible = 'SI' and columna2 = '$row_logisticas_concepto[idorden_logistica]' GROUP BY concepto";
	$result_concepto_ver = mysql_query($query_concepto_ver);

	while ($row_concepto = mysql_fetch_array($result_concepto_ver)) {
		array_push($array_conceptos, $row_concepto[0]);
	}
	
}




$concepto_unico = array_unique($array_conceptos);
$concatenar = implode(",",$concepto_unico);
unset($array_conceptos);

$array_conceptos = explode(",", $concatenar);

$monto_total = 0;
$monto_panamotors = 0;
$monto_sinotruck = 0;
$count_count = 0;
$monto_total_format = 0;

$query_logisticas_responsable = "SELECT * FROM orden_logistica where columna_c = 'Influencers' and DATE_FORMAT(fecha_solicitud, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'";
$result_logisticas_responsable = mysql_query($query_logisticas_responsable);

while ($row_logisticas_responsable = mysql_fetch_array($result_logisticas_responsable)) {
	


	$query_responsables_ver = "SELECT responsable FROM balance_gastos_operacion where visible = 'SI' and columna2 = '$row_logisticas_responsable[idorden_logistica]' GROUP BY responsable";
	$result_responsables_ver = mysql_query($query_responsables_ver);

	while ($row_responsables_ver = mysql_fetch_array($result_responsables_ver)) {

		$name_responsable_ver = name_responsable($row_responsables_ver[responsable]);

		for ($i=0; $i < count($array_conceptos); $i++) {

			$query_new_table = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and columna2 = '$row_logisticas_responsable[idorden_logistica]' and concepto = '$array_conceptos[$i]' and tipo_movimiento = 'cargo' and responsable = '$row_responsables_ver[responsable]'";
			$result_new_table = mysql_query($query_new_table);

			if (mysql_num_rows($result_new_table) >=1) {

				while ($row_new_table = mysql_fetch_array($result_new_table)) {

					$monto_total += $row_new_table[gran_total];

				}
				$monto_total_format = number_format($monto_total,2);

				if ($name_responsable_ver == "RRC") {
					$monto_panamotors = $monto_total / 2;
					$monto_panamotors = number_format($monto_panamotors,2);
					$monto_sinotruck = $monto_panamotors;
				}else {
					$monto_panamotors = number_format("0", 2);
					$monto_sinotruck = $monto_total_format;

				}


				$name_concepto = ucwords($array_conceptos[$i]);

				$nueva_table .= "<tr>
				<td>$name_responsable_ver</td>
				<td>$name_concepto</td>
				<td>$$monto_total_format</td>
				<td>$$monto_panamotors</td>
				<td>$$monto_sinotruck</td>
				</tr>";

				$monto_total = 0;
				$monto_panamotors = 0;
				$monto_sinotruck = 0;
				$count_count = 0;
				$monto_total_format = 0;

			}


		}
	}
}


$nueva_table .= "
</tbody>
<tfoot>

<th colspan='1' style='text-align:right'>Total:</th>
<th colspan='4' style='text-align:left; background: #161616;' class='cantidad_total2'></th>

</tfoot>
</table>
<div class='d-flex'>
<div class='text-secundario-1 mr-2' style='font-weight: bold;'>Total: </div>
<div class='m-cantidad-total-2 text-secundario-1' style='font-weight: bold;'></div>
</div>
</div>

</div>
";






































$query_logisticas_influencers = "SELECT * FROM orden_logistica where columna_c = 'Influencers' and DATE_FORMAT(fecha_solicitud, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'";
$result_logisticas_influencers = mysql_query($query_logisticas_influencers);

$mensaje .= "
<div class='container-bg-1 p-3'>
<div class='table-responsive'>
<table width='100%' class='table table-striped table-bordered table-hover panel-body-center-table' id='example'>
<thead>

<tr>
<th>#</th>
<th>Concepto</th>
<th>Departamento</th>
<th>Responsable</th>
<th>Proveedor</th>
<th>T. Movimiento</th>
<th>M.T. Cargo&nbsp;&nbsp;</th>
<th>M.T. Abono&nbsp;&nbsp;</th>
<th>VIN</th>
<th>Tarjeta | Tag</th>
<th>Logística</th>
<th>F. Movimiento</th>

</tr>
</thead>
<tbody>

";


while ($row_logisticas_influencers = mysql_fetch_array($result_logisticas_influencers)) {

	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and columna2 = '$row_logisticas_influencers[idorden_logistica]' ";
	$result_balance_total = mysql_query($query_balance_total);


	while ($row_balance_total = mysql_fetch_array($result_balance_total)) {
		$ok ++; 

		$nomenclatura_responsable = (is_numeric($row_balance_total[responsable])) ? name_responsable($row_balance_total[responsable]) : $row_balance_total[responsable] ;

		$encriptado = base64_encode($row_balance_total[columna2]);
		$link = "<a href='orden_logistica_detalles.php?idib=$encriptado' target='_blank'>$row_balance_total[columna2]</a>";

		$name_proveedor = ($row_balance_total[tipo_movimiento] == "cargo") ? $row_balance_total[emisora_institucion] : $row_balance_total[receptora_institucion] ;
		$monto_cargo = ($row_balance_total[tipo_movimiento] == "cargo") ? number_format($row_balance_total[gran_total],2) : number_format("0",2); 
		$monto_abono = ($row_balance_total[tipo_movimiento] == "abono") ? number_format($row_balance_total[gran_total],2) : number_format("0",2);
		$nomenclatura_departamento = name_departamento(trim($row_balance_total[idcatalogo_departamento]));

		$mensaje .= "<tr>
		<td>$ok</td>
		<td>$row_balance_total[concepto]</td>
		<td>$nomenclatura_departamento</td>
		<td>$nomenclatura_responsable</td>
		<td>$name_proveedor</td>
		<td>$row_balance_total[tipo_movimiento]</td>
		<td>$ $monto_cargo</td>
		<td>$monto_abono</td>
		<td>$row_balance_total[datos_vin]</td>
		<td>$row_balance_total[comision]</td>
		<td>$link</td>
		<td>$row_balance_total[fecha_movimiento]</td>
		</tr>";

	}
}













$mensaje .= "
</tbody>
<tfoot>

<th colspan='1' style='text-align:right'>Total:</th>
<th colspan='10' style='text-align:left; background: #161616;' class='cantidad_total'></th>

</tfoot>
</table>
<div class='d-flex'>
<div class='text-secundario-1 mr-2' style='font-weight: bold;'>Total: </div>
<div class='m-cantidad-total text-secundario-1' style='font-weight: bold;'></div>
</div>
</div>
</div>";



function name_responsable($id_responsable){

	$query_empleado = (is_numeric($id_responsable)) ? "SELECT * FROM empleados where idempleados = '$id_responsable'" : "SELECT * FROM empleados where columna_b = '$id_responsable'" ;
	$result_empleado = mysql_query($query_empleado);

	if (mysql_num_rows($result_empleado) >=1) {

		while ($row_empleado = mysql_fetch_array($result_empleado)) {
			$name = $row_empleado[columna_b];
			$id_name = $row_empleado[idempleados];
		}
	}else{
		$name;
	}



	$tipo_return = (is_numeric($id_responsable)) ? $name : $id_name ; 

	return $tipo_return;
}


function name_departamento($id_departamento) {

	$query_departamento = "SELECT * FROM catalogo_departamento WHERE trim(idcatalogo_departamento) = '$id_departamento'";
	$result_departamento = mysql_query($query_departamento);

	if (mysql_num_rows($result_departamento) >= 1) {
		while ($row_departamento = mysql_fetch_array($result_departamento)) {
			$nombre_departamento = $row_departamento[nombre];
		}	
	}else {
		$nombre_departamento = "<b>Revisar</b>";
	}

	return $nombre_departamento;

}


echo "$mensaje <hr> $nueva_table";
?>
