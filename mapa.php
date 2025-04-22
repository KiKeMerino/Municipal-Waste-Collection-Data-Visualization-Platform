<?php
    // Configuracion de las tablas de las bases de datos
        $data = file_get_contents("database/data.json");
        $decoded_json = json_decode($data, true);
    
        // Tabla del inventario de contenedores con los campos utilizados
        $lista = $decoded_json["localizacion ecopuntos"];
        $eco_loc[0] = $lista[0]{"tabla"};
        $eco_loc[1] = $lista[1]{"id del ecopunto"};
        $eco_loc[2] = $lista[2]{"latitud"};
        $eco_loc[3] = $lista[3]{"longitud"};

        if(!isset($_GET["id"])){
            $_GET["id"] = 'X';
        }
    ?>

<script type="text/javascript" src="assets/OpenLayers.js"></script>
<script type="text/javascript" src="assets/js/Map.js"></script>
<script type="text/javascript" src="assets/js/LonLat.js"></script>
<link rel="stylesheet" href="assets/css/styles.css">

<script>

map = new OpenLayers.Map("mapdiv");
map.addLayer(new OpenLayers.Layer.OSM());
epsg4326 =  new OpenLayers.Projection("EPSG:4326"); 
projectTo = map.getProjectionObject();


<?php
  include("database/conexion.php");
  $latitudes = array();
  $longitudes = array();
  $ecos = array();
  
  $consulta = "SELECT `$eco_loc[2]`, `$eco_loc[3]`, `$eco_loc[1]` FROM `$eco_loc[0]` ORDER BY `$eco_loc[1]`";
  $lectura = mysqli_query($conecta, $consulta);
  while($lecturas = $lectura->fetch_array() ){
      $latitudes[] = $lecturas["$eco_loc[2]"];
      $longitudes[] = $lecturas["$eco_loc[3]"];
      $ecos[] = $lecturas["$eco_loc[1]"];
    }
    ?>

var lat = <?php echo json_encode($latitudes); ?>;
var lon = <?php echo json_encode($longitudes); ?>;
var cod = <?php echo json_encode($ecos); ?>;
var id_eco = <?php echo json_encode($_GET["id"]); ?>;

/*********************** Establecer el centro del mapa *************************/

    var longitud_centro = -3.60183;
    var latitud_centro = 37.179;
    var zoom = 13;

var lonLat = new OpenLayers.LonLat(longitud_centro,latitud_centro).transform(epsg4326,projectTo);// Latitud y Longitud normal            

map.setCenter (lonLat, zoom);

/*******************************************************************************/

var vectorLayer = new OpenLayers.Layer.Vector("Overlay");

//if(eco_seleccionado != 'X'){    //Si hay un ecopunt seleccionado...
    //}
    
for(var i = 0; i < lat.length;i++){
    latitud = lat[i];
    longitud = lon[i];
    codigo = "<a href=ecopunto.php?id=" + cod[i] + "> Detalles del Ecopunto </a>";
    
    // Define markers as "features" of the vector layer:
    var feature = new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.Point( longitud, latitud).transform(epsg4326, projectTo),
        {description:codigo} ,
        {externalGraphic: 'assets/img/marcador.png', graphicHeight: 25, graphicWidth: 21, graphicXOffset:-12, graphicYOffset:-25  }
    );
        vectorLayer.addFeatures(feature);
}

if(id_eco != 'X'){
var feature = new OpenLayers.Feature.Vector(
    new OpenLayers.Geometry.Point(lon[id_eco], lat[id_eco]).transform(epsg4326, projectTo),
    {description:"<a href=ecopunto.php?id=" + id_eco + "> Detalles del Ecopunto </a>"} ,
    {externalGraphic: 'assets/img/marcado.png', graphicHeight: 50, graphicWidth: 42, graphicXOffset:-12, graphicYOffset:-25  }
    );
    
    vectorLayer.addFeatures(feature);
}

map.addLayer(vectorLayer);
 
    
    //Add a selector control to the vectorLayer with popup functions
    var controls = {
      selector: new OpenLayers.Control.SelectFeature(vectorLayer, { onSelect: createPopup, onUnselect: destroyPopup })
    };

    function createPopup(feature) {
      feature.popup = new OpenLayers.Popup.FramedCloud("pop",
          feature.geometry.getBounds().getCenterLonLat(),
          null,
          '<div class="markerContent">'+feature.attributes.description+'</div>',
          null,
          true,
          function() { controls['selector'].unselectAll(); }
      );
      //feature.popup.closeOnMove = true;
      map.addPopup(feature.popup);
    }

    function destroyPopup(feature) {
      feature.popup.destroy();
      feature.popup = null;
    }
    
    map.addControl(controls['selector']);
    controls['selector'].activate();

</script>
