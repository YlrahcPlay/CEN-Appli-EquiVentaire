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
        SELECT l FROM (SELECT autr_amen_zoot_id, autr_amen_zoot_date_enre, type_autr_amen_zoot_id, type_autr_amen_zoot_libe AS type_amenagement, autr_amen_zoot_date_amgt AS date_amgt, etat_zoot_id, etat_zoot_libe AS etat, autr_amen_zoot_comm AS commentaire, commune||' - '||".'"Nom_Site"'." AS site) AS l)) AS properties
        , ST_AsGeoJSON(ST_Transform(autr_amen_zoot_geom, 4326), 6)::json AS geometry
        FROM bd_equipement.autre_amenagement_zootechnie, bd_equipement.type_autre_amenagement_zootechnie, bd_equipement.etat_zootechnie, md.site_cenhn
        WHERE autr_amen_zoot_type_autr_amen_zoot_id = type_autr_amen_zoot_id AND autr_amen_zoot_etat_zoot_id = etat_zoot_id AND autr_amen_zoot_site_cen_id = site_cenhn.".'"ID"'."
    ) AS f
  ) AS fc";

  $resultat_json = pg_exec($dbConnect,$sql) or die (pgErrorMessage());
  while($ligne = pg_fetch_row($resultat_json))
  {
    echo trim ($ligne[0]);
  }

  pg_close($dbConnect);
?>
