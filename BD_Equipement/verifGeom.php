<?php
  // Fonction de verification de la géométrie
  include('data/AccessDataBasePgConnect.php');

  $type = $_GET['type'];
  $geom = $_GET['geom'];

  if ($type == '1') {
    $objet = "panneau";
  }
  elseif ($type == '2') {
    $objet = "sentier";
  }
  elseif ($type == '3') {
    $objet = "autreamgtcomm";
  }
  elseif ($type == '4') {
    $objet = "cloture";
  }
  elseif ($type == '5') {
    $objet = "barriere";
  }
  elseif ($type == '6') {
    $objet = "autreamgtzoot";
  };

  $geom = "ST_Transform(ST_SetSRID(ST_GeomFromGeoJSON('".$geom."'),4326),2154)";

  $sql = "SELECT bd_equipement.verification('".$objet."'::varchar, ".$geom.")";
  $resultat_verif = pg_query($dbConnect, $sql);
  $verif = pg_fetch_row($resultat_verif);
  pg_close($dbConnect);

  // Si il n'y a pas d'arreur
  if ($verif[0] == 0) {
    // load_attribut($type);
    $recMsg = "";
  }
  // Si l'équipement ce situe en dehors d'un site (levé de l'erreur n° -12)
  elseif ($verif[0] == -11) {
    // Création du message
    if ($objet == 'panneau' || $objet == 'sentier') {
      $recMsg = "Le ";
    }
    elseif ($objet == 'autreamgtcomm' || $objet == 'autreamgtzoot') {
      $recMsg = "L'";

      if ($objet == 'autreamgtcomm') {
        $objet = "amenagement de communication";
      }
      elseif ($objet == 'autreamgtzoot') {
        $objet = "amenagement de zootechnie";
      };
    }
    elseif ($objet == 'cloture' || $objet == 'barriere') {
      $recMsg = "La ";
    };

    $recMsg .= $objet ." doit être à l'interieur d'un site !";
  }
  // Si le dessin de l'équipement (sentier ou clôture) sort du site (levé de l'erreur n° -11)
  elseif ($verif[0] == -12) {
    // $recMsg = "Redessinez ";
    if ($objet == 'sentier') {
      $det_1 = "le ";
      $det_2 = "il ";
    }
    elseif ($objet == 'cloture') {
      $det_1 = "la ";
      $det_2 = "elle ";
    };

    $recMsg = "Redessinez " .$det_1 .$objet .", " .$det_2 ."  passe en dehors du site.";
  }
  // Si l'équipements (barrière ou passage d'homme) est à plus de 20m d'une clôture (levé de l'erreur n° -2)
  elseif ($verif[0] == -20) {
    // Création du message
    $recMsg = "La barrière doit se situer à moins de 20m d'une clôture";
  };
?>
<div class="sqlAction">
  <p><?=$recMsg ?></p>
</div>
