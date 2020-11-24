<!DOCTYPE html>
<html>
<?php

include('../server/get.php');
include('../server/config.php');

use source\server\SQLiteConnection;
use source\server\Geocoder;

$connect_class = new SQLiteConnection();
$annonce_details =  $connect_class->get_annonce_detail($_REQUEST["id"]);

?>

<head>
    <title>
        PA: <?php echo ($annonce_details[0]['titre']); ?>
    </title>
    <script src="http://www.openlayers.org/api/OpenLayers.js"></script>
    <link rel="stylesheet" type="text/css" href="css_details.css">

</head>

<body>
    <?php

    function get_municipality_by_coordinate($lat, $lon)
    {
        $geo_class = new Geocoder();
        $address = $geo_class->get_address_by_coordinates($lat, $lon);
        if ($address->country_code == "fr")
            return ($address->municipality);
        else
            return ("Not In France: " + $address->country);
    }

    ?>

    <div class="container-fluid">
        <div class="jumbotron row">

            <div class="col-lg-2 col-md-4 col-sm-12">
                <img src="https://nhattao.com/styles/nhattao2019/logo.png" class="rounded" alt="Logo" width="50">
            </div>

            <div class="text-center col-lg-8 col-sm-12">
                <form action="recherche_anonce" method="post">
                    <label>Categories</label>
                    <select name="hall" id="hall" value="3">
                        <option></option>
                        <option>decoration</option>
                        <option>automobile</option>
                        <option>cuisine</option>
                        <option>informatique</option>
                        <option>téléphone</option>
                    </select>
                    <input type="text" placeholder="Que cherchez vous?">
                    <input type="text" placeholder="Saisiez une ville,...">
                    <button type="submit">Rechercher</button>
                </form>
            </div>

            <div class="col-lg-2 col-sm-12">
                <form action="sigin" method="get">
                    <button type="submit">Se connecter</button>
                </form>
            </div>

        </div>

    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12">
                <img src=<?php echo 'http://localhost/ProjetIPS/' . ($annonce_details[0]['photo']); ?> width="500">
                <h3><?php echo ($annonce_details[0]['titre']); ?></h3>
                <div class="price_location">
                    <h3><?php echo ($annonce_details[0]['prix']) . "€"; ?></h3>
                    <img src="http://localhost/ProjetIPS/data_base/photos/position.jpg" ; width="20" height="20">
                    <p><?php echo get_municipality_by_coordinate($annonce_details[0]['rdv_lat'], $annonce_details[0]['rdv_lon']) ?></p>
                </div>
                <h3>Description:</h3>
                <p><?php echo ($annonce_details[0]['description']); ?></p>

            </div>
            <div class="col-lg-8 col-md-6 col-sm-12" id="mapdiv" style="width: 600px; height: 400px;"></div>
        </div>
    </div>


    <script src="http://www.openlayers.org/api/OpenLayers.js"></script>
    <?php
    echo '<script>
        map = new OpenLayers.Map("mapdiv");
        map.addLayer(new OpenLayers.Layer.OSM());
        var lonLat = new OpenLayers.LonLat(' . $annonce_details[0]['rdv_lon'] . ',' . ($annonce_details[0]['rdv_lat']) . ')
            .transform(
                new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
                map.getProjectionObject() // to Spherical Mercator Projection
            );
        var zoom = 16;
        var markers = new OpenLayers.Layer.Markers("Markers");
        map.addLayer(markers);
        markers.addMarker(new OpenLayers.Marker(lonLat));
        map.setCenter(lonLat, zoom);
    </script>'
    ?>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="source/geocoder/reverse.js"></script>
</body>
<footer>
    Duc Tien NGUYEN - 2020
</footer>

</html>