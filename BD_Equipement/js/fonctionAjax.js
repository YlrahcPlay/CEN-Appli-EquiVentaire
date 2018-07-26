// Index
//
// line 21 - Diapo photo (popup panneau)
// line 50 - LightBox
// line 62 - Suppression image
// line 84, 111, 141, 167, 197, 226 - Fiches détaillées des équipements
// line 256 - Affiche ou masque un élément
// line 274 - Verification de la validité de la géométrie (A l'interieur d'un site ...)
// line 307 - Chargement des attributs
// line 349 - Cas du "panneau" de type "autre"
// line 359 - Cas d'ajout de fichier aux "panneaux"
// line 395 - Enregistrement des fichiers
// line 419 - Suppression des tables temporaire (si fermeture sans enregistrement)
// line 434 - Verification de la validité des attributs
// line 631 - Enregistrement des attributs
// line 747 - Suppression des attributs
// line 775, 787 - Affiche l'icône PDF, Génération du PDF


// Diapo photo, popup panneau
function photoPanneau(id_panneau) {
  $.ajax({
    url: "photoPanneau.php",
    method: "GET",
    data: {id_panneau:id_panneau},
    dataType: "html",
    async    : false,
    error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
    success  : function(data) {
      // Affichage dans la div spécifié le contenu retourné par le fichier
      $('#popPhotoPanneau').html(data);
      $('.diapo').ready(function() {
        $(".diaporama").jDiaporama({
          width:200,
          height:150,

          delay:3,
          animationSpeed: "slow",
          transition: "slide",

          infos:false
        });
      });
    }
  });
};


// LightBox
$('#lightbox').ready(
  function () {
    lightbox.option({
      'albumLabel':"Image %1 sur %2"
    });

    $("<div class=\"lb-supprContainer\"><a class=\"lb-suppr\"><img src=\"img/garbage.png\" onclick=\"supprImg()\"/></a></div>").appendTo('.lb-data');
    $('.lb-suppr').css({'display': "block", 'float': "right", 'text-align': "right", 'cursor': "pointer"});
    $('.lb-suppr>img').css({'width':"30px", 'height':"30px"})
});

// Suppressio, d'image
function supprImg() {
    suppr = confirm("Confirmez-vous la suppression de l'image ?") // Ouverture de la boite de confirmation

    if (suppr == true) {
      lien = $('.lb-image').attr('src');

      $.ajax({
        url : "supprImg.php", // Où envoyer la requête
        method : "POST", // Méthode à utiliser. (GET, POST, PUT)
        data : {lien:lien}, // Argument(s) à envoyer
        async : false, // true ou false
        error : function(request, error) { alert("Erreur : responseText: "+request.responseText);}, // Action en cas d'echec de la requête
        success : function(data) {alert("Suppression effectué");} // Action en cas de réussite de la requête
      });
    };
  };





// Fiche Détaillé
function fichePanneau(clef, type, precision, date_amgt, etat, commentaire) {
  $.ajax({
    url : "form/formPanneau.php", // Où envoyer la requête
    method : "GET", // Méthode à utiliser. (GET, POST, PUT)
    data : {type:type
          , precision:precision
          , date_amgt:date_amgt
          , etat:etat
          , commentaire:unescape(commentaire)
          , clefModif:clef}, // Argument(s) à envoyer
    dataType : "html", // Type de la réponse. (xml, json, script, html, jsonp, text)
    async : false, // true ou false
    error : function(request, error) { alert("Erreur : responseText: "+request.responseText);}, // Action en cas d'echec de la requête
    success : function(data) {
      // Afficher la div
      if($('#attributs').css('display') == 'none') {
        affiche_masque("#attributs");
      };

      // Insertion de la réponse
      $('#attributs').html(data);

    } // Action en cas de réussite de la requête
  });
};


function ficheSentier(clef, type_sent, type_chem, date_amgt, etat, pmr, difficulte, commentaire, longueur) {
  $.ajax({
    url : "form/formSentier.php", // Où envoyer la requête
    method : "GET", // (GET, POST, PUT)
    data : {type_sentier:type_sent
          , type_cheminement:type_chem
          , date_amgt:date_amgt
          , etat:etat
          , pmr:pmr
          , difficulte:difficulte
          , commentaire:unescape(commentaire)
          , clefModif:clef
          , longueur:longueur}, // Argument(s) à envoyer
    dataType : "html", // Type de la réponse. (xml, json, script, html, jsonp, text)
    async : false, // true ou false
    error : function(request, error) { alert("Erreur : responseText: "+request.responseText);}, // Action en cas d'echec de la requête
    success : function(data) {
      // Afficher la div
      if($('#attributs').css('display') == 'none') {
        affiche_masque("#attributs");
      };

      // Insertion de la réponse
      $('#attributs').html(data);

    }, // Action en cas de réussite de la requête
  });
};


function ficheAmgtComm(clef, type, date_amgt, etat, commentaire) {
$.ajax({
    url : "form/formAutreAmenagementCommunication.php", // Où envoyer la requête
    method : "GET", // (GET, POST, PUT)
    data : {type_amenagement:type
          , date_amgt:date_amgt
          , etat:etat
          , commentaire:unescape(commentaire)
          , clefModif:clef}, // Argument(s) à envoyer
    dataType : "html", // Type de la réponse. (xml, json, script, html, jsonp, text)
    async : false, // true ou false
    error : function(request, error) { alert("Erreur : responseText: "+request.responseText);}, // Action en cas d'echec de la requête
    success : function(data) {
      // Afficher la div
      if($('#attributs').css('display') == 'none') {
        affiche_masque("#attributs");
      };

      // Insertion de la réponse
      $('#attributs').html(data);

    }, // Action en cas de réussite de la requête
  });
};


function ficheCloture(clef, type_mobilite, type_fils, type_poteau, date_amgt, partiel, etat, commentaire, longueur) {
  $.ajax({
    url : "form/formCloture.php", // Où envoyer la requête
    method : "GET", // (GET, POST, PUT)
    data : {type_mobilite:type_mobilite
          , type_fils:type_fils
          , type_poteau:type_poteau
          , date_amgt:date_amgt
          , partiel:partiel
          , etat:etat
          , commentaire:unescape(commentaire)
          , clefModif:clef
          , longueur:longueur}, // Argument(s) à envoyer
    dataType : "html", // Type de la réponse. (xml, json, script, html, jsonp, text)
    async : false, // true ou false
    error : function(request, error) { alert("Erreur : responseText: "+request.responseText);}, // Action en cas d'echec de la requête
    success : function(data) {
      // Afficher la div
      if($('#attributs').css('display') == 'none') {
        affiche_masque("#attributs");
      };

      // Insertion de la réponse
      $('#attributs').html(data);

    }, // Action en cas de réussite de la requête
  });
};


function ficheBarriere(clef, type_mobilite, type_structure, dimension, date_amgt, cadenasPerm, etat, commentaire) {
  $.ajax({
    url : "form/formBarriere.php", // Où envoyer la requête
    method : "GET", // (GET, POST, PUT)
    data : {type_mobilite:type_mobilite
          , type_structure:type_structure
          , dimension:dimension
          , date_amgt:date_amgt
          , cadenasPerm:cadenasPerm
          , etat:etat
          , commentaire:unescape(commentaire)
          , clefModif:clef}, // Argument(s) à envoyer
    dataType : "html", // Type de la réponse. (xml, json, script, html, jsonp, text)
    async : false, // true ou false
    error : function(request, error) { alert("Erreur : responseText: "+request.responseText);}, // Action en cas d'echec de la requête
    success : function(data) {
      // Afficher la div
      if($('#attributs').css('display') == 'none') {
        affiche_masque("#attributs");
      };

      // Insertion de la réponse
      $('#attributs').html(data);

    }, // Action en cas de réussite de la requête
  });
};


function ficheAmgtZoot(clef, type, date_amgt, etat, commentaire) {
$.ajax({
    url : "form/formAutreAmenagementZootechnie.php", // Où envoyer la requête
    method : "GET", // (GET, POST, PUT)
    data : {type_amenagement:type
          , date_amgt:date_amgt
          , etat:etat
          , commentaire:unescape(commentaire)
          , clefModif:clef}, // Argument(s) à envoyer
    dataType : "html", // Type de la réponse. (xml, json, script, html, jsonp, text)
    async : false, // true ou false
    error : function(request, error) { alert("Erreur : responseText: "+request.responseText);}, // Action en cas d'echec de la requête
    success : function(data) {
      // Afficher la div
      if($('#attributs').css('display') == 'none') {
        affiche_masque("#attributs");
      };

      // Insertion de la réponse
      $('#attributs').html(data);

    }, // Action en cas de réussite de la requête
  });
};





// Affiche ou masque un élément
function affiche_masque(destination) {
  var valeur_visibility = $(destination).css('display'); // Récupération de la valeur "display"

  if (valeur_visibility != 'none'){
		$(destination).hide(); // Cacher
    if (destination == '#attributs') { // Si c'est la div attributs qui est cacher, y inserer le gif de chargement
      $('#attributs').html('<span class="loading"><h3 class="centre">Chargement</h3><img src="img/loading_orca.gif" /></span>')
    };
	}
  else{
		$(destination).show(); // Afficher
    if (destination == '#erreur') { // Si c'est la div erreur, y inserer du texte
      $("#erreur").html("Remplissez le(s) champs en rouge correctement")
    };
  };
};


function verifGeom(type, geom) {
  $.ajax({
    url      : "verifGeom.php",
    data     : {type:type
              , geom:geom},
    type     : "GET",
    dataType : "html",
    async    : true,
    error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
    success  : function(data) {
      // Afficher la div
      if($('#attributs').css('display') == 'none') {
        affiche_masque("#attributs");
      };

      // Insertion de la réponse
      $('#attributs').html(data);

      console.log($('.sqlAction').text());

      // Si pas d'erreur charger les attributs
      if ($('.sqlAction>p').text() == '') {
        load_attribut(type);
      }
      else {
        setTimeout("affiche_masque('#attributs')", 4000);
      };
    }
  });
};


// Charge le formulaire spécifique
function load_attribut(type) {
  // Ouverture de formulaire spécifique (selon le type)
  if(type == '1') {
    url = "form/formPanneau.php";
  }
  else if (type == '2') {
    url = "form/formSentier.php";
  }
  else if (type == '3') {
    url = "form/formAutreAmenagementCommunication.php";
  }
  else if (type == '4') {
    url = "form/formCloture.php";
  }
  else if (type == '5') {
    url = "form/formBarriere.php";
  }
  else if (type == '6') {
    url = "form/formAutreAmenagementZootechnie.php";
  };

  $.ajax({
    url : url, // Où envoyer la requête
    method : "GET", // (GET, POST, PUT)
    dataType : "html", // Type de la réponse. (xml, json, script, html, jsonp, text)
    async : false, // true ou false
    error : function(request, error) { alert("Erreur : responseText: "+request.responseText);}, // Action en cas d'echec de la requête
    success : function(data) {
      // Afficher la div
      if($('#attributs').css('display') == 'none') {
        affiche_masque("#attributs");
      };

      // Insertion de la réponse
      $('#attributs').html(data);

    }, // Action en cas de réussite de la requête
  });
};


// Affiche masque l'élément précision
function precision() {
  if ($('#type').val() == 5 && $('#precision').css('display') == 'none' ) { // Si il est sur catégorie Autre, mais qu'il est masqué
    affiche_masque('#precision');
  }
  else if ($('#type').val() != 5 && $('#precision').css('display') != 'none' ) { // Si il est sur une autre catégorie mais qu'il est affiché
    affiche_masque('#precision');
  };
};


function choixDoc(type) {
  if (type == 'pieceJointe') {
    $('#formContenu').hide();
    $('#formFlashCode').hide();
    $('#formPJSiteInternet').hide();

    valeur = $('#pieceJointe').val();
    if (valeur == 1) {
      affiche_masque("#formContenu");
    }
    else if (valeur == 2) {
      affiche_masque("#formFlashCode");
    }
    else if (valeur == 3) {
      affiche_masque("#formPJSiteInternet");
    };
  }
  else if (type == 'supportComm') {
    $('#formPlaquette').hide();
    $('#formSCSiteInternet').hide();
    $('#formApplication').hide();

    valeur = $('#supportComm').val();
    if (valeur == 1) {
      affiche_masque("#formPlaquette");
    }
    else if (valeur == 2) {
      affiche_masque("#formSCSiteInternet");
    }
    else if (valeur == 3) {
      affiche_masque("#formApplication");
    };
  };
};


function wait(origine, destination) {
	$(origine).ajaxForm({
		beforeSubmit: function(a,f,o) {
			$(destination).html('<img src="img/spinner.gif" />');
		},
		success: function(data) {
			$(destination).html(data);
      clearTimeout();
      setTimeout(function() {$(destination).html("");}, 5000);

      if (origine == '#formPJSiteInternet') {
        $('#PJSiteInternet').val("");
      };
      if (origine == '#formSCSiteInternet') {
        $('#SCSiteInternet').val("");
      };
      if (origine == '#formApplication') {
        $('#application').val("");
      };
		}
	});
};


// Supression de la table de liaison en cas de fermeture de la div attribut, sans enregistrement
function suppr_table_tmp(tableLiaison) {
  $.ajax({
    url      : "supprLiaison.php",
    data     : {tableLiaison:tableLiaison},
    type     : "POST",
    dataType : "html",
    async    : false,
    error    : function(request, error) {alert("Erreur : responseText: "+request.responseText);},
    success  :  function(data) {}
  });
};


// Valide le formulaire
function validation(url,destination,type, clefModif, tableLiaison) {
  // Panneau
  if(type == "panneau") {
    // Valeur par défaut
    if ($('#erreur').css('display') != 'none') {affiche_masque('#erreur')};
    $('#type').css({'background-color': '', 'color': '#000'});
    $('#precision>input').css({'background-color': '#FFF', 'color': '#000'});
    $('#date_amgt').css({'background-color': '', 'color': '#000'});
    $('#etat').css({'background-color': '', 'color': '#000'});

    // Mise en évidence des erreurs sinon enregistrement
    if ($('#type').val() == '' || ($('#type').val() == '5' && $('#precision>input').val() == '') || $('#date_amgt').val() == '' || $('#etat').val() == '') {
      affiche_masque('#erreur')
    }
    else {
      recAttributs(url,destination,type, clefModif, tableLiaison);
    };

    if ($('#type').val() == '' || $('#type').val() == '5') {
      if ($('#type').val() == '') {
        $('#type').css({'background-color': '#F00', 'color': '#FFF'});
      };
      if($('#type').val() == '5' && $('#precision>input').val() == '') {
        $('#precision>input').css({'background-color': '#F00', 'color': '#FFF'});
      };
    };
    if ($('#date_amgt').val() == '') {
      $('#date_amgt').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#etat').val() == '') {
      $('#etat').css({'background-color': '#F00', 'color': '#FFF'});
    };
  }

  // Sentier
  else if(type == "sentier") {
    // Valeur par défaut
    if ($('#erreur').css('display') != 'none') {affiche_masque('#erreur')};
    $('#type_sentier').css({'background-color': '', 'color': '#000'});
    $('#type_cheminement').css({'background-color': '', 'color': '#000'});
    $('#date_amgt').css({'background-color': '', 'color': '#000'});
    $('#etat').css({'background-color': '', 'color': '#000'});
    $('.pmr').css({'background-color': '', 'color': '#000'});
    $('#difficulte').css({'background-color': '', 'color': '#000'});

    // Mise en évidence des erreurs sinon enregistrement
    if ($('#type_sentier').val() == '' || $('#type_cheminement').val() == '' || $('#date_amgt').val() == '' || $('#etat').val() == '' || ($('#pmrOui:checked').val() != 'true' && $('#pmrNon:checked').val() != 'false') || $('#difficulte').val() == '') {
      affiche_masque('#erreur');
    }
    else {
      recAttributs(url,destination,type, clefModif, tableLiaison);
    };

    if ($('#type_sentier').val() == '') {
      $('#type_sentier').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#type_cheminement').val() == '') {
      $('#type_cheminement').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#date_amgt').val() == '') {
      $('#date_amgt').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#etat').val() == '') {
      $('#etat').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#pmrOui:checked').val() != 'true' && $('#pmrNon:checked').val() != 'false') {
      $('.pmr').css('background-color', '#F00');
      $('.pmr').css('color', '#FFF');
    };
    if ($('#difficulte').val() == '') {
      $('#difficulte').css({'background-color': '#F00', 'color': '#FFF'});
    };
  }

  // Autre Aménagement de Communication
  else if (type == "autreamgtcomm") {
    // Valeur par défaut
    if ($('#erreur').css('display') != 'none') {affiche_masque('#erreur')};
    $('#type_amenagement').css({'background-color': '', 'color': '#000'});
    $('#date_amgt').css({'background-color': '', 'color': '#000'});

    // Mise en évidence des erreurs sinon enregistrement
    if ($('#type_amenagement').val() == '' || $('#date_amgt').val() == '') {
      affiche_masque('#erreur');
    }
    else {
      recAttributs(url,destination,type, clefModif, "");
    };

    if ($('#type_amenagement').val() == '') {
      $('#type_amenagement').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#date_amgt').val() == '') {
      $('#date_amgt').css({'background-color': '#F00', 'color': '#FFF'});
    };
  }

  // Clôture
  else if (type == "cloture") {
    // Valeur par défaut
    if ($('#erreur').css('display') != 'none') {affiche_masque('#erreur')};
    $('#type_cloture').css({'background-color': '', 'color': '#000'});
    $('#type_fils').css({'background-color': '', 'color': '#000'});
    $('#type_poteau').css({'background-color': '', 'color': '#000'});
    $('#date_amgt').css({'background-color': '', 'color': '#000'});
    $('.partiel').css({'background-color': '', 'color': '#000'});
    $('#etat').css({'background-color': '', 'color': '#000'});

    // Mise en évidence des erreurs sinon enregistrement
    if ($('#type_cloture').val() == '' || $('#type_fils').val() == '' || $('#type_poteau').val() == '' || $('#date_amgt').val() == '' || ($('#partielOui:checked').val() != 'true' && $('#partielNon:checked').val() != 'false') || $('#etat').val() == '') {
      affiche_masque('#erreur');
    }
    else {
      recAttributs(url,destination,type, clefModif, "");
    };

    if ($('#type_cloture').val() == '') {
      $('#type_cloture').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#type_fils').val() == '') {
      $('#type_fils').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#type_poteau').val() == '') {
      $('#type_poteau').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#date_amgt').val() == '') {
      $('#date_amgt').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#partielOui:checked').val() != 'true' && $('#partielNon:checked').val() != 'false') {
      $('.partiel').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#etat').val() == '') {
      $('#etat').css({'background-color': '#F00', 'color': '#FFF'});
    };
  }

  // Barrière
  else if (type == "barriere") {
    // Valeur par défaut
    if ($('#erreur').css('display') != 'none') {affiche_masque('#erreur')};
    $('#type').css({'background-color': '', 'color': '#000'});
    $('#dimension').css({'background-color': '', 'color': '#000'});
    $('#date_amgt').css({'background-color': '', 'color': '#000'});
    $('.cadenasPerm').css({'background-color': '', 'color': '#000'});
    $('#etat').css({'background-color': '', 'color': '#000'});

    // Mise en évidence des erreurs sinon enregistrement
    if ($('#type').val() == '' || $('#dimension').val() == '' || $('#date_amgt').val() == '' || ($('#cadenasPermOui:checked').val() != 'true' && $('#cadenasPermNon:checked').val() != 'false') || $('#etat').val() == '') {
      affiche_masque('#erreur');
    }
    else {
      recAttributs(url,destination,type, clefModif, "");
    };

    if ($('#type').val() == '') {
      $('#type').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#dimension').val() == '') {
      $('#dimension').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#date_amgt').val() == '') {
      $('#date_amgt').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#cadenasPermOui:checked').val() != 'true' && $('#cadenasPermNon:checked').val() != 'false') {
      $('.cadenasPerm').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#etat').val() == '') {
      $('#etat').css({'background-color': '#F00', 'color': '#FFF'});
    };
  }

// Autre Aménagement de Zootechnie
  else if (type == "autreamgtzoot") {
    // Valeur par défaut
    if ($('#erreur').css('display') != 'none') {affiche_masque('#erreur')};
    $('#type_amenagement').css({'background-color': '', 'color': '#000'});
    $('#date_amgt').css({'background-color': '', 'color': '#000'});

    // Mise en évidence des erreurs sinon enregistrement
    if ($('#type_amenagement').val() == '' || $('#date_amgt').val() == '') {
      affiche_masque('#erreur');
    }
    else {
      recAttributs(url,destination,type, clefModif, "");
    };

    if ($('#type_amenagement').val() == '') {
      $('#type_amenagement').css({'background-color': '#F00', 'color': '#FFF'});
    };
    if ($('#date_amgt').val() == '') {
      $('#date_amgt').css({'background-color': '#F00', 'color': '#FFF'});
    };
  };
};


// Enregistre les information saisie
function recAttributs(url,destination,type, clefModif, tableLiaison) {
  // Transmission de l'information de façon spécifique (en fonction du type)
  if(type == "panneau") {
    data = {objet:type
          , type:$('#type').val()
          , precision:$('#precision>input').val()
          , date_amgt:$('#date_amgt').val()
          , etat:$('#etat').val()
          , commentaire:$('#commentaire').val()
          , geom:$('#json').text()
          , clefModif:clefModif
          , tableLiaison:tableLiaison};
  }
  else if(type == "sentier") {
    if ($('#pmrOui:checked').val() == 'true') {
      pmr = true;
    }
    else if ($('#pmrNon:checked').val() == 'false') {
      pmr = false;
    };

    data = {objet:type
          , type_sentier:$('#type_sentier').val()
          , type_cheminement:$('#type_cheminement').val()
          , date_amgt:$('#date_amgt').val()
          , etat:$('#etat').val()
          , pmr:pmr
          , difficulte:$('#difficulte').val()
          , commentaire:$('#commentaire').val()
          , geom:$('#json').text()
          , clefModif:clefModif
          , tableLiaison:tableLiaison} ;
  }
  else if (type == "autreamgtcomm") {
    data = {objet:type
          , type:$('#type_amenagement').val()
          , date_amgt:$('#date_amgt').val()
          , etat:$('#etat').val()
          , commentaire:$('#commentaire').val()
          , geom:$('#json').text()
          , clefModif:clefModif};
  }
  else if (type == "cloture") {
    if ($('#partielOui:checked').val() == 'true') {
      partiel = true;
    }
    else if ($('#partielNon:checked').val() == 'false') {
      partiel = false;
    };

    data = {objet:type
         , type_mobilite:$('#type_mobilite').val()
         , type_fils:$('#type_fils').val()
         , type_poteau:$('#type_poteau').val()
         , date_amgt:$('#date_amgt').val()
         , partiel:partiel
         , etat:$('#etat').val()
         , commentaire:$('#commentaire').val()
         , geom:$('#json').text()
         , clefModif:clefModif} ;
  }
  else if (type == "barriere") {
    if ($('#cadenasPermOui:checked').val() == 'true') {
      cadPerm = true;
    }
    else if ($('#cadenasPermNon:checked').val() == 'false') {
      cadPerm = false;
    };

    data = {objet:type
          , type_mobilite:$('#type_mobilite').val()
          , type_structure:$('#type_structure').val()
          , dimension:$('#dimension').val()
          , date_amgt:$('#date_amgt').val()
          , cadenasPerm:cadPerm
          , etat:$('#etat').val()
          , commentaire:$('#commentaire').val()
          , geom:$('#json').text()
          , clefModif:clefModif} ;
  }
  else if (type == "autreamgtzoot") {
    data = {objet:type
          , type:$('#type_amenagement').val()
          , date_amgt:$('#date_amgt').val()
          , etat:$('#etat').val()
          , commentaire:$('#commentaire').val()
          , geom:$('#json').text()
          , clefModif:clefModif};
  };

  // Envoie et récéption des informations
  $.ajax({
    url : url, // Où envoyer la requête
    method : "GET", // (GET, POST, PUT)
    data : data, // Argument(s) à envoyer
    dataType : "html", // Type de la réponse. (xml, json, script, html, jsonp, text)
    async : false, // true ou false
    error : function(request, error) { alert("Erreur : responseText: "+request.responseText);}, // Action en cas d'echec de la requête
    success : function(data) {
      // Afficher la div
      if($('#attributs').css('display') == 'none') {
        affiche_masque("#attributs");
      };

      // Insertion de la réponse
      $('#attributs').html(data);

    }, // Action en cas de réussite de la requête
  });

  // Après 2 seconde, Met à jour les catégories et Masque la div attributs
    setTimeout("majcategorie(); affiche_masque('#attributs');", 2000);
};


// Suppression
function supprAttibut(objet, id) {
  suppr = confirm("Confirmez-vous la suppression ?") // Ouverture de la boite de confirmation

  // Si c'est confirmé
  if (suppr == true) {
    $.ajax({
      url : "supprAttributs.php", // Où envoyer la requête
      method : "GET", // (GET, POST, PUT)
      data : {objet:objet
            , id:id}, // Argument(s) à envoyer
      dataType : "html", // Type de la réponse. (xml, json, script, html, jsonp, text)
      async : false, // true ou false
      error : function(request, error) { alert("Erreur : responseText: "+request.responseText);}, // Action en cas d'echec de la requête
      success : function(data) {
        // Afficher la div
        affiche_masque("#attributs");

        // Insertion de la réponse
        $('#attributs').html(data);

        // Après 3.5 seconde, Met à jour les catégories et Masque la div attributs
        setTimeout("majcategorie(); affiche_masque('#attributs');", 3500);

      }, // Action en cas de réussite de la requête
    });
  };
};

function affichePdf() {
  site = $('#site').val();

  if (site == 'tous' && $('#pdf').css('display') != 'none') {
    affiche_masque("#pdf");
  }
  else if (site != 'tous' && $('#pdf').css('display') == 'none') {
    affiche_masque("#pdf");
  };
};


function generePdf() {
  site = $('#site').val();
  url_ficheSite = 'ficheSite.php'+'?site='+site;
  window.open(url_ficheSite);
};
