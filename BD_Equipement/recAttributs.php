<?php
  include('data/AccessDataBasePgConnect.php'); // Accès à la base de données
  include('fonction.php'); // Insertion des fonctions

  $objet = $_GET['objet'];
  $clefModif = $_GET['clefModif'];


  // Panneau
  if ($objet == 'panneau') {
    // Récupération des informations transmise
    $type = $_GET['type'];
    $precision = $_GET['precision'];
    if ($precision == '' || $type != 5) {$precision = "null";};
    $date_amgt = $_GET['date_amgt'];
    $etat = $_GET['etat'];
    $commentaire = addslashes($_GET['commentaire']);
    if ($commentaire == '') {$commentaire = "null";};
    $geom = $_GET['geom'];
    $tableLiaison = $_GET['tableLiaison'];

    if ($clefModif != '') {
      $modif = 'true';
      $geom = "(SELECT pann_geom FROM bd_equipement.panneau WHERE pann_id = '".$clefModif."')";
    }
    else {
      $modif = 'false';
      $clefModif = '0';
      $geom = "ST_Transform(ST_SetSRID(ST_GeomFromGeoJSON('".$geom."'),4326),2154)";
    };

    $sql = "SELECT bd_equipement.panneau(".$modif.", ".$geom.", ".$clefModif.", ".$type.", '".$precision."'::varchar, '".$date_amgt."'::date, ".$etat.", E'".$commentaire."'::text)";
  }

  // Sentier
  elseif ($objet == 'sentier') {
    // Récupération des informations transmise
    $type_sentier = $_GET['type_sentier'];
    $type_cheminement = $_GET['type_cheminement'];
    $date_amgt = $_GET['date_amgt'];
    $etat = $_GET['etat'];
    $pmr = $_GET['pmr'];
    $difficulte = $_GET['difficulte'];
    $commentaire = addslashes($_GET['commentaire']);
    if ($commentaire == '') {$commentaire = "null";};
    $geom =  $_GET['geom'];
    $tableLiaison = $_GET['tableLiaison'];

    if ($clefModif != '') {
      $modif = 'true';
      $geom = "(SELECT sent_geom FROM bd_equipement.sentier WHERE sent_id = '".$clefModif."')";
    }
    else {
      $modif = 'false';
      $clefModif = '0';
      $geom = "ST_Transform(ST_SetSRID(ST_GeomFromGeoJSON('".$geom."'),4326),2154)";
    };

    $sql = "SELECT bd_equipement.sentier(".$modif.", ".$geom.", ".$clefModif.", ".$type_sentier.", ".$type_cheminement.", '".$date_amgt."'::date, ".$etat.", ".$pmr.", ".$difficulte.", E'".$commentaire."'::text)";
  }

  // Autre Aménagement de communication
  elseif ($objet == 'autreamgtcomm') {

    // Récupération des informations transmise
    $type = $_GET['type'];
    $date_amgt = $_GET['date_amgt'];
    $etat = $_GET['etat'];
    $commentaire = addslashes($_GET['commentaire']);
    if ($commentaire == '') {$commentaire = "null";};
    $geom = $_GET['geom'];

    if ($clefModif != '') {
      $modif = 'true';
      $geom = "(SELECT autr_amen_comm_geom FROM bd_equipement.autre_amenagement_communication WHERE autr_amen_comm_id = '".$clefModif."')";
    }
    else {
      $modif = 'false';
      $clefModif = '0';
      $geom = "ST_Transform(ST_SetSRID(ST_GeomFromGeoJSON('".$geom."'),4326),2154)";
    };

    $sql = "SELECT bd_equipement.autre_amenagement_communication(".$modif.", ".$geom.", ".$clefModif.", ".$type.", '".$date_amgt."'::date, ".$etat.", E'".$commentaire."'::text)";
  }

  // Clôture
  elseif ($objet == 'cloture') {
    // Récupération des valeurs transmise
    $type_mobilite = $_GET['type_mobilite'];
    $type_fils = $_GET['type_fils'];
    $type_poteau = $_GET['type_poteau'];
    $date_amgt = $_GET['date_amgt'];
    $partiel = $_GET['partiel'];
    $etat = $_GET['etat'];
    $commentaire = addslashes($_GET['commentaire']);
    if ($commentaire == '') {$commentaire = "null";};
    $geom = $_GET['geom'];

    if ($clefModif != '') {
      $modif = 'true';
      $geom = "(SELECT clot_geom FROM bd_equipement.cloture WHERE clot_id = '".$clefModif."')";
    }
    else {
      $modif = 'false';
      $clefModif = '0';
      $geom = "ST_Transform(ST_SetSRID(ST_GeomFromGeoJSON('".$geom."'),4326),2154)";
    };

    $sql = "SELECT bd_equipement.cloture(".$modif.", ".$geom.", ".$clefModif.", ".$type_mobilite.", ".$type_fils.", ".$type_poteau.", '".$date_amgt."'::date, ".$partiel.", ".$etat.", E'".$commentaire."'::text)";
  }

  // Barrière
  elseif ($objet == 'barriere') {
    // Récupération des valeurs transmise
    $type_mobilite = $_GET['type_mobilite'];
    $type_structure = $_GET['type_structure'];
    $dimension = $_GET['dimension'];
    $date_amgt = $_GET['date_amgt'];
    $cadenasPerm = $_GET['cadenasPerm'];
    $etat = $_GET['etat'];
    $commentaire = addslashes($_GET['commentaire']);
    if ($commentaire == '') {$commentaire = "null";};
    $geom = $_GET['geom'];

    if ($clefModif != '') {
      $modif = 'true';
      $geom = "(SELECT barr_geom FROM bd_equipement.barriere WHERE barr_id = '".$clefModif."')";
    }
    else {
      $modif = 'false';
      $clefModif = '0';
      $geom = "ST_Transform(ST_SetSRID(ST_GeomFromGeoJSON('".$geom."'),4326),2154)";
    };

    $sql = "SELECT bd_equipement.barriere(".$modif.", ".$geom.", ".$clefModif.", ".$type_mobilite.", ".$type_structure.", ".$dimension.", '".$date_amgt."'::date, ".$cadenasPerm.", ".$etat.", E'".$commentaire."'::text)";
  }

  // Autre Aménagement de Zootechnie
  elseif ($objet == 'autreamgtzoot') {

    // Récupération des valeurs transmise
    $type = $_GET['type'];
    $date_amgt = $_GET['date_amgt'];
    $etat = $_GET['etat'];
    $commentaire = addslashes($_GET['commentaire']);
    if ($commentaire == '') {$commentaire = "null";};
    $geom = $_GET['geom'];

    if ($clefModif != '') {
      $modif = 'true';
      $geom = "(SELECT autr_amen_zoot_geom FROM bd_equipement.autre_amenagement_zootechnie WHERE autr_amen_zoot_id = '".$clefModif."')";
    }
    else {
      $modif = 'false';
      $clefModif = '0';
      $geom = "ST_Transform(ST_SetSRID(ST_GeomFromGeoJSON('".$geom."'),4326),2154)";
    };

    $sql = "SELECT bd_equipement.autre_amenagement_zootechnie(".$modif.", ".$geom.", ".$clefModif.", ".$type.", '".$date_amgt."'::date, ".$etat.", E'".$commentaire."'::text)";
  };

  $requete = pg_query($dbConnect, $sql); // Requet d'insertion et de modification

  if ($objet == 'panneau') {
      liaison($dbConnect,$objet,$tableLiaison);
    }
    elseif ($objet == 'sentier') {
      liaison($dbConnect,$objet,$tableLiaison);
    };

  $requete = pg_fetch_array($requete);

  // Si la requête a échoué
  if ($requete == false) {
    // Création du message d'erreur
    if ($clefModif != 0) {
      $recMsg = "Modification";
    }
    else {
      $recMsg = "Enregistrement";
    };

    if ($objet == 'panneau' || $objet == 'sentier') {
      $recMsg .= " du ";
    }
    elseif ($objet == 'autreamgtcomm' || $objet == 'autreamgtzoot') {
      $recMsg .= " de l\'";

      if ($objet == 'autreamgtcomm') {
        $objet = "amenagement de valorisation";
      }
      elseif ($objet == 'autreamgtzoot') {
        $objet = "amenagement de gestion";
      };
    }
    elseif ($objet == 'cloture' || $objet == 'barriere') {
      $recMsg .= " de la ";
    };

    $recMsg .= ucfirst($objet) ." échoué !";
  }

  // Si la requête a réussi
  else {
    // si il n'y a pas de levé d'erreur
    if ($requete[0] == 0) {
      // Création du message
      if ($objet == 'autreamgtcomm') {
        $objet = "amenagement de valorisation";
      }
      elseif ($objet == 'autreamgtzoot') {
        $objet = "amenagement de Gestion";
      };

      $recMsg = ucfirst($objet);
      if ($clefModif != 0) {
        $recMsg .= " modifié";
      }
      else {
        $recMsg .= " enregistré";
      };
    };
  };

  pg_close($dbConnect); // Fermeture de l'accès à la base de données
?>
<!DOCTYPE html>
<html lang="fr">
  <div class="sqlAction">
    <p><?=$recMsg ?></p>
  </div>
</html>
