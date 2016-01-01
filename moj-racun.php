<?php
include('zaglavlje.php');

if (!isset($_SESSION['username'])) {
  header('location:prijava.php');
}

include_once('baza.class.php');
$baza = new Baza();
$mysqli = $baza->spojiDB();

$id = $_SESSION['id'];
?>

<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Neplaćene kazne</a></li>
    <li><a href="#tabs-2">Plaćene kazne</a></li>
    <li><a href="#tabs-3">Važeće karte</a></li>
    <li><a href="#tabs-4">Sve karte</a></li>
  </ul>
  <div id="tabs-1">
    <?php
    $sql = "SELECT id_kazna, datum, reg_oznaka, opis, iznos FROM kazna JOIN korisnik ON korisnik_id_korisnik = id_korisnik JOIN parking ON parking_id_parking = id_parking WHERE placeno = 0 AND id_korisnik = $id";
    if ($rs = $mysqli->query($sql)) {
      while ($kazna = $rs->fetch_assoc()) {
        echo "<p> " . $kazna['datum'] . " " . $kazna['reg_oznaka'] . " " . $kazna['opis'] . " " . $kazna['iznos'] . " kn" . " " . "<input type='button' value='Plati kaznu' onclick='placanjeKazne(" . $kazna['id_kazna'] . ");';>" . "</p>";
      }
    }
    ?>
    </div>
  <div id="tabs-2">
    <?php
    $sql = "SELECT id_kazna, datum, reg_oznaka, opis, iznos FROM kazna JOIN korisnik ON korisnik_id_korisnik = id_korisnik JOIN parking ON parking_id_parking = id_parking WHERE placeno = 1 AND id_korisnik = $id";
    if ($rs = $mysqli->query($sql)) {
      while ($kazna = $rs->fetch_assoc()) {
        echo "<p> " . $kazna['datum'] . " " . $kazna['reg_oznaka'] . " " . $kazna['opis'] . " " . $kazna['iznos'] . " kn</p>";
      }
    }
    ?>
  </div>
  <div id="tabs-3">
	<?php
	$sql = "SELECT id_karta, vrijeme, naziv, opis FROM karta JOIN tip_karte ON tip_karte_id_tip_karte = id_tip_karte JOIN parking ON parking_id_parking = id_parking WHERE id_korisnik = " . $_SESSION['id'] . " AND vrijeme = CURDATE() AND tip_karte_id_tip_karte = 1 UNION
SELECT id_karta, vrijeme, naziv, opis FROM karta JOIN tip_karte ON tip_karte_id_tip_karte = id_tip_karte JOIN parking ON parking_id_parking = id_parking WHERE id_korisnik = " . $_SESSION['id'] . " AND vrijeme < CURDATE() AND vrijeme > CURDATE() - 30 AND tip_karte_id_tip_karte = 2";
	if ($rs = $mysqli->query($sql)) {
		while ($karta = $rs->fetch_assoc()) {
			echo "<p> " . $karta['vrijeme'] . " " . $karta['naziv'] . " " . $karta['opis'] . "</p>";
		}
	}
	?>
  </div>
  <div id="tabs-4">
  <?php
  $sql = "SELECT * FROM karta JOIN tip_karte ON tip_karte_id_tip_karte = id_tip_karte JOIN parking ON parking_id_parking = id_parking WHERE id_korisnik = " . $id;
  if ($rs = $mysqli->query($sql)) {
    while ($karta = $rs->fetch_assoc()) {
      echo "<p> " . $karta['vrijeme'] . " " . $karta['naziv'] . " " . $karta['opis'] . "</p>";
    }
  }
  ?>
  </div>
</div>

<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
</script>

<script type="text/javascript">
  function placanjeKazne(id) {
    var idKazna = id;
    $.ajax({
      type: "POST",
      url: "kazna-placanje.php",
      data: "id=" + idKazna,
      cache: false,
      processData: false,
      success:  function(data){
        if (data == 'OK') {
          location.reload();
        }
      }
    });
  }
</script>

<?php
include('podnozje.php');
?>  