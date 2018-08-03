<?php
  include('data/AccessDataBasePgConnect.php'); // Accès à la base de données

  $lienFull = $_POST['lien'];

  $lien = strstr($lienFull, 'doc/');
  $lien_explode = explode('/', $lien);
  $objet = $lien_explode[1];

  if ($objet == 'photo') {
    $id_fichier = explode('.', $lien_explode[2]);
    $id_fichier = $id_fichier[0];

    $lien_miniature = $lien_explode[0]."/".$lien_explode[1]."/miniature/mini_".$lien_explode[2];
    unlink($lien_miniature);

    $sql = "DELETE FROM bd_equipement.support_communication WHERE supp_comm_date_enre = to_timestamp('".$id_fichier."')";
  }
  else {
    $id_fichier = explode('.', $lien_explode[2]);
    $id_fichier = $id_fichier[0];

    $sql = "DELETE FROM bd_equipement.support_communication WHERE supp_comm_date_enre = to_timestamp('".$id_fichier."')";
  };

  unlink($lien);

  pg_query($dbConnect, $sql);
  pg_close($dbConnect);
?>
