<?php
namespace source\server;
use PDO;
class connect_to_post{
    
    function add_user($username, $fullname, $email,$password) {
        // connexion à la base de données SQL
        $pdo = new PDO('sqlite:'. dirname(__FILE__, 3).('\data_base\bdd.db'));
        // requête d'insertion de données; l'identifiant est automatique si on ne le fournit pas
        $requeteSQL = "INSERT INTO users (pseudo, nom, email, mdp_hash) VALUES($username, $fullname, $email,$password)";
        // exécution de la requête
        $stmt = $pdo->prepare($requeteSQL);
        // $stmt->debugDumpParams();
        $stmt->execute($requeteSQL);

        return "ok";
    }

}







?>