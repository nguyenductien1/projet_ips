<?php

session_start();
if (!isset($_SESSION['username']) && !$_SESSION['username']) {
    echo '<meta http-equiv="refresh" content="0;URL=http://localhost/ProjetIPS/source/render/login.php" />';
    die();
}

$nom = $_GET['edit_nom'];
$telephone = $_GET['edit_telephone'];
$email = $_GET['edit_email'];
$ville= $_GET['edit_ville'];

$pseudo = $_SESSION['username'];
// connexion à la base de données SQL
$connection = 'sqlite:' . dirname(__FILE__, 3) . ('\ProjetIPS\data_base\bdd.db');
$pdo = new PDO($connection);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$requeteSQL = "UPDATE users SET nom='$nom', email='$email', telephone='$telephone', ville='$ville' WHERE pseudo='$pseudo'";
// exécution de la requête
$pdo->exec($requeteSQL);
echo "Vos informations sont à jour";
