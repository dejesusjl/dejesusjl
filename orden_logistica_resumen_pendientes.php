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

// Start Querys

#-------------------------------------------Funcion Nombres y Tipo--------------------------------------------------------------------------------

function nombres_datos($id_id, $type_type) {

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


?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="" >
	<meta name="author" content="">
	<meta name="keywords" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/quicksand.css">
	<link rel="stylesheet" href="../../assets/css/style.css">
	<link rel="stylesheet" href="../../assets/css/mod_style_datatables.css">
	<link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css">
	<link rel="stylesheet" href="../../assets/css/fontawesome.css">
	<link rel="stylesheet" href="../../assets/css/slick/slick.css">
	<link rel="stylesheet" href="../../assets/css/slick/slick-theme.css">
	<link rel="stylesheet" href="../../assets/css/fontawesome-stars.css">
	<link rel="stylesheet" href="../../assets/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../../assets/js/calendar/bootstrap_calendar.css">
	<link rel="apple-touch-icon" sizes="57x57" href="../../img/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="../../img/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../../img/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="../../img/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../../img/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="../../img/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="../../img/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="../../img/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="../../img/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="../../img/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../../img/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../../img/favicon/favicon-16x16.png">
	<link rel="manifest" href="../../img/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="../../img/favicon/ms-icon-144x144.png">

	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
	
	<!-- DataTables CSS -->
	<link href="../../plugins/datatables/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

	<!-- DataTables Responsive CSS -->
	<link href="../../plugins/datatables/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

	<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
	<script src="../../js/jquery-1.10.2.js"></script>
	<script src="../../js/jquery-ui.js"></script>

	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
	-->
	

	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.date.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.time.css">
	<title>CCP | Reporte Logísticas Programadas</title>

	<style>
		.dataTables_wrapper table#table_programadas tr.odd td{
			background: #0f4154;
		}
		.dataTables_wrapper .table#table_programadas td{
			background: #0f4154;
		}
		.dataTables_wrapper .table#table_programadas tr td{
			color: #FFFFFF;
		}
		.dataTables_wrapper .table#table_programadas tr:hover td{
			color: #212121;
		}
		.dataTables_wrapper table tr:hover td {
    		background: #E1E1E1 !important;
    		box-shadow: none;
		}
		#table_programadas tbody tr.red {
			background-color: #0f4154 !important;
		}

	</style>

</head>
<body>
	<div class="container-fluid p-0">
		<?php 
		include_once "menu.php"; 
		?>
		<div class="col-sm-9 col-xs-12 content pt-3 p-0">
			<div class="row mt-3 m-0">
				<div class="col-sm-12">
					<div class="mt-1 mb-3 p-3 button-container fondo-container">

						<ol class="breadcrumb fondo-encabezados">
							<li>
								<a class="text-white" href="index.php">Inicio</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li>
								<a class="text-white" href="agregar_orden_logistica.php">Generar Nueva Orden</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li>
								<a class="text-white" href="buscador_logistica.php">Resumen Orden Logistica General</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li class="active text-white">
								<strong>Resumen Ordenes Logística Programadas</strong>
							</li>
						</ol>

						<br>
						
						<?php 
						date_default_timezone_set('America/Mexico_City');
						$fecha_creacion = date("Y-m-d H:i:s");
						?>

						<div class="container-bg-1 p-3">
							<div class="table-responsive">
								<table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="table_programadas">
									<thead>
										<tr>
											<th>ID</th>
											<th>Origen</th>
											<th>Destino</th>
											<th>Cliente</th>
											<th>Solicitante</th>
											<th>F. Informante</th>
											<th>Trasladista</th>
											<th>Estatus</th>
											<th>Fecha y Hora Programada</th>                                                    
										</tr>
									</thead>

									<tbody>  

										<?php 

										$sql= "SELECT * FROM orden_logistica WHERE visible = 'SI' and (idasigna = '' || idasigna = NULL || idasigna = '0')";
										
										$result=mysql_query($sql);

										while ( $fila = mysql_fetch_array($result)) {
											setlocale(LC_TIME, 'es_CO.UTF-8');
											$f = date_create("$fila[fecha_programada]");

											
											$estatus = "$fila[estatus]";
											$fecha_programada = date_format($f,'Y-m-d H:i');
											$idlogistica_encriptada = base64_encode("$fila[idorden_logistica]");



#-------------------------------------------ID--------------------------------------------------------------------------------
											$buscar_id = nombres_datos($fila[idcontacto], $fila[tipo_contacto]);
											$porciones_id = explode("|", $buscar_id);
											$nombre_id = $porciones_id[10];
#-------------------------------------------Solicitante--------------------------------------------------------------------------------

											$buscar_solicitante = nombres_datos($fila[idsolicitante], $fila[tipo_solicitante]);
											$porciones_solicitante = explode("|", $buscar_solicitante);
											$nombre_solicitante = $porciones_solicitante[10];

#-------------------------------------------F. Informacion--------------------------------------------------------------------------------
											$buscar_finformacion = nombres_datos($fila[idfuente_inf], $fila[tipo_fuente_inf]);
											$porciones_finformacion = explode("|", $buscar_finformacion);
											$nombre_fuente_inf = $porciones_finformacion[10];

#-------------------------------------------Trasladista--------------------------------------------------------------------------------

											$buscar_trasladista = nombres_datos($fila[idasigna], $fila[tipo_asignante]);
											$porciones_trasladista = explode("|", $buscar_trasladista);
											$nombre_asignante = $porciones_trasladista[10];










											echo "<tr class='odd gradeX'>
											<td><a href='orden_logistica_detalles.php?idib=$idlogistica_encriptada' target='_blank'>$fila[idorden_logistica]</a></td>
											<td>$fila[municipio_origen]</td>
											<td>$fila[municipio_destino]</td>
											<td>$nombre_id</td>
											<td>$nombre_solicitante</td>
											<td>$nombre_fuente_inf</td>
											<td>$nombre_asignante</td>
											<td>$estatus</td>
											<td>$fecha_programada</td>
											</tr>";
										}
										?>     

									</tbody >
								</table>
							</div>
						</div>


					</div>


				</div>



			</div>

			<?php 
			include_once '../footer.php';
			?>

		</div>
	</div>
</div>
<script src="../../datapicker_moder/lib/compressed/picker.js"></script>
<script src="../../datapicker_moder/lib/compressed/picker.date.js"></script>
<script src="../../datapicker_moder/lib/compressed/picker.time.js"></script>
<script src="../../assets/js/popper.min.js"></script>
<!--Bootstrap-->
<script src="../../assets/js/bootstrap.min.js"></script>
<!--Sweet alert JS-->
<script src="../../assets/js/sweetalert.js"></script>
<!--Progressbar JS-->
<script src="../../assets/js/progressbar.min.js"></script>
<!--Charts-->
<!--Canvas JS-->
<script src="../../assets/js/charts/canvas.min.js"></script>
<!--Bootstrap Calendar JS-->
<script src="../../assets/js/calendar/bootstrap_calendar.js"></script>
<script src="../../assets/js/calendar/demo.js"></script>
<!--Bootstrap Calendar-->
<!--Datatable-->
<script src="../../assets/js/jquery.dataTables.min.js"></script>
<script src="../../assets/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables/datatables-responsive/dataTables.responsive.js?<?php echo $random; ?>"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script src="../../assets/js/custom.js"></script>

<script>
	$('#table_programadas').DataTable({
		language: {
			"decimal": "",
			"emptyTable": "No hay información",
			"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
			"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
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

		"createdRow": function( row, data, dataIndex ) {
			if ( data[6] == "Pendiente" ) {        
				$(row).addClass('red');

			}


		},

		responsive: true,
		lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
		dom: 'Blfrtip',
		buttons: [
		
		],

	});
	var table = $('#table_programadas').DataTable();

	table
	.order([ 0, 'desc' ])
	.draw();
    // --------------------------------------
</script>






</body>
</html>