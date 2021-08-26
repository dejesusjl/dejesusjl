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

$idlogistica_encriptada = $_REQUEST['value'];
$id_logistica = base64_decode($idlogistica_encriptada);


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
  <link rel="stylesheet" href="../../assets/css/alert_popup.css">
  <link rel="stylesheet" href="../../assets/css/mod_style_datatables.css">
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
  <title>CCP | Eliminar Movimientos Bitácora</title>

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
                <a class="text-white" href="orden_logistica_detalles.php?idib=<?php echo $idlogistica_encriptada; ?>">Regresar a Logística <b><?php echo base64_decode($idlogistica_encriptada); ?></b></a>
              </li>
              <span class="text-white"> &nbsp;/&nbsp; </span>
              <li class="active text-white">
                <strong>Eliminar Movimientos</strong>
              </li>
            </ol>

            <br>
            
            <?php 
            date_default_timezone_set('America/Mexico_City');
            $fecha_creacion = date("Y-m-d H:i:s");
            ?>

            <form method="POST" action="guardar_delete_bitacora.php">

              <div class="col-lg-12 p-0">

                <div class="row">
                  <div class="col-sm-12">
                    <div class="container-bg-1 p-3">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover panel-body-center-table" id="example" style="width: 100%;">
                          <thead>
                            <tr>
                              <th>ID Movimiento&nbsp;&nbsp;&nbsp;</th>
                              <th>Tipo</th>
                              <th>Descripción</th>
                              <th>Usuario&nbsp;&nbsp;&nbsp;&nbsp;</th>
                              <th>Seleccionar</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php 


                          $query_bitacora = "SELECT * FROM orden_logistica_bitacora where idorden_logistica = '$id_logistica' and visible = 'SI' order by idorden_logistica_bitacora desc";
                          $result_bitacora = mysql_query($query_bitacora);

                          while ($row_bitacora = mysql_fetch_array($result_bitacora)) {

                            $idorden_logistica_bitacora = $row_bitacora[idorden_logistica_bitacora];




                            $query_usuario = "SELECT * FROM usuarios WHERE idusuario = '$row_bitacora[usuario_creador]'";
                            $result_usuario = mysql_query($query_usuario);

                            while ($row_usuario = mysql_fetch_array($result_usuario)) {
                              $nomenclatura_ccp = $row_usuario[nombre_usuario];
                            }

                            echo "
                            <tr class='odd gradeX'>
                            <td> $row_bitacora[idorden_logistica_bitacora]</td>
                            <td>$row_bitacora[tipo]</td>
                            <td align='justify'>$row_bitacora[descripcion]</td>
                            <td>$nomenclatura_ccp</td>
                            <td><input type='checkbox' name='idbitacora[]' class='filtros' id='exampleRadios$idorden_logistica_bitacora' value='$idorden_logistica_bitacora' >
                            </td>
                            </tr>
                            ";

                          }

                          ?>
                          </tbody>
                        </table>
                      </div>  
                    </div>
                  </div>
                  
                </div>
              </div>
              <center>
                <button class="btn btn-lg btn-primary" id="enviar" type="submit">Guardar</button>
                <input type="hidden" name="id_logistica" value="<?php echo $idlogistica_encriptada; ?>">
              </center>

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

<script>
  $(document).ready(function(){
    $('#example').DataTable({
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
    });
  });
</script>

</body>
</html>