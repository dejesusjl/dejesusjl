function cancelar_enter(){

	var key = event.keyCode;

	if (key === 13) {
		event.preventDefault();
	}

}



function RangeComentarios(r,idlabel_contador,idbutton) {

	let ca = $(r).attr("id");
	let txtcomentarios = $("#"+ca).val();

	if (typeof txtcomentarios != 'undefined') {

		var obtener_idtrim = txtcomentarios.trim();
		var porciones = obtener_idtrim.split(" ");
		var ultimate = "";

		porciones.forEach(function(elemento, indice, array) {
			let ook = elemento.trim();

			if (ook != "") {
				ultimate += elemento.trim() + " ";
			}

		});

		var obtener_trime = ultimate.trim();

		var obtener_id_tamanio = obtener_trime.length;

		var min_character = parseInt(20 - obtener_id_tamanio);

		//(min_character <= 0) ? $('#contador_espan').html("<i class='fas fa-check-double'></i>") :  $('#contador_espan').html(min_character + " caracteres restantes") ;
		(min_character <= 0) ? $('#'+idlabel_contador).html("<i class='fas fa-check-double'></i>") :  $('#'+idlabel_contador).html(min_character + " caracteres restantes") ;

		//(min_character <= 0) ? $('#button_actualizar_balance').show() : $('#button_actualizar_balance').hide() ;
		(min_character <= 0) ? $('#'+idbutton).show() : $('#'+idbutton).hide() ;
	}

}


function TiempoAhora () {

	var today = new Date();

	var mes_long = (today.getMonth()+1);
	var x = `${mes_long}`;
	var meses = (x.length == 1) ? "0"+x : x ;

	var dia_long = today.getDate();
	var y = `${dia_long}`;
	var dias = (y.length == 1) ? "0"+y : y ;


	var Hora_long = today.getHours();
	var a = `${Hora_long}`;
	var horas = (a.length == 1) ? "0"+a : a ;

	var minuto_long = today.getMinutes();
	var b = `${minuto_long}`;
	var minutos = (b.length == 1) ? "0"+b : b ;

	var segundos_long = today.getSeconds();
	var c = `${segundos_long}`;
	var segundos = (c.length == 1) ? "0"+c : c ;


	var date = today.getFullYear() + '-' + meses + '-' + dias;
	var time = horas + ":" + minutos + ":" + segundos;

	return date_time = date + ' ' + time;

}





function actualizar_balance_options() {

	$('#modal_formulario_balance').modal('hide');




	var tipo_formulario = $("#balance_tipo_formulario").val();



	if (tipo_formulario == "Evidencia") {

		var files = $("#evidencia_balance")[0].files[0];

		var comentarios_balance = $("#comentarios_balance").val();
		var idbalance_gastos_operacion = $("#idbalance_gastos_operacion").val();
		var fecha_creacion_balance = $("#fecha_creacion_balance").val();
		var coordenadas = $("#coordenadas_balance").val();

		var formData = new FormData();

		formData.append('evidencia_balance',files);

		formData.append('comentarios_balance', comentarios_balance);
		formData.append('idbalance_gastos_operacion', idbalance_gastos_operacion);
		formData.append('balance_tipo_formulario', tipo_formulario);
		formData.append('fecha_creacion_balance', fecha_creacion_balance);
		formData.append('coordenadas', coordenadas);


	}else {

		var concepto_balance = $("#concepto_balance").val();
		var auxiliares_balance = $("#auxiliares_balance").val();

		var ultimate = "";
		$("input[name='auxiliares_balance[]']").map( function(key){

			let ook = $(this).val().trim();
			if (ook != "") {

				ultimate += $(this).val() + "|";
			}

		});

		var fecha_balance = $("#fecha_balance").val();
		var gran_total_balance = $("#gran_total_balance").val();
		var responsable_individual = $("#responsable_individual").val();
		var search_vin_balance = $("#search_vin_balance").val();
		
		var comentarios_balance = $("#comentarios_balance").val();
		var idbalance_gastos_operacion = $("#idbalance_gastos_operacion").val();
		var fecha_creacion_balance = $("#fecha_creacion_balance").val();
		var coordenadas = $("#coordenadas_balance").val();

		var formData = new FormData();

		formData.append('evidencia_balance',files);

		formData.append('concepto_balance', concepto_balance);
		formData.append('auxiliares_balance', ultimate);
		formData.append('fecha_balance', fecha_balance);
		formData.append('gran_total_balance', gran_total_balance);
		formData.append('responsable_individual', responsable_individual);
		formData.append('search_vin_balance', search_vin_balance);

		formData.append('comentarios_balance', comentarios_balance);
		formData.append('idbalance_gastos_operacion', idbalance_gastos_operacion);
		formData.append('balance_tipo_formulario', tipo_formulario);
		formData.append('fecha_creacion_balance', fecha_creacion_balance);
		formData.append('coordenadas', coordenadas);



	}

	//alert(search_vin_balance);
	//return false;

	$.ajax({
		data : formData,
		url : 'actualizar_balance_gastos_options.php',
		type : 'POST',
		processData: false,
		contentType: false,
		cache: false,
		beforeSend: function(){
			$(".container-loading-ajax").show();
		},
		success : function(json) {

			$("#AddTableBalance").empty();
			
			CallTableBalanceGastos();


			if (json.trim() == 1) {
				
				$(".listo-form").show();
				$(".text-listo").html("<b>Datos Guardados Correctamente</b>");

				setTimeout(function(){
					$(".listo-form").fadeOut(1000);
				}, 1500);


			}else {

				$(".error-form").show();
				$(".text-error").html(json);

				setTimeout(function(){
					$(".error-form").fadeOut(2000);
				}, 1500);
			}



			$(".container-loading-ajax").hide();
		},

		error : function(xhr, status) {

			$(".error-form").show();
			$(".text-error").html("Disculpe, existió un problema");

			setTimeout(function(){
				$(".error-form").fadeOut(1000);
			}, 1500);
		}
	});

}

