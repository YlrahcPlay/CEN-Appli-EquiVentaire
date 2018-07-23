<?php ob_start(); ?>
<style>
  h1 {
    text-align: center;
  }

.aucun {
  text-align: center;
  color: #ff0000;
}

  p {
    margin: 0px;
  }

  .souligne {
    margin-bottom: 5px;
    text-decoration: underline;
  }

  .nb {
    margin-left: 25px
  }

  table, th, td {
    margin-left: 25px;
    border-collapse: collapse;
    border: 1px solid black;
    text-align: center;
  }

  th, td {
    padding: 5px;
  }

  .total {
    margin: 10px 0;
    font-style: italic;
  }
</style>
<?php
  include("data/AccessDataBasePgConnect.php"); // Accès à la base de données
  include_once("fonction.php");

  $site = $_GET['site'];


  $sql = "SELECT commune || ' - ' || ".'"Nom_Site"'." AS site FROM md.site_cenhn WHERE ".'"ID"'." = '".$site."'";
  $req_nom_site = pg_query($dbConnect, $sql);
  $nom_site = pg_fetch_object($req_nom_site);
  $nom_site = $nom_site->site;

  $sql = "SELECT COUNT(*) FROM bd_equipement.panneau WHERE pann_site_cen_id = '".$site."'";
  $req_nb_panneau = pg_query($dbConnect, $sql);
  $nb_panneau = pg_fetch_object($req_nb_panneau);
  $nb_panneau = $nb_panneau->count;

  $sql = "SELECT COUNT(*) FROM bd_equipement.sentier WHERE sent_site_cen_id = '".$site."'";
  $req_nb_sentier = pg_query($dbConnect, $sql);
  $nb_sentier = pg_fetch_object($req_nb_sentier);
  $nb_sentier = $nb_sentier->count;

  $sql = "SELECT COUNT(*) FROM bd_equipement.autre_amenagement_communication WHERE autr_amen_comm_site_cen_id = '".$site."'";
  $req_nb_amgtValo = pg_query($dbConnect, $sql);
  $nb_amgtValo = pg_fetch_object($req_nb_amgtValo);
  $nb_amgtValo = $nb_amgtValo->count;

  $sql = "SELECT COUNT(*) FROM bd_equipement.cloture WHERE clot_site_cen_id = '".$site."'";
  $req_nb_cloture = pg_query($dbConnect, $sql);
  $nb_cloture = pg_fetch_object($req_nb_cloture);
  $nb_cloture = $nb_cloture->count;

  $sql = "SELECT COUNT(*) FROM bd_equipement.barriere WHERE barr_site_cen_id = '".$site."'";
  $req_nb_barriere = pg_query($dbConnect, $sql);
  $nb_barriere = pg_fetch_object($req_nb_barriere);
  $nb_barriere = $nb_barriere->count;

  $sql = "SELECT COUNT(*) FROM bd_equipement.autre_amenagement_zootechnie WHERE autr_amen_zoot_site_cen_id = '".$site."'";
  $req_nb_amgtGest = pg_query($dbConnect, $sql);
  $nb_amgtGest = pg_fetch_object($req_nb_amgtGest);
  $nb_amgtGest = $nb_amgtGest->count;


  if ($nb_panneau != 0) {
    $sql = "SELECT pann_date_amgt AS date_amgt, type_pann_libe AS type, etat_comm_libe AS etat FROM bd_equipement.panneau, bd_equipement.type_panneau, bd_equipement.etat_communication  WHERE pann_site_cen_id = '".$site."' AND type_pann_id = pann_type_pann_id AND etat_comm_id = pann_etat_comm_id ORDER BY type, date_amgt DESC" ;
    $req_info_panneau = pg_query($dbConnect, $sql);
    $res_info_panneau = pg_fetch_all($req_info_panneau);
  };

  if ($nb_sentier != 0) {
    $sql = "SELECT type_sent_libe AS gest, sent_date_amgt AS date_amgt, sent_acces_pmr AS pmr, type_chem_libe AS chem, diff_libe AS diff, etat_comm_libe AS etat, ROUND(SUM(ST_Length(sent_geom))) AS longueur FROM bd_equipement.sentier, bd_equipement.type_sentier, bd_equipement.type_cheminement, bd_equipement.difficulte, bd_equipement.etat_communication WHERE sent_site_cen_id = '".$site."' AND sent_type_sent_id = type_sent_id AND sent_type_chem_id = type_chem_id AND sent_diff_id = diff_id AND sent_etat_comm_id = etat_comm_id GROUP BY gest, date_amgt, etat, chem, pmr, diff ORDER BY gest, date_amgt DESC;";
    $req_sentier_info = pg_query($dbConnect, $sql);
    $res_sentier_info = pg_fetch_all($req_sentier_info);

    $sql = "SELECT ROUND(SUM(ST_Length(sent_geom))) AS longueur FROM bd_equipement.sentier WHERE sent_site_cen_id = '".$site."'";
    $req_long_sentier = pg_query($dbConnect, $sql);
    $long_sentier = pg_fetch_object($req_long_sentier);

    $sql = "SELECT ROUND(SUM(ST_Length(sent_geom))) AS longueur FROM bd_equipement.sentier WHERE sent_site_cen_id = '".$site."' AND sent_type_sent_id = 3";
    $req_long_sentier_cen = pg_query($dbConnect, $sql);
    $long_sentier_cen = pg_fetch_object($req_long_sentier_cen);
  };

  if ($nb_amgtValo != 0) {
    $sql = "SELECT type_autr_amen_comm_libe AS libe, autr_amen_comm_date_amgt AS date_amgt, etat_comm_libe AS etat FROM bd_equipement.autre_amenagement_communication, bd_equipement.type_autre_amenagement_communication, bd_equipement.etat_communication WHERE autr_amen_comm_site_cen_id = '".$site."' AND type_autr_amen_comm_id = autr_amen_comm_type_autr_amen_comm_id AND etat_comm_id = autr_amen_comm_etat_comm_id ORDER BY libe, date_amgt DESC" ;
    $req_info_amgt_valo = pg_query($dbConnect, $sql);
    $res_info_amgt_valo = pg_fetch_all($req_info_amgt_valo);
  };

  if ($nb_cloture != 0) {
    $sql = "SELECT clot_date_amgt AS date_amgt, type_mobi_libe AS mobi, type_fils_libe AS fils, type_pote_libe AS pote, etat_zoot_libe AS etat, ROUND(SUM(ST_Length(clot_geom))) AS longueur FROM bd_equipement.cloture, bd_equipement.type_mobilite, bd_equipement.type_fils, bd_equipement.type_poteau, bd_equipement.etat_zootechnie WHERE clot_site_cen_id = '".$site."' AND clot_type_mobi_id = type_mobi_id AND clot_type_fils_id = type_fils_id AND clot_type_pote_id = type_pote_id AND clot_etat_zoot_id = etat_zoot_id  GROUP BY date_amgt, mobi, fils, pote, etat ORDER BY fils, pote, date_amgt DESC;";
    $req_cloture_info = pg_query($dbConnect, $sql);
    $res_cloture_info = pg_fetch_all($req_cloture_info);

    $sql = "SELECT ROUND(SUM(ST_Length(clot_geom))) AS longueur FROM bd_equipement.cloture WHERE clot_site_cen_id = '".$site."'";
    $req_long_cloture_cen = pg_query($dbConnect, $sql);
    $long_cloture_cen = pg_fetch_object($req_long_cloture_cen);
  };

  if ($nb_barriere != 0) {
    $sql = "SELECT barr_date_amgt AS date_amgt, barr_dime AS dime, type_mobi_libe AS mobi, type_stru_libe AS stru, etat_zoot_libe AS etat FROM bd_equipement.barriere, bd_equipement.type_mobilite, bd_equipement.type_structure, bd_equipement.etat_zootechnie  WHERE barr_site_cen_id = '".$site."' AND type_mobi_id = barr_type_mobi_id AND type_stru_id = barr_type_stru_id AND etat_zoot_id = barr_etat_zoot_id ORDER BY stru, date_amgt DESC" ;
    $req_info_barriere = pg_query($dbConnect, $sql);
    $res_info_barriere = pg_fetch_all($req_info_barriere);
  };

  if ($nb_amgtGest != 0) {
    $sql = "SELECT type_autr_amen_zoot_libe AS libe, autr_amen_zoot_date_amgt AS date_amgt, etat_zoot_libe AS etat FROM bd_equipement.autre_amenagement_zootechnie, bd_equipement.type_autre_amenagement_zootechnie, bd_equipement.etat_zootechnie WHERE autr_amen_zoot_site_cen_id = '".$site."' AND type_autr_amen_zoot_id = autr_amen_zoot_type_autr_amen_zoot_id AND etat_zoot_id = autr_amen_zoot_etat_zoot_id ORDER BY libe, date_amgt DESC" ;
    $req_info_amgt_gest = pg_query($dbConnect, $sql);
    $res_info_amgt_gest = pg_fetch_all($req_info_amgt_gest);
  };
?>
<page backtop="5%" backbottom="5%" backleft="5%" backright="5%">
<h1>Fiche Caractéristique</h1>
<h2><?=$nom_site ?></h2>

<?php if ($nb_panneau == 0 && $nb_sentier == 0 && $nb_amgtValo == 0 && $nb_cloture == 0 && $nb_barriere == 0 && $nb_amgtGest == 0): ?>
  <h3 class="aucun">Aucun équipement n'est sur ce site</h3>
<?php endif; ?>

<bookmark title="Résumé" level="0" ></bookmark>
<div class="resume">
  <?php if ($nb_panneau != 0 || $nb_sentier != 0 || $nb_amgtValo != 0 || $nb_cloture != 0 || $nb_barriere != 0 || $nb_amgtGest != 0): ?>
    <p class="souligne">En résumé sur ce site:</p>
  <?php endif; ?>

  <?php if ($nb_panneau != 0): ?>
    <?php $pann_SP = ucfirst(Singulier_Pluriels($nb_panneau, 'panneau')); ?>
    <p class="nb">• <?=$nb_panneau ?> <?=$pann_SP?></p>
  <?php endif; ?>

  <?php if ($nb_sentier != 0): ?>
    <?php $sent_SP = ucfirst(Singulier_Pluriels($nb_sentier, 'sentier')); ?>
    <p class="nb">• <?=$long_sentier->longueur ?> mètre de <?=$sent_SP?></p>
  <?php endif; ?>

  <?php if ($nb_amgtValo != 0): ?>
    <?php $amgtValo_SP = ucfirst(Singulier_Pluriels($nb_amgtValo, 'aménagement')); ?>
    <p class="nb">• <?=$nb_amgtValo ?> <?=$amgtValo_SP?></p>
  <?php endif; ?>

  <?php if ($nb_cloture != 0): ?>
    <?php $clot_SP = ucfirst(Singulier_Pluriels($nb_cloture, 'clôture')); ?>
    <p class="nb">• <?=$long_cloture_cen->longueur?> mètre de <?=$clot_SP?></p>
  <?php endif; ?>

  <?php if ($nb_barriere != 0): ?>
    <?php $barriere_SP = ucfirst(Singulier_Pluriels($nb_barriere, 'barrière')); ?>
    <p class="nb">• <?=$nb_barriere ?> <?=$barriere_SP?></p>
  <?php endif; ?>

  <?php if ($nb_amgtGest != 0): ?>
    <?php $amgtGest_SP = ucfirst(Singulier_Pluriels($nb_amgtGest, 'aménagement')); ?>
    <p class="nb">• <?=$nb_amgtGest ?> <?=$amgtGest_SP?></p>
  <?php endif; ?>
</div>

<bookmark title="Equipements" level="0" ></bookmark>
<bookmark title="Panneau" level="1" ></bookmark>
<div class="panneau">
<?php if ($nb_panneau != 0): ?>
  <?php $pann_SP = ucfirst(Singulier_Pluriels($nb_panneau, 'panneau')); ?>
  <h3><?=$nb_panneau ?> <?=$pann_SP?></h3>
    <table>
      <tr>
        <th>Mise en place</th>
        <th>État</th>
        <th>Type</th>
      </tr>
    <?php foreach ($res_info_panneau AS $info_panneau): ?>
      <?php $date_amgt = date('j-m-Y', strtotime($info_panneau['date_amgt'])) ?>
          <tr>
            <td><?=$date_amgt ?></td>
            <td><?=$info_panneau['etat']?></td>
            <td><?=$info_panneau['type']?></td>
          </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>
</div>

<bookmark title="Sentier" level="1" ></bookmark>
<div class="sentier">
<?php if ($nb_sentier != 0): ?>
  <?php $sent_SP = ucfirst(Singulier_Pluriels($nb_sentier, 'sentier')); ?>
  <h3><?=$long_sentier->longueur ?> mètre de <?=$sent_SP?></h3>
  <table>
    <tr>
      <th>Mise en place</th>
      <th>État</th>
      <th>Gestionnaire</th>
      <th>Cheminement</th>
      <th>Accès PMR</th>
      <th>Difficulté</th>
      <th>Longueur</th>
    </tr>
  <?php $sent_cen = 0 ?>
  <?php foreach ($res_sentier_info AS $sentier_info): ?>
    <?php if ($sentier_info['gest'] == 'CEN') { $sent_cen .= 1; } ?>
    <?php $date_amgt = date('j-m-Y', strtotime($sentier_info['date_amgt'])) ?>
    <tr>
      <td><?=$date_amgt ?></td>
      <td><?=$sentier_info['etat']?></td>
      <td><?=$sentier_info['gest']?></td>
      <td><?=$sentier_info['chem']?></td>
      <td>
        <?php if ($sentier_info['pmr'] == 't'): ?>
          Oui
        <?php elseif ($sentier_info['pmr'] == 'f'): ?>
          Non
        <?php endif; ?>
      </td>
      <td><?=$sentier_info['diff']?></td>
      <td><?=$sentier_info['longueur']?> m</td>
    </tr>
  <?php endforeach; ?>
  </table>
  <?php if ($sent_cen != 0): ?>
    <p class="total">Longueur total des sentiers géré par le CEN : <?=$long_sentier_cen->longueur?> mètre.</p>
  <?php endif; ?>
<?php endif; ?>
</div>

<bookmark title="Aménagement de Valorisation" level="1" ></bookmark>
<div class="amgtValo">
<?php if ($nb_amgtValo != 0): ?>
  <?php $amgtValo_SP = ucfirst(Singulier_Pluriels($nb_amgtValo, 'aménagement')); ?>
  <h3><?=$nb_amgtValo ?> <?=$amgtValo_SP?></h3>
  <table>
    <tr>
      <th>Mise en place</th>
      <th>État</th>
      <th>Type</th>
    </tr>
  <?php foreach ($res_info_amgt_valo AS $amgt_valo_info): ?>
  <?php $date_amgt = date('j-m-Y', strtotime($amgt_valo_info['date_amgt'])) ?>
    <tr>
      <td><?=$date_amgt ?></td>
      <td><?=$amgt_valo_info['etat']?></td>
      <td><?=$amgt_valo_info['libe']?></td>
    </tr>
  <?php endforeach; ?>
  </table>
<?php endif; ?>
</div>

<bookmark title="Clôture" level="1" ></bookmark>
<div class="cloture">
<?php if ($nb_cloture != 0): ?>
  <?php $clot_SP = ucfirst(Singulier_Pluriels($nb_cloture, 'clôture')); ?>
    <h3><?=$long_cloture_cen->longueur?> mètre de <?=$clot_SP?></h3>
    <table>
      <tr>
        <th>Mise en place</th>
        <th>État</th>
        <th>Mobilité</th>
        <th>Fils</th>
        <th>Poteau</th>
        <th>Longueur</th>
      </tr>
    <?php foreach ($res_cloture_info AS $cloture_info): ?>
    <?php $date_amgt = date('j-m-Y', strtotime($cloture_info['date_amgt'])) ?>
      <tr>
        <td><?=$date_amgt ?></td>
        <td><?=$cloture_info['etat']?></td>
        <td><?=$cloture_info['mobi']?></td>
        <td><?=$cloture_info['fils']?></td>
        <td><?=$cloture_info['pote']?></td>
        <td><?=$cloture_info['longueur']?> m</td>
      </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>
</div>

<bookmark title="Barrière" level="1" ></bookmark>
<div class="barriere">
<?php if ($nb_barriere != 0): ?>
  <?php $barriere_SP = ucfirst(Singulier_Pluriels($nb_barriere, 'barrière')); ?>
  <h3><?=$nb_barriere ?> <?=$barriere_SP?></h3>
  <table>
    <tr>
      <th>Mise en place</th>
      <th>État</th>
      <th>Dimension</th>
      <th>Mobilité</th>
      <th>Structure</th>
    </tr>
  <?php foreach ($res_info_barriere AS $info_barriere): ?>
  <?php $date_amgt = date('j-m-Y', strtotime($info_barriere['date_amgt'])) ?>
    <tr>
      <td><?=$date_amgt ?></td>
      <td><?=$info_barriere['etat']?></td>
      <?php $dimension = Singulier_Pluriels($info_barriere['dime'], 'mètre') ?>
      <td><?=$info_barriere['dime']?> <?=$dimension ?></td>
      <td><?=$info_barriere['mobi']?></td>
      <td><?=$info_barriere['stru']?></td>
    </tr>
  <?php endforeach; ?>
  </table>
<?php endif; ?>
</div>

<bookmark title="Aménagement de Gestion" level="1" ></bookmark>
<div class="amgtGest">
<?php if ($nb_amgtGest != 0): ?>
  <?php $amgtGest_SP = ucfirst(Singulier_Pluriels($nb_amgtGest, 'aménagement')); ?>
  <h3><?=$nb_amgtGest ?> <?=$amgtGest_SP?></h3>
  <table>
    <tr>
      <th>Mise en place</th>
      <th>État</th>
      <th>Type</th>
    </tr>
  <?php foreach ($res_info_amgt_gest AS $info_amgt_gest): ?>
  <?php $date_amgt = date('j-m-Y', strtotime($info_amgt_gest['date_amgt'])) ?>
    <tr>
      <td><?=$date_amgt ?></td>
      <td><?=$info_amgt_gest['etat']?></td>
      <td><?=$info_amgt_gest['libe']?></td>
    </tr>
  <?php endforeach; ?>
  </table>
<?php endif; ?>
</div>
</page>

<?php
  pg_close($dbConnect);

  function Singulier_Pluriels($nb, $mot) {
    if ($nb != 1) {
      if($mot == 'panneau') {
        $mot = $mot."x";
      }
      else {
        $mot = $mot."s";
      }
    };

    return $mot;
  };
?>

<?php
  $content = ob_get_clean();

  require_once('js/html2pdf/html2pdf.class.php');
  try
  {
    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
    // $html2pdf->setModeDebug();
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, false);
    // $html2pdf->writeHTML($content, true);
    $html2pdf->Output('/doc/ficheSite/'.$site.'.pdf');
  }
  catch(HTML2PDF_exception $e) {
    echo $e;
  exit;
  }
?>
