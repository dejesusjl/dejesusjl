<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";

date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$usuario_creador = $_SESSION['usuario_clave'];

$empleados = $_SESSION['empleados'];

$query_usuario_creador = "SELECT * FROM usuarios WHERE idusuario = '$usuario_creador'";
$result_usuario_creador = mysql_query($query_usuario_creador);

while ($row_usuario_creador = mysql_fetch_array($result_usuario_creador)) {

	$rol_loguin = trim($row_usuario_creador[rol]);
}

include_once ($rol_loguin == "100") ?  "funciones_principales.php" : "../Logistica/funciones_principales.php";
include_once ($rol_loguin == "100") ?  "funciones_principales_insert.php" : "../Logistica/funciones_principales_insert.php";



$idcliente = trim($_POST['idcliente']);
$tipo_contacto_id = trim($_POST['tipo_contacto_id']);
$referencia_movimiento = trim($_POST['referencia_movimiento']);
$tipo_fomulario_option = trim($_POST['tipo_fomulario_option']);
$comentarios_recurso = trim($_POST['columna_c']);
$coordenadas = trim($_POST['coordenadas_token']);
$fecha_creacion = $_POST['fecha_creacion'];
$tipo_entrega_recepcion = trim($_POST['tipo_entrega_recepcion']);
$idlogistica = base64_decode($_POST['idlogistica']);
$id_logistica_documentacion = trim($_POST['idorden_logistica_documentacion']);

$t_cambio = trim($_POST['t_cambio']);

$visible = "SI";

$fecha_movimiento_recurso = $_POST['fecha_movimiento'];

$contador_update_wallet = 0;

$array_respuesta_update = array();


if ($tipo_fomulario_option == "CambiarID") {


	$query_referencia_id_cliente = "SELECT * FROM orden_logistica_recurso WHERE trim(referencia) = '$referencia_movimiento'";
	$result_referencia_id_cliente = mysql_query($query_referencia_id_cliente);

	if (mysql_num_rows($result_referencia_id_cliente) >= 1) {

		while ($row_referencia = mysql_fetch_array($result_referencia_id_cliente)) {

			#------------------------------------------- Estatus Tesoreria --------------------------------------------------------------------------------

			$estatus_tesoreria = (trim($row_referencia[estatus]) == "Cancelado") ? "Cancelado" : ConsultarReferenciaSeguimiento($referencia_movimiento);

			#------------------------------------------- Estatus Cobranza --------------------------------------------------------------------------------

			$estatus_cobranza = (trim($row_referencia[estatus]) == "Cancelado") ? "Cancelado" : Estatus_CobranzaFuncion($referencia_movimiento);

			if ($estatus_cobranza == "Pendiente" and $estatus_tesoreria == "Pendiente") {

				$comprobar_new_id =  ComprobarActualizarID($row_referencia[idorden_logistica_documentacion], $idcliente, $tipo_contacto_id, $row_referencia[idorden_logistica_recurso], $row_referencia[concepto], $row_referencia[idorden_logistica]);

				$porciones_new_id = explode("|", $comprobar_new_id);

				if (trim($porciones_new_id[0]) == 1) {

					$query_update_documentacion = "UPDATE orden_logistica_documentacion SET id_responsable = '$idcliente', tipo_responsable = '$tipo_contacto_id' WHERE idorden_logistica_documentacion = '$row_referencia[idorden_logistica_documentacion]'";
					$result_update_documentacion = mysql_query($query_update_documentacion);

					if ($result_update_documentacion == 1) {

						$query_wallet_id_cliente = "SELECT * FROM empleados_wallet WHERE trim(referencia_seguimiento) = '$referencia_movimiento' and visible = 'SI'";
						$result_wallet_id_cliente = mysql_query($query_wallet_id_cliente);

						if (mysql_num_rows($result_wallet_id_cliente) >= 1) {

							while ($row_wallet_id_cliente = mysql_fetch_array($result_wallet_id_cliente)) {

								if ($row_wallet_id_cliente[tipo] == "Egreso") {

									$query_update_wallet_id_cliente = "UPDATE empleados_wallet SET id = '$idcliente', tipo_id = '$porciones_new_id[2]', tabla = '$porciones_new_id[3]' WHERE idempleados_wallet = '$row_wallet_id_cliente[idempleados_wallet]' ";
									$result_update_wallet_id_cliente = mysql_query($query_update_wallet_id_cliente);

									$respuesta_update = ($result_update_wallet_id_cliente == 1) ? array_push($array_respuesta_update, "1") : array_push($array_respuesta_update, "- Error al actualizar el movimiento <b>$row_wallet_id_cliente[idempleados_wallet]</b> <br>");
									$idempleados_wallet = $row_wallet_id_cliente[idempleados_wallet];
								} else if ($row_wallet_id_cliente[tipo] == "Ingreso") {

									$query_update_wallet_id_cliente = "UPDATE empleados_wallet SET id = '$idcliente', tipo_id = '$porciones_new_id[2]', tabla = '$porciones_new_id[3]' WHERE idempleados_wallet = '$row_wallet_id_cliente[idempleados_wallet]' ";
									$result_update_wallet_id_cliente = mysql_query($query_update_wallet_id_cliente);

									$respuesta_update = ($result_update_wallet_id_cliente == 1) ? array_push($array_respuesta_update, "1") : array_push($array_respuesta_update, "- Error al actualizar el movimiento <b>$row_wallet_id_cliente[idempleados_wallet]</b> <br>");
									$idempleados_wallet = $row_wallet_id_cliente[idempleados_wallet];

									if (trim($row_wallet_id_cliente[tipo_receptor]) == "Colaborador" || trim($row_wallet_id_cliente[tipo_receptor]) == "") {

										$query_update_wallet_emisor = "UPDATE empleados_wallet SET emisor = '$idcliente', tipo_emisor = '$porciones_new_id[2]' WHERE idempleados_wallet = '$row_wallet_id_cliente[idempleados_wallet]' ";
										$result_update_wallet_emisor = mysql_query($query_update_wallet_emisor);

										$respuesta_emisor = ($result_update_wallet_emisor == 1) ? array_push($array_respuesta_update, "1") : array_push($array_respuesta_update, "- Error al actualizar el movimiento <b>$row_wallet_id_cliente[idempleados_wallet]</b> <br>");
										$idempleados_wallet = $row_wallet_id_cliente[idempleados_wallet];
									}
								}
							}


							$tratar_array = TratarNumeroText($array_respuesta_update);

							if ($tratar_array == 1) {

								if ($row_referencia[concepto] == "Entrega") {

									$valor_wallet = 1;
									$tipo_movimiento_wallet = "Egreso";
								} else {

									$valor_wallet = 2;
									$tipo_movimiento_wallet = "Ingreso";
								}

								$insertar_logistica_bitacora = LogisticaInsertBitacora($porciones_new_id[4], "Cambio del ID", $row_referencia[idorden_logistica], $comentarios_recurso, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "11", $columna_c, $columna_d, $visible);

								$insertar_wallet_bitacora = WalletInsertBitacora($idempleados_wallet, $referencia_movimiento, "Cambio del ID", $porciones_new_id[4], $valor_wallet, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $row_referencia[idorden_logistica], "Wallet", "", $tipo_movimiento_wallet, $comentarios_recurso, "", "");


								if ($insertar_logistica_bitacora == 1 and $insertar_wallet_bitacora == 1) {

									echo 1;
								} else if ($insertar_logistica_bitacora != 1 and $insertar_wallet_bitacora == 1) {

									echo $insertar_logistica_bitacora;
								} else if ($insertar_logistica_bitacora == 1 and $insertar_wallet_bitacora != 1) {

									echo $insertar_wallet_bitacora;
								} else if ($insertar_logistica_bitacora != 1 and $insertar_wallet_bitacora != 1) {

									echo $insertar_logistica_bitacora;
									echo $insertar_wallet_bitacora;
								}
							} else {

								echo $tratar_array;
							}
						} else {

							echo "- Error no se encontraron movimientos en la <b>WALLET</b>";
						}
					} else {

						echo "-Error al actualizar la tabla <b>Recurso</b>";
					}
				} else {

					echo $comprobar_new_id;
				}
			} else {

				echo "<b>Tesorería</b> ya aplico el movimiento <b>No es posible cambiar</b>";
			}
		}
	} else {

		echo "- No se encontraron movimientos en la tabla Recurso";
	}
} elseif ($tipo_fomulario_option == "CambiarDate") {

	if ($fecha_movimiento_recurso == "") {

		echo "<b>Primero debes de Seleccionar una Fecha</b>";
	} else {

		$array_change_date = array();
		$concatenar_errores_date_array = array();

		$valor = ($tipo_entrega_recepcion == "Egreso") ? 1 : 2;

		$date_format_new = date_format(date_create($fecha_movimiento_recurso), 'd-m-Y');

		#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$query_date_recurso = "SELECT * FROM orden_logistica_recurso WHERE referencia = '$referencia_movimiento' ";
		$result_date_recurso = mysql_query($query_date_recurso);

		while ($row_date_recurso = mysql_fetch_array($result_date_recurso)) {

			$date_recurso_bd = date_format(date_create($row_date_recurso[fecha]), "d-m-Y");

			if ($row_date_recurso[fecha] != $fecha_movimiento_recurso) {


				$query_update_date_recurso = "UPDATE orden_logistica_recurso SET fecha = '$fecha_movimiento_recurso' WHERE idorden_logistica_recurso = '$row_date_recurso[idorden_logistica_recurso]'";
				$result_update_date_recurso = mysql_query($query_update_date_recurso);

				if ($result_update_date_recurso == 1) {

					array_push($concatenar_errores_date_array, "1");
					$concatenar_bitacora_date = "<b>- Logística:</b> la Fecha cambio de <b>$date_recurso_bd</b> por <b>$date_format_new</b><br>";
					array_push($array_change_date, $concatenar_bitacora_date);
				} else {

					array_push($concatenar_errores_date_array, "Error en Logística <br>");
					$concatenar_bitacora_date = "</b>- Error en Logística</b><br>";
					array_push($array_change_date, $concatenar_bitacora_date);
				}
			} else {

				array_push($concatenar_errores_date_array, "1");
			}
		}

		#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		$query_date_wallet = "SELECT * FROM empleados_wallet WHERE referencia_seguimiento = '$referencia_movimiento' and visible = 'SI' ";
		$result_date_wallet = mysql_query($query_date_wallet);

		while ($row_date_wallet = mysql_fetch_array($result_date_wallet)) {

			$date_wallet_bd = date_format(date_create($row_date_wallet[fecha]), "d-m-Y");

			if ($row_date_wallet[fecha] != $fecha_movimiento_recurso) {

				$query_update_date_wallet = "UPDATE empleados_wallet SET fecha_movimiento = '$fecha_movimiento_recurso' WHERE idempleados_wallet = '$row_date_wallet[idempleados_wallet]'";
				$result_update_date_wallet = mysql_query($query_update_date_wallet);

				if ($result_update_date_wallet == 1) {

					$insert_bitacora_date_wallet = WalletInsertBitacora($row_date_wallet[idempleados_wallet], $referencia_movimiento, "Cambio de Fecha", "<b>- Wallet:</b> la Fecha cambio de <b>$date_wallet_bd</b> por <b>$date_format_new</b><br>", $valor, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $idlogistica, "Wallet", $row_date_wallet[token], $tipo_entrega_recepcion, $comentarios_recurso, $columna_d, $columna_e);

					($insert_bitacora_date_wallet == 1) ? array_push($concatenar_errores_date_array, "1") : array_push($concatenar_errores_date_array, $insert_bitacora_date_wallet);
				} else {

					array_push($concatenar_errores_date_array, "Error en Wallet <br>");
					$concatenar_bitacora_date = "</b>- Error en Wallet</b><br>";
					array_push($array_change_date, $concatenar_bitacora_date);
				}
			} else {

				array_push($concatenar_errores_date_array, "1");
			}
		}

		#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		$query_date_edo_cuenta_egresos_ingresos = "SELECT * FROM estado_cuenta_tesorerias_egresos_ingresos WHERE visible = 'SI' AND referencia_seguimiento = '$referencia_movimiento'";
		$result_date_edo_cuenta_egresos_ingresos = mysql_query($query_date_edo_cuenta_egresos_ingresos);

		if (mysql_num_rows($result_date_edo_cuenta_egresos_ingresos) >= 1) {

			while ($row_date_edo_cuenta_egresos_ingresos = mysql_fetch_array($result_date_edo_cuenta_egresos_ingresos)) {

				$date_edo_cuenta_egresos_ingresos_bd = date_format(date_create($row_date_edo_cuenta_egresos_ingresos[fecha_movimiento]), "d-m-Y");

				if ($row_date_edo_cuenta_egresos_ingresos[fecha_movimiento] != $fecha_movimiento_recurso) {

					$query_update_date_edo_cuenta_egresos_ingresos = "UPDATE estado_cuenta_tesorerias_egresos_ingresos SET fecha_movimiento = '$fecha_movimiento_recurso' WHERE idestado_cuenta_tesorerias_egresos_ingresos = '$row_date_edo_cuenta_egresos_ingresos[idestado_cuenta_tesorerias_egresos_ingresos]'";
					$result_updtae_date_edo_cuenta_egresos_ingresos = mysql_query($query_update_date_edo_cuenta_egresos_ingresos);

					if ($result_updtae_date_edo_cuenta_egresos_ingresos == 1) {

						array_push($concatenar_errores_date_array, "1");
						$concatenar_bitacora_date = "<b>- Estado de Cuenta Egresos Ingresos:</b> la Fecha cambio de <b>$date_edo_cuenta_egresos_ingresos_bd</b> por <b>$date_format_new</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					} else {

						array_push($concatenar_errores_date_array, "Error en Estado de Cuenta Egresos Ingresos <br>");
						$concatenar_bitacora_date = "</b>- Error en Estado de Cuenta Egresos Ingresos</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					}
				} else {

					array_push($concatenar_errores_date_array, "1");
				}
			}
		} else {

			array_push($concatenar_errores_date_array, "1");
		}

		#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$query_date_edo_cuenta_tesorerias_traspasos = "SELECT * FROM estado_cunta_tesorerias_traspasos WHERE visible = 'SI' AND referencia_seguimiento = '$referencia_movimiento'";
		$result_date_edo_cuenta_tesorerias_traspasos = mysql_query($query_date_edo_cuenta_tesorerias_traspasos);

		if (mysql_num_rows($result_date_edo_cuenta_tesorerias_traspasos) >= 1) {

			while ($row_date_edo_cuenta_tesorerias_traspasos = mysql_fetch_array($result_date_edo_cuenta_tesorerias_traspasos)) {

				if ($row_date_edo_cuenta_tesorerias_traspasos[fecha_movimiento] != $fecha_movimiento_recurso) {

					$date_edo_cuenta_tesorerias_traspasos = date_format(date_create($row_date_edo_cuenta_tesorerias_traspasos[fecha_movimiento]), "d-m-Y");

					$query_update_date_edo_cuenta_tesorerias_traspasos = "UPDATE estado_cunta_tesorerias_traspasos SET fecha_movimiento = '$fecha_movimiento_recurso' WHERE idestado_cunta_tesorerias_traspasos = '$row_date_edo_cuenta_tesorerias_traspasos[idestado_cunta_tesorerias_traspasos]'";
					$result_update_date_edo_cuenta_tesorerias_traspasos = mysql_query($query_update_date_edo_cuenta_tesorerias_traspasos);

					if ($result_update_date_edo_cuenta_tesorerias_traspasos == 1) {

						array_push($concatenar_errores_date_array, "1");
						$concatenar_bitacora_date = "<b>- Estado de Cuenta Egresos Tesorería Traspasos:</b> la Fecha cambio de <b>$date_edo_cuenta_tesorerias_traspasos</b> por <b>$date_format_new</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					} else {

						array_push($concatenar_errores_date_array, "Error en Estado de Cuenta Tesorería Traspasos <br>");
						$concatenar_bitacora_date = "</b>- Error en Estado de Cuenta Tesorería Traspasos</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					}
				} else {

					array_push($concatenar_errores_date_array, "1");
				}
			}
		} else {

			array_push($concatenar_errores_date_array, "1");
		}

		#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		$query_date_tesorerias2 = "SELECT * FROM estado_cuenta_tesorerias2 WHERE visible = 'SI' AND referencia_seguimiento = '$referencia_movimiento'";
		$result_date_tesorerias2 = mysql_query($query_date_tesorerias2);

		if (mysql_num_rows($result_date_tesorerias2) >= 1) {

			while ($row_date_tesorerias2 = mysql_fetch_array($result_date_tesorerias2)) {

				if ($row_date_tesorerias2[fecha_movimiento] != $fecha_movimiento_recurso) {

					$date__tesorerias2 = date_format(date_create($row_date_tesorerias2[fecha_movimiento]), "d-m-Y");

					$query_update_date_tesorerias2 = "UPDATE estado_cuenta_tesorerias2 SET fecha_movimiento = '$fecha_movimiento_recurso' WHERE idestado_cuenta_tesorerias2 = '$row_date_tesorerias2[idestado_cuenta_tesorerias2]'";
					$result_update_date_tesorerias2 = mysql_query($query_update_date_tesorerias2);

					if ($result_update_date_tesorerias2 == 1) {

						array_push($concatenar_errores_date_array, "1");
						$concatenar_bitacora_date = "<b>- Estado de Cuenta Tesorerías2:</b> la Fecha cambio de <b>$date__tesorerias2</b> por <b>$date_format_new</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					} else {

						array_push($concatenar_errores_date_array, "Error en Estado de Cuenta Tesorerías2 <br>");
						$concatenar_bitacora_date = "</b>- Error en Estado de Cuenta Tesorerías2</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					}
				} else {

					array_push($concatenar_errores_date_array, "1");
				}
			}
		} else {

			array_push($concatenar_errores_date_array, "1");
		}

		#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		$query_date_recibos_tesorerias2 = "SELECT * FROM recibos_estado_cuenta_tesorerias2 WHERE referencia = '$referencia_movimiento'";
		$result_date_recibos_tesorerias2 = mysql_query($query_date_recibos_tesorerias2);

		if (mysql_num_rows($result_date_recibos_tesorerias2) >= 1) {

			while ($row_date_recibos_tesorerias2 = mysql_fetch_array($result_date_recibos_tesorerias2)) {

				$date_recibos_tesorerias2 = date_format(date_create($row_date_recibos_tesorerias2[fecha]), "d-m-Y");

				if ($row_date_recibos_tesorerias2[fecha] != $fecha_movimiento_recurso) {

					$query_update_recibos_tesorerias2 = "UPDATE recibos_estado_cuenta_tesorerias2 SET fecha = '$fecha_movimiento_recurso' WHERE idrecibos_estado_cuenta_tesorerias2 = '$row_date_recibos_tesorerias2[idrecibos_estado_cuenta_tesorerias2]'";
					$result_update_recibos_tesorerias2 = mysql_query($query_update_recibos_tesorerias2);

					if ($result_update_recibos_tesorerias2 == 1) {

						array_push($concatenar_errores_date_array, "1");
						$concatenar_bitacora_date = "<b>- Recibos Tesorerías2:</b> la Fecha cambio de <b>$date_recibos_tesorerias2</b> por <b>$date_format_new</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					} else {

						array_push($concatenar_errores_date_array, "Error en Recibos Tesorerías2 <br>");
						$concatenar_bitacora_date = "</b>- Error en Recibos Tesorerías2</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					}
				} else {

					array_push($concatenar_errores_date_array, "1");
				}
			}
		} else {

			array_push($concatenar_errores_date_array, "1");
		}

		#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		$query_date_estado_cuenta = "SELECT * FROM estado_cuenta WHERE visible = 'SI' AND referencia = '$referencia_movimiento'";
		$result_date_estado_cuenta = mysql_query($query_date_estado_cuenta);

		if (mysql_num_rows($result_date_estado_cuenta) >= 1) {

			while ($row_date_estado_cuenta = mysql_fetch_array($result_date_estado_cuenta)) {

				$date_estado_cuenta = date_format(date_create($row_date_estado_cuenta[fecha_movimiento]), "d-m-Y");

				if ($row_date_estado_cuenta[fecha_movimiento] != $fecha_movimiento_recurso) {

					$query_update_estado_cuenta = "UPDATE estado_cuenta SET fecha_movimiento = '$fecha_movimiento_recurso' WHERE idestado_cuenta = '$row_date_estado_cuenta[idestado_cuenta]'";
					$result_update_estado_cuenta = mysql_query($query_update_estado_cuenta);

					if ($result_update_estado_cuenta == 1) {

						array_push($concatenar_errores_date_array, "1");
						$concatenar_bitacora_date = "<b>- Estado Cuenta:</b> la Fecha cambio de <b>$date_estado_cuenta</b> por <b>$date_format_new</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					} else {

						array_push($concatenar_errores_date_array, "Error en Estado Cuenta <br>");
						$concatenar_bitacora_date = "</b>- Error en Estado Cuenta</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					}
				} else {

					array_push($concatenar_errores_date_array, "1");
				}
			}
		} else {

			array_push($concatenar_errores_date_array, "1");
		}


		#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		$query_date_estado_cuenta_bienes_raices = "SELECT * FROM proveedores_bienes_raices_estado_cuenta WHERE visible = 'SI' AND referencia = '$referencia_movimiento'";
		$result_date_estado_cuenta_bienes_raices = mysql_query($query_date_estado_cuenta_bienes_raices);

		if (mysql_num_rows($result_date_estado_cuenta_bienes_raices) >= 1) {

			while ($row_date_estado_cuenta_bienes_raices = mysql_fetch_array($result_date_estado_cuenta_bienes_raices)) {

				$date_estado_cuenta_bienes_raices = date_format(date_create($row_date_estado_cuenta_bienes_raices[fecha_movimiento]), "d-m-Y");

				if ($row_date_estado_cuenta_bienes_raices[fecha_movimiento] != $fecha_movimiento_recurso) {

					$query_update_estado_cuenta_bienes_raices = "UPDATE proveedores_bienes_raices_estado_cuenta SET fecha_movimiento = '$fecha_movimiento_recurso' WHERE idproveedores_bienes_raices_estado_cuenta = '$row_date_estado_cuenta_bienes_raices[idproveedores_bienes_raices_estado_cuenta]'";
					$result_update_estado_cuenta_bienes_raices = mysql_query($query_update_estado_cuenta_bienes_raices);

					if ($result_update_estado_cuenta_bienes_raices == 1) {

						array_push($concatenar_errores_date_array, "1");
						$concatenar_bitacora_date = "<b>- Estado Cuenta Bienes Raices:</b> la Fecha cambio de <b>$date_estado_cuenta_bienes_raices</b> por <b>$date_format_new</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					} else {

						array_push($concatenar_errores_date_array, "Error en Estado Cuenta Bienes Raices<br>");
						$concatenar_bitacora_date = "</b>- Error en Estado Cuenta Bienes Raices</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					}
				} else {

					array_push($concatenar_errores_date_array, "1");
				}
			}
		} else {

			array_push($concatenar_errores_date_array, "1");
		}

		#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		$query_date_estado_cuenta_bienes_raices = "SELECT * FROM proveedores_bienes_raices_estado_cuenta WHERE visible = 'SI' AND referencia = '$referencia_movimiento'";
		$result_date_estado_cuenta_bienes_raices = mysql_query($query_date_estado_cuenta_bienes_raices);

		if (mysql_num_rows($result_date_estado_cuenta_bienes_raices) >= 1) {

			while ($row_date_estado_cuenta_bienes_raices = mysql_fetch_array($result_date_estado_cuenta_bienes_raices)) {

				$date_estado_cuenta_bienes_raices = date_format(date_create($row_date_estado_cuenta_bienes_raices[fecha_movimiento]), "d-m-Y");

				if ($row_date_estado_cuenta_bienes_raices[fecha_movimiento] != $fecha_movimiento_recurso) {

					$query_update_estado_cuenta_bienes_raices = "UPDATE proveedores_bienes_raices_estado_cuenta SET fecha_movimiento = '$fecha_movimiento_recurso' WHERE idproveedores_bienes_raices_estado_cuenta = '$row_date_estado_cuenta_bienes_raices[idproveedores_bienes_raices_estado_cuenta]'";
					$result_update_estado_cuenta_bienes_raices = mysql_query($query_update_estado_cuenta_bienes_raices);

					if ($result_update_estado_cuenta_bienes_raices == 1) {

						array_push($concatenar_errores_date_array, "1");
						$concatenar_bitacora_date = "<b>- Estado Cuenta Bienes Raices:</b> la Fecha cambio de <b>$date_estado_cuenta_bienes_raices</b> por <b>$date_format_new</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					} else {

						array_push($concatenar_errores_date_array, "Error en Estado Cuenta Bienes Raices<br>");
						$concatenar_bitacora_date = "</b>- Error en Estado Cuenta Bienes Raices</b><br>";
						array_push($array_change_date, $concatenar_bitacora_date);
					}
				} else {

					array_push($concatenar_errores_date_array, "1");
				}
			}
		} else {

			array_push($concatenar_errores_date_array, "1");
		}


		$tratar_array_cambio_fecha = Tratar_Array($array_change_date);

		foreach ($tratar_array_cambio_fecha as $key_bitacora => $value_array) {


			$insert_bitacora_wallet = WalletInsertBitacora("", $referencia_movimiento, "Cambio de Fecha", $value_array, $valor, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $idlogistica, "Wallet", "", $tipo_entrega_recepcion, $comentarios_recurso, $columna_d, $columna_e);

			($insert__bitacora_wallet == 1) ? array_push($concatenar_errores_date_array, "1") : array_push($insert__bitacora_wallet, "1");
		}


		echo TratarNumeroText($concatenar_errores_date_array);
	}
} elseif ($tipo_fomulario_option == "SubirEvidencia") {

	if (isset($_FILES['evidencia'])) {

		$ruta_archivo = ($tipo_entrega_recepcion == "Egreso") ? "../../Documentacion_Logistica/Entrega_Recurso_Wallet/" : "../../Documentacion_Logistica/Recepcion_Recurso_Wallet/";

		$target_path = $ruta_archivo . "ER-" . "$idlogistica" . "_Usr_" . $usuario_creador . $fecha_guardado . "_" . basename($_FILES['evidencia']['name']);

		if (is_dir($ruta_archivo)) {

			$estatus_evidencia = (move_uploaded_file($_FILES['evidencia']['tmp_name'], $target_path)) ? $target_path : "- Ocurrio un error al mover la Evidencia <br>";
		} else {

			$estatus_evidencia = "La carpeta $ruta_archivo no existe";
		}

		if ($estatus_evidencia == "La carpeta $ruta_archivo no existe" || $estatus_evidencia == "- Ocurrio un error al mover la Evidencia <br>") {

			echo $estatus_evidencia;
		} else {

			$query_evidencia_recurso = "SELECT * FROM orden_logistica_documentacion WHERE idorden_logistica_documentacion = '$id_logistica_documentacion'";
			$result_evidencia_recurso = mysql_query($query_evidencia_recurso);

			while ($row_evidencia_recurso = mysql_fetch_array($result_evidencia_recurso)) {

				if (file_exists($row_evidencia_recurso[evidencia])) {

					$evidencia_bd = "<a href=\'$row_evidencia_recurso[evidencia]\' target=\'_blank\'><i class=\'far fa-image fa-2x\'></i><a>";
					$evidencia_nueva = "<a href=\'$target_path\' target=\'_blank\'><i class=\'fas fa-image fa-2x\'></i><a>";

					$mesage_evidencia = "La evidencia cambio de: $evidencia_bd por $evidencia_nueva en <b>$tipo_entrega_recepcion</b>";
				} else {

					$evidencia_nueva = "<a href=\'$target_path\' target=\'_blank\' ><i class=\'far fa-image fa-2x\'></i><a>";
					$mesage_evidencia = "Se agregó nueva evidencia: $evidencia_nueva en <b>$tipo_entrega_recepcion</b>";
				}

				$query_update_evidencia_recurso = "UPDATE orden_logistica_documentacion SET evidencia = '$target_path' WHERE idorden_logistica_documentacion = '$id_logistica_documentacion'";
				$result_update_evidencia_recurso = mysql_query($query_update_evidencia_recurso);

				if ($result_update_evidencia_recurso == 1) {

					$query_wallet_evidencia = "SELECT * FROM empleados_wallet WHERE trim(referencia_seguimiento) = '$referencia_movimiento' and visible = 'SI' ORDER BY idempleados_wallet LIMIT 1 ";
					$result_wallet_evidencia = mysql_query($query_wallet_evidencia);

					while ($row_wallet_evidencia = mysql_fetch_array($result_wallet_evidencia)) {

						$idempleados_wallet = $row_wallet_evidencia[idempleados_wallet];
						$columna_a = $row_wallet_evidencia[token];
					}

					$valor = ($tipo_entrega_recepcion == "Egreso") ? 1 : 2;

					echo WalletInsertBitacora($idempleados_wallet, $referencia_movimiento, "Evidencia", $mesage_evidencia, $valor, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $idempleados_wallet, "Wallet", $columna_a, $tipo_entrega_recepcion, $comentarios_recurso, $columna_d, $columna_e);
				} else {

					echo "Error al subir la evidencia";
				}
			}
		}
	} else {

		echo '- No seleccionaste <b>Ninguna Evidencia</b> <br>';
	}
} elseif ($tipo_fomulario_option == "TipoCambio") {

	if ($t_cambio == 0) {

		echo "No Hay <b>Tipo de Cambio</b>";
	} else {

		$tipo_cambio = str_replace(",", "", $t_cambio);

		$query_tipo_cambio_logistica = "SELECT * FROM orden_logistica_recurso WHERE referencia = '$referencia_movimiento' ";
		$result_tipo_cambio_logistica = mysql_query($query_tipo_cambio_logistica);

		if (mysql_num_rows($result_tipo_cambio_logistica) >= 1) {

			while ($row_logistica_cambio = mysql_fetch_array($result_tipo_cambio_logistica)) {

				if ($row_logistica_cambio[estatus] == "Cancelado") {

					echo "El movimiento fue <b>Cancelado<b>";
				} else {

					$estatus_cobranza = Estatus_CobranzaFuncion($referencia_movimiento);

					if ($estatus_cobranza == "Pendiente") {

						$query_tesorerias_traspasos = "SELECT * FROM estado_cunta_tesorerias_traspasos WHERE visible = 'SI' AND referencia_seguimiento = '$referencia_movimiento' ";
						$result_tesorerias_traspasos = mysql_query($query_tesorerias_traspasos);

						if (mysql_num_rows($result_tesorerias_traspasos) >= 1) {

							while ($row_tesorerias_traspasos = mysql_fetch_array($result_tesorerias_traspasos)) {

								$query_update_traspaso_cambio = "UPDATE estado_cunta_tesorerias_traspasos SET tipo_cambio = '$tipo_cambio' WHERE idestado_cunta_tesorerias_traspasos = '$row_tesorerias_traspasos[idestado_cunta_tesorerias_traspasos]'";
								$result_update_traspaso_cambio = mysql_query($query_update_traspaso_cambio);

								if ($result_update_traspaso_cambio == 1) {

									$query_wallet_cambio = "SELECT * FROM empleados_wallet WHERE trim(referencia_seguimiento) = '$referencia_movimiento' and visible = 'SI' ORDER BY idempleados_wallet desc LIMIT 1 ";
									$result_wallet_cambio = mysql_query($query_wallet_cambio);

									while ($row_wallet_cambio = mysql_fetch_array($result_wallet_cambio)) {

										$idempleados_wallet = $row_wallet_cambio[idempleados_wallet];
										$columna_a = $row_wallet_cambio[token];
									}
									$valor = ($tipo_entrega_recepcion == "Egreso") ? 1 : 2;

									echo WalletInsertBitacora($idempleados_wallet, $referencia_movimiento, "Tipo de Cambio", "El tipo de cambio, cambio de <b>$row_tesorerias_traspasos[tipo_cambio]</b> por <b>$tipo_cambio</b>", $valor, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $idempleados_wallet, "Wallet", $columna_a, $tipo_entrega_recepcion, $comentarios_recurso, $columna_d, $columna_e);
								} else {
									echo "Error al actualizar el tipo de cambio <b>ECT</b>";
								}
							}
						} else {

							echo "No existe el movimiento en <b>Estado de Cuenta Traspasos</b>";
						}
					} else {
						echo "El movimiento ya fue aplicado, <b>Imposible aplicar el cambio tipo_cambio</b>";
					}
				}
			}
		} else {

			echo "No existen movimientos en logistica";
		}
	}
} elseif ($tipo_fomulario_option == "DeleteMov") {

	if ($referencia_movimiento != "") {

		$array_delete_recurso = array();
		$table_delete = "";

		$query_delete_recurso = "SELECT * FROM orden_logistica_recurso WHERE referencia = '$referencia_movimiento' ";
		$result_delete_recurso = mysql_query($query_delete_recurso);

		if (mysql_num_rows($result_delete_recurso) >= 1) {

			while ($row_delete_recurso = mysql_fetch_array($result_delete_recurso)) {

				$estatus_cobranza = (trim($row_delete_recurso[estatus]) == "Cancelado") ? "Cancelado" : Estatus_CobranzaFuncion($referencia_movimiento);

				if ($estatus_cobranza == "Pendiente") {

					#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

					$query_update_delete_recurso = "UPDATE orden_logistica_recurso SET estatus = 'Cancelado', comentarios_auditor = '$comentarios_recurso', fecha_auditada = '$fecha_guardado', usuario_auditor = '$usuario_creador' WHERE idorden_logistica_recurso = '$row_delete_recurso[idorden_logistica_recurso]' ";
					$result_update_delete_recurso = mysql_query($query_update_delete_recurso);

					($result_update_delete_recurso == 1) ? array_push($array_delete_recurso, "1") : "Error al eliminar en <b>Logística</b>";

					$table_delete .= " <b>Logística</b> ";


					#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

					$query_delete_wallet = "SELECT * FROM empleados_wallet WHERE trim(referencia_seguimiento) = '$referencia_movimiento'";
					$result_delete_wallet = mysql_query($query_delete_wallet);

					while ($row_delete_wallet = mysql_fetch_array($result_delete_wallet)) {

						$query_update_delete_wallet = "UPDATE empleados_wallet SET visible = 'NO' WHERE idempleados_wallet = '$row_delete_wallet[idempleados_wallet]'";
						$result_update_delete_wallet = mysql_query($query_update_delete_wallet);

						($result_update_delete_wallet == 1) ? array_push($array_delete_recurso, "1") : "Error al eliminar en <b>Wallet</b>";
						$idempleados_wallet = $row_delete_wallet[idempleados_wallet];
						$columna_a = $row_delete_wallet[token];
						$table_delete .= " <b>Wallet</b> ";
					}
					#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

					$query_delete_referencia_bitacora = "SELECT * FROM empleados_wallet_referencia_bitacora WHERE referencia_seguimiento WHERE referencia_seguimiento = '$referencia_movimiento' ";
					$result_delete_referencia_bitacora = mysql_query($query_delete_referencia_bitacora);

					while ($row_delete_referencia_bitacora = mysql_fetch_array($result_delete_referencia_bitacora)) {

						$query_update_delete_referencia_bitacora = "UPDATE empleados_wallet_referencia_bitacora SET visible = 'NO' WHERE idempleados_wallet_referencia_bitacora = '$row_delete_referencia_bitacora[idempleados_wallet_referencia_bitacora]'";
						$result_update_delete_referencia_bitacora = mysql_query($query_update_delete_referencia_bitacora);

						($result_update_delete_referencia_bitacora == 1) ? array_push($array_delete_recurso, "1") : "Error al eliminar en <b>Referencia Bítácora</b>";

						$table_delete .= " <b>Referencia Bítácora</b> ";
					}

					#--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					$valor = ($tipo_entrega_recepcion == "Egreso") ? 1 : 2;

					$bitacora_delete_recurso = WalletInsertBitacora($idempleados_wallet, $referencia_movimiento, "Eliminar Movimiento", "Se elimino movimiento en :$table_delete", $valor, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $idempleados_wallet, "Wallet", $columna_a, $tipo_entrega_recepcion, $comentarios_recurso, $columna_d, $columna_e);

					array_push($array_delete_recurso, $bitacora_delete_recurso);

					echo TratarNumeroText($array_delete_recurso);
				} else {

					echo "Los movimientos no se pueden eliminar debido a que <b>Ya Fue Aplicado</b>";
				}
			}
		} else {

			echo "No se encontro el movimiento";
		}
	} else {

		echo "Nada que hacer";
	}
} elseif ($tipo_fomulario_option == "SolicitarToken") {

	$id_solicitud_token = trim($_POST['idcolaboratorsolicitartoken']);

	$nombre_colaborador_solitar_token = explode("|", nombres_datos($id_solicitud_token, "Colaborador"));


	$query_token_wallet = "SELECT * FROM empleados_wallet WHERE visible = 'SI' AND referencia_seguimiento = '$referencia_movimiento'";
	$result_token_wallet = mysql_query($query_token_wallet);

	while ($row_token_wallet = mysql_fetch_array($result_token_wallet)) {

		$id_token = $row_token_wallet[id];
		$tipo_id_token = $row_token_wallet[tipo_id];
		$idempleados_wallet_token = $row_token_wallet[idempleados_wallet];
		$valor_token = ($row_token_wallet[idempleados_wallet] == "Ingreso") ? 2 : 1;
		$id_id_token = $row_token_wallet[idlogistica];
		$token_token = $row_token_wallet[token];
		$tipo_movimiento_token = $row_token_wallet[tipo];
	}

	$nombre_id_token = explode("|", nombres_datos($id_token, $tipo_id_token));

	$mensaje_solicitar_token_bd = "<b>$nombre_colaborador_solitar_token[2]</b> Solicito un token para poder realizar un movimiento del ID: $id_token.$nombre_id_token[10] de la referencia <b>$referencia_movimiento</b> del movimiento <b>$idempleados_wallet_token</b>";
	$mensaje_solicitar_token_wh = "*$nombre_colaborador_solitar_token[2]* Solicito un token para poder realizar un movimiento del ID: $id_token.$nombre_id_token[10] de la referencia *$referencia_movimiento* del movimiento *$idempleados_wallet_token*";

	$solicitando_token = WalletInsertBitacora($idempleados_wallet_token, $referencia_movimiento, "Token Movimiento", $mensaje_solicitar_token_bd, $valor_token, 'SI', $usuario_creador, $fecha_creacion, $fecha_guardado, $id_id_token, "Logistica", $token_token, $tipo_movimiento_token, $columna_c, $columna_d, $columna_e);

	echo ($solicitando_token == 1) ? "1|https://api.whatsapp.com/send?phone=$nombre_colaborador_solitar_token[3]&text=$mensaje_solicitar_token_wh" : "$query_token_wallet";
	#
} elseif ($tipo_fomulario_option == "BusquedaReferenciaToken") {

	$query_busqueda_referencia_token = "SELECT * FROM empleados_wallet WHERE visible = 'SI' AND trim(referencia_seguimiento) = '$referencia_movimiento'";
	$result_busqueda_referencia_token = mysql_query($query_busqueda_referencia_token);

	if (mysql_num_rows($result_busqueda_referencia_token) >= 1) {

		while ($row_busqueda_referncia_token = mysql_fetch_array($result_busqueda_referencia_token)) {

			$idtoken = $row_busqueda_referncia_token[id];
			$gran_total_token = $row_busqueda_referncia_token[gran_total];
		}

		$codigo_token = trim(generate_token(""));

		echo "1|$codigo_token|$idtoken|$gran_total_token";
	} else {

		echo "0|<b>La referencia no existe</b>";
	}
} elseif ($tipo_fomulario_option == "GenerarTokenDesbloqueo") {

	$folio = trim($_POST['folio']);
	$idcolaborador_token = trim($_POST['idcolaborador_token']);
	$codigo = trim($_POST['codigo']);
	$fecha_movimiento = date("Y-m-d");
	$idcontacto = trim($_POST['idcontacto']);
	$monto_mx = trim($_POST['monto_mx']);

	$query_bitacora_token_wallet = "SELECT * FROM wallet_bitacora WHERE visible = 'SI' AND referencia = '$folio' AND tipo = 'Token Movimiento'";
	$result_bitacora_token_wallet = mysql_query($query_bitacora_token_wallet);

	while ($row_bitacora_token_wallet = mysql_fetch_array($result_bitacora_token_wallet)) {

		$idempleados_wallet = $row_bitacora_token_wallet[idwallet_bitacora];
		$valor = $row_bitacora_token_wallet[valor];
		$id_id = $row_bitacora_token_wallet[idwallet_bitacora];
		$columna_b = $row_bitacora_token_wallet[columna_b];

		$responsable_token_solicito = explode("|", NameUsuarioCreador($row_bitacora_token_wallet[usuario_creador]));
	}


	$insertar_token_desbloqueo = CodigoAutorizacionWallet($codigo, "Pendiente", $idcolaborador_token, $usuario_creador, $empleados, "SI", $fecha_creacion, $fecha_guardado, $folio, $fecha_movimiento, $idcontacto, $monto_mx);

	$numero_wahts = ($responsable_token_solicito[3] != "" and $responsable_token_solicito[3] != "Pendiente") ? $responsable_token_solicito[3] : "0000000000";

	$mensaje_solicitar_token_bd = ($responsable_token_solicito[1] != "" and $responsable_token_solicito[1] != "Pendiente") ? "<b>$responsable_token_solicito[1]</b> el token es: <b>$codigo</b> de la referencia: <b>$folio</b> solicitada." : "el token es: <b>$codigo</b> de la referencia: <b>$folio</b>";

	$mensaje_solicitar_token_wh = ($responsable_token_solicito[1] != "" and $responsable_token_solicito[3] != "Pendiente") ? "*$responsable_token_solicito[1]* el token es: *$codigo* de la referencia: *$folio* solicitada." : "el token es: *$codigo* de la referencia: *$folio*";

	$insertar_bitacora_desbloqueo = WalletInsertBitacora($idempleados_wallet, $folio, 'Token Respuesta', $mensaje_solicitar_token_bd, $valor, "SI", $usuario_creador, $fecha_creacion, $fecha_guardado, $id_id, "Wallet Bitácora", "", $columna_b, $columna_c, $columna_d, $columna_e);

	$mesaje_whatssap = ($insertar_token_desbloqueo == 1) ? "https://api.whatsapp.com/send?phone=$numero_wahts&text=$mensaje_solicitar_token_wh" : "";

	echo ($insertar_bitacora_desbloqueo == 1 and $insertar_token_desbloqueo) ? "1|$mesaje_whatssap" : "$insertar_token_desbloqueo $insertar_bitacora_desbloqueo|$mesaje_whatssap";

	#
} else {

	echo "- El movimiento <b>$tipo_fomulario_option</b> No existe";
}



function ComprobarActualizarID($idorden_logistica_documentacion, $idcliente, $tipo_contacto_id, $idorden_logistica_recurso, $movimiento_recurso, $idorden_logistica)
{

	$idorden_logistica_documentacion = trim($idorden_logistica_documentacion);
	$idcliente = trim($idcliente);
	$tipo_contacto_id = trim($tipo_contacto_id);

	$query_comprobar_id = "SELECT * FROM orden_logistica_documentacion WHERE idorden_logistica_documentacion = '$idorden_logistica_documentacion'";
	$result_comprobar_id = mysql_query($query_comprobar_id);

	if (mysql_num_rows($result_comprobar_id) == 0) {

		$mensaje_comprobar_id = "- No existen movimientos en <b>logística</b>";
	} else {

		while ($row_comprobar_id = mysql_fetch_array($result_comprobar_id)) {



			$valores_id_search = explode("|", nombres_datos($idcliente, $tipo_contacto_id));



			if ($valores_id_search[11] == "Cliente") {

				$tipo_id_wallet = "Cliente";
				$tabla = "estado_cuenta";
			} else if ($valores_id_search[11] == "Proveedor") {

				$tipo_id_wallet = "Proveedor";

				$tabla = (trim($valores_id_search[12]) == "8") ? "estado_cuenta_proveedores" : "estado_cuenta_requisicion";
			} else if ($valores_id_search[11] == "Proveedor Info" || $valores_id_search[11] == "Transacciones") {

				if (trim($valores_id_search[12]) == "Bienes Raices") {

					$tipo_id_wallet = "Bienes Raices";
					$tabla = "proveedores_bienes_raices_estado_cuenta";
				} else if (trim($valores_id_search[12]) == "Prestamos") {

					$tipo_id_wallet = "Prestamos";
					$tabla = "proveedores_prestamos_estado_cuenta";
				} else if (trim($valores_id_search[12]) == "Transacciones") {

					$tipo_id_wallet = "Transacciones";
					$tabla = "proveedores_transacciones_estado_cuenta";
				} else {

					$tipo_id_wallet = "Pendiente";
					$tabla = "Pendiente";
				}
			} else if ($valores_id_search[11] == "Colaborador") {

				$tipo_id_wallet = "Colaborador";
				$tabla = "Pendiente";
			} else if ($valores_id_search[11] == "Proveedor Temporal") {

				$tipo_id_wallet = "Proveedor Temporal";
				$tabla = "Pendiente";
			} else {

				$tipo_id_wallet = "Pendiente";
				$tabla = "Pendiente";
			}

			#----------------------------------------- Mensaje de Cambio -----------------------------------------

			$nombre_buscar_bd = explode("|", nombres_datos($row_comprobar_id[id_responsable], $row_comprobar_id[tipo_responsable]));
			$nombre_bd = "$row_comprobar_id[id_responsable].$nombre_buscar_bd[10]";

			$nombre_new = "$idcliente.$valores_id_search[10]";

			$mensaje_change = "El ID cambio de <b>$nombre_bd</b> por <b>$nombre_new</b>";

			#----------------------------------------- Mensaje de Cambio -----------------------------------------


			if (trim($row_comprobar_id[id_responsable]) == $idcliente and  trim($row_comprobar_id[tipo_responsable]) == $tipo_contacto_id) {

				$mensaje_comprobar_id = "- El nuevo <b>ID</b> que intentas cambiar es el mismo que se tiene en sistema $nombre_bd";
			}
			if ($idcliente == "" and $tipo_contacto_id == "") {

				$mensaje_comprobar_id = "- No seleccionaste <b>NADA</b>";
			} else {

				$query_update_logistica = "UPDATE orden_logistica SET idcontacto = '$idcliente', tipo_contacto = '$tipo_contacto_id' WHERE idorden_logistica = '$idorden_logistica' ";
				$result_update_logistica = mysql_query($query_update_logistica);

				if ($result_update_logistica == 1) {

					if (trim($movimiento_recurso) == "Entrega") {

						$update_name_recurso = "UPDATE orden_logistica_recurso SET receptora_institucion = '$nombre_new', receptora_agente = '$nombre_new' WHERE idorden_logistica_recurso = '$idorden_logistica_recurso'";
						$result_name_recurso = mysql_query($update_name_recurso);

						$mensaje_comprobar_id = ($result_name_recurso == 1) ? "1|$idcliente|$tipo_id_wallet|$tabla|$mensaje_change" : "Error al actulizar ID Egreso";
					} else {

						$update_name_recurso = "UPDATE orden_logistica_recurso SET emisora_institucion = '$nombre_new', emisora_agente = '$nombre_new' WHERE idorden_logistica_recurso = '$idorden_logistica_recurso'";
						$result_name_recurso = mysql_query($update_name_recurso);

						$mensaje_comprobar_id = ($result_name_recurso == 1) ? "1|$idcliente|$tipo_id_wallet|$tabla|$mensaje_change" : "Error al actulizar ID Ingreso";
					}
				} else {

					$mensaje_comprobar_id = "Error al actualizar logística";
				}
			}
		}
	}

	return $mensaje_comprobar_id;
}
