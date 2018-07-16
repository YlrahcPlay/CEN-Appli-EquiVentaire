<?php
  include("../data/AccessDataBasePgConnect.php"); // Accès à la base de données
  include('../fonction.php'); // Inclus les fonction php


  // Type de Sentier
  $sqlType2ACommunication =
  "SELECT type_autr_amen_comm_id AS id, type_autr_amen_comm_libe AS libelle
  FROM bd_equipement.type_autre_amenagement_communication";

  if(isset($_GET['type_amenagement'])):
    $getType2AComm = $_GET['type_amenagement'];
  endif;

  $resultatsType2AComm = tableau_objet($dbConnect, $sqlType2ACommunication);

  // Date d'aménagement
  if(isset($_GET['date_amgt'])):
    $getDate = $_GET['date_amgt'];
  endif;

  // Etat
  $sql_etats =
  "SELECT etat_comm_id AS id, etat_comm_libe AS libelle
  FROM bd_equipement.etat_communication";

  if(isset($_GET['etat'])) {
    $getEtat = $_GET['etat'];
  };

  $resultats_etats = tableau_objet($dbConnect, $sql_etats);

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


  pg_close($dbConnect); // fermeture de l'accés à la base de données
?>
<div class="formTete">
  <img id="fermer" onclick="affiche_masque('#attributs')" src="img/error.png" alt="Fermer"/> <!-- Déclenche la fonction de fermeture de la div -->
  <h2>Aménagement de Communication</h2>
</div>
<div class="formCorps">
  <div id="erreur"></div>
  <table>
    <tr> <!-- Type d'aménagement -->
      <td class="label"><label for="type_amenagement">Type de l'aménagement :</label></td>
      <td><select id="type_amenagement" name="type_amenagement">
        <option value="">A Choisir</option>
        <?php foreach ($resultatsType2AComm as $type2AComm): ?>
          <option value="<?=$type2AComm->id ?>"
          <?php if(isset($getType2AComm) && $type2AComm->id == $getType2AComm): ?>
            selected>
          <?php else: ?>
            >
          <?php endif; ?>
        <?=$type2AComm->libelle ?> </option>
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
    <tr> <!-- État de l'aménagement -->
      <td class="label"><label for="etat">État de l'aménagement : </label></td>
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
    <tr> <!-- Commentaire -->
      <td colspan="3" class="centre"><textarea id="commentaire" name="commentaire" rows="5" cols="25" placeholder="Saisissez un commentaire"
      <?php if (isset($getCommentaire) && $getCommentaire != 'null'): ?>
        ><?=$getCommentaire ?></textarea>
      <?php else: ?>
        ></textarea>
      <?php endif; ?></td>
    </tr>
  </table>
</div>
<div class="formPied">
  <fieldset>
    <img id="valider" onclick="validation('recAttributs.php', 'attributs', 'autreamgtcomm', '<?=$getModif?>'); majcategorie()" src="img/floppy_disk2.png"/> <!-- Déclanche la fonction d'enregistrement -->
  </fieldset>
</div>
