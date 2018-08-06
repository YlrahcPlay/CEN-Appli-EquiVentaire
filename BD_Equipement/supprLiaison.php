<?php
  include('data/AccessDataBasePgConnect.php'); // Accès à la base de données
  include('fonction.php'); // Insertion des fonctions

  $tableLiaison = $_POST['tableLiaison'];
  // $tableLiaison = $_GET['tableLiaison'];

  $sql = "SELECT COUNT(*) AS nb FROM bd_equipement.".$tableLiaison ;
  $res_nb_fichier = pg_query($dbConnect, $sql);
  $obj_nb_fichier = pg_fetch_object($res_nb_fichier);
  $nb_fichier = intval($obj_nb_fichier->nb);

  if ($nb_fichier != 0) {
    for ($i=1; $i-1 < $nb_fichier ; $i++) {
      $sql = "SELECT liai_fich_id, liai_obje FROM bd_equipement.".$tableLiaison." WHERE liai_id = ".$i." LIMIT 1";
      $resultats_liaison = tableau_objet($dbConnect, $sql);
      $id_fichier = $resultats_liaison[0]->liai_fich_id;
      $objet = $resultats_liaison[0]->liai_obje;


      if ($objet == 'photo') {
        $sql = "SELECT supp_comm_lien FROM bd_equipement.support_communication WHERE supp_comm_date_enre = '".$id_fichier."'";
        $resultats_photo = tableau_objet($dbConnect, $sql);
        $lien = $resultats_photo[0]->photo_lien;

        $lien_explode = explode('/', $lien);
        $lien_miniature = $lien_explode[0]."/".$lien_explode[1]."/miniature/mini_".$lien_explode[2];

        unlink($lien_miniature);
        unlink($lien);
      }
      else {
        $sql = "SELECT supp_comm_lien, supp_comm_type_supp_comm_id AS type_supp_comm_id FROM bd_equipement.support_communication WHERE supp_comm_date_enre = '".$id_fichier."'";
        $resultats_supportComm = tableau_objet($dbConnect, $sql);
        $lien = $resultats_supportComm[0]->supp_comm_lien;
        $objet = $resultats_supportComm[0]->type_supp_comm_id;

        if (in_array($objet, array(2, 3, 4))) {
          unlink($lien);
        }
      };

      $sql = "DELETE FROM bd_equipement.support_communication WHERE supp_comm_date_enre = '".$id_fichier."'";
      pg_query($dbConnect, $sql);
    };
  };

  $sql = "DROP TABLE bd_equipement.".$tableLiaison;
  pg_query($dbConnect, $sql);

  pg_close($dbConnect);

  echo("Success !!!!")
?>
