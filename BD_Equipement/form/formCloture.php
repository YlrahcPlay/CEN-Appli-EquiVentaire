<?php
  include("../data/AccessDataBasePgConnect.php"); // Accès à la base de données
  include('../fonction.php'); // Inclus les fonction php


  // Type de Clôture
  $sqlTypeMobilite =
  "SELECT type_mobi_id AS id, type_mobi_libe AS libelle
  FROM bd_equipement.type_mobilite
  ORDER BY libelle ASC";

  if(isset($_GET['type_mobilite'])):
    $getTypeMobilite = $_GET['type_mobilite'];
  endif;

  $resultatsTypeMobilite = tableau_objet($dbConnect, $sqlTypeMobilite);

  // Type de fils
  $sqlTypeFils =
  "SELECT type_fils_id AS id, type_fils_libe AS libelle
  FROM bd_equipement.type_fils
  ORDER BY libelle ASC";

  if(isset($_GET['type_fils'])):
    $getTypeFils = $_GET['type_fils'];
  endif;

  $resultatsTypeFils = tableau_objet($dbConnect, $sqlTypeFils);

  // Type de poteau
  $sqlTypePoteau =
  "SELECT type_pote_id AS id, type_pote_libe AS libelle
  FROM bd_equipement.type_poteau
  ORDER BY libelle ASC";

  if(isset($_GET['type_poteau'])):
    $getTypePoteau = $_GET['type_poteau'];
  endif;

  $resultatsTypePoteau = tableau_objet($dbConnect, $sqlTypePoteau);

  // Date d'aménagement
  if(isset($_GET['date_amgt'])):
    $getDate = $_GET['date_amgt'];
  endif;

  // Partiel
  if(isset($_GET['partiel'])):
    $getClotPartiel = $_GET['partiel'];
  endif;

  // Etat
  $sql_etats =
  "SELECT etat_zoot_id AS id, etat_zoot_libe AS libelle
  FROM bd_equipement.etat_zootechnie";

  if(isset($_GET['etat'])):
    $getEtat = $_GET['etat'];
  endif;

  $resultats_etats = tableau_objet($dbConnect, $sql_etats);

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


  pg_close($dbConnect); // Fermeture de l'accès à la base de données
?>

<!DOCTYPE HTML>
<html>
  <div class="formTete">
    <img id="fermer" onclick="affiche_masque('#attributs')" src="img/error.png" alt="Fermer"/> <!-- Déclenche la fonction de fermeture de la div -->
    <h2>Clôture</h2>
  </div>
  <div class="formCorps">
    <div id="erreur"></div>
    <table>
      <tr> <!-- Type de mobilité -->
        <td class="label"><label for="type_mobilite">Type de clôture :</label></td>
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
      <tr> <!-- Type de fils -->
        <td class="label"><label for="type_fils">Type de fils dominant : </label></td>
        <td><select id="type_fils" name="type_fils">
          <option value="">A Choisir</option>
          <?php foreach ($resultatsTypeFils as $typeFils): ?>
            <option value="<?=$typeFils->id ?>"
            <?php if(isset($getTypeFils) && $typeFils->id == $getTypeFils): ?>
              selected>
            <?php else: ?>
              >
            <?php endif; ?>
          <?=$typeFils->libelle ?> </option>
          <?php endforeach; ?>
        </select></td>
      </tr>
      <tr> <!-- Type de poteau -->
        <td class="label"><label for="type_poteau">Type de poteau : </label></td>
        <td><select id="type_poteau" name="type_poteau">
          <option value="">A Choisir</option>
          <?php foreach ($resultatsTypePoteau as $typePoteau): ?>
            <option value="<?=$typePoteau->id ?>"
            <?php if(isset($getTypePoteau) && $typePoteau->id == $getTypePoteau): ?>
              selected>
            <?php else: ?>
              >
            <?php endif; ?>
          <?=$typePoteau->libelle ?> </option>
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
      <tr>  <!-- Clôture partiel -->
        <td class="label"><label for="partiel">Clôture partiel : </label></td>
        <td><label class="partiel"><input type="radio" id="partielOui" name="partiel" value="true"
        <?php if(isset($getClotPartiel) and $getClotPartiel == "true"): ?>
        checked
        <?php endif ?>
        > Oui
        <input type="radio" id="partielNon" name="partiel" value="false"
        <?php if(isset($getClotPartiel) and $getClotPartiel == "false"): ?>
        checked
        <?php endif ?>
        > Non </label></td>
      </tr>
      <tr>  <!-- Etat de la clôture -->
        <td class="label"><label for="etat">Etat de la clôture : </label></td>
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
      <?php if (isset($getLongueur)): ?>
        <tr> <!-- Longeur de la clôture -->
          <td class="label"><label for="longueur">Longueur : </label></td>
          <td><?=$getLongueur ?> mètre</td>
        </tr>
      <?php endif; ?>
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
      <img id="valider" onclick="validation('recAttributs.php', 'attributs', 'cloture', '<?=$getModif?>')" src="img/floppy_disk2.png"/> <!-- Déclanche la fonction d'enregistrement -->
    </fieldset>
  </div>
</html>
