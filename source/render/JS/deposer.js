$(document).ready(function () {
  $(document).on("submit", 'form[name="form_deposer"]', function (e) {
    if (
      $("#depose_titre").val() != "" &&
      $("#depose_categories").val() != "" &&
      $("#depose_description").val() != "" &&
      $("#n_villes").val() != ""
    ) {
      e.preventDefault();
      var form = $(this)[0];
      var formData = new FormData(form);
      $.ajax({
        url: "process_depose_annonce.php",
        data: formData,
        type: "POST",
        contentType: false,
        processData: false,
        success: function (data) {
          $("#deposer_success").append(data);
        },
      });
    } else {
      alert("Veillez remplir les champs");
    }
  });
});

var mot_cle = $("#villes").val();
jQuery("#villes").on("keyup", function () {
  var mot_cle = $("#villes").val();
  if (mot_cle !== "") {
    $.get(
      "search_autocomplete.php",
      {
        mot_cle: mot_cle,
      },
      function (data) {
        $("#liste_villes").html(data);
        $("#liste_villes").fadeIn();
      }
    );
  } else {
    $("#liste_villes").html("");
    $("#liste_villes").fadeOut();
  }
});

$(document).on("click", "li", function () {
  $("#villes").val($(this).text());
  $("#liste_villes").fadeOut("fast");
});
var mot_cle = $("#n_villes").val();
jQuery("#n_villes").on("keyup", function () {
  var mot_cle = $("#n_villes").val();
  if (mot_cle !== "") {
    $.get(
      "http://localhost/ProjetIPS/search/process_search_ville.php",
      {
        mot_cle: mot_cle,
      },
      function (data) {
        $("#n_liste_villes").html(data);
        $("#n_liste_villes").fadeIn();
      }
    );
  } else {
    $("#n_liste_villes").html("");
    $("#n_liste_villes").fadeOut();
  }
});

$(document).on("click", "li", function () {
  $("#n_villes").val($(this).text());
  $("#n_liste_villes").fadeOut("fast");
});
