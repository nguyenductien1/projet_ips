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
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script src="JS/jQuery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
    <div id="gauche" class="">
        <h3>Les élements à gauche</h3>
        <div class="container-fluid" id="list_annonces">
            <div id="annonces"> </div>  
        </div>

        <div class="container-fluid">
            <button id="plus">Afficher plus</button>
        </div>

    </div>
    <!--- div droite -->
    <div id="droite" class="">
        <h3>Les élements à droite</h3>
        <div id="mon_profil">
            <
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
                $.get("supprimer_annonces_process.php", {annonce_id:click_id}, function(data) {
                    
                    $('#'+click_id).parent().remove();
                        
                })
            }
            return false;

        }
    </script>

</body>

<footer>
</footer>

</html>