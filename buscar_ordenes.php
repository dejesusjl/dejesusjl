<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "../Logistica/funciones_principales.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s"); 
$usuario_creador = $_SESSION['usuario_clave'];
$idempleados_orden = $_SESSION['empleados'];

$q = trim($_POST['valorBusqueda']);

$idcontacto = trim($_POST['idcontacto']);
$tipo_contacto_id = trim($_POST['tipo_contacto_id']);

$idorden_logistica_tipo_orden = trim($_POST['idorden_logistica_tipo_orden']);

$vin = trim($_POST['vin']);



if ($tipo_contacto_id == "Cliente") {

	$tipo_contacto = "ClienteID";

}elseif ($tipo_contacto_id == "Proveedor") {
	
	$tipo_contacto = "Proveedor";

}elseif ($tipo_contacto_id == "'Empleados'") {

	$tipo_contacto = "'Empleados'";

}else {
	$tipo_contacto = $tipo_contacto;
}


if ($idorden_logistica_tipo_orden == "Root_atc_vin") {

	echo AtencionClientes ($q, $vin, $idorden_logistica_tipo_orden);

}else {

	$query_tipo_orden = "SELECT *  FROM orden_logistica_buscar_ordenes_extras WHERE visible = 'SI' AND idorden_logistica_tipo_orden = '$idorden_logistica_tipo_orden'";
	$result_tipo_orden = mysql_query($query_tipo_orden);

	if (mysql_num_rows($result_tipo_orden) == 0) {

		echo "0|Sin resultados solicitar <b>activar buscador de orden</b>";

	}else {

		while ($row_tipo_orden = mysql_fetch_array($result_tipo_orden) ) {

			if ($row_tipo_orden[tipo_funcion_buscador] == "detallado") {

				echo OrdenesDetallado ($q, $idempleados_orden);

			}elseif ($row_tipo_orden[tipo_funcion_buscador] == "documentacion_vin") {

				echo DocumentacionVin ($q, $idcontacto, $tipo_contacto_id);

			}else {

				echo "0|<b>Solicitar activar buscador de orden</b>";
			}

		}
	}

}





#-------------------------------------------  --------------------------------------------------------------------------------

function OrdenesDetallado ($q, $idempleados_orden) {

	$q = trim($q);
	$idempleados_orden = trim($idempleados_orden);

	$buscar_responsable = explode("|", nombres_datos($idempleados_orden, "Colaborador"));

	$clausula = ($idempleados_orden == 120) ? "AND trim(responsable) = '$buscar_responsable[2]' and ( trim(estatus) = 'Autorizado' || trim(estatus) = 'Solicitud' || trim(estatus) = 'Trabajando' )" : "" ;

	$query_atencion_clientes = "SELECT * FROM atencion_clientes WHERE visible = 'SI' AND idatencion_clientes = '$q' $clausula";
	$result_atencion_clientes = mysql_query($query_atencion_clientes);

	if (mysql_num_rows($result_atencion_clientes) == 0) {
		
		$mensaje_atencion_clientes = "0| Número de orden no valido, verficar con el departamento correspondiente.";

	}else {

		while ($row_atencion_clientes = mysql_fetch_array($result_atencion_clientes) ) {

			$valores_vin = explode("|", date_vin($row_atencion_clientes[datos_vin]));

			if (trim($valores_vin[7]) == "VENDIDO") {

				$mensaje_atencion_clientes = "0|El número de orden existe, pero el VIN:<b>$valores_vin[0] - $valores_vin[1]  - $valores_vin[2]  - $valores_vin[3]  - $valores_vin[4]  - $valores_vin[5] </b> se encuentra con estatus <b>Vendido</b>. Favor de verificar el número de orden y/o solicitra una autorización.";

			}else {

				$mensaje_atencion_clientes = "1|".$row_atencion_clientes[comentarios];

			}

		}
	}

	return $mensaje_atencion_clientes;
}

#-------------------------------------------  --------------------------------------------------------------------------------

function DocumentacionVin ($q, $idcontacto, $tipo_contacto_id) {

	$q = trim($q);


	$query_documentacion = "SELECT * FROM at_oc where visible = 'SI' AND idorden_compra_unidades = '$q' ";
	$result_documentacion = mysql_query($query_documentacion);

	if (mysql_num_rows($result_documentacion) == 0) {

		$mensaje_documentacion = "0| Número de orden no valido, sin resultados.";

	}else {

		while ($row_documentacion = mysql_fetch_array($result_documentacion) ) {

			if (trim($row_documentacion[tipo]) == "Liberación del expediente original") {

				$quey_atc_clientes = "SELECT * FROM atencion_clientes WHERE visible = 'SI' AND idatencion_clientes = '$row_documentacion[idatencion_clientes]'";
				$result_atc_clientes = mysql_query($quey_atc_clientes);

				if (mysql_num_rows($result_atc_clientes) == 0 ) {
					
					$mensaje_documentacion = "0| Número de orden no valido, en ATC.";

				}else {

					while ($row_atc_clientes = mysql_fetch_array($result_atc_clientes) ) {

						$busqueda_vin = explode("|", date_vin($row_atc_clientes[idestado_cuenta]));
						
						$entrega_validacion = ValidarMedioEntrega ($q);

						if ($entrega_validacion == 0) {

							$mensaje_documentacion = "2|$busqueda_vin[0]|$busqueda_vin[1]|$busqueda_vin[2]|$busqueda_vin[3]|$busqueda_vin[4]|$busqueda_vin[5]" ;
							
						}else {

							$mensaje_documentacion = (trim($row_atc_clientes[idcontacto]) == $idcontacto and trim($row_atc_clientes[proveedor_cliente]) == $tipo_contacto_id) ? "1|$busqueda_vin[0]|$busqueda_vin[1]|$busqueda_vin[2]|$busqueda_vin[3]|$busqueda_vin[4]|$busqueda_vin[5]" : "2|$busqueda_vin[0]|$busqueda_vin[1]|$busqueda_vin[2]|$busqueda_vin[3]|$busqueda_vin[4]|$busqueda_vin[5]" ;

						}
					}
				}

			}else {

				$mensaje_documentacion = "0| La orden existe pero no se pueden entregar documentos con este tipo de orden <b>$row_documentacion[tipo]</b>";

			}
		}
	}

	return $mensaje_documentacion;
}

#-------------------------------------------  --------------------------------------------------------------------------------

function AtencionClientes ($q, $vin, $idorden_logistica_tipo_orden) {

	$q = trim($q);
	$vin = trim($vin);
	$idorden_logistica_tipo_orden = trim($idorden_logistica_tipo_orden);

	if ($idorden_logistica_tipo_orden == "Root_atc_vin") {

		$clausula = "AND trim(datos_vin) = '$vin' ";

	}else {

		$clausula = "ook";
	}


	$query_atencion_clientes = "SELECT * FROM atencion_clientes WHERE visible = 'SI' AND idatencion_clientes = '$q' $clausula";
	$result_atencion_clientes = mysql_query($query_atencion_clientes);

	if (mysql_num_rows($result_atencion_clientes) == 0) {
		
		$mensaje_atencion_clientes = "0| No se encontraron resultados.";

	}else {

		while ($row_atencion_clientes = mysql_fetch_array($result_atencion_clientes) ) {

			$valores_vin = explode("|", date_vin($row_atencion_clientes[datos_vin]));

			$mensaje_atencion_clientes = "1|$row_atencion_clientes[comentarios] <br> <center> <b>$valores_vin[0]</b> - $valores_vin[1]  - $valores_vin[2]  - $valores_vin[3]  - $valores_vin[4]  - $valores_vin[5] </center>";

		}
	}

	return $mensaje_atencion_clientes;
}

#-------------------------------------------  --------------------------------------------------------------------------------

function ValidarMedioEntrega ($q) {

	$q = trim($q);

	$query_medio_entrega = "SELECT * FROM checklist_expediente_general_entrega WHERE idorden_compra_unidades = '$q' and trim(medio) = 'Logística'";
	$result_medio_entrega = mysql_query($query_medio_entrega);

	return mysql_num_rows($result_medio_entrega);

}



?>