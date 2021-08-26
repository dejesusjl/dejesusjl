<?php 
session_start();  
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);

?>
<script>
	$(document).ready(function() {
		$('#table_electronic_card').DataTable({

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

		var table = $('#table_electronic_card').DataTable();

		table
		.order([ 0, 'asc' ])
		.draw();


	});

	
</script>



<?php 

#------------------------------- Tipo Crud ------

$tipo_crud = trim($_POST['tipo_crud']);

#------------------------------- READ ------

$tipo_tabla = trim($_POST['tipo_tabla_card']);

if ($tipo_crud == "Read") {

	$mensaje .= "
	<div class='container-bg-1 p-3'>
	<div class='table-responsive'>
	<table class='table table-striped table-bordered table-hover panel-body-center-table' id='table_electronic_card' style='width: 100%;'>
	<thead>
	<tr>
	<th>#</th>
	<th>Responsable</th>
	<th>Tarjeta</th>
	<th>Tipo</th>
	<th>Número de Tarjeta</th>
	<th>NIP</th>
	<th>Fecha</th>
	<th>CVV</th>
	<th>Acciones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	";

	if ($tipo_tabla == "Activos" || $tipo_tabla == "Eliminados" || $tipo_tabla == "ALL") {
		
		if ($tipo_tabla == "Activos") {

			$query_tarjeta = "SELECT * FROM catalogo_monederos_electronicos WHERE visible = 'SI' ORDER BY nombre_tarjeta ASC,idcatalogo_monederos_electronicos DESC";
			$mensaje .= CatalogoMonederoelectronico ($query_tarjeta);

		}else if ($tipo_tabla == "Eliminados") {

			$query_tarjeta = "SELECT * FROM catalogo_monederos_electronicos WHERE visible = 'NO' ORDER BY nombre_tarjeta ASC,idcatalogo_monederos_electronicos DESC";
			$mensaje .= CatalogoMonederoelectronico ($query_tarjeta);

		}else if ($tipo_tabla == "ALL") {

			$query_tarjeta = "SELECT * FROM catalogo_monederos_electronicos ORDER BY idcatalogo_monederos_electronicos DESC";
			$mensaje .= CatalogoMonederoelectronico ($query_tarjeta);

		}else {

			$query_tarjeta = "";
			$mensaje .= CatalogoMonederoelectronico ($query_tarjeta);
		}

	}else {

		$query_tipo_card = "SELECT tipo FROM catalogo_monederos_electronicos GROUP BY tipo";
		$result_tipo_card = mysql_query($query_tipo_card);

		while ($row_tipo_card = mysql_fetch_array($result_tipo_card)) {

			$tipo_si = "$row_tipo_card[tipo]SI";
			$tipo_no = "$row_tipo_card[tipo]NO";
			$tipo_all = "$row_tipo_card[tipo]ALL";

			if ($tipo_tabla == $tipo_si) {

				$query_tarjeta = "SELECT * FROM catalogo_monederos_electronicos WHERE visible = 'SI' AND tipo = '$row_tipo_card[tipo]' ORDER BY nombre_tarjeta ASC,idcatalogo_monederos_electronicos DESC";
				$mensaje .= CatalogoMonederoelectronico ($query_tarjeta);

			}else if ($tipo_tabla == $tipo_no) {
				
				$query_tarjeta = "SELECT * FROM catalogo_monederos_electronicos WHERE visible = 'NO' AND tipo = '$row_tipo_card[tipo]' ORDER BY nombre_tarjeta ASC,idcatalogo_monederos_electronicos DESC";
				$mensaje .= CatalogoMonederoelectronico ($query_tarjeta);

			}elseif ($tipo_tabla == $tipo_all) {

				$query_tarjeta = "SELECT * FROM catalogo_monederos_electronicos WHERE tipo = '$row_tipo_card[tipo]' ORDER BY idcatalogo_monederos_electronicos DESC";
				$mensaje .= CatalogoMonederoelectronico ($query_tarjeta);
				
			}else {

				$query_tarjeta = "";
				$mensaje .= CatalogoMonederoelectronico ($query_tarjeta);
			}
		}

		$query_name_card = "SELECT nombre_tarjeta FROM catalogo_monederos_electronicos GROUP BY nombre_tarjeta";
		$result_name_card = mysql_query($query_name_card);

		while ($row_name_card = mysql_fetch_array($result_name_card)) {

			$name_si = "$row_name_card[nombre_tarjeta]SI";
			$name_no = "$row_name_card[nombre_tarjeta]NO";
			$name_all = "$row_name_card[nombre_tarjeta]ALL";

			if ($tipo_tabla == $name_si) {

				$query_tarjeta = "SELECT * FROM catalogo_monederos_electronicos WHERE visible = 'SI' AND nombre_tarjeta = '$row_name_card[nombre_tarjeta]' ORDER BY nombre_tarjeta ASC,idcatalogo_monederos_electronicos DESC";
				$mensaje .= CatalogoMonederoelectronico ($query_tarjeta);

			}else if ($tipo_tabla == $name_no) {

				$query_tarjeta = "SELECT * FROM catalogo_monederos_electronicos WHERE visible = 'NO' AND nombre_tarjeta = '$row_name_card[nombre_tarjeta]' ORDER BY nombre_tarjeta ASC,idcatalogo_monederos_electronicos DESC";
				$mensaje .= CatalogoMonederoelectronico ($query_tarjeta);

			}elseif ($tipo_tabla == $name_all) {

				$query_tarjeta = "SELECT * FROM catalogo_monederos_electronicos WHERE nombre_tarjeta = '$row_name_card[nombre_tarjeta]' ORDER BY idcatalogo_monederos_electronicos DESC";
				$mensaje .= CatalogoMonederoelectronico ($query_tarjeta);

			}else {

				$query_tarjeta = "";
				$mensaje .= CatalogoMonederoelectronico ($query_tarjeta);
			}
		}
	}





	




}


$mensaje.="
</tbody>
</table>
</div>
</div>";

function CatalogoMonederoelectronico ($query_tarjeta) {

	$result_tarjeta = mysql_query($query_tarjeta);

	$num = 0;

	while ($row_tarjeta = mysql_fetch_array($result_tarjeta)) {

		#------------------------------------------- Increment ------------------------------------------------------------------------------

		$idcatalogo_monederos_electronicos_encriptada = base64_encode(trim($row_tarjeta[idcatalogo_monederos_electronicos]));

		#------------------------------------------- Increment ------------------------------------------------------------------------------

		$num ++;

		#------------------------------------------- Nombre Responsable --------------------------------------------------------------------------------

		if (trim($row_tarjeta[idempleados]) == "" || trim($row_tarjeta[idempleados]) == null || trim($row_tarjeta[idempleados]) == "N/A") {

			$nomenclatura_responsable_tarjeta = "N/A";

		}elseif (is_numeric($row_tarjeta[idempleados])) {

			$buscar_responsable = explode("|", nombres_datos($row_tarjeta[idempleados], "Colaborador"));
			$nomenclatura_responsable_tarjeta = "$buscar_responsable[10] - $buscar_responsable[2]";

		}else{

			$nomenclatura_responsable_tarjeta = $row_tarjeta[idempleados];

		}

		#------------------------------------------- Espacio --------------------------------------------------------------------------------

		$espacio = '<i class="fas fa-minus fa-rotate-90 fa-3x"></i>';

		#------------------------------------------- numero Tarjeta --------------------------------------------------------------------------------

		$num_tarjeta = chunk_split($row_tarjeta[no_tarjeta],4," ");
		$btnCopiar='<span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Copiar Número de tarjeta"><i class="far fa-copy fa-2x" aria-hidden="true" id="copy_info" onclick="copiar_info('.$row_tarjeta[no_tarjeta].');" ></i></span>';

		#------------------------------------------- Carta responsiva --------------------------------------------------------------------------------

		$carta = "<a href='carta_responsiva_pdf.php?card=$idcatalogo_monederos_electronicos_encriptada' target='_blank' data-bs-toggle='tooltip' title='Ver Carta Responsiva'><i class='fa fa-file-pdf-o fa-2x' aria-hidden='true'></i></a>$espacio";

		#------------------------------------------- Evidencia --------------------------------------------------------------------------------

		$evidencia = (file_exists($row_tarjeta[columna_b])) ? "<a href='$row_tarjeta[columna_b]' target='_blank' data-bs-toggle='tooltip' title='Visualizar Evidencia'><i class='fas fa-image fa-2x' aria-hidden='true'></i></a>$espacio" : "";
		$si_no_evidencia = (file_exists($row_tarjeta[columna_b])) ? "SI" : "NO";

		#------------------------------------------- Eliminar Visualizan Movimiento --------------------------------------------------------------------------------

		$activar_eliminar_movimiento = ($row_tarjeta[visible] == 'SI') ? "
		<i class='far fa-eye fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Eliminar Tarjeta' onclick=\"ActionsModalWallet('Delete|$idcatalogo_monederos_electronicos_encriptada|$num_tarjeta|$row_tarjeta[nombre_tarjeta]|NO');\"></i>$espacio" : "<i class='far fa-eye-slash fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Activar Tarjeta' onclick=\"ActionsModalWallet('Delete|$idcatalogo_monederos_electronicos_encriptada|$num_tarjeta|$row_tarjeta[nombre_tarjeta]|SI');\"></i>$espacio";

		#------------------------------------------- Editar Tarjeta --------------------------------------------------------------------------------

		$editar_tarjeta = "<i class='fas fa-edit fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Actualizar Datos' onclick=\"ActionsModalWallet('Update|$idcatalogo_monederos_electronicos_encriptada|$num_tarjeta|$nomenclatura_responsable_tarjeta|$row_tarjeta[nombre_tarjeta]|$row_tarjeta[tipo]|$row_tarjeta[nip]|$row_tarjeta[columna_a]|$row_tarjeta[columna_c]|$si_no_evidencia|$row_tarjeta[idempleados]');\"></i>$espacio";

		#------------------------------------------- Info DB --------------------------------------------------------------------------------

		$info_db = "<i class='fas fa-info-circle fa-2x' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Info Tarjeta' onclick=\"ActionsModalWallet('InfoB|$idcatalogo_monederos_electronicos_encriptada|$num_tarjeta|$row_tarjeta[no_tarjeta]');\"></i>$espacio";

		#------------------------------------------- Acciones DB --------------------------------------------------------------------------------

		$acciones = ($row_tarjeta[visible] == 'SI') ? "$carta $evidencia $activar_eliminar_movimiento $info_db $editar_tarjeta" : "$activar_eliminar_movimiento $info_db" ;




		$fila_tarjeta .= "<tr>
		<td>$num</td>
		<td>$nomenclatura_responsable_tarjeta</td>
		<td>$row_tarjeta[nombre_tarjeta]</td>
		<td>$row_tarjeta[tipo]</td>
		<td>$num_tarjeta <hr> $row_tarjeta[no_tarjeta] <hr> <center>$btnCopiar</center></td>
		<td>$row_tarjeta[nip]</td>
		<td>$row_tarjeta[columna_a]</td>
		<td>$row_tarjeta[columna_c]</td>
		<td>$acciones</td>
		</tr>";


	}

	return $fila_tarjeta;
}


echo $mensaje;
?>