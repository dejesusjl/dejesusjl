<?php
include_once "../../config.php";  



date_default_timezone_set('America/Mexico_City');
$fecha_hoy = date("Y-m-d");
$fecha_ayer = date("Y-m-d",strtotime($fecha_hoy."- 50 days")); 
$fecha_manana =  date("Y-m-d",strtotime($fecha_hoy."+ 1 days"));

$q = trim($_POST['valorHerramienta']);
$okkk = $_POST['contador_nuevo_vin'];
$id_id_contacto = $_POST['id_id_cliente'];
$id_id_departamento = $_POST['id_id_departamento'];
$type_orden = $_POST['type_orden'];
$rol_rol_vin = $_POST['rol_rol_vin'];

$okkk = ($okkk == "" || $okkk == null ) ? "0" : $okkk;

// echo $id_id_contacto = "5606";
// echo "<br>";
// echo $q= "np"; 
// echo "<br>";
// echo $id_id_departamento = "22";
// echo "<br>";
// echo $type_orden = "1";
// echo "<br>";
// echo $rol_rol_vin = "Entrega de Unidad";
// echo "<br>";

#echo "VIN:$q<br>Count:$okkk<br>id:$id_id_contacto<br>departamento:$id_id_departamento<br>Tordende:$type_orden<br>RolVin:$rol_rol_vin<br>";

$query_rol_vin = "SELECT * FROM orden_logistica_rol_vin WHERE visible = 'SI' and trim(nombre) = '$rol_rol_vin' ";
$result_rol_vin = mysql_query($query_rol_vin);

if (mysql_num_rows($result_rol_vin) >= 1) {

	while ($row_rol_vin = mysql_fetch_array($result_rol_vin)) {

		$ver_functions = explode("|", $row_rol_vin[columna_a]);
		

		foreach ($ver_functions as $key => $valor_array) {

			if ($valor_array != "") {

				if ($valor_array == "entrega_vin") {

					$mensaje = entregaVIN($q, $id_id_contacto, $fecha_ayer, $fecha_manana, $okkk);

				}else if ($valor_array == "recepcion_vin") {

					$mensaje = recepcionVIN($q, $fecha_ayer, $fecha_manana, $okkk);

				}else if ($valor_array == "unidades_inventario") {

					$condicion_inventario =	"estatus_unidad <> 'Utilitaria' and vin_numero_serie <> '' and visible = 'SI' and trim(estatus_unidad) <> 'Vendido' and ";
					$mensaje = unidadesInventario ($condicion_inventario, $q, $okkk);

				}else if ($valor_array == "unidades_utilitarias") {
					
					$mensaje = unidadesUtilitarias($q, $okkk);

				}else {

					echo "<b>VIN NO Encontrado</b>";

				}

			}
		}
	}

}else{

	echo "<b>VIN NO Encontrado</b>";

}





#------------------------------------------Entrega VIN Estado Cuenta---------------------------------------------------------------------------------

function entregaVIN($vin_entrada, $id_id_contacto, $fecha_ayer, $fecha_manana, $okkk) {

	//Condicion para buscar el VIN
	$condicion_vin_edo_cuenta = "visible = 'SI ' AND fecha_movimiento between '$fecha_ayer' and '$fecha_manana' AND idcontacto = '$id_id_contacto' and (concepto = 'Venta Directa' || concepto = 'Venta Permuta' ) and ";

	//Buscamos VIN, Marca, Version, Color, Modelo
	$buscar_vin_edo_cuenta = BusquedaVinEdoCuenta ($vin_entrada, $condicion_vin_edo_cuenta, $okkk);
	//echo "<br>";
	if ($buscar_vin_edo_cuenta == "EL VIN no se encuentra en el estado de cuenta") {
		$valor_entrega = $buscar_vin_edo_cuenta;
	}else {

		$porcion_vin_edo_cuenta = explode("|", $buscar_vin_edo_cuenta);

		foreach ($porcion_vin_edo_cuenta as $key_edo_cuenta => $value_edo_cuenta) {

			if ($value_edo_cuenta != "") {
				//echo "<br>$value_edo_cuenta<br>";
				// Generamos la condicion
				$condicion_edo_cuenta = "
				visible = 'SI' and trim(datos_vin) = '$value_edo_cuenta' and idcontacto = '$id_id_contacto' and fecha_movimiento between '$fecha_ayer' and '$fecha_manana' and (concepto = 'Venta Directa' || concepto = 'Venta Permuta' )";
				// Verificamos que este cargado en estado de Cuenta
				$verificar_venta = vin_estado_cuenta($condicion_edo_cuenta);
				//echo "<br>";
				if ($verificar_venta == 1) {

					$condicion_inventario =	"estatus_unidad <> 'Utilitaria' and vin_numero_serie <> '' and ";

					$valor_entrega .= unidadesInventario ($condicion_inventario, $value_edo_cuenta, $okkk);

				}else {
					$valor_entrega = "<b>VIN NO Encontrado</b>";
				}

			}
		}
	}




	return $valor_entrega;

}

#------------------------------------------Busqueda VIN Estado Cuenta---------------------------------------------------------------------------------

function BusquedaVinEdoCuenta ($vin_edocuenta, $condicion, $okkk) {

	$query_vin_edo_cuenta = "SELECT * FROM estado_cuenta WHERE $condicion (datos_vin LIKE '%".$vin_edocuenta."%' || datos_marca LIKE '%".$vin_edocuenta."%' || datos_version LIKE '%".$vin_edocuenta."%' ||  datos_color LIKE '%".$vin_edocuenta."%' ||  datos_modelo LIKE '%".$vin_edocuenta."%')";
	$result_vin_edo_cuenta = mysql_query($query_vin_edo_cuenta);

	if (mysql_num_rows($result_vin_edo_cuenta) == 0) {
		$valor_vin_edo_cuenta = "EL VIN no se encuentra en el estado de cuenta";

	}else {

		while ($row_vin_edo_cuenta = mysql_fetch_array($result_vin_edo_cuenta)) {

			$valor_vin_edo_cuenta .= trim($row_vin_edo_cuenta[datos_vin])."|";

		}

	}
	return $valor_vin_edo_cuenta;

}

#------------------------------------------Recepcion VIN Estado Cuenta, Estado Cuenta Proveedores---------------------------------------------------------------------------------

function recepcionVIN($vin_recibe, $fecha_ayer, $fecha_manana, $okkk) {
	

	//Condicion para buscar la unidad
	$condicion_inventario = "estatus_unidad <> 'Utilitaria' and vin_numero_serie <> '' and ";

	//Verificamos si la unidad ya esta en compra permuta
	$condicion_compra_permuta = "trim(datos_vin) like '%$vin_recibe%' and concepto = 'Compra Permuta' and visible = 'SI'";
	$result_compra_permuta = vin_estado_cuenta($condicion_compra_permuta);

	if ($result_compra_permuta == "1") {
		//echo "<br>Compra Permuta<br>";
		//Verificamos que no tenga adeudo la unidad
		$condicion_edo_cuenta = "trim(datos_vin) like '%$vin_recibe%' and datos_estatus = 'Pendiente' and visible = 'SI'";
		$result_adeudo = vin_estado_cuenta($condicion_edo_cuenta);

		if ($result_adeudo == 0) {
			//echo "<br>-Sin Adeudo<br>";
			$valor_recepcion = unidadesInventario($condicion_inventario, $vin_recibe, $okkk);

			if ($valor_recepcion == "<b>VIN NO Encontrado</b>") {

				$query_edo_cuenta = "SELECT * FROM estado_cuenta WHERE visible = 'SI' and trim(datos_vin) like '%$vin_recibe%'";
				$result_edo_cuenta = mysql_query($query_edo_cuenta);

				while ($row_edo_cuenta = mysql_fetch_array($result_edo_cuenta)) {

					if ($okkk > 0) {
						$valor_recepcion.="
						<div class='content-op-busqueda-2'>
						<i class='fas fa-car icon-busqueda'></i>
						<option class='sugerencias_herramienta$okkk efecto-sugerencia' value='$row_edo_cuenta[idestado_cuenta];$row_edo_cuenta[datos_vin];$row_edo_cuenta[datos_marca];$row_edo_cuenta[datos_version];$row_edo_cuenta[datos_color];$row_edo_cuenta[datos_modelo];Unidad'>$row_edo_cuenta[datos_vin] - $row_edo_cuenta[datos_marca]- $row_edo_cuenta[datos_version]- $row_edo_cuenta[datos_color]- $row_edo_cuenta[datos_modelo]</option>
						</div>
						";
					}else{
						$valor_recepcion.="
						<div class='content-op-busqueda-2'>
						<i class='fas fa-car icon-busqueda'></i>
						<option class='sugerencias_herramienta efecto-sugerencia' value='$row_edo_cuenta[idestado_cuenta];$row_edo_cuenta[datos_vin];$row_edo_cuenta[datos_marca];$row_edo_cuenta[datos_version];$row_edo_cuenta[datos_color];$row_edo_cuenta[datos_modelo];Unidad'>$row_edo_cuenta[datos_vin] - $row_edo_cuenta[datos_marca]- $row_edo_cuenta[datos_version]- $row_edo_cuenta[datos_color]- $row_edo_cuenta[datos_modelo]</option>
						</div>
						";
					}
					
				}
			}

		}else{
			$valor_recepcion = "<b>No se puede Recibir el VIN porque tiene un adeudo</b>";
		}

	}else{

		//echo "<br> Edo. Cuenta Prov <br>";
		$condicion_estado_cuenta_proveedores = "visible = 'SI' and concepto = 'Compra Directa' and datos_vin LIKE '%$vin_recibe%' ";
		$ver_edo_cuentas_proveedores = vin_estado_cuenta_proveedor($condicion_estado_cuenta_proveedores);

		if ($ver_edo_cuentas_proveedores == 1) {

			$ver_vin = unidadesInventario($condicion_inventario, $vin_recibe, $okkk);

			if ($ver_vin == "<b>VIN NO Encontrado</b>") {

				$valor_recepcion = inventarioLOGISTICA($vin_recibe, $okkk);

			}else{
				$valor_recepcion = $ver_vin;
			}


		}else{

			//Verificamos si la unidad existe o no en inventario, no se autoriza la unidad solo se le da a conocer que existe.
			$ver_existe = unidadesInventario($condicion_inventario, $vin_recibe, $okkk);

			if ($ver_existe == "<b>VIN NO Encontrado</b>") {
				
				echo $ver_existe_inv_log = inventarioLOGISTICA($vin_recibe, $okkk);

				if ($ver_existe_inv_log == "<b>VIN NO Encontrado</b>") {
					
					$valor_recepcion = "<b>VIN NO Encontrado</b>";
				}

			}else {
				$valor_recepcion = "<b>VIN existe pero no esta cargado en estado de cuenta.</b>";
			}			
		}

	}

	return $valor_recepcion;

}

#------------------------------------------ Estado Cuenta ---------------------------------------------------------------------------------

function vin_estado_cuenta($opciones_consulta) {

	$idvin = trim($idvin);
	$idclientevin = trim($idclientevin);

	$query_estado_cuenta = "SELECT *  FROM estado_cuenta WHERE $opciones_consulta ";
	$result_estado_cuenta = mysql_query($query_estado_cuenta);

	$result_estado_cuenta = (mysql_num_rows($result_estado_cuenta) >= 1)? "1" : "0" ;

	return $result_estado_cuenta;

}
#------------------------------------------ Estado Cuenta Proveedores---------------------------------------------------------------------------------

function vin_estado_cuenta_proveedor($opciones_consulta) {

	$idvin = trim($idvin);
	$idclientevin = trim($idclientevin);

	$query_estado_cuenta = "SELECT * FROM estado_cuenta_proveedores WHERE $opciones_consulta ";
	$result_estado_cuenta = mysql_query($query_estado_cuenta);

	$result_estado_cuenta = (mysql_num_rows($result_estado_cuenta) >= 1)? "1" : "0" ;

	return $result_estado_cuenta;

}




#------------------------------------------ Inventario ---------------------------------------------------------------------------------


function unidadesInventario ($condicion_inventario, $vin_busqueda, $okkk){

	$vin_busqueda = trim($vin_busqueda);

	$sql1 = "SELECT * from inventario WHERE $condicion_inventario (vin_numero_serie LIKE '%".$vin_busqueda."%' || marca LIKE '%".$vin_busqueda."%' || version LIKE '%".$vin_busqueda."%' ||  modelo LIKE '%".$vin_busqueda."%') LIMIT 10";
	//echo "<br>";
	$res1=mysql_query($sql1);

	if(mysql_num_rows($res1)>=1){

		while($fila1 = mysql_fetch_array($res1)){

			if ($okkk > 0) {
				$mensaje_inventario.="
				<div class='content-op-busqueda-2'>
				<i class='fas fa-car icon-busqueda'></i>
				<option class='sugerencias_herramienta$okkk efecto-sugerencia' value='$fila1[idinventario];$fila1[vin_numero_serie];$fila1[marca];$fila1[version];$fila1[color];$fila1[modelo];Unidad'>$fila1[vin_numero_serie] - $fila1[marca]- $fila1[version]- $fila1[color]- $fila1[modelo]</option>
				</div>
				";
			}else{
				$mensaje_inventario.="
				<div class='content-op-busqueda-2'>
				<i class='fas fa-car icon-busqueda'></i>
				<option class='sugerencias_herramienta efecto-sugerencia' value='$fila1[idinventario];$fila1[vin_numero_serie];$fila1[marca];$fila1[version];$fila1[color];$fila1[modelo];Unidad'>$fila1[vin_numero_serie] - $fila1[marca]- $fila1[version]- $fila1[color]- $fila1[modelo]</option>
				</div>
				";
			}


		}

	}else {

		$sql2 = "SELECT * from inventario_trucks WHERE $condicion_inventario ( vin_numero_serie LIKE '%".$vin_busqueda."%' ||  marca LIKE '%".$vin_busqueda."%' || version LIKE '%".$vin_busqueda."%' || modelo LIKE '%".$vin_busqueda."%') LIMIT 10";

		$res2=mysql_query($sql2);

		if(mysql_num_rows($res2) >=1){

			while($fila2 = mysql_fetch_array($res2)){

				if ($okkk > 0 ) {

					$mensaje_inventario.="
					<div class='content-op-busqueda-2'>
					<i class='fas fa-truck icon-busqueda'></i>
					<option class='sugerencias_herramienta$okkk efecto-sugerencia' value='$fila2[idinventario_trucks];$fila2[vin_numero_serie];$fila2[marca];$fila2[version];$fila2[color];$fila2[modelo];Trucks'>$fila2[vin_numero_serie] - $fila2[marca]- $fila2[version]- $fila2[color]- $fila2[modelo]</option>
					</div>
					";

				}else{
					$mensaje_inventario.="
					<div class='content-op-busqueda-2'>
					<i class='fas fa-truck icon-busqueda'></i>
					<option class='sugerencias_herramienta efecto-sugerencia' value='$fila2[idinventario_trucks];$fila2[vin_numero_serie];$fila2[marca];$fila2[version];$fila2[color];$fila2[modelo];Trucks'>$fila2[vin_numero_serie] - $fila2[marca]- $fila2[version]- $fila2[color]- $fila2[modelo]</option>
					</div>
					";
				}


			}

		}else{


			$mensaje_inventario = "<b>VIN NO Encontrado</b>";
		}

	}

	return $mensaje_inventario;

}

#------------------------------------------ Inventario Logistica---------------------------------------------------------------------------------

function inventarioLOGISTICA($vin_busqueda, $okkk) {
	$vin_busqueda = trim($vin_busqueda);

	$vinlogistica = "SELECT * FROM orden_logistica_inventario WHERE vin like '%".$vin_busqueda."%' and visible ='SI' || marca like '%".$vin_busqueda."%' and visible ='SI' || version like '%".$vin_busqueda."%' and visible ='SI' || color like '%".$vin_busqueda."%' and visible ='SI'";
	$result_vin_logistica = mysql_query($vinlogistica);

	if(mysql_num_rows($result_vin_logistica) >=1){

		while($vin_logistica = mysql_fetch_array($result_vin_logistica)){

			if ($okkk > 0 ) {

				$mensaje_inventario.="
				<div class='content-op-busqueda-2'>
				<i class='fas fa-car icon-busqueda'></i>
				<option class='sugerencias_herramienta$okkk efecto-sugerencia' value='$vin_logistica[idorden_logistica_inventario];$vin_logistica[vin];$vin_logistica[marca];$vin_logistica[version];$vin_logistica[color];$vin_logistica[modelo];Indefinido'>$vin_logistica[vin] - $vin_logistica[marca]- $vin_logistica[version]- $vin_logistica[color]- $vin_logistica[modelo]</option>
				</div>
				";

			}else{
				$mensaje_inventario.="
				<div class='content-op-busqueda-2'>
				<i class='fas fa-car icon-busqueda'></i>
				<option class='sugerencias_herramienta efecto-sugerencia' value='$vin_logistica[idorden_logistica_inventario];$vin_logistica[vin];$vin_logistica[marca];$vin_logistica[version];$vin_logistica[color];$vin_logistica[modelo];Indefinido'>$vin_logistica[vin] - $vin_logistica[marca]- $vin_logistica[version]- $vin_logistica[color]- $vin_logistica[modelo]</option>
				</div>
				";
			}


		}

	}else{
		$mensaje_inventario = "<b>VIN NO Encontrado</b>";
	}

	return $mensaje_inventario;
}



#------------------------------------------ Unidades Utilitarias---------------------------------------------------------------------------------

function unidadesUtilitarias($vin_busqueda, $okkk) {
	$vin_busqueda = trim($vin_busqueda);

	$vinutilitario = "SELECT * FROM catalogo_unidades_utilitarios WHERE visible = 'SI' AND (trim(vin) like '%$vin_busqueda%' || trim(marca) like '%$vin_busqueda%'  || trim(version) like '%$vin_busqueda%'  || trim(color) like '%$vin_busqueda%') ";
	$result_vin_utilitario = mysql_query($vinutilitario);

	if(mysql_num_rows($result_vin_utilitario) >=1){

		while($vin_utilitario = mysql_fetch_array($result_vin_utilitario)){

			if ($okkk > 0 ) {

				$mensaje_inventario.="
				<div class='content-op-busqueda-2'>
				<i class='fas fa-car icon-busqueda'></i>
				<option class='sugerencias_herramienta$okkk efecto-sugerencia' value='$vin_utilitario[idcatalogo_unidades_utilitarios];$vin_utilitario[vin];$vin_utilitario[marca];$vin_utilitario[version];$vin_utilitario[color];$vin_utilitario[modelo];Utilitario'>$vin_utilitario[vin] - $vin_utilitario[marca]- $vin_utilitario[version]- $vin_utilitario[color]- $vin_utilitario[modelo]</option>
				</div>
				";

			}else{
				$mensaje_inventario.="
				<div class='content-op-busqueda-2'>
				<i class='fas fa-car icon-busqueda'></i>
				<option class='sugerencias_herramienta efecto-sugerencia' value='$vin_utilitario[idcatalogo_unidades_utilitarios];$vin_utilitario[vin];$vin_utilitario[marca];$vin_utilitario[version];$vin_utilitario[color];$vin_utilitario[modelo];Utilitario'>$vin_utilitario[vin] - $vin_utilitario[marca]- $vin_utilitario[version]- $vin_utilitario[color]- $vin_utilitario[modelo]</option>
				</div>
				";
			}


		}

	}else{

		$mensaje_inventario = "<b>VIN NO Encontrado</b>";
	}

	return $mensaje_inventario;
}








echo $mensaje;
