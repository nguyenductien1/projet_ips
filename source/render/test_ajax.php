<!DOCTYPE html>
<html>

<head>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
</head>

<body>
    <form name="form_deposer" enctype="multipart/form-data">
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
            <input type="number" id="depose_prix" class="form-control" placeholder="Prix en Euros" name="depose_prix"></input>
        </div>

        <div>
            <label>Description</label>
            <input type="text-box" class="form-control" placeholder="Description" name="depose_description"></input>
        </div>

        <div>
            <label>Location</label>
            <input type="text"></input>
            <input id="villes" type="text" class="form-control" placeholder="Choiser le ville" name="depose_location"><br>
            <div id="liste_villes"></div>
        </div>
        <div id="upload_photo">
            <input type="file" name="fileToUpload" id="fileToUpload" onchange="readURL(this);">
            <!--<label onclick="document.getElementById('fileToUpload').click()">Choisir votre photo</label>-->
            <img id="depose_image" src="#" alt="your image" />
        </div>

        <input id="deposer_button" type="submit" href="#" value="Deposer">

    </form>

    <script src="image_process.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('submit', 'form[name="form_deposer"]', function(e) {
                e.preventDefault();
                var form = $(this)[0];
                var formData = new FormData(form);
                $.ajax({
                    url: 'test_ajax_process.php',
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

</body>

</html>