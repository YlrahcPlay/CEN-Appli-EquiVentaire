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
        SELECT l FROM (SELECT barr_id, barr_date_enre, type_mobi_id, type_mobi_libe AS type_mobilite, type_stru_id, type_stru_libe AS type_structure, barr_dime AS dimension, barr_date_amgt AS date_amgt, barr_cade_perm AS cadenas_permanent, etat_zoot_id, etat_zoot_libe AS etat, barr_comm AS commentaire, commune||' - '||".'"Nom_Site"'." AS site) AS l)) AS properties
        , ST_AsGeoJSON(ST_Transform(barr_geom, 4326), 6)::json AS geometry
        FROM bd_equipement.barriere, bd_equipement.type_mobilite, bd_equipement.type_structure, bd_equipement.etat_zootechnie, md.site_cenhn
        WHERE barr_type_mobi_id = type_mobi_id AND barr_type_stru_id = type_stru_id AND barr_etat_zoot_id = etat_zoot_id AND barr_site_cen_id = site_cenhn.".'"ID"'."
    ) AS f
  ) AS fc";

  $resultat_json = pg_exec($dbConnect,$sql) or die (pgErrorMessage());
  while($ligne = pg_fetch_row($resultat_json))
  {
    echo trim ($ligne[0]);
  }

  pg_close($dbConnect);
?>
