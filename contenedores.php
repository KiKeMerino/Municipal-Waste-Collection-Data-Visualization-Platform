<!DOCTYPE html>

<head>
    <meta charset="utf-8" />    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestion de contenedores</title>
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
    <?php
        $res = $_GET["residuo"]; 
        include ("./database/conexion.php");
    ?>
</head>

<body>
<div id="wrapper">

<?php include ("assets/js/navegacion.php"); ?>

<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2> Peso de los contenedores de 
                    <?php
                        if($res == 'ORGANICA'){echo "Organica";}
                        else if($res == 'ENVASES'){echo "Envases";}
                        else if($res == 'PAPEL'){echo "Papel";}
                        else if($res == 'VIDRIO'){echo "Vidrio";}
                        else if($res == 'RESTO'){echo "Resto";}
                    ?>
                </h2> 

                <h5>Enrique Jose Merino Arribas</h5>
            </div>
        </div>

        <hr/>

        <!---------------------------------------------------------------------------------------------->
        
        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">                     
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Informe resumido de lectura de contenedores
                    </div>
                    <div class="panel-body">
                        <div id="grafico"></div>
                    </div>
                </div>            
            </div>               
        </div>

        <!---------------------------------------------------------------------------------------------->


    
    </div>

</div> <!-- /. WRAPPER  -->
</div> <!-- /. WRAPPER  -->


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
<!-- CUSTOM SCRIPTS 
<script src="assets/js/customjs_cont.php"></script> -->
<?php include ("assets/js/customjs_cont.php"); ?>

</body>
</html>
