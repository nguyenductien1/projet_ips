<?php
session_start();
if (!isset($_SESSION['username']) && !$_SESSION['username']) {
    echo '<meta http-equiv="refresh" content="0;URL=http://localhost/ProjetIPS/source/render/login.php" />';
    die();
}
?>

<?php

//Connexion à fichiers pour récupérer des informations d'utilisateur
include('../server/get.php');
include('../server/config.php');

use source\server\SQLiteConnection;

$connect_class = new SQLiteConnection();

//Déclaration de font
header('Content-Type: text/html; charset=UTF-8');

//query the database for entries containing the term 
$user = $_SESSION['username'];
$nombre_per_page = 5;
$page = $_GET['page'];
settype($page, "int");
$from = ($page-1)*$nombre_per_page;

$requet_sql = "SELECT * FROM annonces WHERE pseudo='$user' ORDER BY date DESC LIMIT '$from', '$nombre_per_page'";

$result = $connect_class->get_annonce_by_user($requet_sql);

foreach ($result as $r) {
if($r['titre']!=""){
    echo '<div>';
    echo '<a href="annonce_details.php?id=' .$r['id'] . '">' . '<h3 class="titre_annonce">', $r['titre'], '</h3>' . '</a>';
    echo '<button id='. $r['id'] . ' class="supprimer" onclick="supprimer_annonces(this.id)">', 'Supprimer', '</button>';
    echo '</div>';
}
else{
    echo '<div>';
    echo '<a href="annonce_details.php?id=' .$r['id'] . '">' . '<h3 class="titre_annonce">', 'Non titre', '</h3>' . '</a>';
    echo '<button id='. $r['id'] . ' class="supprimer" onclick="supprimer_annonces(this.id)">', 'Supprimer', '</button>';
    echo '</div>';
}
}



?>
