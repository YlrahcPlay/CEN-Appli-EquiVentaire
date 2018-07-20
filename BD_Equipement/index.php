<!DOCTYPE HTML>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="author" content="YP">
    <meta name="description" content="Interface Web pour la base de données équipements du CREN Normandie-Seine">

    <title>Equipements CEN</title>

    <!-- Remise à zéro du css -->
    <link rel="stylesheet" type="text/css" href="css/reset.css">

    <!-- jQuery -->
    <script type="text/javascript" language="javascript" src="js/jquery-3.3.1.min.js"></script>

    <!-- Leaflet -->
    <script type="text/javascript" language="javascript" src="js/leaflet/leaflet.js"></script>
    <link rel="stylesheet" type="text/css" href="js/leaflet/leaflet.css">

    <!-- Leaflet.draw -->
    <!-- <script type="text/javascript" language="javascript" src="js/Leaflet.draw/leaflet.draw.js"></script>
    <link rel="stylesheet" type="text/css" href="js/Leaflet.draw/leaflet.draw.css"> -->

    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/Leaflet.draw.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/Leaflet.Draw.Event.js"></script>
    <link rel="stylesheet" type="text/css" href="js/Leaflet.draw/leaflet.draw.css"/>

    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/Toolbar.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/Tooltip.js"></script>

    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/ext/GeometryUtil.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/ext/LatLngUtil.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/ext/LineUtil.Intersect.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/ext/Polygon.Intersect.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/ext/Polyline.Intersect.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/ext/TouchEvents.js"></script>

    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/draw/DrawToolbar.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/draw/handler/Draw.Feature.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/draw/handler/Draw.SimpleShape.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/draw/handler/Draw.Polyline.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/draw/handler/Draw.Marker.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/draw/handler/Draw.Circle.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/draw/handler/Draw.CircleMarker.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/draw/handler/Draw.Polygon.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/draw/handler/Draw.Rectangle.js"></script>


    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/edit/EditToolbar.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/edit/handler/EditToolbar.Edit.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/edit/handler/EditToolbar.Delete.js"></script>

    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/Control.Draw.js"></script>

    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/edit/handler/Edit.Poly.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/edit/handler/Edit.SimpleShape.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/edit/handler/Edit.Rectangle.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/edit/handler/Edit.Marker.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/edit/handler/Edit.CircleMarker.js"></script>
    <script type="text/javascript" language="javascript" src="js/Leaflet.draw/edit/handler/Edit.Circle.js"></script>

    <!-- jDiaporama -->
    <script type="text/javascript" language="javascript" src="js/jDiaporama/jquery.jDiaporama.js"></script>
    <link rel="stylesheet" type="text/css" href="js/jDiaporama/jDiaporama.css">

    <!-- lightbox -->
    <script type="text/javascript" language="javascript" src="js/lightbox/js/lightbox.js"></script>
    <link rel="stylesheet" type="text/css" href="js/lightbox/css/lightbox.css">

    <!-- Ajax méthode -->
    <!-- <script type="text/javascript" language="javascript" src="js/getXhr.js"></script> -->

    <!-- Ajax formulaire méthode -->
    <script type="text/javascript" language="javascript" src="js/jquery.form.js"></script>

    <!-- BD_Equipement -->
    <script type="text/javascript" language="javascript" src="js/carteLeaflet.js"></script>
    <script type="text/javascript" language="javascript" src="js/fonctionAjax.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <?php include('fonction.php') ?>
  </head>
  <body>
    <header>
      <a href="http://cen-normandie.fr/"><img src="img\CEN_normandie seine_RVB.jpg" alt="Logo CEN Normandie-Seine"></a>
      <h1>Equipements</h1>
    </header>
    <main>
      <div id="map"></div> <!-- Affichage de la carte -->
      <div id="attributs"></div> <!-- Affichage des attributs -->
      <div id="json"></div> <!-- Stockage de la géométrie -->
    </main>

    <aside> <!-- Ajout des filtres -->
      
      <?php include("filtre.php") ?>
    </aside>

    <footer> <!-- Ajout du résumé -->
      <?php include("resume.php") ?>
    </footer>
  </body>
</html>
