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
$accion = $_REQUEST['acc'];
$idTarjetaEncriptada = $_REQUEST['idTar'];
$idTarjeta = base64_decode($_REQUEST['idTar']);

$card = $_REQUEST['card'];
$card_name = $_REQUEST['card_name'];
$name_id = $_REQUEST['name_id'];

$tarjeta = base64_decode($card);
$nombre_tarjeta = strtoupper(base64_decode($card_name));
$responsable = base64_decode($name_id);









if($accion=='erase'){  
  
            $consulta= "select columna_b from catalogo_monederos_electronicos where idcatalogo_monederos_electronicos='$idTarjeta';";
            $tabla=mysql_query($consulta);
            $evidencia='';

            while($fila=mysql_fetch_array($tabla)){
              $evidencia=$fila[columna_b];
            }

            $contenido='Se elimino evidencia <br /> Tarjeta: <b>'. $nombre_tarjeta.'</b> No: <b>'.chunk_split($tarjeta,4," ").'</b> <br />Responsable: <b>'.$responsable.'</b>';
            $movimiento='Evidencia';

            $fecha_creacion=date("Y-m-d H:i:s");

            $sql2 = "INSERT INTO catalogo_monedero_electronico_bitacora (id_monedero_electronico, contenido, movimiento, evidencia, usuario_creador, fecha_creacion, fecha_guardado, visible) 
                  VALUES ('$idTarjeta', '$contenido', '$movimiento', '$evidencia', '$usuario_creador', '$fecha_creacion', '$fecha_creacion', 'SI');";

                $result2 = mysql_query($sql2);

            if ($result2 == 1) {      
               
                   echo "
                  <script>
                      console.log('Se Creo Bitacora');
                  </script>
                  ";     
            }else{      
                   echo "
                  <script>
                      console.log('Error al crear Bitacora'+);
                  </script>
                  ";
            }

            $sql = "UPDATE catalogo_monederos_electronicos SET columna_b = '' WHERE idcatalogo_monederos_electronicos = '$idTarjeta';";
            $result = mysql_query($sql);

            if ($result == 1) {      
               
                   echo "
              <script>
                  location.replace(`electronic_card.php?tipo=success&mensaje=Borrado Exitosamente$result2`);
                  </script>
                  ";     
            }else{
              
                   echo "
              <script>
                  location.replace(`electronic_card.php?tipo=error&mensaje=Fallo al Borrar`);
                  </script>
                  ";
            }

   
    
}else{
       $consulta= "select columna_b from catalogo_monederos_electronicos where idcatalogo_monederos_electronicos='$idTarjeta';";
            $tabla=mysql_query($consulta);
            $evidencia='';

            while($fila=mysql_fetch_array($tabla)){
              $evidencia=$fila[columna_b];
            }

            

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
  <title>CCP | Subir Evidencia Tarjeta</title>

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
              <a class="text-white" href="electronic_card.php">Resumen Monedero Electronico</a>
              <span class="text-white"> &nbsp;/&nbsp; </span>
              <li class="text-white" class="active">
                <strong>Subir Evidencia <?php echo chunk_split($tarjeta,4," "); ?></strong>
              </li>
            </ol>

            <br>
            
            <?php 
            date_default_timezone_set('America/Mexico_City');
            $fecha_creacion = date("Y-m-d H:i:s");
            ?>

            <form name="formulario" id="formulario" action="guardar_archivo_evidencia.php" method="POST" enctype="multipart/form-data">
              <div class="col-sm-12 p-0">
                <div class="form-group row">

                  <div class="col-sm-12">
                    <div class="container-bg-1 p-3">
                      <div class="row">
                        <div class="col-sm-12">
                          <label for="titulo">Evidencia:</label>
                          <input class="form-control-file" type="file" id="titulo" name="uploadedfile" required=""/>
                          <input class="form-control" type="hidden" id="tarjeta" name="tarjeta" required="" value="<?php echo $idTarjetaEncriptada ?>" />
                          <input class="form-control" type="hidden" id="No_tarjeta" name="No_tarjeta" required="" value="<?php echo $tarjeta ?>" />
                          <input class="form-control" type="hidden" id="nombre_tarjeta" name="nombre_tarjeta" required="" value="<?php echo $nombre_tarjeta ?>" />
                          <input class="form-control" type="hidden" id="responsable" name="responsable" required="" value="<?php echo $responsable ?>" />
                          <input class="form-control" type="hidden" id="fecha_creacion" name="fecha_creacion" required="" value="<?php echo $fecha_guardado ?>" />

                        </div>
                      </div>
                    </div>
                  </div>                               

                  <div class="col-sm-12">
                    <center>
                      <br>  
                      <button class="btn-lg btn-primary" id="show_date" type="submit">Guardar</button>
                    </center>
                  </div>

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



<script type="text/javascript">

  $(document).ready(function() {

    $(document).on('change','input[type="file"]',function(){
    // this.files[0].size recupera el tamaño del archivo
    // alert(this.files[0].size);
    
    var fileName = this.files[0].name;
    var fileSize = this.files[0].size;
    

    if(fileSize > 9216000){



      alert('El archivo no debe superar los 9MB ');
      this.value = '';
      this.files[0].name = '';
      return false;
    }else{

     return true;

   }
 });


  });


</script>

</body>
</html>


