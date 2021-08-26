<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
$fecha_actual = date("Y-m-d H:i:s");
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
header("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);


$array_options = array();

$query_exception = "SELECT tipo_token FROM orden_logistica_token WHERE visible = 'SI' GROUP BY tipo_token ORDER BY tipo_token ASC";
$result_exception = mysql_query($query_exception);

while ($row_exception = mysql_fetch_array($result_exception)) {

    array_push($array_options, "<option value='$row_exception[tipo_token]'>$row_exception[tipo_token]</option>");
}

array_push($array_options, "<option value='Trasladista Principal'>Trasladista Principal</option>");


$array_options_tratados = Tratar_Array($array_options);


foreach ($array_options_tratados as $key_option => $value_option) {

    $show_tipo_token .= $value_option;
}


$query_expirado = "SELECT idorden_logistica_token, fecha_expiracion_token FROM orden_logistica_token WHERE visible = 'SI' AND columna_b = 'Pendiente'";
$result_expirado = mysql_query($query_expirado);

while ($row_expirado = mysql_fetch_array($result_expirado)) {
    $fecha_ahorita = date("Y-m-d H:i:s");
    $fecha_token = date_format(date_create($row_expirado[fecha_expiracion_token]), 'Y-m-d H:i:s');

    $fecha_actual = strtotime(date("d-m-Y H:i:s", time()));
    $fecha_entrada = strtotime($fecha_token);



    if (intval($fecha_actual) > intval($fecha_entrada)) {

        $result_update_expirado = mysql_query("UPDATE orden_logistica_token SET columna_a = '$fecha_ahorita', columna_b = 'Expirado' WHERE idorden_logistica_token = '$row_expirado[idorden_logistica_token]'");
    }
}




?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="description" content="">
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
    <link rel="icon" type="image/png" sizes="192x192" href="../../img/favicon/android-icon-192x192.png">
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

    <!-- Bootstrap Material DatePicker CSS-->
    <link rel="stylesheet" href="../../plugins/Datepicker/jquery.datetimepicker.css">
    <link rel="stylesheet" href="../../plugins/Datepicker/bootstrap-material-datetimepicker.css">
    <!-- Bootstrap Material DatePicker JS-->
    <script src="../../plugins/Datepicker/material.min.js"></script>
    <script src="../../plugins/Datepicker/moment-with-locales.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <script src="funciones_js_global.js"></script>

    <title>CCP | Detalle Exepciones | Token</title>


</head>

<body>

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
                                <a class="text-white" onclick="ShowFormExceptionToken('Exception');"><i class="fas fa-exclamation-circle"></i> Agregar Excepción</a>
                            </li>
                            <span class="text-white"> &nbsp;/&nbsp; </span>
                            <li>
                                <a class="text-white" onclick="ShowFormToken();" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Token para modulos de logística"><i class="fas fa-user-lock fa-2x"></i> Generar Token</a>
                            </li>
                        </ol>

                        <br>

                        <div class="modal fade" id="modal_exeption_token" tabindex="-1" aria-labelledby="TitleExceptionToken" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="TitleExceptionToken"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="add_exception_token">


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="modal fade" id="modal_token" tabindex="-1" aria-labelledby="TitleToken" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="TitleToken">Generar Nuevo Token</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body" id="add_token">

                                        <div class="row mt-4 mb-4 container-title-line">

                                            <div class="col-sm-12">
                                                <label class="col-form-label">*Tipo de Token:</label>
                                                <input type="text" class="form-control CleanToken" name="tipo_token" required list="show_token_list" id="tipo_token">
                                                <datalist id="show_token_list">
                                                    <?php echo $show_tipo_token; ?>
                                                </datalist>
                                            </div>

                                            <div class="col-sm-12">
                                                <label>Logística</label>
                                                <input type="text" class="form-control CleanToken" name="idorden_logistica" id="idorden_logistica" onkeypress="return SoloNumeros(event);">
                                            </div>

                                            <div class="col-sm-12">
                                                <label>Buscar Colaborador</label>
                                                <input placeholder="Buscar" class="form-control CleanToken" type="text" name="buscar_responsable_token" id="buscar_responsable_token" value="" autocomplete="off" onKeyUp="BuscadorAll();" size="19" width="300%" />
                                                <center>
                                                    <div id="resultadoBusquedaResponsable" class="container-busquedas-1 mt-4 efecto-busqueda" style="display: none;"></div>
                                                </center>
                                            </div>

                                            <div class="col-sm-12">
                                                <label>Responsable</label>
                                                <input type="text" class="form-control CleanToken" id="responsabletxt" readonly>
                                                <input type="hidden" class="CleanToken" id="idcolaborador" name="idcolaborador">
                                                <input type="hidden" class="CleanToken" id="tipocolaborador" name="tipocolaborador">
                                            </div>

                                            <div class='col-sm-12'>
                                                <label>*Fecha Expiración&nbsp;&nbsp;&nbsp;<span><i class="fas fa-trash fa-1.5x" onclick="CleanFecha('fecha_hora_token')"></i></span></label>
                                                <input type="text" id="fecha_hora_token" placeholder="0001-01-01 00:00:00" name="fecha_hora_token" class="form-control CleanToken" readonly="">
                                            </div>

                                            <div class="col-sm-12">
                                                <br>
                                                <center>
                                                    <button class="btn btn-lg btn-primary " onclick="GenerateToken();">Generar Token</button>
                                                </center>
                                            </div>

                                        </div>



                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form id="FormTokenExecepciones" method="POST">

                            <div class="row">

                                <div class="col-sm-12">
                                    <label>Mostrar Tipo de Tabla</label>
                                    <select name="tipo_tabla" id="tipo_tabla" class="form-control">
                                        <optgroup label='Token Logística'>
                                            <option value='TokenPendientes'>Token Pendientes</option>
                                            <option value='TokenALL'>Token Todos</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="col-sm-12">
                                    <br>
                                    <center>
                                        <input type="hidden" name="tipo_movimiento" value="TablaExceptionsToken">
                                        <button class="btn-lg btn-primary" onclick="show_date();" type="button">Buscar Tipo Tabla</button>
                                    </center>
                                </div>

                            </div>
                        </form>

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


    <script src="../../plugins/Datepicker/bootstrap-material-datetimepicker.js"></script>
    <script src="../../plugins/Datepicker/es-mx.min.js"></script>

    <script>
        function show_date() {

            var datos = $("#FormTokenExecepciones").serialize();


            $.ajax({
                url: "buscar_trasladista_principal.php",
                type: "POST",
                data: datos,
                beforeSend: function() {
                    $(".container-loading-ajax").show();
                },
                success: function(table) {

                    $("#show_table").html(table);
                    $(".container-loading-ajax").hide();
                },
                error: function(table) {

                    $(".error-form").show();
                    $(".text-error").html("Disculpa, ocurrió un error");

                    setTimeout(function() {
                        $(".error-form").fadeOut(1000);
                    }, 1500);

                }
            });

        }


        function ShowFormExceptionToken(valor) {

            let titulo = (valor == "Exception") ? "Agregar Excepciones" : "";
            ShowHideModal('toggle|' + titulo);

            if (valor == "Exception") {

                var FormExceptionToken = `
                <h1>En Desarrollo...</h1>
                `;

            }

            $("#add_exception_token").html(FormExceptionToken);
        }




        function ShowHideModal(valor) {

            let porciones = valor.split('|')

            $('#modal_exeption_token').modal(porciones[0]);
            $("#TitleExceptionToken").empty();
            $("#TitleExceptionToken").html(porciones[1]);
            $("#add_exception_token").empty();

        }


        function ShowFormToken() {

            $(".CleanToken").val("");
            $("#modal_token").modal('toggle');

        }

        function GenerateToken() {

            var tipo_movimiento = "CreateNewToken";
            var tipo_token = $("#tipo_token").val();
            var idorden_logistica = $("#idorden_logistica").val();
            var idcolaborador = $("#idcolaborador").val();
            var tipocolaborador = $("#tipocolaborador").val();
            var fecha_hora_token = $("#fecha_hora_token").val();
            var fecha_creacion = TiempoAhora();

            if (tipo_token == "") {

                $("#tipo_token").css("border-color", "red");
                $(".error-form").show();
                $(".text-error").html("ERROR: Debes Agregar Tipo de Token:");

                setTimeout(function() {
                    $(".error-form").fadeOut(1000);
                }, 1500);
                $("#tipo_token").focus();
                return false;
            }

            if (idorden_logistica == "") {

                $("#idorden_logistica").css("border-color", "red");
                $(".error-form").show();
                $(".text-error").html("ERROR: Debes Agregar la Logística:");

                setTimeout(function() {
                    $(".error-form").fadeOut(1000);
                }, 1500);
                $("#idorden_logistica").focus();
                return false;
            }

            if (idcolaborador == "" || tipocolaborador == "") {

                $("#buscar_responsable_token").css("border-color", "red");
                $(".error-form").show();
                $(".text-error").html("ERROR: Debes Agregar al Responsable:");

                setTimeout(function() {
                    $(".error-form").fadeOut(1000);
                }, 1500);
                $("#buscar_responsable_token").focus();
                return false;
            }

            if (fecha_hora_token == "") {

                $("#fecha_hora_token").css("border-color", "red");
                $(".error-form").show();
                $(".text-error").html("ERROR: Debes Agregar Fecha Expiración:");

                setTimeout(function() {
                    $(".error-form").fadeOut(1000);
                }, 1500);
                $("#fecha_hora_token").focus();
                return false;
            }

            $.ajax({
                url: "buscar_trasladista_principal.php",
                type: "POST",
                data: {
                    tipo_movimiento: tipo_movimiento,
                    tipo_token: tipo_token,
                    idorden_logistica: idorden_logistica,
                    idcolaborador: idcolaborador,
                    tipocolaborador: tipocolaborador,
                    fecha_hora_token: fecha_hora_token,
                    fecha_creacion: fecha_creacion
                },
                beforeSend: function() {

                    $(".container-loading-ajax").show();

                },
                success: function(mensaje_token) {


                    var porciones = mensaje_token.trim();
                    var mensaje_token = porciones.split('|');

                    if (mensaje_token[0].trim() == 1) {
                        show_date();
                        $(".listo-form").show();
                        $(".text-listo").html("<b>Token Exitoso!</b>");

                        setTimeout(function() {
                            $(".listo-form").fadeOut(2000);
                        }, 1500);

                    } else {
                        $(".error-form").show();
                        $(".text-error").html(mensaje_token[0]);
                        setTimeout(function() {
                            $(".error-form").fadeOut(1000);
                        }, 1500);

                    }

                    if (mensaje_token[1] != "") {
                        open(mensaje_token[1], "New Windows", "width=600, height=600, left=300, top=300");
                    }

                    $(".CleanToken").val("");
                    $("#modal_token").modal('hide');
                    $(".container-loading-ajax").hide();

                },
                error: function() {

                    $(".error-form").show();
                    $(".text-error").html("Disculpa, ocurrió un error");

                    setTimeout(function() {
                        $(".error-form").fadeOut(1000);
                    }, 1500);
                    $(".container-loading-ajax").hide();
                }
            });


        }

        $(document).ready(function() {

            $('#fecha_hora_token').bootstrapMaterialDatePicker({
                date: true,
                time: true,
                shortTime: true,
                format: 'YYYY-MM-DD HH:mm',
                lang: "es",
                cancelText: 'Cancelar',
                okText: 'Definir'
            });

        });

        function CleanFecha(valor) {

            $("#" + valor).val("");

        }



        function BuscadorAll() {

            var txtSearchResponsable = $("#buscar_responsable_token").val();
            var tipoBusqueda = "ColaboraboradorSI";
            var name_sugerencia = "ResponsableToken";

            if (txtSearchResponsable != "") {

                $.post("buscar_id_colaborador_completo.php", {
                    valorBusqueda: txtSearchResponsable,
                    tipoBusqueda: tipoBusqueda,
                    name_sugerencia: name_sugerencia
                }, function(mensaje_responsable) {

                    $("#resultadoBusquedaResponsable").html(mensaje_responsable);
                    $("#resultadoBusquedaResponsable").show();

                });

            } else {
                $("#resultadoBusquedaResponsable").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
            };

            $(document).on('click', '.' + name_sugerencia, function(event) {
                event.preventDefault();
                aux_recibido = $(this).val();
                var porcion = aux_recibido.split(';');

                $("#buscar_responsable_token").val("");
                $("#responsabletxt").val(porcion[2] + " - " + porcion[3] + " " + porcion[4] + " - " + porcion[5]);
                $("#idcolaborador").val(porcion[0]);
                $("#tipocolaborador").val(porcion[1]);
                $("#resultadoBusquedaResponsable").html("");
                $("#resultadoBusquedaResponsable").hide();
            });

        }

        function CopyAndPaste(valor) {

            var aux = document.createElement("input");
            aux.setAttribute("value", valor);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);

            $(".listo-form").show();
            $(".text-listo").html("<b>Copiado</b>");

            setTimeout(function() {
                $(".listo-form").fadeOut(250);
            }, 450);

        }


        function MovimientoToken(valor1, valor2) {

            $.ajax({
                url: "buscar_trasladista_principal.php",
                type: "POST",
                data: {
                    tipo_movimiento: valor1,
                    id: valor2
                },
                beforeSend: function() {

                },
                success: function(table) {
                    console.log(table);
                    if (table.trim() == 1) {
                        show_date();
                        $(".listo-form").show();
                        $(".text-listo").html("Eliminado");

                        setTimeout(function() {
                            $(".listo-form").fadeOut(200);
                        }, 400);


                    } else {

                        $(".error-form").show();
                        $(".text-error").html(table);

                        setTimeout(function() {
                            $(".error-form").fadeOut(200);
                        }, 400);

                    }


                },
                error: function() {

                    $(".error-form").show();
                    $(".text-error").html("Disculpa, ocurrió un error");

                    setTimeout(function() {
                        $(".error-form").fadeOut(200);
                    }, 400);

                }
            });

        }





        function SoloNumeros(evt) {
            if (window.event) {
                keynum = evt.keyCode;
            } else {
                keynum = evt.which;
            }

            if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 || keynum == 47) {
                return true;
            } else {
                return false;
            }
        }
    </script>




</body>

</html>