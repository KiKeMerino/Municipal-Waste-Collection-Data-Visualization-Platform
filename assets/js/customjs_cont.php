<script>
(function ($) {
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

//------------------------------------------------------------------------------------------------------------//

<?php
    $pesos = array(12);
    for($mes = 0; $mes < 12; $mes++){
        $consulta ="SELECT SUM(`Peso (Kg)`) AS PesoMes FROM `Recogidas 2021` WHERE Residuo = '$res' AND MONTH(Fecha) = $mes";
        $lectura = mysqli_query($conecta, $consulta);
        $peso = mysqli_fetch_assoc($lectura)["PesoMes"];
        if(!is_null($peso))
            $pesos[$mes] = $peso;
        else
            $pesos[$mes] = 0;
    }
?>

var pesos = <?php echo json_encode($pesos); ?>;
var color = '';
var residuo = '<?php echo ($res); ?>';

if(residuo == 'RESTO'){color = '#afb9be';}
else if(residuo == 'ENVASES'){color = '#f7d84e';}
else if(residuo == 'PAPEL'){color = '#09227b';}
else if(residuo == 'VIDRIO'){color = '#048e14';}
else if(residuo == 'ORGANICA'){color = '#8e3f2e';}

var datos= [
    {mes:'Ene', r:pesos[0] },
    {mes:'Feb', r:pesos[1] },
    {mes:'Mar', r:pesos[2] },
    {mes:'Abr', r:pesos[3] },
    {mes:'May', r:pesos[4] },
    {mes:'Jun', r:pesos[5] },
    {mes:'Jul', r:pesos[6] },
    {mes:'Ago', r:pesos[7] },
    {mes:'Sep', r:pesos[8] },
    {mes:'Oct', r:pesos[9] },
    {mes:'Nov', r:pesos[10]},
    {mes:'Dic', r:pesos[11]}

];

var config = {
    element: 'grafico',
    data: datos,
    xkey: 'mes',
    parseTime: false,
    ykeys: ['r'],
    labels: ['Peso'],
    barColors: [color],
    pointSize: 3,
    hideHover: 'auto',
    resize: true
};

    
Morris.Bar(config);

//----------------------------------------------------------------------------------------//           
     
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