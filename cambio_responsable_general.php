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


$id_logistica_desencriptada = base64_decode($_REQUEST['idl']);
$idlogistica = base64_encode($id_logistica_desencriptada);

$n1=strlen($id_logistica_desencriptada);
$n1_aux=6-$n1;
$mat="";

for ($i=0; $i <$n1_aux ; $i++) { 
  $mat.="0";
}

$id_contacto_completo = $mat.$id_logistica_desencriptada;


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
  <link rel="stylesheet" href="../../assets/css/mod_style_datatables.css">
  <link rel="stylesheet" href="../../assets/css/alert_popup.css">
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
  <title>CCP | Cambiar Responsable Balance General</title>

  <style>
    .sugerencias_herramienta:hover{
      background-color: #adadad;
      cursor:default;
    }
    
  </style>
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
                <a class="text-white" href="orden_logistica_detalles.php?idib=<?php echo "$idlogistica"; ?>"> Regresar a Logística <b><?php echo "$id_logistica_desencriptada" ?></b></a>
              </li>
              <span class="text-white"> &nbsp;/&nbsp; </span>
              <li class="active text-white">
                <strong>Cambiar VIN Balance de Gastos General</strong>
              </li>
            </ol>

            <br>
            
            <?php 
            date_default_timezone_set('America/Mexico_City');
            $fecha_creacion = date("Y-m-d H:i:s");
            ?>
            <center>
              <h2 class="text-ids-1"><?php echo "L".$id_contacto_completo; ?></h2>
            </center>


            <div id="ver_documentacion">
              <div>
                <h3 class="text-titulos-1 my-4">Balance de Gastos de Operación</h3>  
              </div>

              <div class="container-bg-1 p-3">

                <div class="table-responsive"> 

                  <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="table_vin">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Concepto</th> 
                        <th>T. Movimiento</th>  
                        <th>Auxiliares</th>   
                        <th>Fecha Movimiento</th>
                        <th>Responsable</th>
                      </tr>
                    </thead>
                    <tbody>  

                      <?php 
                      $count = 0;


                      $query_balance = "SELECT * FROM balance_gastos_operacion where columna2 = '$id_logistica_desencriptada' and visible = 'SI'";
                      $result_balance = mysql_query($query_balance);

                      while ($row_balance = mysql_fetch_array($result_balance)) {
                        $count ++;
                        $id_balance = $row_balance[idbalance_gastos_operacion];
                        $c_concepto = $row_balance[concepto];
                        $t_movimiento = $row_balance[tipo_movimiento];
                        $f_movimiento = $row_balance[fecha_movimiento];
                        $apartado_usado = $row_balance[apartado_usado];
                        $apartado_usado = $row_balance[apartado_usado];
                        $monto = "$".number_format($row_balance[gran_total]);

                        if (is_numeric($row_balance[responsable])) {

                          $query_responsable = "SELECT * FROM empleados where idempleados = '$row_balance[responsable]'"; 
                          $result_responsable = mysql_query($query_responsable); 

                          while ($row_responsable = mysql_fetch_array($result_responsable)) {

                            $responsable = $row_responsable[columna_b];
                          }

                        } else {
                          $responsable = $row_balance[responsable];
                        }


                        echo "
                        <tr>
                        <td>$count</td>
                        <td>$id_balance</td>
                        <td>$c_concepto</td>
                        <td>$t_movimiento</td>
                        <td>$apartado_usado</td>
                        <td>$f_movimiento</td>
                        <td>$responsable</td>
                        </tr>
                        ";
                        }

                      ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="container-bg-1 p-3 mt-4">
              
                <form action="guardar_cambio_responsable_general.php" method="POST" onsubmit="return validar_vin();" >

                  <div class="row m-0">

                    <div class="col-sm-12">
                      <label for="busqueda_asesor">Buscar Responsable</label>
                      <input placeholder="Buscar" class="form-control" type="text" name="busqueda_asesor" id="busqueda_asesor" value="" maxlength="25" autocomplete="off" onKeyUp="buscar_asesor();" size="19" width="300%"  />
                      <center>
                        <div id="resultadoBusquedaAsesor" class="container-busquedas-1 mt-4 efecto-busqueda" style="display: none;"></div>
                      </center>
                    </div>

                    <div class="col-sm-12">
                      <label for="solicitante">*Responsable</label>
                      <input class="form-control" type="text" name="solicitante" id="solicitante" readonly="" />
                    </div>

                    <input type="hidden" name="idresponsable" id="idresponsable">
                    <input type="hidden" name="nomenclatura" id="nomenclatura">


                    <div class="col-sm-12">
                      <label for="comentarios">*Comentarios de Cambio de Responsable</label>
                      <textarea name="comentarios" id="comentarios" class="form-control" cols="30" rows="3"></textarea>
                    </div>

                    <input type="hidden" name="idlogistica" value="<?php echo $idlogistica ?>">
                    <input type="hidden" name="fecha_creacion" value="<?php echo $fecha_creacion ?>">
                    <input type="hidden" name="coordenadas" id="coordenadas">

                    <div class="col-sm-12">
                      <br>
                      <center>
                        <button class="btn btn-lg btn-primary" id="enviar" type="submit">Guardar</button>
                      </center>
                      <br>
                    </div>

                  </div>

                </form>
              </div>

          </div>



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

    // --------------------------------------
    $('#table_vin').DataTable({
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

      ],

    });

    var table = $('#table_vin').DataTable();

    table
    .order([ 0, 'asc' ])
    .draw();
    // --------------------------------------
    $(document).ready(function() {

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

    function buscar_asesor() {
      var textoBusquedaAsesor = $("#busqueda_asesor").val();
      if (textoBusquedaAsesor != "") {
        $.post("buscar_id_colaborador_completo.php", {valorBusqueda: textoBusquedaAsesor}, function(mensaje_asesor) {
          $("#resultadoBusquedaAsesor").html(mensaje_asesor);
          if (mensaje_asesor==" <b>Asesor NO Encontrado</b>") {
            $("#resultadoBusquedaAsesor").show();
            $("#solicitante").attr("readonly","readonly");
          }else{    
            $("#resultadoBusquedaAsesor").show();
            $("#solicitante").attr("readonly","readonly");         
          }
        });
      } else { 
        $("#resultadoBusquedaAsesor").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
      };
    };
    $(document).on('click', '.sugerencias_asesor', function (event) {
      event.preventDefault();            
      aux_recibido=$(this).val();
      var porcion = aux_recibido.split(';');
      unidad_idresponsable=porcion[0];
      unidad_nombre=porcion[7];
      unidad_apellidop=porcion[7];
      unidad_apellidom=porcion[5];
      unidad_nomenclatura=porcion[80];
      tipo_solicitante=porcion[6];
      $("#resultadoBusquedaAsesor").hide();
      $("#busqueda_asesor").val("");
      $("#idresponsable").val(unidad_idresponsable);
      $("#solicitante").val(unidad_nombre + " " + unidad_apellidop + " " + unidad_apellidom);
      $("#nomenclatura").val(unidad_nomenclatura);
      $("#tipo_solicitante").val(tipo_solicitante);
      $("#resultadoBusquedaAsesor").html("");
    });


    function validar_vin(){

      var txtidresponsable = $("#idresponsable").val();
      var txtcomentarios = $("#comentarios").val();

      if(txtidresponsable == null || txtidresponsable.length == 0 || /^\s+$/.test(txtidresponsable)){
        // alert('ERROR: Debes ingresar un Responsable');
        $(".error-form").show();
        $(".text-error").html("ERROR: Debes ingresar un Responsable");

        setTimeout(function(){
          $(".error-form").fadeOut(1000);
        }, 1500);
        $("#busqueda_asesor").focus();
        return false;
      }


      if(txtcomentarios == null || txtcomentarios.length == 0 || /^\s+$/.test(txtcomentarios)){
        // alert('ERROR: Debes ingresar un comentarios');
        $(".error-form").show();
        $(".text-error").html("ERROR: Debes ingresar comentarios");

        setTimeout(function(){
          $(".error-form").fadeOut(1000);
        }, 1500);
        $("#comentarios").focus();
        return false;
      }



      return true;
    }


  </script>

</body>
</html>