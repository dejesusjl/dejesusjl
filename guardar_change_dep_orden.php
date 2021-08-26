<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php"; 
include_once "funciones_principales_insert.php"; 
date_default_timezone_set('America/Mexico_City');
$fecha_guardado=date("Y-m-d H:i:s");
$usuario_creador=$_SESSION['usuario_clave'];
$usuario_loguin=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

$random = rand(5, 15);
?>

<!doctype html>
<html lang="es"> 

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Guardar Departamento Orden</title>

	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="../../css/animate.css" rel="stylesheet">
	<link href="../../css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="../../assets/css/styles_neumorphism_alert.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<link href="../../css/tics.css" rel="stylesheet">

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
	<meta name="theme-color" content="#ffffff">



	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

</head>

<body>

	<div class="neu-container-page" style="overflow: auto;">
		<div>   

			<div class="neu-container-general neu-animation-container">

				<div class="d-flex justify-content-center">
					<img class="neu-logo" src="../../img/GRUPOPANAMOTORSPLATA.png" alt="">
				</div>

				<div class="d-flex justify-content-center">
					<div id="success_alert" class="neu-container-alert mt-4" style="display: none;">
						<div class="d-flex justify-content-center align-items-center neu-alert neu-alert-correcto">
							<h1 class="text-center text-white mb-0">Cambio departamento | tipo de orden agregada exitosamente</h1>
						</div>
					</div>
				</div>

				<div class="d-flex justify-content-center">
					<div id="fail_alert" class="neu-container-alert mt-4" style="display: none;">
						<div class="d-flex justify-content-center align-items-center neu-alert neu-alert-error">		
							<h1 class="text-center text-white mb-0">Se ha producido un error al guardar la información</h1>
						</div>
					</div>			
				</div>

				<div class="d-flex justify-content-center">
					<div id="alert_alert" class="neu-container-alert mt-4" style="display: none;">
						<div class="neu-alert neu-alert-error-tipo">
							<h4 class="text-center text-white mb-0">Error al: </h4>
						</div>
					</div>
				</div>

				<div id="content-contador" class="mt-4">
					<div class="content-contador d-flex justify-content-center align-items-center">
						<div class="contador text-center">
							<p class="text-redirigir mb-0">Seras redirigido en</p>
							<span class="numero-contador">0</span>
						</div>
					</div>				
				</div>

			</div> 




		</div>
	</div>
	<?php 
	

	$idorden_logistica = base64_decode($_POST['id_logistica_dep_orden']);
	$idlogistica_encriptada = $_POST['id_logistica_dep_orden'];

	$departamento = trim($_POST['departamento']);
	$tipo_orden = trim($_POST['tipo_orden']);
	$comentarios = trim($_POST['comentario_dep_orden']);
	$fecha_creacion = trim($_POST['fecha_creacion_dep_orden']);
	$coordenadas = trim($_POST['coordenadas_dep_orden']);

#----------------------------------------------------------  -------------------------------------------------------------------------------------------
	$query_orden = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$idorden_logistica' ";
	$result_orden = mysql_query($query_orden);
	//echo "<br>";
	if (mysql_num_rows($result_orden) >= 1) {
		
		while ($row_orden = mysql_fetch_array($result_orden)) {
			
			$iddepartamento = ($row_orden[iddepartamento] == $departamento || $departamento == "") ? $row_orden[iddepartamento] : $departamento;
			$idcatalogo_orden_logistica = ($row_orden[idcatalogo_orden_logistica] == $tipo_orden || $tipo_orden == "") ? $row_orden[idcatalogo_orden_logistica] : $tipo_orden;

			$name_departamento_principal_anterior = nameDepartamento($row_orden[iddepartamento]);
			$name_departamento_principal_nuevo = nameDepartamento($departamento);

			$name_torden_principal_anterior = nameTipoOrden($row_orden[idcatalogo_orden_logistica]);
			$name_torden_principal_nuevo = nameTipoOrden($tipo_orden);

			$query_update_orden = "UPDATE orden_logistica SET iddepartamento = '$iddepartamento', idcatalogo_orden_logistica = '$idcatalogo_orden_logistica' WHERE idorden_logistica = '$row_orden[idorden_logistica]' ";
			$result_update_orden = mysql_query($query_update_orden);
			//echo "<br>";
			
			if ($result_update_orden >= 1) {

				$insert_bitacora_departamento = ($row_orden[iddepartamento] == $departamento || $departamento == "") ? "" : LogisticaInsertBitacora ("El departamento cambio de <b>$name_departamento_principal_anterior</b> a <b>$name_departamento_principal_nuevo</b>", "Departamento", $idorden_logistica, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "14", "", "", "SI");

				$ver_errores .= ($insert_bitacora_departamento == 1) ? "" : $insert_bitacora_departamento;

				$insert_bitacora_torden = ($row_orden[idcatalogo_orden_logistica] == $tipo_orden || $tipo_orden == "") ? "" : LogisticaInsertBitacora ("El tipo de orden cambio de <b>$name_torden_principal_anterior</b> a <b>$name_torden_principal_nuevo</b>", "
					Tipo de Orden", $idorden_logistica, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "15", "", "", "SI");
				
				$ver_errores .= ($insert_bitacora_torden == 1) ? "" : $insert_bitacora_torden;

				//echo "$row_orden[iddepartamento] <br> $departamento<br>";

				$query_balance = "SELECT * FROM balance_gastos_operacion WHERE columna2 = '$idorden_logistica'";
				$result_balance = mysql_query($query_balance);
				//echo "<br>";
				if (mysql_num_rows($result_balance) >= 1) {

					while ($row_balance = mysql_fetch_array($result_balance)) {

						if ($row_balance[idcatalogo_departamento] != $departamento) {
							
							$show_departamento_anterior = nameDepartamento($row_balance[idcatalogo_departamento]);
							//echo "<br>";
							$show_departamento_nuevo = nameDepartamento($iddepartamento);
							//echo "<br>";
							//echo "<br> Auxiliaraes Anteriores: <b>$row_balance[apartado_usado]</b> <br>";

							$insert_bitacora_balance = BalanceInsertBitacora ("El departamento cambio de <b>$show_departamento_anterior</b> a <b>$show_departamento_nuevo</b>", "Departamento", $idorden_logistica, $comentarios, $coordenadas, $usuario_creador, $fecha_creacion, $fecha_guardado, "5", $columna_c, $columna_d, "SI");

							$ver_errores .= ($insert_bitacora_balance == 1) ? "" : $insert_bitacora_balance;

							$concatenar_arrays = array();
							$array_change_departamento = explode(",", $row_balance[apartado_usado]);

							foreach ($array_change_departamento as $key_departamento => $valor_departamento) {
								//echo "<br>Departamento Anterior: $show_departamento_anterior <br> valor array : $valor_departamento <br>";

								if ($show_departamento_anterior == trim($valor_departamento)) {

									array_push($concatenar_arrays, $show_departamento_nuevo);

								}else {

									array_push($concatenar_arrays, $valor_departamento);

								}
							}

							$quitar_repetidos = eliminar_repetidos ($concatenar_arrays);
							//var_dump($quitar_repetidos);

							$convertir = implode(",", $quitar_repetidos);
							$nuevos_auxiliares = $convertir.",";

							//echo "<br> Auxiliaraes Nuevos:     <b>$nuevos_auxiliares</b> <br>)";

							$query_update_balance = "UPDATE balance_gastos_operacion SET idcatalogo_departamento = '$departamento', apartado_usado = '$nuevos_auxiliares' WHERE idbalance_gastos_operacion = '$row_balance[idbalance_gastos_operacion]' ";
							$result_update_balance = mysql_query($query_update_balance);
							//echo "<br>";
							if ($result_update_balance == 1) {

								$query_auxiliares = "SELECT * FROM balance_gastos_auxiliares WHERE trim(nombre) = '$show_departamento_anterior' and idlogistica = '$row_balance[idbalance_gastos_operacion]'";
								$result_auxiliares = mysql_query($query_auxiliares);
								//echo "<br>";
								if (mysql_num_rows($result_auxiliares) >= 1 ) {

									while ($row_auxiliares = mysql_fetch_array($result_auxiliares)) {

										$update_auxiliares_secundarios = "UPDATE balance_gastos_auxiliares SET nombre = '$show_departamento_nuevo' WHERE idbalance_gastos_auxiliares = '$row_auxiliares[idbalance_gastos_auxiliares]'";
										$result_auxiliares_secundarios = mysql_query($update_auxiliares_secundarios);
										//echo "<br>";
										if ($result_auxiliares_secundarios == 1) {

											$ver_errores .= ""; 

										}else {

											$ver_errores .= "- Auxiliares Secundarios en el id: <b>$row_auxiliares[idbalance_gastos_auxiliares]</b> <br>";
										}

									}

								}else {
									$ver_errores .= "- No existe el departamento en el id: <b>$row_balance[idbalance_gastos_operacion]</b> <br>"; 
								}

							}

						}
					}

				}else{
					$ver_errores = "Sin Errores";
				}
				
			}else {
				$ver_errores = "Fallo";
			}

		}
		
	}else{
		$ver_errores = "- El número <b>$idorden_logistica</b> de logística no existe";
	}


	if ($ver_errores == "" || $ver_errores == "Sin Errores") {

		$ver_errores = "Sin Errores";

	}else {

		$ver_errores = $ver_errores;
	}


#---------------------------------------------------------- Funcion Departamento -------------------------------------------------------------------------------------------

	function nameDepartamento ($iddepartamento) {

		$iddepartamento = trim($iddepartamento);

		$query_departamento = "SELECT * FROM catalogo_departamento WHERE idcatalogo_departamento = '$iddepartamento'";
		$result_departamento = mysql_query($query_departamento);

		while ($row_departamento = mysql_fetch_array($result_departamento)) {
			$nombre_departamento = eliminar_tildes($row_departamento[nombre]);
		}

		$nombre_departamento = trim($nombre_departamento);

		return strtoupper($nombre_departamento);

	}

#-------------------------------------------Funcion Auxiliares Extras--------------------------------------------------------------------------------

	function eliminar_repetidos ($array_entrada_repetidos){

		$array_trim_mayus = array();
		$exit_array = array();

		foreach ($array_entrada_repetidos as $indice => $valor_array) {

			if ($valor_array != "") {
				array_push($array_trim_mayus, trim(strtoupper($valor_array)));
			}
		}

		$eliminar_duplicados = array_unique($array_trim_mayus);

		foreach ($eliminar_duplicados as $key_nuevo => $valor_nuevo_array) {

			if ($valor_nuevo_array != "") {
				array_push($exit_array, eliminar_tildes($valor_nuevo_array));
			}
		}


		return $exit_array;
	}

#---------------------------------------------------------- Funcion Tipo de Orden -------------------------------------------------------------------------------------------

	function nameTipoOrden($idtipo_orden){

		$idtipo_orden = trim($idtipo_orden);

		$query_tipo_orden = "SELECT * FROM orden_logistica_tipo_orden WHERE idorden_logistica_tipo_orden = '$idtipo_orden'";
		$result_tipo_orden = mysql_query($query_tipo_orden);

		while ($row_tipo_orden = mysql_fetch_array($result_tipo_orden)) {
			$nombre_tipo_orden = $row_tipo_orden[nombre];
		}
		return $nombre_tipo_orden;
	}

#----------------------------------------------------------  -------------------------------------------------------------------------------------------





	?>
	<script>

		var si_error_no = '<?php echo $ver_errores; ?>'
		var numeros_whats ='<?php echo $whatsapp_colaboradores;?>'
		var idlogistica = '<?php  echo $idlogistica_encriptada;?>'

		if (si_error_no == "Sin Errores") {
			$('#success_alert').show(); 
			$("#content-contador").show();
			if (numeros_whats == "") {

				redireccionPagina();
			}else{
				open(numeros_whats, `whatsapp`,`width=600, height=600, left=300, top=300`); 

				redireccionPagina();
			}


		}else if (si_error_no == "Fallo") {
			$('#fail_alert').show();  

			$("#content-contador").show();
			redireccionPagina();

		}else{
			$('#alert_alert').show(); 
			$("#content-contador").hide();
			$(".neu-alert-error-tipo").append("<p class='text-white mb-0' style='position: relative; z-index: 2;'>"+ si_error_no+ "</p>");


			var create = `
			<div class="d-flex justify-content-center mt-4">
			<button class="btn btn-lg btn-primary" id="continuar">Continuar</button>
			</div>
			`;

			$("#alert_alert").append(create);
		}



		$(document).ready(function(){
			$("#continuar").click(function(){
				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
			}); 

			$("#yes").click(function(){
				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
			}); 

			$("#nel").click(function(){

				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);

			});
		});

		function redireccionPagina(){
			delayPagina();
			contadorRedirigir();
		}

		function delayPagina(){
			var delay = 1000;
			setTimeout(() => {
				location.replace(`orden_logistica_detalles.php?idib=${idlogistica}`);
			}, delay);
		}

		function contadorRedirigir(){
			$('.numero-contador').each(function () { 
				$(this).prop('Counter', 1).animate(
				{ 
					Counter: $(this).text() 
				}, 
				{ 
					duration: 1000, 
					easing: 'swing', 
					step: function (now) { 
						$(this).text(Math.ceil(now)); 
					} 
				}
				); 
			});
		}

		const neu_animation_container = document.querySelector(".neu-animation-container");
		neu_animation_container.classList.add("add-neu-animation-container");

	</script>

</body>
</html>




