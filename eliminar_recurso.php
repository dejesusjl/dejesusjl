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

#---------------------------------------------------------------------------------------------------------------------------
$fecha_creacion = date("Y-m-d H:i:s");
$idlogistica_documentacion = $_REQUEST['idold'];
$idlogistica_documentacion_desecriptado = base64_decode($idlogistica_documentacion);

$query_recurso = "SELECT * FROM orden_logistica_documentacion WHERE idorden_logistica_documentacion = '$idlogistica_documentacion_desecriptado'";
$result_recurso = mysql_query($query_recurso);

while ($row_recurso = mysql_fetch_array($result_recurso)) {
 $monto = "$".number_format($row_recurso[monto_rembolso],2);
 $tipo_moneda = $row_recurso[tipo_moneda];
 $idorden_logistica = $row_recurso[idorden_logistica];
 $idorden_logistica_documentacion = $row_recurso[idorden_logistica_documentacion];
 $idorden_logistica_encriptada = base64_encode($idorden_logistica);
}



?>
<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="description" content="" >
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="utf-8">
  <meta name="description" content="" >
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!--Meta Responsive tag-->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



  <!--Bootstrap CSS-->
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
  <!--Custom style.css-->
  <link rel="stylesheet" href="../../assets/css/quicksand.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <!--Font Awesome-->
  <link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="../../assets/css/fontawesome.css">
  <!--Slick Carousel CSS-->
  <link rel="stylesheet" href="../../assets/css/slick/slick.css">
  <link rel="stylesheet" href="../../assets/css/slick/slick-theme.css">
  <!--Rating Bars-->
  <link rel="stylesheet" href="../../assets/css/fontawesome-stars.css">
  <!--Datatable-->
  <link rel="stylesheet" href="../../assets/css/dataTables.bootstrap4.min.css">
  <!--Bootstrap Calendar-->
  <link rel="stylesheet" href="../../assets/js/calendar/bootstrap_calendar.css">



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

  <!--   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> -->

  <!-- <script src="../../js/jquery-3.1.1.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script -->



    <!-- DataTables CSS -->
    <link href="../../plugins/datatables/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../../plugins/datatables/datatables-responsive/dataTables.responsive.css" rel="stylesheet">


    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="../../js/jquery-1.10.2.js"></script>
    <script src="../../js/jquery-ui.js"></script>

    <title>CCP | Modificar Movimiento</title>


  </head>
  <body>

    <!--Page Wrapper-->

    <div class="container-fluid">

      <?php 
      include_once "menu.php"; 
      ?>


      <!--Content right-->
      <div class="col-sm-9 col-xs-12 content pt-3 pl-0">


        <div class="row mt-3">
          <div class="col-sm-12">
            <!--Datatable-->
            <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">

              <div class="col-lg-12">


                <ol class="breadcrumb">
                  <li>
                    <a href="index.php">Inicio</a>
                  </li>
                  <span class="text-secondary"> &nbsp;/&nbsp; </span>


                  <li>
                    <a href="agregar_orden_logistica.php"> Agregar Nueva orden</a>
                  </li>
                  <span class="text-secondary"> &nbsp;/&nbsp; </span>

                  <li>
                    <a href="orden_logistica_resumen.php">Resúmen Ordenes Logística</a>
                  </li>
                  <span class="text-secondary"> &nbsp;/&nbsp; </span>

                  <li>
                    <a href="<?php echo "orden_logistica_detalles.php?idib=$idorden_logistica_encriptada";?>">Regresar a <?php echo $idorden_logistica; ?></a>
                  </li>
                  <span class="text-secondary"> &nbsp;/&nbsp; </span>

                  <li  class="active">
                    <strong>Modificar Movimiento</strong>
                  </li>
                </ol>

                <div class="col-lg-12 imagen-perfil">
                  <center>

                    <h2>Monto a Modificar</h2>
                    <h3><?php echo $monto." ".$tipo_moneda ?></h3>

                  </center>
                </div>
                <br>

                <!---------------------------->

                <form name="formulario" id="formulario" action="guardar_eliminar_recurso.php" method="POST" enctype="multipart/form-data">

                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>*Tipo de Moneda</label>     
                      <div class="content-select">
                        <select class="form-control" id="tipo_moneda_documentacion" name="tipo_moneda_documentacion" onchange="buscar_letras2();" required="">
                          <option value="">Elige una opción…</option>
                          <option value="USD">USD</option>
                          <option value="CAD">CAD</option>
                          <option value="MXN">MXN</option>
                        </select>
                        <i></i>
                      </div>          
                    </div>
                  </div>



                  <input class="form-control" type="hidden" id="tipo_cambio_documentacion" name="tipo_cambio_documentacion" onchange="cal()" onkeyup="cal()" onkeypress="return SoloNumeros(event);"/>



                  <div class="col-sm-12 form-group">
                    <label>*Monto</label>
                    <input class="form-control" type="text" id="monto_entrada_documentacion" name="monto_entrada_documentacion" onchange="cal()" onkeyup="cal();buscar_letras2();" onkeypress="return SoloNumeros(event);" required="" />
                  </div>

                  <div class="col-sm-12 form-group">    
                    <label>Monto Letra</label>
                    <input type="text" class="form-control" id="letradocumentacion" name="letra_entrada"  readonly>    
                  </div>

                  <input type="hidden" name="fecha_creacion" value="<?php echo $fecha_creacion; ?>">
                  <input type="hidden" name="idorden_logistica" value="<?php echo $idorden_logistica_encriptada; ?>">
                  <input type="hidden" name="idorden_logistica_documentacion" value="<?php echo $idorden_logistica_documentacion; ?>">
                  <input type="hidden" name="coordenadas" id="coordenadas">
                  <br>
                  <center>
                    <button class="btn btn-lg btn-primary" id="enviar" type="submit">Guardar</button>
                  </center>


                </form>

                <!---------------------------->

              </div>
            </div>
          </div>

          <!--Footer-->
          <div class="row mt-5 mb-4 footer">
            <?php 
            include_once '../footer.php';
            ?>
          </div>
          <!--Footer-->

        </div>
      </div>

      <!--Main Content-->

    </div>

    <!--Page Wrapper-->

    <!-- Page JavaScript Files-->
<!-- <script src="../../assets/js/jquery.min.js"></script>
  <script src="../../assets/js/jquery-1.12.4.min.js"></script> -->
  <!--Popper JS-->
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

  <!--Custom Js Script-->
  <script src="../../assets/js/custom.js"></script>
  <!--Custom Js Script-->

  <link rel="stylesheet" type="text/css" href="../../js/jquery.datetimepicker.css"/>

  <script src="../../js/jquery.datetimepicker.full.js"></script>


  <script>
    $(document).ready(function() {

      $('#dataTables-example1').DataTable({
        responsive: true
      });

      $('#dataTables-example2').DataTable({
        responsive: true
      });

      $('#dataTables-example3').DataTable({
        responsive: true,
        "ordering": false
      });


      $('select#tipo_moneda_documentacion').change(function(){

        var cambio1 = "1";
        var cambio2 = "1";
        var cambio3 = "1";
        var nada = "0";
        var valor = $(this).val();                                        

        if(valor == 'USD'){  

          $("#tipo_cambio_documentacion").val(cambio1);                   
          $('#tipo_cambio_documentacion').prop('readonly', false);

        }else if (valor == 'CAD'){  

          $("#tipo_cambio_documentacion").val(parseFloat(cambio2));                                 
          $('#tipo_cambio_documentacion').prop('readonly', false);

        }else if(valor == 'MXN'){ 

          $("#tipo_cambio_documentacion").val(parseFloat(cambio3));               
          $('#tipo_cambio_documentacion').prop('readonly', true);

        }else if(valor == ''){
          $("#tipo_cambio_documentacion").val(parseFloat(0));                                 

        }

      }); 



    });
  </script>
  <script type="text/javascript">



  </script>
  <script>


    function initMap() {

      infoWindow = new google.maps.InfoWindow;


      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {

          var latitud = position.coords.latitude;
          var longitud = position.coords.longitude;
          var coordenadas = latitud + " " + longitud;


          $("#coordenadas").val(coordenadas);



        }, function() {
          handleLocationError(true);
        });
      } else {

        handleLocationError(false);
      }
    }

    function handleLocationError(browserHasGeolocation, pos) {
      infoWindow.setPosition(pos);
      infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
      infoWindow.open(map);
    }




    function SoloNumeros(evt){
      if(window.event){ 
        keynum = evt.keyCode; 
      }
      else{
        keynum = evt.which; 
      }

      if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 || keynum == 47 ){
        return true;
      }
      else{
        return false;
      }
    }

    function buscar_letras2() {
      var textoletras = $("#monto_entrada_documentacion").val();
      var tipo = $("#tipo_moneda_documentacion").val();


      if (textoletras != "") {
        $.post("buscar_letras_documentacion.php", {valorBusqueda: textoletras, valortipo: tipo}, function(mensaje_letras) {

          $("#letradocumentacion").val(mensaje_letras);


        }); 
      } else { 
        $("#letradocumentacion").val('');
      };
    }; 




    function cal() {
      try {
        var a = parseFloat(document.form_documentacion.tipo_cambio_documentacion.value),
        b = parseFloat(document.form_documentacion.monto_entrada_documentacion.value);
        document.form_documentacion.gran_total_documentacion.value = a * b;
      } catch (e) {
      }
    }

  </script> 

  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKNm5FUjlIYRpuH8aquS6q-7NzQdlAwgc&libraries=places&callback=initMap">
</script>





</body>
</html>