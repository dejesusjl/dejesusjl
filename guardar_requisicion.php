<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
$usuario_creador = $_SESSION['usuario_clave'];
$usuario_creador = $usuario_creador;
$empleados = $_SESSION['empleados'];

$tipo_procesador = trim($_POST['tipo_procesador']);

$fecha_inicio = $_POST['fecha_inicio_prepocesar'];
$fecha_fin = $_POST['fecha_fin_prepocesar'];

// $tipo_procesador = "Combustible";

// $fecha_inicio = "2020-12-12";
// $fecha_fin = "2020-12-12";

if ($fecha_inicio == "" and $fecha_fin != "") {

	$fecha_a = $fecha_fin;
	$fecha_b = $fecha_fin;
} elseif ($fecha_inicio != "" and $fecha_fin == "") {

	$fecha_a = $fecha_inicio;
	$fecha_b = $fecha_inicio;
} elseif ($fecha_inicio != "" and $fecha_fin != "") {

	$fecha_a = $fecha_inicio;
	$fecha_b = $fecha_fin;
} elseif ($fecha_inicio == "" and $fecha_fin == "") {

	$fecha_a = date("Y-m-01");
	$fecha_b = date("Y-m-d");
}



if ($tipo_procesador == "Combustible") {

	// $query_update = mysql_query("SELECT * FROM orden_logistica_combustible where idorden_logistica <> '' || estatus <> 'Pendiente'");
	// while ($row = mysql_fetch_array($query_update)) {
	// 	$query_ok = mysql_query("UPDATE orden_logistica_combustible SET idorden_logistica = '', estatus = 'Pendiente' WHERE idorden_logistica = '$row[idorden_logistica]' ");
	// }

	echo ProcesarCombustible($fecha_a, $fecha_b);
	#
} elseif ($tipo_procesador == "Casetas") {

	// $query_update = mysql_query("SELECT * FROM orden_logistica_casetas where idorden_logistica <> '' || estatus <> 'Pendiente'");
	// while ($row = mysql_fetch_array($query_update)) {
	// 	$query_ok = mysql_query("UPDATE orden_logistica_casetas SET idorden_logistica = '', estatus = 'Pendiente' WHERE idorden_logistica = '$row[idorden_logistica]' ");
	// }

	echo ProcesarCasetas($fecha_a, $fecha_b);
	#
} else {

	echo "Movimiento no Disponible <b>$tipo_procesador</b>";
}


#------------------------------------------- Procesar Combustible --------------------------------------------------------------------------------

function ProcesarCombustible($fecha_a, $fecha_b)
{
	unset($ver_monto);
	unset($monto_total_combustible);
	unset($fecha_movimiento_combustible);
	unset($ver_balance_existe);
	unset($ver_balance_monto);
	$errores_combustible = array();

	$query_combustible_broxel = "SELECT * FROM orden_logistica_combustible WHERE idorden_logistica = '' AND establecimiento <> 'Su pago gracias' AND DATE_FORMAT(fecha_movimiento, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'";
	$result_combustible_broxel = mysql_query($query_combustible_broxel);

	while ($row_combustible = mysql_fetch_array($result_combustible_broxel)) {

		$convertir_a_numero = Dinero($row_combustible[gran_total]);

		$convertir_a_numero = floatval($convertir_a_numero);

		$ver_monto = explode(".", $convertir_a_numero);

		$monto_total_combustible = ($ver_monto[1] == "00") ? $ver_monto[0] : $row_combustible[gran_total];

		$fecha_movimiento_combustible = date_format(date_create($row_combustible[fecha_movimiento]), 'Y-m-d');


		if (is_numeric($monto_total_combustible)) {

			$ver_balance_existe = explode("|", BuscarBalanceGastos($row_combustible[tarjeta], $fecha_movimiento_combustible, $monto_total_combustible, "FechaMonto"));

			if ($ver_balance_existe[0] == "1") {

				$query_update_combustible = "UPDATE orden_logistica_combustible SET idorden_logistica = '$ver_balance_existe[1]', estatus = 'Agregado' WHERE idorden_logistica_combustible = '$row_combustible[idorden_logistica_combustible]'";
				#
			} else if ($ver_balance_existe[0] == "Pendiente") {

				$ver_balance_monto = explode("|", BuscarBalanceGastos($row_combustible[tarjeta], $fecha_movimiento_combustible, $monto_total_combustible, "SoloMonto"));

				if ($ver_balance_monto[0] == "1") {

					$query_update_combustible = "UPDATE orden_logistica_combustible SET estatus = 'Posible movimiento $ver_balance_monto[1]' WHERE idorden_logistica_combustible = '$row_combustible[idorden_logistica_combustible]'";
					#
				} else if ($ver_balance_monto[0] == "Varios") {

					$query_update_combustible = "UPDATE orden_logistica_combustible SET estatus = 'Posible movimiento $ver_balance_monto[1]' WHERE idorden_logistica_combustible = '$row_combustible[idorden_logistica_combustible]'";
				} else {

					$query_update_combustible = "UPDATE orden_logistica_combustible SET estatus = 'Pendiente' WHERE idorden_logistica_combustible = '$row_combustible[idorden_logistica_combustible]'";
				}
			} else {

				$query_update_combustible = "UPDATE orden_logistica_combustible SET estatus = 'Fecha y Monto $ver_balance_existe[1]' WHERE idorden_logistica_combustible = '$row_combustible[idorden_logistica_combustible]'";
			}


			$result_update_combustible = mysql_query($query_update_combustible);

			$errores_combustible = ($result_update_combustible == 1) ? array_push($errores_combustible, "1") : array_push($errores_combustible, "- Error con el movimiento <b>$row_combustible[idorden_logistica_combustible]</b><br>");
			#
		} else {

			array_push($errores_combustible, $row_combustible[tarjeta] . "<br>");
		}
	}

	return TratarNumeroText($errores_combustible);
}

#------------------------------------------- Procesar CCasetas --------------------------------------------------------------------------------



function ProcesarCasetas($fecha_a, $fecha_b)
{

	unset($convertir_a_numero);
	unset($ver_monto);
	unset($monto_total_caseta);
	unset($fecha_movimiento_casetas);
	unset($ver_balance_existe);
	unset($query_update_caseta);
	unset($result_update_casetas);


	$errores_casetas = array();

	$query_caseta = "SELECT * FROM orden_logistica_casetas WHERE idorden_logistica = '' AND DATE_FORMAT(fecha_movimiento, '%Y-%m-%d') between '$fecha_a' and '$fecha_b'";
	$result_caseta = mysql_query($query_caseta);

	while ($row_caseta = mysql_fetch_array($result_caseta)) {

		$convertir_a_numero = Dinero($row_caseta[gran_total]);

		$convertir_a_numero = floatval($convertir_a_numero);

		$ver_monto = explode(".", $convertir_a_numero);

		$monto_total_caseta = ($ver_monto[1] == "00") ? $ver_monto[0] : $row_caseta[gran_total];

		$fecha_movimiento_casetas = date_format(date_create($row_caseta[fecha_movimiento]), 'Y-m-d');

		if (is_numeric($monto_total_caseta)) {

			$ver_balance_existe = explode("|", BuscarBalanceGastos($row_caseta[tag], $fecha_movimiento_casetas, $monto_total_caseta, "FechaMonto"));

			if ($ver_balance_existe[0] == "1") {

				$query_update_caseta = "UPDATE orden_logistica_casetas SET idorden_logistica = '$ver_balance_existe[1]', estatus = 'Agregado' WHERE idorden_logistica_casetas = '$row_caseta[idorden_logistica_casetas]'";
			} else if ($ver_balance_existe[0] == "Pendiente") {

				$ver_balance_monto = explode("|", BuscarBalanceGastos($row_caseta[tag], $fecha_movimiento_casetas, $monto_total_caseta, "SoloMonto"));

				if ($ver_balance_monto[0] == "1") {

					$query_update_caseta = "UPDATE orden_logistica_casetas SET estatus = 'Posible movimiento $ver_balance_monto[1]' WHERE idorden_logistica_casetas = '$row_caseta[idorden_logistica_casetas]'";
				} else if ($ver_balance_monto[0] == "Varios") {

					$query_update_caseta = "UPDATE orden_logistica_casetas SET estatus = 'Posible movimiento $ver_balance_monto[1]' WHERE idorden_logistica_casetas = '$row_caseta[idorden_logistica_casetas]'";
				} else {

					$query_update_caseta = "UPDATE orden_logistica_casetas SET estatus = 'Pendiente' WHERE idorden_logistica_casetas = '$row_caseta[idorden_logistica_casetas]'";
				}
			} else {

				$query_update_caseta = "UPDATE orden_logistica_casetas SET estatus = 'Fecha y Monto $ver_balance_existe[1]' WHERE idorden_logistica_casetas = '$row_caseta[idorden_logistica_casetas]'";
			}

			$query_update_caseta;

			$result_update_casetas = mysql_query($query_update_caseta);

			$errores_casetas = ($result_update_casetas == 1) ? array_push($errores_casetas, "1") : array_push($errores_casetas, "- Error con el movimiento <b>$row_caseta[idorden_logistica_casetas]</b><br>");
			#
		} else {

			array_push($errores_casetas, $row_caseta[tarjeta] . "<br>");
		}
	}

	unset($convertir_a_numero);
	unset($ver_monto);
	unset($monto_total_caseta);
	unset($fecha_movimiento_casetas);
	unset($ver_balance_existe);
	unset($query_update_caseta);
	unset($result_update_casetas);


	return TratarNumeroText($errores_casetas);
}

#------------------------------------------- Procesar Balamce de gastos --------------------------------------------------------------------------------


function BuscarBalanceGastos($recibir_tarjeta, $fecha_movimiento, $gran_total, $tipo_consulta)
{

	$recibir_tarjeta = trim($recibir_tarjeta);
	$gran_total = trim($gran_total);
	$tipo_consulta = trim($tipo_consulta);

	if ($tipo_consulta == "FechaMonto") {

		$query_tarjeta = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' AND tipo_movimiento = 'cargo' AND trim(comision) = '$recibir_tarjeta' AND fecha_movimiento = '$fecha_movimiento' and cargo = '$gran_total'";

		#
	} else if ($tipo_consulta == "SoloMonto") {

		$query_tarjeta = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' AND tipo_movimiento = 'cargo' AND trim(comision) = '$recibir_tarjeta' AND cargo = '$gran_total'";
	}


	$result_tarjeta = mysql_query($query_tarjeta);


	if (mysql_num_rows($result_tarjeta) == 0) {

		$mensaje_tarjeta = "Pendiente|Pendiente";
	} elseif (mysql_num_rows($result_tarjeta) == 1) {

		while ($row_tarjeta = mysql_fetch_array($result_tarjeta)) {

			$mensaje_tarjeta = "1|$row_tarjeta[columna2]";
		}
	} elseif (mysql_num_rows($result_tarjeta) >= 2) {

		while ($row_tarjeta = mysql_fetch_array($result_tarjeta)) {

			$concatenar_varios .= "$row_tarjeta[columna2],";
		}

		$concatenar_varios = substr($concatenar_varios, 0, -1);

		$mensaje_tarjeta = "Varios|$concatenar_varios";
	} else {

		$mensaje_tarjeta = "Error|$recibir_tarjeta";
	}

	// echo $mensaje_tarjeta;
	// echo "<br>";

	return $mensaje_tarjeta;
}
