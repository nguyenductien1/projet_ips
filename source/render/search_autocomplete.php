<?php
//Connexion à fichiers pour récupérer des informations d'utilisateur
include('../server/get.php');
include('../server/config.php');

use source\server\SQLiteConnection;

$connect_class = new SQLiteConnection();

//Déclaration de font
header('Content-Type: text/html; charset=UTF-8');

//query the database for entries containing the term 
$ville = trim(strip_tags($_GET['recherche_autocomplete']));

$requet_sql = "SELECT ville_nom_reel FROM villes_france WHERE ville_nom LIKE '%$ville%'";

$result = $connect_class->recherche_ville_autocomplete($requet_sql);

//array to return 
$reply = array(); 
$reply['query'] = $ville; 
$reply['suggestions'] = array(); 
$reply['data'] = array(); 

foreach ($results as $row) //loop through the retrieved values 
{ 
    //Add this row to the reply 
    $reply['suggestions'][]=htmlentities(stripslashes($row['value'])); 
    $reply['data'][]=(int)$row['id']; 
} 

//format the array into json data 
echo json_encode($reply); 

?>