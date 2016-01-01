<?php
ob_start();
session_start();

include('baza.class.php');
include('dnevnik.php');

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
	
	$baza = new Baza();
	$mysqli = $baza->spojiDB();

	$sql = "UPDATE kazna SET placeno = 1 WHERE id_kazna = $id";
	if ($rs = $mysqli->query($sql)) {
		$sql = "SELECT ime, prezime FROM korisnik WHERE id_korisnik = " . $_SESSION['id'];
		if ($rs = $mysqli->query($sql)) {
			$korisnik = $rs->fetch_assoc();
			pisi("Plaćena kazna. Korisnik: " . $korisnik['ime'] . " " . $korisnik['prezime']);
		}
		
		echo "OK";
	} else {
		echo "Greška: " . mysqli_error($mysqli);
	}
}

?>