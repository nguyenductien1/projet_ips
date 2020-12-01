<?php
//Déclarer pour utiliser session
session_start();

//Déclarer utf-8 
header('Content-Type: text/html; charset=UTF-8');
include('../server/get.php');
include('../server/config.php');

//Connecter à la base de données
use source\server\SQLiteConnection;

$connect_class = new SQLiteConnection();

//Procedure pour se connecter
if (isset($_POST['login'])) {

    //Input
    $username = addslashes($_POST['txtUsername']);
    $password = addslashes($_POST['txtPassword']);

    //Vérifier l'id
    if (!$username || !$password) {
        echo "Veuillez saisir votre nom d'utilisateur et votre mot de passe complets. <a href='javascript: history.go(-1)'>Retourner</a>";
        exit;
    }

    // Encrypt pasword
    $password = md5($password);

    //Vérifier si le nom d'utilisateur existe  
    if (!$connect_class->check_database($username)) {
        echo "Ce nom d'utilisateur n'existe pas. Veuillez vérifier à nouveau. <a href='javascript: history.go(-1)'>Retourner</a>";
        exit;
    }

    //Récupérez le mot de passe de la base de données
    $password_server = $connect_class->check_database($username)['mdp_hash'];

    //Comparez les 2 mots de passe qui correspondent ou pas
    if ($password != $password_server) {
        echo "Mot de passe incorrect. Veuillez entrer à nouveau. <a href='javascript: history.go(-1)'>Retourner</a>";
        exit;
    }

    //Enregistrer le nom d'utilisateur
    $_SESSION['username'] = $username;
    echo "Bonjour " . $username . ". Connexion réussie. <a href='/'>Retournez à la page d'acceuil</a>";
    echo '<meta http-equiv="refresh" content="0;URL=http://localhost/ProjetIPS/index.php" />';
    die();
}

?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="CSS/login.css">
</head>

<body>
    <div class="h-100 row align-items-center">
        <div class="container">
            <form action='login.php?do=login' method='POST'>
                <div class="row col-lg-6">
                    <label> Nom d'utilisateur :</label>
                    <input type='text' name='txtUsername' />
                </div>
                <div class="row col-lg-6">
                    <label> Mots de passe :</label>
                    <input type='password' name='txtPassword' />
                </div>
                <div class="row col-lg-6">
                    <input type='submit' name="login" value='Se Connecter' />
                    <a href='signup.php' title='Se inscrire'>Se inscrire</a>
                </div>
            </form>
        </div>

    </div>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="source/geocoder/reverse.js"></script>
</body>
<footer>
    Duc Tien NGUYEN - 2020
</footer>

</html>