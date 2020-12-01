<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Petite Anonnce</title>
    <link rel="stylesheet" type="text/css" href="source/render/css_index.css">

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
            return ("Not In France: " + $address->country);
    }

    ?>
    <div class="container-fluid">
        <div class="jumbotron row">

            <div class="col-lg-2 col-md-4 col-sm-12">
                <img src="https://nhattao.com/styles/nhattao2019/logo.png" class="rounded" alt="Logo" width="100">
            </div>

            <div class="text-center col-lg-8 col-sm-12">
                <form action="http://localhost/ProjetIPS/source/render/recherche.php" method="post">
                    <label>Categories</label>
                    <select name="recherche_categories" id="categories">
                        <option></option>
                        <option>decoration</option>
                        <option>automobile</option>
                        <option>cuisine</option>
                        <option>informatique</option>
                        <option>telephonie</option>
                    </select>
                    <input type="text" name="recherche_mot_cle" placeholder="Que cherchez vous?">
                    <input type="text" id="recherche_autocomplete" name="recherche_ville" placeholder="Saisiez une ville ...">
                    <button type="submit">Rechercher</button>
                </form>
            </div>
            <?php
            if (isset($_SESSION['username']) && $_SESSION['username']) {
                echo '<a href=http://localhost/ProjetIPS/source/render/mon_compte.php>' . $_SESSION['username'] . '</a>' .
                    '<form action="http://localhost/ProjetIPS/source/render/logout.php" method="post">
                    <button type="submit">Déconnecter</button>
                     </form>';
            } else {
                echo '<div class="col-lg-2 col-sm-12">
                <form action="http://localhost/ProjetIPS/source/render/signup.php" method="get">
                    <button type="submit">Inscrire</button>
                </form>
                <form action="http://localhost/ProjetIPS/source/render/login.php" method="get">
                    <button type="submit">Se connecter</button>
                </form>
                </div>';
            }

            ?>

        </div>
        <div class="row">
            <form action="http://localhost/ProjetIPS/source/render/deposer_annonce.php" method="get">
                <button type="submit">Déposer un annonnece</button>
            </form>
        </div>

    </div>

    <div class="container">
        <div class="row">
            <?php
            foreach ($derniers_annonces as &$annonce) {

                echo '<div class="col-lg-6 col-md-6 col-sm-12">',
                    '<a href="source/render/annonce_details.php?id=' . $annonce['id'] . '">' . '<h3 class="titre_annonce">',
                    $annonce['titre'],
                    '</h3>' . '</a>',
                    '<div class="price_location">',
                    '<h3>',
                    $annonce['prix'],
                    '€</h3>',
                    '<img src="data_base/photos/position.jpg";  width="20" height="20">
                        <p>',
                    get_municipality_by_coordinate($annonce['rdv_lat'], $annonce['rdv_lon']),
                    '</p>
                    </div>',
                    '<p>',
                    $annonce['categorie'],
                    '</p>',
                    '<p>',
                    $annonce['description'],
                    '</p>',
                    '<img src=',
                    $annonce['photo'],
                    ' width="200">
                </div>';
            }
            ?>
        </div>
    </div>

    <script type="text/javascript">
        a1 = $("#recherche_autocomplete").autocomplete({
            serviceUrl: 'search_autocomplete.php', //tell the script where to send requests 
            width: 448, //set width 

            //callback just to show it's working 
            onSelect: function(value, data) {
                alert('You selected: ' + value + ', ' + data);
            }
        });
    </script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="source/geocoder/reverse.js"></script>
</body>
<footer>
    Duc Tien NGUYEN - 2020
</footer>

</html>