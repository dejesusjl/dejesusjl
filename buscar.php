<?php
include_once "../../config.php";  
include_once "funciones_principales.php";  


$q = $_POST['valorBusqueda'];
$consulta_tipo = $_POST['valorSelect'];

/*echo $q = "Abel diaz";
$consulta_tipo = "Cliente";
echo "<br>";*/

if ($consulta_tipo == "logistica") {


	$query_orden = "SELECT * FROM orden_logistica WHERE idorden_logistica = '$q' order by idorden_logistica desc";
	
	$result_orden = mysql_query($query_orden);

	if(mysql_num_rows($result_orden) == 0){

		echo '<b class="text-noresults">Logística NO Encontrada</b>';

	}else{

		while($fila=mysql_fetch_array($result_orden)){

			echo $mensaje_logistica = Search_Logistics ("idl", "", "", $fila[idorden_logistica]);

		}

	}

}elseif ($consulta_tipo == "vin") {
	
	$query_vin = "SELECT * FROM orden_logistica_unidades where visible = 'SI' AND trim(vin) like '%$q%' order by idorden_logistica_unidades desc limit 10";
	$result_vin = mysql_query($query_vin);

	if(mysql_num_rows($result_vin) == 0){

		echo '<b class="text-noresults">VIN no encontrado</b>';

	} else {

		while ($row_vin = mysql_fetch_array($result_vin)) {

			echo $mensaje_vin = Search_Logistics ("idl", "", "", $row_vin[idorden_logistica]);
		}
	} 

}elseif ($consulta_tipo == "ejecutivo"){

	$query_trasladista = "SELECT * FROM empleados where nombre LIKE '%$q%' || apellido_materno LIKE '%$q%' || apellido_paterno LIKE '%$q%' || columna_b LIKE '%$q%' limit 10";
	$result_trasladista = mysql_query($query_trasladista);

	if(mysql_num_rows($result_trasladista) == 0){

		echo '<b class="text-noresults">Ejecutivo no encontrado</b>';

	} else {
		while ($row_trasladista = mysql_fetch_array($result_trasladista)) {

			$query_ejecutivo = " SELECT * FROM orden_logistica where (idasigna = '$row_trasladista[idempleados]' and tipo_asignante = 'Colaborador' || idorden_logistica IN (SELECT idorden_logistica From orden_logistica_ayudante WHERE (id_colaborador_proveedor LIKE '$row_trasladista[idempleados]') and visible = 'SI' and tipo = 'Colaborador' )) order by idorden_logistica desc limit 10";

			$result_ejecutivo = mysql_query($query_ejecutivo);

			while ($row_ejecutivo =mysql_fetch_array($result_ejecutivo)) {

				echo $mensaje_vin = Search_Logistics ("idl", "", "", $row_ejecutivo[idorden_logistica]);
			}

		}
	}

}elseif ($consulta_tipo == "Cliente") {

#------------------------------------------------- CLIENTE ------------------------------------------------- ------------------------------------------------- -------------------------------------------------  
	$sql = "SELECT * FROM contactos WHERE trim(nombre) LIKE '%$q%' ||  trim(apellidos) LIKE '%$q%' ||  trim(alias) LIKE '%$q%' ||  trim(telefono_celular) LIKE '%$q%'  ||  trim(telefono_otro) LIKE '%$q%' || trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' || trim(concat_ws(' ', apellidos, nombre)) LIKE '%$q%' || idcontacto = '$q' limit 5";
	$res = mysql_query($sql);
	
	if (mysql_num_rows($res) >=1) {

		while($fila = mysql_fetch_array($res)){
			
			echo $mensaje_contactos = Search_Logistics ("ID", $fila[idcontacto], "Cliente", $q);

		}
	}
#------------------------------------------------- PROVEEDOR ------------------------------------------------- ------------------------------------------------- -------------------------------------------------  
	$sql1 = "SELECT * FROM proveedores WHERE visible = 'SI' and (trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(telefono_otro) LIKE '%$q%' or trim(telefono_celular) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', apellidos, nombre)) like '%$q%' or idproveedores = '$q') LIMIT 5";
	$res1 = mysql_query($sql1);
	
	if (mysql_num_rows($res1) >=1) {

		while($fila1 = mysql_fetch_array($res1)){
			
			echo $mensaje_proveedores = Search_Logistics ("ID", $fila1[idproveedores], "Proveedor", $q);

		}
	}
#------------------------------------------------- COLABORADOR ------------------------------------------------- ------------------------------------------------- -------------------------------------------------  
	$sql2 = "SELECT * FROM empleados WHERE visible = 'SI' AND (trim(nombre) LIKE '%$q%' || trim(apellido_paterno) LIKE '%$q%' || trim(apellido_materno) LIKE '%$q%' || trim(columna_b) LIKE '%$q%' || trim(concat_ws(' ', nombre, apellido_paterno, apellido_materno)) LIKE '%$q%' || trim(concat_ws(' ', apellido_paterno, apellido_materno, nombre)) LIKE '%$q%' ) LIMIT 5";
	$res2 = mysql_query($sql2);
	
	if (mysql_num_rows($res2) >=1) {

		while($fila2 = mysql_fetch_array($res2)){
			
			echo $mensaje_colaborador = Search_Logistics ("ID", $fila2[idempleados], "Colaborador", $q);

		}
	}
#------------------------------------------------- PROVEEDOR TEMPORAL ------------------------------------------------- ------------------------------------------------- ------------------------------------------------- 
	$sql3 = "SELECT * FROM orden_logistica_proveedores WHERE visible = 'SI' AND (trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', apellidos, nombre)) like '%$q%' or trim(telefono_otro) LIKE '%$q%' or trim(telefono_celular) LIKE '%$q%' or trim(idorden_logistica_proveedores) = '$q' ) LIMIT 5";
	$res3 = mysql_query($sql3);
	
	if (mysql_num_rows($res3) >=1) {

		while($fila3 = mysql_fetch_array($res3)){
			
			echo $mensaje_prov_temporal = Search_Logistics ("ID", $fila3[idorden_logistica_proveedores], "Proveedor Temporal", $q);

		}
	}
#------------------------------------------------- PROVEEDOR INFO ------------------------------------------------- ------------------------------------------------- ------------------------------------------------- 
	$sql4 = "SELECT * FROM proveedores_info WHERE trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', apellidos, nombre)) like '%$q%' or idproveedores_info = '$q' OR trim(telefono_otro) LIKE '%$q%' OR trim(telefono_celular) LIKE '%$q%' LIMIT 5";
	$res4 = mysql_query($sql4);
	
	if (mysql_num_rows($res4) >=1) {

		while($fila4 = mysql_fetch_array($res4)){
			
			echo $mensaje_prov_info = Search_Logistics ("ID", $fila4[idproveedores_info], "Proveedor Info", $q);

		}
	}
#------------------------------------------------- PROSPECTOS ------------------------------------------------- ------------------------------------------------- ------------------------------------------------- 
	$sql5 = "SELECT * FROM prospectos WHERE trim(nombre) LIKE '%$q%' or trim(apellidos) LIKE '%$q%' or trim(alias) LIKE '%$q%' or trim(concat_ws(' ', trim(nombre), trim(apellidos))) like '%$q%' or trim(concat_ws(' ', apellidos, nombre)) like '%$q%' or idprospectos = '$q' OR trim(telefono_otro) LIKE '%$q%' OR trim(telefono_celular) LIKE '%$q%' LIMIT 5";
	$res5 = mysql_query($sql5);
	
	if (mysql_num_rows($res5) >=1) {

		while($fila5 = mysql_fetch_array($res5)){
			
			echo $mensaje_prospectos = Search_Logistics ("ID", $fila5[idprospectos], "Prospectos", $q);

		}
	}

}



function Search_Logistics ($type, $id_contacto, $tipo_contacto, $idlogistica) {

	$type = trim($type);
	$id_contacto = trim($id_contacto);
	$tipo_contacto = trim($tipo_contacto);
	$idlogistica = trim($idlogistica);

	if ($type == "ID") {

		$query_logistica = "SELECT * FROM orden_logistica WHERE trim(idcontacto) = '$id_contacto' and trim(tipo_contacto) = '$tipo_contacto'";
		
	}elseif ($type == "idl") {

		$query_logistica = "SELECT * FROM orden_logistica WHERE trim(idorden_logistica) = '$idlogistica'";
	}

	$result_logistica = mysql_query($query_logistica);

	if (mysql_num_rows($result_logistica) >=1) {

		while ($row_logistica = mysql_fetch_array($result_logistica)) {
			
			$idl = base64_encode($row_logistica[idorden_logistica]);
			$consulta_nombres = nombres_datos($row_logistica[idcontacto], $row_logistica[tipo_contacto]);
			$porciones_id = explode("|", $consulta_nombres);

			$respuesta_logistica = "<div class='sugerencias'><a href='orden_logistica_detalles.php?idib=$idl'><i class='fa fa-eye'></i> $row_logistica[idorden_logistica] $porciones_id[10] - $porciones_id[11]</em></a></div>";
		}

	}

	return $respuesta_logistica;

}


?>
