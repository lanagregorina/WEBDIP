<?php
include('zaglavlje.php');
include_once('baza.class.php');

if (!isset($_SESSION['username'])) {
    header('location:prijava.php');
}

if ($_SESSION['tip'] != 1 && $_SESSION['tip'] != 2) {
    header('location:index.php');
}

$baza = new Baza();
$mysqli = $baza->spojiDB();

if (isset($_GET['id'])) {
	$id = intval($_GET['id']);
}

$sql = "SELECT id_korisnik, ime, prezime, reg_oznaka FROM korisnik WHERE parking = $id";
if ($rs = $mysqli->query($sql)) {
	$automobili = array();
	while ($row = $rs->fetch_assoc()) {
		$automobili[] = $row;
	}
}

echo "<table class='tablica' border=1>";
echo "<thead>";
echo "<tr>";
echo "<th>Ime</th>";
echo "<th>Prezime</th>";
echo "<th>Registracijska oznaka</th>";
echo "<th>Karta</th>";
echo "<th>Datum kupnje</th>";
echo "<th>Datum parkiranja</th>";
echo "<th>Akcija</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach ($automobili as $auto) {
	echo "<tr>";
	$sql = "SELECT parking, naziv, vrijeme, vrijeme_parkiranja, tip_karte_id_tip_karte, id_karta FROM korisnik JOIN karta ON korisnik.id_korisnik = karta.id_korisnik AND parking = karta.parking_id_parking JOIN tip_karte ON id_tip_karte = tip_karte_id_tip_karte WHERE parking = $id AND korisnik.id_korisnik = " . $auto['id_korisnik'];
	if ($rs = $mysqli->query($sql)) {
		if ($rs->num_rows > 0) {
			$karte = array();
			while ($karta = $rs->fetch_assoc()) {
				$karte[] = $karta;
			}

			foreach ($karte as $karta) {
				echo "<td>" . $auto['ime'] . "</td>";
				echo "<td>" . $auto['prezime'] . "</td>";
				echo "<td>" . $auto['reg_oznaka'] . "</td>";
				echo "<td>" . $karta['naziv'] . "</td>";
				echo "<td>" . $karta['vrijeme'] . "</td>";
				echo "<td>" . $karta['vrijeme_parkiranja'] . "</td>";

				$sql = "SELECT zaposlenik FROM parking WHERE zaposlenik = " . $_SESSION['id'] . " AND id_parking = $id";
				if ($rs = $mysqli->query($sql)) {
					if ($rs->num_rows == 1 || $_SESSION['tip'] == 1) {
						$sql = "SELECT * FROM kazna WHERE parking_id_parking = $id AND korisnik_id_korisnik = " . $auto['id_korisnik'] . " AND karta_id_karta = " . $karta['id_karta'];
						if ($rs = $mysqli->query($sql)) {
							if ($rs->num_rows == 1) {
								echo "<td>Isporučena kazna</td>";
								echo "</tr>";
							} else {
								$sql = "SELECT pomak FROM pomak";
								$rs = $mysqli->query($sql);
								$pomak = $rs->fetch_assoc();

								if ($karta['tip_karte_id_tip_karte'] == 1) {
									$datumKupnje = $karta['vrijeme'];
									$datumIsteka = date('Y-m-d h:i:s', strtotime($datumKupnje. ' + 1 day'));
									
									$vrijeme_servera = time();
									$vrijeme_sustava = $vrijeme_servera + ($pomak['pomak'] * 60 * 60);
									$trenutnoVrijeme = date('Y-m-d', $vrijeme_sustava);

									if ($trenutnoVrijeme > $datumIsteka) {
										$istekTimeStamp = strtotime($datumIsteka);
										$trenutnoTimeStamp = strtotime($trenutnoVrijeme);
										$rezultat = $trenutnoTimeStamp - $istekTimeStamp;
										$kaznaSati = intval(($rezultat + 86400)/60/60);
										
										$sql = "SELECT cijena_sat FROM parking WHERE id_parking = $id";
										if ($rs = $mysqli->query($sql)) {
											$row = $rs->fetch_row();
											$cijenaKazna = $row[0];
											
											$kazna = $kaznaSati * $cijenaKazna;
										}
										echo "<form action='kazna.php' method='POST'>";
										echo "<input type='hidden' name='kazna' value='$kazna'>";
										echo "<input type='hidden' name='idKor' value='" . $auto['id_korisnik'] ."'>";
										echo "<input type='hidden' name='idPar' value='$id'>";
										echo "<input type='hidden' name='idKar' value='" . $karta['id_karta'] . "'>";
										echo "<td><a href='kazna.php'><input type='submit' value='Isporuči kaznu'></a></td>";
										echo "</form>";
									} else {
										echo "<td></td>";
									}
									
								} else if ($karta['tip_karte_id_tip_karte'] == 2) {
									$datumKupnje = $karta['vrijeme'];
									$datumIsteka = date('Y-m-d h:i:s', strtotime($datumKupnje. ' + 1 month'));
									
									$vrijeme_servera = time();
									$vrijeme_sustava = $vrijeme_servera + ($pomak['pomak'] * 60 * 60);
									$trenutnoVrijeme = date('Y-m-d', $vrijeme_sustava);
									
									if ($trenutnoVrijeme > $datumIsteka) {
										
										$istekTimeStamp = strtotime($datumIsteka);
										$trenutnoTimeStamp = strtotime($trenutnoVrijeme);
										$rezultat = $trenutnoTimeStamp - $istekTimeStamp;
										$kaznaSati = intval(($rezultat + 86400)/60/60);
										
										$sql = "SELECT cijena_sat FROM parking WHERE id_parking = $id";
										if ($rs = $mysqli->query($sql)) {
											$row = $rs->fetch_row();
											$cijenaKazna = $row[0];
											
											$kazna = $kaznaSati * $cijenaKazna;
										}
										echo "<form action='kazna.php' method='POST'>";
										echo "<input type='hidden' name='kazna' value='$kazna'>";
										echo "<input type='hidden' name='idKor' value='" . $auto['id_korisnik'] ."'>";
										echo "<input type='hidden' name='idPar' value='$id'>";
										echo "<input type='hidden' name='idKar' value='" . $karta['id_karta'] . "'>";
										echo "<td><a href='kazna.php'><input type='submit' value='Isporuči kaznu'></a></td>";
										echo "</form>";
									} else {
										echo "<td></td>";
									}
								}
							echo "</tr>";
							}
						}
					} else {
						echo "</tr>";
					}
				}
			}
		}		
	}
}
echo "</tbody>";

echo "</table>";

?>

<?php
include('podnozje.php');
?>  