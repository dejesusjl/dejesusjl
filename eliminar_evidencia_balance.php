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
$id_b_g_o = $_REQUEST['idbgodelete'];
$id_balance_gastos_operacion = base64_decode($id_b_g_o);

$idlogistica_encriptada = $_REQUEST['clm2delete'];

$logistica_desencriptada = base64_decode($idlogistica_encriptada);



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
  <title>CCP | Eliminar Evidencia</title>

</head>
<body>
  <div class="container-fluid p-0">
    <?php 
    include_once "menu.php"; 
    ?>
    <div class="col-sm-9 col-xs-12 content pt-3 p-0">
      <div class="row mt-3 m-0">
        <div class="col-sm-12">
          <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">



           <br><br>
           <center><span class="image-construccion"><img src="../../img/300X300.png" alt=""></span></center>

           <br><br><br><br><br>

           <center>
            <div class="alert alert-success" role="alert" id="success_alert" style="display: none;">
              <h1>Evidencia Eliminada EXITOSAMENTE</h1>
            </div>

            <div class="alert alert-danger" role="alert" id="fail_alert" style="display: none;">
              <h1>Se ha producido un ERROR al eliminar la evidencia</h1>



            </div>

            <div class="alert alert-info" role="alert" id="alert_alert" style="display: none;">

              <h4>Error al:</h4>


            </div>

          </center>  

          <?php 


          $update_balance = "UPDATE balance_gastos_operacion set archivo = 'Pendiente' WHERE idbalance_gastos_operacion = '$id_balance_gastos_operacion' AND columna2 = '$logistica_desencriptada'";
          $result_balance = mysql_query($update_balance);

          $ver_errores = ($result_balance == 1) ? "Sin Errores" : "Error al Actualizar movimiento $id_balance_gastos_operacion" ;

          ?>
          <script>

            var si_error_no = '<?php echo $ver_errores; ?>'
            var numeros_whats ='<?php echo $whatsapp_colaboradores;?>'
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
              location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
            }

            function ordenLogistica(idlogistica){
              location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
            }

            $(document).ready(function(){
              $("#continuar").click(function(){
                location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
              }); 

              $("#yes").click(function(){
                location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
              }); 

              $("#nel").click(function(){
                location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
              });
            });


          </script>


        </div>
      </div>
    </div>

    <?php 
    include_once '../footer.php';
    ?>

  </div>
</div>
</div>





</body>
</html>