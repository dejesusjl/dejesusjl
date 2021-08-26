<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
header("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);

$options_tipo .= "
<optgroup label='Proveedor'>
<option value='ProveedorSI'>Proveedores Activos</option>
<option value='ProveedorNO'>Proveedores Eliminados</option>
<option value='ProveedorALL'>Proveedores Todos</option>
</optgroup>
<optgroup label='Proveedor Temporal'>
<option value='ProveedorTSI'>Proveedor Temporal Activos</option>
<option value='ProveedorTNO'>Proveedor Temporal Eliminados</option>
<option value='ProveedorTALL'>Proveedor Temporal Todos</option>
</optgroup>
";


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
    <script src='funciones_js_global.js'></script>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/quicksand.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/alert_popup.css">
    <link rel="stylesheet" href="../../assets/css/mod_style_datatables.css">
    <link rel="stylesheet" href="../../assets/css/styles_loading_ajax.css">
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

    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
    <script src="../../js/jquery-1.10.2.js"></script>
    <script src="../../js/jquery-ui.js"></script>


    <link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.css">
    <link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.date.css">
    <link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.time.css">
    <title>CCP | Proveedores Detalles</title>
    <style>
        #show_date {
            cursor: pointer;
        }

        /*Scroll de tablas*/
        #columna {
            overflow: auto;
            margin: 5px;
            width: 100%;
            height: 500px;
            /*establece la altura máxima, lo que no entre quedará por debajo y saldra la barra de scroll*/
        }

        .spelling-error {
            text-decoration-line: underline;
            text-decoration-color: #882439;
        }

        .color-div {

            border: 1.5px solid #882439;
            padding: 1%;


        }

        .picker__holder {

            overflow: hidden !important;
        }
    </style>
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


        <div class="error-form" style="background: rgba(255, 255, 255, 0.4); width: 100%; height: 100vh; position: fixed; z-index: 9999; top: 0px; display: none;">
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

                        <ul class="sidebar-menu mb-4 breadcrumb fondo-encabezados">

                            <li class="parent">
                                <a href="index.php" class=""><i class="fa fa-home mr-3"></i>
                                    <span class="none">Inicio </span>
                                </a>
                            </li>

                            <li class="parent">

                                <a href="#" onclick="toggle_menu('add_new_supplier'); return false" class="text-white"><i class="far fa-id-card mr-3"></i>
                                    <span class="none">Proveedor</span>
                                </a>

                                <ul class="children" id="add_new_supplier">

                                    <li class="child"><a href="#" class="ml-4" onclick="AddNEwSupplier();"><i class="fas fa-user-plus mr-2"></i>Agregar Nuevo Proveedor Individual</a></li>
                                    <li class="child"><a href="../../Documentacion_Logistica/Plantillas/Plantilla_Proveedores.csv" class="ml-4"><i class="fas fa-download mr-2"></i>Descargar Plantilla Actualizacion Masiva</a></li>
                                    <li class="child"><a href="#" class="ml-4" onclick="ModalArchivos();"><i class="fas fa-file-csv mr-2"></i>Cargar Plantilla Actualizacion Masiva</a></li>

                                </ul>
                            </li>

                        </ul>



                        <div class="modal fade" id="modal_actions_wallet" tabindex="-1" aria-labelledby="title_modal_actions" aria-hidden="true">
                            <div class="modal-dialog modal-lg overflow-hidden">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="title_modal_actions"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body" id="add_opciones_modal_options">



                                    </div>

                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <form id="form_proveedores" method="POST">

                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="container-bg-1 p-3">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="tipo_vista">Mostrar Tipo de Tabla</label>
                                                <div class="content-select">
                                                    <select name="tipo_vista" id="tipo_vista" class="form-control">
                                                        <?php echo $options_tipo; ?>
                                                    </select>
                                                    <i></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <br>
                                    <center>

                                        <button class="btn-lg btn-primary" id="show_date" type="button" onclick="MostrarContenido();">Buscar</button>

                                    </center>
                                </div>


                            </div>
                        </form>


                        <div>
                            <div id="show_table" class="mt-4">

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <br>

            <div class="col-sm-12" id="BitacoraArchivos">
            </div>

            <br>








            <?php
            include_once '../footer.php';
            ?>

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


    <script type="text/javascript" class="init">
        //window.addEventListener("load", MostrarBitacora);

        function AddFecha(valor) {

            $('#' + valor).pickadate({
                // Strings and translations
                monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Otu', 'Nov', 'Dic'],
                weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                showMonthsShort: false,
                showWeekdaysFull: false,
                // Buttons
                today: 'Hoy',
                clear: 'Limpiar',
                close: 'Cerrar',
                // Accessibility labels
                labelMonthNext: 'Siguiente Mes',
                labelMonthPrev: 'Anterior Mes',
                labelMonthSelect: 'Selecciona un mes',
                labelYearSelect: 'Selecciona un año',
                // Formats
                format: 'yyyy-mm-dd',
                selectMonths: true,
                selectYears: true,

                // Date limits
                max: +1,

            });

            $("#" + valor).data('pickadate').open();

            event.stopPropagation();
            event.preventDefault();
        }

        function MostrarContenido() {

            var datos_proveedores = $("#form_proveedores").serialize();

            $.ajax({
                url: 'ajaxpro.php',
                data: datos_proveedores,
                type: 'POST',
                beforeSend: function() {
                    $(".container-loading-ajax").show();
                },
                success: function(json) {

                    $("#show_table").html(json);
                    $(".container-loading-ajax").hide();
                },

                error: function(xhr, status) {

                    $(".error-form").show();
                    $(".text-error").html("Disculpe, existió un problema");

                    setTimeout(function() {
                        $(".error-form").fadeOut(1000);
                    }, 1500);
                }

            });

        }

        //------------------------------------------- Agregar Nuevo Proveedor --------------------------------------------------------------------------------

        function AddNEwSupplier() {

            $('#modal_actions_wallet').modal('toggle');
            $('#title_modal_actions').empty();
            $('#title_modal_actions').html("Agregar Nuevo Proveedor");

            $("#add_opciones_modal_options").empty();


            var newsupplier = `
			<div class="row">

			<div class="col-sm-12">
				<label><b>Tipo de Proveedor</b></label>
				<select name="tipo_proveedor" class="form-control" id="tipo_proveedor_new_supplier">
					<option value="">Selecciona una opción</option>
					<option value="Proveedor">Proveedor</option>
					<option value="Proveedor Temporal">Proveedor Temporal</option>
				</select>
			</div>

			<div class="col-sm-12">
				<label>Nombre</label>
				<input class="form-control" type="text" id="name_new_supplier" name="nombre_proveedor">
			</div>

			<div class="col-sm-12">
				<label>Apellidos</label>
				<input class="form-control" type="text" id="apellidos_new_supplier" name="apellidos_proveedor">
			</div>

			<div class="col-sm-12">
				<label>Alias</label>
				<textarea name='alias_proveedor' id='alias_new_supplier' class='form-control' rows='3'></textarea>
			</div>

			<div class="col-sm-12">
				<label>Teléfono</label>
				<input class="form-control" type="text" id="telefono_new_supplier" name="telefono_celular_proveedor" onkeypress="return SoloNumeros(event);">
			</div>

			<div class="col-sm-12">
				<label><b>*RFC</b></label>
				<input class="form-control" type="text" id="rfc_new_supplier" name="rfc_proveedor" onKeyUp="mayus(this);">
			</div>

			<div class="col-sm-12">
				<label>Estado</label>
				<select class="form-control" name="estado_proveedor" id="estado_new_supplier">
				<option value="">Selecciona una entidad ...</option>
				<?php
                $query_entidades = "SELECT * FROM catalogo_entidates WHERE visible = 'SI'";
                $result_entidades = mysql_query($query_entidades);
                while ($row_entidades = mysql_fetch_array($result_entidades)) {
                    echo "<option value='$row_entidades[nombre_entidad]'>$row_entidades[nombre_entidad]</option>";
                }
                ?>
				</select>
			</div>
			
			<div class="col-sm-12">
				<label>Delegación | Municipio</label>
				<input class="form-control" type="text" id="calle_new_supplier" name="delmuni_proveedor">
			</div>
			
			<div class="col-sm-12">
				<label>Colonia</label>
				<input class="form-control" type="text" id="colonia_proveedor_new_supplier" name="colonia_proveedor">
			</div>
			
			<div class="col-sm-12">
				<label>Calle</label>
				<input class="form-control" type="text" id="calle_new_supplier" name="calle_proveedor">
			</div>
			
			<br>
			<br>

			<div class="col-sm-12">
				<center>
					<button type="button" class="btn btn-primary btn-lg" onclick="SaveNewSupplier();">Guardar Nuevo Proveedor</button>
				</center>
			</div>
			
			</div>
			`;

            $("#add_opciones_modal_options").html(newsupplier);

        }


        function SaveNewSupplier() {

            var tipo_proveedor = $("#tipo_proveedor_new_supplier").val();
            var nombre_proveedor = $("#name_new_supplier").val();
            var apellidos_proveedor = $("#apellidos_new_supplier").val();
            var alias_proveedor = $("#alias_new_supplier").val();
            var telefono_celular_proveedor = $("#telefono_new_supplier").val();
            var rfc_proveedor = $("#rfc_new_supplier").val();
            var estado_proveedor = $("#estado_new_supplier").val();
            var delmuni_proveedor = $("#calle_new_supplier").val();
            var colonia_proveedor = $("#colonia_proveedor_new_supplier").val();
            var calle_proveedor = $("#calle_new_supplier").val();
            var fecha_creacion = TiempoAhora();


            var formData = new FormData();


            formData.append('tipo_proveedor', tipo_proveedor);
            formData.append('nombre_proveedor', nombre_proveedor);
            formData.append('apellidos_proveedor', apellidos_proveedor);
            formData.append('alias_proveedor', alias_proveedor);
            formData.append('telefono_celular_proveedor', telefono_celular_proveedor);
            formData.append('rfc_proveedor', rfc_proveedor);
            formData.append('estado_proveedor', estado_proveedor);
            formData.append('delmuni_proveedor', delmuni_proveedor);
            formData.append('colonia_proveedor', colonia_proveedor);
            formData.append('calle_proveedor', calle_proveedor);
            formData.append('fecha_creacion_proveedor', fecha_creacion);



            // for (var value of formData.values()) {
            // 	console.log(value);
            // }

            if (tipo_proveedor == "") {
                $("#tipo_proveedor_new_supplier").css("border-color", "#882439");
                $(".error-form").show();
                $(".text-error").html("Debes de seleccionar una opción");

                setTimeout(function() {
                    $(".error-form").fadeOut(1000);
                }, 1500);

                $("#tipo_proveedor_new_supplier").focus();
                return false;
            }

            if (nombre_proveedor == "") {
                $("#name_new_supplier").css("border-color", "#882439");
                $(".error-form").show();
                $(".text-error").html("Debes de colocar el nombre");

                setTimeout(function() {
                    $(".error-form").fadeOut(1000);
                }, 1500);

                $("#name_new_supplier").focus();
                return false;
            }
            $('#modal_actions_wallet').modal('hide');
            $('#title_modal_actions').empty();
            $("#add_opciones_modal_options").empty();

            $.ajax({
                type: "POST",
                url: "agregar_proveedor.php",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $(".container-loading-ajax").show();
                },
                success: function(mensaje_proveedor) {
                    console.log(mensaje_proveedor);
                    if (mensaje_proveedor.trim() == "- No Hay Nombre <br>" || mensaje_proveedor.trim() == "- Proximamente <br>" || mensaje_proveedor.trim() == "- Error al Agregar Proveedor <br>" || mensaje_proveedor.trim() == "" || mensaje_proveedor.trim() == "- Nada que hacer <br>" || mensaje_proveedor.trim() == "- Ya Existe<br>") {

                        $(".error-form").show();
                        $(".text-error").html(mensaje_proveedor);

                        setTimeout(function() {
                            $(".error-form").fadeOut(1000);
                        }, 1500);

                    } else {

                        $(".listo-form").show();
                        $(".text-listo").html("<b>Proveedor Guardado Correctamente</b>");

                        setTimeout(function() {
                            $(".listo-form").fadeOut(2000);
                        }, 1500);

                    }
                    $(".container-loading-ajax").hide();
                },
                error: function(xhr, status) {

                    $(".error-form").show();
                    $(".text-error").html("Disculpe, existió un problema");

                    setTimeout(function() {
                        $(".error-form").fadeOut(1000);
                    }, 1500);
                }

            });

        }

        //------------------------------------------- Editar Proveedor --------------------------------------------------------------------------------

        function ActionsEditProveedor(valor) {

            var porciones = valor.split('|');

            $('#modal_actions_wallet').modal('toggle');
            $('#title_modal_actions').empty();
            $('#title_modal_actions').html(`Editar Proveedor <b>${porciones[4]} ${porciones[5]}</b>`);

            $("#add_opciones_modal_options").empty();


            var editar_proveedor = `

            <div class="row align-items-center py-1 container-checks-1" style="padding: 0px;">
                <div class="col-sm-12 mb-2">
                    <label for="Prov_unidad_ID">ID:</label>
                    <input type="text" class="form-control" id="Prov_unidad_ID" value="${porciones[2]}" autocomplete="off" readonly>
                </div>


                <div class="col-sm-6 mb-2">
                    <label for="Prov_unidad_nombre">Nombre:</label>
                    <input type="text" class="form-control" id="Prov_unidad_nombre" value="${porciones[4]}" autocomplete="off">
                </div>
                
                <div class="col-sm-6 mb-2">
                    <label for="Prov_unidad_apellidos">Apellidos:</label>
                    <input type="text" class="form-control" id="Prov_unidad_apellidos" value="${porciones[5]}" autocomplete="off">
                </div>

                <div class="col-sm-6 mb-2">
                    <label for="Prov_alias">Alias:</label>
                    <input type="text" class="form-control" id="Prov_alias" value="${porciones[8]}" autocomplete="off">

                </div>


                <div class="col-sm-6 mb-2">
                    <label for="Prov_rfc">RFC:</label>
                    <input type="text" class="form-control" id="Prov_rfc" value="${porciones[7]}" autocomplete="off" onKeyUp="mayus(this);">

                </div>

                <div class="col-sm-6 mb-2">
                    <label for="Prov_telefono">Teléfono:</label>
                    <input type="text" class="form-control" id="Prov_telefono" value="${porciones[11]}" autocomplete="off" onkeypress="return SoloNumeros(event);">
                </div>

                <div class="col-sm-6 mb-2">
                    <label for="Prov_calle">Calle:</label>
                    <input type="text" class="form-control" id="Prov_calle" value="${porciones[33]}" autocomplete="off">

                </div>

                <div class="col-sm-6 mb-2">
                    <label for="Prov_colonia">Colonia:</label>
                    <input type="text" class="form-control" id="Prov_colonia" value="${porciones[32]}" autocomplete="off">

                </div>
                
                <div class="col-sm-6 mb-2">
                    <label for="Prov_municipio">Delegación / Municipio:</label>
                    <input type="text" class="form-control" id="Prov_municipio" value="${porciones[31]}" autocomplete="off">
                </div>

                <div class="col-sm-6 mb-2">
                    <label for="Prov_estado">Estado:</label>
                <select class="form-control" name="Prov_estado" id="Prov_estado">
				<option value="${porciones[30]}">${porciones[30]}</option>
				<?php
                $query_entidades = "SELECT * FROM catalogo_entidates WHERE visible = 'SI'";
                $result_entidades = mysql_query($query_entidades);
                while ($row_entidades = mysql_fetch_array($result_entidades)) {
                    echo "<option value='$row_entidades[nombre_entidad]'>$row_entidades[nombre_entidad]</option>";
                }
                ?>
				</select>
                    
                </div>

                <div class="col-sm-6 mb-2">
                    <label for="Prov_CP">CP:</label>
                    <input type="text" class="form-control" id="Prov_CP" value="${porciones[29]}" autocomplete="off">
                </div>
                
                <div class="col-sm-12">
                    <center>
                        <button type="button" class="btn btn-primary btn-lg" onclick="EditarProveedor();">Actualizar Proveedor</button>
                    </center>
                </div>

            </div>
            `;
            $("#add_opciones_modal_options").html(editar_proveedor);

        }

        //------------------------------------------- Actualizar Proveedor --------------------------------------------------------------------------------


        function EditarProveedor() {

            var idprovedores_compuesto_proveedor = $("#Prov_unidad_ID").val();
            var nombre_proveedor = $("#Prov_unidad_nombre").val();
            var apellidos_proveedor = $("#Prov_unidad_apellidos").val();
            var alias_proveedor = $("#Prov_alias").val();
            var telefono_celular_proveedor = $("#Prov_telefono").val();
            var rfc_proveedor = $("#Prov_rfc").val();
            var estado_proveedor = $("#Prov_estado").val();
            var delmuni_proveedor = $("#Prov_municipio").val();
            var colonia_proveedor = $("#Prov_colonia").val();
            var calle_proveedor = $("#Prov_calle").val();
            var codigo_postal = $("#Prov_CP").val();

            var fecha_creacion = TiempoAhora();


            var formData = new FormData();


            formData.append('idprovedores_compuesto_proveedor', idprovedores_compuesto_proveedor);
            formData.append('tipo_proveedor', "Actualizar Proveedor");
            formData.append('nombre_proveedor', nombre_proveedor);
            formData.append('apellidos_proveedor', apellidos_proveedor);
            formData.append('alias_proveedor', alias_proveedor);
            formData.append('telefono_celular_proveedor', telefono_celular_proveedor);
            formData.append('rfc_proveedor', rfc_proveedor);
            formData.append('estado_proveedor', estado_proveedor);
            formData.append('delmuni_proveedor', delmuni_proveedor);
            formData.append('colonia_proveedor', colonia_proveedor);
            formData.append('calle_proveedor', calle_proveedor);
            formData.append('codigo_postal_proveedor', codigo_postal);
            formData.append('fecha_creacion_proveedor', fecha_creacion);



            $('#modal_actions_wallet').modal('hide');
            $('#title_modal_actions').empty();


            $.ajax({
                type: "POST",
                url: "agregar_proveedor.php",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $(".container-loading-ajax").show();
                },
                success: function(response) {
                    console.log(response);
                    if (response.trim() == "1") {

                        $(".listo-form").show();
                        $(".text-listo").html("<b>Datos Actualizados Correctamente</b>");

                        setTimeout(function() {
                            $(".listo-form").fadeOut(2000);
                        }, 1500);

                    } else {

                        $(".error-form").show();
                        $(".text-error").html(response);

                        setTimeout(function() {
                            $(".error-form").fadeOut(3000);
                        }, 1500);
                    }
                    MostrarContenido();
                    $(".container-loading-ajax").hide();
                }

            });

        }

        //------------------------------------------- Bitacora de Proveedor Numeros --------------------------------------------------------------------------------
        function ShowBitacora(valor) {

            $('#modal_actions_wallet').modal('toggle');
            $('#title_modal_actions').empty();
            $('#title_modal_actions').html(`Bitácora de Proveedor`);

            $("#add_opciones_modal_options").empty();
            $("#add_opciones_modal_options").html(valor);


        }

        //------------------------------------------- Procesar Archivos --------------------------------------------------------------------------------


        function ModalArchivos(actionswallet) {

            $('#modal_actions_wallet').modal('toggle');
            $('#title_modal_actions').empty();
            $('#title_modal_actions').html("Cargar Archivos Combustible | Casetas");

            $("#add_opciones_modal_options").empty();

            $("#guardar_actions").show();

            var agregar_formulario = `
                <div class="col-sm-12">
                    <label>*Seleccionar tipo de archivo</label>
                    <select name="tipo_archivo" id="tipo_archivo" class="form-control vaciar_input">
                    <option value="">Selecciona una Opción...</option>
                    <optgroup label='Plantilla Proveedores'>
                        <option value='Plantilla Proveedores'>Proveedores</option>
                    </optgroup>

                    </select>
                </div>

                <div class="col-sm-12">
                    <label>*Evidencia</label>
                    <input type="file" name="archivo" id="archivo" class="form-control vaciar_input" accept=".csv">
                </div>

                <br>
                <div class="col-sm-12">
                <center>
                    <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal" id="guardar_actions" onclick="ConfirmarActions();">Procesar Archivo</button>
                </center>
                </div>
                `;

            $("#add_opciones_modal_options").html(agregar_formulario);


            $(".vaciar_input").val("");

        }

        //------------------------------------------- Guardar Procesador de Archivos --------------------------------------------------------------------------------

        function ConfirmarActions() {

            var tipo_archivo = $("#tipo_archivo").val();
            var archivo = $("#archivo")[0].files[0];
            var fecha_creacion = TiempoAhora();

            var formData = new FormData();

            formData.append('tipo_archivo', tipo_archivo);
            formData.append('archivo', archivo);
            formData.append('fecha_creacion', fecha_creacion);

            var link_ajax = "asignar_reasignar_card.php";

            $('#modal_actions_wallet').modal('hide');
            $('#title_modal_actions').empty();
            $("#add_opciones_modal_options").empty();

            $.ajax({

                type: "POST",
                url: link_ajax,
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $(".container-loading-ajax").show();
                },
                success: function(json) {

                    var porciones = json.split('|');
                    // console.log("|" + porciones[0].trim() + "|");
                    // console.log("|" + porciones[1].trim() + "|");
                    // console.log("|" + porciones[2].trim() + "|");

                    if (porciones[0].trim() == 1) {
                        //console.log("ok ok");
                        $(".listo-form").show();
                        $(".text-listo").html("<b>Datos Guardados Correctamente</b>" + porciones[2]);

                        setTimeout(function() {
                            $(".listo-form").fadeOut(2000);
                        }, 1500);


                    } else if (porciones[0].trim() == 0) {
                        //console.log("modal si");
                        $('#modal_actions_wallet').modal('show');
                        $('#title_modal_actions').empty();
                        $('#title_modal_actions').html("<b>Errores del archivo procesado</b>");

                        $("#add_opciones_modal_options").empty();
                        $("#guardar_actions").hide();


                        $("#add_opciones_modal_options").html(porciones[2]);


                        $(".vaciar_input").val("");

                    } else {

                        //console.log("modal no");
                        $(".error-form").show();
                        $(".text-error").html(porciones[2]);

                        setTimeout(function() {
                            $(".error-form").fadeOut(1000);
                        }, 1500);
                    }

                    $(".container-loading-ajax").hide();

                },
                error: function(xhr, status) {

                    $(".error-form").show();
                    $(".text-error").html("Disculpe, existió un problema");

                    setTimeout(function() {
                        $(".error-form").fadeOut(1000);
                    }, 1500);
                }

            });
        }




        //------------------------------------------- Solo Numeros --------------------------------------------------------------------------------

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

        function mayus(e) {
            e.value = e.value.toUpperCase();
        }
    </script>





</body>

</html>