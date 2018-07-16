<?php
  include("../data/AccessDataBasePgConnect.php"); // Accès à la base de données
  include('../fonction.php'); // Inclus les fonction php


  // Type de Clôture
  $sqlTypeMobilite =
  "SELECT type_mobi_id AS id, type_mobi_libe AS libelle
  FROM bd_equipement.type_mobilite
  WHERE type_mobi_id IN (1, 3)";

  if(isset($_GET['type_mobilite'])):
    $getTypeMobilite = $_GET['type_mobilite'];
  endif;

  $resultatsTypeMobilite = tableau_objet($dbConnect, $sqlTypeMobilite);

  // Type
  $sqlTypeStructure =
  "SELECT type_stru_id AS id, type_stru_libe AS libelle
  FROM bd_equipement.type_structure";

  if(isset($_GET['type_structure'])):
    $getTypeStructure = $_GET['type_structure'];
  endif;

  $resultatsTypeStructure = tableau_objet($dbConnect, $sqlTypeStructure);

  // Dimension
  if(isset($_GET['dimension'])):
    $getDimension = $_GET['dimension'];
  endif;

  // Date d'aménagement
  if(isset($_GET['date_amgt'])):
    $getDate = $_GET['date_amgt'];
  endif;

  // Cadenas Permanant
  if(isset($_GET['cadenasPerm'])):
    $getCadenasPerm = $_GET['cadenasPerm'];
  endif;

  // Etat
  $sql_etats =
  "SELECT etat_zoot_id AS id, etat_zoot_libe AS libelle
  FROM bd_equipement.etat_zootechnie";

  if(isset($_GET['etat'])):
    $getEtat = $_GET['etat'];
  endif;

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


  pg_close($dbConnect); // Fermeture de l'accès à la base de données
?>

<!DOCTYPE HTML>
<html>
  <div class="formTete">
    <img id="fermer" onclick="affiche_masque('#attributs')" src="img/error.png" alt="Fermer"/> <!-- Déclenche la fonction de fermeture de la div -->
    <h2>Barrière</h2>
  </div>
  <div class="formCorps">
    <div id="erreur"></div>
    <table>
      <tr> <!-- Type de mobilité -->
        <td class="label"><label for="type_mobilite">Type de barrière :</label></td>
        <td><select id="type_mobilite" name="type_mobilite">
          <option value="">A Choisir</option>
          <?php foreach ($resultatsTypeMobilite as $typeMobilite): ?>
            <option value="<?=$typeMobilite->id ?>"
            <?php if(isset($getTypeMobilite) && $typeMobilite->id == $getTypeMobilite): ?>
              selected>
            <?php else: ?>
              >
            <?php endif; ?>
          <?=$typeMobilite->libelle ?> </option>
          <?php endforeach; ?>
        </select></td>
      </tr>
      <tr> <!-- Type de structure -->
        <td class="label"><label for="type_structure">Type de structure : </label></td>
        <td><select id="type_structure" name="type_structure">
          <option value="">A Choisir</option>
          <?php foreach ($resultatsTypeStructure as $typeStructure): ?>
            <option value="<?=$typeStructure->id ?>"
            <?php if(isset($getTypeStructure) && $typeStructure->id == $getTypeStructure): ?>
              selected>
            <?php else: ?>
              >
            <?php endif; ?>
          <?=$typeStructure->libelle ?> </option>
          <?php endforeach; ?>
        </select></td>
      </tr>
      <tr> <!-- Dimension -->
        <td class="label"><label for="dimension">Dimension : </label></td>
        <td><input type="number" min="1" max="5" id="dimension" name="dimension"
        <?php if(isset($getDimension)): ?>
          value="<?=$getDimension ?>"
        <?php endif; ?>
        > m</td>
      </tr>
      <tr> <!-- Date de mise en place -->
        <td class="label"><label for="date_amgt">Date de mise en place : </label></td>
        <td><input type="date" id="date_amgt" name="date_amgt"
        <?php if(isset($getDate)): ?>
          value="<?=$getDate ?>"
        <?php endif; ?>
        ></td>
      </tr>
      <tr> <!-- Cadenas Permanant -->
        <td class="label"><label for="cadenasPerm">Cadenas permanant : </label></td>
        <td><label class="cadenasPerm"><input type="radio" id="cadenasPermOui" name="cadenasPerm" value="true"
        <?php if(isset($getCadenasPerm) and $getCadenasPerm == "true"): ?>
        checked
        <?php endif ?>
        > Oui
        <input type="radio" id="cadenasPermNon" name="cadenasPerm" value="false"
        <?php if(isset($getCadenasPerm) and $getCadenasPerm == "false"): ?>
        checked
        <?php endif ?>
        > Non</label></td>
      </tr>
      <tr> <!-- Etat -->
          <td class="label"><label for="etat">Etat de la barrière : </label></td>
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
      <img id="valider" onclick="validation('recAttributs.php', 'attributs', 'barriere', '<?=$getModif?>')" src="img/floppy_disk2.png"/> <!-- Déclanche la fonction d'enregistrement -->
    </fieldset>
  </div>
</html>
