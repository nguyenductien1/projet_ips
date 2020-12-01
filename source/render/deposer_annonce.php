<?php
session_start();
if (!isset($_SESSION['username']) && !$_SESSION['username']) {
    echo '<meta http-equiv="refresh" content="0;URL=http://localhost/ProjetIPS/source/render/login.php" />';
    die();
}
?>
<html>

<head>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="jumbotron row">

            <div class="col-lg-2 col-md-4 col-sm-12">
                <img src="https://nhattao.com/styles/nhattao2019/logo.png" class="rounded" alt="Logo" width="100">
            </div>

            <div class="text-center col-lg-8 col-sm-12">
                <form action="http://localhost/ProjetIPS/source/render/recherche.php" method="post">
                    <label>Categories</label>
                    <select name="recherche_categories" id="categories">
                        <option></option>
                        <option>decoration</option>
                        <option>automobile</option>
                        <option>cuisine</option>
                        <option>informatique</option>
                        <option>telephonie</option>
                    </select>
                    <input type="text" name="recherche_mot_cle" placeholder="Que cherchez vous?">
                    <input type="text" id="recherche_autocomplete" name="recherche_ville" placeholder="Saisiez une ville ...">
                    <button type="submit">Rechercher</button>
                </form>
            </div>
            <?php
            if (isset($_SESSION['username']) && $_SESSION['username']) {
                echo '<a href=http://localhost/ProjetIPS/source/render/mon_compte.php>' . $_SESSION['username'] . '</a>' .
                    '<form action="http://localhost/ProjetIPS/source/render/logout.php" method="post">
                    <button type="submit">Déconnecter</button>
                     </form>';
            } else {
                echo '<div class="col-lg-2 col-sm-12">
                <form action="http://localhost/ProjetIPS/source/render/signup.php" method="get">
                    <button type="submit">Inscrire</button>
                </form>
                <form action="http://localhost/ProjetIPS/source/render/login.php" method="get">
                    <button type="submit">Se connecter</button>
                </form>
                </div>';
            }

            ?>

        </div>

    </div>



    <div class="container">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <form name="form_deposer" method="post" enctype="multipart/form-data">
                <label>Titre de l'annonce</label>
                <input type="text" class="form-control" placeholder="Veuillez écrire titre de l'annonce" name="depose_titre"></input>

                <label>Categories</label>
                <select name="depose_categories" id="categories">
                    <option></option>
                    <option>decoration</option>
                    <option>automobile</option>
                    <option>cuisine</option>
                    <option>informatique</option>
                    <option>telephonie</option>
                </select>
                <div>
                    <label>Prix</label>
                    <input type="number" class="form-control" placeholder="Prix en Euros" name="depose_prix"></input>
                </div>

                <div>
                    <label>Description</label>
                    <textarea class="form-control" placeholder="Description" name="depose_description"> </textarea>
                </div>

                <div>
                    <label>Location</label>
                    <input id="villes" type="text" class="form-control" placeholder="Choiser le ville" name="depose_location"></input>
                    <div id="liste_villes"></div>
                </div>
                <div id="upload_photo">
                    <input type="file" name="fileToUpload" id="fileToUpload" onchange="readURL(this);">
                    <!--<label onclick="document.getElementById('fileToUpload').click()">Choisir votre photo</label>-->
                    <img id="depose_image" src="#" alt="your image" />
                </div>

                <input type="submit" href='#' value="Deposer">
            </form>
        </div>
    </div>

    <script src="js/image_process.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('submit', 'form[name="form_deposer"]', function(e) {
                e.preventDefault();
                var form = $(this)[0];
                var formData = new FormData(form);
                $.ajax({
                    url: 'depose_annonce_process.php',
                    data: formData,
                    type: 'POST',
                    // THIS MUST BE DONE FOR FILE UPLOADING
                    contentType: false,
                    processData: false,
                    // ... Other options like success and etc
                    success: function(data) {
                        //Do stuff for ahed process....
                        console.log(data);
                        alert(data);
                    }
                });

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
        $("#villes").on("keyup", (function() {
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



    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="source/geocoder/reverse.js"></script>

</body>

</html>