<?php
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
date_default_timezone_set('America/Mexico_City');
$fecha_guardado=date("Y-m-d H:i:s"); 
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
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
  <title>CCP | Guardar Unidades</title>

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
              <h1 class="text-center text-white">VINES agregados exitosamente</h1>
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

  $fecha_creacion = $_POST['fecha_creacion_herramienta_trabajo'];
  $coordenadas = $_POST['coordenadas_vin'];

  $idresponsable = trim($_POST['id_responsable_vin_logistica']);
  $tipo_responsable = trim($_POST['tipo_responsable_vin_logistica']);


  $idlogistica_encriptada = $_POST['idorden_logisticaht'];
  $tipo_unidad_insertar = $_POST['tipo_unidad_insertar'];



  $idorden_logistica = base64_decode($idlogistica_encriptada);

  if ($idresponsable == "" || $idresponsable == null || $idresponsable == "N/A") {

    $idresponsable = null;
    $tipo_responsable = null;

  }else{
    $idresponsable = $idresponsable;
    $tipo_responsable = $tipo_responsable;
  }



  #----------------------------------------------------------Vines-------------------------------------------------------------------------------------------

  $tipo_orden_recibir = $_POST['rol_vin'];
  $vin_recibir = $_POST['soy_vin'];
  $marca_recibir = $_POST['soy_marca'];
  $version_recibir = $_POST['soy_version'];
  $color_recibir = $_POST['soy_color'];
  $modelo_recibir = $_POST['soy_modelo'];
  $tipo_unidad_recibir = $_POST['tipo_vin'];
  $id_asignado_recibir = $_POST['idpersona_asignada_ht'];

  $agrupar_vines = array();

  for ($i=0; $i < count($vin_recibir) ; $i++) { 

    if ($vin_recibir[$i] != "") {
     array_push($agrupar_vines, trim($vin_recibir[$i])."*".trim($tipo_orden_recibir[$i])."*".trim($marca_recibir[$i])."*".trim($version_recibir[$i])."*".trim($color_recibir[$i])."*".trim($modelo_recibir[$i])."*".trim($tipo_unidad_recibir[$i])."*".trim($id_asignado_recibir[$i])."|");
   }

 }


 $eliminar_vines_duplicados = array_unique($agrupar_vines);

 $agrupar_vines_eliminados = substr(implode($eliminar_vines_duplicados), 0,-1);

 $nuevo_array_ayudantes = explode("|", $agrupar_vines_eliminados);

 $tipo_orden = array();
 $vin = array();
 $marca = array();
 $version = array();
 $color = array();
 $modelo = array();
 $tipo_unidad = array();
 $id_asignado = array();

 for ($j=0; $j < count($nuevo_array_ayudantes) ; $j++) { 

  $particion_ayudantes = explode("*", $nuevo_array_ayudantes[$j]);

  array_push($vin, trim($particion_ayudantes[0]));
  array_push($tipo_orden, trim($particion_ayudantes[1]));
  array_push($marca, trim($particion_ayudantes[2]));
  array_push($version, trim($particion_ayudantes[3]));
  array_push($color, trim($particion_ayudantes[4]));
  array_push($modelo, trim($particion_ayudantes[5]));
  array_push($tipo_unidad, trim($particion_ayudantes[6]));
  array_push($id_asignado, trim($particion_ayudantes[7]));
  

}




if (count($vin) >=1) {

 for ($i=0; $i < sizeof($vin) ; $i++) { 

   $query_vin_repetido = "SELECT * FROM orden_logistica_unidades WHERE TRIM(vin) = '".$vin[$i]."' AND visible = 'SI' and idorden_logistica = '$idorden_logistica'";
   $result_vin_repetido = mysql_query($query_vin_repetido);
   
   if (mysql_num_rows($result_vin_repetido) == 0 ) {

    $separador = explode(";", $id_asignado[$i]);
    $idpersona_asignada = $separador[0];
    
    $tipopersona_asignada = $separador[1];

    $insert_unidades = "INSERT INTO orden_logistica_unidades (tipo_orden, vin, tipo_unidad, idresponsable, tipo_responsable, idpersona_asignada, tipopersona_asignada, idorden_logistica, visible, usuario_creador, fecha_creacion, fecha_guardado) VALUES ('".$tipo_orden[$i]."','".$vin[$i]."','".$tipo_unidad[$i]."','$idresponsable','$tipo_responsable','$separador[0]','$separador[1]','$idorden_logistica','SI','$usuario_creador','$fecha_creacion','$fecha_guardado')";
    $result_unidades = mysql_query($insert_unidades);
    $result_unidades = 1;
    if ($result_unidades == 1) {

      if ($tipo_unidad[$i] == "Utilitario") {

        $query_unidades = "SELECT * FROM catalogo_unidades_utilitarios WHERE TRIM(vin) = '$vin[$i]'";
        $result_unidades = mysql_query($query_unidades);

        while ($row_unidades = mysql_fetch_array($result_unidades)) {

         $update_utilitario = "UPDATE catalogo_unidades_utilitarios SET estatus_unidad = 'En Ruta' WHERE idcatalogo_unidades_utilitarios = '$row_unidades[idcatalogo_unidades_utilitarios]'";
         $result_utilitario = mysql_query($update_utilitario);

         if ($result_utilitario == 1) {

           $ver_errores .= "1|";

         }else{

           $ver_errores .= "Error al Actualizar estatus de: <b>$vin[$i]</b> <br>|";
         }

       }
     }


     if ($tipo_unidad[$i] == "Indefinido") {


      $query_vin_new = "SELECT * FROM orden_logistica_inventario WHERE TRIM(vin) = '$vin[$i]'";
      $result_vin_new = mysql_query($query_vin_new);

      if (mysql_num_rows($result_vin_new) == 0) {

       $insert_inventario = "INSERT INTO orden_logistica_inventario (vin, marca, version, color, modelo, visible, fecha_creacion, fecha_guardado, idorden_logistia, tipo_unidad_inventario, tipo, estatus_unidad) VALUES ('$vin[$i]', '$marca[$i]', '$version[$i]', '$color[$i]', '$modelo[$i]', 'SI', '$fecha_creacion', '$fecha_guardado', '$idorden_logistica', '$tipo_unidad_insertar[$i]', 'Logistica', 'NO')";
       $result_inventario = mysql_query($insert_inventario);

       if ($result_inventario == 0) {
        $ver_errores .= "Error al insertar a Inventario Tempral el VIN: <b>$vin[$i]</b> <br>|";

      }else{
        $ver_errores .= "1|";
      }


    }

  }



  $descripcion_cambio = "Se Asignó La Unidad con el VIN <b>$vin[$i]</b>";
  $tipo = "VIN";


  $insert_bitacora_vin = insert_bitacora ($descripcion_cambio, $tipo, $idorden_logistica, $usuario_creador, $fecha_creacion, $fecha_guardado, "SI", $coordenadas, "7", "");

  $ver_errores .= ($insert_bitacora_vin == 1) ? "1|" : $insert_bitacora_vin;


}else{
  $ver_errores .= "- Error al Insertar VIN: <b>$vin[$i]</b> <br>|";
}

}
}

}else {
  $ver_errores = "Fallo";
}



$porciones_errores = explode("|", $ver_errores);

foreach ($porciones_errores as $key => $new_valor) {

  if (trim($new_valor) != "1") {
    $queda_valor .= $new_valor;
  }

}


$ver_errores = ($queda_valor == "") ? "Sin Errores" : $queda_valor ;


#----------------------------------------------------------Insert Bitacora------------------------------------------------------------------------------------------

function insert_bitacora ($descripcion_bitacora, $tipo_bitacora, $idorden_logistica, $usuario_creador_bitacora, $fecha_creacion_bitacora, $fecha_guardado_bitacora, $visible, $coordenadas_bitacora, $valor_bitacora, $comentarios_bitacora){

  $insert_bitacora = "INSERT INTO orden_logistica_bitacora (descripcion, tipo, idorden_logistica, usuario_creador, fecha_creacion, fecha_guardado, visible, coordenadas, valor, comentarios) VALUES ('$descripcion_bitacora', '$tipo_bitacora', '$idorden_logistica', '$usuario_creador_bitacora','$fecha_creacion_bitacora','$fecha_guardado_bitacora','$visible', '$coordenadas_bitacora', '$valor_bitacora', '$comentarios_bitacora')";

  $result_insert_bitacora = mysql_query($insert_bitacora);

  return  $resultado_bitacora = ($result_insert_bitacora == 1) ? "1" : "|Error al Insertar Bitacora $tipo_bitacora <br>|" ;

}



?>
<script>

  var si_error_no = '<?php echo $ver_errores; ?>'
  var numeros_whats ='<?php echo $whatsapp_colaboradores;?>'
  var idlogistica = '<?php  echo $idlogistica_encriptada;?>'
  console.log(si_error_no);

  if (si_error_no == "Sin Errores") {
    $('#success_alert').show(); 
    $("#content-contador").show();
    var porciones = numeros_whats.split('|');
    var contador = porciones.length;


    if (contador > 0) {

      porciones.forEach(myFunction);
      var sumar = 0;
      function myFunction(item, index) {

        if (item != "") {
          open(item, index,`width=600, height=600, left=${sumar}, top=300`); 
          var sumar = sumar + 300; 
          redireccionPagina2();
        }else{
          redireccionPagina2();
        }


      }



    }else{
      redireccionPagina2();
    }







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
      location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
    });
  });

  function redireccionPagina(){
   delayPagina();
   contadorRedirigir();		
 }
 function redireccionPagina2(){
   delayPagina2();
   contadorRedirigir();		
 }


 function delayPagina(){
   var delay = 3000;
   setTimeout(() => {
    location.replace(`agregar_orden_logistica.php`);
  }, delay);
 }
 function delayPagina2(){
   var delay = 3000;
   setTimeout(() => {
    location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
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