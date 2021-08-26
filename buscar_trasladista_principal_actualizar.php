<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$usuario_creador = $_SESSION['usuario_clave'];
$id_colaborador = $_SESSION['empleados'];


$tipo_accion = $_POST['tipo_accion'];

$idlogistica = trim($_POST['idlogistica']);

$q = $_POST['valorBusqueda'];
$fecha_creacion = $_POST['fecha_creacion'];
$coordenadas = $_POST['coordenadas'];

# ---------------------------------------
$array_colaboradores_exepcion = ['88'];

$nombre_loguin = explode("|", nombres_datos($id_colaborador, "Colaborador"));


if ($tipo_accion == "ComprobarVIN") {

	if (in_array($id_colaborador, $array_colaboradores_exepcion)) {

		$mensaje = 1;
		#
	} else {

		$query_logistica = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$idlogistica' ";
		$result_logistica = mysql_query($query_logistica);

		if (mysql_num_rows($result_logistica) >= 1) {

			while ($row_logistica = mysql_fetch_array($result_logistica)) {

				$query_comprobar_vin = "SELECT * FROM orden_logistica_unidades WHERE trim(idorden_logistica) = '$row_logistica[idorden_logistica]' AND visible = 'SI'";
				$result_comprobar_vin = mysql_query($query_comprobar_vin);

				$mensaje = (mysql_num_rows($result_comprobar_vin) >= 1) ? 1 : 0;
			}
		} else {

			$mensaje = "Error Logistica";
			#
		}
		#
	}
	#
} else if ($tipo_accion == "TrasladistaPrincipal") {

	$query_options_exceptions = "SELECT * FROM orden_logistica_id_excepciones WHERE visible = 'SI' AND tipo = 'Trasladista Principal' AND parametros = 'NO' ";
	$result_options_exceptions = mysql_query($query_options_exceptions);

	if (mysql_num_rows($result_options_exceptions) >= 1) {

		$mensaje .= "
		<div class='col-sm-12'>
		<div class='alert alert-info' role='alert'>
		<h4>No se han agregado unidades en la logística. Por lo tanto, se asume que es para personal en específico.</h4>
		<h5>Puedes realizar lo siguiente:</h5>
		<ol>
		<li>Agregar los vines correspondientes.</li>
		<li>Solicitar a <b>DID</b> agregar personal con excepciones(Colaborador, Proveedor...etc.)</li>
		<li>Solicitar <b>Token Logística</b>.
		<ol>
		<li>A continuación selecciona la opción <b>Solicitar Token | Ya tengo token</b></li>
		<li>Se desbloquearan las opciones para Solicitar o escribir el token en caso que lo tengas.</li>
		</ol>
		</li>
		</ol>
		

		<div class='col-sm-12'>
		<label>Seleccionar Trasladista</label>
		<select id='trasladistaexeption' class='form-control' onchange='ExceptionTrasladistaP();'>
		<option value=''>Selecciona una opción...</option>
		<option value='OptionToken'>Solicitar Token | Ya tengo token</option>
		";

		while ($row_options_exceptions = mysql_fetch_array($result_options_exceptions)) {

			$nombre_id = explode("|", nombres_datos($row_options_exceptions[id], $row_options_exceptions[id_tipo]));

			$mensaje .= "<option value='$row_options_exceptions[id]|$row_options_exceptions[id_tipo]'>$nombre_id[10] - $row_options_exceptions[id_tipo]</option>";
		}

		$mensaje .= "</select>
		</div>

		<div class='col-sm-12 my-4' id='FormSolicitarTokenTPrincipal' style='display: none;'>
		<label>¿ Solicitar Token ?</label><br>
		<label>SI</label>
		<input type='radio' class='radio1 AsignarTPL' id='AsignarTPLSI' name='tokentrasladistaprincipalmodal' onclick=\"SolicitarTokenDesbloqueo('AsignarTPL|SI');\"> &nbsp;&nbsp;&nbsp;&nbsp;
		<label>Ya Tengo token</label>
		<input type='radio' class='radio1 AsignarTPL' id='AsignarTPLNO' name='tokentrasladistaprincipalmodal' onclick=\"SolicitarTokenDesbloqueo('AsignarTPL|NO');\">
		</div>

		<div class='col-sm-12' id='showSolicitarTokenTPrincipal' style='display: none;'>

		<label>*Comentarios Solicitud&nbsp;&nbsp;<span class='contador_span' id='contador_espan_trasladista_principal'>20 caracteres restantes</label>
		<textarea id='txtSolicitarTokenTPrincipal' class='form-control cleantokentrasladistaPrincipal' rows='3' onkeypress='cancelar_enter()' onkeyup=\"RangeComentarios(this,'contador_espan_trasladista_principal','button_solicitar_trasladista_principal');\"></textarea>

		<center>
		<div class='col-sm-12'>
			<br>
			<button class='btn btn-lg btn-primary' type='button' id='button_solicitar_trasladista_principal' style='display: none;' onclick=\"EnviarSolicitudDesbloqueo('txtSolicitarTokenTPrincipal');\">Enviar Solicitud</button>
		</div>
		</center>
		</div>

		
		<div class='col-sm-12' id='YategoTokenTrasladistaPrincipal' style='display: none;'>
		<label>Verificar Token</label>
		<input type='text' id='tokenunlockprincipal' class='form-control cleantokentrasladistaPrincipal'>
		<center>
			<div class='col-sm-12'>
				<br>
				<button class='btn btn-lg btn-primary' type='button' id='VerificarTokenTprincipal' onclick=\"AjaxVerificarTokenTP('tokenunlockprincipal');\">Verificar Token</button>
			</div>
		</center>
		<div>
		</div>
		</div>
		";

		#
	} else {

		$mensaje = "
		<div class='col-sm-12'>
		<div class='alert alert-info' role='alert'>
		<h4>No se han agregado unidades en la logística. Por lo tanto, se asume que es para personal en específico.</h4>
		<h5>Puedes realizar lo siguiente:</h5>
		<ol>
		<li>Agregar los vines correspondientes.</li>
		<li>Solicitar a <b>DID</b> agregar personal con excepciones(Colaborador, Proveedor...etc.)</li>
		<li>Solicitar <b>Token Logística</b>.
		<ol>
		<li>Se desbloquearan las opciones para Solicitar o escribir el token en caso que lo tengas.</li>
		</ol>
		</li>
		</ol>

		<div class='col-sm-12 my-4' id='FormSolicitarTokenTPrincipal' style='display: block;'>
		<label>¿ Solicitar Token ?</label><br>
		<label>SI</label>
		<input type='radio' class='radio1 AsignarTPL' id='AsignarTPLSI' name='tokentrasladistaprincipalmodal' onclick=\"SolicitarTokenDesbloqueo('AsignarTPL|SI');\"> &nbsp;&nbsp;&nbsp;&nbsp;
		<label>Ya Tengo token</label>
		<input type='radio' class='radio1 AsignarTPL' id='AsignarTPLNO' name='tokentrasladistaprincipalmodal' onclick=\"SolicitarTokenDesbloqueo('AsignarTPL|NO');\">
		</div>

		<div class='col-sm-12' id='showSolicitarTokenTPrincipal' style='display: none;'>

		<label>*Comentarios Solicitud&nbsp;&nbsp;<span class='contador_span' id='contador_espan_trasladista_principal'>20 caracteres restantes</label>
		<textarea id='txtSolicitarTokenTPrincipal' class='form-control cleantokentrasladistaPrincipal' rows='3' onkeypress='cancelar_enter()' onkeyup=\"RangeComentarios(this,'contador_espan_trasladista_principal','button_solicitar_trasladista_principal');\"></textarea>

		<center>
		<div class='col-sm-12'>
			<br>
			<button class='btn btn-lg btn-primary' type='button' id='button_solicitar_trasladista_principal' style='display: none;' onclick=\"EnviarSolicitudDesbloqueo('txtSolicitarTokenTPrincipal');\">Enviar Solicitud</button>
		</div>
		</center>
		</div>

		
		<div class='col-sm-12' id='YategoTokenTrasladistaPrincipal' style='display: none;'>
		<label>Verificar Token</label>
		<input type='text' id='tokenunlockprincipal' class='form-control cleantokentrasladistaPrincipal'>
		<center>
			<div class='col-sm-12'>
				<br>
				<button class='btn btn-lg btn-primary' type='button' id='VerificarTokenTprincipal' onclick=\"AjaxVerificarTokenTP('tokenunlockprincipal');\">Verificar Token</button>
			</div>
		</center>
		<div>
		</div>
		</div>
		";
	}
	#
} elseif ($tipo_accion == "Solicitud de Token") {

	$txtcomplementariobd = ($idlogistica != "") ? " Logística Número <b>$idlogistica</b>" : "";
	$txtcomplementariowt = ($idlogistica != "") ? " Logística Número *$idlogistica*" : "";

	$descripcion = "Solicito desbloquear el módulo de <b>Asignación Trasladista Principal</b> debido a: $q $txtcomplementariobd";
	$descripcion_whats = "Solicito desbloquear el módulo de *Asignación Trasladista Principal* debido a: $q $txtcomplementariowt";

	$numero_whats_token = "https://api.whatsapp.com/send?phone=5217121122112&text=$descripcion_whats";


	if ($idlogistica != "") {

		$token_bitacora = LogisticaInsertBitacora("Desbloquear Módulo", "Token Logística", $idlogistica, $descripcion, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "13", $columna_c, $columna_d, "SI");

		$mensaje = ($token_bitacora == 1) ? "1|$numero_whats_token" : $token_bitacora;
		#
	} else {

		$mensaje = "1|$numero_whats_token";
		#
	}
} elseif ($tipo_accion == "ComprobarTokenLogisticaTPrincipal") {

	$query_verificar_token = "SELECT * FROM orden_logistica_token WHERE token = '$q' AND tipo_token = 'Trasladista Principal' AND idorden_logistica = '$idlogistica' AND idcolaborador = '$id_colaborador' AND tipocolaborador = 'Colaborador' AND visible = 'SI'";
	$result_verificar_token = mysql_query($query_verificar_token);

	if (mysql_num_rows($result_verificar_token) >= 1) {

		while ($row_verificar_token = mysql_fetch_array($result_verificar_token)) {

			if ($row_verificar_token[fecha_expiracion_token] != "") {

				$fecha_act = date("Y-m-d H:i:s");
				$fecha_token = date_format(date_create($row_verificar_token[fecha_expiracion_token]), 'Y-m-d H:i:s');

				$fecha_actual = strtotime(date("d-m-Y H:i:00", time()));
				$fecha_entrada = strtotime($fecha_token);

				if ($fecha_actual > $fecha_entrada) {

					$datetime1 = date_create($fecha_act);
					$datetime2 = date_create($row_verificar_token[fecha_expiracion_token]);

					$interval = date_diff($datetime1, $datetime2);

					if ($interval->format("%y") >= "1") {

						$mensaje = $interval->format("Caduco hace %y año con %m mes(es) y %d día(s) con %H hora(s) y %I minuto(s)");
						#
					} else if ($interval->format("%m") >= "1") {

						$mensaje = $interval->format("Caduco hace %m mes(es) y %d día(s) con %H hora(s) y %I minuto(s)");
						#
					} else if ($interval->format("%d") >= "1") {

						$mensaje = $interval->format("Caduco hace %d día(s) con %H hora(s) y %I minuto(s)");
						#
					} else if ($interval->format("%H") >= "1") {

						$mensaje = $interval->format("Caduco hace %H hora(s) y %I minuto(s)");
						#
					} elseif ($interval->format("%I") >= "1") {

						$mensaje = $interval->format("Caduco hace apenas %I minuto(s)");
						#
					} else if ($interval->format("%s") >= "1") {

						$mensaje = $interval->format("Caduco hace apenas %s segundo(s)");
						#
					} else {

						$mensaje = "Sin Resultados Token";
					}
					#
				} else {

					//$query_update_token = "UPDATE orden_logistica_token SET visible = 'NO', columna_a = '$fecha_guardado', columna_b = 'Aplicado' WHERE idorden_logistica_token = '$row_verificar_token[idorden_logistica_token]'";
					//$result_update_token = mysql_query($query_update_token);

					//$mensaje = ($result_update_token == 1) ? 1 : "Error al actualizar token";

					$mensaje = 1;
				}
			} else {
				$mensaje = "Sin token para <b>$nombre_loguin[10] - $nombre_loguin[2]</b>";
			}
		}
	} else {

		$mensaje = "No hay token para <b>$nombre_loguin[10] - $nombre_loguin[2]</b>";
	}

	#	
} else {


	$mensaje = "Aun no hay opciones para este evento $tipo_accion";
	#
}




echo $mensaje;
unset($tipo_accion);
