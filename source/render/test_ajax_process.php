<?php
session_start();

//Connexion à fichiers pour récupérer des informations d'utilisateur
include('../server/get.php');
include('../server/config.php');

use source\server\SQLiteConnection;

$connect_class   = new SQLiteConnection();
$depose_location = addslashes($_POST['depose_location']);
$ville_position  = $connect_class->get_position_ville($depose_location);
$depose_lat = $ville_position[1];
$depose_lon = $ville_position[0];

//var_dump($depose_location);
//var_dump($_POST);
$depose_titre        = addslashes($_POST['depose_titre']);
$depose_categories   = addslashes($_POST['depose_categories']);
$depose_description  = addslashes($_POST['depose_description']);
$depose_prix         = addslashes($_POST['depose_prix']);
$depose_lat = $ville_position[1];
$depose_lon = $ville_position[0];
$date = date("Y-m-d h:m:s");


//Creer un aléatoire nom pour l'image
function makeRandomString($max = 15)
{
    $i = 0; //Reset the counter.
    $possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $keys_length = strlen($possible_keys);
    $str = ""; //Let's declare the string, to add later.
    while ($i < $max) {
        $rand = mt_rand(1, $keys_length - 1);
        $str .= $possible_keys[$rand];
        $i++;
    }
    return $str;
}
if (!empty($_FILES) && isset($_FILES['fileToUpload'])){

    $target = $_SERVER['DOCUMENT_ROOT'] . "/ProjetIPS/data_base/photos/annonces/";

    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
    
    $_FILES['fileToUpload']['name'] = makeRandomString() . '.' . end($temp);

    $target = $target . basename($_FILES['fileToUpload']['name']);

    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target)) {
        $status = "The file " . basename($_FILES['fileToUpload']['name']) . " has been uploaded";
        $imageFileType = pathinfo($target, PATHINFO_EXTENSION);
        $check = getimagesize($target);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".<br>";
            $uploadOk = 1;
        } else {
            echo "File is not an image.<br>";
            $uploadOk = 0;
        }
    } else {
        $status = "Sorry, there was a problem uploading your file.";
    }
    
    
    if(Strlen(end($temp))!=0){
        $depose_photo = 'data_base/photos/annonces/'. $_FILES['fileToUpload']['name'];
    }
    else{$depose_photo = 'data_base/photos/annonces/no_photo.jpg';}

}

   
if (deposer_annonce($depose_titre, $depose_categories, $depose_description, $depose_prix, $depose_photo, $depose_lat, $depose_lon, $date)=="ok"){
    echo  "Votre annonce a été déposé. <a href='http://localhost/ProjetIPS/source/render/mon_compte.php'>Retournez à votre page personel </a>";
   echo '<meta http-equiv="refresh" content="10;URL=http://localhost/ProjetIPS/source/render/mon_compte.php" />';
}

function deposer_annonce($depose_titre, $depose_categories, $depose_description, $depose_prix, $depose_photo, $rdv_lat, $rdv_lon, $date){
    $depose_pseudo=$_SESSION['username'];
    // connexion à la base de données SQL
    $pdo = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . "/ProjetIPS/data_base/bdd.db");
    // requête d'insertion de données; l'identifiant est automatique si on ne le fournit pas
    $requeteSQL = "INSERT INTO annonces (titre, description, categorie , pseudo, prix, photo, rdv_lat, rdv_lon, date) 
                  VALUES('$depose_titre', '$depose_description', '$depose_categories', '$depose_pseudo', '$depose_prix', '$depose_photo', '$rdv_lat', '$rdv_lon', '$date');";
    // exécution de la requête
    $pdo->exec($requeteSQL);
  
    return "ok";

}