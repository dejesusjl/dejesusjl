<?php 
require_once('../../bdd.php');
require_once('../../config.php');
include_once "../../phpqrcode/qrlib.php";
include_once "funciones_principales.php";

$reci = $_REQUEST['idrb'];
$id_recibo = base64_decode($reci);

$url = "https://www.panamotorscenter.com/Prod/CCP/Perfiles2/Logistica/recibo_wallet_pdf.php?idrb=$reci"; 
$filename = "../../Codigos_qr_recibos_wallet/codigoqridrb=$reci.png";
$level = 'H'; 
$tamaniopixel = 10;
$tamaniomargen = 1; 

QRcode::png($url,$filename,$level,$tamaniopixel,$tamaniomargen);

$query_recurso = "SELECT * FROM orden_logistica_recurso WHERE idorden_logistica_documentacion = '$id_recibo'";
$result_recurso = mysql_query($query_recurso);

while ($row_recurso = mysql_fetch_array($result_recurso)) {

 $idorden_logistica_recurso = $row_recurso[idorden_logistica_recurso];


 $fecha = date_create($row_recurso[fecha]);
 $fecha_movimiento = date_format($fecha, "d-m-Y");

 $monto = number_format($row_recurso[monto],2);
 $comentarios = $row_recurso[comentarios];
 $comentarios = ucwords(strtolower($comentarios));

 $metodo_pago = $row_recurso[metodo_pago];
 $tipo_cambio = $row_recurso[tipo_cambio];

 $monto_recurso = number_format($row_recurso[monto], 2)." $row_recurso[tipo_moneda]";

 $monto_letras = convertir($row_recurso[monto], $row_recurso[tipo_moneda]);

 $referencia = $row_recurso[referencia];

 $query_documentacion = "SELECT * FROM orden_logistica_documentacion WHERE idorden_logistica_documentacion ='$id_recibo'";
 $result_documentacion = mysql_query($query_documentacion);

 while ($row_documentacion = mysql_fetch_array($result_documentacion)) {

  $id_contacto = $row_documentacion[id_responsable];

  $ahow_id = nombres_datos($row_documentacion[id_responsable], $row_documentacion[tipo_responsable]);
  $porciones_id = explode("|", $ahow_id);

  $calle = ($porciones_id[7] == "") ? "Sin calle" : $porciones_id[7];
  $colonia = ($porciones_id[8] == "") ? "Sin colonia" : $porciones_id[8];
  $municipio = ($porciones_id[6] == "") ? "Sin municipio" : $porciones_id[6];
  $estado = ($porciones_id[5] == "") ? "Sin estado" : $porciones_id[5];





  $query_logistica = "SELECT * FROM orden_logistica WHERE idorden_logistica";
  $result_logistica = mysql_query($query_logistica);

  while ($row_logistica = mysql_fetch_array($result_logistica)) {

    $show_responsble_logistica = nombres_datos($row_logistica[idasigna], $row_logistica[tipo_asignante]);
    $porciones_responsble_logistica = explode("|", $show_responsble_logistica);


  }


  $tipo_entrega_recepcion = ($row_documentacion[tipo] == "Entrega") ? "Entregado por:" : "Recibido por:";

}
}


$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
date_default_timezone_set('America/Mexico_City');

$date = date_create($fecha_recibo);
$dia = date_format($date, 'd');
$mes_aux = date_format($date, 'm');
$mes = ucfirst($meses[$mes_aux-1]);
$ano = date_format($date, 'Y');
$hora = date_format($date, 'H:i:s');

$fecha_impresion = "$dia $mes $ano $hora";

#-------------------------------------------  --------------------------------------------------------------------------------

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vista Recibo</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
  <style>

    .content-formato-pdf{
      width: 800px;
      margin: auto;
    }
    .header, .footer{
      width: 100%;
    }
    .header img, .footer img{
      width: 100%;
    }
    .datos-personales, .content-tablas, .dato-user-impresion{
      margin-top: 30px;
    }
    .content-dato{
      width: 30%;
    }
    .content-dato h6{
      text-align: right;
      font-weight: bold;
    }
    .content-dato-base{
      width: 70%;
      padding-left: 5px;
    }
    .content-dato-base h6{
      color: #616161;
    }
    .tabla-1{
      width: 100%; 
      border: 2px solid #cdcdcd;
    }
    .tabla-1 tr td{
      padding: 10px;
    }
    .tabla-1 tr:nth-child(even){
      background: #F3F3F3;
    } 
    .dato-user-impresion p{
      font-weight: bold;
    }
    .dato-user-impresion span{
      font-weight: normal;
      color: #616161;
    }
    .leyenda{
      text-align: left; 
      color: #836C71; 
      margin-top: 80px;
      font-size: 8px;
    }
    .dato-i{
      width: 100%;
    }
    @media (max-width: 767px){
      .content-formato-pdf{
        width: 100%;
      }
      .content-center-flex{
        display: flex;
        justify-content: center;
      }
      .content-datos-adicional{
        margin-top: 30px;
      }
      .content-tablas, .dato-user-impresion, .content-leyenda-qr{
        padding: 0px 10px;
      }
      .a-800{
        width: 80%;
      }
    }
    @media (max-width: 575px){
      .content-dato h6, .content-dato-base h6, .content-datos-adicional h6, .dato-user-impresion p, .leyenda{
        font-size: 12px;
      }
      .tabla-1 tbody tr td{
        font-size: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="content-formato-pdf">
    <picture class="header">
      <img src="../../img/estado-cuenta-panamotors/header_nombre_recibo.png" alt="">
    </picture>
    <div class="datos-personales">
      <div class="row m-0">
        <div class="col-md-6 content-center-flex p-0">
          <div class="a-800">
            <div class="d-flex dato-i">
              <div class="content-dato">
                <h6>ID: </h6>
              </div>
              <div class="content-dato-base">
                <h6><?php echo $id_contacto; ?></h6>
              </div>
            </div>
            <div class="d-flex dato-i">
              <div class="content-dato">
                <h6>Nombre: </h6>
              </div>
              <div class="content-dato-base">
                <h6><?php echo $porciones_id[10]; ?></h6>
              </div>
            </div>
            <div class="d-flex dato-i">
              <div class="content-dato">
                <h6>Calle: </h6>
              </div>
              <div class="content-dato-base">
                <h6><?php echo $calle; ?></h6>
              </div>
            </div>
            <div class="d-flex dato-i">
              <div class="content-dato">
                <h6>Colonia: </h6>
              </div>
              <div class="content-dato-base">
                <h6><?php echo $colonia; ?></h6>
              </div>
            </div>
            <div class="d-flex dato-i">
              <div class="content-dato">
                <h6>Municipio: </h6>
              </div>
              <div class="content-dato-base">
                <h6><?php echo $municipio; ?></h6>
              </div>
            </div>
            <div class="d-flex dato-i">
              <div class="content-dato">
                <h6>Estado: </h6>
              </div>
              <div class="content-dato-base">
                <h6><?php echo $estado; ?></h6>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 content-center-flex p-0">
          <div class="content-datos-adicional a-800">
            <div class="d-flex dato-i">
              <div class="content-dato">
                <h6>Fecha: </h6>
              </div>
              <div class="content-dato-base">
                <h6><?php echo $fecha_movimiento; ?></h6>
              </div>
            </div>
            <div class="d-flex dato-i">
              <div class="content-dato">
                <h6>Recibo:</h6>
              </div>
              <div class="content-dato-base">
                <h6><?php echo $referencia; ?></h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="content-tablas">
      <div class="table-responsive">
        <table class="tabla-1 table">
          <tr>
            <td style="width: 33%; background: #ECECEC;"><b>Movimiento</b></td>
            <td style="width: 33%; background: #ECECEC;"><b>Forma de pago</b></td>
            <td style="width: 33%; background: #ECECEC;"><b>Tipo de cambio</b></td>
          </tr>
          <tr>
            <td><?php echo $comentarios; ?></td>
            <td><?php echo $metodo_pago; ?></td>
            <td><?php echo $tipo_cambio; ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="content-tablas">
      <div class="table-responsive">
        <table class="tabla-1 table">
          <tr>
            <td style="width: 20%;"><b>TOTAL: </b></td>
            <td style="width: 80%;"> $ <?php echo $monto_recurso; ?></td>
          </tr>
          <tr>
            <td></td>
            <td><?php echo $monto_letras; ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="dato-user-impresion">
      <p><?php echo $tipo_entrega_recepcion; ?> <span> <?php echo $porciones_responsble_logistica[10]; ?> </span></p>
      <p>Fecha impresión: <span><?php echo $fecha_impresion; ?></span></p>
    </div>
    <div class="con d-flex">
      <div style="width: 80%;">
        <p class="leyenda" style="width: 100%;">El presente recibo no es válido si los datos desplegados con la lectura del QR son diferentes al impreso. Valide la información y asegúrese de recibir un comprobante válido.</p>
      </div>
      <div class="d-flex justify-content-end" style="width: 20%;">
        <img src="<?php echo $filename; ?>" style="width: 100px; height: 100px;">
      </div>
    </div>
    <picture class="footer">
      <img src="../../img/estado-cuenta-panamotors/footer2.png" alt="">
    </picture>
  </div>
</body>
</html>