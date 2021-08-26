<?php 
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";

date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s"); 
$usuario_creador=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];


$idlogistica = $_REQUEST['idlogistica'];
$idcolaborador = $_REQUEST['idcolaborador'];
$valores = $_REQUEST['valores'];

$idlogistica = trim($idlogistica);
$idcolaborador = trim($idcolaborador);
$valores = trim($valores);

$array_departamento = array();
$array_vin = array();
$array_auxiliares = array();

$array_id = explode("|", $valores);
$condicion = "";

foreach ($array_id as $key_id => $value_id) {

	if (trim($value_id) != "") {
		
		$condicion .= " idbalance_gastos_operacion ='".trim($value_id)."' ||";
	}
}

$idbalance_gastos_operacion = substr($condicion, 0, -3);

$query_balance = "SELECT * FROM balance_gastos_operacion WHERE $idbalance_gastos_operacion";
$result_balance = mysql_query($query_balance);

if (mysql_num_rows($result_balance) == 0) {

	echo "0";

}else {

	while ($row_balance = mysql_fetch_array($result_balance)) {

		array_push($array_vin, $row_balance[datos_vin]);

		if (is_numeric($row_balance[responsable])) {

			$consultar_nombre = nombres_datos($row_balance[responsable], "Colaborador");
			$porciones_nombre = explode("|", $consultar_nombre);
			array_push($array_auxiliares, $porciones_nombre[10]);

			if ($porciones_nombre[0] != "Pendiente") {

				$query_proveedores_separado = "SELECT * FROM proveedores WHERE trim(nombre) = '$porciones_nombre[0]' and trim(apellidos) = '$porciones_nombre[1]' ";
				$resul_proveedores_separado = mysql_query($query_proveedores_separado);
				
				if (mysql_num_rows($resul_proveedores_separado) == 0 ) {

					$concatenar_nombre_apellidos = $porciones_nombre[0]." ".$porciones_nombre[1];

					$query_proveedores_junto = "SELECT * FROM proveedores WHERE trim(nombre) = '$concatenar_nombre_apellidos'";
					$resul_proveedores_junto = mysql_query($query_proveedores_junto);

					if (mysql_num_rows($resul_proveedores_junto) == 0 ) {


						$nombre_completo = trim($porciones_nombre[10]);
						$nom = eliminar_tildes($nombre_completo);

						$words = explode(" ", $nom); 

						$nomeclatura = ""; 

						foreach ($words as $w) {
							$nomeclatura .= $w[0]; 
						}

						$query_insert_new_proveedor = "INSERT INTO proveedores (idprovedores_compuesto, nomeclatura, nombre, apellidos, visible, usuario_creador, fecha_creacion, fecha_guardado) values ('$porciones_nombre[0]', '$nomeclatura', '$porciones_nombre[0]', '$porciones_nombre[1]', 'SI', '$usuario_creador', '$fecha_guardado', '$fecha_guardado')";
						$result_insert_new_proveedor = mysql_query($query_insert_new_proveedor);

						if ($result_insert_new_proveedor == 1) {

							$rs = mysql_query("SELECT @@identity AS id");
							if ($row = mysql_fetch_row($rs)) {
								$id = trim($row[0]);
							}

							$fecha_creado_idcompud = date("dmY");
							$idcompuesto = $id."-".$nomeclatura."-".$fecha_creado_idcompud;
							$query_update_new ="UPDATE proveedores SET idprovedores_compuesto = '$idcompuesto' WHERE idproveedores = '$id'";
							$result_update_new = mysql_query($query_update_new);

							if ($result_update_new == 1) {

								$nomenclatura_proveedor = $idcompuesto;

							}else{

								$nomenclatura_proveedor = "Error de proveedor 3";

							}

						}else{
							$nomenclatura_proveedor = "Error de proveedor 2";
						}

					}else {

						while ($row_nombre_junto_proveedor = mysql_fetch_array($resul_proveedores_junto)) {

							$nomenclatura_proveedor = trim($row_nombre_junto_proveedor[idprovedores_compuesto]);

						}

					}
				}else {

					while ($row_nombre_apellidos_proveedor = mysql_fetch_array($resul_proveedores_separado)) {

						$nomenclatura_proveedor = trim($row_nombre_apellidos_proveedor[idprovedores_compuesto]);

					}
				}

			}else { # Responsable Pendiente
				$nomenclatura_proveedor = "Error de proveedor 1";
			}
		}else { #is numeric

			$responsable_bd_prov = trim($row_balance[responsable]);


			$query_proveedores_numeric_prov = "SELECT * FROM proveedores WHERE trim(concat_ws(' ', trim(nombre), trim(apellidos))) = '$responsable_bd_prov' ";
			$resul_proveedores_numeric_prov = mysql_query($query_proveedores_numeric_prov);

			if (mysql_num_rows($resul_proveedores_numeric_prov) == 0) {


				$nom = eliminar_tildes($responsable_bd_prov);

				$words = explode(" ", $nom); 

				$nomeclatura = ""; 

				foreach ($words as $w) {
					$nomeclatura .= $w[0]; 
				}

				$query_insert_new_proveedor = "INSERT INTO proveedores (idprovedores_compuesto, nomeclatura, nombre, visible, usuario_creador, fecha_creacion, fecha_guardado) values ('$nomeclatura', '$nomeclatura', '$nom', 'SI', '$usuario_creador', '$fecha_guardado', '$fecha_guardado')";
				$result_insert_new_proveedor = mysql_query($query_insert_new_proveedor);

				if ($result_insert_new_proveedor == 1) {

					$rs = mysql_query("SELECT @@identity AS id");
					if ($row = mysql_fetch_row($rs)) {
						$id = trim($row[0]);
					}

					$fecha_creado_idcompud = date("dmY");
					$idcompuesto = $id."-".$nomeclatura."-".$fecha_creado_idcompud;
					$query_update_new ="UPDATE proveedores SET idprovedores_compuesto = '$idcompuesto' WHERE idproveedores = '$id'";
					$result_update_new = mysql_query($query_update_new);

					if ($result_update_new == 1) {

						$nomenclatura_proveedor = $idcompuesto;

					}else{

						$nomenclatura_proveedor = "Error de proveedor 3";

					}

				}else{
					$nomenclatura_proveedor = "Error de proveedor 2";
				}


				
			}else {

				while ($row_proveedores_numeric_prov = mysql_fetch_array($resul_proveedores_numeric_prov)) {

					$nomenclatura_proveedor = $row_proveedores_numeric_prov[idprovedores_compuesto];
				}

			}

		} 
#------------------------- Departamento DB-------------------------

		$departamento_balance = $row_balance[idcatalogo_departamento];

#------------------------- Auxiliares-------------------------

		$apartado_usado = $row_balance[apartado_usado];
		$convertir_array_auxiliares = explode(",", $apartado_usado);

		foreach ($convertir_array_auxiliares as $key_auxiliares_bd => $value_auxiliares_bd) {

			array_push($array_auxiliares, $value_auxiliares_bd);
		}




#------------------------- Monto Total-------------------------

		$monto_total += $row_balance[gran_total];













	 }# while






}# else




#------------------------- Departamento -------------------------
array_push($array_auxiliares, "Logística");


$name_departamento_bd = DepartamentoName($departamento_balance);
$departamento_option = "<option value='$departamento_balance'>$name_departamento_bd</option>";
#------------------------- AUXILIARES -------------------------
$auxiliares_unicos = DeleteRepeats($array_auxiliares);

$pasar_auxiliares = implode(",", $auxiliares_unicos);






$vin_unique = DeleteRepeats($array_vin);
$options_vin = CreateOptions($vin_unique);







echo "$nomenclatura_proveedor|$departamento_option|$options_vin|$monto_total|$pasar_auxiliares,|";

















function CreateOptions($array_options) {

	foreach ($array_options as $key_create_options => $value_create_options) {
		$porciones_options = explode($separador, $value_create_options);
		$valor_option = trim($value_create_options);
		$texto_option = trim($value_create_options);

		$options_concatenados .= "<option value='$valor_option'>$texto_option</option>";
	}

	return $options_concatenados;

}






?>