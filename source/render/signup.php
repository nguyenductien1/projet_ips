<!DOCTYPE html>
<html>

<head>
    <title>Inscription pour les petites annonces</title>

</head>

<body>
    <h1>Inscription pour les petites annonces</h1>
    <form action="process_signup.php" method="POST">
        <table cellpadding="0" cellspacing="0" border="1">
            <tr>
                <td>
                Nom d'utilisateur :
                </td>
                <td>
                    <input type="text" name="txtUsername" size="50" />
                </td>
            </tr>
            <tr>
                <td>
                    Mots de passe :
                </td>
                <td>
                    <input type="password" name="txtPassword" size="50" />
                </td>
            </tr>
            <tr>
                <td>
                    Email :
                </td>
                <td>
                    <input type="text" name="txtEmail" size="50" />
                </td>
            </tr>
            <tr>
                <td>
                    Nom et prénom :
                </td>
                <td>
                    <input type="text" name="txtFullname" size="50" />
                </td>
            </tr>
            <tr>
                <td>
                    Date de Naissance :
                </td>
                <td>
                    <input type="text" name="txtBirthday" size="50" />
                </td>
            </tr>
            <tr>
                <td>
                    Sexe :
                </td>
                <td>
                    <select name="txtSex">
                        <option value=""></option>
                        <option value="Nam">Male</option>
                        <option value="Nu">Female</option>
                    </select>
                </td>
            </tr>
        </table>
        <input type="submit" value="S'incrire" />
        <input type="reset" value="Effacer" />
    </form>
</body>
<footer>
    Duc Tien NGUYEN - 2020
</footer>

</html>