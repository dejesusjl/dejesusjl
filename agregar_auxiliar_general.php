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

// Start Querys

$pasar_logistica = $_REQUEST['idl'];




$idlogistica_encriptada = $pasar_logistica;
$idlogistica_back = base64_decode($idlogistica_encriptada);




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
  <link rel="stylesheet" href="../../assets/css/alert_popup.css">
  <link rel="stylesheet" href="../../assets/css/mod_style_datatables.css">
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

  <link rel="stylesheet" href="../../assets/css/themify-icons.css">
  <link rel="stylesheet" href="../../assets/css/paper-bootstrap-wizard.css">


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



  <!-- DataTables CSS -->
  <link href="../../plugins/datatables/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

  <!-- DataTables Responsive CSS -->
  <link href="../../plugins/datatables/datatables-responsive/dataTables.responsive.css" rel="stylesheet">


  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="../../js/jquery-1.10.2.js"></script>
  <script src="../../js/jquery-ui.js"></script>

  <!-- Bootstrap Material DatePicker CSS-->
  <link rel="stylesheet" href="../../plugins/Datepicker/jquery.datetimepicker.css">
  <link rel="stylesheet" href="../../plugins/Datepicker/bootstrap-material-datetimepicker.css">
  <!-- Bootstrap Material DatePicker JS-->
  <script src="../../plugins/Datepicker/material.min.js"></script>
  <script src="../../plugins/Datepicker/moment-with-locales.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

  <title>CCP | Agregar Auxiliar General</title>

</head>
<body>
  <div class="container-fluid p-0">
    <?php 
    include_once "menu.php"; 
    ?>
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
                <a class="text-white" href="orden_logistica_detalles.php?idib=<?php echo "$idlogistica_encriptada"; ?>"> Regresar a Logística <b><?php echo "$idlogistica_back" ?></b></a>
              </li>
              <span class="text-white"> &nbsp;/&nbsp; </span>
              <li class="text-white" class="active">
                <strong>Agregar Auxiliar General</strong>
              </li>
            </ol>

            <br>

            <?php 
            date_default_timezone_set('America/Mexico_City');
            $fecha_creacion = date("Y-m-d H:i:s");
            ?>

            <form  action="guardar_auxiliar_general.php" method="POST">




              <div class="row">

                <div class="col-sm-12">
                  <div class="container-bg-1 p-3">
                  
                    <label for="auxiliares">*Auxiliar General</label>
                    <input type = "text" class = "form-control" name="auxiliares" list="tokenfiel" id ="auxiliares"  required="">   
                    <datalist id="tokenfiel">
                      <?php 
                      $query_auxiliares = "SELECT nombre FROM balance_gastos_auxiliares where visible='SI' group by nombre";
                      $result_auxiliares = mysql_query($query_auxiliares);
                      while ($row_auxiliares = mysql_fetch_array($result_auxiliares)) {
                        echo "<option value='$row_auxiliares[nombre]'>";
                      } 

                      ?>

                    </datalist> 
                  </div>
                </div>
                
            


                <input type="hidden" name="pasar_logistica" value='<?php echo "$pasar_logistica"; ?>'> 
                <input type="hidden" name="fecha_creacion" value='<?php echo "$fecha_creacion"; ?>'> 

                <div class="col-sm-12">
                  <center>
                    <br>  
                    <button class="btn-lg btn-primary" type="submit">Guardar</button>
                  </center>
                </div>

              </div>




            </form>




          </div>


        </div>



      </div>

      <?php 
      include_once '../footer.php';
      ?>

    </div>
  </div>
</div>

<link rel="stylesheet" type="text/css" href="../../js/jquery.datetimepicker.css"/>
<script src="../../js/jquery.datetimepicker.full.js"></script>

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
  <script src="../../assets/js/jquery.bootstrap.wizard.js"></script>
  <!-- <script src="../../assets/js/paper-bootstrap-wizard.js"></script> -->
  <script src="../../assets/js/jquery.validate.min.js"></script>

  <script src="../../plugins/Datepicker/bootstrap-material-datetimepicker.js"></script>
  <script src="../../plugins/Datepicker/es-mx.min.js"></script>

  <!-- LiBRERIAS AUTOCOMPLETAR -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>


  <script>


    $(document).ready(function() {


     $('#table_delete_movimiento').DataTable({
      language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
        }
      },
      responsive: true,
      lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
      dom: 'Blfrtip',
      buttons: [
      'copy', 'excel'
      ],

    });
     var table = $('#table_delete_movimiento').DataTable();

     table
     .order([ 0, 'asc' ])
     .draw();

     //////////////////////////////////////////////////////////////

     if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var latitud = position.coords.latitude;
        var longitud = position.coords.longitude;

        var coordenadas_1 = latitud + " " + longitud;

        $("#coordenadas").val(coordenadas_1);

      }, function() {
        handleLocationError(true);
      });
    } else {

      handleLocationError(false);
    }




  });


    function buscar_herramienta() {
      var textoBusquedaherramienta = $("#busqueda_herramienta").val();
      if (textoBusquedaherramienta != "") {
        $.post("buscar_vin_herramienta.php", 
          {valorHerramienta: textoBusquedaherramienta}, 

          function(mensaje_herramienta) {

            $("#resultadoBusquedaherramienta").html(mensaje_herramienta);

            if (mensaje_herramienta==" <b>VIN NO Encontrado</b>") {

              $("#resultadoBusquedaherramienta").show(); 
              $("#vin_herramienta").attr("readonly","readonly");      
              $("#marca_herramienta").attr("readonly","readonly");      
              $("#version_herramienta").attr("readonly","readonly");      
              $("#color_herramienta").attr("readonly","readonly");      
              $("#modelo_herramienta").attr("readonly","readonly"); 
              


            }else{   

              $("#resultadoBusquedaherramienta").show(); 
              $("#vin_herramienta").attr("readonly","readonly");      
              $("#marca_herramienta").attr("readonly","readonly");      
              $("#version_herramienta").attr("readonly","readonly");      
              $("#color_herramienta").attr("readonly","readonly");      
              $("#modelo_herramienta").attr("readonly","readonly");      
            }
          });
      } else { 
        $("#resultadoBusquedaherramienta").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
      };
    };
    $(document).on('click', '.sugerencias_herramienta', function (event) {
      event.preventDefault();            
      aux_recibido=$(this).val();
      var porcion = aux_recibido.split(';');
      unidad_herramientavin=porcion[0];
      unidad_htvin=porcion[1];
      unidad_htmarca=porcion[2];
      unidad_htversion=porcion[3];
      unidad_htcolor=porcion[4];
      unidad_htmodelo=porcion[5];
      unidad_httipo=porcion[6];


      $("#resultadoBusquedaherramienta").hide();
      $("#busqueda_herramienta").val("");
      $("#tipo_herramienta").val(unidad_httipo);
      $("#vin_herramienta").val(unidad_htvin);
      $("#marca_herramienta").val(unidad_htmarca);
      $("#version_herramienta").val(unidad_htversion);
      $("#color_herramienta").val(unidad_htcolor);
      $("#modelo_herramienta").val(unidad_htmodelo);
      $("#resultadoBusquedaherramienta").html("");


    });


    function validar_vin(){

      var txtvin_herramienta = $("#vin_herramienta").val();
      var txtcomentarios = $("#comentarios").val();

      if(txtvin_herramienta == null || txtvin_herramienta.length == 0 || /^\s+$/.test(txtvin_herramienta)){
        alert('ERROR: Debes ingresar un VIN');
        $("#busqueda_herramienta").focus();
        return false;
      }


      if(txtcomentarios == null || txtcomentarios.length == 0 || /^\s+$/.test(txtcomentarios)){
        alert('ERROR: Debes ingresar un comentarios');
        $("#comentarios").focus();
        return false;
      }



      return true;
    }





  </script>



</body>
</html>