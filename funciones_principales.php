<?php

#-------------------------------------------Funcion Nombres y Tipo--------------------------------------------------------------------------------

function nombres_datos($id_id, $type_type)
{

	$id_id = trim($id_id);
	$type_type = trim($type_type);

	if ($type_type == "Cliente") {

		$query_cliente = "SELECT * FROM contactos WHERE idcontacto = '$id_id'";
		$result_cliente = mysql_query($query_cliente);

		if (mysql_num_rows($result_cliente) >= 1) {

			while ($row_cliente = mysql_fetch_array($result_cliente)) {

				$nombre = trim($row_cliente[nombre]);
				$apellidos = trim($row_cliente[apellidos]);
				$alias = trim($row_cliente[alias]);
				$telefono = (trim($row_cliente[telefono_celular]) == "") ? "N/A" : trim($row_cliente[telefono_celular]);
				$telefono_otro = (trim($row_cliente[telefono_otro]) == "") ? "N/A" : trim($row_cliente[telefono_otro]);
				$estado_cliente = (trim($row_cliente[estado]) == "") ? "Sin Estado" : trim($row_cliente[estado]);
				$municipio_cliente = (trim($row_cliente[delmuni]) == "") ? "Sin Municipio" : trim($row_cliente[delmuni]);
				$calle_cliente = (trim($row_cliente[calle]) == "") ? "Sin Calle" : trim($row_cliente[calle]);
				$colonia_cliente = (trim($row_cliente[colonia]) == "") ? "Sin Colonia" : trim($row_cliente[colonia]);
				$cp_cliente = (trim($row_cliente[cp_cliente]) == "") ? "N/A" : trim($row_cliente[cp_cliente]);
			}

			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Cliente|Pendiente";
		} else {

			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Cliente|Pendiente";
		}
	} elseif ($type_type == "Proveedor") {

		$query_proveedor = "SELECT * FROM proveedores WHERE idproveedores = '$id_id'";
		$result_proveedor = mysql_query($query_proveedor);

		if (mysql_num_rows($result_proveedor) >= 1) {

			while ($row_proveedor = mysql_fetch_array($result_proveedor)) {

				$nombre = trim($row_proveedor[nombre]);
				$apellidos = trim($row_proveedor[apellidos]);
				$alias = trim($row_proveedor[alias]);
				$telefono = (trim($row_proveedor[telefono_celular]) == "") ? "N/A" : trim($row_proveedor[telefono_celular]);
				$telefono_otro = (trim($row_proveedor[telefono_otro]) == "") ? "N/A" : trim($row_proveedor[telefono_otro]);
				$estado_cliente = (trim($row_proveedor[estado]) == "") ? "Sin Estado" : trim($row_proveedor[estado]);
				$municipio_cliente = (trim($row_proveedor[delmuni]) == "") ? "Sin Municipio" : trim($row_proveedor[delmuni]);
				$calle_cliente = (trim($row_proveedor[calle]) == "") ? "Sin Calle" : trim($row_proveedor[calle]);
				$colonia_cliente = (trim($row_proveedor[colonia]) == "") ? "Sin Colonia" : trim($row_proveedor[colonia]);
				$cp_cliente = (trim($row_proveedor[cp_cliente]) == "") ? "N/A" : trim($row_proveedor[cp_cliente]);
				$condicion_proveedor = trim($row_proveedor[col10]);
			}

			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor|$condicion_proveedor";
		} else {

			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor|Pendiente";
		}
	} elseif ($type_type == "Proveedor Temporal") {

		$query_proveedor_tem = "SELECT * FROM orden_logistica_proveedores WHERE idorden_logistica_proveedores = '$id_id'";
		$result_proveedor_tem = mysql_query($query_proveedor_tem);

		if (mysql_num_rows($result_proveedor_tem) >= 1) {

			while ($row_proveedor_tem = mysql_fetch_array($result_proveedor_tem)) {
				$nombre = trim($row_proveedor_tem[nombre]);
				$apellidos = trim($row_proveedor_tem[apellidos]);
				$alias = trim($row_proveedor_tem[alias]);
				$telefono = (trim($row_proveedor_tem[telefono_celular]) == "") ? "N/A" : trim($row_proveedor_tem[telefono_celular]);
				$telefono_otro = (trim($row_proveedor_tem[telefono_otro]) == "") ? "N/A" : trim($row_proveedor_tem[telefono_otro]);
				$estado_cliente = (trim($row_proveedor_tem[estado]) == "") ? "Sin Estado" : trim($row_proveedor_tem[estado]);
				$municipio_cliente = (trim($row_proveedor_tem[delmuni]) == "") ? "Sin Municipio" : trim($row_proveedor_tem[delmuni]);
				$calle_cliente = (trim($row_proveedor_tem[calle]) == "") ? "Sin Calle" : trim($row_proveedor_tem[calle]);
				$colonia_cliente = (trim($row_proveedor_tem[colonia]) == "") ? "Sin Colonia" : trim($row_proveedor_tem[colonia]);
				$cp_cliente = (trim($row_proveedor_tem[cp_cliente]) == "") ? "N/A" : trim($row_proveedor_tem[codigo_postal]);
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor Temporal|Pendiente";
		} else {
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor Temporal|Pendiente";
		}
	} elseif ($type_type == "Colaborador" || $type_type == "Empleado"  || $type_type == "Empleados") {

		$query_colaborador = "SELECT * FROM empleados WHERE idempleados = '$id_id'";
		$result_colaborador = mysql_query($query_colaborador);

		if (mysql_num_rows($result_colaborador) >= 1) {

			while ($row_colaborador = mysql_fetch_array($result_colaborador)) {
				$nombre = trim($row_colaborador[nombre]);
				$apellidos = trim($row_colaborador[apellido_paterno]) . " " . trim($row_colaborador[apellido_materno]);
				$alias = trim($row_colaborador[columna_b]);
				$telefono = (trim($row_colaborador[telefono_empresa]) == "") ? "N/A" : trim("521" . $row_colaborador[telefono_empresa]);
				$telefono_otro = (trim($row_colaborador[telefono_personal]) == "") ? "N/A" : trim("521" . $row_colaborador[telefono_personal]);
				$estado_cliente = (trim($row_colaborador[estado]) == "") ? "Sin Estado" : trim($row_colaborador[estado]);
				$municipio_cliente = (trim($row_colaborador[municipio]) == "") ? "Sin Municipio" : trim($row_colaborador[municipio]);
				$calle_cliente = (trim($row_colaborador[calle_numero]) == "") ? "Sin Calle" : trim($row_colaborador[calle_numero]);
				$colonia_cliente = (trim($row_colaborador[colonia]) == "") ? "Sin Colonia" : trim($row_colaborador[colonia]);
				$cp_cliente = (trim($row_colaborador[cp]) == "") ? "N/A" : trim($row_colaborador[cp]);
				$nomenclatura_co = trim($row_colaborador[columna_b]);
				$puesto_actual = trim($row_colaborador[puesto_actual]);
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Colaborador|Pendiente|$puesto_actual";
		} else {
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Colaborador|Pendiente|Pendiente";
		}
	} elseif ($type_type == "Proveedor Info" || $type_type == "Transacciones") {

		$query_proveedor_info = "SELECT * FROM proveedores_info WHERE idproveedores_info = '$id_id'";
		$result_proveedor_info = mysql_query($query_proveedor_info);

		if (mysql_num_rows($result_proveedor_info) >= 1) {

			while ($row_proveedor_info = mysql_fetch_array($result_proveedor_info)) {
				$nombre = "$row_proveedor_info[nombre]";
				$apellidos = trim("$row_proveedor_info[apellidos]");
				$alias = trim("$row_proveedor_info[alias]");
				$telefono = (trim($row_proveedor_info[telefono_celular]) == "") ? "N/A" : trim($row_proveedor_info[telefono_celular]);
				$telefono_otro = (trim($row_proveedor_info[telefono_otro]) == "") ? "N/A" : trim($row_proveedor_info[telefono_otro]);
				$estado_cliente = (trim($row_proveedor_info[estado]) == "") ? "Sin Estado" : trim($row_proveedor_info[estado]);
				$municipio_cliente = (trim($row_proveedor_info[delmuni]) == "") ? "Sin Municipio" : trim($row_proveedor_info[delmuni]);
				$calle_cliente = (trim($row_proveedor_info[calle]) == "") ? "Sin Calle" : trim($row_proveedor_info[calle]);
				$colonia_cliente = (trim($row_proveedor_info[colonia]) == "") ? "Sin Colonia" : trim($row_proveedor_info[colonia]);
				$cp_cliente = (trim($row_proveedor_info[cp_cliente]) == "") ? "N/A" : trim($row_proveedor_info[codigo_postal]);
				$condicion_proveedor_info = trim("$row_proveedor_info[tipo]");
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Transacciones|$condicion_proveedor_info";
		} else {
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor Info|Pendiente";
		}
	} elseif ($type_type == "Prospectos") {

		$query_prospectos = "SELECT * FROM prospectos WHERE idprospectos = '$id_id'";
		$result_prospectos = mysql_query($query_prospectos);

		if (mysql_num_rows($result_prospectos) >= 1) {

			while ($row_prospectos = mysql_fetch_array($result_prospectos)) {
				$nombre = "$row_prospectos[nombre]";
				$apellidos = trim("$row_prospectos[apellidos]");
				$alias = trim("$row_prospectos[alias]");
				$telefono = trim("$row_prospectos[telefono_celular]");
				$telefono_otro = trim("$row_prospectos[telefono_otro]");
				$estado_cliente = trim("$row_prospectos[estado]");
				$municipio_cliente = trim("$row_prospectos[delmuni]");
				$calle_cliente = trim("$row_prospectos[colonia]");
				$colonia_cliente = trim("$row_prospectos[calle]");
				$cp_cliente = trim("$row_prospectos[codigo_postal]");
			}
			$concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Prospectos|Pendiente";
		} else {
			$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Prospectos|Pendiente";
		}
	} else {
		$concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente";
	}

	return $concatenacion;
}

#------------------------------------------Funcion Eliminar Tildes---------------------------------------------------------------------------------

function eliminar_tildes($cadena)
{

	$cadena = str_replace(
		array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
		array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
		$cadena
	);

	$cadena = str_replace(
		array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
		array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
		$cadena
	);

	$cadena = str_replace(
		array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
		array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
		$cadena
	);

	$cadena = str_replace(
		array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
		array('o', 'o', 'o', 'o', 'o', 'O', 'O', 'O'),
		$cadena
	);

	$cadena = str_replace(
		array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
		array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
		$cadena
	);

	$cadena = str_replace(
		array('ñ', 'Ñ', 'ç', 'Ç',),
		array('n', 'Ñ', 'c', 'C',),
		$cadena
	);

	return $cadena;
}

#-------------------------------------------Extraer VIN buscar vin --------------------------------------------------------------------------------

function date_vin($vin)
{

	$buscar_vin = CutterVin(trim($vin));

	$query_logistica_unidades = "SELECT * from inventario where TRIM(vin_numero_serie) LIKE '%$buscar_vin%' and TRIM(estatus_unidad) <> 'Utilitaria' and TRIM(estatus_unidad) <> 'Utilitario'";
	$result_query_logistica_unidades = mysql_query($query_logistica_unidades);

	if (mysql_num_rows($result_query_logistica_unidades) >= 1) {

		while ($row_query_logistica_unidades = mysql_fetch_array($result_query_logistica_unidades)) {
			$marca_logistica = trim($row_query_logistica_unidades[marca]);
			$version_logistica = trim($row_query_logistica_unidades[version]);
			$color_logistica = trim($row_query_logistica_unidades[color]);
			$modelo_logistica = trim($row_query_logistica_unidades[modelo]);
			$ver_vin = trim($row_query_logistica_unidades[vin_numero_serie]);
			$id_unidad = trim($row_query_logistica_unidades[idinventario]);
			$estatus_unidad = trim($row_query_logistica_unidades[estatus_unidad]);
		}

		$ver_vin = CutterVin($ver_vin);

		$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Unidad|$id_unidad|$estatus_unidad";
	} else {

		$query_logistica_trucks = "SELECT * from inventario_trucks where TRIM(vin_numero_serie) LIKE '%$buscar_vin%' and TRIM(estatus_unidad) <> 'Utilitaria' and TRIM(estatus_unidad) <> 'Utilitario'";
		$result_query_logistica_trucks = mysql_query($query_logistica_trucks);

		if (mysql_num_rows($result_query_logistica_trucks) >= 1) {
			while ($row_query_logistica_trucks = mysql_fetch_array($result_query_logistica_trucks)) {

				$marca_logistica = trim($row_query_logistica_trucks[marca]);
				$version_logistica = trim($row_query_logistica_trucks[version]);
				$color_logistica = trim($row_query_logistica_trucks[color]);
				$modelo_logistica = trim($row_query_logistica_trucks[modelo]);
				$ver_vin = trim($row_query_logistica_trucks[vin_numero_serie]);
				$id_unidad = trim($row_query_logistica_trucks[idinventario]);
				$estatus_unidad = trim($row_query_logistica_trucks[estatus_unidad]);
			}

			$ver_vin = CutterVin($ver_vin);

			$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Trucks|$id_unidad|$estatus_unidad";
		} else {

			$query_logistica_utilitario = "SELECT * from catalogo_unidades_utilitarios where TRIM(vin) LIKE '%$buscar_vin%' and visible = 'SI'";
			$result_query_logistica_utilitario = mysql_query($query_logistica_utilitario);

			if (mysql_num_rows($result_query_logistica_utilitario) >= 1) {

				while ($row_query_logistica_utilitario = mysql_fetch_array($result_query_logistica_utilitario)) {

					$marca_logistica = trim($row_query_logistica_utilitario[marca]);
					$version_logistica = trim($row_query_logistica_utilitario[version]);
					$color_logistica = trim($row_query_logistica_utilitario[color]);
					$modelo_logistica = trim($row_query_logistica_utilitario[modelo]);
					$ver_vin = trim($row_query_logistica_utilitario[vin]);
					$id_unidad = trim($row_query_logistica_utilitario[idcatalogo_unidades_utilitarios]);
				}

				$ver_vin = CutterVin($ver_vin);

				$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Utilitario|$id_unidad|Utilitaria";
			} else {

				$query_logistica_inventario = "SELECT * FROM orden_logistica_inventario WHERE TRIM(vin) LIKE '%$buscar_vin%' and visible = 'SI'";
				$result_logistica_inventario = mysql_query($query_logistica_inventario);

				if (mysql_num_rows($result_logistica_inventario) >= 1) {

					while ($row_logistica_inventario = mysql_fetch_array($result_logistica_inventario)) {
						$marca_logistica = trim($row_logistica_inventario[marca]);
						$version_logistica = trim($row_logistica_inventario[version]);
						$color_logistica = trim($row_logistica_inventario[color]);
						$modelo_logistica = trim($row_logistica_inventario[modelo]);
						$ver_vin = trim($row_logistica_inventario[vin]);
						$id_unidad = trim($row_logistica_inventario[idorden_logistica_inventario]);
					}

					$ver_vin = CutterVin($ver_vin);

					$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Indefinido|$id_unidad|Indefinido";
				} else {

					$marca_logistica = trim("Por definir");
					$version_logistica = trim("Por definir");
					$color_logistica = trim("Por definir");
					$modelo_logistica = trim("Por definir");
					$ver_vin = $buscar_vin;
					$id_unidad = trim("Por definir");

					$ver_vin = CutterVin($ver_vin);

					$result_vin = "$ver_vin|$marca_logistica|$version_logistica|$color_logistica|$modelo_logistica|Por Definir|$id_unidad|Por definir";
				}
			}
		}
	}

	return $result_vin;
}

#------------------------------------------- Cortar VIN --------------------------------------------------------------------------------

function CutterVin($vin)
{

	$vin = trim($vin);
	$tamanio_vin = strlen($vin);

	if ($tamanio_vin <= 8) {

		$new_vin = $vin;
	} else {

		$new_vin = substr($vin, -8);
	}

	return $new_vin;
}
#------------------------------------------- Letras Numeros --------------------------------------------------------------------------------

function unidad($numuero)
{
	switch ($numuero) {
		case 9: {
				$numu = "NUEVE ";
				break;
			}
		case 8: {
				$numu = "OCHO ";
				break;
			}
		case 7: {
				$numu = "SIETE ";
				break;
			}
		case 6: {
				$numu = "SEIS ";
				break;
			}
		case 5: {
				$numu = "CINCO ";
				break;
			}
		case 4: {
				$numu = "CUATRO";
				break;
			}
		case 3: {
				$numu = "TRES ";
				break;
			}
		case 2: {
				$numu = "DOS ";
				break;
			}
		case 1: {
				$numu = "UNO ";
				break;
			}
		case 0: {
				$numu = "";
				break;
			}
	}
	return $numu;
}

function decena($numdero)
{
	if ($numdero >= 90 && $numdero <= 99) {
		$numd = "NOVENTA ";
		if ($numdero > 90)
			$numd = $numd . "Y " . (unidad($numdero - 90));
	} else if ($numdero >= 80 && $numdero <= 89) {
		$numd = "OCHENTA ";
		if ($numdero > 80)
			$numd = $numd . "Y " . (unidad($numdero - 80));
	} else if ($numdero >= 70 && $numdero <= 79) {
		$numd = "SETENTA ";
		if ($numdero > 70)
			$numd = $numd . "Y " . (unidad($numdero - 70));
	} else if ($numdero >= 60 && $numdero <= 69) {
		$numd = "SESENTA ";
		if ($numdero > 60)
			$numd = $numd . "Y " . (unidad($numdero - 60));
	} else if ($numdero >= 50 && $numdero <= 59) {
		$numd = "CINCUENTA ";
		if ($numdero > 50)
			$numd = $numd . "Y " . (unidad($numdero - 50));
	} else if ($numdero >= 40 && $numdero <= 49) {
		$numd = "CUARENTA ";
		if ($numdero > 40)
			$numd = $numd . "Y " . (unidad($numdero - 40));
	} else if ($numdero >= 30 && $numdero <= 39) {
		$numd = "TREINTA ";
		if ($numdero > 30)
			$numd = $numd . "Y " . (unidad($numdero - 30));
	} else if ($numdero >= 20 && $numdero <= 29) {
		if ($numdero == 20)
			$numd = "VEINTE ";
		else
			$numd = "VEINTI" . (unidad($numdero - 20));
	} else if ($numdero >= 10 && $numdero <= 19) {
		switch ($numdero) {
			case 10: {
					$numd = "DIEZ ";
					break;
				}
			case 11: {
					$numd = "ONCE ";
					break;
				}
			case 12: {
					$numd = "DOCE ";
					break;
				}
			case 13: {
					$numd = "TRECE ";
					break;
				}
			case 14: {
					$numd = "CATORCE ";
					break;
				}
			case 15: {
					$numd = "QUINCE ";
					break;
				}
			case 16: {
					$numd = "DIECISEIS ";
					break;
				}
			case 17: {
					$numd = "DIECISIETE ";
					break;
				}
			case 18: {
					$numd = "DIECIOCHO ";
					break;
				}
			case 19: {
					$numd = "DIECINUEVE ";
					break;
				}
		}
	} else
		$numd = unidad($numdero);
	return $numd;
}

function centena($numc)
{
	if ($numc >= 100) {
		if ($numc >= 900 && $numc <= 999) {
			$numce = "NOVECIENTOS ";
			if ($numc > 900)
				$numce = $numce . (decena($numc - 900));
		} else if ($numc >= 800 && $numc <= 899) {
			$numce = "OCHOCIENTOS ";
			if ($numc > 800)
				$numce = $numce . (decena($numc - 800));
		} else if ($numc >= 700 && $numc <= 799) {
			$numce = "SETECIENTOS ";
			if ($numc > 700)
				$numce = $numce . (decena($numc - 700));
		} else if ($numc >= 600 && $numc <= 699) {
			$numce = "SEISCIENTOS ";
			if ($numc > 600)
				$numce = $numce . (decena($numc - 600));
		} else if ($numc >= 500 && $numc <= 599) {
			$numce = "QUINIENTOS ";
			if ($numc > 500)
				$numce = $numce . (decena($numc - 500));
		} else if ($numc >= 400 && $numc <= 499) {
			$numce = "CUATROCIENTOS ";
			if ($numc > 400)
				$numce = $numce . (decena($numc - 400));
		} else if ($numc >= 300 && $numc <= 399) {
			$numce = "TRESCIENTOS ";
			if ($numc > 300)
				$numce = $numce . (decena($numc - 300));
		} else if ($numc >= 200 && $numc <= 299) {
			$numce = "DOSCIENTOS ";
			if ($numc > 200)
				$numce = $numce . (decena($numc - 200));
		} else if ($numc >= 100 && $numc <= 199) {
			if ($numc == 100)
				$numce = "CIEN ";
			else
				$numce = "CIENTO " . (decena($numc - 100));
		}
	} else
		$numce = decena($numc);
	return $numce;
}

function miles($nummero)
{
	if ($nummero >= 1000 && $nummero < 2000) {
		$numm = "MIL " . (centena($nummero % 1000));
	}
	if ($nummero >= 2000 && $nummero < 10000) {
		$numm = unidad(Floor($nummero / 1000)) . " MIL " . (centena($nummero % 1000));
	}
	if ($nummero < 1000)
		$numm = centena($nummero);
	return $numm;
}

function decmiles($numdmero)
{
	if ($numdmero == 10000)
		$numde = "DIEZ MIL ";
	if ($numdmero > 10000 && $numdmero < 20000) {
		$numde = decena(Floor($numdmero / 1000)) . "MIL " . (centena($numdmero % 1000));
	}
	if ($numdmero >= 20000 && $numdmero < 100000) {
		$numde = decena(Floor($numdmero / 1000)) . "MIL " . (miles($numdmero % 1000));
	}
	if ($numdmero < 10000)
		$numde = miles($numdmero);
	return $numde;
}

function cienmiles($numcmero)
{
	if ($numcmero == 100000)
		$num_letracm = "CIEN MIL ";
	if ($numcmero >= 100000 && $numcmero < 1000000) {
		$num_letracm = centena(Floor($numcmero / 1000)) . "MIL " . (centena($numcmero % 1000));
	}
	if ($numcmero < 100000)
		$num_letracm = decmiles($numcmero);
	return $num_letracm;
}

function millon($nummiero)
{
	if ($nummiero >= 1000000 && $nummiero < 2000000) {
		$num_letramm = "UN MILLON " . (cienmiles($nummiero % 1000000));
	}
	if ($nummiero >= 2000000 && $nummiero < 10000000) {
		$num_letramm = unidad(Floor($nummiero / 1000000)) . " MILLONES " . (cienmiles($nummiero % 1000000));
	}
	if ($nummiero < 1000000)
		$num_letramm = cienmiles($nummiero);
	return $num_letramm;
}

function decmillon($numerodm)
{
	if ($numerodm == 10000000)
		$num_letradmm = "DIEZ MILLONES ";
	if ($numerodm > 10000000 && $numerodm < 20000000) {
		$num_letradmm = decena(Floor($numerodm / 1000000)) . "MILLONES " . (cienmiles($numerodm % 1000000));
	}
	if ($numerodm >= 20000000 && $numerodm < 100000000) {
		$num_letradmm = decena(Floor($numerodm / 1000000)) . "MILLONES " . (millon($numerodm % 1000000));
	}
	if ($numerodm < 10000000)
		$num_letradmm = millon($numerodm);
	return $num_letradmm;
}

function cienmillon($numcmeros)
{
	if ($numcmeros == 100000000)
		$num_letracms = "CIEN MILLONES ";
	if ($numcmeros >= 100000000 && $numcmeros < 1000000000) {
		$num_letracms = centena(Floor($numcmeros / 1000000)) . "MILLONES " . (millon($numcmeros % 1000000));
	}
	if ($numcmeros < 100000000)
		$num_letracms = decmillon($numcmeros);
	return $num_letracms;
}

function milmillon($nummierod)
{
	if ($nummierod >= 1000000000 && $nummierod < 2000000000) {
		$num_letrammd = "MIL " . (cienmillon($nummierod % 1000000000));
	}
	if ($nummierod >= 2000000000 && $nummierod < 10000000000) {
		$num_letrammd = unidad(Floor($nummierod / 1000000000)) . " MIL " . (cienmillon($nummierod % 1000000000));
	}
	if ($nummierod < 1000000000)
		$num_letrammd = cienmillon($nummierod);
	return $num_letrammd;
}

function convertir($numero, $t)
{
	$num = str_replace(",", "", $numero);
	$num = number_format($num, 2, '.', '');
	$cents = substr($num, strlen($num) - 2, strlen($num) - 1);
	$num = (int)$num;
	$numf = milmillon($num);

	if ($t == "USD") {
		return $numf . "" . $cents . " " . $t;
	} elseif ($t == "CAD") {
		return $numf . "" . $cents . " " . $t;
	} elseif ($t == "MXN") {
		return $numf . "PESOS " . $cents . "/100 M/N";
	}
}

#------------------------------------------- Departamento --------------------------------------------------------------------------------

function DepartamentoName($iddepartamento)
{

	$iddepartamento = trim($iddepartamento);

	$query_departamento = "SELECT * FROM catalogo_departamento WHERE idcatalogo_departamento = '$iddepartamento'";
	$result_departamento = mysql_query($query_departamento);

	if (mysql_num_rows($result_departamento) == 0) {

		$nombre_departamento = "Pendiente";
	} else {

		while ($row_departamento = mysql_fetch_array($result_departamento)) {

			$nombre_departamento = trim($row_departamento[nombre]);
		}
	}

	return $nombre_departamento;
}

#------------------------------------------- Tipo Orden  tipo --------------------------------------------------------------------------------

function OrdenName($idcatalogo_orden_logistica)
{

	$idcatalogo_orden_logistica = trim($idcatalogo_orden_logistica);

	$query_orden = "SELECT * FROM orden_logistica_tipo_orden WHERE idorden_logistica_tipo_orden = '$idcatalogo_orden_logistica'";
	$result_orden = mysql_query($query_orden);

	if (mysql_num_rows($result_orden) == 0) {

		$nombre_orden = "Pendiente";
	} else {

		while ($row_orden = mysql_fetch_array($result_orden)) {

			$nombre_orden = trim($row_orden[nombre]);
		}
	}

	return $nombre_orden;
}

#------------------------------------------- Costo Total Generar Logistica --------------------------------------------------------------------------------

function BalanceTotalCosto($opciones, $consulta_monto)
{

	$opciones = trim($opciones);
	$consulta_monto = trim($consulta_monto);

	$query_balance = "SELECT $opciones FROM balance_gastos_operacion where $consulta_monto";
	$result_balance = mysql_query($query_balance);

	if (mysql_num_rows($result_balance) == 0) {

		$costo_general = 0;
	} else {

		while ($row_balance = mysql_fetch_array($result_balance)) {

			$costo_general = $row_balance[monto_total];
		}
	}

	return $costo_general;
}

#------------------------------------------- Nombre Proveedor Balance de Gastos --------------------------------------------------------------------------------

function NombreProveedorBalance($idcompuesto)
{

	$idcompuesto = trim($idcompuesto);

	$query_normal_proveedor = "SELECT * FROM proveedores WHERE trim(idprovedores_compuesto) = '$idcompuesto'";
	$result_normal_proveedor = mysql_query($query_normal_proveedor);

	if (mysql_num_rows($result_normal_proveedor) >= 1) {

		while ($row_normal_proveedor = mysql_fetch_array($result_normal_proveedor)) {

			$name_proveedor_compuesto = (trim($row_normal_proveedor[apellidos]) == "") ? trim($row_normal_proveedor[nombre]) : trim($row_normal_proveedor[nombre]) . " " . trim($row_normal_proveedor[apellidos]);
		}
	} else {

		$query_temporal_proveedor = "SELECT * FROM orden_logistica_proveedores WHERE trim(idprovedores_compuesto) = '$idcompuesto'";
		$result_temporal_proveedor = mysql_query($query_temporal_proveedor);

		if (mysql_num_rows($result_temporal_proveedor) >= 1) {

			while ($row_temporal_proveedor = mysql_fetch_array($result_temporal_proveedor)) {

				$name_proveedor_compuesto = (trim($row_temporal_proveedor[apellidos]) == "") ? trim($row_temporal_proveedor[nombre]) : trim($row_temporal_proveedor[nombre]) . " " . trim($row_temporal_proveedor[apellidos]);
			}
		} else {

			$name_proveedor_compuesto = "Pendiente";
		}
	}

	return $name_proveedor_compuesto;
}

#------------------------------------------- Estatus Principal --------------------------------------------------------------------------------

function EstatusPrincipalLogistica($idlogistica)
{

	$idlogistica = trim($idlogistica);

	$query_status_logistica = "SELECT * FROM orden_logistica_bitacora WHERE visible = 'SI' and idorden_logistica = '$idlogistica' and valor = '1' order by idorden_logistica_bitacora DESC limit 1";
	$result_status_logistica = mysql_query($query_status_logistica);

	while ($row_status_logistica = mysql_fetch_array($result_status_logistica)) {

		$estatus_principal = $row_status_logistica[tipo];
	}

	return $estatus_principal;
}

#------------------------------------------- usuario creador usuario --------------------------------------------------------------------------------

function NameUsuarioCreador($id_user_create)
{

	$id_user_create = trim($id_user_create);
	$nombre_usuario_creador = '';
	unset($nombre_usuario_creador);

	$query_usuario_creador = "SELECT * FROM usuarios WHERE idusuario = '$id_user_create'";
	$result_usuario_creador = mysql_query($query_usuario_creador);

	while ($row_usuario_creador = mysql_fetch_array($result_usuario_creador)) {

		$search_name_create = nombres_datos($row_usuario_creador[idempleados], "Colaborador");
		$porciones_create = explode("|", $search_name_create);

		$nombre_usser_complete = $porciones_create[10];
		$nomenclatura_usser_complete = $porciones_create[2];
		$rol_usser_complete = $porciones_create[2];
		$numero_usser_creador = $porciones_create[3];

		$rol_loguin_actual = trim($row_usuario_creador[rol]);

		$nombre_usuario_creador = "$nombre_usser_complete|$nomenclatura_usser_complete|$rol_usser_complete|$numero_usser_creador|$rol_loguin_actual";
	}

	return $nombre_usuario_creador;
}

#----------------------------------------------------------Consultar BITACORA WALLET-------------------------------------------------------------------------------------------

function ConsultarBitacoraWallet($tipo, $egreso_ingreso, $referencia_wallet_entrega_recepcion)
{

	$tipo = trim($tipo);
	$egreso_ingreso = trim($egreso_ingreso);
	$referencia_wallet_entrega_recepcion = trim($referencia_wallet_entrega_recepcion);


	$query_recibo = "SELECT * FROM wallet_bitacora WHERE visible = 'SI' and tipo = '$tipo' and columna_b = '$egreso_ingreso' and referencia = '$referencia_wallet_entrega_recepcion'";
	$result_recibo = mysql_query($query_recibo);

	return mysql_num_rows($result_recibo);
}
#------------------------------------------- CONSULTAR REFERENCIA BITACORA RECURSO --------------------------------------------------------------------------------

function ConsultarReferenciaSeguimiento($referencia_seguimiento)
{

	$referencia_seguimiento = trim($referencia_seguimiento);

	$query_si_referencia_wallet = "SELECT * FROM empleados_wallet WHERE trim(referencia_seguimiento) = '$referencia_seguimiento'";
	$result_si_referencia_wallet = mysql_query($query_si_referencia_wallet);

	if (mysql_num_rows($result_si_referencia_wallet) >= 1) {

		$query_ref_seguimiento = "SELECT * FROM empleados_wallet_referencia_bitacora WHERE trim(referencia_seguimiento) = '$referencia_seguimiento' and visible = 'SI'";
		$result_ref_seguimiento = mysql_query($query_ref_seguimiento);

		$valor_referencia_bitacora = mysql_num_rows($result_ref_seguimiento);
		#--------------------------------------------------------------------

		$query_tesorerias_egresos_ingresos = "SELECT * FROM estado_cuenta_tesorerias_egresos_ingresos WHERE visible = 'SI' and ( referencia = '$referencia_seguimiento' || referencia_seguimiento = '$referencia_seguimiento' )";
		$result_tesorerias_egresos_ingresos = mysql_query($query_tesorerias_egresos_ingresos);

		$valor_tesorerias_egresos_ingresos = mysql_num_rows($result_tesorerias_egresos_ingresos);
		#----------------------------------------------------------------------------------------

		$valores_tesoreria = intval($valor_referencia_bitacora) + intval($valor_tesorerias_egresos_ingresos);

		if (intval($valores_tesoreria) == 0 || intval($valores_tesoreria) == 1 || $valores_tesoreria == "") {

			$respuesta_referencia_tesoreria = "Pendiente";
		} elseif (intval($valores_tesoreria) == 2) {

			$respuesta_referencia_tesoreria = "Aplicado";
		} elseif (intval($valores_tesoreria) >= 3) {

			$respuesta_referencia_tesoreria = "Movimientos Duplicados";
		}
	} else {

		$respuesta_referencia_tesoreria = "N/A";
	}

	return $respuesta_referencia_tesoreria;
}

#------------------------------------------- Carpeta Rol Usuario Loguin --------------------------------------------------------------------------------

function CarpetasRol($rol_usuario)
{

	$rol_usuario = trim($rol_usuario);

	if ($rol_usuario == 3) {

		$carpeta_menu = "../Credito_Cobranza/menu.php";
		$carpeta_index = "../Credito_Cobranza/index.php";
	} elseif ($rol_usuario == 4) {

		$carpeta_menu = "../Fuerza_Ventas/menu.php";
		$carpeta_index = "../Fuerza_Ventas/index.php";
	} elseif ($rol_usuario == 40) {

		$carpeta_menu = "../Gerencia_Cobranza/menu.php";
		$carpeta_index = "../Gerencia_Cobranza/index.php";
	} elseif ($rol_usuario == 5) {

		$carpeta_menu = "../Atencion_Clientes/menu.php";
		$carpeta_index = "../Atencion_Clientes/index.php";
	} elseif ($rol_usuario == 6) {

		$carpeta_menu = "../Coordinacion_Administrativa/menu.php";
		$carpeta_index = "../Coordinacion_Administrativa/index.php";
	} elseif ($rol_usuario == 7) {

		$carpeta_menu = "../Evaluacion_Diagnostico/menu.php";
		$carpeta_index = "../Evaluacion_Diagnostico/index.php";
	} elseif ($rol_usuario == 8) {

		$carpeta_menu = "../Administracion_Ventas/menu.php";
		$carpeta_index = "../Administracion_Ventas/index.php";
	} elseif ($rol_usuario == 150) {

		$carpeta_menu = "../Seguimiento_Individual/menu.php";
		$carpeta_index = "../Seguimiento_Individual/index.php";
	} elseif ($rol_usuario == 700) {

		$carpeta_menu = "../Administracion_Compras/menu.php";
		$carpeta_index = "../Administracion_Compras/index.php";
	} elseif ($rol_usuario == "root") {

		$carpeta_menu = "../Reportes/menu.php";
		$carpeta_index = "../Reportes/index.php";
	} elseif ($rol_usuario == "20") {

		$carpeta_menu = "../Consulta_Fuerza_Ventas/menu.php";
		$carpeta_index = "../Consulta_Fuerza_Ventas/index.php";
	} elseif ($rol_usuario == "500") {

		$carpeta_menu = "../Informativo/menu.php";
		$carpeta_index = "../Informativo/index.php";
	} elseif ($rol_usuario == "600") {

		$carpeta_menu = "../Inventario_Completo/menu.php";
		$carpeta_index = "../Inventario_Completo/index.php";
	} elseif ($rol_usuario == "800") {

		$carpeta_menu = "../Mercadotecnia/menu.php";
		$carpeta_index = "../Mercadotecnia/index.php";
	} elseif ($rol_usuario == "1200") {

		$carpeta_menu = "../Recursos_Humanos/menu.php";
		$carpeta_index = "../Recursos_Humanos/index.php";
	} elseif ($rol_usuario == 15) {

		$carpeta_menu = "../Administracion_Compras/menu.php";
		$carpeta_index = "../Administracion_Compras/index.php";
	} elseif ($rol_usuario == "50") {

		$carpeta_menu = "../Caja_Chica/menu.php";
		$carpeta_index = "../Caja_Chica/index.php";
	} elseif ($rol_usuario == 900) {

		$carpeta_menu = "../Inventario/menu.php";
		$carpeta_index = "../Inventario/index.php";
	} elseif ($rol_usuario == 1300) {

		$carpeta_menu = "../Gestion_Financiera/menu.php";
		$carpeta_index = "../Gestion_Financiera/index.php";
	} elseif ($rol_usuario == 1301) {

		$carpeta_menu = "../Logistica_Interna/menu.php";
		$carpeta_index = "../Logistica_Interna/index.php";
	} elseif ($rol_usuario == 16) {

		$carpeta_menu = "../Relaciones/menu.php";
		$carpeta_index = "../Relaciones/index.php";
	} else if ($rol_usuario == 2000) {

		$carpeta_menu = "../Inventario_Refacciones/menu.php";
		$carpeta_index = "../Inventario_Refacciones/index.php";
	} else if ($rol_usuario == "VET") {

		$carpeta_menu = "../Vendedores_Externos_Trucks/menu.php";
		$carpeta_index = "../Vendedores_Externos_Trucks/index.php";
	} else if ($rol_usuario == "TEMP@ME") {

		$carpeta_menu = "../Movimiento_Exitoso/menu.php";
		$carpeta_index = "../Movimiento_Exitoso/index.php";
	} else if ($rol_usuario == "100") {

		$carpeta_menu = "../Logistica/menu.php";
		$carpeta_index = "../Logistica/index.php";
	} else if ($rol_usuario == "101") {

		$carpeta_menu = "../Generar_Logistica/menu.php";
		$carpeta_index = "../Generar_Logistica/index.php";
	} else if ($rol_usuario == "102") {

		$carpeta_menu = "../Ejecutivos_Traslado/menu.php";
		$carpeta_index = "../Ejecutivos_Traslado/index.php";
	} else if ($rol_usuario == '17') {

		$carpeta_menu = "../Admon_Compras/menu.php";
		$carpeta_index = "../Admon_Compras/index.php";
	} else if ($rol_usuario == 'GEXT') {

		$carpeta_menu = "../Gestoria_Externa/menu.php";
		$carpeta_index = "../Gestoria_Externa/index.php";
	} else if ($rol_usuario == 'CONTABILIDAD') {

		$carpeta_menu = "../Contabilidad/menu.php";
		$carpeta_index = "../Contabilidad/index.php";
	} else if ($rol_usuario == 'OTC') {

		$carpeta_menu = "../Ordenes_Talleres_Clientes/menu.php";
		$carpeta_index = "../Ordenes_Talleres_Clientes/index.php";
	} else if ($rol_usuario == 'AdmonVentas') {

		$carpeta_menu = "../Admon_Ventas/menu.php";
		$carpeta_index = "../Admon_Ventas/index.php";
	} else if ($rol_usuario == 'IEC') {

		$carpeta_menu = "../Inventario_Estatus_Cambios/menu.php";
		$carpeta_index = "../Inventario_Estatus_Cambios/index.php";
	} else if ($rol_usuario == 'Prospectos') {

		$carpeta_menu = "../Prospectos/menu.php";
		$carpeta_index = "../Prospectos/index.php";
	} else if ($rol_usuario == 'Reg. Exp. VIN') {

		$carpeta_menu = "../Exp_VIN/menu.php";
		$carpeta_index = "../Exp_VIN/index.php";
	} else if ($rol_usuario == 'JACKO') {

		$carpeta_menu = "../Desarrollo_Jacko/menu.php";
		$carpeta_index = "../Desarrollo_Jacko/index.php";
	} else if ($rol_usuario == 'Cartera Contactos') {

		$carpeta_menu = "../Cartera_Contactos/menu.php";
		$carpeta_index = "../Cartera_Contactos/index.php";
	} else if ($rol_usuario == 'Ordenes Talleres') {

		$carpeta_menu = "../Ordenes_Talleres/menu.php";
		$carpeta_index = "../Ordenes_Talleres/index.php";
	} else if ($rol_usuario == 'LEGAL') {

		$carpeta_menu = "../Legal/menu.php";
		$carpeta_index = "../Legal/index.php";
	} else if ($rol_usuario == 'Movimientos_Credito_Cobranza') {

		$carpeta_menu = "../Movimientos_Credito_Cobranza/menu.php";
		$carpeta_index = "../Movimientos_Credito_Cobranza/index.php";
	} else if ($rol_usuario == 'Comisiones') {

		$carpeta_menu = "../Comisiones/menu.php";
		$carpeta_index = "../Comisiones/index.php";
	} else if ($rol_usuario == '103') {

		$carpeta_menu = "../Encargado_Piso/menu.php";
		$carpeta_index = "../Encargado_Piso/index.php";
	} else if ($rol_usuario == 'DualTrucks') {

		$carpeta_menu = "../DualTrucks/menu.php";
		$carpeta_index = "../DualTrucks/index.php";
	} else if ($rol_usuario == 'New_User') {

		$carpeta_menu = "../New_User/menu.php";
		$carpeta_index = "../New_User/index.php";
	} else if ($rol_usuario == 'orden_compra') {

		$carpeta_menu = "../orden_compra/menu.php";
		$carpeta_index = "../orden_compra/index.php";
	} else if ($rol_usuario == 'Gerencia_Trucks') {

		$carpeta_menu = "../Gerencia_Trucks/menu.php";
		$carpeta_index = "../Gerencia_Trucks/index.php";
	} else if ($rol_usuario == 'Orden_Proveedores_Admon_Compras') {

		$carpeta_menu = "../Orden_Proveedores_Admon_Compras/menu.php";
		$carpeta_index = "../Orden_Proveedores_Admon_Compras/index.php";
	} else if ($rol_usuario == 'Tesorerias') {

		$carpeta_menu = "../Tesorerias/menu.php";
		$carpeta_index = "../Tesorerias/index.php";
	} else if ($rol_usuario == 'Ordenes_Proveedores_Detallado') {

		$carpeta_menu = "../Ordenes_Proveedores_Detallado/menu.php";
		$carpeta_index = "../Ordenes_Proveedores_Detallado/index.php";
	} else if ($rol_usuario == 'Inventario_Bajas') {

		$carpeta_menu = "../Inventario_Bajas/menu.php";
		$carpeta_index = "../Inventario_Bajas/index.php";
	} else if ($rol_usuario == 'Inventario_Historial') {

		$carpeta_menu = "../Inventario_Historial/menu.php";
		$carpeta_index = "../Inventario_Historial/index.php";
	} else if ($rol_usuario == 'Costo_total_VIN') {

		$carpeta_menu = "../Costo_total_VIN/menu.php";
		$carpeta_index = "../Costo_total_VIN/index.php";
	} else if ($rol_usuario == 'Chat_Panamotors') {

		$carpeta_menu = "../Chat_Panamotors/menu.php";
		$carpeta_index = "../Chat_Panamotors/index.php";
	} else if ($rol_usuario == 'Inventario_Admin') {

		$carpeta_menu = "../Inventario_Admin/menu.php";
		$carpeta_index = "../Inventario_Admin/index.php";
	} else if ($rol_usuario == 'Inventario_Cortes') {

		$carpeta_menu = "../Inventario_Cortes/menu.php";
		$carpeta_index = "../Inventario_Cortes/index.php";
	} else if ($rol_usuario == 'Plantilla_CCP_Nueva') {

		$carpeta_menu = "../Plantilla_CCP_Nueva/menu.php";
		$carpeta_index = "../Plantilla_CCP_Nueva/index.php";
	} else if ($rol_usuario == 'Cartera_Fuerza_Ventas') {

		$carpeta_menu = "../Cartera_Fuerza_Ventas/menu.php";
		$carpeta_index = "../Cartera_Fuerza_Ventas/index.php";
	} else if ($rol_usuario == 'Movimiento_Exitoso_General') {

		$carpeta_menu = "../Movimiento_Exitoso_General/menu.php";
		$carpeta_index = "../Movimiento_Exitoso_General/index.php";
	} else if ($rol_usuario == 'Credito_Cobranza') {

		$carpeta_menu = "../Credito_Cobranza/menu.php";
		$carpeta_index = "../Credito_Cobranza/index.php";
	} else if ($rol_usuario == 'Ordenes_Proveedores_Clientes') {

		$carpeta_menu = "../Ordenes_Proveedores_Clientes/menu.php";
		$carpeta_index = "../Ordenes_Proveedores_Clientes/index.php";
	} else if ($rol_usuario == 'Proveedores_Transacciones') {

		$carpeta_menu = "../Proveedores_Transacciones/menu.php";
		$carpeta_index = "../Proveedores_Transacciones/index.php";
	} else if ($rol_usuario == 'Proveedores_Prestamos') {

		$carpeta_menu = "../Proveedores_Prestamos/menu.php";
		$carpeta_index = "../Proveedores_Prestamos/index.php";
	} else if ($rol_usuario == 'Proveedores_Bienes_Raices') {

		$carpeta_menu = "../Proveedores_Bienes_Raices/menu.php";
		$carpeta_index = "../Proveedores_Bienes_Raices/index.php";
	} else if ($rol_usuario == 'Admon_Compras') {

		$carpeta_menu = "../Admon_Compras/menu.php";
		$carpeta_index = "../Admon_Compras/index.php";
	} else if ($rol_usuario == 'Reportes_ejecutivos') {

		$carpeta_menu = "../Reportes_ejecutivos/menu.php";
		$carpeta_index = "../Reportes_ejecutivos/index.php";
	} else if ($rol_usuario == 'Admon_Edo_Cuenta') {

		$carpeta_menu = "../Admon_Edo_Cuenta/menu.php";
		$carpeta_index = "../Admon_Edo_Cuenta/index.php";
	} else if ($rol_usuario == 'Comprobantes_egresos') {

		$carpeta_menu = "../Comprobantes_egresos/menu.php";
		$carpeta_index = "../Comprobantes_egresos/index.php";
	} else if ($rol_usuario == 'Solicitud_Compra') {

		$carpeta_menu = "../Solicitud_Compra/menu.php";
		$carpeta_index = "../Solicitud_Compra/index.php";
	} else if ($rol_usuario == 'Wallet') {

		$carpeta_menu = "../Wallet/menu.php";
		$carpeta_index = "../Wallet/index.php";
	} else if ($rol_usuario == 'Inventario_souvenir_vin') {

		$carpeta_menu = "../Inventario_souvenir_vin/menu.php";
		$carpeta_index = "../Inventario_souvenir_vin/index.php";
	} else if ($rol_usuario == 'Gerencia_Cobranza') {

		$carpeta_menu = "../Gerencia_Cobranza/menu.php";
		$carpeta_index = "../Gerencia_Cobranza/index.php";
	} else if ($rol_usuario == 'Vista_Previa_Movimiento_Exitoso') {

		$carpeta_menu = "../Vista_Previa_Movimiento_Exitoso/menu.php";
		$carpeta_index = "../Vista_Previa_Movimiento_Exitoso/index.php";
	} else if ($rol_usuario == 'Biografia_VIN') {

		$carpeta_menu = "../Biografia_VIN/menu.php";
		$carpeta_index = "../Biografia_VIN/index.php";
	}

	return $carpeta_menu . "|" . $carpeta_index;
}

#------------------------------------------- Funcion Estatus Tesoreria --------------------------------------------------------------------------------

function Estatus_CobranzaFuncion($referencia_seguimiento)
{

	$referencia_seguimiento = trim($referencia_seguimiento);

	$query_si_referencia_wallet = "SELECT * FROM empleados_wallet WHERE trim(referencia_seguimiento) = '$referencia_seguimiento'";
	$result_si_referencia_wallet = mysql_query($query_si_referencia_wallet);

	if (mysql_num_rows($result_si_referencia_wallet) >= 1) {

		$query_recurso_cobranza = "SELECT * FROM estado_cunta_tesorerias_traspasos WHERE visible = 'SI' and referencia = '$referencia_seguimiento' ";
		$result_recurso_cobranza = mysql_query($query_recurso_cobranza);

		if (mysql_num_rows($result_recurso_cobranza) == 0) {

			$query_estado_cuenta_proveedores = "SELECT * FROM estado_cuenta_proveedores WHERE visible = 'SI' AND ( trim(referencia) = '$referencia_seguimiento' || trim(col1) = '$referencia_seguimiento' ) ";
			$result_estado_cuenta_proveedores = mysql_query($query_estado_cuenta_proveedores);

			$respuesta_referencia_cobranza = (mysql_num_rows($result_estado_cuenta_proveedores) == 0) ? "Pendiente" : "Entregado";
		} else {

			while ($row_recurso_cobranza = mysql_fetch_array($result_recurso_cobranza)) {

				if (trim($row_recurso_cobranza[estatus]) == "Usado") {

					$respuesta_referencia_cobranza = "Entregado";
				} else {

					$query_estado_cuenta_proveedores = "SELECT * FROM estado_cuenta_proveedores WHERE visible = 'SI' AND ( trim(referencia) = '$referencia_seguimiento' || trim(col1) = '$referencia_seguimiento' ) ";
					$result_estado_cuenta_proveedores = mysql_query($query_estado_cuenta_proveedores);

					$respuesta_referencia_cobranza = (mysql_num_rows($result_estado_cuenta_proveedores) == 0) ? "Pendiente" : "Entregado";
				}
			}
		}
	} else {

		$respuesta_referencia_cobranza = "N/A";
	}

	return $respuesta_referencia_cobranza;
}

#------------------------------------------- Hoy no circula --------------------------------------------------------------------------------

function HoyCirculasCDMX($matricula, $engomado)
{

	$matricula = trim($matricula);

	#---------TRATAR MATRICULA SOLO NUMEROS----------------------------

	$arr_matricula = str_split($matricula);

	foreach ($arr_matricula as $valor_matricula) {

		if (is_numeric($valor_matricula)) {
			$var_matricula_numero .= $valor_matricula;
		}
	}


	$ultimo_digito = (is_numeric($var_matricula_numero)) ? substr($var_matricula_numero, -1) : "N";

	#---------CONDICIONES POR DIA ----------------------------

	$fecha_actual_hoy = date("l");

	if ($fecha_actual_hoy == "Monday") {

		$primer_numero = 5;
		$segundo_numero = 6;
		$color_restringido = "AMARILLO";
	} else if ($fecha_actual_hoy == "Tuesday") {

		$primer_numero = 7;
		$segundo_numero = 8;
		$color_restringido = "ROSA";
	} else if ($fecha_actual_hoy == "Wednesday") {

		$primer_numero = 3;
		$segundo_numero = 4;
		$color_restringido = "ROJO";
	} else if ($fecha_actual_hoy == "Thursday") {

		$primer_numero = 1;
		$segundo_numero = 2;
		$color_restringido = "VERDE";
	} else if ($fecha_actual_hoy == "Friday") {

		$primer_numero = 9;
		$segundo_numero = 0;
		$color_restringido = "AZUL";
	} else if ($fecha_actual_hoy == "Saturday") {
	} else if ($fecha_actual_hoy == "Sunday") {
	}

	#---------Operaciones POR DIA ----------------------------

	if (is_numeric($ultimo_digito)) {

		if ($ultimo_digito == $primer_numero || $ultimo_digito == $segundo_numero) {

			$result_validar .= "Hoy NO circulan <b>$primer_numero y $segundo_numero</b><br>";

			if ($engomado == $color_restringido) {

				$result_validar .= "Hoy NO circula por <b>engomado</b><br>";
			} elseif ($engomado == "") {

				$result_validar .= "Puedes Circular con permiso<br>";
			}
		} elseif ($ultimo_digito == "") {

			$result_validar .= "Puedes Circular con permiso<br>";

			if ($engomado == $color_restringido) {

				$result_validar .= "Hoy NO circula por <b>engomado</b><br>";
			} elseif ($engomado == "") {

				$result_validar .= "Puedes Circular con permiso<br>";
			}
		} else {

			if ($engomado == $color_restringido) {

				$result_validar .= "Hoy NO circula por <b>engomado</b><br>";
			} elseif ($engomado == "") {

				$result_validar .= "Puedes Circular con permiso<br>";
			}
		}
	} elseif ($ultimo_digito == "") {

		$result_validar .= "Pendiente<br>";
	} else {

		$result_validar .= "Pendiente<br>";
	}

	return $result_validar;
}

#------------------------------------------- Verificacion vehicular verificacion --------------------------------------------------------------------------------

function VerificacionVehicular($engomado)
{

	$engomado = trim($engomado);
	$mes_actual_hoy = date('n');
	$anio_siguiente = date('Y') + 1;


	if ($engomado == "" || is_numeric($engomado) || $engomado == "Pendiente" || $engomado == "PENDIENTE" || $engomado == "POR DEFINIR") {

		$mensaje_verificacion = "No hay engomado para mostrar información";
	} elseif ($engomado == "N/A" || $engomado == "NA") {

		$mensaje_verificacion = "No aplica verificación";
	} else {

		if ($engomado == "AMARILLO") {

			if ($mes_actual_hoy >= 1 and $mes_actual_hoy <= 2) {

				$mensaje_verificacion = "Próxima verificación <b>Enero - Febrero</b>";
			} else if ($mes_actual_hoy >= 3 and $mes_actual_hoy <= 8) {

				$mensaje_verificacion = "Próxima verificación <b>Julio - Agosto</b>";
			} else {

				$mensaje_verificacion = "Próxima verificación <b>Enero - Febrero</b> de $anio_siguiente";
			}
		} else if ($engomado == "ROSA") {

			if ($mes_actual_hoy >= 1 and $mes_actual_hoy <= 3) {

				$mensaje_verificacion = "Próxima verificación <b>Febrero - Marzo</b>";
			} else if ($mes_actual_hoy >= 4 and $mes_actual_hoy <= 9) {

				$mensaje_verificacion = "Próxima verificación <b>Agosto - Septiembre</b>";
			} else {

				$mensaje_verificacion = "Próxima verificación <b>Febrero - Marzo</b> de $anio_siguiente";
			}
		} else if ($engomado == "ROJO") {

			if ($mes_actual_hoy >= 1 and $mes_actual_hoy <= 4) {

				$mensaje_verificacion = "Próxima verificación <b>Marzo - Abril</b>";
			} else if ($mes_actual_hoy >= 5 and $mes_actual_hoy <= 10) {

				$mensaje_verificacion = "Próxima verificación <b>Agosto - Septiembre</b>";
			} else {

				$mensaje_verificacion = "Próxima verificación <b>Marzo - Abril</b> de $anio_siguiente";
			}
		} else if ($engomado == "VERDE") {

			if ($mes_actual_hoy >= 1 and $mes_actual_hoy <= 5) {

				$mensaje_verificacion = "Próxima verificación <b>Abril - Mayo</b>";
			} else if ($mes_actual_hoy >= 6 and $mes_actual_hoy <= 11) {

				$mensaje_verificacion = "Próxima verificación <b>Octubre - Noviembre</b>";
			} else {

				$mensaje_verificacion = "Próxima verificación <b>Abril - Mayo</b> de $anio_siguiente";
			}
		} elseif ($engomado == "AZUL") {

			if ($mes_actual_hoy >= 1 && $mes_actual_hoy <= 6) {

				$mensaje_verificacion = "Próxima verificación <b>Mayo - Junio</b>";
			} else {

				$mensaje_verificacion = "Próxima verificación <b>Noviembre - Diciembre</b>";
			}
		}
	}

	return $mensaje_verificacion;
}

#------------------------------------------- Estatus Recurso estatus --------------------------------------------------------------------------------

function EstatusRecursoFuncion($referencia_seguimiento, $idorden_logistica_recurso)
{

	$referencia_seguimiento = trim($referencia_seguimiento);
	$idorden_logistica_recurso = trim($idorden_logistica_recurso);

	$query_estatus_recurso = "SELECT * FROM wallet_bitacora WHERE visible = 'SI' AND trim(referencia) = '$referencia_seguimiento' AND trim(tipo) = 'Validación Recurso' ";
	$result_estatus_recurso = mysql_query($query_estatus_recurso);

	if (mysql_num_rows($result_estatus_recurso) == 0) {

		$query_estatus_old_recurso = "SELECT * FROM orden_logistica_recurso WHERE idorden_logistica_recurso = '$idorden_logistica_recurso'";
		$result_estatus_old_recurso = mysql_query($query_estatus_old_recurso);

		if (mysql_num_rows($result_estatus_old_recurso) == 0) {

			$recurso_estatus = "Pendiente";
		} else {

			while ($row_estatus_old_recurso = mysql_fetch_array($result_estatus_old_recurso)) {

				$recurso_estatus = trim($row_estatus_old_recurso[estatus]);
			}
		}
	} else {

		$recurso_estatus = "Confirmado";
	}

	return $recurso_estatus;
}

#------------------------------------------- Token Ultimo token --------------------------------------------------------------------------------

function TokenWalletUltimo($referencia_seguimiento)
{

	$referencia_seguimiento = trim($referencia_seguimiento);

	$query_token_wallet = "SELECT * FROM empleados_wallet where visible = 'SI' AND referencia_seguimiento = '$referencia_seguimiento' ORDER BY idempleados_wallet DESC LIMIT 1";
	$result_token_wallet = mysql_query($query_token_wallet);

	if (mysql_num_rows($result_token_wallet) >= 1) {

		while ($row_token_wallet = mysql_fetch_array($result_token_wallet)) {

			$respuesta_token_wallet = trim($row_token_wallet[token]);
		}
	} else {

		$respuesta_token_wallet = "N/A";
	}

	return $respuesta_token_wallet;
}

#------------------------------------------- Referencia wallet referencia --------------------------------------------------------------------------------

function ReferenciaVisiblesWallet($referencia_seguimiento)
{

	$referencia_seguimiento = trim($referencia_seguimiento);

	$query_referencia_visibles = "SELECT * FROM empleados_wallet WHERE visible = 'SI' AND trim(referencia_seguimiento) = '$referencia_seguimiento' LIMIT 1";
	$result_referencia_visibles = mysql_query($query_referencia_visibles);

	if (mysql_num_rows($result_referencia_visibles) == 0) {

		$referencia_seguimiento = $referencia_seguimiento;
	} else {

		while ($row_referencia_visibles = mysql_fetch_array($result_referencia_visibles)) {

			$referencia_seguimiento = trim($row_referencia_visibles[referencia_seguimiento]);
		}
	}

	return $referencia_seguimiento;
}

#------------------------------------------- Buscar Tarjeta buscar --------------------------------------------------------------------------------

function SearchCard($busqueda_6, $busqueda_4, $tipo_tarjeta)
{

	$busqueda_6 = trim($busqueda_6);
	$busqueda_4 = trim($busqueda_4);
	$tipo_tarjeta = trim($tipo_tarjeta);

	$query_busqueda_tarjeta = "SELECT * FROM catalogo_monederos_electronicos WHERE LEFT(no_tarjeta, 6) = '$busqueda_6' and RIGHT(no_tarjeta, 4) = '$busqueda_4' AND nombre_tarjeta = '$tipo_tarjeta';";
	$result_busqueda_tarjeta = mysql_query($query_busqueda_tarjeta);


	if (mysql_num_rows($result_busqueda_tarjeta) == 0) {

		$mensaje_tarjeta = "Error| no se encontro en el catálogo| no se encontro en el catálogo";
	} else if (mysql_num_rows($result_busqueda_tarjeta) == 1) {

		while ($row_busqueda_tarjeta = mysql_fetch_array($result_busqueda_tarjeta)) {

			$num_tarjeta .= chunk_split($row_busqueda_tarjeta[no_tarjeta], 4, " ");

			if (trim($row_busqueda_tarjeta[idempleados]) == "" || trim($row_busqueda_tarjeta[idempleados]) == null || trim($row_busqueda_tarjeta[idempleados]) == "N/A") {

				$nomenclatura_responsable_tarjeta = "N/A";
			} elseif (is_numeric($row_busqueda_tarjeta[idempleados])) {

				$buscar_responsable = explode("|", nombres_datos($row_busqueda_tarjeta[idempleados], "Colaborador"));
				$nomenclatura_responsable_tarjeta = "$buscar_responsable[10] - $buscar_responsable[2]";
			} else {

				$nomenclatura_responsable_tarjeta = $row_busqueda_tarjeta[idempleados];
			}


			$responsable_tarjeta = explode("|", nombres_datos($id_id, $type_type));

			$mensaje_tarjeta = "$row_busqueda_tarjeta[no_tarjeta]|$num_tarjeta|$nomenclatura_responsable_tarjeta";
		}
	} else if (mysql_num_rows($result_busqueda_tarjeta) >= 2) {

		while ($row_busqueda_tarjeta = mysql_fetch_array($result_busqueda_tarjeta)) {

			$concatenar_num_tarjeta .= chunk_split($row_busqueda_tarjeta[no_tarjeta], 4, " ") . ",";


			if (trim($row_busqueda_tarjeta[idempleados]) == "" || trim($row_busqueda_tarjeta[idempleados]) == null || trim($row_busqueda_tarjeta[idempleados]) == "N/A") {

				$nomenclatura_responsable_tarjeta .= "N/A,";
			} elseif (is_numeric($row_busqueda_tarjeta[idempleados])) {

				$buscar_responsable = explode("|", nombres_datos($row_busqueda_tarjeta[idempleados], "Colaborador"));
				$nomenclatura_responsable_tarjeta .= "$buscar_responsable[10] - $buscar_responsable[2],";
			} else {

				$nomenclatura_responsable_tarjeta .= "$row_busqueda_tarjeta[idempleados],";
			}
		}

		$num_tarjeta = substr($concatenar_num_tarjeta, 0, -1);
		$nomenclatura_responsable_tarjeta = substr($nomenclatura_responsable_tarjeta, 0, -1);

		$mensaje_tarjeta = "Error| se debe de ajustar el algoritmo ya que se encontraron: " . mysql_num_rows($result_busqueda_tarjeta) . " coincedencias <b>$num_tarjeta<b>|$nomenclatura_responsable_tarjeta";
	}

	return $mensaje_tarjeta;
}

#------------------------------------------- Buscar tarjeta buscar card buscar monedero buscar monedero electronico buscar --------------------------------------------------------------------------------

function BuscarMonederoElectronico($card)
{

	$card = trim($card);

	$query_monedero_electronico_search = "SELECT * FROM catalogo_monederos_electronicos WHERE trim(no_tarjeta) = '$card' AND (nombre_tarjeta = 'BROXEL' || nombre_tarjeta = 'EFECTICARD SA DE CV' || nombre_tarjeta = 'EFECTIVALE SA DE CV' || nombre_tarjeta = 'SI VALE SA DE CV' || nombre_tarjeta = 'SI VALE SA DE CV DESPENSA' || nombre_tarjeta = 'SI VALE SA DE CV DESPENSA' || nombre_tarjeta = 'TAG ID DE MEXICO SA DE CV') ";
	$result_monedero_electronico_search = mysql_query($query_monedero_electronico_search);

	if (mysql_num_rows($result_monedero_electronico_search) >= 1) {

		while ($row_monedero_electronico_search = mysql_fetch_array($result_monedero_electronico_search)) {

			if (is_numeric($row_monedero_electronico_search[idempleados])) {

				$search_responsable = explode("|", nombres_datos($row_monedero_electronico_search[idempleados], "Colaborador"));

				$responsable = "$row_monedero_electronico_search[nombre_tarjeta]|$row_monedero_electronico_search[tipo]|$row_monedero_electronico_search[nip]|$search_responsable[10] - $search_responsable[2]|$row_monedero_electronico_search[columna_a]|$row_monedero_electronico_search[columna_b]|$row_monedero_electronico_search[columna_c]";
			} else {

				$responsable = "$row_monedero_electronico_search[nombre_tarjeta]|$row_monedero_electronico_search[tipo]|$row_monedero_electronico_search[nip]|$row_monedero_electronico_search[idempleados]|$row_monedero_electronico_search[columna_a]|$row_monedero_electronico_search[columna_b]|$row_monedero_electronico_search[columna_c]";
			}
		}
	} else {

		$responsable = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente";
	}

	return $responsable;
}

#-------------------------------------------  --------------------------------------------------------------------------------
