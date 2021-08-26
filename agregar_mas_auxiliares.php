<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);


$array_options = array();

$options_add = "
<option value='documentacion_vin'>Documentación del VIN</option>
<option value='detallado'>Evaluación y Diagnóstigo</option>
";

$query_busqueda_orden = "SELECT tipo_funcion_buscador FROM orden_logistica_buscar_ordenes_extras GROUP BY tipo_funcion_buscador ORDER BY tipo_funcion_buscador ASC";
$result_busqueda_orden = mysql_query($query_busqueda_orden);

if (mysql_num_rows($result_busqueda_orden) == 0 ) {

  array_push($array_options, $options_add);


}else {

  while ($row_busqueda_orden = mysql_fetch_array($result_busqueda_orden)) {

    $name_option = ($row_busqueda_orden[tipo_funcion_buscador] == "documentacion_vin") ? "Documentación del VIN" : "Evaluación y Diagnóstigo";

    array_push($array_options, "<option value='$row_busqueda_orden[tipo_funcion_buscador]'>$name_option</option>");
    
  }
}


$trataroptions = Tratar_Array ($array_options);

foreach ($trataroptions as $key_option => $value_option) {

  $concat_options .= $value_option;

}


$query_orden = "SELECT idorden_logistica_tipo_orden, nombre FROM orden_logistica_tipo_orden WHERE visible = 'SI' GROUP BY nombre,idorden_logistica_tipo_orden ORDER BY nombre ASC";
$result_orden = mysql_query($query_orden);

while ($row_orden = mysql_fetch_array($result_orden)) {

  $options_orden .= "<option value='$row_orden[idorden_logistica_tipo_orden]'>$row_orden[nombre]</option>";

}




?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="description" content="" >
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="./style2.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/quicksand.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="../../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../../assets/css/slick/slick.css">
  <link rel="stylesheet" href="../../assets/css/slick/slick-theme.css">
  <link rel="stylesheet" href="../../assets/css/fontawesome-stars.css">
  <link rel="stylesheet" href="../../assets/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../assets/js/calendar/bootstrap_calendar.css">
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

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>

  <!-- DataTables CSS -->
  <link href="../../plugins/datatables/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

  <!-- DataTables Responsive CSS -->
  <link href="../../plugins/datatables/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

  <script src="./script.js"></script>
  <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
  <script src="../../js/jquery-1.10.2.js"></script>
  <script src="../../js/jquery-ui.js"></script>

<!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
-->


<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.css">
<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.date.css">
<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.time.css">
<title>CCP | Buscar Función Tipo de Orden</title>

</head>
<body onload="LoadingFunctions()">

  <div class="container-fluid p-0">
    <?php 
    include_once "menu.php"; 
    ?>

    <div class="container-loading-ajax" style="display: none;">
      <div class="content-loading-ajax">
        <div class="content-form-1">
          <span class="circle-uno"></span>
          <span class="circle-dos"></span>
        </div>
        <div class="content-form-2">
          <span class="circle-tres"></span>
          <span class="circle-cuatro"></span>
          <span class="circle-cinco"></span>
          <span class="circle-seis"></span>
        </div>
      </div>
    </div>

    <div class='listo-form' style="background: rgba(255, 255, 255, 1); width: 100%; height: 100vh; position: fixed; z-index: 9999; top: 0px; display: none;">
      <div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%);">
        <div class="popup-mensaje popuplisto animate-popup">
          <div style="padding: 10px 20px; background: #25E28C;">
            <div class="listo">
              <span class="icono-listo"></span>
            </div>
          </div>
          <div class="text-center mt-2" style="padding: 10px 20px;">
            <h1 style="font-size: 22px;" class="text-listo"></h1>
          </div>
        </div>
      </div>
    </div>

    <div class="error-form" style="background: rgba(255, 255, 255, 1); width: 100%; height: 100vh; position: fixed; z-index: 9999; top: 0px; display: none;">
      <div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%);">
        <div class="popup-mensaje popuperror animatepopup">
          <div style="padding: 10px 20px; background: #F13154;">
            <div class="error">
              <span class="icono-error"></span>
            </div>
          </div>
          <div class="text-center mt-2" style="padding: 10px 20px;">
            <h1 style="font-size: 22px;" class="text-error"></h1>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-9 col-xs-12 content pt-3 p-0">
      <div class="row mt-3 m-0">
        <div class="col-sm-12">
          <div class="mt-1 mb-3 p-3 button-container fondo-container">

            <ol class="breadcrumb fondo-encabezados">
              <li>
                <a class="text-white" href="index.php">Inicio</a>
              </li>
              <span class="text-white"> &nbsp;/&nbsp; </span>
              <li>
                <a class="text-white" onclick="ShowFormOrdenes();">Agregar Función Tipo de orden</a>
              </li>
              <span class="text-white"> &nbsp;/&nbsp; </span>
              <li class="text-white" class="active">
                <strong> Agregar Tipo Orden Departamento</strong>
              </li>
            </ol>

            <br>

            <div class="modal fade" id="modal_add_orden" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Búsqueda de funcón para cada tipo de Orden</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">


                    <form id="form_agregar_nuevas_ordenes">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group row">

                            <div class="col-sm-12 field_busqueda_Torden" >

                            </div>

                            <div class="col-sm-12 mt-4">
                              <center>
                                <a id='create_torden' style='width: 180px;height: 90px;' class="create_torden icon-DOrden" class="" title="Add field"><i class='fa fa-plus-circle fa-5x zoom font-iconr' aria-hidden='true' ></i></a>
                                <div class="tooltipDetalleOrden mb-3">
                                  <p>Agregar Búsqueda Tipo Orden</p>
                                </div>
                              </center>
                            </div>

                            <input id="indtorden" type="hidden" value="0" readonly>
                            <input id="count_torden_aux" type="hidden" value="0" readonly>
                            <input type="hidden" name="tipo_movimiento" value="Create">
                            <input type="hidden" name="fecha_creacion" value="<?php echo $fecha_guardado; ?>">

                            <script type="text/javascript">
                              $(document).ready(function(){


                                var addButtonTorden = $('.create_torden');
                                var wrapper_T_orden = $('.field_busqueda_Torden');

                                $(addButtonTorden).click(function() {


                                  var obtener_count_torden = $("#count_torden_aux").val();


                                  var add_coun_aux_torden = parseInt(obtener_count_torden, 10) + 1;
                                  $("#count_torden_aux").val(add_coun_aux_torden);

                                  var obtener_aux_tipo_orden = $("#indtorden").val();

                                  if (obtener_aux_tipo_orden == 0) {

                                    var contador_aux = 1;

                                  } else {

                                    if ($.isNumeric(obtener_aux_tipo_orden) == true) {

                                      var contador_aux = parseInt(obtener_aux_tipo_orden, 10) + 1;

                                    } else {

                                      var cortar = obtener_aux_tipo_orden.substr(0, 1);

                                      var contador_aux = parseInt(obtener_aux_tipo_orden, 10) + 1;

                                    }
                                  }



                                  $("#indtorden").val(contador_aux);

                                  var fieldHTMLTipo_orden = `

                                  <div class="row mt-4 mb-4 container-title-line">

                                  <div class="col-sm-6">
                                  <label>Tipo de Orden Logística</label>
                                  <select name="tipo_orden[]" class="form-control">
                                  <?php echo $options_orden; ?>
                                  </select>
                                  </div>

                                  <div class="col-sm-6">
                                  <label>Tipo de Busqueda</label>
                                  <select name="orden_busqueda[]" class="form-control">
                                  <?php echo $concat_options; ?>
                                  </select>
                                  </div>

                                  <a class="button-eliminar remove_button mt-4 mb-4">
                                  <span>Eliminar</span><i class="fas fa-trash"></i>
                                  </a>


                                  </div>
                                  `;


                                  $(wrapper_T_orden).append(fieldHTMLTipo_orden);

                                });


                                $(wrapper_T_orden).on('click', '.remove_button', function(e) {
                                  e.preventDefault();
                                  $(this).parent('div').remove();

                                  var obteneroriginalaux = $("#indtorden").val();
                                  $("#indtorden").val(obteneroriginalaux + "|");

                                  var disminuir_count_aux = $("#count_torden_aux").val();
                                  var nuewcount_individual_aux = parseInt(disminuir_count_aux, 10) - 1;
                                  $("#count_torden_aux").val(nuewcount_individual_aux);

                                  if (nuewcount_individual_aux == 0) {
                                    $("#indtorden").val("0");
                                  }

                                });
                              });
                            </script>

                          </div>
                        </div>
                      </div>
                    </form>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <button class="btn-lg btn-primary"  onclick="Guardar_NuevasOrdenes();">Guardar</button>
                    </div>

                  </div>

                </div>
              </div>
            </div>

            <div class="col-sm-12" id="show_table">

            </div>








          </div>



        </div>

        <?php 
        include_once '../footer.php';
        ?>

      </div>
    </div>
  </div>
  <script src="../../datapicker_moder/lib/compressed/picker.js"></script>
  <script src="../../datapicker_moder/lib/compressed/picker.date.js"></script>
  <script src="../../datapicker_moder/lib/compressed/picker.time.js"></script>
  <script src="../../assets/js/popper.min.js"></script>
  <!--Bootstrap-->
  <script src="../../assets/js/bootstrap.min.js"></script>
  <!--Sweet alert JS-->
  <script src="../../assets/js/sweetalert.js"></script>
  <!--Progressbar JS-->
  <script src="../../assets/js/progressbar.min.js"></script>
  <!--Charts-->
  <!--Canvas JS-->
  <script src="../../assets/js/charts/canvas.min.js"></script>
  <!--Bootstrap Calendar JS-->
  <script src="../../assets/js/calendar/bootstrap_calendar.js"></script>
  <script src="../../assets/js/calendar/demo.js"></script>
  <!--Bootstrap Calendar-->
  <!--Datatable-->
  <script src="../../assets/js/jquery.dataTables.min.js"></script>
  <script src="../../assets/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../plugins/datatables/datatables-responsive/dataTables.responsive.js?<?php echo $random; ?>"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
  <script src="../../assets/js/custom.js"></script>

  <script>

    function LoadingFunctions() {

      ShowDataTable();


    }

    function ShowDataTable () {

     var datos = "Read";

     $.ajax({
       url: "guardar_mas_auxiliares.php",
       type: "POST",
       data : {tipo_movimiento : datos},
       beforeSend: function(){
        $(".container-loading-ajax").show();
      },
      success : function(table) {

        $("#show_table").html(table);
        $(".container-loading-ajax").hide();
      },
      error : function(table) {

        $(".error-form").show();
        $(".text-error").html("Disculpa, ocurrió un error");

        setTimeout(function(){
          $(".error-form").fadeOut(1000);
        }, 1500);

      }
    });

   }


   function ShowFormOrdenes () {

    $('#modal_add_orden').modal('toggle');
    $('.field_busqueda_Torden').empty();
    $('#indtorden').val("0");
    $('#count_torden_aux').val("0");

  }

  function HideFormOrdenes () {

    $('#modal_add_orden').modal('hide');
    $('.field_busqueda_Torden').empty();
    $('#indtorden').val("0");
    $('#count_torden_aux').val("0");

  }




  function Guardar_NuevasOrdenes () {

    var datos = $("#form_agregar_nuevas_ordenes").serialize();


    $.ajax({
      url: "guardar_mas_auxiliares.php",
      type: "POST",
      data: datos,
      beforeSend: function(){
        $(".container-loading-ajax").show();
      },
      success : function(respuesta) {

        if (respuesta.trim() == "1") {

          $(".listo-form").show();
          $(".text-listo").html("Datos Guardados Correctamente");

          setTimeout(function(){
            $(".listo-form").fadeOut(1000);
          }, 1500);

        }else {

          $(".error-form").show();
          $(".text-error").html(respuesta);

          setTimeout(function(){
            $(".error-form").fadeOut(5000);
          }, 1500);

        }

        HideFormOrdenes();
        ShowDataTable();
        $("#show_table").html(respuesta);
        $(".container-loading-ajax").hide();
      },
      error : function(respuesta) {

        $(".error-form").show();
        $(".text-error").html(respuesta);

        setTimeout(function(){
          $(".error-form").fadeOut(1000);
        }, 1500);

      }

    });


  }

  function EliminarMovimientos() {

    var datos = $("#delete_movimientos").serialize();

    $.ajax({
     url: "guardar_mas_auxiliares.php",
     type: "POST",
     data: datos,
     beforeSend: function(){

      $(".container-loading-ajax").show();
    },
    success : function(respuesta_delete) {

      if (respuesta_delete.trim() == "1") {

        $(".listo-form").show();
        $(".text-listo").html("Datos Guardados Correctamente");

        setTimeout(function(){
          $(".listo-form").fadeOut(1000);
        }, 1500);

      }else {

        $(".error-form").show();
        $(".text-error").html(respuesta_delete);

        setTimeout(function(){
          $(".error-form").fadeOut(5000);
        }, 1500);

      }

      HideFormOrdenes();
      ShowDataTable();
      $("#show_table").html(respuesta_delete);
      $(".container-loading-ajax").hide();
    },
    error : function(respuesta_delete) {

      $(".error-form").show();
      $(".text-error").html(respuesta_delete);

      setTimeout(function(){
        $(".error-form").fadeOut(1000);
      }, 1500);

    }

  });


  }


</script>




</body>
</html>