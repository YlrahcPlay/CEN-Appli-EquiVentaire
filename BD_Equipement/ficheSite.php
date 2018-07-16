<?php
  include("data/AccessDataBasePgConnect.php"); // Accès à la base de données
  // require_once('html2pdf.class.php');

  // $site = $_POST['site'];
  $site = $_GET['site'];
  // var_dump($site);
  $sql = "SELECT commune || ' - ' || ".'"Nom_Site"'." AS site FROM md.site_cenhn WHERE ".'"ID"'." = '".$site."'";
  $req_nom_site = pg_query($dbConnect, $sql);
  $nom_site = pg_fetch_object($req_nom_site);
  $nom_site = $nom_site->site;

  $content = "<h1>Fiche Caractéristique<h1>";
  $content .= "<br/><h2>".$nom_site."</h2>";
  $content .= "<br/>c'est :";

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
    $content_panneau = $nb_panneau ."Panneau";

    $sql = "SELECT COUNT(*) FROM bd_equipement.type_panneau";
    $req_nb_typePanneau = pg_query($dbConnect, $sql);
    $nb_typePanneau = pg_fetch_object($req_nb_typePanneau);
    $nb_typePanneau = $nb_typePanneau->count;

    for ($i=1; $i <= $nb_typePanneau; $i++) {
      $sql = "SELECT COUNT(*) FROM bd_equipement.panneau WHERE pann_site_cen_id = '".$site."' AND pann_type_pann_id = ".$i;
      $req_nb_panneau_type = pg_query($dbConnect, $sql);
      $nb_panneau_type = pg_fetch_object($req_nb_panneau_type);
      $nb_panneau_type = $nb_panneau_type->count;
      echo("<br/>Il y a ".$nb_panneau_type." de type ".$i);
    }

    $content .= $content_panneau;
  }

  pg_close($dbConnect);

  echo($content);
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
