<?php session_start(); ?>
<?php

//Get ville by coordinate
function get_address_by_coordinates($lat, $lon){
    // Create a stream
    $opts = array('http'=>array('header'=>"User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
    $context = stream_context_create($opts);
    $json_file = file_get_contents("https://nominatim.openstreetmap.org/reverse?format=json&lat={$lat}&lon={$lon}&zoom=18&addressdetails=1", false, $context);
    $obj = json_decode($json_file);
    $address= $obj->address;
    if ($address->country_code=="fr")
        return ($address->municipality);
    else
        return ($address->country);
}


$titre = $_GET['titre'];
$categorie = $_GET['categorie'];
$ville = $_GET['ville'];


//Connexion à fichiers pour récupérer des informations d'utilisateur
function get_annonce_by_user($requet_sql){
    $pdo_3 = new PDO('sqlite:'. dirname(__FILE__, 3).('\ProjetIPS\data_base\bdd.db'));
    $stm = $pdo_3->query($requet_sql);
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

//Déclaration de font
header('Content-Type: text/html; charset=UTF-8');

//query the database for entries containing the term 
$nombre_per_page = 5;
$page = $_GET['page'];
settype($page, "int");
$from = ($page - 1) * $nombre_per_page;

$requet_sql = "SELECT * FROM annonces WHERE titre LIKE '%$titre%' AND categorie LIKE '%$categorie%' ORDER BY date DESC LIMIT '$from', '$nombre_per_page'";

$result = get_annonce_by_user($requet_sql);

foreach ($result as $r) {
    if ($ville !='' && $ville==get_address_by_coordinates($r['rdv_lat'], $r['rdv_lon'])){

        if ($r['titre'] != "") {
            echo '<div class="col-12 col-sm-6 col-lg-4 search">'.
                    '<div class="search-element-content">'.
                        '<div class="search-content col-12 col-sm-8 col-lg-8">'.
                            '<a href="../ProjetIPS/source/render/annonce_details.php?id=' . $r['id'] . '">' . '<h3 class="titre_annonce">', $r['titre'], '</h3>' . '</a>'.
                            '<h4>'.$r['prix'].'€'.'</h4>'.
                            '<i class="fa fa-map-marker">','</i>' .
                            '<span>'.
                                get_address_by_coordinates($r['rdv_lat'], $r['rdv_lon']).
                            '</span>'.
                        '</div>'.
                        '<div class="image-parent col-12 col-sm-4 col-lg-4">
                            <img src='.$r['photo'].' class="img-fluid" alt="quixote">
                        </div>
                    </div>
            </div>';
        } else {
            echo '<div class="col-12 col-sm-6 col-lg-4 search">'.
                    '<div class="search-element-content">'.
                        '<div class="search-content col-12 col-sm-8 col-lg-8">'.
                            '<a href="../ProjetIPS/source/render/annonce_details.php?id=' . $r['id'] . '">' . '<h3 class="titre_annonce">', $r['titre'], '</h3>' . '</a>'.
                            '<h4>'.$r['prix'].'€'.'</h4>'.
                            '<i class="fa fa-map-marker">','</i>' .
                            '<span>'.
                                get_address_by_coordinates($r['rdv_lat'], $r['rdv_lon']).
                            '</span>'.
                        '</div>'.
                        '<div class="image-parent col-12 col-sm-4 col-lg-4">
                                <img src='.$r['photo'].' class="img-fluid" alt="quixote">
                        </div>
                    </div>
                </div>';
        }

    }
    else if ($ville ==''){

        if ($r['titre'] != "") {
            echo '<div class="col-12 col-sm-6 col-lg-4 search">'.
                '<div class="search-element-content">'.
                '<div class="search-content col-12 col-sm-8 col-lg-8">'.
                '<a href="../ProjetIPS/source/render/annonce_details.php?id=' . $r['id'] . '">' . '<h3 class="titre_annonce">', $r['titre'], '</h3>' . '</a>'.
                '<h4>'.$r['prix'].'€'.'</h4>'.
                '<i class="fa fa-map-marker">','</i>' .
                '<span>'.
                    get_address_by_coordinates($r['rdv_lat'], $r['rdv_lon']).
                '</span>'.
                '</div>'.
              '<div class="image-parent col-12 col-sm-4 col-lg-4">
                  <img src='.$r['photo'].' class="img-fluid" alt="quixote">
              </div>
              </div>
            </div>';
        } else {
            echo '<div class="col-12 col-sm-6 col-lg-4 search">'.
                '<div class="search-element-content">'.
                '<div class="search-content col-12 col-sm-8 col-lg-8">'.
                '<a href="../ProjetIPS/source/render/annonce_details.php?id=' . $r['id'] . '">' . '<h3 class="titre_annonce">', $r['titre'], '</h3>' . '</a>'.
                '<h4>'.$r['prix'].'€'.'</h4>'.
                '<i class="fa fa-map-marker">','</i>' .
                '<span>'.
                    get_address_by_coordinates($r['rdv_lat'], $r['rdv_lon']).
                '</span>'.
                '</div>'.
              '<div class="image-parent col-12 col-sm-4 col-lg-4">
                    <img src='.$r['photo'].' class="img-fluid" alt="quixote">
              </div>
              </div>
            </div>';
        }

    }
    
}



