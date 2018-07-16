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
        SELECT l FROM (SELECT clot_id, clot_date_enre, type_mobi_id, type_mobi_libe AS type_mobilite, type_fils_id, type_fils_libe AS type_fils, type_pote_id, type_pote_libe AS type_poteau, clot_date_amgt AS date_amgt, clot_partiel, etat_zoot_id, etat_zoot_libe AS etat, clot_comm AS commentaire, Round(ST_Length(clot_geom)) AS longueur, commune||' - '||".'"Nom_Site"'." AS site) AS l)) AS properties
        , ST_AsGeoJSON(ST_Transform(clot_geom, 4326), 6)::json AS geometry
        FROM bd_equipement.cloture, bd_equipement.type_mobilite, bd_equipement.type_fils, bd_equipement.type_poteau, bd_equipement.etat_zootechnie, md.site_cenhn
        WHERE clot_type_mobi_id = type_mobi_id AND clot_type_fils_id = type_fils_id AND clot_type_pote_id = type_pote_id AND clot_etat_zoot_id = etat_zoot_id AND clot_site_cen_id = site_cenhn.".'"ID"'."
    ) AS f
  ) AS fc";

  $resultat_json = pg_exec($dbConnect,$sql) or die (pgErrorMessage());
  while($ligne = pg_fetch_row($resultat_json))
  {
    echo trim ($ligne[0]);
  }

  pg_close($dbConnect);
?>
