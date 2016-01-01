<?php
include('zaglavlje.php');

if (!isset($_SESSION['username'])) {
    header('location:prijava.php');
}

include_once('baza.class.php');

if ($_SESSION['tip'] != 1) {
	header('location:index.php');
}

$baza = new Baza();
$mysqli = $baza->spojiDB();

$sql = "SELECT pomak FROM pomak";
$rs = $mysqli->query($sql);
$pomak = $rs->fetch_assoc();

$vrijeme_servera = time();
$vrijeme_sustava = $vrijeme_servera + ($pomak['pomak'] * 60 * 60);
$trenutnoVrijeme = date('Y-m-d', $vrijeme_sustava);

$sql = "SELECT ime, prezime, email, reg_oznaka, vrijeme FROM korisnik
		JOIN karta ON korisnik.id_korisnik = karta.id_korisnik JOIN tip_karte ON id_tip_karte = tip_karte_id_tip_karte
		WHERE tip_karte_id_tip_karte = 2 AND DATE_ADD(vrijeme,INTERVAL 1 MONTH) > '$trenutnoVrijeme'
		AND DATE_ADD(DATE_ADD(vrijeme,INTERVAL 1 MONTH), INTERVAL -3 DAY) < '$trenutnoVrijeme'";

if ($rs = $mysqli->query($sql)) {
	$korisnici = array();
	while ($korisnik = $rs->fetch_assoc()) {
		$korisnici[] = $korisnik;
	}
}

echo "<table border=1 class='tablica'>";
echo "<thead>";
echo "<tr>";
echo "<th>Ime</th>";
echo "<th>Prezime</th>";
echo "<th>Registracija</th>";
echo "<th>Datum kupnje</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach ($korisnici as $kor) {
	echo "<tr>";
	echo "<td>" . $kor['ime'] . "</td>";
	echo "<td>" . $kor['prezime'] . "</td>";
	echo "<td>" . $kor['reg_oznaka'] . "</td>";
	echo "<td>" . $kor['vrijeme'] . "</td>";
	echo "<tr></tr>";
}
echo "</tbody>";
echo "</table>";
echo "<a href='parking-notifikacije.php?action=salji'><input type='button' id='gumb-parking' value='Pošalji notifkacije'></a>";

if ($_GET['action'] == 'salji') {
	$message = "Poštovani, Vaša mjesečna karta ističe u roku od 3 dana. Molimo produžite Vašu kartu ukoliko želite nastaviti koristite usluge eParkinga. Hvala!";
	$headers = "Content-Type: text/html; charset=UTF-8";

	foreach ($korisnici as $kor) {
		mail($kor['email'], 'Istek mjesečne karte', $message, $headers);
	}
}

?>

<?php
include('podnozje.php');
?>  