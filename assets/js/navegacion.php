<header>

    <div>
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Botón para volver a Inicio -->
                <a class="navbar-brand" href="index.php?id=<?php if(isset($_GET["id"])){echo $_GET["id"];} ?>"><img src='./assets/img/granada.png' alt='Ayto.Granada: escudo del Ayuntamiento de Granada' title='Ayto.Granada: escudo del Ayuntamiento de Granada'></a> 
            </div>

            <div style="color: white; padding: 5px 5px 3px 40px; float: left; font-size: 16px;">
                <h1 color="white">Red de Ecopuntos de Granada</h1>
            </div>
            &nbsp;
        </nav> <!-- /. NAV TOP  -->

            <!-- Se muestra el ultimo acceso a la plataforma -->
        <div style="color: black; padding: 3px 3px 3px 3px; float: right; font-size: 11px;"> Último acaceso: 
            <script type="text/javascript">
                var d = new Date(); 
                var minutos = d.getMinutes();
                if(minutos<10){minutos = '0' + minutos; }
                document.write(d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear(), ' a las '+d.getHours(),':'+minutos, 'h.');
            </script>
        </div>
    <?php
        include ("menu.php");
    ?>

</header>