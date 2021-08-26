<?php 
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";

date_default_timezone_set('America/Mexico_City');


$usuario_creador = $_SESSION['usuario_clave'];


$query_usuario_creador = "SELECT * FROM usuarios WHERE idusuario = '$usuario_creador'";
$result_usuario_creador = mysql_query($query_usuario_creador);

while ($row_usuario_creador = mysql_fetch_array($result_usuario_creador)) {

	$rol_usuario_creador = trim($row_usuario_creador[rol]);
}

include_once ($rol_usuario_creador == "100" ) ?  "funciones_principales.php" : "../Logistica/funciones_principales.php";
include_once ($rol_usuario_creador == "100" ) ?  "funciones_principales_insert.php" : "../Logistica/funciones_principales_insert.php";


$name_funcion = $_POST['valorBusqueda'];
$tipo_movimineto = $_POST['valorSelect'];
$idc = $_POST['idc'];

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];


if (trim($name_funcion) == "balance" ) {

	echo $mensaje = Balance_gastos_operacion($tipo_movimineto, $idc);
	
}elseif (trim($name_funcion) == "recurso" ) {

	echo $mensaje = Entrega_Recepcion_Recurso ($tipo_movimineto, $idc, $fecha_inicio, $fecha_fin);

}









function Balance_gastos_operacion($tipo_movimineto, $idc){

	$tipo_movimineto = trim($tipo_movimineto);
	$idc = trim($idc);

	$efectivo_requisicion_balance = 0;
	$tarjeta_requisicion_balance = 0;

	$query_count_balance = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' and columna2 = '$idc' ";
	$result_count_balance = mysql_query($query_count_balance);

	if (mysql_num_rows($result_count_balance) >=1) {


		if ($tipo_movimineto == "concepto") {

			$query_concepto_balance = "SELECT concepto FROM balance_gastos_operacion WHERE visible = 'SI' and columna2 = '$idc' group by concepto"; 
			$result_concepto_balance = mysql_query($query_concepto_balance);

			$show_movimiento .= "<div class='container-checks-1 mt-4'>

			<div class='d-flex justify-content-center align-items-center text-secundario-1'>
			<i class='fas fa-filter mr-2'></i>
			<b>Concepto:</b>
			</div>	
			<div class='d-flex justify-content-center align-items-center flex-wrap'>
			";

			while ($row_concepto_blance = mysql_fetch_array($result_concepto_balance)) {

				$show_movimiento .= "<div class='m-2'>
				<input onchange='filterme_balance()' type='checkbox' class='filtros' name='filter_concepto_balance' value='$row_concepto_blance[concepto]'>
				<span>$row_concepto_blance[concepto]</span>
				</div>";


			}

			$show_movimiento .= "</div>
			</div>";

			$show_movimiento .= "
			</div>
			</div>";
			
		}elseif ($tipo_movimineto == "tmovimineto") {
			
			$show_movimiento .= "
			<div class='d-flex justify-content-center'>
			<div>";

			$show_movimiento .= "
			<div class='container-checks-1'>
			<div class='d-flex justify-content-center align-items-center text-secundario-1'>
			<i class='fas fa-filter mr-2'></i>
			<b>Tipo de movimiento:</b>
			</div>		

			<div class='d-flex justify-content-center align-items-center flex-wrap'>
			<div class='m-2'>
			<input onchange='filterme_balance()' type='checkbox' class='filtros' name='filter_concepto_movimiento' value='cargo'>
			<span>Cargo</span>
			</div>
			<div class='m-2'>
			<input onchange='filterme_balance()' type='checkbox' class='filtros' name='filter_concepto_movimiento' value='abono'>
			<span>Abono</span>
			</div>
			</div>
			</div>
			";

		}elseif ($tipo_movimineto == "fecha") {
			
			$query_fecha_balance = "SELECT fecha_movimiento FROM balance_gastos_operacion WHERE visible = 'SI' and columna2 = '$idc' group by fecha_movimiento order by fecha_movimiento asc"; 
			$result_fecha_balance = mysql_query($query_fecha_balance);

			$show_movimiento .= "<div class='container-checks-1 mt-4'>

			<div class='d-flex justify-content-center align-items-center text-secundario-1'>
			<i class='fas fa-filter mr-2'></i>
			<b>Fecha:</b>
			</div>	
			<div class='d-flex justify-content-center align-items-center flex-wrap'>
			";

			while ($row_fecha_blance = mysql_fetch_array($result_fecha_balance)) {

				$fecha_movimiento = date_create($row_fecha_blance[fecha_movimiento]);
				$fecha_movimiento = date_format($fecha_movimiento, "d-m-Y");

				$show_movimiento .= "<div class='m-2'>
				<input onchange='filterme_balance()' type='checkbox' class='filtros' name='filter_fecha_balance' value='$fecha_movimiento'>
				<span>$fecha_movimiento</span>
				</div>";


			}

			$show_movimiento .= "</div>
			</div>";

			$show_movimiento .= "
			</div>
			</div>";

		}elseif ($tipo_movimineto == "responsable") {

			$query_responsable_balance = "SELECT responsable FROM balance_gastos_operacion WHERE visible = 'SI' and columna2 = '$idc' group by responsable order by responsable asc"; 
			$result_responsable_balance = mysql_query($query_responsable_balance);

			$show_movimiento .= "<div class='container-checks-1 mt-4'>

			<div class='d-flex justify-content-center align-items-center text-secundario-1'>
			<i class='fas fa-filter mr-2'></i>
			<b>Responsable:</b>
			</div>	
			<div class='d-flex justify-content-center align-items-center flex-wrap'>
			";

			while ($row_responsable_blance = mysql_fetch_array($result_responsable_balance)) {

				if (is_numeric(trim($row_responsable_blance[responsable]))) {

					$show_balance_responsable = nombres_datos($row_responsable_blance[responsable], "Colaborador");
					$show_balance_responsable_porciones = explode("|", $show_balance_responsable);
					$responsable_requisicion = $show_balance_responsable_porciones[2];

				}else{

					$responsable_requisicion = trim($row_responsable_blance[responsable]);

				}



				$show_movimiento .= "<div class='m-2'>
				<input onchange='filterme_balance()' type='checkbox' class='filtros' name='filter_responsable_balance' value='$responsable_requisicion'>
				<span>$responsable_requisicion</span>
				</div>";


			}

			$show_movimiento .= "</div>
			</div>";

			$show_movimiento .= "
			</div>
			</div>";


			
		} elseif ($tipo_movimineto == "vin") {

			$query_vin_balance = "SELECT datos_vin FROM balance_gastos_operacion WHERE visible = 'SI' and columna2 = '$idc' group by datos_vin"; 
			$result_vin_balance = mysql_query($query_vin_balance);

			$show_movimiento .= "<div class='container-checks-1 mt-4'>

			<div class='d-flex justify-content-center align-items-center text-secundario-1'>
			<i class='fas fa-filter mr-2'></i>
			<b>VIN:</b>
			</div>	
			<div class='d-flex justify-content-center align-items-center flex-wrap'>
			";

			while ($row_vin_blance = mysql_fetch_array($result_vin_balance)) {

				$show_movimiento .= "<div class='m-2'>
				<input onchange='filterme_balance()' type='checkbox' class='filtros' name='filter_datos_vin_balance' value='$row_vin_blance[datos_vin]'>
				<span>$row_vin_blance[datos_vin]</span>
				</div>";


			}

			$show_movimiento .= "</div>
			</div>";

			$show_movimiento .= "
			</div>
			</div>";

		} elseif ($tipo_movimineto == "mpago") {

			while ($row_query_count_balance = mysql_fetch_array($result_count_balance)) {

				if (trim($row_query_count_balance[comision]) == "N/A") {
					$efectivo_requisicion_balance ++;
				}

				if (trim($row_query_count_balance[comision]) != "N/A") {
					$tarjeta_requisicion_balance ++;
				}
			}

			if ($efectivo_requisicion_balance + $tarjeta_requisicion_balance >=1) {

				$show_movimiento .= "<div class='container-checks-1 mt-4'>

				<div class='d-flex justify-content-center align-items-center text-secundario-1'>
				<i class='fas fa-filter mr-2'></i>
				<b>Método de Pago:</b>
				</div>	
				<div class='d-flex justify-content-center align-items-center flex-wrap'>
				";

				if ($efectivo_requisicion_balance >=1) {

					$show_movimiento .= $efectivo_balance_requisicion = "<div class='m-2'>
					<input onchange='filterme_balance()' type='checkbox' class='filtros' name='filter_metodo_pago_balance' value='Efectivo'>
					<span>Efectivo</span>
					</div>";

				}

				if ($tarjeta_requisicion_balance >=1) {

					$show_movimiento .= $efectivo_balance_requisicion = "<div class='m-2'>
					<input onchange='filterme_balance()' type='checkbox' class='filtros' name='filter_metodo_pago_balance' value='Tarjeta'>
					<span>Tarjeta</span>
					</div>";

				}



				$show_movimiento .= "</div>
				</div>";

				$show_movimiento .= "
				</div>
				</div>";

			}

		}elseif ($tipo_movimineto == "tarjeta") {

			$query_tarjeta_balance = "SELECT comision FROM balance_gastos_operacion WHERE visible = 'SI' and columna2 = '$idc' group by comision"; 
			$result_tarjeta_balance = mysql_query($query_tarjeta_balance);

			$show_movimiento .= "<div class='container-checks-1 mt-4'>

			<div class='d-flex justify-content-center align-items-center text-secundario-1'>
			<i class='fas fa-filter mr-2'></i>
			<b>Tarjeta:</b>
			</div>	
			<div class='d-flex justify-content-center align-items-center flex-wrap'>
			";

			while ($row_tarjeta_blance = mysql_fetch_array($result_tarjeta_balance)) {

				$show_movimiento .= "<div class='m-2'>
				<input onchange='filterme_balance()' type='checkbox' class='filtros' name='filter_comision_balance' value='$row_tarjeta_blance[comision]'>
				<span>$row_tarjeta_blance[comision]</span>
				</div>";


			}

			$show_movimiento .= "</div>
			</div>";

			$show_movimiento .= "
			</div>
			</div>";
			
		}elseif ($tipo_movimineto == "proveedor") {


			$query_tarjeta_balance = "SELECT idcatalogo_provedores FROM balance_gastos_operacion WHERE visible = 'SI' and columna2 = '$idc' group by idcatalogo_provedores"; 
			$result_tarjeta_balance = mysql_query($query_tarjeta_balance);

			$show_movimiento .= "<div class='container-checks-1 mt-4'>

			<div class='d-flex justify-content-center align-items-center text-secundario-1'>
			<i class='fas fa-filter mr-2'></i>
			<b>Proveedor:</b>
			</div>	
			<div class='d-flex justify-content-center align-items-center flex-wrap'>
			";

			while ($row_tarjeta_blance = mysql_fetch_array($result_tarjeta_balance)) {
				$proveedor_nombre_balance = NombreProveedorBalance ($row_tarjeta_blance[idcatalogo_provedores]);

				$show_movimiento .= "<div class='m-2'>
				<input onchange='filterme_balance()' type='checkbox' class='filtros' name='filter_idcatalogo_provedores_balance' value='$proveedor_nombre_balance'>
				<span>$proveedor_nombre_balance</span>
				</div>";


			}

			$show_movimiento .= "</div>
			</div>";

			$show_movimiento .= "
			</div>
			</div>";
			
		}

	}


	return $show_movimiento;


}

#------------------------------------------- recurso --------------------------------------------------------------------------------


function Entrega_Recepcion_Recurso ($tipo_movimineto, $idc, $fecha_inicio, $fecha_fin) {

	$tipo_movimineto = trim($tipo_movimineto);
	$idc = trim($idc);	

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

		$fecha_a = date("Y-m-01 ");
		$fecha_b = date("Y-m-d");  
	}

	$array_tipo_movimiento = array();
	$array_id = array();
	$array_responsable = array();
	$array_recurso_status = array();
	$array_logistica_status = array();
	$array_tesoreria_status = array();
	$array_cobranza_status = array();


	$query_recurso = "SELECT * FROM orden_logistica_recurso WHERE fecha between '$fecha_a' and '$fecha_b'";
	$result_recurso = mysql_query($query_recurso);

	while ($row_recurso = mysql_fetch_array($result_recurso)) {
		
		#------------------------------------------- Referencia --------------------------------------------------------------------------------

		$referencia_recibo = ReferenciaVisiblesWallet ($row_recurso[referencia]);

		#------------------------------------------- Movimiento --------------------------------------------------------------------------------

		if ($tipo_movimineto == "tipo_movimiento") {

			$input_tipo_movimiento = "
			<div class='m-2'>
			<input onchange='filter_recurso()' type='checkbox' class='filtros' name='filter_tipo_movimiento' value='$row_recurso[concepto]'>
			<span>$row_recurso[concepto]</span>
			</div>
			";

			array_push($array_tipo_movimiento, $input_tipo_movimiento);

		}elseif ($tipo_movimineto == "id") {

		#------------------------------------------- ID --------------------------------------------------------------------------------

			$query_documentacion = "SELECT * FROM orden_logistica_documentacion WHERE idorden_logistica_documentacion = '$row_recurso[idorden_logistica_documentacion]'";
			$result_documentacion = mysql_query($query_documentacion);

			while ($row_documentacion = mysql_fetch_array($result_documentacion)) {

				$id_id = trim($row_documentacion[id_responsable]);
				$tipo_tabla_id = ($row_documentacion[tipo_responsable] == "Proveedor Info") ? "Transacciones" : $row_documentacion[tipo_responsable];

				$name_id = explode("|", nombres_datos($row_documentacion[id_responsable], $row_documentacion[tipo_responsable]));
			}

			$nombre_id_recurso = "$id_id.$name_id[10] - $tipo_tabla_id";

			$input_tipo_movimiento = "
			<div class='m-2'>
			<input onchange='filter_recurso()' type='checkbox' class='filtros' name='filter_id' value='$nombre_id_recurso'>
			<span>$nombre_id_recurso</span>
			</div>
			";

			array_push($array_id, $input_tipo_movimiento);

		}elseif ($tipo_movimineto == "responsable") {

		#------------------------------------------- Responsable --------------------------------------------------------------------------------

			$query_logistica = "SELECT * FROM orden_logistica WHERE idorden_logistica = $row_recurso[idorden_logistica]";
			$result_logistica = mysql_query($query_logistica);

			while ($row_logistica = mysql_fetch_array($result_logistica)) {

				$name_responsable = explode("|", nombres_datos($row_logistica[idasigna], $row_logistica[tipo_asignante]));

				$nombre_responsable_recurso = "$name_responsable[10]-$name_responsable[2]";

				$input_tipo_movimiento = "
				<div class='m-2'>
				<input onchange='filter_recurso()' type='checkbox' class='filtros' name='filter_responsable' value='$nombre_responsable_recurso'>
				<span>$nombre_responsable_recurso</span>
				</div>
				";

				array_push($array_responsable, $input_tipo_movimiento);
			}
			
		}elseif ($tipo_movimineto == "status_recurso") {

		#------------------------------------------- Estatus Recurso --------------------------------------------------------------------------------

			$estatus_recurso = (trim($row_recurso[estatus]) == "Cancelado") ? "Cancelado" : EstatusRecursoFuncion ($referencia_recibo, $row_recurso[idorden_logistica_recurso]);

			$input_tipo_movimiento = "
			<div class='m-2'>
			<input onchange='filter_recurso()' type='checkbox' class='filtros' name='filter_status_recurso' value='$estatus_recurso'>
			<span>$estatus_recurso</span>
			</div>
			";

			array_push($array_recurso_status, $input_tipo_movimiento);
			
		}elseif ($tipo_movimineto == "status_logistica") {
			
		#------------------------------------------- Estatus Logistica --------------------------------------------------------------------------------

			$estatus_logistica = EstatusPrincipalLogistica ($row_recurso[idorden_logistica]);

			$input_tipo_movimiento = "
			<div class='m-2'>
			<input onchange='filter_recurso()' type='checkbox' class='filtros' name='filter_status_logistica' value='$estatus_logistica'>
			<span>$estatus_logistica</span>
			</div>
			";

			array_push($array_logistica_status, $input_tipo_movimiento);

		}elseif ($tipo_movimineto == "status_tesoreria") {
			
		#------------------------------------------- Estatus Tesoreria --------------------------------------------------------------------------------

			$estatus_tesoreria = (trim($row_recurso[estatus]) == "Cancelado") ? "Cancelado" : ConsultarReferenciaSeguimiento ($referencia_recibo);

			$input_tipo_movimiento = "
			<div class='m-2'>
			<input onchange='filter_recurso()' type='checkbox' class='filtros' name='filter_status_tesoreria' value='$estatus_tesoreria'>
			<span>$estatus_tesoreria</span>
			</div>
			";

			array_push($array_tesoreria_status, $input_tipo_movimiento);

		}elseif ($tipo_movimineto == "status_cobranza") {

		#------------------------------------------- Estatus Cobranza --------------------------------------------------------------------------------

			$estatus_cobranza = (trim($row_recurso[estatus]) == "Cancelado") ? "Cancelado" : Estatus_CobranzaFuncion ($referencia_recibo);

			$input_tipo_movimiento = "
			<div class='m-2'>
			<input onchange='filter_recurso()' type='checkbox' class='filtros' name='filter_status_cobranza' value='$estatus_cobranza'>
			<span>$estatus_cobranza</span>
			</div>
			";

			array_push($array_cobranza_status, $input_tipo_movimiento);
		}
	}

	if ($tipo_movimineto == "tipo_movimiento") {

		return Show_Array_Unico ($array_tipo_movimiento, "Tipo de Movimiento:");

	} elseif ($tipo_movimineto == "id") {

		return Show_Array_Unico ($array_id, "ID:");

	}elseif ($tipo_movimineto == "responsable") {

		return Show_Array_Unico ($array_responsable, "Responsable:");

	}elseif ($tipo_movimineto == "status_recurso") {

		return Show_Array_Unico ($array_recurso_status, "Estatus Recurso:");

	}elseif ($tipo_movimineto == "status_logistica") {

		return Show_Array_Unico ($array_logistica_status, "Estatus Logística:");

	}elseif ($tipo_movimineto == "status_tesoreria") {

		return Show_Array_Unico ($array_tesoreria_status, "Estatus Tesorería:");

	}elseif ($tipo_movimineto == "status_cobranza") {

		return Show_Array_Unico ($array_cobranza_status, "Estatus Cobranza:");

	}
}




function Show_Array_Unico ($arrays_concatenados, $nombre_encabezado){

	$unique_array = array_unique($arrays_concatenados);
	$pass_to_string = implode($unique_array);


	$nombre_encabezado = trim($nombre_encabezado);

	return $pasar_movimentos = "
	<div class='container-checks-1 mt-4'>

	<div class='d-flex justify-content-center align-items-center text-secundario-1'>
	<i class='fas fa-filter mr-2'></i>
	<b>$nombre_encabezado</b>
	</div>	

	<div class='d-flex justify-content-start align-items-center flex-wrap'>

	$pass_to_string

	</div>
	</div>
	";



} 








?>