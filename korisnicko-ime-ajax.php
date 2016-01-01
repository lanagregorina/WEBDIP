<?php
ob_start();
session_start();
include_once('baza.class.php');

$baza = new Baza();
$mysqli = $baza->spojiDB();

$korIme = $_POST['korisnicko-ime'];

$sql = "SELECT * FROM korisnik WHERE korisnicko_ime = '$korIme'";

if ($rs = $mysqli->query($sql)) {
	if ($rs->num_rows != 0 && $korIme != $_SESSION['username']) {
		echo 0;
	} else {
		echo 1;
	}
}

?>