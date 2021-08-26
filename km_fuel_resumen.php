<script>
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

	});

	$(function() {
		otable = $('#example').dataTable();
	})







</script>



<script type="text/javascript">


	function filterme() {
  //build a regex filter string with an or(|) condition
  var types = $('input:checkbox[name="filter_responsable"]:checked').map(function() {
  	return '^' + this.value + '\$';
  }).get().join('|');
  //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
  otable.fnFilter(types, 7, true, false, false, false);

  //build a regex filter string with an or(|) condition
  var types = $('input:checkbox[name="filter_vin"]:checked').map(function() {
  	return '^' + this.value + '\$';
  }).get().join('|');
  //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
  otable.fnFilter(types, 1, true, false, false, false);

  //build a regex filter string with an or(|) condition
  var types = $('input:checkbox[name="filter_type"]:checked').map(function() {
  	return '^' + this.value + '\$';
  }).get().join('|');
  //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
  otable.fnFilter(types, 2, true, false, false, false);

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


$fecha_inicio = $_POST['fecha_inicio'];

$fecha_fin = $_POST['fecha_fin'];

if ($fecha_inicio == "" and $fecha_fin != "") {
	
	$fecha_a = $fecha_fin;
	$fecha_b = $fecha_fin;

}elseif ($fecha_inicio != "" and $fecha_fin == "") {
	
	$fecha_a = $fecha_inicio;
	$fecha_b = $fecha_inicio;

}elseif ($fecha_inicio != "" and $fecha_fin != "") {
	
	$fecha_a = $fecha_inicio;
	$fecha_b = $fecha_fin;

} else{
	
	$fecha_a=date("Y-m-01 ");
	$fecha_b=date("Y-m-d");  

}







$mensaje .= "
<div class='container-bg-1 p-3'>
<div class='table-responsive'>
<table width='100%'' class='table table-striped table-bordered table-hover panel-body-center-table' id='example'>
<thead>

<tr>
<th>#</th>
<th>VIN</th>
<th>Tipo</th>
<th>Kilometraje Anterior</th>
<th>Kilometraje Actual</th>
<th>Diferencia Kilometraje</th>
<th>Evidencia</th>
<th>Responsable</th>
</tr>
</thead>
<tbody>
";



$incrementar_km = 0;

$query_km_fuel = "SELECT * FROM unidades_utilitarios_km where visible = 'SI' and DATE_FORMAT(fecha_creacion, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'";
$result_km_fuel = mysql_query($query_km_fuel);

while ($row_km = mysql_fetch_array($result_km_fuel)) {
	$incrementar_km ++;

	$var_operacion = $row_km[kilometraje] - $row_km[km_anterior];

	$query_name = "SELECT * FROM empleados WHERE idempleados = '$row_km[idcolaborador]'";
	$result_name = mysql_query($query_name);

	while ($rom_name = mysql_fetch_array($result_name)) {
		$nomenclatura_km = $rom_name[columna_b];
	}

	$ver_evidencia_km = (file_exists($row_km[archivo])) ? "<a href='$row_km[archivo]' target='_blank'><i class='fa fa-picture-o' aria-hidden='true'></i></a>" : "Sin Evidencia" ;



	$mensaje .= "<tr class='odd gradeX'>
	<td>$incrementar_km</td>
	<td>$row_km[vin]</td>
	<td>$row_km[rol_km]</td>
	<td>".number_format($row_km[km_anterior])."</td>
	<td>".number_format($row_km[kilometraje])."</td>
	<td>".number_format($var_operacion)."</td>
	<td>$ver_evidencia_km</td>
	<td>$nomenclatura_km</td>
	</tr>";
}

$mensaje .= "
</tbody>

</table>
</div>
</div>";


#-------------------------------------------Funcion logisticas--------------------------------------------------------------------------------

function Range_Logistics ($fecha_a, $fecha_b, $vin){

	$query_logistica = "SELECT * FROM orden_logistica where DATE_FORMAT(fecha_salida, '%Y-%m-%d') between '$fecha_a' and '$fecha_b' || DATE_FORMAT(hora_real_solucion, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'";
	$result_logistica = mysql_query($query_logistica);

	while ($row_logistica = mysql_fetch_array($result_logistica)) {





	}


}


echo $mensaje;





?>

