<style  type="text/Css">
  table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
  }

  th, td {
    padding: 0.25em;
  }
</style>

<?php
  include("data/AccessDataBasePgConnect.php"); // Accès à la base de données
  include_once("fonction.php");
  // require_once('html2pdf.class.php');

  // $site = $_POST['site'];
  $site = $_GET['site'];
  // var_dump($site);

  $sql = "SELECT commune || ' - ' || ".'"Nom_Site"'." AS site FROM md.site_cenhn WHERE ".'"ID"'." = '".$site."'";
  $req_nom_site = pg_query($dbConnect, $sql);
  $nom_site = pg_fetch_object($req_nom_site);
  $nom_site = $nom_site->site;

  $sql = "SELECT COUNT(*) FROM bd_equipement.panneau WHERE pann_site_cen_id = '".$site."'";
  $req_nb_panneau = pg_query($dbConnect, $sql);
  $nb_panneau = pg_fetch_object($req_nb_panneau);
  $nb_panneau = $nb_panneau->count;
  echo("Nb Panneau = ".$nb_panneau);

  $sql = "SELECT ROUND(ST_Length(sent_geom)) AS longueur FROM bd_equipement.sentier WHERE sent_site_cen_id = '".$site."'";
  $req_long_sentier = pg_query($dbConnect, $sql);
  $long_sentier = pg_fetch_object($req_long_sentier);
  $long_sentier = $long_sentier->longueur;
  echo("<br/>Longueur Sentier = ".$long_sentier);

  $sql = "SELECT COUNT(*) FROM bd_equipement.autre_amenagement_communication WHERE autr_amen_comm_site_cen_id = '".$site."'";
  $req_autreamgtcomm = pg_query($dbConnect, $sql);
  $autreamgtcomm = pg_fetch_object($req_autreamgtcomm);
  $autreamgtcomm = $autreamgtcomm->count;
  echo("<br/>Nb Amgt Valorisation = ".$autreamgtcomm);

  $sql = "SELECT ROUND(ST_Length(clot_geom)) AS longueur FROM bd_equipement.cloture WHERE clot_site_cen_id = '".$site."'";
  $req_long_cloture = pg_query($dbConnect, $sql);
  $long_cloture = pg_fetch_object($req_long_cloture);
  $long_cloture = $long_cloture->longueur;
  echo("<br/>Longueur Cloture = ".$long_cloture);

  $sql = "SELECT COUNT(*) FROM bd_equipement.barriere WHERE barr_site_cen_id = '".$site."'";
  $req_nb_barriere = pg_query($dbConnect, $sql);
  $nb_barriere = pg_fetch_object($req_nb_barriere);
  $nb_barriere = $nb_barriere->count;
  echo("<br/>Nb Barrière = ".$nb_barriere);

  $sql = "SELECT COUNT(*) FROM bd_equipement.autre_amenagement_zootechnie WHERE autr_amen_zoot_site_cen_id = '".$site."'";
  $req_nb_autreamgtzoot = pg_query($dbConnect, $sql);
  $nb_autreamgtzoot = pg_fetch_object($req_nb_autreamgtzoot);
  $nb_autreamgtzoot = $nb_autreamgtzoot->count;
  echo("<br/>Nb Amgt Gestion = ".$nb_autreamgtzoot);

  if ($nb_panneau != 0) {
    $sql = "SELECT type_pann_libe AS libe FROM bd_equipement.type_panneau";
    $req_libe_type_pann = pg_query($dbConnect, $sql);
    $libe_type_pann = pg_fetch_all($req_libe_type_pann);
    // var_dump($libe_type_pann);

    $nb_typePanneau = count($libe_type_pann);

    $tableau_pann_type_nb = array();
    for ($i=1; $i <= $nb_typePanneau; $i++) {
      $sql = "SELECT COUNT(*) FROM bd_equipement.panneau WHERE pann_site_cen_id = '".$site."' AND pann_type_pann_id = ".$i;
      $req_nb_panneau_type = pg_query($dbConnect, $sql);
      $nb_panneau_type = pg_fetch_object($req_nb_panneau_type);
      $nb_panneau_type = $nb_panneau_type->count;

      array_push($tableau_pann_type_nb, array('id' => $i, 'libe' => $libe_type_pann[$i-1]['libe'], 'nb' => $nb_panneau_type));
    };
    // var_dump($tableau_pann_type_nb);
  }
?>
<h1>Fiche Caractéristique<h1>
<h2><?=$nom_site ?></h2>

<?php
  if ($nb_panneau != 0):
    $pann_SP = ucfirst(Singulier_Pluriels($nb_panneau, 'panneau')); ?>
    <h3><?=$nb_panneau ?> <?=$pann_SP?></h3>
  <?php endif;

  foreach ($tableau_pann_type_nb AS $pann_type_info):
    if ($pann_type_info['nb'] != 0):
      $sql = "SELECT pann_date_amgt AS date_amgt, etat_comm_libe AS etat FROM bd_equipement.panneau, bd_equipement.etat_communication WHERE pann_site_cen_id = '".$site."' AND pann_type_pann_id = ".$pann_type_info['id'] ."AND etat_comm_id = pann_etat_comm_id" ;
      $req_info_panneau = pg_query($dbConnect, $sql);
      $res_info_panneau = pg_fetch_all($req_info_panneau);
      // var_dump($res_info_panneau);
      ?>

      <p><?=$pann_type_info['nb'] ?> de type <?=$pann_type_info['libe'] ?></p>
      <ul>
        <table>
          <tr>
            <th>Mise en place</th>
            <th>État</th>
          </tr>
        <?php foreach ($res_info_panneau AS $info_panneau): ?>
          <?php $date_amgt = date('j-m-Y', strtotime($info_panneau['date_amgt'])) ?>
              <tr>
                <td><?=$date_amgt ?></td>
                <td><?=strtolower($info_panneau['etat'])?></td>
              </tr>
        <?php endforeach; ?>
        </table>
      </ul>
    <?php
    endif;
  endforeach;
?>




<!-- <?php
  try
  {
    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
    // $html2pdf->setModeDebug();
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('exemple00.pdf');
  }
  catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
  }
?> -->

<?php
  pg_close($dbConnect);

  function Singulier_Pluriels($nb, $mot) {
    if ($nb != 1) {
      if($mot == 'panneau') {
        $mot = 'panneaux';
      };
    };

    return $mot;
  };
?>
