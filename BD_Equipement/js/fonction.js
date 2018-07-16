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





// Fiche Détaillé
function fichePanneau(clef, type, precision, date_amgt, etat, commentaire) {
  // Déclaration des variables
  var xhr_object = null;
  if(window.XMLHttpRequest) {xhr_object = new XMLHttpRequest()} // Pour que ça marche avec Firefox
  else if (window.ActiveXObject) {xhr_object = new ActiveXObject("Microsoft.XMLHTTP")}; //Pour que ça marche avec Internet Explorer

  // Préparation de l'url pour la récupération d'information
  url = "formulaire/formPanneau.php"
    + "?type=" + type
    + "&precision=" + precision
    + "&date_amgt=" + date_amgt
    + "&etat=" + etat
    + "&commentaire=" + commentaire
    + "&clefModif=" + clef
    ;

  // Afficher la div
  if($('#attributs').css('display') == 'none') {
    affiche_masque("#attributs");
  };

  // Envoie et récéption de la requête spécifique
  xhr_object.open("POST", url, true);

  xhr_object.onreadystatechange = function(){
    if ( xhr_object.readyState == 4 ){
      // Affichage dans la div spécifié le contenu retourné par le fichier
      document.getElementById("attributs").innerHTML = xhr_object.responseText;
    };
  };

  // Cas du get
  xhr_object.send(null);
};


function ficheSentier(clef, type_sent, type_chem, date_amgt, etat, pmr, difficulte, commentaire, longueur) {
  var xhr_object = null;
  if(window.XMLHttpRequest) {xhr_object = new XMLHttpRequest()} // Pour que ça marche avec Firefox
  else if (window.ActiveXObject) {xhr_object = new ActiveXObject("Microsoft.XMLHTTP")}; //Pour que ça marche avec Internet Explorer

  // Préparation de l'url
  url = "formulaire/formSentier.php"
    + "?type_sentier=" + type_sent
    + "&type_cheminement=" + type_chem
    + "&date_amgt=" + date_amgt
    + "&etat=" + etat
    + "&pmr=" + pmr
    + "&difficulte=" + difficulte
    + "&commentaire=" + commentaire
    + "&clefModif=" + clef
    + "&longueur=" + longueur
    ;

  // Afficher la div
  if($('#attributs').css('display') == 'none') {
    affiche_masque("#attributs");
  };

  // Envoie et récéption de la requête spécifique
  xhr_object.open("POST", url, true);

  xhr_object.onreadystatechange = function(){
    if ( xhr_object.readyState == 4 ){
      // Affichage dans la div spécifié le contenu retourné par le fichier
      document.getElementById("attributs").innerHTML = xhr_object.responseText;
    };
  };

  // Cas du get
  xhr_object.send(null);
};


function ficheAmgtComm(clef, type, date_amgt, commentaire) {
  // Déclaration des variables
  var xhr_object = null;

  if(window.XMLHttpRequest) {xhr_object = new XMLHttpRequest()} // Pour que ça marche avec Firefox
  else if (window.ActiveXObject) {xhr_object = new ActiveXObject("Microsoft.XMLHTTP")}; //Pour que ça marche avec Internet Explorer

  // Préparation de l'url
  url = "formulaire/formAutreAmenagementCommunication.php"
    + "?type_amenagement=" + type
    + "&date_amgt=" + date_amgt
    + "&commentaire=" + commentaire
    + "&clefModif=" + clef
    ;

  // Afficher la div
  if($('#attributs').css('display') == 'none') {
    affiche_masque("#attributs");
  };

  // Envoie et récéption de la requête spécifique
  xhr_object.open("POST", url, true);

  xhr_object.onreadystatechange = function(){
    if ( xhr_object.readyState == 4 ){
      // Affichage dans la div spécifié le contenu retourné par le fichier
      document.getElementById("attributs").innerHTML = xhr_object.responseText;
    };
  };

  // Cas du get
  xhr_object.send(null);
};


function ficheCloture(clef, type_mobilite, type_fils, type_poteau, date_amgt, partiel, etat, commentaire, longueur) {
  var xhr_object = null;
  if(window.XMLHttpRequest) {xhr_object = new XMLHttpRequest()} // Pour que ça marche avec Firefox
  else if (window.ActiveXObject) {xhr_object = new ActiveXObject("Microsoft.XMLHTTP")}; //Pour que ça marche avec Internet Explorer

  // Préparation de l'url
  url = "formulaire/formCloture.php"
    + "?type_mobilite=" + type_mobilite
    + "&type_fils=" + type_fils
    + "&type_poteau=" + type_poteau
    + "&date_amgt=" + date_amgt
    + "&partiel=" + partiel
    + "&etat=" + etat
    + "&commentaire=" + commentaire
    + "&clefModif=" + clef
    + "&longueur=" + longueur
    ;

  // Afficher la div
  if($('#attributs').css('display') == 'none') {
    affiche_masque("#attributs");
  };

  // Envoie et récéption de la requête spécifique
  xhr_object.open("POST", url, true);;

  xhr_object.onreadystatechange = function(){
    if ( xhr_object.readyState == 4 ){
      // Affichage dans la div spécifié le contenu retourné par le fichier
      document.getElementById("attributs").innerHTML = xhr_object.responseText;
    };
  };

  // Cas du get
  xhr_object.send(null);
};


function ficheBarriere(clef, type_mobilite, type_structure, dimension, date_amgt, cadenasPerm, etat, commentaire) {
  var xhr_object = null;
  if(window.XMLHttpRequest) {xhr_object = new XMLHttpRequest()} // Pour que ça marche avec Firefox
  else if (window.ActiveXObject) {xhr_object = new ActiveXObject("Microsoft.XMLHTTP")}; //Pour que ça marche avec Internet Explorer

  // Préparation de l'url
  url = "formulaire/formBarriere.php"
    + "?type_mobilite=" + type_mobilite
    + "&type_structure=" + type_structure
    + "&dimension=" + dimension
    + "&date_amgt=" + date_amgt
    + "&cadenasPerm=" + cadenasPerm
    + "&etat=" + etat
    + "&commentaire=" + commentaire
    + "&clefModif=" + clef
    ;

  // Afficher la div
  if($('#attributs').css('display') == 'none') {
    affiche_masque("#attributs");
  };

  // Envoie et récéption de la requête spécifique
  xhr_object.open("POST", url, true);

  xhr_object.onreadystatechange = function(){
    if ( xhr_object.readyState == 4 ){
      // Affichage dans la div spécifié le contenu retourné par le fichier
      document.getElementById("attributs").innerHTML = xhr_object.responseText;
    };
  };

  // Cas du get
  xhr_object.send(null);
};


function ficheAmgtZoot(clef, type, date_amgt, commentaire) {
  // Déclaration des variables
  var xhr_object = null;
  if(window.XMLHttpRequest) {xhr_object = new XMLHttpRequest()} // Pour que ça marche avec Firefox
  else if (window.ActiveXObject) {xhr_object = new ActiveXObject("Microsoft.XMLHTTP")}; //Pour que ça marche avec Internet Explorer

  // Préparation de l'url
  url = "formulaire/formAutreAmenagementZootechnie.php"
    + "?type_amenagement=" + type
    + "&date_amgt=" + date_amgt
    + "&commentaire=" + commentaire
    + "&clefModif=" + clef
    ;

  // Afficher la div
  if($('#attributs').css('display') == 'none') {
    affiche_masque("#attributs");
  };

  // Envoie et récéption de la requête spécifique
  xhr_object.open("POST", url, true);

  xhr_object.onreadystatechange = function(){
    if ( xhr_object.readyState == 4 ){
      // Affichage dans la div spécifié le contenu retourné par le fichier
      document.getElementById("attributs").innerHTML = xhr_object.responseText;
    };
  };

  // Cas du get
  xhr_object.send(null);
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
  // Afficher la div
  if($('#attributs').css('display') == 'none') {
    affiche_masque("#attributs");
  };

  var xhr_object = null;
  if(window.XMLHttpRequest) {xhr_object = new XMLHttpRequest()} // Pour que ça marche avec Firefox
	else if (window.ActiveXObject) {xhr_object = new ActiveXObject("Microsoft.XMLHTTP")}; //Pour que ça marche avec Internet Explorer

  url = "verifGeom.php"
    + "?type=" + type
    + "&geom=" + geom
    ;

  // Envoie et récéption de la requête spécifique
	xhr_object.open("POST", url, true);

  xhr_object.onreadystatechange = function(){
		if ( xhr_object.readyState == 4 ){
      // Affichage dans la div spécifié le contenu retourné par le fichier
			document.getElementById("attributs").innerHTML = xhr_object.responseText;

      if ($('.sqlAction>p').text() == '') {
        load_attribut(type);
      }
      else {
        setTimeout("affiche_masque('#attributs')", 4000);
      };
		};
	};


  // Cas du get
	xhr_object.send(null);

  // $.ajax({
  //   url      : "verifGeom.php",
  //   data     : {type:type, geom:geom},
  //   type     : "GET",
  //   dataType : "html",
  //   async    : true,
  //   error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
  //   success  : function(data) {$('#attribus').html(data);}
  // });
};


// Charge le formulaire spécifique
function load_attribut(type) {
  var xhr_object = null;
  if(window.XMLHttpRequest) {xhr_object = new XMLHttpRequest()} // Pour que ça marche avec Firefox
	else if (window.ActiveXObject) {xhr_object = new ActiveXObject("Microsoft.XMLHTTP")}; //Pour que ça marche avec Internet Explorer

  // Ouverture de formulaire spécifique (selon le type)
  if(type == '1') {
    url = "formulaire/formPanneau.php"
      ;
  }
  else if (type == '2') {
    url = "formulaire/formSentier.php"
      ;
  }
  else if (type == '3') {
    url = "formulaire/formAutreAmenagementCommunication.php"
      ;
  }
  else if (type == '4') {
    url = "formulaire/formCloture.php"
      ;
  }
  else if (type == '5') {
    url = "formulaire/formBarriere.php"
      ;
  }
  else if (type == '6') {
    url = "formulaire/formAutreAmenagementZootechnie.php"
      ;
  };

  // Afficher la div
  if($('#attributs').css('display') == 'none') {
    affiche_masque("#attributs");
  };

  // Envoie et récéption de la requête spécifique
	xhr_object.open("POST", url, true);

  xhr_object.onreadystatechange = function(){
		if ( xhr_object.readyState == 4 ){
      // Affichage dans la div spécifié le contenu retourné par le fichier
			document.getElementById("attributs").innerHTML = xhr_object.responseText;
		};
	};

  // Cas du get
	xhr_object.send(null);
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
  // Déclaration des variables
  var xhr_object = null;
  if(window.XMLHttpRequest) {xhr_object = new XMLHttpRequest()} // Pour que ça marche avec Firefox
	else if (window.ActiveXObject) {xhr_object = new ActiveXObject("Microsoft.XMLHTTP")}; //Pour que ça marche avec Internet Explorer

  // Transmission de l'information de façon spécifique (en fonction du type)
  if(type == "panneau") {
    url = url
      + "?objet=" + type
      + "&type=" + $('#type').val()
      + "&precision=" + $('#precision>input').val()
      + "&date_amgt=" + $('#date_amgt').val()
      + "&etat=" + $('#etat').val()
      + "&commentaire=" + escape($('#commentaire').val())
      + "&geom=" + $('#json').text()
      + "&clefModif=" + clefModif
      + "&tableLiaison=" + tableLiaison
      ;
  }
  else if(type == "sentier") {
    if ($('#pmrOui:checked').val() == 'true') {
      pmr = true;
    }
    else if ($('#pmrNon:checked').val() == 'false') {
      pmr = false;
    };

    url = url
      + "?objet=" + type
      + "&type_sentier=" + $('#type_sentier').val()
      + "&type_cheminement=" + $('#type_cheminement').val()
      + "&date_amgt=" + $('#date_amgt').val()
      + "&etat=" + $('#etat').val()
      + "&pmr=" + pmr
      + "&difficulte=" + $('#difficulte').val()
      + "&commentaire=" + escape($('#commentaire').val())
      + "&geom=" + $('#json').text()
      + "&clefModif=" + clefModif
      + "&tableLiaison=" + tableLiaison
      ;
  }
  else if (type == "autreamgtcomm") {
    url = url
      + "?objet=" + type
      + "&type=" + $('#type_amenagement').val()
      + "&date_amgt=" + $('#date_amgt').val()
      + "&commentaire=" + escape($('#commentaire').val())
      + "&geom=" + $('#json').text()
      + "&clefModif=" + clefModif
      ;
  }
  else if (type == "cloture") {
    if ($('#partielOui:checked').val() == 'true') {
      partiel = true;
    }
    else if ($('#partielNon:checked').val() == 'false') {
      partiel = false;
    };

    url = url
      + "?objet=" + type
      + "&type_mobilite=" + $('#type_mobilite').val()
      + "&type_fils=" + $('#type_fils').val()
      + "&type_poteau=" + $('#type_poteau').val()
      + "&date_amgt=" + $('#date_amgt').val()
      + "&partiel=" + partiel
      + "&etat=" + $('#etat').val()
      + "&commentaire=" + escape($('#commentaire').val())
      + "&geom=" + $('#json').text()
      + "&clefModif=" + clefModif
      ;
  }
  else if (type == "barriere") {
    if ($('#cadenasPermOui:checked').val() == 'true') {
      cadPerm = true;
    }
    else if ($('#cadenasPermNon:checked').val() == 'false') {
      cadPerm = false;
    };

    url = url
      + "?objet=" + type
      + "&type_mobilite=" + $('#type_mobilite').val()
      + "&type_structure=" + $('#type_structure').val()
      + "&dimension=" + $('#dimension').val()
      + "&date_amgt=" + $('#date_amgt').val()
      + "&cadenasPerm=" + cadPerm
      + "&etat=" + $('#etat').val()
      + "&commentaire=" + escape($('#commentaire').val())
      + "&geom=" + $('#json').text()
      + "&clefModif=" + clefModif
      ;
  }
  else if (type == "autreamgtzoot") {
    url = url
      + "?objet=" + type
      + "&type=" + $('#type_amenagement').val()
      + "&date_amgt=" + $('#date_amgt').val()
      + "&commentaire=" + escape($('#commentaire').val())
      + "&geom=" + $('#json').text()
      + "&clefModif=" + clefModif
      ;
  };

  // Envoie et récéption de la requête spécifique
	xhr_object.open("POST", url, true);
	xhr_object.onreadystatechange = function(){
		if ( xhr_object.readyState == 4 ){
			// Affichage dans la div spécifié le contenu retourné par le fichier
			document.getElementById("attributs").innerHTML = xhr_object.responseText;
    }
	}
	// Cas du get
	xhr_object.send(null);

  // Après 2 seconde, Met à jour les catégories et Masque la div attributs
    setTimeout("majcategorie(); affiche_masque('#attributs');", 2000);
};


// Suppression
function supprAttibut(objet, id) {
  suppr = confirm("Confirmez-vous la suppression ?") // Ouverture de la boite de confirmation

  // Si c'est confirmé
  if (suppr == true) {
    // Déclaration des variables
    var xhr_object = null;
    if(window.XMLHttpRequest) {xhr_object = new XMLHttpRequest()} // Pour que ça marche avec Firefox
    else if (window.ActiveXObject) {xhr_object = new ActiveXObject("Microsoft.XMLHTTP")}; //Pour que ça marche avec Internet Explorer

    // Préparation de l'url
    url = "supprAttributs.php"
      + "?objet=" + objet
      + "&id=" + id
    ;

    // Envoie et récéption de la requête spécifique
    xhr_object.open("POST", url, true);
    xhr_object.onreadystatechange = function(){
      if ( xhr_object.readyState == 4 ){
        affiche_masque('#attributs'); // affichage de la div attributs
        document.getElementById("attributs").innerHTML = xhr_object.responseText; // Intégration de la réponse
      };
    };
    // Cas du get
    xhr_object.send(null);

    setTimeout("majcategorie(); affiche_masque('#attributs');", 5000); // Après 2 seconde, Met à jour les catégories et Masque la div attributs
  };
};

// LightBox options
$(document).ready(
  function() {
    lightbox.option({
      'albumLabel':"Image %1 sur %2"
    });
});
