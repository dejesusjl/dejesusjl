<?php
session_start();
include_once "../../config.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$usuario_creador = $_SESSION['usuario_clave'];

$estatus = $_POST['estatus'];
$idorden_logistica = $_POST['idorden_logistica'];
$comentarios = $_POST['comentarios'];
$coordenadas = $_POST['coordenadas'];
$fecha_creacion = $_POST['fecha_creacion'];


$estatusDB =  EstatusPrincipalLogistica($idorden_logistica);

$bitacora_descripcion = "El estatus cambio de <b>" . $estatusDB . "</b> a <b>$estatus</b><br>";

$insertar_movimiento = LogisticaInsertBitacora($bitacora_descripcion, $estatus, $idorden_logistica, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "1", "", "", "SI");

if ($insertar_movimiento == 1) {

  $query_principal = "UPDATE orden_logistica set estatus = '$estatus' where idorden_logistica = '$idorden_logistica'";
  $result_principal = mysql_query($query_principal);

  if ($estatus == "Cancelado") {

    $query_cancelar = "UPDATE orden_logistica set estatus = '$estatus', idasigna = 'N/A' where idorden_logistica = '$idorden_logistica'";
    $result_cancelar = mysql_query($query_cancelar);

    if ($result_cancelar == 1) {

      $mensaje = CancelarRecurso($idorden_logistica, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado);
    } else {

      $mensaje = "- Error en el Trasladista Principal para Cancelar";
    }
  } else {

    $mensaje = 1;
    $whats = "";
  }
} else {

  $mensaje = $insertar_movimiento;
}






function CancelarRecurso($idorden_logistica, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado)
{

  $concatenar_referencias = array();
  $resultados_array = array();

  $query_recurso = "SELECT * FROM orden_logistica_recurso WHERE idorden_logistica = '$idorden_logistica' AND estatus <> 'Cancelado'";
  $resut_recurso = mysql_query($query_recurso);

  if (mysql_num_rows($resut_recurso) >= 1) {

    while ($row_recurso = mysql_fetch_array($resut_recurso)) {

      $update_recibos = "UPDATE orden_logistica_recurso SET receptora_agente = 'N/A', estatus = 'Cancelado', comentarios_auditor = 'Logística Cancelada', fecha_auditada = '$fecha_guardado', usuario_auditor = '$usuario_creador' WHERE idorden_logistica_recurso = '$row_recurso[idorden_logistica_recurso]'";
      $result_recibos = mysql_query($update_recibos);

      array_push($concatenar_referencias, $row_recurso[referencia]);
    }

    $tratar_array = Tratar_Array($concatenar_referencias);

    foreach ($tratar_array as $key => $value) {

      $query_wallet = "SELECT * FROM empleados_wallet WHERE referencia_seguimiento = '$value' ORDER BY idempleados_wallet DESC LIMIT 1";
      $result_wallet = mysql_query($query_wallet);

      while ($row_wallet = mysql_fetch_array($result_wallet)) {

        $valor = ($row_wallet[tipo] == "Egreso") ? 1 : 2;
        $insert_bitacora = WalletInsertBitacora($row_wallet[idempleados_wallet], $row_wallet[referencia_seguimiento], "Eliminar Movimiento", "Logística Cancelada", $valor, 'SI', $usuario_creador, $fecha_creacion, $fecha_guardado, $row_wallet[idempleados_wallet], "Wallet", $row_wallet[token], $row_wallet[tipo], $comentarios, "", "");

        array_push($resultados_array, $insert_bitacora);
      }
    }
    $tratar_resultados = Tratar_Array($resultados_array);

    $mensaje_cancelar_recurso = TratarNumeroText($tratar_resultados);
  } else {

    $mensaje_cancelar_recurso = 1;
  }

  return $mensaje_cancelar_recurso;
}
