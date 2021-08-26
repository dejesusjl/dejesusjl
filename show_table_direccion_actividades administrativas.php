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
            .column( 9 )
            .data()
            .reduce( function (a, b) {
            	return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotal = api
            .column( 9, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
            	return intVal(a) + intVal(b);
            }, 0 );

            // Update footer
            

            $( api.column( 9 ).footer() ).html(
            	'$ '+formatNumber.new(pageTotal.toFixed(2))+' (Saldo Total: $ '+formatNumber.new(total.toFixed(2))+' )'
            	);
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
            .column( 3 )
            .data()
            .reduce( function (a, b) {
            	return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotal = api
            .column( 3, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
            	return intVal(a) + intVal(b);
            }, 0 );

            // Update footer
            

            $( api.column( 3 ).footer() ).html(
            	'$ '+formatNumber.new(pageTotal.toFixed(2))+' (Saldo Total: $ '+formatNumber.new(total.toFixed(2))+' )'
            	);
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
$fecha_guardado=date("Y-m-d H:i:s"); 
$usuario_creador=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);


$fecha_inicio_mes = date("Y-m-")."01";

$fecha_actual_mes = date("Y-m-d"); 









$fecha_inicio = $_POST['fecha_inicio'];

$fecha_fin = $_POST['fecha_fin'];



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
	
	$fecha_a = $fecha_inicio_mes;
	$fecha_b = $fecha_actual_mes;
}





















$mensaje .= "
<div class='container-bg-1 p-3'>
<div class='table-responsive'>
<table width='100%'' class='table table-striped table-bordered table-hover panel-body-center-table' id='example'>
<thead>

<tr>
<th>#</th>
<th>Departamento</th>
<th>Tipo de Orden</th>
<th>Origen</th>
<th>Destino</th>
<th>ID</th>
<th>Solicitante</th>
<th>F. Información</th>
<th>Trasladista</th>
<th>T. Gastos</th>
<th>Fecha&nbsp;&nbsp;&nbsp;&nbsp;</th>
<th>VIN</th>
<th>Acompañantes</th>
</tr>
</thead>
<tbody>

";

$concatenar_logisticas = array();

$query_orden_logistica = "SELECT * FROM orden_logistica where iddepartamento = '25' and (idcatalogo_orden_logistica = '2' || idcatalogo_orden_logistica = '13' ||idcatalogo_orden_logistica = '23' || idcatalogo_orden_logistica = '24'  || idcatalogo_orden_logistica = '70')  and DATE_FORMAT(fecha_creacion, '%Y-%m-%d') between '$fecha_a' and '$fecha_b' ";
$result_orden_logistica = mysql_query($query_orden_logistica);

if (mysql_num_rows($result_orden_logistica) >=1) {
	
	while ($row_ordenlogistica = mysql_fetch_array($result_orden_logistica)) {

#-------------------------------------------ID Logistica--------------------------------------------------------------------------------
		$idorden_logistica_enriptado = base64_encode($row_ordenlogistica[idorden_logistica]);
		$link = " <a href='orden_logistica_detalles.php?idib=$idorden_logistica_enriptado' target='_BLANK'>$row_ordenlogistica[idorden_logistica]</a>";
#-------------------------------------------ID departamento--------------------------------------------------------------------------------
		$ver_departamento = name_departamento($row_ordenlogistica[iddepartamento]);

#-------------------------------------------Tipo orden--------------------------------------------------------------------------------
		$ver_torden = name_Torden($row_ordenlogistica[idcatalogo_orden_logistica]);

#-------------------------------------------ID--------------------------------------------------------------------------------

		$buscar_id = nombres_datos($row_ordenlogistica[idcontacto], $row_ordenlogistica[tipo_contacto]);
		$porciones_id = explode("|", $buscar_id);
		$nombre_id = $porciones_id[10];
#-------------------------------------------Solicitante--------------------------------------------------------------------------------

		$buscar_solicitante = nombres_datos($row_ordenlogistica[idsolicitante], $row_ordenlogistica[tipo_solicitante]);
		$porciones_solicitante = explode("|", $buscar_solicitante);
		$nombre_solicitante = $porciones_solicitante[10];

#-------------------------------------------F. Informacion--------------------------------------------------------------------------------
		$buscar_finformacion = nombres_datos($row_ordenlogistica[idfuente_inf], $row_ordenlogistica[tipo_fuente_inf]);
		$porciones_finformacion = explode("|", $buscar_finformacion);
		$nombre_fuente_inf = $porciones_finformacion[10];

#-------------------------------------------Trasladista--------------------------------------------------------------------------------

		$buscar_trasladista = nombres_datos($row_ordenlogistica[idasigna], $row_ordenlogistica[tipo_asignante]);
		$porciones_trasladista = explode("|", $buscar_trasladista);
		$nombre_asignante = $porciones_trasladista[10];

#-------------------------------------------Estatus Logisca--------------------------------------------------------------------------------

		$estatus_principal = estatusLogistica($row_ordenlogistica[idorden_logistica]);
		$mostrar_vin = searchVIN($row_ordenlogistica[idorden_logistica]);
		$mostrar_ayudante = searchAyudante($row_ordenlogistica[idorden_logistica]);

		$recibir_fecha = date_create($row_ordenlogistica[fecha_solicitud]);
		$fecha_solicitud = date_format($recibir_fecha, "d-m-Y");

		$costo_logistica = costoTotalLogistica($row_ordenlogistica[idorden_logistica]);

		array_push($concatenar_logisticas, $row_ordenlogistica[idorden_logistica]);

		

		$mensaje .= "<tr>
		<td>$link</td>
		<td>$ver_departamento</td>
		<td>$ver_torden</td>
		<td>$row_ordenlogistica[municipio_origen], $row_ordenlogistica[estado_origen]</td>
		<td>$row_ordenlogistica[municipio_destino], $row_ordenlogistica[estado_destino]</td>
		<td>$nombre_id</td>
		<td>$nombre_solicitante</td>
		<td>$nombre_fuente_inf</td>
		<td>$nombre_asignante</td>
		<td>$costo_logistica</td>
		<td>$fecha_solicitud</td>
		<td>$mostrar_vin</td>
		<td>$mostrar_ayudante</td>
		</tr>";



	}
}



$mensaje .= "
</tbody>
<tfoot>

<th colspan='9' style='text-align:right'>Total:</th>
<th colspan='4' style='text-align:left;'></th>

</tfoot>
</table>
</div>
</div>";

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

$nueva_table .= "
<div class='container-bg-1 p-3'>
<div class='table-responsive'>
<table width='100%'' class='table table-striped table-bordered table-hover panel-body-center-table' id='tableresults'>
<thead>

<tr>
<th>#</th>
<th>Responsable</th>
<th>Concepto</th>
<th>Monto Total</th>
</tr>
</thead>
<tbody>
";



if (count($concatenar_logisticas) >= 1) {

	for ($k=0; $k <count($concatenar_logisticas) ; $k++) { 

		$array_conceptos = array();

		$query_concepto_ver = "SELECT concepto FROM balance_gastos_operacion where visible = 'SI' and columna2 = '$concatenar_logisticas[$k]' GROUP BY concepto";
		$result_concepto_ver = mysql_query($query_concepto_ver);
		

		if (mysql_num_rows($result_concepto_ver) >=1) {

			while ($row_concepto = mysql_fetch_array($result_concepto_ver)) {
				array_push($array_conceptos, $row_concepto[0]);
			}

			$monto_total = 0;
			$monto_total_format = 0;

			$query_responsables_ver = "SELECT responsable FROM balance_gastos_operacion where visible = 'SI' and columna2 = '$concatenar_logisticas[$k]' GROUP BY responsable";
			$result_responsables_ver = mysql_query($query_responsables_ver);

			while ($row_responsables_ver = mysql_fetch_array($result_responsables_ver)) {

				$name_responsable_ver = name_responsable($row_responsables_ver[responsable]);

				for ($i=0; $i < count($array_conceptos); $i++) { 

					$query_new_table = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and columna2 = '$concatenar_logisticas[$k]' and concepto = '$array_conceptos[$i]' and tipo_movimiento = 'cargo' and responsable = '$row_responsables_ver[responsable]'";
					$result_new_table = mysql_query($query_new_table);

					if (mysql_num_rows($result_new_table) >=1) {

						while ($row_new_table = mysql_fetch_array($result_new_table)) {

							$monto_total += $row_new_table[gran_total];

						}

						$monto_total_format = number_format($monto_total,2);



						$name_concepto = ucwords($array_conceptos[$i]);

						$nueva_table .= "<tr>
						<td>$concatenar_logisticas[$k]</td>
						<td>$name_responsable_ver</td>
						<td>$name_concepto</td>
						<td>$$monto_total_format</td>
						</tr>";

						$monto_total = 0;
						$monto_total_format = 0;

					}
				}
			}

			
		}



	}
}












$nueva_table .= "
</tbody>
<tfoot>

<th colspan='3' style='text-align:right'>Total:</th>
<th colspan='1' style='text-align:left;'></th>




</tfoot>
</table>
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



#-------------------------------------------Funcion Nombres y Tipo--------------------------------------------------------------------------------

function nombres_datos($id_id, $type_type) {

	$id_id = trim($id_id);
	$type_type = trim($type_type);

	if ($type_type == "Cliente") {

		$query_cliente = "SELECT * FROM contactos WHERE idcontacto = '$id_id'";
		$result_cliente = mysql_query($query_cliente);

		if (mysql_num_rows($result_cliente) >= 1) {

			while ($row_cliente = mysql_fetch_array($result_cliente)) {
				$nombre = "$row_cliente[nombre]"; 
				$apellidos = "$row_cliente[apellidos]"; 
				$alias = "$row_cliente[alias]"; 
				$telefono = "$row_cliente[telefono_celular]"; 
				$telefono_otro = "$row_cliente[telefono_otro]"; 
				$estado_cliente = "$row_cliente[estado]"; 
				$municipio_cliente = "$row_cliente[delmuni]"; 
				$calle_cliente = "$row_cliente[calle]"; 
				$colonia_cliente = "$row_cliente[colonia]"; 
				$cp_cliente = "$row_cliente[cp_cliente]";
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Cliente";
		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Cliente";
		}

	}elseif ($type_type == "Proveedor") {

		$query_proveedor = "SELECT * FROM proveedores WHERE idproveedores = '$id_id'";
		$result_proveedor = mysql_query($query_proveedor);

		if (mysql_num_rows($result_proveedor) >= 1) {

			while ($row_proveedor = mysql_fetch_array($result_proveedor)) {
				$nombre = trim("$row_proveedor[nombre]");
				$apellidos = trim("$row_proveedor[apellidos]");
				$alias = trim("$row_proveedor[alias]");
				$telefono = trim("$row_proveedor[telefono_celular]");
				$telefono_otro = trim("$row_proveedor[telefono_otro]");
				$estado_cliente = trim("$row_proveedor[estado]");
				$municipio_cliente = trim("$row_proveedor[delmuni]");
				$calle_cliente = trim("$row_proveedor[calle]");
				$colonia_cliente = trim("$row_proveedor[colonia]");
				$cp_cliente = trim("$row_proveedor[cp_cliente]");
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor";
		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor";
		}


	}elseif ($type_type == "Proveedor Temporal") {

		$query_proveedor_tem = "SELECT * FROM orden_logistica_proveedores WHERE idorden_logistica_proveedores = '$id_id'";
		$result_proveedor_tem = mysql_query($query_proveedor_tem);

		if (mysql_num_rows($result_proveedor_tem) >= 1) {

			while ($row_proveedor_tem = mysql_fetch_array($result_proveedor_tem)) {
				$nombre = trim("$row_proveedor_tem[nombre]");
				$apellidos = trim("$row_proveedor_tem[apellidos]");
				$alias = trim("$row_proveedor_tem[alias]");
				$telefono = trim("$row_proveedor_tem[telefono_celular]");
				$telefono_otro = trim("$row_proveedor_tem[telefono_otro]");
				$estado_cliente = trim("$row_proveedor_tem[estado]");
				$municipio_cliente = trim("$row_proveedor_tem[delmuni]");
				$calle_cliente = trim("$row_proveedor_tem[calle]");
				$colonia_cliente = trim("$row_proveedor_tem[colonia]");
				$cp_cliente = trim("$row_proveedor_tem[codigo_postal]");
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor Temporal";
		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor Temporal";
		}

	}elseif ($type_type == "Colaborador") {

		$query_colaborador = "SELECT * FROM empleados WHERE idempleados = '$id_id'";
		$result_colaborador = mysql_query($query_colaborador);

		if (mysql_num_rows($result_colaborador) >= 1) {

			while ($row_colaborador = mysql_fetch_array($result_colaborador)) {
				$nombre = "$row_colaborador[nombre]";
				$apellidos = trim("$row_colaborador[apellido_paterno]")." ".trim("$row_colaborador[apellido_materno]"); 
				$alias = trim("$row_colaborador[columna_b]");
				$telefono = trim("$row_colaborador[telefono_personal]");
				$telefono_otro = trim("$row_colaborador[telefono_emergencia]");
				$estado_cliente = trim("$row_colaborador[estado]");
				$municipio_cliente = trim("$row_colaborador[municipio]");
				$calle_cliente = trim("$row_colaborador[calle_numero]");
				$colonia_cliente = trim("$row_colaborador[colonia]");
				$cp_cliente = trim("$row_colaborador[cp]");
				$nomenclatura_co = trim("$row_colaborador[columna_b]");
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nomenclatura_co|Colaborador";
		}else{
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Colaborador";
		}

	}else{
		$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente";
	}

	return $concatenacion;

}

#-------------------------------------------Funcion Departamento--------------------------------------------------------------------------------

function name_departamento($id_departamento) {

	$id_departamento = trim($id_departamento);

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

#-------------------------------------------Funcion Tipo Orden--------------------------------------------------------------------------------

function name_Torden($id_tipo_orden){

	$id_tipo_orden = trim($id_tipo_orden);

	$query_tipo_orden = "SELECT * FROM catalogo_orden_logistica WHERE idcatalogo_orden_logistica = '$id_tipo_orden'";
	$result_tipo_orden = mysql_query($query_tipo_orden);

	while ($row_tipo_orden = mysql_fetch_array($result_tipo_orden)) {
		$name_tipo_orden = $row_tipo_orden[nombre_orden];
	}
	return $name_tipo_orden;
}

#-------------------------------------------Funcion Estatus_principal--------------------------------------------------------------------------------

function estatusLogistica($id_logistica_estatus) {

	$id_logistica_estatus = trim($id_logistica_estatus);

	$query_estatus = "SELECT * FROM orden_logistica_bitacora WHERE visible = 'SI' and valor = '1' and idorden_logistica = '$id_logistica_estatus' order by idorden_logistica_bitacora desc limit 1";
	$result_estatus = mysql_query($query_estatus);

	while ($row_estatus = mysql_fetch_array($result_estatus)) {
		$estatus_logistica = $row_estatus[tipo];
	}
	return $estatus_logistica;
}

#-------------------------------------------Funcion VIN--------------------------------------------------------------------------------

function searchVIN($id_logistica_vin){
	$id_logistica_vin = trim($id_logistica_vin);

	$mostrar_unidad = "";

	$query_busqueda_vin = "SELECT * FROM orden_logistica_unidades WHERE visible = 'SI' and idorden_logistica = '$id_logistica_vin' ";
	$result_busqueda_vin = mysql_query($query_busqueda_vin);

	if (mysql_num_rows($result_busqueda_vin) == 0) {

		$mostrar_unidad .= "Pendiente";

	}elseif (mysql_num_rows($result_busqueda_vin) == 1) {

		while ($row_busqueda_vin = mysql_fetch_array($result_busqueda_vin)) {

			$buscardatos_vin = date_vin($row_busqueda_vin[vin]);
			$porciones_vin = explode("|", $buscardatos_vin);

			$mostrar_unidad .= "
			<b>VIN:</b> $porciones_vin[0]<br>
			<b>Marca:</b> $porciones_vin[1]<br>
			<b>Versión:</b> $porciones_vin[2]<br>
			<b>Color:</b> $porciones_vin[3]<br>
			<b>Modelo:</b> $porciones_vin[4]<br>
			<b>T. Unidad:</b> $porciones_vin[5]";
		}
		
	} else{

		while ($row_busqueda_vin = mysql_fetch_array($result_busqueda_vin)) {

			$buscardatos_vin = date_vin($row_busqueda_vin[vin]);
			$porciones_vin = explode("|", $buscardatos_vin);

			$mostrar_unidad .= "
			<b>VIN:</b> $porciones_vin[0]<br>
			<b>Marca:</b> $porciones_vin[1]<br>
			<b>Versión:</b> $porciones_vin[2]<br>
			<b>Color:</b> $porciones_vin[3]<br>
			<b>Modelo:</b> $porciones_vin[4]<br>
			<b>T. Unidad:</b> $porciones_vin[5]<hr>";
		}
	}
	$mostrar_unidad;

	return $mostrar_unidad;

}


#-------------------------------------------Extraer VIN--------------------------------------------------------------------------------
function date_vin($vin) {

	$buscar_vin = trim($vin);


	$query_logistica_unidades = "SELECT * from inventario where TRIM(vin_numero_serie) = '$buscar_vin' and TRIM(estatus_unidad) <> 'Utilitaria' and TRIM(estatus_unidad) <> 'Utilitario'";
	$result_query_logistica_unidades = mysql_query($query_logistica_unidades);

	if (mysql_num_rows($result_query_logistica_unidades) >= 1) {

		while ($row_query_logistica_unidades = mysql_fetch_array($result_query_logistica_unidades)) {
			$marca_logistica = trim("$row_query_logistica_unidades[marca]");
			$version_logistica = trim("$row_query_logistica_unidades[version]");
			$color_logistica = trim("$row_query_logistica_unidades[color]");
			$modelo_logistica = trim("$row_query_logistica_unidades[modelo]");
			$ver_vin = trim("$row_query_logistica_unidades[vin_numero_serie]");
			$id_unidad = trim($row_query_logistica_unidades[idinventario]);
		}

		$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Unidad|$id_unidad";

	}else{

		$query_logistica_trucks = "SELECT * from inventario_trucks where TRIM(vin_numero_serie) = '$buscar_vin' and TRIM(estatus_unidad) <> 'Utilitaria' and TRIM(estatus_unidad) <> 'Utilitario'";
		$result_query_logistica_trucks = mysql_query($query_logistica_trucks);

		if (mysql_num_rows($result_query_logistica_trucks) >= 1) {
			while ($row_query_logistica_trucks = mysql_fetch_array($result_query_logistica_trucks)) {

				$marca_logistica = trim("$row_query_logistica_trucks[marca]");
				$version_logistica = trim("$row_query_logistica_trucks[version]");
				$color_logistica = trim("$row_query_logistica_trucks[color]");
				$modelo_logistica = trim("$row_query_logistica_trucks[modelo]");
				$ver_vin = trim("$row_query_logistica_trucks[vin_numero_serie]");
				$id_unidad = trim($row_query_logistica_trucks[idinventario]);
			}

			$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Trucks|$id_unidad";

		}else{

			$query_logistica_utilitario = "SELECT * from catalogo_unidades_utilitarios where TRIM(vin) = '$buscar_vin'";
			$result_query_logistica_utilitario = mysql_query($query_logistica_utilitario);

			if (mysql_num_rows($result_query_logistica_utilitario) >= 1) {

				while ($row_query_logistica_utilitario = mysql_fetch_array($result_query_logistica_utilitario)) {

					$marca_logistica = trim("$row_query_logistica_utilitario[marca]");
					$version_logistica = trim("$row_query_logistica_utilitario[version]");
					$color_logistica = trim("$row_query_logistica_utilitario[color]");
					$modelo_logistica = trim("$row_query_logistica_utilitario[modelo]");
					$ver_vin = trim("$row_query_logistica_utilitario[vin]");
					$id_unidad = trim($row_query_logistica_utilitario[idcatalogo_unidades_utilitarios]);

				}	

				$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Utilitario|$id_unidad";

			}else{

				$query_logistica_inventario = "SELECT * FROM orden_logistica_inventario WHERE TRIM(vin) = '$buscar_vin' and visible = 'SI'";
				$result_logistica_inventario = mysql_query($query_logistica_inventario);

				if (mysql_num_rows($result_logistica_inventario) >= 1) {

					while ($row_logistica_inventario = mysql_fetch_array($result_logistica_inventario)) {
						$marca_logistica = trim("$row_logistica_inventario[marca]");
						$version_logistica = trim("$row_logistica_inventario[version]");
						$color_logistica = trim("$row_logistica_inventario[color]");
						$modelo_logistica = trim("$row_logistica_inventario[modelo]");
						$ver_vin = trim("$row_logistica_inventario[vin]");
						$id_unidad = trim($row_logistica_inventario[idorden_logistica_inventario]);
					}

					$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Indefinido|$id_unidad";

				}else{

					$marca_logistica = trim("Por definir");
					$version_logistica = trim("Por definir");
					$color_logistica = trim("Por definir");
					$modelo_logistica = trim("Por definir");
					$ver_vin = trim("Por definir");
					$id_unidad = trim("Por definir");


					$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Por Definir|$id_unidad";
				}						
			}
		}
	}

	return $result_vin;

}
#-------------------------------------------Extraer Ayudante--------------------------------------------------------------------------------

function searchAyudante($id_logistica_ayudante) {

	$id_logistica_ayudante = trim($id_logistica_ayudante);

	$query_ayudante = "SELECT * FROM orden_logistica_ayudante where visible = 'SI' and idorden_logistica = '$id_logistica_ayudante'";
	$result_ayudante = mysql_query($query_ayudante);

	if (mysql_num_rows($result_ayudante) == 0) {
		$ver_ayudantes = "N/A";

	}else if (mysql_num_rows($result_ayudante) == 1) {
		
		while ($row_ayudante = mysql_fetch_array($result_ayudante)) {

			$buscar_ayudante = nombres_datos(trim($row_ayudante[id_colaborador_proveedor]), trim($row_ayudante[tipo]));

			$porciones_ayudante = explode("|", $buscar_ayudante);
			$ver_ayudantes .= $porciones_ayudante[10];

		}

	} else {

		while ($row_ayudante = mysql_fetch_array($result_ayudante)) {

			$buscar_ayudante = nombres_datos(trim($row_ayudante[id_colaborador_proveedor]), trim($row_ayudante[tipo]));

			$porciones_ayudante = explode("|", $buscar_ayudante);
			$ver_ayudantes .= $porciones_ayudante[10]."<hr>";

		}
	}
	return $ver_ayudantes;
}

function costoTotalLogistica($id_logistica_pasar) {

	$query_costo = "SELECT sum(gran_total) FROM balance_gastos_operacion where visible = 'SI' and columna2 = '$id_logistica_pasar' and tipo_movimiento = 'cargo' ";
	$result_costo = mysql_query($query_costo);

	while ($row_costo = mysql_fetch_array($result_costo)) {
		$valor_monto = $row_costo[0];
	}


	return $total_monto = ($valor_monto == null || $valor_monto == "")? "$ 0.00" : "$ ".number_format($valor_monto, 2);

}

//$nueva_table
echo "$mensaje <hr> $nueva_table";
?>
