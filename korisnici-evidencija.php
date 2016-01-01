<?php
include_once('baza.class.php');

if (isset($_GET['action'])) {
	$action = $_GET['action'];
	
	switch($action) {
		case 'otkljucaj':
			$id = intval($_GET['id']);
			otkljucajKorisnika($id);
			break;
		case 'blokiraj':
			$id = intval($_GET['id']);
			blokirajKorisnika($id);
			break;
	}
}

function otkljucajKorisnika($id) {
	$baza = new Baza();
	$mysqli = $baza->spojiDB();
	
	$sql = "UPDATE korisnik SET status = 1 WHERE id_korisnik = " . $id;
	
	if ($rs = $mysqli->query($sql)) {
		header('location:korisnici.php');
	}
}

function blokirajKorisnika($id) {
	$baza = new Baza();
	$mysqli = $baza->spojiDB();
	
	$sql = "UPDATE korisnik SET status = 2 WHERE id_korisnik = " . $id;
	
	if ($rs = $mysqli->query($sql)) {
		header('location:korisnici.php');
	}
}
?>