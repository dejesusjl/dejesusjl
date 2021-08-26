<?php 
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
date_default_timezone_set('America/Mexico_City');
$fecha_guardado=date("Y-m-d H:i:s"); 
$fecha_creacion = date("d-m-Y H:i"); 
$usuario_creador=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];
// header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada 
// header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos 
// header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE 
// header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE 
$random = rand(5, 15);


$query_nomenclatura = "SELECT * FROM usuarios WHERE idusuario = '$usuario_creador'";
$result_nomenclatura = mysql_query($query_nomenclatura);
while ($row_nomenclatura = mysql_fetch_array($result_nomenclatura)) {
  $sigla_ccp = "$row_nomenclatura[sigla_ccp]";
  
}

$query = "SELECT * FROM empleados WHERE columna_b = '$sigla_ccp'";
$resultq = mysql_query($query);
while ($rowq = mysql_fetch_array($resultq)) {
  $id_colaborador = "$rowq[idempleados]";
  $nombre_colaborador = "$rowq[nombre]". " "."$rowq[apellido_paterno]"." "."$rowq[apellido_materno]";
}
/////////////////////////////////////////////////////////////////////////////////////////////


$query_total_logisticas = "SELECT * FROM orden_logistica";
$result_total_logisticas = mysql_query($query_total_logisticas);
$total_logisticas = number_format(mysql_num_rows($result_total_logisticas));
$ultima_logistica = base64_encode(mysql_num_rows($result_total_logisticas));


$query_logisticas_canceladas = "SELECT * FROM  orden_logistica WHERE idasigna = 'N/A'";
$result_logisticas_canceladas = mysql_query($query_logisticas_canceladas);
$total_logisticas_canceladas = number_format(mysql_num_rows($result_logisticas_canceladas));


$query_total_logisticas = "SELECT * FROM orden_logistica WHERE idorden_logistica = '1'";
$result_total_logisticas = mysql_query($query_total_logisticas);

while ($row_logisticas = mysql_fetch_array($result_total_logisticas)) {

  $primer_fecha = $row_logisticas[fecha_solicitud];
  $fecha_logistica = date_create($primer_fecha);
  $fecha_primer_logistica = date_format($fecha_logistica, 'd-m-Y H:i');
}


//---------Departamento con mas logisticas -------------------------------------------------

$array_departamentos = array();

$query_departamento_logisticas = "SELECT catalogo_departamento.nombre,count(orden_logistica.iddepartamento) FROM orden_logistica inner join catalogo_departamento WHERE orden_logistica.iddepartamento = catalogo_departamento.idcatalogo_departamento group by iddepartamento,iddepartamento order by count(iddepartamento) desc limit 3";
$result_departamento_logisticas = mysql_query($query_departamento_logisticas);

while ($row_departamento_logisticas = mysql_fetch_array($result_departamento_logisticas)) {

  array_push($array_departamentos, trim($row_departamento_logisticas[0]), trim($row_departamento_logisticas[1]));
  
}
//---------Colaboradores con mas logisticas -------------------------------------------------

$array_colaboradores = array();

$query_usuarios_logisticas = "SELECT empleados.columna_b, count(orden_logistica.idsolicitante) FROM orden_logistica INNER JOIN empleados WHERE orden_logistica.idsolicitante = empleados.idempleados group by orden_logistica.idsolicitante, empleados.columna_b order by count(orden_logistica.idsolicitante) desc";
$result_usuarios_logisticas = mysql_query($query_usuarios_logisticas);

while ($row_usuarios_logisticas = mysql_fetch_array($result_usuarios_logisticas)) {

  array_push($array_colaboradores, trim($row_usuarios_logisticas[0]), trim($row_usuarios_logisticas[1]));
  
}


//---------Tipo de Orden con mas logisticas -------------------------------------------------

$array_tipo_orden = array();

$query_count_orden_old = "SELECT catalogo_orden_logistica.nombre_orden, count(orden_logistica.idcatalogo_orden_logistica) AS total_orden FROM orden_logistica
INNER JOIN 
catalogo_orden_logistica 
WHERE
orden_logistica.idcatalogo_orden_logistica = catalogo_orden_logistica.idcatalogo_orden_logistica
GROUP BY catalogo_orden_logistica.nombre_orden ORDER BY total_orden desc limit 3
";
$result_count_orden_old = mysql_query($query_count_orden_old);

while ($row_count_orden_old = mysql_fetch_array($result_count_orden_old)) {

  array_push($array_tipo_orden, trim($row_count_orden_old[0]), trim($row_count_orden_old[1]));
  
  
}

//---------Clientes con mas logisticas -------------------------------------------------
#-------------------------------------------Funcion Nombres y Tipo--------------------------------------------------------------------------------

function nombres_datos($id_id, $type_type) {

  if ($type_type == "Cliente") {

    $query_cliente = "SELECT * FROM contactos WHERE idcontacto = '$id_id'";
    $result_cliente = mysql_query($query_cliente);

    if (mysql_num_rows($result_cliente) >= 1) {

      while ($row_cliente = mysql_fetch_array($result_cliente)) {
        $nombre = "$row_cliente[nombre]"; 
        $apellidos = "$row_cliente[apellidos]"; 
        $alias = "$row_cliente[alias]"; 
        $telefono = "$row_cliente[telefono_celular]"; 
        $telefono_otro = "$row_cliente[telefono_otro]"; 
        $estado_cliente = "$row_cliente[estado]"; 
        $municipio_cliente = "$row_cliente[delmuni]"; 
        $calle_cliente = "$row_cliente[calle]"; 
        $colonia_cliente = "$row_cliente[colonia]"; 
        $cp_cliente = "$row_cliente[cp_cliente]";
      }
      $concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Cliente";
    }else{
      $concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Cliente";
    }

  }elseif ($type_type == "Proveedor") {

    $query_proveedor = "SELECT * FROM proveedores WHERE idproveedores = '$id_id'";
    $result_proveedor = mysql_query($query_proveedor);

    if (mysql_num_rows($result_proveedor) >= 1) {

      while ($row_proveedor = mysql_fetch_array($result_proveedor)) {
        $nombre = trim("$row_proveedor[nombre]");
        $apellidos = trim("$row_proveedor[apellidos]");
        $alias = trim("$row_proveedor[alias]");
        $telefono = trim("$row_proveedor[telefono_celular]");
        $telefono_otro = trim("$row_proveedor[telefono_otro]");
        $estado_cliente = trim("$row_proveedor[estado]");
        $municipio_cliente = trim("$row_proveedor[delmuni]");
        $calle_cliente = trim("$row_proveedor[calle]");
        $colonia_cliente = trim("$row_proveedor[colonia]");
        $cp_cliente = trim("$row_proveedor[cp_cliente]");
      }
      $concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor";
    }else{
      $concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor";
    }


  }elseif ($type_type == "Proveedor Temporal") {

    $query_proveedor_tem = "SELECT * FROM orden_logistica_proveedores WHERE idorden_logistica_proveedores = '$id_id'";
    $result_proveedor_tem = mysql_query($query_proveedor_tem);

    if (mysql_num_rows($result_proveedor_tem) >= 1) {

      while ($row_proveedor_tem = mysql_fetch_array($result_proveedor_tem)) {
        $nombre = trim("$row_proveedor_tem[nombre]");
        $apellidos = trim("$row_proveedor_tem[apellidos]");
        $alias = trim("$row_proveedor_tem[alias]");
        $telefono = trim("$row_proveedor_tem[telefono_celular]");
        $telefono_otro = trim("$row_proveedor_tem[telefono_otro]");
        $estado_cliente = trim("$row_proveedor_tem[estado]");
        $municipio_cliente = trim("$row_proveedor_tem[delmuni]");
        $calle_cliente = trim("$row_proveedor_tem[calle]");
        $colonia_cliente = trim("$row_proveedor_tem[colonia]");
        $cp_cliente = trim("$row_proveedor_tem[codigo_postal]");
      }
      $concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nombre $apellidos|Proveedor Temporal";
    }else{
      $concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Proveedor Temporal";
    }

  }elseif ($type_type == "Colaborador") {

    $query_colaborador = "SELECT * FROM empleados WHERE idempleados = '$id_id'";
    $result_colaborador = mysql_query($query_colaborador);

    if (mysql_num_rows($result_colaborador) >= 1) {

      while ($row_colaborador = mysql_fetch_array($result_colaborador)) {
        $nombre = "$row_colaborador[nombre]";
        $apellidos = trim("$row_colaborador[apellido_paterno]")." ".trim("$row_colaborador[apellido_materno]"); 
        $alias = trim("$row_colaborador[columna_b]");
        $telefono = trim("$row_colaborador[telefono_personal]");
        $telefono_otro = trim("$row_colaborador[telefono_emergencia]");
        $estado_cliente = trim("$row_colaborador[estado]");
        $municipio_cliente = trim("$row_colaborador[municipio]");
        $calle_cliente = trim("$row_colaborador[calle_numero]");
        $colonia_cliente = trim("$row_colaborador[colonia]");
        $cp_cliente = trim("$row_colaborador[cp]");
        $nomenclatura_co = trim("$row_colaborador[columna_b]");
      }
      $concatenacion = "$nombre|$apellidos|$alias|$telefono|$telefono_otro|$estado_cliente|$municipio_cliente|$calle_cliente|$colonia_cliente|$cp_cliente|$nomenclatura_co|Colaborador";
    }else{
      $concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Colaborador";
    }

  }else{
    $concatenacion = "Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente|Pendiente";
  }

  return $concatenacion;

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="description" content="" >
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--    <meta http-equiv="Expires" content="0">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache"> -->
  <!--Meta Responsive tag-->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,user-scalable=no">
  
  <!--Bootstrap CSS-->
  <link rel="stylesheet" href="../../assets/css/bootstrap.min.css?<?php echo $random; ?>">
  <!--Custom style.css-->
  <link rel="stylesheet" href="../../assets/css/quicksand.css?<?php echo $random; ?>">
  <link rel="stylesheet" href="../../assets/css/style.css?<?php echo $random; ?>">
  <link rel="stylesheet" href="../../assets/css/mod_style_datatables.css?<?php echo $random; ?>">
  <!--Font Awesome-->
  <link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css?<?php echo $random; ?>">
  <link rel="stylesheet" href="../../assets/css/fontawesome.css?<?php echo $random; ?>">
  <!--Animate CSS-->
  <link rel="stylesheet" href="../../assets/css/animate.min.css?<?php echo $random; ?>">
  <!--Chartist CSS-->
  <link rel="stylesheet" href="../../assets/css/chartist.min.css?<?php echo $random; ?>">
  <!--Morris Css-->
  <link rel="stylesheet" href="../../assets/css/morris.css?<?php echo $random; ?>">
  <!--Map-->
  <link rel="stylesheet" href="../../assets/css/jquery-jvectormap-2.0.2.css?<?php echo $random; ?>">
  <!--Bootstrap Calendar-->
  <link rel="stylesheet" href="../../assets/js/calendar/bootstrap_calendar.css?<?php echo $random; ?>">
  <!--Nice select -->
  <link rel="stylesheet" href="../../assets/css/nice-select.css?<?php echo $random; ?>">
  
  <!-- Favicon -->
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
  
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

  <title>CCP | Logística</title>

  <link href="../../plugins/datatables/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

  <!-- DataTables Responsive CSS -->
  <link href="../../plugins/datatables/datatables-responsive/dataTables.responsive.css" rel="stylesheet">


  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="../../js/jquery-1.10.2.js"></script>
  <script src="../../js/jquery-ui.js"></script>

</head>
<style>
.dataTables_filter input.form-control{
  width: auto;
}
</style>
<body>

  <!--Page Wrapper-->

  <div class="container-fluid p-0">

    <?php 
    include_once "menu.php"; 
    ?>


    <!--Content right-->
    <div class="col-sm-9 col-xs-12 content pt-3 p-0">


      <div class="row mt-3 m-0">
        <div class="col-sm-12">
          <!--Datatable-->
          <div class="mt-1 mb-3 p-3 button-container fondo-container">

           <h5 class="mb-3" ><strong>Estadísticas</strong></h5>

           <!--Dashboard widget-->
           <div class="mt-1 mb-3 button-container">
            <div class="row pl-0">

              <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                <div class="bg-white border shadow">
                  <div class="p-2 text-center">
                    <h5 class="mb-0 mt-2 text-green"><small><strong>Logísticas Atendidas</strong></small></h5>
                    <?php 
                    $query_solicitadas = "SELECT * FROM orden_logistica WHERE idasigna <> '' and trim(idasigna) <> 'N/A' ";
                    $result_solicitadas = mysql_query($query_solicitadas);
                    $num_atendidas = mysql_num_rows($result_solicitadas);
                    echo "<h1>$num_atendidas</h1>";
                    ?>
                  </div>
                  <div class="align-bottom">
                    <center>
                      <span id="profitBar"></span>
                    </center>
                  </div>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                <div class="bg-white border shadow">
                  <div class="p-2 text-center">
                    <h5 class="mb-0 mt-2 text-theme"><small><strong>Logísticas Programadas</strong></small></h5>
                    <?php 
                    $query_programadas = "SELECT * FROM orden_logistica WHERE trim(idasigna) = ''";
                    $result_programadas = mysql_query($query_programadas);
                    $num_programadas = mysql_num_rows($result_programadas);
                    echo "<h1>$num_programadas</h1>";
                    ?>
                  </div>
                  <div class="align-bottom">
                   <center>
                    <span id="incomeBar"></span>
                  </center>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
              <div class="bg-white border shadow">
                <div class="p-2 text-center">
                  <h5 class="mb-0 mt-2 text-danger"><small><strong>Logísticas Canceladas</strong></small></h5>
                  <?php 
                  $query_canceladas = "SELECT * FROM  orden_logistica WHERE trim(idasigna) = 'N/A'";
                  $result_canceladas = mysql_query($query_canceladas);
                  $num_canceladas = mysql_num_rows($result_canceladas);
                  echo "<h1>$num_canceladas</h1>";
                  ?>
                </div>
                <div class="align-bottom">
                  <center>
                    <span id="expensesBar"></span>
                  </center>
                </div>
              </div>
            </div>


          </div>
        </div>
        <!--/Dashboard widget-->

        <div class="row mt-3">



          <div class="col-sm-12 col-md-12">
            <!--Custom Sales small chart-->
            <div class="mt-1 mb-3 button-container bg-white border shadow-sm lh-sm">
              <div class="fb-follow-widget">
                <div class="fb-widget-top bg-theme text-white">
                  <div class="row p-3 fb-widget-top-desc">
                    <div class="col-sm-6 col-6">
                      <h5>Logísticas</h5>
                      <small><?php echo $fecha_primer_logistica; ?></small>
                    </div>
                    <div class="col-sm-6 col-6 text-right">
                      <a href="orden_logistica_detalles.php?idib=<?php echo $ultima_logistica; ?>" class="text-theme"><?php echo "<h5><i class='fa fa-caret-up'></i> $total_logisticas</h5>"; ?></a>
                      <small><?php echo $fecha_creacion; ?></small>
                    </div>
                  </div>
                  <div class="ct-chart" id="areaChartFb" style="width: 100%; height:100px"></div>
                </div>
                <div class="fb-widget-bottom">
                  <div class="row p-3 fb-widget-bottom">
                    <div class="col-sm-6 col-6 fb-wb-inner">
                    <!--    <p> <small><i class="fa fa-circle text-danger"></i> 32% dietary intake</small></p>
                      <p><small><i class="fa fa-circle text-theme"></i> 68% motion capture</small></p> -->
                      <h5>Total Logísticas : <span class="text-theme"><?php echo $total_logisticas; ?></span></h5>
                    </div>
                  <!--   <div class="col-sm-6 col-6 text-right">
                  <div id="fbFollowChart" style="height: 130px"></div>
                </div> -->
              </div>
            </div>
          </div>
          
        </div>
        <!--/Custom Sales small chart-->
      </div>
    </div>
    
    <!--Custom cards section-->
    <div class="row">
      <!--Visitors statistics card-->
      <div class="col-sm-4 custom-card">
        <div class="mt-1 mb-3 button-container p-3 bg-white border shadow lh-sm">
          <div class="text-center mb-3">
            <h5 class="mb-0 mt-2"><small>Usuarios con más Logísticas</small></h5>
            <?php echo "<h4>$array_colaboradores[0]</h4> <h2>$array_colaboradores[1]</h2>"; ?>
            
          </div>
          
          <svg viewBox="0 0 36 25" class="circular-chart blue">
            <path class="circle-bg"
            d="M18 2.0845
            a 7.9567 7.9567 0 0 1 0 15.9134
            a 7.9567 7.9567 0 0 1 0 -15.9134"
            />
            <path class="circle"
            stroke-dasharray="40, 60"
            d="M18 2.0845
            a 7.9567 7.9567 0 0 1 0 15.9134
            a 7.9567 7.9567 0 0 1 0 -15.9134"
            />
            <text x="18" y="12.00" class="percentage">&#xf0c0;</text>
          </svg>
          <div class="row mx-2">
            <div class="col-sm-6 col-12">
              <h5><?php echo "$array_colaboradores[3]"; ?></h5>
              <span class="text-muted small"><strong><?php echo $array_colaboradores[2]; ?></strong></span>
            </div>
            <div class="col-sm-6 col-12 text-right">
              <h5><?php echo "$array_colaboradores[5]"; ?></h5>
              <span class="text-muted small"><strong><?php echo $array_colaboradores[4]; ?></strong></span>
            </div>
          </div>
        </div>
      </div>
      <!--/Visitors statistics card-->
      
      <!--Transaction statistics card-->
      <div class="col-sm-4 custom-card">
        <div class="mt-1 mb-3 button-container p-3 bg-white border shadow lh-sm">
          <div class="text-center mb-3">
            <h5 class="mb-0 mt-2"><small>Tipo de Orden mas Solicitada</small></h5>
            <?php echo "<h4>$array_tipo_orden[0]</h4> <h2>$array_tipo_orden[1]</h2>"; ?>
          </div>
          
          <svg viewBox="0 0 36 25" class="circular-chart red">
            <path class="circle-bg"
            d="M18 2.0845
            a 7.9567 7.9567 0 0 1 0 15.9134
            a 7.9567 7.9567 0 0 1 0 -15.9134"
            />
            <path class="circle"
            stroke-dasharray="40, 60"
            d="M18 2.0845
            a 7.9567 7.9567 0 0 1 0 15.9134
            a 7.9567 7.9567 0 0 1 0 -15.9134"
            />
            <text x="18" y="12.00" class="percentage">&#xf1b9;</text>
          </svg>
          
          <div class="row mx-2">
            <div class="col-sm-6 col-12">
              <h5><?php echo "$array_tipo_orden[3]"; ?></h5>
              <span class="text-muted small"><strong><?php echo $array_tipo_orden[2]; ?></strong></span>
            </div>
            <div class="col-sm-6 col-12 text-right">
              <h5><?php echo "$array_tipo_orden[5]"; ?></h5>
              <span class="text-muted small"><strong><?php echo $array_tipo_orden[4]; ?></strong></span>
            </div>
          </div>
        </div>
      </div>
      <!--/Transaction statistics card-->
      
      <!--Tasks statistics card-->
      <div class="col-sm-4 custom-card">
        <div class="mt-1 mb-3 button-container p-3 bg-white border shadow lh-sm">
          <div class="text-center mb-3">
            <h5 class="mb-0 mt-2"><small>Departamentos con más Logísticas</small></h5>
            <?php echo "<h4>$array_departamentos[0]</h4> <h2>$array_departamentos[1]</h2>"; ?>
            
          </div>
          
          <svg viewBox="0 0 36 25" class="circular-chart green">
            <path class="circle-bg"
            d="M18 2.0845
            a 7.9567 7.9567 0 0 1 0 15.9134
            a 7.9567 7.9567 0 0 1 0 -15.9134"
            />
            <path class="circle"
            stroke-dasharray="40, 60"
            d="M18 2.0845
            a 7.9567 7.9567 0 0 1 0 15.9134
            a 7.9567 7.9567 0 0 1 0 -15.9134"
            />
            <text x="18" y="12.00" class="percentage">&#xf0ae;</text>
          </svg>
          
          <div class="row mx-2">
            <div class="col-sm-6 col-12">
              <h5><?php echo "$array_departamentos[3]"; ?></h5>
              <span class="text-muted small"><strong><?php echo $array_departamentos[2]; ?></strong></span>
            </div>
            <div class="col-sm-6 col-12 text-right">
              <h5><?php echo "$array_departamentos[5]"; ?></h5>
              <span class="text-muted small"><strong><?php echo $array_departamentos[4]; ?></strong></span>
            </div>
          </div>
        </div>
      </div>
      <!--Transaction statistics card-->
    </div>
    <!--Custom cards Section-->
    
    <div class="row pl-0 mt-3">
      <!--Dashboard widget Contacts-->
      <div class="col-lg-4 col-md-4 col-sm-4 card-pro mb-3">
        <div class="card shadow">
          <div class="card-body">
            <h5 class="card-title bc-header">ID mas solicitado</h5>
            
            <?php 
            
            $query_id_solicitado = "SELECT contactos.idcontacto,contactos.nombre, contactos.apellidos, count(orden_logistica.idcontacto) as total_id, contactos.foto_perfil
            FROM orden_logistica 
            INNER JOIN contactos 
            WHERE orden_logistica.idcontacto = contactos.idcontacto and orden_logistica.tipo_contacto = 'Cliente' group by orden_logistica.idcontacto, contactos.nombre 
            order by total_id desc limit 6";
            $result_id_solicitado = mysql_query($query_id_solicitado);
            
            while ($row_id_solicitado = mysql_fetch_array($result_id_solicitado)) {

              if ($row_id_solicitado[foto_perfil] == "NO" || $row_id_solicitado[foto_perfil] == "" || $row_id_solicitado[foto_perfil] == null) {

                $foto_perfil_id = "../../img/avatar_hombre.png";
                
              }else{

                $foto_perfil_id = (file_exists($row_id_solicitado[foto_perfil])) ? $row_id_solicitado[foto_perfil] : "../../img/avatar_hombre.png" ;
                
              }
              
              
              
              echo "<div class='media border-top border-bottom pt-1'>
              <img class='align-self-center mr-2 rounded-circle mb-1' src='$foto_perfil_id' width='40px' height='40px' alt='Generic placeholder image'>
              <div class='media-body'>
              <p class='bc-description mt-2'>$row_id_solicitado[nombre] $row_id_solicitado[apellidos] <span class='pull-right'><i class='fa fa-pencil'></i></span></p>
              <div class='clearfix'></div>
              </div>
              </div>";
              
            }
            
            
            ?>
            
            
          </div>
        </div>
      </div>
      
      <!--Dashboard widget pROVEEDORES-->
      <div class="col-lg-4 col-md-4 col-sm-4 card-pro mb-3">
        <div class="card shadow">
          <div class="card-body">
            <h5 class="card-title bc-header">Proveedor mas solicitado</h5>
            
            <?php 
            
            $query_prov_solicitado = "SELECT proveedores.idproveedores, proveedores.nombre, proveedores.apellidos, count(orden_logistica.idcontacto) as total_id, proveedores.foto_perfil
            FROM orden_logistica 
            INNER JOIN proveedores 
            WHERE orden_logistica.idcontacto = proveedores.idproveedores and orden_logistica.tipo_contacto = 'Proveedor' group by orden_logistica.idcontacto, proveedores.nombre 
            order by total_id desc limit 6;";
            $result_prov_solicitado = mysql_query($query_prov_solicitado);
            
            while ($row_prov_solicitado = mysql_fetch_array($result_prov_solicitado)) {

              if ($row_prov_solicitado[foto_perfil] == "NO" || $row_prov_solicitado[foto_perfil] == "" || $row_prov_solicitado[foto_perfil] == null || $row_prov_solicitado[foto_perfil] == "N/A") {

                $foto_perfil_id = "../../img/avatar_hombre.png";
                
              }else{

                $foto_perfil_id = (file_exists($row_prov_solicitado[foto_perfil])) ? $row_prov_solicitado[foto_perfil] : "../../img/avatar_hombre.png" ;
                
              }
              
              
              
              echo "<div class='media border-top border-bottom pt-1'>
              <img class='align-self-center mr-2 rounded-circle mb-1' src='$foto_perfil_id' width='40px' height='40px' alt='Generic placeholder image'>
              <div class='media-body'>
              <p class='bc-description mt-2'>$row_prov_solicitado[nombre] $row_prov_solicitado[apellidos] <span class='pull-right'><i class='fa fa-pencil'></i></span></p>
              <div class='clearfix'></div>
              </div>
              </div>";
              
            }
            
            
            ?>
            
            
          </div>
        </div>
      </div>
      
      
      <div class="col-lg-4 col-md-4 col-sm-4 card-calendar mb-3">
        <!--Calendar-->
        <div class="calendar-wrapper panel-head-primary shadow">
          <div id="calendar" class="calendar-box"></div>
          <div class="dropdown-divider"></div>
          <div class="time pl-3 pr-3 pb-1">
            <h6 class="p-typo"><strong>Meet a friend</strong> <span class="badge badge-success pull-right">10:00am</span></h6>
          </div>
        </div>
        <!--Calendar-->
        
        <div class="card text-white bg-success mb-3 mt-2 shadow">
          <div class="card-body">
            <h6 class="card-title mb-1">Notification</h6>
            <p class="card-text small text-white">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
          </div>
        </div>
      </div>
      
    </div>
    
    <!--Latest projects-->

    <!--Latest projects-->
    
    <div class="col-sm-12">
      <!-- <div class="row mt-3"> -->
        <!-- <div class="col-sm-12"> -->
          <!-- <div class="shadow panel-head-primary"> -->
            <h5 class="text-center mt-3 mb-3"><strong>Logísticas Pendientes</strong></h5>

            <div class="container-bg-1 p-3">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover panel-body-center-table" id="example" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Origen</th>
                      <th>Destino</th>
                      <th>Cliente</th>
                      <th>Solicitante</th>
                      <th>F. Informante</th>
                      <th>Trasladista</th>
                      <th>Estatus</th>
                      <th>Fecha y Hora Programada</th>                                                    
                    </tr>
                  </thead>
                  <tbody>

                    <?php 

                    $sql= "SELECT * FROM orden_logistica WHERE visible = 'SI' and (idasigna = '' || idasigna = NULL || idasigna = '0')";
                    
                    $result=mysql_query($sql);

                    while ( $fila = mysql_fetch_array($result)) {
                      setlocale(LC_TIME, 'es_CO.UTF-8');
                      $f = date_create("$fila[fecha_programada]");
                      $estatus = "$fila[estatus]";
                      $fecha_programada = date_format($f,'Y-m-d H:i');
                      $idlogistica_encriptada = base64_encode("$fila[idorden_logistica]");
  #-------------------------------------------ID--------------------------------------------------------------------------------
                      $buscar_id = nombres_datos($fila[idcontacto], $fila[tipo_contacto]);
                      $porciones_id = explode("|", $buscar_id);
                      $nombre_id = $porciones_id[10];
  #-------------------------------------------Solicitante--------------------------------------------------------------------------------

                      $buscar_solicitante = nombres_datos($fila[idsolicitante], $fila[tipo_solicitante]);
                      $porciones_solicitante = explode("|", $buscar_solicitante);
                      $nombre_solicitante = $porciones_solicitante[10];

  #-------------------------------------------F. Informacion--------------------------------------------------------------------------------
                      $buscar_finformacion = nombres_datos($fila[idfuente_inf], $fila[tipo_fuente_inf]);
                      $porciones_finformacion = explode("|", $buscar_finformacion);
                      $nombre_fuente_inf = $porciones_finformacion[10];

  #-------------------------------------------Trasladista--------------------------------------------------------------------------------

                      $buscar_trasladista = nombres_datos($fila[idasigna], $fila[tipo_asignante]);
                      $porciones_trasladista = explode("|", $buscar_trasladista);
                      $nombre_asignante = $porciones_trasladista[10];


                      echo "<tr class='odd gradeX'>
                      <td><a href='orden_logistica_detalles.php?idib=$idlogistica_encriptada' target='_blank'>$fila[idorden_logistica]</a></td>
                      <td>$fila[municipio_origen]</td>
                      <td>$fila[municipio_destino]</td>
                      <td>$nombre_id</td>
                      <td>$nombre_solicitante</td>
                      <td>$nombre_fuente_inf</td>
                      <td>$nombre_asignante</td>
                      <td>$estatus</td>
                      <td>$fecha_programada</td>
                      </tr>";
                    }
                    ?>  

                  </tbody>
                </table>
              </div>
            </div>
            <!--  </div> -->
            <!-- </div> -->
            <!-- </div> -->
          </div> 


        </div>
        <!--/Datatable-->

      </div>
    </div>

    <!--Footer-->
    <?php 
    include_once '../footer.php';
    ?>
    <!--Footer-->

  </div>
</div>

<!--Main Content-->

</div>
<!--Page Wrapper-->

<!-- Page JavaScript Files-->
<script src="../../assets/js/jquery.min.js?<?php echo $random; ?>"></script>
<script src="../../assets/js/jquery-1.12.4.min.js?<?php echo $random; ?>"></script>
<!--Popper JS-->
<script src="../../assets/js/popper.min.js?<?php echo $random; ?>"></script>
<!--Bootstrap-->
<script src="../../assets/js/bootstrap.min.js?<?php echo $random; ?>"></script>
<!--Sweet alert JS-->
<script src="../../assets/js/sweetalert.js?<?php echo $random; ?>"></script>
<!--Progressbar JS-->
<script src="../../assets/js/progressbar.min.js?<?php echo $random; ?>"></script>
<!--Flot.JS-->
<script src="../../assets/js/charts/jquery.flot.min.js?<?php echo $random; ?>"></script>
<script src="../../assets/js/charts/jquery.flot.pie.min.js?<?php echo $random; ?>"></script>
<script src="../../assets/js/charts/jquery.flot.categories.min.js?<?php echo $random; ?>"></script>
<script src="../../assets/js/charts/jquery.flot.stack.min.js?<?php echo $random; ?>"></script>
<!--Sparkline-->
<script src="../../assets/js/charts/sparkline.min.js?<?php echo $random; ?>"></script>
<!--Morris.JS-->
<script src="../../assets/js/charts/raphael.min.js?<?php echo $random; ?>"></script>
<script src="../../assets/js/charts/morris.js?<?php echo $random; ?>"></script>
<!--Chart JS-->
<script src="../../assets/js/charts/chart.min.js?<?php echo $random; ?>"></script>
<!--Chartist JS-->
<script src="../../assets/js/charts/chartist.min.js?<?php echo $random; ?>"></script>
<script src="../../assets/js/charts/chartist-data.js?<?php echo $random; ?>"></script>
<script src="../../assets/js/charts/demo.js?<?php echo $random; ?>"></script>
<!--Maps-->
<script src="../../assets/js/maps/jquery-jvectormap-2.0.2.min.js?<?php echo $random; ?>"></script>
<script src="../../assets/js/maps/jquery-jvectormap-world-mill-en.js?<?php echo $random; ?>"></script>
<script src="../../assets/js/maps/jvector-maps.js?<?php echo $random; ?>"></script>
<!--Bootstrap Calendar JS-->
<script src="../../assets/js/calendar/bootstrap_calendar.js?<?php echo $random; ?>"></script>
<script src="../../assets/js/calendar/demo.js?<?php echo $random; ?>"></script>
<!--Nice select-->
<script src="../../assets/js/jquery.nice-select.min.js?<?php echo $random; ?>"></script>

<!--Custom Js Script-->
<script src="../../assets/js/custom.js?<?php echo $random; ?>"></script>

<!--Datatable-->
<script src="../../assets/js/jquery.dataTables.min.js"></script>
<script src="../../assets/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables/datatables-responsive/dataTables.responsive.js?<?php echo $random; ?>"></script>

<script  type="text/javascript" class="init">
  $(document).ready(function() {

    $('#example').DataTable({
      language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
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
      responsive: true,
      lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
      dom: 'Blfrtip',
      buttons: [
      'copy', 'excel'
      ],

    });
    var table = $('#example').DataTable();

    table
    .order([0, 'desc' ])
    .draw();  

  });


</script>
</body>
</html>