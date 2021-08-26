<?php
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 

$valor = $_POST['valorBusqueda'];
$q = trim($valor);
//$q = "lcn";

if ($q == "") {

	$mensaje = "<b>Tarjeta Tag NO Encontrada</b>";

}else{

	if (is_numeric($q)) {

		$query_card = "SELECT * FROM catalogo_monederos_electronicos where no_tarjeta LIKE '%$q%' || nip LIKE '%$q%' ";
		$result_card = mysql_query($query_card);

		if (mysql_num_rows($result_card) == 0) {

			$mensaje = "<b>Tarjeta Tag NO Encontrada</b>";

		}else{
			while ($row_card = mysql_fetch_array($result_card)) {

				$portador = (is_numeric($row_card[idempleados])) ? name_responsable($row_card[idempleados]) : $row_card[idempleados] ;

				$mensaje.="
				<div class='content-op-busqueda-2'>
				<i class='far fa-credit-card icon-busqueda'></i>
				<option class='sugerencias_tarjeta efecto-sugerencia' value='$row_card[no_tarjeta];$row_card[tipo];$portador'>
				$row_card[nombre_tarjeta] - $row_card[no_tarjeta] - $row_card[tipo] - $portador
				</option>
				</div>";


			}
		}
	}else{

		$responsable_tarjeta = name_responsable($q);

		$query_card = "SELECT * FROM catalogo_monederos_electronicos where  nombre_tarjeta LIKE '%$q%' || tipo LIKE '%$q%' || idempleados = '".$responsable_tarjeta."' ";
		$result_card = mysql_query($query_card);

		if (mysql_num_rows($result_card) == 0) {

			$mensaje = "<b>Tarjeta Tag NO Encontrada</b>";

		}else{

			while ($row_card = mysql_fetch_array($result_card)) {

				$portador = (is_numeric($row_card[idempleados])) ? name_responsable($row_card[idempleados]) : $row_card[idempleados] ;

				$mensaje.="
				<div class='content-op-busqueda-2'>
				<i class='far fa-credit-card icon-busqueda'></i>
				<option class='sugerencias_tarjeta efecto-sugerencia' value='$row_card[no_tarjeta];$row_card[tipo];$portador'>
				$row_card[nombre_tarjeta] - $row_card[no_tarjeta] - $row_card[tipo] - $portador
				</option>
				</div>";

			}
		}
	}
}





function name_responsable($id_responsable){

	if (is_numeric($id_responsable) and $id_responsable != "" and $id_responsable != "0") {

		$query_empleado = "SELECT * FROM empleados where idempleados = '$id_responsable'";
		$result_empleado = mysql_query($query_empleado);

		if (mysql_num_rows($result_empleado) >=1) {

			while ($row_empleado = mysql_fetch_array($result_empleado)) {
				$tipo_return = $row_empleado[columna_b];
				$id_name = $row_empleado[idempleados];
			}
		}else{

			$tipo_return = $id_responsable;
		}
	}else{

		$query_empleado = "SELECT * FROM empleados where nombre LIKE '%$id_responsable%' || apellido_paterno LIKE '%$id_responsable%' || apellido_materno LIKE '%$id_responsable%' || columna_b LIKE '%$id_responsable%' || concat_ws(' ', nombre, apellido_paterno, apellido_materno) LIKE '%$id_responsable%' ";
		$result_empleado = mysql_query($query_empleado);

		if (mysql_num_rows($result_empleado) >=1) {

			while ($row_empleado = mysql_fetch_array($result_empleado)) {
				$name = $row_empleado[columna_b];
				$id_name = $row_empleado[idempleados];

				$tipo_return = $id_name;
			}

		}else{
			$tipo_return = $id_responsable;
		}
	}



	return $tipo_return;
}	



echo $mensaje;

?>
