<?php 
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado=date("Y-m-d H:i:s"); 
$usuario_creador=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);

$visible = "SI";


if(isset($_REQUEST['tarjeta'])){

	$idTarjeta=base64_decode($_REQUEST['tarjeta']);



	$No_tarjeta=$_REQUEST['No_tarjeta'];
	$nombre_tarjeta=$_REQUEST['nombre_tarjeta'];
	$responsable=$_REQUEST['responsable'];
	$fecha_creacion=$_REQUEST['fecha_creacion'];

	$target_path = "../../Balance_Gastos_Evidencia/";

	$target_path = $target_path."L"."$idTarjeta"."_Usr_".$usuario_creador."_".basename( $_FILES['uploadedfile']['name']);

	if ($target_path!="../../Balance_Gastos_Evidencia/") {


		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {

			$archivo_cargado=$target_path;

			$sql = "UPDATE catalogo_monederos_electronicos SET columna_b = '$archivo_cargado' WHERE idcatalogo_monederos_electronicos = '$idTarjeta';";
			$result = mysql_query($sql);

			if ($result == 1) {

				echo "
				<script language='javascript' type='text/javascript'>
				document.location.replace('electronic_card.php?tipo=success&mensaje=Guardado Exitosamente'); 
				</script>
				";

				$contenido='Se inserto evidencia <br /> Tarjeta: <b>'. $nombre_tarjeta.'</b> No: <b>'.chunk_split($No_tarjeta,4," ").'</b> <br />Responsable: <b>'.$responsable.'</b>';
				$movimiento='Evidencia';
				$evidencia=$archivo_cargado;
				$fecha_guardado=date("Y-m-d H:i:s");

				$sql2 = "INSERT INTO catalogo_monedero_electronico_bitacora (id_monedero_electronico, contenido, movimiento, evidencia, usuario_creador, fecha_creacion, fecha_guardado, visible) 
				VALUES ('$idTarjeta', '$contenido', '$movimiento', '$evidencia', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', 'SI');";

				$result2 = mysql_query($sql2);

				if ($result2 == 1) {      

					echo "
					<script>
					console.log('Se Creo Bitacora');
					</script>
					";     
				}else{      
					echo "
					<script>
					console.log('Error al crear Bitacora'+);
					</script>
					";
				}



			}else{
				echo "
				<script language='javascript' type='text/javascript'>
				document.location.replace('electronic_card.php?tipo=error&mensaje=Error al Guardar'); 
				</script>
				";
			}



		}

	}


}else{

	$idestado = base64_decode($_REQUEST['idestado']);
	$idorden_logistica = $_REQUEST['idlogistica'];
	$fecha_creacion = $_REQUEST['fecha_creacion'];
	$coordenadas = $_REQUEST['coordenadas'];
	$idorden_logistica = $_REQUEST['idlogistica'];
	$idorden_lo = base64_decode($idorden_logistica);

	$target_path = "../../Balance_Gastos_Evidencia/";

	$target_path = $target_path."L"."$idorden_lo"."_Usr_".$usuario_creador."_".basename( $_FILES['uploadedfile']['name']);

	if (is_dir("../../Balance_Gastos_Evidencia/")) {

		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {

			$archivo_cargado = $target_path;

			$query_bd_balance_gastos_operacion = "SELECT * FROM balance_gastos_operacion WHERE idbalance_gastos_operacion = '$idestado' ";
			$result_bd_balance_gastos_operacion = mysql_query($query_bd_balance_gastos_operacion);

			while ($row_bd_balance_gastos_operacion = mysql_fetch_array($result_bd_balance_gastos_operacion)) {

				if (file_exists($row_bd_balance_gastos_operacion[archivo])) {

					$evidencia_bd = "<a href=\'$row_bd_balance_gastos_operacion[archivo]\' target=\'_blank\'><i class=\'far fa-image fa-2x\'></i><a>";
					$evidencia_nueva = "<a href=\'$archivo_cargado\' target=\'_blank\'><i class=\'fas fa-image fa-2x\'></i><a>";

					$mesage_evidencia = "La evidencia cambio de: $evidencia_bd por $evidencia_nueva";	

				}else {

					$evidencia_nueva = "<a href=\'$archivo_cargado\' target=\'_blank\' ><i class=\'far fa-image fa-2x\'></i><a>";
					$mesage_evidencia = "Se agregó nueva evidencia: $evidencia_nueva";

				}
			}
			
			$sql = "UPDATE balance_gastos_operacion SET archivo = '$archivo_cargado' WHERE idbalance_gastos_operacion = '$idestado';";
			$result = mysql_query($sql);

			if ($result == 1) {

				$insert_bitacora_balance_image = BalanceInsertBitacora ($mesage_evidencia, "Evidencia", $idorden_lo, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "6", $idestado, $columna_d, $visible);


				echo "
				<script language='javascript' type='text/javascript'>
				alert('Datos Guardados Exitosamente');
				document.location.replace('orden_logistica_detalles.php?idib=$idorden_logistica'); 
				</script>
				";




			}else {

				echo "
				<script language='javascript' type='text/javascript'>
				alert('Intente Nuevamente');
				document.location.replace('orden_logistica_detalles.php?idib=$idorden_logistica'); 
				</script>
				";

			}

		}else {

			echo "
			<script language='javascript' type='text/javascript'>
			alert('Intente Nuevamente');
			document.location.replace('orden_logistica_detalles.php?idib=$idorden_logistica'); 
			</script>
			";
		}
	}




}


?>