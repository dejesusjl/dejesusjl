<?php 
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php"; 
include_once "funciones_principales_insert.php"; 

date_default_timezone_set('America/Mexico_City');
$fecha_guardado=date("Y-m-d H:i:s");
$fecha_creacion=date("Y-m-d H:i:s"); 
$usuario_creador=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];
$fecha_act = date("Y-m-d H:i:s");

$tipo_movimiento = $_POST['tipo_movimiento'];
$id = base64_decode($_POST['id']);

if ($tipo_movimiento == "BitacoraALL") {

	$mensaje .= "
	<br>
	<h6 class='mb-3'>Bitacora:</h6>
	<div class='mt-1 mb-3 p-3 button-container bg-white shadow-sm border' id='columna'>
	<hr>
	<div class='feed-single mb-3'>
	";

	$count_bitacora = 0;

	$sql = "SELECT * FROM catalogo_monedero_electronico_bitacora WHERE visible = 'SI' ORDER BY fecha_guardado DESC";
	$result=mysql_query($sql);

	while ( $fila = mysql_fetch_array($result)) {
		$count_bitacora ++;
		$tipo = $fila[movimiento];
		$contenido = $fila[contenido];
		$fecha_bitacora =$fila[fecha_guardado];
		$fecha_cr=$fila[fecha_creacion];

		$user = $fila[usuario_creador];				
		$archivo=$fila[evidencia];

		$sql22= "SELECT nombre_usuario, sigla_ccp, foto_perfil FROM usuarios WHERE idusuario='$user' ";
		$result22=mysql_query($sql22);
		while ( $fila22 = mysql_fetch_array($result22)) {
			$nombre_usuario="$fila22[nombre_usuario]";
			$sigla_ccp="$fila22[sigla_ccp]";
			$foto_perfil="$fila22[foto_perfil]";
		}

		$idcn=base64_encode($idcontacto);
		$direccion_archivo="";
		if ($archivo!="") {
			$direccion_archivo="<a href='$archivo' target='_blank'><i class='fa fa-picture-o'></a></i>";
		}



		$mensaje .= "
		<div class='media'>
		<img class='mr-3 rounded-circle' height='40px' width='40px' src='$foto_perfil'>
		<div class='media-body'>
		<h6 class='mt-1'>$direccion_archivo $tipo 
		<small class='text-muted small pull-right'><i class='fa fa-clock'></i> $fecha_bitacora <br /></small>
		<br>
		$contenido
		<p class='clearfix'></p>
		</h6>
		<p>$nombre_usuario</p>
		<div class='feed-footer'>
		<span class='pr-3'>$fecha_cr</span>
		</div>
		</div>
		</div> <hr>";
	}


	$mensaje .= "
	</div>
	</div>
	";

} elseif ($tipo_movimiento == "BitacoraIndividual") {

	$query_movimientos = "SELECT * FROM catalogo_monedero_electronico_bitacora WHERE visible = 'SI' AND id_monedero_electronico = '$id'";
	$result_movimientos = mysql_query($query_movimientos);

	while ($row_movimientos = mysql_fetch_array($result_movimientos)) {


		$buscar_name = NameUsuarioCreador($row_movimientos[usuario_creador]);
		$nombre_usuario_creador = explode("|", $buscar_name);


		$fecha_bitacora = date_create($row_movimientos[fecha_guardado]);
		$fecha_bitacora = date_format($fecha_bitacora, "d-m-Y H:i");

		$mensaje .= "
		<div class='media' style='text-align: justify;'>

		<i class='fas fa-user-tie fa-2x'></i>

		<div class='media-body'>

		<h4>$row_movimientos[movimiento]</h4>
		<h5>$row_movimientos[contenido]</h5>
		<h6>$row_movimientos[comentarios]</h6>

		<p>$nombre_usuario_creador[0]</p>

		<div class='feed-footer'>
		<span><b>$fecha_bitacora</b></span>
		</div>

		</div>
		</div>
		<hr>
		";


	}
}

echo $mensaje;

?>






