<?php 
session_start();  
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
//$usuario_creador = $_SESSION['usuario_clave'];
//$empleados = $_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);

?>
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
		$('#table_bitacora_combustible_tag').DataTable({

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

					var ok = i;

					if (typeof i === 'string') {

						let uno = ok.replace('$', '');
						uno = uno.replace('MXN', '');
						uno = uno.replace('USD', '');
						uno = uno.replace('CAD', '');
						uno = uno.replace(',', '');
						uno = uno.replace(',', '');
						uno = uno.replace(',', '');

						return uno = parseFloat(uno);

					}else if (typeof i === 'number') {

						return typeof i === 'number' ? i : 0;

					}
				};




				total = api
				.column( 2 )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );


				pageTotal = api
				.column( 2, { page: 'current'} )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );


				var letrastotal = Monto_General (total);

				$( api.column( 2 ).footer() ).html(
					'$ '+formatNumber.new(pageTotal.toFixed(2))+' (Monto Total '+formatNumber.new(total.toFixed(2))+' )' + letrastotal
					);

				var cantidad_total = $(".cantidad_total2").html();
				$(".m-cantidad-total-2").html(cantidad_total);

			},
			
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


		});

		var table = $('#table_bitacora_combustible_tag').DataTable();

		table
		.order([ 0, 'asc' ])
		.draw();


	});


	function Monto_General (valor) {
		

		var dataToReturn = "";

		$.ajax({
			url : 'buscar_letras_documentacion.php',
			async: false,
			data : {
				valorBusqueda : valor,
				valortipo : "MXN"
			},
			type : 'POST',

			success : function(json) {

				respuesta_monto = json;
				
			}

		});

		return respuesta_monto;

	}

	


</script>





<?php 

#------------------------------- Tipo Vista ------

$tipo_tabla = trim($_POST['tipo_tabla']);


if ($tipo_tabla == "Bitacora") {

	$mensaje .= "
	<br>
	<center>
	<h3>Costo Total de Monedero Electrónico</h3>
	</center>

	<div class='container-bg-1 p-3'>
	<div class='table-responsive'>
	<table class='table table-striped table-bordered table-hover panel-body-center-table' id='table_bitacora_combustible_tag' style='width: 100%;'>
	<thead>
	<tr>
	<th>#</th>
	<th>Concepto</th>
	<th>Monto Total &nbsp;&nbsp</th>
	<th>Primer Movimiento&nbsp;&nbsp</th>
	<th>Ultimo Movimiento&nbsp;&nbsp</th>
	<th>Total de Movimientos</th>
	</tr>
	</thead>
	<tbody>
	";
#------------------------------- Casetas ------

	$monto_total_casetas = 0.00;
	$primer_fecha_caseta = "-";
	$ultima_fecha_caseta = "-";
	$contador_caseta = 0.00;

	$query_monto_total_casetas = "SELECT sum(gran_total) FROM orden_logistica_casetas WHERE visible = 'SI' ";
	$result_monto_total_casetas = mysql_query($query_monto_total_casetas);

	while ($row_monto_total_casetas = mysql_fetch_array($result_monto_total_casetas)) {

		$monto_total_casetas = number_format($row_monto_total_casetas[0],2);
	}


	$query_primer_fecha_caseta = "SELECT fecha_movimiento FROM orden_logistica_casetas WHERE visible = 'SI' order by fecha_movimiento ASC LIMIT 1";
	$result_primer_fecha_caseta = mysql_query($query_primer_fecha_caseta);

	while ($row_primer_fecha_caseta = mysql_fetch_array($result_primer_fecha_caseta)) {
		
		$primer_fecha_caseta = date_format(date_create($row_primer_fecha_caseta[0]), 'd-m-Y H:i:s');
	}

	$query_ultima_fecha_caseta = "SELECT fecha_movimiento FROM orden_logistica_casetas WHERE visible = 'SI' order by fecha_movimiento DESC LIMIT 1";
	$result_ultima_fecha_caseta = mysql_query($query_ultima_fecha_caseta);

	while ($row_ultima_fecha_caseta = mysql_fetch_array($result_ultima_fecha_caseta)) {
		
		$ultima_fecha_caseta = date_format(date_create($row_ultima_fecha_caseta[0]), 'd-m-Y H:i:s');
	}


	$query_contador_general_caseta = "SELECT count(*) FROM orden_logistica_casetas WHERE visible = 'SI'";
	$result_contador_general_caseta = mysql_query($query_contador_general_caseta);

	while ($row_contador_general_caseta = mysql_fetch_array($result_contador_general_caseta)) {
		
		$contador_caseta = number_format($row_contador_general_caseta[0]);
	}




	$mensaje .= "
	<tr>
	<td>1</td>
	<td>Casetas</td>
	<td>$$monto_total_casetas</td>
	<td>$primer_fecha_caseta</td>
	<td>$ultima_fecha_caseta</td>
	<td>$contador_caseta</td>
	</tr>
	";

#------------------------------- Combustible Broxel------

	$monto_total_broxel = 0.00;
	$primer_fecha_broxel = "-";
	$ultima_fecha_broxel = "-";
	$contador_broxel = 0.00;

	$query_monto_total_broxel = "SELECT sum(gran_total) FROM orden_logistica_combustible WHERE visible = 'SI' and concepto = 'Broxel' AND establecimiento <> 'Su pago gracias'";
	$result_monto_total_broxel = mysql_query($query_monto_total_broxel);

	while ($row_monto_total_broxel = mysql_fetch_array($result_monto_total_broxel)) {

		$monto_total_broxel = number_format($row_monto_total_broxel[0], 2);

	}

	$query_primer_fecha_broxel = "SELECT fecha_movimiento FROM orden_logistica_combustible WHERE visible = 'SI' and concepto = 'Broxel' AND establecimiento <> 'Su pago gracias' order by fecha_movimiento ASC LIMIT 1";
	$result_primer_broxel = mysql_query($query_primer_fecha_broxel);

	while ($row_primer_fecha_broxel = mysql_fetch_array($result_primer_broxel)) {

		$primer_fecha_broxel = date_format(date_create($row_primer_fecha_broxel[0]), 'd-m-Y H:i:s');

	}

	$query_ultima_fecha_broxel = "SELECT fecha_movimiento FROM orden_logistica_combustible WHERE visible = 'SI' and concepto = 'Broxel' AND establecimiento <> 'Su pago gracias' order by fecha_movimiento DESC LIMIT 1";
	$result_ultima_broxel = mysql_query($query_ultima_fecha_broxel);

	while ($row_ultima_fecha_broxel = mysql_fetch_array($result_ultima_broxel)) {

		$ultima_fecha_broxel = date_format(date_create($row_ultima_fecha_broxel[0]), 'd-m-Y H:i:s');

	}

	$query_contador_general_broxel = "SELECT count(*) FROM orden_logistica_combustible WHERE visible = 'SI' and concepto = 'Broxel' AND establecimiento <> 'Su pago gracias'";
	$result_contador_general_broxel = mysql_query($query_contador_general_broxel);

	while ($row_contador_general_broxel = mysql_fetch_array($result_contador_general_broxel)) {

		$contador_broxel = number_format($row_contador_general_broxel[0]);

	}



	$mensaje .= "
	<tr>
	<td>2</td>
	<td>Combustible Broxel</td>
	<td>$$monto_total_broxel</td>
	<td>$primer_fecha_broxel</td>
	<td>$ultima_fecha_broxel</td>
	<td>$contador_broxel</td>
	</tr>
	";

#------------------------------- Combustible Si Vale ------

	$monto_total_si_vale = 0.00;
	$primer_fecha_si_vale = "-";
	$ultima_fecha_si_vale = "-";
	$contador_sivale = 0.00;

	$query_monto_total_si_vale = "SELECT sum(gran_total) FROM orden_logistica_combustible where visible = 'SI' and concepto = 'SI Vale' AND establecimiento <> 'DISPERSION DE SALDO' AND establecimiento <> 'AJUSTE DE SALDO' AND establecimiento <>  'TRANSFERENCIA A TERCEROS'";
	$result_monto_total_si_vale = mysql_query($query_monto_total_si_vale);

	while ($row_monto_total_si_vale = mysql_fetch_array($result_monto_total_si_vale)) {

		$monto_total_si_vale = number_format($row_monto_total_si_vale[0], 2);

	}

	$query_primer_fecha_si_vale = "SELECT fecha_movimiento FROM orden_logistica_combustible WHERE visible = 'SI' and concepto = 'Si Vale' order by fecha_movimiento ASC LIMIT 1";
	$result_primer_si_vale = mysql_query($query_primer_fecha_si_vale);

	while ($row_primer_fecha_si_vale = mysql_fetch_array($result_primer_si_vale)) {

		$primer_fecha_si_vale = date_format(date_create($row_primer_fecha_si_vale[0]), 'd-m-Y H:i:s');

	}

	$query_ultima_fecha_si_vale = "SELECT fecha_movimiento FROM orden_logistica_combustible WHERE visible = 'SI' and concepto = 'Si Vale' order by fecha_movimiento DESC LIMIT 1";
	$result_ultima_si_vale = mysql_query($query_ultima_fecha_si_vale);

	while ($row_ultima_fecha_si_vale = mysql_fetch_array($result_ultima_si_vale)) {

		$ultima_fecha_si_vale = date_format(date_create($row_ultima_fecha_si_vale[0]), 'd-m-Y H:i:s');

	}

	$query_contador_general_si_vale = "SELECT count(*) FROM orden_logistica_combustible where visible = 'SI' and concepto = 'SI Vale' AND establecimiento <> 'DISPERSION DE SALDO' AND establecimiento <> 'AJUSTE DE SALDO' AND establecimiento <>  'TRANSFERENCIA A TERCEROS'";
	$result_contador_general_si_vale = mysql_query($query_contador_general_si_vale);

	while ($row_contador_general_si_vale = mysql_fetch_array($result_contador_general_si_vale)) {

		$contador_sivale = number_format($row_contador_general_si_vale[0]);

	}



	$mensaje .= "
	<tr>
	<td>2</td>
	<td>Combustible Si Vale</td>
	<td>$$monto_total_si_vale</td>
	<td>$primer_fecha_si_vale</td>
	<td>$ultima_fecha_si_vale</td>
	<td>$contador_sivale</td>
	</tr>
	";



	$mensaje.="
	</tbody>
	<tfoot>

	<th colspan='2' style='text-align:right'>Total:</th>
	<th colspan='4' style='text-align:left;' class='cantidad_total'></th>

	</tfoot>
	</table>
	</div>
	</div>";



}


echo $mensaje;
?>