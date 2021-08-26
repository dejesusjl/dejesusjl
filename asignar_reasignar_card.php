<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales_insert.php";
include_once "funciones_principales.php";

date_default_timezone_set('America/Mexico_City');

$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];


$tipo_archivo = $_POST['tipo_archivo'];
$fecha_creacion = $_POST['fecha_creacion'];
$visible = "SI";

$fecha_archivo = date("Y-m-d-H:i:s");

#/*
if (isset($_FILES['archivo'])) {

	if ($tipo_archivo == "") {

		echo "2||No seleccionaste el tipo de archivo";
	} else {

		$extension = explode(".", $_FILES['archivo']['name']);

		if (end($extension) != "csv") {

			echo "2||Solo archivos <b>CSV</b>";
		} else {

			$ruta_archivo = "../../Documentacion_Logistica/Archivos_Casetas_Combustible/";

			$target_path = $ruta_archivo . "$tipo_archivo-" . "_Usr_" . $usuario_creador . $fecha_archivo . "_" . basename($_FILES['archivo']['name']);

			if (is_dir($ruta_archivo)) {

				$estatus_evidencia = (move_uploaded_file($_FILES['archivo']['tmp_name'], $target_path)) ? $target_path : "||- Ocurrio un error al mover el Archivo<br>";
			} else {

				$estatus_evidencia = "||La carpeta $ruta_archivo no existe";
			}


			if ($estatus_evidencia == "||La carpeta $ruta_archivo no existe" || $estatus_evidencia == "||- Ocurrio un error al mover el Archivo<br>") {

				echo $estatus_evidencia;
			} else {

				$fecha_guardado = date("Y-m-d H:i:s");

				$query_insert_archivo = "INSERT INTO orden_logistica_archivos_casetas_combustible (tipo_archivo, ruta, fecha_inicio, fecha_fin, total_movimientos, movimientos_insertados, movimientos_duplicados, movimientos_actualizados, movimientos_restantes, comentarios, visible, usuario_creador, fecha_creacion, fecha_guardado, columna_a, columna_b, columna_c) VALUES ('$tipo_archivo', '$estatus_evidencia', '0001-01-01', '0001-01-01', '', '', '', '', '', '', '$visible', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '', '', '')";
				$result_insert_archivo = mysql_query($query_insert_archivo);

				if ($result_insert_archivo == 1) {

					$rs = mysql_query("SELECT @@identity AS id");
					if ($row_ultimo_insert = mysql_fetch_row($rs)) {
						$idorden_logistica_archivos_casetas_combustible = trim($row_ultimo_insert[0]);
					}

					#						*/
					/*
$estatus_evidencia = "../../Documentacion_Logistica/Archivos_Casetas_Combustible/Plantilla Proveedores-_Usr_99_Plantilla_Proveedores.csv";
$tipo_archivo = "Plantilla Proveedores";
$fecha_creacion = date("Y-m-d H:i:s");
$idorden_logistica_archivos_casetas_combustible = 34;
*/
					$array_options = ['Casetas Cierres', 'Casetas Cargos', 'Movimientos Diarios Broxel', 'Factura Broxel', 'Factura Si Vale'];

					$array_secundario = ['Plantilla Proveedores'];

					if (in_array($tipo_archivo, $array_options)) {

						echo ProcesarInfoCasetasCombustible($tipo_archivo, $fecha_creacion, $visible, $estatus_evidencia, $idorden_logistica_archivos_casetas_combustible, $usuario_creador);
						#
					} elseif (in_array($tipo_archivo, $array_secundario)) {

						echo ProcesarPlantillaProveedores($tipo_archivo, $fecha_creacion, $visible, $estatus_evidencia, $idorden_logistica_archivos_casetas_combustible, $usuario_creador);
						#
					} else {

						echo ErrorFuncionFallo($tipo_archivo, $fecha_creacion, $visible, $estatus_evidencia, $idorden_logistica_archivos_casetas_combustible);
					}
					#/*
				} else {

					echo "||<b>Error al guardar el archivo</b>";
				}
			}
		}
	}
} else {

	echo "||<b>No hay Archivo</b>";
}
#*/
#------------------------------------------- Factura Broxel Factura --------------------------------------------------------------------------------

function ProcesarInfoCasetasCombustible($tipo_archivo, $fecha_creacion, $visible, $estatus_evidencia, $idorden_logistica_archivos_casetas_combustible, $usuario_creador)
{

	$fila = 1;
	$linea = 0;

	$contador_insertados = 0;
	$contador_duplicados = 0;
	$contador_error_insert = 0;
	$contador_actualizados = 0;
	$concatenar_errores_movimientos_factura = "";

	$concatenar_resultado = array();
	$array_fechas = array();

	$caseta = "";
	$carril = "";
	$gran_total = "";

	$litros = "";
	$precio_unitario = "";

	#---Combustible
	$buscar_fecha = "";
	unset($buscar_fecha);
	$fecha_movimiento = "";
	unset($fecha_movimiento);
	$cuenta = "";
	unset($cuenta);
	$busqueda_6 = "";
	unset($busqueda_6);
	$busqueda_4 = "";
	unset($busqueda_4);
	$tarjeta_busqueda = "";
	unset($tarjeta_busqueda);
	$tarjeta = "";
	unset($tarjeta);
	$titular = "";
	unset($titular);
	$establecimiento = "";
	unset($establecimiento);
	$rfc = "";
	unset($rfc);
	$monto_litros = "";
	unset($monto_litros);
	$total_litros = "";
	unset($total_litros);
	$litros = "";
	unset($litros);
	$gran_total = "";
	unset($gran_total);
	$precio_unitario = "";
	unset($precio_unitario);

	#---MensajeFinal
	$resultado_procesar_archivo = "";
	unset($resultado_procesar_archivo);

	if (($gestor = fopen($estatus_evidencia, "r")) !== FALSE) {

		while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {

			$numero = count($datos);

			$linea++;

			if ($linea > 1) {

				$fila++;


				for ($c = 0; $c < $numero; $c++) {

					$fecha_guardado = date("Y-m-d H:i:s");


					// Inicicia insert de Casetas

					if ($tipo_archivo == "Casetas Cierres") {

						$concepto_archivos = "Pase, Servicios Electronicos, S.A. DE C.V.";

						if (strlen(trim($datos[4])) == 5 and strlen(trim($datos[5])) == 14 and strlen(trim($datos[7])) == 10 and strlen(trim($datos[8])) < 9 and strlen(trim($datos[8])) < 9 and is_numeric(trim($datos[12])) and is_numeric(trim($datos[19]))) {

							# Convertir la Fecha
							$buscar_fecha = explode("/", $datos[7]);
							$fecha_movimiento = "$buscar_fecha[0]-$buscar_fecha[1]-$buscar_fecha[2] $datos[8]";
							array_push($array_fechas, $fecha_movimiento);

							# TAG

							$tag = substr($datos[5], 4, -2);
							$tag = trim($tag);

							# Caseta

							$array_caseta = str_split($datos[10]);

							unset($caseta);

							foreach ($array_caseta as $key => $value) {

								$caseta .= str_replace("?", "_", preg_replace('@\x{FFFD}@u', '_', $value));
							}

							$caseta = trim($caseta);

							#Carril

							$array_carril = str_split($datos[11]);

							unset($carril);

							foreach ($array_carril as $key_carril => $value_carril) {

								$carril .= str_replace("?", "_", preg_replace('@\x{FFFD}@u', '_', $value_carril));
							}

							$carril = trim($carril);

							# Responsable tag

							$responsable = explode("|", BuscarMonederoElectronico($tag));

							# clase

							$clase = trim($datos[9]);

							#Monto Total

							$gran_total = trim(floatval(Dinero($datos[12])));

							#consecar

							$consecar = trim($datos[19]);

							$query_casetas_cierres_repetido = "SELECT * FROM orden_logistica_casetas where trim(tag) = '$tag' AND fecha_movimiento = '$fecha_movimiento' AND caseta = '$caseta' AND carril = '$carril' AND gran_total = '$gran_total' ";
							$result_casetas_cierres_repetido = mysql_query($query_casetas_cierres_repetido);

							if (mysql_num_rows($result_casetas_cierres_repetido) >= 1) {

								array_push($concatenar_resultado, "Duplicado<br>");
								$contador_duplicados++;
							} else {

								$query_insert_cierres_repetidos = "INSERT INTO orden_logistica_casetas (tipo, concepto, idorden_logistica_archivos_casetas_combustible, responsable, tag, fecha_movimiento, caseta, carril, clase, gran_total, consecar, idorden_logistica, estatus, columna_c, visible, usuario_creador, fecha_creacion, fecha_guardado) VALUES ('$tipo_archivo', 'TAG', '$idorden_logistica_archivos_casetas_combustible', '$responsable[3]', '$tag', '$fecha_movimiento', '$caseta', '$carril', '$clase', '$gran_total', '$consecar', '', 'Pendiente', '', '$visible', '$usuario_creador', '$fecha_creacion', '$fecha_guardado')";
								$result_insert_cierres_repetidos = mysql_query($query_insert_cierres_repetidos);

								if ($result_insert_cierres_repetidos == 1) {

									$contador_insertados++;

									array_push($concatenar_resultado, "1");
								} else {

									$mensaje_resultado = "Error al insertar el movimiento <b>($linea)</b> tarjeta: <b>$tag</b>, Establecimiento: <b>$caseta</b> monto de <b>$gran_total</b><br>";
									$concatenar_errores_movimientos_factura .= "<b>$linea</b>,";

									array_push($concatenar_resultado, $mensaje_resultado);

									$contador_error_insert++;
								}
							}
						} else {

							$mensaje_resultado = "Error al insertar el movimiento <b>($linea)</b><b>Es posible que el archivo no corresponda a la opción seleccionada ($tipo_archivo)</b><br>$<hr>";
							$concatenar_errores_movimientos_factura .= "<b>$linea</b>,";

							array_push($concatenar_resultado, $mensaje_resultado);

							$contador_error_insert++;
						}
					} else if ($tipo_archivo == "Casetas Cargos") {

						$concepto_archivos = "Pase, Servicios Electronicos, S.A. DE C.V.";

						if (strlen(trim($datos[0])) == 14 and strlen(trim($datos[2])) == 10 and strlen(trim($datos[3])) <= 8 and is_numeric(trim($datos[6])) and is_numeric(trim($datos[10]))) {

							# Convertir la Fecha
							$buscar_fecha = explode("/", $datos[2]);
							$fecha_movimiento = "$buscar_fecha[2]-$buscar_fecha[1]-$buscar_fecha[0] $datos[3]";
							array_push($array_fechas, $fecha_movimiento);

							# TAG
							$tag = substr($datos[0], 4, -2);
							$tag = trim($tag);

							# Caseta

							$array_caseta = str_split($datos[4]);

							unset($caseta);

							foreach ($array_caseta as $key => $value) {

								$caseta .= str_replace("?", "_", preg_replace('@\x{FFFD}@u', '_', $value));
							}

							$caseta = trim($caseta);

							#Carril

							$array_carril = str_split($datos[5]);

							unset($carril);

							foreach ($array_carril as $key_carril => $value_carril) {

								$carril .= str_replace("?", "_", preg_replace('@\x{FFFD}@u', '_', $value_carril));
							}

							$carril = trim($carril);

							# Responsable tag

							$responsable = explode("|", BuscarMonederoElectronico($tag));

							# clase

							$clase = trim($datos[6]);

							#Monto Total

							$gran_total = trim(floatval(Dinero($datos[7])));

							#consecar

							$consecar = trim($datos[10]);

							$query_casetas_cierres_repetido = "SELECT * FROM orden_logistica_casetas where trim(tag) = '$tag' AND fecha_movimiento = '$fecha_movimiento' AND caseta = '$caseta' AND carril = '$carril' AND gran_total = '$gran_total' ";
							$result_casetas_cierres_repetido = mysql_query($query_casetas_cierres_repetido);

							if (mysql_num_rows($result_casetas_cierres_repetido) >= 1) {

								array_push($concatenar_resultado, "Duplicado<br>");
								$contador_duplicados++;
							} else {

								$query_insert_cierres_repetidos = "INSERT INTO orden_logistica_casetas (tipo, concepto, idorden_logistica_archivos_casetas_combustible, responsable, tag, fecha_movimiento, caseta, carril, clase, gran_total, consecar, idorden_logistica, estatus, columna_c, visible, usuario_creador, fecha_creacion, fecha_guardado) VALUES ('$tipo_archivo', 'TAG', '$idorden_logistica_archivos_casetas_combustible', '$responsable[3]', '$tag', '$fecha_movimiento', '$caseta', '$carril', '$clase', '$gran_total', '$consecar', '', 'Pendiente', '', '$visible', '$usuario_creador', '$fecha_creacion', '$fecha_guardado')";
								$result_insert_cierres_repetidos = mysql_query($query_insert_cierres_repetidos);

								if ($result_insert_cierres_repetidos == 1) {

									$contador_insertados++;

									array_push($concatenar_resultado, "1");
								} else {

									$mensaje_resultado = "Error al insertar el movimiento <b>($linea)</b> tarjeta: <b>$tag</b>, Establecimiento: <b>$caseta</b> monto de <b>$gran_total</b><br>";
									$concatenar_errores_movimientos_factura .= "<b>$linea</b>,";

									array_push($concatenar_resultado, $mensaje_resultado);

									$contador_error_insert++;
								}
							}
						} else {

							$mensaje_resultado = "Error al insertar el movimiento <b>($linea)</b><b>Es posible que el archivo no corresponda a la opción seleccionada ($tipo_archivo)</b><br><hr>";
							$concatenar_errores_movimientos_factura .= "<b>$linea</b>,";

							array_push($concatenar_resultado, $mensaje_resultado);

							$contador_error_insert++;
						}
					} elseif ($tipo_archivo == "Movimientos Diarios Broxel") {

						$concepto_archivos = "Servicios Broxel S.A.P.I de C.V.";

						$tarjeta_if_espacios = str_replace(" ", "", $datos[3]);

						if (strlen(trim($datos[0])) == 10 and is_numeric(trim($datos[1])) and strlen(trim($datos[1])) == 6 and strlen(trim($datos[2])) == 10 and is_numeric(trim($datos[2])) and strlen(trim($tarjeta_if_espacios)) == 16 and is_numeric(trim($datos[6])) and strlen(trim($datos[7])) == 3 and is_numeric(trim($datos[10]))) {
							# Convertir la Fecha
							$buscar_fecha = explode("/", $datos[0]);

							# Convertir la Hora

							$horas = substr($datos[1], 0, -4);

							# Convertir minutos

							$minutos = substr($datos[1], 2, -2);

							# Convertir segundos

							$segundos = substr($datos[1], -2);

							$fecha_movimiento = "$buscar_fecha[2]-$buscar_fecha[1]-$buscar_fecha[0] $horas:$minutos:$segundos";
							array_push($array_fechas, $fecha_movimiento);

							# cuenta

							$cuenta = trim($datos[2]);

							# Tarjeta


							$tarjeta_sin_espacios = str_replace(" ", "", $datos[3]);

							$busqueda_6 = substr(trim($tarjeta_sin_espacios), 0, -10);
							$busqueda_4 = substr(trim($tarjeta_sin_espacios), 12);

							$tarjeta_busqueda = explode("|", SearchCard($busqueda_6, $busqueda_4, "BROXEL"));
							$tarjeta = (trim($tarjeta_busqueda[0]) == "Error") ? trim($datos[3]) : trim($tarjeta_busqueda[0]);

							# Titular
							$titular = (trim($tarjeta_busqueda[2]) == "no se encontro en el catálogo") ? $datos[4] : trim($tarjeta_busqueda[2]);

							# Establecimiento

							$establecimiento = trim($datos[5]);

							# RFC

							$rfc = str_replace(" ", "", $datos[8]);
							$rfc = trim($rfc);

							# LITROS

							$litros = trim("0");

							# Monto Total

							$gran_total = trim(floatval(Dinero($datos[6])));

							# Referencia

							$referencia = trim($datos[10]);

							# Precio Unitario

							$precio_unitario = trim("0");

							$query_facturas_broxel = "SELECT * FROM orden_logistica_combustible where fecha_movimiento = '$fecha_movimiento' AND cuenta = '$cuenta' AND rfc = '$rfc' AND gran_total = '$gran_total' ";
							$result_facturas_broxel = mysql_query($query_facturas_broxel);

							if (mysql_num_rows($result_facturas_broxel) >= 1) {

								array_push($concatenar_resultado, "Duplicado<br>");
								$contador_duplicados++;
							} else {

								$query_insert_movimientos_broxel = "INSERT INTO orden_logistica_combustible (tipo, concepto, fecha_movimiento, cuenta, titular, tarjeta, establecimiento, rfc, litros, gran_total, precio_unitario, idorden_logistica_archivos_casetas_combustible, idorden_logistica, estatus, referencia, columna_b, columna_c, usuario_creador, visible, fecha_creacion, fecha_guardado) VALUES ('$tipo_archivo', 'Broxel', '$fecha_movimiento', '$cuenta', '$titular', '$tarjeta', '$establecimiento', '$rfc', '$litros', '$gran_total', '$precio_unitario', '$idorden_logistica_archivos_casetas_combustible', '', 'Pendiente', '$referencia', '', '', '$usuario_creador', '$visible', '$fecha_creacion', '$fecha_guardado')";
								$result_insert_movimientos_broxel = mysql_query($query_insert_movimientos_broxel);

								if ($result_insert_movimientos_broxel == 1) {

									$contador_insertados++;

									array_push($concatenar_resultado, "1");
								} else {

									$mensaje_resultado = "Error al insertar el movimiento <b>($linea)</b> tarjeta: <b>$tarjeta</b>, Establecimiento: <b>$establecimiento</b> monto de <b>$datos[12]</b><br><hr>";
									$concatenar_errores_movimientos_factura .= "<b>$linea</b>,";

									array_push($concatenar_resultado, $mensaje_resultado);

									$contador_error_insert++;
								}

								#---Combustible
								$buscar_fecha = "";
								unset($buscar_fecha);
								$fecha_movimiento = "";
								unset($fecha_movimiento);
								unset($horas);
								unset($minutos);
								unset($segundos);
								$cuenta = "";
								unset($cuenta);
								$busqueda_6 = "";
								unset($busqueda_6);
								$busqueda_4 = "";
								unset($busqueda_4);
								$tarjeta_busqueda = "";
								unset($tarjeta_busqueda);
								$tarjeta = "";
								unset($tarjeta);
								$titular = "";
								unset($titular);
								$establecimiento = "";
								unset($establecimiento);
								$rfc = "";
								unset($rfc);
								$monto_litros = "";
								unset($monto_litros);
								$total_litros = "";
								unset($total_litros);
								$litros = "";
								unset($litros);
								$gran_total = "";
								unset($gran_total);
								$precio_unitario = "";
								unset($precio_unitario);
							}
						} else {

							$datosdmb0 = strlen(trim($datos[0]));
							$datosdmb1n = (is_numeric($datos[1])) ? "SI" : "NO";
							$datosdmb1 = strlen(trim($datos[1]));
							$datosdmb2n = (is_numeric($datos[2])) ? "SI" : "NO";
							$datosdmb2 = strlen(trim($datos[2]));
							$datoscarddmb = strlen(trim($tarjeta_if_espacios));
							$datosdmb6n = (is_numeric($datos[6])) ? "SI" : "NO";
							$datosdmb7 = strlen(trim($datos[7]));
							$datosdmb10n = (is_numeric($datos[10])) ? "SI" : "NO";
							$mensaje_resultado = "
							Error al insertar el movimiento <b>($linea)</b><br>
							Es posible que el archivo no corresponda a la opción seleccionada <b>($tipo_archivo)</b> O Alguna columna no corresponda a los parametros establecidos para insertar el movimiento:<br>
							</b><br>-$datos[0]- $datosdmb0 Caracteres de 10<br>
							-$datos[1]- Númerico $datosdmb1n y $datosdmb1 Caracteres de 6<br>
							-$datos[2]- Númerico $datosdmb2n y $datosdmb2 Caracteres de 10<br>
							-$datos[3]- $datoscarddmb Caracteres de 16<br>
							-$datos[6]- Númerico $datosdmb6n<br>
							-$datos[7]- $datosdmb7 Caracteres de 3<br>
							-$datos[10]- Númerico $datosdmb10n<hr>";
							$concatenar_errores_movimientos_factura .= "<b>$linea</b>,";

							array_push($concatenar_resultado, $mensaje_resultado);

							$contador_error_insert++;
						}
					} else if ($tipo_archivo == "Factura Broxel") {

						$concepto_archivos = "Servicios Broxel S.A.P.I de C.V.";

						if (strlen(trim($datos[0])) == 10 and strlen(trim($datos[1])) == 10 and strlen(trim($datos[2])) == 8 and strlen(trim($datos[3])) == 8 and is_numeric(trim($datos[3])) and strlen(trim($datos[5])) == 17 and strlen(trim($datos[8])) == 3 and is_numeric(trim($datos[9]))) {
							# Convertir la Fecha
							$buscar_fecha = explode("/", $datos[0]);
							$fecha_movimiento = "$buscar_fecha[2]-$buscar_fecha[1]-$buscar_fecha[0] $datos[2]";
							array_push($array_fechas, $fecha_movimiento);

							# cuenta

							$cuenta = "00" . trim($datos[3]);

							# Tarjeta

							$busqueda_6 = substr(trim($datos[5]), 0, -11);
							$busqueda_4 = substr(trim($datos[5]), 13);

							$tarjeta_busqueda = explode("|", SearchCard($busqueda_6, $busqueda_4, "BROXEL"));
							$tarjeta = trim($tarjeta_busqueda[0]);

							# Titular

							$titular = trim($tarjeta_busqueda[2]);

							# Establecimiento

							$establecimiento = trim($datos[6]);

							# RFC

							$rfc = str_replace(" ", "", $datos[15]);
							$rfc = trim($rfc);

							# LITROS

							$monto_litros = trim($datos[9]);
							$total_litros = floatval($monto_litros);
							$litros = trim(Dinero($total_litros));

							# Monto Total

							$gran_total = trim(floatval(Dinero($datos[12])));

							# Precio Unitario

							$precio_unitario = trim(floatval(Dinero($datos[14])));


							$query_facturas_broxel = "SELECT * FROM orden_logistica_combustible where fecha_movimiento = '$fecha_movimiento' AND cuenta = '$cuenta' AND gran_total = '$gran_total'";
							$result_facturas_broxel = mysql_query($query_facturas_broxel);

							if (mysql_num_rows($result_facturas_broxel) >= 1) {

								while ($row_duplicados = mysql_fetch_array($result_facturas_broxel)) {

									//$new_rfc = ($row_duplicados[rfc] != $rfc) ? "rfc = '$rfc', " : "";
									$new_litros = ($row_duplicados[litros] != $litros) ? "litros = '$litros', " : "";
									$new_precio_unitario = ($row_duplicados[precio_unitario] != $precio_unitario) ? "precio_unitario = '$precio_unitario', " : "";

									$concatenar_update = $new_rfc . $new_litros . $new_precio_unitario;
									$cortar = substr($concatenar_update, 0, -2);

									$query_update_broxel = "UPDATE orden_logistica_combustible SET $cortar WHERE idorden_logistica_combustible = '$row_duplicados[idorden_logistica_combustible]'";
									$result_update_broxel = mysql_query($query_update_broxel);

									if ($result_update_broxel == 1) {

										$contador_actualizados++;
									} else {
									}
								}

								array_push($concatenar_resultado, "Duplicado<br>");
								$contador_duplicados++;
							} else {

								$query_insert_facturas_broxel = "INSERT INTO orden_logistica_combustible (tipo, concepto, fecha_movimiento, cuenta, titular, tarjeta, establecimiento, rfc, litros, gran_total, precio_unitario, idorden_logistica_archivos_casetas_combustible, idorden_logistica, estatus, referencia, columna_b, columna_c, usuario_creador, visible, fecha_creacion, fecha_guardado) VALUES ('$tipo_archivo', 'Broxel', '$fecha_movimiento', '$cuenta', '$titular', '$tarjeta', '$establecimiento', '$rfc', '$litros', '$gran_total', '$precio_unitario', '$idorden_logistica_archivos_casetas_combustible', '', 'Pendiente', '$referencia', '', '', '$usuario_creador', '$visible', '$fecha_creacion', '$fecha_guardado')";
								$result_insert_facturas_broxel = mysql_query($query_insert_facturas_broxel);

								if ($result_insert_facturas_broxel == 1) {

									$contador_insertados++;

									array_push($concatenar_resultado, "1");
								} else {

									$mensaje_resultado = "Error al insertar el movimiento <b>($linea)</b> tarjeta: <b>$tarjeta</b>, Establecimiento: <b>$establecimiento</b> monto de <b>$datos[12]</b><br><hr>";
									$concatenar_errores_movimientos_factura .= "<b>$linea</b>,";

									array_push($concatenar_resultado, $mensaje_resultado);

									$contador_error_insert++;
								}
							}
						} else {

							$mensaje_resultado = "Error al insertar el movimiento <b>($linea)</b><b>Es posible que el archivo no corresponda a la opción seleccionada ($tipo_archivo) <br >Alguna columna no corresponde a los parametros:</b><br>*$datos[0]* 10 Caracteres <br>*$datos[1]* 10 Caracteres <br> *$datos[2]* 8 Cacteres <br> *$datos[3]* Númeric y 8 caracteres <br> *$datos[5]* 17 caracteres <br *$datos[8]* 3 Caracteres <br> *$datos[9]* Númerico><hr>";
							$concatenar_errores_movimientos_factura .= "<b>$linea</b>,";

							array_push($concatenar_resultado, $mensaje_resultado);

							$contador_error_insert++;
						}
					} else if ($tipo_archivo == "Factura Si Vale") {

						$concepto_archivos = "Si Vale Mexico S.A. de C.V.";

						if (is_numeric(trim($datos[0])) and strlen(trim($datos[0])) == 8 and strlen(trim($datos[4])) == 16 and is_numeric(trim($datos[4])) and strlen(trim($datos[5])) == 10 and strlen(trim($datos[6])) == 8 and is_numeric(trim($datos[16]))) {

							# Convertir la Fecha
							$buscar_fecha = explode("/", $datos[5]);
							$fecha_movimiento = "$buscar_fecha[2]-$buscar_fecha[1]-$buscar_fecha[0] $datos[6]";
							array_push($array_fechas, $fecha_movimiento);

							# cuenta

							$cuenta = trim($datos[0]);

							# Tarjeta

							$tarjeta = trim($datos[4]);

							# Titular

							$porciones_titular = explode("|", BuscarMonederoElectronico($tarjeta));
							$titular = trim($porciones_titular[3]);

							# Establecimiento

							$establecimiento = trim($datos[19]);

							# RFC

							$rfc = trim($datos[17]);

							# LITROS

							$monto_litros = trim($datos[15]);
							$total_litros = floatval($monto_litros);
							$litros = trim(Dinero($total_litros));

							# Monto Total

							$gran_total = trim(floatval(Dinero($datos[9])));

							# Precio Unitario

							$precio_unitario = floatval($gran_total) / intval($litros);


							$query_facturas_si_vale = "SELECT * FROM orden_logistica_combustible where fecha_movimiento = '$fecha_movimiento' AND cuenta = '$cuenta' AND rfc = '$rfc' AND gran_total = '$gran_total' AND litros = '$litros' AND precio_unitario = '$precio_unitario' AND tarjeta = '$tarjeta'";
							$result_facturas_si_vale = mysql_query($query_facturas_si_vale);

							if (mysql_num_rows($result_facturas_si_vale) >= 1) {

								array_push($concatenar_resultado, "Duplicado<br>");
								$contador_duplicados++;
							} else {

								$query_insert_facturas_broxel = "INSERT INTO orden_logistica_combustible (tipo, concepto, fecha_movimiento, cuenta, titular, tarjeta, establecimiento, rfc, litros, gran_total, precio_unitario, idorden_logistica_archivos_casetas_combustible, idorden_logistica, estatus, referencia, columna_b, columna_c, usuario_creador, visible, fecha_creacion, fecha_guardado) VALUES ('$tipo_archivo', 'Si Vale', '$fecha_movimiento', '$cuenta', '$titular', '$tarjeta', '$establecimiento', '$rfc', '$litros', '$gran_total', '$precio_unitario', '$idorden_logistica_archivos_casetas_combustible', '', 'Pendiente', '$referencia', '', '', '$usuario_creador', '$visible', '$fecha_creacion', '$fecha_guardado')";
								$result_insert_facturas_broxel = mysql_query($query_insert_facturas_broxel);

								if ($result_insert_facturas_broxel == 1) {

									$contador_insertados++;

									array_push($concatenar_resultado, "1");
								} else {

									$mensaje_resultado = "Error al insertar el movimiento <b>($linea)</b> tarjeta: <b>$tarjeta</b>, Establecimiento: <b>$establecimiento</b> monto de <b>$datos[12]</b><br><hr>";
									$concatenar_errores_movimientos_factura .= "<b>$linea</b>,";

									array_push($concatenar_resultado, $mensaje_resultado);

									$contador_error_insert++;
								}
							}
						} else {

							$mensaje_resultado = "Error al insertar el movimiento <b>($linea)</b><b>Es posible que el archivo no corresponda a la opción seleccionada ($tipo_archivo)</b><br><hr>";
							$concatenar_errores_movimientos_factura .= "<b>$linea</b>,";

							array_push($concatenar_resultado, $mensaje_resultado);

							$contador_error_insert++;
						}
					}

					break;
				}
			}
		}

		fclose($gestor);
	}

	$eliminar_duplicados = Tratar_Array($array_fechas);

	asort($eliminar_duplicados);

	$primer_fecha = current($eliminar_duplicados);

	$segunda_fecha = end($eliminar_duplicados);

	$primer_fecha = ($primer_fecha == "") ? "0001-01-01" : $primer_fecha;
	$segunda_fecha = ($segunda_fecha == "") ? "0001-01-01" : $segunda_fecha;

	$total_registros = $fila - 1;
	$total_faltantes = $total_registros - $contador_insertados;

	$mensaje1 = "Total de Registros: <b>$total_registros</b><br>";
	$mensaje2 = "Movimientos Duplicados: <b>$contador_duplicados</b><br>";
	$mensaje3 = "Movimientos Insertados: <b>$contador_insertados</b> de <b>$total_registros</b><br>";
	$mensaje4 = "Movimientos Restantes: <b>$total_faltantes</b><br>";
	$mensaje5 = "Movimientos Actualizados: <b>$contador_actualizados</b><br><hr>";

	if ($total_registros == $contador_insertados || $total_registros == $contador_duplicados || $contador_duplicados + $contador_insertados == $total_registros) {

		$comentarios_factura = "OK";
	} else {

		$comentarios_factura = "Error al insertar el movimiento:<br>" . substr($concatenar_errores_movimientos_factura, 0, -1);
		$comentarios_factura = trim($comentarios_factura);
	}


	$query_update_factura = "UPDATE orden_logistica_archivos_casetas_combustible SET fecha_inicio = '$primer_fecha', fecha_fin = '$segunda_fecha', total_movimientos = '$total_registros', movimientos_insertados = '$contador_insertados', movimientos_duplicados = '$contador_duplicados', movimientos_actualizados = '$contador_actualizados', movimientos_restantes = '$total_faltantes', comentarios = '$comentarios_factura', concepto = '$concepto_archivos' WHERE idorden_logistica_archivos_casetas_combustible = '$idorden_logistica_archivos_casetas_combustible' ";
	$result_update = mysql_query($query_update_factura);

	if (is_numeric(TratarNumeroText($concatenar_resultado))) {

		$resultado_procesar_archivo = "1||$mensaje1 $mensaje2 $mensaje3 $mensaje4 $mensaje5";
	} else {

		if (TratarNumeroText(Tratar_Array($concatenar_resultado)) == "Duplicado<br>") {

			$resultado_procesar_archivo = "0|SI|$mensaje1 $mensaje2 $mensaje3 $mensaje4 $mensaje5 ";
		} else {

			$resultado_procesar_archivo = "0|SI|$mensaje1 $mensaje2 $mensaje3 $mensaje4 $mensaje5 " . TratarNumeroText(Tratar_Array($concatenar_resultado));
		}
	}

	return trim($resultado_procesar_archivo);
}

#------------------------------------------- Error Archivo Error --------------------------------------------------------------------------------

function ErrorFuncionFallo($tipo_archivo, $fecha_creacion, $visible, $estatus_evidencia, $idorden_logistica_archivos_casetas_combustible)
{

	$fila = 1;
	$linea = 0;

	$contador_insertados = 0;
	$contador_duplicados = 0;
	$contador_error_insert = 0;
	$contador_actualizados = 0;
	$concatenar_errores_movimientos_factura = "";

	$concatenar_resultado = array();
	$array_fechas = array();

	$verificar_es_numero = "";

	if (($gestor = fopen($estatus_evidencia, "r")) !== FALSE) {

		while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {

			$numero = count($datos);

			$linea++;

			if ($linea > 1) {

				$fila++;

				for ($c = 0; $c < $numero; $c++) {

					$fecha_guardado = date("Y-m-d H:i:s");

					$buscar_primer_carcter = "/";
					$posicion1 = strpos($datos[$c], $buscar_primer_carcter);

					if ($posicion1 === false) {

						$buscar_segundo_carcter = "-";
						$posicion2 = strpos($datos[$c], $buscar_segundo_carcter);

						if ($posicion1 === false) {
						} else {

							$buscar_fecha = explode("-", $datos[$c]);

							foreach ($buscar_fecha as $key_numeric => $valuenumeric) {

								$verificar_es_numero .= (is_numeric($valuenumeric)) ? 1 : "a";
							}


							if (is_numeric($verificar_es_numero)) {

								$fecha_movimiento = "$buscar_fecha[0]-$buscar_fecha[1]-$buscar_fecha[2]";

								array_push($array_fechas, $fecha_movimiento);
								break;
							}
						}
					} else {

						$buscar_fecha = explode("/", $datos[$c]);

						if ($buscar_fecha[2] > 2000) {

							$fecha_movimiento = "$buscar_fecha[2]-$buscar_fecha[1]-$buscar_fecha[0]";
						} else {
							$fecha_movimiento = "$buscar_fecha[0]-$buscar_fecha[1]-$buscar_fecha[2]";
						}

						array_push($array_fechas, $fecha_movimiento);

						break;
					}
				}
			}
		}

		fclose($gestor);
	}


	$eliminar_duplicados = Tratar_Array($array_fechas);

	asort($eliminar_duplicados);

	$primer_fecha = current($eliminar_duplicados);

	$segunda_fecha = end($eliminar_duplicados);

	$primer_fecha = ($primer_fecha == "") ? "0001-01-01" : $primer_fecha;
	$segunda_fecha = ($segunda_fecha == "") ? "0001-01-01" : $segunda_fecha;

	$total_registros = $fila - 1;
	$total_faltantes = $total_registros - $contador_insertados;


	$query_archivo_invalido = "UPDATE orden_logistica_archivos_casetas_combustible SET fecha_inicio = '$primer_fecha', fecha_fin = '$segunda_fecha', total_movimientos = '$total_registros', movimientos_insertados = '$contador_insertados', movimientos_duplicados = '$contador_duplicados', movimientos_actualizados = '$contador_actualizados', movimientos_restantes = '$total_faltantes', comentarios = 'No se puede tratar el archivo debido a que la opción <b>$tipo_archivo</b> es incorrecta', concepto = 'Desconocido' WHERE idorden_logistica_archivos_casetas_combustible = '$idorden_logistica_archivos_casetas_combustible'";
	$result_archivos_invalido = mysql_query($query_archivo_invalido);

	return ($result_archivos_invalido == 1) ? "0|SI|- No se puede tratar el archivo debido a que la opción <b>$tipo_archivo</b> es incorrecta" : "0|SI| - No se puede tratar el archivo debido a que la opción <b>$tipo_archivo</b> es incorrecta <br> Error al actualizar bítacora";
}


function ProcesarPlantillaProveedores($tipo_archivo, $fecha_creacion, $visible, $estatus_evidencia, $idorden_logistica_archivos_casetas_combustible, $usuario_creador)
{

	$fila = 1;
	$linea = 0;

	$contador_insertados = 0;
	$contador_duplicados = 0;
	$contador_error_insert = 0;
	$contador_actualizados = 0;
	$concatenar_errores_movimientos_factura = "";

	$concatenar_resultado = array();
	$array_fechas = array();

	$verificar_es_numero = "";


	if (($gestor = fopen($estatus_evidencia, "r")) !== FALSE) {

		while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {

			$numero = count($datos);

			$linea++;

			if ($linea >= 10) {

				$fila++;

				for ($c = 0; $c < $numero; $c++) {

					$fecha_guardado = date("Y-m-d H:i:s");
					#

					if (strlen(trim($datos[0])) == 1 and is_numeric(trim($datos[0])) and trim($datos[0]) != "") {

						$archivo_idprovedores_compuesto = trim($datos[1]);
						$archivo_nombre = trim($datos[2]);
						$archivo_apellidos = trim($datos[3]);
						$archivo_alias = trim($datos[4]);
						$archivo_rfc = trim($datos[5]);
						$archivo_telefono = trim($datos[6]);
						$archivo_calle = trim($datos[7]);
						$archivo_colonia = trim($datos[8]);
						$archivo_municipio = trim($datos[9]);
						$archivo_estado = trim($datos[10]);
						$archivo_cp = trim($datos[11]);

						$verificar_updates = UpdateProveedor($archivo_idprovedores_compuesto, $nomeclatura, $archivo_nombre, $archivo_apellidos, $sexo, $archivo_rfc, $archivo_alias, $trato, $telefono_otro, $archivo_telefono, $email, $referencia_nombre, $referencia_celular, $referencia_fijo, $referencia_nombre2, $referencia_celular2, $referencia_fijo2, $referencia_nombre3, $referencia_celular3, $referencia_fijo3, $tipo_registro, $recomendado, $entrada, $asesor, $tipo_cliente, $tipo_credito, $linea_credito, $archivo_cp, $archivo_estado, $archivo_municipio, $archivo_colonia, $archivo_calle, $foto_perfil, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado,  $metodo_pago, $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $archivo_ine, $archivo_comprobante);

						array_push($concatenar_resultado, $verificar_updates);

						if ($verificar_updates == 1) {
							$contador_insertados++;
						}
					} else {

						$contador_error_insert++;
						array_push($concatenar_resultado, "$archivo_idprovedores_compuesto, ");
					}

					break;
				}
			}
		}

		fclose($gestor);
	}


	$eliminar_duplicados = Tratar_Array($array_fechas);

	asort($eliminar_duplicados);

	$primer_fecha = date('Y-m-d');

	$segunda_fecha = date('Y-m-d');

	$primer_fecha = ($primer_fecha == "") ? "0001-01-01" : $primer_fecha;
	$segunda_fecha = ($segunda_fecha == "") ? "0001-01-01" : $segunda_fecha;

	$total_registros = $fila - 1;
	$total_faltantes = $total_registros - $contador_insertados;

	$resultado_insert = (is_numeric(TratarNumeroText($concatenar_resultado))) ? "1||" : TratarNumeroText($concatenar_resultado);

	$comentarios = (is_numeric(TratarNumeroText($concatenar_resultado))) ? "Ok" : TratarNumeroText($concatenar_resultado);

	$query_archivo_invalido = "UPDATE orden_logistica_archivos_casetas_combustible SET fecha_inicio = '$primer_fecha', fecha_fin = '$segunda_fecha', total_movimientos = '$total_registros', movimientos_insertados = '$contador_insertados', movimientos_duplicados = '$contador_duplicados', movimientos_actualizados = '$contador_actualizados', movimientos_restantes = '$total_faltantes', comentarios = '$comentarios', concepto = 'Actualización de Proveedores' WHERE idorden_logistica_archivos_casetas_combustible = '$idorden_logistica_archivos_casetas_combustible'";
	$result_archivos_invalido = mysql_query($query_archivo_invalido);

	return $resultado_insert;
}
