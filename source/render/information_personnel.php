<?php

session_start();
if (!isset($_SESSION['username']) && !$_SESSION['username']) {
    echo '<meta http-equiv="refresh" content="0;URL=http://localhost/ProjetIPS/source/render/login.php" />';
    die();
}

$pseudo_session = $_SESSION['username'];
// connexion à la base de données SQL
$connection = 'sqlite:' . dirname(__FILE__, 3) . ('\data_base\bdd.db');
$pdo = new PDO($connection);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$requet_pseudo_par_id_annonce = "SELECT * FROM users WHERE pseudo='$pseudo_session'";
// requête d'insertion de données; l'identifiant est automatique si on ne le fournit pas
$stm = $pdo->query($requet_pseudo_par_id_annonce);
$info_personnel = $stm->fetchAll(PDO::FETCH_BOTH);

echo 
    '<div>'.
    '<label for="edit_nom">Nom et Prénom</label>'.
     '<input type="text"  id="edit_nom" name="edit_nom" value='.'"'.$info_personnel[0]['nom'] .'"'. '></input>'.
     '</div>'.
     '<div>'.
     '<label for="edit_email">Email</label>'.
     '<input type="text" id="edit_email" name="edit_email" value='.'"'.$info_personnel[0]['email'].'"'.'></input>'.
     '</div>'.
     '<div>'.
     '<label for="edit_ville">Ville</label>'.
     '<input type="text" id="edit_ville" name="edit_ville" value='.'"'.$info_personnel[0]['ville'].'"'.' onkeyup="search_ville()"></input>'.
     '<div id=liste_villes></div>'.
     '</div>'.
     '<div>'.
     '<label for="edit_telephone">Telephone</label>'.
     '<input type="text" id="edit_telephone" name="edit_telephone" value='.'"'.$info_personnel[0]['telephone'].'"'.'></input>'.
     '</div>'.
     '<button id="update_infos" onclick="update_infos()">Mettre à jour</button>'.
     '<button id="Retourner" onclick="retourner()">Retourner</button>'
     ;

