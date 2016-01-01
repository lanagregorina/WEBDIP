<?php
ob_start();
session_start();

include('baza.class.php');
include('dnevnik.php');

if (isset($_POST['id'])) {
	$id = intval($_POST['id']);
	
	$baza = new Baza();
	$mysqli = $baza->spojiDB();

	if ($_POST['action'] == 'move') {
		$sql = "UPDATE korisnik SET parking = NULL, vrijeme_parkiranja = NULL WHERE id_korisnik = " . $_SESSION['id'];
		if ($rs = $mysqli->query($sql)) {
			$sql = "SELECT ime, prezime, reg_oznaka, opis FROM korisnik, parking WHERE id_parking = $id AND id_korisnik = " . $_SESSION['id'];
			if($rs = $mysqli->query($sql)) {
				$row = $rs->fetch_assoc();
				pisi("Maknut automobil " . $row['reg_oznaka'] . " s parkirališta " . $row['opis']);
				echo "OK";
				//header('location:parking.php');
			}
		}
	} else if ($_POST['action'] == 'park') {
		$timestamp = date("Y-m-d");
		$sql = "UPDATE korisnik SET parking = $id, vrijeme_parkiranja = '$timestamp' WHERE id_korisnik = " . $_SESSION['id'];
		if ($rs = $mysqli->query($sql)) {
			$sql = "SELECT ime, prezime, reg_oznaka, opis FROM korisnik JOIN parking ON korisnik.parking = parking.id_parking WHERE id_korisnik = " . $_SESSION['id'];
			if($rs = $mysqli->query($sql)) {
				$row = $rs->fetch_assoc();
				pisi("Parkiran automobil " . $row['reg_oznaka'] . " na parkiralištu " . $row['opis']);
				echo "OK";
				//header('location:parking.php');
			}
		}
	}
}
?>