<?php 
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s"); 
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 

$random = rand(5, 15);


$fecha_actual = date("l"); 

#-------------------------------------------Funcion Nombres y Tipo--------------------------------------------------------------------------------
$recibido = trim($_REQUEST["vn"]);

$idc=base64_decode($recibido);

$vin_trim = trim($idc);

date_default_timezone_set('America/Mexico_City');
$fecha_actual = date("l");


$query_vin = "SELECT * FROM catalogo_unidades_utilitarios WHERE TRIM(vin) = '$vin_trim'";
$result_vin = mysql_query($query_vin);

if (mysql_num_rows($result_vin) >= 1) {

	while ($row_vin = mysql_fetch_array($result_vin)) {

		$idcatalogo_unidades_utilitarios = trim($row_vin[idcatalogo_unidades_utilitarios]);
		$marca = trim($row_vin[marca]);
		$version = trim($row_vin[version]);
		$color = trim($row_vin[color]);
		$modelo = trim($row_vin[modelo]);
		$km = trim($row_vin[km]);
		$transmicion = trim($row_vin[transmicion]);
		$vin = trim($row_vin[vin]);
		$matricula = trim($row_vin[matricula]);
		$entidad = trim($row_vin[entidad]);
		$pelicula_antiasalto = trim($row_vin[pelicula_antiasalto]);
		$fecha_instalacion = trim($row_vin[fecha_instalacion]);
		$tipo_uso = trim($row_vin[tipo_uso]);
		$fecha_contratacion_seguro = trim($row_vin[fecha_contratacion_seguro]);
		$vigencia = trim($row_vin[vigencia]);
		$tenencias = trim($row_vin[tenencias]);
		$tarjeta_circulacion = trim($row_vin[tarjeta_circulacion]);
		$fecha_apertura = trim($row_vin[fecha_apertura]);
		$fecha_ingreso = trim($row_vin[fecha_ingreso]);
		$fecha_ingreso_taller = trim($row_vin[fecha_ingreso_taller]);
		$fecha_salida_piso = trim($row_vin[fecha_salida_piso]);
		$dias_inventario = trim($row_vin[dias_inventario]);
		$indice_impuestos = trim($row_vin[indice_impuestos]);
		$tipo_compra = trim($row_vin[tipo_compra]);
		$precio_compra = trim($row_vin[precio_compra]);
		$costo_total = trim($row_vin[costo_total]);
		$tipo_venta = trim($row_vin[tipo_venta]);
		$estatus_unidad = trim($row_vin[estatus_unidad]);
		$ubicacion = trim($row_vin[ubicacion]);
		$comentario = trim($row_vin[comentario]);
		$visible = trim($row_vin[visible]);


		if (is_numeric($row_vin[comentario])) {
			$query_responsable = "SELECT * FROM empleados where idempleados = '$row_vin[comentario]'";
			$result_responsable = mysql_query($query_responsable);
			while ($row_responsable = mysql_fetch_array($result_responsable)) {
				$responsable = $row_responsable[columna_b];
			}
		}else{
			$responsable = $row_vin[comentario];
		}

		$detalle_unidad = "<tr>
		<td>Marca</td>
		<td><b>$marca</b></td>
		<td>Versión</td>
		<td><b>$version</b></td>
		</tr>

		<tr>
		<td>Color</td>
		<td><b>$color</b></td>
		<td>Modelo</td>
		<td><b>$modelo</b></td>
		</tr>

		<tr>
		<td>Matrícula</td>
		<td id='matricula_vin'><b>$matricula</b></td>
		<td>Transmición</td>
		<td><b>$transmicion</b></td>
		</tr>

		<tr>
		<td>Entidad</td>
		<td><b>$entidad</b></td>
		<td>Engomado</td>
		<td id='engomado_vin'><b>$tipo_uso</b></td>
		</tr>

		";

	}

}else{

	$buscar_vin =  date_vin($vin_trim);
	$porciones_vin = explode("|", $buscar_vin);




	$vin = $porciones_vin[0];

	$marca = $porciones_vin[1];
	$version = $porciones_vin[2];
	$color = $porciones_vin[3];
	$modelo = $porciones_vin[4];
	$matricula = "Pendiente";
	$transmicion = "Pendiente";
	$entidad = "Pendiente";
	$tipo_uso = "Pendiente";

	$detalle_unidad = "<tr>
	<td>Marca</td>
	<td><b>$marca</b></td>
	<td>Versión</td>
	<td><b>$version</b></td>
	</tr>

	<tr>
	<td>Color</td>
	<td><b>$color</b></td>
	<td>Modelo</td>
	<td><b>$modelo</b></td>
	</tr>

	<tr>
	<td>Matrícula</td>
	<td id='matricula_vin'><b>$matricula</b></td>
	<td>Transmición</td>
	<td><b>$transmicion</b></td>
	</tr>

	<tr>
	<td>Entidad</td>
	<td><b>$entidad</b></td>
	<td>Engomado</td>
	<td id='engomado_vin'><b>$tipo_uso</b></td>
	</tr>

	";
}

$arr_matricula = str_split($matricula);

foreach ($arr_matricula as $valor_matricula) {
	
	if (is_numeric($valor_matricula)) {
		$var_matricula_numero .= $valor_matricula;
	}
}


$ultimo_digito = (is_numeric($var_matricula_numero))? substr($var_matricula_numero, -1) : "N" ;



//echo "string:$ultimo_digito";


if ($fecha_actual == "Monday") {

	$ver_error = validar_entrada($fecha_actual, $ultimo_digito ,"5", "6", $tipo_uso, "AMARILLO");

}else if ($fecha_actual == "Tuesday") {

	$ver_error = validar_entrada($fecha_actual, $ultimo_digito ,"7", "8", $tipo_uso, "ROSA");

}else if ($fecha_actual == "Wednesday") {

	$ver_error = validar_entrada($fecha_actual, $ultimo_digito ,"3", "4", $tipo_uso, "ROJO");

}else if ($fecha_actual == "Thursday") {

	$ver_error = validar_entrada($fecha_actual, $ultimo_digito ,"1", "2", $tipo_uso, "VERDE");

}else if ($fecha_actual == "Friday") {

	$ver_error = validar_entrada($fecha_actual, $ultimo_digito ,"9", "0", $tipo_uso, "AZUL");

}else if ($fecha_actual == "Saturday") {




}else if ($fecha_actual == "Sunday") {



}





function validar_entrada($fecha_hoy, $ultimo_digito ,$primer_numero, $segundo_numero, $color_traes, $color_restringido) {
	
	$fecha_hoy = trim($fecha_hoy);
	$ultimo_digito = trim($ultimo_digito);
	$primer_numero = trim($primer_numero);
	$segundo_numero = trim($segundo_numero);
	$color_traes = trim($color_traes);
	$color_restringido = trim($color_restringido);

	if (is_numeric($ultimo_digito)) {

		if ($ultimo_digito == $primer_numero || $ultimo_digito == $segundo_numero) {

			$result_validar .= "Hoy NO circulan <b>$primer_numero $segundo_numero</b> y tu último dígito númerico es: <b>$ultimo_digito</b><br>|";

			if ($color_traes == $color_restringido) {

				$result_validar .= "Hoy NO circula engomado de color: <b>$color_restringido</b><br>|";

			}elseif ($color_traes == "") {

				$result_validar .= "Puedes Circular con permiso<br>|";
			}

		}elseif ($ultimo_digito == "") {

			$result_validar .= "Puedes Circular con permiso<br>|";

			if ($color_traes == $color_restringido) {

				$result_validar .= "Hoy NO circula engomado de color: <b>$color_restringido</b><br>|";

			}elseif ($color_traes == "") {

				$result_validar .= "Puedes Circular con permiso<br>|";
			}

		}else{

			if ($color_traes == $color_restringido) {

				$result_validar .= "Hoy NO circula engomado de color: <b>$color_restringido</b><br>|";

			}elseif ($color_traes == "") {

				$result_validar .= "Puedes Circular con permiso<br>|";
			}
		}

	}elseif ($ultimo_digito == "") {

		$result_validar .= "Pendiente<br>|";

	} else{

		$result_validar .= "Pendiente<br>|";

	}



	$ver_resultado = explode("|", $result_validar);
	$ver_resultado_unico = array_unique($ver_resultado);



	foreach ($ver_resultado_unico as $key => $value) {

		if ($value != "") {

			$resultado_final .= $value."|";
		}
	}

	$resultado_final = substr($resultado_final, 0, -1);

	

	return $resultado_final;
}






$uno = $ver_error;

if (trim($uno) == "") {
	
	$valor_final = 1;	

}else{
	
	$dos = explode("|", $uno);

	if (count($dos) > 0) {

		foreach ($dos as $key_uno => $val_array) {

			if ($val_array != "") {

				$valor_final .= $val_array;
			}
		}

	}else {

		$valor_final = 1;

	}
}

if ($valor_final == "") {
	$valor_final = 1;	
}else {
	$valor_final = $valor_final;
}


echo $valor_final;


$query_vin_fotos = "SELECT * FROM publicacion_vin_fotos WHERE visible = 'SI' and ruta_foto like '%$vin%' and tipo = 'Principal'";
$result_vin_fotos = mysql_query($query_vin_fotos);

if (mysql_num_rows($result_vin_fotos) >= 1) {

	while ($row_vin_fotos = mysql_fetch_array($result_vin_fotos)) {
		$ruta_vin_fotos = "$row_vin_fotos[ruta_foto]";
	}
}else{
	$ruta_vin_fotos = "../../Sesion_VIN/blanco.jpeg";
}



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

	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/quicksand.css">
	<link rel="stylesheet" href="../../assets/css/style.css">
	<link rel="stylesheet" href="../../assets/css/mod_style_datatables.css">
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

	<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
	<script src="../../js/jquery-1.10.2.js"></script>
	<script src="../../js/jquery-ui.js"></script>

	<!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
	-->
	

	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.date.css">
	<link rel="stylesheet" href="../../datapicker_moder/lib/compressed/themes/default.time.css">
	<title>CCP | Detalle de Unidad</title>

	<style>
	.red {
		background-color: #d1ecf1 !important;
	}
	.img-circula{
		width: 700px;
	}

	@media (max-width: 767px){
		.img-circula{
			width: 100%;
		}
	}

	#columna{
		overflow: auto;
		margin: 5px;
		width: 100%;
		height: 500px; /*establece la altura máxima, lo que no entre quedará por debajo y saldra la barra de scroll*/
	}
</style>

</head>
<body>



	<div class="container-fluid p-0">
		<?php 
		include_once "menu.php"; 
		?>
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
								<a class="text-white" href="detalle_utilitarias.php">Resumen Unidades Utilitarias</a>
							</li>
							<span class="text-white"> &nbsp;/&nbsp; </span>
							<li class="active text-white">
								<strong><a class="text-white d-flex align-items-center" data-toggle="modal" data-target="#info_vin"> <i class="fas fa-edit fa-2x"></i>&nbsp;Detalle Unidad Utilitaria</a></strong>
							</li>
						</ol>

						<br>
						
						<div class="col-lg-12 imagen-perfil">
							<center>
								<h2 class="text-ids-1"><?php echo $vin; ?></h2>



								<?php

								echo "<img alt='image' width='100' height='100' class='img-circle' src='$ruta_vin_fotos'>";

								?>
								<br><br>
								<h2><?php echo $responsable; ?></h2>
							</center>
						</div>


						<div class="container-bg-1 p-3">
							<div class="table-responsive">
								<table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table mb-0" id="table_liberar_personal">
									<tbody>  
										<?php
										echo $detalle_unidad;
										?>
									</tbody >
								</table>
							</div>
						</div>							

						<div class="row mt-4">
							<div class="hr-line-dashed"></div>
							<div class="col-sm-12 alert alert-success" role="alert" id="circulas_si" style="display: none;">

								<center>
									<h1>Hoy Circulas!!</h1>
								</center>
							</div>

							<div class="col-sm-12 alert alert-danger" role="alert" id="circulas_no" style="display: none;" >

								<center>
									<div id="add_valores">

									</div>
								</center>

							</div>

							<div class="col-sm-12 alert alert-warning" role="alert" id="circulas_pendiente" style="display: none;">
								
								<center>
									<h1>PENDIENTE</h1>
								</center>
							</div>



							<div class="col-sm-12">
								<center>
									<picture>
										<img src="circula.png" id="cdmx_nocircula" alt="Hoy no Circula CDMX" class="img-circula">
									</picture>
								</center>
							</div>


							<!-- ******************************Detalle Utilitario****************************************** -->
							<div class="modal fade" id="info_vin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">EDITAR INFORMACIÓN</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<form action="update_utilitarias.php" method="POST" >

												<?php
												date_default_timezone_set('America/Mexico_City');
												$fecha_creacion = date("Y-m-d H:i:s");
												?>

												<div class="form-group">
													<label for="recipient-name" class="col-form-label">Vin:</label>
													<input type="text" class="form-control" name="vin" id="recipient-name" value="<?php echo $vin; ?>" readonly=""  >
												</div>

												<div class="form-group">
													<label for="matricula" class="col-form-label">Matrícula:</label>
													<input type="text" class="form-control" id="matricula" name="matricula" value="<?php echo $matricula; ?>" onKeyUp="mayus(this);" >
												</div>

												<div class="form-group">
													<label for="entidad" class="col-form-label">Entidad:</label>
													<input type="text" class="form-control" id="entidad" name="entidad" list="entidades" value="<?php echo $entidad ?>" required="" onKeyUp="mayus(this);" >
													<datalist id="entidades">
														<?php
														$query_entidad = "SELECT entidad FROM catalogo_unidades_utilitarios GROUP BY entidad";
														$result_entidad = mysql_query($query_entidad);
														while ($row_entidad = mysql_fetch_array($result_entidad)) {
															echo "<option value='$row_entidad[entidad]'></option>";
														}

														?>
													</datalist>

												</div>

												<div class="form-group">
													<label for="engomado" class="col-form-label">Engomado:</label>
													<input type="text" class="form-control" id="engomado" name="engomado" list="engomadoes" value="<?php echo $tipo_uso  ?>" required="" onKeyUp="mayus(this);" >
													<datalist id="engomadoes">
														<?php
														$query_engomado = "SELECT tipo_uso FROM catalogo_unidades_utilitarios GROUP BY tipo_uso";
														$result_engomado = mysql_query($query_engomado);
														while ($row_engomado = mysql_fetch_array($result_engomado)) {
															echo "<option value='$row_engomado[tipo_uso]'></option>";
														}

														?>
													</datalist>

												</div>

												<div class="form-group">
													<label>Ejecutivo Asignado</label>
													<input placeholder="Buscar" class="form-control" type="text" name="busqueda_trasladista" id="busqueda_trasladista2" maxlength="25" autocomplete="off" onKeyUp="buscar_trasladista2();" size="19" width="300%" />
													<center>
														<div id="resultadoBusquedaTrasladista2" style="display: none" class="efecto-busqueda mt-4"></div>
													</center>
												</div>

												<div class="form-group">
													<label form="trasladista">*Ejecutivo </label>
													<input class="form-control" type="text"  name="trasladista" id="trasladista2" readonly="" value="<?php echo $responsable; ?>" />
												</div>

												<div class="form-group">
													<label for="comentarios" class="col-form-label">Comentarios:</label>
													<textarea class="form-control" id="comentarios" name="comentarios" required=""></textarea>
												</div>

												<input type="hidden" id="id_trasladista2" name="id_trasladista" value='<?php echo "$comentario"; ?>'>
												<input type="hidden" id="tipo_trasladista2" name="tipo_trasladista" value='<?php echo "$comentario"; ?>'>
												<input type="hidden" id="fecha_creacion" name="fecha_creacion" value='<?php echo "$fecha_creacion"; ?>'>

												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar Ventana</button>
													<button type="submit" class="btn btn-primary">Actualizar Utilitario</button>
												</div>

											</form>
										</div>

									</div>
								</div>
							</div>


							<hr>
							<div class="col-sm-12 form-group p-4">
								<h3 class="m-t-none m-b" style="font-size: 20px; border-bottom: 2px solid #882439; color: #d43759;"><strong>Historial de Combustible</strong></h3>
							</div>

							<div class="col-sm-12">
								<div class="container-bg-1 p-3">
									<div class="table-responsive">
										<table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="table_gastos_combustible">
											<thead>
												<tr>
													<th>#</th>
													<th>Concepto</th>
													<th>Fecha Movimiento</th>
													<th>Responsable</th>
													<th>No. Logistica</th>
													<th>Total</th>
													<th>Evidencia</th>
													<th>Tarjeta</th>
													<th>Kilometraje</th>
													<th>Evidencia</th>
													<th>Kilometros Aprox</th>
												</tr>
											</thead>
											<tbody>

												<?php
												$inccrementar_combustible = 0;

												$query_balance = "SELECT * FROM balance_gastos_operacion WHERE datos_vin = '$vin_trim' and visible = 'SI' and tipo_movimiento = 'cargo' and concepto = 'CARGA DE COMBUSTIBLE'";
												$result_balance = mysql_query($query_balance);

												while ($row_balance = mysql_fetch_array($result_balance)) {
													$inccrementar_combustible++;
													$idbalance_gastos_operacion = "$row_balance[idbalance_gastos_operacion]";
													$concepto = "$row_balance[concepto]";
													$fecha_movimiento_balance = "$row_balance[fecha_movimiento]";
													$responsable = "$row_balance[responsable]";
													$num_logistica = "$row_balance[columna2]";
													$evidencia_combustible = "$row_balance[archivo]";
													$number_card = "$row_balance[comision]";


													$query_asignado = "SELECT * FROM empleados  WHERE idempleados = '$responsable'";
													$result_asignado = mysql_query($query_asignado);
													while ($row_asignado = mysql_fetch_array($result_asignado)) {
														$responsable_balance = "$row_asignado[columna_b]";
													}

													$query_total = "SELECT sum(monto_total) FROM balance_gastos_operacion WHERE columna2 = '$num_logistica' and visible = 'SI' and tipo_movimiento = 'cargo' and concepto = 'CARGA DE COMBUSTIBLE' and datos_vin = '$vin_trim'";
													$result_total = mysql_query($query_total);

													while ($row_total = mysql_fetch_array($result_total)) {
														$monto_total_combustible = "$".number_format("$row_total[0]", 2);
													}

													if ($evidencia_combustible == null || $evidencia_combustible == "" || $evidencia_combustible == "Pendiente") {
														$evidencia_gasolina = "S/N Evidencia";
													}else{
														$evidencia_gasolina = "<a href='$evidencia_combustible' target='_blank'><i class='fa fa-picture-o' aria-hidden='true'></i></a>";
													}

													$query_logistica = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$num_logistica'";
													$result_logistica = mysql_query($query_logistica);

													while ($row_logistica = mysql_fetch_array($result_logistica)) {

														$km = "$row_logistica[kilometros]";
														$quitar_km = explode("km", $km);
														$quitar_coma = str_replace(",",".",$quitar_km[0]);
														$km_aprox = $quitar_coma * 2;
													}

													$query_km = "SELECT * FROM unidades_utilitarios_km WHERE id_balance = '$idbalance_gastos_operacion' and visible = 'SI'";
													$result_km = mysql_query($query_km);

													while ($row_km = mysql_fetch_array($result_km)) {
														$kilometraje = "$row_km[kilometraje]";
														$kilometraje_evidencia = "$row_km[archivo]";

													}

													$logistica_encriptada = base64_encode($num_logistica);
													$balance_encriptada = base64_encode($idbalance_gastos_operacion);
													$fecha_encriptada = base64_encode($fecha_movimiento_balance);

													if ($kilometraje == "" ) {
														$acciones = "<a href='carga_km.php?vn=$recibido&log=$logistica_encriptada&bal=$balance_encriptada&mov=$fecha_encriptada'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>";
														$evidencia_kilometraje = "En Espera";
													}else{

														$acciones = $kilometraje;
														$evidencia_kilometraje = "<a href='$kilometraje_evidencia' target='_blank'><i class='fa fa-picture-o' aria-hidden='true'></i></a>";


													}



													echo "<tr class='odd gradeX'>
													<td>$inccrementar_combustible</td>
													<td>$concepto</td>
													<td>$fecha_movimiento_balance</td>
													<td>$responsable_balance</td>
													<td>$num_logistica</td>
													<td>$monto_total_combustible</td>
													<td>$evidencia_gasolina</td>
													<td>$number_card</td>
													<td>$acciones</td>
													<td>$evidencia_kilometraje</td>
													<td>$km_aprox Km</td>
													</tr>";
												}
												?>
											</tbody>
											<tfoot>
												<tr>
													<th colspan="4" style="text-align:right">Total:</th>
													<th colspan="7"></th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="sec-datos col-sm-12 mt-4">
							<br>
							<h6 class="mb-3">Seguimientos:</h6>

							<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border" id="columna">

								<hr>
								<div class="feed-single mb-3">
									<?php
									$sql20 = "SELECT * FROM catalogo_unidades_utilitarios_bitacora WHERE TRIM(vin) = '$idc' and visible = 'SI' ORDER BY idcatalogo_unidades_utilitarios_bitacora DESC";
									$result20=mysql_query($sql20);
									while ( $fila10 = mysql_fetch_array($result20)) {
										$tipo = "$fila10[tipo]";
										$comentarios = "";
										$f_olb = date_create("$fila10[fecha_guardado]");
										$fecha_bitacora = date_format($f_olb, 'd-m-Y H:i');
										$user = "$fila10[usuario_creador]";

										$sql22= "SELECT *FROM usuarios WHERE idusuario='$user' ";
										$result22=mysql_query($sql22);
										while ( $fila22 = mysql_fetch_array($result22)) {
											$nombre_usuario="$fila22[nombre_usuario]";
											$sigla_ccp="$fila22[sigla_ccp]";
											$foto_perfil="$fila22[foto_perfil]";
										}


										$direccion_archivo=null;
										if ($tipo=="Matrícula") {
											$color = "color:#898584;";
											$icono_chat="fa fa-th";
										}else if ($tipo=="Entidad") {
											$color = "color:green;";
											$icono_chat="fa fa-map";
										}else if ($tipo=="Engomado") {
											$color = "color:red;";
											$icono_chat="fa fa-microchip";
										}else if ($tipo=="Propietario") {
											$color = "color:#ff520b;";
											$icono_chat="fa fa-user-plus";
										}else if ($tipo=="GPS") {
											$color = "color:#ff520b;";
											$icono_chat="fas fa-globe fa-1.5x";
										}else{
											$icono_chat="fa fa-question-circle-o";
											$color = "color:red;";
										}
										$idcn=base64_encode($idcontacto);
										if ($archivo=="") {
											$icono_evidencia="fa fa-upload";
											$direccion_archivo_="<br>Evidencias: <a href='subir_archivo_evidencia.php?idev=$idactividades&idse=$idactividades_seguimiento'><i class='$icono_evidencia'></a></i>";
										}else{
											$direccion_archivo_="<br>Evidencias: <a href='$archivo' target='_blank'><i class='$icono_evidencia'></a></i>";
										}





										echo "
										<div class='media'>
										<img class='mr-3 rounded-circle' height='40px' width='40px' src='$foto_perfil'>
										<div class='media-body'>
										<h6 class='mt-1'><i class='$icono_chat'></i> $tipo
										<small class='text-muted small pull-right'><i class='fa fa-clock'></i>$fecha_bitacora</small>

										<br>
										$fila10[descripcion]
										<br>
										$fila10[comentarios]

										<p class='clearfix'></p>
										</h6>
										<p>$nombre_usuario</p>

										<div class='feed-footer'>


										<span class='pr-3'>$fecha_bitacora</span>
										<span class='pr-3'>$direccion_archivo</span>

										</div>
										</div>
										</div> <hr>";
									}
									?>


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

<script>

	$(document).ready(function() {

		var ver_valores = '<?php echo $valor_final;?>'

		if (ver_valores == "1") {

			$("#circulas_si").show();

		}else if (ver_valores == "Puedes Circular con permiso<br>") {
			
			$("#circulas_pendiente").show();

		}else {
			
			$("#circulas_no").show();
			$("#add_valores").html(ver_valores);

		}
		


	});

</script>






<script>


	$('#fecha_a').pickadate({
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
        // disable: [
        // 1,2,3, 4,5,6
        // ]
    });

	$('#fecha_vencimiento').pickadate({
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
        // disable: [
        // 1,2,3, 4,5,6
        // ]
    });





</script>





<script>

	function buscar_trasladista2() {
		var textoBusquedaAsesor = $("#busqueda_trasladista2").val();
		if (textoBusquedaAsesor != "") {
			$.post("buscar_responsable_monedero.php", {valorBusqueda: textoBusquedaAsesor}, function(mensaje_asesor) {
				$("#resultadoBusquedaTrasladista2").html(mensaje_asesor);
				if (mensaje_asesor==" <b>Asesor NO Encontrado</b>") {
					$("#trasladista2").attr("readonly","readonly");
					$("#resultadoBusquedaTrasladista2").show();
				}else{
					$("#resultadoBusquedaTrasladista2").show();
					$("#trasladista2").attr("readonly","readonly");
				}
			});
		} else {
			$("#resultadoBusquedaTrasladista2").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
		};
	};
	$(document).on('click', '.sugerencias_asesor', function (event) {
		event.preventDefault();
		aux_recibido=$(this).val();
		var porcion = aux_recibido.split(';');
		unidad_id_asesor=porcion[0];
		unidad_nomenclatura=porcion[1];
		tipo_solicitante=porcion[2];

		$("#resultadoBusquedaTrasladista2").hide();
		$("#busqueda_trasladista2").val("");
		$("#id_trasladista2").val(unidad_id_asesor);
		$("#trasladista2").val(unidad_nomenclatura);
		$("#tipo_trasladista2").val(tipo_solicitante);
		$("#resultadoBusquedaTrasladista2").html("");
	});







</script>


<script>

	var formatNumber = {
 separador: ",", // separador para los miles
 sepDecimal: '.', // separador para los decimales
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

$('#table_gastos_combustible').DataTable({
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

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
            	return typeof i === 'string' ?
            	i.replace(/[\$,]/g, '')*1 :
            	typeof i === 'number' ?
            	i : 0;
            };

            // Total over all pages
            total = api
            .column( 5 )
            .data()
            .reduce( function (a, b) {
            	return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotal = api
            .column( 5, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
            	return intVal(a) + intVal(b);
            }, 0 );

            // Update footer
            

            $( api.column( 5 ).footer() ).html(
            	'$ '+formatNumber.new(pageTotal.toFixed(2))+' (Saldo Total: $ '+formatNumber.new(total.toFixed(2))+' )'
            	);
        },
        responsive: true,
        lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
        dom: 'Blfrtip',
        buttons: [
        'copy', 'excel'
        ],

    });

var table = $('#table_gastos_combustible').DataTable();

table
.order([ 0, 'asc' ])
.draw();


function mayus(e) {
	e.value = e.value.toUpperCase();
}


</script>



</body>
</html>