<?php

namespace source\server;
use PDO;

class SQLiteConnection {
    function get_derniers_annonces() {
        // connexion à la base de données SQL 
        $pdo = new PDO('sqlite:'. Config::PATH_TO_SQLITE_FILE);
        // requête de sélection 
        $requeteSQL = "SELECT * FROM(
                        SELECT * FROM annonces ORDER BY date DESC LIMIT 8)dernierannonce
                        ORDER BY date DESC";
        // exécution de la requête
        $stm = $pdo->query($requeteSQL);
        // récupération des résultats
        $infos_annonces = $stm->fetchAll(PDO::FETCH_BOTH);
       
        return $infos_annonces;
    }

    function get_annonce_detail($id) {
        // connexion à la base de données SQL 
        $pdo_2 = new PDO('sqlite:'. dirname(__FILE__, 3).('\data_base\bdd.db'));
        // requête de sélection de l'annonce ayant l'identifiant $id (colonne "id")
        $requeteSQL = "SELECT * FROM annonces WHERE id=" .$id;
        // exécution de la requête
        $stm = $pdo_2->query($requeteSQL);
        // récupération des résultats
        $infos_annonce = $stm->fetchAll(PDO::FETCH_BOTH);
       
        return $infos_annonce;
    }

    function check_database($variable_recherche){
        $pdo_3 = new PDO('sqlite:'. dirname(__FILE__, 3).('\data_base\bdd.db'));
        $requet_sql = "SELECT pseudo,mdp_hash FROM users WHERE pseudo='$variable_recherche'";
        $stm = $pdo_3->query($requet_sql);
        $row = $stm->fetch(PDO::FETCH_BOTH);
        return $row;
    }

    function recherche_annonce($titre, $categorie){
        $pdo_3 = new PDO('sqlite:'. dirname(__FILE__, 3).('\data_base\bdd.db'));
        $requet_sql = "SELECT * FROM annonces WHERE titre LIKE '%$titre%' AND categorie = '$categorie'";
        $stm = $pdo_3->query($requet_sql);
        $row = $stm->fetchAll(PDO::FETCH_BOTH);
        return $row;
    }
    
    function recherche_annonce_sans_categorie($titre){
        $pdo_3 = new PDO('sqlite:'. dirname(__FILE__, 3).('\data_base\bdd.db'));
        $requet_sql = "SELECT * FROM annonces WHERE titre LIKE '%$titre%'";
        $stm = $pdo_3->query($requet_sql);
        $row = $stm->fetchAll(PDO::FETCH_BOTH);
        return $row;
    }
    function recherche_annonce_sans_titre($categorie){
        $pdo_3 = new PDO('sqlite:'. dirname(__FILE__, 3).('\data_base\bdd.db'));
        $requet_sql = "SELECT * FROM annonces WHERE categorie LIKE '%$categorie%'";
        $stm = $pdo_3->query($requet_sql);
        $row = $stm->fetchAll(PDO::FETCH_BOTH);
        return $row;
    }

    function recherche_annonce_avec_limit($requet_sql){
        $pdo_3 = new PDO('sqlite:'. dirname(__FILE__, 3).('\data_base\bdd.db'));
        $stm = $pdo_3->query($requet_sql);
        $row = $stm->fetchAll(PDO::FETCH_BOTH);
        return $row;
    }

    function get_position_ville($ville_nom){
        $pdo = new PDO('sqlite:'. dirname(__FILE__, 3).('\data_base\bdd.db'));
        $requet_sql = "SELECT ville_longitude_deg, ville_latitude_deg FROM villes_france WHERE ville_nom_reel = '$ville_nom'";
        $stm = $pdo->query($requet_sql);
        $row = $stm->fetch(PDO::FETCH_BOTH);
        return $row;
    }
    function recherche_ville_autocomplete($requet_sql){
        $pdo_3 = new PDO('sqlite:'. dirname(__FILE__, 3).('\data_base\bdd.db'));
        $stm = $pdo_3->query($requet_sql);
        $row = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    function get_annonce_by_user($requet_sql){
        $pdo_3 = new PDO('sqlite:'. dirname(__FILE__, 3).('\data_base\bdd.db'));
        $stm = $pdo_3->query($requet_sql);
        $row = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    function supprimer_annonce($requet_sql) {
        $pdo = new PDO('sqlite:'. dirname(__FILE__, 3).('\data_base\bdd.db'));
        $pdo->exec($requet_sql);
    }

}

class Geocoder{

    function get_address_by_coordinates($lat, $lon){
        // Create a stream
        $opts = array('http'=>array('header'=>"User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
        $context = stream_context_create($opts);
        $json_file = file_get_contents("https://nominatim.openstreetmap.org/reverse?format=json&lat={$lat}&lon={$lon}&zoom=18&addressdetails=1", false, $context);
        $obj = json_decode($json_file);
        return $obj->address;
    }

}



















?>