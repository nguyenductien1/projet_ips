<?php
// Il ne fait rien si ce n'est pas une evènement d'inscription
if (!isset($_POST['txtUsername'])) {
    die('');
}

//Connexion à fichiers pour récupérer des informations d'utilisateur
include('../server/get.php');
include('../server/config.php');

use source\server\SQLiteConnection;

$connect_class = new SQLiteConnection();

//Déclaration de font
header('Content-Type: text/html; charset=UTF-8');

//Récupérer les données de signup.php
$username   = addslashes($_POST['txtUsername']);
$password   = addslashes($_POST['txtPassword']);
$email      = addslashes($_POST['txtEmail']);
$fullname   = addslashes($_POST['txtFullname']);
$birthday   = addslashes($_POST['txtBirthday']);
$sex        = addslashes($_POST['txtSex']);
echo $username;

//Vérification que tous les information ont été écrivé
if (!$username || !$password || !$email || !$fullname || !$birthday || !$sex) {
    echo "Veuillez insérer complètement les information. <a href='javascript: history.go(-1)'>Retourner</a>";
    exit;
}

// Hash mots de pass
$password = md5($password);

//Vérification du nom d'utilisateur
if (!$connect_class->check_database($username)) {
    echo "pseudo ok";
} else {
    if (strlen($connect_class->check_database($username)['pseudo']) > 0) {
        echo "Cet identifiant existe déjà. Veuillez choisir un autre nom d'utilisateur. <a href='javascript: history.go(-1)'>Trở lại</a>";
        exit;
    }
}


//Vérifiez que l'e-mail est dans le bon format ou pas
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Cet e-mail n'est pas valide. Veuillez saisir un autre e-mail. <a href='javascript: history.go(-1)'>Retourner</a>";
    exit;
}

//Vérifiez que l'e-mail a été distributé à un utilisateur
if (!$connect_class->check_database($username)) {
    echo "email ok";
} else {
    if (strlen($connect_class->check_database($email)['email']) > 0) {
        echo "Cet e-mail a déjà un utilisateur. Veuillez choisir un autre e-mail. <a href='javascript: history.go(-1)'>Retourner</a>";
        exit;
    }
}

//Vérifier le formulaire de saisie de la date de naissance
list($dd, $mm, $yyyy) = explode('/', $birthday);
if (!checkdate($mm, $dd, $yyyy)) {
    echo "Date de naissance invalide. Veuillez saisir à nouveau. <a href='javascript: history.go(-1)'>Retourner</a>";
    exit;
}

// Enregistrer les informations de utilisateur dans le tableau
function add_user_2($username, $fullname, $email, $password)
{
    // connexion à la base de données SQL
    $pdo = new PDO('sqlite:' . dirname(__FILE__, 3) . ('\data_base\bdd.db'));
    // requête d'insertion de données; l'identifiant est automatique si on ne le fournit pas
    $requeteSQL = "INSERT INTO users (pseudo, nom, email, mdp_hash) VALUES(:pseudo, :nom, :email, :mdp_hash)";
    // exécution de la requête
    $stmt = $pdo->prepare($requeteSQL);
    // $stmt->debugDumpParams();
    $stmt->execute([
        ':pseudo' => $username,
        ':nom' => $fullname,
        ':email' => $email,
        ':mdp_hash' => $password,
    ]);

    return "ok";
}

$info_add_member = "";
if (add_user_2($username, $fullname, $email, $password) == "ok") {
    $info_add_member = "done";
}
echo $info_add_member;

//Annoncer la procedure d'inscription
if ($info_add_member == "done") {
    echo "Processus d'inscription réussi. <a href='http://localhost/ProjetIPS'>Retourner à la page principale</a>";
    echo '<meta http-equiv="refresh" content="0;URL=http://localhost/ProjetIPS" />';
} else {
    echo "Une erreur s'est produite lors de l'inscription. <a href='signup.php'>Veuillez re-essayer</a>";
}
