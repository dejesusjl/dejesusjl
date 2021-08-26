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
$empleados = $_SESSION['empleados'];

#------------ ------------------------------------
$tipo_movimiento = $_POST['tipo_movimiento'];
#------------ ------------------------------------

if ($tipo_movimiento == "Create") {

  #------------ Agregar ----------------------------
  $tipo_orden_array = $_POST['tipo_orden'];
  $orden_busqueda_array = $_POST['orden_busqueda'];
  $fecha_creacion = $_POST['fecha_creacion'];
  $visible = "SI";
  #------------ ------------------------------------

  if (count($tipo_orden_array) == 0 || $tipo_orden_array == NULL) {

    $mensaje = "- Error no seleccionaste nada <br>";

  }else {

    for ($i=0; $i <count($tipo_orden_array) ; $i++) {

      $idorden_logistica_tipo_orden = trim($tipo_orden_array[$i]);
      $tipo_funcion_buscador = trim($orden_busqueda_array[$i]);

      if ($idorden_logistica_tipo_orden != "") {

        $query_evitar_duplicado = "SELECT * FROM orden_logistica_buscar_ordenes_extras WHERE trim(idorden_logistica_tipo_orden) = '$idorden_logistica_tipo_orden' AND trim(tipo_funcion_buscador) = '$tipo_funcion_buscador' ";
        $result_evitar_duplicado = mysql_query($query_evitar_duplicado);

        if (mysql_num_rows($result_evitar_duplicado) == 0) {

          $insert_ordenes_extras = "INSERT INTO orden_logistica_buscar_ordenes_extras (idorden_logistica_tipo_orden, tipo_funcion_buscador, visible, usuario_creador, fecha_creacion, fecha_guardado, columna_a, columna_b, columna_c, columna_d) VALUES ('$idorden_logistica_tipo_orden', '$tipo_funcion_buscador', '$visible', '$usuario_creador', '$fecha_creacion', '$fecha_guardado', '$columna_a', '$columna_b', '$columna_c', '$columna_d')";
          $result_ordenes_extras = mysql_query($insert_ordenes_extras);
          $name_orden_insert = OrdenName ($idorden_logistica_tipo_orden);
          $concatenar_insert .= ($result_ordenes_extras == 1) ? "" : "- Error al insertar <b>$name_orden_insert</b> con la funcion: <b>$tipo_funcion_buscador</b> <br>";

        }else {

          while ($row_evitar_duplicado = mysql_fetch_array($result_evitar_duplicado)) {

            if ($row_evitar_duplicado[visible] == "NO") {

              $name_orden_update = OrdenName ($row_evitar_duplicado[idorden_logistica_tipo_orden]);

              $update_buscar_ordenes = "UPDATE orden_logistica_buscar_ordenes_extras SET visible = 'SI', usuario_creador = '$usuario_creador', fecha_creacion = '$fecha_creacion', fecha_guardado = '$fecha_guardado' WHERE idorden_logistica_buscar_ordenes_extras = '$row_evitar_duplicado[idorden_logistica_buscar_ordenes_extras]'";
              $result_buscar_ordenes = mysql_query($update_buscar_ordenes);
              $concatenar_update .= ($result_buscar_ordenes == 1) ? "" : "- Error al actualizar <b>$name_orden_update</b> <br>";

            }else {

              $concatenar_update .= "";

            }
          }
        }
      }
    }

    $concatenar_general = trim($concatenar_insert).trim($concatenar_update);

    $mensaje = (trim($concatenar_general) == "") ? 1 : trim($concatenar_general);

  }

}elseif ($tipo_movimiento == "Delete") {

  $extras_delete_array = $_POST['extras_array'];

  if (count($extras_delete_array) == 0) {

    $mensaje = "- No seleccionaste nada para eliminar<br>";

  }else {

    foreach ($extras_delete_array as $key_delete => $value_delete) {
      $idorden_aux = trim($value_delete);
      
      if ($value_delete != "") {
        $query_delete = "UPDATE orden_logistica_buscar_ordenes_extras SET visible = 'NO' WHERE idorden_logistica_buscar_ordenes_extras = '$idorden_aux' ";
        $result_delete = mysql_query($query_delete);

        $name_delete = OrdenName($idorden_aux);
        $concatenar_delete .= ($result_delete == 1) ? "" : "-Error al eliminar el buscador de la orden <b>$name_delete</b>";

      }
    }

    $mensaje = (trim($concatenar_delete) == "") ? "1" : $concatenar_delete;

  }

}elseif ($tipo_movimiento == "Read") {

  $mensaje = "
  <script>

  $(document).ready(function() {

    $('#table_tipo_orden').DataTable({
      language: {
        'decimal': '',
        'emptyTable': 'No hay información',
        'info': 'Mostrando _START_ a _END_ de _TOTAL_ Entradas',
        'infoEmpty': 'Mostrando 0 to 0 of 0 Entradas',
        'infoFiltered': '(Filtrado de _MAX_ total entradas)',
        'infoPostFix': '',
        'thousands': ',',
        'lengthMenu': 'Mostrar _MENU_ Entradas',
        'loadingRecords': 'Cargando...',
        'processing': 'Procesando...',
        'search': 'Buscar:',
        'zeroRecords': 'Sin resultados encontrados',
        'paginate': {
          'first': 'Primero',
          'last': 'Ultimo',
          'next': 'Siguiente',
          'previous': 'Anterior'
        }
        },
        responsive: true,
        lengthMenu: [[10, 25, 50,-1], [10, 25, 50, 'All']],
        dom: 'Blfrtip',
        buttons: [
        'copy', 'excel'
        ],

        });
        var table = $('#table_tipo_orden').DataTable();

        table
        .order([ 1, 'asc' ])
        .draw();
        });

        </script>
        ";

        $mensaje .= "
        <div class='container-bg-1 p-3'>
        <div class='table-responsive'>
        <form id='delete_movimientos'>
        <table width='100%' class='table table-striped table-bordered table-hover panel-body-center-table' id='table_tipo_orden'>
        <thead>
        <tr>
        <th>#</th>
        <th>Tipo Orden Logística&nbsp;&nbsp;&nbsp;</th>
        <th>Nombre Función</th>
        <th>Acciones</th>
        </tr>
        </thead>
        <tbody>  
        ";

        $incrementar = 0;
        $query_buscar_orden_auxiliar = "SELECT 
        idorden_logistica_buscar_ordenes_extras,
        orden_logistica_tipo_orden.nombre AS nameorden,
        tipo_funcion_buscador
        FROM
        orden_logistica_buscar_ordenes_extras
        INNER JOIN
        orden_logistica_tipo_orden
        WHERE
        orden_logistica_buscar_ordenes_extras.idorden_logistica_tipo_orden = orden_logistica_tipo_orden.idorden_logistica_tipo_orden
        AND orden_logistica_buscar_ordenes_extras.visible = 'SI'
        ORDER BY nameorden ASC;
        ";
        $result_buscar_orden_auxiliar = mysql_query($query_buscar_orden_auxiliar);

        while ($row_buscar_orden_auxiliar = mysql_fetch_array($result_buscar_orden_auxiliar)) {

          $incrementar ++;
          $mensaje .= "
          <tr>
          <td>$incrementar</td>
          <td>$row_buscar_orden_auxiliar[nameorden]</td>
          <td>$row_buscar_orden_auxiliar[tipo_funcion_buscador]</td>
          <td><input type='checkbox' name='extras_array[]' class='filtros' value='$row_buscar_orden_auxiliar[idorden_logistica_buscar_ordenes_extras]' >
          </td>
          </tr>
          ";

        }

        $mensaje .= "
        </tbody >
        </table>
        <input type='hidden' name='tipo_movimiento' value='Delete'>
        </form>
        <div class='col-sm-12'>
        <center>
        <button class='btn-lg btn-primary' onclick='EliminarMovimientos();'>Guardar</button>
        </center>
        </div>
        </div>
        </div>
        ";

      }else {

        $mensaje = "- El movimiento <b>Esta Pendiente</b> <br>";

      }






      echo $mensaje

    ?>