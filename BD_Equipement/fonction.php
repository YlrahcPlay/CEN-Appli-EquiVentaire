<?php

  // Mise en forme de requete
  function tableau_objet($connDB, $sql) {
    $resultats = array();
    $requete = pg_query($connDB,$sql);
    while($donnee = pg_fetch_object($requete))
    {
      array_push($resultats, $donnee);
    }
    return $resultats;
  }

  // Création de la table temporaire de liaison pour les documents
  function creationLiaison($dbConnect) {
    $nomTable = "liaison_".time();
    $sql = "CREATE TABLE bd_equipement.".$nomTable."(
  		liai_id			SERIAL NOT NULL,
  		liai_fich_id	TIMESTAMP,
  		liai_obje		VARCHAR(25),
  		CONSTRAINT prk_constraint_".$nomTable." PRIMARY KEY (liai_id)
  	)WITHOUT OIDS";
    $resultat = pg_query($dbConnect, $sql);

    return $nomTable;
  };

  function liaison($dbConnect, $categorie, $tableLiaison) {
    $sql = "SELECT COUNT(*) AS nb FROM bd_equipement.".$tableLiaison ;
    $res_nb_fichier = pg_query($dbConnect, $sql);
    $obj_nb_fichier = pg_fetch_object($res_nb_fichier);
    $nb_fichier = intval($obj_nb_fichier->nb);

		if ($nb_fichier != 0) {
      if ($categorie == 'panneau') {
        $sql = "SELECT pann_id AS id FROM bd_equipement.panneau ORDER BY pann_date_enre DESC LIMIT 1";
      }
      elseif ($categorie == 'sentier') {
        $sql = "SELECT sent_id AS id FROM bd_equipement.sentier ORDER BY sent_date_enre DESC LIMIT 1";
      };

      $res_id_ref = pg_query($dbConnect, $sql);
      $obj_id_ref = pg_fetch_object($res_id_ref);
      $id_ref = $obj_id_ref->id;

      for ($i=1; $i-1 < $nb_fichier ; $i++) {
        $sql = "SELECT liai_fich_id, liai_obje FROM bd_equipement.".$tableLiaison." WHERE liai_id = ".$i." LIMIT 1";
        $resultats_liaison = tableau_objet($dbConnect, $sql);
        $id_fichier = $resultats_liaison[0]->liai_fich_id;
        $objet = $resultats_liaison[0]->liai_obje;

        if ($objet == 'photo') {
          $sql = "UPDATE bd_equipement.photo SET photo_pann_id = ".$id_ref." WHERE photo_date_enre = '".$id_fichier."'";
        }
        elseif ($objet == 'piece_jointe') {
          $sql = "UPDATE bd_equipement.piece_jointe SET piec_join_pann_id = ".$id_ref." WHERE piec_join_date_enre = '".$id_fichier."'";
        }
        elseif ($objet == 'support_communication') {
    			$sql = "UPDATE bd_equipement.support_communication SET supp_comm_sent_id = ".$id_ref." WHERE supp_comm_date_enre = '".$id_fichier."'";
        };
        pg_query($dbConnect, $sql);
      };
    };

    $sql = "DROP TABLE bd_equipement.".$tableLiaison;
    pg_query($dbConnect, $sql);
  };
?>
