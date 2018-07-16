<?php
  include("data/AccessDataBasePgConnect.php"); // Accès à la base de données
  // require_once('html2pdf.class.php');

  // $site = $_POST['site'];
  $site = $_GET['site'];
  var_dump($site);

  $sql = "SELECT COUNT(*) FROM bd_equipement.panneau, md.site_cenhn WHERE ".'"ID"'." = '".$site."'";
  $req_nb_panneau = pg_query($dbConnect, $sql);
  $nb_panneau = pg_fetch_object($req_nb_panneau);
  $nb_panneau = $nb_panneau->count;
  var_dump($nb_panneau);

  $sql = "SELECT COUNT(*) FROM bd_equipement.sentier, md.site_cenhn WHERE ".'"ID"'." = '".$site."'";
  $req_nb_sentier = pg_query($dbConnect, $sql);
  $nb_sentier = pg_fetch_object($req_nb_sentier);
  $nb_sentier = $nb_sentier->count;
  var_dump($nb_sentier);

  $sql = "SELECT COUNT(*) FROM bd_equipement.autre_amenagement_communication, md.site_cenhn WHERE ".'"ID"'." = '".$site."'";
  $req_autreamgtcomm = pg_query($dbConnect, $sql);
  $autreamgtcomm = pg_fetch_object($req_autreamgtcomm);
  $autreamgtcomm = $autreamgtcomm->count;
  var_dump($autreamgtcomm);

  $sql = "SELECT COUNT(*) FROM bd_equipement.cloture, md.site_cenhn WHERE ".'"ID"'." = '".$site."'";
  $req_nb_cloture = pg_query($dbConnect, $sql);
  $nb_cloture = pg_fetch_object($req_nb_cloture);
  $nb_cloture = $nb_cloture->count;
  var_dump($nb_cloture);

  $sql = "SELECT COUNT(*) FROM bd_equipement.barriere, md.site_cenhn WHERE ".'"ID"'." = '".$site."'";
  $req_nb_barriere = pg_query($dbConnect, $sql);
  $nb_barriere = pg_fetch_object($req_nb_barriere);
  $nb_barriere = $nb_barriere->count;
  var_dump($nb_barriere);

  $sql = "SELECT COUNT(*) FROM bd_equipement.autre_amenagement_zootechnie, md.site_cenhn WHERE ".'"ID"'." = '".$site."'";
  $req_nb_autreamgtzoot = pg_query($dbConnect, $sql);
  $nb_autreamgtzoot = pg_fetch_object($req_nb_autreamgtzoot);
  $nb_autreamgtzoot = $nb_autreamgtzoot->count;
  var_dump($nb_autreamgtzoot);

  if ($nb_panneau != 0) {
    echo "Check my branch";
  }
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
