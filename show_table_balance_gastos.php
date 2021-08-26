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
<?php
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
date_default_timezone_set('America/Mexico_City');

$fecha_inicio_mes = date("Y-m-")."01";

$fecha_actual_mes = date("Y-m-d"); 


$usuario_creador=$_SESSION['usuario_clave'];

$concepto = trim($_POST['concepto']);


$proveedor = trim($_POST['proveedor']);



$id_colaborador = trim($_POST['id_colaborador']);
$nomme_columna = name_responsable($id_colaborador);

$departamento = trim($_POST['departamento']);


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
	
	$fecha_a = "";
	$fecha_b = "";
}


$metodopago = trim($_POST['metodopago']);

$range_gastos = trim($_POST['range_gastos']);

$porciones_costos = explode(",", $range_gastos);

if (trim($porciones_costos[0]) == "0" and trim($porciones_costos[1]) == "0") {

	$monto_a = "";
	$monto_b = "";

}else{

	$monto_a = trim($porciones_costos[0]);
	$monto_b = trim($porciones_costos[1]);

}

$vin = trim($_POST['vin_herramienta']);


$tarjeta = trim($_POST['tarjeta']);


$idlogistica = $_POST['idlogistica'];





// and $idlogistica == "" and $concepto == "" and $proveedor == "" and $id_colaborador == "" and $nomme_columna == "" and $departamento == "" and $fecha_a == "" and $fecha_b == "" and $metodopago == "" and $monto_a == "" and $monto_b == "" and $vin == "" and $tarjeta == ""

# Cominezan las consultas con las combinaciones posibles
if ($idlogistica != "" and $concepto == "" and $proveedor == "" and $id_colaborador == "" and $nomme_columna == "" and $departamento == "" and $fecha_a == "" and $fecha_b == "" and $metodopago == "" and $monto_a == "" and $monto_b == "" and $vin == "" and $tarjeta == "") {
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and columna2 = '$idlogistica'";
	$condicion = 0;

}else if ($concepto != "" and $idlogistica == "" and $proveedor == "" and $id_colaborador == "" and $nomme_columna == "" and $departamento == "" and $fecha_a == "" and $fecha_b == "" and $metodopago == "" and $monto_a == "" and $monto_b == "" and $vin == "" and $tarjeta == "") {
#1 ----------Consulta | Concepto
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto'";
	$condicion = 1;

}else if ($proveedor != "" and $idlogistica == "" and $concepto == "" and $id_colaborador == "" and $nomme_columna == "" and $departamento == "" and $fecha_a == "" and $fecha_b == "" and $metodopago == "" and $monto_a == "" and $monto_b == "" and $vin == "" and $tarjeta == "") {
#2 ----------Consulta | Proveedor
	$query_balance_total = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' )";
	$condicion = 2;

}else if ($id_colaborador != "" and $idlogistica == "" and $concepto == "" and $proveedor == "" and $nomme_columna == "" and $departamento == "" and $fecha_a == "" and $fecha_b == "" and $metodopago == "" and $monto_a == "" and $monto_b == "" and $vin == "" and $tarjeta == "") {
#3 ----------Consulta | Colaborador
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' )";
	$condicion = 3;

}else if ($departamento != "" and $idlogistica == "" and $concepto == "" and $proveedor == "" and $id_colaborador == "" and $nomme_columna == "" and $fecha_a == "" and $fecha_b == "" and $metodopago == "" and $monto_a == "" and $monto_b == "" and $vin == "" and $tarjeta == "") {
#4 ----------Consulta | Departamento
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and idcatalogo_departamento = '$departamento'";
	$condicion = 4;

}else if ($fecha_a != "" and $fecha_b != "" and $idlogistica == "" and $concepto == "" and $proveedor == "" and $id_colaborador == "" and $nomme_columna == "" and $departamento == "" and $metodopago == "" and $monto_a == "" and $monto_b == "" and $vin == "" and $tarjeta == "") {
#5 ----------Consulta | Fechas
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and fecha_movimiento between '$fecha_a' and '$fecha_b' ";
	$condicion = 5;

}else if ($metodopago != "" and $idlogistica == "" and $concepto == "" and $proveedor == "" and $id_colaborador == "" and $nomme_columna == "" and $departamento == "" and $fecha_a == "" and $fecha_b == "" and $monto_a == "" and $monto_b == "" and $vin == "" and $tarjeta == "") {
#6 ----------Consulta | Metodo Pago
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion where visible = 'SI' and comision = 'N/A'" : "SELECT * FROM balance_gastos_operacion where visible = 'SI' and comision <> 'N/A'" ;
	$condicion = 6;

}else if ($monto_a != "" and $monto_b != "" and $idlogistica == "" and $concepto == "" and $proveedor == "" and $id_colaborador == "" and $nomme_columna == "" and $departamento == "" and $fecha_a == "" and $fecha_b == "" and $metodopago == "" and $vin == "" and $tarjeta == "") {
#7 ----------Consulta | MontoTotal
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and gran_total between '$monto_a' and '$monto_b' ";
	$condicion = 7;

}else if ($vin != "" and $idlogistica == "" and $concepto == "" and $proveedor == "" and $id_colaborador == "" and $nomme_columna == "" and $departamento == "" and $fecha_a == "" and $fecha_b == "" and $metodopago == "" and $monto_a == "" and $monto_b == "" and $tarjeta == "") {
#8 ----------Consulta | VIN
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and trim(datos_vin) = '$vin'";	
	$condicion = 8;

}else if ($tarjeta != "" and $idlogistica == "" and $concepto == "" and $proveedor == "" and $id_colaborador == "" and $nomme_columna == "" and $departamento == "" and $fecha_a == "" and $fecha_b == "" and $metodopago == "" and $monto_a == "" and $monto_b == "" and $vin == "") {
#9 ----------Consulta | Tarjeta
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and trim(comision) = '$tarjeta'";
	$condicion = 9;

}else if ($concepto != "" and $departamento != "") {
#10 ----------Consulta | Concepto Departamento
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and idcatalogo_departamento = '$departamento''";
	$condicion = 10;

}else if ($concepto != "" and $fecha_a != "" and $fecha_b != "") {
#11 ----------Consulta | Concepto Fecha
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and fecha_movimiento between '$fecha_a' and '$fecha_b'";
	$condicion = 11;

}else if ($concepto != "" and $metodopago != "") {
#12 ----------Consulta | Concepto MetodoPago
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and comision = 'N/A'" : "SELECT * FROM balance_gastos_operacion where visible = 'SI' and comision <> 'N/A'" ;
	$condicion = 12;

}else if ($proveedor != "" and $departamento != "") {
#13 ----------Consulta | Proveedor Departamento
	$query_balance_total = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and idcatalogo_departamento = '$departamento'";
	$condicion = 13;

}else if ($proveedor != "" and $fecha_a != "" and $fecha_b != "") {
#14 ----------Consulta | Proveedor Fecha
	$query_balance_total = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and fecha_movimiento between '$fecha_a' and '$fecha_b'";	
	$condicion = 14;

}else if ($proveedor != "" and $metodopago != "") {
#15 ----------Consulta | Proveedor MetodoPago
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and comision = 'N/A'" : "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and comision <> 'N/A'" ;
	$condicion = 15;

}else if ($id_colaborador != "" and $departamento != "") {
#16 ----------Consulta | Colaborador Departamento
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and idcatalogo_departamento = '$departamento'";
	$condicion = 16;

}else if ($id_colaborador != "" and $fecha_a != "" and $fecha_b != "") {
#17 ----------Consulta | Colaborador Fecha
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and fecha_movimiento between '$fecha_a' and '$fecha_b'";
	$condicion = 17;

}else if ($id_colaborador != "" and $metodopago != "") {
#18 ----------Consulta | Colaborador MetodoPago
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and comision = 'N/A'" : "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and comision <> 'N/A'" ;
	$condicion = 18;

}else if ($concepto != "" and $monto_a != "" and $monto_b != "") {
#19 ----------Consulta | Concepto MontoTotal
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and gran_total between '$monto_a' and '$monto_b' ";
	$condicion = 19;

}else if ($concepto != "" and $vin != "") {
#20 ----------Consulta | Concepto VIN
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and trim(datos_vin) = '$vin'";
	$condicion = 20;

}else if ($concepto != "" and $tarjeta != "") {
#21 ----------Consulta | Concepto Tarjeta
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and trim(comision) = '$tarjeta'";
	$condicion = 21;

}else if ($proveedor != "" and $monto_a != "" and $monto_b != "") {
#22 ----------Consulta | Proveedor MontoTotal
	$query_balance_total = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and gran_total between '$monto_a' and '$monto_b' ";
	$condicion = 22;

}else if ($proveedor != "" and $vin != "") {
#23 ----------Consulta | Proveedor VIN
	$query_balance_total = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and trim(datos_vin) = '$vin' ";
	$condicion = 23;

}else if ($proveedor != "" and $tarjeta != "") {
#24 ----------Consulta | Proveedor Tarjeta 
	$query_balance_total = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and trim(comision) = '$tarjeta' ";	 
	$condicion = 24;

}else if ($id_colaborador != "" and $monto_a != "" and $monto_b != "") {
#25 ----------Consulta | Colaborador MontoTotal
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and gran_total between '$monto_a' and '$monto_b' ";
	$condicion = 25;

}else if ($id_colaborador != "" and $vin != "") {
#26 ----------Consulta | Colaborador VIN
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and trim(datos_vin) = '$vin' ";
	$condicion = 26;

}else if ($id_colaborador != "" and $tarjeta != "") {
#27 ----------Consulta | Colaborador Tarjeta
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and trim(comision) = '$tarjeta' ";
	$condicion = 27;

}else if ($departamento != "" and $monto_a != "" and $monto_b != "") {
#28 ----------Consulta | Departamento MontoTotal
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and idcatalogo_departamento = '$departamento' and gran_total between '$monto_a' and '$monto_b' ";
	$condicion = 28;

}else if ($departamento != "" and $vin != "") {
#29 ----------Consulta | Departamento VIN
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and idcatalogo_departamento = '$departamento' and trim(datos_vin) = '$vin' ";
	$condicion = 29;

}else if ($idcatalogo_departamento != "" and $tarjeta != "") {
#30 ----------Consulta | Departamento Tarjeta
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and idcatalogo_departamento = '$departamento' and trim(comision) = '$tarjeta' ";
	$condicion = 30;

}else if ($fecha_a != "" and $fecha_b != "" and $monto_a != "" and $monto_b != "") {
#31 ----------Consulta | Fecha MontoTotal
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and fecha_movimiento between '$fecha_a' and '$fecha_b' and gran_total between '$monto_a' and '$monto_b' ";
	$condicion = 31;

}else if ($fecha_a != "" and $fecha_b != "" and $vin != "") {
#32 ----------Consulta | Fecha VIN
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and fecha_movimiento between '$fecha_a' and '$fecha_b' and trim(datos_vin) = '$vin' ";
	$condicion = 32;

}else if ($fecha_a != "" and $fecha_b != "" and $tarjeta != "") {
#33 ----------Consulta | Fecha Tarjeta
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and fecha_movimiento between '$fecha_a' and '$fecha_b' and trim(comision) = '$tarjeta' ";
	$condicion = 33;

}else if ($metodopago != "" and $monto_a != "" and $monto_b != "") {
#34 ----------Consulta | MetodoPago MontoTotal
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion where visible = 'SI' and comision = 'N/A' and gran_total between '$monto_a' and '$monto_b' " : "SELECT * FROM balance_gastos_operacion where visible = 'SI' and comision <> 'N/A' and gran_total between '$monto_a' and '$monto_b' " ;
	$condicion = 34;

}else if ($metodopago != "" and $monto_a != "" and $vin != "") {
#35 ----------Consulta | MetodoPago VIN
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion where visible = 'SI' and comision = 'N/A' and trim(datos_vin) = '$vin' " : "SELECT * FROM balance_gastos_operacion where visible = 'SI' and comision <> 'N/A' and trim(datos_vin) = '$vin' ";
	$condicion = 35;

}else if ($metodopago != "" and $tarjeta != "") {
#36 ----------Consulta | MetodoPago Tarjeta
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion where visible = 'SI' and comision = 'N/A'  " :"SELECT * FROM balance_gastos_operacion where visible = 'SI' and trim(comision) = '$tarjeta' ";
	$condicion = 36;

}else if ($concepto != "" and $departamento != "" and $monto_a != "" and $monto_b != "") {
#37 ----------Consulta | Concepto Departamento MontoTotal
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and idcatalogo_departamento = '$departamento' and gran_total between '$monto_a' and '$monto_b'";
	$condicion = 37;

}else if ($concepto != "" and $departamento != "" and $vin != "") {
#38 ----------Consulta | Concepto Departamento VIN
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and idcatalogo_departamento = '$departamento' and trim(datos_vin) = '$vin'";
	$condicion = 38;

}else if ($concepto != "" and $departamento != "" and $tarjeta != "") {
#39 ----------Consulta | Concepto Departamento Tarjeta
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and idcatalogo_departamento = '$departamento' and trim(comision) = '$tarjeta'";
	$condicion = 39;

}else if ($concepto != "" and $fecha_a != "" and $fecha_b != "" and $monto_a != "" and $monto_b != "") {
#40 ----------Consulta | Concepto Fecha MontoTotal
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and fecha_movimiento between '$fecha_a' and '$fecha_b' and gran_total between '$monto_a' and '$monto_b'";
	$condicion = 40;

}else if ($concepto != "" and $fecha_a != "" and $fecha_b != "" and $vin != "") {
#41 ----------Consulta | Concepto Fecha VIN
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and fecha_movimiento between '$fecha_a' and '$fecha_b' and trim(datos_vin) = '$vin'";
	$condicion = 41;

}else if ($concepto != "" and $fecha_a != "" and $fecha_b != "" and $tarjeta != "") {
#42 ----------Consulta | Concepto Fecha Tarjeta
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and fecha_movimiento between '$fecha_a' and '$fecha_b' and trim(comision) = '$tarjeta'";
	$condicion = 42;

}else if ($concepto != "" and $metodopago != "" and $monto_a != "" and $monto_b != "") {
#43 ----------Consulta | Concepto MetodoPago MontoTotal
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and comision = 'N/A' and gran_total between '$monto_a' and '$monto_b'" : "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and comision <> 'N/A' and gran_total between '$monto_a' and '$monto_b'" ;
	$condicion = 43;

}else if ($concepto != "" and $metodopago != "" and $vin != "") {
#44 ----------Consulta | Concepto MetodoPago VIN
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and comision = 'N/A' and trim(datos_vin) = '$vin'" : "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and comision <> 'N/A' and trim(datos_vin) = '$vin'" ;
	$condicion = 44;

}else if ($concepto != "" and $metodopago != "" and $tarjeta != "") {
#45 ----------Consulta | Concepto MetodoPago Tarjeta
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and comision = 'N/A' " : "SELECT * FROM balance_gastos_operacion where visible = 'SI' and concepto = '$concepto' and trim(comision) = '$tarjeta'" ;
	$condicion = 45;

}else if ($proveedor != "" and $departamento != "" and $monto_a != "" and $monto_b != "") {
#46 ----------Consulta | Proveedor Departamento MontoTotal
	$query_balance_total = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and idcatalogo_departamento = '$departamento' and gran_total between '$monto_a' and '$monto_b'";
	$condicion = 46;

}else if ($proveedor != "" and $departamento != "" and $vin != "") {
#47 ----------Consulta | Proveedor Departamento VIN
	$query_balance_total = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and idcatalogo_departamento = '$departamento' and trim(datos_vin) = '$vin'";
	$condicion = 47;

}else if ($proveedor != "" and $departamento != "" and $tarjeta != "") {
#48 ----------Consulta | Proveedor Departamento Tarjeta
	$query_balance_total = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and idcatalogo_departamento = '$departamento' and trim(comision) = '$tarjeta'";
	$condicion = 48;

}else if ($proveedor != "" and $fecha_a != "" and $fecha_b != "" and $monto_a != "" and $monto_b != "") {
#49 ----------Consulta | Proveedor Fecha MontoTotal
	$query_balance_total = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and fecha_movimiento between '$fecha_a' and '$fecha_b' and gran_total between '$monto_a' and '$monto_b'";	
	$condicion = 49;

}else if ($proveedor != "" and $fecha_a != "" and $fecha_b != "" and $vin != "") {
#50 ----------Consulta | Proveedor Fecha VIN
	$query_balance_total = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and fecha_movimiento between '$fecha_a' and '$fecha_b' and trim(datos_vin) = '$vin'";
	$condicion = 50;

}else if ($proveedor != "" and $fecha_a != "" and $fecha_b != "" and $tarjeta != "") {
#51 ----------Consulta | Proveedor Fecha Tarjeta
	$query_balance_total = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and fecha_movimiento between '$fecha_a' and '$fecha_b' and trim(comision) = '$tarjeta'";
	$condicion = 51;

}else if ($proveedor != "" and $metodopago != "" and $monto_a != "" and $monto_b != "") {
#52 ----------Consulta | Proveedor MetodoPago MontoTotal
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and comision = 'N/A' and gran_total between '$monto_a' and '$monto_b'" : "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and comision <> 'N/A' and gran_total between '$monto_a' and '$monto_b'" ;
	$condicion = 52;

}else if ($proveedor != "" and $metodopago != "" and $vin != "") {
#53 ----------Consulta | Proveedor MetodoPago VIN
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and comision = 'N/A' and trim(datos_vin) = '$vin'" : "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and comision <> 'N/A' and trim(datos_vin) = '$vin'" ;
	$condicion = 53;

}else if ($proveedor != "" and $metodopago != "" and $tarjeta != "") {
#54 ----------Consulta | Proveedor MetodoPago Tarjeta
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and comision = 'N/A'" : "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and (emisora_institucion = '$proveedor' || receptora_institucion = '$proveedor' ) and trim(comision) = '$tarjeta'" ;
	$condicion = 54;

}else if ($id_colaborador != "" and $departamento != "" and $monto_a != "" and $monto_b != "") {
#55 ----------Consulta | Colaborador Departamento MontoTotal
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and idcatalogo_departamento = '$departamento' and gran_total between '$monto_a' and '$monto_b'";
	$condicion = 55;

}else if ($id_colaborador != "" and $departamento != "" and $vin != "") {
#56 ----------Consulta | Colaborador Departamento VIN
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and idcatalogo_departamento = '$departamento' and trim(datos_vin) = '$vin'";
	$condicion = 56;

}else if ($id_colaborador != "" and $departamento != "" and $tarjeta != "") {
#57 ----------Consulta | Colaborador Departamento Tarjeta
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and idcatalogo_departamento = '$departamento' and trim(comision) = '$tarjeta'";
	$condicion = 57;

}else if ($id_colaborador != "" and $fecha_a != "" and $fecha_b != "" and $monto_a != "" and $monto_b != "") {
#58 ----------Consulta | Colaborador Fecha MontoTotal
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and fecha_movimiento between '$fecha_a' and '$fecha_b' and gran_total between '$monto_a' and '$monto_b'";
	$condicion = 58;

}else if ($id_colaborador != "" and $fecha_a != "" and $fecha_b != "" and $vin != "") {
#59 ----------Consulta | Colaborador Fecha VIN
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and fecha_movimiento between '$fecha_a' and '$fecha_b' and trim(datos_vin) = '$vin'";
	$condicion = 59;

}else if ($id_colaborador != "" and $fecha_a != "" and $fecha_b != "" and $tarjeta != "") {
#60 ----------Consulta | Colaborador Fecha Tarjeta
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and fecha_movimiento between '$fecha_a' and '$fecha_b' and trim(comision) = '$tarjeta'";
	$condicion = 60;

}else if ($id_colaborador != "" and $metodopago != "" and $monto_a != "" and $monto_b !="") {
#61 ----------Consulta | Colaborador MetodoPago MontoTotal
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and comision = 'N/A' and gran_total between '$monto_a' and '$monto_b'" : "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and comision <> 'N/A' and gran_total between '$monto_a' and '$monto_b'" ;
	$condicion = 61;

}else if ($id_colaborador != "" and $metodopago != "" and $vin != "") {
#62 ----------Consulta | Colaborador MetodoPago VIN
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and comision = 'N/A' and trim(datos_vin) = '$vin'" : "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and comision <> 'N/A' and trim(datos_vin) = '$vin'" ;
	$condicion = 62;

}else if ($id_colaborador != "" and $metodopago != "" and $tarjeta != "") {
#63 ----------Consulta | Colaborador MetodoPago Tarjeta
	$query_balance_total = ($metodopago == "Efectivo") ? "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and comision = 'N/A'" : "SELECT * FROM balance_gastos_operacion where visible = 'SI' and (responsable = '$id_colaborador' || responsable = '$nomme_columna' ) and trim(comision) = '$tarjeta'" ;
	$condicion = 63;

}else{
# ----------Consulta | General	
	$query_balance_total = "SELECT * FROM balance_gastos_operacion where visible = 'SI' and fecha_movimiento between '$fecha_inicio_mes' and '$fecha_actual_mes' ";
	$condicion = 64;

}

$ok = 0;
$result_balance_total = mysql_query($query_balance_total);

$mensaje .= "<div class='table-responsive'>
<table width='100%'' class='table table-striped table-bordered table-hover panel-body-center-table' id='example'>
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
<th>Referencia</th>
</tr>
</thead>
<tbody>
";

while ($row_balance_total = mysql_fetch_array($result_balance_total)) {

	$nomenclatura_responsable = (is_numeric($row_balance_total[responsable])) ? name_responsable($row_balance_total[responsable]) : $row_balance_total[responsable] ;

	$ok ++; 
	$encriptado = base64_encode($row_balance_total[columna2]);
	$link = "<a href='orden_logistica_detalles.php?idib=$encriptado' target='_blank'>$row_balance_total[columna2]</a>";

	$name_proveedor = ($row_balance_total[tipo_movimiento] == "cargo") ? $row_balance_total[emisora_institucion] : $row_balance_total[receptora_institucion] ;
	$monto_cargo = ($row_balance_total[tipo_movimiento] == "cargo") ? number_format($row_balance_total[gran_total],2) : number_format("0",2);
	$monto_abono = ($row_balance_total[tipo_movimiento] == "abono") ? number_format($row_balance_total[gran_total],2) : number_format("0",2);
	$new_monto_cargo += ($row_balance_total[tipo_movimiento] == "cargo") ? $row_balance_total[gran_total] : number_format("0",2);
	$new_monto_abono += ($row_balance_total[tipo_movimiento] == "abono") ? $row_balance_total[gran_total] : number_format("0",2);
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
	<td>$condicion</td>
	</tr>";

}

$format_cargo = number_format($new_monto_cargo,2);
$format_abono = number_format($new_monto_abono,2);

$total_diferencia = $new_monto_cargo - $new_monto_abono;
$monto_diferencia = number_format($total_diferencia,2);

$mensaje .= "
</tbody>
<tfoot>

<th colspan='6' style='text-align:right'>Total:</th>
<th colspan='6' style='text-align:left;'></th>

<!--<tr>
<th colspan='6' style='text-align:right'>Total Abono:</th>
<th colspan='6' style='text-align:left;'>$$format_abono</th>
</tr>

<tr>
<th colspan='6' style='text-align:right'>Total Diferencia:</th>
<th colspan='6' style='text-align:left;'>$$monto_diferencia</th>
</tr>-->


</tfoot>
</table>
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


echo $mensaje;
?>
