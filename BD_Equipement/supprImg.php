<?php
  include('data/AccessDataBasePgConnect.php'); // Accès à la base de données

  $lienFull = $_POST['lien'];

  $lien = strstr($lienFull, 'doc/');
  $lien_explode = explode('/', $lien);
  $objet = $lien_explode[1];

  if ($objet == 'photo') {
    $id_fichier = explode('.', $lien_explode[2]);
    $id_fichier = $id_fichier[0];

    $lien_miniature = substr($lien, 0, 10)."miniature/mini_".substr($lien, 10);
    unlink($lien_miniature);

    $sql = "DELETE FROM bd_equipement.photo WHERE photo_date_enre = to_timestamp('".$id_fichier."')";
  }
  elseif ($objet == 'pieceJointe') {
    $id_fichier = explode('.', $lien_explode[3]);
    $id_fichier = $id_fichier[0];

    $sql = "DELETE FROM bd_equipement.piece_jointe WHERE piec_join_date_enre = to_timestamp('".$id_fichier."')";
  }
  elseif ($objet == 'supportComm') {
    $id_fichier = explode('.', $lien_explode[2]);
    $id_fichier = $id_fichier[0];

    $sql = "DELETE FROM bd_equipement.support_communication WHERE supp_comm_date_enre = to_timestamp('".$id_fichier."')";
  };

  unlink($lien);

  pg_query($dbConnect, $sql);
  pg_close($dbConnect);
?>
