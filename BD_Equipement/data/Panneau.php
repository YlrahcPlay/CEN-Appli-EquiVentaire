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
        SELECT l FROM (SELECT pann_id, pann_date_enre, type_pann_id, type_pann_libe AS type_panneau, pann_prec, pann_date_amgt AS date_amgt, etat_comm_id, etat_comm_libe AS etat, pann_comm AS commentaire, commune||' - '||".'"Nom_Site"'." AS site) AS l)) AS properties
        , ST_AsGeoJSON(ST_Transform(pann_geom, 4326), 6)::json AS geometry
        FROM bd_equipement.panneau, bd_equipement.type_panneau, bd_equipement.etat_communication, md.site_cenhn
        WHERE pann_type_pann_id = type_pann_id AND pann_etat_comm_id = etat_comm_id AND pann_site_cen_id = site_cenhn.".'"ID"'."
    ) AS f
  ) AS fc";

  $resultat_json = pg_exec($dbConnect,$sql) or die (pgErrorMessage());
  while($ligne = pg_fetch_row($resultat_json))
  {
    echo trim ($ligne[0]);
  }

  pg_close($dbConnect);
?>
