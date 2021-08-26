<?php 
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$usuario_creador=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];

$tipo_formulario = $_POST['tipo_formulario'];
$idunidades_utilitarios_herramientas = base64_decode($_POST['iduuh']);
$tipo = $_POST['tipo'];
$descripcion = $_POST['descripcion'];
$idorden = $_POST['idorden'];
$tipo_orden = $_POST['tipo_orden'];
$estatus = trim($_POST['estatus']);
$columna_a = $_POST['columna_a'];
$columna_b = $_POST['columna_b'];
$columna_c = $_POST['columna_c'];
$fecha_a = $_POST['fecha_a'];
$fecha_vencimiento = $_POST['fecha_vencimiento'];
$comentarios = $_POST['comentarios'];
$fecha_creacion = $_POST['fecha_creacion'];

$visible = "SI";


$array_mensajes = array();


$query_herramientas = "SELECT * FROM unidades_utilitarios_herramientas WHERE idunidades_utilitarios_herramientas = '$idunidades_utilitarios_herramientas'";
$result_herramientas = mysql_query($query_herramientas);

if (mysql_num_rows($result_herramientas) == 0) {
	
	$mensaje = "No existe el movimiento";

}else {

	while ($row_herramientas = mysql_fetch_array($result_herramientas)) {

		if ($tipo_formulario == "Evidencia") {


			$ruta_archivo = "../../Documentacion_Logistica/Poliza_GPS_Utilitarias/";
			$nomenclatura_archivo_name = $row_herramientas[tipo]."_".$row_herramientas[vin]."_Usr_".$usuario_creador."_date_".$fecha_guardado;
			$name_input_file = "evidencia";

			$target_path = $ruta_archivo.$nomenclatura_archivo_name."_".basename( $_FILES[$name_input_file]['name']);

			$estatus_evidencia = CargarImagenEvidenciaIndividual ($ruta_archivo, $name_input_file, $target_path);


			if ($estatus_evidencia == "- Ocurrio un error al mover la Evidencia <br>" || $estatus_evidencia == "La carpeta $ruta_archivo no existe") {

				$mensaje = $estatus_evidencia;

			}else {

				$query_update_evidencia = "UPDATE unidades_utilitarios_herramientas SET valor = '$estatus_evidencia' where idunidades_utilitarios_herramientas = '$idunidades_utilitarios_herramientas'";
				$result_update_evidencia = mysql_query($query_update_evidencia);

				if (is_numeric($row_herramientas[idorden])) {

					$update_atencion_clientes = "UPDATE atencion_clientes SET archivo = '$estatus_evidencia' WHERE idatencion_clientes = '$row_herramientas[idorden]'";
					$result_atencion_clientes = mysql_query($update_atencion_clientes);
					
				}else {

					$result_atencion_clientes = 1;

				}

				if ($result_update_evidencia == 1 AND $result_atencion_clientes) {

					if (file_exists($row_herramientas[valor])) {

						$evidencia_bd = "<a href=\'$row_herramientas[valor]\' target=\'_blank\'><i class=\'far fa-image fa-2x\'></i><a>";
						$evidencia_nueva = "<a href=\'$estatus_evidencia\' target=\'_blank\'><i class=\'fas fa-image fa-2x\'></i><a>";

						$mesage_evidencia = "La evidencia cambio de: $evidencia_bd por $evidencia_nueva";	

					}else {

						$evidencia_nueva = "<a href=\'$estatus_evidencia\' target=\'_blank\' ><i class=\'far fa-image fa-2x\'></i><a>";
						$mesage_evidencia = "Se agregó nueva evidencia: $evidencia_nueva";

					}

					$evidencia_bitacora = UtilitariasInsertarBitacora ($mesage_evidencia, $row_herramientas[tipo], $row_herramientas[vin], $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, "4", "", "", "", $visible);
					$mensaje = ($evidencia_bitacora == 1) ? 1 : $evidencia_bitacora;

				}else {

					$mensaje = "Error al guardar el archivo ".$_FILES[$name_input_file]['name'];

				}
			}
		}elseif ($tipo_formulario == "Visible") {
#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

			$estatus_visible = ($row_herramientas[visible] == "SI") ? "NO" : "SI";
			$estatus_visible_mesage = ($row_herramientas[visible] == "SI") ? "Eliminar" : "Restaurar";
			$estatus_visible_mesage1 = ($row_herramientas[visible] == "SI") ? "Eliminado" : "Restaurado";

			$query_update_visible = "UPDATE unidades_utilitarios_herramientas SET visible = '$estatus_visible' WHERE idunidades_utilitarios_herramientas = '$idunidades_utilitarios_herramientas'";
			$result_update_visible = mysql_query($query_update_visible);

			if ($result_update_visible == 1) {

				$comentario_visible = "El movimiento de $row_herramientas[tipo] con $row_herramientas[descripcion] fue <b>$estatus_visible_mesage1</b> exitosamente";

				$fechas_bitacora  = UtilitariasInsertarBitacora ($comentario_visible, $row_herramientas[tipo], $row_herramientas[vin], $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, "6", "", "", "", $visible);
				$mensaje = ($fechas_bitacora == 1) ? 1 : $fechas_bitacora;
				
			}else {
				$mensaje = "- Error al $estatus_visible_mesage el movimiento de $row_herramientas[tipo] con $row_herramientas[descripcion] del vin <b>$row_herramientas[vin]</b>";
			}


		}elseif ($tipo_formulario == "EditarOrden") {

			#Concepto
			if ($tipo != "") {

				$actualizar_tipo = UpdateConcepto ("tipo", $tipo, $row_herramientas[tipo], $row_herramientas[vin], $idunidades_utilitarios_herramientas, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible, "7");
				array_push($array_mensajes, $actualizar_tipo);
			}

			#Descripcion
			if ($descripcion != "") {
				$actualizar_descripcion = UpdateConcepto ("descripcion", $descripcion, $row_herramientas[descripcion], $row_herramientas[vin], $idunidades_utilitarios_herramientas, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible, "10");
				array_push($array_mensajes, $actualizar_descripcion);
			}

			#idorden
			if ($idorden != "") {
				$actualizar_id_orden = UpdateConcepto ("idorden", $idorden, $row_herramientas[idorden], $row_herramientas[vin], $idunidades_utilitarios_herramientas, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible, "11");
				array_push($array_mensajes, $actualizar_id_orden);
			}

			#tipo_orden
			if ($tipo_orden != "") {
				$actualizar_tipo_orden = UpdateConcepto ("tipo_orden", $tipo_orden, $row_herramientas[tipo_orden], $row_herramientas[vin], $idunidades_utilitarios_herramientas, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible, "12");
				array_push($array_mensajes, $actualizar_tipo_orden);
			}

			#estatus
			if ($estatus != "") {
				$actualizar_estatus = UpdateConcepto ("estatus", $estatus, $row_herramientas[estatus], $row_herramientas[vin], $idunidades_utilitarios_herramientas, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible, "13");
				array_push($array_mensajes, $actualizar_estatus);
			}

			#columna_a
			if ($columna_a != "") {
				$actualizar_imei_poliza = UpdateConcepto ("columna_a", $columna_a, $row_herramientas[columna_a], $row_herramientas[vin], $idunidades_utilitarios_herramientas, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible, "14");
				array_push($array_mensajes, $actualizar_imei_poliza);
			}

			#columna_b
			if ($columna_b != "") {
				$actualizar_telefono = UpdateConcepto ("columna_b", $columna_b, $row_herramientas[columna_b], $row_herramientas[vin], $idunidades_utilitarios_herramientas, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible, "15");
				array_push($array_mensajes, $actualizar_telefono);
			}

			#columna_c
			if ($columna_c != "") {
				$actualizar_modalidad_pago = UpdateConcepto ("columna_c", $columna_c, $row_herramientas[columna_c], $row_herramientas[vin], $idunidades_utilitarios_herramientas, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible, "9");
				array_push($array_mensajes, $actualizar_modalidad_pago);
			}

			#Fecha Inicio
			if ($fecha_a != "") {
				$actualizar_fechas = UpdateFechas ($fecha_a, $fecha_vencimiento, $idunidades_utilitarios_herramientas, $row_herramientas[fecha_a], $row_herramientas[fecha_vencimiento], $row_herramientas[tipo], $row_herramientas[vin], $comentarios, $fecha_creacion, $fecha_guardado, $visible, $usuario_creador);
				array_push($array_mensajes, $actualizar_fechas);
			}

			#Fecha vencimiento
			if ($fecha_vencimiento != "") {
				$actualizar_fechas = UpdateFechas ($fecha_a, $fecha_vencimiento, $idunidades_utilitarios_herramientas, $row_herramientas[fecha_a], $row_herramientas[fecha_vencimiento], $row_herramientas[tipo], $row_herramientas[vin], $comentarios, $fecha_creacion, $fecha_guardado, $visible, $usuario_creador);
				array_push($array_mensajes, $actualizar_fechas);
			}


			$mensaje = TratarNumeroText ($array_mensajes);
			
			
		} else {

			$mensaje = "No exite esta opcion $tipo_formulario";

		}

	}	#while
}




echo $mensaje;
#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

function UpdateFechas ($date_a, $date_b, $idunidades_utilitarios_herramientas, $fecha_data_base_a, $fecha_dta_base_vencimiento, $data_base_tipo, $data_base_vin, $comentarios, $fecha_creacion, $fecha_guardado, $visible, $usuario_creador) {

	$estus_fecha_inicial = ($fecha_data_base_a == "" || $fecha_data_base_a == "0001-01-01") ? 0 : 1;
	$estus_fecha_final = ($fecha_dta_base_vencimiento == "" || $fecha_dta_base_vencimiento == "0001-01-01") ? 0 : 1;

	//$date_a = $_POST['fecha_a'];
	//$date_b = $_POST['fecha_vencimiento'];

			if ($estus_fecha_inicial == 0 and $estus_fecha_final == 0) {  #Auditado
				
				if ($date_a == "" and $date_b == "") {  #Auditado
					
					$evidencia_mensaje = "1- Error no estas ingresando ninguna fecha de inicio ni de vencimiento <br>";

				}else if ($date_a != "" and $date_b == "") {  #Auditado

					$query_update_fechas = "UPDATE unidades_utilitarios_herramientas SET fecha_a = '$date_a' WHERE idunidades_utilitarios_herramientas = '$idunidades_utilitarios_herramientas'";
					$result_update_fechas = mysql_query($query_update_fechas);

					if ($result_update_fechas == 1) {

						$fecha_inicio = date_create($date_a);
						$fecha_inicio = date_format($fecha_inicio, 'd-m-Y');

						$comentario_fechas = "Se agregó la fecha inicial <b>$fecha_inicio</b>";

						$fechas_bitacora  = UtilitariasInsertarBitacora ($comentario_fechas, $data_base_tipo, $data_base_vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, "5", "", "", "", $visible);
						$evidencia_mensaje = ($fechas_bitacora == 1) ? 1 : $fechas_bitacora;

					}else {
						$evidencia_mensaje = "- Error al guardar la fecha inicial <br>";
					}
					
				}elseif ($date_a == "" and $date_b != "") {  #Auditado

					$query_update_fechas = "UPDATE unidades_utilitarios_herramientas SET fecha_vencimiento = '$date_b' WHERE idunidades_utilitarios_herramientas = '$idunidades_utilitarios_herramientas'";
					$result_update_fechas = mysql_query($query_update_fechas);

					if ($result_update_fechas == 1) {

						$fecha_vencimiento = date_create($_POST['fecha_vencimiento']);
						$fecha_vencimiento = date_format($fecha_vencimiento, 'd-m-Y');

						$comentario_fechas = "Se agregó la fecha de vencimiento <b>$fecha_vencimiento</b>";

						$fechas_bitacora  = UtilitariasInsertarBitacora ($comentario_fechas, $data_base_tipo, $data_base_vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, "5", "", "", "", $visible);
						$evidencia_mensaje = ($fechas_bitacora == 1) ? 1 : $fechas_bitacora;

					}else {
						$evidencia_mensaje = "- Error al guardar la fecha de vencimiento <br>";
					}


				}elseif ($date_a != "" and $date_b != "") {  #Auditado


					if ($date_a < $date_b || $date_a == $date_b) {
						
						$query_update_fechas = "UPDATE unidades_utilitarios_herramientas SET fecha_a = '$date_a', fecha_vencimiento = '$date_b' WHERE idunidades_utilitarios_herramientas = '$idunidades_utilitarios_herramientas'";
						$result_update_fechas = mysql_query($query_update_fechas);

						if ($result_update_fechas == 1) {

							$fecha_inicio = date_create($date_a);
							$fecha_fin = date_create($date_b);

							$fecha_inicio = date_format($fecha_inicio, "d-m-y");
							$fecha_fin = date_format($fecha_fin, "d-m-y");
							
							$comentario_fechas = "Se agregó la fecha inicial <b>$fecha_inicio</b> <br> Se agregó la fecha de vencimiento <b>$fecha_fin</b>";

							$fechas_bitacora  = UtilitariasInsertarBitacora ($comentario_fechas, $data_base_tipo, $data_base_vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, "5", "", "", "", $visible);
							$evidencia_mensaje = ($fechas_bitacora == 1) ? 1 : $fechas_bitacora;

						}else {

							$evidencia_mensaje = "- Error al guardar fecha inicial y fecha de vencimiento <br>";

						}
					}  else{

						$evidencia_mensaje = "- La fecha de Inicial($date_a) es MAYOR que la fecha de vencimiento <b>$date_b</b> <br>";
					}	
				}


			}elseif ($estus_fecha_inicial == 0 and $estus_fecha_final == 1) { 	#Auditado

				if ($date_a == "") {

					$evidencia_mensaje = "2- Error no estas ingresando ninguna fecha <br>";

				}else {

					if ($date_a == $fecha_data_base_a) {

						$evidencia_mensaje = 1;

					}else {

						$query_update_fechas = "UPDATE unidades_utilitarios_herramientas SET fecha_a = '$date_a' WHERE idunidades_utilitarios_herramientas = '$idunidades_utilitarios_herramientas'";
						$result_update_fechas = mysql_query($query_update_fechas);

						if ($result_update_fechas == 1) {

							$fecha_inicio = date_create($date_a);
							$fecha_inicio = date_format($fecha_inicio, 'd-m-Y');

							$comentario_fechas = "Se agregó la fecha inicial <b>$fecha_inicio</b>";

							$fechas_bitacora  = UtilitariasInsertarBitacora ($comentario_fechas, $data_base_tipo, $data_base_vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, "5", "", "", "", $visible);
							$evidencia_mensaje = ($fechas_bitacora == 1) ? 1 : $fechas_bitacora;

						}else {

							$evidencia_mensaje = "- Error al guardar fecha inicial <br>";

						}
					}
				}

				
			}else if ($estus_fecha_inicial == 1 and $estus_fecha_final == 0) {	#Auditado

				
				if ($date_b == "") {

					$evidencia_mensaje = "3- Error no estas ingresando ninguna fecha <br>";

				}else {

					if ($date_b == $fecha_dta_base_vencimiento) {

						$evidencia_mensaje = 1;

					}else {

						$query_update_fechas = "UPDATE unidades_utilitarios_herramientas SET fecha_vencimiento = '$date_b' WHERE idunidades_utilitarios_herramientas = '$idunidades_utilitarios_herramientas'";
						$result_update_fechas = mysql_query($query_update_fechas);

						if ($result_update_fechas == 1) {

							$fecha_vencimiento = date_create($date_b);
							$fecha_vencimiento = date_format($fecha_vencimiento, 'd-m-Y');

							$comentario_fechas = "Se agregó la fecha de vencimiento <b>$fecha_vencimiento</b>";

							$fechas_bitacora  = UtilitariasInsertarBitacora ($comentario_fechas, $data_base_tipo, $data_base_vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, "5", "", "", "", $visible);
							$evidencia_mensaje = ($fechas_bitacora == 1) ? 1 : $fechas_bitacora;

						}else {

							$evidencia_mensaje = "- Error al guardar fecha inicial <br>";

						}
					}
				}


				
			}else if ($estus_fecha_inicial = 1 and $estus_fecha_final == 1) {




				$fecha_a_form_format = date_create($date_a);
				$fecha_a_form_format = date_format($fecha_a_form_format, 'd-m-Y');

				$fecha_b_form_format = date_create($date_b);
				$fecha_b_form_format = date_format($fecha_a_form_format, 'd-m-Y');

				
				

				$fecha_a_bd_format = date_create($fecha_data_base_a);
				$fecha_a_bd_format = date_format($fecha_a_bd_format, 'd-m-Y');

				$fecha_b_bd_format = date_create($fecha_dta_base_vencimiento);
				$fecha_b_bd_format = date_format($fecha_b_bd_format, 'd-m-Y');


				$fecha_a_db = $fecha_data_base_a;
				$fecha_b_db = $fecha_dta_base_vencimiento;


				$fecha_a_update = ($date_a == "") ? $fecha_a_db : $date_a;
				$fecha_b_update = ($date_b == "") ? $fecha_b_db : $date_b;


				if ($date_a == "" and $date_b == "") {	#Auditado

					$evidencia_mensaje = "4- Error no estas ingresando ninguna fecha  <br>";

				}else {


					if ($fecha_a_update < $fecha_b_update || $fecha_a_update == $fecha_b_update) {


						if ($date_a == $fecha_a_db and $date_b == $fecha_b_db) {	#Auditado

							$evidencia_mensaje = 1;

						}else {

							$query_update_fechas = "UPDATE unidades_utilitarios_herramientas SET fecha_a = '$fecha_a_update', fecha_vencimiento = '$fecha_b_update' WHERE idunidades_utilitarios_herramientas = '$idunidades_utilitarios_herramientas'";
							$result_update_fechas = mysql_query($query_update_fechas);

							if ($result_update_fechas == 1) {

								if ($date_a != $fecha_a_db and $date_b != $fecha_b_db) {

									$comentario_fechas = "La fecha inicial cambio del <b>$fecha_a_bd_format</b> al <b>$fecha_a_form_format</b> <br> La fecha de vencimiento cambio del <b>$fecha_b_bd_format</b> al <b>$fecha_b_form_format</b>";

									$fechas_bitacora  = UtilitariasInsertarBitacora ($comentario_fechas, $data_base_tipo, $data_base_vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, "5", "", "", "", $visible);
									$evidencia_mensaje = ($fechas_bitacora == 1) ? 1 : $fechas_bitacora;

								}elseif ($date_a != $fecha_a_db and $date_b == $fecha_b_db) {

									$comentario_fechas = "La fecha inicial cambio del <b>$fecha_a_bd_format</b> al <b>$fecha_a_form_format</b>";

									$fechas_bitacora  = UtilitariasInsertarBitacora ($comentario_fechas, $data_base_tipo, $data_base_vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, "5", "", "", "", $visible);
									$evidencia_mensaje = ($fechas_bitacora == 1) ? 1 : $fechas_bitacora;

								}elseif ($date_a == $fecha_a_db and $date_b != $fecha_b_db) {

									$comentario_fechas = "La fecha de vencimiento cambio del <b>$fecha_b_bd_format</b> al <b>$fecha_b_form_format</b>";

									$fechas_bitacora  = UtilitariasInsertarBitacora ($comentario_fechas, $data_base_tipo, $data_base_vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, "5", "", "", "", $visible);
									$evidencia_mensaje = ($fechas_bitacora == 1) ? 1 : $fechas_bitacora;

								}elseif ($date_a == $fecha_a_db and $date_b == $fecha_b_db) {

									$evidencia_mensaje = 1;

								}

							}else {
								$evidencia_mensaje = "- Error al actualizar las fechas <br>";
							}

						}

					}else {	#Auditado

						$evidencia_mensaje = "- La fecha de Inicial($fecha_a_update) es MAYOR que la fecha de vencimiento <b>$fecha_b_update</b> <br>";

					}
				}
			}else {
				$evidencia_mensaje = "- Ocurrio un error con las fechas <br>";
			}


			return $evidencia_mensaje;
		}

#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		function UpdateConcepto ($database_columna, $valor_nuevo, $data_base_tipo, $data_base_vin, $idunidades_utilitarios_herramientas, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible, $valor_bitacora) {


			if ($valor_nuevo == "") {

				$concepto_mensaje = "El $database_columna viene vacío";

			}else {

				if ($valor_nuevo ==  trim($data_base_tipo)) {

					$concepto_mensaje = 1;

				}else {

					$query_update_concepto = "UPDATE unidades_utilitarios_herramientas SET $database_columna = '$valor_nuevo' WHERE idunidades_utilitarios_herramientas = '$idunidades_utilitarios_herramientas'";
					$result_update_concepto = mysql_query($query_update_concepto);

					if ($result_update_concepto == 1) {

						$comentario_concepto = "El $database_columna cambio de <b>$data_base_tipo</b> a <b>$valor_nuevo</b>";

						$conceptos_bitacora  = UtilitariasInsertarBitacora ($comentario_concepto, $data_base_tipo, $data_base_vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $valor_bitacora, "", "", "", $visible);
						$concepto_mensaje = ($conceptos_bitacora == 1) ? 1 : $conceptos_bitacora;

					}else {	
						$concepto_mensaje = "- Error al modificar el $database_columna en el movimiento $data_base_tipo del vin <b>$data_base_vin</b>";
					}

				}
			}

			return $concepto_mensaje;
		}

#---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

















	?>