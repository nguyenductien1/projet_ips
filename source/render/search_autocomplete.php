<?php
//Connexion à fichiers pour récupérer des informations d'utilisateur
include('../server/get.php');
include('../server/config.php');

use source\server\SQLiteConnection;

$connect_class = new SQLiteConnection();

//Déclaration de font
header('Content-Type: text/html; charset=UTF-8');

//query the database for entries containing the term 
$ville = $_GET['mot_cle'];

$requet_sql = "SELECT ville_nom_reel FROM villes_france WHERE ville_nom LIKE '$ville%' LIMIT 10";

$result = $connect_class->recherche_ville_autocomplete($requet_sql);

$result_villes = [];
foreach ($result as $r) {
 array_push($result_villes, $r["ville_nom_reel"]);
}
//format the array into json data 
//echo $_GET['mot_cle'];
//echo json_encode($result_villes); 

$output = '<ul class="list-unstyled">';		

  		if (count($result_villes) > 0) {
  			foreach ($result_villes as $ville_selected) {
  				$output .= '<li>'.$ville_selected.'</li>';
  			}
  		}else{
  			  $output .= '<li> City not Found</li>';
  		}
  		
          $output .= '</ul>';
          
echo $output;


?>