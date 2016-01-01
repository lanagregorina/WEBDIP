<?php
include('zaglavlje.php');

include_once('baza.class.php');

$baza = new Baza();
$mysqli = $baza->spojiDB();

$sql = "SELECT * FROM parking JOIN korisnik ON zaposlenik = id_korisnik";

if ($rs = $mysqli->query($sql)) {
$parking = array();
	while ($row = $rs->fetch_assoc()){
		$parking[] = $row;
	}
}

echo "<table border=1 class='tablica'>";
echo "<thead>";
echo "<tr>";
echo "<th>Naziv</th>";
echo "<th>Broj mjesta</th>";
echo "<th>Cijena dan</th>";
echo "<th>Cijena mjesec</th>";
echo "<th>Cijena kazne (sat)</th>";
echo "<th>Zaposlenik</th>";
if (isset($_SESSION['username'])) {
	echo "<th>Akcija</th>";
}
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach ($parking as $par) {
	echo "<tr>";
	echo "<td>" . $par['opis'] . "</td>";
	echo "<td>" . $par['broj_mjesta'] . "</td>";
	$sql2 = "SELECT cijena FROM parking_cijena WHERE parking_id = " . $par['id_parking'];
	if ($rs2 = $mysqli->query($sql2)) {
		$cijene = array();
		while ($row2 = $rs2->fetch_row()){
			$cijene[] = $row2;
		}
	}
	echo "<td>" . $cijene[0][0] . " kn</td>"; //ispis prvog rezultata iz polja cijene (indeks 0) i zatim jedinog zapisa iz tog rezultata (indeks 0), odnosno same cijene
	echo "<td>" . $cijene[1][0] . " kn</td>";
	echo "<td>" . $par['cijena_sat'] . " kn</td>";
	echo "<td>" . $par['ime'] . " " . $par['prezime'] . "</td>";
	if ($_SESSION['tip'] == 2 || $_SESSION['tip'] == 1) {
		echo "<td><a href='parking-provjera.php?id=" . $par['id_parking'] . "'><input type='button' value='Provjeri parking'></a></td>";
	if ($_SESSION['tip'] == 1 || ($_SESSION['tip'] == 2 && $_SESSION['id'] == $par['zaposlenik'])) {
		echo "<td><a href='parking-uredi.php?id=" . $par['id_parking'] . "'><input type='button' value='Uredi'></a></td>";
	}
	} else if ($_SESSION['tip'] == 3) {
		$sql = "SELECT korisnik.id_korisnik FROM korisnik JOIN karta ON karta.id_korisnik = korisnik.id_korisnik AND karta.parking_id_parking = " . $par['id_parking'] ." WHERE korisnik.id_korisnik = " . $_SESSION['id'];
		if ($rs = $mysqli->query($sql)) {
			if ($rs->num_rows > 0) {
				$sql = "SELECT parking FROM korisnik WHERE parking = " . $par['id_parking'] . " AND id_korisnik = " . $_SESSION['id'];
				if ($rs = $mysqli->query($sql)) {
					if ($rs->num_rows == 1) {
						echo "<td><input type='button' value='Makni automobil' onclick='parkiranje(2, " . $par['id_parking'] . ");'></td>";
					} else {
						echo "<td><input type='button' value='Parkiraj' onclick='parkiranje(1, " . $par['id_parking'] . ");'></td>";
					}
				}
			} else {
				echo "<td></td>";
			}
		}
	echo "</tr>";
	}
}
echo "</tbody>";
echo "</table>";

if ($_SESSION['tip'] == 1) {
	echo "<a href='parking-dodaj.php'><input type='button' id='gumb-parking' value='Dodaj parking'></a>";
	echo "<br>";
	echo "<br>";
	echo "<a href='parking-notifikacije.php'><input type='button' id='gumb-parking' value='Notifikacije korisnicima'></a>";
}

?>

<script type="text/javascript">
	function parkiranje(akcija, parkingId) {
		var id = parkingId;
		if (akcija == 2) {
			var akc = 'move';
		} else if (akcija == 1) {
			var akc = 'park';
		}

		$.ajax({
			type: "POST",
			url: "parkiranje.php",
			data: "id=" + id + "&action=" + akc,
			cache: false,
			processData: false,
			success:  function(data){
				if (data == 'OK' && akc == 'park') {
					location.reload();
				} else if (data == 'OK' && akc == 'move') {
					location.reload();
				}
			}
		});
	}
</script>

<?php
include('podnozje.php');
?>  