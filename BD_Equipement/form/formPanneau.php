<?php
  include("../data/AccessDataBasePgConnect.php"); // Accès à la base de données
  include('../fonction.php'); // Inclus les fonction php


  // Type
  $sql_types =
  "SELECT type_pann_id AS id, type_pann_libe AS libelle
  FROM bd_equipement.type_panneau
  ORDER BY libelle ASC";

  if(isset($_GET['type'])) {
    $getType = $_GET['type'];
  };

  $resultats_types = tableau_objet($dbConnect, $sql_types);


  // Précision
  if(isset($_GET['precision'])) {
    $getPrecision = $_GET['precision'];
    if ($getPrecision == 'null') {
      $getPrecision = '';
    };
  };


  // Date d'aménagement
  if(isset($_GET['date_amgt'])){
    $getDate = $_GET['date_amgt'];
  };


  // Etat
  $sql_etats =
  "SELECT etat_comm_id AS id, etat_comm_libe AS libelle
  FROM bd_equipement.etat_communication";

  if(isset($_GET['etat'])) {
    $getEtat = $_GET['etat'];
  };

  $resultats_etats = tableau_objet($dbConnect, $sql_etats);

  // Support de communication
  $sql_suppComm = "SELECT type_supp_comm_id AS id, type_supp_comm_libe AS libelle
  FROM bd_equipement.type_support_communication
  WHERE type_supp_comm_id IN (2, 3, 5)
  ORDER BY libelle ASC";

  $resultats_supportComm = tableau_objet($dbConnect, $sql_suppComm);


  // Commentaire
  if(isset($_GET['commentaire'])) {
    $getCommentaire = $_GET['commentaire'];
  };


  // Si c'est une modification réucpération de l'ID
  if(isset($_GET['clefModif'])) {
    $getModif = $_GET['clefModif'];
  }
  else {
    $getModif = "";
  };


  if ($getModif != '') {
    $sql_lienContenu = "SELECT supp_comm_lien AS lien FROM bd_equipement.support_communication WHERE supp_comm_type_supp_comm_id = 2 AND supp_comm_equi_id = ".$getModif;
    $resultats_lienContenu = tableau_objet($dbConnect, $sql_lienContenu);
    $nbLienContenu = count($resultats_lienContenu);
    $LienContenuJPG = array();
    $LienContenuPDF = array();
    for ($i=0; $i < $nbLienContenu; $i++) {
      if (strrchr($resultats_lienContenu[$i]->lien, '.') == '.jpg') {
        array_push($LienContenuJPG, $resultats_lienContenu[$i]->lien);
      }
      elseif (strrchr($resultats_lienContenu[$i]->lien, '.') == '.pdf') {
        array_push($LienContenuPDF, $resultats_lienContenu[$i]->lien);
      };
    };
    $nbLienContenuJPG = count($LienContenuJPG);
    $nbLienContenuPDF = count($LienContenuPDF);

    $sql_lienFlashCode = "SELECT supp_comm_lien AS lien FROM bd_equipement.support_communication WHERE supp_comm_type_supp_comm_id = 3 AND supp_comm_equi_id = ".$getModif;
    $resultats_lienFlashCode = tableau_objet($dbConnect, $sql_lienFlashCode);
    $nbLienFlashCode = count($resultats_lienFlashCode);
    $LienFlashCodeJPG = array();
    $LienFlashCodePDF = array();
    for ($i=0; $i < $nbLienFlashCode; $i++) {
      if (strrchr($resultats_lienFlashCode[$i]->lien, '.') == '.jpg') {
        array_push($LienFlashCodeJPG, $resultats_lienFlashCode[$i]->lien);
      }
      elseif (strrchr($resultats_lienFlashCode[$i]->lien, '.') == '.pdf') {
        array_push($LienFlashCodePDF, $resultats_lienFlashCode[$i]->lien);
      };
    };
    $nbLienFlashCodeJPG = count($LienFlashCodeJPG);
    $nbLienFlashCodePDF = count($LienFlashCodePDF);

    $sql_lienSiteInternet = "SELECT supp_comm_lien AS liensiteintenet FROM bd_equipement.support_communication WHERE supp_comm_type_supp_comm_id = 5 AND supp_comm_equi_id = ".$getModif;
    $resultats_lienSiteInternet = tableau_objet($dbConnect, $sql_lienSiteInternet);
    $nbLienSiteInternet = count($resultats_lienSiteInternet);
  };

  $nomTable = creationLiaison($dbConnect);

  pg_close($dbConnect); // Fermeture de l'accès à la base de données
?>
<div class="formTete">
  <img id="fermer" onclick="suppr_table_tmp('<?=$nomTable?>'), affiche_masque('#attributs')" src="img/error.png"/ alt="Fermer"> <!-- Déclenche la fonction de fermeture de la div -->
  <h2>Panneau</h2>
</div>
<div class="formCorps">
  <div id="erreur"></div> <!-- Lieu d'affichage en cas d'erreur -->
  <table>
    <tr> <!-- Type de panneau -->
      <td class="label"><label for="type">Type de panneau : </label></td>
      <td colspan="2"><select id="type" name="type" onchange="precision()">
        <option value="">A Choisir</option>
        <?php foreach ($resultats_types as $type): ?>
          <option value="<?=$type->id ?>"
          <?php if(isset($getType) && $type->id == $getType): ?>
            selected>
          <?php else: ?>
            >
          <?php endif; ?>
          <?=$type->libelle ?></option>
        <?php endforeach; ?>
      </select>

      <?php if (isset($getType) && $getType == 5): ?>
        <span id="precision" style="display:inline">
        <input type="text" name="precision" placeholder="Précision"
        <?php if(isset($getPrecision)): ?>
          value="<?=$getPrecision ?>">
        <?php else: ?>
          >
        <?php endif; ?>
      </span>
      <?php else: ?>
        <span id="precision">
        <input type="text" name="precision" placeholder="Précision"
        <?php if(isset($getPrecision)): ?>
          value="<?=$getPrecision ?>">
        <?php else: ?>
          >
        <?php endif; ?>
      </span>
      <?php endif; ?>
      </td>
    </tr>
    <tr> <!-- Date de mise en place -->
      <td class="label"><label for="date_amgt">Date de mise en place : </label></td>
      <td colspan="2"><input type="date" id="date_amgt" name="date_amgt"
      <?php if(isset($getDate)): ?>
        value="<?=$getDate ?>"
      <?php endif; ?>
      ></td>
    </tr>
    <tr> <!-- État du panneau -->
      <td class="label"><label for="etat">État du panneau : </label></td>
      <td colspan="2"><select id="etat" name="etat">
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
    <tr> <!-- Photos - Insérertion -->
      <td class="label"><label for="photo">Photos : </label></td>
      <td colspan="2">
        <form id="formPhoto" action="upload.php?tableLiaison=<?=$nomTable?>" method="post" enctype="multipart/form-data">
        	<input type="file" name="photo" accept="image/jpg, image/jpeg, image/x-png"></input>
        	<input type="submit" value="Envoyer" onclick="wait('#formPhoto', '#loadingUploadPhoto')"></input>
        	<span id="loadingUploadPhoto"></span>
        </form>
      </td>
    </tr>
    <tr> <!-- Support - Insértion -->
      <td class="label"><label for="supportComm">Supports de valorisation: </label></td>
      <td colspan="2"><select id="supportComm" name="supportComm" onchange="choixDoc('panneau')">
        <option value="">Type à Choisir</option>
        <?php foreach ($resultats_supportComm as $supportComm): ?>
          <option value="<?=$supportComm->id ?>"><?=$supportComm->libelle ?></option>
        <?php endforeach; ?>
      </select></td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center;">
        <form id="formContenu" action="upload.php?tableLiaison=<?=$nomTable?>&categorie=1" method="post" enctype="multipart/form-data">
        	<input type="file" id="contenu" name="contenu" accept="image/jpg, image/jpeg, image/x-png, application/pdf"></input>
        	<input type="submit" value="Envoyer" onclick="wait('#formContenu', '#loadingUploadContenu')"></input>
        	<span id="loadingUploadContenu"></span>
        </form>
        <form id="formFlashCode" action="upload.php?tableLiaison=<?=$nomTable?>" method="post" enctype="multipart/form-data">
        	<input type="file" id="flashCode" name="flashCode" accept="image/jpg, image/jpeg, image/x-png"></input>
        	<input type="submit" value="Envoyer" onclick="wait('#formFlashCode', '#loadingUploadFlashCode')"></input>
        	<span id="loadingUploadFlashCode"></span>
        </form>
        <form id="formSiteInternet" action="upload.php?tableLiaison=<?=$nomTable?>&categorie=1" method="post" enctype="multipart/form-data">
          <input type="text" id="SiteInternet" name="SiteInternet">
          <button type="submit" onclick="wait('#formSiteInternet', '#loadingUploadingSiteInternet')">Envoyer</button>
          <p>Exemple : "http://www.MonSite.com"</p>
          <span id="loadingUploadingSiteInternet"></span>
        </form>
      </td>
    </tr>
    <tr> <!-- Commentaire -->
      <td colspan="3" class="centre"><textarea id="commentaire" name="commentaire" rows="5" cols="25" placeholder="Saisissez un commentaire"
      <?php if (isset($getCommentaire) && $getCommentaire != 'null'): ?>
        ><?=$getCommentaire ?></textarea>
      <?php else: ?>
        ></textarea>
      <?php endif; ?></td>
    </tr>
    <?php if ($getModif != ''): ?> <!-- Pièces-Jointe - Affichage -->
      <?php if ($nbLienContenu > 0): ?>
        <tr id="lienContenu" class="lienDoc">
          <td colspan="3" style="text-align:center">
            <label>Contenu</label>
            <p>Il y a <?=$nbLienContenu ?> élément de contenu.</p>
            <?php if ($nbLienContenuJPG != 0): ?>
              <br/><a href="http://localhost/BD_Equipement/<?=$LienContenuJPG[0] ?>" data-lightbox="contenu" data-title="Contenu">Il y a <?=$nbLienContenuJPG ?> images associées.</a>
              <?php for ($i=1; $i < $nbLienContenuJPG; $i++): ?>
                <a class="docContenu" href="http://localhost/BD_Equipement/<?=$LienContenuJPG[$i] ?>" data-lightbox="contenu" data-title="Contenu"/>
              <?php endfor; ?>
            <?php endif; ?>
            <?php if ($nbLienContenuPDF != 0): ?>
              <?php for ($i=0; $i < $nbLienContenuPDF; $i++): ?>
                <a class="lienPDF" href="#" onclick="openFile('<?=$LienContenuPDF[$i] ?>')">Contenu pdf n°<?=$i+1 ?></a>
              <?php endfor; ?>
            <?php endif; ?>
          </td>
        </tr>
      <?php endif; ?>
      <?php if ($nbLienFlashCode > 0): ?>
        <tr id="lienFlashCode" class="lienDoc">
          <td colspan="3" style="text-align:center">
            <label>FlashCode</label>
            <p>Il y a <?=$nbLienFlashCode ?> flashcode.</p>
            <?php if ($nbLienFlashCodeJPG != 0): ?>
              <br/><a href="http://localhost/BD_Equipement/<?=$LienFlashCodeJPG[0] ?>" data-lightbox="flashCode" data-title="FlashCode">Il y a <?=$nbLienFlashCodeJPG ?> images associées.</a>
              <?php for ($i=1; $i < $nbLienFlashCodeJPG; $i++): ?>
                <a class="docContenu" href="http://localhost/BD_Equipement/<?=$LienFlashCodeJPG[$i] ?>" data-lightbox="flashCode" data-title="FlashCode"/>
              <?php endfor; ?>
            <?php endif; ?>
            <?php if ($nbLienFlashCodePDF != 0): ?>
              <?php for ($i=0; $i < $nbLienFlashCodePDF; $i++): ?>
                <a class="lienPDF" href="#" onclick="openFile('<?=$LienFlashCodePDF[$i] ?>')">Flashcode pdf n°<?=$i+1 ?></a>
              <?php endfor; ?>
            <?php endif; ?>
          </td>
        </tr>
      <?php endif; ?>
      <?php if ($nbLienSiteInternet > 0): ?>
        <tr id="lienSiteInternet" class="lienDoc">
          <td colspan="3" style="text-align:center">
            <label>Site Internet</label>
            <?php for ($i=0; $i < $nbLienSiteInternet; $i++): ?>
              <br/><a class="lienPDF" href="#" onclick="openFile('<?=$resultats_lienSiteInternet[$i]->liensiteintenet ?>')"><?=$resultats_lienSiteInternet[$i]->liensiteintenet ?></a>
            <?php endfor; ?>
          </td>
        </tr>
      <?php endif; ?>
    <?php endif; ?>
  </table>
</div>
<div class="formPied">
  <fieldset>
    <img id="valider" onclick="validation('recAttributs.php', 'attributs', 'panneau', '<?=$getModif ?>', '<?=$nomTable ?>')" src="img/floppy_disk2.png" alt="Enregistrer"/> <!-- Déclanche la fonction d'enregistrement -->
  </fieldset>
</div>
