  <?php
  session_start();  
  include_once "../../config.php"; 
  require_once('../../bdd.php');
  include_once "../../recuperar_usuario.php"; 
  date_default_timezone_set('America/Mexico_City');
  $fecha_guardado=date("Y-m-d H:i:s"); 
  $usuario_creador=$_SESSION['usuario_clave'];
  $empleados=$_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);
?>

<!doctype html>
<html lang="es" class="no-js"> 

<head>
  <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Guardar VIN General</title>

  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="../../css/animate.css" rel="stylesheet">
  <link href="../../css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/styles_neumorphism_alert.css">
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

<body>

<div class="neu-container-page" style="overflow: auto;">

  <div>
    <div class="neu-container-general neu-animation-container">
    
      <div class="d-flex justify-content-center">
        <img class="neu-logo" src="../../img/GRUPOPANAMOTORSPLATA.png" alt="">
      </div>

      <div class="d-flex justify-content-center">
        <div id="success_alert" class="neu-container-alert mt-4" style="display: none;">
          <div class="d-flex justify-content-center align-items-center neu-alert neu-alert-correcto">
            <h1 class="text-center text-white">VIN modificado exitosamente</h1>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-center">
        <div id="fail_alert" class="neu-container-alert mt-4" style="display: none;">
          <div class="d-flex justify-content-center align-items-center neu-alert neu-alert-error">		
            <h1 class="text-center text-white">Se ha producido un error al guardar la información </h1>
          </div>
        </div>			
      </div>

      <div class="d-flex justify-content-center">
        <div id="alert_alert" class="neu-container-alert mt-4" style="display: none;">
          <div class="neu-alert neu-alert-error-tipo">
            <h4 class="text-center text-white">Error al: </h4>
          </div>
        </div>
      </div>

      <div id="content-contador" class="mt-4">
        <div class="content-contador d-flex justify-content-center align-items-center">
          <div class="contador text-center">
            <p class="text-redirigir mb-0">Seras redirigido en</p>
            <span class="numero-contador">0</span>
          </div>
        </div>				
      </div>

    </div>
  </div>

</div>

  <?php 

  $idorden_logistica = base64_decode($_POST['idlogistica']);
  $idlogistica_encriptada = $_POST['idlogistica'];
  $comentarios = trim($_POST['comentarios']);
  $fecha_creacion = trim($_POST['fecha_creacion']);


  $vin_herramienta = trim($_POST['vin_herramienta']);
  $coordenadas = trim($_POST['coordenadas']);

  $ver_errores = 0;

  $query_balance = "SELECT * FROM balance_gastos_operacion where columna2 = '$idorden_logistica' and visible = 'SI'";
  $result_balance = mysql_query($query_balance);

  if (mysql_num_rows($result_balance) == 0) {
    $ver_errores = "Fallo";
  }else{

    while ($row_balance = mysql_fetch_array($result_balance)) {


      if (trim($row_balance[datos_vin]) !== "N/A") {


        if (trim($row_balance[datos_vin]) !== $vin_herramienta) {


          $apartado_usado = $row_balance[apartado_usado];
          $vin_old = trim($row_balance[datos_vin]);
          $idbalance_gastos_operacion = trim($row_balance[idbalance_gastos_operacion]);


          $porciones = explode("|", $row_balance[apartado_usado]);

          foreach ($porciones as $key => $value) {

            if ($value == $vin_old) {
              $reemplazar = array($key => $vin_herramienta);
              $nuevo_array_reemplazado = array_replace($porciones, $reemplazar);

              $nuevo_array_insertar = implode("|", $nuevo_array_reemplazado);


              $update_balance = "UPDATE balance_gastos_operacion SET apartado_usado = '$nuevo_array_insertar', datos_vin = '$vin_herramienta' WHERE idbalance_gastos_operacion = '$idbalance_gastos_operacion'" ; 
              $result_update_balance = mysql_query($update_balance);

              if ($result_update_balance == 1) {

                $descripcion_bitacora_sistema = "Se actualizo el VIN de: <b>$vin_old</b> por: <b>$vin_herramienta</b> <br> Y La cadena auxiliares cambio de: <br> <b>$apartado_usado</b> a: <br> <b>$nuevo_array_insertar</b>";
                $tipo_bitacora = "VIN General";
                $valor_bitacora = "3";
                $comentarios_bitacora = $comentarios;

                $insert_bitacora = agregarBitacora($descripcion_bitacora_sistema, $tipo_bitacora, $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, $valor_bitacora, $comentarios_bitacora);

                $ver_errores .= ($insert_bitacora == "") ? "" : $insert_bitacora;

                //Actualizar Balance de Gastos Auxiliares

                $query_auxiliares = "SELECT * FROM balance_gastos_auxiliares WHERE idlogistica = '$idbalance_gastos_operacion' and TRIM(nombre) = '$vin_old'";
                $result_auxiliares = mysql_query($query_auxiliares);

                while ($row_auxiliares = mysql_fetch_array($result_auxiliares)) {

                 $update_auxiliares = "UPDATE balance_gastos_auxiliares SET nombre = '$vin_herramienta' WHERE idbalance_gastos_auxiliares = '$row_auxiliares[idbalance_gastos_auxiliares]'";
                 $result_updae_auxiliares = mysql_query($update_auxiliares);

                 if ($result_updae_auxiliares == 1) {

                  $ver_errores ++ ;

                }else{
                  $ver_errores .= "- Error al Actualizar tabla Auxiliares movimiento $row_auxiliares[idbalance_gastos_auxiliares] <br>";
                }

              }





            }else{
              $ver_errores .= "- Error con el movimiento $idbalance_gastos_operacion <br>";
            }





          }
        }
          //var_dump($porciones);
          //var_dump($nuevo_array);
      }
    }else{

      $auxiliar_insert_vin = $row_balance[apartado_usado]."$vin_herramienta|";

      $update_balance_add_vin = "UPDATE balance_gastos_operacion SET apartado_usado = '$auxiliar_insert_vin', datos_vin = '$vin_herramienta' WHERE idbalance_gastos_operacion = '$row_balance[idbalance_gastos_operacion]'"; 
      
      $result_update_balance_add_vin = mysql_query($update_balance_add_vin);

      if ($result_update_balance_add_vin == 1) {
       $descripcion_bitacora_sistema = "Se Agrego el VIN: <b>$vin_herramienta</b> ya que el movimiento no tiene VIN Y se agrega a la tabla de auxiliares.";
       $tipo_bitacora = "Auxiliar VIN";
       $valor_bitacora = "7";
       $comentarios_bitacora = $comentarios;

       $insert_bitacora_vin = agregarBitacora($descripcion_bitacora_sistema, $tipo_bitacora, $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, $valor_bitacora, $comentarios_bitacora);

       if ($insert_bitacora_vin == "") {

        $insert_auxiliares = "INSERT INTO balance_gastos_auxiliares (nombre, idauxiliar_principales, idlogistica, fecha_movimiento, visible, usuario_creador, fecha_creacion, fecha_guardado) VALUES ('$vin_herramienta', '$row_balance[idauxiliar_principales]', '$row_balance[idbalance_gastos_operacion]', '$row_balance[fecha_movimiento]', 'SI', '$usuario_creador', '$fecha_creacion', '$fecha_guardado')";
        $result_insert = mysql_query($insert_auxiliares);

        if ($result_insert == 1) {

         $descripcion_insert_vin = "Se Agrego el VIN: <b>$vin_herramienta</b> ya que el movimiento no tiene VIN Y se agrega a la tabla de auxiliares.";
         $tipo_bitacora_vin = "Auxiliar VIN";
         $valor_bitacora_vin = "7";
         $comentarios_bitacora_vin = $comentarios;

         $insert_bitacora_aux_vin = agregarBitacora($descripcion_insert_vin, $tipo_bitacora_vin, $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, $valor_bitacora_vin, $comentarios_bitacora_vin);

         $ver_errores .= ($insert_bitacora_aux_vin == "")? $ver_errores ++ : $insert_bitacora_aux_vin;



       }else{
        $ver_errores.= "- Error al insertar la tabla <b>Auxiliares</b> <br>";
      }

    }else{

      $ver_errores .= $insert_bitacora_vin;

    }
  }else{
    $ver_errores .= "- Error al insertar el nuevo VIN <br>";
  }
}
}
}


$ver_errores = (is_numeric($ver_errores)) ? "Sin Errores" : $ver_errores ;



function agregarBitacora ($descripcion_bitacora_sistema, $tipo_bitacora, $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, $coordenadas, $valor_bitacora, $comentarios_bitacora){

 $bitacora_add = "INSERT INTO balance_gastos_operacion_bitacora (descripcion, tipo, idorden_logistica, usuario_creador, fecha_creacion, fecha_guardado, visible, coordenadas, valor, comentarios) VALUES ('$descripcion_bitacora_sistema', '$tipo_bitacora', '$idorden_logistica', '$usuario_creador','$fecha_creacion','$fecha_guardado','SI', '$coordenadas', '$valor_bitacora', '$comentarios_bitacora')";

 $result_bitacora = mysql_query($bitacora_add);

 $respuesta_bitacora = ($result_bitacora == 1) ? "" : "<br> - Error al Insertar $tipo_bitacora a Bitácora <br>";

 return $respuesta_bitacora;


}







?>
<script>

 var si_error_no = '<?php echo $ver_errores; ?>'
 var idlogistica = '<?php  echo $idlogistica_encriptada;?>'

 if (si_error_no == "Sin Errores") {
  $('#success_alert').show(); 
  $("#content-contador").show();
  redireccionPagina();

}else if (si_error_no == "Fallo") {
  $('#fail_alert').show();  
  $("#content-contador").show();
  redireccionPagina();

}else{
  $('#alert_alert').show(); 
  $("#content-contador").hide();

  $(".neu-alert-error-tipo").append("<p class='text-white mb-0' style='position: relative; z-index: 2;'>"+ si_error_no +"</p>");



  var create = `
  <div class="d-flex justify-content-center mt-4">
				<button class="btn btn-lg btn-primary" id="continuar">Continuar</button>
			</div>
  `;

  $("#alert_alert").append(create);
}



$(document).ready(function(){
  $("#continuar").click(function(){
    location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#ver_balance_gastos`);
  }); 

  // $("#yes").click(function(){
  //   location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#ver_balance_gastos`);
  // }); 

  // $("#nel").click(function(){
  //   location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#ver_balance_gastos`);
  // });
});


function redireccionPagina(){
			delayPagina();
			contadorRedirigir();		
		}

		function delayPagina(){
			var delay = 3000;
			setTimeout(() => {
				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#ver_balance_gastos`);
			}, delay);
		}

		function contadorRedirigir(){
			$('.numero-contador').each(function () { 
				$(this).prop('Counter', 3).animate(
					{ 
						Counter: $(this).text() 
					}, 
					{ 
						duration: 3000, 
						easing: 'swing', 
						step: function (now) { 
							$(this).text(Math.ceil(now)); 
						} 
					}
				); 
			});
		}

		const neu_animation_container = document.querySelector(".neu-animation-container");
		neu_animation_container.classList.add("add-neu-animation-container");


</script>




</body>
</html>




