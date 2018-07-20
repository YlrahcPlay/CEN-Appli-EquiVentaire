<?php
  include("AccessDataBasePgConnect.php");
  $idsite = $_GET['idsite'];

  if($idsite == 'tous') {
    $sql = "SELECT row_to_json(fc) FROM (
      SELECT
      'FeatureCollection' AS type
      , array_to_json(array_agg(f)) AS features
      FROM (
        SELECT
        'Feature' AS type
        , row_to_json((
          SELECT l FROM (SELECT ".'"ID"'." AS code_site, ".'"Nom_Site"'." AS nom_site, commune) AS l)) AS properties
          , ST_AsGeoJSON(ST_Transform(geom, 4326), 6)::json AS geometry
        FROM md.site_cenhn WHERE categorie = 1
      ) AS f
    ) AS fc";

  } else {
    $sql = "SELECT row_to_json(fc) FROM (
      SELECT
      'FeatureCollection' AS type
      , array_to_json(array_agg(f)) AS features
      FROM (
        SELECT
        'Feature' AS type
        , row_to_json((
          SELECT l FROM (SELECT ".'"ID"'." AS code_site, ".'"Nom_Site"'." AS nom_site, commune) AS l)) AS properties
          , ST_AsGeoJSON(ST_Transform(geom, 4326), 6)::json AS geometry
        FROM md.site_cenhn
        WHERE site_cenhn.".'"ID"'."::text like '".$idsite."'
      ) AS f
    ) AS fc";
  }

  $resultat_json = pg_exec($dbConnect,$sql) or die (pgErrorMessage());
  while($ligne = pg_fetch_row($resultat_json))
  {
    echo trim ($ligne[0]);
  }

  pg_close($dbConnect);
?>
