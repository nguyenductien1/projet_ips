<!DOCTYPE html>
<html>

<head>
    <title>Inscription pour les petites annonces</title>

</head>

<body>

    <div class="container">
        <h1>Inscription pour les petites annonces</h1>
        <form action="process_signup.php" method="POST">
            <div>
                <label for="txtUsername">Nom d'utilisateur :</label>
                <input type="text" name="txtUsername" size="50" />
            </div>
            <div>
                <label for="txtPassword">Mots de passe :</label>
                <input type="password" name="txtPassword" size="50" />
            </div>
            <div>
                <label for="txtEmail">Email :</label>
                <input type="text" name="txtEmail" size="50" />
            </div>
            <div>
                <label for="txtFullname"> Nom et prénom :</label>
                <input type="text" name="txtFullname" size="50" />
            </div>
            <div>
                <label for="txtBirthday">Date de Naissance :</label>
                <input type="text" name="txtBirthday" size="50" />
            </div>
            <div>
                <label for="txtSex">Sexe :</label>
                <select name="txtSex">
                    <option value=""></option>
                    <option value="Nam">Male</option>
                    <option value="Nu">Female</option>
                </select>
            </div>

            <input type="submit" value="S'incrire" />
            <input type="reset" value="Effacer" />
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