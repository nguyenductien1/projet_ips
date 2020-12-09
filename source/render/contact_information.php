<?php

$pseudo = $_GET['pseudo'];
// connexion à la base de données SQL
$connection = 'sqlite:' . dirname(__FILE__, 3) . ('\data_base\bdd.db');
$pdo = new PDO($connection);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$requeteSQL = "SELECT nom, telephone, email FROM users WHERE pseudo = '$pseudo'";
// exécution de la requête
$stm = $pdo->query($requeteSQL);
$row = $stm->fetchAll(PDO::FETCH_ASSOC);
echo '<div id="contact_nom">'.$row[0]['nom'].'</div>'.
    '<div id="contact_telephone">'.'Téléphone: 0'.$row[0]['telephone'].'</div>'.
    '<div id="contact_email">'.'Email: '.$row[0]['email'].'</div>';
