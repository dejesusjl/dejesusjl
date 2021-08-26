<?php
session_start();
include_once "../../config.php";
require_once('../../bdd.php');
include_once "../../recuperar_usuario.php";
date_default_timezone_set('America/Mexico_City');
$fecha_guardado=date("Y-m-d H:i:s");
$usuario_creador=$_SESSION['usuario_clave'];
$empleados=$_SESSION['empleados'];
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE
$random = rand(5, 15);
$contadorAutos=0;
$limite=7;

if (isset($_POST['mensaje'])){
    $texto=$_POST['mensaje'];
    $mensaje="";
                $consulta="select 
                   i.idinventario, i.vin_numero_serie, i.marca, i.version, i.modelo, i.color, i.estatus_unidad
                from 
                    inventario i 
                where i.vin_numero_serie = any (select bg.datos_vin
                                                from balance_gastos_operacion bg 
                                                where 
                                                bg.concepto='CARGA DE COMBUSTIBLE' and 
                                                bg.visible='SI' and
                                                bg.tipo_movimiento='cargo' 
                                                group by bg.datos_vin) and 
                                            (TRIM(i.vin_numero_serie) LIKE '%".$texto."%'|| TRIM(i.marca) LIKE '%".$texto."%' || TRIM(i.version) LIKE '%".$texto."%' ||TRIM(i.modelo) LIKE '%".$texto."%' || TRIM(i.color) LIKE '%".$texto."%' ) and
                                                i.visible='SI' and i.estatus_unidad='utilitaria' LIMIT ".$limite.";";

    $consulta1="select e.nombre, e.apellido_paterno, e.apellido_materno, e.columna_b, cu.vin
                FROM catalogo_unidades_utilitarios cu join empleados e on cu.comentario=e.idempleados  
                    where e.visible='SI' and cu.visible='SI' and 
                    (TRIM(e.columna_b) LIKE '%".$texto."%'|| TRIM(e.apellido_paterno) LIKE '%".$texto."%' || TRIM(e.apellido_materno) LIKE '%".$texto."%' ||TRIM(e.nombre) LIKE '%".$texto."%') LIMIT 5;";
    
    $Tabla1=mysql_query($consulta1);
    $Numero1=mysql_num_rows($Tabla1);

    $Tabla=mysql_query($consulta);
    $Numero=mysql_num_rows($Tabla);

    if($Numero>0){
		while ($fila=mysql_fetch_array($Tabla)) {  
            $consResponsable="select e.nombre, e.apellido_paterno, e.apellido_materno, e.columna_b, cu.vin
                            FROM catalogo_unidades_utilitarios cu join empleados e on cu.comentario=e.idempleados  
                                where e.visible='SI' and cu.visible='SI' and TRIM(cu.vin)=TRIM('$fila[vin_numero_serie]') LIMIT 1;";
                $tablaC=mysql_query($consResponsable);
                $Numero3=mysql_num_rows($tablaC);
                while($fila3=mysql_fetch_array($tablaC)){

                    $consultaR="select contenido from inventario_dinamico where columna='rendimiento' and idinventario=$fila[idinventario] order by contenido desc LIMIT 1;"; 

                    $Tablita=mysql_query($consultaR); 

                        if(mysql_num_rows($Tablita)==0){                 
                        	$mensaje.="<div class='content-op-busqueda-2'>
                                        <i class='fas fa-car icon-busqueda'></i>
                                        <option href='#origen' class='autoSeleccionado efecto-sugerencia' value='$fila[vin_numero_serie];$fila[marca];$fila[version];$fila[modelo];$fila[color];$fila[estatus_unidad];0;$fila3[columna_b]'>$fila[vin_numero_serie] - $fila[marca]- $fila[version]- $fila[modelo]- $fila[color] - S/R - $fila3[columna_b] </option>
                                    </div>";
                                    $contadorAutos++;
                        }else{
                            while ($fila2=mysql_fetch_array($Tablita)) {
                                $mensaje.="<div class='content-op-busqueda-2'>
                                        <i class='fas fa-car icon-busqueda'></i>
                                        <option href='#origen' class='autoSeleccionado efecto-sugerencia' value='$fila[vin_numero_serie];$fila[marca];$fila[version];$fila[modelo];$fila[color];$fila[estatus_unidad];$fila2[contenido]; $fila3[columna_b]'>$fila[vin_numero_serie] - $fila[marca]- $fila[version]- $fila[modelo]- $fila[color] - C/R - $fila3[columna_b]</option>
                                    </div>";
                                    $contadorAutos++;
                            }
                        }
                }
        }
    }
    if($Numero1>0){
        while ($filaCol=mysql_fetch_array($Tabla1)) {  
            $consulta="select 
                   i.idinventario, i.vin_numero_serie, i.marca, i.version, i.modelo, i.color, i.estatus_unidad
                from 
                    inventario i 
                where i.vin_numero_serie = any (select bg.datos_vin
                                                from balance_gastos_operacion bg 
                                                where 
                                                bg.concepto='CARGA DE COMBUSTIBLE' and 
                                                bg.visible='SI' and
                                                bg.tipo_movimiento='cargo' 
                                                group by bg.datos_vin) and TRIM(i.vin_numero_serie)=TRIM('$filaCol[vin]');";
            $Tabla=mysql_query($consulta);
            $Numero4=mysql_num_rows($Tabla);
            //$mensaje.="<p><b>Ahora aqui: ".$texto." -> ".$filaCol[vin]." -> ".$Numero4." -> ".$filaCol[columna_b]."</b></p>";  
            while ($fila=mysql_fetch_array($Tabla)) {

                ///revisa Aqui
                $consultaR="select contenido from inventario_dinamico where columna='rendimiento' and idinventario='$fila[idinventario]' order by contenido desc LIMIT 1;"; 

                    $Tablita=mysql_query($consultaR); 
                     //$mensaje.="<p><b>ya entro : ".$texto." -> ".$fila[idinventario]." -> ".mysql_num_rows($Tablita)." -> "."</b></p>";  
                        if(mysql_num_rows($Tablita)==0){                 
                            $mensaje.="<div class='content-op-busqueda-2'>
                                        <i class='fas fa-car icon-busqueda'></i>
                                        <option href='#origen' class='autoSeleccionado efecto-sugerencia' value='$fila[vin_numero_serie];$fila[marca];$fila[version];$fila[modelo];$fila[color];$fila[estatus_unidad];0;$filaCol[columna_b]'>$fila[vin_numero_serie] - $fila[marca]- $fila[version]- $fila[modelo]- $fila[color] - S/R - $filaCol[columna_b] </option>
                                    </div>";
                                    $contadorAutos++;
                        }else{
                            while ($fila2=mysql_fetch_array($Tablita)) {
                                $mensaje.="<div class='content-op-busqueda-2'>
                                        <i class='fas fa-car icon-busqueda'></i>
                                        <option href='#origen' class='autoSeleccionado efecto-sugerencia' value='$fila[vin_numero_serie];$fila[marca];$fila[version];$fila[modelo];$fila[color];$fila[estatus_unidad];$fila2[contenido]; $filaCol[columna_b]'>$fila[vin_numero_serie] - $fila[marca]- $fila[version]- $fila[modelo]- $fila[color] - C/R - $filaCol[columna_b]</option>
                                    </div>";
                                    $contadorAutos++;
                            }
                        }
            }
        }
    }
            

    
   $mensaje.="<p><b>Se Encontraron: ".$contadorAutos." Resultados</b></p>";        

    echo $mensaje;
}

if (isset($_POST['serie'])){
    $agrega="";
    $limite=20;
    $vin=$_POST['serie'];
    $consulta="select bg.monto_total, bg.columna2 as 'orden_salida', bg.fecha_creacion, ol.fecha_salida, bg.columna5, bg.columna6
                FROM balance_gastos_operacion bg join orden_logistica ol on bg.columna2=ol.idorden_logistica
                WHERE datos_vin='".$vin."' and concepto='CARGA DE COMBUSTIBLE' and tipo_movimiento='cargo' and ol.fecha_salida<>'null' and bg.visible='SI' and ol.visible='SI' order by fecha_salida desc LIMIT ".$limite.";";

        $Tabla=mysql_query($consulta);
        $Numero=mysql_num_rows($Tabla);
        if($Numero>0){
            $fecha=date('Y-m-d h:i:s');
            $index=0;
            $habilitaFecha="%<input type='hidden' id='fechaPoner' value='";
            while ($fila=mysql_fetch_array($Tabla)) {                 
                if($fecha!=$fila[fecha_salida]){      
                    /*$consulta1="select 
                        i.vin_numero_serie, i.marca, i.version, i.modelo, i.color, i.estatus_unidad,
                        bg.monto_total, bg.columna2 as 'orden_carga', bg.fecha_creacion,
                        ol.idorden_logistica as 'orden_salida', ol.fecha_salida, ol.fecha_llega_destino, ol.coordenadas_origen,
                        ol.municipio_origen,ol.estado_origen,ol.ubicacion_destino, ol.municipio_destino,ol.estado_destino,ol.kilometros
                    FROM 
                        inventario i JOIN balance_gastos_operacion bg ON i.vin_numero_serie=bg.datos_vin JOIN orden_logistica_unidades olu ON bg.datos_vin=olu.vin 
                        JOIN orden_logistica ol ON olu.idorden_logistica=ol.idorden_logistica 
                    WHERE 
                        i.visible='SI' and 
                        bg.concepto='CARGA DE COMBUSTIBLE' and bg.visible='SI' and
                        bg.tipo_movimiento='cargo' and
                        bg.datos_vin='".$vin."' and bg.columna2='".$fila[orden_salida]."' and
                        ol.fecha_llega_destino between '".$fila[fecha_salida]."' and '".$fecha."' and
                        olu.visible='SI' order by fecha_salida asc;";

                    $Tabla1=mysql_query($consulta1);
                    $Numero1=mysql_num_rows($Tabla1); */  
                    //if($Numero1>0){      
                        $date = date_create($fila[fecha_salida]);
                        $fsE=date_format($date,'d-m-Y');//substr($fila[fecha_salida], 0, 10);              
                        $agrega.="<option href='#origen' class='efecto-sugerencia' value='$fila[orden_salida];$fila[monto_total];$fila[fecha_salida];$fecha;$vin;$fila[columna5];$fila[columna6]'>$fsE</option>";                    
                        $fecha=$fila[fecha_salida];
                        $habilitaFecha.=$fecha."+";
                   // }
                }                
            }
        }
        $habilitaFecha.="'></input>";
        $agrega.= $habilitaFecha;
    echo $agrega;  
}

if (isset($_POST['FechaI']) && isset($_POST['FechaF']) && isset($_POST['orden']) && isset($_POST['vin'])){    
    $vin=$_POST['vin'];
    $orden=$_POST['orden'];
    $FechaInicial=$_POST['FechaI'];
    $FechaFinal=$_POST['FechaF'];
    $rendimiento=$_POST['rendimiento'];
    $gas=$_POST['gasolina'];
    $monto=$_POST['monto'];
    $men=$_POST['carro'];
    $agrega="";

    $consulta="select 
                    i.vin_numero_serie, i.marca, i.version, i.modelo, i.color, i.estatus_unidad,
                    bg.monto_total, bg.columna2 as 'orden_carga', bg.fecha_creacion,
                    ol.idorden_logistica as 'orden_salida', ol.fecha_salida, ol.fecha_llega_destino, ol.coordenadas_origen,
                    ol.municipio_origen,ol.estado_origen,ol.ubicacion_destino, ol.municipio_destino,ol.estado_destino,ol.kilometros
                FROM 
                    inventario i JOIN balance_gastos_operacion bg ON i.vin_numero_serie=bg.datos_vin JOIN orden_logistica_unidades olu ON bg.datos_vin=olu.vin 
                    JOIN orden_logistica ol ON olu.idorden_logistica=ol.idorden_logistica 
                WHERE 
                    i.visible='SI' and 
                    bg.concepto='CARGA DE COMBUSTIBLE' and bg.visible='SI' and
                    bg.tipo_movimiento='cargo' and
                    bg.datos_vin='".$vin."' and bg.columna2='".$orden."' and
                    ol.fecha_llega_destino between '".$FechaInicial."' and '".$FechaFinal."' and
                    olu.visible='SI' order by fecha_salida asc;";

    $Tabla=mysql_query($consulta);
    $Numero=mysql_num_rows($Tabla);
    $tablaHead="<thead>";
    $tablaBody="";
    $contarRow=1;
    $contarViews=1;
    $fecha=date('Y-m-d h:i:s');
        $index=0;
        $comparaLitro=0;
        $comparaKilometro=0;
        $difLt=0;
        $difKm=0;
        
        $litros=number_format ( ($monto/$gas) , 2 , "." , "");
        $km=($litros*$rendimiento);
    if($Numero>0){


        while ($fila=mysql_fetch_array($Tabla)) {            
            
            $agrega.="<option href='#origen' class='efecto-sugerencia' value='$fila[vin_numero_serie]; $fila[marca]; $fila[version]; $fila[modelo];$fila[color]; $fila[estatus_unidad]; $fila[monto_total]; $fila[orden_carga]; $fila[fecha_creacion]; $fila[orden_salida]; $fila[fecha_salida]; $fila[fecha_llega_destino]; $fila[coordenadas_origen]; $fila[ubicacion_destino]; $fila[kilometros]; '>$fila[orden_salida]   /   $ $fila[monto_total]    /   $fila[fecha_salida]</option>";
            $idlogistica_encriptada = base64_encode("$fila[orden_carga]");
            $tablaHead="<thead>
            <tr><th colspan='6'><div align='center'>$fila[vin_numero_serie]     |   $fila[marca]    |   $fila[version]  |   $fila[modelo]   |   $fila[color]    |   $fila[estatus_unidad]   |   $rendimiento km/l</div></th></tr>
            <tr><th><div align='center'>Orden de Carga:<br /><a id='$fila[orden_carga]' href='orden_logistica_detalles.php?idib=$idlogistica_encriptada' target='_blank'>$fila[orden_carga]</div></th><th><div align='center'>Inicio del Periodo de Carga:<br />$FechaInicial</div></th><th><div align='center'>Fin del Periodo de Carga:<br />$FechaFinal</div></th><th><div align='center'>Monto Cargado:<br />$$fila[monto_total]</div></th><th><div align='center'>Km Estimados:<br />$km</div></th><th><div align='center'>Litros Aprox:<br />$litros</div></th></tr>";
            $ajKm=str_replace(",", ".", $fila[kilometros]);
            $ltRecorridos=number_format ( ($ajKm/$rendimiento) , 2 , "." , "");
                $idlogistica_encriptada = base64_encode("$fila[orden_salida]");
                $tablaBody.="
                <tr for='$fila[orden_salida]'><td ><a id='$fila[orden_salida]' href='orden_logistica_detalles.php?idib=$idlogistica_encriptada' target='_blank'>$fila[orden_salida] </td><td>$fila[fecha_salida]</td><td>$fila[municipio_origen]<br />$fila[estado_origen]<br />$fila[coordenadas_origen]</td><td>$fila[municipio_destino]<br />$fila[estado_destino]<br /> $fila[ubicacion_destino]</td><td>$fila[kilometros]</td><td>$ltRecorridos</td></tr>";

                $comparaLitro+=$ltRecorridos;
                $comparaKilometro+=$ajKm;
                $fecha=$fila[fecha_salida];
            
        }
        $difLt=$litros-$comparaLitro;
    $difKm=$km-$comparaKilometro;
    $costo=$comparaLitro*$gas;
    $difCosto=$difLt*$gas;
    $tablaHead.="   <tr><th></th><th></th><th><div align='right'>Total Consumido:</div></th><td><div align='center'>$ $costo</div></td><td><div align='center'>$comparaKilometro km</div></td><td><div align='center'>$comparaLitro L</div></td></tr>
                    <tr><th></th><th></th><th><div align='right'>Diferencia:</div></th><td><div align='center'>$ $difCosto</div></td><td><div align='center'>$difKm km</div></td><td><div align='center'>$difLt L</div></td></tr>
                    <tr><th><br /></th><th><br /></th><th><br /></th><th><br /></th><th><br /></th><th><br /></th></tr>
                    <tr><th>No. de Orden:</th><th>Fecha:</th><th>Origen:</th><th>Destino:</th><th>Kilometros:</th><th>Litros: </th></tr></thead>
            <tbody>";

            

    $tablaBody.="</tbody>";

    $agrega=$tablaHead.$tablaBody;

    }else{
        $idlogistica_encriptada = base64_encode("$orden");
        $tablaHead="<thead>
        <tr><th colspan='6'><div align='center'>$men | $rendimiento</div></th></tr>
            <tr><th><div align='center'>Orden de Carga:<br /><a id='$orden' href='orden_logistica_detalles.php?idib=$idlogistica_encriptada' target='_blank'>$orden</div></th><th><div align='center'>Fecha de Carga:<br />$FechaInicial</div></th><th><div align='center'>Calculado Hasta:<br />$FechaFinal</div></th><th><div align='center'>Monto Cargado:<br />$ $monto</div></th><th><div align='center'>Km Estimados:<br />$km</div></th><th><div align='center'>Litros Aprox:<br />$litros</div></th></tr>
            "; 

        $difLt=$litros-$comparaLitro;
    $difKm=$km-$comparaKilometro;
    $costo=$comparaLitro*$gas;
    $difCosto=$difLt*$gas;
    $tablaHead.="   <tr><th></th><th></th><th><div align='right'>Total Consumido:</div></th><td><div align='center'>$ $costo</div></td><td><div align='center'>$comparaKilometro km</div></td><td><div align='center'>$comparaLitro L</div></td></tr>
                    <tr><th></th><th></th><th><div align='right'>Diferencia:</div></th><td><div align='center'>$ $difCosto</div></td><td><div align='center'>$difKm km</div></td><td><div align='center'>$difLt L</div></td></tr>
                    <tr><th><br /></th><th><br /></th><th><br /></th><th><br /></th><th><br /></th><th><br /></th></tr>
                    <tr><th>No. de Orden:</th><th>Fecha:</th><th>Origen:</th><th>Destino:</th><th>Kilometros:</th><th>Litros: </th></tr></thead>
            <tbody>";

            

    $tablaBody.="</tbody>";

    $agrega=$tablaHead.$tablaBody;   
    }


    
    echo $agrega;
}


if(isset($_POST['FechasDesactivaI'])&&isset($_POST['FechasDesactivaF'])){
    $inicio=$_POST['FechasDesactivaI'];
    $fin=$_POST['FechasDesactivaF'];

    $comienzo = $inicio;
    $final = $fin;
    $regresa="";
    for($i = $comienzo; $i <= $final; $i++){
        $regresa.= $i."\n";
    }
    echo  $regresa.$inicio.$fin;
}
?>
