<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
include_once "funciones_principales.php";
include_once "funciones_principales_insert.php";

date_default_timezone_set('America/Mexico_City');
$fecha_guardado = date("Y-m-d H:i:s");
$usuario_creador = $_SESSION['usuario_clave'];
$empleados = $_SESSION['empleados'];

#------------ ------------------------------------
$tipo_movimiento = $_POST['tipo_movimiento'];
#------------ ------------------------------------

if ($tipo_movimiento == "CreateNewToken") {

        $token = generate_token("");

        $tipo_token = $_POST['tipo_token'];
        $idorden_logistica = $_POST['idorden_logistica'];
        $idcolaborador = $_POST['idcolaborador'];
        $tipocolaborador = $_POST['tipocolaborador'];
        $fecha_hora_token = $_POST['fecha_hora_token'];
        $fecha_creacion = $_POST['fecha_creacion'];


        $buscar_responsable_token = explode("|", nombres_datos($idcolaborador, $tipocolaborador));


        $insertar_token = TokenLogisticaInsert($token, $tipo_token, $idorden_logistica, $idcolaborador, $tipocolaborador, $fecha_hora_token, $columna_a, "Pendiente", $columna_c, "SI", $usuario_creador, $fecha_creacion, $fecha_guardado);

        $mensaje = ($insertar_token == 1) ? "1|https://api.whatsapp.com/send?phone=$buscar_responsable_token[3]&text=$token" : "$insertar_token|";

        #
} elseif ($tipo_movimiento == "TablaExceptionsToken") {

        $mensaje = "
        <script>

        $(document).ready(function() {

        $('#table_tipo_orden').DataTable({
        language: {
        'decimal': '',
        'emptyTable': 'No hay información',
        'info': 'Mostrando _START_ a _END_ de _TOTAL_ Entradas',
        'infoEmpty': 'Mostrando 0 to 0 of 0 Entradas',
        'infoFiltered': '(Filtrado de _MAX_ total entradas)',
        'infoPostFix': '',
        'thousands': ',',
        'lengthMenu': 'Mostrar _MENU_ Entradas',
        'loadingRecords': 'Cargando...',
        'processing': 'Procesando...',
        'search': 'Buscar:',
        'zeroRecords': 'Sin resultados encontrados',
        'paginate': {
        'first': 'Primero',
        'last': 'Ultimo',
        'next': 'Siguiente',
        'previous': 'Anterior'
        }
        },
        responsive: true,
        lengthMenu: [[10, 25, 50,-1], [10, 25, 50, 'All']],
        dom: 'Blfrtip',
        buttons: [
        'copy', 'excel'
        ],

        });
        var table = $('#table_tipo_orden').DataTable();

        table
        .order([ 1, 'asc' ])
        .draw();
        });

        </script>
        ";

        $tipo_tabla = trim($_POST['tipo_tabla']);

        $array_exeptions_token = ['TokenPendientes', 'TokenALL'];

        if (in_array($tipo_tabla, $array_exeptions_token)) {

                $mensaje .= "
                <div class='container-bg-1 p-3'>
                <div class='table-responsive'>
        
                <table width='100%' class='table table-striped table-bordered table-hover panel-body-center-table' id='table_tipo_orden'>
                <thead>
                <tr>
                <th>#</th>
                <th>Tipo de Token&nbsp;&nbsp;&nbsp;</th>
                <th>Token</th>
                <th>Logística</th>
                <th>Colaborador Token</th>
                <th>Expiración Token</th>
                <th>Aplicacion Token</th>
                <th>Estatus</th>
                <th>Acciones</th>
                </tr>
                </thead>
                <tbody>  
                ";
        }


        if (in_array($tipo_tabla, $array_exeptions_token)) {

                if ($tipo_tabla == "TokenPendientes") {

                        $query_token = "SELECT * FROM orden_logistica_token WHERE visible = 'SI' AND columna_b = 'Pendiente' ORDER BY fecha_expiracion_token DESC";
                        #        
                } elseif ($tipo_tabla == "TokenALL") {

                        $query_token = "SELECT * FROM orden_logistica_token ORDER BY fecha_expiracion_token DESC";
                        #
                } else {
                        $query_token = "";
                }
        }


        $incrementar = 0;

        $result_token = mysql_query($query_token);

        while ($row_token = mysql_fetch_array($result_token)) {

                $incrementar++;
                $copy_and_paste_token = "<hr><center><i class='far fa-copy fa-2x' onclick=\"CopyAndPaste('$row_token[token]')\"></i></center>";

                $buscar_colaborador_token = explode("|", nombres_datos($row_token[idcolaborador], $row_token[tipocolaborador]));

                $fecha_expiracion_token = date_format(date_create($row_token[fecha_expiracion_token]), 'd-m-Y H:i');

                $fecha_aplicacion_token = ($row_token[columna_a] == "" || is_null($row_token[columna_a])) ? "Pendiente" : date_format(date_create($row_token[columna_a]), "d-m-Y H:i");


                $acciones = ($row_token[columna_b] == "Pendiente" and $row_token[visible] == "SI") ? "<input type='checkbox' class='filtros' onclick=\"MovimientoToken('Token', '$row_token[idorden_logistica_token]');\">" : "N/A";

                $mensaje .= "
                <tr>
                <td>$incrementar</td>
                <td>$row_token[tipo_token]</td>
                <td>$row_token[token]$copy_and_paste_token</td>
                <td>$row_token[idorden_logistica]</td>
                <td>$buscar_colaborador_token[10] - $buscar_colaborador_token[2]</td>
                <td>$fecha_expiracion_token</td>
                <td>$fecha_aplicacion_token</td>
                <td>$row_token[columna_b]</td>
                <td>$acciones</td>
                </tr>
                ";
        }

        $mensaje .= "
        </tbody >
        </table>
        </div>
        </div>
        ";
} elseif ($tipo_movimiento == "Token") {

        $id = trim($_POST[id]);

        if ($id == "" || is_null($id)) {

                $mensaje = 1;
        } else {

                $query_delete_token = "UPDATE orden_logistica_token SET visible = 'NO', columna_b = 'Cancelado', columna_a = '$fecha_guardado' WHERE idorden_logistica_token = '$id'";
                $result_delete_token = mysql_query($query_delete_token);

                $mensaje = ($result_delete_token == 1) ? 1 : "- Error <br>";
        }
} else {

        $mensaje = "- El movimiento <b>Esta Pendiente</b> <br>";
}


echo $mensaje;


function TokenLogisticaInsert($token, $tipo_token, $idorden_logistica, $idcolaborador, $tipocolaborador, $fecha_expiracion_token, $columna_a, $columna_b, $columna_c, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado)
{

        $token = trim($token);
        $tipo_token = trim($tipo_token);
        $idorden_logistica = trim($idorden_logistica);
        $idcolaborador = trim($idcolaborador);
        $tipocolaborador = trim($tipocolaborador);
        $fecha_expiracion_token = trim($fecha_expiracion_token);
        $columna_a = trim($columna_a);
        $columna_b = trim($columna_b);
        $columna_c = trim($columna_c);
        $visible = trim($visible);
        $usuario_creador = trim($usuario_creador);
        $fecha_creacion = trim($fecha_creacion);
        $fecha_guardado = trim($fecha_guardado);

        $query_repetir_token = "SELECT * FROM orden_logistica_token WHERE visible = 'SI' AND tipo_token = '$tipo_token' AND fecha_creacion = '$fecha_creacion'";
        $result_repetir_token = mysql_query($query_repetir_token);


        if (mysql_num_rows($result_repetir_token) >= 1) {

                $mensaje_token = 1;
        } else {

                $query_insert_token = "INSERT INTO orden_logistica_token (token, tipo_token, idorden_logistica, idcolaborador, tipocolaborador, fecha_expiracion_token, columna_a, columna_b, columna_c, visible, usuario_creador, fecha_creacion, fecha_guardado) VALUES ('$token', '$tipo_token', '$idorden_logistica', '$idcolaborador', '$tipocolaborador', '$fecha_expiracion_token', '$columna_a', '$columna_b', '$columna_c', '$visible', '$usuario_creador', '$fecha_creacion', '$fecha_guardado')";
                $result_insert_token = mysql_query($query_insert_token);

                $mensaje_token = ($result_insert_token == 1) ? "1" : "- Error al Generar el Token <br>";
        }

        return $mensaje_token;
}
