<?php
  include('data/AccessDataBasePgConnect.php'); // Accès à la base de donnée
  include('fonction.php'); // Inclus les fonction php

  // Récupration des valeurs
  $objet = $_GET['objet'];
  $clef = $_GET['id'];

  // Suppression des documents associé
  if ($objet == 'panneau') {
    $sql = "SELECT supp_comm_lien AS lien FROM bd_equipement.support_communication WHERE supp_comm_cate_id = 1 AND supp_comm_type_supp_comm_id = 1 AND supp_comm_equi_id = ".$clef;
    $resultats_photo = tableau_objet($dbConnect, $sql);

    foreach ($resultats_photo as $photo) {
      $lien = $photo->lien;
      unlink($lien);
      $lien_explode = explode('/', $lien);
      $lienMiniature = $lien_explode[0]."/".$lien_explode[1]."/miniature/mini_".$lien_explode[2];
      unlink($lienMiniature);
    };

    $sql = "SELECT supp_comm_lien AS lien FROM bd_equipement.support_communication WHERE supp_comm_cate_id = 1 AND supp_comm_type_supp_comm_id IN (2, 3) AND supp_comm_equi_id = ".$clef;
    $resultats_supportComm = tableau_objet($dbConnect, $sql);
  }
  elseif ($objet == 'sentier') {
    $sql = "SELECT supp_comm_lien AS lien FROM bd_equipement.support_communication WHERE supp_comm_cate_id = 2 AND supp_comm_type_supp_comm_id = 4 AND supp_comm_equi_id = ".$clef;
    $resultats_supportComm = tableau_objet($dbConnect, $sql);
  }
  elseif ($objet == 'autreamgtcomm') {
    $sql = "SELECT supp_comm_lien AS lien FROM bd_equipement.support_communication WHERE supp_comm_cate_id = 3 AND supp_comm_type_supp_comm_id = 2 AND supp_comm_equi_id = ".$clef;
    $resultats_supportComm = tableau_objet($dbConnect, $sql);
  };

if (isset($resultats_supportComm)) {
  foreach ($resultats_supportComm as $supportComm) {
    $lien = $supportComm->lien;
    unlink($lien);
  };
};

  // Appel de la fonction de suppression
  $sql = "SELECT bd_equipement.suppression('".$objet."', '".$clef."')";

  // Exécution du sql
  $req_suppr = pg_query($dbConnect, $sql);
  $req_suppr = pg_fetch_array($req_suppr);

  if ($req_suppr == false) { // Si la requête à échoué
    $supprMsg = "Suppression avorté !";
  }
  else { // Si la requête à réussi
    if ($req_suppr[0] == 0) {
      $supprMsg = "Suppression effectué";

    }
    elseif ($req_suppr[0] == -1) {
      $supprMsg = "Des barrières ou des passages d'homme sont installer sur cette clôture,
                  <br/> veuillez les supprimer avant.";
    };
  };

  pg_close($dbConnect); // fermeture de l'accès à la base de données
?>
<!DOCTYPE html>
<html lang="fr">
  <div class="sqlAction">
    <p><?=$supprMsg ?></p>
  </div>
</html>
