<?php

$annonce_id =$_GET['annonce_id'];
// connexion à la base de données SQL
$pdo = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . "/ProjetIPS/data_base/bdd.db");
// requête d'insertion de données; l'identifiant est automatique si on ne le fournit pas
$requeteSQL = "DELETE FROM annonces WHERE id='$annonce_id'";
// exécution de la requête
$pdo->exec($requeteSQL);

echo "Annonce Supprimée";

?>