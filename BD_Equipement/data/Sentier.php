<?php
  include("AccessDataBasePgConnect.php");

  $sql = "SELECT row_to_json(fc) FROM (
    SELECT
    'FeatureCollection' AS type
    , array_to_json(array_agg(f)) AS features
    FROM (
      SELECT
      'Feature' AS type
      , row_to_json((
        SELECT l FROM (SELECT sent_id, sent_date_enre, type_sent_id, type_sent_libe AS type_sentier, type_chem_id, type_chem_libe AS type_cheminement, sent_date_amgt AS date_amgt, etat_comm_id, etat_comm_libe AS etat, sent_acces_pmr AS acces_pmr, diff_id, diff_libe AS difficulte, sent_comm AS commentaire, Round(ST_Length(sent_geom)) AS longueur, commune||' - '||".'"Nom_Site"'." AS site) AS l)) AS properties
        , ST_AsGeoJSON(ST_Transform(sent_geom, 4326), 6)::json AS geometry
        FROM bd_equipement.sentier, bd_equipement.type_sentier, bd_equipement.type_cheminement, bd_equipement.etat_communication, bd_equipement.difficulte, md.site_cenhn
        WHERE sent_type_sent_id = type_sent_id AND sent_type_chem_id = type_chem_id AND sent_etat_comm_id = etat_comm_id AND sent_diff_id = diff_id AND sent_site_cen_id = site_cenhn.".'"ID"'."
    ) AS f
  ) AS fc";

  $resultat_json = pg_exec($dbConnect,$sql) or die (pgErrorMessage());
  while($ligne = pg_fetch_row($resultat_json))
  {
    echo trim ($ligne[0]);
  }

  pg_close($dbConnect);
?>
