<?php 


session_start();  
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";
date_default_timezone_set('America/Mexico_City');
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];


#------------------------------- Tipo Crud ------

$tipo_crud = trim($_POST['tipo_crud']);

#------------------------------- Update ------

$idcatalogo_monederos_electronicos = $_POST['idcatalogo_monederos_electronicos_encriptado'];
$name_tarjeta = trim($_POST['name_tarjeta']);
$type_tarjeta = trim($_POST['type_tarjeta']);
$valor = trim($_POST['valor']);
$nip = trim($_POST['nip']);
$idempleados = trim($_POST['idempleados']);
$mes = trim($_POST['mes']);
$anio = trim($_POST['anio']);
$cvv = trim($_POST['cvv']);

$activar_desactivar = trim($_POST['activar_desactivar']);

$comentarios = trim($_POST['comentarios']);
$fecha_creacion = $_POST['fecha_creacion'];

$visible = 'SI';

$fecha_guardado= date("Y-m-d H:i:s");



if ($tipo_crud == "Create") {

	if ($valor == "") {

		echo "<b>No Capturaste un Numero de Tarjeta | Tag Valido</b>";
		
	}else {

		if ($name_tarjeta == "") {

			echo "<b>No Seleccionaste Tarjeta | Tag</b>";
			
		}else {

			if ($type_tarjeta == "") {

				echo "<b>No Seleccionaste el Tipo de Tarjeta | Tag</b>";
				
			}else {

				$query_repetir = "SELECT * FROM catalogo_monederos_electronicos WHERE trim(no_tarjeta) = '$valor' ";
				$result_repetir = mysql_query($query_repetir);

				if (mysql_num_rows($result_repetir) == 0) {

					$name_tarjeta = ($name_tarjeta == "") ? "N/A" : $name_tarjeta;

					$concat_mes_anio = ($mes != "" AND $anio != "") ? $concat_mes_anio = "$mes/$anio" : "/" ;

					$query_insert_monedero = "INSERT INTO catalogo_monederos_electronicos (nombre_tarjeta, tipo, no_tarjeta, nip, idempleados, columna_a, columna_b, columna_c, visible, usuario_creador, fecha_creacion, fecha_guardado) VALUES ('$name_tarjeta', '$type_tarjeta', '$valor', '$nip', '$idempleados', '$concat_mes_anio', '$columna_b', '$cvv', '$visible', '$usuario_creador', '$fecha_creacion', '$fecha_guardado')";
					$result_insert_monedero = mysql_query($query_insert_monedero);


					if($result_insert_monedero == 1) {

						$rs = mysql_query("SELECT @@identity AS id");
						if ($row_ultimo_insert = mysql_fetch_row($rs)) {
							$id_monedero_electronico = trim($row_ultimo_insert[0]);
						}

						$contenido = 'Se Agrego Nueva Tarjeta<br /> Tarjeta: <b>'.$name_tarjeta.'</b> No: <b>'.chunk_split($valor,4," ").'</b> <br />TIPO: <b>'.$type_tarjeta.'</b><br>';

						$movimiento='Inventario';
						$evidencia='';

						echo monederoInsertaBitacora ($id_monedero_electronico, $contenido, $movimiento, $evidencia, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible);


					}else {

						echo "Ocurrio un error al guardar la información";
					}

				}else {

					echo "El numero de tarjeta <b>$valor</b> ya existe por lo tanto debes de activarla y modificar la información de ser necesario";

				}
			}
		}
	}

}elseif ($tipo_crud == "Update") {
	
	$idcatalogo_monederos_electronicos = base64_decode($idcatalogo_monederos_electronicos);


	$visible = "SI";
	$array_updates = array(); 

	$query_card_electronic = "SELECT * FROM catalogo_monederos_electronicos WHERE idcatalogo_monederos_electronicos = '$idcatalogo_monederos_electronicos'";
	$result_card_electronic = mysql_query($query_card_electronic);

	if (mysql_num_rows($result_card_electronic) >=1) {

		while ($row_update_card_electronic = mysql_fetch_array($result_card_electronic)) {

			$fecha_guardado= date("Y-m-d H:i:s"); 

			$num_tarjeta = chunk_split($row_update_card_electronic[no_tarjeta],4," ");
			$number_card_mensaje = "<br>Tarjeta: <b>$row_update_card_electronic[nombre_tarjeta]</b> No: <b>$num_tarjeta</b>";

			#------------------------------- Nombre ---------------------------
			if ($row_update_card_electronic[nombre_tarjeta] != $name_tarjeta) {

				$updatename_card = UpdateCardElectronic ($idcatalogo_monederos_electronicos, "nombre_tarjeta", $name_tarjeta );

				if ($updatename_card == 1) {

					$contenido = "El nombre de la tarjeta cambio de <b>$row_update_card_electronic[nombre_tarjeta]</b> por: <b>$name_tarjeta</b>$number_card_mensaje";
					
					$bitacora_name_card = monederoInsertaBitacora($idcatalogo_monederos_electronicos, $contenido, "Tarjeta", "", $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible);
					array_push($array_updates, $bitacora_name_card);

				}else {

					array_push($array_updates, $updatename_card);

				}
			}else {

				array_push($array_updates, "1");
			}

			#------------------------------- Tipo ---------------------------
			if ($row_update_card_electronic[tipo] != $type_tarjeta) {

				$updatename_tipo = UpdateCardElectronic ($idcatalogo_monederos_electronicos, "tipo", $type_tarjeta );

				if ($updatename_tipo == 1) {

					$contenido = "El tipo de la tarjeta cambio de <b>$row_update_card_electronic[tipo]</b> por: <b>$type_tarjeta</b>$number_card_mensaje";
					
					$bitacora_tipo_card = monederoInsertaBitacora($idcatalogo_monederos_electronicos, $contenido, "Tipo", "", $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible);
					array_push($array_updates, $bitacora_tipo_card);

				}else {

					array_push($array_updates, $updatename_tipo);

				}
			}else {

				array_push($array_updates, "1");
			}

			#------------------------------- Responsbale ---------------------------
			if ($row_update_card_electronic[idempleados] != $idempleados) {

				if (trim($row_update_card_electronic[idempleados]) == "" || trim($row_update_card_electronic[idempleados]) == null || trim($row_update_card_electronic[idempleados]) == "N/A") {

					$nomenclatura_responsable_tarjeta = "N/A";

				}elseif (is_numeric($row_update_card_electronic[idempleados])) {

					$buscar_responsable = explode("|", nombres_datos($row_update_card_electronic[idempleados], "Colaborador"));
					$nomenclatura_responsable_tarjeta = "$buscar_responsable[10] - $buscar_responsable[2]";

				}else{

					$nomenclatura_responsable_tarjeta = $row_update_card_electronic[idempleados];

				}

				if (is_numeric($idempleados)) {

					$search_new_responsable = explode("|", nombres_datos($idempleados, "Colaborador"));
					$new_responsable = "$search_new_responsable[10] - $search_new_responsable[2]";

				}else {

					$new_responsable = $idempleados;
				}


				$update_idresponsable = UpdateCardElectronic ($idcatalogo_monederos_electronicos, "idempleados", $idempleados );

				if ($update_idresponsable == 1) {

					$contenido = "El responsable de la tarjeta cambio de <b>$nomenclatura_responsable_tarjeta</b> por: <b>$new_responsable</b>$number_card_mensaje";
					
					$bitacora_responsable_card = monederoInsertaBitacora($idcatalogo_monederos_electronicos, $contenido, "Responsable", "", $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible);
					array_push($array_updates, $bitacora_responsable_card);

				}else {

					array_push($array_updates, $update_idresponsable);

				}

			}else {

				array_push($array_updates, "1");
			}

			#------------------------------- NIP ---------------------------
			if ($row_update_card_electronic[nip] != $nip) {

				$update_nip = UpdateCardElectronic ($idcatalogo_monederos_electronicos, "nip", $nip );

				if ($update_nip == 1) {

					$contenido = "El NIP de la tarjeta cambio de <b>$row_update_card_electronic[nip]</b> por: <b>$nip</b>$number_card_mensaje";
					
					$bitacora_nip_card = monederoInsertaBitacora($idcatalogo_monederos_electronicos, $contenido, "NIP", "", $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible);
					array_push($array_updates, $bitacora_nip_card);

				}else {

					array_push($array_updates, $update_nip);

				}
			}else {

				array_push($array_updates, "1");
			}

			#------------------------------- Vencimiento ---------------------------

			if ($mes != "" AND $anio != "") {

				$concat_mes_anio = "$mes/$anio";

				if ($row_update_card_electronic[columna_a] != $concat_mes_anio) {

					$update_mes_anio = UpdateCardElectronic ($idcatalogo_monederos_electronicos, "columna_a", $concat_mes_anio );

					if ($update_mes_anio == 1) {

						$contenido = "El Vencimiento de la tarjeta cambio de <b>$row_update_card_electronic[columna_a]</b> por: <b>$concat_mes_anio</b>$number_card_mensaje";

						$bitacora_vencimiento_card = monederoInsertaBitacora($idcatalogo_monederos_electronicos, $contenido, "Vencimiento", "", $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible);
						array_push($array_updates, $bitacora_vencimiento_card);

					}else {

						array_push($array_updates, $update_mes_anio);

					}
				}	
			}else {

				array_push($array_updates, "1");
			}

			#------------------------------- Evidencia ---------------------------


			if (isset($_FILES['evidencia'])) {

				$ruta_archivo = "../../Balance_Gastos_Evidencia/";

				$target_path = $ruta_archivo."TE-"."$row_update_card_electronic[no_tarjeta]"."_Usr_".$usuario_creador.$fecha_guardado."_".basename( $_FILES['evidencia']['name']);

				if (is_dir($ruta_archivo)) { 

					$estatus_evidencia = (move_uploaded_file($_FILES['evidencia']['tmp_name'], $target_path)) ? $target_path : "- Ocurrio un error al mover la Evidencia <br>" ;

				}else {

					$estatus_evidencia = "La carpeta $ruta_archivo no existe";

				}


				if ($estatus_evidencia == "La carpeta $ruta_archivo no existe" || $estatus_evidencia == "- Ocurrio un error al mover la Evidencia <br>") {

					array_push($array_updates, $estatus_evidencia);

				}else {

					if (file_exists($row_update_card_electronic[columna_b])) {

						$evidencia_bd = "<a href=\"$row_update_card_electronic[columna_b]\" target=\"_blank\"><i class=\"far fa-image fa-2x\"></i><a>";
						$evidencia_nueva = "<a href=\"$target_path\" target=\"_blank\"><i class=\"fas fa-image fa-2x\"></i><a>";

						$contenido = "La evidencia cambio de: $evidencia_bd por $evidencia_nueva";	

					}else {

						$evidencia_nueva = "<a href=\"$target_path\" target=\"_blank\" ><i class=\"far fa-image fa-2x\"></i><a>";
						$contenido = "Se agregó nueva evidencia: $evidencia_nueva";

					}

					$update_evidencia = UpdateCardElectronic ($idcatalogo_monederos_electronicos, "columna_b", $estatus_evidencia );

					if ($update_evidencia == 1) {

						$bitacora_evidencia_card = monederoInsertaBitacora($idcatalogo_monederos_electronicos, $contenido, "Evidencia", $estatus_evidencia, $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible);
						array_push($array_updates, $bitacora_evidencia_card);

					}else {

						array_push($array_updates, $update_evidencia);

					}


				}
			}else {

				array_push($array_updates, "1");
			}


			#------------------------------- Vencimiento ---------------------------

			if ($row_update_card_electronic[columna_c] != $cvv) {

				$update_cvv = UpdateCardElectronic ($idcatalogo_monederos_electronicos, "columna_c", $cvv );

				if ($update_cvv == 1) {

					$contenido = "El CVV de la tarjeta cambio de <b>$row_update_card_electronic[columna_c]</b> por: <b>$cvv</b>$number_card_mensaje";

					$bitacora_vencimiento_card = monederoInsertaBitacora($idcatalogo_monederos_electronicos, $contenido, "CVV", "", $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible);
					array_push($array_updates, $bitacora_vencimiento_card);

				}else {

					array_push($array_updates, $update_cvv);

				}
			}else {

				array_push($array_updates, "1");
			}

			#------------------------------- Vencimiento ---------------------------
			
			echo TratarNumeroText ($array_updates);

		}#while

	}else {

		echo "<b>El moviento no existe</b>";

	}

}elseif ($tipo_crud == "Delete") {

	$idcatalogo_monederos_electronicos = base64_decode($idcatalogo_monederos_electronicos);

	$delete_create = UpdateCardElectronic($idcatalogo_monederos_electronicos, "visible", $activar_desactivar );

	$contenido = ($activar_desactivar == "SI") ? 'Se dio de Alta <br /> Tarjeta: <b>'.$name_tarjeta.'</b> No: <b>'.chunk_split($valor,4," ").'</b>' : 'Se dio de Baja <br /> Tarjeta: <b>'.$name_tarjeta.'</b> No: <b>'.chunk_split($valor,4," ").'</b>' ;

	echo monederoInsertaBitacora($idcatalogo_monederos_electronicos, $contenido, "Inventario", "", $comentarios, $usuario_creador, $fecha_creacion, $fecha_guardado, $visible);

}else {

	echo "El Movimiento <b>$tipo_crud</b> no esta disponible";

}



function UpdateCardElectronic ($idcatalogo_monederos_electronicos, $nombre_columna, $valor_update ) {

	$idcatalogo_monederos_electronicos = trim($idcatalogo_monederos_electronicos);

	$query_update_card_electronic = "UPDATE catalogo_monederos_electronicos SET $nombre_columna = '$valor_update' WHERE idcatalogo_monederos_electronicos = '$idcatalogo_monederos_electronicos' ";
	$result_update_card_electronic = mysql_query($query_update_card_electronic);

	return ($result_update_card_electronic == 1) ? 1 : "- Ocurrio un error al actualizar <b>$nombre_columna</b> <br>";

}


?>