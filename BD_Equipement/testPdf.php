<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>pdf</title>
  </head>
  <body>
    <h1>Test insertion pdf</h1>

    <!-- <h2>Iframe</h2> -->
    <!-- <p style="text-align: center;">
        <iframe src="doc\contenu\1533803703.pdf" width="600" height="800" align="middle" style="max-width: 100%;"></iframe>
    </p> -->

    <h2>Anchor</h2>
    <!-- <p style="cursor:pointer" onclick="openFile(doc\contenu\1533803703.pdf)">Le pdf</p> -->
    <p style="cursor:pointer" onclick="openFile('https://www.wordreference.com')">Wordref</p>
    <!-- http://www.wordreference.com/ -->
  </body>
</html>

<script type="text/javascript">
function openFile(lien) {
  window.open(lien);
};
</script>
