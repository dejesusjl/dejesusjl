<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
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
	<title>Guardar Auxiliar General</title>

	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="../../css/animate.css" rel="stylesheet">
	<link href="../../css/style.css" rel="stylesheet">
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

	<!-- DataTables CSS -->
	<link href="../../plugins/datatables/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

	<!-- DataTables Responsive CSS -->
	<link href="../../plugins/datatables/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="../../plugins/datatables/dist/css/sb-admin-2.css" rel="stylesheet">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

	<style>
		.neu-container-general{
			background: linear-gradient(145deg, #25282b, #373c41);
			border: 1px solid #37393c;
			border-radius: 20px;
			box-shadow: 20px 20px 50px #17191b, -20px -20px 50px #2b3034;
			padding: 20px;
			position: relative;
			transition: .3s;
			width: 700px;
		}
		.neu-logo{
			width: 320px;
		}
		.neu-container-alert{
			border-radius: 40px;
			box-shadow: inset 0px 4px 5px #222629, inset 0px -4px 5px #44474a;
			padding: 20px;
		}
		.neu-alert{
			border-radius: 30px;
			overflow: hidden;
			padding: 10px;
			position: relative;
		}
		.neu-alert-correcto{
			/* background: linear-gradient(145deg, #007965, #00af91); */
			box-shadow: 0px 20px 40px rgba(11, 162, 106, .4);
		}
		.add-animation-neu-alert-correcto{
			animation: animateneualert 1s linear infinite;
		}
		@keyframes animateneualert{
			0%{
				box-shadow: none;
				}100%{
					box-shadow: 0px 20px 40px rgba(11, 162, 106, .4);
				}
			}
			.neu-alert-correcto:before, .neu-alert-correcto:after{
				animation: animatebarra 5s ease;
				content: '';
				height: 100%;
				position: absolute;
				top: 0;
				width: 50%;
			}
			.neu-alert-correcto:before{
				background: linear-gradient(145deg, #007965, #00af91);
				left: 0;
			}
			.neu-alert-correcto:after{
				background: linear-gradient(145deg, #00af91, #007965);
				right: 0;
			}
			.neu-alert-error{
				/* background: linear-gradient(145deg, #b71137, #e81d4c); */
				box-shadow: 0px 20px 40px rgba(183, 17, 55, .4);
			}
			.neu-alert-error:before, .neu-alert-error:after{
				animation: animatebarra 5s ease;
				content: '';
				height: 100%;
				position: absolute;
				top: 0;
				width: 50%;
			}
			.neu-alert-error:before{
				background: linear-gradient(145deg, #b71137, #e81d4c);
				left: 0;
			}
			.neu-alert-error:after{
				background: linear-gradient(145deg, #e81d4c, #b71137);
				right: 0;
			}
			.neu-alert-error-tipo{
				/* background: linear-gradient(145deg, #0278ae, #51adcf); */
				box-shadow: 0px 20px 40px rgba(2, 120, 174, .4);
			}
			.neu-alert-error-tipo:before, .neu-alert-error-tipo:after{
				animation: animatebarra 5s ease;
				content: '';
				height: 100%;
				position: absolute;
				top: 0;
				width: 50%;
			}
			.neu-alert-error-tipo:before{
				background: linear-gradient(145deg, #0278ae, #51adcf);
				left: 0;
			}
			.neu-alert-error-tipo:after{
				background: linear-gradient(145deg, #51adcf, #0278ae);
				right: 0;
			}
			@keyframes animatebarra{
				0%{
					width: 50%;
					}100%{
						width: 0;
					}
				}

				.neu-alert h1, .neu-alert h4{
					font-weight: 500;
					position: relative;
					z-index: 2;
				}

				.numero-contador{
					font-size: 80px;
					font-weight: bold;
				}

				@media (max-width: 767px){
					.neu-container-general{
						width: 90%;
						margin: auto;
					}
					.neu-logo{
						width: 200px;
					}
					.neu-alert h1{
						font-size: 24px;
					}
				}

				@media (max-width: 380px){
					.neu-logo{
						width: 150px;
					}
					.neu-alert h1{
						font-size: 18px;
					}
				}

				.neu-animation-container{
					transform: scaleX(1);
				}

				.add-neu-animation-container{
					animation: animationneu .5s linear;
				}

				@keyframes animationneu{
					0%{
						transform: scaleX(0);
						} 50%{
							transform: scaleX(1.1);
							} 100%{
								transform: scaleX(1);
							}
						}
					</style>

				</head>

				<body>

					<div style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%; background: linear-gradient(to top, #17191b, #33383d);">
						<div>

							<div class="neu-container-general neu-animation-container">

								<div class="d-flex justify-content-center">
									<img class="neu-logo" src="../../img/GRUPOPANAMOTORSPLATA.png" alt="">
								</div>

								<div class="d-flex justify-content-center">
									<div id="success_alert" class="neu-container-alert mt-4" style="display: none;">
										<div class="d-flex justify-content-center align-items-center neu-alert neu-alert-correcto">
											<h1 class="text-center text-white mb-0">Auxiliar agregado exitosamente</h1>
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
										<div class="d-flex justify-content-center align-items-center neu-alert neu-alert-error-tipo">
											<h4 class="text-center text-white mb-0">Error en:</h4>
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



							<center>
								<div class="alert alert-success" role="alert" id="success_alert" style="display: none;">
									<h1>Documentación Agregada EXITOSAMENTE</h1>
								</div>

								<div class="alert alert-info" role="alert" id="alert_alert" style="display: none;">
									<h4>Error al:</h4>
								</div>
							</center>

						</div>
					</div>


					<?php

#----------------------------------------------------------  -------------------------------------------------------------------------------------------

					$auxiliares = trim($_POST['auxiliares']);
					$fecha_creacion = trim($_POST['fecha_creacion']);



					$idlogistica_encriptada = $_POST['pasar_logistica'];
					$idlogistica = base64_decode($idlogistica_encriptada);



					$query_balance_gastos_operacion = "SELECT * FROM balance_gastos_operacion WHERE visible = 'SI' AND columna2 = '$idlogistica'";
					$result_balance_gastos_operacion = mysql_query($query_balance_gastos_operacion);

					if (mysql_num_rows($result_balance_gastos_operacion) == 0) {

						$ver_errores = "Fallo";

					}else {

						while ($row_balance_gastos_operacion = mysql_fetch_array($result_balance_gastos_operacion)) {

							$ver_estatus_auxiliares = update_auxiliares($row_balance_gastos_operacion[idbalance_gastos_operacion], strtoupper($auxiliares));

							if ($ver_estatus_auxiliares == 1) {

								$agregar_nuevo_auxiliar = insert_auxiliares ($auxiliares, $row_balance_gastos_operacion[idauxiliar_principales], $row_balance_gastos_operacion[idbalance_gastos_operacion], $row_balance_gastos_operacion[fecha_movimiento], "SI", $usuario_creador, $fecha_creacion, $fecha_guardado);

								$mensaje .=  ($agregar_nuevo_auxiliar == "" ) ? "" : $agregar_nuevo_auxiliar;



							}else {

								$agregar_nuevo_auxiliar = insert_auxiliares ($auxiliares, $row_balance_gastos_operacion[idauxiliar_principales], $row_balance_gastos_operacion[idbalance_gastos_operacion], $row_balance_gastos_operacion[fecha_movimiento], "SI", $usuario_creador, $fecha_creacion, $fecha_guardado);

								$mensaje .=  ($agregar_nuevo_auxiliar == "" ) ? "" : $agregar_nuevo_auxiliar;

								$mensaje .= $ver_estatus_auxiliares;

							}
						}
					}




					function update_auxiliares($pasar_id_movimiento, $auxiliares){

						$query = "SELECT * FROM balance_gastos_operacion WHERE idbalance_gastos_operacion = '$pasar_id_movimiento'";
						$result = mysql_query($query);

						while ($row = mysql_fetch_array($result)) {
							$apartado_usado = "$row[apartado_usado]";
						}

						$apartado_usado = trim($apartado_usado);

						if ($apartado_usado == "") {
							$ver_auxiliares = $auxiliares.",";
						}else{

							$string = $apartado_usado.$auxiliares;

							$array = explode(",", $string);

							$eliminar_aux_repe = array_unique($array);

							$var_ok = implode(",", $eliminar_aux_repe);

							$ver_aux = explode(",",$var_ok);

							$count_nuevo = count($ver_aux);

							$array_sin_espacios = array_unique($ver_aux);

							$array_contar = count($array_sin_espacios);

							$aumentar = 0;

							while ($aumentar < $count_nuevo) {

								if ($array_sin_espacios[$aumentar] != "") {
									$ver_auxiliares .=$array_sin_espacios[$aumentar].",";
								}

								$aumentar ++;
							}
						}


						$update_balance = "UPDATE balance_gastos_operacion SET apartado_usado = '$ver_auxiliares' WHERE idbalance_gastos_operacion = '$pasar_id_movimiento'";
						$result_balance = mysql_query($update_balance);

						$valor_funcion = ($result_balance == 1) ? "1" : "- Error al Actualizar en el Balance ya se encuentra el auxiliar <b>$auxiliares</b> <br>";


						return $valor_funcion;
					}


					function insert_auxiliares ($nombre, $idauxiliar_principales, $idlogistica, $fecha_movimiento, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado) {

						$query_aux_repetido = "SELECT * FROM balance_gastos_auxiliares WHERE visible = 'SI' and nombre = '$nombre' and idlogistica = '$idlogistica' ";
						$result_aux_repetido = mysql_query($query_aux_repetido);

						if (mysql_num_rows($result_aux_repetido) == 0) {

							$query_insert = "INSERT INTO balance_gastos_auxiliares (nombre, idauxiliar_principales, idlogistica, fecha_movimiento, visible, usuario_creador, fecha_creacion, fecha_guardado) VALUES ('$nombre','$idauxiliar_principales','$idlogistica','$fecha_movimiento','$visible','$usuario_creador','$fecha_creacion','$fecha_guardado')";

							$result_insert = mysql_query($query_insert);

							if ($result_insert == 1) {

								$resultado_insert = "";

							}else {

								$resultado_insert = "- Error al Insertar en la tabla Auxiliares. <br>";

							}

						}else {

							$resultado_insert = "- El auxiliar <b>$nombre</b> ya se encuentra agregado en la tabla <b>Auxiliares</b><br>";

						}

						return $resultado_insert;
					}



					if ($mensaje == "") {

						$ver_errores = "Sin Errores";

					}else {
						$ver_errores = $mensaje;
					}



					?>
					<script>

						var si_error_no = '<?php echo $ver_errores; ?>'

						var idlogistica = '<?php  echo $idlogistica_encriptada;?>'


						if (si_error_no == "Sin Errores") {

							$('#success_alert').show();
							redireccionPagina();

						}else if (si_error_no == "Fallo") {
							$('#fail_alert').show();

							redireccionPagina();

						}else{

							$('#alert_alert').show();

							$("#alert_alert").append(si_error_no);


							var create = `
							<div class="d-flex justify-content-center mt-4">
							<button class="btn btn-lg btn-primary" id="continuar">Continuar</button>
							</div>
							`;

							$("#alert_alert").append(create);
						}



						$(document).ready(function(){
							$("#continuar").click(function(){
								location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#dataTables-example1`);
							});

							$("#yes").click(function(){
								location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#dataTables-example1`);
							});

							$("#nel").click(function(){

								location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#dataTables-example1`);

							});
						});

						function redireccionPagina(){
							delayPagina();
							contadorRedirigir();
						}

						function delayPagina(){
							var delay = 5000;
							setTimeout(() => {
								location.replace(`orden_logistica_detalles.php?idib=${idlogistica}#dataTables-example1`);
							}, delay);
						}

						function contadorRedirigir(){
							$('.numero-contador').each(function () {
								$(this).prop('Counter', 5).animate(
								{
									Counter: $(this).text()
								},
								{
									duration: 5000,
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
