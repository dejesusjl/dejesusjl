
<?php 
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";

date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s"); 
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];

$idlogistica = $_REQUEST['idlogistica'];
$idcolaborador = $_REQUEST['idcolaborador'];

$idlogistica = trim($idlogistica);
$idcolaborador = trim($idcolaborador);


$concepto = $_REQUEST['concepto'];
$idcatalogo_provedores = $_REQUEST['idcatalogo_provedores'];
$responsable = $_REQUEST['responsable'];
$idcatalogo_departamento = $_REQUEST['idcatalogo_departamento'];
$estatus = "Aprobado";
$idfoliogo = "";
$apartado_usado = $_REQUEST['apartado_usado'];
$tipo_movimiento = "cargo";
$efecto_movimiento = "suma";
$fecha_movimiento = $_REQUEST['fecha_movimiento'];
$metodo_pago = "1";
$saldo_anterior = "0";
$saldo = $_REQUEST['gran_total'];
$monto_precio = $_REQUEST['gran_total'];
$serie_monto = "1/1";
$monto_total = $_REQUEST['gran_total'];
$tipo_moneda = "MXN";
$tipo_cambio = "1";
$gran_total = $_REQUEST['gran_total'];
$cargo = $_REQUEST['gran_total'];
$abono = $_REQUEST['abono'];
$emisora_institucion = $_REQUEST['emisora_institucion'];
$emisora_agente = $_REQUEST['emisora_agente'];
$receptora_institucion = $_REQUEST['receptora_institucion'];
$receptora_agente = $_REQUEST['receptora_agente'];
$tipo_comprobante = "N/A";
$referencia = $_REQUEST['referencia'];
$datos_vin = $_REQUEST['datos_vin'];
$archivo = "Pendiente";
$comentarios = $_REQUEST['comentarios'];
$idauxiliar_principales = "6";
$comision = "N/A";
$columna1 = $_REQUEST['columna1'];
$columna2 = $_REQUEST['columna2'];
$columna3 = $_REQUEST['columna3'];
$columna5 = "Auxiliares";
$columna6 = $_REQUEST['columna6'];
$columna7 = $_REQUEST['columna7'];
$columna8 = $_REQUEST['columna8'];
$columna9 = $_REQUEST['columna9'];
$columna10 = $_REQUEST['columna10'];
$factura = $_REQUEST['referencia'];
$datos_estatus = "Pendiente";
$usuario = $_REQUEST['usuario'];
/*$fecha = $_REQUEST['fecha'];*/
$visible = "SI";
$comentarios_eliminacion = $_REQUEST['comentarios_eliminacion'];
$usuario_elimino = $_REQUEST['usuario_elimino'];
/*$fecha_eliminacion = $_REQUEST['fecha_eliminacion'];*/

$fecha_creacion = $_REQUEST['fecha_creacion'];

$id_movimientos = $_REQUEST['id_movimientos'];
$idlogistica_encriptada = $_REQUEST['pasar_logistica'];
$idlogistica = base64_decode($idlogistica_encriptada);

$query_repetido = "SELECT * FROM estado_cuenta_requisicion WHERE concepto = '$concepto' and fecha_creacion = '$fecha_creacion' and visible = 'SI' ";
$result_repetido = mysql_query($query_repetido);

$result_auxiliares = "";
$result_balance = "";

#bloqueo
#$result_repetido = 0;

if (mysql_num_rows($result_repetido) == 0) {

	$apartado_usado = mb_strtolower($apartado_usado);
	$apartado_usado = ucfirst($apartado_usado);
	
	$query_insert_requisicion = "INSERT INTO estado_cuenta_requisicion (concepto, idcatalogo_provedores, responsable, idcatalogo_departamento, estatus, idfoliogo, apartado_usado, tipo_movimiento, efecto_movimiento, fecha_movimiento, metodo_pago, saldo_anterior, saldo, monto_precio, serie_monto, monto_total, tipo_moneda, tipo_cambio, gran_total, cargo, abono, emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, tipo_comprobante, referencia, datos_vin, archivo, comentarios, idauxiliar_principales, comision, columna1, columna2, columna3, columna5, columna6, columna7, columna8, columna9, columna10, factura, datos_estatus, usuario, visible, comentarios_eliminacion, usuario_elimino, usuario_creador, fecha_creacion, fecha_guardado) VALUES ('$concepto', '$idcatalogo_provedores', '$responsable', '$idcatalogo_departamento', '$estatus', '$idfoliogo', '$apartado_usado', '$tipo_movimiento', '$efecto_movimiento', '$fecha_movimiento', '$metodo_pago', '$saldo_anterior', '$saldo', '$monto_precio', '$serie_monto', '$monto_total', '$tipo_moneda', '$tipo_cambio', '$gran_total', '$cargo', '$abono', '$emisora_institucion', '$emisora_agente', '$receptora_institucion', '$receptora_agente', '$tipo_comprobante', '$referencia', '$datos_vin', '$archivo', '$comentarios', '$idauxiliar_principales', '$comision', '$columna1', '$columna2', '$columna3', '$columna5', '$columna6', '$columna7', '$columna8', '$columna9', '$columna10', '$factura', '$datos_estatus', '$usuario', '$visible', '$comentarios_eliminacion', '$usuario_elimino', '$usuario_creador', '$fecha_creacion', '$fecha_guardado') ";

	$result_insert_requisiscion = mysql_query($query_insert_requisicion);

}else {
	$result_insert_requisiscion = 0;
}

if ($result_insert_requisiscion == 1) {

	$recuperar_id = mysql_query("SELECT @@identity AS id");

	if ($row_id = mysql_fetch_row($recuperar_id)) {
		$idestado_cuenta_requisicion = trim($row_id[0]);

		$create_array_auxiliares = explode(",", $apartado_usado);

		foreach ($create_array_auxiliares as $key_auxiliares => $value_auxiliares) {

			$str = mb_strtolower($value_auxiliares);
			$nombre_auxiliar = ucfirst($str);

			$nombre_auxiliar = trim($nombre_auxiliar);

			if ($nombre_auxiliar != "") {

				$query_repetido_auxiliar = "SELECT * FROM auxiliares WHERE nombre = '$nombre_auxiliar' and fecha_creacion = '$fecha_creacion'";
				$result_repetido_auxiliar = mysql_query($query_repetido_auxiliar);

				if (mysql_num_rows($result_repetido_auxiliar) == 0) {

					$query_insert_auxiliares = "INSERT INTO auxiliares (nombre, nomenclatura, direccion, idauxiliar_principales, idfoliogo, idestado_cuenta_requisicion, visible, usuario_creador, fecha_creacion, fecha_guardado, fecha_movimiento_estado_cuenta_requisicion) VALUES ('$nombre_auxiliar', '', '', '6', '', '$idestado_cuenta_requisicion', 'SI', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$fecha_movimiento' ) ";
					$result_insert_auxiliares = mysql_query($query_insert_auxiliares);
					//echo "<br>";
					$result_auxiliares .= ($result_insert_auxiliares == 1) ? "1|" : "0|";

				}else {

					$result_auxiliares .= "0|";
				}
			}
		}

		$movimientos = explode("|", $id_movimientos);

		foreach ($movimientos as $key_balance => $value_valance) {
			$idbalance_gastos_operacion = trim($value_valance);

			if ($idbalance_gastos_operacion != "") {

				$query_update_balance = "UPDATE balance_gastos_operacion SET columna7 = 'Pagado', columna8 = '$idestado_cuenta_requisicion' where idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
				$result_balance_gastos = mysql_query($query_update_balance);

				$result_balance .= ($result_balance_gastos == 0) ? "0|" : "1|";

				$query_balance_id = "SELECT * FROM balance_gastos_operacion WHERE columna3 = '$idbalance_gastos_operacion'";
				$result_balance_id = mysql_query($query_balance_id);

				if (mysql_num_rows($result_balance_id)) {

					while ($row_balance_id = mysql_fetch_array($result_balance_id)) {

						$query_update_balance = "UPDATE balance_gastos_operacion SET columna7 = 'Pagado', columna8 = '$idestado_cuenta_requisicion' where idbalance_gastos_operacion = '$row_balance_id[idbalance_gastos_operacion]'";
						$result_balance_gastos = mysql_query($query_update_balance);
					}
				}
			}
		}
	}

}else {

	$result_principal = "Ocurrio un error al guardar el movimiento";	

}

# Tratar Resultados auxiliares

$error_auxiliar = "";
$tratar_auxiliares = explode("|", $result_auxiliares);

foreach ($tratar_auxiliares as $key_tratar_aux => $value_tratar_aux) {
	
	$value_tratar_aux = trim($value_tratar_aux);

	if ($value_tratar_aux != "") {
		
		$error_auxiliar .= ($value_tratar_aux == "0") ? "a" : "";
		
	}
}

$mensaje_auxiliar = ($error_auxiliar == "") ? "0" : "1";

# Tratar Resultados Balance

$error_balance = "";
$tratar_balance = explode("|", $result_auxiliares);

foreach ($tratar_balance as $key_tratar_balance => $value_tratar_balance) {

	$value_tratar_balance = trim($value_tratar_balance);

	if ($value_tratar_balance != "") {

		$error_balance .= ($value_tratar_balance == "0") ? "a" : "";

	}
}


$mensaje_balance = ($error_balance == "") ? "0" : "1";



$query_responsable_balance = "SELECT responsable FROM balance_gastos_operacion WHERE visible = 'SI' AND trim(columna2) = '$idlogistica' AND trim(tipo_movimiento) = 'cargo' AND trim(comision) = 'N/A' and (columna7 <> 'Pagado'  OR columna7 IS NULL) GROUP BY responsable";
$result_responsable_balance = mysql_query($query_responsable_balance);

$direccionador = (mysql_num_rows($result_responsable_balance) == 0) ? "orden_logistica_detalles.php?idib=$idlogistica_encriptada" : "pagar_caja_chica_auxiliar.php?idl=$idlogistica_encriptada";
$fail = "pagar_caja_chica_auxiliar.php?idl=$idlogistica_encriptada";


if ($result_principal == "Ocurrio un error al guardar el movimiento") {

	echo "
	<script language='javascript' type='text/javascript'>
	alert('Movimiento Duplicado');
	document.location.replace('$direccionador');
	</script>
	";

}else {

	if ($mensaje_auxiliar == "1" and $mensaje_balance == "1") {
		
		echo "
		<script language='javascript' type='text/javascript'>
		alert('Datos guardados correctamente');
		document.location.replace('$direccionador');
		</script>
		";

	}elseif ($mensaje_auxiliar == "1" and $mensaje_balance == "0") {

		echo "
		<script language='javascript' type='text/javascript'>
		alert('Error al actualizar los estatus en el balance de gastos');
		document.location.replace('$direccionador');
		</script>
		";

	}elseif ($mensaje_auxiliar == "0" and $mensaje_balance == "1") {

		echo "
		<script language='javascript' type='text/javascript'>
		alert('Error con los auxiliares');
		document.location.replace('$direccionador');
		</script>
		";

	}elseif ($mensaje_auxiliar == "0" and $mensaje_balance == "0") {
		
		echo "
		<script language='javascript' type='text/javascript'>
		alert('Error en auxiliares y  balance de gastos');
		document.location.replace('$direccionador');
		</script>
		";

	}else {
		
		echo "
		<script language='javascript' type='text/javascript'>
		alert('Adelante');
		document.location.replace('$direccionador');
		</script>
		";

	}
}



?>