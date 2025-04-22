
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Red de Ecopuntos</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <link type="text/css" href="assets/css/ui-darkness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
	<script type="text/javascript" src="assets/js/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui-1.8.23.custom.min.js"></script>
    <meta name = "author" content="Enrique Jose Merino Arribas">

    <?php
        // Configuracion de las tablas de las bases de datos
        $data = file_get_contents("database/data.json");
        $decoded_json = json_decode($data, true);
    
        // Tabla del inventario de contenedores con los campos utilizados
        $lista = $decoded_json["lista contenedores"];
        $inventario[0] = $lista[0]{"tabla"};
        $inventario[1] = $lista[1]{"id"};
        $inventario[2] = $lista[2]{"codigo"};
        $inventario[3] = $lista[3]{"tag"};
        $inventario[4] = $lista[4]{"tipo de contenedor"};
        $inventario[5] = $lista[5]{"tipo de residuo"};

        // Tabla con los distintos tipos de contenedores con su peso maximo y minimo
        $lista = $decoded_json["tipos contenedor"];
        $tipos_cont[0] = $lista[0]{"tabla"};
        $tipos_cont[1] = $lista[1]{"peso minimo"};
        $tipos_cont[2] = $lista[2]{"peso maximo"};
    
        // Tabla de los ecopuntos con los campos utilizados
        $lista = $decoded_json["ecopuntos"];
        $ecopuntos[0] = $lista[0]{"tabla"};
        $ecopuntos[1] = $lista[1]{"id del ecopunto"};
        $ecopuntos[2] = $lista[2]{"id del contenedor"};
    
        // Tabla de las recogidas realizadas en 2021 con los campos utilizados
        $lista = $decoded_json["recogidas historico"];
        $recogidas_h[0] = $lista[0]{"tabla"};
        $recogidas_h[1] = $lista[1]{"peso"};
        $recogidas_h[2] = $lista[2]{"fecha"};
        $recogidas_h[3] = $lista[3]{"codigo contenedor"};
    
        // Tabla actual de recogidas con los campos utilizados
        $lista = $decoded_json["recogidas actual"];
        $recogidas_a[0] = $lista[0]{"tabla"};
        $recogidas_a[1] = $lista[1]{"peso"};
        $recogidas_a[2] = $lista[2]{"fecha"};
        $recogidas_a[3] = $lista[3]{"tipo de residuo"};
        $recogidas_a[4] = $lista[4]{"tag"};

        $ocultar_vidrio = $decoded_json["ocultar vidrio"];

        if(isset($_GET["id"])){$id_eco = $_GET["id"]; }
        else{$id_eco = 'X'; }


        // Si no se especifica la vista, por defecto será Recogidas al escanear el QR
        if(isset($_GET["view"])){$view = $_GET["view"]; }
        else{$view = 'Recogidas'; }
        
        // Por defecto se mostrará el rango de fechas desde hace un mes hasta el dia de hoy
        if(!isset($_POST['fecha1'])){
            $_POST['fecha1'] = date("Y-m-d",strtotime("-1 month"));
        }
        if(!isset($_POST['fecha2'])){
            $_POST['fecha2'] = date("Y-m-d");
        }

        // Por defecto se mostrarán todos los residuos (checkbox marcados)
        if(!isset($_POST['residuos'])){
            $_POST['residuos'] = ['RESTO', 'PAPEL', 'ENVASES', 'VIDRIO', 'ORGANICA'];
        }
        $selection = $_POST['residuos'];

        // Por defecto se mostrarán en la tabla las 5 ultimas recogidas
        if(isset($_GET["tab"])){$tab = $_GET["tab"]; }
        else{$tab = 5; }

        include ("./database/conexion.php");

        if($id_eco == 'X'){
             echo '<script type="text/javascript">
                    alert("Primero debe seleccionar un ecopunto para visualizar sus datos");
                    window.location.assign("index.php");
                    </script>';
        }

      
        // Lectura del Tipo de residuo, Tag, Codigo y Tipo de Contenedor del ecopunto actual.
        if($ocultar_vidrio == true){
            $consulta11 = "SELECT `$inventario[5]`, `$inventario[3]`, `$inventario[2]`, `$inventario[4]` FROM `$ecopuntos[0]` INNER JOIN `$inventario[0]` ON `$ecopuntos[0]`.`$ecopuntos[2]` = `$inventario[0]`.`$inventario[1]` WHERE `$ecopuntos[1]` = $id_eco AND (`$inventario[5]` = 'ORGANICA' OR `$inventario[5]` = 'RESTO' OR `$inventario[5]` = 'ENVASES' OR `$inventario[5]` = 'PAPEL')";
        }
        else{
            $consulta11 = "SELECT `$inventario[5]`, `$inventario[3]`, `$inventario[2]`, `$inventario[4]` FROM `$ecopuntos[0]` INNER JOIN `$inventario[0]` ON `$ecopuntos[0]`.`$ecopuntos[2]` = `$inventario[0]`.`$inventario[1]` WHERE `$ecopuntos[1]` = $id_eco AND (`$inventario[5]` = 'ORGANICA' OR `$inventario[5]` = 'RESTO' OR `$inventario[5]` = 'ENVASES' OR `$inventario[5]` = 'PAPEL' OR `$inventario[5]` = 'VIDRIO')";
        }
            $lectura11 = mysqli_query ($conecta, $consulta11);
	    $total = mysqli_num_rows($lectura11);
	    while ($lecturas=$lectura11->fetch_array()){ // Mientras halla pesos que leer:
            if($lecturas["$inventario[5]"] == 'ORGANICA'){  // CAMBIAR: eliminar linea
                $residuos[] = 'RESTO';  // CAMBIAR: eliminar linea
            }   // CAMBIAR: eliminar linea
            else{// CAMBIAR: eliminar linea
		        $residuos[] = $lecturas["$inventario[5]"];
            }// CAMBIAR: eliminar linea
		    $tags[] = $lecturas["$inventario[3]"];
            $codigos[] = $lecturas["$inventario[2]"];
            $tipos[] = $lecturas["$inventario[4]"];
	    }

        // Filtro de Pesos calculado a partir de la densidad sin compactar del residuo y el volumen del contenedor
        $consulta = "SELECT `$tipos_cont[1]`, `$tipos_cont[2]` FROM `$tipos_cont[0]`";
        $lectura = mysqli_query($conecta, $consulta);
        while($lecturas=$lectura->fetch_array()){
            $minimos[] = $lecturas["Limite_min"];
            $maximos[] = $lecturas["Peso_max"];
        }
        $ALEHOPVIDRIO_min = $minimos[0]; $ALEHOPVIDRIO_max = $maximos[0]; $ENVASESSOTERRADOGANCHO_min = $minimos[1]; $ENVASESSOTERRADOGANCHO_max = $maximos[1]; $ENVASESSOTERRADOLATERAL_min = $minimos[2]; $ENVASESSOTERRADOLATERAL_max = $maximos[2]; $ENVASESSUPGANCHO_min = $minimos[3]; $ENVASESSUPGANCHO_max = $maximos[3]; $IGLUVIDRIO_min = $minimos[4]; $IGLUVIDRIO_max = $maximos[4]; $LATERALENV32_min = $minimos[5]; $LATERALENV32_max = $maximos[5]; $LATERALORG24_min = $minimos[6]; $LATERALORG24_max = $maximos[6]; $LATERALORG32_min = $minimos[7]; $LATERALORG32_max = $maximos[7]; $LATERALPAPELCARTON32_min = $minimos[8]; $LATERALPAPELCARTON32_max = $maximos[8]; $ORGANICASOTERRADOLATERAL_min = $minimos[9]; $ORGANICASOTERRADOLATERAL_max = $maximos[9]; $PAPELCARTONSOTERRADOGANCHO_min = $minimos[10]; $PAPELCARTONSOTERRADOGANCHO_max = $maximos[10]; $PAPELCARTONSOTERRADOLATERAL_min = $minimos[11]; $PAPELCARTONSOTERRADOLATERAL_max = $maximos[11]; $PAPELCARTONSUPGANCHO_min = $minimos[12]; $PAPELCARTONSUPGANCHO_max = $maximos[12]; $VIDRIOGANCHOSOTERRADO_min = $minimos[14]; $VIDRIOGANCHOSOTERRADO_max = $maximos[14]; 
        function filtrado($lcPeso, $tipo, $minimos, $maximos){
            $filtro = false;
            switch($tipo){
                case 'ALE-HOP VIDRIO':
                    if($lcPeso > $minimos[0] && $lcPeso < $maximos[0]){
                        $filtro = true;
                    }
                    break;
                case 'ENVASES SOTERRADO GANCHO':
                    if($lcPeso > $minimos[1] && $lcPeso < $maximos[1]){
                        $filtro = true;
                    }
                    break;
                case 'ENVASES SOTERRADO LATERAL':
                    if($lcPeso > $minimos[2] && $lcPeso < $maximos[2]){
                        $filtro = true;
                    }
                    break;
                case 'ENVASES SUP. GANCHO':
                    if($lcPeso > $minimos[3] && $lcPeso < $maximos[3]){
                        $filtro = true;
                    }
                    break;
                case 'IGLU VIDRIO':
                    if($lcPeso > $minimos[4] && $lcPeso < $maximos[4]){
                        $filtro = true;
                    }
                    break;
                case 'LATERAL ENV 32':
                    if($lcPeso > $minimos[5] && $lcPeso < $maximos[5]){
                        $filtro = true;
                    }
                    break;
                case 'LATERAL ORG 24':
                    if($lcPeso > $minimos[6] && $lcPeso < $maximos[6]){
                        $filtro = true;
                    }
                    break;
                case 'LATERAL ORG 32':
                    if($lcPeso > $minimos[7] && $lcPeso < $maximos[7]){
                        $filtro = true;
                    }
                    break;
                case 'LATERAL PAPEL-CARTON 32':
                    if($lcPeso > $minimos[8] && $lcPeso < $maximos[8]){
                        $filtro = true;
                    }
                    break;
                case 'ORGANICA SOTERRADO LATERAL':
                    if($lcPeso > $minimos[9] && $lcPeso < $maximos[9]){
                        $filtro = true;
                    }
                    break;
                case 'PAPEL-CARTON SOTERRADO GANCHO':
                    if($lcPeso > $minimos[10] && $lcPeso < $maximos[10]){
                        $filtro = true;
                    }
                    break;
                case 'PAPEL-CARTON SOTERRADO LATERAL':
                    if($lcPeso > $minimos[11] && $lcPeso < $maximos[11]){
                        $filtro = true;
                    }
                    break;
                case 'PAPEL-CARTON SUP. GANCHO':
                    if($lcPeso > $minimos[12] && $lcPeso < $maximos[12]){
                        $filtro = true;
                    }
                    break;
                case 'VIDRIO GANCHO SOTERRADO':
                    if($lcPeso > $minimos[14] && $lcPeso < $maximos[14]){
                        $filtro = true;
                    }
                    break;
            }
            return $filtro;
        }
    ?>

</head>

<body>
<div id="wrapper">

<?php include ("assets/js/navegacion.php"); ?>

<div id="page-wrapper">
<div id="page-inner">

<!-- TITULO: Recogidas del ecopunto X -->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12" style="color: red;">
        <h1><?php echo $view." del ecopunto ".$id_eco; ?></h1>
    </div>
    <hr/>
</div>

<!-- Redirige en una pestaña nueva a la web de GranadaMejora o a la Aplicacion en Play Store/AppStore -->
<font size="4">
    Si tiene alguna incidencia acceda a <a href='https://gecorweb.com/login' target="_blank"> nuestra web </a>
    o a nuestra app disponible para <a href='https://play.google.com/store/apps/details?id=granada.gecorsystem.gecorn&hl=es&gl=US' target="_blank"> Android</a> &nbsp; / &nbsp; <a href='https://apps.apple.com/es/app/granada-mejora/id1463527383' target="_blank"> IOS</a>
    <hr/>
</font>


<div style="width: 100%; height: 300px;" id="mapdiv"></div>
<?php include("mapa.php");?>
<script>
    if(id_eco != 'X'){
        var longitud_centro = lon[id_eco];
        var latitud_centro = lat[id_eco];
        var zoom = 18;
}
var lonLat = new OpenLayers.LonLat(longitud_centro,latitud_centro).transform(epsg4326,projectTo);// Latitud y Longitud normal            

map.setCenter (lonLat, zoom);
</script>

<script>    // Script para deshabilitar el zoom y el arrastre del mapa
var i, l, c = map.getControlsBy( "zoomWheelEnabled", true );
for ( i = 0, l = c.length; i < l; i++ ) {
    c[i].disableZoomWheel();
}
for (var i = 0; i< map.controls.length; i++) {
    if (map.controls[i].displayClass == 
                "olControlNavigation") {
        map.controls[i].deactivate();
    }
}
</script>

<!-- Muestra el numero de contenedores del ecopunto. Ej -> 7 Contendores: -3 de resto -2 de papel -2 de envases -->
<div class="row">
    <div class="col-12">
        <div class="panel panel-back noti-box" style="horizontal-align:middle" style="vertical-align:middle">
            <div class="text-box" >
                <p class="main-text">
                    <?php
                        $contador = array(0, 0, 0, 0, 0);
                        echo "<u>".$total."&nbsp;Contenedores:</u><br><br>";

                        // Recuento del numero de contenedores de cada tipo
                        for($i = 0; $i < $total; $i++){
                            switch($residuos[$i]){
                                case 'RESTO':   
                                    $contador[0]++;
                                    $distinct[0] = 'RESTO';
                                    break;
                                case 'ENVASES':
                                    $contador[1]++;
                                    $distinct[1] = 'ENVASES';
                                    break;
                                case 'PAPEL':
                                    $contador[2]++;
                                    $distinct[2] = 'PAPEL';
                                    break;
                                case 'VIDRIO':
                                    $contador[3]++;
                                    $distinct[3] = 'VIDRIO';
                                    break;
                                case 'ORGANICA':
                                    $contador[4]++;
                                    $distinct[4] = 'ORGANICA'; 
                                    break;
                            }
                        }
                echo "</p>";
                        if($contador[0] != 0){
                            echo "<font size='4'>&nbsp;&nbsp;&nbsp;- ".$contador[0]." de resto.</font><br>";
                        }
                        if($contador[1] != 0){
                            echo "<font size='4'>&nbsp;&nbsp;&nbsp;- ".$contador[1]." de envases.</font><br>";
                        }
                        if($contador[2] != 0){
                            echo "<font size='4'>&nbsp;&nbsp;&nbsp;- ".$contador[2]." de papel.</font><br>";
                        }
                        if($contador[3] != 0){
                            echo "<font size='4'>&nbsp;&nbsp;&nbsp;- ".$contador[3]." de vidrio.</font><br>";
                        }
                        if($contador[4] != 0){
                            echo "<font size='4'>&nbsp;&nbsp;&nbsp;- ".$contador[4]." de organica.</font><br>"; 
                        }
                        
                    ?>
            </div>
        </div>
    </div>
</div>

<!-- Por cada tipo de residuo se muestra la opcion de un checkbox con una imagen de cada contenedor correspondiente SIN REPETIR residuo -->
<div class="row">
    <div align="center" class='col-md-12 col-sm-12 col-xs-12'>
        <?php
            echo '<form action="#" method="post">';

            if($contador[0] != 0){
                echo("&nbsp;<label><input type='checkbox' name='residuos[]' value='RESTO' checked><img width='154px' src='./assets/img/resto.png'></label>&nbsp;");
            }

            if($contador[1] != 0){
                echo("&nbsp;<label><input type='checkbox' name='residuos[]' value='ENVASES' checked><img width='154px' src='./assets/img/envases.png'></label>&nbsp;");
            }

            if($contador[2] != 0){
                echo("&nbsp;<label><input type='checkbox' name='residuos[]' value='PAPEL' checked><img width='168px' src='./assets/img/papel.png'></label>&nbsp;");
            }

            if($contador[3] != 0){
                echo("&nbsp;<label><input type='checkbox' name='residuos[]' value='VIDRIO' checked><img width='126px' src='./assets/img/vidrio.png'></label>&nbsp;");
            }

            if($contador[4] != 0){
                echo("&nbsp;<label><input type='checkbox' name='residuos[]' value='ORGANICA' checked><img width='154px' src='./assets/img/organica.png'></label>&nbsp;"); 
            }
        ?>

        <br><br>

        <h3>
            <form action="#tabla" method="POST"/>
                Desde:&nbsp;<input type="date" name="fecha1" min="2021-01-01" max = $maximos[];="<?php echo date("Y-m-d");?>" value="<?php echo $_POST["fecha1"];?>"><br><br>
                Hasta:&nbsp;<input type="date" name="fecha2" min="2021-01-01" max = $maximos[];="<?php echo date("Y-m-d");?>" value="<?php echo $_POST["fecha2"];?>">
                <br><br><div align="center"><input type="submit" name="comprobar" value="Ver"/><br></div>
            </form>
        </h3>
    </div>
</div>

<!-- Visualizacion de la grafica -->
<div id="grafica" class= "row">
    <div class="col-md-12 col-sm-12 col-xs-12">           
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php
                // Se muestra el rango de fechas de la grafica en formato dd/mm/yyyy
                    if($_POST['fecha1'] == date("Y-m-d",strtotime("-1 month")) && $_POST['fecha2'] == date("Y-m-d")){
                        echo("<h4>".$view." en el último mes</h4>");
                    }
                    else if($_POST['fecha1'] == date("Y-m-d",strtotime("-1 week")) && $_POST['fecha2'] == date("Y-m-d")){
                        echo("<h4>".$view." en la última semana</h4>");
                    }
                    else{
                        echo("<h4>".$view." desde el ". date("d/m/Y",strtotime($_POST['fecha1']))." hasta el ".date("d/m/Y",strtotime($_POST['fecha2']))."</h4>");
                    }
                ?>
            </div>
            <div class="panel-body">
                <div id="grafica-donut"></div>
                <div id="legend" class="donut-legend"></div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla con las ultimas x recogidas -->
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 style="text-align:center"><?php echo $tab; ?> últimas recogidas </h4>
        </div>
        <?php
            $link = "ecopunto.php?id=$id_eco&view=$view";
            echo("<div><br>
                    <a href='".$link."&tab=1#tabla'> <p style='text-align:center; margin:0 0 0px; padding-top: 10px'>Última recogida de cada contenedor</p> </a>
                    <a href='".$link."&tab=5#tabla'> <p style='text-align:center; margin:0 0 0px; padding-top: 10px'>5 Últimas recogidas</p> </a>
                    <a href='".$link."&tab=10#tabla'> <p style='text-align:center; margin:0 0 0px; padding-top: 10px'>10 Últimas recogidas</p> </a>
                    <a href='".$link."&tab=20#tabla'> <p style='text-align:center; margin:0 0 0px; padding-top: 10px'>20 Últimas recogidas</p> </a>
                </div>");
        ?>

        <div id="tabla" class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Residuo</th>
                            <th>Fecha</th>
                            <th>Peso</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $contador = 0;
                            if($tab > 1){
                                if($ocultar_vidrio == true){
                                    $consulta = "SELECT `$recogidas_a[3]`, `$recogidas_a[2]`, `$recogidas_a[1]`, `$inventario[4]` FROM `$recogidas_a[0]` INNER JOIN `$ecopuntos[0]` INNER JOIN `$inventario[0]` ON `$inventario[0]`.`$inventario[1]` = `$ecopuntos[0]`.`$ecopuntos[2]` ON `$recogidas_a[0]`.`$recogidas_a[4]` = `$inventario[0]`.`$inventario[3]` WHERE `$ecopuntos[1]` = $id_eco AND (`$recogidas_a[3]` = 'ORGANICA' OR `$recogidas_a[3]` = 'RESTO' OR `$recogidas_a[3]` = 'ENVASES' OR `$recogidas_a[3]` = 'PAPEL') ORDER BY `$recogidas_a[2]` DESC";
                                }
                                else{
                                    $consulta = "SELECT `$recogidas_a[3]`, `$recogidas_a[2]`, `$recogidas_a[1]`, `$inventario[4]` FROM `$recogidas_a[0]` INNER JOIN `$ecopuntos[0]` INNER JOIN `$inventario[0]` ON `$inventario[0]`.`$inventario[1]` = `$ecopuntos[0]`.`$ecopuntos[2]` ON `$recogidas_a[0]`.`$recogidas_a[4]` = `$inventario[0]`.`$inventario[3]` WHERE `$ecopuntos[1]` = $id_eco AND (`$recogidas_a[3]` = 'ORGANICA' OR `$recogidas_a[3]` = 'RESTO' OR `$recogidas_a[3]` = 'ENVASES' OR `$recogidas_a[3]` = 'PAPEL' OR `$recogidas_a[3]` = 'VIDRIO') ORDER BY `$recogidas_a[2]` DESC";
                                }
                                $lectura = mysqli_query($conecta, $consulta);
                                while( ($lecturas = $lectura->fetch_array() ) && $contador < $tab){ // Mientras halla datos que leer:
                                    $lcTipo = $lecturas["$inventario[4]"];
                                    $lcPeso = $lecturas["$recogidas_a[1]"];

                                    if(filtrado($lcPeso, $lcTipo, $minimos, $maximos)){
                                        echo ("<tr>");
                                        $lcGarbage=$lecturas["$recogidas_a[3]"];
                                        if($lcGarbage == 'ORGANICA'){$lcGarbage='RESTO';}   // CAMBIAR: eliminar linea
                                        echo ("<td>".$lcGarbage."</td>");
                                        $lcFecha = date("d/m/Y", strtotime($lecturas["$recogidas_a[2]"]));
                                        echo ("<td>".$lcFecha."</td>");
                                        echo ("<td>".$lcPeso." Kg</td>");
                                        
                                        echo ("</tr>");
                                        $contador++;
                                    }
                                }
                            }

                            else if($tab == 1){
                                $residuos_uniq = array_unique($residuos);
                                $tab = count($residuos_uniq);
                                foreach($residuos_uniq as $residuo){
				    if ( $residuo ==  "RESTO") { $residuo = "ORGANICA"; } // CAMBIAR: eliminar lina
                                    $consulta = "SELECT `$recogidas_a[3]`, `$recogidas_a[2]`, `$recogidas_a[1]`, `$inventario[4]` FROM `$recogidas_a[0]` INNER JOIN `$ecopuntos[0]` INNER JOIN `$inventario[0]` ON `$inventario[0]`.`$inventario[1]` = `$ecopuntos[0]`.`$ecopuntos[2]` ON `$recogidas_a[0]`.`$recogidas_a[4]` = `$inventario[0]`.`$inventario[3]` WHERE `$ecopuntos[1]` = $id_eco AND `$recogidas_a[3]` = '$residuo' ORDER BY `$recogidas_a[2]` DESC";
                                    $lectura = mysqli_query($conecta, $consulta);
                                    $encontrado = false;
                                    while( ($lecturas = $lectura->fetch_array() ) && ($contador < $tab) && (!$encontrado) ){ // Mientras halla datos que leer:
                                        $lcTipo = $lecturas["$inventario[4]"];
                                        $lcPeso = $lecturas["$recogidas_a[1]"];
                                        if(filtrado($lcPeso, $lcTipo, $minimos, $maximos)){
                                            echo ("<tr>");
                                            $lcGarbage=$lecturas["$recogidas_a[3]"];
                                            if($lcGarbage == 'ORGANICA'){$lcGarbage='RESTO';}   // CAMBIAR: eliminar linea
                                            echo ("<td>".$lcGarbage."</td>");
                                            $lcFecha = date("d/m/Y", strtotime($lecturas["$recogidas_a[2]"]));
                                            echo ("<td>".$lcFecha."</td>");
                                            echo ("<td>".$lcPeso." Kg</td>");
                                            
                                            echo ("</tr>");
                                            $contador++;
                                            $encontrado = true;
                                        }
                                    }
                                }
                            }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- CONTADOR DE VISITAS -->
<script>
    function getexpirydate(nodays){
        var UTCstring;
        Today = new Date();
        nomilli=Date.parse(Today);
        Today.setTime(nomilli+nodays*24*60*60*1000);
        UTCstring = Today.toUTCString();
        return UTCstring;
    }

    function getcookie(cookiename){
        var cookiestring=""+document.cookie;
        var index1=cookiestring.indexOf(cookiename);
        if (index1==-1 || cookiename=="")
            return "";
        var index2=cookiestring.indexOf(";",index1);
        if (index2==-1)
            index2=cookiestring.length;
        return unescape(cookiestring.substring(index1+cookiename.length+1,index2));
    }

    function setcookie(name,value,duration){
        cookiestring=name+"="+escape(value)+";EXPIRES="+getexpirydate(duration);
        document.cookie=cookiestring;
        if(!getcookie(name)){
            return false;
        }
        else{
            return true;
        }
    }

    count= getcookie("counter");
    if(isNaN(count)){
        y = setcookie("counter",0,1);
        count=0;
    }
    count++;
    document.write("<p style='float:right;'>" + count + " visitas</p>");

    y = setcookie("counter",count,1);

</script>

<!-- FIN DEL CONTADOR DE VISITAS -->

</div> <!-- /. PAGE-INNER -->
</div> <!-- /. PAGE-WRAPPER -->
</div> <!-- /. WRAPPER  -->



<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->

<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="assets/js/jquery.metisMenu.js"></script>
<!-- MORRIS CHART SCRIPTS -->
<script src="assets/js/morris/raphael-2.1.0.min.js"></script>
<script src="assets/js/morris/morris.js"></script>
<!-- CUSTOM SCRIPTS -->
<?php include("assets/js/customjs_eco.php"); ?>

</body>
</html>
