<!DOCTYPE html>
<html>

<head>
    <title>Inscription pour les petites annonces</title>
    <link rel="stylesheet" href="CSS/signup.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>

<body>

    <div class="container">
        <h2>Inscription pour les petites annonces</h2>
        <form class="form" action="process_signup.php" method="POST">
            <div  class="form-group">
                <label for="txtUsername">Nom d'utilisateur :</label>
                <input type="text" name="txtUsername" class="form-control" requried/>
            </div>
            <div class="form-group">
                <label for="txtPassword">Mots de passe :</label>
                <input type="password" name="txtPassword" class="form-control" requried/>
            </div>
            <div class="form-group">
                <label for="txtEmail">Email :</label>
                <input type="text" name="txtEmail" class="form-control" requried/>
            </div>
            <div class="form-group">
                <label for="txtFullname"> Nom et prénom :</label>
                <input type="text" name="txtFullname" class="form-control" requried/>
            </div>
            <div class="form-group">
                <label for="txtBirthday">Date de Naissance :</label>
                <input type="text" name="txtBirthday" class="form-control" requried/>
            </div>
            <div class="form-group">
                <label for="txtSex">Sexe :</label>
                <select name="txtSex" class="form-control">
                    <option value=""></option>
                    <option value="Nam">Male</option>
                    <option value="Nu">Female</option>
                </select>
            </div>

            <input type="submit" class="btn btn-primary" value="S'incrire" />
            <input type="reset" class="btn btn-default" value="Effacer" />
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="source/geocoder/reverse.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</body>
<footer>
    Duc Tien NGUYEN - 2020
</footer>

</html>