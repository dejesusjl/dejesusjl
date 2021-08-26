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


$idprovedores_compuesto = trim($_POST['idprovedores_compuesto_proveedor']);
$nomeclatura = trim($_POST['nomeclatura_proveedor']);
$nombre = trim($_POST['nombre_proveedor']);
$apellidos = trim($_POST['apellidos_proveedor']);
$sexo = trim($_POST['sexo_proveedor']);
$rfc = trim($_POST['rfc_proveedor']);
$alias = trim($_POST['alias_proveedor']);
$trato = trim($_POST['trato_proveedor']);
$telefono_otro = trim($_POST['telefono_otro_proveedor']);
$telefono_celular = trim($_POST['telefono_celular_proveedor']);
$email = trim($_POST['email_proveedor']);
$referencia_nombre = trim($_POST['referencia_nombre_proveedor']);
$referencia_celular = trim($_POST['referencia_celular_proveedor']);
$referencia_fijo = trim($_POST['referencia_fijo_proveedor']);
$referencia_nombre2 = trim($_POST['referencia_nombre2_proveedor']);
$referencia_celular2 = trim($_POST['referencia_celular2_proveedor']);
$referencia_fijo2 = trim($_POST['referencia_fijo2_proveedor']);
$referencia_nombre3 = trim($_POST['referencia_nombre3_proveedor']);
$referencia_celular3 = trim($_POST['referencia_celular3_proveedor']);
$referencia_fijo3 = trim($_POST['referencia_fijo3_proveedor']);
$tipo_registro = trim($_POST['tipo_registro_proveedor']);
$recomendado = trim($_POST['recomendado_proveedor']);
$entrada = trim($_POST['entrada_proveedor']);
$asesor = trim($_POST['asesor_proveedor']);
$tipo_cliente = trim($_POST['tipo_cliente_proveedor']);
$tipo_credito = trim($_POST['tipo_credito_proveedor']);
$linea_credito = trim($_POST['linea_credito_proveedor']);
$codigo_postal = trim($_POST['codigo_postal_proveedor']);
$estado = trim($_POST['estado_proveedor']);
$delmuni = trim($_POST['delmuni_proveedor']);
$colonia = trim($_POST['colonia_proveedor']);
$calle = trim($_POST['calle_proveedor']);
$foto_perfil = trim($_POST['foto_perfil_proveedor']);
$visible = "SI";

$fecha_creacion = $_POST['fecha_creacion_proveedor'];
$metodo_pago = trim($_POST['metodo_pago_proveedor']);
$col1 = trim($_POST['col1_proveedor']);
$col2 = trim($_POST['col2_proveedor']);
$col3 = trim($_POST['col3_proveedor']);
$col4 = trim($_POST['col4_proveedor']);
$col5 = trim($_POST['col5_proveedor']);
$col6 = trim($_POST['col6_proveedor']);
$col7 = trim($_POST['col7_proveedor']);
$col8 = trim($_POST['col8_proveedor']);
$col9 = trim($_POST['col9_proveedor']);
$col10 = trim($_POST['col10_proveedor']);
$archivo_ine = trim($_POST['archivo_ine_proveedor']);
$archivo_comprobante = trim($_POST['archivo_comprobante_proveedor']);



$tipo_proveedor = trim($_POST['tipo_proveedor']);

// $tipo_proveedor = "Actualizar Proveedor";
// $idprovedores_compuesto = "2118-HM-10082021";
// $nombre = "Hola Mundo S.A. de C.V.";
// $apellidos = "Corporation";
// $telefono_celular = "7121122112";
// $rfc = "HMC9513578520";
// $estado = "Ciudad de Mexico";
// $delmuni = "Tacuba";
// $colonia = "Torre Blanca";
// $calle = "Lago Zug";
// $codigo_postal = "";
// $fecha_creacion = date("Y-m-d H:i:s");

if ($tipo_proveedor == "Proveedor") {

	if ($nombre == "") {

		echo "- No Hay Nombre <br>";
		#
	} else {

		echo AgregarProveedor($idprovedores_compuesto, $nomeclatura, $nombre, $apellidos, $sexo, $rfc, $alias, $trato, $telefono_otro, $telefono_celular, $email, $referencia_nombre, $referencia_celular, $referencia_fijo, $referencia_nombre2, $referencia_celular2, $referencia_fijo2, $referencia_nombre3, $referencia_celular3, $referencia_fijo3, $tipo_registro, $recomendado, $entrada, $asesor, $tipo_cliente, $tipo_credito, $linea_credito, $codigo_postal, $estado, $delmuni, $colonia, $calle, $foto_perfil, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $metodo_pago, $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $archivo_ine, $archivo_comprobante);
		#
	}
} elseif ($tipo_proveedor == "Proveedor Temporal") {

	echo AgregarProveedorTemporal($idprovedores_compuesto, $nomeclatura, $nombre, $apellidos, $sexo, $rfc, $alias, $trato, $telefono_otro, $telefono_celular, $email, $referencia_nombre, $referencia_celular, $referencia_fijo, $referencia_nombre2, $referencia_celular2, $referencia_fijo2, $referencia_nombre3, $referencia_celular3, $referencia_fijo3, $tipo_registro, $recomendado, $entrada, $asesor, $tipo_cliente, $tipo_credito, $linea_credito, $codigo_postal, $estado, $delmuni, $colonia, $calle, $foto_perfil, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $metodo_pago, $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10);
	#
} elseif ($tipo_proveedor == "Actualizar Proveedor") {

	echo UpdateProveedor($idprovedores_compuesto, $nomeclatura, $nombre, $apellidos, $sexo, $rfc, $alias, $trato, $telefono_otro, $telefono_celular, $email, $referencia_nombre, $referencia_celular, $referencia_fijo, $referencia_nombre2, $referencia_celular2, $referencia_fijo2, $referencia_nombre3, $referencia_celular3, $referencia_fijo3, $tipo_registro, $recomendado, $entrada, $asesor, $tipo_cliente, $tipo_credito, $linea_credito, $codigo_postal, $estado, $delmuni, $colonia, $calle, $foto_perfil, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado,  $metodo_pago, $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $archivo_ine, $archivo_comprobante);
	#
} else {
	echo "- Nada que hacer <br>";
}
