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



</head>
<body>
<div id="wrapper">

<?php include ("assets/js/navegacion.php"); ?>

<div id="page-wrapper">
<div id="page-inner">

<main>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12" style="color: black;">
        <h1>Seleccione un ecopunto para visualizar sus datos</h1>
    </div>
    <hr/>
</div>
<div tabindex="1" id="mapdiv"></div>
    <?php include("mapa.php"); ?>

</main>

</div> <!--FIN: page-wrapper -->
</div> <!--FIN:  page-inner  -->

</body>
</html>
