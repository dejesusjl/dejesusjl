<?php
session_start();  
include_once "../../config.php";  
include_once "../../recuperar_usuario.php";
$fecha_actual = date("l"); 


$usuario_creador = $_SESSION['usuario_clave'];
date_default_timezone_set('America/Mexico_City');
$fecha_guardado= date("Y-m-d H:i:s");   


$fecha_hora_programada = $_POST['fecha_hora_programada'];
$comentario = $_POST['comentario_programada'];
$id_logisticapasar = base64_decode($_POST['id_logistica_cambio']);
$fecha_creacion = $_POST['fecha_creacion_programada'];
$coordenadas = $_POST['coordenadas_programada'];

$visible = "SI";

$idlogistica_encriptada = base64_encode($id_logisticapasar);




$update = "UPDATE orden_logistica SET fecha_programada = '$fecha_hora_programada' where idorden_logistica = '$id_logisticapasar'";


$result_orden_logistica = mysql_query($update);

if ($result_orden_logistica == 1) {

  $query = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$id_logisticapasar'";
  $result_query = mysql_query($query);

  while ($row = mysql_fetch_array($result_query)) {
    $calle_origen = $row[calle_origen];
    $estado_origen = $row[estado_origen];
  }

  $bitacora_descripcion ="Cambio de Fecha Programada";
  $bitacora_tipo = "Fecha Programada";
  $bitacora_valor = "10";
  $insert_programada = insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador, $comentario);

  $valor0 = ($insert_programada == ";") ? 1 : $insert_programada ;

  if ($fecha_actual == "Saturday") {
    $nomenclatura = "MAMM";
    $whats_vane = trim("7227507535");
  }else{
    $nomenclatura = "MAMM";
    $whats_vane = trim("7227507535");
  }

    #Bitacora
  $bitacora_descripcion = "<b>$nomenclatura</b> tuvimos una modificación en la logística No. <b>$id_logisticapasar</b> con destino a <b>$calle_origen, $estado_origen</b> por que: <b>$comentario</b> conoce los detalles consultando CCP";
  $mensaje_programada_whtas = "*$nomenclatura* tuvimos una modificación en la logística No. *$id_logisticapasar* con destino a *$calle_origen,* *$estado_origen* por que: *$comentario* conoce los detalles consultando CCP";

  $bitacora_tipo = "Notificación";
  $bitacora_valor = "2";
  $insert_bitacora = insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador, $comentario);

  $valor1 = ($insert_bitacora == ";") ? 1 : $insert_bitacora;

  

  $whatsapp = "https://api.whatsapp.com/send?phone=52$whats_vane&text=$mensaje_programada_whtas";

  $suma = $valor+$valor0+$valor1;


  if (is_numeric($suma)) {
    echo "Sin Errores|$whatsapp";
  }else{
    echo "$valor0"."$valor1";
  }

  




}else{

  $ver_errores = "Fallo|";


}



  #----------------------------------------------------------INSERTAR BITACORA-------------------------------------------------------------------------------------------

function insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador, $comentario) {


  $insert_bitacora = "INSERT INTO orden_logistica_bitacora (descripcion, tipo, idorden_logistica, usuario_creador, fecha_creacion, fecha_guardado, visible, coordenadas, valor,comentarios) VALUES ('$bitacora_descripcion', '$bitacora_tipo', '$id_logisticapasar', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', 'SI', '$coordenadas', '$bitacora_valor', '$comentario')";
  $result_bitacora = mysql_query($insert_bitacora);

  $respuesta_bitacora = ($result_bitacora == 1) ? ";" : "- ERROR en bitacora de tipo: $bitacora_tipo <br>";


  return $respuesta_bitacora;

}


?>
