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
        return ("Not In France: "+ $address->country);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container-fluid">
        <div class="jumbotron row">

            <div class="col-lg-2 col-md-4 col-sm-12">
               <a href="http://localhost/ProjetIPS/"> <img src="https://nhattao.com/styles/nhattao2019/logo.png"  class="rounded" alt="Logo" width="100"> </a>
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
                    <input type="text" name="recherche_ville" placeholder="Saisiez une ville,...">
                    <button type="submit">Rechercher</button>
                </form>
            </div>
            <?php 
            if (isset($_SESSION['username']) && $_SESSION['username']){
                echo '<a href=mon_compte.php>'.$_SESSION['username'].'</a>'.
                    '<form action="http://localhost/ProjetIPS/source/render/logout.php" method="post">
                    <button type="submit">Déconnecter</button>
                     </form>';

            }
            else{
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

    </div>
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
        <div class="row">
            <?php
            foreach ($results as &$result) {
                if ($ville == get_municipality_by_coordinate($result['rdv_lat'], $result['rdv_lon']) || strlen($ville)==0){
                    echo '<div class="col-lg-6 col-md-6 col-sm-12">',
                    '<a href="annonce_details.php?id=' . $result['id'] . '">' . '<h3 class="titre_annonce">',
                    $result['titre'],
                    '</h3>' . '</a>',
                    '<div class="price_location">',
                    '<h3>',
                    $result['prix'],
                    '€</h3>',
                    '<img src="http://localhost/ProjetIPS/data_base/photos/position.jpg";  width="20" height="20">
                    <p>',
                    get_municipality_by_coordinate($result['rdv_lat'], $result['rdv_lon']),
                    '</p>
                </div>',
                    '<p>',
                    $result['categorie'],
                    '</p>',
                    '<p>',
                    $result['description'],
                    '</p>',
                    '<img src=','http://localhost/ProjetIPS/',
                    $result['photo'],
                    ' width="200">
            </div>';
            }
            else{echo '<p>No results</p>';}

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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="source/geocoder/reverse.js"></script>    
</body>

</html>