<?php 
session_start();  
include_once "../../config.php"; 
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php"; 
date_default_timezone_set('America/Mexico_City');
$fecha_guardado=date("Y-m-d H:i:s"); 
$usuario_creador=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];

$sql= "SELECT *FROM usuarios WHERE idusuario='$usuario_creador'";
$result=mysql_query($sql);
while ( $fila = mysql_fetch_array($result)) {
    $foto="$fila[foto_perfil]";
    $rol="$fila[rol]";
    $contra_bd="$fila[password]";
    $usuario="$fila[usuario]";
    $sigla_ccp="$fila[sigla_ccp]";
    $nombre=ucwords("$fila[nombre_usuario]"); 
    $usuario_creador_user="$fila[usuario_creador]";
    $fecha_creacion="$fila[fecha_creacion]";
}
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="description" content="" >
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!--Meta Responsive tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,user-scalable=no">

    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <!--Custom style.css-->
    <link rel="stylesheet" href="../../assets/css/quicksand.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../assets/css/fontawesome.css">
    <!--Animate CSS-->
    <link rel="stylesheet" href="../../assets/css/animate.min.css">
    <!--Chartist CSS-->
    <link rel="stylesheet" href="../../assets/css/chartist.min.css">
    <!--Morris Css-->
    <link rel="stylesheet" href="../../assets/css/morris.css">
    <!--Map-->
    <link rel="stylesheet" href="../../assets/css/jquery-jvectormap-2.0.2.css">
    <!--Bootstrap Calendar-->
    <link rel="stylesheet" href="../../assets/js/calendar/bootstrap_calendar.css">
    <!--Nice select -->
    <link rel="stylesheet" href="../../assets/css/nice-select.css">
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

    <title>CCP | Titulo</title>

    <script type="text/javascript">

        $(document).ready(function(){ 
           $('#alternar-respuesta-ej1').on('click',function(){
              $('#respuesta-ej1').toggle('slow');
          });

           $('#alternar-respuesta-ej2').on('click',function(){
              $('#respuesta-ej2').toggle('slow');
          });

       });
   </script>


   <script>

    function validateForm() {
        var contra_actual = document.forms["contra"]["contra_actual"].value;
        var contra_1 = document.forms["contra"]["contra_nueva1"].value;
        var contra_2 = document.forms["contra"]["contra_nueva2"].value;

        var contra_bd=<?php echo "'$contra_bd'";?>; 

        if (contra_actual == "") {
            alert("La contraseña actual es necesaria, por favor indicalo para poder guardar la información");
            return false;
        }

        if (contra_actual!=contra_bd) {
            alert("Las contraseña actual proporcionada NO coincide con la asignada desde base de datos, deben ser idénticas para poder guardar la información");
            return false;
        }

        if (contra_1 == "") {
            alert("La nueva contraseña es necesaria, por favor indicalo para poder guardar la información");
            return false;
        }

        if (contra_2 == "") {
            alert("Repetir la nueva contraseña es necesario, por favor indicalo para poder guardar la información");
            return false;
        }

        if (contra_1!=contra_2) {
            alert("Las contraseñas proporcionadas NO coinciden, deben ser idénticas para poder guardar la información");
            return false;
        }





    }
</script>
</head>
<body>
    <!--Page loader-->
    <div class="loader-wrapper">
        <div class="loader-circle">
            <div class="loader-wave"></div>
        </div>
    </div>
    <!--Page loader-->
    
    <!--Page Wrapper-->

    <div class="container-fluid">


        <?php 
        include_once "menu.php"; 
        ?>
        <!--Content right-->
        <div class="col-sm-9 col-xs-12 content pt-3 pl-0">
            <h5 class="mb-3" ><strong>Titulo</strong></h5>


            <!--Custom cards Section-->

            <div class="mt-1 mb-3 button-container">
                <div class="row pl-0">
                    <div class="col-lg-12 col-md-4 col-sm-6 col-12 mb-3">
                        <div class="bg-white border shadow">


                            <div class="col-lg-12 imagen-perfil">
                                <center>
                                    <h2><?php echo $usuario; ?></h2>
                                    <a href="#">
                                        <?php 
                                        echo "<img alt='image' class='img-circle' width='100' height='100' src='$foto'>";                                 
                                        ?>  
                                    </a>
                                    
                                    <div class="media-body">

<!--                                         <i id="alternar-respuesta-ej2" class="fa fa-pencil-square-o" aria-hidden="true"></i>
-->                                        
<div id="respuesta-ej2" style="display:none">
    <form id="contacto" name="contacto" enctype="multipart/form-data" method="post" action="guardar_foto_perfil.php">
        <label>Actualizar Foto de Perfil</label>
        <input type="file" placeholder="Foto de Perfil" name="uploadedfile" class="form-control" required="">
        <button class="btn btn-lg btn-primary" type="submit">Actualizar</button>
    </form>
</div>

</div>
</div>

<!-- Datos Personales -->
<div><h3 class="m-t-none m-b">Datos Personales</h3>
</div>
</center>
<div class="table-responsive">
    <table class="table table-striped">
        <tbody>
            <tr>
                <td>Nombre(s)</td>
                <td colspan="3"><b><?php echo $nombre; ?></b></td>  
            </tr>
            <tr>
                <td>Usuario</td>
                <td><b><?php echo $usuario; ?></b></td>

            </tr>

        </tbody>
    </table>
</div>
<!-- Fin | Datos Personales -->


<div class="table-responsive">
    <div class="form-group">
        <div class="col-lg-12">
            <center>
                <div><h3 class="m-t-none m-b">Generar Key Access</h3>
                </div>
                <h1 id="new_password"></h1> 
                <h1><i class="fa fa-clone" aria-hidden="true" id="copy_info" onclick="copiar_info('new_password');" style="display: none;"></i></h1>
                <div id="mensaje"></div>
                <input type="hidden" id="usser" value="<?php echo $usuario; ?>">
                <input type="hidden" id="ccp" value="<?php echo $sigla_ccp; ?>">
                <input type="hidden" id="info_new">
                <div id="btn_eliminar"><center><button type="submit" class="btn btn-primary" id="guardar_info">Generar Key</button></center></div>
            </center>
        </div>                                
    </div>
</div>




</div>
</div>
</div>
</div>


<!--Footer-->
<?php 
include_once '../footer.php';
?>
<!--Footer-->


</div>
</div>

<!-- Page JavaScript Files-->
<script src="../../assets/js/jquery.min.js"></script>
<script src="../../assets/js/jquery-1.12.4.min.js"></script>
<!--Popper JS-->
<script src="../../assets/js/popper.min.js"></script>
<!--Bootstrap-->
<script src="../../assets/js/bootstrap.min.js"></script>
<!--Sweet alert JS-->
<script src="../../assets/js/sweetalert.js"></script>
<!--Progressbar JS-->
<script src="../../assets/js/progressbar.min.js"></script>
<!--Flot.JS-->
<script src="../../assets/js/charts/jquery.flot.min.js"></script>
<script src="../../assets/js/charts/jquery.flot.pie.min.js"></script>
<script src="../../assets/js/charts/jquery.flot.categories.min.js"></script>
<script src="../../assets/js/charts/jquery.flot.stack.min.js"></script>
<!--Sparkline-->
<script src="../../assets/js/charts/sparkline.min.js"></script>
<!--Morris.JS-->
<script src="../../assets/js/charts/raphael.min.js"></script>
<script src="../../assets/js/charts/morris.js"></script>
<!--Chart JS-->
<script src="../../assets/js/charts/chart.min.js"></script>
<!--Chartist JS-->
<script src="../../assets/js/charts/chartist.min.js"></script>
<script src="../../assets/js/charts/chartist-data.js"></script>
<script src="../../assets/js/charts/demo.js"></script>
<!--Maps-->
<script src="../../assets/js/maps/jquery-jvectormap-2.0.2.min.js"></script>
<script src="../../assets/js/maps/jquery-jvectormap-world-mill-en.js"></script>
<script src="../../assets/js/maps/jvector-maps.js"></script>
<!--Bootstrap Calendar JS-->
<script src="../../assets/js/calendar/bootstrap_calendar.js"></script>
<script src="../../assets/js/calendar/demo.js"></script>
<!--Nice select-->
<script src="../../assets/js/jquery.nice-select.min.js"></script>

<!--Custom Js Script-->
<script src="../../assets/js/custom.js"></script>
<script>
   $(document).ready(function(){
    $("#guardar_info").click(function(){
     var usser = $("#usser").val();
     var ccp = $("#ccp").val();




     if (usser === "") {
     }else if (ccp === "") {
     }else{
        parametros = {
           "usser" : usser,
           "ccp" : ccp

       };
       $.ajax({
                        data:  parametros, //datos que se envian a traves de ajax
                        url:   'generar_contrasenia.php', //archivo que recibe la peticion
                        type:  'post', //método de envio
                        beforeSend: function () {

                            $("#guardar_info").remove();
                            $("#btn_eliminar").append('<center><button class="btn btn-primary" type="button" disabled id="act_btn">  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>  Cargando</button></center>');
                        },
                        success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve

                            response = response.replace(" ", "");
                            console.log(response);
                            $("#new_password").html(response);
                            $("#copy_info").show();
                            $("#info_new").val(response);
                            $("#act_btn").remove();
                            $("#btn_eliminar").append('<center><button type="button" class="btn btn-lg btn-primary" disabled>Key Generada</button></center>');
                        }
                    });
   }

});
});
</script>




<script>
    function copiar_info(id_elemento) {
      var aux = document.createElement("input");
      aux.setAttribute("value", document.getElementById(id_elemento).innerHTML);
      document.body.appendChild(aux);
      aux.select();
      document.execCommand("copy");
      document.body.removeChild(aux);

      $("#mensaje").html('<div class="alert alert-success" role="alert">Key Access Copiada. Guarda la Key Access, te servira para ingresar desde otro dispositivo.</div>');
      myFunction();
      
      
  }

  function myFunction() {
    setTimeout(function(){ location.href="../../logout.php"; }, 3000);
}
</script>


</body>
</html>