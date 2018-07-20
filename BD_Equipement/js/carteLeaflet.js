//// Préparation de la donnée "Panneau" ////
function panneau_Data() {
  //// Style à appliquer ////
  var style_commPanneau = {
    icon: new L.Icon({
      iconUrl: './img/IconCommPanneau.png' // chemin vers l'icone (Nombreux choix sur : https://www.flaticon.com/)
      , shadowUrl: './img/shadow.png'
      , iconSize: [40, 40] // Taille de l'image [Largeur, Hauteur]
      , iconAnchor: [20, 40] // Point d'ancrage de l'image [Horizontal, Vertical]
      , shadowSize:  [40, 40] // Taille de l'ombre [Largeur, Hauteur]
      , shadowAnchor: [10,40] // Point d'ancrage de l'ombre [Horizontal, Vertical]
    })
  };

  //// Appelle des données ////
  $.ajax({
    // requete a la bdd en ajax
    url      : "data/Panneau.php",
    type     : "GET",
    dataType : "json",
    async    : false,
    error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
    success  : function(data) {
        point_panneau = data;
        }
  });

  //// Intégration à la carte + info-bulle////
  commPanneau = L.geoJSON(point_panneau, {
    pointToLayer: function(pt, latlng) {
      return L.marker(latlng, style_commPanneau);
    },
    // Info-bulle
    onEachFeature: function(attribut, couche) {
      couche.on({
        click: function(entite) {
          contenu = "<div class=\"popup\"><label class=\"popTitre\">Panneau</label>"
            + "<br/><span><label class=\"popType\">Type : </label>" + attribut.properties.type_panneau + "</span>"
            + "<br/><span id=\"popPhotoPanneau\"></span>"
            + "<br/><button type=\"button\" id=\"fiche\" name=\"fiche\" onclick=\"fichePanneau(\'" + attribut.properties.pann_id + "\',\'" + attribut.properties.type_pann_id + "\',\'" + attribut.properties.pann_prec + "\',\'" + attribut.properties.date_amgt + "\',\'" + attribut.properties.etat_comm_id + "\',\'" + escape(attribut.properties.commentaire) + "\')\">Fiche Détaillée</button>"
            + "<br/><button type=\"button\" id=\"suppr\" name=\"suppr\" onclick=\"supprAttibut(\'panneau\', \'" + attribut.properties.pann_id + "\'), maCarte.closePopup()\"><img id=\"supprImg\" src=\"img/garbage.png\" alt=\"Supprimer\"/></button></div>";
          popup = L.popup({closeOnClick: true})
            .setLatLng(entite.latlng)
            .setContent(contenu)
            .openOn(maCarte);

          photoPanneau(attribut.properties.pann_id);
        }
      });
    }
  });
  commPanneau.addTo(maCarte);
};


//// Préparation la donnée "Sentier Pédagogique" ////
function sentier_Data() {
  //// Style à appliquer ////
  var style_commSentier = {
    color: "#ff9900" // couleur du contour
    , weight: 3 // épaisseur du contour
    , opacity: 1 // opacité du contour
  };

  //// Appelle des données ////
  $.ajax({
    // requete a la bdd en ajax
    url      : "data/Sentier.php",
    type     : "GET",
    dataType : "json",
    async    : false,
    error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
    success  : function(data) {
        ligne_sentier_pedagogique = data;
        }
    });

  //// Intégration  à la carte + Info-bulle ////
  commSentier = L.geoJSON(ligne_sentier_pedagogique, {
    style: function() {
      return style_commSentier
    },
    // Info-bulle
    onEachFeature: function(attribut, couche) {
      couche.on({
        click: function(entite) {
          contenu = "<div class=\"popup\"><label class=\"popTitre\">Sentier</label>"
            + "<br/><span><label class=\"popType\">Type : </label>" + attribut.properties.type_sentier + "</span>"
            + "<br/><span><label class=\"popType\">Longeur : </label>" + attribut.properties.longueur + " m </span>"
            + "<br/><button type=\"button\" id=\"fiche\" name=\"fiche\" onclick=\"ficheSentier(\'" + attribut.properties.sent_id + "\',\'" + attribut.properties.type_sent_id + "\',\'" + attribut.properties.type_chem_id + "\',\'" + attribut.properties.date_amgt + "\',\'" + attribut.properties.etat_comm_id + "\',\'" + attribut.properties.acces_pmr + "\',\'" + attribut.properties.diff_id + "\',\'" + escape(attribut.properties.commentaire) + "\',\'" + attribut.properties.longueur + "\')\">Fiche Détaillée</button>"
            + "<br/><button type=\"button\" id=\"suppr\" name=\"suppr\" onclick=\"supprAttibut(\'sentier\', \'" + attribut.properties.sent_id + "\'), maCarte.closePopup()\"><img id=\"supprImg\" src=\"img/garbage.png\" alt=\"Supprimer\"/></button></div>";
          popup = L.popup({closeOnClick: true})
            .setLatLng(entite.latlng)
            .setContent(contenu)
            .openOn(maCarte);
        }
      });
    }
  });
  commSentier.addTo(maCarte);
};

//// Préparation de la donnée "Autre Aménagement de Communication" ////
function autre_amenagement_communication_Data() {
  //// Style à appliquer ////
  var style_commAutreAmenagement = {
    icon: new L.Icon({
      iconUrl: './img/IconCommAutreAmenagement.png' // chemin vers l'icone (Nombreux choix sur : https://www.flaticon.com/)
      , shadowUrl: './img/shadow.png'
      , iconSize: [40, 40] // Taille de l'image [Largeur, Hauteur]
      , iconAnchor: [20, 40] // Point d'ancrage de l'image [Horizontal, Vertical]
      , shadowSize:  [40, 40] // Taille de l'onmbre [Largeur, Hauteur]
      , shadowAnchor: [10,40] // Point d'anchrage de l'ombre [Horizontal, Vertical]
    })
  };

  //// Appelle des données ////
  $.ajax({
    // requete a la bdd en ajax
    url      : "data/AutreAmenagementCommunication.php",
    type     : "GET",
    dataType : "json",
    async    : false,
    error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
    success  : function(data) {
        point_autre_amenagement_communication = data;
        }
  });

  //// Intégration à la carte + Info-bulle////
  commAutreAmenagement = L.geoJSON(point_autre_amenagement_communication, {
    pointToLayer: function(pt, latlng) {
      return L.marker(latlng, style_commAutreAmenagement);
    },
    // Info-bulle
    onEachFeature: function(attribut, couche) {
      couche.on({
        click: function(entite) {
          contenu = "<div class=\"popup\"><label class=\"popTitre\">Autre Aménagement de Communication</label>"
            + "<br/><span><label class=\"popType\">Type : </label>" + attribut.properties.type_amenagement + "</span>"
            + "<br/><button type=\"button\" id=\"fiche\" name=\"fiche\" onclick=\"ficheAmgtComm(\'" + attribut.properties.autr_amen_comm_id + "\',\'" + attribut.properties.type_autr_amen_comm_id + "\',\'" + attribut.properties.date_amgt + "\',\'" + attribut.properties.etat_comm_id + "\',\'" + escape(attribut.properties.commentaire) + "\')\">Fiche Détaillée</button>"
            + "<br/><button type=\"button\" id=\"suppr\" name=\"suppr\" onclick=\"supprAttibut(\'autreamgtcomm\', \'" + attribut.properties.autr_amen_comm_id + "\'), maCarte.closePopup()\"><img id=\"supprImg\" src=\"img/garbage.png\" alt=\"Supprimer\"/></button></div>";
          popup = L.popup({closeOnClick: true})
            .setLatLng(entite.latlng)
            .setContent(contenu)
            .openOn(maCarte);
        }
      });
    }
  });
  commAutreAmenagement.addTo(maCarte);
};

//// Préparation de la donnée "Clôture" ////
function cloture_Data() {
  //// Style à appliquer ////
  var style_zootCloture = {
    color: "#3366cc" // couleur du contour
    , weight: 3 // épaisseur du contour
    , opacity: 1 // opacité du contour
  };

  //// Appelle des données ////
  $.ajax({
    // requete a la bdd en ajax
    url      : "data/Cloture.php",
    type     : "GET",
    dataType : "json",
    async    : false,
    error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
    success  : function(data) {
        ligne_cloture = data;
        }
  });

  //// Intégration à la carte + Info-bulle////
  zootCloture = L.geoJSON(ligne_cloture, {
    style: function() {
      return style_zootCloture
    },
    // Info-bulle
    onEachFeature: function(attribut, couche) {
      couche.on({
        click: function(entite) {
          contenu = "<div class=\"popup\"><label class=\"popTitre\">Clôture</label>"
            + "<br/><span><label class=\"popType\">Type : </label>" + attribut.properties.type_mobilite + "</span>"
            + "<br/><span><label class=\"popType\">Longeur : </label>" + attribut.properties.longueur + " m </span>"
            + "<br/><button type=\"button\" id=\"fiche\" name=\"fiche\" onclick=\"ficheCloture(\'" + attribut.properties.clot_id + "\',\'" + attribut.properties.type_mobi_id + "\',\'" + attribut.properties.type_fils_id + "\',\'" + attribut.properties.type_pote_id + "\',\'" + attribut.properties.date_amgt + "\',\'" + attribut.properties.clot_partiel + "\',\'" + attribut.properties.etat_zoot_id + "\',\'" + escape(attribut.properties.commentaire) + "\',\'" + attribut.properties.longueur + "\')\">Fiche Détaillée</button>"
            + "<br/><button type=\"button\" id=\"suppr\" name=\"suppr\" onclick=\"supprAttibut(\'cloture\', \'" + attribut.properties.clot_id + "\'), maCarte.closePopup()\"><img id=\"supprImg\" src=\"img/garbage.png\" alt=\"Supprimer\"/></button></div>";
          popup = L.popup({closeOnClick: true})
            .setLatLng(entite.latlng)
            .setContent(contenu)
            .openOn(maCarte);
        }
      });
    }
  });
  zootCloture.addTo(maCarte);
};

//// Préparation de la donnée "Barrière" ////
function barriere_Data() {
  //// Style à appliquer ////
  var style_zootBarriere = {
    icon: new L.Icon({
      iconUrl: './img/IconZootBarriere.png' // chemin vers l'icone (Nombreux choix sur : https://www.flaticon.com/)
      , shadowUrl: './img/shadow.png'
      , iconSize: [40, 40] // Taille de l'image [Largeur, Hauteur]
      , iconAnchor: [20, 40] // Point d'ancrage de l'image [Horizontal, Vertical]
      , shadowSize:  [40, 40] // Taille de l'ombre [Largeur, Hauteur]
      , shadowAnchor: [10,40] // Point d'ancrage de l'ombre [Horizontal, Vertical]
    })
  };

  //// Appelle des données ////
  $.ajax({
    // requete a la bdd en ajax
    url      : "data/Barriere.php",
    type     : "GET",
    dataType : "json",
    async    : false,
    error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
    success  : function(data) {
        point_barriere = data;
        }
  });

  //// Intégration à la carte + info-bulle////
  zootBarriere = L.geoJSON(point_barriere, {
    pointToLayer: function(pt, latlng) {
      return L.marker(latlng, style_zootBarriere);
    },
    // Info-Bulle
    onEachFeature: function(attribut, couche) {
      couche.on({
        click: function(entite) {
          contenu = "<div class=\"popup\"><label class=\"popTitre\">Barrière</label>"
            + "<br/><span><label class=\"popType\">Type : </label>" + attribut.properties.type_mobilite + "</span>"
            + "<br/><span><label class=\"popType\">Type de structure : </label>" + attribut.properties.type_structure + "</span>"
            + "<br/><button type=\"button\" id=\"fiche\" name=\"fiche\" onclick=\"ficheBarriere(\'" + attribut.properties.barr_id + "\',\'" + attribut.properties.type_mobi_id + "\',\'" + attribut.properties.type_stru_id + "\',\'" + attribut.properties.dimension + "\',\'" + attribut.properties.date_amgt + "\',\'" + attribut.properties.cadenas_permanent + "\',\'" + attribut.properties.etat_zoot_id + "\',\'" + escape(attribut.properties.commentaire) + "\')\">Fiche Détaillée</button>"
            + "<br/><button type=\"button\" id=\"suppr\" name=\"suppr\" onclick=\"supprAttibut(\'barriere\', \'" + attribut.properties.barr_id + "\'), maCarte.closePopup()\"><img id=\"supprImg\" src=\"img/garbage.png\" alt=\"Supprimer\"/></button></div>";
          popup = L.popup({closeOnClick: true})
            .setLatLng(entite.latlng)
            .setContent(contenu)
            .openOn(maCarte);
        }
      });
    }
  });
  zootBarriere.addTo(maCarte);
};

//// Préparation de la donnée "Autre Aménagement de Zootechnie" ////
function autre_amenagement_zootechnie_Data() {
  //// Style à appliquer ////
  var style_zootAutreAmenagement = {
    icon: new L.Icon({
      iconUrl: './img/IconZootAutreAmenagement.png' // chemin vers l'icone (Nombreux choix sur : https://www.flaticon.com/)
      , shadowUrl: './img/shadow.png'
      , iconSize: [40, 40] // Taille de l'image [Largeur, Hauteur]
      , iconAnchor: [20, 40] // Point d'ancrage de l'image [Horizontal, Vertical]
      , shadowSize:  [40, 40] // Taille de l'ombre [Largeur, Hauteur]
      , shadowAnchor: [10,40] // Point d'ancrage de l'ombre [Horizontal, Vertical]
    })
  };

  //// Appelle des données ////
  $.ajax({
    // requete a la bdd en ajax
    url      : "data/AutreAmenagementZootechnie.php",
    type     : "GET",
    dataType : "json",
    async    : false,
    error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
    success  : function(data) {
        point_autre_amenagement_zootechnie = data;
        }
  });

  //// Intégration à la carte + info-bulle ////
  zootAutreAmenagement = L.geoJSON(point_autre_amenagement_zootechnie, {
    pointToLayer: function(pt, latlng) {
      return L.marker(latlng, style_zootAutreAmenagement);
    },
    // Info-bulle
    onEachFeature: function(attribut, couche) {
      couche.on({
        click: function(entite) {
          contenu = "<div class=\"popup\"><label class=\"popTitre\">Autre Aménagement de Zootechnie</label>"
            + "<br/><span><label class=\"popType\">Type : </label>" + attribut.properties.type_amenagement + "</span>"
            + "<br/><button type=\"button\" id=\"fiche\" name=\"fiche\" onclick=\"ficheAmgtZoot(\'" + attribut.properties.autr_amen_zoot_id + "\',\'" + attribut.properties.type_autr_amen_zoot_id + "\',\'" + attribut.properties.date_amgt + "\',\'" + attribut.properties.etat_zoot_id + "\',\'" + escape(attribut.properties.commentaire) + "\')\">Fiche Détaillée</button>"
            + "<br/><button type=\"button\" id=\"suppr\" name=\"suppr\" onclick=\"supprAttibut(\'autreamgtzoot\', \'" + attribut.properties.autr_amen_zoot_id + "\'), maCarte.closePopup()\"><img id=\"supprImg\" src=\"img/garbage.png\" alt=\"Supprimer\"/></button></div>";
          popup = L.popup({closeOnClick: true})
            .setLatLng(entite.latlng)
            .setContent(contenu)
            .openOn(maCarte);
        }
      });
    }
  });
  zootAutreAmenagement.addTo(maCarte);
};





//// Affichage des sites en fonction des filtres ////
function majsite(){
  //// Style à appliquer ////
  var style_site_polygone = {
    color: "#00ff00" // couleur du contour
    , weight: 3 // épaisseur du contour
    , opacity: 1 // opacité du contour
    , fillOpacity: 0.2 // opacité du remplissage
  };

  //// Efface les sites, si non appelé ////
  if(typeof(site_localisation) != 'undefined'){
    sitesCEN.clearLayers();
  };

  //// Récupération de l'ID ////
  idsite = $('#site').val();

  //// Appelle des données ////
  $.ajax({
    // requete a la bdd en ajax
    url      : "data/SitesCenNs.php",
    data     : {idsite:idsite},
    type     : "GET",
    dataType : "json",
    async    : false,
    error    : function(request, error) { alert("Erreur : responseText: "+request.responseText);},
    success  : function(data) {
        site_localisation = data;
        }
    });

  // Intégration des données à la carte
  sitesCEN = L.geoJSON(site_localisation, {
    style: function(polygone) {
      return style_site_polygone
    }
    ,
    // // Info-Bulle
    onEachFeature: function(attribut, couche) {
        // contenu = "<b>ID : </b>" + attribut.properties.code_site
        //   + "<br><b>Site : </b>" + attribut.properties.commune + " - " + attribut.properties.nom_site;
        contenu = attribut.properties.commune + " - " + attribut.properties.nom_site;
        couche.bindTooltip(contenu, {
          permanent: false
          , sticky: true
          , opacity: 1
          , direction: "top"
        });
        // sticky : la popup suit ou pas le curseur de la souris
        // direction  : endroit d'ouverture par rapport au survol ("top", "bottom", "left", "right", "center")
    }
  });
  sitesCEN.addTo(maCarte);
  // // Ajout d'une couche sélectionnable au controleur
  // lControl.addOverlay(sitesCEN, "Sites du CEN");

  // Zoom sur l'entité
  maCarte.fitBounds(sitesCEN.getBounds());
};

//// Affichage des catégories en fonction des filtres ////
function majcategorie() {
  //// Suppression des entités non-appelé ////
  if(typeof(point_panneau) != 'undefined'){
    commPanneau.clearLayers();
  };
  if(typeof(ligne_sentier_pedagogique) != 'undefined'){
    commSentier.clearLayers();
  };
  if(typeof(point_autre_amenagement_communication) != 'undefined'){
    commAutreAmenagement.clearLayers();
  };
  if(typeof(ligne_cloture) != 'undefined'){
    zootCloture.clearLayers();
  };
  if(typeof(point_barriere) != 'undefined'){
    zootBarriere.clearLayers();
  };
  if(typeof(point_autre_amenagement_zootechnie) != 'undefined'){
    zootAutreAmenagement.clearLayers();
  };

  // Récupération de l'id
  idcategorie = $('#categorie').val();

  //// Affichage en fonction du filtre choisie ////
  if(idcategorie == "tous") {
    panneau_Data()
    , sentier_Data()
    , autre_amenagement_communication_Data()
    , cloture_Data()
    , barriere_Data()
    , autre_amenagement_zootechnie_Data();
  }
  else if(idcategorie == 1) {
    panneau_Data()
    , sentier_Data();
  }
  else if(idcategorie == 2) {
    sentier_Data();
  }
  else if(idcategorie == 3) {
    autre_amenagement_communication_Data()
    , sentier_Data();
  }
  else if(idcategorie == 4) {
    cloture_Data();
  }
  else if(idcategorie == 5) {
    barriere_Data()
    , cloture_Data();
  }
  else if(idcategorie == 6) {
    autre_amenagement_zootechnie_Data()
    , cloture_Data();
  };
};

//// Dessin ////
function drawing(){
  if(typeof(dessinControl) != 'undefined') {
    maCarte.removeControl(dessinControl);
  };

  // Dessin ponctuel (point)
  if($('#site').val() != "tous" && ($('#categorie').val() == "1" || $('#categorie').val() == "3" || $('#categorie').val() == "5" || $('#categorie').val() == "6")){
    // Création du controle d'édition du dessin et insére le dessin dans le groupe des couches éditables
    dessinControl = new L.Control.Draw({
      draw: {
        marker: true
        , circle: false
        , circlemarker: false
        , rectangle: false
        , polyline: false
        , polygon : false
        , toolbar: {
            buttons: {
              marker: 'Poser un marqueur'
            },
      			actions: {
      				title: 'Annuler le dessin',
      				text: 'Annuler'
      			}
    		}
      }
    });
    maCarte.addControl(dessinControl);
  }
  else if ($('#site').val() != "tous" && ($('#categorie').val() == "2" || $('#categorie').val() == "4")) {
    // Création du controle d'édition du dessin et insére le dessin dans le groupe des couches éditables
    dessinControl = new L.Control.Draw({
      draw: {
        marker: false
        , circle: false
        , circlemarker: false
        , rectangle: false
        , polyline: true
        , polygon : false
        , toolbar: {
            buttons: {
              polyline: 'Dessiner une ligne'
            },
      			actions: {
      				title: 'Annuler le dessin',
      				text: 'Annuler'
      			},
      			finish: {
      				title: 'Finir le dessin',
      				text: 'Finir'
      			},
      			undo: {
      				title: 'Supprimer le dernier point dessiné',
      				text: 'Supprimer le dernier point'
      			}
    		}
      }
    });
    maCarte.addControl(dessinControl);
  };
};





//// Initialisation de la carte ////
$(document).ready(function() { // Action à faire quand la page html est chargé
  // Création de la carte
  maCarte = L.map('map', {
    center: [49.391, 1.012] // Centrage (Coordonnées [Latitude, Longitude])
    , zoom: 8 // Niveau de zoom initiale
    , minZoom: 8 // Blockage du niveau de zoom avec un minimum (Le plus éloigné)
    , maxBounds: [ [48.5, -0.1],[50.2, 2] ] // Blockage de l'emprise de carte sur la Normandie-Seine (Point Bas-Gauche, Point Haut-Droit)
    // , maxBounds: [ [48.0, -2],[50.2, 2] ] // Blockage de l'emprise de carte sur la région Normandie (Point Bas-Gauche, Point Haut-Droit)
    , zoomControl: false // Désactivation du controleur de zoom (permet de la déplacer, par défaut = 'Haut-Gauche')
  });


  // Création du controleur de couche (position haut-gauche)
  lControl = L.control.layers(null, null, {position: 'topleft'}).addTo(maCarte);

  // Création du controleur de zoom (position haut-droite)
  zoomControl = L.control.zoom({position: 'topright'}).addTo(maCarte);

  // Création de l'échelle (position bas-gauche)
  echelleControl = L.control.scale({position: 'bottomleft'}).addTo(maCarte);


  // Ajout des fonds de plan à la carte + ajout au controleur
  fondTopo = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
    maxZoom: 17, //
    attribution: '&copy; <a href="https://opentopomap.org/#map=5/49.023/10.020">OpenTopoMap</a>'
  }).addTo(maCarte);
  lControl.addBaseLayer(fondTopo, "Carte Topo");

  osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a>'
  });
  lControl.addBaseLayer(osm, "Open Street Map");

  googleSat = L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    attribution: '&copy;2018 TerraMetrics, &copy;2018 Google'
  });
  lControl.addBaseLayer(googleSat, "Google Satellite");


  // Affichage des sites et équipements
  majsite();
  majcategorie();

  // Quand un dessin est crée
  maCarte.on('draw:created', function(event) {
    var layer = event.layer;
    var shape = layer.toGeoJSON().geometry;
    var shape_for_db = JSON.stringify(shape);

    document.getElementById('json').innerHTML = shape_for_db;

    verifGeom($('#categorie').val(), $('#json').text())
  });
});
