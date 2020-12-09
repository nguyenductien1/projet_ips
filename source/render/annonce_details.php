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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css_details.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">


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
            return ($address->country);
        //echo $address->country;
    }

    ?>

<nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="col-xs-3 col-sm-6 col-md-2 col-lg-1">
                <div class="navbar-header">
                    <a href="http://localhost/ProjetIPS/"> <img src="https://nhattao.com/styles/nhattao2019/logo.png" class="rounded" alt="Logo"> </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-7 form-screen">
                <form class="navbar-form navbar-left" action="http://localhost/ProjetIPS/source/render/recherche.php" method="post">
                    <div class="form-group">
                        <select class="form-control" name="recherche_categories" id="categories" placeholder="Search">
                            <option></option>
                            <option>decoration</option>
                            <option>automobile</option>
                            <option>cuisine</option>
                            <option>informatique</option>
                            <option>telephonie</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="recherche_mot_cle" placeholder="Que cherchez vous?">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="villes" name="recherche_ville" placeholder="Saisiez une ville ...">
                        <div id="liste_villes"></div>
                    </div>
                    <span><button type="submit" class="btn btn-default glyphicon-glyphicon-search">Rechercher</button></span>
                </form>
            </div>
            <div class="col-xs-9 col-sm-6 col-md-4 col-lg-4">
                <ul class="nav navbar-nav navbar-right content-left">
                    <?php
                    if (isset($_SESSION['username']) && $_SESSION['username']) {
                        echo
                            '<li class="guess"><form action="http://localhost/ProjetIPS/source/render/deposer_annonce.php" method="get">
                            <button type="submit" class="btn btn-primary">Déposer</button></form></li>',
                            '<li><span><a class="glyphicon glyphicon-user" href=http://localhost/ProjetIPS/source/render/mon_compte.php>' . $_SESSION['username'] . '</a></span></li>',
                            '<li><form action="http://localhost/ProjetIPS/source/render/logout.php" method="post">
                                        <span><button type="submit" class="btn btn-primary">Déconnecter</button></span>
                                </form></li>';
                    } else {
                        echo
                            '<li class="signin"><form action="http://localhost/ProjetIPS/source/render/deposer_annonce.php" method="get">
                                <button type="submit" class="btn btn-primary">Déposer</button></form></li>',
                            '<li><form action="http://localhost/ProjetIPS/source/render/signup.php" method="get">
                                <button type="submit" class="btn btn-primary">Inscrire</button></form></li>',
                            '<li><form action="http://localhost/ProjetIPS/source/render/login.php" method="get">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </form></li>';
                    }

                    ?>
                </ul>
                <a href="javascript:void(0);" class="icon" id="menu-bar">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-moblie">
                <form class="navbar-form navbar-left" action="http://localhost/ProjetIPS/source/render/recherche.php" method="post">
                    <div class="form-group">
                        <select class="form-control" name="recherche_categories" id="categories" placeholder="Search">
                            <option></option>
                            <option>decoration</option>
                            <option>automobile</option>
                            <option>cuisine</option>
                            <option>informatique</option>
                            <option>telephonie</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="recherche_mot_cle" placeholder="Que cherchez vous?">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="villes" name="recherche_ville" placeholder="Saisiez une ville ...">
                    </div>
                    <button type="submit" class="btn btn-default">Rechercher</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <img class="image-principal" src=<?php echo 'http://localhost/ProjetIPS/' . ($annonce_details[0]['photo']); ?>>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h3><?php echo ($annonce_details[0]['titre']); ?></h3>
                    <p><?php echo ($annonce_details[0]['description']); ?></p>
                    <div class="price_location">
                        <h3><?php echo ($annonce_details[0]['prix']) . "€"; ?></h3>

                        <div>
                            <span><i class="fa fa-map-marker"></i></span>
                            <span><?php echo get_municipality_by_coordinate($annonce_details[0]['rdv_lat'], $annonce_details[0]['rdv_lon']) ?></span>
                        </div>

                        <a><p><span><i>par </i></span><span id="contact_pseudo"><?php echo ($annonce_details[0]['pseudo']) ?></span></p></a>
                        <div id="contact_infos"> </div>
                        <button id="show_contact" class="btn btn-primary" style="display:block">Voir contact</button>
                        <button id="hide_contact" class="btn btn-success" style="display:none">Manquer contact</button>

                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="mapdiv"></div>
            </div>
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


<script type="text/javascript">
$('#show_contact').click(function(){
    var pseudo = $('#contact_pseudo')[0].innerText;
    $.get("contact_information.php",{pseudo:pseudo}, function(data){
        $('#contact_infos').append(data);
        $('#show_contact').hide();
        $('#hide_contact').css('display', 'block');
    })
})
$('#hide_contact').click(function(){
    $('#contact_infos').children().remove();
    $('#show_contact').show();
    $('#hide_contact').css('display', 'none');
})

$("#menu-bar").on("click", function() {
    if ($(".content-left").css('display') === "flex") {
        $(".content-left").css("display", "none");
    } else {
        $(".content-left").css("display", "flex");
    }
});
</script>

</body>
<footer>
    Duc Tien NGUYEN - 2020
</footer>

</html>