$(document).ready(function() {
    var addButtonVIN = $('.agrega_v');
    var wrapper_vin = $('.tabla_llenar');
	var contador=0;
	eliminados=[];
	agregados=[];  
	var num_autos = $("#num_autos").val();
	var add_auto;
	puntosAdicionales=[];

    $(addButtonVIN).click(function() {
    	$("#show_ruta").show();
    
	    var Vin= $("#vin_herramienta").val();
	    var Marca= $("#marca_herramienta").val();
	    var Version= $("#version_herramienta").val();
	    var Color= $("#color_herramienta").val();
	    var Modelo= $("#modelo_herramienta").val();
	    var Tipo= $("#tipo_herramienta").val();
	    var Rendimiento= $("#Rendimiento").val();
	    var fieldHTMLVIN="";
	    var existe=false;
    	
        
        //alert(Vin +  Marca + Version + Color+Modelo+Tipo+Rendimiento+obtener_count_vin);
   		if(agregados.length==0){
   			existe=false;
   			contador++;
        	add_auto = contador; 
        }else{
        	for (var i = 0; i <agregados.length ; i++) {
        		if(agregados[i]==Vin){        			
        			existe=true;
        		}else{
        			add_auto = contador; 
        		}
        	}
        }

        if(!existe){ 
            if(Rendimiento>0){
            	remplazo=false; 
            	 for (var i = 0,j=1;i<eliminados.length && !remplazo;i++,j++) {
            	 	if(eliminados[i]=='aqui'){
            	 		remplazo=true;
            	 		eliminados[i]=0;
            	 		agregados[i]=Vin;

            	 		$("#vin"+j).val(Vin);
            	 		$("#marca"+j).val(Marca);
            	 		$("#version"+j).val(Version);
            	 		$("#color"+j).val(Color);
            	 		$("#modelo"+j).val(Modelo);
            	 		$("#tipo"+j).val(Tipo);
            	 		$("#rendimiento"+j).val(Rendimiento);
            	 	//	$("#busqueda_herramienta").attr(`onclick="quita('${j}' );"`);

            	 		$("#vehiculo"+j).show();
            	 	}
            	 }
            	 if(!remplazo){
    	        	contador++;
    	        	//alert('No existe Vin: '+Vin+'... Agregando...'); 
    	        	agregados[add_auto-1]=Vin;
    	        	eliminados.push(0);
    	        	fieldHTMLVIN = `
    	                            <div class="row" id="vehiculo${add_auto}">

    		                            <div class="col-sm-12 mt-4">
    		                                <div class="mb-3">
    		                                <center style="font-size: 20px; border-bottom: 2px solid #882439; color: #d43759;">Vehículo ${add_auto}</center>
    		                            </div> </div>
    	 	

    	                                <div class="col-sm-3" >
    	                                    <label>VIN </label>                                          
    	                                    <input id="vin${add_auto}" value="${Vin}" class="form-control" type="text" id="vin_herramienta${add_auto}" name="vin_herramienta"  readonly="" minlength="8" maxlength="8" onKeyUp="mayus(this);"  />
    	                                </div>

    	                                <div class="col-sm-3">
    	                                    <label>Marca</label>
    	                                    <input id="marca${add_auto}" value="${Marca}" class="form-control" type="text" id="marca_herramienta${add_auto}" name="marca_herramienta" readonly="" onKeyUp="mayus(this);" />
    	                                </div> 

    	                                <div class="col-sm-3">
    	                                    <label>Versión</label>
    	                                    <input id="version${add_auto}" value="${Version}" class="form-control" type="text" id="version_herramienta${add_auto}" name="version_herramienta" readonly="" onKeyUp="mayus(this);" />

    	                                </div>  

    	                                <div class="col-sm-3">
    	                                    <label>Color</label>                                          
    	                                    <input id="color${add_auto}" value="${Color}" class="form-control" type="text" id="color_herramienta${add_auto}" name="color_herramienta" readonly="" onKeyUp="mayus(this);" />

    	                                </div>

    	                                <div class="col-sm-3">
    	                                    <label>Modelo</label>                                          
    	                                    <input id="modelo${add_auto}" value="${Modelo}" class="form-control" type="text" id="modelo_herramienta${add_auto}" name="modelo_herramienta" readonly="" />
    	                                    
    	                                </div>  
    	                                <div class="col-sm-3">
    	                                    <label>Tipo</label>                                          
    	                                    <input id="tipo${add_auto}" value="${Tipo}" class="form-control" type="text" id="tipo_herramienta${add_auto}" name="tipo_herramienta" readonly="" />
    	                                </div>  
    	                                <div class="col-sm-3">
    	                                    <label>Rendimiento</label>                                          
    	                                    <input id="rendimiento${add_auto}" value="${Rendimiento}" class="form-control" type="text" id="Rendimiento${add_auto}" name="Rendimiento" readonly="" />
    	                                    
    	                                </div> 
    	                                <a class="button-eliminar quitar_auto mt-4 mb-4" id="${add_auto}" value="${add_auto}" onclick="quita('${add_auto}' );">
    	                                    <span>Eliminar</span><i class="fas fa-trash"></i>
    	                                </a>                                    
    	                            </div>`;
    	                            $(wrapper_vin).append(fieldHTMLVIN);
    	        }
            }else{
                $(".error-form").show();
                        $(".text-error").html("ERROR: El Rendimiento tiene que ser mayor a 0.")
                        setTimeout(function() {
                            $(".error-form").fadeOut(1000);
                        }, 1500);
                        $("#busqueda_herramienta").focus();
            }
        }else{
            $(".error-form").show();
                        $(".text-error").html("ERROR: Ya Agregaste el VIN:  "+Vin )
                        setTimeout(function() {
                            $(".error-form").fadeOut(1000);
                        }, 1500);
                        $("#busqueda_herramienta").focus();
        	//alert('ya existe Vin: '+Vin);

        }
        
        actAuto();

       //alert("Autos: "+contadorAutos);

       //limpiando
    $("#vin_herramienta").val("");
   	$("#marca_herramienta").val("");
    $("#version_herramienta").val("");
    $("#color_herramienta").val("");
    $("#modelo_herramienta").val("");
    $("#tipo_herramienta").val("");
    $("#Rendimiento").val("");
    document.getElementById("busqueda_herramienta").focus();
    $("#aniade").hide();

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

}); //FIN document Ready

var distancia;
var tiempo;

function caclulaCostos(d,t){
	//alert("Sin slice: "+$("#kml").val());
	//alert("con slice: "+$("#kml").val().slice(0,-5)+"Arreglo: "+(this).agregados);
	kilitros=[];
	distancia=d;
	tiempo=t;
	for(var i=document.getElementById('autosRuta').options.length-1;i>=0;i--){
		document.getElementById('autosRuta').remove(i);
	}

	for(var i=0, j=1;i<(this).agregados.length;i++,j++){
		if((this).agregados[i]!="libre"){						
			option = document.createElement('option');
			option.value = j;
		 	option.text = (this).agregados[i]+" - "+$("#marca"+j).val()+" - "+$("#version"+j).val()+" - "+$("#modelo"+j).val()+" - "+$("#color"+j).val();
		 	document.getElementById('autosRuta').appendChild(option);
		 	kilitros.push($("#rendimiento"+j).val());
		}
	}
	option = document.createElement('option');
			option.value = 0;
		 	option.text = "Todos los vehiculos";
		 	document.getElementById('autosRuta').appendChild(option);
		 	$("#autosRuta").val(0);
	document.getElementById('autosRuta').addEventListener("change", cambia);
	cambia();
}

	
	function cambia(){
		var r=document.getElementById('autosRuta').selectedIndex;
		var p=document.getElementById('autosRuta').options[r];
		//alert("seleccionaste: "+p.value);
		if(r!=kilitros.length){
			// alert("se cambio a: "+r+"Con rendimiento de: "+$("#rendimiento"+(p.value)).val());		
			kmlitro=$("#rendimiento"+(p.value)).val();
			gas=(distancia/kmlitro).toFixed(2);
			cost=((document.getElementById("precio_gas").value)*gas).toFixed(2);
			//alert("distancia: "+distancia+"gasolina: "+gas+"costo: "+cost+"kml:"+kmlitro);
			document.getElementById("kml").value = kmlitro + " km/l";
			document.getElementById("gas").value = gas + " lts";
			document.getElementById("costo").value ="$ " + new Intl.NumberFormat("en-IN").format(cost) ; 
		}else{
			//alert("total litros:");
			totalltr=0;
			distR=0;
			for(i=0;i<kilitros.length;i++){
				//console.log("Total: "+totalltr);

				gas=(distancia/parseFloat(kilitros[i])).toFixed(2);
				cost=((document.getElementById("precio_gas").value)*gas).toFixed(2);

				totalltr+=parseFloat(cost);
				distR+=parseFloat(gas);
			}
			
			document.getElementById("kml").value = "Varios";
			document.getElementById("gas").value = distR.toFixed(2) + " lts";
			document.getElementById("costo").value ="$ " + new Intl.NumberFormat("en-IN").format( totalltr.toFixed(2)) ; 

		}

	}

function quita(auto){

			(this).eliminados[auto-1]="aqui";
			(this).agregados[auto-1]="libre";
			(this).add_auto=auto;
			(this).contador--;			
			$("#vehiculo"+auto).hide();
			actAuto();
		//e.preventDefault();
    
     
   //document.getElementById('vehiculo'+auto).remove();
   // $(this).parent('div').remove();
   // contador--;


}
function actAuto(){
	var contadorAutos=0;
        for (var i = 0; i<(this).agregados.length ;i++) {
        	if((this).agregados[i]!="libre"){
        		contadorAutos++;
        	}

        }
        $("#ponAuto").text(contadorAutos);
}


            function buscar_herramienta() {
                var textoBusquedaherramienta = $("#busqueda_herramienta").val();
                if (textoBusquedaherramienta != "") {
                    $.post("buscar_vin_rendimiento.php", {valorHerramienta: textoBusquedaherramienta}, function(mensaje_herramienta) {
                        $("#resultadoBusquedaherramienta").html(mensaje_herramienta);
                        if (mensaje_herramienta==" <b>VIN NO Encontrado</b>") {
                            $("#vin_herramienta").removeAttr("readonly","readonly");
                            $("#resultadoBusquedaherramienta").show();
                        }else{    
                            $("#resultadoBusquedaherramienta").show();
                            $("#vin_herramienta").attr("readonly","readonly");      
                            $("#marca_herramienta").attr("readonly","readonly");      
                            $("#version_herramienta").attr("readonly","readonly");      
                            $("#color_herramienta").attr("readonly","readonly");      
                            $("#modelo_herramienta").attr("readonly","readonly");      
                        }
                    });
                } else { 
                    $("#resultadoBusquedaherramienta").html('<p><b>No es posible realizar la búsqueda con datos incompletos.</b></p>');
                };
            };




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


}

hayParadas=false;
function AgregaParada(){
	if(validarFormulario()){
		sigPunto=cualSigue();
		puntosAdicionales[sigPunto]=0;
		htmlParada= `
					<div class="col-sm-12 mt-2" id="show_parada${sigPunto}" >
						<div class="col-sm-12 container-bg-1 p-3">
							<div class="d-flex align-items-center flex-wrap mb-2">
								<label class="mb-0 mr-2" for="">Buscar Parada ${sigPunto}</label>
								<div class="container-iconos-1" onclick="eliminaParada(${sigPunto});">
									<i class="fa fa-trash-o" aria-hidden="true" ></i>
								</div>
							</div>
							<input type="text" id="punto${sigPunto}" name="punto${sigPunto}" class="form-control">
						</div>
					</div>

		`;
		$('#paradas').append(htmlParada);
		var parada = document.getElementById('punto'+sigPunto);
		var paradaAutocomplete = new google.maps.places.Autocomplete(parada);
		paradaAutocomplete.setFields(['place_id']);
		hayParadas=true;
	}

}
function eliminaParada(id){
	puntosAdicionales[id]=1;
	//alert('hiciste click: '+id);
	document.getElementById('show_parada'+id).remove();
	
}

function cualSigue(){
	var regresame=0;
	for(var i = 0 ;i<puntosAdicionales.length;i++ ){
		if(puntosAdicionales[i]==0){
			console.log('ruta: '+i);
			regresame++;
		}else{
            console.log('se pone en: '+regresame);
            return regresame;
        }
	}
	//console.log('tengo: '+regresame);
	/*/if(regresame==0)
	return 0;
	else/*/
        console.log('se pone en: '+regresame);
		return regresame;
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
    if(hayParadas){
    	//alert("si hay paradas "+ waypts);
    	for (var i = 0; i< puntosAdicionales.length; i++) {
    		pto=$("#punto"+i).val();
    		if (puntosAdicionales[i]==0 ) {
    			//alert('si es punto '+puntosAdicionales[i]);
	    			if( pto == null || pto.length == 0 || /^\s+$/.test(pto)){
				        $(".error-form").show();
				        $(".text-error").html("ERROR: El campo buscar Parada "+pto +" no debe ir vacío o lleno de solamente espacios en blanco.")
				        setTimeout(function() {
				            $(".error-form").fadeOut(1000);
				        }, 1500);
				        $("#start").focus();
				        return false;
		    		}
		    }else{
		    	//alert('no es punto '+puntosAdicionales[i]);
		    }
    	}
    }else{
    	vacia=[];
    	waypts=vacia;
    	//alert("no hay paradas "+waypts);
    }

    return true;

}

function paradaInMap(){
	vacia=[];
    	waypts=vacia;
	for (var i = 0; i< puntosAdicionales.length; i++) {
        if(puntosAdicionales[i]==0){
    		pto=$("#punto"+i).val();	
        	waypts.push({
                location: pto,
                stopover: false,
            });	
        }    
	}
	//alert("puntos: "+puntosAdicionales+" way: "+waypts.length);

}














function mayus(e) {
    e.value = e.value.toUpperCase();
}

