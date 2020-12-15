<?php
//Connexion à fichiers pour récupérer des informations d'utilisateur
function recherche_ville_autocomplete($requet_sql){
	$pdo_3 = new PDO('sqlite:'. dirname(__FILE__, 3).('\ProjetIPS\data_base\bdd.db'));
	$stm = $pdo_3->query($requet_sql);
	$row = $stm->fetchAll(PDO::FETCH_ASSOC);
	return $row;
}

//Déclaration de font
header('Content-Type: text/html; charset=UTF-8');

//query the database for entries containing the term 
$ville = $_GET['mot_cle'];

$requet_sql = "SELECT ville_nom_reel FROM villes_france WHERE ville_nom LIKE '$ville%' LIMIT 5";

$result = recherche_ville_autocomplete($requet_sql);

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