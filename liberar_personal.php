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
	<title>CCP | Liberar Personal</title>

	<style>
		.red {
			background-color: #d1ecf1 !important;
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
								<strong>Liberar Personal</strong>
							</li>
						</ol>

						<br>
						
						<?php 
						date_default_timezone_set('America/Mexico_City');
						$fecha_creacion = date("Y-m-d H:i:s");
						?>


						<div class='d-flex justify-content-center align-items-center'>
							<div class='m-3 container-checks-1 d-flex flex-wrap'>
								<div class="mx-2 text-secundario-1">
									<i class='fas fa-filter'></i>
									<span><b>Puesto:</b></span>
								</div>
								<div class="mx-2 d-flex align-items-center">
									<input onchange='filterme()' type='checkbox' class='filtros' name='puesto_actual_colaborador' value='Ejecutivo de Traslado'>
									<span>Trasladistas</span>
								</div>
							</div>
						</div>


						<div class="container-bg-1 p-3">
							<div class="table-responsive">
								<table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="table_liberar_personal">
									<thead>
										<tr>
											<th>#</th>
											<th>Nombre Completo</th>                                        
											<th>Teléfono Empresa</th> 
											<th>No.Licencia</th>
											<th>Estatus</th> 
											<th>Acciones</th>
											<th>Última Logística</th>
											<th>Puesto</th>                                                    
										</tr>
									</thead>

									<tbody>  
										<?php 

										$sql = "SELECT * FROM empleados WHERE visible ='SI'";
										$result = mysql_query($sql);


										$ver_telefono="";

										while ($fila = mysql_fetch_array($result)) {


											$ide ="$fila[idempleados]";
											$idempleados = base64_encode("$fila[idempleados]");
											$telefono_empresa = "$fila[telefono_empresa]";
											$estatus = "$fila[columna_a]";
											$numero_licencia = "$fila[numero_licencia]";
											$nombre_completo = "$fila[nombre]"." "."$fila[apellido_paterno]"." "."$fila[apellido_materno]"." ($fila[columna_b])";

											if ($estatus == "Disponible") {

												$ver_estatus = "<td><i class='far fa-check-circle fa-2x'></i></td>";

											}elseif ($estatus == "En Ruta") {

												$ver_estatus = "<td><i class='fas fa-road fa-2x'></i></td>";  

											}elseif ($estatus == "Descanso") {

												$ver_estatus = "<td><i class='fas fa-bed fa-2x'></i></td>";

											}elseif ($estatus == "Permiso") {

												$ver_estatus = "<td><i class='far fa-stop-circle fa-2x'></i></td>";

											}else{
												$ver_estatus = "<td>$estatus</td>";
											}


											$query_logistica = "SELECT * FROM orden_logistica WHERE idasigna = '$ide' and tipo_asignante = 'Colaborador'";
											$result_logistica = mysql_query($query_logistica);

											if (mysql_num_rows($result_logistica) == 0) {
												$ultima_logistica = 0;
											}else{
												while ($row_logistica = mysql_fetch_array($result_logistica)) {
													$ultima_logistica = "$row_logistica[idorden_logistica]";
												}
											}



											$query_ayudantes = "SELECT * FROM orden_logistica_ayudante WHERE id_colaborador_proveedor = '$ide' and tipo = 'Colaborador' and visible = 'SI'";
											$result_ayudante = mysql_query($query_ayudantes);

											if (mysql_num_rows($result_ayudante) == 0) {
												$ultimo_ayudante = 0;
											}else{
												while ($row_ayudante = mysql_fetch_array($result_ayudante)) {
													$ultimo_ayudante = "$row_ayudante[idorden_logistica]";
												} 
											}



											$logistica_logistica_encriptada = base64_encode($ultima_logistica); 
											$logistica_ayudante_encriptada = base64_encode($ultimo_ayudante); 

											if ($ultima_logistica > $ultimo_ayudante) {
												$logistica_ultimo = "<td><a href='orden_logistica_detalles.php?idib=$logistica_logistica_encriptada' target='_blank'>$ultima_logistica</a></td>";
											}else{
												$logistica_ultimo = "<td><a href='orden_logistica_detalles.php?idib=$logistica_ayudante_encriptada' target='_blank'>$ultimo_ayudante</a></td>";
											}

											$tipo_vn_p = base64_encode("Personal");
											$liberar = "<td><a href='liberar_vin_personal.php?type_vn_per=$tipo_vn_p&vn_personal=$idempleados'><i class='fa fa-check fa-2x' aria-hidden='true'></i></a></td>";


											if ($telefono_empresa != " " && $telefono_empresa != NULL) {

												$ver_telefono = "<td><a title='Llamar' href='tel:+52$telefono_empresa' target='_blank'><i class='fa fa-mobile fa-2x'aria-hidden='true'></i></a>&nbsp;&nbsp;<a href='https://api.whatsapp.com/send?phone=521$telefono_empresa&text=' target='_blank'><img src='https://img.icons8.com/offices/30/000000/whatsapp.png' style='width:10%;'></a>
												</td>"; 
											}else{
												$ver_telefono = "<td>S/N</td>"; 
											}
											echo "<tr class='odd gradeX'>
											<td>$fila[idempleados]</td>
											<td>$nombre_completo</td>                    
											$ver_telefono
											<td>$numero_licencia</td>
											$ver_estatus
											$liberar
											$logistica_ultimo 
											<td>$fila[puesto_actual]</td>           
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
	$('#table_liberar_personal').DataTable({
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
	var table = $('#table_liberar_personal').DataTable();

	table
	.order([ 0, 'asc' ])
	.draw();
    // --------------------------------------
</script>


<script type="text/javascript">


	function filterme() {
		//build a regex filter string with an or(|) condition
		var types = $('input:checkbox[name="puesto_actual_colaborador"]:checked').map(function() {
			return '^' + this.value + '\$';
		}).get().join('|');
		//filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
		otable.fnFilter(types, 7, true, false, false, false);
	}

	$(function() {
		otable = $('#table_liberar_personal').dataTable();
	});        


</script>



</body>
</html>