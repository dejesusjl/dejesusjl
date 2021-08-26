<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$usuario_creador = $_SESSION['usuario_clave'];
$usuario_loguin = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
header("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

$random = rand(5, 15);

#------------------------------------------Se declara el array para los AUXILIARES---------------------------------------------------------------------------------

$concetrador_auxiliares = array();

#------------------------------------------Se Reciben Variable---------------------------------------------------------------------------------
//Inicia Auxiliar Principal
$id_aux_principal = trim($_POST['idauxiliar_principales']);

$ver_auxiliar_principal = aux_principal($id_aux_principal);
array_push($concetrador_auxiliares, $ver_auxiliar_principal);

$concepto = trim($_POST['concepto']);


$tipo_movimiento = trim($_POST['tipo_movimiento']);

$efecto_venta = trim($_POST['efecto_venta']);

$fecha_movimiento = trim($_POST['fecha_movimiento']);


// Inicia Proveedor
$idcompuesto_proveedor = $_POST['idcatalogo_provedores'];


$ver_proveedor = names_proveedores($idcompuesto_proveedor);
array_push($concetrador_auxiliares, $ver_proveedor);

//---- Inicia RESPONSABLE
$resp_balance_gastos = trim($_POST['resp_balance_gastos']);


$porciones_responsable = explode("|", $resp_balance_gastos);
$consultar_nombre = nombres_datos($porciones_responsable[0], $porciones_responsable[1]);
$porciones_nombre_responsable = explode("|", $consultar_nombre);


if ($porciones_responsable[1] == "Colaborador") {
	$ver_responsable = trim($porciones_nombre_responsable[2]);
	$id_responsable = trim($porciones_responsable[0]);
} else {
	$ver_responsable = $porciones_nombre_responsable[10];
	$id_responsable = $ver_responsable;
}


array_push($concetrador_auxiliares, $ver_responsable);


// Inician Auxiliares EXTRAS
$auxiliares = explode(",", $_POST['auxiliares']);

if (count($auxiliares) >= 1) {

	$ver_auxiliares = eliminar_repetidos($auxiliares);

	foreach ($ver_auxiliares as $new_auxs) {

		if ($new_auxs != "") {
			array_push($concetrador_auxiliares, trim($new_auxs));
		}
	}
}


// Inician Auxiliares EXTRAS
$auxiliares_balance_gastos = explode(",", $_POST['auxiliares_balance_gastos']);

if (count($auxiliares_balance_gastos) >= 1) {



	$ver_auxiliares_balance_gastos = eliminar_repetidos($auxiliares_balance_gastos);

	foreach ($ver_auxiliares_balance_gastos as $new_auxs_balance_gastos) {

		if ($new_auxs_balance_gastos != "") {
			array_push($concetrador_auxiliares, trim($new_auxs_balance_gastos));
		}
	}
}

// Inicia departamento
$departamento = trim($_POST['iddepartamento_balance']);


$ver_departamento = name_departamento($departamento);

array_push($concetrador_auxiliares, $ver_departamento);

$metodo_pago = trim($_POST['metodo_pago']);

$saldo_anterior = trim($_POST['saldo']);

$monto_precio = trim($_POST['monto_abono']);

$saldo = trim($_POST['saldo_nuevo']);



$tipo_moneda = trim($_POST['tipo_moneda1']);

$tipo_cambio = trim($_POST['tipo_cambio2']);

$gran_total = trim($_POST['monto_entrada']);

$cargo = $monto_precio;

$monto_total = $monto_precio;


// Inicia VIN
$vin_venta = trim($_POST['vin_venta']);


if ($vin_venta != "" and $vin_venta != "N/A") {

	$ver_vin = $vin_venta;
	array_push($concetrador_auxiliares, $vin_venta);
	array_push($concetrador_auxiliares, "COSTO TOTAL");
} else {
	$ver_vin = "N/A";
}


if (trim($_POST['number_card']) != "N/A" and trim($_POST['number_card']) != "") {

	$number_card = trim($_POST['number_card']);
	array_push($concetrador_auxiliares, $number_card);
} else {

	$number_card = "N/A";
}

// Inician agentes
$emisor_venta = trim($_POST['emisor_venta']);
$agente_emisor_venta = trim($_POST['agente_emisor_venta']);

$receptor_venta = trim($_POST['receptor_venta']);
$agente_receptor_venta = trim($_POST['agente_receptor_venta']);

if ($number_card != "N/A" and $number_card != "") {

	array_push($concetrador_auxiliares, $agente_emisor_venta);
	array_push($concetrador_auxiliares, $agente_receptor_venta);
} else {

	if ($tipo_movimiento == "cargo") {
		array_push($concetrador_auxiliares, $agente_emisor_venta);
	} else {
		array_push($concetrador_auxiliares, $agente_receptor_venta);
	}
}

$comprobante_venta = trim($_POST['comprobante_venta']);
$factura = trim($_POST['factura']);

//Inicia Referencia
$n_referencia_venta = trim($_POST['n_referencia_venta']);
array_push($concetrador_auxiliares, $n_referencia_venta);

$descripcion_venta = trim($_POST['descripcion_venta']);


$idlogistica_encriptada = trim($_POST['idorden_logistica_requisicion']);
$idlogistica = base64_decode($idlogistica_encriptada);
$fecha_creacion = trim($_POST['fecha_creacion_balance']);


$abono_automatico = trim($_POST['abono_automatico']);
$recibo_automatico = trim($_POST['recibo_automatico']);

$archivo = "Pendiente";

//Inicia Combustible

$columna5 = trim($_POST['precio_unitario']);
$columna6 = trim($_POST['total_litros']);

#------------------------------------------Preparamos el array de auxiliares-------------------------------------------------------------------------------------------------------------------------------------------------

$insert_auxiliares = eliminar_repetidos($concetrador_auxiliares);
$var_auxiliares_nuevos = array();

foreach ($insert_auxiliares as $key_new => $concatenar_nuevo) {

	if ($concatenar_nuevo != "") {
		array_push($var_auxiliares_nuevos, $concatenar_nuevo . ",");
	}
}

$ver_auxiliares_general = implode($var_auxiliares_nuevos);

#------------------------------------------ Parametros Archivos --------------------------------------------------------------------------------------------------------------------------------------------------

$idorden_logistica_combustible_archivo = $_POST['idorden_logistica_combustible_archivo'];

#------------------------------------------Inician las funciones--------------------------------------------------------------------------------------------------------------------------------------------------



$consulta_existente = consultar_repetido($usuario_creador, $fecha_creacion, $idlogistica, $concepto);
//$consulta_existente = 0;
if ($consulta_existente == 1) {

	if ($tipo_movimiento == "cargo") {

		$balance_gastos_operacion_cargo = BalanceGastosCargo($concepto, $idcompuesto_proveedor, $id_responsable, $departamento, "Solicitud", $ver_auxiliares_general, $tipo_movimiento, $efecto_venta, $fecha_movimiento, $metodo_pago, $saldo_anterior, $saldo, $monto_precio, $monto_total, $tipo_moneda, $tipo_cambio, $gran_total, $cargo, $emisor_venta, $agente_emisor_venta, $receptor_venta, $agente_receptor_venta, $comprobante_venta, $n_referencia_venta, $ver_vin, $archivo, $descripcion_venta, $id_aux_principal, $number_card, $idlogistica, $factura, "SI", $usuario_creador, $fecha_creacion, $fecha_guardado, $abono_automatico, $recibo_automatico, $columna5, $columna6, $idorden_logistica_combustible_archivo);

		if ($balance_gastos_operacion_cargo == 1) {

			$ver_errores = 1;
		} else {

			$ver_errores = $balance_gastos_operacion_cargo;
		}
	} else if ($tipo_movimiento == "abono") {

		$balance_gastos_operacion_abono = BalanceGastosAbono($concepto, $idcompuesto_proveedor, $id_responsable, $departamento, "Solicitud", $ver_auxiliares_general, $tipo_movimiento, $efecto_venta, $fecha_movimiento, $metodo_pago, $saldo, $monto_precio, $monto_total, $tipo_moneda, $tipo_cambio, $gran_total, $cargo, $emisor_venta, $agente_emisor_venta, $receptor_venta, $agente_receptor_venta, $comprobante_venta, $n_referencia_venta, $ver_vin, $archivo, $descripcion_venta, $id_aux_principal, $number_card, $idlogistica, $factura, "SI", $usuario_creador, $fecha_creacion, $fecha_guardado, $columna1, $columna3, $abono_automatico, $recibo_automatico, $columna5, $columna6, $idorden_logistica_combustible_archivo);




		if ($balance_gastos_operacion_abono == 1) {

			$ver_errores = 1;
		} else {
			$ver_errores = $balance_gastos_operacion_abono;
		}
	}
} else {
	$ver_errores = "- El movimiento <b>$concepto</b> ya se encuentra cargado <br>";
}







echo "$ver_errores";





#-------------------------------------------departamento--------------------------------------------------------------------------------
$sqld = "SELECT * FROM catalogo_departamento WHERE idcatalogo_departamento = '$iddepartamento'";
$resultd = mysql_query($sqld);
while ($filad = mysql_fetch_array($resultd)) {
	$nombre_departamento = "$filad[nombre]";
	$id_departamento = "$filad[idcatalogo_departamento]";
}

$sql1 = "SELECT * FROM catalogo_orden_logistica WHERE idcatalogo_orden_logistica = '$idcatalogo_orden_logistica'";
$result1 = mysql_query($sql1);
while ($fila1 = mysql_fetch_array($result1)) {
	$nombre_orden = "$fila1[nombre_orden]";
}

#-------------------------------------------Funcion Proveedores--------------------------------------------------------------------------------

function names_proveedores($id_compuesto)
{

	$id_compuesto = trim($id_compuesto);

	$query_proveedor_compuesto = "SELECT * FROM proveedores WHERE trim(idprovedores_compuesto) = '$id_compuesto' ";
	$result_proveedor_compuesto = mysql_query($query_proveedor_compuesto);

	if (mysql_num_rows($result_proveedor_compuesto) >= 1) {

		while ($row_proveedor_compuesto = mysql_fetch_array($result_proveedor_compuesto)) {

			$nombre_compuesto = (trim($row_proveedor_compuesto[apellidos]) == "") ? trim($row_proveedor_compuesto[nombre]) : trim($row_proveedor_compuesto[nombre]) . " " . trim($row_proveedor_compuesto[apellidos]);
		}
	} else {

		$query_temporal_compuesto = "SELECT * FROM orden_logistica_proveedores WHERE trim(idprovedores_compuesto) = '$id_compuesto' ";
		$result_temporal_compuesto = mysql_query($query_temporal_compuesto);

		if (mysql_num_rows($result_temporal_compuesto) >= 1) {

			while ($row_temporal_compuesto = mysql_fetch_array($result_temporal_compuesto)) {

				$nombre_compuesto = (trim($row_temporal_compuesto[apellidos]) == "") ? trim($row_temporal_compuesto[nombre]) : trim($row_temporal_compuesto[nombre]) . " " . trim($row_temporal_compuesto[apellidos]);
			}
		} else {
			$nombre_compuesto = "";
		}
	}

	$nombre_compuesto = trim($nombre_compuesto);

	return $nombre_compuesto;
}


#-------------------------------------------Funcion Departamento--------------------------------------------------------------------------------

function name_departamento($search_id_departamento)
{



	$query_departamento_buscar = "SELECT * FROM catalogo_departamento WHERE trim(idcatalogo_departamento) = $search_id_departamento";
	$result_departamento_buscar = mysql_query($query_departamento_buscar);

	while ($row_departamento = mysql_fetch_array($result_departamento_buscar)) {
		$nombre_departamento = trim($row_departamento[nombre]);
	}

	return $nombre_departamento;
}

#-------------------------------------------Funcion Auxiliar Principal--------------------------------------------------------------------------------

function aux_principal($aux_principal)
{

	$query_aux_principal = "SELECT * FROM auxiliar_principales WHERE trim(idauxiliar_principales) = '$aux_principal'";
	$result_aux_principal = mysql_query($query_aux_principal);

	while ($row_aux_principal = mysql_fetch_array($result_aux_principal)) {

		$name_aux_principal = trim($row_aux_principal[concepto]);

		if ($name_aux_principal == "CCH Caja Chica" || $name_aux_principal == "CCH CAJA CHICA") {

			$name_aux_principal = "CAJA CHICA";
		} else {
			$name_aux_principal = $name_aux_principal;
		}
	}

	return trim($name_aux_principal);
}

#-------------------------------------------Funcion Auxiliares Extras--------------------------------------------------------------------------------

function eliminar_repetidos($array_entrada_repetidos)
{

	$array_trim_mayus = array();
	$exit_array = array();

	foreach ($array_entrada_repetidos as $indice => $valor_array) {

		if ($valor_array != "") {
			array_push($array_trim_mayus, trim($valor_array));
		}
	}

	$eliminar_duplicados = array_unique($array_trim_mayus);

	foreach ($eliminar_duplicados as $key_nuevo => $valor_nuevo_array) {

		if ($valor_nuevo_array != "") {
			array_push($exit_array, eliminar_tildes($valor_nuevo_array));
		}
	}


	return $exit_array;
}

#-------------------------------------------Funcion insertar CARGO--------------------------------------------------------------------------------
function BalanceGastosCargo($concepto, $idcatalogo_provedores, $responsable, $idcatalogo_departamento, $estatus, $apartado_usado, $tipo_movimiento, $efecto_movimiento, $fecha_movimiento, $metodo_pago, $saldo_anterior, $saldo, $monto_precio, $monto_total, $tipo_moneda, $tipo_cambio, $gran_total, $cargo, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia, $datos_vin, $archivo, $comentarios, $idauxiliar_principales, $comision, $columna2, $factura, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $abono_automatico, $recibo_automatico, $columna5, $columna6, $idorden_logistica_combustible_archivo)
{

	$insert_balance_cargo = "INSERT INTO balance_gastos_operacion (concepto, idcatalogo_provedores, responsable, idcatalogo_departamento, estatus, apartado_usado, tipo_movimiento, efecto_movimiento, fecha_movimiento, metodo_pago, saldo_anterior, saldo, monto_precio, monto_total, tipo_moneda, tipo_cambio, gran_total, cargo, emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, tipo_comprobante, referencia, datos_vin, archivo, comentarios, idauxiliar_principales, comision, columna2, factura, visible, usuario_creador, fecha_creacion, fecha_guardado, columna5, columna6, columna9) VALUES ('$concepto', '$idcatalogo_provedores', '$responsable', '$idcatalogo_departamento', '$estatus', '$apartado_usado', '$tipo_movimiento', '$efecto_movimiento', '$fecha_movimiento', '$metodo_pago', '$saldo_anterior', '$saldo', '$monto_precio', '$monto_total', '$tipo_moneda', '$tipo_cambio', '$gran_total', '$cargo', '$emisora_institucion', '$emisora_agente', '$receptora_institucion', '$receptora_agente', '$tipo_comprobante', '$referencia', '$datos_vin', '$archivo', '$comentarios', '$idauxiliar_principales', '$comision', '$columna2', '$factura', '$visible', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$columna5', '$columna6', '$idorden_logistica_combustible_archivo')";
	$result_balance_cargo = mysql_query($insert_balance_cargo);


	if ($result_balance_cargo == 1) {

		$query_cargo = mysql_query("SELECT @@identity AS id");
		if ($row_cargo = mysql_fetch_row($query_cargo)) {
			$idbalance_cargo = trim($row_cargo[0]);
		}

		// Insertamos los auxiliares del cargo
		$ver_cargo_insertar = explode(",", $apartado_usado);

		foreach ($ver_cargo_insertar as $key_inicial_cargo => $insert_aux_cargo) {

			if ($insert_aux_cargo != "") {

				$insert_cargo_auxiliares = InsertAuxiliares($insert_aux_cargo, $idauxiliar_principales, $idbalance_cargo, $fecha_movimiento, "SI", $usuario_creador, $fecha_creacion, $fecha_guardado);

				if ($insert_cargo_auxiliares != 1) {

					$respuesta_balance_cargo_insert .= $insert_cargo_auxiliares;
				}
			}
		}

		// Verificamos si viene por el procesador de archivo
		$actualizar_archivo_movimiento = ($idorden_logistica_combustible_archivo != "") ? ActualizarCombustible($columna2, $idorden_logistica_combustible_archivo) : "";


		if ($comision != "N/A") {

			$balance_gastos_operacion_abono = BalanceGastosAbono($concepto, $idcatalogo_provedores, $responsable, $idcatalogo_departamento, "Solicitud", $apartado_usado, "abono", "resta", $fecha_movimiento, $metodo_pago, $saldo, $monto_precio, $monto_total, $tipo_moneda, $tipo_cambio, $gran_total, $cargo, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia, $datos_vin, $archivo, $comentarios, $idauxiliar_principales, $comision, $columna2, $factura, "SI", $usuario_creador, $fecha_creacion, $fecha_guardado, "NO", $idbalance_cargo, $abono_automatico, $recibo_automatico, $columna5, $columna6, $idorden_logistica_combustible_archivo);

			$respuesta_balance_cargo = ($balance_gastos_operacion_abono == 1 and $respuesta_balance_cargo_insert == "") ? "1" : $balance_gastos_operacion_abono . $respuesta_balance_cargo_insert;
		} else {

			if ($abono_automatico == "SI") {

				$balance_gastos_operacion_abono = BalanceGastosAbono($concepto, $idcatalogo_provedores, $responsable, $idcatalogo_departamento, "Solicitud", $apartado_usado, "abono", "resta", $fecha_movimiento, $metodo_pago, $saldo, $monto_precio, $monto_total, $tipo_moneda, $tipo_cambio, $gran_total, $cargo, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia, $datos_vin, $archivo, $comentarios, $idauxiliar_principales, $comision, $columna2, $factura, "SI", $usuario_creador, $fecha_creacion, $fecha_guardado, "NO", $idbalance_cargo, $abono_automatico, $recibo_automatico, $columna5, $columna6, $idorden_logistica_combustible_archivo);

				$respuesta_balance_cargo = ($balance_gastos_operacion_abono == 1 and $respuesta_balance_cargo_insert == "") ? "1" : $balance_gastos_operacion_abono . $respuesta_balance_cargo_insert;
			} else {

				$respuesta_balance_cargo = ($respuesta_balance_cargo_insert == "") ? "1" : $respuesta_balance_cargo_insert;
			}
		}
	} else {

		$respuesta_balance_cargo = ($comision != "N/A" and $comision != "") ? "- Error al Insertar <b>CARGO</b> Y <b>ABONO</b><br>" : "- Error al Insertar <b>CARGO</b><br>";
	}

	return $respuesta_balance_cargo;
}


#-------------------------------------------Funcion insertar ABONO--------------------------------------------------------------------------------

function BalanceGastosAbono($concepto, $idcatalogo_provedores, $responsable, $idcatalogo_departamento, $estatus, $apartado_usado, $tipo_movimiento, $efecto_movimiento, $fecha_movimiento, $metodo_pago, $saldo, $monto_precio, $monto_total, $tipo_moneda, $tipo_cambio, $gran_total, $cargo, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia, $datos_vin, $archivo, $comentarios, $idauxiliar_principales, $comision, $columna2, $factura, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $columna1, $columna3, $abono_automatico, $recibo_automatico, $columna5, $columna6, $idorden_logistica_combustible_archivo)
{


	if (trim($comision) != "N/A") {

		$emisora_institucion_abono = $receptora_institucion;
		$emisora_agente_abono = $receptora_agente;
		$receptora_institucion_abono = $emisora_institucion;
		$receptora_agente_abono = $emisora_agente;

		$tipo_comprobante = $tipo_comprobante;
	} else {

		if ($abono_automatico == "SI") {

			$emisora_institucion_abono = $receptora_institucion;
			$emisora_agente_abono = $receptora_agente;
			$receptora_institucion_abono = $emisora_institucion;
			$receptora_agente_abono = $emisora_agente;

			$tipo_comprobante = "RECIBO AUTOMáTICO";
		} else {

			$emisora_institucion_abono = $emisora_institucion;
			$emisora_agente_abono = $emisora_agente;
			$receptora_institucion_abono = $receptora_institucion;
			$receptora_agente_abono = $receptora_agente;

			$tipo_comprobante = $tipo_comprobante;
		}
	}

	$insert_balance_abono = "INSERT INTO balance_gastos_operacion (concepto, idcatalogo_provedores, responsable, idcatalogo_departamento, estatus, apartado_usado, tipo_movimiento, efecto_movimiento, fecha_movimiento, metodo_pago, saldo_anterior, saldo, monto_precio, monto_total, tipo_moneda, tipo_cambio, gran_total, abono, emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, tipo_comprobante, referencia, datos_vin, archivo, comentarios, idauxiliar_principales, comision, columna2, factura, visible, usuario_creador, fecha_creacion, fecha_guardado, columna1, columna3, columna5, columna6, columna9) VALUES ('$concepto', '$idcatalogo_provedores', '$responsable', '$idcatalogo_departamento', '$estatus', '$apartado_usado', '$tipo_movimiento', '$efecto_movimiento', '$fecha_movimiento', '$metodo_pago', '$monto_precio', '$saldo', '$monto_precio', '$monto_total', '$tipo_moneda', '$tipo_cambio', '$gran_total', '$cargo', '$emisora_institucion_abono', '$emisora_agente_abono', '$receptora_institucion_abono', '$receptora_agente_abono', '$tipo_comprobante', '$referencia', '$datos_vin', '$archivo', '$comentarios', '$idauxiliar_principales', '$comision', '$columna2', '$factura', '$visible', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$columna1', '$columna3', '$columna5', '$columna6', '$idorden_logistica_combustible_archivo')";
	$result_balance_abono = mysql_query($insert_balance_abono);

	if ($result_balance_abono == 1) {

		$query_abono = mysql_query("SELECT @@identity AS id");
		if ($row_abono = mysql_fetch_row($query_abono)) {
			$idbalance_abono = trim($row_abono[0]);
		}

		$ver_abono_insertar = explode(",", $apartado_usado);

		foreach ($ver_abono_insertar as $key_inicial_cargo => $insert_aux_abono) {

			if ($insert_aux_abono != "") {

				$insert_cargo_auxiliares = InsertAuxiliares($insert_aux_abono, $idauxiliar_principales, $idbalance_abono, $fecha_movimiento, "SI", $usuario_creador, $fecha_creacion, $fecha_guardado);

				if ($insert_cargo_auxiliares != 1) {

					$respuesta_balance_abono_insert .= $insert_cargo_auxiliares;
				}
			}
		}

		$recibo_nombre_departamento = name_departamento($idcatalogo_departamento);


		$result_insert_recibo = (strtolower($tipo_comprobante) == "recibo automático" || $recibo_automatico == "SI") ? insert_recibo($fecha_movimiento, $monto_precio, $emisora_institucion_abono, $emisora_agente_abono, $receptora_institucion_abono, $receptora_agente_abono, $concepto, $metodo_pago, $referencia, $comentarios, $idbalance_abono, $metodo_pago, $idauxiliar_principales, $usuario_creador, $recibo_nombre_departamento, $fecha_guardado, $tipo_moneda, $tipo_cambio, $gran_total) : "1";


		if ($respuesta_balance_abono_insert == "" and $result_insert_recibo == 1) {

			$respuesta_balance_abono = 1;
		} else {
			$respuesta_balance_abono = $respuesta_balance_abono_insert;
		}
	} else {

		$respuesta_balance_abono = "-Error al Insertar <b>ABONO</b><br>";
	}

	return $respuesta_balance_abono;
}


#-------------------------------------------Funcion CONSULTA NO REPETIR--------------------------------------------------------------------------------

function consultar_repetido($usuario_creador, $fecha_creacion, $idlogistica, $concepto)
{

	$query_repetido = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and usuario_creador = '$usuario_creador' and fecha_creacion = '$fecha_creacion' and columna2 = '$idlogistica' and concepto = '$concepto' ";
	$result_repetido = mysql_query($query_repetido);

	return $respuesta_repetido = (mysql_num_rows($result_repetido) == 0) ? "1" : "- Ya existe este movimiento <br>";
}



#-------------------------------------------Funcion Insertar Auxiliares --------------------------------------------------------------------------------

function InsertAuxiliares($name_auxiliar, $id_aux_principal, $idbalance_gastos_operacion, $fecha_movimiento, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado)
{

	$query_auxiliares = "INSERT INTO balance_gastos_auxiliares (nombre, idauxiliar_principales, idlogistica, fecha_movimiento, visible, usuario_creador, fecha_creacion, fecha_guardado) VALUES ('$name_auxiliar','$id_aux_principal','$idbalance_gastos_operacion','$fecha_movimiento','$visible','$usuario_creador','$fecha_creacion','$fecha_guardado')";
	$result_auxiliares = mysql_query($query_auxiliares);

	return $respuesta_auxiliares = ($result_auxiliares == 1) ? "1" : "- Error al insertar el auxiliar <b>$name_auxiliar</b><br>";
}


#-------------------------------------------Funcion Insertar Recibos --------------------------------------------------------------------------------

function insert_recibo($fecha_movimiento, $monto_precio, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $concepto_principal, $metodo_pago, $referencia, $comentarios, $idbalance_abono, $idauxiliar_principales, $usuario_creador, $name_departamento, $fecha_guardado, $tipo_moneda, $tipo_cambio, $gran_total)
{

	$query_recibo = "INSERT INTO balance_gastos_recibos(fecha, monto, emisora_institucion, emisora_agente, receptora_institucion, receptora_agente, concepto, metodo_pago, referencia, comentarios, idbalance_gastos_operacion, id_tesoreria, idauxiliar_principales, usuario_creador, departamento, fecha_guardado, tipo_moneda, tipo_cambio, gran_total) VALUES ('$fecha_movimiento','$monto_precio','$emisora_institucion', '$emisora_agente', '$receptora_institucion', '$receptora_agente','$concepto_principal','$metodo_pago','$referencia','$comentarios','$idbalance_abono',' $metodo_pago','$idauxiliar_principales','$usuario_creador','$name_departamento','$fecha_guardado','$tipo_moneda','$tipo_cambio','$gran_total')";
	$result_recibo = mysql_query($query_recibo);

	return $respuesta_recibo = ($result_recibo == 1) ? "1" : "- Error al Generar el <b>Recibo</b><br>";
}

function ActualizarCombustible($idorden_logistica, $idorden_logistica_combustible_archivo)
{
	$idorden_logistica_combustible_archivo = trim($idorden_logistica_combustible_archivo);

	$update_combustible = "UPDATE orden_logistica_combustible SET idorden_logistica = '$idorden_logistica', estatus = 'Agregado' WHERE idorden_logistica_combustible = '$idorden_logistica_combustible_archivo'";
	$result_combustible = mysql_query($update_combustible);

	$resultado_update_combustible = ($result_combustible == 1) ? 1 : "- Error al actualizar la tabla de archivos<br>";

	return $resultado_update_combustible;
}
