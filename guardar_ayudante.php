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
  <title>CCP| Guardar Ayudante</title>

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
              <h1 class="text-center text-white">Acompañante(s) Agregado(s) exitosamente</h1>
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

  $idlogistica_encriptada = $_POST['id_logistica_ayudantes'];
  $id_logisticapasar = base64_decode($_POST['id_logistica_ayudantes']);
  $fecha_creacion = $_POST['fecha_creacion_ayudantes1'];
  $coordenadas = $_POST['coordenadas_ayudante'];
  #----------------------------------------------------------Ayudantes-------------------------------------------------------------------------------------------


  $id_ayudante_recibir = $_POST['id_ayudante'];
  $tipo_ayudante_recibir = $_POST['tipo_ayudante'];
  $comentario_ayudante_recibir = $_POST['comentario_ayudante'];

  $agrupar_ayudantes = array();

  for ($i=0; $i < count($id_ayudante_recibir) ; $i++) { 

    array_push($agrupar_ayudantes, trim($id_ayudante_recibir[$i]).";".trim($tipo_ayudante_recibir[$i]).";".trim($comentario_ayudante_recibir[$i])."/");

  }

  $eliminar_ayudantes_duplicados = array_unique($agrupar_ayudantes);

  $agrupar_ayudantes_eliminados = substr(implode($eliminar_ayudantes_duplicados), 0,-1);

  $nuevo_array_ayudantes = explode("/", $agrupar_ayudantes_eliminados);
  $id_ayudante = array();
  $tipo_ayudante = array();
  $comentario_ayudante = array();

  for ($j=0; $j < count($nuevo_array_ayudantes) ; $j++) { 

    $particion_ayudantes = explode(";", $nuevo_array_ayudantes[$j]);

    array_push($id_ayudante, trim($particion_ayudantes[0]));
    array_push($tipo_ayudante, trim($particion_ayudantes[1]));
    array_push($comentario_ayudante, trim($particion_ayudantes[2]));

  }

#----------------------------------------------------------Consulta General-------------------------------------------------------------------------------------------
  $query_logistica = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$id_logisticapasar'";
  $result_logistica = mysql_query($query_logistica);

  while ($row_logistica = mysql_fetch_array($result_logistica)) {

    $id_asigna = trim("$row_logistica[idasigna]");
    $tipo_asignante = trim("$row_logistica[tipo_asignante]");
    $municipio_origen = trim("$row_logistica[municipio_origen]");
    $estado_origen = trim("$row_logistica[estado_origen]");
    $municipio_destino = trim("$row_logistica[municipio_destino]");
    $estado_destino = trim("$row_logistica[estado_destino]");

  }

  $name_trasladista_principal = name_usuario($id_asigna, $tipo_asignante);
  $porciones_nombre_principal = explode("/", $name_trasladista_principal);

  $nombre_trasladista_pricipal = ($id_asigna == "") ? "(Trasladista Pendiente)" : $porciones_nombre_principal[1] ;


  if (count($id_ayudante_recibir) >= 1) {


    $ver_resultado = insertAyudantes($id_ayudante, $tipo_ayudante, $comentario_ayudante, $id_logisticapasar, $usuario_creador, $fecha_creacion,  $fecha_guardado, $coordenadas, $municipio_origen, $estado_origen ,$municipio_destino, $estado_destino, $idasigna, $tipo_asignante, $nombre_trasladista_pricipal);

    $ver_errores =  $ver_resultado;

  }else{

   $ver_errores = "Fallo";
 }


      # inician las Funciones 

#----------------------------------------------------------INSERTAR AYUDANTES-------------------------------------------------------------------------------------------

 function insertAyudantes($id_ayudante, $tipo_ayudante, $comentario_ayudante, $id_logisticapasar, $usuario_creador, $fecha_creacion,  $fecha_guardado, $coordenadas, $municipio_origen, $estado_origen ,$municipio_destino, $estado_destino, $idasigna, $tipo_asignante, $nombre_trasladista_pricipal) {

  $contador_ayudantes = 0;

  for ($i=0; $i < sizeof($id_ayudante) ; $i++) {

    $ver_duplicate = Evitar_Duplicados ($id_ayudante[$i], $tipo_ayudante[$i], $id_logisticapasar);

    if ($ver_duplicate == 1) {

     $insert_ayudantes = "INSERT orden_logistica_ayudante (id_colaborador_proveedor, tipo, idorden_logistica, comentarios, visible, usuario_creador, fecha_creacion, fecha_guardado) VALUES ('".$id_ayudante[$i]."', '".$tipo_ayudante[$i]."', '$id_logisticapasar', '".$comentario_ayudante[$i]."', 'SI', '$usuario_creador', '$fecha_creacion', '$fecha_guardado')";
     $result_insert_ayudantes = mysql_query($insert_ayudantes);

   }else{

    //$result_insert_ayudantes = 0;
    //$contador_ayudantes .= "- Error al isertar el id: <b>$id_ayudante[$i]</b> ya se encuentra agrgado<br>"; 
   }



   if ($result_insert_ayudantes == 1) {

    $contador_ayudantes ++;

      # Obtenemos el nombre de los ayudantes
    $name_ayudante =  name_usuario ($id_ayudante[$i], $tipo_ayudante[$i]);
    $nombre_ayudante = explode("/", $name_ayudante);

      # Actualizamos el estatus del Ayudante Colaborador 
    $actualizar_ayudantes = ($tipo_ayudante[$i] == "Colaborador") ? updateColaboradores($id_ayudante[$i]) : "1" ;

    if ($actualizar_ayudantes == 1) {

      $descripcion_cambio = "Se Agregó a <b>$nombre_ayudante[1]</b> como Acompañante";
      $tipo = "Acompañante";

      $guardar_bitacora_ayudante = insertarBitacora($descripcion_cambio, "Acompañante", $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, "4", $usuario_creador, $comentario_ayudante[$i]);

      if ($guardar_bitacora_ayudante == 1) {

        if ($tipo_ayudante[$i] == "Colaborador") {

          $carpeta_direccionador = ($nombre_ayudante[4] == "Ejecutivo de Traslado") ? "https://www.panamotorscenter.com/Prod/CCP/Perfiles2/Ejecutivos_Traslado/orden_logistica_detalles.php?idib=$logistica_encriptada" : "https://www.panamotorscenter.com/Prod/CCP/Perfiles/Generar_Logistica/orden_logistica_detalles.php?idib=$logistica_encriptada";

          $mensaje_bd = "<b>$nombre_ayudante[1]</b> Acompañaras a <b>$nombre_trasladista_pricipal</b> a un traslado de <b>$municipio_origen, $estado_origen</b> a <b>$municipio_destino, $estado_destino</b> Logística número <b>$id_logisticapasar</b>";
          $mensaje_whats = "*$nombre_ayudante[1]* Acompañaras a *$nombre_trasladista_pricipal* a un traslado de *$municipio_origen, $estado_origen* a *$municipio_destino, $estado_destino* Logística número *$id_logisticapasar* $carpeta_direccionador";
          $whatsapp_ayudante .= "https://api.whatsapp.com/send?phone=$nombre_ayudante[3]&text=$mensaje_whats|";

        }else{

          $mensaje_whats = "*$nombre_ayudante[1]* usted tiene un número de orden. *$id_logisticapasar*, de logística para cualquier duda o aclaración.";
          $mensaje_bd = "<b>$nombre_ayudante[1]</b> usted tiene un número de orden. <b>$id_logisticapasar</b>, de logística para cualquier duda o aclaración.";
          $whatsapp_ayudante .= "https://api.whatsapp.com/send?phone=$nombre_ayudante[3]&text=$mensaje_whats|";
        }

        $insert_notificacion_bitacora = insertarBitacora($mensaje_bd, "Notificación", $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, "2", $usuario_creador, $comentario_ayudante[$i]);
      }
    }
  }
}  
return $whatsapp_ayudante;
}


  #----------------------------------------------------------UPDATE COLABORADORES-------------------------------------------------------------------------------------------

function updateColaboradores($id_colaborador_actualizar) {

  $update_empleados = "UPDATE empleados SET columna_a = 'En Ruta' WHERE idempleados = '$id_colaborador_actualizar'";
  $result_update_empleado = mysql_query($update_empleados);

  $solicito_nombre = name_usuario($id_colaborador_actualizar, "Colaborador");

  $trim_name = explode("/", $solicito_nombre);

  $result_update_colaborador .= ($result_update_empleado == 1) ? "1" : "- Error de Estatus con $trim_name[1] <br>";

  return $result_update_colaborador;

}


  #----------------------------------------------------------INSERTAR BITACORA-------------------------------------------------------------------------------------------

function insertarBitacora($bitacora_descripcion, $bitacora_tipo, $id_logisticapasar, $fecha_creacion, $fecha_guardado, $coordenadas, $bitacora_valor, $usuario_creador, $comentarios) {


  $insert_bitacora = "INSERT INTO orden_logistica_bitacora (descripcion, tipo, idorden_logistica, usuario_creador, fecha_creacion, fecha_guardado, visible, coordenadas, valor, comentarios) VALUES ('$bitacora_descripcion', '$bitacora_tipo', '$id_logisticapasar', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', 'SI', '$coordenadas', '$bitacora_valor', '$comentarios')";
  $result_bitacora = mysql_query($insert_bitacora);

  $respuesta_bitacora = ($result_bitacora == 1) ? "1" : "; ERROR en bitacora de tipo: $bitacora_tipo ;";


  return $respuesta_bitacora;

}


    #----------------------------------------------------------CONSULTAS Nombres-------------------------------------------------------------------------------------------


function name_usuario ($id_id, $id_type){

  $id_id = trim($id_id);
  $id_type = trim($id_type);

  if ($id_type == "Colaborador") {

    $query_name_colaborador = "SELECT * FROM empleados where idempleados = '$id_id'";
    $result_name_colaborador = mysql_query($query_name_colaborador);

    if (mysql_num_rows($result_name_colaborador) >= 1) {

      while ($row_colaborador = mysql_fetch_array($result_name_colaborador)) {

        if (is_numeric($row_colaborador[telefono_empresa]) and $row_colaborador[telefono_empresa] != "" and $row_colaborador[telefono_empresa] != null) {

          $phone_number =  "52$row_colaborador[telefono_empresa]";

        } elseif (is_numeric($row_colaborador[telefono_personal]) and $row_colaborador[telefono_personal] != "" and $row_colaborador[telefono_personal] != null) {

          $phone_number =  "52$row_colaborador[telefono_personal]";

        } else {

          $phone_number = "520000000000";
        }

        $name_name = "$row_colaborador[idempleados]/$row_colaborador[columna_b]/Colaborador/$phone_number/$row_colaborador[puesto_actual]"; 
      }

    } else {

      $name_name = "Colaborador/Colaborador/Colaborador/Colaborador";
    }


  }elseif ($id_type == "Cliente") {

    $query_name_cliente = "SELECT * FROM contactos WHERE idcontacto = '$id_id'";
    $result_name_cliente = mysql_query($query_name_cliente);

    if (mysql_num_rows($result_name_cliente) >= 1) {

      while ($row_cliente = mysql_fetch_array($result_name_cliente)) {

        if (is_numeric($row_cliente[telefono_celular]) and $row_cliente[telefono_celular] != "" and $row_cliente[telefono_celular] != null) {

          $phone_number =  "52$row_cliente[telefono_celular]";

        } elseif (is_numeric($row_cliente[telefono_otro]) and $row_cliente[telefono_otro] != "" and $row_cliente[telefono_otro] != null) {

          $phone_number =  "52$row_cliente[telefono_otro]";

        } else {

          $phone_number = "520000000000";
        }

        $name_name = "$row_cliente[idcontacto]/$row_cliente[nombre] $row_cliente[apellidos]/Cliente/$phone_number"; 

      }

    }else{

      $name_name = "Cliente/Cliente/Cliente/Cliente";
    }

  }elseif ($id_type == "Proveedor") {

    $query_name_proveedor = "SELECT * FROM proveedores WHERE idproveedores = '$id_id'";
    $result_name_proveedor = mysql_query($query_name_proveedor);

    if (mysql_num_rows($result_name_proveedor) >= 1) {

      while ($row_proveedor = mysql_fetch_array($result_name_proveedor)) {

        if (is_numeric($row_proveedor[telefono_celular]) and $row_proveedor[telefono_celular] != "" and $row_proveedor[telefono_celular] != null) {

          $phone_number =  "52$row_proveedor[telefono_celular]";

        } elseif (is_numeric($row_proveedor[telefono_otro]) and $row_proveedor[telefono_otro] != "" and $row_proveedor[telefono_otro] != null) {

          $phone_number =  "52$row_proveedor[telefono_otro]";

        } else {

          $phone_number = "520000000000";
        }

        $name_name = "$row_proveedor[idproveedores]/$row_proveedor[nombre] $row_proveedor[apellidos]/Proveedor/$phone_number"; 

      }

    }else{

      $name_name = "Proveedor/Proveedor/Proveedor/Proveedor";
    }

  }elseif ($id_type == "Proveedor Temporal") {

    $query_name_proveedor_temporal = "SELECT * FROM orden_logistica_proveedores WHERE idorden_logistica_proveedores = '$id_id'";
    $result_name_proveedor_temporal = mysql_query($query_name_proveedor_temporal);

    if (mysql_num_rows($result_name_proveedor_temporal) >= 1) {

      while ($row_proveedor_temporal = mysql_fetch_array($result_name_proveedor_temporal)) {

        if (is_numeric($row_proveedor_temporal[telefono_celular]) and $row_proveedor_temporal[telefono_celular] != "" and $row_proveedor_temporal[telefono_celular] != null) {

          $phone_number =  "52$row_proveedor_temporal[telefono_celular]";

        } elseif (is_numeric($row_proveedor_temporal[telefono_otro]) and $row_proveedor_temporal[telefono_otro] != "" and $row_proveedor_temporal[telefono_otro] != null) {

          $phone_number =  "52$row_proveedor_temporal[telefono_otro]";

        } else {

          $phone_number = "520000000000";
        }

        $name_name = "$row_proveedor_temporal[idorden_logistica_proveedores]/$row_proveedor_temporal[nombre] $row_proveedor_temporal[apellidos]/Proveedor Temporal/$phone_number"; 

      }

    }else{

      $name_name = "Proveedor Temporal/Proveedor Temporal/Proveedor Temporal/Proveedor Temporal";
    }

  } else {

    $name_name = "Nada/Nada/Nada/Nada";
  }

  return $name_name;

}

#----------------------------------------------------------Evitar Duplicados-------------------------------------------------------------------------------------------

function Evitar_Duplicados ($id, $tipo, $idlogistica) {

  $id = trim($id);
  $tipo = trim($tipo);

  $query_logistica = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$idlogistica' AND trim(idasigna) = '$id' AND trim(tipo_asignante) = '$tipo'";
  $result_logistica = mysql_query($query_logistica);

  if (mysql_num_rows($result_logistica) >= 1) {

    $resultado_ayudante = 0;

  }else {

    $query_ayudantes = "SELECT * FROM orden_logistica_ayudante WHERE idorden_logistica = '$idlogistica' AND visible = 'SI' AND trim(id_colaborador_proveedor) = '$id' AND trim(tipo) = '$tipo'";
    $result_ayudantes = mysql_query($query_ayudantes);

    $resultado_ayudante = (mysql_num_rows($result_ayudantes) >= 1) ? 0 : 1;

  }

  return $resultado_ayudante;

}








?>

<script>


  var numeros_whats ='<?php echo $ver_errores;?>'
  var idlogistica = '<?php  echo $idlogistica_encriptada;?>'


  if (numeros_whats != "Sin Errores") {
    console.log("1");

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







  }else if (numeros_whats == "Fallo") {
    console.log("2");
    $('#fail_alert').show();  
    $("#content-contador").show();
    redireccionPagina();

  }else{
    console.log("3");
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

  }


  $(document).ready(function(){
    $("#continuar").click(function(){
      location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
    }); 

    $("#yes").click(function(){
      location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#example`);
    }); 

    $("#nel").click(function(){
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
   var delay = 1000;
   setTimeout(() => {
    location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
  }, delay);
 }
 function delayPagina2(){
   var delay = 1000;
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
      duration: 1000, 
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