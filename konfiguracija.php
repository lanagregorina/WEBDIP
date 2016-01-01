<?php
include('zaglavlje.php');
include_once('pomak.php');

if (!isset($_SESSION['username'])) {
    header('location:prijava.php');
} else {
    if ($_SESSION['tip'] != 1) {
        header('location:index.php');
    }
}

if ($_GET['action'] == 'pomak') {
  virtualnoVrijeme();
}

?>

<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Pomak vremena</a></li>
    <li><a href="#tabs-2">Upravljanje straničenjem</a></li>
    <li><a href="#tabs-3">Izgled korisničkog sučelja</a></li>
  </ul>
  <div id="tabs-1">
    <a href="http://arka.foi.hr/PzaWeb/PzaWeb2004/config/vrijeme.html" target="_blank">Pomak u broju sati</a>
    <br>
    <br>
    <a href="konfiguracija.php?action=pomak"><input type="button" value="Učitaj vrijeme"></a>
  </div>
  <div id="tabs-2">
  </div>
  <div id="tabs-3">
  </div>
</div>

<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
</script>

<?php

include('podnozje.php');

?>