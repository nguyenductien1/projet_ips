<?php
session_start();
if (!isset($_SESSION['username']) && !$_SESSION['username']) {
    echo '<meta http-equiv="refresh" content="0;URL=http://localhost/ProjetIPS/source/render/login.php" />';
    die();
}
?>
<html>

<head>
    <title>Déposer nouvelle annonce</title>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="CSS/deposer_annonce.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    
</head>

<body>
<nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="col-xs-3 col-sm-6 col-md-2 col-lg-1">
                <div class="navbar-header">
                    <a href="http://localhost/ProjetIPS/"> <img src="https://nhattao.com/styles/nhattao2019/logo.png" class="rounded" alt="Logo"> </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-7 form-screen">
                <form class="navbar-form navbar-left" action="http://localhost/ProjetIPS/source/render/recherche.php" method="post">
                    <div class="form-group">
                        <select class="form-control" name="recherche_categories" id="categories" placeholder="Search">
                            <option></option>
                            <option>decoration</option>
                            <option>automobile</option>
                            <option>cuisine</option>
                            <option>informatique</option>
                            <option>telephonie</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="recherche_mot_cle" placeholder="Que cherchez vous?">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="villes" name="recherche_ville" placeholder="Saisiez une ville ...">
                        <div id="liste_villes"></div>
                    </div>
                    <span><button type="submit" class="btn btn-default glyphicon-glyphicon-search">Rechercher</button></span>
                </form>
            </div>
            <div class="col-xs-9 col-sm-6 col-md-4 col-lg-4">
                <ul class="nav navbar-nav navbar-right content-left">
                    <?php
                    if (isset($_SESSION['username']) && $_SESSION['username']) {
                        echo
                            '<li class="guess"><form action="http://localhost/ProjetIPS/source/render/deposer_annonce.php" method="get">
                            <button type="submit" class="btn btn-primary">Déposer</button></form></li>',
                            '<li class="user-login"><span><a class="glyphicon glyphicon-user" href=http://localhost/ProjetIPS/source/render/mon_compte.php>' . $_SESSION['username'] . '</a></span></li>',
                            '<li><form action="http://localhost/ProjetIPS/source/render/logout.php" method="post">
                                        <span><button type="submit" class="btn btn-primary">Déconnecter</button></span>
                                </form></li>';
                    } else {
                        echo
                            '<li class="signin"><form action="http://localhost/ProjetIPS/source/render/deposer_annonce.php" method="get">
                                <button type="submit" class="btn btn-primary">Déposer</button></form></li>',
                            '<li><form action="http://localhost/ProjetIPS/source/render/signup.php" method="get">
                                <button type="submit" class="btn btn-primary">Inscrire</button></form></li>',
                            '<li><form action="http://localhost/ProjetIPS/source/render/login.php" method="get">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </form></li>';
                    }

                    ?>
                </ul>
                <a href="javascript:void(0);" class="icon" id="menu-bar">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-moblie">
                <form class="navbar-form navbar-left" action="http://localhost/ProjetIPS/source/render/recherche.php" method="post">
                    <div class="form-group">
                        <select class="form-control" name="recherche_categories" id="categories" placeholder="Search">
                            <option></option>
                            <option>decoration</option>
                            <option>automobile</option>
                            <option>cuisine</option>
                            <option>informatique</option>
                            <option>telephonie</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="recherche_mot_cle" placeholder="Que cherchez vous?">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="villes" name="recherche_ville" placeholder="Saisiez une ville ...">
                    </div>
                    <button type="submit" class="btn btn-default">Rechercher</button>
                </form>
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

    <script type="text/javascript">
        $(document).ready(function() {
                $(document).on('submit', 'form[name="form_deposer"]', function(e) {
                if ($('#depose_titre')!="" && $('#depose_categories')!="" && $('#depose_description')!=""){
                e.preventDefault();
                var form = $(this)[0];
                var formData = new FormData(form);
                $.ajax({
                    url: 'depose_annonce_process.php',
                    data: formData,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#deposer_success").append(data);
                        console.log(data);
                    }
                });}
                else{alert("Veillez remplir les champs")}

            });
            
        });
    </script>

    <style type="text/css">
        ul {
            margin-top: 0px;
            background: #fff;
            color: #000;
        }

        li {
            padding: 12px;
            cursor: pointer;
            color: black;
        }

        li:hover {
            background: #f0f0f0;
        }
    </style>

    <script>
        var mot_cle = $('#villes').val();
        jQuery("#villes").on("keyup", (function() {
                var mot_cle = $('#villes').val();
                if (mot_cle !== "") {
                    $.get('search_autocomplete.php', {
                        mot_cle: mot_cle
                    }, function(data) {
                        $("#liste_villes").html(data);
                        $("#liste_villes").fadeIn();
                    })

                } else {
                    $("#liste_villes").html("");
                    $("#liste_villes").fadeOut();
                }

            })
        );

        $(document).on("click", "li", function() {
            $('#villes').val($(this).text());
            $('#liste_villes').fadeOut("fast");
        });
    </script>
    <script>
        var mot_cle = $('#n_villes').val();
        jQuery("#n_villes").on("keyup", (function() {
                var mot_cle = $('#n_villes').val();
                if (mot_cle !== "") {
                    $.get('search_autocomplete.php', {
                        mot_cle: mot_cle
                    }, function(data) {
                        $("#n_liste_villes").html(data);
                        $("#n_liste_villes").fadeIn();
                    })

                } else {
                    $("#n_liste_villes").html("");
                    $("#n_liste_villes").fadeOut();
                }

            })
        );

        $(document).on("click", "li", function() {
            $('#n_villes').val($(this).text());
            $('#n_liste_villes').fadeOut("fast");
        });
    </script>


</body>

</html>