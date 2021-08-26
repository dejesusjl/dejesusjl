<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado=date("Y-m-d H:i:s");
$usuario_creador=$_SESSION['usuario_clave'];
$usuario_loguin=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

?>

<!doctype html>
<html lang="en-gb" class="no-js"> 

<head>
  <title>Guardar Recurso</title>

  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="../../css/animate.css" rel="stylesheet">
  <link href="../../css/style.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <link href="../../css/tics.css" rel="stylesheet">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="57x57" href="../../img/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="../../img/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="../../img/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="../../img/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="../../img/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="../../img/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="../../img/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="../../img/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="../../img/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="../../img/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="../../img/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../../img/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="../../img/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">

  <!-- DataTables CSS -->
  <link href="../../plugins/datatables/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

  <!-- DataTables Responsive CSS -->
  <link href="../../plugins/datatables/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="../../plugins/datatables/dist/css/sb-admin-2.css" rel="stylesheet">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">


</head>

<body class="category-page construccion">

  <div class="columns-container">
    <div class="container" id="columns">    
      <div class="row">
        <br><br>
        <center><span class="image-construccion"><img src="../../img/300X300.png" alt=""></span></center>
        
        <br><br><br><br><br>

        <center>
          <div class="alert alert-success" role="alert" id="success_alert" style="display: none;">
            <h1>Movimiento Modificado EXITOSAMENTE</h1>
          </div>

          <div class="alert alert-danger" role="alert" id="fail_alert" style="display: none;">
            <h1>Se ha producido un ERROR al guardar la información</h1>

            

          </div>

          <div class="alert alert-info" role="alert" id="alert_alert" style="display: none;">

            <h4>Error al:</h4>


          </div>

        </center>   


      </div>   
    </div>
  </div>
  <?php 

  $idorden_logistica = base64_decode($_POST['idorden_logistica']);
  $idlogistica_encriptada = $_POST['idorden_logistica'];
  $idorden_logistica_documentacion = trim($_POST['idorden_logistica_documentacion']);
  $fecha_creacion = trim($_POST['fecha_creacion']);
  $tipo_moneda_documentacion = trim($_POST['tipo_moneda_documentacion']);
  $tipo_cambio_documentacion = trim($_POST['tipo_cambio_documentacion']);
  $monto_entrada_documentacion = trim($_POST['monto_entrada_documentacion']);
  $monto_entrada_documentacion_format = number_format($monto_entrada_documentacion,2);
  $coordenadas = trim($_POST['coordenadas']);


  $query_recurso = "SELECT * FROM orden_logistica_recurso where idorden_logistica_documentacion = '$idorden_logistica_documentacion'";
  $result_recurso = mysql_query($query_recurso);

  while ($row_recurso = mysql_fetch_array($result_recurso)) {

    $idorden_logistica_recurso = $row_recurso[idorden_logistica_recurso];
    $monto_db = $row_recurso[monto];
    $monto_db_format = number_format($monto_db, 2);
    $tipo_cambio_db = $row_recurso[tipo_cambio];
    $tipo_moneda_db = $row_recurso[tipo_moneda];
    $entrega_recepcion_recurso = $row_recurso[concepto];

    
    $descripcion_bitacora_sistema .= "El monto cambio de <b>$$monto_db_format $tipo_moneda_db</b> a <b>$$monto_entrada_documentacion_format $tipo_moneda_documentacion</b>";
    

  }


  $gran_total = $monto_entrada_documentacion * $tipo_cambio_documentacion;


  $update_recurso = "UPDATE orden_logistica_recurso set monto = '$monto_entrada_documentacion', tipo_moneda = '$tipo_moneda_documentacion', tipo_cambio = '$tipo_cambio_documentacion', gran_total = '$gran_total' where idorden_logistica_recurso = '$idorden_logistica_recurso'";
  $result_recurso_update = mysql_query($update_recurso);

  if ($result_recurso_update == 1) {

   $tipo_bitacora = "Documentación";
   $documento = "Recurso";
   $valor_bitacora = "11";

   $bitacora_documentacion = agregarBitacora ($descripcion_bitacora_sistema, $tipo_bitacora, $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, $valor_bitacora, $comentarios_bitacora, $documento);

   if ($bitacora_documentacion == "") {

    $update_documentacion = "UPDATE orden_logistica_documentacion SET monto_rembolso = '$monto_entrada_documentacion' WHERE idorden_logistica_documentacion = '$idorden_logistica_documentacion'"; 
    $result_documentacion = mysql_query($update_documentacion);

    if ($result_documentacion == 1) {

     $tipo_recurso = ($entrega_recepcion_recurso == "Recepción") ? "Ingreso" : "Egreso";

     $query_wallet = "SELECT * FROM empleados_wallet where visible = 'SI' AND idlogistica = '$idorden_logistica' and tipo = '$tipo_recurso' ";
     $result_wallet = mysql_query($query_wallet);
     
     while ($row_wallet = mysql_fetch_array($result_wallet)) {

      $query_update_wallet = "UPDATE empleados_wallet SET monto = '$monto_entrada_documentacion', tipo_moneda = '$tipo_moneda_documentacion', tipo_cambio = '$tipo_cambio_documentacion', gran_total = '$gran_total' where idempleados_wallet = '$row_wallet[idempleados_wallet]' ";
      $result_update_wallet = mysql_query($query_update_wallet);
      
      if ($result_update_wallet == 1) {

        $valor = ($entrega_recepcion_recurso == "Recepción") ? "2" : "1";
        $add_bitacora_wallet = insertarBitacoraWallet($row_wallet[idempleados_wallet], $row_wallet[referencia], "Recurso Cambio", $descripcion_bitacora_sistema, $valor, "SI", $fecha_creacion, $fecha_guardado, $idorden_logistica, "Logistica", $usuario_creador, $row_wallet[token], $tipo_recurso);

        if ($add_bitacora_wallet == 1) {

          $ver_errores = "Sin Errores";

        }else {

          $ver_errores = "Error al Actualizar bitacora Wallet";

        }

      }else {

        $ver_errores = "Error al Actualizar Wallet";

      }

    }

  }else{
    $ver_errores = "Error al cambiar el monto en Documentación";
  }

}else{
  $ver_errores = $bitacora_documentacion;
}


}else{
 $ver_errores = "Fallo"; 
}





function agregarBitacora ($descripcion_bitacora_sistema, $tipo_bitacora, $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, $valor_bitacora, $comentarios_bitacora, $documento){

 $bitacora_add = "INSERT INTO orden_logistica_bitacora (descripcion, tipo, idorden_logistica, usuario_creador, fecha_creacion, fecha_guardado, visible, coordenadas, valor, comentarios) VALUES ('$descripcion_bitacora_sistema', '$tipo_bitacora', '$idorden_logistica', '$usuario_creador','$fecha_creacion','$fecha_guardado','SI', '$coordenadas', '$valor_bitacora', '$comentarios_bitacora')";

 $result_bitacora = mysql_query($bitacora_add);

 $respuesta_bitacora = ($result_bitacora == 1) ? "" : "<br> - Error al Insertar $documento a Bitácora <br>";

 return $respuesta_bitacora;


}

#----------------------------------------------------------INSERTAR BITACORA WALLET-------------------------------------------------------------------------------------------


function insertarBitacoraWallet($idempleados_wallet, $referencia, $tipo, $descripcion, $valor, $visible, $fecha_creacion, $fecha_guardado, $id_id, $tipo_type, $usuario_creador,$columna_a, $tipo_egreso_ingreso) {

  $query_repetir_wallet = "SELECT * FROM wallet_bitacora WHERE visible = 'SI' and tipo = '$tipo' and fecha_creacion = '$fecha_creacion'";
  $result_repetir_wallet = mysql_query($query_repetir_wallet);

  if (mysql_num_rows($result_repetir_wallet) >=1 ) {

    $respuesta_bitacora_wallet = 0;

  }else {

    $valor_bitacora = ($tipo_egreso_ingreso == "Egreso") ? 1 : 2;

    $insert_bitacora_wallet = "INSERT INTO wallet_bitacora (idempleados_wallet, referencia, tipo, descripcion, valor, visible, fecha_creacion, fecha_guardado, id_id, tipo_type, usuario_creador, columna_a, columna_b) VALUES ('$idempleados_wallet', '$referencia', '$tipo', '$descripcion', '$valor_bitacora', '$visible', '$fecha_creacion', '$fecha_guardado', '$id_id', '$tipo_type', '$usuario_creador', '$columna_a', '$tipo_egreso_ingreso')";
    $result_bitacora_wallet = mysql_query($insert_bitacora_wallet);

    $respuesta_bitacora_wallet = ($result_bitacora_wallet == 1) ? "1" : "0";

  }

  return $respuesta_bitacora_wallet;
}





?>
<script>

  var si_error_no = '<?php echo $ver_errores; ?>'
  var idlogistica = '<?php  echo $idlogistica_encriptada;?>'


  if (si_error_no == "Sin Errores") {
    $('#success_alert').show(); 

    setInterval(ordenLogistica(idlogistica), 5000);




  }else if (si_error_no == "Fallo") {
    $('#fail_alert').show();  

    setInterval(salir, 5000);


  }else{
    $('#alert_alert').show(); 

    $("#alert_alert").append(si_error_no);


    var create = `
    <div class="col-sm-12">
    <div class="form-group">
    <div class="col-lg-12">
    <br>
    <center>
    <button class="btn btn-lg btn-primary" id="continuar">Continuar</button>
    </center>
    <br>
    </div>
    </div>
    </div>
    `;

    $("#alert_alert").append(create);
  }


  function salir(){
    location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#verdocumentacion`);
  }

  function ordenLogistica(idlogistica){
    location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#verdocumentacion`);
  }

  $(document).ready(function(){
    $("#continuar").click(function(){
      location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#verdocumentacion`);
    }); 

    $("#yes").click(function(){
      location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#verdocumentacion`);
    }); 

    $("#nel").click(function(){
      location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#verdocumentacion`);
    });
  });


</script>




</body>
</html>




