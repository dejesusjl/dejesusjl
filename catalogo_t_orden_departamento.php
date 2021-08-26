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

	<link rel="stylesheet" href="./style2.css">
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

	<script src="./script.js"></script>
	<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
	<script src="../../js/jquery-1.10.2.js"></script>
	<script src="../../js/jquery-ui.js"></script>

  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
  -->
  

  <link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.css">
  <link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.date.css">
  <link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.time.css">
  <title>CCP | T. Orden Departamento </title>

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
								<a class="text-white" href="catalogo_t_orden_departamento_agregar.php">Agregar Tipo orden Departamento</b></a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li  class="active text-white">
								<strong>Resumen Tipo Orden Departamento</strong>
							</li>
						</ol>

						<br>



						<div class="table-responsive">
							<form action="index.php" method="POST">
								<table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="table_t_orden_departamento">
									<thead>
										<tr>
											<th>#</th>
											<th>Colaborador&nbsp;&nbsp;&nbsp;</th>
											<th>Departamento</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>  

										<?php
										$incrementar = 0;
										$query_colaborador_departamento = "SELECT 
										orden_logistica_tipo_orden_departamento.idorden_logistica_tipo_orden_departamento,
										catalogo_departamento.nombre AS name_departamento,
										orden_logistica_tipo_orden.nombre AS name_orden
										FROM
										orden_logistica_tipo_orden_departamento
										INNER JOIN
										orden_logistica_tipo_orden,
										catalogo_departamento
										WHERE
										orden_logistica_tipo_orden_departamento.idtipo_orden = orden_logistica_tipo_orden.idorden_logistica_tipo_orden
										AND orden_logistica_tipo_orden_departamento.iddepartamento = catalogo_departamento.idcatalogo_departamento
										AND orden_logistica_tipo_orden_departamento.visible = 'SI' ORDER BY name_departamento ASC;";
										$result_colaborador_departamento = mysql_query($query_colaborador_departamento);

										while ($row_colaborador_departamento = mysql_fetch_array($result_colaborador_departamento)) {
											
											$incrementar ++;
											echo "
											<tr>
											<td>$incrementar</td>
											<td>$row_colaborador_departamento[name_departamento]</td>
											<td>$row_colaborador_departamento[name_orden]</td>
											<td><input type='checkbox' name='id_orden_departamento[]' class='filtros' value='$row_colaborador_departamento[idorden_logistica_tipo_orden_departamento]' >
											</td>
											</tr>
											";
											
										}
										?> 


									</tbody >
								</table>
								<div class="col-sm-12">
									<center>
										<button class="btn-lg btn-primary" id="eliminar_movimientos" type="submit">Guardar</button>
									</center>
								</div>
							</form>
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
	
	$(document).ready(function() {

		$('#table_t_orden_departamento').DataTable({
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
			responsive: true,
			lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
			dom: 'Blfrtip',
			buttons: [
			'copy', 'excel'
			],

		});
		var table = $('#table_t_orden_departamento').DataTable();

		table
		.order([ 0, 'asc' ])
		.draw();
	});

</script>


</body>
</html>