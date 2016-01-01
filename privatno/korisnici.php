<?php
header('Content-type: text/html; charset=utf-8');
include_once('../baza.class.php');

$baza = new Baza();
$mysqli = $baza->spojiDB();

$ime = "lana";

$sql = "SELECT ime, prezime, korisnicko_ime, lozinka, naziv FROM korisnik JOIN tip_korisnika ON tip_korisnika_id_tip_korisnika = id_tip_korisnika";
if ($rs = $mysqli->query($sql)) {
	$korisnici = array();
	while ($korisnik = $rs->fetch_assoc()) {
		$korisnici[] = $korisnik;
	}
}

echo "<table border='1'>";
echo "<thead>";
echo "<tr>";
echo "<th>Ime</th>";
echo "<th>Prezime</th>";
echo "<th>Korisničko ime</th>";
echo "<th>Lozinka</th>";
echo "<th>Tip korisnika</th>";
echo "</tr>";
echo "<tbody>";
echo "</tbody>";
echo "<tr>";
foreach ($korisnici as $kor) {
	echo "<td>" . $kor['ime'] . "</td>";
	echo "<td>" . $kor['prezime'] . "</td>";
	echo "<td>" . $kor['korisnicko_ime'] . "</td>";
	echo "<td>" . $kor['lozinka'] . "</td>";
	echo "<td>" . $kor['naziv'] . "</td>";
	echo "</tr>";
}
echo "</thead>";
echo "</table>"

?>