<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];

$q = $_POST['valorBusqueda'];
$tipo_busqueda = trim($_POST['tipoBusqueda']);
$okkk = trim($_POST['contador']);
$name_sugerencia = trim($_POST['name_sugerencia']);

// $q = "10699";
// $tipo_busqueda = trim("ResponsablesOptions");
// $okkk = trim($_POST['contador']);
// $name_sugerencia = trim($_POST['name_sugerencia']);

$okkk = ($okkk == "" || $okkk == null) ? "" : $okkk;
$okkk = trim($okkk);

$nombre_sugerencia = trim($name_sugerencia . $okkk);

if ($tipo_busqueda == "ColaboraboradorSI") {

	$query_colaborador_si = "SELECT * FROM empleados WHERE visible = 'SI' and (nombre LIKE '%" . $q . "%' || apellido_paterno LIKE '%" . $q . "%' || apellido_materno LIKE '%" . $q . "%' || columna_b LIKE '%" . $q . "%' ||  concat_ws(' ', nombre, apellido_paterno, apellido_materno) LIKE '%" . $q . "%' || concat_ws(' ',apellido_paterno, apellido_materno) LIKE '%" . $q . "%' || concat_ws(' ', nombre, apellido_paterno) LIKE '%" . $q . "%' || concat_ws(' ', nombre, apellido_materno) LIKE '%" . $q . "%' || concat_ws(' ', nombre, apellido_paterno) LIKE '%" . $q . "%' || concat_ws(' ', apellido_materno) LIKE '%" . $q . "%') LIMIT 5";
	$result_colaborador_si = mysql_query($query_colaborador_si);

	if (mysql_num_rows($result_colaborador_si) > 0) {

		while ($row_colaborador_si = mysql_fetch_array($result_colaborador_si)) {

			$mensaje .= "
			<div class='content-op-busqueda-2'>
			<i class='fas fa-user'></i>
			<option class='$nombre_sugerencia efecto-sugerencia' value='$row_colaborador_si[idempleados];Colaborador;$row_colaborador_si[nombre];$row_colaborador_si[apellido_paterno];$row_colaborador_si[apellido_materno];$row_colaborador_si[columna_b];$row_colaborador_si[puesto_actual];$row_colaborador_si[telefono_empresa];$row_colaborador_si[telefono_personal]'>$row_colaborador_si[nombre] - $row_colaborador_si[apellido_paterno] $row_colaborador_si[apellido_materno] - $row_colaborador_si[columna_b]</option>
			</div>
			";
		}
	} else {

		$mensaje = "<b>Sin Resultados</b>";
	}
} elseif ($tipo_busqueda == "BusquedaLogistica") {

	$query_search_logistica = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$q'";
	$result_search_logistica = mysql_query($query_search_logistica);

	if (mysql_num_rows($result_search_logistica) >= 1) {

		while ($row_search_logistica = mysql_fetch_array($result_search_logistica)) {

			#Nombre ID	
			$search_id = explode("|", nombres_datos($row_search_logistica[idcontacto], $row_search_logistica[tipo_contacto]));

			#Nombre Departamento
			$nombre_departamento = DepartamentoName($row_search_logistica[iddepartamento]);

			#Referencia

			$n1 = strlen($q);
			$n1_aux = 6 - $n1;
			$mat = "";

			for ($i = 0; $i < $n1_aux; $i++) {
				$mat .= "0";
			}

			$id_logistica_referencia = "L" . $mat . $q;

			$idorden_logisticaencriptada = base64_encode($row_search_logistica[idorden_logistica]);

			$mensaje .= "
			<div class='content-op-busqueda-2'>
			<i class='fas fa-road'></i>
			<option class='$nombre_sugerencia efecto-sugerencia' value='$row_search_logistica[idorden_logistica];$row_search_logistica[iddepartamento];$nombre_departamento;$id_logistica_referencia;$idorden_logisticaencriptada'>$row_search_logistica[idorden_logistica] - $search_id[10]</option>
			</div>
			";
		}
	} else {

		$mensaje = "<b>Sin Resultados</b>";
	}
} else if ($tipo_busqueda == "ResponsablesOptions") {

	$mensaje = OptionsResponsablesSelect($q);
	#
} elseif ($tipo_busqueda == "VINOptions") {

	$mensaje = OptionsVinSelect($q);
	#
} elseif ($tipo_busqueda == "ProveedorSI") {

	$mensaje = BusquedaProveesoresSI($q, $nombre_sugerencia);
	#
} elseif ($tipo_busqueda == "TrasladistaAyudantesSI") {

	$mensaje = BusquedaTrasladistaAyudantesSI($q, $nombre_sugerencia);
	#
} else {

	if ($q != "") {

		$query = "SELECT * FROM empleados WHERE visible = 'SI' and (nombre LIKE '%" . $q . "%' || apellido_paterno LIKE '%" . $q . "%' ||  apellido_materno LIKE '%" . $q . "%' ||  columna_b LIKE '%" . $q . "%' ||  concat_ws(' ', nombre, apellido_paterno, apellido_materno) LIKE '%" . $q . "%') LIMIT 5";
		$result = mysql_query($query);

		if (mysql_num_rows($result) >= 1) {
			$colaborador = "Colaborador";

			while ($row = mysql_fetch_array($result)) {

				$mensaje .= "
			<div class='content-op-busqueda-2'>
				<i class='fas fa-user icon-busqueda'></i>
				<option class='sugerencias_asesor efecto-sugerencia' value='$row[idempleados];$row[puesto];$row[sueldo_mensual];$row[fecha_inicio_labores];$row[foto_reciente];$row[apellido_paterno];$row[apellido_materno];$row[nombre];$row[estado];$row[municipio];$row[colonia];$row[calle_numero];$row[cp];$row[telefono_personal];$row[telefono_empresa];$row[telefono_emergencia];$row[sexo];$row[lugar_nacimiento];$row[fecha_nacimiento];$row[nacionalidad];$row[vive_con];$row[estatura];$row[peso];$row[personas_dependen];$row[estado_civil];$row[curp];$row[rfc];$row[nss];$row[licencia_manejo];$row[clase_licencia];$row[estado_licencia];$row[vigencia_licencia];$row[numero_licencia];$row[estado_salud];$row[padece_enfermedad_cronica];$row[si_enfermedad_cronica];$row[deporte_practica];$row[pasatiempo_favorito];$row[meta_vida];$row[idiomas_domina];$row[funciones_oficina_domina];$row[maquinas_oficina_taller_maneja];$row[software_domina];$row[otras_funciones_domina];$row[entero_empleo];$row[entero_empleo_otro];$row[pariente_trabaja_empresa];$row[si_pariente_trabaja];$row[afianzado];$row[si_afianzado];$row[afiliado_sindicato];$row[si_sindicato];$row[seguro_vida];$row[suma_seguro];$row[podria_viajar];$row[no_razones_viajar];$row[cambiar_lugar_residencia];$row[no_cambiar_residencia];$row[tiene_ingresos];$row[si_ingresos_descripcion];$row[importe_mensual_ingresos];$row[conyuge_trabaja];$row[si_conyuge_descripcion];$row[percepcion_mensual_conyuge];$row[casa_propia];$row[valor_aproximado_casa];$row[paga_renta];$row[renta_mesual];$row[auto_propio];$row[marca_auto];$row[modelo_auto];$row[deudas];$row[si_deudas_con_quien];$row[importe_deudas];$row[gastos_mensuales];$row[puesto_actual];$row[sueldo_actual];$row[direccion];$row[departamento];$row[columna_a];$row[columna_b];$row[orden_empleado];$row[orden_rango];$row[visible];$row[usuario_creador];$row[fecha_creacion];$row[fecha_guardado];$row[puesto_fv];$colaborador'>
					$row[nombre] - $row[apellido_paterno] - $row[apellido_materno] - $row[columna_b] - $colaborador
				</option>
			</div>
			";
			}
		} else {

			$mensaje = "<b>NO Encontrado</b>";
		}
	} else {
		$mensaje = "<b>Sin Resultados</b>";
	}
}


function OptionsResponsablesSelect($idorden_logistica)
{

	$array_responsables_balance = array();
	$options_responsables = "";

	$query_responsable_principal = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$idorden_logistica'";
	$result_responsable_principal = mysql_query($query_responsable_principal);

	while ($row_responsable_principal = mysql_fetch_array($result_responsable_principal)) {

		# Busqueda del trasladista principal
		$principal_responsable = explode("|", nombres_datos($row_responsable_principal[idasigna], $row_responsable_principal[tipo_asignante]));

		$responsable_principal = ($principal_responsable[0] == "Pendiente") ? "" : "<option value = '$row_responsable_principal[idasigna]|$row_responsable_principal[tipo_asignante]'>$principal_responsable[10] - $principal_responsable[2]</option>";

		array_push($array_responsables_balance, $responsable_principal);

		#buscar si hay ayudantes en la logistica

		$query_ayudantes_responsable = "SELECT * FROM orden_logistica_ayudante WHERE visible = 'SI' AND idorden_logistica = '$idorden_logistica'";
		$result_ayudantes_responsable = mysql_query($query_ayudantes_responsable);

		while ($row_ayudantes_responsable = mysql_fetch_array($result_ayudantes_responsable)) {

			$search_name_ayudantes_responsable = explode("|", nombres_datos($row_ayudantes_responsable[id_colaborador_proveedor], $row_ayudantes_responsable[tipo]));

			$concat_resp_ayudantes = "<option value = '$row_ayudantes_responsable[id_colaborador_proveedor]|$row_ayudantes_responsable[tipo]'>$search_name_ayudantes_responsable[10] - $search_name_ayudantes_responsable[2]</option>";
			array_push($array_responsables_balance, $concat_resp_ayudantes);
		}

		#Eliminamos los duplicados y los que estan vacios
		$tratar_array_responsables = Tratar_Array($array_responsables_balance);

		if (count($tratar_array_responsables) >= 1) {

			foreach ($tratar_array_responsables as $key_options => $value_options_responsable) {

				$options_responsables .= $value_options_responsable;
			}
		} else {

			$options_responsables = "Pendiente";
		}
	}

	return $options_responsables;
}

function OptionsVinSelect($idorden_logistica)
{

	$idorden_logistica = trim($idorden_logistica);

	$query_unidad_option = "SELECT * FROM orden_logistica_unidades WHERE visible = 'SI' AND idorden_logistica = '$idorden_logistica'";
	$result_unidad_option = mysql_query($query_unidad_option);

	if (mysql_num_rows($result_unidad_option) >= 1) {

		while ($row_unidad_option = mysql_fetch_array($result_unidad_option)) {

			$datos_unidad = explode("|", date_vin($row_unidad_option[vin]));


			$mensaje_vin .= "<option value='$datos_unidad[0]'>$datos_unidad[0] - $datos_unidad[1] - $datos_unidad[2] - $datos_unidad[3] - $datos_unidad[4] - $datos_unidad[5]</option>";
		}
	} else {
		$mensaje_vin = "Pendiente";
	}

	return $mensaje_vin;
}

#------------------------------------------- Buscar Proveedores buscar Search Proveedor Search --------------------------------------------------------------------------------

function BusquedaProveesoresSI($q, $nombre_sugerencia)
{
	$result_busqueda_proveedor = "";

	$query_proveedor_busqueda = "SELECT * FROM proveedores WHERE visible = 'SI' and (nombre LIKE '%$q%' or apellidos LIKE '%$q%' or alias LIKE '%$q%' or concat_ws(' ', nombre, apellidos) like '%$q%' or concat_ws(' ', apellidos, nombre) like '%$q%' || rfc like '%$q%') LIMIT 10";
	$result_proveedor_busqueda = mysql_query($query_proveedor_busqueda);

	if (mysql_num_rows($result_proveedor_busqueda) >= 1) {

		while ($row_proveedor_busqueda = mysql_fetch_array($result_proveedor_busqueda)) {
			$result_busqueda_proveedor .= "
		<div class='content-op-busqueda-2'>
			<i class='fas fa-address-book icon-busqueda'></i>
			<option class='$nombre_sugerencia efecto-sugerencia' value='$row_proveedor_busqueda[idprovedores_compuesto];$row_proveedor_busqueda[nombre];$row_proveedor_busqueda[apellidos];$row_proveedor_busqueda[alias];Proveedor;$row_proveedor_busqueda[rfc]'>
				$row_proveedor_busqueda[nombre] - $row_proveedor_busqueda[apellidos] - Proveedor
			</option>
		</div>
		";
		}
	} else {

		$query_proveedor_temporal_busqueda = "SELECT * FROM orden_logistica_proveedores WHERE visible = 'SI' and (nombre LIKE '%$q%' || apellidos LIKE '%$q%' || alias LIKE '%$q%' || nomeclatura LIKE '%$q%' || concat_ws(' ', nombre, apellidos) like '%$q%' or concat_ws(' ', apellidos, nombre) like '%$q%' || rfc like '%$q%') LIMIT 10";
		$result_proveedor_temporal_busqueda = mysql_query($query_proveedor_temporal_busqueda);

		if (mysql_num_rows($result_proveedor_temporal_busqueda) >= 1) {

			while ($row_proveedor_temporal_busqueda = mysql_fetch_array($result_proveedor_temporal_busqueda)) {

				$result_busqueda_proveedor .= "
			<div class='content-op-busqueda-2'>
				<i class='fas fa-address-book icon-busqueda'></i>
				<option class='$nombre_sugerencia efecto-sugerencia' value='$row_proveedor_temporal_busqueda[idprovedores_compuesto];$row_proveedor_temporal_busqueda[nombre];$row_proveedor_temporal_busqueda[apellidos];$row_proveedor_temporal_busqueda[alias];Proveedor Temporal;$row_proveedor_temporal_busqueda[rfc]'>
					$row_proveedor_temporal_busqueda[nombre] - $row_proveedor_temporal_busqueda[apellidos]- Proveedor Temporal
				</option>
			</div>
			";
			}
		} else {

			$result_busqueda_proveedor = "<b>ID NO Encontrado</b>";
		}
	}

	return $result_busqueda_proveedor;
}


#------------------------------------------- Buscar Trasladista Acompañantes Ayudantes--------------------------------------------------------------------------------

function BusquedaTrasladistaAyudantesSI($q, $nombre_sugerencia)
{

	$result_busqueda_trasladista_ayudantes = "";

	$query = "SELECT * FROM empleados WHERE visible = 'SI' AND columna_a = 'Disponible' and (nombre LIKE '%$q%' || apellido_paterno LIKE '%$q%' || apellido_materno LIKE '%$q%' || columna_b LIKE '%$q%' || concat_ws(' ', nombre, apellido_paterno, apellido_materno) LIKE '%$q%' ) LIMIT 10";
	$result = mysql_query($query);

	if (mysql_num_rows($result) >= 1) {

		$colaborador = "Colaborador";

		while ($row = mysql_fetch_array($result)) {

			$result_busqueda_trasladista_ayudantes .= "
		<div class='content-op-busqueda-2'>
		<i class='fas fa-user icon-busqueda'></i>
		<option class='$nombre_sugerencia efecto-sugerencia' value='$row[idempleados];$row[nombre] $row[apellido_paterno] $row[apellido_materno];$colaborador'>$row[nombre] - $row[apellido_paterno] - $row[apellido_materno] $colaborador </option>
		</div>
		";
		}
		#	
	} else {

		$contacto = "Cliente";
		$query1 = "SELECT * FROM contactos WHERE visible = 'SI' AND ( nombre LIKE '%$q%' ||  apellidos LIKE '%$q%' ||  alias LIKE '%$q%' ||  telefono_celular LIKE '%$q%'  ||  telefono_otro LIKE '%$q%' || concat_ws(' ', nombre, apellidos) LIKE '%$q%' || concat_ws(' ', apellidos, nombre) LIKE '%$q%' || idcontacto = '$q' ) LIMIT 10";
		$result1 = mysql_query($query1);

		if (mysql_num_rows($result1) >= 1) {

			while ($row1 = mysql_fetch_array($result1)) {
				$result_busqueda_trasladista_ayudantes .= "
			<div class='content-op-busqueda-2'>
			<i class='fas fa-user icon-busqueda'></i>
			<option class='$nombre_sugerencia efecto-sugerencia' value='$row1[idcontacto];$row1[nombre] $row1[apellidos];$contacto'>$row1[nombre] - $row1[apellidos] - <b>$contacto</b> </option>
			</div>
			";
			}
		} else {

			$proveedor = "Proveedor";
			$query2 = "SELECT * FROM proveedores WHERE visible = 'SI' AND ( nombre LIKE '%$q%' or apellidos LIKE '%$q%' or alias LIKE '%$q%' or concat_ws(' ', nombre, apellidos) LIKE '%$q%' or concat_ws(' ', apellidos, nombre) LIKE '%$q%' || rfc LIKE '%$q%') LIMIT 10";
			$result2 = mysql_query($query2);

			if (mysql_num_rows($result2) >= 1) {

				while ($row2 = mysql_fetch_array($result2)) {
					$result_busqueda_trasladista_ayudantes .= "
				<div class='content-op-busqueda-2'>
				<i class='fas fa-user icon-busqueda'></i>
				<option class='$nombre_sugerencia efecto-sugerencia' value='$row2[idproveedores];$row2[nombre] $row2[apellidos];$proveedor'>$row2[nombre] - $row2[apellidos] - <b>$proveedor</b> </option>
				</div>
				";
				}
			} else {

				$proveedor_temporal = "Proveedor Temporal";
				$query3 = "SELECT * FROM orden_logistica_proveedores WHERE visible = 'SI' AND ( nombre LIKE '%$q%' or apellidos LIKE '%$q%' or alias LIKE '%$q%' or concat_ws(' ', nombre, apellidos) LIKE '%$q%' or concat_ws(' ', apellidos, nombre) LIKE '%$q%' || rfc LIKE '%$q%') LIMIT 10";
				$result3 = mysql_query($query3);

				if (mysql_num_rows($result3)) {


					while ($row3 = mysql_fetch_array($result3)) {
						$result_busqueda_trasladista_ayudantes .= "
					<div class='content-op-busqueda-2'>
					<i class='fas fa-user icon-busqueda'></i>
					<option class='$nombre_sugerencia efecto-sugerencia' value='$row3[idorden_logistica_proveedores];$row3[nombre] $row3[apellidos];$proveedor_temporal'>$row3[nombre] - $row3[apellidos] - <b>$proveedor_temporal</b> </option>
					</div>
					";
					}
				} else {
					$result_busqueda_trasladista_ayudantes = "<b>Sin Resultados</b>";
				}
			}
		}
	}
	return $result_busqueda_trasladista_ayudantes;
}



echo $mensaje;
