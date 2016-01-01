<?php
session_start();
ob_start();

include_once 'baza.class.php';
$baza = new Baza();

$mysqli = $baza->spojiDB();

$email = $_GET['email'];
$kljuc = $_GET['kljuc'];

$sql = "SELECT * FROM korisnik WHERE email = '$email' AND aktivacijski_kljuc = '$kljuc' AND status = 0";

if ($rs = $mysqli->query($sql)) {
	if ($rs->num_rows == 1) {
		$korisnik = $rs->fetch_assoc();
		$vrijemeRegistracije = strtotime($korisnik['vrijeme_registracije']);

		$sql = "SELECT pomak FROM pomak";
		$rs = $mysqli->query($sql);
		$pomak = $rs->fetch_assoc();

		$vrijemeServera = time();
		$vrijemeSustava = $vrijemeServera + ($pomak['pomak'] * 60 * 60);

		if ($vrijemeRegistracije + (24 * 60 * 60) < $vrijemeSustava) {
			echo "Vaš aktivacijski kod je istekao! Molimo kontaktirajte administratora.";
			echo "<a href='index.php'><input type='button' value='U redu'></a>";
		} else {
			$sql = "UPDATE korisnik SET status = 1 WHERE email = '$email'";
			if ($rs = $mysqli->query($sql)) {
				echo "Uspjesno ste aktivirali racun!";
				echo "<a href='prijava.php'><input type='button' value='U redu'></a>";
			} else {
				echo mysqli_error($mysqli);
			}
		}		
	} else {
		echo "Pogrešni podaci za aktivaciju!";
	}
}


?>