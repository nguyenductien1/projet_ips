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

    <form action="depose_annonce_process.php" method="post" enctype="multipart/form-data">
        <label >Titre de l'annonce</label>
        <input type="text" class="form-control" placeholder="Veuillez écrire titre de l'annonce" name="depose_titre"></input>

        <label >Categories</label>
        <select name="depose_categories" id="categories">
            <option></option>
            <option>decoration</option>
            <option>automobile</option>
            <option>cuisine</option>
            <option>informatique</option>
            <option>telephonie</option>
        </select>
        <div>
            <label >Prix</label>
            <input type="number" class="form-control" placeholder="Prix en Euros" name="depose_prix"></input>
        </div>

        <div>
            <label >Description</label>
            <input type="text-box" class="form-control" placeholder="Description" name="depose_description"></input>
        </div>

        <div>
            <label >Location</label>
            <input type="text" class="form-control" placeholder="Choiser le ville" name="depose_location"></input>
        </div>
        <div id="upload_photo">
            <input type="file"  name="fileToUpload" id="fileToUpload" onchange="readURL(this);">
            <!--<label onclick="document.getElementById('fileToUpload').click()">Choisir votre photo</label>-->
            <img id="depose_image" src="#" alt="your image" /> 
        </div>

        <input type="submit" value="Deposer">
    </form>
    <script src="image_process.js"></script>
</body>

</html>