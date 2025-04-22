<script>
(function ($){
    "use strict";
    var mainApp = {

        main_fun: function () {
            /*====================================
            METIS MENU 
            ======================================*/
            $('#main-menu').metisMenu();

            /*====================================
              LOAD APPROPRIATE MENU BAR
           ======================================*/
            $(window).bind("load resize", function () {
                if ($(this).width() < 768) {
                    $('div.sidebar-collapse').addClass('collapse')
                } else {
                    $('div.sidebar-collapse').removeClass('collapse')
                }
            });

//-------------------------------------------------------------------------------------------------------//

<?php

    $datos = array(0, 0, 0, 0, 0);
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $selection = $_POST['residuos'];
    
    // Por cada contenedor del ecopunto...
    for($i = 0; $i < $total; $i++){
        $residuo = $residuos[$i];
        $tag = $tags[$i];
        $codigo = $codigos[$i];
        $tipo = $tipos[$i];
        // 2 consultas para tener en cuenta la tabla actual ($t_actual) y la tabla historica ($t_historico)
        $consulta1 = "SELECT `$recogidas_h[1]` AS Peso FROM `$recogidas_h[0]` WHERE `$recogidas_h[3]` = '$codigo' AND `$recogidas_h[2]` BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) ORDER BY `$recogidas_h[2]` ASC";
        $consulta2 = "SELECT `$recogidas_a[1]` AS Peso FROM `$recogidas_a[0]` WHERE `$recogidas_a[4]` = '$tag' AND `$recogidas_a[2]` BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) ORDER BY `$recogidas_a[2]` ASC";

        // Si esta marcado el checkbox...
        if(in_array($residuo, $selection)){
            $lectura1 = mysqli_query($conecta, $consulta1);
            $lectura2 = mysqli_query($conecta, $consulta2);
            $recogidas = 0;
            while( $lecturas = $lectura1->fetch_array() ){
                $peso1 = $lecturas["Peso"];
                if(filtrado($peso1, $tipo, $minimos, $maximos)){
                    if($view == 'Recogidas'){
                        $recogidas++;    // De aqui van a salir en numero de recogidas filtradas en 2021
                    }
                    elseif($view == 'Pesos'){
                        $recogidas += $peso1;   // De aqui va a salir la suma de pesos filtrados en 2021
                    }
                }
            }
            while( $lecturas = $lectura2->fetch_array() ){
                $peso2 = $lecturas["Peso"];
                if(filtrado($peso2, $tipo, $minimos, $maximos)){
                    if($view == 'Recogidas'){
                        $recogidas++;    // De aqui van a salir en numero de recogidas filtradas en 2022
                    }
                    elseif($view == 'Pesos'){
                        $recogidas += $peso2;   // De aqui va a salir la suma de pesos filtrados en 2022
                    }
                }
            }

            switch($residuo){
                case 'RESTO':
                    $datos[0] += $recogidas;
                    break;
                case 'ENVASES':
                    $datos[1] += $recogidas;
                    break;
                case 'PAPEL':
                    $datos[2] += $recogidas;
                    break;
                case 'VIDRIO':
                    $datos[3] += $recogidas;
                    break;
                case 'ORGANICA':
                    $datos[4] += $recogidas;  
                    break;
            }
        }
	}
?>

var pesos = <?php echo json_encode($datos); ?>;
var datos= [
    {fecha:'Resto',  r:pesos[0]},
    {fecha:'Envases',  r:pesos[1]},
    {fecha:'Papel',  r:pesos[2]},
    {fecha:'Vidrio',  r:pesos[3]},
    {fecha:'Organica',  r:pesos[4]}
];

// Datos para grafica con barras
/*    var config = {
        element: 'grafica-barras',
        data: datos,
        xkey: 'fecha',
        parseTime: false,
        ykeys: ['r'],
        labels: ['Resto','Envases','Papel','Vidrio','Organica'],
        barColors: function(row, series, type) {
            if (type != 'bar') {
            return;
            }
            switch (row.x) {
            case 0: return '#afb9be';
            case 1: return '#f7d84e';
            case 2: return '#09227b';
            case 3: return '#048e14';
            case 4: return '#8e3f2e';
            }
        },
        pointSize: 3,
        hideHover: 'auto',
        resize: true
    };*/
//Morris.Donut(config);

// Datos para grafica donut
    var browsersChart = Morris.Donut({
            element: 'grafica-donut',
            data: [{
                label: "Resto",
                value: pesos[0]
            }, {
                label: "Envases",
                value: pesos[1]
            }, {
                label: "Papel",
                value: pesos[2]
            }, {
                label: "Vidrio",
                value: pesos[3]
            }, {
                label: "Orgánica", 
                value: pesos[4]
            }],
            colors: ['#afb9be', '#f7d84e', '#09227b', '#048e14', '#8e3f2e'],
            resize: true,
     
        })

    browsersChart.options.data.forEach(function(label, i) {
        var legendItem = $('<span></span>').text( label['label'] + " ( " +label['value'] + " )" ).prepend('<br><span>&nbsp;</span>');
        legendItem.find('span')
        .css('backgroundColor', browsersChart.options.colors[i])
        .css('width', '20px')
        .css('display', 'inline-block')
        .css('margin', '5px');
        $('#legend').append(legendItem)
    });



//--------------------------------------------------------------------------------------------------------//   

        },

        initialization: function () {
            mainApp.main_fun();

        }

    }
    // Initializing ///

    $(document).ready(function () {
        mainApp.main_fun();
    });

}(jQuery));

</script>
