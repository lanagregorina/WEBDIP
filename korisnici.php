<?php
include('zaglavlje.php');

if (!isset($_SESSION['username'])) {
    header('location:prijava.php');
} else {
    if ($_SESSION['tip'] != 1) {
        header('location:index.php');
    }
}

include_once('baza.class.php');

$baza = new Baza();
$mysqli = $baza->spojiDB();

$sql = "SELECT id_korisnik, ime, prezime, korisnicko_ime, neuspjele_prijave, marka_automobila, reg_oznaka, status FROM korisnik";

if ($rs = $mysqli->query($sql)) {
$korisnici = array();
	while ($row = $rs->fetch_assoc()){
		$korisnici[] = $row;
	}
}

echo "<table class='tablica' border=1>";
echo "<thead>";
echo "<tr>";
echo "<th>Ime</th>";
echo "<th>Prezime</th>";
echo "<th>Korisničko ime</th>";
echo "<th>Marka automobila</th>";
echo "<th>Registracija</th>";
echo "<th>Akcija</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach ($korisnici as $kor) {
	echo "<tr>";
	echo "<td>" . $kor['ime'] . "</td>";
	echo "<td>" . $kor['prezime'] . "</td>";
	echo "<td>" . $kor['korisnicko_ime'] . "</td>";
	echo "<td>" . $kor['marka_automobila'] . "</td>";
	echo "<td>" . $kor['reg_oznaka'] . "</td>";
	if ($kor['status'] == 2) {
		echo "<td><a href='korisnici-evidencija.php?id=". $kor['id_korisnik'] . "&action=otkljucaj'><input type='button' value='Otključaj'></a></td>";
	}
	else {
		echo "<td><a href='korisnici-evidencija.php?id=". $kor['id_korisnik'] . "&action=blokiraj'><input type='button' value='Blokiraj'></a></td>";
	}
	echo "<td><a href='korisnik-uredi.php?id=". $kor['id_korisnik'] . "'><input type='button' value='Uredi'></a></td>";
	echo "</tr>";
	
}
echo "</tbody>";

echo "</table>";
?>

<?php
include('podnozje.php');
?>        
