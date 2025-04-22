<meta charset="utf-8"/>
<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
			<li class="text-center">
                <br><br>
			</li>

		    <li>
                <a class="active-menu" href="index.php?id=<?php if(isset($_GET["id"]) && $_GET["id"] != ''){echo $_GET["id"];} else{echo 'X';} ?>"> <i class="fa fa-map-marker fa-2x"></i> Mapa</a>
            </li>

            <li>
                <a href= "ecopunto.php?id=<?php if(isset($_GET["id"]) && $_GET["id"] != ''){echo $_GET["id"];} else{echo 'X';} ?>&view=Recogidas"><i class="fa fa-trash-o fa-2x"></i>Recogidas del ecopunto</a>
            </li>

            <li>
                <a href="ecopunto.php?id=<?php if(isset($_GET["id"]) && $_GET["id"] != ''){echo $_GET["id"];} else{echo 'X';} ?>&view=Pesos"><i class="fa fa-dashboard fa-2x"></i>Pesos del ecopunto</a>
            </li>

            <li>
                <a href="historico.php?id=<?php if(isset($_GET["id"]) && $_GET["id"] != ''){echo $_GET["id"];} else{echo 'X';} ?>"><i class="fa fa-desktop fa-2x"></i>Evolución anual</a>
            </li>

            <li>
                <a href="acercade.php?id=<?php if(isset($_GET["id"]) && $_GET["id"] != ''){echo $_GET["id"];} else{echo 'X';} ?>"><i class="fa fa-info-circle fa-2x" aria-hidden="true"></i>Acerca de...</a>
            </li>

        </ul>
    </div>
</nav> 
