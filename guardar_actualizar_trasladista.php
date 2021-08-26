<?php
session_start();
include_once "../../config.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$usuario_creador = $_SESSION['usuario_clave'];


$id_trasladista = trim($_REQUEST['id_trasladista']);
$tipo_trasladista = trim($_REQUEST['tipo_trasladista']);
$id_log = $_REQUEST['id_log'];
$fecha_creacion = $_REQUEST['fecha_creacion'];
$coordenadas = $_REQUEST['ubicacion_real_no_update_trasladista'];
$comentarios = trim($_REQUEST['comentario_update_trasladista']);
$array_asignacion_vin = $_REQUEST['array_asignacion_vin'];

// $id_trasladista = "3";
// $tipo_trasladista = "Colaborador";
// $id_log = "11545";
// $fecha_creacion = $fecha_guardado;
// $coordenadas = "20.588796, -100.3898794";
// $comentarios = "Soy el comentario";


$logistica_encriptada = base64_encode($id_log);

$array_errores = array();


#------------------------Verificar Si el trasladista nuevo es diferente al que se tiene---------------------------------------------------------------------------------------------------------------------------------------------------------

$ver_trasladista_diferente = VerificarTrasladitaDiferente($id_log, $id_trasladista, $tipo_trasladista);

if ($ver_trasladista_diferente == 1) {

	$query_orden_bitacora = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$id_log'";
	$result_orden_bitacora = mysql_query($query_orden_bitacora);

	if (mysql_num_rows($result_orden_bitacora) >= 1) {

		while ($row_orden_bitacora = mysql_fetch_array($result_orden_bitacora)) {

			$id_trasladista_anterior = trim("$row_orden_bitacora[idasigna]");
			$type_trasladista_anterior = trim("$row_orden_bitacora[tipo_asignante]");

			$municipio_origen = trim("$row_orden_bitacora[municipio_origen]");
			$estado_origen = trim("$row_orden_bitacora[estado_origen]");
			$municipio_destino = trim("$row_orden_bitacora[municipio_destino]");
			$estado_destino = trim("$row_orden_bitacora[estado_destino]");
			$estatus_actual = ($row_orden_bitacora[idasigna] == "" || $row_orden_bitacora[idasigna] == 0) ? "Nuevo" : "Cambio";
			$usser_solicitante = "$row_orden_bitacora[usuario_creador]";
		}

		$ver_recorrido = VerificarRecorrido($id_log);

		if ($ver_recorrido == 1) {

			$query_update_new = "UPDATE orden_logistica SET idasigna = '$id_trasladista', tipo_asignante = '$tipo_trasladista' WHERE idorden_logistica = '$id_log'";
			$result_new = mysql_query($query_update_new);

			if ($result_new == 1) {

				if ($estatus_actual == "Nuevo") {

					$actualizar_colaborador_anterior = 1;
					#
				} else {

					$actualizar_colaborador_anterior = ($type_trasladista_anterior == "Colaborador") ? updateColaboradores($id_trasladista_anterior, "Disponible") : "1";
					#
				}

				if ($actualizar_colaborador_anterior == 1) {

					#------------------------Obtenemos el nombre de el trasladista Anterior

					$nomenclatura_trasladista_anterior = explode("|", nombres_datos($id_trasladista_anterior, $type_trasladista_anterior));

					#------------------------Obtenemos el nombre de el trasladista Nuevo

					$nomenclatura_trasladista_nuevo = explode("|", nombres_datos($id_trasladista, $tipo_trasladista));

					#------------------------Insertar cambio de trasladista Principal

					$descripcion_cambio = ($estatus_actual == "Nuevo") ? "Se Asignó a <b>$nomenclatura_trasladista_nuevo[2]</b> como Ejecutivo de Traslado Principal" : "El Ejecutivo de Traslado cambio de <b>" . $nomenclatura_trasladista_anterior[2] . "</b> a <b>$nomenclatura_trasladista_nuevo[2]</b><br>";

					$tipo_movimiento_bitacora = ($estatus_actual == "Nuevo") ? "Ejecutivo de Traslado" : "Cambio de Ejecutivo de Traslado";

					#$insertar_change_ejecutivo = insert_bitacora($descripcion_cambio, $tipo_movimiento_bitacora, $id_log, $usuario_creador, $fecha_creacion, $fecha_guardado, "SI", $coordenadas, "3", $comentarios);

					$insertar_change_ejecutivo = LogisticaInsertBitacora($descripcion_cambio, $tipo_movimiento_bitacora, $id_log, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "3", $columna_c, $columna_d, "SI");

					if ($insertar_change_ejecutivo == 1) {

						$actualizar_colaborador_nuevo = ($tipo_trasladista == "Colaborador") ? updateColaboradores($id_trasladista, "En Ruta") : "1";

						if ($actualizar_colaborador_nuevo == 1) {

							if ($estatus_actual == "Nuevo") {

								$insertar_notificacion_trasladista_anterior = 1;
								$numero_whats_trasladista_anterior = "";
								#
							} else {

								if ($nomenclatura_trasladista_anterior[11] == "Colaborador") {

									#------------------------Preparamos las variables para insertar las notificaciones a la bitacora del trasladista anterior
									$descripcion_trasladista_anterior_whats = "*$nomenclatura_trasladista_anterior[2]* La logística No. *$id_log* fue reasignada a alguien mas. Favor de esperar nuevas Indicaciones";
									$descripcion_trasladista_anterior_base = "<b>$nomenclatura_trasladista_anterior[2]</b> La logística No. <b>$id_log</b> fue reasignada a alguien mas. Favor de esperar nuevas Indicaciones";
									$numero_whats_trasladista_anterior = "https://api.whatsapp.com/send?phone=$nomenclatura_trasladista_anterior[3]&text=$descripcion_trasladista_anterior_whats";

									$insertar_notificacion_trasladista_anterior	= LogisticaInsertBitacora($descripcion_trasladista_anterior_base, "Notificación", $id_log, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "2", $columna_c, $columna_d, "SI");
									#
								} else {
									#------------------------Preparamos las variables para insertar las notificaciones a la bitacora del trasladista anterior
									$descripcion_trasladista_anterior_whats = "*$nomenclatura_trasladista_anterior[2]* La logística No. *$id_log* fue reasignada a alguien mas.";
									$descripcion_trasladista_anterior_base = "<b>$nomenclatura_trasladista_anterior[2]</b> La Logística No. <b>$id_log</b> fue reasignada a alguien mas.";
									$numero_whats_trasladista_anterior = "https://api.whatsapp.com/send?phone=$nomenclatura_trasladista_anterior[3]&text=$descripcion_trasladista_anterior_whats";
									#------------------------Insertamos en la bitacora del trasladista anterior
									$insertar_notificacion_trasladista_anterior	= LogisticaInsertBitacora($descripcion_trasladista_anterior_base, "Notificación", $id_log, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "2", $columna_c, $columna_d, "SI");
								}
							}

							if ($insertar_notificacion_trasladista_anterior == 1) {

								if ($nomenclatura_trasladista_nuevo[11] == "Colaborador") {

									$carpeta_direccionador = ($nomenclatura_trasladista_nuevo[13] == "Ejecutivo de Traslado") ? "https://www.panamotorscenter.com/Prod/CCP/Perfiles2/Ejecutivos_Traslado/orden_logistica_detalles.php?idib=$logistica_encriptada" : "https://www.panamotorscenter.com/Prod/CCP/Perfiles2/Generar_Logistica/orden_logistica_detalles.php?idib=$logistica_encriptada";

									#------------------------Preparamos las variables para insertar las notificaciones a la bitacora del trasladista nuevo

									$descripcion_trasladista_nuevo_whats = "*$nomenclatura_trasladista_nuevo[2] *Tienes una nueva Logística por atender No. *$id_log*, Tu origen: *$municipio_origen*, *$estado_origen* tu Destino: *$municipio_destino*, *$estado_destino* conoce los detalles consultando CCP $carpeta_direccionador";

									$descripcion_trasladista_nuevo_base = "<b>$nomenclatura_trasladista_nuevo[2] </b>Tienes una nueva Logística por atender No. <b>$id_log</b>, Tu origen: <b>$municipio_origen</b>, <b>$estado_origen</b> tu Destino: <b>$municipio_destino</b>, <b>$estado_destino</b> conoce los detalles consultando CCP";
									$numero_whats_trasladista_nuevo = "https://api.whatsapp.com/send?phone=$nomenclatura_trasladista_nuevo[3]&text=$descripcion_trasladista_nuevo_whats";

									$nomenclatura_nuevo_trasladista = $nomenclatura_trasladista_nuevo[2];
									#------------------------Insertamos en la bitacora del trasladista nuevo

									$insertar_notificacion_trasladista_nuevo = LogisticaInsertBitacora($descripcion_trasladista_nuevo_base, "Notificación", $id_log, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "2", $columna_c, $columna_d, "SI");
								} else {

									#------------------------Preparamos las variables para insertar las notificaciones a la bitacora del trasladista nuevo
									$descripcion_trasladista_nuevo_whats = "*$nomenclatura_trasladista_nuevo[2]* usted tiene un número de orden. *$id_log*, de logística para cualquier duda o aclaración.";
									$descripcion_trasladista_nuevo_base = "<b>$nomenclatura_trasladista_nuevo[2]</b> usted tiene un número de orden. <b>$id_log</b>, de logística para cualquier duda o aclaración.";
									$numero_whats_trasladista_nuevo = "https://api.whatsapp.com/send?phone=$nomenclatura_trasladista_nuevo[3]&text=$descripcion_trasladista_nuevo_whats";

									$nomenclatura_nuevo_trasladista = $nomenclatura_trasladista_nuevo[2];
									#------------------------Insertamos en la bitacora del trasladista nuevo

									$insertar_notificacion_trasladista_nuevo = LogisticaInsertBitacora($descripcion_trasladista_nuevo_base, "Notificación", $id_log, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "2", $columna_c, $columna_d, "SI");
								}

								if ($insertar_notificacion_trasladista_nuevo == 1) {

									$actualizar_vines = ActualizarVin($id_log, $id_trasladista, $tipo_trasladista, $array_asignacion_vin);

									if ($actualizar_vines == 1) {

										$consultar_recurso = explode("|", ActualizarRecursoWallet($id_log, $estatus_actual, $id_trasladista, $tipo_trasladista, $usuario_creador, $fecha_creacion, $fecha_guardado, $comentarios, $coordenadas, $nomenclatura_trasladista_anterior[2]));

										$whats_recurso1 = $consultar_recurso[1];
										$whats_recurso2 = $consultar_recurso[2];

										if (trim($consultar_recurso[0]) == 1) {

											if ($estatus_actual == "Nuevo") {

												$ver_programada = explode("|", LogisticaProgramada($usser_solicitante, $id_log, $logistica_encriptada, $nomenclatura_nuevo_trasladista, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado));
												$whats_programada = $ver_programada[1];
												if ($ver_programada[0] == 1) {

													array_push($array_errores, "1");
													#
												} else {
													array_push($array_errores, $ver_programada[0]);
												}
											} else {
												array_push($array_errores, "1");
											}
										} else {

											array_push($array_errores, $consultar_recurso[0]);
										}
									} else {
										array_push($array_errores, $actualizar_vines);
									}
								} else {
									array_push($array_errores, $insertar_notificacion_trasladista_nuevo);
								}
							} else {

								array_push($array_errores, $insertar_notificacion_trasladista_anterior);
							}
						} else {
							array_push($array_errores, $actualizar_colaborador_nuevo);
						}
					} else {

						array_push($array_errores, $insertar_change_ejecutivo);
					}
				} else {

					array_push($array_errores, "- Ocurrió un error al actualizar el colaborador anterior<br>");
				}
			} else {

				array_push($array_errores, "-Error al asignar <br>");
			}
		} else {

			array_push($array_errores, "- La logística esta en la fase: <b>$ver_recorrido</b>, ya no se puede asignar al trasladista se debe de eliminar los movimientos para poder asignar.<br>");
		}
	} else {

		array_push($array_errores, "El número de orden no existe <b>$id_log</b>.");
	}
} else {
	array_push($array_errores, $ver_trasladista_diferente);
}


$concatenador_errores = TratarNumeroText($array_errores);

echo $mensaje = "$concatenador_errores|$numero_whats_trasladista_anterior|$numero_whats_trasladista_nuevo|$whats_recurso1|$whats_recurso2|$whats_programada|";


#----------------------------------------------------------Verificar trasldista diferente-------------------------------------------------------------------------------------------

function VerificarTrasladitaDiferente($id_log, $id_trasladista, $tipo_trasladista)
{

	$id_log = trim($id_log);
	$id_trasladista = trim($id_trasladista);
	$tipo_trasladista = trim($tipo_trasladista);

	$query_verificar_trasladista = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$id_log' AND idasigna = '$id_trasladista' AND tipo_asignante = '$tipo_trasladista'";
	$result_verificar_trasladista = mysql_query($query_verificar_trasladista);

	if (mysql_num_rows($result_verificar_trasladista) == 0) {

		$query_buscar_ayudante = "SELECT * FROM orden_logistica_ayudante WHERE visible = 'SI' and trim(idorden_logistica) = '$id_log' and trim(id_colaborador_proveedor) = '$id_trasladista' and trim(tipo) = '$tipo_trasladista'";
		$result_buscar_ayudante = mysql_query($query_buscar_ayudante);

		if (mysql_num_rows($result_buscar_ayudante) == 0) {

			$resltado_es_diferente = 1;
		} else {
			$resltado_es_diferente = "Ya se encuentra agregado como acompañante, si deseas agregarlo como principal debes de quitarlo como acompañante.<br>";
		}
	} else {

		$resltado_es_diferente = "Es el mismo que estas intentando cambiar.<br>";
	}

	return $resltado_es_diferente;
}

#---------------------------------------------------------- Verificar Estatus Recorrido Estatus -------------------------------------------------------------------------------------------

function VerificarRecorrido($idorden_logistica)
{

	$idorden_logistica = trim($idorden_logistica);

	$query_recorrido = "SELECT * FROM orden_logistica_bitacora where visible = 'SI' and idorden_logistica = '$idorden_logistica' and valor = '1' order by idorden_logistica_bitacora desc limit 1;";
	$result_recorrido = mysql_query($query_recorrido);

	while ($row_recorrido = mysql_fetch_array($result_recorrido)) {

		$valor_recorrido = (trim($row_recorrido[tipo]) == "Solicitud" || trim($row_recorrido[tipo]) == "Enterado" || trim($row_recorrido[tipo]) == "Inicia Recorrido") ? 1 : trim($row_recorrido[tipo]);
	}
	return $valor_recorrido;
}


#----------------------------------------------------------Update Colaborador------------------------------------------------------------------------------------------

function updateColaboradores($id_colaborador_actualizar, $type_estado)
{

	$update_empleados = "UPDATE empleados SET columna_a = '$type_estado' WHERE idempleados = '$id_colaborador_actualizar'";
	$result_update_empleado = mysql_query($update_empleados);


	$trim_name = explode("|", nombres_datos($id_colaborador_actualizar, "Colaborador"));

	$result_update_colaborador = ($result_update_empleado == 1) ? 1 : "-Error al Actualizar el  Estatus de <b>$trim_name[2]|</b>";

	return $result_update_colaborador;
}

#----------------------------------------------------------Actualizar VIN------------------------------------------------------------------------------------------

function ActualizarVin($id_log, $id_trasladista, $tipo_trasladista, $array_asignacion_vin)
{

	$id_log = trim($id_log);
	$array_errores_vin = array();

	$query_unidades = "SELECT * FROM orden_logistica_unidades WHERE visible = 'SI' AND idorden_logistica = '$id_log'";
	$result_unidades = mysql_query($query_unidades);

	if (mysql_num_rows($result_unidades) >= 1) {

		while ($row_unidades = mysql_fetch_array($result_unidades)) {

			$query_update_unidades = "UPDATE orden_logistica_unidades SET idresponsable = '$id_trasladista', tipo_responsable = '$tipo_trasladista' WHERE idorden_logistica_unidades = '$row_unidades[idorden_logistica_unidades]' ";
			$result_update_unidades = mysql_query($query_update_unidades);

			$mensaje_update_vin = ($result_update_unidades == 1) ? 1 : "- Error al actualizar el movimiento $row_unidades[idorden_logistica_unidades]. <br>";

			array_push($array_errores_vin, $mensaje_update_vin);

			if (trim($row_unidades[idpersona_asignada]) == $id_trasladista and trim($row_unidades[tipopersona_asignada]) == "$tipo_trasladista") {

				$update_unidades_asigando = "UPDATE orden_logistica_unidades SET idpersona_asignada = '$id_trasladista', tipopersona_asignada = '$tipo_trasladista' WHERE idorden_logistica_unidades = '$row_unidades[idorden_logistica_unidades]' ";
				$result_unidades_asigando = mysql_query($update_unidades_asigando);

				$mensaje_asignado = ($result_unidades_asigando == 1) ? 1 : "- Error al actualizar el movimiento $row_unidades[idorden_logistica_unidades]. <br>";

				array_push($array_errores_vin, $mensaje_asignado);
			} else {
				array_push($array_errores_vin, "1");
			}
		}
	} else {

		array_push($array_errores_vin, "1");
	}

	return $resultado_vin = TratarNumeroText($array_errores_vin);
}

#---------------------------------------------------------- Actualizar Recurso Actualizar Recibos Actualizar------------------------------------------------------------------------------------------

function ActualizarRecursoWallet($id_log, $estatus_actual, $id_trasladista, $tipo_trasladista, $usuario_creador, $fecha_creacion, $fecha_guardado, $comentarios, $coordenadas, $nomenclatura_trasladista_anterior)
{

	$id_log = trim($id_log);
	$estatus_actual = trim($estatus_actual);

	$id_trasladista = trim($id_trasladista);
	$tipo_trasladista = trim($tipo_trasladista);

	$columna_c = $comentarios;

	$array_errores_recuso = array();

	$ver_actualizar_recurso =  VerificarRecorrido($id_log);

	if ($ver_actualizar_recurso == 1) {

		$query_recurso = "SELECT * FROM orden_logistica_recurso WHERE idorden_logistica = '$id_log'";
		$resut_recurso = mysql_query($query_recurso);

		if (mysql_num_rows($resut_recurso) >= 1) {

			while ($row_recurso = mysql_fetch_array($resut_recurso)) {

				if ($row_recurso[concepto] == "Recepción") {

					$nombre_recurso_change = explode("|", nombres_datos($id_trasladista, $tipo_trasladista));

					$update_recibos = "UPDATE orden_logistica_recurso SET receptora_agente = '$nombre_recurso_change[10]' WHERE idorden_logistica_recurso = '$row_recurso[idorden_logistica_recurso]'";
					$result_recibos = mysql_query($update_recibos);

					if ($result_recibos == 1) {

						array_push($array_errores_recuso, "1");
						#
					} else {
						array_push($array_errores_recuso, "Error al actualizar el movimiento <b>$row_recurso[idorden_logistica_recurso], de la tabla recurso. 1</b><br>");
					}
				} else {
					array_push($array_errores_recuso, "1");
				}

				$query_empleados_wallet = "SELECT * FROM empleados_wallet where visible = 'SI' and referencia_seguimiento = '$row_recurso[referencia]' ";
				$result_empleados_wallet = mysql_query($query_empleados_wallet);

				if (mysql_num_rows($result_empleados_wallet) >= 1) {


					while ($row_empleados_wallet = mysql_fetch_array($result_empleados_wallet)) {

						if (trim($row_empleados_wallet[tipo]) == "Egreso") {

							if ($estatus_actual == "Nuevo") {

								$query_update_wallet_egreso = "UPDATE empleados_wallet SET receptor = '$id_trasladista', tipo_receptor = '$tipo_trasladista' WHERE idempleados_wallet = '$row_empleados_wallet[idempleados_wallet]' ";
								$result_update_wallet_egreso = mysql_query($query_update_wallet_egreso);

								if ($result_update_wallet_egreso == 1) {

									array_push($array_errores_recuso, "1");

									$mensaje_token = "Nuevo token: *$row_empleados_wallet[token]*";
									$numero_whats_entrega = "https://api.whatsapp.com/send?phone=$nombre_recurso_change[3]&text=$mensaje_token";
									#
								} else {

									array_push($array_errores_recuso, "Error al actualizar el movimiento <b>$row_empleados_wallet[idempleados_wallet]</b> en la wallet 2.<br>");

									$mensaje_token = "";
									$numero_whats_entrega = "";
								}
							} else {

								$generar_token_egreso = generate_token($ok);

								$query_update_wallet_egreso = "UPDATE empleados_wallet SET receptor = '$id_trasladista', tipo_receptor = '$tipo_trasladista', token = '$generar_token_egreso' WHERE idempleados_wallet = '$row_empleados_wallet[idempleados_wallet]' ";
								$result_update_wallet_egreso = mysql_query($query_update_wallet_egreso);

								if ($result_update_wallet_egreso == 1) {
									$change_bitacora_egreso = WalletInsertBitacora($row_empleados_wallet[idempleados_wallet], $row_empleados_wallet[referencia], "Cambio Colaborador", "Se realizo un cambio de Colaborador de <b>$nomenclatura_trasladista_anterior</b> por <b>$nombre_recurso_change[2]</b>", "1", "SI", $usuario_creador, $fecha_creacion, $fecha_guardado, $id_log, "Logistica", $row_empleados_wallet[token], "Egreso", $columna_c, $columna_d, $columna_e);
								}

								$new_token_egreso = LogisticaInsertBitacora("Nuevo token por cambio de Ejecutivo <b>Entrega de Recurso</b>", "Token", $id_log, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "13", "", $columna_d, "SI");

								$query_bitacora_wallet_egreso = "SELECT * FROM wallet_bitacora WHERE visible = 'SI' and id_id = '$id_log' and tipo_type = 'Logistica' and columna_b = 'Egreso' and tipo = 'Confirmar Recibo' ";
								$result_bitacora_wallet_egreso = mysql_query($query_bitacora_wallet_egreso);

								if ($result_bitacora_wallet_egreso >= 1) {

									while ($row_bitacora_wallet_egreso = mysql_fetch_array($result_bitacora_wallet_egreso)) {

										$query_update_bitacora_egreso = "UPDATE wallet_bitacora SET visible = 'NO' WHERE idwallet_bitacora = '$row_bitacora_wallet_egreso[idwallet_bitacora]'";
										$resul_update_bitacora_egreso = mysql_query($query_update_bitacora_egreso);
									}
								}

								if ($resul_update_bitacora_egreso == 1) {

									array_push($array_errores_recuso, "1");

									$mensaje_token = "Nuevo token: *$generar_token_egreso*";
									$numero_whats_entrega = "https://api.whatsapp.com/send?phone=$nombre_recurso_change[3]&text=$mensaje_token";
									#
								} else {

									array_push($array_errores_recuso, "Error al actualizar el movimiento <b>$row_empleados_wallet[idempleados_wallet]</b> en la wallet.3<br>");
									$mensaje_token = "";
									$numero_whats_entrega = "";
									#
								}
							}
						} else {

							if ($estatus_actual == "Nuevo") {

								$query_update_wallet_ingreso = "UPDATE empleados_wallet SET receptor = '$id_trasladista', tipo_receptor = '$tipo_trasladista' WHERE idempleados_wallet = '$row_empleados_wallet[idempleados_wallet]' ";
								$result_update_wallet_ingreso = mysql_query($query_update_wallet_ingreso);



								if ($result_update_wallet_ingreso == 1) {

									array_push($array_errores_recuso, "1");

									$mensaje_token = "Nuevo token: *$row_empleados_wallet[token]*";
									$numero_whats_recepcion = "https://api.whatsapp.com/send?phone=$nombre_recurso_change[3]&text=$mensaje_token";
									#
								} else {

									array_push($array_errores_recuso, "Error al actualizar el movimiento <b>$row_empleados_wallet[idempleados_wallet]</b> en la wallet 4.<br>");

									$mensaje_token = "";
									$numero_whats_recepcion = "";
									#
								}
							} else {

								$generar_token_ingreso = generate_token($ok);

								$query_update_wallet_ingreso = "UPDATE empleados_wallet SET receptor = '$id_trasladista', tipo_receptor = '$tipo_trasladista', token = '$generar_token_ingreso' WHERE idempleados_wallet = '$row_empleados_wallet[idempleados_wallet]' ";
								$result_update_wallet_ingreso = mysql_query($query_update_wallet_ingreso);

								if ($result_update_wallet_ingreso == 1) {

									$change_bitacora_ingreso = WalletInsertBitacora($row_empleados_wallet[idempleados_wallet], $row_empleados_wallet[referencia], "Cambio Colaborador", "Se realizo un cambio de Colaborador de <b>$nomenclatura_trasladista_anterior</b> por <b>$nombre_recurso_change[2]</b>", "2", "SI", $usuario_creador, $fecha_creacion, $fecha_guardado, $id_log, "Logistica", $row_empleados_wallet[token], "Ingreso", $columna_c, $columna_d, $columna_e);
								}


								$new_token_ingreso = LogisticaInsertBitacora("Nuevo token por cambio de Ejecutivo <b>Recepción de Recurso</b>", "Token", $id_log, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "13", "", $columna_d, "SI");

								$query_bitacora_wallet_ingreso = "SELECT * FROM wallet_bitacora WHERE visible = 'SI' and id_id = '$id_log' and tipo_type = 'Logistica' and columna_b = 'Ingreso' and tipo = 'Confirmar Recibo' ";
								$result_bitacora_wallet_ingreso = mysql_query($query_bitacora_wallet_ingreso);


								if (mysql_num_rows($result_bitacora_wallet_ingreso) >= 1) {

									while ($row_bitacora_wallet_ingreso = mysql_fetch_array($result_bitacora_wallet_ingreso)) {

										$query_update_bitacora_ingreso = "UPDATE wallet_bitacora SET visible = 'NO' WHERE idwallet_bitacora = '$row_bitacora_wallet_ingreso[idwallet_bitacora]'";
										$resul_update_bitacora_ingreso = mysql_query($query_update_bitacora_ingreso);
									}
								} else {
									$resul_update_bitacora_ingreso = 1;
								}


								if ($resul_update_bitacora_ingreso == 1) {

									array_push($array_errores_recuso, "1");

									$mensaje_token = "Nuevo token: *$generar_token_ingreso*";
									$numero_whats_recepcion = "https://api.whatsapp.com/send?phone=$nombre_recurso_change[3]&text=$mensaje_token";
									#
								} else {

									array_push($array_errores_recuso, "Error al actualizar el movimiento <b>$row_empleados_wallet[idempleados_wallet]</b> en la wallet 5.<br>");

									$mensaje_token = "";
									$numero_whats_recepcion = "";
									#
								}
							}
						}
					}
					#	
				} else {
					array_push($array_errores_recuso, "1");
				}
			}
		} else {
			array_push($array_errores_recuso, "1");
		}
	} else {

		array_push($array_errores_recuso, "El Recurso no puede ser actualizado, debido a que el trasladista no se encuentra dentro de la fase: <b>Enterado</b> ó <b>Inicia Recorrido</b>, es necesario eliminar sus movimientos para poder actualizar.<br>");
	}

	$ver_estatus_recurso = TratarNumeroText($array_errores_recuso);

	return "$ver_estatus_recurso|$numero_whats_entrega|$numero_whats_recepcion";
}

#---------------------------------------------------------- Logistica Programada ------------------------------------------------------------------------------------------

function LogisticaProgramada($usser_solicitante, $id_log, $logistica_encriptada, $nomenclatura_nuevo_trasladista, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado)
{

	$usser_solicitante = trim($usser_solicitante);

	#------------------------Verificar si se envia o no Mensaje de logistica a el usuario creador

	$query_usuarios = "SELECT * FROM usuarios WHERE idusuario = '$usser_solicitante'";
	$result_usuario = mysql_query($query_usuarios);

	while ($row_usuario = mysql_fetch_array($result_usuario)) {
		$rol = "$row_usuario[rol]";
		$idempleado_creador = "$row_usuario[idempleados]";
	}

	#------------------------Obtenemos el nombre de el usuario creador

	$nombre_usser_creador = nombres_datos($idempleado_creador, "Colaborador");
	$nomenclatura_usser_creador = explode("|", $nombre_usser_creador);


	if ($rol != "100") {

		$direccionador_carpeta = ($nomenclatura_usser_creador[13] == "Ejecutivo de Traslado") ? "https://www.panamotorscenter.com/Prod/CCP/Perfiles2/Ejecutivos_Traslado/orden_logistica_detalles.php?idib=$logistica_encriptada" : "https://www.panamotorscenter.com/Prod/CCP/Perfiles2/Generar_Logistica/orden_logistica_detalles.php?idib=$logistica_encriptada";

		$notificacion_whats = "*$nomenclatura_usser_creador[2]* La Logística  No. *$id_log*, Esta siendo atendida Por: *$nomenclatura_nuevo_trasladista* conoce los detalles consultando CCP";
		$notificacion_bd = "<b>$nomenclatura_usser_creador[2]</b> La Logística No. <b>$id_log</b>, Esta siendo atendida Por: <b>$nomenclatura_nuevo_trasladista</b> conoce los detalles consultando CCP";
		$whatsapp_solicitante = "https://api.whatsapp.com/send?phone=$nomenclatura_usser_creador[3]&text=$notificacion_whats $direccionador_carpeta";

		$insert_notificacion = LogisticaInsertBitacora($notificacion_bd, "Notificación", $id_log, "", $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "2", "", "", "SI");

		$resultado_logistica_programada = ($insert_notificacion == 1) ? 1 : "Error al insertar la bitácora de logística programada.<br>";
		#
	} else {

		$resultado_logistica_programada = 1;
		$whatsapp_solicitante = "";
	}

	return "$resultado_logistica_programada|$whatsapp_solicitante";
}
