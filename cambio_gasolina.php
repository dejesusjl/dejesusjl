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

  $id_balance_gastos_operacion = $_REQUEST['idbgo'];
  $id_balance_gastos_operaciondes = base64_decode($id_balance_gastos_operacion);
  $clm2 = base64_decode($_REQUEST['clm2']);
  $idlogistica = base64_encode($clm2);

  $array_ides = "";


  $idlogistica_encriptada = $idlogistica;
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
    <!--Font Awesome
    <link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../assets/css/fontawesome.css">           -->
    <!--Slick Carousel CSS-->
    <link rel="stylesheet" href="../../assets/css/slick/slick.css">
    <link rel="stylesheet" href="../../assets/css/slick/slick-theme.css">
    <!--Rating Bars
    <link rel="stylesheet" href="../../assets/css/fontawesome-stars.css">   -->
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

    <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> -->

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

      <!-- Bootstrap Material DatePicker CSS-->
      <link rel="stylesheet" href="../../plugins/Datepicker/jquery.datetimepicker.css">
      <link rel="stylesheet" href="../../plugins/Datepicker/bootstrap-material-datetimepicker.css">
      <!-- Bootstrap Material DatePicker JS-->
      <script src="../../plugins/Datepicker/material.min.js"></script>
      <script src="../../plugins/Datepicker/moment-with-locales.min.js"></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
     

      <style>
      /*/ Mi Radio Button/*/
      .content-input input,
      .content-select select{
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
      }
       
      .content-input input{
        visibility: hidden;
        position: absolute;
        right: 0;
      }
      .content-input{
        position: relative;
        margin-bottom: 10px;
        padding:12px 5px 1px 5px; /* Damos un padding de 60px para posicionar 
              el elemento <i> en este espacio*/
        display: block;
      }
       
      /* Estas reglas se aplicarán a todos las elementos i 
      después de cualquier input*/
      .content-input input + i{
             background: #6F0000 ;
             border:2px solid rgba(0,0,0,0.2);
             position: absolute; 
             left: 70;
      }
       
      /* Estas reglas se aplicarán a todos los i despues 
      de un input de tipo checkbox*/
      .content-input input[type=checkbox ] + i{
        width: 100px;
        height: 20px;
        border-radius: 10px;
      }

      /*
      Creamos el círculo que aparece encima de los checkbox
      con la etqieta before. Importante aunque no haya contenido
      debemos poner definir este valor.
      */
      .content-input input[type=checkbox] + i:before{
        content: ''; /* No hay contenido */
        width: 17px;
        height: 17px;
        background: #fff;
        border-radius: 75%;
        position: absolute;
        z-index: 1;
        left: 0px;
        top: 0px;
        -webkit-box-shadow: 3px 0 3px 0 rgba(0,0,0,0.2);
        box-shadow: 3px 0 3px 0 rgba(0,0,0,0.2);
      }
      .content-input input[type=checkbox]:checked + i:before{
        left: 80px;
        -webkit-box-shadow: -3px 0 3px 0 rgba(0,0,0,0.2);
        box-shadow: 3px 0 -3px 0 rgba(0,0,0,0.2);
      }
       
      .content-input input[type=checkbox]:checked + i{
       background: #267D02;
      }
      .content-input input[type=checkbox] + i:after{
        content: 'Precio';
        position: absolute;
        font-size: 20px;
        color: rgba(255,255,255,1);
        top: 0px;
        left: 25px;
        opacity: 1 /* Ocultamos este elemento */;
        transition: all 0.25s ease 0.25s;
      }
       
      /* Cuando esté checkeado cambiamos la opacidad a 1 y lo mostramos */
      .content-input input[type=checkbox]:checked + i:after{        
        content: 'Litros';
       opacity: 1;
      }
    </style>

      <title>CCP | Cambiar Costo del Combustible</title>

    </head>
    <body>
      <div class="container-fluid p-0">
        <?php 
        include_once "menu.php"; 
        ?>
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
                    <a class="text-white" href="orden_logistica_detalles.php?idib=<?php echo "$idlogistica_encriptada"; ?>"> Regresar a Logística <b><?php echo "$idlogistica_back" ?></b></a>
                  </li>
                  <span class="text-white"> &nbsp;/&nbsp; </span>
                  <li class="text-white" class="active">
                    <strong>Cambiar Datos del Combustible</strong>
                  </li>
                </ol>

                <br>

                <?php 
                date_default_timezone_set('America/Mexico_City');
                $fecha_creacion = date("Y-m-d H:i:s");
                ?>

                <form method="POST" id="form_vin_individual" action="guardar_cambio_gasolina.php" onsubmit="return validar_vin();" >



                  <div class="container-bg-1 p-3">
                    <div class="table-responsive">

                      <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="table_vin_individual">

                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Id</th>
                            <th>Concepto</th>   
                            <th>T.Movimiento</th>   
                            <th>Fecha Movimiento</th>
                            <th>Monto</th>
                            <th>VIN</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php 
                          $count = 0;
                          $count1 = 1;

                          $query_balance = "SELECT * FROM balance_gastos_operacion where idbalance_gastos_operacion = '$id_balance_gastos_operaciondes' and visible = 'SI'";
                          $result_balance = mysql_query($query_balance);

                          while ($row_balance = mysql_fetch_array($result_balance)) {
                            $count ++;
                            $id_balance = $row_balance[idbalance_gastos_operacion];
                            $c_concepto = $row_balance[concepto];
                            $t_movimiento = $row_balance[tipo_movimiento];
                            $f_movimiento = $row_balance[fecha_movimiento];
                            $d_vin = $row_balance[datos_vin];
                            $c_3 = $row_balance[columna3];
                            $monto = "$".number_format($row_balance[gran_total]);
                            $Monto2="<input  type='number' name='monto_cargado' id='monto_cargado' value='". $row_balance[gran_total] ."'  class='form-control' readonly=''>";
                            //console.log("Tienes un rendimiento: ".$row_balance[gran_total]);


                            if ($t_movimiento == "cargo") {
                              $query_balance1 = "SELECT * FROM balance_gastos_operacion where columna3 = '$id_balance' and visible = 'SI'";
                              $result_balance1 = mysql_query($query_balance1);
                              if (mysql_num_rows($result_balance1) >=1) {

                                echo "
                                      <tr>
                                      <td>$count</td>
                                      <td>$id_balance</td>
                                      <td>$c_concepto</td>
                                      <td>$t_movimiento</td>
                                      <td>$f_movimiento</td>
                                      <td>$monto</td>
                                      <td>$d_vin</td>
                                      </tr>
                                      ";

                                while ($row_balance1 = mysql_fetch_array($result_balance1)) {

                                  $count1 ++;
                                  $id_balance1 = $row_balance1[idbalance_gastos_operacion];
                                  $c_concepto1 = $row_balance1[concepto];
                                  $t_movimiento1 = $row_balance1[tipo_movimiento];
                                  $f_movimiento1 = $row_balance1[fecha_movimiento];
                                  $d_vin1 = $row_balance1[datos_vin];
                                  $monto1 = "$".number_format($row_balance1[gran_total]);
                                  echo "
                                  <tr>
                                  <td>$count1</td>
                                  <td>$id_balance1</td>
                                  <td>$c_concepto1</td>
                                  <td>$t_movimiento1</td>
                                  <td>$f_movimiento1</td>
                                  <td>$monto1</td>
                                  <td>$d_vin1</td>
                                  </tr>
                                  ";
                                  $array_ides = $id_balance.";$id_balance1";
                                }
                              }else{
                                $array_ides = $id_balance;
                                echo "
                                <tr>
                                <td>$count</td>
                                <td>$id_balance</td>
                                <td>$c_concepto</td>
                                <td>$t_movimiento</td>
                                <td>$f_movimiento</td>
                                <td>$monto</td>
                                <td>$d_vin</td>
                                </tr>
                                ";
                              }
                            }else{


                              $query_balance_abono = "SELECT * FROM balance_gastos_operacion where idbalance_gastos_operacion = '$c_3' and visible = 'SI'";
                              $result_balance_abano = mysql_query($query_balance_abono);

                              if (mysql_num_rows($result_balance_abano) >= 1) {

                                echo "
                                <tr>
                                <td>$count</td>
                                <td>$id_balance</td>
                                <td>$c_concepto</td>
                                <td>$t_movimiento</td>
                                <td>$f_movimiento</td>
                                <td>$monto</td>
                                <td>$d_vin</td>
                                </tr>
                                ";

                                while ($row_balance1 = mysql_fetch_array($result_balance_abano)) {

                                  $count1 ++;
                                  $id_balance1 = $row_balance1[idbalance_gastos_operacion];
                                  $c_concepto1 = $row_balance1[concepto];
                                  $t_movimiento1 = $row_balance1[tipo_movimiento];
                                  $f_movimiento1 = $row_balance1[fecha_movimiento];
                                  $d_vin1 = $row_balance1[datos_vin];
                                  $monto1 = "$".number_format($row_balance1[gran_total]);
                                  echo "
                                  <tr>
                                  <td>$count1</td>
                                  <td>$id_balance1</td>
                                  <td>$c_concepto1</td>
                                  <td>$t_movimiento1</td>
                                  <td>$f_movimiento1</td>
                                  <td>$monto1</td>
                                  <td>$d_vin1</td>
                                  </tr>
                                  ";
                                  $array_ides = $id_balance.";$id_balance1";
                                }

                              }else{

                                echo "
                                <tr>
                                <td>$count</td>
                                <td>$id_balance</td>
                                <td>$c_concepto</td>
                                <td>$t_movimiento</td>
                                <td>$f_movimiento</td>
                                <td>$monto</td>
                                <td>$d_vin</td>
                                </tr>
                                ";
                                $array_ides = $id_balance;
                              }
                            }
                          }

                          ?>
                        </tbody>


                      </table>

                    </div>
                  </div>

                  <div class="container-bg-1 p-3 mt-4">

                  <div class="row">

                    <?php
                          //http://www.gasolinamx.com/estado/estado-de-mexico/acambay-de-ruiz-castaneda
                          //http://www.gasolinamx.com/precio-gasolina
                            $data = file_get_contents("http://www.gasolinamx.com/estado/estado-de-mexico/acambay-de-ruiz-castaneda");
                             
                            if ( preg_match('|<td>Magna</td>\s+<td>(.*?)</td>|is' , $data , $cap ) )
                            {
                                echo "                                
                              <div class='col-sm-12' align='center'>
                                <label for='Magna'>Magna: ".$cap[1]."</label>
                                    <input type='radio' id='Magna' class='gasolina1 radio1' name='combustible'  checked='checked' required='' value='$cap[1]'>
                                ";
                            }
                            if ( preg_match('|<td>Premium</td>\s+<td>(.*?)</td>|is' , $data , $cap ) )
                            {
                                echo "<label for='Premium'>Premium: ".$cap[1]."</label>
                                  <input type='radio' id='Premium' class='gasolina2 radio1' name='combustible'   required='' value='$cap[1]'>
                                ";
                            }
                            if ( preg_match('|<td>Diesel</td>\s+<td>(.*?)</td>|is' , $data , $cap ) )
                            {
                                echo "<label for='Diesel'>Diésel: ".$cap[1]."</label>
                                    <input type='radio' id='Diesel' class='gasolina3 radio1' name='combustible'   required='' value='$cap[1]'>                                   
                                </div>                                
                                ";
                            }
                          ?>
                      <div class='col-sm-4'>
                          <label class="content-input">Monto: &nbsp; &nbsp; </span>Ajustar a: <input type="checkbox" name="Vehiculo" id="modSi" value="modSi"><i></i>
                          </label>
                       <?php echo "$Monto2"; ?>
                      </div>

                      <div class='col-sm-4'>
                          <label >Combustible: &nbsp; <a href='http://www.gasolinamx.com/estado/estado-de-mexico/acambay-de-ruiz-castaneda'  target='_blank' title='Consulta el precio de la gasolina'><i class='fas fa-gas-pump'></i></a>
                          </label>
                        <input  type='number' name='precio_gas' id='precio_gas' onKeyUp='Refresh();' class='form-control' min='10' step="0.01"  placeholder="No admitido">
                      </div>

                        <div class='col-sm-4'>
                        <label>Litros:</label>
                      <input  type='number' name='litros_cargados' id='litros_cargados' onKeyUp='Refresh();' class='form-control' min= '0' readonly="" step="0.01"  placeholder="No admitido">
                    </div>

                    

                    <div class="col-sm-12 form-group">
                      <label for="comentarios">Comentarios</label>
                      <textarea name="comentarios" id="comentarios" class="form-control" cols="30" rows="3"></textarea>  
                    </div>

                  </div>

                </div>

                    <input type="hidden" name="id_balance_gastos_operacion" value="<?php echo $array_ides; ?>">
                    <input type="hidden" name="clm2" value="<?php echo $idlogistica; ?>">
                    <input type="hidden" name="fecha_creacion" value="<?php echo $fecha_creacion; ?>">
                    <input type="hidden" name="coordenadas" id="coordenadas">

                    <div class="col-sm-12">
                      <center>
                        <button class="btn-lg btn-primary" type="submit">Guardar</button>
                      </center>
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

    <!-- <script src="../../plugins/Datepicker/bootstrap-material-datetimepicker.js"></script>
    <script src="../../plugins/Datepicker/es-mx.min.js"></script>                                   -->

    <!-- LiBRERIAS AUTOCOMPLETAR -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>


    <script>


      $(document).ready(function() {


       $('#table_vin_individual').DataTable({
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
       var table = $('#table_vin_individual').DataTable();

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

      $("#Magna").get(0).click();


    });


 $(document).on('click', '#modSi', function (event) {
    if ($('#modSi').is(':checked')) {
       $('#precio_gas').prop('readonly', true);
      $('#litros_cargados').removeAttr("readOnly");
    }else{      
       $('#precio_gas').removeAttr("readOnly");
      $('#litros_cargados').prop('readonly', true);
    }
});

function Refresh(){  
  costoTotal=$("#monto_cargado").val();
  if ($('#modSi').is(':checked')) {

      litros=$('#litros_cargados').val();
      precioG=(costoTotal/litros).toFixed(2);

      console.log("Monto total: "+costoTotal+"  Litros: "+litros+"  Precio Unitario: "+precioG);

      $('#precio_gas').val(precioG);

  }else{ 
    precioUnitario=$('#precio_gas').val();
    litros=(costoTotal/precioUnitario).toFixed(2);    

    console.log("Monto total: "+costoTotal+"  precio Unitario: "+precioUnitario+"  Litros Cargados: "+litros);

    $('#litros_cargados').val(litros);
  }
}

 $(document).on('click', '#Magna', function (event) {
    if ($('#Magna').is(':checked') && !$('#modSi').is(':checked')) {
      p=$('#Magna').val();
       $('#precio_gas').val(p);
       Refresh();
    }
});

 $(document).on('click', '#Premium', function (event) {
    if ($('#Premium').is(':checked') && !$('#modSi').is(':checked')) {
       p=$('#Premium').val();
       $('#precio_gas').val(p);
       Refresh();
    }
});

  $(document).on('click', '#Diesel', function (event) {
    if ($('#Diesel').is(':checked') && !$('#modSi').is(':checked')) {
       p=$('#Diesel').val();
       $('#precio_gas').val(p);
       Refresh();
    }
});




    </script>



  </body>
  </html>