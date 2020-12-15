var mot_cle = $("#villes_s").val();
$("#villes_s").on("keyup", function () {
  var mot_cle = $("#villes_s").val();
  if (mot_cle !== "") {
    $.get(
      "../ProjetIPS/search/process_search_ville.php",
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
  $("#villes_s").val($(this).text());
  $("#liste_villes").fadeOut("fast");
});

var mot_cle = $("#villes_m").val();
$("#villes_m").on("keyup", function () {
  var mot_cle = $("#villes_m").val();
  if (mot_cle !== "") {
    $.get(
      "../ProjetIPS/search/process_search_ville.php",
      {
        mot_cle: mot_cle,
      },
      function (data) {
        $("#liste_villes_m").html(data);
        $("#liste_villes_m").fadeIn();
      }
    );
  } else {
    $("#liste_villes_m").html("");
    $("#liste_villes_m").fadeOut();
  }
});

$(document).on("click", "li", function () {
  $("#villes_m").val($(this).text());
  $("#liste_villes_m").fadeOut("fast");
});

$("#menu-bar").on("click", function () {
  if ($(".content-left").css("display") === "flex") {
    $(".content-left").css("display", "none");
  } else {
    $(".content-left").css("display", "flex");
  }
});

var i = 1;
$("#button_recherche_s").on("click", function () {
  $('#resultat_recherche').children().show();
  $("#recherche_index").children().remove();
  $("#dernieres_annonces").hide();
  var titre = $("#titre_s").val();
  var ville = $("#villes_s").val();
  var categorie = $("#categories_s").val();
  $.get(
    "../ProjetIPS/search/recherche.php",
    { titre: titre, categorie: categorie, ville: ville, page: i },
    function (data) {
      $("#recherche_index").append(data);
    }
  );
});

$("#button_recherche_m").on("click", function () {
    $('#resultat_recherche').children().show();
    $("#recherche_index").children().remove();
    $("#dernieres_annonces").hide();
    var titre = $("#titre_m").val();
    var ville = $("#villes_m").val();
    var categorie = $("#categories_m").val();
    $.get(
      "../ProjetIPS/search/recherche.php",
      { titre: titre, categorie: categorie, ville: ville, page: i },
      function (data) {
        $("#recherche_index").append(data);
      }
    );
  });

$("#afficher_plus").on("click", function () {
  i += 1;
  if ($("#titre_s").val()!='' || $("#categories_s")!=0 || $("#villes_s").val()!=0){
    var titre = $("#titre_s").val();
    var ville = $("#villes_s").val();
    var categorie = $("#categories_s").val();
  }
  else if($("#titre_m").val()!='' || $("#categories_m")!=0 || $("#villes_m").val()!=0){
    var titre = $("#titre_m").val();
    var ville = $("#villes_m").val();
    var categorie = $("#categories_m").val();
  }
  
  $.get(
    "../ProjetIPS/search/recherche.php",
    { titre: titre, categorie: categorie, ville: ville, page: i },
    function (data) {
      $("#recherche_index").append(data);
    }
  );
});


$(document).ready(function() {
    $('#resultat_recherche').children().hide();
});

