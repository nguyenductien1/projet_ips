<?php
session_start();
if (!isset($_SESSION['username']) && !$_SESSION['username']) {
    echo '<meta http-equiv="refresh" content="0;URL=../login/login.php" />';
    die();
}
?>

<!DOCTYPE html>
<html>

<head>
    <script src="http://localhost/ProjetIPS/libraries/jquery.min.js"></script>
    <script src="http://localhost/ProjetIPS/libraries/jquery-ui.min.js"></script>
    <script src="http://localhost/ProjetIPS/libraries/bootstrap-3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://localhost/ProjetIPS/libraries/bootstrap-3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../source/render/CSS/mon_compte.css">
    <link rel="stylesheet" type="text/css" href="../source/render/CSS/index.css">
    <title>PA: Bienvenue <?php echo $_SESSION['username'] ?> </title>

    <script>
        i = 1;
        jQuery(document).ready(function() {
            $.get("load_annonces_mon_compte.php", {
                page: i
            }, function(data) {
                $("#annonces").append(data);
            })
        })
    </script>
</head>

<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="col-xs-3 col-sm-6 col-md-2 col-lg-1">
            <div class="navbar-header">
                <a href="http://localhost/ProjetIPS/"> <img src="https://nhattao.com/styles/nhattao2019/logo.png" class="rounded" alt="Logo"> </a>
            </div>
        </div>

        <div class="col-xs-9 col-sm-6 col-md-4 col-lg-4">
            <ul class="nav navbar-nav navbar-right content-right">
                <?php
                if (isset($_SESSION['username']) && $_SESSION['username']) {
                    echo
                        '<li class="guess"><form action="../source/render/deposer_annonce.php" method="get">
                        <button type="submit" class="btn btn-primary">Déposer</button></form></li>',
                        '<li class="user-login"><span><a class="glyphicon glyphicon-user" href=../source/render/mon_compte.php>' . $_SESSION['username'] . '</a></span></li>',
                        '<li><form action="../login/logout.php" method="post">
                                    <span><button type="submit" class="btn btn-primary">Déconnecter</button></span>
                            </form></li>';
                } else {
                    echo
                        '<li class="signin"><form action="../source/render/deposer_annonce.php" method="get">
                            <button type="submit" class="btn btn-primary">Déposer</button></form></li>',
                        '<li><form action="../signup/signup.php" method="get">
                            <button type="submit" class="btn btn-primary">Inscrire</button></form></li>',
                        '<li><form action="../login/login.php" method="get">
                            <button type="submit" class="btn btn-primary">Se connecter</button>
                        </form></li>';
                }
                ?>
            </ul>
            <a href="javascript:void(0);" class="icon" id="menu-bar">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </div>
</nav>
    <!--- div gauche -->
        <div class="container">
            <div class="row">
                <div id="gauche" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 main-content">
                    <h3>Mes annonces</h3>
                    <div id="list_annonces">
                        <div id="annonces"> </div>
                    </div>

                    <div class="button-show-more">
                        <button id="plus" class="btn btn-success">Afficher plus</button>
                    </div>

                </div>
                <!--- div droite -->
                <div id="droite" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 main-content">
                    <h3>Mes informations</h3>
                    <div id="mon_profil"></div>
                    <button id="show_infomation_personnel" class="btn btn-success">Vos Infos</button>
                </div>
            </div>
        </div>


    <script src="../source/render/JS/mon_compte.js"></script>

</body>

<footer>
</footer>

</html>