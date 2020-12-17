<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Petite Anonnce</title>
    <script src="http://localhost/ProjetIPS/libraries/jquery.min.js"></script>
    <script src="http://localhost/ProjetIPS/libraries/jquery-ui.min.js"></script>
    <script src="http://localhost/ProjetIPS/libraries/bootstrap-3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://localhost/ProjetIPS/libraries/bootstrap-3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="source/render/CSS/index.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">

</head>

<?php
include('../ProjetIPS/source/server/post.php');
include('../ProjetIPS/source/server/bdd.php');
include('../ProjetIPS/source/server/config.php');
include('../ProjetIPS/source/server/get.php');
include('../ProjetIPS/source/geocoder/reverse.php');

//Call SQLiteConnection Class from 
use source\server\SQLiteConnection;
use source\server\Geocoder;

function derniers_annonces()
{
    $connect_class = new SQLiteConnection();
    return $connect_class->get_derniers_annonces();
}


?>

<body>
    <?php
    $derniers_annonces = derniers_annonces();

    function get_municipality_by_coordinate($lat, $lon)
    {
        $geo_class = new Geocoder();
        $address = $geo_class->get_address_by_coordinates($lat, $lon);
        if ($address->country_code == "fr")
            return ($address->municipality);
        else
            return ($address->country);
    }

    ?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="col-xs-3 col-sm-6 col-md-2 col-lg-1">
                <div class="navbar-header">
                    <a href="http://localhost/ProjetIPS/"> <img src="../ProjetIPS/data_base/photos/annoces.jpg" class="rounded" alt="Logo"> </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-7 form-screen">
                <div class="navbar-form navbar-left">
                    <div class="form-group">
                        <select class="form-control" id="categories_s" placeholder="Search">
                            <option></option>
                            <option>decoration</option>
                            <option>automobile</option>
                            <option>cuisine</option>
                            <option>informatique</option>
                            <option>telephonie</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control"  id='titre_s' placeholder="Que cherchez vous?">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="villes_s"  placeholder="Saisiez une ville ...">
                        <div id="liste_villes"></div>
                    </div>
                    <span><button id='button_recherche_s' class="btn btn-default glyphicon-glyphicon-search">Rechercher</button></span>
                </div>
            </div>
            <div class="col-xs-9 col-sm-6 col-md-4 col-lg-4">
                <ul class="nav navbar-nav navbar-right content-left">
                    <?php
                    if (isset($_SESSION['username']) && $_SESSION['username']) {
                        echo
                            '<li class="guess"><form action="http://localhost/ProjetIPS/source/render/deposer_annonce.php" method="get">
                            <button type="submit" class="btn btn-primary">Déposer</button></form></li>',
                            '<li class="user-login"><span><a class="glyphicon glyphicon-user" href=http://localhost/ProjetIPS/mon_compte/mon_compte.php>' . $_SESSION['username'] . '</a></span></li>',
                            '<li><form action="http://localhost/ProjetIPS/login/logout.php" method="post">
                                        <span><button type="submit" class="btn btn-primary">Déconnecter</button></span>
                                </form></li>';
                    } else {
                        echo
                            '<li class="signin"><form action="http://localhost/ProjetIPS/source/render/deposer_annonce.php" method="get">
                                <button type="submit" class="btn btn-primary">Déposer</button></form></li>',
                            '<li><form action="http://localhost/ProjetIPS/signup/signup.php" method="get">
                                <button type="submit" class="btn btn-primary">Inscrire</button></form></li>',
                            '<li><form action="http://localhost/ProjetIPS/login/login.php" method="get">
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
                <div class="navbar-form navbar-left">
                    <div class="form-group">
                        <select class="form-control" id="categories_m" placeholder="Search">
                            <option></option>
                            <option>decoration</option>
                            <option>automobile</option>
                            <option>cuisine</option>
                            <option>informatique</option>
                            <option>telephonie</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" id='titre_m' class="form-control" placeholder="Que cherchez vous?">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="villes_m"  placeholder="Saisiez une ville ...">
                        <div id="liste_villes_m"></div>
                    </div>
                    <button id='button_recherche_m' class="btn btn-default">Rechercher</button>
                </div>
            </div>
        </div>
    </nav>

    <div id='dernieres_annonces' class="container">
        <div class="row content-wrapper">
            <?php
            foreach ($derniers_annonces as &$annonce) {

                echo
                    '<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">',
                    '<div class="content">',
                    '<div class="margin-10">',
                    '<a href="source/render/annonce_details.php?id=' . $annonce['id'] . '">' . '<h3 class="titre_annonce">', $annonce['titre'], '</h3>' . '</a>',
                    '<h3>',$annonce['prix'],'€</h3>',
                    '<h5>',$annonce['date'].'</h5>',
                    '<div class="price_location margin-5">',
                    '<i class="fa fa-map-marker">','</i>' .
                    '<span>',
                        get_municipality_by_coordinate($annonce['rdv_lat'], $annonce['rdv_lon']),
                    '</span>
                    </div>',
                        '<p class="margin-5">',$annonce['categorie'],'</p>',
                        '<p class="margin-5">',$annonce['description'],'</p>',
                    '</div>',
                    '<div class="photo">','<img src=',$annonce['photo'],'>',
                    '</div>',
                    '</div>',
                    '</div>';
            }
            ?>
        </div>
    </div>
    <div class="container" id='resultat_recherche' >
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12 text-center">
                <h4 class="text-muted">Résultat de recherche</h4> 
                <div id="recherche_index"></div>
                </div>
            </div>
        <div class="row text-center">
            <button type="button" id="afficher_plus" class="btn btn-primary">Voir plus</button>
        </div>
        
    </div>
    

    <script src="../ProjetIPS/source/render/JS/index.js"></script>

</body>
<footer>
<div class="footer">
  <p>Duc Tien NGUYEN - 2020</p>
</div>
</footer>

</html>