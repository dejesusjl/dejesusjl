<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$fecha_token = date("YmdHis");
$usuario_creador_loguin = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];


$fecha_movimiento = date("Y-m-d");

# Inician Recepcion de Variables
$id_logistica = base64_decode($_POST['idlogistica']);
$referencia_movimiento = $_POST['referencia_movimiento'];
$tipo_token = $_POST['tipo_token'];


$id_colaborador = $_POST['id_colaborador'];
$type_colaborador = $_POST['type_colaborador'];

$fecha_creacion = $_POST['fecha_creacion'];
$coordenadas_recurso = $_POST['coordenadas_token'];
$comentarios = $_POST['columna_c'];
$idcatalogo_tesorerias = $_POST['idcatalogo_tesorerias'];
$visible = "SI";


echo $query_empleados_wallet = "SELECT * FROM empleados_wallet WHERE visible = 'SI' AND referencia_seguimiento = '$referencia_movimiento' and tipo_movimiento = 'abono' and tipo = 'Ingreso' order by idempleados_wallet asc limit 1";
$result_empleados_wallet = mysql_query($query_empleados_wallet);

if (mysql_num_rows($result_empleados_wallet) >= 1) {

  $mensaje = "while";
/*
  while ($row_empleados_wallet = mysql_fetch_array($result_empleados_wallet)) {

    if ($type_colaborador == "Tesoreria") {

      $pasar_tesoreria = $id_colaborador;

      $receptor = $id_colaborador;
      $tipo_receptor = $type_colaborador;


    }else {

      $pasar_tesoreria = $row_empleados_wallet[tesoreria];

      if ($id_colaborador == "78" and $type_colaborador = "Colaborador") {

        $receptor = "TP1";
        $tipo_receptor = "Tesoreria";

      }else if ($id_colaborador == "116" and $type_colaborador = "Colaborador") {

        $receptor = "TJFR";
        $tipo_receptor = "Tesoreria";

      }else if ($id_colaborador == "118" and $type_colaborador = "Colaborador") {

        $receptor = "TEDFM";
        $tipo_receptor = "Tesoreria";

      }else {

        $receptor = $id_colaborador;
        $tipo_receptor = $type_colaborador;
        
      }
    }


    $aplicar_recurso = ConsultarReferenciaSeguimiento ($row_empleados_wallet[referencia_seguimiento]);

    if (trim($aplicar_recurso) == "Pendiente") {


      $pasar_emisor = (trim($row_empleados_wallet[receptor]) == $empleados) ? $empleados : $row_empleados_wallet[receptor];

      $token_traspaso = generate_token($ok);

      $insert_to_wallet = Wallet_Id_tInsert ($fecha_movimiento, "abono", $row_empleados_wallet[monto], $row_empleados_wallet[tipo_moneda], $row_empleados_wallet[tipo_cambio], $row_empleados_wallet[gran_total], $row_empleados_wallet[gran_total], $row_empleados_wallet[id], $row_empleados_wallet[tipo_id], $row_empleados_wallet[tabla], $pasar_tesoreria, $row_empleados_wallet[idlogistica], "Pendiente", $pasar_emisor, $row_empleados_wallet[tipo_receptor], $receptor, $tipo_receptor, $row_empleados_wallet[referencia], $token_traspaso, $visible, $usuario_creador, $empleados, $fecha_creacion, $fecha_guardado, $row_empleados_wallet[referencia_seguimiento], "1", "Ingreso");

      $porciones_trim_insert_wallet = explode("|", $insert_to_wallet);

      if ($porciones_trim_insert_wallet[0] == 1) {

        $referencia = "$empleados/$fecha_token/$porciones_trim_insert_wallet[1]/$empleados/$usuario_creador/$receptor";

        $query_update_wallet = "UPDATE empleados_wallet SET referencia = '$referencia' WHERE visible='SI' AND idempleados_wallet = '$porciones_trim_insert_wallet[1]'";
        $result_update_wallet = mysql_query($query_update_wallet);

        if ($result_update_wallet == 1) {

          $ver_name_emisor = nombres_datos($pasar_emisor, "Colaborador");
          $name_emisor = explode("|", $ver_name_emisor);

          if ($type_colaborador == "Tesoreria") {

            $nombre_emisor = $id_colaborador;

          }else{

            $ver_name_receptor = nombres_datos($id_colaborador, "Colaborador");
            $name_receptor = explode("|", $ver_name_receptor);
            $nombre_emisor = $name_receptor[10];

          }

          $insert_bitacora_logistica_new = LogisticaInsertBitacora ($descripcion, "Token", $id_logistica, $token_traspaso, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "13", $columna_c, $columna_d, $visible);


          $descripcion = "Se realizo un traspaso de $name_emisor[10] a $nombre_emisor con estatus <b>Pendiente</b> por un monto de ".number_format($row_empleados_wallet[monto],2)." con fecha $fecha_movimiento, referencia <b>$row_empleados_wallet[referencia_seguimiento]</b>";
          $insert_bitacora_wallet_new =  WalletInsertBitacora ($porciones_trim_insert_wallet[1], $row_empleados_wallet[referencia_seguimiento], "Traspaso Recurso", $descripcion, "2", $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $id_logistica, "Logistica", $token_traspaso, "Ingreso", $comentarios, $columna_d, $columna_e);

          if ($insert_bitacora_logistica_new == 1 AND $insert_bitacora_wallet_new == 1) {

            $insert_to_referencia_wallet = ReferenciaWalletInsert ($row_empleados_wallet[referencia_seguimiento], $row_empleados_wallet[gran_total], $row_empleados_wallet[idempleados_wallet], $visible, $usuario_creador, $empleados, $fecha_creacion, $fecha_guardado);

            if ($insert_to_referencia_wallet == 1) {

              $mensaje = UpdateInsertRecurso ($id_logistica, $idcatalogo_tesorerias, $comentarios, $usuario_creador, $fecha_guardado);

            }else {

              $mensaje = $insert_to_referencia_wallet;

            }

          }else {

            $mensaje = "Error al insertar Bitácoras: $insert_bitacora_logistica_new $insert_bitacora_wallet_new";

          }

        }else {

          $mensaje = "- Error al actualizar la referencia de recurso <br>";
        }

      }else{

        $mensaje = "- Error al aplicar el recurso <br> $insert_to_wallet";

      }
    }else {

      $mensaje = "- El Movimiento ya fue <b>Aplicado</b><br>";

    }
  } #WHILE*/

}else {

  $mensaje = "- El Movimiento no <b>Existe</b><br>";

}

echo $mensaje;

#-------------------------------------------Funcion INSERT WALLET--------------------------------------------------------------------------------

function Wallet_Id_tInsert ($fecha_movimiento, $tipo_movimiento, $monto, $tipo_moneda, $tipo_cambio, $gran_total, $monto_real, $id, $tipo_id, $tabla, $tesoreria, $idlogistica, $estatus, $emisor, $tipo_emisor, $receptor, $tipo_receptor, $referencia, $token, $visible, $usuario_creador, $empleado_creador, $fecha_creacion, $fecha_guardado, $referencia_seguimiento, $metodo_pago, $tipo) {

  $query_duplicar_wallet = "SELECT * FROM empleados_wallet WHERE idlogistica = '$idlogistica' and tipo = '$tipo' and fecha_creacion = '$fecha_creacion' and emisor = '$emisor' and tipo_emisor = '$tipo_emisor' and tipo_receptor = '$tipo_receptor'";
  $result_duplicar_wallet = mysql_query($query_duplicar_wallet);

  if (mysql_num_rows($result_duplicar_wallet) == 0) {

    $query_insert_wallet = "INSERT INTO empleados_wallet (fecha_movimiento, tipo_movimiento, monto, tipo_moneda, tipo_cambio, gran_total, monto_real, id, tipo_id, tabla, tesoreria, idlogistica, estatus, emisor, tipo_emisor, receptor, tipo_receptor, referencia, token, visible, usuario_creador, empleado_creador, fecha_creacion, fecha_guardado, referencia_seguimiento, metodo_pago, tipo) VALUES ('$fecha_movimiento', '$tipo_movimiento', '$monto', '$tipo_moneda', '$tipo_cambio', '$gran_total', '$monto_real', '$id', '$tipo_id', '$tabla', '$tesoreria', '$idlogistica', '$estatus', '$emisor', '$tipo_emisor', '$receptor', '$tipo_receptor', '$referencia', '$token', '$visible', '$usuario_creador', '$empleado_creador', '$fecha_creacion', '$fecha_guardado', '$referencia_seguimiento', '$metodo_pago', '$tipo')";
    $result_insert_wallet = mysql_query($query_insert_wallet);

    $respuesta_insert = mysql_query("SELECT @@identity AS id");

    if ($row_respuesta = mysql_fetch_row($respuesta_insert)){

      $id_respuesta = trim($row_respuesta[0]);

    }

    return ($result_insert_wallet == 1)? "1|$id_respuesta" : "- Ocurrio un error al guardar el $tipo <br>";

  }else {

    return "-No se puede duplicar el movimiento <br>";

  }
}
#----------------------------------------------------------INSERTAR Recurso Entrega Actualizar Recurso-------------------------------------------------------------------------------------------

function UpdateInsertRecurso ($id_logistica, $idcatalogo_tesorerias, $comentarios_auditor, $usuario_creador, $fecha_guardado) {

  $idcatalogo_tesorerias = (trim($idcatalogo_tesorerias) == "") ? "P/D" : $idcatalogo_tesorerias;

  $query_orden_logistica_recurso = "SELECT * FROM orden_logistica_recurso WHERE estatus <> 'Cancelado' and idorden_logistica = '$id_logistica' ";
  $result_orden_logistica_recurso = mysql_query($query_orden_logistica_recurso);

  while ($row_orden_logistica_recurso = mysql_fetch_array($result_orden_logistica_recurso)) {

    $update_recurso = "UPDATE orden_logistica_recurso SET estatus = 'Entregado', id_tesoreria = '$idcatalogo_tesorerias', metodo_pago = '1', comentarios_auditor = '$comentarios_auditor', fecha_auditada = '$fecha_guardado', usuario_auditor = '$usuario_creador' WHERE idorden_logistica_recurso = '$row_orden_logistica_recurso[idorden_logistica_recurso]'";
    $result_update_recurso = mysql_query($update_recurso);

    $resultado_entrega_reguso = ($result_update_recurso == 1) ? 1 : "- Error al actualizar el estatus del recurso de <b>Logistica</b> <br>";

  }

  return $resultado_entrega_reguso;
}






?>
