$(document).ready(function() {


    $('#departamento').on('change', function() {

        //Acciones No orden 
        CleanNoOrden();

        //Acciones ID 
        CleanDatosID();
        //Acciones ID 
        CleanVINPrincipal();
        $("#show_id_vin_si").hide();

        Remove_VinAdicional();



        var form_data_valor = $("#departamento").val()

        $.ajax({
            type: "POST",
            url: "buscar_departamento_logistica.php",
            data: { id_d: form_data_valor },
            success: function(response) {

                $('#tipo_orden').html(response);
            }
        });


        $.ajax({
            type: "POST",
            url: "buscar_rolvin_departamento.php",
            data: { id_d: form_data_valor },
            success: function(valor) {

                $('#rol_vin').html(valor);
            }
        });

    });

    //-----------------------------------------------------
    // Acciones CAMBIA TIPO DE ORDEN
    $("#tipo_orden").on('change', function() {

        var type_orden = $("#tipo_orden").val();

        if (type_orden == "") {

            //Acciones No orden
            CleanNoOrden();

            //Acciones ID
            CleanDatosID();

        } else {

            //Acciones No orden
            $("#show_no_orden").show();

        }

    });



    //-----------------------------------------------------
    // Acciones lleva orden
    $(".orden1").click(function() {

        if ($(".orden1").is(':checked')) {
            $("#cuenta_si_orden").show();
            $("#num_orden").focus();
            $("#num_orden").val("");

            $("#desc_si_orden").hide();
            $("#desc_no_orden").hide();

            //acciones ID
            $("#show_id").show();

        }

    });


    $(".orden2").click(function() {

        if ($(".orden2").is(':checked')) {
            $("#cuenta_si_orden").hide();
            $("#num_orden").val("");

            $("#desc_si_orden").hide();
            $("#desc_no_orden").hide();

            //acciones ID
            $("#show_id").show();
        }

    });



    $("#rol_vin").on('change', function() {

        var ver_rol_unidad = $("#rol_vin").val();




        if (ver_rol_unidad == "") {

            $("#show_rol_vin_adicional").hide();
            CleanVINPrincipal();
            Remove_VinAdicional();

            $("#vin_autorizacion").empty();
            $("#vin_autorizacion").hide();
            $("#vin_autorizacion_muestra").empty();
            $("#vin_autorizacion_muestra").hide();

        } else if (ver_rol_unidad == "Muestra del VIN") {

            CleanVINPrincipal();
            $("#vin_autorizacion").hide();
            $("#vin_autorizacion").empty();

            $("#vin_autorizacion_muestra").empty();
            $("#vin_autorizacion_muestra").show();
            



            var add_autorizacion = `
            <div class="row">

            <div class="col-sm-12">
            <label>*¿Quién autoriza?</label>   
            <div class="content-select">
            <select class="form-control limpiarvin" id="idem_au_vin0" name="idcolaboradorautoriza[]" required="">
            <option value="">Elige una opción…</option>
            <option value="118">EDFM</option>
            <option value="116">JFR</option>
            <option value="88">JAH</option>
            <option value="55">AAGH</option>
            </select>
            </div>            
            </div>

            <div class="col-sm-12">
            <label>*Comentarios</label><span class="contador_span" id="contador_espan0"> 10 caracteres restantes</span>
            <textarea class="form-control limpiarvin" id="comentarios0" name="comentarios_autorizacion[]" rows="3" required="" onkeyup="RangeComentarios('0');"></textarea value="ok">
            </div>

            <div class="col-sm-12">
            <label>Cargar Archivo</label>
            <input type="file" class="form-control-file" name="archivoautorizacion[]" id="evidencia_archivo_vin0" onchange="change_file_vin_principal('0')" required>
            <input  type="hidden" value="VIN" name="tipo_evidencia[]">
            </div>

            </div>
            `;


            $("#vin_autorizacion_muestra").append(add_autorizacion);

        } else {

            CleanVINPrincipal();
            $("#show_rol_vin").show();
            $("#vin_autorizacion").empty();
            $("#vin_autorizacion_muestra").empty();

            $("#vin_autorizacion_muestra").empty();
            $("#vin_autorizacion_muestra").hide();

        }

    });














    //-----------------------------------------------------
    // Agregar Vin Adicional
    var addButtonVIN = $('.create_vin');
    var wrapper_vin = $('.field_wrapper_vin');

    $(addButtonVIN).click(function() {


        var obtener_count_vin = $("#count_vin").val();


        var add_coun_vin = parseInt(obtener_count_vin, 10) + 1;
        $("#count_vin").val(add_coun_vin);



        var obtener_aux_vin = $("#aux_vin").val();

        if (obtener_aux_vin == 0) {

            var contador_vin = 1;

        } else {

            if ($.isNumeric(obtener_aux_vin) == true) {

                var contador_vin = parseInt(obtener_aux_vin, 10) + 1;

            } else {

                var cortar = obtener_aux_vin.substr(0, 1);

                var contador_vin = parseInt(obtener_aux_vin, 10) + 1;

            }
        }

        //--------------------------------
        var consulta_vin_departamento = $("#departamento").val();


        $.ajax({
            type: "POST",
            url: "buscar_rolvin_departamento.php",
            data: { id_d: consulta_vin_departamento },
            success: function(valor) {

                $('#rol_vin' + contador_vin).html(valor);
            }
        });
        //--------------------------------

        $("#aux_vin").val(contador_vin);

        var fieldHTMLVIN = `
        <div class="row mt-4 mb-4 container-title-line">

        <div class="col-sm-12">
        <div class="form-group">
        <h3 class="m-t-none m-b"><strong>Agregar Unidad</strong></h3>
        </div>
        </div>

        <div class="col-sm-12">
        <label>Rol del VIN ${contador_vin}</label>
        <div class='content-select'>
        <select name="rol_vin[]" id="rol_vin${contador_vin}" class="form-control stilo_border" required="" onchange="changeRolAdicionalVIN(${contador_vin})">
        <option value="">Seleccionar Rol ...</option>
        </select>
        <i></i>
        </div>
        </div>

        <div id="show_rol_vin_adicional${contador_vin}" style="display: none;" class="col-sm-12">


        <div class="row col-sm-12">
        <label>Buscar VIN</label>
        <input placeholder="Buscar VIN" class="form-control vin_adicional borrar_vin" type="text" name="busqueda_herramienta[]" id="busqueda_herramienta_adicional${contador_vin}" autocomplete="off" onkeyup="verificarVIN(${contador_vin});" size="19" width="300%"  >

        <center>
        <div id="resultadoBusquedaherramienta_adicional${contador_vin}" class="container-busquedas-1 mt-4" style="display: none;">
        </div>
        </center>
        </div>

        <div id="vin_autorizacion${contador_vin}" style="display: none;">

        <div class="col-sm-12">
        <label>*¿Quién autoriza?</label>   
        <div class="content-select">
        <select class="form-control limpiarvin" id="idem_au_vin0" name="idcolaboradorautoriza[]" required="">
        <option value="">Elige una opción…</option>
        <option value="118">EDFM</option>
        <option value="116">JFR</option>
        <option value="88">JAH</option>
        <option value="55">AAGH</option>
        </select>
        </div>            
        </div>

        <div class="col-sm-12">
        <label>*Comentarios</label><span class="contador_span" id="contador_espan0"> 10 caracteres restantes</span>
        <textarea class="form-control limpiarvin" id="comentarios0" name="comentarios_autorizacion[]" rows="3" required="" onkeyup="RangeComentarios(${contador_vin});"></textarea value="ok">
        </div>

        <div class="col-sm-12">
        <label>Cargar Archivo</label>
        <input type="file" class="form-control-file" name="archivoautorizacion[]" id="evidencia_archivo_vin0" onchange="change_file_vin_principal(${contador_vin})" required>
        <input  type="hidden" value="VIN" name="tipo_evidencia[]">
        </div>

        </div>


        <div class="row" id="show_autorizacion${contador_vin}" style="display: none;">
        <div class="col-sm-6">
        <label>VIN</label>
        <input type="text" id="soy_vin${contador_vin}" name="soy_vin[]" class="form-control borrar_vin" readonly minlength="8" maxlength="8" onKeyUp="mayus(this);">
        </div>

        <div class="col-sm-6">
        <label>Marca</label>
        <input type="text" id="marca_vin${contador_vin}" name="soy_marca[]" class="form-control borrar_vin" readonly onKeyUp="mayus(this);">
        </div>

        <div class="col-sm-6">
        <label>Version</label>
        <input type="text" id="version_vin${contador_vin}" name="soy_version[]" class="form-control borrar_vin" readonly list="search_version${contador_vin}"  onKeyUp="mayus(this);" />
        </div>

        <div class="col-sm-6">
        <label>Color</label>
        <input type="text" id="color_vin${contador_vin}" name="soy_color[]" class="form-control borrar_vin" readonly list="search_color${contador_vin}"  onKeyUp="mayus(this);" />
        </div>

        <div class="col-sm-6">
        <label>Modelo</label>
        <input type="number" id="modelo_vin${contador_vin}" name="soy_modelo[]" class="form-control borrar_vin" readonly min="1900" max="2050">
        </div>

        <div class="col-sm-6"><label>Tipo Unidad</label>
        <input type="text" id="tipo_vin${contador_vin}" name="tipo_vin[]" class="form-control borrar_vin" readonly >
        </div> 


        </div>      
        </div>      

        <a class="button-eliminar remove_button mt-4 mb-4">
        <span>Eliminar</span><i class="fas fa-trash"></i>
        </a>


        </div>`;


        $(wrapper_vin).append(fieldHTMLVIN);

    });


$(wrapper_vin).on('click', '.remove_button', function(e) {
    e.preventDefault();
    $(this).parent('div').remove();

    var obtener_aux_vinsin_tocar = $("#aux_vin").val();
    $("#aux_vin").val(obtener_aux_vinsin_tocar + "|");

    var disminuir_count_vin = $("#count_vin").val();
    var nuevo_contador_vin = parseInt(disminuir_count_vin, 10) - 1;
    $("#count_vin").val(nuevo_contador_vin);

    if (nuevo_contador_vin == 0) {
        $("#aux_vin").val("0");
    }


});












    //-----------------------------------------------------
    //Inician AcompañANTES


    $(".ayudante1").click(function() {

        if ($(".ayudante1").is(':checked')) {

            $("#desc_ayudantes").show();
            $("#show_detalle_actividad").show();
        }
    });


    $(".ayudante2").click(function() {

        if ($(".ayudante2").is(':checked')) {

            $("#desc_ayudantes").hide();
            $("#show_detalle_actividad").show();
            $("#show_ayudante_adicional").empty();

        }
    });





    var addButtonAyudante = $('.create_ayudante');
    var wrapper_ayudante = $('.field_wrapper_ayudante');

    $(addButtonAyudante).click(function() {


        var obtener_count_ayudante = $("#count_ayudante").val();


        var add_coun_ayudante = parseInt(obtener_count_ayudante, 10) + 1;
        $("#count_ayudante").val(add_coun_ayudante);



        var obtener_aux_ayudante = $("#aux_ayudante").val();

        if (obtener_aux_ayudante == 0) {

            var contador_ayudante = 1;

        } else {

            if ($.isNumeric(obtener_aux_ayudante) == true) {

                var contador_ayudante = parseInt(obtener_aux_ayudante, 10) + 1;

            } else {

                var cortar = obtener_aux_ayudante.substr(0, 1);

                var contador_ayudante = parseInt(obtener_aux_ayudante, 10) + 1;

            }
        }



        $("#aux_ayudante").val(contador_ayudante);

        var fieldHTMLAyudante = `
        <div class="row mt-4 mb-4 container-title-line">

        <div class="col-sm-12">
        <h3 class="m-t-none m-b"><strong>Agregar Acompañante ${contador_ayudante}</strong></h3>
        </div>

        <div class="col-sm-12">
        <label>Buscar Acompañante</label>
        <input placeholder="Buscar Acompañante" class="form-control" type="text" name="busqueda_ayudante[]" id="busqueda_ayudante${contador_ayudante}" value="" autocomplete="off" onkeyup="verificarayudante(${contador_ayudante});" size="19" width="300%" />
        <center>
        <div id="resultadoBusquedaAyudante${contador_ayudante}" class="container-busquedas-1 mt-4 efecto-busqueda" style="display: none;"></div>
        </center>
        </div>

        <div class="col-sm-12">
        <label>ID</label>
        <input type="text" id="id_ayudante${contador_ayudante}"  class="form-control" name="id_ayudante[]" readonly="">
        </div>

        <div class="col-sm-12">
        <label>Tipo</label>
        <input type="text" id="tipo_ayudante${contador_ayudante}" class="form-control" name="tipo_ayudante[]" readonly="">
        </div>

        <div class="col-sm-12">
        <label for="comentario_ayudante${contador_ayudante}">Detalle de Actividad</label>
        <textarea class="form-control" id="comentario_ayudante${contador_ayudante}" name="comentario_ayudante[]" rows="3" required""></textarea>
        </div>


        <a class="button-eliminar remove_buttonAyudante mt-4 mb-4">
        <span>Eliminar</span><i class="fas fa-trash"></i>
        </a>

        </div>`;

        if ($(".ayudante1").is(':checked')) {

            $(wrapper_ayudante).append(fieldHTMLAyudante);

        }



    });


    $(wrapper_ayudante).on('click', '.remove_buttonAyudante', function(e) {
        e.preventDefault();
        $(this).parent('div').remove();

        var obtener_aux_ayudantesin_tocar = $("#aux_ayudante").val();
        $("#aux_ayudante").val(obtener_aux_ayudantesin_tocar + "|");

        var disminuir_count_ayudante = $("#count_ayudante").val();
        var nuevo_contador_ayudante = parseInt(disminuir_count_ayudante, 10) - 1;
        $("#count_ayudante").val(nuevo_contador_ayudante);

        if (nuevo_contador_ayudante == 0) {
            $("#aux_ayudante").val("0");
        }


    });




    $('#fecha_hora_programada').bootstrapMaterialDatePicker({
        date: true,
        time: true,
        shortTime: true,
        format: 'YYYY-MM-DD HH:mm',
        lang: "es",
        cancelText: 'Cancelar',
        okText: 'Definir'
    });

    $('#hora_estimada_solucion').bootstrapMaterialDatePicker({
        date: true,
        time: true,
        shortTime: true,
        format: 'YYYY-MM-DD HH:mm',
        lang: "es",
        cancelText: 'Cancelar',
        okText: 'Definir'
    });




    $("#clean_start").click(function() {
        $("#start").val("");



        document.querySelector(".P1_origen").checked = false;
        document.querySelector(".P2_origen").checked = false;
        document.querySelector(".P3_origen").checked = false;
        document.querySelector(".miubicacionorigen").checked = false;

        $(".content-imgCarro").css("left", "0px");

        $("#imgCarL1, #imgCarL2").removeClass("animateL");
        $("#imgCarL1, #imgCarL2").addClass("animateL2");

        function myFunction(m360) {
            if (m360.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m480.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m688.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m767.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m1024.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m1280.matches) {
                $(".content-imgCarro").css("left", "0%");
            }
        }

        var m360 = window.matchMedia("(max-width: 360px)");
        var m480 = window.matchMedia("(max-width: 480px)");
        var m688 = window.matchMedia("(max-width: 688px)");
        var m767 = window.matchMedia("(max-width: 767px)");
        var m1024 = window.matchMedia("(max-width: 1024)");
        var m1280 = window.matchMedia("(max-width: 1280px)");

        myFunction(m360); // Se llama a la funcion y se ejecuta
        m360.addListener(myFunction); // Adjunta la funcion para cambios de estado
    });

    $("#clean_end").click(function() {
        $("#end").val("");



        document.querySelector(".P1_destino").checked = false;
        document.querySelector(".P2_destino").checked = false;
        document.querySelector(".P3_destino").checked = false;
        document.querySelector(".miubicaciondestino").checked = false;

        $(".content-imgCarro").css("left", "0px");

        $("#imgCarL1, #imgCarL2").removeClass("animateL");
        $("#imgCarL1, #imgCarL2").addClass("animateL2");

        function myFunction(m360) {
            if (m360.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m480.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m688.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m767.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m1024.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m1280.matches) {
                $(".content-imgCarro").css("left", "0%");
            }
        }

        var m360 = window.matchMedia("(max-widht: 360px)");
        var m480 = window.matchMedia("(max-width: 480px)");
        var m688 = window.matchMedia("(max-width: 688px)");
        var m767 = window.matchMedia("(max-width: 767px)");
        var m1024 = window.matchMedia("(max-width: 1024)");
        var m1280 = window.matchMedia("(max-width: 1280px)");

        myFunction(m360); // Se llama a la funcion y se ejecuta
        m360.addListener(myFunction); // Adjunta la funcion para cambios de estado
    });

    $("#clean_hora_programada").click(function() {
        $("#fecha_hora_programada").val("");

        $(".content-imgCarro").css("left", "0px");

        $("#imgCarL1, #imgCarL2").removeClass("animateL");
        $("#imgCarL1, #imgCarL2").addClass("animateL2");

        function myFunction(m360) {
            if (m360.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m480.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m688.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m767.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m1024.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m1280.matches) {
                $(".content-imgCarro").css("left", "0%");
            }
        }

        var m360 = window.matchMedia("(max-width: 360px)");
        var m480 = window.matchMedia("(max-width: 480px)");
        var m688 = window.matchMedia("(max-width: 688px)");
        var m767 = window.matchMedia("(max-width: 767px)");
        var m1024 = window.matchMedia("(max-width: 1024)");
        var m1280 = window.matchMedia("(max-width: 1280px)");

        myFunction(m360); // Se llama a la funcion y se ejecuta
        m360.addListener(myFunction); // Adjunta la funcion para cambios de estado
    });


    $("#ejecutivo_traslado").on('change', function() {
        var valor_ejecutivo = $("#ejecutivo_traslado").val();
        var porcion_ejecutivo = valor_ejecutivo.split(';');

        var create = "<option value='" + porcion_ejecutivo[0] + "'>" + porcion_ejecutivo[1] + "</option>";
        $("#valores_responsables").val(create + "*");

    });






}); //FIN document Ready


//-------------------------------------- Funcion buscar No Orden

function buscar_num_orden() {

    var textoBusquedanum_orden = $("#num_orden").val();


    if (textoBusquedanum_orden != "") {

        $.post("buscar_no_orden.php", { valorBusqueda: textoBusquedanum_orden }, function(mensaje_orden) {

            if (mensaje_orden.trim() == "0") {

                $("#desc_no_orden2").show();
                $("#desc_si_orden").hide();

            } else {

                $("#desc_si_orden").show();
                $("#desc_si_orden").html("<h5 class='mb-0'>" + mensaje_orden + "</h5>");
                $("#desc_no_orden2").hide();
            }


        });

    } else {
        $("#desc_si_orden").hide();
        $("#desc_no_orden2").hide();
    }
};


//-------------------------------------- Funcion ID

function buscar_cliente() {
    var textoBusquedaID = $("#busqueda_id").val();
    var id_departamento = $("#departamento").val();
    
    if (textoBusquedaID != "") {

        $.post("buscar_cliente_logostica.php", { valorBusqueda: textoBusquedaID, type_id: id_departamento },

            function(mensaje_id) {

                $("#resultadoBusquedaId").show();
                $("#resultadoBusquedaId").html(mensaje_id);


                if (mensaje_id.trim() == "<b>ID NO Encontrado</b>") {

                    $("#show_add_id").show();
                    $("#idcliente").val("");
                    $("#nombre").val("");
                    $("#apellidos").val("");
                    $("#alias").val("");
                    $("#celular").val("");
                    $("#fijo").val("");
                    $("#estado").val("");
                    $("#municipio").val("");
                    $("#colonia").val("");
                    $("#calle").val("");
                    $("#codigo_postal_cliente").val("");
                    $("#tipo_contacto_id").val("");
                    //$("#create_button").show();

                } else {
                    $("#idcliente").attr("readonly", "readonly");
                    $("#nombre").attr("readonly", "readonly");
                    $("#apellidos").attr("readonly", "readonly");
                    $("#alias").attr("readonly", "readonly");
                    $("#celular").attr("readonly", "readonly");
                    $("#fijo").attr("readonly", "readonly");
                    $("#estado").attr("readonly", "readonly");
                    $("#municipio").attr("readonly", "readonly");
                    $("#colonia").attr("readonly", "readonly");
                    $("#calle").attr("readonly", "readonly");
                    $("#codigo_postal_cliente").attr("readonly", "readonly");
                    $("#codigo_postal_cliente").attr("readonly", "readonly");
                    $("#create_button").hide();
                    $("#show_add_id").hide();

                }
            });
    } else {
        $("#resultadoBusquedaId").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
    };
};


$(document).on('click', '.option_id_logistica_generar', function(event) {

    event.preventDefault();
    aux_recibido = $(this).val();
    var porcion = aux_recibido.split(';');
    unidad_id = porcion[0];
    unidad_nombre = porcion[1];
    unidad_apellidos = porcion[2];
    unidad_alias = porcion[3];
    unidad_telefono_celular = porcion[4];
    unidad_telefono_otro = porcion[5];
    unidad_estado = porcion[6];
    unidad_municipio = porcion[7];
    unidad_colonia = porcion[8];
    unidad_calle = porcion[9];
    unidad_cp = porcion[10];
    unidad_tipo_id = porcion[11];
    $("#busqueda_id").val("");
    $("#idcliente").val(unidad_id);
    $("#nombre").val(unidad_nombre);
    $("#apellidos").val(unidad_apellidos);
    $("#alias").val(unidad_alias);
    $("#celular").val(unidad_telefono_celular);
    $("#fijo").val(unidad_telefono_otro);
    $("#estado").val(unidad_estado);
    $("#estado_destino").val(unidad_estado);
    $("#municipio").val(unidad_municipio);
    $("#municipio_destino").val(unidad_municipio);
    $("#colonia").val(unidad_colonia);
    $("#colonia_destino").val(unidad_colonia);
    $("#calle").val(unidad_calle);
    $("#calle_destino").val(unidad_calle);
    $("#codigo_postal_cliente").val(unidad_cp);
    $("#tipo_contacto_id").val(unidad_tipo_id);
    $("#resultadoBusquedaId").html("");
    $("#resultadoBusquedaId").hide();

    if (unidad_id != "") {

        CleanCamposVinGeneral();
        $("#show_id_vin_si").show();
        $("#rol_vin").val("");
        $("#vin_autorizacion").empty("");
        Remove_VinAdicional();


    } else {

        CleanCamposVinGeneral();
        $("#show_id_vin_si").hide();
        $("#rol_vin").val("");
        $("#vin_autorizacion").empty("");
        Remove_VinAdicional();
    }







});


function guardar_temporal() {


    var nombre_cliente = $("#nombre").val();
    var apellidos_cliente = $("#apellidos").val();
    var alias_cliente = $("#alias").val();
    var celular_cliente = $("#celular").val();
    var fijo_cliente = $("#fijo").val();
    var estado_cliente = $("#estado").val();
    var municipio_cliente = $("#municipio").val();
    var colonia_cliente = $("#colonia").val();
    var calle_cliente = $("#calle").val();
    var codigo_postal_cliente_cliente = $("#codigo_postal_cliente").val();


    $.ajax({
        url: 'agregar_proveedor.php',
        data: {
            nombre_cliente: nombre_cliente,
            apellidos_cliente: apellidos_cliente,
            alias_cliente: alias_cliente,
            celular_cliente: celular_cliente,
            fijo_cliente: fijo_cliente,
            estado_cliente: estado_cliente,
            municipio_cliente: municipio_cliente,
            colonia_cliente: colonia_cliente,
            calle_cliente: calle_cliente,
            codigo_postal_cliente_cliente: codigo_postal_cliente_cliente
        },
        type: 'POST',
        success: function(json) {
            var porcionestemporal = json.split('|');

            if (porcionestemporal[0] >= 0) {
                $("#create_button").hide();
                $("#idcliente").attr("readonly", "readonly");
                $("#nombre").attr("readonly", "readonly");
                $("#apellidos").attr("readonly", "readonly");
                $("#alias").attr("readonly", "readonly");
                $("#celular").attr("readonly", "readonly");
                $("#fijo").attr("readonly", "readonly");
                $("#estado").attr("readonly", "readonly");
                $("#municipio").attr("readonly", "readonly");
                $("#colonia").attr("readonly", "readonly");
                $("#calle").attr("readonly", "readonly");
                $("#codigo_postal_cliente").attr("readonly", "readonly");

                $("#idcliente").val(porcionestemporal[0]);
                $("#nombre").val(porcionestemporal[1]);
                $("#apellidos").val(porcionestemporal[2]);
                $("#alias").val(porcionestemporal[3]);
                $("#celular").val(porcionestemporal[4]);
                $("#fijo").val(porcionestemporal[5]);
                $("#estado").val(porcionestemporal[6]);
                $("#municipio").val(porcionestemporal[7]);
                $("#colonia").val(porcionestemporal[8]);
                $("#calle").val(porcionestemporal[9]);
                $("#codigo_postal_cliente").val(porcionestemporal[10]);
                $("#tipo_contacto_id").val(porcionestemporal[11]);



            } else {

                console.log(json);

            }




        },


        error: function(xhr, status) {

            $(".error-form").show();
            $(".text-error").html("Disculpe, existio un problema");

            setTimeout(function() {
                $(".error-form").fadeOut(1000);
            }, 1500);
        }
    });




}

//Vin Principal

function buscar_herramienta() {
    var textoBusquedaherramienta = $("#busqueda_herramienta").val();
    var id_id_cliente = $("#idcliente").val();
    var id_id_departamento = $("#departamento").val();
    var type_orden = $("#tipo_orden").val();
    var rol_rol_vin = $("#rol_vin").val();

    if (textoBusquedaherramienta != "") {
        console.log(textoBusquedaherramienta);
        $.post("buscar_vin_general_logistica.php", { valorHerramienta: textoBusquedaherramienta, id_id_cliente: id_id_cliente, id_id_departamento: id_id_departamento, type_orden: type_orden, rol_rol_vin: rol_rol_vin }, function(mensaje_herramienta) {
            $("#resultadoBusquedaherramienta").html(mensaje_herramienta);
            $("#resultadoBusquedaherramienta").show();

            if (mensaje_herramienta.trim() == "<b>VIN NO Encontrado</b>") {

                $("#soy_vin").removeAttr("readonly", "readonly");
                $("#soy_vin").val("");
                $("#marca_vin").removeAttr("readonly", "readonly");
                $("#marca_vin").val("");
                $("#version_vin").removeAttr("readonly", "readonly");
                $("#version_vin").val("");
                $("#color_vin").removeAttr("readonly", "readonly");
                $("#color_vin").val("");
                $("#modelo_vin").removeAttr("readonly", "readonly");
                $("#modelo_vin").val("");
                $("#tipo_vin").val("Indefinido");


                $("#desc_type_unidad").val("");
                $("#desc_type_unidad").show("");
                $("#desc_type_unidad").attr("required", "required");


                $("#soy_vin").attr("required", "required");
                $("#marca_vin").attr("required", "required");
                $("#version_vin").attr("required", "required");
                $("#color_vin").attr("required", "required");
                $("#modelo_vin").attr("required", "required");



            } else {

                $("#soy_vin").attr("readonly", "readonly");
                $("#marca_vin").attr("readonly", "readonly");
                $("#version_vin").attr("readonly", "readonly");
                $("#color_vin").attr("readonly", "readonly");
                $("#modelo_vin").attr("readonly", "readonly");
                $("#soy_vin").removeAttr("required", "required");
                $("#marca_vin").removeAttr("required", "required");
                $("#version_vin").removeAttr("required", "required");
                $("#color_vin").removeAttr("required", "required");
                $("#modelo_vin").removeAttr("required", "required");

                $("#desc_type_unidad").val("");
                $("#desc_type_unidad").hide();
                $("#desc_type_unidad").removeAttr("required", "required");





            }
        });
    } else {
        $("#resultadoBusquedaherramienta").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
    };
};

$(document).on('click', '.sugerencias_herramienta', function(event) {
    event.preventDefault();
    aux_recibido = $(this).val();
    var porcion = aux_recibido.split(';');
    unidad_herramientavin = porcion[0];
    unidad_htvin = porcion[1];
    unidad_htmarca = porcion[2];
    unidad_htversion = porcion[3];
    unidad_htcolor = porcion[4];
    unidad_htmodelo = porcion[5];
    unidad_httipo = porcion[6];
    unidad_autorizacion = porcion[7];
    console.log(unidad_autorizacion);
    console.log(unidad_htvin);
    $("#busqueda_herramienta").val(unidad_htvin);
    $("#soy_vin").val(unidad_htvin);
    $("#marca_vin").val(unidad_htmarca);
    $("#version_vin").val(unidad_htversion);
    $("#color_vin").val(unidad_htcolor);
    $("#modelo_vin").val(unidad_htmodelo);
    $("#tipo_vin").val(unidad_httipo);
    $("#count_principal_vin").val("1");
    $("#resultadoBusquedaherramienta").html("");
    $("#resultadoBusquedaherramienta").hide();

    if (typeof unidad_autorizacion === 'undefined') {

        console.log("Vin sin Autorizacion");
        $("vin_autorizacion").empty();  

        if (unidad_htvin == "") {

            $("#show_rol_vin_adicional").hide();
            $("#show_autorizacion").show();
            $("#show_origen_id").hide();
            $("#show_destino_id").hide();
            $("#button_origen_destino").hide();

            

        } else {

            $("#show_rol_vin_adicional").show();
            $("#show_autorizacion").show();
            $("#show_origen_id").show();
            $("#show_destino_id").show();
            $("#button_origen_destino").show();

            

        }

    }else {
        console.log("Vin CON Autorizacion ");
        $("#show_autorizacion").hide();
        $("vin_autorizacion").empty(); 
        $("#vin_autorizacion").show();

        var autorizaciones = `
        <div class="col-sm-12">
        <label>*¿Quién autoriza?</label>   
        <div class="content-select">
        <select class="form-control limpiarvin" id="idem_au_vin0" name="idcolaboradorautoriza[]" required="">
        <option value="">Elige una opción…</option>
        <option value="118">EDFM</option>
        <option value="116">JFR</option>
        <option value="88">JAH</option>
        <option value="55">AAGH</option>
        </select>
        </div>            
        </div>

        <div class="col-sm-12">
        <label>*Comentarios</label><span class="contador_span" id="contador_espan0"> 10 caracteres restantes</span>
        <textarea class="form-control limpiarvin" id="comentarios0" name="comentarios_autorizacion[]" rows="3" required="" onkeyup="RangeComentarios('0');"></textarea value="ok">
        </div>

        <div class="col-sm-12">
        <label>Cargar Archivo</label>
        <input type="file" class="form-control-file" name="archivoautorizacion[]" id="evidencia_archivo_vin0" onchange="change_file_vin_principal('0')" required>
        <input  type="hidden" value="VIN" name="tipo_evidencia[]">
        </div>
        `;
        $("#vin_autorizacion").append(autorizaciones);
    }





});

function RangeComentarios(valor) {
    console.log("Contador de caracteres " + valor);

    var obtener_id = $("#comentarios" + valor).val();
    var obtener_idtrim = obtener_id.trim();
    var obtener_id_tamanio = obtener_idtrim.length;

    var min_character = parseInt(10 - obtener_id_tamanio);

    (min_character <= 0) ? $('#contador_espan'+valor).html("<i class='fas fa-check-double'></i>") :  $('#contador_espan'+valor).html(min_character + " caracteres restantes") ;


}

$(document).on('change','input[type="file"]',function(){



    var fileSize = this.files[0].size;
    let ca = $(this).attr("id");
    console.log(ca);



    var arrayDeCadenas = ca.split("");


    for (var i=0; i < arrayDeCadenas.length; i++) {

        if ($.isNumeric( arrayDeCadenas[i] )) {
            var solo_numero = arrayDeCadenas[i];
        }
    }

    console.log(solo_numero);




    if(fileSize > 9216000){


      $("#evidencia_archivo_vin"+solo_numero).val("")

      change_file_vin_principal(solo_numero);
      alert('El archivo no debe superar los 9MB ');
      return false;

  }else{



    $("#show_autorizacion").show();
    $("#show_rol_vin_adicional").show();

    return true;

}
});

function change_file_vin_principal(valor) {

    var inputfilevin_principal = $("#evidencia_archivo_vin"+valor).val();




    if (inputfilevin_principal == 0 || inputfilevin_principal == "") {

        CleanVINPrincipal();
        $("#rol_vin").val("");
        $("#vin_autorizacion").empty();
        $("#show_rol_vin_adicional").hide();



    } else {



    }

}

// Vin Adicional

function verificarVIN(contador_nuevo_vin) {


    var vin_nomenclatura = $("#busqueda_herramienta_adicional" + contador_nuevo_vin).val();

    var id_id_cliente_adicional = $("#idcliente").val();
    var id_id_departamento_adicional = $("#departamento").val();
    var type_orden_adicional = $("#tipo_orden").val();
    var rol_adicional_vin = $("#rol_vin" + contador_nuevo_vin).val();


    $.post("buscar_vin_general_logistica.php", { valorHerramienta: vin_nomenclatura, contador_nuevo_vin: contador_nuevo_vin, id_id_cliente: id_id_cliente_adicional, id_id_departamento: id_id_departamento_adicional, type_orden: type_orden_adicional, rol_rol_vin: rol_adicional_vin }, function(mensaje_vin2) {

        $("#resultadoBusquedaherramienta_adicional" + contador_nuevo_vin).html(mensaje_vin2);
        $("#resultadoBusquedaherramienta_adicional" + contador_nuevo_vin).show();


    });


    $(document).on('click', '.sugerencias_herramienta' + contador_nuevo_vin, function(event_adicional) {
        event_adicional.preventDefault();
        aux_recibido_adicional = $(this).val();
        var porcion_adicional = aux_recibido_adicional.split(';');
        unidad_herramientavin_adicional = porcion_adicional[0];
        unidad_htvin_adicional = porcion_adicional[1];
        unidad_htmarca_adicional = porcion_adicional[2];
        unidad_htversion_adicional = porcion_adicional[3];
        unidad_htcolor_adicional = porcion_adicional[4];
        unidad_htmodelo_adicional = porcion_adicional[5];
        unidad_httipo_adicional = porcion_adicional[6];
        unidad_autorizacion_adicional = porcion_adicional[7]


        $("#busqueda_herramienta_adicional" + contador_nuevo_vin).val(unidad_htvin_adicional);
        $("#soy_vin" + contador_nuevo_vin).val(unidad_htvin_adicional);
        $("#marca_vin" + contador_nuevo_vin).val(unidad_htmarca_adicional);
        $("#version_vin" + contador_nuevo_vin).val(unidad_htversion_adicional);
        $("#color_vin" + contador_nuevo_vin).val(unidad_htcolor_adicional);
        $("#modelo_vin" + contador_nuevo_vin).val(unidad_htmodelo_adicional);
        $("#tipo_vin" + contador_nuevo_vin).val(unidad_httipo_adicional);
        $("#resultadoBusquedaherramienta_adicional" + contador_nuevo_vin).html("");
        $("#resultadoBusquedaherramienta_adicional" + contador_nuevo_vin).hide();

        console.log(unidad_autorizacion_adicional);

        if (typeof unidad_autorizacion_adicional === 'undefined') {

            console.log(`Vin sin Autorizacion ${contador_nuevo_vin}`);
            $("#vin_autorizacion"+contador_nuevo_vin).hide();

            if (unidad_htvin_adicional == "") {

                $("#show_autorizacion"+contador_nuevo_vin).show();
                $("#show_rol_vin_adicional"+contador_nuevo_vin).hide();

            } else {

                $("#show_autorizacion"+contador_nuevo_vin).show();
                $("#show_rol_vin_adicional"+contador_nuevo_vin).hide();
            }

        }else {
            console.log("activando autorizaciones " + contador_nuevo_vin);
            $("#vin_autorizacion"+contador_nuevo_vin).show();
        }



    });



}



function verificarayudante(contador_nuevo_ayudante) {


    var ayudante_nomenclatura = $("#busqueda_ayudante" + contador_nuevo_ayudante).val();

    $.post("buscar_ayudante_generar_logistica.php", { valorBusqueda: ayudante_nomenclatura, contador_nuevo_ayudante: contador_nuevo_ayudante }, function(mensaje_ayudante2) {

        $("#resultadoBusquedaAyudante" + contador_nuevo_ayudante).html(mensaje_ayudante2);
        $("#resultadoBusquedaAyudante" + contador_nuevo_ayudante).show();


    });


    $(document).on('click', '.sugerencias_asesor' + contador_nuevo_ayudante, function(event_adicional) {
        event_adicional.preventDefault();
        aux_recibido_adicional = $(this).val();
        var porcion_adicional = aux_recibido_adicional.split(';');

        unidad_id_ayudante_adicional = porcion_adicional[0];
        unidad_nomenclatura_ayudante_adicional = porcion_adicional[1];
        unidad_tipo_ayudante_adicional = porcion_adicional[2];

        $("#busqueda_ayudante" + contador_nuevo_ayudante).val(unidad_nomenclatura_ayudante_adicional);
        $("#id_ayudante" + contador_nuevo_ayudante).val(unidad_id_ayudante_adicional);
        $("#tipo_ayudante" + contador_nuevo_ayudante).val(unidad_tipo_ayudante_adicional);
        $("#resultadoBusquedaAyudante" + contador_nuevo_ayudante).html("");
        $("#resultadoBusquedaAyudante" + contador_nuevo_ayudante).hide();

    });


}







function acciones_solicitante() {

    if ($("#busqueda_asesor").val() == "") {
        $("#show_ayudantes").hide();
    } else {
        $("#show_ayudantes").show();
    }

}

function verificar_cambios() {

    var comentario_actividad_general = $("#comentario_actividad").val();


    if (comentario_actividad_general.trim() == "") {

        $("#show_guardar").hide();

    } else {
        console.log("adelante");
        $("#show_guardar").show();

    }

}

























































function CleanNoOrden() {
    console.log("No Orden");
    $("#show_no_orden").hide();
    $("#cuenta_si_orden").hide();
    $("#num_orden").val("");
    $("#desc_si_orden").empty();
    $("#desc_no_orden").empty();
    $(".orden1").attr('checked', false);
    $(".orden2").attr('checked', false);

}


// Funciones para limpiar por secciones

function CleanDatosID() {

    $("#show_id").hide();

    $("#busqueda_id").val("");
    $("#idcliente").val("");
    $("#nombre").val("");
    $("#apellidos").val("");
    $("#alias").val("");
    $("#celular").val("");
    $("#fijo").val("");
    $("#estado").val("");
    $("#municipio").val("");
    $("#colonia").val("");
    $("#calle").val("");
    $("#codigo_postal_cliente").val("");
    $("#tipo_contacto_id").val("");
    $("#show_add_id").hide();
}

function CleanCamposVinGeneral() {

    $(".borrar_vin").val("");

}

function CleanVINPrincipal() {


    $("#busqueda_herramienta").val("");
    $("#desc_type_unidad").val("");
    $("#soy_vin").val("");
    $("#marca_vin").val("");
    $("#version_vin").val("");
    $("#color_vin").val("");
    $("#modelo_vin").val("");
    $("#tipo_vin").val("");

    $("#show_rol_vin").hide();

}


function Remove_VinAdicional() {
    console.log("Remove VIN adicional");
    $("#show_vin_adicional").empty();

    $("#aux_vin").val("0");
    $("#count_vin").val("0");
    $("#count_principal_vin").val("0");

}



function Remove_AyudanteAdicional() {
    console.log("Remove Ayudante adicional");
    $("#show_ayudante_adicional").empty();

    $("#aux_ayudante").val("0");
    $("#count_ayudante").val("0");
    $("#count_principal_vin").val("0");

    $(".ayudante1").attr('checked', false);
    $(".ayudante2").attr('checked', false);

}


function changeRolAdicionalVIN(valorVIN) {

    if ($("#rol_vin" + valorVIN).val() == "") {

        $("#show_rol_vin_adicional" + valorVIN).hide();

        $("#busqueda_herramienta_adicional" + valorVIN).val("");
        $("#soy_vin" + valorVIN).val("");
        $("#marca_vin" + valorVIN).val("");
        $("#version_vin" + valorVIN).val("");
        $("#color_vin" + valorVIN).val("");
        $("#modelo_vin" + valorVIN).val("");
        $("#tipo_vin" + valorVIN).val("");
        $("#responsable_unidad" + valorVIN).val("");


    } else {

        $("#show_rol_vin_adicional" + valorVIN).show();

        $("#busqueda_herramienta_adicional" + valorVIN).val("");
        $("#soy_vin" + valorVIN).val("");
        $("#marca_vin" + valorVIN).val("");
        $("#version_vin" + valorVIN).val("");
        $("#color_vin" + valorVIN).val("");
        $("#modelo_vin" + valorVIN).val("");
        $("#tipo_vin" + valorVIN).val("");
        $("#responsable_unidad" + valorVIN).val("");

    }

}

function CleanTrayecto() {

    $("#show_datos_recorrido").hide();

    $("#kilometros").val("");
    $("#timeall").val("");
    $("#fecha_hora_programada").val("");

}



function CleanActividad() {
    $("#comentario_actividad").val("");
}




function SoloNumeros(evt) {
    if (window.event) { //asignamos el valor de la tecla a keynum
        keynum = evt.keyCode; //IE
    } else {
        keynum = evt.which; //FF
    }
    //comprobamos si se encuentra en el rango numérico
    if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 || keynum == 47) {
        return true;
    } else {
        return false;
    }
}

function validarFormulario() {

    var txtstart = $("#start").val();
    var txtend = $("#end").val();

    if (txtstart == null || txtstart.length == 0 || /^\s+$/.test(txtstart)) {
        // alert('ERROR: El campo buscar Origen no debe ir vacío o lleno de solamente espacios en blanco');
        $(".error-form").show();
        $(".text-error").html("ERROR: El campo buscar Origen no debe ir vacío o lleno de solamente espacios en blanco.")
        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    }

    if (txtend == null || txtend.length == 0 || /^\s+$/.test(txtend)) {
        // alert('ERROR: El campo buscar Destino no debe ir vacío o lleno de solamente espacios en blanco');
        $(".error-form").show();
        $(".text-error").html("ERROR: El campo buscar Destino no debe ir vacío o lleno de solamente espacios en blanco.");
        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#end").focus();
        return false;
    }


    return true;

}







function validateForm() {

    var fecha_hora_programada = $("#fecha_hora_programada").val();
    var idcliente = $("#idcliente").val();
    var solicitante = $("#solicitante").val();
    var info = $("#info").val();
    var trasladista = $("#trasladista").val();



    if (fecha_hora_programada === "") {
        alert("Debes de Agregar Fecha de Salida ");
        $("#fecha_hora_programada").focus();

        $(".content-imgCarro").css("left", "0px");

        $("#imgCarL1, #imgCarL2").removeClass("animateL");
        $("#imgCarL1, #imgCarL2").addClass("animateL2");

        function myFunction(m360) {
            if (m360.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m480.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m688.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m767.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m1024.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m1280.matches) {
                $(".content-imgCarro").css("left", "0%");
            }
        }

        var m360 = window.matchMedia("(max-width: 360px)");
        var m480 = window.matchMedia("(max-width: 480px)");
        var m688 = window.matchMedia("(max-width: 688px)");
        var m767 = window.matchMedia("(max-width: 767px)");
        var m1024 = window.matchMedia("(max-width: 1024)");
        var m1280 = window.matchMedia("(max-width: 1280px)");

        myFunction(m360); // Se llama a la funcion y se ejecuta
        m360.addListener(myFunction); // Adjunta la funcion para cambios de estado
        return false;
    } else if (idcliente === "") {
        // alert("Debes de Agregar un Cliente ");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar un cliente");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#busqueda_colaborador").focus();
        return false;
    } else if (solicitante === "") {
        // alert("Debes de Agregar un Solicitante");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar un solicitante");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#busqueda_asesor").focus();
        return false;
    } else if (info === "") {
        // alert("Debes de Agregar un Informante");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar un informante");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#busqueda_informante").focus();
        return false;
    } else if (estado_o === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (municipio_o === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (colonia_o === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (calle_o === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (cpo === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (coordenadas_origen === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (estado_d === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (municipio_d === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (colonia_d === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (calle_d === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (cpd === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (coordenadas_destino === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else {
        return true;
    }


}







function validateForm() {

    var fecha_hora_programada = $("#fecha_hora_programada").val();
    var idcliente = $("#idcliente").val();
    var solicitante = $("#solicitante").val();
    var info = $("#info").val();
    var trasladista = $("#trasladista").val();


    var estado_o = $("#estado_o").val();
    var municipio_o = $("#municipio_o").val();
    var colonia_o = $("#colonia_o").val();
    var calle_o = $("#calle_o").val();
    var cpo = $("#cpo").val();
    var coordenadas_origen = $("#coordenadas_origen").val();
    var estado_d = $("#estado_d").val();
    var municipio_d = $("#municipio_d").val();
    var colonia_d = $("#colonia_d").val();
    var calle_d = $("#calle_d").val();
    var cpd = $("#cpd").val();
    var coordenadas_destino = $("#coordenadas_destino").val();




    if (fecha_hora_programada === "") {
        alert("Debes de Agregar Fecha de Salida ");
        $("#fecha_hora_programada").focus();

        $(".content-imgCarro").css("left", "0px");

        $("#imgCarL1, #imgCarL2").removeClass("animateL");
        $("#imgCarL1, #imgCarL2").addClass("animateL2");

        function myFunction(m360) {
            if (m360.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m480.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m688.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m767.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m1024.matches) {
                $(".content-imgCarro").css("left", "0%");
            } else if (m1280.matches) {
                $(".content-imgCarro").css("left", "0%");
            }
        }

        var m360 = window.matchMedia("(max-width: 360px)");
        var m480 = window.matchMedia("(max-width: 480px)");
        var m688 = window.matchMedia("(max-width: 688px)");
        var m767 = window.matchMedia("(max-width: 767px)");
        var m1024 = window.matchMedia("(max-width: 1024)");
        var m1280 = window.matchMedia("(max-width: 1280px)");

        myFunction(m360); // Se llama a la funcion y se ejecuta
        m360.addListener(myFunction); // Adjunta la funcion para cambios de estado
        return false;
    } else if (idcliente === "") {
        // alert("Debes de Agregar un Cliente ");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar un cliente");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#busqueda_colaborador").focus();
        return false;
    } else if (solicitante === "") {
        // alert("Debes de Agregar un Solicitante");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar un solicitante");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#busqueda_asesor").focus();
        return false;
    } else if (info === "") {
        // alert("Debes de Agregar un Informante");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar un informante");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#busqueda_informante").focus();
        return false;
    } else if (estado_o === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (municipio_o === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (colonia_o === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (calle_o === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (cpo === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (coordenadas_origen === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (estado_d === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (municipio_d === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (colonia_d === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (calle_d === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (cpd === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else if (coordenadas_destino === "") {
        // alert("Debes de Agregar Origen y Destino");
        $(".error-form").show();
        $(".text-error").html("Debes de agregar origen y destino");

        setTimeout(function() {
            $(".error-form").fadeOut(1000);
        }, 1500);
        $("#start").focus();
        return false;
    } else {
        return true;
    }


}


function mayus(e) {
    e.value = e.value.toUpperCase();
}




function validarhora() {

    $("#fecha_hora_programada").change(function() {
        var time_google = $("#timeall").val();
        var fecha_actual = new Date();
        var fecha_programada = $("#fecha_hora_programada").val();


        var fecha1 = moment(fecha_actual);
        var fecha2 = moment(fecha_programada);
        var diferencia = (fecha2.diff(fecha1, 'minutes'));

        var porciones = time_google.split(' ');
        var long_porciones = porciones.length;

        //console.log(fecha_actual + " VS " + fecha_programada);
        //console.log(diferencia);

        if (long_porciones == 2) {

            if (porciones[1] == "min") {

                if (porciones[0] < diferencia) {

                    $("#desc_adelante").show();
                    //$("#desc_inconsiente").show();
                    //$("#desc_btn_guardar").show();
                    $("#desc_pocajontas").hide();
                } else {
                    $("#desc_pocajontas").show();
                    $("#desc_adelante").hide();
                    //$("#desc_inconsiente").hide();
                    //$("#desc_btn_guardar").hide();         
                }
            }


        } else if (long_porciones == 3) {


            var multiplicar = parseInt(porciones[0]) * parseInt(60) + parseInt(porciones[1]);
            console.log("multiplicar dias  " + multiplicar + "   diferencia " + diferencia);
            if (multiplicar < diferencia) {
                $("#desc_adelante").show();
                //$("#desc_inconsiente").show();
                //$("#desc_btn_guardar").show();
                $("#desc_pocajontas").hide();
            } else {
                $("#desc_pocajontas").show();
                $("#desc_adelante").hide();
                //$("#desc_inconsiente").hide();
                //$("#desc_btn_guardar").hide();          
            }

        } else if (long_porciones == 5) {

            var multiplicar_dias = parseInt(porciones[0]) * parseInt(1440) + parseInt(porciones[3] * 60);
            //console.log("multiplicar dias  " + multiplicar_dias + "   diferencia " + diferencia);
            if (multiplicar_dias < diferencia) {
                $("#desc_adelante").show();
                //$("#desc_inconsiente").show();
                //$("#desc_btn_guardar").show();
                $("#desc_pocajontas").hide();

            } else {
                $("#desc_pocajontas").show();
                $("#desc_adelante").hide();
                //$("#desc_inconsiente").hide();          
                //$("#desc_btn_guardar").hide();          
            }
        }

    });

}

$(".inconsiente1").click(function() {

    if ($(".inconsiente1").is(':checked')) {
        //$("#desc_inconsiente").show();
        //$("#desc_btn_guardar").show();

    }

});


$(".inconsiente2").click(function() {

    if ($(".inconsiente2").is(':checked')) {
        //$("#desc_inconsiente").hide(); 
        $("#fecha_hora_programada").focus();
        $("#desc_btn_guardar").hide();

        $(".content-imgCarro").css("left", "80%");

        $("#imgCarL1, #imgCarL2").addClass("animateL");
        $("#imgCarL1, #imgCarL2").removeClass("animateL2");

        function myFunction(m360) {
            if (m360.matches) {
                $(".content-imgCarro").css("left", "32%");
            } else if (m480.matches) {
                $(".content-imgCarro").css("left", "38%");
            } else if (m688.matches) {
                $(".content-imgCarro").css("left", "56%");
            } else if (m767.matches) {
                $(".content-imgCarro").css("left", "60%");
            } else if (m1024.matches) {
                $(".content-imgCarro").css("left", "60%");
            } else if (m1280.matches) {
                $(".content-imgCarro").css("left", "65%");
            }
        }

        var m360 = window.matchMedia("(max-width: 360px)");
        var m480 = window.matchMedia("(max-width: 480px)");
        var m688 = window.matchMedia("(max-width: 688px)");
        var m767 = window.matchMedia("(max-width: 767px)");
        var m1024 = window.matchMedia("(max-width: 1024)");
        var m1280 = window.matchMedia("(max-width: 1280px)");

        myFunction(m360); // Se llama a la funcion y se ejecuta
        m360.addListener(myFunction); // Adjunta la funcion para cambios de estado

    }

});

function buscar_asesor() {
    var textoBusquedaAsesor = $("#busqueda_asesor").val();
    if (textoBusquedaAsesor != "") {
        $.post("buscar_asesor_logistica.php", { valorBusqueda: textoBusquedaAsesor }, function(mensaje_asesor) {
            $("#resultadoBusquedaAsesor").html(mensaje_asesor);
            $("#resultadoBusquedaAsesor").show();
            if (mensaje_asesor.trim() == "<b>NO Encontrado</b>") {
                $("#solicitante").attr("readonly", "readonly");
            } else {
                $("#solicitante").attr("readonly", "readonly");
            }
        });
    } else {
        $("#resultadoBusquedaAsesor").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
    };
};

$(document).on('click', '.sugerencias_asesor_solicitante', function(event) {
    event.preventDefault();
    aux_recibido = $(this).val();
    var porcion = aux_recibido.split(';');
    unidad_id_asesor = porcion[0];
    unidad_nomenclatura = porcion[1];
    tipo_solicitante = porcion[2];
    $("#busqueda_asesor").val("");
    $("#id_asesor").val(unidad_id_asesor);
    $("#solicitante").val(unidad_nomenclatura);
    $("#tipo_solicitante").val(tipo_solicitante);
    $("#resultadoBusquedaAsesor").html("");
    $("#resultadoBusquedaAsesor").hide();
});

function buscar_informante() {
    var textoBusquedaInformante = $("#busqueda_informante").val();
    if (textoBusquedaInformante != "") {
        $.post("buscar_informante.php", { valorBusqueda: textoBusquedaInformante }, function(mensaje_informante) {
            $("#resultadoBusquedaInformante").html(mensaje_informante);
            if (mensaje_informante.trim() == "<b>NO Encontrado</b>") {
                $("#info").attr("readonly", "readonly");
                $("#resultadoBusquedaInformante").show();
            } else {}
            $("#info").attr("readonly", "readonly");
            $("#resultadoBusquedaInformante").show();

        });
    } else {
        $("#resultadoBusquedaInformante").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
    };
};

$(document).on('click', '.sugerencias_informante', function(event) {
    event.preventDefault();
    aux_recibido = $(this).val();
    var porcion = aux_recibido.split(';');
    unidad_id_informante = porcion[0];
    unidad_nomenclatura_informante = porcion[1];
    tipo_informante = porcion[2];
    $("#busqueda_informante").val("");
    $("#id_informante").val(unidad_id_informante);
    $("#info").val(unidad_nomenclatura_informante);
    $("#tipo_informante").val(tipo_informante);
    $("#resultadoBusquedaInformante").html("");
    $("#resultadoBusquedaInformante").hide();
});



function buscar_trasladista() {
    var textoBusquedaTrasladista = $("#busqueda_trasladista").val();
    if (textoBusquedaTrasladista != "") {
        $.post("buscar_trasladista_gl.php", { valorBusqueda: textoBusquedaTrasladista }, function(mensaje_trasladista) {
            $("#resultadoBusquedaTrasladista").html(mensaje_trasladista);

            if (mensaje_trasladista.trim() == "<b>NO Encontrado</b>") {
                $("#ejecutivo_traslado").val("");
                $("#trasladista").val("");
                $("#tipo_trasladista").val("");
                $("#resultadoBusquedaTrasladista").show();
            } else {
                $("#trasladista").attr("readonly", "readonly");
                $("#resultadoBusquedaTrasladista").show();
            }
        });
    } else {
        $("#resultadoBusquedaTrasladista").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
    };
};

$(document).on('click', '.sugerencias_trasladista', function(event) {
    event.preventDefault();
    aux_recibido = $(this).val();
    var porcion = aux_recibido.split(';');
    unidad_id_trasladista = porcion[0];
    unidad_nomenclatura_trasladista = porcion[1];
    tipo_trasladista = porcion[2];
    $("#busqueda_trasladista").val("");
    $("#ejecutivo_traslado").val(unidad_id_trasladista);
    $("#trasladista").val(unidad_nomenclatura_trasladista);
    $("#tipo_trasladista").val(tipo_trasladista);
    $("#resultadoBusquedaTrasladista").html("");
    $("#resultadoBusquedaTrasladista").hide();
    $("#valores_inputs").val(`<option value="${unidad_id_trasladista}*${tipo_trasladista}">${unidad_nomenclatura_trasladista}</option>` + ";");

});







$("#clean_programada").click(function() {
    $("#busqueda_trasladista").val("");
    $("#ejecutivo_traslado").val("");
    $("#trasladista").val("");
    $("#tipo_trasladista").val("");

    // $(".t_programada").prop("checked", false);
    document.querySelector(".t_programada").checked = false;

});


$(".t_programada").click(function() {

    if ($(".t_programada").is(':checked')) {
        $("#busqueda_trasladista").val("");
        $("#ejecutivo_traslado").val("");
        $("#tipo_trasladista").val("");

        $("#trasladista").val("Logistica Programada");
    }
});