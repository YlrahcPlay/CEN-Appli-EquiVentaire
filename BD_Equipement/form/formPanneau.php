<?php
  include("../data/AccessDataBasePgConnect.php"); // Accès à la base de données
  include('../fonction.php'); // Inclus les fonction php


  // Type
  $sql_types =
  "SELECT type_pann_id AS id, type_pann_libe AS libelle
  FROM bd_equipement.type_panneau";

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

  // Pièce-Jointe
  $sql_pieceJointe =
  "SELECT type_piec_join_id AS id, type_piec_join_libe AS libelle
  FROM bd_equipement.type_piece_jointe";

  $resultats_pieceJointe = tableau_objet($dbConnect, $sql_pieceJointe);


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
    $sql_lienContenu = "SELECT piec_join_lien AS liencontenu FROM bd_equipement.piece_jointe WHERE piec_join_type_piec_join_id = 1 AND piec_join_pann_id = ".$getModif;
    $resultats_lienContenu = tableau_objet($dbConnect, $sql_lienContenu);
    $nbLienContenu = count($resultats_lienContenu);

    $sql_lienFlashCode = "SELECT piec_join_lien AS lienflashcode FROM bd_equipement.piece_jointe WHERE piec_join_type_piec_join_id = 2 AND piec_join_pann_id = ".$getModif;
    $resultats_lienFlashCode = tableau_objet($dbConnect, $sql_lienFlashCode);
    $nbLienFlashCode = count($resultats_lienFlashCode);

    $sql_lienPJSiteInternet = "SELECT piec_join_lien AS liensiteintenet FROM bd_equipement.piece_jointe WHERE piec_join_type_piec_join_id = 3 AND piec_join_pann_id = ".$getModif;
    $resultats_lienPJSiteInternet = tableau_objet($dbConnect, $sql_lienPJSiteInternet);
    $nbLienPJSiteInternet = count($resultats_lienPJSiteInternet);
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
    <tr> <!-- Insérertion de photos -->
      <td class="label"><label for="photo">Photos : </label></td>
      <td colspan="2">
        <form id="formPhoto" action="upload.php?tableLiaison=<?=$nomTable?>" method="post" enctype="multipart/form-data">
        	<input type="file" name="photo" accept="image/jpg, image/jpeg, image/x-png"></input>
        	<input type="submit" value="Envoyer" onclick="wait('#formPhoto', '#loadingUploadPhoto')"></input>
        	<span id="loadingUploadPhoto"></span>
        </form>
      </td>
    </tr>
    <tr> <!-- Insértion des pièces-jointe -->
      <td class="label"><label for="pieceJointe">Pièce-jointes : </label></td>
      <td colspan="2"><select id="pieceJointe" name="pieceJointe" onchange="choixDoc('pieceJointe')">
        <option value="">Type à Choisir</option>
        <?php foreach ($resultats_pieceJointe as $pieceJointe): ?>
          <option value="<?=$pieceJointe->id ?>"><?=$pieceJointe->libelle ?></option>
        <?php endforeach; ?>
      </select></td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center;">
        <form id="formContenu" action="upload.php?tableLiaison=<?=$nomTable?>" method="post" enctype="multipart/form-data">
        	<input type="file" id="contenu" name="contenu" accept="image/jpg, image/jpeg, image/x-png, application/pdf"></input>
        	<input type="submit" value="Envoyer" onclick="wait('#formContenu', '#loadingUploadContenu')"></input>
        	<span id="loadingUploadContenu"></span>
        </form>
        <form id="formFlashCode" action="upload.php?tableLiaison=<?=$nomTable?>" method="post" enctype="multipart/form-data">
        	<input type="file" id="flashCode" name="flashCode" accept="image/jpg, image/jpeg, image/x-png"></input>
        	<input type="submit" value="Envoyer" onclick="wait('#formFlashCode', '#loadingUploadFlashCode')"></input>
        	<span id="loadingUploadFlashCode"></span>
        </form>
        <form id="formPJSiteInternet" action="upload.php?tableLiaison=<?=$nomTable?>" method="post" enctype="multipart/form-data">
          <input type="text" id="PJSiteInternet" name="PJSiteInternet">
          <button type="submit" onclick="wait('#formPJSiteInternet', '#loadingUploadingPJSiteInternet')">Envoyer</button>
          <span id="loadingUploadingPJSiteInternet"></span>
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
    <?php if ($getModif != ''): ?>
      <?php if ($nbLienContenu > 0): ?>
        <tr id="lienContenu" class="lienDoc">
          <td colspan="3" style="text-align:center">
            <label>Contenu</label>
            <br/><a href="http://localhost/BD_Equipement/<?=$resultats_lienContenu[0]->liencontenu ?>" data-lightbox="contenu" data-title="Contenu">Il y a <?=$nbLienContenu ?> élément de contenu.</a>
            <?php for ($i=1; $i < $nbLienContenu; $i++): ?>
              <a class="docContenu" href="http://localhost/BD_Equipement/<?=$resultats_lienContenu[$i]->liencontenu ?>" data-lightbox="contenu" data-title="Contenu"/>
            <?php endfor; ?>
          </td>
        </tr>
      <?php endif; ?>
      <?php if ($nbLienFlashCode > 0): ?>
        <tr id="lienFlashCode" class="lienDoc">
          <td colspan="3" style="text-align:center">
            <label>FlashCode</label>
            <br/><a href="http://localhost/BD_Equipement/<?=$resultats_lienFlashCode[0]->lienflashcode ?>" data-lightbox="flashCode" data-title="FlashCode">Il y a <?=$nbLienFlashCode ?> flash-code.</a>
            <?php for ($i=1; $i < $nbLienFlashCode; $i++): ?>
              <a class="docFlashCode" href="http://localhost/BD_Equipement/<?=$resultats_lienFlashCode[$i]->lienflashcode ?>" data-lightbox="flashCode" data-title="FlashCode"/>
            <?php endfor; ?>
          </td>
        </tr>
      <?php endif; ?>
      <?php if ($nbLienPJSiteInternet > 0): ?>
        <tr id="lienPJSiteInternet" class="lienDoc">
          <td colspan="3" style="text-align:center">
            <label>Site Internet</label>
            <?php for ($i=0; $i < $nbLienPJSiteInternet; $i++): ?>
              <br/><a href="<?=$resultats_lienPJSiteInternet[$i]->liensiteintenet ?>"><?=$resultats_lienPJSiteInternet[$i]->liensiteintenet ?></a>
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
