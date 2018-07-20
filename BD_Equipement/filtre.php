<?php
  include("data/AccessDataBasePgConnect.php");


  //// Sites ////
  $sql_sites = "SELECT ".'"ID"'." AS code_site, ".'"Nom_Site"'." AS nom_site, commune FROM md.site_cenhn WHERE categorie = 1 ORDER BY commune, nom_site";
  $resultat_sites = tableau_objet($dbConnect, $sql_sites);


  //// Catégories ////
  $sql_categories = "SELECT cate_id, cate_libe FROM bd_equipement.categorie ORDER BY cate_id";
  $resultat_categories = tableau_objet($dbConnect, $sql_categories);


  //// Ferme la connexion à la BD ////
  pg_close($dbConnect);
?>
<div class="filtre">
  <!-- Séléction du site -->
  <select id="site" onclick="affichePdf(), majsite(), drawing(), majcategorie()">
    <option value="tous" selected>Choisir un Site</option>
    <?php foreach ($resultat_sites as $site): ?>
      <option value="<?=$site->code_site ?>"><?=$site->commune ?> - <?=$site->nom_site ?></option>
    <?php endforeach; ?>
  </select>

  <!-- Séléction de la catégorie -->
  <select id="categorie" onchange="majcategorie(), drawing()">
    <option value="tous">Choisir une Catégorie</option>
    <!-- <?php foreach ($resultat_categories as $categorie): ?>
      <option value="<?=$categorie->cate_id ?>"><?=$categorie->cate_libe ?></option>
    <?php endforeach; ?> -->
    <optgroup label="Valorisation">
      <?php for ($i=1; $i <= 3 ; $i++): ?>
        <option value="<?=$resultat_categories[$i-1]->cate_id ?>"><?=$resultat_categories[$i-1]->cate_libe ?></option>
      <?php endfor; ?>
    </optgroup>
    <optgroup label="Gestion">
      <?php for ($i=4; $i <= 6 ; $i++): ?>
        <option value="<?=$resultat_categories[$i-1]->cate_id ?>"><?=$resultat_categories[$i-1]->cate_libe ?></option>
      <?php endfor; ?>
    </optgroup>
  </select>
</div>
