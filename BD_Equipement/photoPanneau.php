<?php
  include('data/AccessDataBasePgConnect.php');
  include('fonction.php');

  $id_ref = $_GET['id_panneau'];

  $sql = "SELECT supp_comm_lien AS lien FROM bd_equipement.support_communication WHERE supp_comm_type_supp_comm_id = 1 AND supp_comm_cate_id = 1 AND supp_comm_equi_id = ".$id_ref;
  $resultat_photos = tableau_objet($dbConnect, $sql);

  pg_close($dbConnect);
?>
<?php if (count($resultat_photos) > 0): ?>
  <div class="diapo">
    <ul class="diaporama">
      <?php for ($i=0; $i < count($resultat_photos); $i++): ?>
        <?php
        $lien_explode = explode('/', $resultat_photos[$i]->lien);
          $idPhoto = $lien_explode[2];
          $lien = $lien_explode[0]."/".$lien_explode[1]."/miniature/mini_".$idPhoto;
        ?>
        <!-- <li><a href="http://localhost/BD_Equipement/<?=$resultat_photos[$i]->lien ?>" data-lightbox="photo" data-title="Photo"><img src="<?=$lien ?>"/></a></li> -->
        <li><a href="#" onclick="supprImg('<?=$lien ?>')"><img src="<?=$lien ?>"/></a></li>
      <?php endfor; ?>
    </ul>
  </div>
<?php endif; ?>
