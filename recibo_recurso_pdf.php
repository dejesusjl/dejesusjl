<?php

$reci=$_REQUEST['idrb'];
$id_recibo=base64_decode($reci);




include_once "../../config.php"; 


$query_reembolso = "SELECT * FROM orden_logistica_recurso WHERE idorden_logistica_documentacion = '$id_recibo'";
$result_reembolso = mysql_query($query_reembolso);

while ($row_reembolso = mysql_fetch_array($result_reembolso)) {
  $num ++;

  $idorden_logistica_recurso = "$row_reembolso[idorden_logistica_recurso]";
  $fecha = "$row_reembolso[fecha]";
  $monto = number_format("$row_reembolso[monto]",2);
  $emisora_institucion = "$row_reembolso[emisora_institucion]";
  $emisora_agente = "$row_reembolso[emisora_agente]";
  $receptora_institucion = "$row_reembolso[receptora_institucion]";
  $receptora_agente = "$row_reembolso[receptora_agente]";
  $concepto = "$row_reembolso[concepto]";
  $metodo_pago = "$row_reembolso[metodo_pago]";
  $monto_letras = convertir($row_reembolso[monto], $row_reembolso[tipo_moneda]);
  $idbalance_gastos = "$row_reembolso[idbalance_gastos]";
  $comentarios = "$row_reembolso[comentarios]";
  $columna_a = "$row_reembolso[columna_a]";
  $referencia = "$row_reembolso[referencia]";

  $nombre_responsable = ($row_reembolso[concepto] == "Entrega") ? $receptora_institucion : $receptora_agente ;

}





$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
date_default_timezone_set('America/Mexico_City');

$date = date_create($fecha_recibo);
$dia=date_format($date, 'd');
$mes_aux=date_format($date, 'm');
$mes=ucfirst($meses[$mes_aux-1]);
$ano=date_format($date, 'Y');
$hora=date_format($date, 'H:i:s');






$n2=strlen($idorden_logistica_recurso);
$n2_aux=6-$n1;
$mat2="";

for ($i2=0; $i2 <$n2_aux ; $i2++) { 
  $mat2.="0";
}

$id_contacto_completo = "RL".$mat2.$idorden_logistica_recurso;



///Inicio de Letras a numeros
function unidad($numuero){ 
  switch ($numuero) 
  { 
    case 9: 
    { 
      $numu = "NUEVE"; 
      break; 
    } 
    case 8: 
    { 
      $numu = "OCHO"; 
      break; 
    } 
    case 7: 
    { 
      $numu = "SIETE"; 
      break; 
    } 
    case 6: 
    { 
      $numu = "SEIS"; 
      break; 
    } 
    case 5: 
    { 
      $numu = "CINCO"; 
      break; 
    } 
    case 4: 
    { 
      $numu = "CUATRO"; 
      break; 
    } 
    case 3: 
    { 
      $numu = "TRES"; 
      break; 
    } 
    case 2: 
    { 
      $numu = "DOS"; 
      break; 
    } 
    case 1: 
    { 
      $numu = "UNO"; 
      break; 
    } 
    case 0: 
    { 
      $numu = ""; 
      break; 
    } 
  } 
  return $numu; 
} 

function decena($numdero){ 

  if ($numdero >= 90 && $numdero <= 99) 
  { 
    $numd = "NOVENTA "; 
    if ($numdero > 90) 
      $numd = $numd."Y ".(unidad($numdero - 90)); 
  } 
  else if ($numdero >= 80 && $numdero <= 89) 
  { 
    $numd = "OCHENTA "; 
    if ($numdero > 80) 
      $numd = $numd."Y ".(unidad($numdero - 80)); 
  } 
  else if ($numdero >= 70 && $numdero <= 79) 
  { 
    $numd = "SETENTA "; 
    if ($numdero > 70) 
      $numd = $numd."Y ".(unidad($numdero - 70)); 
  } 
  else if ($numdero >= 60 && $numdero <= 69) 
  { 
    $numd = "SESENTA "; 
    if ($numdero > 60) 
      $numd = $numd."Y ".(unidad($numdero - 60)); 
  } 
  else if ($numdero >= 50 && $numdero <= 59) 
  { 
    $numd = "CINCUENTA "; 
    if ($numdero > 50) 
      $numd = $numd."Y ".(unidad($numdero - 50)); 
  } 
  else if ($numdero >= 40 && $numdero <= 49) 
  { 
    $numd = "CUARENTA "; 
    if ($numdero > 40) 
      $numd = $numd."Y ".(unidad($numdero - 40)); 
  } 
  else if ($numdero >= 30 && $numdero <= 39) 
  { 
    $numd = "TREINTA "; 
    if ($numdero > 30) 
      $numd = $numd."Y ".(unidad($numdero - 30)); 
  } 
  else if ($numdero >= 20 && $numdero <= 29) 
  { 
    if ($numdero == 20) 
      $numd = "VEINTE "; 
    else 
      $numd = "VEINTI".(unidad($numdero - 20)); 
  } 
  else if ($numdero >= 10 && $numdero <= 19) 
  { 
    switch ($numdero){ 
      case 10: 
      { 
        $numd = "DIEZ "; 
        break; 
      } 
      case 11: 
      { 
        $numd = "ONCE "; 
        break; 
      } 
      case 12: 
      { 
        $numd = "DOCE "; 
        break; 
      } 
      case 13: 
      { 
        $numd = "TRECE "; 
        break; 
      } 
      case 14: 
      { 
        $numd = "CATORCE "; 
        break; 
      } 
      case 15: 
      { 
        $numd = "QUINCE "; 
        break; 
      } 
      case 16: 
      { 
        $numd = "DIECISEIS "; 
        break; 
      } 
      case 17: 
      { 
        $numd = "DIECISIETE "; 
        break; 
      } 
      case 18: 
      { 
        $numd = "DIECIOCHO "; 
        break; 
      } 
      case 19: 
      { 
        $numd = "DIECINUEVE "; 
        break; 
      } 
    } 
  } 
  else 
    $numd = unidad($numdero); 
  return $numd; 
} 

function centena($numc){ 
  if ($numc >= 100) 
  { 
    if ($numc >= 900 && $numc <= 999) 
    { 
      $numce = "NOVECIENTOS "; 
      if ($numc > 900) 
        $numce = $numce.(decena($numc - 900)); 
    } 
    else if ($numc >= 800 && $numc <= 899) 
    { 
      $numce = "OCHOCIENTOS "; 
      if ($numc > 800) 
        $numce = $numce.(decena($numc - 800)); 
    } 
    else if ($numc >= 700 && $numc <= 799) 
    { 
      $numce = "SETECIENTOS "; 
      if ($numc > 700) 
        $numce = $numce.(decena($numc - 700)); 
    } 
    else if ($numc >= 600 && $numc <= 699) 
    { 
      $numce = "SEISCIENTOS "; 
      if ($numc > 600) 
        $numce = $numce.(decena($numc - 600)); 
    } 
    else if ($numc >= 500 && $numc <= 599) 
    { 
      $numce = "QUINIENTOS "; 
      if ($numc > 500) 
        $numce = $numce.(decena($numc - 500)); 
    } 
    else if ($numc >= 400 && $numc <= 499) 
    { 
      $numce = "CUATROCIENTOS "; 
      if ($numc > 400) 
        $numce = $numce.(decena($numc - 400)); 
    } 
    else if ($numc >= 300 && $numc <= 399) 
    { 
      $numce = "TRESCIENTOS "; 
      if ($numc > 300) 
        $numce = $numce.(decena($numc - 300)); 
    } 
    else if ($numc >= 200 && $numc <= 299) 
    { 
      $numce = "DOSCIENTOS "; 
      if ($numc > 200) 
        $numce = $numce.(decena($numc - 200)); 
    } 
    else if ($numc >= 100 && $numc <= 199) 
    { 
      if ($numc == 100) 
        $numce = "CIEN "; 
      else 
        $numce = "CIENTO ".(decena($numc - 100)); 
    } 
  } 
  else 
    $numce = decena($numc); 

  return $numce;  
} 

function miles($nummero){ 
  if ($nummero >= 1000 && $nummero < 2000){ 
    $numm = "MIL ".(centena($nummero%1000)); 
  } 
  if ($nummero >= 2000 && $nummero <10000){ 
    $numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000)); 
  } 
  if ($nummero < 1000) 
    $numm = centena($nummero); 

  return $numm; 
} 

function decmiles($numdmero){ 
  if ($numdmero == 10000) 
    $numde = "DIEZ MIL"; 
  if ($numdmero > 10000 && $numdmero <20000){ 
    $numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));  
  } 
  if ($numdmero >= 20000 && $numdmero <100000){ 
    $numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000)); 
  } 
  if ($numdmero < 10000) 
    $numde = miles($numdmero); 

  return $numde; 
} 

function cienmiles($numcmero){ 
  if ($numcmero == 100000) 
    $num_letracm = "CIEN MIL"; 
  if ($numcmero >= 100000 && $numcmero <1000000){ 
    $num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));  
  } 
  if ($numcmero < 100000) 
    $num_letracm = decmiles($numcmero); 
  return $num_letracm; 
} 

function millon($nummiero){ 
  if ($nummiero >= 1000000 && $nummiero <2000000){ 
    $num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000)); 
  } 
  if ($nummiero >= 2000000 && $nummiero <10000000){ 
    $num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000)); 
  } 
  if ($nummiero < 1000000) 
    $num_letramm = cienmiles($nummiero); 

  return $num_letramm; 
} 

function decmillon($numerodm){ 
  if ($numerodm == 10000000) 
    $num_letradmm = "DIEZ MILLONES"; 
  if ($numerodm > 10000000 && $numerodm <20000000){ 
    $num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));  
  } 
  if ($numerodm >= 20000000 && $numerodm <100000000){ 
    $num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));  
  } 
  if ($numerodm < 10000000) 
    $num_letradmm = millon($numerodm); 

  return $num_letradmm; 
} 

function cienmillon($numcmeros){ 
  if ($numcmeros == 100000000) 
    $num_letracms = "CIEN MILLONES"; 
  if ($numcmeros >= 100000000 && $numcmeros <1000000000){ 
    $num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000)); 
  } 
  if ($numcmeros < 100000000) 
    $num_letracms = decmillon($numcmeros); 
  return $num_letracms; 
} 

function milmillon($nummierod){ 
  if ($nummierod >= 1000000000 && $nummierod <2000000000){ 
    $num_letrammd = "MIL ".(cienmillon($nummierod%1000000000)); 
  } 
  if ($nummierod >= 2000000000 && $nummierod <10000000000){ 
    $num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000)); 
  } 
  if ($nummierod < 1000000000) 
    $num_letrammd = cienmillon($nummierod); 

  return $num_letrammd; 
} 


function convertir($numero, $t){ 
  $num = str_replace(",","",$numero); 
  $num = number_format($num,2,'.',''); 
  $cents = substr($num,strlen($num)-2,strlen($num)-1); 
  $num = (int)$num; 
  $numf = milmillon($num); 

  if ($t == "USD") {
    return $numf."".$cents." ".$t; 
  }elseif ($t == "CAD") {
    return $numf."".$cents." ".$t; 
  }elseif ($t == "MXN") {
    return $numf."PESOS ".$cents."/100 M/N";
  }

} 
///Fin de funcion de letras a numeros

$contenido='
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PANAMOTORS | Recibo</title>
<style type="text/css">
  body{
    margin: 0;
    font-family: "geometric" !important;
  }

  .img_header{
    margin: 0px 0 0 0;
  }

  .content-pedido{
    width:50%;
    display:block;
    float:left;
    padding: 10px 0px 0 0;
  }

  /*fecha*/

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




  .pleca-margin-top{

  }

  .container{
    width: 1024px;
    height: 400px;
    margin: 0;
  }

  /*Content-datos*/
  .content-datos{
    margin: 10px 0 0 0;
  }

  .cliente-img{
    width: 100px;
    margin: -15px 0 0 0;
  }
  
  table.tabla-datos {
    margin: 0px 0 0 0;
    height: 100px;
    display: block;
    background-color: red;
  }

  .invisible{
    display:block;
    margin:-29px 0 0 0;
  }

  /*Content-datos-facturar*/

  p.titulo-datos-facturar-titulo{
    font-size: 10px;
    font-weight: bold;
    height: 18px;
    display: block;
    padding:0 0px -10px 0;
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
    padding: 8px;
  }

  /*Content-datos-observaciones*/

  .content-datos-obs{
    margin:0px 0 0 0;
  }

  p.titulo-datos-obs {
    font-size: 10px;
    font-weight: bold;
    height: 18px;
    display: block;
    padding:0 20px 0 0;
  }

  p.text-datos-obs {
    font-size: 9px;
    height: 18px;
    display: block;
    color:gray;
  }

  p.text-datos-obs-2 {
    font-size: 7px;
    height: 18px;
    display: block;
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
    width: 100%;
    margin: -10px 0 0 0;
    font-size: 11px;
    background-image: url(../../img/estado-cuenta-panamotors/fondo_recibo.png);
    background-repeat: no-repeat;
    background-position: center;
    border-collapse: none;
  }

  .tabla-1 td {

    text-align: left;
    padding: 4px;
    font-size: 10px;
  }

  .tabla-1 tr th {
    padding: 4px;
    text-align: right;
    border-right: 2px solid #882439;
  }

  .tabla-1 tr:nth-child(even) {

    text-align: left;
    padding: 8px;
    text-align: center;
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



  /*total-1*/

  .content-total-1{
    width:50%;
    display:block;
    float:left;
  }

  /*total-2*/

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
    background-color: white;
    color: black;
  }

  .datos-textos-grande{
    text-align: right;
  }

  .header-segundo {
    margin-top: 35px;
  }
  </style>
</head>
<body>

  <div class="container">
  <div style=" margin: 0; background-image: url(../../img/estado-cuenta-panamotors/fondo_recibo.png); background-repeat: no-repeat; background-position: center; background-size: 30%;">
  <div class="header">
  <img src="../../img/estado-cuenta-panamotors/header_nombre_recibo.png" class="img_header" alt="">
  </div>
  <!--fin-header-->

  <!--pedido-->
  <div class="content-pedido">
  <table class="tabla-datos-facturar">
  <tr>
  <td style="width: 100px;">
  <p class="titulo-datos-facturar">No. Recibo:</p>
  </td>
  <td style="width: 157px;">
  <p class="text-datos-facturar">'.$id_contacto_completo.'</p>
  </td>
  </tr>
  </table>
  </div>
  <!--fin-pedido-->

  <!--table-fecha-->
  <div class="content-fecha">
  <table class="tabla-fecha">
  <tr>
  <td></td>
  <td>'.$dia.'</td>
  <td>'.$mes.'</td>
  <td>'.$ano.'</td>        
  </tr>
  <tr>
  <th>FECHA</th>
  <th>DÍA</th>
  <th>MES</th>
  <th>AÑO</th>
  </tr>
  </table>
  </div>
  <!--fin-table-fecha-->

  <div class="both">
  </div>

  <!--pleca-->
  <!--<div class="header">
  <img src="../../img/estado-cuenta-panamotors/pleca.png" alt="">
  </div> -->
  <!--fin-pleca-->

  <div class="invisible">
  </div>
  <br>

  <table class="tabla-1" style="margin-top: 10px;">
  <tr>
  <th>Concepto:</th>
  <td colspan="3" align="left">'.$concepto.'</td>
  </tr>
  <tr>
  <th>Monto:</th>
  <td align="left">$ '.$monto .'</td>
  </tr>

  <tr>
  <th>Monto en letra: </th>
  <td colspan="3" align="left">'.$monto_letras.'</td>
  </tr>
  <tr>
  <th>Método de pago: </th>
  <td align="left">'.$metodo_pago.'</td>
  <th>Referencia: </th>
  <td align="left">'.$referencia.'</td>
  </tr>
  <tr>
  <th>I. Emisora: </th>
  <td align="left">'.$emisora_institucion.'</td>
  <th>A. Emisor: </th>
  <td align="left">'.$emisora_agente.'</td>
  </tr>
  <tr>
  <th>I. Receptora: </th>
  <td align="left">'.$receptora_institucion.'</td>
  <th>A. Receptor: </th>
  <td align="left">'.$receptora_agente.'</td>
  </tr>
  <tr>
  <th>Comentarios: </th>
  <td colspan="3" align="left">'.$comentarios.'</td>
  </tr>
  </table>
  <!--fin-content-tabla-2-->

  <div class="content-datos-obs"><br>
  <p class="text-datos-obs" align="center">______________________________________________</p>
  <p class="text-datos-obs" align="center">'.$nombre_responsable.'</p>
  </div>

  <!--table-entrega-->
  <div class="content-datos-obs">
  <p class="text-datos-obs-2" align="center"><b>NO es válido este recibo sino lleva sello.</b></p>
  <p class="text-datos-obs" align="center"><img style="display: block; margin-top: -10px;" src="../../img/estado-cuenta-panamotors/footer2.png" alt=""></p>
  </div>
  <!--fin-table-entrega-->
  </div>
  <!--pleca-->
  <div class="header">
  <img src="../../img/estado-cuenta-panamotors/pleca.png" alt="">
  </div>
  <!--fin-pleca-->

  <!--
  <div class="footer">
  <img src="../../img/estado-cuenta-panamotors/footer.png" alt="">
  </div>-->
  <!--fin-footer-->


  <!--Inicio Segundo Reciboooo-->

  <div style="background-image: url(../../img/estado-cuenta-panamotors/fondo_recibo.png); background-repeat: no-repeat; background-position: center; background-size: 30%;">
  <div class="header-segundo">
  <img src="../../img/estado-cuenta-panamotors/header_nombre_recibo.png" class="img_header" alt="">
  </div>
  <!--fin-header-->

  <!--pedido-->
  <div class="content-pedido">
  <table class="tabla-datos-facturar">
  <tr>
  <td style="width: 100px;">
  <p class="titulo-datos-facturar">No. Recibo:</p>
  </td>
  <td style="width: 157px;">
  <p class="text-datos-facturar">'.$id_contacto_completo.'</p>
  </td>
  </tr>
  </table>
  </div>
  <!--fin-pedido-->

  <!--table-fecha-->
  <div class="content-fecha">
  <table class="tabla-fecha">
  <tr>
  <td></td>
  <td>'.$dia.'</td>
  <td>'.$mes.'</td>
  <td>'.$ano.'</td>        
  </tr>
  <tr>
  <th>FECHA</th>
  <th>DÍA</th>
  <th>MES</th>
  <th>AÑO</th>
  </tr>
  </table>
  </div>
  <!--fin-table-fecha-->

  <div class="both">
  </div>

  <!--pleca-->
  <!--<div class="header">
  <img src="../../img/estado-cuenta-panamotors/pleca.png" alt="">
  </div> -->
  <!--fin-pleca-->

  <div class="invisible">
  </div>
  <br>
  
  <div>
  <table class="tabla-1" style="margin-top: 10px;">
  <tr>
  <th>Concepto:</th>
  <td colspan="3" align="left">'.$concepto.'</td>
  </tr>
  <tr>
  <th>Monto:</th>
  <td align="left">$ '.$monto .'</td>
  </tr>

  <tr>
  <th>Monto en letra: </th>
  <td colspan="3" align="left">'.$monto_letras.'</td>
  </tr>
  <tr>
  <th>Método de pago: </th>
  <td align="left">'.$metodo_pago.'</td>
  <th>Referencia: </th>
  <td align="left">'.$referencia.'</td>
  </tr>
  <tr>
  <th>I. Emisora: </th>
  <td align="left">'.$emisora_institucion.'</td>
  <th>A. Emisor: </th>
  <td align="left">'.$emisora_agente.'</td>
  </tr>
  <tr>
  <th>I. Receptora: </th>
  <td align="left">'.$receptora_institucion.'</td>
  <th>A. Receptor: </th>
  <td align="left">'.$receptora_agente.'</td>
  </tr>
  <tr>
  <th>Comentarios: </th>
  <td colspan="3" align="left">'.$comentarios.'</td>
  </tr>
  </table>
  <!--fin-content-tabla-2-->

  <div class="content-datos-obs"><br>
  <p class="text-datos-obs" align="center">______________________________________________</p>
  <p class="text-datos-obs" align="center">'.$nombre_responsable.'</p>
  </div>

  <!--table-entrega-->
  <div class="content-datos-obs">
  <p class="text-datos-obs-2" align="center"><b>NO es válido este recibo sino lleva sello.</b></p>
  <p class="text-datos-obs" align="center"><img style="display: block; margin-top: -10px;" src="../../img/estado-cuenta-panamotors/footer2.png" alt=""></p>
  </div>
  <!--fin-table-entrega-->
  </div>

  <!--
  <div class="footer">
  <img src="../../img/estado-cuenta-panamotors/footer.png" alt="">
  </div>-->
  <!--fin-footer-->

  </div>

  
  </body>

</html>';

#echo $contenido;

include("../../MPDF57/mpdf.php");

/*

$mpdf->SetHTMLHeader('<img src="../../img/estado-cuenta-panamotors/header.png" class="img_header" alt=""><br>');
$mpdf->SetHTMLFooter('
  <p class="text-datos-obs">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; INFORMACIÓN CONFIDENCIAL Y RESTRINGIDA PROPIEDAD DE PANAMOTORS CENTER S.A. DE C.V. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; {PAGENO} de {nb}</p>
  ');
*/

  $mpdf=new mPDF('s','Letter','','','10','10','5','5');
  $mpdf->WriteHTML($contenido);

  $mpdf->Output("Recibo".$fecha."$receptora_agente.pdf","I");
  
  exit;

  ?>