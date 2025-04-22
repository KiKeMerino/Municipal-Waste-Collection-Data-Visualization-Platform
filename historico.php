<!DOCTYPE html>
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
   <meta name = "author" content="Enrique Jose Merino Arribas">
   <?php include ("./database/conexion.php"); ?>
</head>

<body>
<div id="wrapper">

<?php include ("assets/js/navegacion.php"); ?>

    <!-- /. NAV SIDE  -->
<div id="page-wrapper" >
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h2>Peso recogido en 2021</h2>   
        </div>
    </div>            
    <!-- /. ROW  -->
    <hr/>
    

    <h3> &nbsp; Selecciona el contenedor</h3>
    <!----------------------------------------------------------------------------------------->     

    <div class="row" align="center">
    <a href="contenedores.php?residuo=RESTO&id=<?php if(isset($_GET["id"])){echo $_GET["id"];} ?>"> <img width=140px style='horizontal-align:middle' src="./assets/img/resto.png"> </a>
        <div class="panel panel-back noti-box">
            <div class="text-box" >
                <p class="main-text">
                    <?php
                        // Total de contenedores
                        $consulta="SELECT Id_contenedor FROM Inventario_contenedores WHERE `Tipo Residuo` = 'ORGANICA' ";//CAMBIAR: 'RESTO'
                        $lectura=mysqli_query ($conecta, $consulta);
                        $total_resto=mysqli_num_rows ($lectura);
                        echo ($total_resto);
                    ?>
                    de Resto
                </p>
            </div>
        </div>
    </div>

    <hr/><!----------------------------------------------------------------------------------------->

    <div class="row" align="center">
        <a href="contenedores.php?residuo=ENVASES&id=<?php if(isset($_GET["id"])){echo $_GET["id"];} ?>"> <img width=140px src="./assets/img/envases.png"> </a>
        <div class="panel panel-back noti-box">
            <div class="text-box" >
                <p class="main-text">
                    <?php
                        // Total de lecturas
                        $consulta="SELECT Id_contenedor FROM Inventario_contenedores WHERE `Tipo Residuo` = 'ENVASES' ";
                        $lectura=mysqli_query ($conecta, $consulta);
                        $total_envases=mysqli_num_rows ($lectura);
                        echo ($total_envases);
                    ?>
                    de Envases
                </p>
            </div>
        </div>
    </div>

    <hr/><!----------------------------------------------------------------------------------------->

    <div class="row" align="center">           
        <a href="contenedores.php?residuo=PAPEL&id=<?php if(isset($_GET["id"])){echo $_GET["id"];} ?>"> <img width=150px src="./assets/img/papel.png"> </a>
        <div class="panel panel-back noti-box">
            <div class="text-box" >
                <p class="main-text">
                    <?php
                        // Total de lecturas
                        $consulta="SELECT Id_contenedor FROM Inventario_contenedores WHERE `Tipo Residuo` = 'PAPEL' ";
                        $lectura=mysqli_query ($conecta, $consulta);
                        $total_papel=mysqli_num_rows ($lectura);
                        echo ($total_papel);
                    ?>
                    de Papel
                </p>
            </div>
        </div>
    </div>
        
    <hr/><!----------------------------------------------------------------------------------------->

    <div class="row" align="center">           
        <a href="contenedores.php?residuo=VIDRIO&id=<?php if(isset($_GET["id"])){echo $_GET["id"];} ?>"> <img width=120px src="./assets/img/vidrio.png"> </a>
        <div class="panel panel-back noti-box">
            <div class="text-box" >
                <p class="main-text">
                    <?php
                        // Total de lecturas
                        $consulta="SELECT Id_contenedor FROM Inventario_contenedores WHERE `Tipo Residuo` = 'VIDRIO' ";
                        $lectura=mysqli_query ($conecta, $consulta);
                        $total_vidrio=mysqli_num_rows ($lectura);
                        echo ($total_vidrio);
                    ?>
                    de Vidrio
                </p>
            </div>
        </div>
    </div>

    <hr/>
    <!-------------------- CAMBIAR: descomentar todo esto de abajo --------------------------------------------------------------------->

    <!--div class="row" align="center">          
        <a href="contenedores.php?residuo=ORGANICA&id=<?php if(isset($_GET["id"])){echo $_GET["id"];} ?>"> <img width=140px src="./assets/img/organica.png"> </a>
        <div class="panel panel-back noti-box">
            <div class="text-box" >
                <p class="main-text">
                    <?php
                        // Total de lecturas
                        $consulta="SELECT Id_contenedor FROM Inventario_contenedores WHERE `Tipo Residuo` = 'ORGANICA' ";
                        $lectura=mysqli_query ($conecta, $consulta);
                        $total_envases=mysqli_num_rows ($lectura);
                        echo ($total_envases);
                    ?>
                    de Organica
                </p>
            </div>
        </div>
    </div-->




    
</div> <!-- Fin page-inner -->
</div> <!-- Fin page-wrapper -->
</div> <!-- Fin page-wrapper -->


<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="assets/js/jquery.metisMenu.js"></script>
    <!-- MORRIS CHART SCRIPTS -->
<script src="assets/js/morris/raphael-2.1.0.min.js"></script>
<script src="assets/js/morris/morris.js"></script>
    
   
</body>
</html>
