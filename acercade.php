
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

</head>

<body>
<div id="wrapper">

<?php include ("assets/js/navegacion.php"); ?>

<div id="page-wrapper">
<div id="page-inner">

<center>
    <div class="titulo"> Objetivo </div>
</center>
<p class="cuerpo">
    El objetivo principal es poder visualizar de manera abierta los datos relativos a los ecopuntos como son:
    <ul class="cuerpo">
        <li> La localización de cada ecopunto en un mapa interactivo de Granada </li>
        <li> El número de recogidas de cada residuo en el ecopunto </li>
        <li> El peso recogido de cada residuo en el ecopunto </li>
        <li> La evolución anual de cada residuo relativo al peso total recogido en toda Granada </li>
    </ul>
</p>

<center>
    <div class="titulo">Funcionamiento de la Web </div>
</center>

<p class="cuerpo"> La web consta de: </p>

<ul class="cuerpo">
    <li> El logo del Ayuntamiento de Granada al que podemos clickar y que redijirá al inicio de la web (un mapa con todos los ecopuntos en Granada) </li>
    <li> Una pequeña nota con la fecha y hora de la ultima consulta a la web </li>
    <li>Un mensaje para realizar cualquier tipo de petición redirigiendo a la pagina web o app de 'Granada Mejora' </li>
    <li> Un menú de 4 opciones con el que moverse en la página web </li>
</ul>

<p class="cuerpo"> El menú tiene 4 opciones con las que podremos navegar a través de las distintas partes de la web: </p>

<ul class="cuerpo">
    <li> Mapa: se trata de un mapa en el que se visualizan todos los ecopuntos con su enlace a la url para visualizarlo con mas detalle </li>

    <li> Recogidas del ecopunto: se visualiza el numero de recogidas del ultimo mes, siendo este intervalo de tiempo personalizable, y tambien una tabla con las ultimas recogidas que se han hecho en el ecopunto, pudiendose cambiar este valor a las 5, 10, 20 o incluso las ultimas recogidas de cada contenedor del ecopunto </li>

    <li> Pesos del ecopunto se visualiza el peso recogido en el intervalo de tiempo seleccionado de los contenedores del ecopunto, y tambien una tabla con las ultimas recogidas que se han hecho en el ecopunto, pudiendose cambiar este valor a las 5, 10, 20 o incluso las ultimas recogidas de cada contenedor del ecopunto </li>

    <li> Evolución anual: en el que se ve la suma de los pesos del contenedor seleccionado por meses del año de 2021 </li>
</ul>

<p class="cuerpo">
    Este menú será siempre visible por lo que podremos navegar hacia cualquier punto siempre que se quiera.
    Si se intenta visualizar los pesos o las recogidas del ecopunto sin haber seleccionado ninguno, saltará una alerta diciendo que debemos seleccionar algún ecopunto y redirigiendo al inicio para poder seleccionarlo en el mapa
</p>
<br>

<center>
    <div class="titulo"> Quienes somos </div>
</center>
<p class="cuerpo">
    Proyecto realizado por Enrique Merino, estudiante de Ingeniería Informática en la Universidad de Granada en colaboración con el Ayuntamiento por el sistema Ícaro.
</p>

<footer class="cuerpo">
    <adress>
        <a href="mailto:kikemerino@correo.ugr.es"> Contacto </a><br>
    </adress>
</footer>

    
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