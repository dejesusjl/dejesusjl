$(document).ready(function() {
	function initMap() {}   	
});

function buscar_vin() {
    var busqueda = $("#busqueda_herramienta").val();
    var mensaje_herramienta="";
    if (busqueda != "") {
        $.post("consultaOrdenesCarga.php", {mensaje: busqueda}, function(resultado) {
            $("#resultadoBusquedaherramienta").html(resultado);
            $("#resultadoBusquedaherramienta").show();
        });
    } else { 
        $("#resultadoBusquedaherramienta").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
    };
};

$(document).on('click', '.autoSeleccionado', function (event) {
    event.preventDefault();            
    aux_recibido=$(this).val();
    var vehiculo = aux_recibido.split(';');
    vin=vehiculo[0];
    marca=vehiculo[1];
    version=vehiculo[2];
    modelo=vehiculo[3];
    color=vehiculo[4];
    estatus_unidad=vehiculo[5];
    rendimiento=vehiculo[6];
    responsable=vehiculo[7];
    if(rendimiento==0){
        error('Esta Unidad No Tiene Rendimiento, Colocalo!');
        $('#Rendimiento').removeAttr("readOnly");
        $("#Rendimiento").focus();
    }
    $("#busqueda_herramienta").val("");
    $("#busqueda_herramienta").attr("href='#origen'");

    $("#vin_box").val(vin);
    $("#marca_box").val(marca);
    $("#version_box").val(version);
    $("#modelo_box").val(modelo);
    $("#color_box").val(color);
    $("#estatus_box").val(estatus_unidad);
    $("#responsable_box").val(responsable);
    $("#Rendimiento").val(rendimiento);
    $("#resultadoBusquedaherramienta").hide();
    $("#aniade").show();

    $.post("consultaOrdenesCarga.php", {serie: vin}, function(resultado) {
        //console.log('resultado: '+resultado);
        separacion=resultado.split('%');
        $("#autosRuta").html(separacion[0]);
        $('#FechasSepara').html(separacion[1]);
        creaCalendario();
        Refresh();
         $("#FechasSelect").show();
    });

});
function Refresh(){
    $("#autosRuta").get(0).click();
}

$(document).on('change', '#autosRuta', function (event) {
    existe=false;
    $("#precio_gas").val('');
});
$(document).on('click', '#autosRuta', function (event) {
    event.preventDefault();            
    aux_recibido=$(this).val();
    var orden = aux_recibido.split(';');

    ordenlogistica=orden[0];
    monto_total=orden[1];
    fecha_inicio=orden[2];
    fecha_fin=orden[3];
    vin=orden[4];
    rendimiento=$("#Rendimiento").val();  
    gasolina=orden[5];
    lts=orden[6]; 
    gasolinaAux=$("#precio_gas").val();
    gasAnterior=0;
    
    if((gasolina<=0 || gasolina=='')){
        if(existe){
            gasolina=gasolinaAux;
        }else{
            error('Esta orden no tiene precio de la gasolina, coloquelo porfavor!');
            $('#precio_gas').removeAttr("readOnly");
            $("#precio_gas").focus();
            existe=true;
        }
    }else{
        console.log('Litros:'+lts+'   Gas unitario aux: '+gasolina);            
        $("#precio_gas").val(gasolina);
        $("#precio_gas").prop('readonly', true);
        
    }




    if(rendimiento<=0||rendimiento==''){
        error('Esta unidad no tiene un rendimiento valido!');
        $('#Rendimiento').removeAttr("readOnly");
        $("#Rendimiento").focus();
    }else{
        //console.log('Presionaste la fecha: '+fecha_inicio+' Hasta:'+fecha_fin);
        carrin= $("#vin_box").val()+ " | "+$("#marca_box").val()+ " | "+$("#version_box").val()+ " | "+$("#modelo_box").val()+ " | "+$("#color_box").val()+ " | "+$("#estatus_box").val()+ " | ";
        $.post("consultaOrdenesCarga.php", {FechaI: fecha_inicio , FechaF: fecha_fin, orden: ordenlogistica, vin: vin,rendimiento: rendimiento, gasolina: gasolina, monto: monto_total, carro: carrin}, function(resultado) {
            //console.log('resultado: '+resultado);
            $('#rellename').dataTable().fnClearTable();
			$('#rellename').dataTable().fnDestroy();
			$("#rellename").html(resultado);
                        
         	$('#rellename').DataTable({
	        	lengthMenu: [[5,10, 25, -1], ["5" ,"10", " 25", "Todo ___"]],
	        	bSort: false,
	        	"pagingType": "numbers",
				language: {
                          "sProcessing":     "Procesando...",
                          "sLengthMenu":     "Mostrar  _MENU_  registros",
                          "sZeroRecords":    "No se encontraron resultados",
                          "sEmptyTable":     "Ningún dato disponible en esta tabla",
                          "sInfo":           "Mostrando ordenes del _START_ al _END_ de un total de _TOTAL_ ordenes",
                          "sInfoEmpty":      "No se encontraron ordenes",
                          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                          "sInfoPostFix":    "",
                          "sSearch":         "Buscar:",
                          "sUrl":            "",
                          "sInfoThousands":  ",",
                          "sLoadingRecords": "Cargando...",
                          "oPaginate": {
                                        "sFirst":    "Primero",
                                        "sLast":     "Último",
                                        "sNext":     "Siguiente",
                                        "sPrevious": "Anterior"
                                      },
                          "oAria":    {
                                      "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                                      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                                      },
                          "decimal": ",",
                          "thousands": "."
                        }

	        }
	        );   
        });
        //
       
    }


});
$(document).on('change', '#autosRuta', function (event) {
    Refresh();
});

$(document).on('click', '#modSi', function (event) {
    if ($('#modSi').is(':checked')) {
        $('#Rendimiento').removeAttr("readOnly");
    }else{
        $('#Rendimiento').prop('readonly', true);
    }
});

$(document).on('click', '#Magna', function() {

    if ($("#Magna").is(':checked')) {
        //magna
        var comb=$('#Magna').val();

        console.log(comb);
        document.getElementById("precio_gas").value=comb;
        Refresh();
    }

});
$(document).on('click', "#Premium",function() {

    if ($("#Premium").is(':checked')) {
        //premium
        var comb=$('#Premium').val();
       console.log(comb);
        document.getElementById("precio_gas").value=comb;
        Refresh();

    }

});
$(document).on('click', "#Diesel",function() {

    if ($("#Diesel").is(':checked')) {
        //diesel
         var comb=$('#Diesel').val();
        console.log(comb);
        document.getElementById("precio_gas").value=comb;
        Refresh();

    }

});

function error(Mensaje){
    $(".error-form").show();
    $(".text-error").html(Mensaje);
    setTimeout( function(){
        $(".error-form").fadeOut(250);
    }, 750);
}

function creaCalendario(){
    
    fechas=$('#fechaPoner').val().split('+');
    desactiva=[];
    desactiva2=[];
    console.log('Fechas a Separar: '+fechas.length+'Inicia: '+fechas[0]+' Finaliza: '+fechas[fechas.length-2]);
    var fdes="";
    for(i=0;i<fechas.length-1;i++){        
        desactiva.push((fechas[i].substr(0,10)).split('-'));
        desactiva2.push(desactiva[i]);
        fdes+="["+desactiva[i]+"],";
       console.log('Fecha '+i+' : '+desactiva[i]+" -> "+typeof(desactiva[i]));
    }
    
    iniciaF=fechas[0].substr(0,10);
    fiinF=fechas[fechas.length-2].substr(0,10);
    f2=true+","+fdes.substr(0,fdes.length-1);

    console.log('Fecha des: '+desactiva +  typeof(desactiva));
    console.log('Fecha des2: '+desactiva2 +  typeof(desactiva2));


    console.log('inicio: '+iniciaF);
    console.log('fin: '+fiinF);
        //
    iniciaF=iniciaF.split('-');
    fiinF=fiinF.split('-');
    iniciaF[1]=iniciaF[1]-1;
    fiinF[1]=fiinF[1]-1;    
    $('#fecha_hora_programada').pickadate({
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


        disable: [true,desactiva],


        // Accessibility labels
        labelMonthNext: 'Siguiente Mes',
        labelMonthPrev: 'Anterior Mes',
        labelMonthSelect: 'Selecciona un mes',
        labelYearSelect: 'Selecciona un año',
        // Formats
        format: 'yyyy-mm-dd',
        selectMonths: true,
        selectYears: true
    });
}