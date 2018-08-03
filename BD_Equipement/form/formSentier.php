<?php
  include("../data/AccessDataBasePgConnect.php"); // Accès à la base de données
  include('../fonction.php'); // Inclus les fonction php


  // Type de Sentier
  $sqlTypeSentier =
  "SELECT type_sent_id AS id, type_sent_libe AS libelle
  FROM bd_equipement.type_sentier";

  if(isset($_GET['type_sentier'])):
    $getTypeSentier = $_GET['type_sentier'];
  endif;

  $resultatsTypeSentier = tableau_objet($dbConnect, $sqlTypeSentier);


  // Type de Cheminement
  $sqlTypeCheminement =
  "SELECT type_chem_id AS id, type_chem_libe AS libelle
  FROM bd_equipement.type_cheminement";

  if(isset($_GET['type_cheminement'])):
    $getTypeCheminement = $_GET['type_cheminement'];
  endif;

  $resultatsTypeCheminement = tableau_objet($dbConnect, $sqlTypeCheminement);


  // Date d'aménagement
  if(isset($_GET['date_amgt'])):
    $getDate = $_GET['date_amgt'];
  endif;


  // Etat
  $sql_etats =
  "SELECT etat_comm_id AS id, etat_comm_libe AS libelle
  FROM bd_equipement.etat_communication";

  if(isset($_GET['etat'])):
    $getEtat = $_GET['etat'];
  endif;


  // Accès PMR
  if(isset($_GET['pmr'])):
    $getAccesPmr = $_GET['pmr'];
  endif;

  $resultats_etats = tableau_objet($dbConnect, $sql_etats);


  // Difficulté
  $sql_difficultes =
  "SELECT diff_id AS id, diff_libe AS libelle
  FROM bd_equipement.difficulte";

  if(isset($_GET['difficulte'])):
    $getDifficulte = $_GET['difficulte'];
  endif;

  $resultats_difficultes = tableau_objet($dbConnect, $sql_difficultes);

  // Supprot de communication
  $sql_suppComm = "SELECT type_supp_comm_id AS id, type_supp_comm_libe AS libelle
  FROM bd_equipement.type_support_communication
  WHERE type_supp_comm_id IN (4, 5, 6)";

  $resultats_supportComm = tableau_objet($dbConnect, $sql_suppComm);


  // Longueur
  if(isset($_GET['longueur'])) {
    $getLongueur = $_GET['longueur'];
  };

  // Commentaire
  if(isset($_GET['commentaire'])) {
    $getCommentaire = $_GET['commentaire'];
  };

  // Si c'est une modification
  if(isset($_GET['clefModif'])) {
    $getModif = $_GET['clefModif'];
  }
  else {
    $getModif = "";
  };

  if ($getModif != '') {
    $sql_lienPlaquette = "SELECT supp_comm_lien AS lien FROM bd_equipement.support_communication WHERE supp_comm_type_supp_comm_id = 1 AND supp_comm_equi_id = " .$getModif;
    $resultats_lienPlaquette = tableau_objet($dbConnect, $sql_lienPlaquette);
    $nbLienPlaquette = count($resultats_lienPlaquette);

    $sql_lienSiteInternet = "SELECT supp_comm_lien AS lien FROM bd_equipement.support_communication WHERE supp_comm_type_supp_comm_id = 2 AND supp_comm_equi_id = " .$getModif;
    $resultats_lienSiteInternet = tableau_objet($dbConnect, $sql_lienSiteInternet);
    $nbLienSiteInternet = count($resultats_lienSiteInternet);

    $sql_lienApplication = "SELECT supp_comm_lien AS lien FROM bd_equipement.support_communication WHERE supp_comm_type_supp_comm_id = 3 AND supp_comm_equi_id = " .$getModif;
    $resultats_lienApplication = tableau_objet($dbConnect, $sql_lienApplication);
    $nbLienApplication = count($resultats_lienApplication);
  }

  $nomTable = creationLiaison($dbConnect);

  pg_close($dbConnect); // fermeture de l'accès à la base de données
?>
<div class="formTete">
  <img id="fermer" onclick="suppr_table_tmp('<?=$nomTable?>'), affiche_masque('#attributs')" src="img/error.png" alt="Fermer"/> <!-- Déclenche la fonction de fermeture de la div -->
  <h2>Sentier</h2>
</div>
<div class="formCorps">
  <div id="erreur"></div>
  <table>
    <tr> <!-- Type de sentier -->
      <td class="label"><label for="type_sentier">Type de sentier : </label></td>
      <td><select id="type_sentier" name="type_sentier">
        <option value="">A Choisir</option>
        <?php foreach ($resultatsTypeSentier as $typeSentier): ?>
          <option value="<?=$typeSentier->id ?>"
          <?php if(isset($getTypeSentier) && $typeSentier->id == $getTypeSentier): ?>
            selected>
          <?php else: ?>
            >
          <?php endif; ?>
        <?=$typeSentier->libelle ?> </option>
        <?php endforeach; ?>
      </select></td>
    </tr>
    <tr> <!-- Type de cheminement -->
      <td class="label"><label for="type_cheminement">Type de cheminement : </label></td>
      <td><select id="type_cheminement" name="type_cheminement">
        <option value="">A Choisir</option>
        <?php foreach ($resultatsTypeCheminement as $typeCheminement): ?>
          <option value="<?=$typeCheminement->id ?>"
          <?php if(isset($getTypeCheminement) && $typeCheminement->id == $getTypeCheminement): ?>
            selected>
          <?php else: ?>
            >
          <?php endif; ?>
        <?=$typeCheminement->libelle ?> </option>
        <?php endforeach; ?>
      </select></td>
    </tr>
    <tr> <!-- Date de mise en place -->
      <td class="label"><label for="date_amgt">Date de mise en place : </label></td>
      <td><input type="date" id="date_amgt" name="date_amgt"
      <?php if(isset($getDate)): ?>
        value="<?=$getDate ?>"
      <?php endif; ?>
      ></td>
    </tr>
    <tr> <!-- Etat du sentier -->
      <td class="label"><label for="etat">État du sentier : </label></td>
      <td><select id="etat" name="etat">
        <option value="">A Choisir</option>
        <?php foreach ($resultats_etats as $etat): ?>
          <option value="<?=$etat->id ?>"
          <?php if(isset($getEtat) && $etat->id == $getEtat): ?>
            selected>
          <?php else: ?>
            >
          <?php endif; ?>
        <?=$etat->libelle ?> </option>
        <?php endforeach; ?>
      </select></td>
    </tr>
    <tr> <!-- Accès PMR -->
      <td class="label"><label for="pmr">Accès PMR : </label></td>
      <td><label class="pmr"><input type="radio" id="pmrOui" name="pmr" value="true"
      <?php if(isset($getAccesPmr) and $getAccesPmr == "true"): ?>
      checked
      <?php endif ?>
      > Oui
      <input type="radio" id="pmrNon" name="pmr" value="false"
      <?php if(isset($getAccesPmr) and $getAccesPmr == "false"): ?>
      checked
      <?php endif ?>
      > Non</label></td>
    </tr>
    <tr> <!-- Difficulté -->
      <td class="label"><label for="difficulte">Difficulté : </label></td>
      <td><select id="difficulte" name="difficulte">
        <option value="">A Choisir</option>
        <?php foreach ($resultats_difficultes as $difficulte): ?>
          <option value="<?=$difficulte->id ?>"
          <?php if(isset($getDifficulte) && $difficulte->id == $getDifficulte): ?>
            selected>
          <?php else: ?>
            >
          <?php endif; ?>
        <?=$difficulte->libelle ?> </option>
        <?php endforeach; ?>
      </select></td>
    </tr>
    <tr> <!-- Support de communication - Insertion -->
      <td class="label"><label for="supportComm">Supports de valorisation : </label></td>
      <td><select id="supportComm" name="supportComm" onchange="choixDoc('supportComm')">
        <option value="">Type à Choisir</option>
        <?php foreach ($resultats_supportComm as $supportComm): ?>
          <option value="<?=$supportComm->id ?>"><?=$supportComm->libelle ?></option>
        <?php endforeach; ?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2" style="text-align: center;">
        <form id="formPlaquette" action="upload.php?tableLiaison=<?=$nomTable?>" method="post" enctype="multipart/form-data">
        	<input type="file" id="plaquette" name="plaquette" accept="image/jpg, image/jpeg, image/x-png, application/pdf"/>
        	<input type="submit" value="Envoyer" onclick="wait('#formPlaquette', '#loadingUploadPlaquette')"/>
        	<span id="loadingUploadPlaquette"></span>
        </form>
        <form id="formSiteInternet" action="upload.php?tableLiaison=<?=$nomTable?>&categorie=2" method="post" enctype="multipart/form-data">
          <input type="text" id="SiteInternet" name="SiteInternet"/>
          <input type="submit" value="Envoyer" onclick="wait('#formSiteInternet', '#loadingUploadingSiteInternet')"/>
          <span id="loadingUploadingSiteInternet"></span>
        </form>
        <form id="formApplication" action="upload.php?tableLiaison=<?=$nomTable?>" method="post" enctype="multipart/form-data">
        	<input type="text" id="application" name="application"/>
        	<input type="submit" value="Envoyer" onclick="wait('#formApplication', '#loadingUploadApplication')"/>
        	<span id="loadingUploadApplication"></span>
        </form>
      </td>
    </tr>
    <?php if (isset($getLongueur)): ?>
      <tr> <!-- Longeur du sentier -->
        <td class="label"><label for="longueur">Longueur : </label></td>
        <td><?=$getLongueur ?> mètre</td>
      </tr>
    <?php endif; ?>
    <tr> <!-- Commentaire -->
      <td colspan="2" class="centre"><textarea id="commentaire" name="commentaire" rows="5" cols="25" placeholder="Saisissez un commentaire"
      <?php if (isset($getCommentaire) && $getCommentaire != 'null'): ?>
        ><?=$getCommentaire ?></textarea>
      <?php else: ?>
        ></textarea>
      <?php endif; ?></td>
    </tr> <!-- Support de communication - Affichage -->
    <?php if ($getModif != ''): ?>
      <?php if ($nbLienPlaquette > 0): ?>
        <tr id="lienPlaquette" class="lienDoc">
          <td colspan="3" style="text-align:center">
            <label>Plaquette</label>
            <br/><a href="http://localhost/BD_Equipement/<?=$resultats_lienPlaquette[0]->lien ?>" data-lightbox="plaquette" data-title="Plaquette">Il y a <?=$nbLienPlaquette ?> Plaquettes.</a>
            <?php for ($i=1; $i < $nbLienPlaquette; $i++): ?>
              <a class="docPlaquette" href="http://localhost/BD_Equipement/<?=$resultats_lienPlaquette[$i]->lien ?>" data-lightbox="plaquette" data-title="Plaquette"/>
            <?php endfor; ?>
          </td>
        </tr>
      <?php endif; ?>
      <?php if ($nbLienSiteInternet > 0): ?>
        <tr id="lienSiteInternet" class="lienDoc">
          <td colspan="3" style="text-align:center">
            <label>Site Internet</label>
            <?php for ($i=0; $i < $nbLienSiteInternet; $i++): ?>
              <br/><a href="<?=$resultats_lienSiteInternet[$i]->lien ?>"><?=$resultats_lienSiteInternet[$i]->lien ?></a>
            <?php endfor; ?>
          </td>
        </tr>
      <?php endif; ?>
      <?php if ($nbLienApplication > 0): ?>
        <tr id="lienApplication" class="lienDoc">
          <td colspan="3" style="text-align:center">
            <label>Application</label>
            <?php for ($i=0; $i < $nbLienApplication; $i++): ?>
              <br/><a href="#"><?=$resultats_lienApplication[$i]->lien ?></a>
            <?php endfor; ?>
          </td>
        </tr>
      <?php endif; ?>
    <?php endif; ?>
  </table>
</div>
<div class="formPied">
  <fieldset>
    <img id="valider" onclick="validation('recAttributs.php', 'attributs', 'sentier', '<?=$getModif?>', '<?=$nomTable ?>')" src="img/floppy_disk2.png" alt="Enregistrer"/> <!-- Déclanche la fonction d'enregistrement -->
  </fieldset>
</div>
