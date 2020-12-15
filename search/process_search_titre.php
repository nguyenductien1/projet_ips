<?php
//Connexion à fichiers pour récupérer des informations d'utilisateur
include('../server/get.php');
include('../server/config.php');

use source\server\SQLiteConnection;

$connect_class = new SQLiteConnection();

//Déclaration de font
header('Content-Type: text/html; charset=UTF-8');

//query the database for entries containing the term 
$titre = $_GET['titre'];

$requet_sql = "SELECT titre FROM annonces WHERE titre LIKE '$titre%' LIMIT 5";

$result = $connect_class->recherche_ville_autocomplete($requet_sql);

$result_titre = [];
foreach ($result as $r) {
 array_push($result_titre, $r["titre"]);
}


$output = '<ul class="list-unstyled">';		

  		if (count($result_titre) > 0) {
  			foreach ($result_titre as $titre_selected) {
  				$output .= '<li>'.$titre_selected.'</li>';
  			}
  		}else{
  			  $output .= '<li> No product found</li>';
  		}
  		
          $output .= '</ul>';
          
echo $output;


?>