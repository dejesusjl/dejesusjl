<script>
	$(document).ready(function() {
		$('#example').DataTable({

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
				'copy', 'excel'
			]


		});

		var table = $('#example').DataTable();

		table
			.order([0, 'desc'])
			.draw();
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


$usuario_creador = $_SESSION['usuario_clave'];


$idlogistica = $_POST['idlogistica'];

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];



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

	$fecha_a = "";
	$fecha_b = "";
}

$estado_origen = trim($_POST['estado_origen']);
$municipio_origen = trim($_POST['municipio_origen']);

$estado_origen = trim($_POST['estado_origen']);
$municipio_origen = trim($_POST['municipio_origen']);

$estado_destino = trim($_POST['estado_destino']);
$municipio_destino = trim($_POST['municipio_destino']);

$idcontacto = trim($_POST['idcontacto']);

$iddepartamento = trim($_POST['departamento']);
$idcatalogo_orden_logistica = trim($_POST['nombre_orden']);

$vin_herramienta = trim($_POST['vin_herramienta']);


# Cominezan las consultas con las combinaciones posibles
if ($idlogistica != "" and $fecha_a == "" and $fecha_b == "" and $estado_origen == "" and $municipio_origen == "" and  $estado_destino == "" and $municipio_destino == "" and $idcontacto == "" and $iddepartamento == "" and $idcatalogo_orden_logistica == "" and $vin_herramienta == "") {
	#1 ----------Consulta | Número Logistica
	$num_query = "1";
	$query_logistica = "SELECT * FROM orden_logistica where idorden_logistica = '$idlogistica'";
} else if ($idlogistica == "" and $fecha_a != "" and $fecha_b != "" and $estado_origen == "" and $municipio_origen == "" and  $estado_destino == "" and $municipio_destino == "" and $idcontacto == "" and $iddepartamento == "" and $idcatalogo_orden_logistica == "" and $vin_herramienta == "") {
	#2 ----------Consulta | Rango de Fechas
	$num_query = "2";
	$query_logistica = "SELECT * FROM orden_logistica where DATE_FORMAT(fecha_solicitud, '%Y-%m-%d') between '$fecha_a' and '$fecha_b' ||  DATE_FORMAT(fecha_programada, '%Y-%m-%d') between '$fecha_a' and '$fecha_b' ||  DATE_FORMAT(fecha_salida, '%Y-%m-%d') between '$fecha_a' and '$fecha_b' ||  DATE_FORMAT(fecha_llega_destino, '%Y-%m-%d') between '$fecha_a' and '$fecha_b' ||  DATE_FORMAT(fecha_retorno, '%Y-%m-%d') between '$fecha_a' and '$fecha_b' || DATE_FORMAT(hora_real_solucion, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'";
} elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $estado_origen != "" and $municipio_origen == "" and  $estado_destino == "" and $municipio_destino == "" and $idcontacto == "" and $iddepartamento == "" and $idcatalogo_orden_logistica == "" and $vin_herramienta == "") {
	#3 ----------Consulta | Estado_Origen
	$num_query = "3";
	$query_logistica = "SELECT * FROM orden_logistica where $estado_origen = '$estado_origen' ";
} elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $estado_origen == "" and $municipio_origen != "" and  $estado_destino == "" and $municipio_destino == "" and $idcontacto == "" and $iddepartamento == "" and $idcatalogo_orden_logistica == "" and $vin_herramienta == "") {
	#4 ----------Consulta | Municipio_Origen
	$num_query = "4";
	$query_logistica = "SELECT * FROM orden_logistica where municipio_origen = '$municipio_origen' ";
} elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $estado_origen == "" and $municipio_origen == "" and $estado_destino != "" and $municipio_destino == "" and $idcontacto == "" and $iddepartamento == "" and $idcatalogo_orden_logistica == "" and $vin_herramienta == "") {
	#5 ----------Consulta | Estado_destino
	$num_query = "5";
	$query_logistica = "SELECT * FROM orden_logistica where estado_destino = '$estado_destino' ";
} elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $estado_origen == "" and $municipio_origen == "" and  $estado_destino == "" and $municipio_destino != "" and $idcontacto == "" and $iddepartamento == "" and $idcatalogo_orden_logistica == "" and $vin_herramienta == "") {
	#6 ----------Consulta | Municipio_destino
	$num_query = "6";
	$query_logistica = "SELECT * FROM orden_logistica where municipio_destino = '$municipio_destino' ";
} elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $estado_origen == "" and $municipio_origen == "" and  $estado_destino == "" and $municipio_destino == "" and $idcontacto != "" and $iddepartamento == "" and $idcatalogo_orden_logistica == "" and $vin_herramienta == "") {
	#7 ----------Consulta |  ID Especifico
	$num_query = "7";
	$query_logistica = "SELECT * FROM orden_logistica where idcontacto = '$idcontacto' and tipo_contacto = $tipo_contacto ";
} elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $estado_origen == "" and $municipio_origen == "" and  $estado_destino == "" and $municipio_destino == "" and $idcontacto == "" and $iddepartamento != "" and $idcatalogo_orden_logistica == "" and $vin_herramienta == "") {
	#8 ----------Consulta | Departamento
	$num_query = "8";
	$query_logistica = "SELECT * FROM orden_logistica where iddepartamento == '$iddepartamento' ";
} elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $estado_origen == "" and $municipio_origen == "" and  $estado_destino == "" and $municipio_destino == "" and $idcontacto == "" and $iddepartamento == "" and $idcatalogo_orden_logistica == "" and $vin_herramienta == "") {
	#9 ----------Consulta | Tipo orden
	$num_query = "9";
	$query_logistica = "SELECT * FROM orden_logistica where idcatalogo_orden_logistica = '$idcatalogo_orden_logistica' ";
} /*elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $estado_origen == "" and $municipio_origen == "" and  $estado_destino == "" and $municipio_destino == "" and $idcontacto == "" and $iddepartamento == "" and $idcatalogo_orden_logistica == "" and $vin_herramienta != "") {
#10 ----------Consulta |
	$num_query = "10"; 

} elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $estado_origen == "" and $municipio_origen == "" and  $estado_destino == "" and $municipio_destino == "" and $idcontacto == "" and $iddepartamento == "" and $idcatalogo_orden_logistica == "" and $vin_herramienta != "") {
#11 ----------Consulta |
	$num_query = ""; 
	$query_logistica = "SELECT * FROM orden_logistica where  ";

} elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $estado_origen == "" and $municipio_origen == "" and  $estado_destino == "" and $municipio_destino == "" and $idcontacto == "" and $iddepartamento == "" and $idcatalogo_orden_logistica == "" and $vin_herramienta == "") {
# ----------Consulta |
	$num_query = ""; 
	$query_logistica = "SELECT * FROM orden_logistica where  ";

} elseif ($idlogistica == "" and $fecha_a == "" and $fecha_b == "" and $estado_origen == "" and $municipio_origen == "" and  $estado_destino == "" and $municipio_destino == "" and $idcontacto == "" and $iddepartamento == "" and $idcatalogo_orden_logistica == "" and $vin_herramienta == "") {
# ----------Consulta |
	$num_query = ""; 
	$query_logistica = "SELECT * FROM orden_logistica where  ";

}*/ else {
	# ----------Consulta | General	
	$query_logistica = "SELECT * FROM orden_logistica";
}


$result_logistica = mysql_query($query_logistica);

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
<th>Estatus</th>
<th>Fecha</th>
<th>VIN</th>
<th>Acompañantes</th>
<th>Referencia</th>
</tr>
</thead>
<tbody>
";



while ($row_logistica = mysql_fetch_array($result_logistica)) {

	#-------------------------------------------ID Logistica--------------------------------------------------------------------------------
	$idorden_logistica_enriptado = base64_encode($row_logistica[idorden_logistica]);
	$link = " <a href='orden_logistica_detalles.php?idib=$idorden_logistica_enriptado' target='_BLANK'>$row_logistica[idorden_logistica]</a>";
	#-------------------------------------------ID departamento--------------------------------------------------------------------------------
	$ver_departamento = DepartamentoName($row_logistica[iddepartamento]);

	#-------------------------------------------Tipo orden--------------------------------------------------------------------------------
	$ver_torden = OrdenName($row_logistica[idcatalogo_orden_logistica]);

	#-------------------------------------------ID--------------------------------------------------------------------------------

	$buscar_id = nombres_datos($row_logistica[idcontacto], $row_logistica[tipo_contacto]);
	$porciones_id = explode("|", $buscar_id);
	$nombre_id = $porciones_id[10];
	#-------------------------------------------Solicitante--------------------------------------------------------------------------------

	$buscar_solicitante = nombres_datos($row_logistica[idsolicitante], $row_logistica[tipo_solicitante]);
	$porciones_solicitante = explode("|", $buscar_solicitante);
	$nombre_solicitante = $porciones_solicitante[2];

	#-------------------------------------------F. Informacion--------------------------------------------------------------------------------
	$buscar_finformacion = nombres_datos($row_logistica[idfuente_inf], $row_logistica[tipo_fuente_inf]);
	$porciones_finformacion = explode("|", $buscar_finformacion);
	$nombre_fuente_inf = $porciones_finformacion[2];

	#-------------------------------------------Trasladista--------------------------------------------------------------------------------

	$buscar_trasladista = nombres_datos($row_logistica[idasigna], $row_logistica[tipo_asignante]);
	$porciones_trasladista = explode("|", $buscar_trasladista);
	$nombre_asignante = (trim($row_logistica[tipo_asignante]) == "Colaborador") ? $porciones_trasladista[2] : $porciones_trasladista[10];



	#-------------------------------------------Estatus Logisca--------------------------------------------------------------------------------

	$estatus_principal = EstatusPrincipalLogistica($row_logistica[idorden_logistica]);
	$mostrar_vin = searchVIN($row_logistica[idorden_logistica]);
	$mostrar_ayudante = searchAyudante($row_logistica[idorden_logistica]);

	$recibir_fecha = date_create($row_logistica[fecha_solicitud]);
	$fecha_solicitud = date_format($recibir_fecha, "d-m-Y");


	$mensaje .= "<tr>
	<td>$link</td>
	<td>$ver_departamento</td>
	<td>$ver_torden</td>
	<td>$row_logistica[municipio_origen], $row_logistica[estado_origen]</td>
	<td>$row_logistica[municipio_destino], $row_logistica[estado_destino]</td>
	<td>$nombre_id</td>
	<td>$nombre_solicitante</td>
	<td>$nombre_fuente_inf</td>
	<td>$nombre_asignante</td>
	<td>$estatus_principal</td>
	<td>$fecha_solicitud</td>
	<td>$mostrar_vin</td>
	<td>$mostrar_ayudante</td>
	<td>$num_query</td>
	</tr>";
}


$mensaje .= "
</tbody>
</table>
</div>
</div>";


#-------------------------------------------Funcion VIN--------------------------------------------------------------------------------

function searchVIN($id_logistica_vin)
{
	$id_logistica_vin = trim($id_logistica_vin);

	$mostrar_unidad = "";

	$query_busqueda_vin = "SELECT * FROM orden_logistica_unidades WHERE visible = 'SI' and idorden_logistica = '$id_logistica_vin' ";
	$result_busqueda_vin = mysql_query($query_busqueda_vin);

	if (mysql_num_rows($result_busqueda_vin) == 0) {

		$mostrar_unidad .= "Pendiente";
	} elseif (mysql_num_rows($result_busqueda_vin) == 1) {

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
	} else {

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


#-------------------------------------------Extraer Ayudante--------------------------------------------------------------------------------

function searchAyudante($id_logistica_ayudante)
{

	$id_logistica_ayudante = trim($id_logistica_ayudante);

	$query_ayudante = "SELECT * FROM orden_logistica_ayudante where visible = 'SI' and idorden_logistica = '$id_logistica_ayudante'";
	$result_ayudante = mysql_query($query_ayudante);

	if (mysql_num_rows($result_ayudante) == 0) {

		$ver_ayudantes = "N/A";
	} else if (mysql_num_rows($result_ayudante) == 1) {

		while ($row_ayudante = mysql_fetch_array($result_ayudante)) {

			$buscar_ayudante = nombres_datos(trim($row_ayudante[id_colaborador_proveedor]), trim($row_ayudante[tipo]));

			$porciones_ayudante = explode("|", $buscar_ayudante);
			$ver_ayudantes .= (trim($row_ayudante[tipo]) == "Colaborador") ? $porciones_ayudante[2] : $porciones_ayudante[10];
		}
	} else {

		while ($row_ayudante = mysql_fetch_array($result_ayudante)) {

			$buscar_ayudante = nombres_datos(trim($row_ayudante[id_colaborador_proveedor]), trim($row_ayudante[tipo]));

			$porciones_ayudante = explode("|", $buscar_ayudante);
			$ver_ayudantes .= $porciones_ayudante[2] . "<hr>";
			$ver_ayudantes .= (trim($row_ayudante[tipo]) == "Colaborador") ? $porciones_ayudante[2] . "<hr>" : $porciones_ayudante[10] . "<hr>";
		}
	}
	return $ver_ayudantes;
}



echo $mensaje;
?>