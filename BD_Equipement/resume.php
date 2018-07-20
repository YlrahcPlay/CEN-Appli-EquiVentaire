<?php
  include("data/AccessDataBasePgConnect.php");

  //// Nombre de panneau ////
  $sql_nbPanneau = "SELECT count(*) FROM bd_equipement.panneau";
  $requete = pg_query($dbConnect,$sql_nbPanneau);
  $nbPanneau = pg_fetch_row($requete);


  //// Nombre de Km de Sentier du CEN ////
  $sql_nbSentierPeda = "SELECT DISTINCT type_sent_libe, ST_Length(sent_geom) FROM bd_equipement.sentier, bd_equipement.type_sentier WHERE sent_type_sent_id = type_sent_id AND type_sent_libe = 'CEN'";
  $resultat_sentPeda = tableau_objet($dbConnect, $sql_nbSentierPeda);

  $longueur = 0;
  foreach ($resultat_sentPeda as $sentPeda) {
    $longueur += $sentPeda->st_length;
  }
  $longueurSent = round($longueur/100)/10;


  //// Nombre d'aménagement de communication ////
  $sql_nbAmgtComm = "SELECT count(*) FROM bd_equipement.autre_amenagement_communication";
  $requete = pg_query($dbConnect,$sql_nbAmgtComm);
  $nbAmgtComm = pg_fetch_row($requete);


  //// Nombre de Km de Clôture ////
  $sql_nbCloture = "SELECT DISTINCT ST_Length(clot_geom) FROM bd_equipement.cloture";
  $resultat_nbCloture = tableau_objet($dbConnect, $sql_nbCloture);

  $longueur = 0;
  foreach ($resultat_nbCloture as $nbCloture) {
    $longueur += $nbCloture->st_length;
  }
  $longueurClot = round($longueur/100)/10;


  //// Nombre de barrière ////
  $sql_nbBarriere = "SELECT count(*) FROM bd_equipement.barriere";
  $requete = pg_query($dbConnect,$sql_nbBarriere);
  $nbBarriere = pg_fetch_row($requete);


  //// Nombre d'aménagement de zootechnie
  $sql_nbAmgtZoot = "SELECT count(*) FROM bd_equipement.autre_amenagement_zootechnie";
  $requete = pg_query($dbConnect,$sql_nbAmgtZoot);
  $nbAmgtZoot = pg_fetch_row($requete);

  //// Ferme la connexion à la BD ////
  pg_close($dbConnect);
?>
<div class="resume">
  <p>En résumé, le CEN Normandie-Seine, c'est :</p>
  <!-- <p>En résumé, le CEN Normandie, c'est :</p> -->
  <p><?=$nbPanneau['0'] ?> <span class="pann">Panneaux -</span> <?=$longueurSent ?> Km de <span class="sent">Sentier -</span> <?=$nbAmgtComm['0'] ?> <span class="amgtComm">Aménagements de Valorisation</span></p>
  <p><?=$longueurClot ?> Km de <span class="clot">Clôture -</span> <?=$nbBarriere['0'] ?> <span class="barr">Barrières -</span> <?=$nbAmgtZoot['0'] ?> <span class="amgtZoot">Aménagements de Gestion</span></p>
</div>

<!-- <table class="resume centre">
  <tr>
    <th colspan="3">En résumé, le CEN Normandie-Seine, c'est :</th>
  </tr>
  <tr>
    <td><?=$nbPanneau['0'] ?> <span class="pann">Panneaux</span></td>
    <td><?=$longueurSent ?> Km de <span class="sent">Sentier</span></td>
    <td><?=$nbAmgtComm['0'] ?> <span class="amgtComm">Aménagements de Communication</span></td>
  </tr>
  <tr>
    <td><?=$longueurClot ?> Km de <span class="clot">Clôture</span></td>
    <td><?=$nbBarriere['0'] ?> <span class="barr">Barrières</span></td>
    <td><?=$nbAmgtZoot['0'] ?> <span class="amgtZoot">Aménagements de Zootechnie</span></td>
  </tr>
</table> -->
