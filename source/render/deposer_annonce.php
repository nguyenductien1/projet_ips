<?php
session_start();
if (!isset($_SESSION['username']) && !$_SESSION['username']) {
    echo '<meta http-equiv="refresh" content="0;URL=http://localhost/ProjetIPS/login/login.php" />';
    die();
}
?>
<html>

<head>
    <title>Déposer nouvelle annonce</title>
    <script src="http://localhost/ProjetIPS/libraries/jquery.min.js"></script>
    <script src="http://localhost/ProjetIPS/libraries/jquery-ui.min.js"></script>
    <script src="http://localhost/ProjetIPS/libraries/bootstrap-3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://localhost/ProjetIPS/libraries/bootstrap-3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="CSS/deposer_annonce.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    
</head>

<body>
<nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="col-xs-3 col-sm-6 col-md-2 col-lg-1">
                <div class="navbar-header">
                    <a href="http://localhost/ProjetIPS/"> <img src="http://localhost/ProjetIPS/data_base/photos/annoces.jpg" class="rounded" alt="Logo"> </a>
                </div>
            </div>

            <div class="col-xs-9 col-sm-6 col-md-10 col-lg-11">
                <ul class="nav navbar-nav navbar-right content-right">
                    <?php
                    if (isset($_SESSION['username']) && $_SESSION['username']) {
                        echo
                            '<li class="guess"><form action="http://localhost/ProjetIPS/source/render/deposer_annonce.php" method="get">
                            <button type="submit" class="btn btn-primary">Déposer</button></form></li>',
                            '<li class="user-login"><span><a class="glyphicon glyphicon-user" href=http://localhost/ProjetIPS/mon_compte/mon_compte.php>' . $_SESSION['username'] . '</a></span></li>',
                            '<li><form action="http://localhost/ProjetIPS/login/logout.php" method="post">
                                        <span><button type="submit" class="btn btn-primary">Déconnecter</button></span>
                                </form></li>';
                    } else {
                        echo
                            '<li class="signin"><form action="http://localhost/ProjetIPS/source/render/deposer_annonce.php" method="get">
                                <button type="submit" class="btn btn-primary">Déposer</button></form></li>',
                            '<li><form action="http://localhost/ProjetIPS/signup/signup.php" method="get">
                                <button type="submit" class="btn btn-primary">Inscrire</button></form></li>',
                            '<li><form action="http://localhost/ProjetIPS/login/login.php" method="get">
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



    <div class="container">
        <div class="main-content">
            <form name="form_deposer" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label >Titre de l'annonce</label>
                    <input type="text" id="depose_titre" class="form-control" placeholder="Veuillez écrire titre de l'annonce" name="depose_titre"></input>
                </div>
                <div class="form-group">
                    <label>Categories</label>
                    <select id="depose_categories" name="depose_categories" id="categories" requried>
                        <option></option>
                        <option>decoration</option>
                        <option>automobile</option>
                        <option>cuisine</option>
                        <option>informatique</option>
                        <option>telephonie</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Prix</label>
                    <input id="depose_prix" type="number" class="form-control" placeholder="Prix en Euros" name="depose_prix" requried></input>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" placeholder="Description" name="depose_description" requried> </textarea>
                </div>

                <div class="form-group">
                    <label>Location</label>
                    <input id="n_villes" type="text" class="form-control" placeholder="Choiser le ville" name="depose_location" requried></input>
                    <div id="n_liste_villes"></div>
                </div>
                <div id="upload_photo">
                    <input type="file" name="fileToUpload" id="fileToUpload" onchange="readURL(this);">
                    <img id="depose_image" src="#" alt="votre photo" />
                </div>

                <input type="submit" class="btn btn-primary" href='#' value="Deposer">
            </form>
        </div>
    </div>
    <div id="deposer_success"></div>

    <script src="js/image_process.js"></script>
    <script src="js/deposer.js"></script>

    

</body>

</html>