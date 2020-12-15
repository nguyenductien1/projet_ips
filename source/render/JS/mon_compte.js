i = 1;
$("#plus").click(function () {
  i = i + 1;
  $.get(
    "load_annonces_mon_compte.php",
    {
      page: i,
    },
    function (data) {
      $("#annonces").append(data);
    }
  );
});

function process_supprimer_annonces(click_id) {
  if (confirm("Vous êtes sure?")) {
    // your deletion code
    $.get(
      "process_supprimer_annonces.php",
      {
        annonce_id: click_id,
      },
      function (data) {
        $("#" + click_id)
          .parent()
          .remove();
      }
    );
  }
  return false;
}

jQuery("#show_infomation_personnel").click(function () {
  $("#mon_profil").children().remove();
  $(this).hide();
  $.get(
    "information_personnel.php",
    {
      id: "ok",
    },
    function (data) {
      //console.log(data);
      $("#mon_profil").append(data);
    }
  );
});

function update_infos() {
  var nom = document.getElementById("edit_nom").value;
  var email = document.getElementById("edit_email").value;
  var ville = document.getElementById("edit_ville").value;
  var telephone = document.getElementById("edit_telephone").value;
  $.get(
    "process_modifier_infos.php",
    {
      edit_nom: nom,
      edit_email: email,
      edit_ville: ville,
      edit_telephone: telephone,
    },
    function (data) {
      alert(data);
    }
  );
}
function retourner() {
  $("#mon_profil").children().remove();
  jQuery("#show_infomation_personnel").show();
}

function search_ville() {
  var mot_cle = document.getElementById("villes1").value;
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
}

$(document).on("click", "li", function () {
  $("#villes1").val($(this).text());
  $("#liste_villes").fadeOut("fast");
});

$("#menu-bar").on("click", function () {
  if ($(".content-left").css("display") === "flex") {
    $(".content-left").css("display", "none");
  } else {
    $(".content-left").css("display", "flex");
  }
});
