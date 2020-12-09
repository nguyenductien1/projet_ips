<?php
session_start();
if (!isset($_SESSION['username']) && !$_SESSION['username']) {
    echo '<meta http-equiv="refresh" content="0;URL=http://localhost/ProjetIPS/source/render/login.php" />';
    die();
}
?>

<!DOCTYPE html>
<html>

<head>
    <script src="JS/jQuery.js"></script>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="CSS/mon_compte.css">
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
    <!--- div gauche -->
        <div class="container">
            <div class="row">
                <div id="gauche" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 main-content">
                    <h3>Liste des produits</h3>
                    <div id="list_annonces">
                        <div id="annonces"> </div>
                    </div>

                    <div class="button-show-more">
                        <button id="plus" class="btn btn-primary">Afficher plus</button>
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


    <script>
        i = 1;
        $("#plus").click(function() {
            i = i + 1;
            $.get("load_annonces_mon_compte.php", {
                page: i
            }, function(data) {
                $('#annonces').append(data);
            })
        })

        function supprimer_annonces(click_id) {
            if (confirm("Vous êtes sure?")) {
                // your deletion code
                $.get("supprimer_annonces_process.php", {
                    annonce_id: click_id
                }, function(data) {

                    $('#' + click_id).parent().remove();

                })
            }
            return false;

        }

        jQuery('#show_infomation_personnel').click(function() {
            $('#mon_profil').children().remove();
            $(this).hide();
            $.get("information_personnel.php", {
                id: "ok"
            }, function(data) {
                console.log(data);
                $("#mon_profil").append(data);
            })
        })
    </script>
    <script type="text/javascript">
        function update_infos(){
           var nom = document.getElementById('edit_nom').value;
           var email = document.getElementById('edit_email').value;
           var ville = document.getElementById('edit_ville').value;
           var telephone = document.getElementById('edit_telephone').value;
           $.get("modifier_infos.php", {
                edit_nom: nom,
                edit_email: email,
                edit_ville: ville,
                edit_telephone: telephone
            }, function(data) {
                alert(data);
                
            })
        }
        function retourner(){
            $('#mon_profil').children().remove();
            jQuery('#show_infomation_personnel').show();

        }
    </script>

<script>
        function search_ville(){
            var mot_cle = document.getElementById('edit_ville').value;
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
        }

        $(document).on("click", "li", function() {
            $('#edit_ville').val($(this).text());
            $('#liste_villes').fadeOut("fast");
        });

        $("#menu-bar").on("click", function() {
            if ($(".content-left").css('display') === "flex") {
                $(".content-left").css("display", "none");
            } else {
                $(".content-left").css("display", "flex");
            }
        });
    </script>

</body>

<footer>
</footer>

</html>