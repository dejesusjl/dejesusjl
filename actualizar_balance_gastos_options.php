<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales_insert.php";
include_once "funciones_principales.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
$date_movimiento = date("Y-m-d");





$concepto = $_POST['concepto_balance'];
$responsable_individual = $_POST['responsable_individual'];
$fecha_balance = $_POST['fecha_balance'];
$gran_total = $_POST['gran_total_balance'];
$datos_vin = $_POST['search_vin_balance'];
$archivo = $_POST['archivo'];

$array_auxiliares = explode("|", $_POST['auxiliares_balance']);


$comentarios = trim($_POST['comentarios_balance']);
$idbalance_gastos_operacion_encriptada = $_POST['idbalance_gastos_operacion'];
$idbalance_gastos_operacion = base64_decode($idbalance_gastos_operacion_encriptada);
$tipo_formulario = $_POST['balance_tipo_formulario'];
$fecha_creacion = $_POST['fecha_creacion_balance'];
$coordenadas = trim($_POST['coordenadas']);
$visible = "SI";



$query_balance_movimiento = "SELECT * FROM balance_gastos_operacion WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
$result_balance_movimiento = mysql_query($query_balance_movimiento);

if (mysql_num_rows($result_balance_movimiento) == 0) {

	$mensaje = "No existe el movimiento";
} else {

	while ($row_balance_movimiento = mysql_fetch_array($result_balance_movimiento)) {

		if ($tipo_formulario == "Evidencia") {
			#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------			
			$ruta_archivo = "../../Balance_Gastos_Evidencia/";
			$nomenclatura_archivo_name = $row_herramientas[tipo] . "_" . $row_herramientas[vin] . "_Usr_" . $usuario_creador . "_date_" . $fecha_guardado;
			$name_input_file = "evidencia_balance";

			$target_path = $ruta_archivo . $nomenclatura_archivo_name . "_" . basename($_FILES[$name_input_file]['name']);

			$estatus_evidencia = CargarImagenEvidenciaIndividual($ruta_archivo, $name_input_file, $target_path);


			if ($estatus_evidencia == "- Ocurrio un error al mover la Evidencia <br>" || $estatus_evidencia == "La carpeta $ruta_archivo no existe") {

				$mensaje = $estatus_evidencia;
			}

			if ($estatus_evidencia == "- Ocurrio un error al mover la Evidencia <br>" || $estatus_evidencia == "La carpeta $ruta_archivo no existe") {

				$mensaje = $estatus_evidencia;
			} else {

				$query_update_evidencia = "UPDATE balance_gastos_operacion SET archivo = '$estatus_evidencia' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
				$result_update_evidencia = mysql_query($query_update_evidencia);

				if ($result_update_evidencia == 1) {


					if (file_exists($row_balance_movimiento[archivo])) {

						$evidencia_bd = "<a href=\'$row_balance_movimiento[valor]\' target=\'_blank\'><i class=\'far fa-image fa-2x\'></i><a>";
						$evidencia_nueva = "<a href=\'$estatus_evidencia\' target=\'_blank\'><i class=\'fas fa-image fa-2x\'></i><a>";

						$mesage_evidencia = "La evidencia cambio de: $evidencia_bd por $evidencia_nueva en $row_balance_movimiento[tipo_movimiento]";
					} else {

						$evidencia_nueva = "<a href=\'$estatus_evidencia\' target=\'_blank\' ><i class=\'far fa-image fa-2x\'></i><a>";
						$mesage_evidencia = "Se agregó nueva evidencia: $evidencia_nueva en $row_balance_movimiento[tipo_movimiento]";
					}

					$evidencia_bitacora = BalanceInsertBitacora($mesage_evidencia, "Evidencia", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "6", $idbalance_gastos_operacion, $columna_d, $visible);
					$mensaje = ($evidencia_bitacora == 1) ? 1 : $evidencia_bitacora;
				} else {

					$mensaje = "Error al guardar el archivo " . $_FILES[$name_input_file]['name'];
				}
			}
		} elseif ($tipo_formulario == "Concepto") {
			#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

			$concepto_bd = trim($row_balance_movimiento[concepto]);

			if ($concepto == "") {

				$mensaje = "El Concepto viene vacío";
			} else {

				if ($concepto == $concepto_bd) {

					$mensaje = "El Concepto es el mismo al que se tiene en sistema";
				} else {

					$add_condicion_concepto = (trim($concepto) == "CARGA DE COMBUSTIBLE" || trim($concepto) == "Carga de Combustible") ? ", columna5 = '', columna6 = '' " : "";

					if (trim($row_balance_movimiento[tipo_movimiento]) == "cargo") {

						$query_concepto_cargo = "SELECT * FROM balance_gastos_operacion WHERE trim(columna3) = $idbalance_gastos_operacion";
						$result_concepto_cargo = mysql_query($query_concepto_cargo);

						if (mysql_num_rows($result_concepto_cargo) == 0) {

							$query_update_concepto = "UPDATE balance_gastos_operacion SET concepto = '$concepto' $add_condicion_concepto WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
							$result_update_concepto = mysql_query($query_update_concepto);

							if ($result_update_concepto == 1) {

								$mesage_concepto = "El concepto cambio de <b>$concepto_bd</b> a <b>$concepto</b> en $row_balance_movimiento[tipo_movimiento]";
								$evidencia_bitacora = BalanceInsertBitacora($mesage_concepto, "Concepto", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "7", $idbalance_gastos_operacion, $columna_d, $visible);
								$mensaje = ($evidencia_bitacora == 1) ? 1 : $evidencia_bitacora;
							} else {
								$mensaje = "- Error al modificar el <b>$concepto</b> en el movimiento $row_balance_movimiento[tipo_movimiento]</b>";
							}
						} else {

							while ($row_concepto_cargo = mysql_fetch_array($result_concepto_cargo)) {

								$query_cargo_concepto = "UPDATE balance_gastos_operacion SET concepto = '$concepto' $add_condicion_concepto WHERE idbalance_gastos_operacion = '$row_concepto_cargo[idbalance_gastos_operacion]'";
								$result_cargo_concepto = mysql_query($query_cargo_concepto);

								if ($result_cargo_concepto == 1) {

									$query_update_concepto = "UPDATE balance_gastos_operacion SET concepto = '$concepto' $add_condicion_concepto WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
									$result_update_concepto = mysql_query($query_update_concepto);

									if ($result_update_concepto == 1) {

										$mesage_concepto = "El concepto cambio de <b>$concepto_bd</b> a <b>$concepto</b> en $row_balance_movimiento[tipo_movimiento]";
										$evidencia_bitacora = BalanceInsertBitacora($mesage_concepto, "Concepto", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "7", $idbalance_gastos_operacion, $columna_d, $visible);
										$evidencia_bitacora_cargo = BalanceInsertBitacora($mesage_concepto, "Concepto", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "7", $row_concepto_cargo[idbalance_gastos_operacion], $columna_d, $visible);

										$mensaje = ($evidencia_bitacora == 1 and $evidencia_bitacora_cargo == 1) ? 1 : $evidencia_bitacora;
									} else {
										$mensaje = "- Error al modificar el <b>$concepto</b> en el movimiento $row_balance_movimiento[tipo_movimiento]</b>";
									}
								} else {

									$mensaje = "- Error al modificar el <b>$concepto</b> en el movimiento $row_concepto_cargo[tipo_movimiento]</b>";
								}
							}
						}
					} else { #Abono

						if (trim($row_balance_movimiento[columna3]) == "") {

							$query_update_concepto = "UPDATE balance_gastos_operacion SET concepto = '$concepto' $add_condicion_concepto WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
							$result_update_concepto = mysql_query($query_update_concepto);

							if ($result_update_concepto == 1) {

								$mesage_concepto = "El concepto cambio de <b>$concepto_bd</b> a <b>$concepto</b> en $row_balance_movimiento[tipo_movimiento]";
								$evidencia_bitacora = BalanceInsertBitacora($mesage_concepto, "Concepto", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "7", $idbalance_gastos_operacion, $columna_d, $visible);
								$mensaje = ($evidencia_bitacora == 1) ? 1 : $evidencia_bitacora;
							} else {
								$mensaje = "- Error al modificar el <b>$concepto</b> en el movimiento $row_balance_movimiento[tipo_movimiento]</b>";
							}
						} else {

							$query_update_concepto = "UPDATE balance_gastos_operacion SET concepto = '$concepto' $add_condicion_concepto WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
							$result_update_concepto = mysql_query($query_update_concepto);

							$query_abono_concepto = "UPDATE balance_gastos_operacion SET concepto = '$concepto' $add_condicion_concepto WHERE idbalance_gastos_operacion = '$row_balance_movimiento[columna3]'";
							$result_abono_concepto = mysql_query($query_abono_concepto);



							if ($result_update_concepto == 1 and $result_abono_concepto == 1) {

								$mesage_concepto = "El concepto cambio de <b>$concepto_bd</b> a <b>$concepto</b> en $row_balance_movimiento[tipo_movimiento]";
								$evidencia_bitacora = BalanceInsertBitacora($mesage_concepto, "Concepto", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "7", $idbalance_gastos_operacion, $columna_d, $visible);
								$evidencia_bitacora_abono = BalanceInsertBitacora($mesage_concepto, "Concepto", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "7", $row_balance_movimiento[columna3], $columna_d, $visible);


								$mensaje = ($evidencia_bitacora == 1 and $evidencia_bitacora_abono == 1) ? 1 : $evidencia_bitacora;
							} else {
								$mensaje = "- Error al modificar el <b>$concepto</b> en el movimiento $row_balance_movimiento[tipo_movimiento]</b>";
							}
						}
					}
				}
			}
		} elseif ($tipo_formulario == "AuxiliarIndividual") {

			$tratar_array_individual = Tratar_Array($array_auxiliares);


			if (count($tratar_array_individual) == 0) {

				$mensaje = "No Ingresaste ningún <b>Auxiliar</b>";
			} else {

				if (trim($row_balance_movimiento[tipo_movimiento]) == "cargo") {

					$query_auxiliar_abono = "SELECT * FROM balance_gastos_operacion WHERE columna3 = '$idbalance_gastos_operacion'";
					$result_auxiliar_abono = mysql_query($query_auxiliar_abono);

					if (mysql_num_rows($result_auxiliar_abono) == 0) {

						$mandar_aux_cargo = VerificarAuxiliares_balance($tratar_array_individual, $idbalance_gastos_operacion, $row_balance_movimiento[idauxiliar_principales], $row_balance_movimiento[columna2], $row_balance_movimiento[apartado_usado], $date_movimiento, $fecha_creacion, $fecha_guardado, $visible, $usuario_creador);

						$mesage_auxiliar_individual_cargo = "Se agregaron auxiliares en el <b>$row_balance_movimiento[tipo_movimiento]</b>";
						$mensaje = BalanceInsertBitacora($mesage_auxiliar_individual_cargo, "Auxiliar Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "9", $idbalance_gastos_operacion, $columna_d, $visible);
					} else {

						while ($row_auxiliar_abono = mysql_fetch_array($result_auxiliar_abono)) {

							$tipo_movimientorow_auxiliar_abono = $row_auxiliar_abono[tipo_movimiento];
							$idbalance_gastos_operacion_abono = $row_auxiliar_abono[idbalance_gastos_operacion];

							$insert_abono_auxiliar = VerificarAuxiliares_balance($tratar_array_individual, $row_auxiliar_abono[idbalance_gastos_operacion], $row_auxiliar_abono[idauxiliar_principales], $row_auxiliar_abono[columna2], $row_auxiliar_abono[apartado_usado], $date_movimiento, $fecha_creacion, $fecha_guardado, $visible, $usuario_creador);
						}
					}

					$insert_cargo_auxiliar = VerificarAuxiliares_balance($tratar_array_individual, $idbalance_gastos_operacion, $row_balance_movimiento[idauxiliar_principales], $row_balance_movimiento[columna2], $row_balance_movimiento[apartado_usado], $date_movimiento, $fecha_creacion, $fecha_guardado, $visible, $usuario_creador);

					$mesage_auxiliar_individual_cargo = "Se agregaron auxiliares en el <b>$row_balance_movimiento[tipo_movimiento]</b>";
					$mesage_auxiliar_individual_abono = "Se agregaron auxiliares en el <b>$tipo_movimientorow_auxiliar_abono</b>";


					if ($insert_cargo_auxiliar == 1 and $insert_abono_auxiliar == 1) {

						$bitacora_auxiliar_cargo = BalanceInsertBitacora($mesage_auxiliar_individual_cargo, "Auxiliar Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "9", $idbalance_gastos_operacion, $columna_d, $visible);
						$bitacora_auxiliar_abono = BalanceInsertBitacora($mesage_auxiliar_individual_abono, "Auxiliar Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "9", $idbalance_gastos_operacion_abono, $columna_d, $visible);

						$mensaje = 1;
					} else if ($insert_cargo_auxiliar == 1 and $insert_abono_auxiliar == 0) {

						$bitacora_auxiliar_cargo = BalanceInsertBitacora($mesage_auxiliar_individual_cargo, "Auxiliar Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "9", $idbalance_gastos_operacion, $columna_d, $visible);
						$mensaje = "- Cargo: Correcto. Abono: $insert_abono_auxiliar";
					} else if ($insert_cargo_auxiliar == 0 and $insert_abono_auxiliar == 1) {

						$bitacora_auxiliar_abono = BalanceInsertBitacora($mesage_auxiliar_individual_abono, "Auxiliar Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "9", $idbalance_gastos_operacion_abono, $columna_d, $visible);

						$mensaje = "- Abono: Correcto. Cargo: $insert_cargo_auxiliar";
					} else if ($insert_cargo_auxiliar == 0 and $insert_abono_auxiliar == 0) {

						$mensaje = "Error al actualizar el cargo y el abono $insert_cargo_auxiliar $insert_abono_auxiliar";
					}
				} else {

					if (trim($row_balance_movimiento[columna3]) == "") {

						$mandar_aux_abono = VerificarAuxiliares_balance($tratar_array_individual, $idbalance_gastos_operacion, $row_balance_movimiento[idauxiliar_principales], $row_balance_movimiento[columna2], $row_balance_movimiento[apartado_usado], $date_movimiento, $fecha_creacion, $fecha_guardado, $visible, $usuario_creador);

						$mesage_auxiliar_individual_abono = "Se agregaron auxiliares en el <b>$row_balance_movimiento[tipo_movimiento]</b>";
						$mensaje = BalanceInsertBitacora($mesage_auxiliar_individual_abono, "Auxiliar Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "9", $idbalance_gastos_operacion, $columna_d, $visible);
					} else {

						$insert_abono_auxiliar = VerificarAuxiliares_balance($tratar_array_individual, $idbalance_gastos_operacion, $row_balance_movimiento[idauxiliar_principales], $row_balance_movimiento[columna2], $row_balance_movimiento[apartado_usado], $date_movimiento, $fecha_creacion, $fecha_guardado, $visible, $usuario_creador);

						$insert_cargo_auxiliar = VerificarAuxiliares_balance($tratar_array_individual, $row_balance_movimiento[columna3], $row_balance_movimiento[idauxiliar_principales], $row_balance_movimiento[columna2], $row_balance_movimiento[apartado_usado], $date_movimiento, $fecha_creacion, $fecha_guardado, $visible, $usuario_creador);


						$mesage_auxiliar_individual_abono = "Se agregaron auxiliares en el <b>$row_balance_movimiento[tipo_movimiento]</b>";
						$mesage_auxiliar_individual_cargo = "Se agregaron auxiliares en el <b>cargo</b>";


						if ($insert_cargo_auxiliar == 1 and $insert_abono_auxiliar == 1) {


							$bitacora_auxiliar_cargo = BalanceInsertBitacora($mesage_auxiliar_individual_abono, "Auxiliar Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "9", $row_balance_movimiento[columna3], $columna_d, $visible);
							$bitacora_auxiliar_abono = BalanceInsertBitacora($mesage_auxiliar_individual_cargo, "Auxiliar Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "9", $idbalance_gastos_operacion, $columna_d, $visible);

							$mensaje = 1;
						} else if ($insert_cargo_auxiliar == 1 and $insert_abono_auxiliar == 0) {

							$bitacora_auxiliar_cargo = BalanceInsertBitacora($mesage_auxiliar_individual_abono, "Auxiliar Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "9", $row_balance_movimiento[columna3], $columna_d, $visible);
							$mensaje = "- Cargo: Correcto. Abono: $insert_abono_auxiliar";
						} else if ($insert_cargo_auxiliar == 0 and $insert_abono_auxiliar == 1) {

							$bitacora_auxiliar_abono = BalanceInsertBitacora($mesage_auxiliar_individual_cargo, "Auxiliar Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "9", $idbalance_gastos_operacion, $columna_d, $visible);

							$mensaje = "- Abono: Correcto. Cargo: $insert_cargo_auxiliar";
						} else if ($insert_cargo_auxiliar == 0 and $insert_abono_auxiliar == 0) {

							$mensaje = "Error al actualizar el cargo y el abono $insert_cargo_auxiliar $insert_abono_auxiliar";
						}
					}
				}
			}
		} elseif ($tipo_formulario == "Fechas") {

			if ($fecha_balance == "") {

				$mensaje = "<b>No hay fecha</b>";
			} elseif ($fecha_balance == $row_balance_movimiento[fecha_movimiento]) {

				$mensaje = "<b>La fecha es la misma a la que se tiene en sistema</b>";
			} else {

				$mesage_fecha = "La fecha cambio de <b>$row_balance_movimiento[fecha_movimiento]</b> a <b>$fecha_balance</b> en $row_balance_movimiento[tipo_movimiento]";

				if ($row_balance_movimiento[tipo_movimiento] == "cargo") {

					$query_fecha_abono = "SELECT * FROM balance_gastos_operacion WHERE columna3 = '$idbalance_gastos_operacion'";
					$result_fecha_abono = mysql_query($query_fecha_abono);

					if (mysql_num_rows($result_fecha_abono) == 0) {

						$query_update_fecha = "UPDATE balance_gastos_operacion SET fecha_movimiento = '$fecha_balance' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
						$result_update_fecha = mysql_query($query_update_fecha);

						if ($result_update_fecha == 1) {

							$change_dates_auxiliares = ActualizarFecha_Auxiliares($idbalance_gastos_operacion, $fecha_balance);

							if ($change_dates_auxiliares == 1) {

								$mensaje = BalanceInsertBitacora($mesage_fecha, "Fecha Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "11", $idbalance_gastos_operacion, $columna_d, $visible);
							}
						} else {
							$mensaje = "<b>Error al actualizar la fecha en $row_balance_movimiento[tipo_movimiento]</b>";
						}
					} else {

						while ($row_fecha_abono = mysql_fetch_array($result_fecha_abono)) {

							$idbalance_gastos_operacion_fecha_abono	= $row_fecha_abono[idbalance_gastos_operacion];
						}

						$query_update_fecha = "UPDATE balance_gastos_operacion SET fecha_movimiento = '$fecha_balance' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
						$result_update_fecha = mysql_query($query_update_fecha);

						if ($result_update_fecha == 1) {

							$change_dates_auxiliares = ActualizarFecha_Auxiliares($idbalance_gastos_operacion, $fecha_balance);

							$bitacora_fecha_cargo = BalanceInsertBitacora($mesage_fecha, "Fecha Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "11", $idbalance_gastos_operacion, $columna_d, $visible);

							if ($change_dates_auxiliares == 1 and $bitacora_fecha_cargo == 1) {

								$query_update_fecha_abono = "UPDATE balance_gastos_operacion SET fecha_movimiento = '$fecha_balance' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion_fecha_abono'";
								$result_update_fecha_abono = mysql_query($query_update_fecha_abono);

								if ($result_update_fecha_abono == 1) {

									$change_dates_auxiliares_abono = ActualizarFecha_Auxiliares($idbalance_gastos_operacion_fecha_abono, $fecha_balance);

									if ($change_dates_auxiliares_abono == 1) {

										$mesage_fecha_abono = "La fecha cambio de <b>$row_balance_movimiento[fecha_movimiento]</b> a <b>$fecha_balance</b> en abono";
										$mensaje = BalanceInsertBitacora($mesage_fecha_abono, "Fecha Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "11", $idbalance_gastos_operacion_fecha_abono, $columna_d, $visible);
									} else {

										$mensaje = $change_dates_auxiliares_abono;
									}
								} else {

									$mensaje = "<b>Error al actualizar la fecha en abono</b>";
								}
							} else {

								$mensaje = "-Error al actualizar el abono y <br>" . $change_dates_auxiliares . "<br>" . $bitacora_fecha_cargo;
							}
						} else {

							$mensaje = "<b>Error al actualizar la fecha en $row_balance_movimiento[tipo_movimiento]</b>";
						}
					}
				} else {

					if ($row_balance_movimiento[columna3] == "") {

						$query_update_fecha = "UPDATE balance_gastos_operacion SET fecha_movimiento = '$fecha_balance' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
						$result_update_fecha = mysql_query($query_update_fecha);

						if ($result_update_fecha == 1) {

							$change_dates_auxiliares = ActualizarFecha_Auxiliares($idbalance_gastos_operacion, $fecha_balance);

							if ($change_dates_auxiliares == 1) {

								$mensaje = BalanceInsertBitacora($mesage_fecha, "Fecha Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "11", $idbalance_gastos_operacion, $columna_d, $visible);
							}
						} else {

							$mensaje = "<b>Error al actualizar la fecha en $row_balance_movimiento[tipo_movimiento]</b>";
						}
					} else {

						$query_update_fecha = "UPDATE balance_gastos_operacion SET fecha_movimiento = '$fecha_balance' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
						$result_update_fecha = mysql_query($query_update_fecha);

						if ($result_update_fecha == 1) {

							$change_dates_auxiliares = ActualizarFecha_Auxiliares($idbalance_gastos_operacion, $fecha_balance);

							$bitacora_fecha_abono = BalanceInsertBitacora($mesage_fecha, "Fecha Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "11", $idbalance_gastos_operacion, $columna_d, $visible);

							if ($change_dates_auxiliares == 1 and $bitacora_fecha_abono == 1) {

								$query_update_fecha_cargo = "UPDATE balance_gastos_operacion SET fecha_movimiento = '$fecha_balance' WHERE idbalance_gastos_operacion = '$row_balance_movimiento[columna3]'";
								$result_update_fecha_cargo = mysql_query($query_update_fecha_cargo);

								if ($result_update_fecha_cargo == 1) {

									$change_dates_auxiliares_cargo = ActualizarFecha_Auxiliares($row_balance_movimiento[columna3], $fecha_balance);

									if ($change_dates_auxiliares_cargo == 1) {

										$mesage_fecha_cargo = "La fecha cambio de <b>$row_balance_movimiento[fecha_movimiento]</b> a <b>$fecha_balance</b> en cargo";
										$mensaje = BalanceInsertBitacora($mesage_fecha_cargo, "Fecha Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "11", $row_balance_movimiento[columna3], $columna_d, $visible);
									} else {

										$mensaje = $change_dates_auxiliares_cargo;
									}
								} else {

									$mensaje = "<b>Error al actualizar la fecha en abono</b>";
								}
							} else {

								$mensaje = "-Error al actualizar el abono y <br>" . $change_dates_auxiliares . "<br>" . $bitacora_fecha_abono;
							}
						} else {

							$mensaje = "<b>Error al actualizar la fecha en $row_balance_movimiento[tipo_movimiento]</b>";
						}
					}
				}
			}
		} elseif ($tipo_formulario == "MontoBalance") {


			$gran_total = trim($gran_total);
			$gran_total = str_replace(",", "", $gran_total);

			if ($gran_total == "") {

				$mensaje = "<b>No hay monto</b>";
			} elseif ($gran_total == $row_balance_movimiento[gran_total]) {

				$mensaje = "<b>el monto es el mismo al que se tiene en sistema</b>";
			} else {



				$monto_format_old = number_format($row_balance_movimiento[gran_total], 2);
				$monto_format_new = number_format($gran_total, 2);

				$mensaje_monto = "El monto cambio de <b>$$monto_format_old</b> a <b>$$monto_format_new</b> en $row_balance_movimiento[tipo_movimiento]";

				if ($row_balance_movimiento[tipo_movimiento] == "cargo") {

					$select_monto_abono = "SELECT * FROM balance_gastos_operacion WHERE columna3 = '$idbalance_gastos_operacion'";
					$query_monto_abono = mysql_query($select_monto_abono);

					if (mysql_num_rows($query_monto_abono) >= 1) {

						while ($row_monto_abono = mysql_fetch_array($query_monto_abono)) {

							$idbalance_monto_abono = $row_monto_abono[idbalance_gastos_operacion];
						}

						$query_update_monto_cargo = "UPDATE balance_gastos_operacion SET saldo_anterior = '0', saldo = '$gran_total', monto_precio = '$gran_total', monto_total = '$gran_total', tipo_moneda = 'MXN', tipo_cambio = '1', gran_total = '$gran_total', cargo = '$gran_total' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
						$result_update_monto_cargo = mysql_query($query_update_monto_cargo);

						$query_update_monto_abono = "UPDATE balance_gastos_operacion SET saldo_anterior = '0', saldo = '$gran_total', monto_precio = '$gran_total', monto_total = '$gran_total', tipo_moneda = 'MXN', tipo_cambio = '1', gran_total = '$gran_total', abono = '$gran_total' WHERE idbalance_gastos_operacion = '$idbalance_monto_abono'";
						$result_update_monto_abono = mysql_query($query_update_monto_abono);

						$mensaje_monto_abono = "El monto cambio de <b>$$monto_format_old</b> a <b>$$monto_format_new</b> en abono";

						if ($result_update_monto_cargo == 1 and $result_update_monto_abono == 1) {

							$monto_bitacora_cargo = BalanceInsertBitacora($mensaje_monto, "Monto", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "12", $idbalance_gastos_operacion, $columna_d, $visible);

							$monto_bitacora_abono = BalanceInsertBitacora($mensaje_monto_abono, "Monto", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "12", $idbalance_monto_abono, $columna_d, $visible);


							if ($monto_bitacora_cargo == 1 and $monto_bitacora_abono == 1) {

								$mensaje = 1;
							} elseif ($monto_bitacora_cargo == 1 and $monto_bitacora_abono == 0) {

								$mensaje = "Cargo y Abono actualizados exitosamente pero con error de Bitácora en el Abono: $monto_bitacora_abono";
							} else if ($monto_bitacora_cargo == 0 and $monto_bitacora_abono == 1) {

								$mensaje = "Cargo y Abono actualizados exitosamente pero con error de Bitácora en el Cargo: $monto_bitacora_cargo";
							} else if ($monto_bitacora_cargo == 0 and $monto_bitacora_abono == 1) {

								$mensaje = "Cargo y Abono actualizados exitosamente pero con error de Bitácora en el Cargo: $monto_bitacora_cargo y en el Abono: $monto_bitacora_abono";
							}
						}
					} else {

						$query_update_monto_cargo = "UPDATE balance_gastos_operacion SET saldo_anterior = '0', saldo = '$gran_total', monto_precio = '$gran_total', monto_total = '$gran_total', tipo_moneda = 'MXN' tipo_cambio = '1', gran_total = '$gran_total', cargo = '$gran_total' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
						$result_update_monto_cargo = mysql_query($query_update_monto_cargo);

						if ($result_update_monto_cargo == 1) {

							$mensaje = BalanceInsertBitacora($mensaje_monto, "Monto", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "12", $idbalance_gastos_operacion, $columna_d, $visible);
						} else {

							$mensaje = "Error al actualizar el movimiento cargo";
						}
					}
				} else {

					if ($row_balance_movimiento[columna3] != "") {

						$query_update_monto_abono = "UPDATE balance_gastos_operacion SET saldo_anterior = '0', saldo = '$gran_total', monto_precio = '$gran_total', monto_total = '$gran_total', tipo_moneda = 'MXN', tipo_cambio = '1', gran_total = '$gran_total', abono = '$gran_total' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
						$result_update_monto_abono = mysql_query($query_update_monto_abono);

						$query_update_monto_cargo = "UPDATE balance_gastos_operacion SET saldo_anterior = '0', saldo = '$gran_total', monto_precio = '$gran_total', monto_total = '$gran_total', tipo_moneda = 'MXN', tipo_cambio = '1', gran_total = '$gran_total', cargo = '$gran_total' WHERE idbalance_gastos_operacion = '$row_balance_movimiento[columna3]'";
						$result_update_monto_cargo = mysql_query($query_update_monto_cargo);

						$mensaje_monto_cargo = "El monto cambio de <b>$$monto_format_old</b> a <b>$$monto_format_new</b> en cargo";

						if ($result_update_monto_abono == 1 and $result_update_monto_cargo == 1) {

							$monto_bitacora_abono = BalanceInsertBitacora($mensaje_monto, "Monto", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "12", $idbalance_gastos_operacion, $columna_d, $visible);

							$monto_bitacora_cargo = BalanceInsertBitacora($mensaje_monto_cargo, "Monto", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "12", $row_balance_movimiento[columna3], $columna_d, $visible);


							if ($monto_bitacora_abono == 1 and $monto_bitacora_cargo == 1) {

								$mensaje = 1;
							} elseif ($monto_bitacora_abono == 1 and $monto_bitacora_cargo == 0) {

								$mensaje = "Cargo y Abono actualizados exitosamente pero con error de Bitácora en el Cargo: $monto_bitacora_cargo";
							} else if ($monto_bitacora_abono == 0 and $monto_bitacora_cargo == 1) {

								$mensaje = "Cargo y Abono actualizados exitosamente pero con error de Bitácora en el Abono: $monto_bitacora_abono";
							} else if ($monto_bitacora_abono == 0 and $monto_bitacora_cargo == 1) {

								$mensaje = "Cargo y Abono actualizados exitosamente pero con error de Bitácora en el Abono: $monto_bitacora_abono y en el Cargo: $monto_bitacora_cargo";
							}
						}
					} else {

						$query_update_monto_abono = "UPDATE balance_gastos_operacion SET saldo_anterior = '0', saldo = '$gran_total', monto_precio = '$gran_total', monto_total = '$gran_total', tipo_moneda = 'MXN' tipo_cambio = '1', gran_total = '$gran_total', cargo = '$gran_total' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
						$result_update_monto_abono = mysql_query($query_update_monto_abono);

						if ($result_update_monto_abono == 1) {

							$mensaje = BalanceInsertBitacora($mensaje_monto, "Monto", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "12", $idbalance_gastos_operacion, $columna_d, $visible);
						} else {

							$mensaje = "Error al actualizar el movimiento abono";
						}
					}
				}
			}
		} elseif ($tipo_formulario == "ResponsableIndividual") {

			$responsable_individual = $_POST['responsable_individual'];


			$responsable_balance_individual = trim($responsable_individual);
			$particionar_responsable_individual = explode("|", $responsable_balance_individual);

			$responsable = $particionar_responsable_individual[0];

			if ($responsable == "") {

				$mensaje = "<b>No Seleccionaste ningun responsable</b>";
			} elseif ($responsable == $row_balance_movimiento[responsable]) {

				$mensaje = "<b>El responsable es el mismo al que se tiene en sistema</b>";
			} else {


				if (is_numeric($row_balance_movimiento[responsable])) {

					$searh_responsable_bd = nombres_datos($row_balance_movimiento[responsable], "Colaborador");
					$porciones_resp_bd = explode("|", $searh_responsable_bd);

					$name_responsable_indivividual_old = $porciones_resp_bd[2];
				} else {

					$name_responsable_indivividual_old = $row_balance_movimiento[responsable];
				}




				$search_responsable_name_individual = nombres_datos($particionar_responsable_individual[0], $particionar_responsable_individual[1]);
				$porciones_responsable_name_individual = explode("|", $search_responsable_name_individual);

				if ($particionar_responsable_individual[1] == "Colaborador") {

					$name_responsable_indivividual_new = $porciones_responsable_name_individual[2];
					$valor_update_responsable_individual = $particionar_responsable_individual[0];
				} else {

					$name_responsable_indivividual_new = $porciones_responsable_name_individual[10];
					$valor_update_responsable_individual = $name_responsable_indivividual_new;
				}


				$mensaje_responsable = "El responsable cambio de <b>$name_responsable_indivividual_old</b> a <b>$name_responsable_indivividual_new</b> en $row_balance_movimiento[tipo_movimiento]";


				if ($row_balance_movimiento[tipo_movimiento] == "cargo") {

					$query_abono_responsable = "SELECT * FROM balance_gastos_operacion WHERE columna3 = '$idbalance_gastos_operacion'";
					$result_abono_responsable = mysql_query($query_abono_responsable);

					if (mysql_num_rows($result_abono_responsable) == 0) {

						$query_update_responsable = "UPDATE balance_gastos_operacion SET responsable = '$valor_update_responsable_individual', idfoliogo = '$responsable_balance_individual' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion' ";
						$result_update_responsable = mysql_query($query_update_responsable);

						if ($result_update_responsable == 1) {

							$mensaje = BalanceInsertBitacora($mensaje_responsable, "Responsable Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "2", $idbalance_gastos_operacion, $columna_d, $visible);
						} else {

							$mensaje = "- Error al actualizar el responsable en $row_balance_movimiento[tipo_movimiento]";
						}
					} else {

						while ($row_responsable_abono = mysql_fetch_array($result_abono_responsable)) {
							$idbalance_responsable_abono = $row_responsable_abono[idbalance_gastos_operacion];
						}

						$change_to_array_cargo = explode(",", $row_balance_movimiento[apartado_usado]);



						$actualizar_auxiliar_bd_cargo = ReplaceAuxiliar($change_to_array_cargo, $name_responsable_indivividual_old, $name_responsable_indivividual_new, $idbalance_gastos_operacion);
						$actualizar_auxiliar_bd_abono = ReplaceAuxiliar($change_to_array_cargo, $name_responsable_indivividual_old, $name_responsable_indivividual_new, $idbalance_responsable_abono);


						if ($actualizar_auxiliar_bd_cargo == 1 and $actualizar_auxiliar_bd_abono == 1) {

							$query_update_responsable_cargo = "UPDATE balance_gastos_operacion SET responsable = '$valor_update_responsable_individual', idfoliogo = '$responsable_balance_individual' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion' ";
							$result_update_responsable_cargo = mysql_query($query_update_responsable_cargo);

							$query_update_responsable_abono = "UPDATE balance_gastos_operacion SET responsable = '$valor_update_responsable_individual', idfoliogo = '$responsable_balance_individual' WHERE idbalance_gastos_operacion = '$idbalance_responsable_abono' ";
							$result_update_responsable_abono = mysql_query($query_update_responsable_abono);

							$mensaje_responsable_abono = "El responsable cambio de <b>$name_responsable_indivividual_old</b> a <b>$name_responsable_indivividual_new</b> en abono";

							if ($result_update_responsable_cargo == 1 and $result_update_responsable_abono == 1) {

								$mensaje_cargo_responsable = BalanceInsertBitacora($mensaje_responsable, "Responsable Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "2", $idbalance_gastos_operacion, $columna_d, $visible);
								$mensaje_abono_responsable = BalanceInsertBitacora($mensaje_responsable_abono, "Responsable Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "2", $idbalance_responsable_abono, $columna_d, $visible);

								if ($mensaje_cargo_responsable == 1 and $mensaje_abono_responsable == 1) {

									$mensaje = 1;
								} elseif ($mensaje_cargo_responsable == 0 and $mensaje_abono_responsable == 1) {

									$mensaje = "Responsable actualizado correctamente error en bitácora CARGO: $mensaje_cargo_responsable";
								} elseif ($mensaje_cargo_responsable == 1 and $mensaje_abono_responsable == 0) {

									$mensaje = "Responsable actualizado correctamente error en bitácora ABONO: $mensaje_abono_responsable";
								} elseif ($mensaje_cargo_responsable == 0 and $mensaje_abono_responsable == 0) {

									$mensaje = "Responsable actualizado correctamente error en bitácora CARGO: $mensaje_cargo_responsable ABONO: $mensaje_abono_responsable";
								}
							}
						} else {
							$mensaje = $actualizar_auxiliar_bd_cargo . $actualizar_auxiliar_bd_abono;
						}
					}
				} else {

					$query_abono_responsable = "SELECT * FROM balance_gastos_operacion WHERE columna3 = '$idbalance_gastos_operacion'";
					$result_abono_responsable = mysql_query($query_abono_responsable);

					if ($row_balance_movimiento[columna3] == 0) {

						$query_update_responsable = "UPDATE balance_gastos_operacion SET responsable = '$valor_update_responsable_individual', idfoliogo = '$responsable_balance_individual' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion' ";
						$result_update_responsable = mysql_query($query_update_responsable);

						if ($result_update_responsable == 1) {

							$mensaje = BalanceInsertBitacora($mensaje_responsable, "Responsable Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "2", $idbalance_gastos_operacion, $columna_d, $visible);
						} else {

							$mensaje = "- Error al actualizar el responsable en $row_balance_movimiento[tipo_movimiento]";
						}
					} else {


						$idbalance_responsable_cargo = $row_balance_movimiento[columna3];


						$change_to_array_abono = explode(",", $row_balance_movimiento[apartado_usado]);



						$actualizar_auxiliar_bd_qabono = ReplaceAuxiliar($change_to_array_abono, $name_responsable_indivividual_old, $name_responsable_indivividual_new, $idbalance_gastos_operacion);
						$actualizar_auxiliar_bd_cargo = ReplaceAuxiliar($change_to_array_abono, $name_responsable_indivividual_old, $name_responsable_indivividual_new, $idbalance_responsable_cargo);


						if ($actualizar_auxiliar_bd_qabono == 1 and $actualizar_auxiliar_bd_cargo == 1) {

							$query_update_responsable_qabono = "UPDATE balance_gastos_operacion SET responsable = '$valor_update_responsable_individual', idfoliogo = '$responsable_balance_individual' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion' ";
							$result_update_responsable_qabono = mysql_query($query_update_responsable_qabono);

							$query_update_responsable_cargo = "UPDATE balance_gastos_operacion SET responsable = '$valor_update_responsable_individual', idfoliogo = '$responsable_balance_individual' WHERE idbalance_gastos_operacion = '$idbalance_responsable_cargo' ";
							$result_update_responsable_cargo = mysql_query($query_update_responsable_cargo);

							$mensaje_responsable_cargo = "El responsable cambio de <b>$name_responsable_indivividual_old</b> a <b>$name_responsable_indivividual_new</b> en abono";

							if ($result_update_responsable_qabono == 1 and $result_update_responsable_cargo == 1) {

								$mensaje_qabono_responsable = BalanceInsertBitacora($mensaje_responsable, "Responsable Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "2", $idbalance_gastos_operacion, $columna_d, $visible);
								$mensaje_cargo_responsable = BalanceInsertBitacora($mensaje_responsable_cargo, "Responsable Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "2", $idbalance_responsable_cargo, $columna_d, $visible);

								if ($mensaje_qabono_responsable == 1 and $mensaje_cargo_responsable == 1) {

									$mensaje = 1;
								} elseif ($mensaje_qabono_responsable != 1 and $mensaje_cargo_responsable == 1) {

									$mensaje = "Responsable actualizado correctamente error en bitácora ABONO: $mensaje_qabono_responsable";
								} elseif ($mensaje_qabono_responsable == 1 and $mensaje_cargo_responsable != 1) {

									$mensaje = "Responsable actualizado correctamente error en bitácora CARGO: $mensaje_cargo_responsable";
								} elseif ($mensaje_qabono_responsable != 1 and $mensaje_cargo_responsable != 1) {

									$mensaje = "Responsable actualizado correctamente error en bitácora ABONO: $mensaje_qabono_responsable CARGO: $mensaje_cargo_responsable";
								}
							}
						} else {
							$mensaje = $actualizar_auxiliar_bd_qabono . $actualizar_auxiliar_bd_cargo;
						}
					}
				}
			}
		} elseif ($tipo_formulario == "VINIndividual") {

			$datos_vin = trim($datos_vin);
			$vin_bd = trim($row_balance_movimiento[datos_vin]);


			if ($datos_vin == "") {

				$mensaje = "<b>No Seleccionaste ningun VIN</b>";
			} elseif ($datos_vin == $vin_bd) {

				$mensaje = "<b>El Vin es el mismo al que se tiene en sistema $datos_vin</b>";
			} else {

				if ($vin_bd == "" || $vin_bd == "N/A") {

					$mensaje_vin = "Se agregó nuevo VIN : <b>$datos_vin</b> en $row_balance_movimiento[tipo_movimiento]";
					$mensaje_vin_abono = "Se agregó nuevo VIN : <b>$datos_vin</b> en abono";
					$mensaje_vin_cargo = "Se agregó nuevo VIN : <b>$datos_vin</b> en cargo";
				} else {

					$mensaje_vin = "El vin cambio de <b>$vin_bd</> a <b>$datos_vin</b> en $row_balance_movimiento[tipo_movimiento]";
					$mensaje_vin_abono = "El vin cambio de <b>$vin_bd</> a <b>$datos_vin</b> en abono";
					$mensaje_vin_cargo = "El vin cambio de <b>$vin_bd</> a <b>$datos_vin</b> en cargo";
				}


				if ($row_balance_movimiento[tipo_movimiento] == "cargo") {

					$ver_idbalancegastos_abono = BuscarAbono($idbalance_gastos_operacion);

					if ($ver_idbalancegastos_abono == 0) {

						$mensaje = "<b>Próximamente</b>";
					} else {

						$reemplazar_vin_cargo = ReemplazarAgregarAuxiliar($vin_bd, $idbalance_gastos_operacion, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $row_balance_movimiento[idauxiliar_principales], $date_movimiento, $row_balance_movimiento[columna2], $datos_vin);
						$reemplazar_vin_abono = ReemplazarAgregarAuxiliar($vin_bd, $ver_idbalancegastos_abono, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $row_balance_movimiento[idauxiliar_principales], $date_movimiento, $row_balance_movimiento[columna2], $datos_vin);

						if ($reemplazar_vin_cargo == 1 and $reemplazar_vin_abono == 1) {

							$actualizar_auxiliares_vin = ConsultarAuxiliares($idbalance_gastos_operacion);

							$query_update_auxiliares_cargo = "UPDATE balance_gastos_operacion SET datos_vin = '$datos_vin', apartado_usado = '$actualizar_auxiliares_vin' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion' ";
							$result_update_auxiliares_cargo = mysql_query($query_update_auxiliares_cargo);

							$query_update_auxiliares_abono = "UPDATE balance_gastos_operacion SET datos_vin = '$datos_vin', apartado_usado = '$actualizar_auxiliares_vin' WHERE idbalance_gastos_operacion = '$ver_idbalancegastos_abono' ";
							$result_update_auxiliares_abono = mysql_query($query_update_auxiliares_abono);


							if ($result_update_auxiliares_cargo == 1 and $result_update_auxiliares_abono == 1) {

								$mensaje_qabono_responsable = BalanceInsertBitacora($mensaje_vin, "VIN Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "4", $idbalance_gastos_operacion, $columna_d, $visible);
								$mensaje_cargo_responsable = BalanceInsertBitacora($mensaje_vin_abono, "VIN Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "4", $ver_idbalancegastos_abono, $columna_d, $visible);

								if ($mensaje_qabono_responsable == 1 and $mensaje_cargo_responsable == 1) {

									$mensaje = 1;
								} elseif ($mensaje_qabono_responsable != 1 and $mensaje_cargo_responsable == 1) {

									$mensaje = "Responsable actualizado correctamente error en bitácora ABONO: $mensaje_qabono_responsable";
								} elseif ($mensaje_qabono_responsable == 1 and $mensaje_cargo_responsable != 1) {

									$mensaje = "Responsable actualizado correctamente error en bitácora CARGO: $mensaje_cargo_responsable";
								} elseif ($mensaje_qabono_responsable != 1 and $mensaje_cargo_responsable != 1) {

									$mensaje = "Responsable actualizado correctamente error en bitácora ABONO: $mensaje_qabono_responsable CARGO: $mensaje_cargo_responsable";
								}
							} else {

								$mensaje = "Error al actualizar el VIN en cargo y abono";
							}
						} else {

							$mensaje = "Error en: $reemplazar_vin_cargo $reemplazar_vin_abono";
						}
					}
				} else {

					$ver_idbalancegastos_cargo = trim($row_balance_movimiento[columna3]);

					if ($ver_idbalancegastos_cargo == "") {

						$mensaje = "<b>Próximamente</b>";
					} else {

						$reemplazar_vin_qabono = ReemplazarAgregarAuxiliar($vin_bd, $idbalance_gastos_operacion, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $row_balance_movimiento[idauxiliar_principales], $date_movimiento, $row_balance_movimiento[columna2], $datos_vin);
						$reemplazar_vin_cargo = ReemplazarAgregarAuxiliar($vin_bd, $ver_idbalancegastos_cargo, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $row_balance_movimiento[idauxiliar_principales], $date_movimiento, $row_balance_movimiento[columna2], $datos_vin);

						if ($reemplazar_vin_qabono == 1 and $reemplazar_vin_cargo == 1) {

							$actualizar_auxiliares_vin = ConsultarAuxiliares($idbalance_gastos_operacion);

							$query_update_auxiliares_abono = "UPDATE balance_gastos_operacion SET datos_vin = '$datos_vin', apartado_usado = '$actualizar_auxiliares_vin' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion' ";
							$result_update_auxiliares_abono = mysql_query($query_update_auxiliares_abono);

							$query_update_auxiliares_cargo = "UPDATE balance_gastos_operacion SET datos_vin = '$datos_vin', apartado_usado = '$actualizar_auxiliares_vin' WHERE idbalance_gastos_operacion = '$ver_idbalancegastos_cargo' ";
							$result_update_auxiliares_cargo = mysql_query($query_update_auxiliares_cargo);


							if ($result_update_auxiliares_abono == 1 and $result_update_auxiliares_cargo == 1) {

								$mensaje_qabono_responsable = BalanceInsertBitacora($mensaje_vin, "VIN Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "4", $idbalance_gastos_operacion, $columna_d, $visible);
								$mensaje_cargo_responsable = BalanceInsertBitacora($mensaje_vin_cargo, "VIN Individual", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "4", $ver_idbalancegastos_cargo, $columna_d, $visible);

								if ($mensaje_qabono_responsable == 1 and $mensaje_cargo_responsable == 1) {

									$mensaje = 1;
								} elseif ($mensaje_qabono_responsable != 1 and $mensaje_cargo_responsable == 1) {

									$mensaje = "Responsable actualizado correctamente error en bitácora ABONO: $mensaje_qabono_responsable";
								} elseif ($mensaje_qabono_responsable == 1 and $mensaje_cargo_responsable != 1) {

									$mensaje = "Responsable actualizado correctamente error en bitácora CARGO: $mensaje_cargo_responsable";
								} elseif ($mensaje_qabono_responsable != 1 and $mensaje_cargo_responsable != 1) {

									$mensaje = "Responsable actualizado correctamente error en bitácora ABONO: $mensaje_qabono_responsable CARGO: $mensaje_cargo_responsable";
								}
							} else {

								$mensaje = "Error al actualizar el VIN en cargo y abono";
							}
						} else {

							$mensaje = "Error en: $reemplazar_vin_qabono $reemplazar_vin_cargo";
						}
					}
				}
			}
		} elseif ($tipo_formulario == "Visible") {

			$mensaje_visible = "Se elimino el movimiento <b>$row_balance_movimiento[concepto]</b> en cargo";

			if ($row_balance_movimiento[tipo_movimiento] == "cargo") {

				$ver_idbalancegastos_abono = BuscarAbono($idbalance_gastos_operacion);

				if ($ver_idbalancegastos_abono == 0) {

					$delete_cargo_auxiliares = DeleteAuxiliares($idbalance_gastos_operacion, $row_balance_movimiento[concepto]);

					$mensaje_visible_abono = "Se elimino el movimiento <b>$row_balance_movimiento[concepto]</b> en cargo";

					$update_archivos = (trim($row_balance_movimiento[columna9]) == "" || trim($row_balance_movimiento[columna9]) == "undefined") ? 1 : ActualizarCombustibleCaseta($row_balance_movimiento[columna9], $row_balance_movimiento[concepto]);

					if ($delete_cargo_auxiliares == 1 and $update_archivos == 1) {

						$mensaje_cargo_visible = BalanceInsertBitacora($mensaje_visible, "Visible", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "13", $idbalance_gastos_operacion, $columna_d, $visible);

						$mensaje = ($mensaje_cargo_visible == 1) ? 1 : "Error en $mensaje_cargo_visible";
					} else {

						$mensaje = $delete_cargo_auxiliares . $update_archivos;
					}
				} else {

					$delete_cargo_auxiliares = DeleteAuxiliares($idbalance_gastos_operacion, $row_balance_movimiento[concepto]);
					$delete_abono_auxiliares = DeleteAuxiliares($ver_idbalancegastos_abono, $row_balance_movimiento[concepto]);

					$mensaje_visible_abono = "Se elimino el movimiento <b>$row_balance_movimiento[concepto]</b> en abono";

					$update_archivos = (trim($row_balance_movimiento[columna9]) == "" || trim($row_balance_movimiento[columna9]) == "undefined") ? 1 : ActualizarCombustibleCaseta($row_balance_movimiento[columna9], $row_balance_movimiento[concepto]);

					if ($delete_cargo_auxiliares == 1 and $delete_abono_auxiliares == 1 and $update_archivos == 1) {

						$mensaje_cargo_visible = BalanceInsertBitacora($mensaje_visible, "Visible", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "13", $idbalance_gastos_operacion, $columna_d, $visible);
						$mensaje_abono_visible = BalanceInsertBitacora($mensaje_visible_abono, "Visible", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "13", $ver_idbalancegastos_abono, $columna_d, $visible);

						$mensaje = ($mensaje_cargo_visible == 1 and $mensaje_abono_visible == 1) ? 1 : "Error en $mensaje_cargo_visible $mensaje_abono_visible";
					} else {

						$mensaje = $delete_cargo_auxiliares . $delete_abono_auxiliares . $update_archivos;
					}
				}
			} else {

				$ver_idbalancegastos_cargo = $row_balance_movimiento[columna3];

				if ($ver_idbalancegastos_cargo == "") {

					$delete_qabono_auxiliares = DeleteAuxiliares($idbalance_gastos_operacion, $row_balance_movimiento[concepto]);
					$mensaje_visible_cargo = "Se elimino el movimiento <b>$row_balance_movimiento[concepto]</b> en abono";

					$update_archivos = (trim($row_balance_movimiento[columna9]) == "" || trim($row_balance_movimiento[columna9]) == "undefined") ? 1 : ActualizarCombustibleCaseta($row_balance_movimiento[columna9], $row_balance_movimiento[concepto]);

					if ($delete_qabono_auxiliares == 1 and $update_archivos == 1) {

						$mensaje_qabono_visible = BalanceInsertBitacora($mensaje_visible, "Visible", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "13", $idbalance_gastos_operacion, $columna_d, $visible);

						$mensaje = ($mensaje_qabono_visible == 1) ? 1 : "Error en $mensaje_qabono_visible";
						#
					} else {

						$mensaje = $delete_qabono_auxiliares  . $update_archivos;
						#
					}
				} else {

					$delete_qabono_auxiliares = DeleteAuxiliares($idbalance_gastos_operacion, $row_balance_movimiento[concepto]);
					$delete_cargo_auxiliares = DeleteAuxiliares($ver_idbalancegastos_cargo, $row_balance_movimiento[concepto]);

					$mensaje_visible_cargo = "Se elimino el movimiento <b>$row_balance_movimiento[concepto]</b> en abono";

					$update_archivos = (trim($row_balance_movimiento[columna9]) == "" || trim($row_balance_movimiento[columna9]) == "undefined") ? 1 : ActualizarCombustibleCaseta($row_balance_movimiento[columna9], $row_balance_movimiento[concepto]);

					if ($delete_qabono_auxiliares == 1 and $delete_cargo_auxiliares == 1 and $update_archivos == 1) {

						$mensaje_qabono_visible = BalanceInsertBitacora($mensaje_visible, "Visible", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "13", $idbalance_gastos_operacion, $columna_d, $visible);
						$mensaje_cargo_visible = BalanceInsertBitacora($mensaje_visible_cargo, "Visible", $row_balance_movimiento[columna2], $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "13", $ver_idbalancegastos_cargo, $columna_d, $visible);

						$mensaje = ($mensaje_qabono_visible == 1 and $mensaje_cargo_visible == 1) ? 1 : "Error en $mensaje_qabono_visible $mensaje_cargo_visible";
					} else {

						$mensaje = $delete_qabono_auxiliares . $delete_cargo_auxiliares . $update_archivos;
					}
				}
			}
		} else {

			$mensaje = "No exite esta opcion <b>$tipo_formulario</b>";
		} #else
	} #while
} #elsec


#-------------------------------------------  --------------------------------------------------------------------------------

function VerificarAuxiliares_balance($pasar_array_auxiliares, $idbalance_gastos_operacion, $idauxiliar_principales, $idlogistica_pasar, $auxiliares_bd, $date_movimiento, $fecha_creacion, $fecha_guardado, $visible, $usuario_creador)
{

	$array_auxiliar_no_existe = array();
	$array_auxiliar_ya_existe = array();
	$concatenar_resultados = "";

	foreach ($pasar_array_auxiliares as $key_no_existe => $value_existe_auxiliar) {

		$value_existe_auxiliar = trim($value_existe_auxiliar);

		if ($value_existe_auxiliar != "") {

			$query_consultar_auxiliar = "SELECT * FROM balance_gastos_auxiliares WHERE trim(nombre) = '$value_existe_auxiliar' and idlogistica = '$idbalance_gastos_operacion'";
			$result_consultar_auxiliar = mysql_query($query_consultar_auxiliar);

			if (mysql_num_rows($result_consultar_auxiliar) == 0) {

				array_push($array_auxiliar_no_existe, $value_existe_auxiliar);

				$insertar_auxiliar = AuxiliaresBalanceInsert($value_existe_auxiliar, $idauxiliar_principales, $idbalance_gastos_operacion, $date_movimiento, $idlogistica_pasar, $direccion, $idfoliogo, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $col1, $col2, $col3);
				$concatenar_resultados .= ($insertar_auxiliar == 1) ? "" : $insertar_auxiliar;
			} else {

				array_push($array_auxiliar_ya_existe, $value_existe_auxiliar);
			}
		}
	}

	$ya_existen_auxiliares = Tratar_Array($array_auxiliar_ya_existe);
	$si_no_hay_auxiliares = Tratar_Array($array_auxiliar_no_existe);


	if (count($si_no_hay_auxiliares) == 0) {

		$auxiliares_mensaje = "Los Auxiliares: <b>" . implode(",", $ya_existen_auxiliares) . "</b> ya existen <br>";
	} else {

		$concatenar_resultados = trim($concatenar_resultados);

		if ($concatenar_resultados == "") {

			$concatenar_auxiliares = $auxiliares_bd . implode(",", $si_no_hay_auxiliares) . ",";
			$convertir_array_concatenar_auxiliares = explode(",", $concatenar_auxiliares);
			$tratar_auxiliares_concatenados = Tratar_Array($convertir_array_concatenar_auxiliares);
			$nuevos_balores_auxiliares = implode(",", $tratar_auxiliares_concatenados) . ",";

			$update_auxiliares_bd = "UPDATE balance_gastos_operacion SET apartado_usado = '$nuevos_balores_auxiliares' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
			$result_auxiliares_bd = mysql_query($update_auxiliares_bd);

			$auxiliares_mensaje = ($result_auxiliares_bd == 1) ? 1 : "- Los auxiiares: <b>" . implode(",", $si_no_hay_auxiliares) . "<b> Fueron Insertados correctamente sin embargo no fue posible actualizar el movimiento <br>";
		} else {
			$auxiliares_mensaje = $concatenar_resultados;
		}
	}

	return $auxiliares_mensaje;
}

#-------------------------------------------  --------------------------------------------------------------------------------

function ActualizarFecha_Auxiliares($idbalance_gastos_operacion, $fecha_balance)
{

	$idbalance_gastos_operacion = trim($idbalance_gastos_operacion);

	$query_update_fecha_auxiliares = "SELECT * FROM balance_gastos_auxiliares WHERE visible = 'SI' and idlogistica = '$idbalance_gastos_operacion'";
	$result_update_fecha_auxiliares = mysql_query($query_update_fecha_auxiliares);

	if (mysql_num_rows($result_update_fecha_auxiliares) == 0) {

		$mensaje_fehas = "No Existen Auxiliares";
	} else {

		while ($row_update_fecha_auxiliares = mysql_fetch_array($result_update_fecha_auxiliares)) {

			$query_auxiliares_update_fecha = "UPDATE balance_gastos_auxiliares SET fecha_movimiento = '$fecha_balance' WHERE idbalance_gastos_auxiliares = '$row_update_fecha_auxiliares[idbalance_gastos_auxiliares]'";
			$result_auxiliares_update_fecha = mysql_query($query_auxiliares_update_fecha);

			$concatenar_resul_fechas .= ($result_auxiliares_update_fecha == 1) ? "" : "Error al cambiar la fecha del auxiliar <b>$row_update_fecha_auxiliares[nombre]<b> <br>";
		}
	}

	return ($concatenar_resul_fechas == "") ? 1 : $concatenar_resul_fechas;
}

#-------------------------------------------  --------------------------------------------------------------------------------

function ReplaceAuxiliar($array_auxiliares_change, $valor_busqueda, $valor_reemplazar, $idbalance_gastos_operacion)
{

	$valor_busqueda = trim($valor_busqueda);
	$valor_reemplazar = trim($valor_reemplazar);
	$idbalance_gastos_operacion = trim($idbalance_gastos_operacion);

	$new_array_valor_change = array();

	foreach ($array_auxiliares_change as $key_auxiliares_change => $value_auxiliares_change) {

		$value_auxiliares_change = trim($value_auxiliares_change);

		if ($value_auxiliares_change != "") {

			if ($value_auxiliares_change == $valor_busqueda) {

				array_push($new_array_valor_change, $valor_reemplazar);

				$query_update_change_auxiliar = "SELECT * FROM balance_gastos_auxiliares WHERE trim(nombre) = '$valor_busqueda' AND idlogistica = '$idbalance_gastos_operacion'";
				$result_update_change_auxiliar = mysql_query($query_update_change_auxiliar);

				if ($result_update_change_auxiliar == 0) {

					$mensaje_change = "El auxiliar: <b>$valor_busqueda</b> no se encuentra en la tabla de auxiliares <br>";

					break;
				} else {

					while ($row_update_change_auxiliar = mysql_fetch_array($result_update_change_auxiliar)) {

						$update_change_auxiliar_new_val = "UPDATE balance_gastos_auxiliares SET nombre = '$valor_reemplazar' WHERE idbalance_gastos_auxiliares = '$row_update_change_auxiliar[idbalance_gastos_auxiliares]' ";
						$result_change_auxiliar_new_val = mysql_query($update_change_auxiliar_new_val);

						if ($result_change_auxiliar_new_val == 1) {

							$mensaje_change = "Adelante";
						} else {

							$mensaje_change = "Error al actualizar el nuevo auxiliar <b>$valor_reemplazar</b> <br>";

							break;
						}
					}
				}
			} else {

				array_push($new_array_valor_change, $value_auxiliares_change);
			}
		}
	}




	if ($mensaje_change == "El auxiliar: <b>$valor_busqueda</b> no se encuentra en la tabla de auxiliares <br>" || $mensaje_change == "Error al actualizar el nuevo auxiliar <b>$valor_reemplazar</b> <br>") {

		$mensaje_change = $mensaje_change;
	} else {

		$tratar_auxiliar_change = Tratar_Array($new_array_valor_change);
		$implode_auxiliar_change = implode(",", $tratar_auxiliar_change) . ",";



		$query_update_change_aux_balance = "UPDATE balance_gastos_operacion SET apartado_usado = '$implode_auxiliar_change' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'";
		$result_update_change_aux_balance = mysql_query($query_update_change_aux_balance);

		$mensaje_change = ($result_update_change_aux_balance == 1) ? 1 : "-Error al actualizar el cambio de auxiliar";
	}


	return $mensaje_change;
}





function ReemplazarAgregarAuxiliar($auxiliar_busqueda, $idbalance_gastos_operacion, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $idauxiliar_principales, $fecha_movimiento, $idlogistica_pasar, $auxiliar_reemplazar)
{

	$auxiliar_busqueda = trim($auxiliar_busqueda);
	$idbalance_gastos_operacion = trim($idbalance_gastos_operacion);
	$auxiliar_reemplazar = trim($auxiliar_reemplazar);

	$query_busqueda_auxiliar = "SELECT * FROM balance_gastos_auxiliares WHERE trim(nombre) = '$auxiliar_busqueda' AND visible = 'SI' and idlogistica = '$idbalance_gastos_operacion'";
	$result_busqueda_auxiliar = mysql_query($query_busqueda_auxiliar);

	if (mysql_num_rows($result_busqueda_auxiliar) >= 1) {

		while ($row_busqueda_auxiliar = mysql_fetch_array($result_busqueda_auxiliar)) {

			$query_update_busqueda_auxiliar = "UPDATE balance_gastos_auxiliares SET nombre = '$auxiliar_reemplazar' WHERE idbalance_gastos_auxiliares = '$row_busqueda_auxiliar[idbalance_gastos_auxiliares]'";
			$result_update_busqueda_auxiliar = mysql_query($query_update_busqueda_auxiliar);

			$respuesta_busqueda_auxiliar = ($result_update_busqueda_auxiliar == 1) ? 1 : "Error al actualizar el auxiliar <b>$auxiliar_busqueda</b> <br>";
		}
	} else {

		$respuesta_busqueda_auxiliar = AuxiliaresBalanceInsert($auxiliar_busqueda, $idauxiliar_principales, $idbalance_gastos_operacion, $fecha_movimiento, $idlogistica_pasar, $direccion, $idfoliogo, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $col1, $col2, $col3);
	}

	return $respuesta_busqueda_auxiliar;
}




function BuscarAbono($idbalance_gastos_operacion)
{

	$idbalance_gastos_operacion = trim($idbalance_gastos_operacion);

	$query_busqueda_abono = "SELECT * FROM balance_gastos_operacion WHERE columna3 = '$idbalance_gastos_operacion'";
	$result_busqueda_abono = mysql_query($query_busqueda_abono);

	if (mysql_num_rows($result_busqueda_abono) >= 1) {

		while ($row_busqueda_abono = mysql_fetch_array($result_busqueda_abono)) {

			$result_idbalance_gastos_operacion_abono = $row_busqueda_abono[idbalance_gastos_operacion];
		}
	} else {

		$result_idbalance_gastos_operacion_abono = 0;
	}

	return $result_idbalance_gastos_operacion_abono;
}



function ConsultarAuxiliares($idbalance_gastos_operacion)
{

	$idbalance_gastos_operacion = trim($idbalance_gastos_operacion);

	$concatenar_add_auxiliares = array();

	$query_add_auxiliares = "SELECT * FROM balance_gastos_auxiliares WHERE idlogistica = '$idbalance_gastos_operacion' and visible = 'SI' ";
	$result_add_auxiliares = mysql_query($query_add_auxiliares);

	while ($row_add_auxiliares = mysql_fetch_array($result_add_auxiliares)) {

		array_push($concatenar_add_auxiliares, $row_add_auxiliares[nombre]);
	}

	$limpiar_auxiliares = Tratar_Array($concatenar_add_auxiliares);

	return implode(",", $limpiar_auxiliares) . ",";
}


function DeleteAuxiliares($idbalance_gastos_operacion, $concepto)
{

	$idbalance_gastos_operacion = trim($idbalance_gastos_operacion);

	$query_delete_auxiliares = "SELECT * FROM balance_gastos_auxiliares WHERE idlogistica = '$idbalance_gastos_operacion' and visible = 'SI' ";
	$result_delete_auxiliares = mysql_query($query_delete_auxiliares);

	while ($row_delete_auxiliares = mysql_fetch_array($result_delete_auxiliares)) {

		$query_baja_auxiliares = "UPDATE balance_gastos_auxiliares SET visible = 'NO' WHERE idbalance_gastos_auxiliares = '$row_delete_auxiliares[idbalance_gastos_auxiliares]'";
		$result_baja_auxiliares = mysql_query($query_baja_auxiliares);

		$resul_baja_delete_auxiliares .= ($result_baja_auxiliares == 1) ? "" : "-Error al eliminar el auxiliar <b>$row_delete_auxiliares[nombre]</b> <br>";
	}

	$query_visible_balance = "UPDATE balance_gastos_operacion SET visible = 'NO' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion' ";
	$result_visible_balance = mysql_query($query_visible_balance);


	return ($resul_baja_delete_auxiliares == "" and $result_visible_balance == 1) ? 1 : "$resul_baja_delete_auxiliares  Error al Eliminar el movimiento $concepto";
}


function ActualizarCombustibleCaseta($idorden_logistica_combustible_peajes, $concepto)
{

	$idorden_logistica_combustible_peajes = trim($idorden_logistica_combustible_peajes);
	$concepto = trim($concepto);

	if ($concepto == "CARGA DE COMBUSTIBLE" || $concepto == "Carga de combustible") {

		$query_update_combustible = "UPDATE orden_logistica_combustible	SET idorden_logistica = '', estatus = 'Pendiente' WHERE idorden_logistica_combustible = '$idorden_logistica_combustible_peajes'";
		$result_update_combustible = mysql_query($query_update_combustible);

		$mensaje_combustible_peaje = ($result_update_combustible == 1) ? 1 : "- Error al Actualizar Archivo Combustible <br>";
	} else {

		$query_update_peaje = "UPDATE orden_logistica_casetas SET idorden_logistica = '', estatus = 'Pendiente' WHERE idorden_logistica_combustible = '$idorden_logistica_combustible_peajes'";
		$result_update_peaje = mysql_query($query_update_peaje);

		$mensaje_combustible_peaje = ($result_update_peaje == 1) ? 1 : "- Error al Actualizar Archivo Caseta <br>";
	}

	return $mensaje_combustible_peaje;
}



echo $mensaje;
