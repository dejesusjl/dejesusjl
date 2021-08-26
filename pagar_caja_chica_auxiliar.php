<?php 
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
include_once "funciones_principales.php"; 
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$fecha_movimiento = date("Y-m-d");
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






$query_responsable_balance = "SELECT responsable FROM balance_gastos_operacion WHERE visible = 'SI' AND trim(columna2) = '$idlogistica_back' AND trim(tipo_movimiento) = 'cargo' AND trim(comision) = 'N/A' and (columna7 <> 'Pagado'  OR columna7 IS NULL) GROUP BY responsable";
$result_responsable_balance = mysql_query($query_responsable_balance);

$ocultar_desocultar_form = mysql_num_rows($result_responsable_balance);

while ($row_responsable_balance = mysql_fetch_array($result_responsable_balance)) {

  if (is_numeric($row_responsable_balance[responsable])) {

    $show_responsable_select = nombres_datos($row_responsable_balance[responsable], "Colaborador");
    $porciones_responsable_select = explode("|", $show_responsable_select);

    $name_responsable_select = $porciones_responsable_select[10];

  }else {

   $name_responsable_select = $row_responsable_balance[responsable];

 }

 $select_responsable .= "<option value='$row_responsable_balance[responsable]'>$name_responsable_select</option>";

}


$n1=strlen($idlogistica_back);
$n1_aux =6-$n1;
$mat = "";

for ($i=0; $i <$n1_aux ; $i++) { 
  $mat.= "0";
}

$referencia = "L".$mat.$idlogistica_back;



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

  <title>CCP | Caja Chica - Logistica</title>

</head>
<body onload="show_functions()">

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
                <strong>Pago Directo Caja Chica</strong>
              </li>
            </ol>

            <br>

            <?php 
            date_default_timezone_set('America/Mexico_City');
            $fecha_creacion = date("Y-m-d H:i:s");
            ?>



            <div class="col-sm-12" id="show_table_pagar_colaborador">




            </div>










            <form  action="guardar_caja_chica_auxiliar.php" onsubmit="return validar_cajachica();" method="POST" id="form_caja_chica" style="display: none;">




              <div class="row col-sm-12">

                <div class="col-sm-6">
                  <label>*Concepto</label>
                  <input type="text" class="form-control" name="concepto" value="GASTOS DE TRASLADO" readonly="">
                </div>


                <div class="col-sm-6">
                  <label>*Trasladista</label>
                  <select name="responsable" id="responsable" class="form-control">
                    <option value="">Selecciona una opción...</option>
                    <?php echo $select_responsable; ?>
                  </select>
                </div>

                <div class="col-sm-6">
                  <label>*Proveedor</label>
                  <input type="text" name="idcatalogo_provedores" id="idcatalogo_provedores" class="form-control" readonly>
                </div>

                <div class="col-sm-6">
                  <label>*Departamento</label>
                  <select name="idcatalogo_departamento" id="idcatalogo_departamento" class="form-control" readonly>
                  </select>
                </div>

                <div class="col-sm-12">
                  <label>*Auxiliares</label>
                  <textarea name="apartado_usado" id="apartado_usado" class="form-control" rows="3" readonly></textarea>
                </div>

                <div class="col-sm-3">
                  <label>*VIN</label>
                  <select name="datos_vin" id="datos_vin" class="form-control"></select>
                </div>

                <div class="col-sm-3">
                  <label>*Fecha Movimiento</label>
                  <input type="text" class="form-control" name="fecha_movimiento" value="<?php echo $fecha_movimiento; ?>" readonly="">
                </div>

                <div class="col-sm-3">
                  <label>*Monto Total</label>
                  <input type="text" class="form-control" name="gran_total" id="gran_total" readonly value="">
                </div>

                <div class="col-sm-3">
                  <label>*Referencia</label>
                  <input type="text" class="form-control" name="referencia" value="<?php echo $referencia; ?>" readonly>
                </div>

                <div class="col-sm-6">
                  <label>*Institución Emisora</label>
                  <input type="text" id="emisora_institucion" class="form-control" name="emisora_institucion" readonly="">
                </div>

                <div class="col-sm-6">
                  <label>*Agente Emisor</label>
                  <input type="text" id="emisora_agente" class="form-control" name="emisora_agente" readonly="">
                </div>

                <div class="col-sm-6">
                  <label>*Institución Receptora</label>
                  <input type="text" id="receptora_institucion" class="form-control" name="receptora_institucion" value="Panamotors Center, S.A. de C.V." readonly="">
                </div>

                <div class="col-sm-6">
                  <label>*Agente Receptor</label>
                  <input type="text" id="receptora_agente" class="form-control" name="receptora_agente" value="CCH" readonly="">
                </div>

                <div class="col-sm-12">
                  <label>*Comentarios</label>
                  <textarea name="comentarios" id="comentarios" class="form-control" rows="3"></textarea>
                </div>



                <input type="hidden" name="pasar_logistica" value='<?php echo "$pasar_logistica"; ?>'> 
                <input type="hidden" name="id_movimientos" id="id_movimientos"> 
                <input type="hidden" name="fecha_creacion" value='<?php echo "$fecha_creacion"; ?>'> 

                <div class="col-sm-12">
                  <center>
                    <br>  
                    <button class="btn-lg btn-primary" type="submit">Guardar</button>
                  </center>
                </div>

              </div>
            </form>
            <br> 

            <div class="col-sm-12 sec-datos">
              <br>
              <div><h3 class="text-titulos-1 my-4 d-flex align-items-center flex-wrap"> Resumen de Gastos Pagados</h3> 
              </div>


              <div class='container-bg-1 p-3'>
                <div class='table-responsive'>
                  <table width='100%' class='table table-striped table-bordered table-hover panel-body-center-table' id='table_gastos_pagados'>
                    <thead>

                      <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Concepto</th>
                        <th>Tipo Movimiento</th>
                        <th>Fecha_movimiento</th>
                        <th>Responsable</th>
                        <th>Monto Total</th>
                        <th>VIN</th>
                      </tr>

                    </thead>
                    <tbody>

                      <?php 
                      $count = 0;

                      $query_balance = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' AND trim(columna2) = '$idlogistica_back' AND trim(tipo_movimiento) = 'cargo' AND trim(comision) = 'N/A' and columna7 = 'Pagado' order by responsable ASC";
                      $result_balance = mysql_query($query_balance);

                      while ($row_balance = mysql_fetch_array($result_balance)) {
                        $count ++;
                        $valores .= $row_balance[idbalance_gastos_operacion]."|";

                        $fecha_movimiento = date_create($row_balance[fecha_movimiento]);
                        $fecha_movimiento = date_format($fecha_movimiento, 'd-m-Y');

                        if (is_numeric($row_balance[responsable])) {

                          $show_responsable_select = nombres_datos($row_balance[responsable], "Colaborador");
                          $porciones_responsable_select = explode("|", $show_responsable_select);

                          $name_responsable_select = $porciones_responsable_select[10];

                        }else {

                          $name_responsable_select = $row_balance[responsable];

                        }

                        $gran_total = "$".number_format($row_balance[gran_total],2);
                        $monto_comparar += $row_balance[gran_total];

                        echo "
                        <tr>
                        <td>$count</td>
                        <td>$row_balance[idbalance_gastos_operacion]</td>
                        <td>$row_balance[concepto]</td>
                        <td>$row_balance[tipo_movimiento]</td>
                        <td>$fecha_movimiento</td>
                        <td>$name_responsable_select</td>
                        <td>$gran_total</td>
                        <td>$row_balance[datos_vin]</td>
                        </tr>
                        ";

                      }

                      ?>
                    </tbody>
                    <tfoot>

                      <th colspan='6' style='text-align:right'>Total Pagado:</th>
                      <th colspan='2' style='text-align:left;' class='cantidad_total'></th>

                    </tfoot>
                  </table>

                </div>
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

<link rel="stylesheet" type="text/css" href="../../js/jquery.datetimepicker.css"/>
<script src="../../js/jquery.datetimepicker.full.js"></script>


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

  function show_functions() {

    var ocultar_desocultar_form = '<?php echo $ocultar_desocultar_form; ?>'
    console.log(ocultar_desocultar_form);

    (ocultar_desocultar_form > 0) ? $("#form_caja_chica").show() : $("#form_caja_chica").hide();

    
  }


  $(document).ready(function() {









    $("#responsable").on('change', function() {

     $("#show_table_pagar_colaborador").empty();
     $("#idcatalogo_provedores").val("");
     $("#idcatalogo_departamento").empty();
     $("#datos_vin").empty();
     $("#gran_total").val("");
     $("#apartado_usado").val("");
     $("#emisora_institucion").val("");
     $("#emisora_agente").val("");

     if ($(this).val()!="") {

      var pasar_responsable_select = $(this).val();
      var idlogistica = '<?php echo $idlogistica_back; ?>'
      var nombre = $("#responsable option:selected").text();

      $.ajax({
        url: 'tabla_caja_chica_auxiliar_ajax.php',
        data: {
          idlogistica: idlogistica,
          idcolaborador: pasar_responsable_select 
        },
        type: 'POST',
        success: function(datetablepagar) {

          $("#show_table_pagar_colaborador").empty();
          $("#show_table_pagar_colaborador").html(datetablepagar);

          var valores = $("#valores").val();
          $("#id_movimientos").val(valores);

          $.ajax({
            url: 'obtener_datos_balance_ajax.php',
            data: {
              idlogistica: idlogistica,
              idcolaborador: pasar_responsable_select,
              valores: valores,
            },
            type: 'POST',
            success: function(json) {

              var porcionesajax = json.split('|');

              if (porcionesajax[0] == 0) {

                $(".error-form").show();
                $(".text-error").html("No existen movimientos");

                setTimeout(function(){
                  $(".error-form").fadeOut(1000);
                }, 1500);

              } else {

                if (porcionesajax[0] == "Error de proveedor 3" || porcionesajax[0] == "Error de proveedor 2" || porcionesajax[0] == "Error de proveedor 1") {
                  $("#idcatalogo_provedores").css("border", "4px solid #882439");

                }
                $("#idcatalogo_provedores").val(porcionesajax[0]);

                $("#idcatalogo_departamento").append(porcionesajax[1]);
                $("#datos_vin").append(porcionesajax[2]);
                $("#gran_total").val(porcionesajax[3]);
                $("#apartado_usado").val(porcionesajax[4]);
                $("#emisora_institucion").val(nombre.trim());
                $("#emisora_agente").val(nombre.trim());

              }

            },
            error: function(xhr, status) {
              $(".error-form").show();
              $(".text-error").html("Disculpe, existió un problema");

              setTimeout(function(){
                $(".error-form").fadeOut(1000);
              }, 1500);
            }
          });


        },


        error: function(xhr, status) {
          $(".error-form").show();
          $(".text-error").html("Disculpe, existió un problema");

          setTimeout(function(){
            $(".error-form").fadeOut(1000);
          }, 1500);
        }
      });
    }

  });

    var formatNumber = {
      separador: ",",
      sepDecimal: '.',
      formatear:function (num){
        num +='';
        var splitStr = num.split('.');
        var splitLeft = splitStr[0];
        var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
        var regx = /(\d+)(\d{3})/;
        while (regx.test(splitLeft)) {
          splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
        }
        return this.simbol + splitLeft  +splitRight;
      },
      new:function(num, simbol){
        this.simbol = simbol ||'';
        return this.formatear(num);
      }
    }

    $('#table_gastos_pagados').DataTable({
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
      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;


        var intVal = function ( i ) {

          var ok = i;

          if (typeof i === 'string') {

            let uno = ok.replace('$', '');
            uno = uno.replace('MXN', '');
            uno = uno.replace(',', '');
            uno = uno.replace('USD', '');
            uno = uno.replace('CAD', '');

            return uno = parseFloat(uno);

          }else if (typeof i === 'number') {

            return typeof i === 'number' ? i : 0;

          }
        };



            // Total over all pages
            total = api
            .column( 6 )
            .data()
            .reduce( function (a, b) {
              return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotal = api
            .column( 6, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
              return intVal(a) + intVal(b);
            }, 0 );

            // Update footer
            

            $( api.column( 6 ).footer() ).html(
              '$ '+formatNumber.new(pageTotal.toFixed(2))+' (Saldo Total Pagado: $ '+formatNumber.new(total.toFixed(2))+' )'
              );

            var cantidad_total = $(".cantidad_total2").html();
            $(".m-cantidad-total-2").html(cantidad_total);

          },

          responsive: true,
          lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
          dom: 'Blfrtip',
          buttons: [
          'copy', 'excel'
          ],

        });
    var table = $('#table_gastos_pagados').DataTable();

    table
    .order([ 0, 'asc' ])
    .draw();

     //////////////////////////////////////////////////////////////




   });





function validar_cajachica() {

  var select_responsable = document.getElementById('responsable').selectedIndex;
  var txt_proveedor =  $("#idcatalogo_provedores").val();
  var txt_departamento = $("#idcatalogo_departamento").val();
  var txt_apartado_usado = $("#apartado_usado").val();
  var txt_gran_total = $("#gran_total").val();
  var txt_monto_comparar = $("#monto_comparar").val();
  var txt_emisora_institucion = $("#emisora_institucion").val();
  var txt_emisora_agente = $("#emisora_agente").val();
  var txtcomentarios = $("#comentarios").val();



  if(select_responsable == null || select_responsable == 0){
    $(".error-form").show();
    $(".text-error").html("ERROR: Debes seleccionar un responsable");
    $("#responsable").css("border", "4px solid #882439");
    $("#responsable").focus();
    setTimeout(function(){
      $(".error-form").fadeOut(1000);
    }, 1500);

    return false;
  }

  if(txt_proveedor == null || txt_proveedor.length == 0 || /^\s+$/.test(txt_proveedor)){

    $(".error-form").show();
    $(".text-error").html("ERROR: Debes seleccionar una proveedor");
    $("#idcatalogo_provedores").focus();
    $("#idcatalogo_provedores").css("border", "4px solid #882439");
    setTimeout(function(){
      $(".error-form").fadeOut(1000);
    }, 1500);
    return false;
  }

  if(txt_departamento == null || txt_departamento.length == 0 || /^\s+$/.test(txt_departamento)){
    $(".error-form").show();
    $(".text-error").html("ERROR: Debes seleccionar un departamento");
    $("#idcatalogo_departamento").focus();
    $("#idcatalogo_departamento").css("border", "4px solid #882439");
    setTimeout(function(){
      $(".error-form").fadeOut(1000);
    }, 1500);
    return false;
  }

  if(txt_apartado_usado == null || txt_apartado_usado.length == 0 || /^\s+$/.test(txt_apartado_usado)){
    $(".error-form").show();
    $(".text-error").html("ERROR: Deben de existir auxiliares");
    $("#apartado_usado").focus();
    $("#apartado_usado").css("border", "4px solid #882439");
    return false;
    setTimeout(function(){
      $(".error-form").fadeOut(1000);
    }, 1500);
  }

  if(txt_monto_comparar != txt_gran_total || txt_monto_comparar.length == 0 || /^\s+$/.test(txt_monto_comparar)){
    $(".error-form").show();
    $(".text-error").html("ERROR: El monto de la tabla no coincide con los datos obtenidos");
    $("#monto_comparar").focus();
    $("#monto_comparar").css("border", "4px solid #882439");
    setTimeout(function(){
      $(".error-form").fadeOut(1000);
    }, 1500);
    return false;
  }

  if(txt_emisora_institucion == null || txt_emisora_institucion.length == 0 || /^\s+$/.test(txt_emisora_institucion)){
   $(".error-form").show();
   $(".text-error").html("ERROR: En institución emisora");
   $("#emisora_institucion").focus();
   $("#emisora_institucion").css("border", "4px solid #882439");
   setTimeout(function(){
    $(".error-form").fadeOut(1000);
  }, 1500);
   return false;
 }

 if(txt_emisora_agente == null || txt_emisora_agente.length == 0 || /^\s+$/.test(txt_emisora_agente)){
   $(".error-form").show();
   $(".text-error").html("ERROR: con el agente emisor");
   $("#emisora_agente").focus();
   $("#emisora_agente").css("border", "4px solid #882439");
   setTimeout(function(){
    $(".error-form").fadeOut(1000);
  }, 1500);
   return false;
 }

 if(txtcomentarios == null || txtcomentarios.length == 0 || /^\s+$/.test(txtcomentarios)){
  $(".error-form").show();
  $(".text-error").html("ERROR: Debes ingresar un comentario");
  $("#comentarios").focus();
  $("#comentarios").css("border", "4px solid #882439");
  setTimeout(function(){
    $(".error-form").fadeOut(1000);
  }, 1500);
  return false;
}



return true;
}



</script>



</body>
</html>