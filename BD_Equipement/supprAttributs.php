<?php
  include('data/AccessDataBasePgConnect.php'); // Accès à la base de donnée
  include('fonction.php'); // Inclus les fonction php

  // Récupration des valeurs
  $objet = $_GET['objet'];
  $clef = $_GET['id'];

  // Suppression des documents associé
  if ($objet == 'panneau') {
    $sql = "SELECT photo_lien AS lien FROM bd_equipement.photo WHERE photo_pann_id = ".$clef;
    $resultats_photo = tableau_objet($dbConnect, $sql);

    $sql = "SELECT piec_join_lien AS lien FROM bd_equipement.piece_jointe WHERE piec_join_pann_id = ".$clef." AND piec_join_type_piec_join_id != 3";
    $resultats_pieceJointe = tableau_objet($dbConnect, $sql);

    foreach ($resultats_photo as $photo) {
      $lien = $photo->lien;
      unlink($lien);
      $lienMiniature = substr($lien, 0, 10) ."miniature/mini_" .substr($lien, 10);
      unlink($lienMiniature);
    };

    foreach ($resultats_pieceJointe as $pieceJointe) {
      $lien = $pieceJointe->lien;
      unlink($lien);
    };
  }
  elseif ($objet == 'sentier') {
    $sql = "SELECT supp_comm_lien AS lien FROM bd_equipement.support_communication WHERE supp_comm_sent_id = ".$clef." AND supp_comm_type_supp_comm_id = 1";
    $resultats_supportComm = tableau_objet($dbConnect, $sql);

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
