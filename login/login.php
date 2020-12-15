<?php
//Déclarer pour utiliser session
session_start();

//Déclarer utf-8 
header('Content-Type: text/html; charset=UTF-8');
function check_database($variable_recherche){
    $pdo_3 = new PDO('sqlite:'. dirname(__FILE__, 3).('\ProjetIPS\data_base\bdd.db'));
    $requet_sql = "SELECT pseudo,mdp_hash FROM users WHERE pseudo='$variable_recherche'";
    $stm = $pdo_3->query($requet_sql);
    $row = $stm->fetch(PDO::FETCH_BOTH);
    return $row;
}

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
    if (!check_database($username)) {
        echo "Ce nom d'utilisateur n'existe pas. Veuillez vérifier à nouveau. <a href='javascript: history.go(-1)'>Retourner</a>";
        exit;
    }

    //Récupérez le mot de passe de la base de données
    $password_server = check_database($username)['mdp_hash'];

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
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="../source/render/CSS/login.css">
</head>

<body>
        <div class="login-box">
            <form class="form" action='login.php?do=login' method='POST'>
                <div class="form-group">
                    <label for="username" class="text-info"> Nom d'utilisateur :</label>
                    <input type='text' name='txtUsername' id="username" class="form-control" requried/>
                </div>
                <div class="form-group">
                    <label for="password" class="text-info"> Mots de passe :</label>
                    <input type='password' name='txtPassword'  id="password" class="form-control" requried/>
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type='submit' name="login" value='Se Connecter' />
                </div>

                <div class="register-link text-left">
                    <a href='../signup/signup.php' class="text-info" title='Se inscrire'>Se inscrire</a>
                </div>
            </form>
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