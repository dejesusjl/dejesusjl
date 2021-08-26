<?php

session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
date_default_timezone_set('America/Mexico_City');

include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";

$reci=$_REQUEST['idc'];
$idorden_logistica = base64_decode($reci);

$n1=strlen($idc);
$n1_aux=6-$n1;
$mat="";

for ($i=0; $i <$n1_aux ; $i++) { 
	$mat.="0";
}

$idorden_logistica_completo = $mat.$idorden_logistica;

#-------------------------------------------Fecha--------------------------------------------------------------------------------

$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

date_default_timezone_set('America/Mexico_City');
$date = date_create();
$dia = date_format($date, 'd');
$mes_aux = date_format($date, 'm');
$mes = ucfirst($meses[$mes_aux-1]);
$ano = date_format($date, 'Y');
$hora = date_format($date, 'H:i:s');




$contador =0;

$idpro = array();
$idrespon = array();
$cargos_arreglo = array();
$abono_arreglo = array();
$suma_cargo1 = 0;
$suma_abono1 = 0;

$sql100 = "SELECT * FROM balance_gastos_operacion WHERE columna2 = '$idorden_logistica' and visible = 'SI' order by fecha_movimiento asc ";
$result100 = mysql_query($sql100);

while ($fila100 = mysql_fetch_array($result100)) {	

	$iddepartamento ="$fila100[idcatalogo_departamento]";
	$idbalance_gastos_operacionxd = "$fila100[idbalance_gastos_operacion]"; 
	$id_aux_prin = "$fila100[idauxiliar_principales]"; 

	$sql4 = "SELECT * FROM auxiliar_principales WHERE idauxiliar_principales='$id_aux_prin' AND visible='SI'";
	$result4 = mysql_query($sql4 );

	while ($fila4 = mysql_fetch_array($result4)) {
		$departamento_auxiliar = "$fila4[concepto]";
		if ($departamento_auxiliar == "CCH Caja Chica" || $departamento_auxiliar =="CCH CAJA CHICA") {
			$departamento_auxiliar = "CAJA CHICA";
		}else{
			$departamento_auxiliar = strtoupper($departamento_auxiliar);
		}
	}

	$querydepartamento = "SELECT * FROM catalogo_departamento where idcatalogo_departamento = '$iddepartamento'";
	$resultquerydepartamento = mysql_query($querydepartamento);

	while ($rowdepartamento = mysql_fetch_array($resultquerydepartamento)) {
		$departamento_derequisicion = eliminar_tildes("$rowdepartamento[nombre]");

	}



	$sql7="SELECT * FROM catalogo_departamento  WHERE idcatalogo_departamento='$iddepartamento'";
	$result7= mysql_query($sql7);

	while ($fila7= mysql_fetch_array($result7)) {
		$departamento ="$fila7[nombre]";
	}
	$contador++;
	$tabla_movimientos_balance .= imprimir("$fila100[idbalance_gastos_operacion]", "$fila100[monto_precio]","$fila100[idcatalogo_departamento]" , $contador, "$fila100[fecha_movimiento]",$idaxuliares, $departamento_auxiliar, $departamento_derequisicion, $idbalance_gastos_operacionxd, $concep);	
}



$query_total_logistica = "SELECT sum(cargo) FROM balance_gastos_operacion where columna2 = '$idaxuliares' and visible = 'SI' and concepto <> 'REEMBOLSO' ";
$result_total_logistica = mysql_query($query_total_logistica);

while ($row_total_logistica = mysql_fetch_array($result_total_logistica)) {
	$costo_total_logistica = "$".number_format("$row_total_logistica[0]" ,2);
	$costo_total_logistica_1 = "$row_total_logistica[0]";

}

$query_anticipo = "SELECT sum(abono) FROM balance_gastos_operacion where columna2 = '$idaxuliares' and visible = 'SI' and concepto = 'ANTICIPO'";
$result_anticipo = mysql_query($query_anticipo);


while ($row_total_anticipo = mysql_fetch_array($result_anticipo)) {
	
	$total_anticipo_1 = "$row_total_anticipo[0]";

	if ($total_anticipo_1 == "" || $total_anticipo_1 == null || $total_anticipo_1 == 0) {
		$total_anticipo = "$".number_format(0 ,2);
	}else{
		$total_anticipo = "$".number_format("$row_total_anticipo[0]" ,2);
	}
}




$query_cargos_logistica = "SELECT sum(cargo) FROM balance_gastos_operacion where columna2 = '$idaxuliares' and visible = 'SI' and comision = 'N/A' and concepto <>'REEMBOLSO'";
$result_cargos_logistica = mysql_query($query_cargos_logistica);

while ($row_cargos_logistica = mysql_fetch_array($result_cargos_logistica)) {
	$costo_cargos_logistica_1 = "$row_cargos_logistica[0]";	
}

$query_efectivo_logistica = "SELECT sum(cargo) FROM balance_gastos_operacion WHERE columna2 = '$idaxuliares' and visible = 'SI' and comision = 'N/A' AND concepto <> 'REEMBOLSO'";
$result_efectivo_logistica = mysql_query($query_efectivo_logistica);

while ($row_efectivo_logistica = mysql_fetch_array($result_efectivo_logistica)) {
	
	$costo_cargos_efectivo1 = "$row_efectivo_logistica[0]";	

	if ($costo_cargos_efectivo1 == "" || $costo_cargos_efectivo1 == null || $costo_cargos_efectivo1 == 0) {
		$costo_cargos_efectivo = "$".number_format(0 ,2);
	}else{
		$costo_cargos_efectivo = "$".number_format("$row_efectivo_logistica[0]", 2);
	}

}


$reembolso_logistica1 = $total_anticipo_1-$costo_cargos_logistica_1;  
$reembolso_logistica = "$".number_format($reembolso_logistica1, 2);

$query_mpago = "SELECT metodo_pago FROM balance_gastos_operacion where columna2 = '$idaxuliares' and visible = 'SI' group by metodo_pago;";
$result_mpago = mysql_query($query_mpago);

while ($row_mpago = mysql_fetch_array($result_mpago)) {
	$total_metodo_pago1 .= "$row_mpago[0]".",";
}

$total_metodo_pago = substr($total_metodo_pago1, 0, -1);





function imprimir($idec, $mt_total, $idc, $contador, $fechas_mv,$idap, $departamento_auxiliar, $departamento_derequisicion, $idbalance_gastos_operacionxd, $concep){
	global $saldo_total;
	global $saldos;

	$sql6 = "SELECT * FROM balance_gastos_operacion WHERE idcatalogo_departamento = '$idc' and visible = 'SI' and idbalance_gastos_operacion ='$idec'";

	$result6 = mysql_query($sql6);
	while ($fila6 = mysql_fetch_array($result6)) {


		if ($fila6['tipo_movimiento']=="abono" || $fila6['tipo_movimiento']=="cargo") {

			$tipo_mon = "";
			$cambio = "";
			$cantidad = "";
			if ($fila6[tipo_moneda] == "MXN" || $fila6[tipo_moneda] == "USD" || $fila6[tipo_moneda] == "CAD") {
				$cambio = number_format($fila6[tipo_cambio],2);
				$tipo_mon = "Moneda: $fila6[tipo_moneda]<br> T. Cambio: $cambio<br>";
				$cantidad = "Cantidad: ".number_format($fila6[gran_total], 2)."<br>";
			}else{
				$tipo_mon = "";
				$cantidad = "";
			}



			if ($fila6['abono']!="") {
				$abono=number_format($mt_total,2);
			} else { $abono=""; }

			if ($fila6['cargo']!="") {
				$cargo=number_format($mt_total,2);
			} else { $cargo=""; }

			if ($fila6['tipo_movimiento']=="abono") {
				$cargo_abono_texto="<td><span></span></td>
				<td><span>$ $abono</span></td>"; 
				$saldo_total = $saldos - $mt_total; 
				$saldos = $saldo_total;
				$saldo_total = number_format($saldo_total,2);  
				$monto_precio_formato_letras= convertir($abono);
				$montos_abono_cargo = "Monto: $ $abono ($monto_precio_formato_letras)<br>";  
				$total = "Total: $ $abono";    
			}
			if ($fila6['tipo_movimiento']=="cargo") {
				$cargo_abono_texto="<td><span>$ $cargo</span></td>
				<td><span></span></td>"; 
				$saldo_total = $saldos + $mt_total; 
				$saldos = $saldo_total;
				$saldo_total = number_format($saldo_total,2);
				$monto_precio_formato_letras= convertir($cargo);
				$montos_abono_cargo = "Monto: $ $cargo ($monto_precio_formato_letras)<br>";
				$total = "Total: $ $cargo";
			}

			$fecha_movimiento_bien = "";
			$date = date_create($fila6['fecha_movimiento']);
			$fecha_movimiento_bien=date_format($date, 'd-m-Y');
			$monto_precio_formato_letras= convertir($abono);


			$sql8="SELECT * FROM catalogo_departamento  WHERE idcatalogo_departamento='$idc'";
			$result8= mysql_query($sql8);

			while ($fila8= mysql_fetch_array($result8)) {
				$departamento2 = eliminar_tildes(strtoupper("$fila8[nombre]"));
			}




			$idpro =explode(";","$fila6[idcatalogo_provedores]");
			$var=0;
			$co =0;
			$co = count($idpro);

			$provedores ="";
			$provedores2 ="";
			while ($var < $co) {

				$sql10 = "SELECT * FROM proveedores WHERE idprovedores_compuesto ='$idpro[$var]'";
				$result10 = mysql_query($sql10);

				if (mysql_num_rows($result10) >= 1) {

					while ($fila10 = mysql_fetch_array($result10)) {
						$provedores.= "$fila10[nombre]"." "."$fila10[apellidos]".",";

					}
				}else{
					$query_prov_temporal = "SELECT * FROM orden_logistica_proveedores WHERE idprovedores_compuesto = '$idpro[$var]'";
					$result_prov_temporal = mysql_query($query_prov_temporal);
					while ($row_prov_temporal = mysql_fetch_array($result_prov_temporal)) {
						$provedores.= "$row_prov_temporal[nombre]"." "."$row_prov_temporal[apellidos]".",";
					}

				}

				

				$var++;
			}


			$provedores2=substr($provedores, 0,-1);


			$idrespon = explode(";","$fila6[responsable]");

			$var2 =0;
			$co2 = 0;

			$co2 = count($idrespon);

			$nombres ="";
			$nombres2 ="";

			while ($var2 < $co2) {

				if (is_numeric($idrespon[$var2]) == FALSE) {

					$nombress .= strtoupper($idrespon[$var2]).",";
					$var2++;

				}else{

					$sql11 ="SELECT * FROM empleados  WHERE idempleados='$idrespon[$var2]'";
					$result11 = mysql_query($sql11);
					$nombres_completo ="";

					while ($fila11 = mysql_fetch_array($result11)) {
						$nom ="$fila11[columna_b]";

						$nombres .= $nom.",";

					}

					$nom ="";
					$nom2="";
					$nombres2=substr($nombres, 0,-1);

					$nombres_ara = array();
					$nombres_ara =explode(",", $nombres2);

					$v =  count($nombres_ara);
					$v3=0;

					$w = array();

					while ($v3 < $v) {


						$words = explode(" ", $nombres_ara[$v3]); $acronym = ""; foreach ($words as $w) { $acronym .= $w[0]; }
						$nom .= $acronym.",";
						$string .=$nom.",";
						$v3++;

					}



					$var2++;

				}

			}
			$nom2 = substr($nom, 0,-1);



			$array_si= array();
			$array_si2= array();
			$string3 = $nombress.$nombres2;

			$array_si =explode(",", $string3);

			$con3=count($array_si);
			$var4=0;
			$con5=0;
			$cadina ="";
			$cadina2="";

			while ($var4 < $con3) {

				if ($array_si[$var4]!="") {

					$array_si2[$con5]=$array_si[$var4];

					$cadina .= $array_si2[$con5].",";

					$con5++;
				}


				$var4++;
			}


			$cadina2= substr($cadina, 0,-1);



			$array_aux  = array();
			$auxiliares_todos = "$fila6[apartado_usado]";

			$array_aux = explode(",", $auxiliares_todos);

			$cont =0;
			$var4 = count ($array_aux);


			while ($cont < $var4) {

				if ($array_aux[$cont] != "") {
					$auxsi .= "".strtoupper($array_aux[$cont]).",";
				}


				$cont++;
			}

			$estatus_requisicion = strtoupper("$fila6[estatus]");
			$tipo_comprobante_requisicion = eliminar_tildes(strtoupper("$fila6[tipo_comprobante]"));
			$institucion_emisora_requisicion = eliminar_tildes(strtoupper("$fila6[emisora_institucion]"));
			$agente_emisora_requisicion = eliminar_tildes(strtoupper("$fila6[emisora_agente]"));
			$receptora_institucion = eliminar_tildes(strtoupper("$fila6[receptora_institucion]"));
			$receptora_agente = eliminar_tildes(strtoupper("$fila6[receptora_agente]"));

			$texto_informacion="Responsable: $cadina2<br>
			Departamento: $departamento2<br>
			Proveedor: $provedores2<br>
			Factura: $fila6[factura]<br>
			VIN: $fila6[datos_vin]<br>
			Método de pago: $fila6[metodo_pago]<br>
			$montos_abono_cargo
			$tipo_mon
			$cantidad
			I. Emisora: $institucion_emisora_requisicion<br> 
			A. Emisor: $agente_emisora_requisicion<br>
			I. Receptora: $receptora_institucion<br>
			A. Receptor: $receptora_agente<br>
			Tipo de Comprobante: $tipo_comprobante_requisicion<br>
			No. de Referencia: $fila6[referencia]<br>";

			$fechas_mv = str_replace(",", "<br>", $fechas_mv);


			$trim_provedores2 = trim($provedores2);


			if ($concep == "CCH CAJA CHICA" && $trim_provedores2 == "CAJA CHICA") {


				$visualizar_proveedor = $concep.",";

			}else{


				if ($concep == $trim_provedores2) {

					$visualizar_proveedor = $concep.",";

				}elseif ($concep != $trim_provedores2) {

					$visualizar_proveedor = $concep.","."".$trim_provedores2.",";
				}

			}



			/*if ($departamento_auxiliar == $departamento_derequisicion) {

				$visualizar_departamento = "".strtoupper($departamento_auxiliar).","."".strtoupper($cadina2).",";
			}else{*/
				$visualizar_departamento = "".strtoupper($departamento_auxiliar).","."".strtoupper($departamento_derequisicion).","."".strtoupper($cadina2).","."".strtoupper($visualizar_proveedor).",".$receptora_agente.",";
			#}

				$visualizar_auxiliares = ",".strtoupper($visualizar_proveedor).",".strtoupper($visualizar_departamento);

			/*if ($fila6[comision] == "N/A") {
				$auxiliares_cadena =$visualizar_auxiliares.",".strtoupper("$fila6[apartado_usado]").",".$fila6[comision].",".$receptora_agente.",".$fila6[referencia];
			}else{*/
				$auxiliares_cadena =$visualizar_auxiliares.",".strtoupper("$fila6[apartado_usado]").",".$fila6[comision].",".$receptora_agente.",".$fila6[referencia].",".$fila6[receptora_agente];
			#}

			#$auxiliares_cadena =$visualizar_auxiliares.",".strtoupper("$fila6[apartado_usado]");

				$array_unico = array();
				$array_aux= array();
				$array_aux_espacios= array();

				$array_aux =explode(",", $auxiliares_cadena);


				$variable =  count($array_aux);

				$con1 =0;
				$con2 =0;

				while ($con1 < $variable ) {
					if ($array_aux[$con1] !="") {
						$array_aux_espacios[$con2]=trim($array_aux[$con1]);
						$con2++;
					}

					$con1++;
				}

				$array_unico = array_unique($array_aux_espacios);

				$array_contar = count($array_unico);

				$var0 = 0;
				while ($var0 < $variable) {

					if ($array_unico[$var0] != "") {
						$visualizar_array_auxiliares .="- ".$array_unico[$var0]."<br>";
					} 


					$var0 ++;
				}	
				$fechas_mv = date_create($fechas_mv);											
				$fechas_mv = date_format($fechas_mv,"d-m-Y");
				$tabla_movimientos_balance .="<tr>
				<td><span>$contador</span></td>
				<td><span>$fechas_mv</span></td>
				<td $color_cuenta><span>$fila6[concepto]</span></td>
				<td >$texto_informacion</td>
				<td><span>$visualizar_array_auxiliares </span></td>
				$cargo_abono_texto
				<td><span>$ $saldo_total</span></td>
				</tr>";
			}

		}
		return $tabla_movimientos_balance ;
	}


	$contenido_balance='<!DOCTYPE html>
	<html lang="es">
	<head>
	<meta charset = "utf-8">
	<title>PANAMOTORS | Balance de Gastos</title>
	<style type="text/css">
	body{
		margin: 0;
		font-family: "geometric";
	}
	.content-pedido{
		width:50%;
		display:block;
		float:left;
		padding: 10px 0px 0 0;
	}

	.content-fecha{
		width:50%;
		display:block;
		float:right;
		padding: 10px 0 0 0;
	}
	.tabla-fecha {
		border-collapse: collapse;
		width: 100%;
		margin: 0px 0 0 0;
		font-size: 10px;
	}
	.tabla-fecha td, .tabla-fecha th {
		border: 0px solid #dddddd;
		text-align: left;
		padding: 0px;
		text-align: center;
	}
	.tabla-fecha tr:nth-child(even) {
		border: 0px solid #dddddd;
		text-align: left;
		padding: 0px;
		text-align: center;
	}  

	.both{
		clear: both;
	}

	.container{
		width: 1024px;
		height: 400px;
		margin: 0;
	}



	.invisible{
		display:block;
		margin:-29px 0 0 0;
	}


	p.titulo-datos-facturar {
		font-size: 10px;
		font-weight: bold;
		display: block;
		text-align: right;
		padding:0 0px 0px 0;
	}
	p.text-datos-facturar {
		font-size: 10px;
		display: block;
	}
	.tabla-datos-facturar td, .tabla-datos-facturar th {

		padding: 0px;

	}
	.tabla-datos-facturar tr{
		margin:0;
	}
	.tabla-datos-facturar tr:nth-child(even) {
		margin:0;
	}


	p.text-datos-obs {
		font-size: 10px;
		height: 18px;
		display: block;
		text-align: right;
		color:gray;
	}
	p.titulo-datos {
		font-size: 10px;
		font-weight: bold;
		display: block;
		text-align: right;
		padding:0 20px 0 0;
	}
	p.text-datos {
		font-size: 10px;
		display: block;
	}
	.tabla-datos td, .tabla-datos th {
		padding: 8px;

	}

	/* Tabla 1*/
	.tabla-1 {
		border-collapse: none;
		width: 100%;
		margin: -10px 0 0 0;
		font-size: 9px;
	}
	.tabla-1 td, .tabla-1 th {
		text-align: left;
		padding: 8px;
            //text-align: center;
	}
	.tabla-1 tr:nth-child(even) {
		text-align: left;
		padding: 8px;
		text-align: center;
	}
	.tabla-1 tr td{
		border-bottom: 1px solid #dddddd;
	}
	.tabla-2 {
		border-collapse: collapse;
		width: 100%;
		margin: 20px 0 30px 0;
		font-size: 10px;
	}
	.tabla-2 td, .tabla-2 th {
		border: 1px solid #dddddd;
		text-align: left;
		padding: 8px;
		text-align: center;
	}

	.tabla-2 tr:nth-child(even) {
		background-color: #dddddd;
		text-align: center;
	}
	.logo-edo-cot{
		width: 100px;
		display: block;
		margin: -20px 0 0 0;
	}
	/*Credito y cobranza*/
	.tabla-credito {
		border-collapse: collapse;
		width: 100%;
		margin: -10px 0 0 0;
		font-size: 10px;
		color: #696969;
	}
	.tabla-credito td, .tabla-credito th {
		border: 0px solid #dddddd;
		text-align: left;
		padding: 8px;
		text-align: center;
	}
	.tabla-credito tr:nth-child(even) {
		border: 0px solid #dddddd;
		text-align: left;
		padding: 8px;
		text-align: center;
	}
	.tabla-datos-entrega{
		margin: 20px 0 0 0;
	}
	p.titulo-datos-entrega {
		font-size: 10px;
		font-weight: bold;
		height: 18px;
		margin: 0px 0 -20px 0;
	}

	.content-total-1{
		width:50%;
		display:block;
		float:left;
	}

	.content-total-2{
		width:50%;
		display:block;
		float:right;
	}
	.titulo-total-final {
		font-size: 22px;
		font-weight: bold;
		display: block;
		text-align: center;
		padding:0 0px 0px 0;
		color:#3f0f2d;
	}
	.titulos-total-final-text{
		font-size: 14px;
		font-weight: bold;
		display: block;
		text-align: center;
		padding:0 0px 0px 0;
	}
	p.titulo-datos-total {
		font-size: 10px;
		font-weight: bold;
		display: block;
		text-align: right;
		padding:0 0px 0px 0;
	}
	p.text-datos-total {
		font-size: 10px;
		display: block;
	}

	.tabla-datos-total td, .tabla-datos-total th {
		padding: 8px;
	}


	.estatus-abono-positivo{
		background-color: #52ef90;
		color:black;
	}
	.estatus-abono-negativo{
		background-color: #ef5353;
		color:black;
	}
	.estatus-abono-neutro{
		background-color: transparent;
		color: black;
	}
	.datos-textos-grande{
		text-align: right;
	}
	.tabla-1-1 {
		border-collapse: collapse;
		width: 100%;
		margin: 0;
		font-size: 8px;
	}
	.tabla-1-1 td, .tabla-1-1 th {
	//border: 1px solid #dddddd;
		text-align: left;
		padding: 3px;
		margin: 0;
            //text-align: center;
	}
	.tabla-1-1 tr:nth-child(even) {
	//border: 1px solid #dddddd;
		text-align: center;
		padding: 0;
	//text-align: center;
	}
	.c-gradiant-v{
		background: linear-gradient(0deg,#882439,#A51D3A,#882439);
		color: #fff;
	}	
	</style>
	</head>
	<body style=" margin: 0; background-image: url(../../img/estado-cuenta-panamotors/fondo.png); background-repeat: no-repeat; background-position: center;">
	<div class="container">

	<div class="header">

	<!-- <img src="../../img/estado-cuenta-panamotors/header_balance_operacion.png" class="img_header" alt=""> -->

	</div>

	<div class="content-pedido">
	<table class="tabla-datos-facturar">
	<tr>
	<td style="width: 20px;">
	<p class="titulo-datos-facturar">Logística:</p>
	</td>
	<td style="width: 257px;">
	<p class="text-datos-facturar">'." "."L".$idorden_logistica_completo.'</p>


	</td>
	</tr>
	</table>
	</div>


	<div class="content-fecha">
	<table class="tabla-fecha">
	<tr>
	<td></td>
	<td>'.$dia.'</td>
	<td>'.$mes.'</td>
	<td>'.$ano.'</td>
	<td>'.$hora.'</td>
	</tr>
	<tr>
	<th>FECHA CORTE:</th>
	<th>DÍA</th>
	<th>MES</th>
	<th>AÑO</th>
	<th>HORA</th>
	</tr>
	</table>
	</div>

	<div class="both"></div>

	<div class="header">
	<img src="../../img/estado-cuenta-panamotors/pleca.png" alt="">
	</div>


	<div class="content-facturar">


	<table class="tabla-1-1">


	<tr>
	<td style="width: 25%; text-align: right;"><b>MONTO TOTAL LOGISTICA:</b></td>
	<td style="width: 25%;">'.$costo_total_logistica.'</td>
	<td style="width: 25%; text-align: right;"><b>ANTICIPO:</b></td>
	<td style="width: 25%;">'.$total_anticipo.'</td>
	</tr>

	<tr>
	<td style="text-align: right;"><b>MÉTODO DE PAGO:</b></td>
	<td>'.$total_metodo_pago.'</td>
	<td style="text-align: right;"><b>MONTO TOTAL CARGOS EFECTIVO:</b></td>
	<td>'.$costo_cargos_efectivo.'</td>
	</tr>

	<tr>
	<td></td>
	<td></td>
	<td style="text-align: right;"><b>REEMBOLSO:</b></td>
	<td>'.$reembolso_logistica.'</td>
	</tr>





	</table>
	</div>

	<br>
	<div class="invisible"></div>

	<br>
	<br>
	<table class="tabla-1">
	<tr>
	<th class="c-gradiant-v">#</th>
	<th class="c-gradiant-v">FECHA</th>
	<th class="c-gradiant-v">CONCEPTO</th>
	<th class="c-gradiant-v">DATOS</th>
	<th class="c-gradiant-v">AUXILIARES</th>
	<th class="c-gradiant-v">CARGOS</th>
	<th class="c-gradiant-v">ABONOS&nbsp;&nbsp;&nbsp;</th>
	<th class="c-gradiant-v">SALDO</th>

	</tr>


	'.$tabla_movimientos_balance.'
	</table>

	</body>
	</html>';





#echo $contenido;


	include("../../MPDF57/mpdf.php");
	$mpdf=new mPDF('s','Letter','','','10','10','28','30');

	$mpdf->SetHTMLHeader('<img src="../../img/estado-cuenta-panamotors/header_balance_operacion.png" class="img_header" alt=""><br>');
	$mpdf->SetHTMLFooter('
		<p class="text-datos-obs"><img src="../../img/estado-cuenta-panamotors/footer2.png" alt="">{PAGENO} de {nb}</p>
		');

	$mpdf->WriteHTML($contenido_balance);
	$mpdf->Output();

	exit;



?>