<?php
  include('data/AccessDataBasePgConnect.php'); // Accès à la base de données
  include('fonction.php'); // Insertion des fonctions

  $tableLiaison = $_POST['tableLiaison'];

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
        $sql = "SELECT photo_lien FROM bd_equipement.photo WHERE photo_date_enre = '".$id_fichier."'";
        $resultats_photo = tableau_objet($dbConnect, $sql);
        $lien = $resultats_photo[0]->photo_lien;

        $lien_miniature = substr($lien, 0, 10)."miniature/mini_".substr($lien, 10);

        unlink($lien_miniature);
        unlink($lien);

        $sql = "DELETE FROM bd_equipement.photo WHERE photo_date_enre = '".$id_fichier."'";
      }
      elseif ($objet == 'piece_jointe') {
        $sql = "SELECT piec_join_lien, piec_join_type_piec_join_id AS type_piec_join FROM bd_equipement.piece_jointe WHERE piec_join_date_enre = '".$id_fichier."'";
        $resultats_pieceJointe = tableau_objet($dbConnect, $sql);
        $lien = $resultats_pieceJointe[0]->piec_join_lien;
        $objet = $resultats_pieceJointe[0]->type_piec_join;

        if ($objet != 3) {
          unlink($lien);
        };

        $sql = "DELETE FROM bd_equipement.piece_jointe WHERE piec_join_date_enre = '".$id_fichier."'";
      }
      elseif ($objet == 'support_communication') {
        $sql = "SELECT supp_comm_lien, supp_comm_type_supp_comm_id AS type_supp_comm_id FROM bd_equipement.support_communication WHERE supp_comm_date_enre = '".$id_fichier."'";
        $resultats_supportComm = tableau_objet($dbConnect, $sql);
        $lien = $resultats_supportComm[0]->supp_comm_lien;
        $objet = $resultats_supportComm[0]->type_supp_comm_id;

        if ($objet == 1) {
          unlink($lien);
        }

        $sql = "DELETE FROM bd_equipement.support_communication WHERE supp_comm_date_enre = '".$id_fichier."'";
      };
      pg_query($dbConnect, $sql);
    };
  };

  $sql = "DROP TABLE bd_equipement.".$tableLiaison;
  pg_query($dbConnect, $sql);

  pg_close($dbConnect);
?>
