<?php session_start(); ?>
<?php
// Il ne fait rien si ce n'est pas une evènement de recherche
if (!isset($_POST['recherche_categories']) && !isset($_POST['recherche_mot_cle']) && !isset($_POST['recherche_ville'])) {
    die('');
}
//Connexion à fichiers pour récupérer des informations d'utilisateur
include('../server/get.php');
include('../server/config.php');

use source\server\SQLiteConnection;
use source\server\Geocoder;

$connect_class = new SQLiteConnection();

//Get ville by coordinate
function get_municipality_by_coordinate($lat, $lon){
    $geo_class = new Geocoder();
    $address = $geo_class->get_address_by_coordinates($lat, $lon);
    if ($address->country_code=="fr")
        return ($address->municipality);
    else
        return ($address->country);
        //echo $address->country;
}

//Déclaration de font
header('Content-Type: text/html; charset=UTF-8');

//Récupérer les données de index.php
$categories   = addslashes($_POST['recherche_categories']);
$mot_cle      = addslashes($_POST['recherche_mot_cle']);
$ville        = addslashes($_POST['recherche_ville']);

//Récupérer les données de bdd des annonces
if (strlen($categories) > 0 && strlen($mot_cle) > 0) {
    $recherche_results = $connect_class->recherche_annonce($categories, $mot_cle);
} elseif (strlen($categories) == 0 && strlen($mot_cle) > 0) {
    $recherche_results = $connect_class->recherche_annonce_sans_categorie($mot_cle);
} elseif (strlen($categories) > 0 && strlen($mot_cle) == 0) {
    $recherche_results = $connect_class->recherche_annonce_sans_titre($categories);
}
  elseif (strlen($categories) == 0 && strlen($mot_cle) == 0 && strlen($ville)==0) {
    $requet_sql_non = "SELECT * FROM annonces WHERE categorie LIKE '%$categories%' AND titre LIKE '%$mot_cle%'";
    $recherche_results = $connect_class->recherche_annonce_avec_limit($requet_sql_non);
}
elseif (strlen($categories) == 0 && strlen($mot_cle) == 0 && strlen($ville)!==0) {
    $requet_sql_non = "SELECT * FROM annonces WHERE categorie LIKE '%$categories%' AND titre LIKE '%$mot_cle%'";
    $recherche_results = $connect_class->recherche_annonce_avec_limit($requet_sql_non);
}


$total_records = 0;
foreach ($recherche_results as $result) {
    $total_records = $total_records + 1;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>PA - Recherche: <?php echo $categories .' '. $mot_cle ?></title>
    <meta charset="UTF-8">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="source/geocoder/reverse.js"></script> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="CSS/recherche.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>

<body>
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
                        echo '<li class="guess"><form action="http://localhost/ProjetIPS/source/render/deposer_annonce.php" method="get">
                            <button type="submit" class="btn btn-primary">Déposer</button></form></li>',
                            '<li class="user-login"><span><a class="glyphicon glyphicon-user" href=http://localhost/ProjetIPS/source/render/mon_compte.php>' . $_SESSION['username'] . '</a></span></li>' .
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
    <?php
    //Connect to Database

    // Rechercer LIMIT et CURRENT_PAGE
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 10;

    // Calculer TOTAL_PAGE et START
    // Total de pages
    $total_page = ceil($total_records / $limit);

    // Limiter current_page de 1 à total_page
    if ($current_page > $total_page) {
        $current_page = $total_page;
    } else if ($current_page < 1) {
        $current_page = 1;
    }

    // Rechercher Start
    $start = ($current_page - 1) * $limit;

    // Requêter pour récupérer les annonces
   
    $requet_sql = "SELECT * FROM annonces WHERE categorie LIKE '%$categories%' AND titre LIKE '%$mot_cle%' LIMIT $start, $limit";
    $results = $connect_class->recherche_annonce_avec_limit($requet_sql);

    ?>
    
    <!-- Afficher les annonces -->
    <div class="container">
        <div class="row content-wrapper">
            <?php
            foreach ($results as &$result) {
                if ($ville == get_municipality_by_coordinate($result['rdv_lat'], $result['rdv_lon']) || strlen($ville)==0){
                    echo 
                    '<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">',
                        '<div class="content">',
                            '<div class="margin-10">',
                                '<a href="annonce_details.php?id=' . $result['id'] . '">' . '<h3 class="titre_annonce">',$result['titre'],'</h3>' . '</a>',
                                '<h3>',$result['prix'],'€</h3>',
                            '<div class="price_location margin-5">',
                                '<i class="fa fa-map-marker">','</i>',
                                '<span',get_municipality_by_coordinate($result['rdv_lat'], $result['rdv_lon']),'</span>
                            </div>',
                                '<p class="margin-5">',$result['categorie'],'</p>',
                                '<p class="margin-5">',$result['description'],'</p>',
                            '</div>',
                            '<div class="photo">','<img src=','http://localhost/ProjetIPS/', $result['photo'],'>','</div>',
                        '</div>',
                    '</div>';
                    }

                }
                
            ?>
        </div>
    </div>

    <div class="pagination">
        <?php
        // Afficher le pagination
        // Si current_page > 1 et total_page > 1 on va afficher button  prev
        if ($current_page > 1 && $total_page > 1) {
            echo '<a href="http://localhost/ProjetIPS/source/render/recherche.php?page=' . ($current_page - 1) . '">Prev</a> | ';
        }

        // Boucle au milieu
        for ($i = 1; $i <= $total_page; $i++) {
            // Si cette page est la current page span
            // Si non afficher tag a
            if ($i == $current_page) {
                echo '<span>' . $i . '</span> | ';
            } else {
                echo '<a href="http://localhost/ProjetIPS/source/render/recherche.php?page=' . $i . '">' . $i . '</a> | ';
            }
        }

        // Si current_page < $total_page et total_page > 1 affichier next
        if ($current_page < $total_page && $total_page > 1) {
            echo '<a href="http://localhost/ProjetIPS/source/render/recherche.php?page=' . ($current_page + 1) . '">Next</a> | ';
        }
        ?>
    </div>
</body>

</html>