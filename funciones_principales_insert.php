<?php

date_default_timezone_set('America/Mexico_City');

#------------------------------------------- Bitacora logistica bitacora --------------------------------------------------------------------------------

function LogisticaInsertBitacora($descripcion, $tipo, $idorden_logistica, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, $valor, $columna_c, $columna_d, $visible)
{

	$descripcion = trim($descripcion);
	$tipo = trim($tipo);
	$idorden_logistica = trim($idorden_logistica);
	$comentarios = trim($comentarios);
	$coordenadas = trim($coordenadas);
	$usuario_creador = trim($usuario_creador);
	$fecha_creacion = trim($fecha_creacion);
	$fecha_guardado = trim($fecha_guardado);
	$valor = trim($valor);
	$columna_c = trim($columna_c);
	$columna_d = trim($columna_d);
	$visible = trim($visible);

	$query_duplicado_bitacora_logistica = "SELECT * FROM orden_logistica_bitacora WHERE idorden_logistica = '$idorden_logistica' AND $tipo = '$tipo' AND $fecha_creacion = '$fecha_creacion' AND visible = 'SI'";
	$result_duplicado_bitacora_logistica = mysql_query($query_duplicado_bitacora_logistica);

	if (mysql_num_rows($result_duplicado_bitacora_logistica) >= 1) {

		$result_logistica_insert_bitacora = 1;
	} else {

		$query_insert_bitacora_logistica = "INSERT INTO orden_logistica_bitacora (descripcion, tipo, idorden_logistica, comentarios, coordenadas, usuario_creador, fecha_creacion, fecha_guardado, valor, columna_c, columna_d, visible) VALUES ('$descripcion', '$tipo', '$idorden_logistica', '$comentarios', '$coordenadas', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$valor', '$columna_c', '$columna_d', '$visible')";
		$result_logistica_insert_bitacora = mysql_query($query_insert_bitacora_logistica);
	}


	return ($result_logistica_insert_bitacora == 1) ? 1 : "- Error al insertar en bitácora Logística <b>$tipo</b><br>";
}

#-------------------------------------------  --------------------------------------------------------------------------------

function BalanceInsertBitacora($descripcion, $tipo, $idorden_logistica, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, $valor, $columna_c, $columna_d, $visible)
{

	$descripcion = trim($descripcion);
	$tipo = trim($tipo);
	$idorden_logistica = trim($idorden_logistica);
	$comentarios = trim($comentarios);
	$coordenadas = trim($coordenadas);
	$usuario_creador = trim($usuario_creador);
	$fecha_creacion = trim($fecha_creacion);
	$fecha_guardado = trim($fecha_guardado);
	$valor = trim($valor);
	$columna_c = (trim($columna_c) == "") ? NULL : trim($columna_c);
	$columna_d = (trim($columna_d) == "") ? NULL : trim($columna_d);
	$visible = trim($visible);

	$query_insert_bitacora_balance = "INSERT INTO balance_gastos_operacion_bitacora (descripcion, tipo, idorden_logistica, comentarios, coordenadas, usuario_creador, fecha_creacion, fecha_guardado, valor, columna_c, columna_d, visible) VALUES ('$descripcion', '$tipo', '$idorden_logistica', '$comentarios', '$coordenadas', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$valor', '$columna_c', '$columna_d', '$visible')";
	$result_logistica_insert_balance = mysql_query($query_insert_bitacora_balance);

	return ($result_logistica_insert_balance == 1) ? "1" : "- Error al insertar en bitácora Balance <b>$tipo</b><br>";
}

#------------------------------------------- Bitacora Monedero Bitacora monedero electronico bitacora --------------------------------------------------------------------------------

function monederoInsertaBitacora($id_monedero_electronico, $contenido, $movimiento, $evidencia, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible)
{

	$id_monedero_electronico = trim($id_monedero_electronico);
	$contenido = trim($contenido);
	$movimiento = trim($movimiento);
	$evidencia = trim($evidencia);
	$usuario_creador = trim($usuario_creador);
	$fecha_creacion = trim($fecha_creacion);
	$fecha_guardado = trim($fecha_guardado);
	$visible = trim($visible);

	$sql = "INSERT INTO catalogo_monedero_electronico_bitacora (id_monedero_electronico, contenido, movimiento, evidencia, comentarios, usuario_creador, fecha_creacion, fecha_guardado, visible)
	VALUES ('$id_monedero_electronico', '$contenido', '$movimiento', '$evidencia', '$comentarios', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$visible')";
	$result = mysql_query($sql);

	return ($result == 1) ? "1" : "- Error al insertar el movimiento <b>$movimiento</b><br>";
}

#-------------------------------------------  --------------------------------------------------------------------------------

function UtilitariasInsertarBitacora($descripcion, $tipo, $vin, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $valor, $columna_a, $columna_b, $columna_c, $visible)
{

	$descripcion = trim($descripcion);
	$tipo = trim($tipo);
	$vin = trim($vin);
	$comentarios = trim($comentarios);
	$usuario_creador = trim($usuario_creador);
	$fecha_creacion = trim($fecha_creacion);
	$fecha_guardado = trim($fecha_guardado);
	$valor = trim($valor);
	$columna_a = trim($columna_a);
	$columna_b = trim($columna_b);
	$columna_c = trim($columna_c);
	$visible = trim($visible);

	$query_insert_bitacora_utilitarias = "INSERT INTO catalogo_unidades_utilitarios_bitacora (descripcion, tipo, vin, comentarios, usuario_creador, fecha_creacion, fecha_guardado, valor, columna_a, columna_b, columna_c, visible) VALUES ('$descripcion', '$tipo', '$vin', '$comentarios', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$valor', '$columna_a', '$columna_b', '$columna_c', '$visible')";
	$result_insert_utilitarias = mysql_query($query_insert_bitacora_utilitarias);

	return ($result_insert_utilitarias == 1) ? 1 : "Error al Insertar la bitacora del vin <b>$vin</b> pero no afecta la operacion anterior<br>";
}

#------------------------------------------- INSERTAR MULTIPLES ARCHIVOS --------------------------------------------------------------------------------

function CargarImagenEvidenciaArray($ruta_archivo, $nomenclatura_archivo_name, $name_input_file, $index)
{

	$ruta_archivo = trim($ruta_archivo);
	$nomenclatura_archivo_name = trim($nomenclatura_archivo_name);
	$name_input_file = trim($name_input_file);
	$index = trim($index);

	$target_path = $ruta_archivo . $nomenclatura_archivo_name . "_" . basename($_FILES[$name_input_file]['name'][$index]);

	if (is_dir($ruta_archivo)) {

		if (move_uploaded_file($_FILES[$name_input_file]['tmp_name'][$index], $target_path)) {

			$estatus_evidencia = $target_path;
		} else {
			$estatus_evidencia = "- Ocurrio un error al mover la Evidencia <br>";
		}
	} else {
		$estatus_evidencia = "La carpeta $ruta_archivo no existe";
	}

	return $estatus_evidencia;
}

#------------------------------------------- INSERTAR ARCHIVOS INDIVIDUALMENTE --------------------------------------------------------------------------------

function CargarImagenEvidenciaIndividual($ruta_archivo, $name_input_file, $target_path)
{

	if (is_dir($ruta_archivo)) {

		if (move_uploaded_file($_FILES[$name_input_file]['tmp_name'], $target_path)) {

			$estatus_evidencia = $target_path;
		} else {
			$estatus_evidencia = "- Ocurrio un error al mover la Evidencia <br>";
		}
	} else {
		$estatus_evidencia = "La carpeta $ruta_archivo no existe";
	}

	return $estatus_evidencia;
}

#------------------------------------------- iNSERTAR EN EMPLEADOS WALLET --------------------------------------------------------------------------------

function WalletInsert($fecha_movimiento, $tipo_movimiento, $monto, $tipo_moneda, $tipo_cambio, $gran_total, $monto_real, $id, $tipo_id, $tabla, $tesoreria, $idlogistica, $estatus, $emisor, $tipo_emisor, $receptor, $tipo_receptor, $referencia, $token, $visible, $usuario_creador, $empleado_creador, $fecha_creacion, $fecha_guardado, $referencia_seguimiento, $metodo_pago, $tipo)
{

	$query_duplicar_wallet = "SELECT * FROM empleados_wallet WHERE idlogistica = '$idlogistica' and tipo = '$tipo' and fecha_creacion = '$fecha_creacion' and emisor = '$emisor' and tipo_emisor = '$tipo_emisor' and tipo_receptor = '$tipo_receptor'";
	$result_duplicar_wallet = mysql_query($query_duplicar_wallet);

	if (mysql_num_rows($result_duplicar_wallet) == 0) {

		$query_insert_wallet = "INSERT INTO empleados_wallet (fecha_movimiento, tipo_movimiento, monto, tipo_moneda, tipo_cambio, gran_total, monto_real, id, tipo_id, tabla, tesoreria, idlogistica, estatus, emisor, tipo_emisor, receptor, tipo_receptor, referencia, token, visible, usuario_creador, empleado_creador, fecha_creacion, fecha_guardado, referencia_seguimiento, metodo_pago, tipo) VALUES ('$fecha_movimiento', '$tipo_movimiento', '$monto', '$tipo_moneda', '$tipo_cambio', '$gran_total', '$monto_real', '$id', '$tipo_id', '$tabla', '$tesoreria', '$idlogistica', '$estatus', '$emisor', '$tipo_emisor', '$receptor', '$tipo_receptor', '$referencia', '$token', '$visible', '$usuario_creador', '$empleado_creador', '$fecha_creacion', '$fecha_guardado', '$referencia_seguimiento', '$metodo_pago', '$tipo')";

		$result_insert_wallet = mysql_query($query_insert_wallet);
	} else {

		$result_insert_wallet = 0;
	}

	return $result = ($result_insert_wallet == 1) ? "1" : "- Ocurrio un error al guardar el $tipo <br>";
}

#------------------------------------------- iNSERTAR BITACORA WALLET WALLET BITACORA --------------------------------------------------------------------------------

function WalletInsertBitacora($idempleados_wallet, $referencia, $tipo, $descripcion, $valor, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $id_id, $tipo_type, $columna_a, $columna_b, $columna_c, $columna_d, $columna_e)
{

	$idempleados_wallet = trim($idempleados_wallet);
	$referencia = trim($referencia);
	$tipo = trim($tipo);
	$descripcion = trim($descripcion);
	$valor = trim($valor);
	$visible = trim($visible);
	$usuario_creador = trim($usuario_creador);
	$id_id = trim($id_id);
	$tipo_type = trim($tipo_type);
	$columna_a = trim($columna_a);
	$columna_b = trim($columna_b);
	$columna_c = (trim($columna_c) == "") ? NULL : trim($columna_c);
	$columna_d = (trim($columna_d) == "") ? NULL : trim($columna_d);
	$columna_e = (trim($columna_e) == "") ? NULL : trim($columna_e);

	$query_repetir_wallet = "SELECT * FROM wallet_bitacora WHERE visible = 'SI' and tipo = '$tipo' and fecha_creacion = '$fecha_creacion' and columna_b = '$columna_b' and descripcion = '$descripcion'";
	$result_repetir_wallet = mysql_query($query_repetir_wallet);

	if (mysql_num_rows($result_repetir_wallet) >= 1) {

		$respuesta_bitacora_wallet = 1;
	} else {

		$insert_bitacora_wallet = "INSERT INTO wallet_bitacora (idempleados_wallet, referencia, tipo, descripcion, valor, visible, usuario_creador, fecha_creacion, fecha_guardado, id_id, tipo_type, columna_a, columna_b, columna_c, columna_d, columna_e) VALUES ('$idempleados_wallet', '$referencia', '$tipo', '$descripcion', '$valor', '$visible', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$id_id', '$tipo_type', '$columna_a', '$columna_b', '$columna_c', '$columna_d', '$columna_e')";
		$result_bitacora_wallet = mysql_query($insert_bitacora_wallet);

		$respuesta_bitacora_wallet = ($result_bitacora_wallet == 1) ? "1" : "- Error al insertar el $columna_b en la bitácora WALLET <br>";
	}


	return $respuesta_bitacora_wallet;
}

#------------------------------------------- GENERADOR DE TOKEN --------------------------------------------------------------------------------

function generate_token($ok)
{

	$fecha_wallet = date("YmdHis");
	$inicio_wallet = rand(1, 1000000);
	$fin_wallet = rand(10000000, 999999999999);
	$final_rnd_wallet = rand($inicio_wallet, $fin_wallet);
	$password_completa_wallet = $final_rnd_wallet . $fecha_wallet;
	$token_new = substr($password_completa_wallet, -15);

	return $token_new;
}

#-------------------------------------------  Eliminar Repetidos y vacios vonvertir a mayuscula y eliminar acentos  --------------------------------------------------------------------------------

function DeleteRepeats($array_entrada_repetidos)
{

	$array_trim_mayus = array();
	$exit_array = array();

	foreach ($array_entrada_repetidos as $indice => $valor_array) {

		if ($valor_array != "") {
			array_push($array_trim_mayus, trim(strtoupper($valor_array)));
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

#------------------------------------------- Eliminar Repetidos y vacios tal cual esta escrito tratar array tratar--------------------------------------------------------------------------------

function Tratar_Array($name_array)
{

	$array_tratado = array();
	$array_final = array();

	foreach ($name_array as $key_array_tratado => $value_array_tratado) {

		$value_array_tratado = trim($value_array_tratado);

		if ($value_array_tratado != "") {

			array_push($array_tratado, $value_array_tratado);
		}
	}

	$eliminar_iguales = array_unique($array_tratado);

	foreach ($eliminar_iguales as $key_nuevo => $valor_nuevo_array) {

		if ($valor_nuevo_array != "") {
			array_push($array_final, $valor_nuevo_array);
		}
	}

	return $array_final;
}

#------------------------------------------- Insertar Auxiliares Balance de Gastos de Operacion --------------------------------------------------------------------------------

function AuxiliaresBalanceInsert($nombre, $idauxiliar_principales, $idlogistica, $fecha_movimiento, $nomenclatura, $direccion, $idfoliogo, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $col1, $col2, $col3)
{

	$nombre = trim($nombre);
	$idauxiliar_principales = trim($idauxiliar_principales);
	$idlogistica = trim($idlogistica);
	$fecha_movimiento = trim($fecha_movimiento);
	$nomenclatura = trim($nomenclatura);
	$direccion = trim($direccion);
	$idfoliogo = trim($idfoliogo);
	$visible = trim($visible);
	$usuario_creador = trim($usuario_creador);
	$fecha_creacion = trim($fecha_creacion);
	$fecha_guardado = trim($fecha_guardado);
	$col1 = trim($col1);
	$col2 = trim($col2);
	$col3 = trim($col3);

	$query_insert_auxiliares_balance = "INSERT INTO balance_gastos_auxiliares (nombre, idauxiliar_principales, idlogistica, fecha_movimiento, nomenclatura, direccion, idfoliogo, visible, usuario_creador, fecha_creacion, fecha_guardado, col1, col2, col3) VALUES ('$nombre','$idauxiliar_principales','$idlogistica','$fecha_movimiento','$nomenclatura','$direccion','$idfoliogo','$visible','$usuario_creador','$fecha_creacion','$fecha_guardado','$col1','$col2','$col3')";
	$result_insert_auxiliares_balance = mysql_query($query_insert_auxiliares_balance);

	return ($result_insert_auxiliares_balance == 1) ? 1 : "- Error al insertar el auxiliar <b>$nombre</b>";
}

#------------------------------------------- Insertar Referencia de WALLET --------------------------------------------------------------------------------

function ReferenciaWalletInsert($referencia_seguimiento, $monto, $idempleados_wallet, $visible, $usuario_creador, $empleado_creador, $fecha_creacion, $fecha_guardado)
{

	$referencia_seguimiento = trim($referencia_seguimiento);
	$monto = trim($monto);
	$idempleados_wallet = trim($idempleados_wallet);
	$visible = trim($visible);
	$usuario_creador = trim($usuario_creador);
	$empleado_creador = trim($empleado_creador);
	$fecha_creacion = trim($fecha_creacion);
	$fecha_guardado = trim($fecha_guardado);

	$ver_referencia_duplicada = ConsultarReferenciaSeguimiento($referencia_seguimiento);

	if ($ver_referencia_duplicada == "Pendiente") {

		$query_insert_referencia_wallet = "INSERT INTO empleados_wallet_referencia_bitacora (referencia_seguimiento, monto, idempleados_wallet, visible, usuario_creador, empleado_creador, fecha_creacion, fecha_guardado) VALUES ('$referencia_seguimiento', '$monto', '$idempleados_wallet', '$visible', '$usuario_creador', '$empleado_creador', '$fecha_creacion', '$fecha_guardado')";
		$result_insert_referencia_wallet = mysql_query($query_insert_referencia_wallet);

		$mensaje_referencia = ($result_insert_referencia_wallet == 1) ? 1 : "-Error al Insertar la referencia: </b>$referencia_seguimiento</b> <br>";
	} else {

		$mensaje_referencia = "- La referencia <b>$referencia_seguimiento</b> ya se encuentra Aplicada <br>";
	}


	return $mensaje_referencia;
}

#------------------------------------------- Tratar Resultado Array --------------------------------------------------------------------------------

function TratarNumeroText($pasar_array)
{

	foreach ($pasar_array as $key_pasar => $value_pasar) {

		$valor_array .= (is_numeric($value_pasar)) ? "" : $value_pasar;
	}

	return $valor_array = (trim($valor_array) == "") ? 1 : $valor_array;
}

#------------------------------------------- Solo numero y punto solo punto y numero  --------------------------------------------------------------------------------

function Dinero($monto_total)
{

	$monto_total = trim($monto_total);

	$solonumero = "";
	$string_array = str_split($monto_total);
	unset($solonumero);

	foreach ($string_array as $key_dinero => $value_dinero) {

		if ($value_dinero == "0" || $value_dinero == "1" || $value_dinero == "2" || $value_dinero == "3" || $value_dinero == "4" || $value_dinero == "5" || $value_dinero == "6" || $value_dinero == "7" || $value_dinero == "8" || $value_dinero == "9" || $value_dinero == ".") {

			$solonumero .= $value_dinero;
		}
	}

	return $solonumero;
}

#------------------------------------------- Agregar Proveedor Agregar --------------------------------------------------------------------------------

function AgregarProveedor($idprovedores_compuesto, $nomeclatura, $nombre, $apellidos, $sexo, $rfc, $alias, $trato, $telefono_otro, $telefono_celular, $email, $referencia_nombre, $referencia_celular, $referencia_fijo, $referencia_nombre2, $referencia_celular2, $referencia_fijo2, $referencia_nombre3, $referencia_celular3, $referencia_fijo3, $tipo_registro, $recomendado, $entrada, $asesor, $tipo_cliente, $tipo_credito, $linea_credito, $codigo_postal, $estado, $delmuni, $colonia, $calle, $foto_perfil, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $metodo_pago, $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $archivo_ine, $archivo_comprobante)
{

	$query_repetido = "SELECT * FROM proveedores WHERE nombre = '$nombre' AND apellidos = '$apellidos' AND fecha_creacion = '$fecha_creacion'";
	$result_repetido = mysql_query($query_repetido);

	if (mysql_num_rows($result_repetido) >= 1) {

		while ($row_repetido = mysql_fetch_array($result_repetido)) {

			$mensaje_proveedor = $row_repetido[idproveedores] . "|" . $row_repetido[nombre] . "|" . $row_repetido[apellidos] . "|" . $row_repetido[alias] . "|" . $row_repetido[telefono_celular] . "|" . $row_repetido[telefono_otro] . "|" . $row_repetido[estado] . "|" . $row_repetido[delmuni] . "|" . $row_repetido[colonia] . "|" . $row_repetido[calle] . "|" . $row_repetido[codigo_postal] . "|Proveedor Temporal|$row_repetido[idprovedores_compuesto]|$row_repetido[rfc]";
		}
		#
	} else {

		if (trim($nombre) != "") {

			$query_ya_existe_nombre = "SELECT * FROM proveedores WHERE visible = 'SI' AND trim(nombre) = '$nombre'";
			$result_ya_exixte_nombre = mysql_query($query_ya_existe_nombre);
		}

		if (trim($nombre) != "" and trim($apellidos) != "") {

			$query_ya_existe_nombre_apellidos = "SELECT * FROM proveedores WHERE visible = 'SI' AND trim(nombre) = '$nombre' AND trim(apellidos) = '$apellidos'";
			$result_ya_exixte_nombre_apellidos = mysql_query($query_ya_existe_nombre_apellidos);

			$query_ya_existe_concatenado = "SELECT * FROM proveedores WHERE visible = 'SI' AND trim(nombre) = '$nombre $apellidos'";
			$result_ya_existe_concatenado = mysql_query($query_ya_existe_concatenado);
		}

		if (trim($rfc) != "") {

			$query_ya_existe_rfc = "SELECT * FROM proveedores WHERE visible = 'SI' AND trim(rfc) = '$rfc'";
			$result_ya_existe_rfc = mysql_query($query_ya_existe_rfc);
		}

		$total_querys = mysql_num_rows($result_ya_exixte_nombre) + mysql_num_rows($result_ya_exixte_nombre_apellidos) + mysql_num_rows($result_ya_existe_concatenado) + mysql_num_rows($result_ya_existe_rfc);

		if ($total_querys == 0) {
			//Nomenclatura nuevo proveedor
			$nombre_completo = $nombre . " " . $apellidos;
			$nom = eliminar_tildes($nombre_completo);

			$words = explode(" ", $nom);

			$nomeclatura = "";
			foreach ($words as $w) {
				$nomeclatura .= $w[0];
			}

			$query_insert_proveedor = "INSERT INTO proveedores (idprovedores_compuesto, nomeclatura, nombre, apellidos, sexo, rfc, alias, trato, telefono_otro, telefono_celular, email, referencia_nombre, referencia_celular, referencia_fijo, referencia_nombre2, referencia_celular2, referencia_fijo2, referencia_nombre3, referencia_celular3, referencia_fijo3, tipo_registro, recomendado, entrada, asesor, tipo_cliente, tipo_credito, linea_credito, codigo_postal, estado, delmuni, colonia, calle, foto_perfil, visible, usuario_creador, fecha_creacion, fecha_guardado, metodo_pago, col1, col2, col3, col4, col5, col6, col7, col8, col9, col10, archivo_ine, archivo_comprobante) VALUES ('$idprovedores_compuesto', '$nomeclatura', '$nombre', '$apellidos', '$sexo', '$rfc', '$alias', '$trato', '$telefono_otro', '$telefono_celular', '$email', '$referencia_nombre', '$referencia_celular', '$referencia_fijo', '$referencia_nombre2', '$referencia_celular2', '$referencia_fijo2', '$referencia_nombre3', '$referencia_celular3', '$referencia_fijo3', '$tipo_registro', '$recomendado', '$entrada', '$asesor', '$tipo_cliente', '$tipo_credito', '$linea_credito', '$codigo_postal', '$estado', '$delmuni', '$colonia', '$calle', '$foto_perfil', '$visible', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$metodo_pago', '$col1', '$col2', '$col3', '$col4', '$col5', '$col6', '$col7', '$col8', '$col9', '$col10', '$archivo_ine', '$archivo_comprobante')";
			$result_insert_proveedor = mysql_query($query_insert_proveedor);

			if ($result_insert_proveedor == 1) {

				$rescatar_id = mysql_query("SELECT @@identity AS id");
				if ($row = mysql_fetch_row($rescatar_id)) {
					$id = trim($row[0]);
				}

				date_default_timezone_set('America/Mexico_City');
				$fecha_creado_idcompud = date("dmY");
				$idcompuesto = $id . "-" . $nomeclatura . "-" . $fecha_creado_idcompud;

				$query_update_proveedor = "UPDATE proveedores SET idprovedores_compuesto = '$idcompuesto' WHERE idproveedores = '$id'";
				$result_update_proveedor  = mysql_query($query_update_proveedor);

				$mensaje_proveedor = ($result_update_proveedor == 1) ?  $id . "|" . $nombre . "|" . $apellidos . "|" . $alias . "|" . $telefono_celular . "|" . $telefono_otro . "|" . $estado . "|" . $municipio_cliente . "|" . $colonia . "|" . $calle . "|" . $codigo_postal . "|Proveedor Temporal|$idcompuesto|$rfc" : "Error al Actualizar Proveedor";
			} else {

				$mensaje_proveedor = "- Error al Agregar Proveedor <br>";
			}
			#
		} else {

			$mensaje_proveedor = "- Ya Existe<br>";
			#
		}
	}

	return $mensaje_proveedor;
}

#------------------------------------------- Agregar proveedor temporal agregar --------------------------------------------------------------------------------

function AgregarProveedorTemporal($idprovedores_compuesto, $nomeclatura, $nombre, $apellidos, $sexo, $rfc, $alias, $trato, $telefono_otro, $telefono_celular, $email, $referencia_nombre, $referencia_celular, $referencia_fijo, $referencia_nombre2, $referencia_celular2, $referencia_fijo2, $referencia_nombre3, $referencia_celular3, $referencia_fijo3, $tipo_registro, $recomendado, $entrada, $asesor, $tipo_cliente, $tipo_credito, $linea_credito, $codigo_postal, $estado, $delmuni, $colonia, $calle, $foto_perfil, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $metodo_pago, $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10)
{

	$query_repetido_temporal = "SELECT * FROM orden_logistica_proveedores WHERE nombre = '$nombre' AND apellidos = '$apellidos' AND fecha_creacion = '$fecha_creacion'";
	$result_repetido_temporal = mysql_query($query_repetido_temporal);

	if (mysql_num_rows($result_repetido_temporal) >= 1) {

		while ($row_repetido_temporal = mysql_fetch_array($result_repetido_temporal)) {

			$mensaje_proveedor = $row_repetido_temporal[idorden_logistica_proveedores] . "|" . $row_repetido_temporal[nombre] . "|" . $row_repetido_temporal[apellidos] . "|" . $row_repetido_temporal[alias] . "|" . $row_repetido_temporal[telefono_celular] . "|" . $row_repetido_temporal[telefono_otro] . "|" . $row_repetido_temporal[estado] . "|" . $row_repetido_temporal[delmuni] . "|" . $row_repetido_temporal[colonia] . "|" . $row_repetido_temporal[calle] . "|" . $row_repetido_temporal[codigo_postal] . "|Proveedor Temporal|$row_repetido_temporal[idprovedores_compuesto]|$row_repetido_temporal[rfc]";
		}
		#
	} else {

		if (trim($nombre) != "") {

			$query_ya_existe_nombre = "SELECT * FROM orden_logistica_proveedores WHERE visible = 'SI' AND trim(nombre) = '$nombre'";
			$result_ya_exixte_nombre = mysql_query($query_ya_existe_nombre);
		}

		if (trim($nombre) != "" and trim($apellidos) != "") {

			$query_ya_existe_nombre_apellidos = "SELECT * FROM orden_logistica_proveedores WHERE visible = 'SI' AND trim(nombre) = '$nombre' AND trim(apellidos) = '$apellidos'";
			$result_ya_exixte_nombre_apellidos = mysql_query($query_ya_existe_nombre_apellidos);

			$query_ya_existe_concatenado = "SELECT * FROM orden_logistica_proveedores WHERE visible = 'SI' AND trim(nombre) = '$nombre $apellidos'";
			$result_ya_existe_concatenado = mysql_query($query_ya_existe_concatenado);
		}

		if (trim($rfc) != "") {

			$query_ya_existe_rfc = "SELECT * FROM orden_logistica_proveedores WHERE visible = 'SI' AND trim(rfc) = '$rfc'";
			$result_ya_existe_rfc = mysql_query($query_ya_existe_rfc);
		}

		$total_querys = mysql_num_rows($result_ya_exixte_nombre) + mysql_num_rows($result_ya_exixte_nombre_apellidos) + mysql_num_rows($result_ya_existe_concatenado) + mysql_num_rows($result_ya_existe_rfc);

		if ($total_querys == 0) {
			//Nomenclatura nuevo proveedor
			$nombre_completo = $nombre . " " . $apellidos;
			$nom = eliminar_tildes($nombre_completo);

			$words = explode(" ", $nom);

			$nomeclatura = "";
			foreach ($words as $w) {
				$nomeclatura .= $w[0];
			}

			$query_insert_proveedor = "INSERT INTO orden_logistica_proveedores (idprovedores_compuesto, nomeclatura, nombre, apellidos, sexo, rfc, alias, trato, telefono_otro, telefono_celular, email, referencia_nombre, referencia_celular, referencia_fijo, referencia_nombre2, referencia_celular2, referencia_fijo2, referencia_nombre3, referencia_celular3, referencia_fijo3, tipo_registro, recomendado, entrada, asesor, tipo_cliente, tipo_credito, linea_credito, codigo_postal, estado, delmuni, colonia, calle, foto_perfil, visible, usuario_creador, fecha_creacion, fecha_guardado, metodo_pago, col1, col2, col3, col4, col5, col6, col7, col8, col9, col10) VALUES ('$idprovedores_compuesto', '$nomeclatura', '$nombre', '$apellidos', '$sexo', '$rfc', '$alias', '$trato', '$telefono_otro', '$telefono_celular', '$email', '$referencia_nombre', '$referencia_celular', '$referencia_fijo', '$referencia_nombre2', '$referencia_celular2', '$referencia_fijo2', '$referencia_nombre3', '$referencia_celular3', '$referencia_fijo3', '$tipo_registro', '$recomendado', '$entrada', '$asesor', '$tipo_cliente', '$tipo_credito', '$linea_credito', '$codigo_postal', '$estado', '$delmuni', '$colonia', '$calle', '$foto_perfil', '$visible', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$metodo_pago', '$col1', '$col2', '$col3', '$col4', '$col5', '$col6', '$col7', '$col8', '$col9', '$col10')";
			$result_insert_proveedor_temporal = mysql_query($query_insert_proveedor);

			if ($result_insert_proveedor_temporal == 1) {

				$rescatar_id = mysql_query("SELECT @@identity AS id");
				if ($row = mysql_fetch_row($rescatar_id)) {
					$id = trim($row[0]);
				}

				date_default_timezone_set('America/Mexico_City');
				$fecha_creado_idcompud = date("dmY");
				$idcompuesto = $id . "-" . $nomeclatura . "-" . $fecha_creado_idcompud;

				$query_update_proveedor = "UPDATE orden_logistica_proveedores SET idprovedores_compuesto = '$idcompuesto' WHERE idorden_logistica_proveedores = '$id'";
				$result_update_proveedor  = mysql_query($query_update_proveedor);

				$mensaje_proveedor = ($result_update_proveedor == 1) ?  $id . "|" . $nombre . "|" . $apellidos . "|" . $alias . "|" . $telefono_celular . "|" . $telefono_otro . "|" . $estado . "|" . $municipio_cliente . "|" . $colonia . "|" . $calle . "|" . $codigo_postal . "|Proveedor Temporal|$idcompuesto|$rfc" : "Error al Actualizar Proveedor";
			} else {

				$mensaje_proveedor = "- Error al Agregar Proveedor <br>";
			}
			#
		} else {

			$mensaje_proveedor = "- Ya Existe<br>";
			#
		}
	}

	return $mensaje_proveedor;
}


#------------------------------------------- bitacora proveedor bitacora --------------------------------------------------------------------------------

function CambiosProveedor($descripcion_cambio, $usuario, $fecha, $idproveedores)
{

	$query_insert_bitacora_proveedor = "INSERT INTO proveedores_cambios (descripcion_cambio, usuario, fecha, idproveedores) VALUES ('$descripcion_cambio', '$usuario', '$fecha', '$idproveedores')";
	$result_insert_bitacora_proveedor = mysql_query($query_insert_bitacora_proveedor);

	$result_bitacora_proveedor = ($result_insert_bitacora_proveedor == 1) ? 1 : "- Error al insertar la bitácora<br>";

	return $result_bitacora_proveedor;
}


#------------------------------------------- bitacora proveedor temporal --------------------------------------------------------------------------------

function CambiosProveedorTemporal($descripcion_cambio, $usuario, $fecha, $idproveedores)
{

	$query_insert_bitacora_proveedor_temporal = "INSERT INTO orden_logistica_proveedores_bitacora (descripcion_cambio, usuario, fecha, idproveedores) VALUES ('$descripcion_cambio', '$usuario', '$fecha', '$idproveedores')";
	$result_insert_bitacora_proveedor_temporal = mysql_query($query_insert_bitacora_proveedor_temporal);

	$result_bitacora_proveedor_temporal = ($result_insert_bitacora_proveedor_temporal == 1) ? 1 : "- Error al insertar la bitácora<br>";

	return $result_bitacora_proveedor_temporal;
}

#------------------------------------------- Actualizar proveedor actualizar --------------------------------------------------------------------------------

function UpdateProveedor($idprovedores_compuesto, $nomeclatura, $nombre, $apellidos, $sexo, $rfc, $alias, $trato, $telefono_otro, $telefono_celular, $email, $referencia_nombre, $referencia_celular, $referencia_fijo, $referencia_nombre2, $referencia_celular2, $referencia_fijo2, $referencia_nombre3, $referencia_celular3, $referencia_fijo3, $tipo_registro, $recomendado, $entrada, $asesor, $tipo_cliente, $tipo_credito, $linea_credito, $codigo_postal, $estado, $delmuni, $colonia, $calle, $foto_perfil, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $metodo_pago, $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $archivo_ine, $archivo_comprobante)
{

	$mensaje_actualizacion = "";

	$query_search_proveedor = "SELECT * FROM proveedores WHERE idprovedores_compuesto = '$idprovedores_compuesto'";
	$result_search_proveedor = mysql_query($query_search_proveedor);

	if (mysql_num_rows($result_search_proveedor) == 1) {

		while ($row_search_proveedor = mysql_fetch_array($result_search_proveedor)) {

			$nombre = ($nombre != "" and $row_search_proveedor[nombre] != $nombre) ? $nombre : $row_search_proveedor[nombre];
			$apellidos = ($apellidos != "" and $row_search_proveedor[apellidos] != $apellidos) ? $apellidos : $row_search_proveedor[apellidos];
			$sexo = ($sexo != "" and $row_search_proveedor[sexo] != $sexo) ? $sexo : $row_search_proveedor[sexo];
			$rfc = ($rfc != "" and $row_search_proveedor[rfc] != $rfc) ? $rfc : $row_search_proveedor[rfc];
			$alias = ($alias != "" and $row_search_proveedor[alias] != $alias) ? $alias : $row_search_proveedor[alias];
			$trato = ($trato != "" and $row_search_proveedor[trato] != $trato) ? $trato : $row_search_proveedor[trato];
			$telefono_otro = ($telefono_otro != "" and $row_search_proveedor[telefono_otro] != $telefono_otro) ? $telefono_otro : $row_search_proveedor[telefono_otro];
			$telefono_celular = ($telefono_celular != "" and $row_search_proveedor[telefono_celular] != $telefono_celular) ? $telefono_celular : $row_search_proveedor[telefono_celular];
			$email = ($email != "" and $row_search_proveedor[email] != $email) ? $email : $row_search_proveedor[email];
			$referencia_nombre = ($referencia_nombre != "" and $row_search_proveedor[referencia_nombre] != $referencia_nombre) ? $referencia_nombre : $row_search_proveedor[referencia_nombre];
			$referencia_celular = ($referencia_celular != "" and $row_search_proveedor[referencia_celular] != $referencia_celular) ? $referencia_celular : $row_search_proveedor[referencia_celular];
			$referencia_fijo = ($referencia_fijo != "" and $row_search_proveedor[referencia_fijo] != $referencia_fijo) ? $referencia_fijo : $row_search_proveedor[referencia_fijo];
			$referencia_nombre2 = ($referencia_nombre2 != "" and $row_search_proveedor[referencia_nombre2] != $referencia_nombre2) ? $referencia_nombre2 : $row_search_proveedor[referencia_nombre2];
			$referencia_celular2 = ($referencia_celular2 != "" and $row_search_proveedor[referencia_celular2] != $referencia_celular2) ? $referencia_celular2 : $row_search_proveedor[referencia_celular2];
			$referencia_fijo2 = ($referencia_fijo2 != "" and $row_search_proveedor[referencia_fijo2] != $referencia_fijo2) ? $referencia_fijo2 : $row_search_proveedor[referencia_fijo2];
			$referencia_nombre3 = ($referencia_nombre3 != "" and $row_search_proveedor[referencia_nombre3] != $referencia_nombre3) ? $referencia_nombre3 : $row_search_proveedor[referencia_nombre3];
			$referencia_celular3 = ($referencia_celular3 != "" and $row_search_proveedor[referencia_celular3] != $referencia_celular3) ? $referencia_celular3 : $row_search_proveedor[referencia_celular3];
			$referencia_fijo3 = ($referencia_fijo3 != "" and $row_search_proveedor[referencia_fijo3] != $referencia_fijo3) ? $referencia_fijo3 : $row_search_proveedor[referencia_fijo3];
			$tipo_registro = ($tipo_registro != "" and $row_search_proveedor[tipo_registro] != $tipo_registro) ? $tipo_registro : $row_search_proveedor[tipo_registro];
			$recomendado = ($recomendado != "" and $row_search_proveedor[recomendado] != $recomendado) ? $recomendado : $row_search_proveedor[recomendado];
			$entrada = ($entrada != "" and $row_search_proveedor[entrada] != $entrada) ? $entrada : $row_search_proveedor[entrada];
			$asesor = ($asesor != "" and $row_search_proveedor[asesor] != $asesor) ? $asesor : $row_search_proveedor[asesor];
			$tipo_cliente = ($tipo_cliente != "" and $row_search_proveedor[tipo_cliente] != $tipo_cliente) ? $tipo_cliente : $row_search_proveedor[tipo_cliente];
			$tipo_credito = ($tipo_credito != "" and $row_search_proveedor[tipo_credito] != $tipo_credito) ? $tipo_credito : $row_search_proveedor[tipo_credito];
			$linea_credito = ($linea_credito != "" and $row_search_proveedor[linea_credito] != $linea_credito) ? $linea_credito : $row_search_proveedor[linea_credito];
			$codigo_postal = ($codigo_postal != "" and $row_search_proveedor[codigo_postal] != $codigo_postal) ? $codigo_postal : $row_search_proveedor[codigo_postal];
			$estado = ($estado != "" and $row_search_proveedor[estado] != $estado) ? $estado : $row_search_proveedor[estado];
			$delmuni = ($delmuni != "" and $row_search_proveedor[delmuni] != $delmuni) ? $delmuni : $row_search_proveedor[delmuni];
			$colonia = ($colonia != "" and $row_search_proveedor[colonia] != $colonia) ? $colonia : $row_search_proveedor[colonia];
			$calle = ($calle != "" and $row_search_proveedor[calle] != $calle) ? $calle : $row_search_proveedor[calle];
			$foto_perfil = ($foto_perfil != "" and $row_search_proveedor[foto_perfil] != $foto_perfil) ? $foto_perfil : $row_search_proveedor[foto_perfil];
			$metodo_pago = ($metodo_pago != "" and $row_search_proveedor[metodo_pago] != $metodo_pago) ? $metodo_pago : $row_search_proveedor[metodo_pago];
			$col1 = ($col1 != "" and $row_search_proveedor[col1] != $col1) ? $col1 : $row_search_proveedor[col1];
			$col2 = ($col2 != "" and $row_search_proveedor[col2] != $col2) ? $col2 : $row_search_proveedor[col2];
			$col3 = ($col3 != "" and $row_search_proveedor[col3] != $col3) ? $col3 : $row_search_proveedor[col3];
			$col4 = ($col4 != "" and $row_search_proveedor[col4] != $col4) ? $col4 : $row_search_proveedor[col4];
			$col5 = ($col5 != "" and $row_search_proveedor[col5] != $col5) ? $col5 : $row_search_proveedor[col5];
			$col6 = ($col6 != "" and $row_search_proveedor[col6] != $col6) ? $col6 : $row_search_proveedor[col6];
			$col7 = ($col7 != "" and $row_search_proveedor[col7] != $col7) ? $col7 : $row_search_proveedor[col7];
			$col8 = ($col8 != "" and $row_search_proveedor[col8] != $col8) ? $col8 : $row_search_proveedor[col8];
			$col9 = ($col9 != "" and $row_search_proveedor[col9] != $col9) ? $col9 : $row_search_proveedor[col9];
			$col10 = ($col10 != "" and $row_search_proveedor[col10] != $col10) ? $col10 : $row_search_proveedor[col10];
			$archivo_ine = ($archivo_ine != "" and $row_search_proveedor[archivo_ine] != $archivo_ine) ? $archivo_ine : $row_search_proveedor[archivo_ine];
			$archivo_comprobante = ($archivo_comprobante != "" and $row_search_proveedor[archivo_comprobante] != $archivo_comprobante) ? $archivo_comprobante : $row_search_proveedor[archivo_comprobante];


			$query_update_proveedor = "UPDATE proveedores SET  nombre = '$nombre', apellidos = '$apellidos', sexo = '$sexo', rfc = '$rfc', alias = '$alias', trato = '$trato', telefono_otro = '$telefono_otro', telefono_celular = '$telefono_celular', email = '$email', referencia_nombre = '$referencia_nombre', referencia_celular = '$referencia_celular', referencia_fijo = '$referencia_fijo', referencia_nombre2 = '$referencia_nombre2', referencia_celular2 = '$referencia_celular2', referencia_fijo2 = '$referencia_fijo2', referencia_nombre3 = '$referencia_nombre3', referencia_celular3 = '$referencia_celular3', referencia_fijo3 = '$referencia_fijo3', tipo_registro = '$tipo_registro', recomendado = '$recomendado', entrada = '$entrada', asesor = '$asesor', tipo_cliente = '$tipo_cliente', tipo_credito = '$tipo_credito', linea_credito = '$linea_credito', codigo_postal = '$codigo_postal', estado = '$estado', delmuni = '$delmuni', colonia = '$colonia', calle = '$calle', foto_perfil = '$foto_perfil', metodo_pago = '$metodo_pago', col1 = '$col1', col2 = '$col2', col3 = '$col3', col4 = '$col4', col5 = '$col5', col6 = '$col6', col7 = '$col7', col8 = '$col8', col9 = '$col9', col10 = '$col10', archivo_ine = '$archivo_ine', archivo_comprobante = '$archivo_comprobante' WHERE idproveedores = '$row_search_proveedor[idproveedores]'";

			$result_update_proveedor = mysql_query($query_update_proveedor);

			if ($result_update_proveedor == 1) {

				if ($nombre != "" and $row_search_proveedor[nombre] != $nombre) {
					$txtbitacora_proveedor .= "EL Nombre cambio de <b>$row_search_proveedor[nombre]</b> por <b>$nombre</b><br>";
				}
				if ($apellidos != "" and $row_search_proveedor[apellidos] != $apellidos) {
					$txtbitacora_proveedor .= "Los apellidos cambiaron de <b>$row_search_proveedor[apellidos]</b> por <b>$apellidos</b><br>";
				}
				if ($sexo != "" and $row_search_proveedor[sexo] != $sexo) {
					$txtbitacora_proveedor .= "EL sexo cambio de <b>$row_search_proveedor[sexo]</b> por <b>$sexo</b><br>";
				}
				if ($rfc != "" and $row_search_proveedor[rfc] != $rfc) {
					$txtbitacora_proveedor .= "EL RFC cambio de <b>$row_search_proveedor[rfc]</b> por <b>$rfc</b><br>";
				}
				if ($alias != "" and $row_search_proveedor[alias] != $alias) {
					$txtbitacora_proveedor .= "EL alias cambio de <b>$row_search_proveedor[alias]</b> por <b>$alias</b><br>";
				}
				if ($trato != "" and $row_search_proveedor[trato] != $trato) {
					$txtbitacora_proveedor .= "EL trato cambio de <b>$row_search_proveedor[trato]</b> por <b>$trato</b><br>";
				}
				if ($telefono_otro != "" and $row_search_proveedor[telefono_otro] != $telefono_otro) {
					$txtbitacora_proveedor .= "EL teléfono otro cambio de <b>$row_search_proveedor[telefono_otro]</b> por <b>$telefono_otro</b><br>";
				}
				if ($telefono_celular != "" and $row_search_proveedor[telefono_celular] != $telefono_celular) {
					$txtbitacora_proveedor .= "EL teléfono celular cambio de <b>$row_search_proveedor[telefono_celular]</b> por <b>$telefono_celular</b><br>";
				}
				if ($email != "" and $row_search_proveedor[email] != $email) {
					$txtbitacora_proveedor .= "EL email cambio de <b>$row_search_proveedor[email]</b> por <b>$email</b><br>";
				}
				if ($referencia_nombre != "" and $row_search_proveedor[referencia_nombre] != $referencia_nombre) {
					$txtbitacora_proveedor .= "EL nombre de referencia cambio de <b>$row_search_proveedor[referencia_nombre]</b> por <b>$referencia_nombre</b><br>";
				}
				if ($referencia_celular != "" and $row_search_proveedor[referencia_celular] != $referencia_celular) {
					$txtbitacora_proveedor .= "EL celular de cambio de <b>$row_search_proveedor[referencia_celular]</b> por <b>$referencia_celular</b><br>";
				}
				if ($referencia_fijo != "" and $row_search_proveedor[referencia_fijo] != $referencia_fijo) {
					$txtbitacora_proveedor .= "EL telefono fijo de referencia cambio de <b>$row_search_proveedor[referencia_fijo]</b> por <b>$referencia_fijo</b><br>";
				}
				if ($referencia_nombre2 != "" and $row_search_proveedor[referencia_nombre2] != $referencia_nombre2) {
					$txtbitacora_proveedor .= "EL referencia_nombre2 cambio de <b>$row_search_proveedor[referencia_nombre2]</b> por <b>$referencia_nombre2</b><br>";
				}
				if ($referencia_celular2 != "" and $row_search_proveedor[referencia_celular2] != $referencia_celular2) {
					$txtbitacora_proveedor .= "EL referencia_celular2 cambio de <b>$row_search_proveedor[referencia_celular2]</b> por <b>$referencia_celular2</b><br>";
				}
				if ($referencia_fijo2 != "" and $row_search_proveedor[referencia_fijo2] != $referencia_fijo2) {
					$txtbitacora_proveedor .= "EL referencia_fijo2 cambio de <b>$row_search_proveedor[referencia_fijo2]</b> por <b>$referencia_fijo2</b><br>";
				}
				if ($referencia_nombre3 != "" and $row_search_proveedor[referencia_nombre3] != $referencia_nombre3) {
					$txtbitacora_proveedor .= "EL referencia_nombre3 cambio de <b>$row_search_proveedor[referencia_nombre3]</b> por <b>$referencia_nombre3</b><br>";
				}
				if ($referencia_celular3 != "" and $row_search_proveedor[referencia_celular3] != $referencia_celular3) {
					$txtbitacora_proveedor .= "EL referencia_celular3 cambio de <b>$row_search_proveedor[referencia_celular3]</b> por <b>$referencia_celular3</b><br>";
				}
				if ($referencia_fijo3 != "" and $row_search_proveedor[referencia_fijo3] != $referencia_fijo3) {
					$txtbitacora_proveedor .= "EL referencia_fijo3 cambio de <b>$row_search_proveedor[referencia_fijo3]</b> por <b>$referencia_fijo3</b><br>";
				}
				if ($tipo_registro != "" and $row_search_proveedor[tipo_registro] != $tipo_registro) {
					$txtbitacora_proveedor .= "EL tipo_registro cambio de <b>$row_search_proveedor[tipo_registro]</b> por <b>$tipo_registro</b><br>";
				}
				if ($recomendado != "" and $row_search_proveedor[recomendado] != $recomendado) {
					$txtbitacora_proveedor .= "EL recomendado cambio de <b>$row_search_proveedor[recomendado]</b> por <b>$recomendado</b><br>";
				}
				if ($entrada != "" and $row_search_proveedor[entrada] != $entrada) {
					$txtbitacora_proveedor .= "EL entrada cambio de <b>$row_search_proveedor[entrada]</b> por <b>$entrada</b><br>";
				}
				if ($asesor != "" and $row_search_proveedor[asesor] != $asesor) {
					$txtbitacora_proveedor .= "EL asesor cambio de <b>$row_search_proveedor[asesor]</b> por <b>$asesor</b><br>";
				}
				if ($tipo_cliente != "" and $row_search_proveedor[tipo_cliente] != $tipo_cliente) {
					$txtbitacora_proveedor .= "EL tipo_cliente cambio de <b>$row_search_proveedor[tipo_cliente]</b> por <b>$tipo_cliente</b><br>";
				}
				if ($tipo_credito != "" and $row_search_proveedor[tipo_credito] != $tipo_credito) {
					$txtbitacora_proveedor .= "EL tipo_credito cambio de <b>$row_search_proveedor[tipo_credito]</b> por <b>$tipo_credito</b><br>";
				}
				if ($linea_credito != "" and $row_search_proveedor[linea_credito] != $linea_credito) {
					$txtbitacora_proveedor .= "EL linea_credito cambio de <b>$row_search_proveedor[linea_credito]</b> por <b>$linea_credito</b><br>";
				}
				if ($codigo_postal != "" and $row_search_proveedor[codigo_postal] != $codigo_postal) {
					$txtbitacora_proveedor .= "EL codigo_postal cambio de <b>$row_search_proveedor[codigo_postal]</b> por <b>$codigo_postal</b><br>";
				}
				if ($estado != "" and $row_search_proveedor[estado] != $estado) {
					$txtbitacora_proveedor .= "EL estado cambio de <b>$row_search_proveedor[estado]</b> por <b>$estado</b><br>";
				}
				if ($delmuni != "" and $row_search_proveedor[delmuni] != $delmuni) {
					$txtbitacora_proveedor .= "EL delmuni cambio de <b>$row_search_proveedor[delmuni]</b> por <b>$delmuni</b><br>";
				}
				if ($colonia != "" and $row_search_proveedor[colonia] != $colonia) {
					$txtbitacora_proveedor .= "EL colonia cambio de <b>$row_search_proveedor[colonia]</b> por <b>$colonia</b><br>";
				}
				if ($calle != "" and $row_search_proveedor[calle] != $calle) {
					$txtbitacora_proveedor .= "EL calle cambio de <b>$row_search_proveedor[calle]</b> por <b>$calle</b><br>";
				}
				if ($foto_perfil != "" and $row_search_proveedor[foto_perfil] != $foto_perfil) {
					$txtbitacora_proveedor .= "EL foto_perfil cambio de <b>$row_search_proveedor[foto_perfil]</b> por <b>$foto_perfil</b><br>";
				}
				if ($metodo_pago != "" and $row_search_proveedor[metodo_pago] != $metodo_pago) {
					$txtbitacora_proveedor .= "EL metodo_pago cambio de <b>$row_search_proveedor[metodo_pago]</b> por <b>$metodo_pago</b><br>";
				}
				if ($col1 != "" and $row_search_proveedor[col1] != $col1) {
					$txtbitacora_proveedor .= "EL col1 cambio de <b>$row_search_proveedor[col1]</b> por <b>$col1</b><br>";
				}
				if ($col2 != "" and $row_search_proveedor[col2] != $col2) {
					$txtbitacora_proveedor .= "EL col2 cambio de <b>$row_search_proveedor[col2]</b> por <b>$col2</b><br>";
				}
				if ($col3 != "" and $row_search_proveedor[col3] != $col3) {
					$txtbitacora_proveedor .= "EL col3 cambio de <b>$row_search_proveedor[col3]</b> por <b>$col3</b><br>";
				}
				if ($col4 != "" and $row_search_proveedor[col4] != $col4) {
					$txtbitacora_proveedor .= "EL col4 cambio de <b>$row_search_proveedor[col4]</b> por <b>$col4</b><br>";
				}
				if ($col5 != "" and $row_search_proveedor[col5] != $col5) {
					$txtbitacora_proveedor .= "EL col5 cambio de <b>$row_search_proveedor[col5]</b> por <b>$col5</b><br>";
				}
				if ($col6 != "" and $row_search_proveedor[col6] != $col6) {
					$txtbitacora_proveedor .= "EL col6 cambio de <b>$row_search_proveedor[col6]</b> por <b>$col6</b><br>";
				}
				if ($col7 != "" and $row_search_proveedor[col7] != $col7) {
					$txtbitacora_proveedor .= "EL col7 cambio de <b>$row_search_proveedor[col7]</b> por <b>$col7</b><br>";
				}
				if ($col8 != "" and $row_search_proveedor[col8] != $col8) {
					$txtbitacora_proveedor .= "EL col8 cambio de <b>$row_search_proveedor[col8]</b> por <b>$col8</b><br>";
				}
				if ($col9 != "" and $row_search_proveedor[col9] != $col9) {
					$txtbitacora_proveedor .= "EL col9 cambio de <b>$row_search_proveedor[col9]</b> por <b>$col9</b><br>";
				}
				if ($col10 != "" and $row_search_proveedor[col10] != $col10) {
					$txtbitacora_proveedor .= "EL col10 cambio de <b>$row_search_proveedor[col10]</b> por <b>$col10</b><br>";
				}
				if ($archivo_ine != "" and $row_search_proveedor[archivo_ine] != $archivo_ine) {
					$txtbitacora_proveedor .= "EL archivo_ine cambio de <b>$row_search_proveedor[archivo_ine]</b> por <b>$archivo_ine</b><br>";
				}
				if ($archivo_comprobante != "" and $row_search_proveedor[archivo_comprobante] != $archivo_comprobante) {
					$txtbitacora_proveedor .= "EL archivo_comprobante cambio de <b>$row_search_proveedor[archivo_comprobante]</b> por <b>$archivo_comprobante</b><br>";
				}

				$add_cambios_proveedor = CambiosProveedor($txtbitacora_proveedor, $usuario_creador, $fecha_guardado, $row_search_proveedor[idproveedores]);

				#Actualizar auxiliares

				if ($add_cambios_proveedor == 1) {

					$nombre_bd = trim("$row_search_proveedor[nombre] $row_search_proveedor[apellidos]");
					$nombre_new = trim("$nombre $apellidos");

					$mensaje_actualizacion =  UpdateProveedoresAuxiliaresBalance($nombre_bd, $nombre_new, $usuario_creador, $fecha_guardado, $row_search_proveedor[idproveedores]);
					#
				} else {

					$nombre_bd = trim("$row_search_proveedor[nombre] $$row_search_proveedor[apellidos]");
					$nombre_new = trim("$nombre $apellidos");

					$add_auxiliares = UpdateProveedoresAuxiliaresBalance($nombre_bd, $nombre_new, $usuario_creador, $fecha_guardado, $row_search_proveedor[idproveedores]);

					$result_auxiliares = ($add_auxiliares == 1) ? "" : $add_auxiliares;
					#

					$mensaje_actualizacion = $add_cambios_proveedor . $result_auxiliares;
				}
			} else {

				$mensaje_actualizacion = "- Ocurrio un error al Actualizar el Proveedor <br>";
			}
		}
	} else {

		$query_search_proveedor_temporal = "SELECT * FROM orden_logistica_proveedores WHERE idprovedores_compuesto = '$idprovedores_compuesto'";
		$result_search_proveedor_temporal = mysql_query($query_search_proveedor_temporal);

		if (mysql_num_rows($result_search_proveedor_temporal) >= 1) {

			while ($row_search_proveedor_temporal = mysql_fetch_array($result_search_proveedor_temporal)) {

				$nombre = ($nombre != "" and $row_search_proveedor_temporal[nombre] != $nombre) ? $nombre : $row_search_proveedor_temporal[nombre];
				$apellidos = ($apellidos != "" and $row_search_proveedor_temporal[apellidos] != $apellidos) ? $apellidos : $row_search_proveedor_temporal[apellidos];
				$sexo = ($sexo != "" and $row_search_proveedor_temporal[sexo] != $sexo) ? $sexo : $row_search_proveedor_temporal[sexo];
				$rfc = ($rfc != "" and $row_search_proveedor_temporal[rfc] != $rfc) ? $rfc : $row_search_proveedor_temporal[rfc];
				$alias = ($alias != "" and $row_search_proveedor_temporal[alias] != $alias) ? $alias : $row_search_proveedor_temporal[alias];
				$trato = ($trato != "" and $row_search_proveedor_temporal[trato] != $trato) ? $trato : $row_search_proveedor_temporal[trato];
				$telefono_otro = ($telefono_otro != "" and $row_search_proveedor_temporal[telefono_otro] != $telefono_otro) ? $telefono_otro : $row_search_proveedor_temporal[telefono_otro];
				$telefono_celular = ($telefono_celular != "" and $row_search_proveedor_temporal[telefono_celular] != $telefono_celular) ? $telefono_celular : $row_search_proveedor_temporal[telefono_celular];
				$email = ($email != "" and $row_search_proveedor_temporal[email] != $email) ? $email : $row_search_proveedor_temporal[email];
				$referencia_nombre = ($referencia_nombre != "" and $row_search_proveedor_temporal[referencia_nombre] != $referencia_nombre) ? $referencia_nombre : $row_search_proveedor_temporal[referencia_nombre];
				$referencia_celular = ($referencia_celular != "" and $row_search_proveedor_temporal[referencia_celular] != $referencia_celular) ? $referencia_celular : $row_search_proveedor_temporal[referencia_celular];
				$referencia_fijo = ($referencia_fijo != "" and $row_search_proveedor_temporal[referencia_fijo] != $referencia_fijo) ? $referencia_fijo : $row_search_proveedor_temporal[referencia_fijo];
				$referencia_nombre2 = ($referencia_nombre2 != "" and $row_search_proveedor_temporal[referencia_nombre2] != $referencia_nombre2) ? $referencia_nombre2 : $row_search_proveedor_temporal[referencia_nombre2];
				$referencia_celular2 = ($referencia_celular2 != "" and $row_search_proveedor_temporal[referencia_celular2] != $referencia_celular2) ? $referencia_celular2 : $row_search_proveedor_temporal[referencia_celular2];
				$referencia_fijo2 = ($referencia_fijo2 != "" and $row_search_proveedor_temporal[referencia_fijo2] != $referencia_fijo2) ? $referencia_fijo2 : $row_search_proveedor_temporal[referencia_fijo2];
				$referencia_nombre3 = ($referencia_nombre3 != "" and $row_search_proveedor_temporal[referencia_nombre3] != $referencia_nombre3) ? $referencia_nombre3 : $row_search_proveedor_temporal[referencia_nombre3];
				$referencia_celular3 = ($referencia_celular3 != "" and $row_search_proveedor_temporal[referencia_celular3] != $referencia_celular3) ? $referencia_celular3 : $row_search_proveedor_temporal[referencia_celular3];
				$referencia_fijo3 = ($referencia_fijo3 != "" and $row_search_proveedor_temporal[referencia_fijo3] != $referencia_fijo3) ? $referencia_fijo3 : $row_search_proveedor_temporal[referencia_fijo3];
				$tipo_registro = ($tipo_registro != "" and $row_search_proveedor_temporal[tipo_registro] != $tipo_registro) ? $tipo_registro : $row_search_proveedor_temporal[tipo_registro];
				$recomendado = ($recomendado != "" and $row_search_proveedor_temporal[recomendado] != $recomendado) ? $recomendado : $row_search_proveedor_temporal[recomendado];
				$entrada = ($entrada != "" and $row_search_proveedor_temporal[entrada] != $entrada) ? $entrada : $row_search_proveedor_temporal[entrada];
				$asesor = ($asesor != "" and $row_search_proveedor_temporal[asesor] != $asesor) ? $asesor : $row_search_proveedor_temporal[asesor];
				$tipo_cliente = ($tipo_cliente != "" and $row_search_proveedor_temporal[tipo_cliente] != $tipo_cliente) ? $tipo_cliente : $row_search_proveedor_temporal[tipo_cliente];
				$tipo_credito = ($tipo_credito != "" and $row_search_proveedor_temporal[tipo_credito] != $tipo_credito) ? $tipo_credito : $row_search_proveedor_temporal[tipo_credito];
				$linea_credito = ($linea_credito != "" and $row_search_proveedor_temporal[linea_credito] != $linea_credito) ? $linea_credito : $row_search_proveedor_temporal[linea_credito];
				$codigo_postal = ($codigo_postal != "" and $row_search_proveedor_temporal[codigo_postal] != $codigo_postal) ? $codigo_postal : $row_search_proveedor_temporal[codigo_postal];
				$estado = ($estado != "" and $row_search_proveedor_temporal[estado] != $estado) ? $estado : $row_search_proveedor_temporal[estado];
				$delmuni = ($delmuni != "" and $row_search_proveedor_temporal[delmuni] != $delmuni) ? $delmuni : $row_search_proveedor_temporal[delmuni];
				$colonia = ($colonia != "" and $row_search_proveedor_temporal[colonia] != $colonia) ? $colonia : $row_search_proveedor_temporal[colonia];
				$calle = ($calle != "" and $row_search_proveedor_temporal[calle] != $calle) ? $calle : $row_search_proveedor_temporal[calle];
				$foto_perfil = ($foto_perfil != "" and $row_search_proveedor_temporal[foto_perfil] != $foto_perfil) ? $foto_perfil : $row_search_proveedor_temporal[foto_perfil];
				$metodo_pago = ($metodo_pago != "" and $row_search_proveedor_temporal[metodo_pago] != $metodo_pago) ? $metodo_pago : $row_search_proveedor_temporal[metodo_pago];
				$col1 = ($col1 != "" and $row_search_proveedor_temporal[col1] != $col1) ? $col1 : $row_search_proveedor_temporal[col1];
				$col2 = ($col2 != "" and $row_search_proveedor_temporal[col2] != $col2) ? $col2 : $row_search_proveedor_temporal[col2];
				$col3 = ($col3 != "" and $row_search_proveedor_temporal[col3] != $col3) ? $col3 : $row_search_proveedor_temporal[col3];
				$col4 = ($col4 != "" and $row_search_proveedor_temporal[col4] != $col4) ? $col4 : $row_search_proveedor_temporal[col4];
				$col5 = ($col5 != "" and $row_search_proveedor_temporal[col5] != $col5) ? $col5 : $row_search_proveedor_temporal[col5];
				$col6 = ($col6 != "" and $row_search_proveedor_temporal[col6] != $col6) ? $col6 : $row_search_proveedor_temporal[col6];
				$col7 = ($col7 != "" and $row_search_proveedor_temporal[col7] != $col7) ? $col7 : $row_search_proveedor_temporal[col7];
				$col8 = ($col8 != "" and $row_search_proveedor_temporal[col8] != $col8) ? $col8 : $row_search_proveedor_temporal[col8];
				$col9 = ($col9 != "" and $row_search_proveedor_temporal[col9] != $col9) ? $col9 : $row_search_proveedor_temporal[col9];
				$col10 = ($col10 != "" and $row_search_proveedor_temporal[col10] != $col10) ? $col10 : $row_search_proveedor_temporal[col10];


				$query_update_proveedor = "UPDATE orden_logistica_proveedores SET  nombre = '$nombre', apellidos = '$apellidos', sexo = '$sexo', rfc = '$rfc', alias = '$alias', trato = '$trato', telefono_otro = '$telefono_otro', telefono_celular = '$telefono_celular', email = '$email', referencia_nombre = '$referencia_nombre', referencia_celular = '$referencia_celular', referencia_fijo = '$referencia_fijo', referencia_nombre2 = '$referencia_nombre2', referencia_celular2 = '$referencia_celular2', referencia_fijo2 = '$referencia_fijo2', referencia_nombre3 = '$referencia_nombre3', referencia_celular3 = '$referencia_celular3', referencia_fijo3 = '$referencia_fijo3', tipo_registro = '$tipo_registro', recomendado = '$recomendado', entrada = '$entrada', asesor = '$asesor', tipo_cliente = '$tipo_cliente', tipo_credito = '$tipo_credito', linea_credito = '$linea_credito', codigo_postal = '$codigo_postal', estado = '$estado', delmuni = '$delmuni', colonia = '$colonia', calle = '$calle', foto_perfil = '$foto_perfil', metodo_pago = '$metodo_pago', col1 = '$col1', col2 = '$col2', col3 = '$col3', col4 = '$col4', col5 = '$col5', col6 = '$col6', col7 = '$col7', col8 = '$col8', col9 = '$col9', col10 = '$col10' WHERE idorden_logistica_proveedores = '$row_search_proveedor_temporal[idorden_logistica_proveedores]'";

				$result_update_proveedor = mysql_query($query_update_proveedor);

				if ($result_update_proveedor == 1) {


					if ($nombre != "" and $row_search_proveedor_temporal[nombre] != $nombre) {
						$txtbitacora_proveedor .= "EL Nombre cambio de <b>$row_search_proveedor_temporal[nombre]</b> por <b>$nombre</b><br>";
					}
					if ($apellidos != "" and $row_search_proveedor_temporal[apellidos] != $apellidos) {
						$txtbitacora_proveedor .= "Los apellidos cambiaron de <b>$row_search_proveedor_temporal[apellidos]</b> por <b>$apellidos</b><br>";
					}
					if ($sexo != "" and $row_search_proveedor_temporal[sexo] != $sexo) {
						$txtbitacora_proveedor .= "EL sexo cambio de <b>$row_search_proveedor_temporal[sexo]</b> por <b>$sexo</b><br>";
					}
					if ($rfc != "" and $row_search_proveedor_temporal[rfc] != $rfc) {
						$txtbitacora_proveedor .= "EL RFC cambio de <b>$row_search_proveedor_temporal[rfc]</b> por <b>$rfc</b><br>";
					}
					if ($alias != "" and $row_search_proveedor_temporal[alias] != $alias) {
						$txtbitacora_proveedor .= "EL alias cambio de <b>$row_search_proveedor_temporal[alias]</b> por <b>$alias</b><br>";
					}
					if ($trato != "" and $row_search_proveedor_temporal[trato] != $trato) {
						$txtbitacora_proveedor .= "EL trato cambio de <b>$row_search_proveedor_temporal[trato]</b> por <b>$trato</b><br>";
					}
					if ($telefono_otro != "" and $row_search_proveedor_temporal[telefono_otro] != $telefono_otro) {
						$txtbitacora_proveedor .= "EL teléfono otro cambio de <b>$row_search_proveedor_temporal[telefono_otro]</b> por <b>$telefono_otro</b><br>";
					}
					if ($telefono_celular != "" and $row_search_proveedor_temporal[telefono_celular] != $telefono_celular) {
						$txtbitacora_proveedor .= "EL teléfono celular cambio de <b>$row_search_proveedor_temporal[telefono_celular]</b> por <b>$telefono_celular</b><br>";
					}
					if ($email != "" and $row_search_proveedor_temporal[email] != $email) {
						$txtbitacora_proveedor .= "EL email cambio de <b>$row_search_proveedor_temporal[email]</b> por <b>$email</b><br>";
					}
					if ($referencia_nombre != "" and $row_search_proveedor_temporal[referencia_nombre] != $referencia_nombre) {
						$txtbitacora_proveedor .= "EL nombre de referencia cambio de <b>$row_search_proveedor_temporal[referencia_nombre]</b> por <b>$referencia_nombre</b><br>";
					}
					if ($referencia_celular != "" and $row_search_proveedor_temporal[referencia_celular] != $referencia_celular) {
						$txtbitacora_proveedor .= "EL celular de cambio de <b>$row_search_proveedor_temporal[referencia_celular]</b> por <b>$referencia_celular</b><br>";
					}
					if ($referencia_fijo != "" and $row_search_proveedor_temporal[referencia_fijo] != $referencia_fijo) {
						$txtbitacora_proveedor .= "EL telefono fijo de referencia cambio de <b>$row_search_proveedor_temporal[referencia_fijo]</b> por <b>$referencia_fijo</b><br>";
					}
					if ($referencia_nombre2 != "" and $row_search_proveedor_temporal[referencia_nombre2] != $referencia_nombre2) {
						$txtbitacora_proveedor .= "EL referencia_nombre2 cambio de <b>$row_search_proveedor_temporal[referencia_nombre2]</b> por <b>$referencia_nombre2</b><br>";
					}
					if ($referencia_celular2 != "" and $row_search_proveedor_temporal[referencia_celular2] != $referencia_celular2) {
						$txtbitacora_proveedor .= "EL referencia_celular2 cambio de <b>$row_search_proveedor_temporal[referencia_celular2]</b> por <b>$referencia_celular2</b><br>";
					}
					if ($referencia_fijo2 != "" and $row_search_proveedor_temporal[referencia_fijo2] != $referencia_fijo2) {
						$txtbitacora_proveedor .= "EL referencia_fijo2 cambio de <b>$row_search_proveedor_temporal[referencia_fijo2]</b> por <b>$referencia_fijo2</b><br>";
					}
					if ($referencia_nombre3 != "" and $row_search_proveedor_temporal[referencia_nombre3] != $referencia_nombre3) {
						$txtbitacora_proveedor .= "EL referencia_nombre3 cambio de <b>$row_search_proveedor_temporal[referencia_nombre3]</b> por <b>$referencia_nombre3</b><br>";
					}
					if ($referencia_celular3 != "" and $row_search_proveedor_temporal[referencia_celular3] != $referencia_celular3) {
						$txtbitacora_proveedor .= "EL referencia_celular3 cambio de <b>$row_search_proveedor_temporal[referencia_celular3]</b> por <b>$referencia_celular3</b><br>";
					}
					if ($referencia_fijo3 != "" and $row_search_proveedor_temporal[referencia_fijo3] != $referencia_fijo3) {
						$txtbitacora_proveedor .= "EL referencia_fijo3 cambio de <b>$row_search_proveedor_temporal[referencia_fijo3]</b> por <b>$referencia_fijo3</b><br>";
					}
					if ($tipo_registro != "" and $row_search_proveedor_temporal[tipo_registro] != $tipo_registro) {
						$txtbitacora_proveedor .= "EL tipo_registro cambio de <b>$row_search_proveedor_temporal[tipo_registro]</b> por <b>$tipo_registro</b><br>";
					}
					if ($recomendado != "" and $row_search_proveedor_temporal[recomendado] != $recomendado) {
						$txtbitacora_proveedor .= "EL recomendado cambio de <b>$row_search_proveedor_temporal[recomendado]</b> por <b>$recomendado</b><br>";
					}
					if ($entrada != "" and $row_search_proveedor_temporal[entrada] != $entrada) {
						$txtbitacora_proveedor .= "EL entrada cambio de <b>$row_search_proveedor_temporal[entrada]</b> por <b>$entrada</b><br>";
					}
					if ($asesor != "" and $row_search_proveedor_temporal[asesor] != $asesor) {
						$txtbitacora_proveedor .= "EL asesor cambio de <b>$row_search_proveedor_temporal[asesor]</b> por <b>$asesor</b><br>";
					}
					if ($tipo_cliente != "" and $row_search_proveedor_temporal[tipo_cliente] != $tipo_cliente) {
						$txtbitacora_proveedor .= "EL tipo_cliente cambio de <b>$row_search_proveedor_temporal[tipo_cliente]</b> por <b>$tipo_cliente</b><br>";
					}
					if ($tipo_credito != "" and $row_search_proveedor_temporal[tipo_credito] != $tipo_credito) {
						$txtbitacora_proveedor .= "EL tipo_credito cambio de <b>$row_search_proveedor_temporal[tipo_credito]</b> por <b>$tipo_credito</b><br>";
					}
					if ($linea_credito != "" and $row_search_proveedor_temporal[linea_credito] != $linea_credito) {
						$txtbitacora_proveedor .= "EL linea_credito cambio de <b>$row_search_proveedor_temporal[linea_credito]</b> por <b>$linea_credito</b><br>";
					}
					if ($codigo_postal != "" and $row_search_proveedor_temporal[codigo_postal] != $codigo_postal) {
						$txtbitacora_proveedor .= "EL codigo_postal cambio de <b>$row_search_proveedor_temporal[codigo_postal]</b> por <b>$codigo_postal</b><br>";
					}
					if ($estado != "" and $row_search_proveedor_temporal[estado] != $estado) {
						$txtbitacora_proveedor .= "EL estado cambio de <b>$row_search_proveedor_temporal[estado]</b> por <b>$estado</b><br>";
					}
					if ($delmuni != "" and $row_search_proveedor_temporal[delmuni] != $delmuni) {
						$txtbitacora_proveedor .= "EL delmuni cambio de <b>$row_search_proveedor_temporal[delmuni]</b> por <b>$delmuni</b><br>";
					}
					if ($colonia != "" and $row_search_proveedor_temporal[colonia] != $colonia) {
						$txtbitacora_proveedor .= "EL colonia cambio de <b>$row_search_proveedor_temporal[colonia]</b> por <b>$colonia</b><br>";
					}
					if ($calle != "" and $row_search_proveedor_temporal[calle] != $calle) {
						$txtbitacora_proveedor .= "EL calle cambio de <b>$row_search_proveedor_temporal[calle]</b> por <b>$calle</b><br>";
					}
					if ($foto_perfil != "" and $row_search_proveedor_temporal[foto_perfil] != $foto_perfil) {
						$txtbitacora_proveedor .= "EL foto_perfil cambio de <b>$row_search_proveedor_temporal[foto_perfil]</b> por <b>$foto_perfil</b><br>";
					}
					if ($metodo_pago != "" and $row_search_proveedor_temporal[metodo_pago] != $metodo_pago) {
						$txtbitacora_proveedor .= "EL metodo_pago cambio de <b>$row_search_proveedor_temporal[metodo_pago]</b> por <b>$metodo_pago</b><br>";
					}
					if ($col1 != "" and $row_search_proveedor_temporal[col1] != $col1) {
						$txtbitacora_proveedor .= "EL col1 cambio de <b>$row_search_proveedor_temporal[col1]</b> por <b>$col1</b><br>";
					}
					if ($col2 != "" and $row_search_proveedor_temporal[col2] != $col2) {
						$txtbitacora_proveedor .= "EL col2 cambio de <b>$row_search_proveedor_temporal[col2]</b> por <b>$col2</b><br>";
					}
					if ($col3 != "" and $row_search_proveedor_temporal[col3] != $col3) {
						$txtbitacora_proveedor .= "EL col3 cambio de <b>$row_search_proveedor_temporal[col3]</b> por <b>$col3</b><br>";
					}
					if ($col4 != "" and $row_search_proveedor_temporal[col4] != $col4) {
						$txtbitacora_proveedor .= "EL col4 cambio de <b>$row_search_proveedor_temporal[col4]</b> por <b>$col4</b><br>";
					}
					if ($col5 != "" and $row_search_proveedor_temporal[col5] != $col5) {
						$txtbitacora_proveedor .= "EL col5 cambio de <b>$row_search_proveedor_temporal[col5]</b> por <b>$col5</b><br>";
					}
					if ($col6 != "" and $row_search_proveedor_temporal[col6] != $col6) {
						$txtbitacora_proveedor .= "EL col6 cambio de <b>$row_search_proveedor_temporal[col6]</b> por <b>$col6</b><br>";
					}
					if ($col7 != "" and $row_search_proveedor_temporal[col7] != $col7) {
						$txtbitacora_proveedor .= "EL col7 cambio de <b>$row_search_proveedor_temporal[col7]</b> por <b>$col7</b><br>";
					}
					if ($col8 != "" and $row_search_proveedor_temporal[col8] != $col8) {
						$txtbitacora_proveedor .= "EL col8 cambio de <b>$row_search_proveedor_temporal[col8]</b> por <b>$col8</b><br>";
					}
					if ($col9 != "" and $row_search_proveedor_temporal[col9] != $col9) {
						$txtbitacora_proveedor .= "EL col9 cambio de <b>$row_search_proveedor_temporal[col9]</b> por <b>$col9</b><br>";
					}
					if ($col10 != "" and $row_search_proveedor_temporal[col10] != $col10) {
						$txtbitacora_proveedor .= "EL col10 cambio de <b>$row_search_proveedor_temporal[col10]</b> por <b>$col10</b><br>";
					}
					if ($archivo_ine != "" and $row_search_proveedor_temporal[archivo_ine] != $archivo_ine) {
						$txtbitacora_proveedor .= "EL archivo_ine cambio de <b>$row_search_proveedor_temporal[archivo_ine]</b> por <b>$archivo_ine</b><br>";
					}
					if ($archivo_comprobante != "" and $row_search_proveedor_temporal[archivo_comprobante] != $archivo_comprobante) {
						$txtbitacora_proveedor .= "EL archivo_comprobante cambio de <b>$row_search_proveedor_temporal[archivo_comprobante]</b> por <b>$archivo_comprobante</b><br>";
					}

					$mensaje_actualizacion = CambiosProveedorTemporal($txtbitacora_proveedor, $usuario_creador, $fecha_guardado, $row_search_proveedor_temporal[idorden_logistica_proveedores]);
				} else {

					$mensaje_actualizacion = "- Ocurrio un error al Actualizar el Proveedor <br>";
				}
			}
		} else {

			$mensaje_actualizacion = "-El Id no existe<br>";
		}
	}


	return $mensaje_actualizacion;
}

#------------------------------------------- Insertar codigo Autorizacion insertar token insertar --------------------------------------------------------------------------------


function CodigoAutorizacionWallet($codigo, $estatus, $empleados, $usuario_creador, $empleador_creador, $visible, $fecha_creacion, $fecha_guardado, $folio, $fecha_movimiento, $idcontacto, $monto_mx)
{

	$codigo = trim($codigo);
	$estatus = trim($estatus);
	$empleados = trim($empleados);
	$usuario_creador = trim($usuario_creador);
	$empleador_creador = trim($empleador_creador);
	$visible = trim($visible);
	$fecha_creacion = trim($fecha_creacion);
	$fecha_guardado = trim($fecha_guardado);
	$folio = trim($folio);
	$fecha_movimiento = trim($fecha_movimiento);
	$idcontacto = trim($idcontacto);
	$monto_mx = trim($monto_mx);

	$query_repetido_codigo = "SELECT * FROM estado_cuenta_tesorerias2_codigo_autorizacion WHERE fecha_creacion = $fecha_creacion AND folio = '$folio' AND visible = 'SI'";
	$result_repetido_codigo = mysql_query($query_repetido_codigo);

	if ($result_repetido_codigo == 1) {

		$mensaje_codigo_autorizacion = 1;
	} else {

		$query_insert_codigo_autorizacion = "INSERT INTO estado_cuenta_tesorerias2_codigo_autorizacion (codigo, estatus, empleados, usuario_creador, empleador_creador, visible, fecha_creacion, fecha_guardado, folio, fecha_movimiento, idcontacto, monto_mx) VALUES ('$codigo', '$estatus', '$empleados', '$usuario_creador', '$empleador_creador', '$visible', '$fecha_creacion', '$fecha_guardado', '$folio', '$fecha_movimiento', '$idcontacto', '$monto_mx')";
		$result_insert_codigo_autorizacion = mysql_query($query_insert_codigo_autorizacion);

		$mensaje_codigo_autorizacion = ($result_insert_codigo_autorizacion) ? 1 : "- Error al Insertar el <b>token</b> <br>";
	}


	return $mensaje_codigo_autorizacion;
}


#------------------------------------------- Actualizar Auxiliares Actualizar --------------------------------------------------------------------------------


function UpdateProveedoresAuxiliaresBalance($nombre_bd, $nombre_new, $usuario_creador, $fecha_guardado, $idproveedor)
{

	$nombre_bd  = trim($nombre_bd);
	$nombre_new = trim($nombre_new);

	$concatenar_tablas = array();
	$array_resultados = array();

	# Consulta Tablas auxiliares
	$query_auxiliares = "SELECT * FROM auxiliares WHERE trim(nombre) = '$nombre_bd'";

	$result_auxiliares = mysql_query($query_auxiliares);

	if (mysql_num_rows($result_auxiliares) >= 1) {

		while ($row_auxiliares = mysql_fetch_array($result_auxiliares)) {

			$query_update_auxiliares = "UPDATE auxiliares SET nombre = '$nombre_new' WHERE idauxiliares = '$row_auxiliares[idauxiliares]'";
			$result_update_auxiliares = mysql_query($query_update_auxiliares);

			($result_update_auxiliares == 1) ? array_push($array_resultados, "1") : array_push($array_resultados, "- Error en el movimiento <b>$row_auxiliares[idauxiliares]</b> de la tabla <b>Auxiliares</b><br>");

			($result_update_auxiliares == 1) ? array_push($concatenar_tablas, "Se actualizó en tabla <b>auxiliares</b><br>") : array_push($concatenar_tablas, "-Error en el movimiento <b>$row_auxiliares[idauxiliares]</b> de la tabla <b>Auxiliares</b><br>");
		}
	} else {

		array_push($array_resultados, "1");
	}

	# Consulta Tablas Balnce de Gastos Auxiliares Logistica

	$query_balance = "SELECT * FROM balance_gastos_auxiliares WHERE trim(nombre) = '$nombre_bd'";
	$result_balance = mysql_query($query_balance);

	if (mysql_num_rows($result_balance) >= 1) {

		while ($row_balance = mysql_fetch_array($result_balance)) {

			$query_update_balance = "UPDATE balance_gastos_auxiliares SET nombre = '$nombre_new' WHERE idbalance_gastos_auxiliares = '$row_balance[idbalance_gastos_auxiliares]'";
			$result_update_balance = mysql_query($query_update_balance);

			($result_update_balance == 1) ? array_push($array_resultados, "1") : array_push($array_resultados, "- Error en el movimiento <b>$row_balance[idbalance_gastos_auxiliares]</b> de la tabla <b>Balance Auxiliares</b><br>");

			($result_update_balance == 1) ? array_push($concatenar_tablas, "Se actualizó en tabla <b>balance auxiliares </b><br>") : array_push($concatenar_tablas, "- Error en el movimiento <b>$row_balance[idbalance_gastos_auxiliares]</b> de la tabla <b>Balance Auxiliares</b><br>");
		}
	} else {

		array_push($array_resultados, "1");
	}

	# Bitacora Proveedor

	$tratar_concatenar = Tratar_Array($concatenar_tablas);

	if (count($tratar_concatenar) >= 1) {

		foreach ($tratar_concatenar as $key_tratar => $value_tratar) {

			$add_bitacora = CambiosProveedor($value_tratar, $usuario_creador, $fecha_guardado, $idproveedor);

			array_push($array_resultados, $add_bitacora);
		}
	} else {

		array_push($array_resultados, "1");
	}

	# Resultado Final

	return TratarNumeroText(Tratar_Array($array_resultados));
}
