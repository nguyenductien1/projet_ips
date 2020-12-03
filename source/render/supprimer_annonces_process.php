<?php

session_start();
if (!isset($_SESSION['username']) && !$_SESSION['username']) {
    echo '<meta http-equiv="refresh" content="0;URL=http://localhost/ProjetIPS/source/render/login.php" />';
    die();
}

$pseudo = $_SESSION['username'];
$annonce_id =$_GET['annonce_id'];
// connexion à la base de données SQL
$connection = 'sqlite:' . dirname(__FILE__, 3) . ('\data_base\bdd.db');
$pdo = new PDO($connection);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$requet_pseudo_par_id_annonce = "SELECT pseudo FROM annonces WHERE id='$annonce_id'";
// requête d'insertion de données; l'identifiant est automatique si on ne le fournit pas
$stm = $pdo->query($requet_pseudo_par_id_annonce);
$id = $stm->fetchAll(PDO::FETCH_BOTH);

$pseudo_from_annonce = $id[0]['pseudo'];
if ($pseudo_from_annonce ==$pseudo){
    $requeteSQL = "DELETE FROM annonces WHERE id='$annonce_id'";
// exécution de la requête
    $pdo->exec($requeteSQL);
    echo "Annonce Supprimée";

}
else {echo '<meta http-equiv="refresh" content="0;URL=http://localhost/ProjetIPS/source/render/login.php" />';}
