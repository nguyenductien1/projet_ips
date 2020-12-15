<?php
session_start();
if (!isset($_SESSION['username']) && !$_SESSION['username']) {
    echo '<meta http-equiv="refresh" content="0;URL=../login/login.php" />';
    die();
}
?>

<?php

//Connexion à fichiers pour récupérer des informations d'utilisateur
function get_annonce_by_user($requet_sql){
    $pdo_3 = new PDO('sqlite:'. dirname(__FILE__, 3).('\ProjetIPS\data_base\bdd.db'));
    $stm = $pdo_3->query($requet_sql);
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $row;
}

//Déclaration de font
header('Content-Type: text/html; charset=UTF-8');

//query the database for entries containing the term 
$user = $_SESSION['username'];
$nombre_per_page = 5;
$page = $_GET['page'];
settype($page, "int");
$from = ($page - 1) * $nombre_per_page;

$requet_sql = "SELECT * FROM annonces WHERE pseudo='$user' ORDER BY date DESC LIMIT '$from', '$nombre_per_page'";

$result = get_annonce_by_user($requet_sql);

foreach ($result as $r) {
    if ($r['titre'] != "") {
        echo '<div>';
        echo '<a href="../source/render/annonce_details.php?id=' . $r['id'] . '">' . '<h3 class="titre_annonce">', $r['titre'], '</h3>' . '</a>';
        echo '<button id=' . $r['id'] . ' class="supprimer" onclick="process_supprimer_annonces(this.id)">', 'Supprimer', '</button>';
        echo '</div>';
    } else {
        echo '<div>';
        echo '<a href="../source/render/annonce_details.php?id=' . $r['id'] . '">' . '<h3 class="titre_annonce">', 'Non titre', '</h3>' . '</a>';
        echo '<button id=' . $r['id'] . ' class="supprimer" onclick="process_supprimer_annonces(this.id)">', 'Supprimer', '</button>';
        echo '</div>';
    }
}



?>
