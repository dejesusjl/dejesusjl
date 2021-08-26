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
		$('#table_archivos_combustible_tag').DataTable({

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
						uno = uno.replace(',', '');
						uno = uno.replace('USD', '');
						uno = uno.replace('CAD', '');

						return uno = parseFloat(uno);

					}else if (typeof i === 'number') {

						return typeof i === 'number' ? i : 0;

					}else {

						return 0;

					}
				};




				total = api
				.column( 6 )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );


				pageTotal = api
				.column( 6, { page: 'current'} )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );




				$( api.column( 6 ).footer() ).html(
					'$ '+formatNumber.new(pageTotal.toFixed(2))+' (Total de Movimientos '+formatNumber.new(total.toFixed(2))+' )'
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

		var table = $('#table_archivos_combustible_tag').DataTable();

		table
		.order([ 0, 'asc' ])
		.draw();


	});

	


</script>





<?php 

#------------------------------- Tipo Vista ------

$tipo_tabla = trim($_POST['tipo_tabla']);




if ($tipo_tabla == "Archivos") {

	$mensaje .= "
	<br>
	<center>
	<h3>Historial de Archivos</h3>
	</center>

	<div class='container-bg-1 p-3'>
	<div class='table-responsive'>
	<table class='table table-striped table-bordered table-hover panel-body-center-table' id='table_archivos_combustible_tag' style='width: 100%;'>
	<thead>
	<tr>
	<th>#</th>
	<th>Concepto</th>
	<th>Tipo Archivo</th>
	<th>Fecha de Inicio&nbsp;&nbsp</th>
	<th>Fecha Final&nbsp;&nbsp</th>
	<th>Total Movimientos</th>
	<th>Movimiento Insertados</th>
	<th>Movimientos Duplicados</th>
	<th>Movimientos Actualizados</th>
	<th>Movimientos Restantes</th>
	<th>Usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th>Fecha y Hora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th>Comentarios</th>
	</tr>
	</thead>
	<tbody>
	";

	$contador = 0;

	$query_archivos = "SELECT * FROM orden_logistica_archivos_casetas_combustible WHERE visible = 'SI' order by idorden_logistica_archivos_casetas_combustible DESC";
	$result_archivos = mysql_query($query_archivos);

	while ($row_archivos = mysql_fetch_array($result_archivos)) {

		#------------------------------------------- Increment ------------------------------------------------------------------------------

		$contador ++;

		#------------------------------------------- Fecha Inicio ------------------------------------------------------------------------------

		$fecha_inicio = date_format(date_create($row_archivos[fecha_inicio]), 'd-m-Y');

		#------------------------------------------- Fecha Final ------------------------------------------------------------------------------

		$fecha_final = date_format(date_create($row_archivos[fecha_fin]), 'd-m-Y');

		#------------------------------------------- Total movimientos ------------------------------------------------------------------------------

		$total_movimientos = number_format($row_archivos[total_movimientos]);

		#------------------------------------------- movimientos insertados ------------------------------------------------------------------------------

		$movimientos_insertados = number_format($row_archivos[movimientos_insertados]);

		#------------------------------------------- movimientos duplicados ------------------------------------------------------------------------------

		$movimientos_duplicados = number_format($row_archivos[movimientos_duplicados]);

		#------------------------------------------- movimientos actualizados ------------------------------------------------------------------------------

		$movimientos_actualizados = number_format($row_archivos[movimientos_actualizados]);

		#------------------------------------------- movimientos restantes ------------------------------------------------------------------------------

		$movimientos_restantes = number_format($row_archivos[movimientos_restantes]);

		#------------------------------------------- Usuario Creador ------------------------------------------------------------------------------

		$search_usuario = explode("|", NameUsuarioCreador ($row_archivos[usuario_creador]));

		#------------------------------------------- Fecha Hora ------------------------------------------------------------------------------

		$fecha_guardado = date_format(date_create($row_archivos[fecha_guardado]), 'd-m-Y H:i:s');


		$mensaje .= "
		<tr>
		<td>$contador</td>
		<td>$row_archivos[concepto]</td>
		<td>$row_archivos[tipo_archivo]</td>
		<td>$fecha_inicio</td>
		<td>$fecha_final</td>
		<td>$total_movimientos</td>
		<td>$movimientos_insertados</td>
		<td>$movimientos_duplicados</td>
		<td>$movimientos_actualizados</td>
		<td>$movimientos_restantes</td>
		<td>$search_usuario[0] - $search_usuario[1]</td>
		<td>$fecha_guardado</td>
		<td>$row_archivos[comentarios]</td>
		</tr>
		";

	}




	$mensaje.="
	</tbody>
	<tfoot>

	<th colspan='6' style='text-align:right'>Total:</th>
	<th colspan='7' style='text-align:left;' class='cantidad_total'></th>

	</tfoot>
	</table>
	</div>
	</div>";



}


echo $mensaje;
?>