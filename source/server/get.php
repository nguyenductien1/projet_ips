<?php

namespace source\server;
use PDO;

class SQLiteConnection {
    function get_derniers_annonces() {
        // connexion à la base de données SQL 
        $pdo = new PDO('sqlite:'. Config::PATH_TO_SQLITE_FILE);
        // requête de sélection 
        $requeteSQL = "SELECT * FROM(
                        SELECT * FROM annonces ORDER BY date DESC LIMIT 4)dernierannonce
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
        $requet_sql = "SELECT pseudo FROM users WHERE pseudo='$variable_recherche'";
        $stm = $pdo_3->query($requet_sql);
        $row = $stm->fetch(PDO::FETCH_BOTH);
        return $row;
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