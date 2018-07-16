<?php
  include('data/AccessDataBasePgConnect.php');
  include('fonction.php');

  $id_ref = $_GET['id_panneau'];

  $sql = "SELECT photo_lien AS lien FROM bd_equipement.photo WHERE photo_pann_id = ".$id_ref;
  $resultat_photos = tableau_objet($dbConnect, $sql);

  pg_close($dbConnect);
?>
<?php if (count($resultat_photos) > 0): ?>
  <div class="diapo">
    <ul class="diaporama">
      <?php for ($i=0; $i < count($resultat_photos); $i++): ?>
        <?php
          $idPhoto = substr($resultat_photos[$i]->lien, 10);
          $lien = substr($resultat_photos[$i]->lien, 0, 10) ."miniature/mini_".$idPhoto;
        ?>
        <li><a href="http://localhost/BD_Equipement/<?=$resultat_photos[$i]->lien ?>" data-lightbox="photo" data-title="Photo"><img src="<?=$lien ?>"/></a></li>
      <?php endfor; ?>
    </ul>
  </div>
<?php endif; ?>
