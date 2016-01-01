<?php
include('zaglavlje.php');
include_once('baza.class.php');
include('dnevnik.php');

$baza = new Baza();
$mysqli = $baza->spojiDB();

$idKor = $_POST['idKor'];
$idPar = $_POST['idPar'];
$idKar = $_POST['idKar'];
$iznosKazne = $_POST['kazna'];
	
$sql = "INSERT INTO kazna VALUES (DEFAULT, DEFAULT, '$iznosKazne', DEFAULT, $idPar, $idKor, $idKar)";
if ($rs = $mysqli->query($sql)) {
	pisi("Isporučena kazna korisniku " . $_POST['ime'] . " " . $_POST['prezime'] . " na parkiralištu " . $_POST['parkiraliste']);

	$path = "img/" . $_POST['reg-oznaka'];
	foreach($_FILES['slike']['tmp_name'] as $key => $tmp_name) {
	    $file_name = $_FILES['slike']['name'][$key];
	    $file_size = $_FILES['slike']['size'][$key];
	    $file_tmp = $_FILES['slike']['tmp_name'][$key];
	    $file_type = $_FILES['slike']['type'][$key];  
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
	    if (move_uploaded_file($file_tmp, $path . "/" . $file_name)) {
			header('location:parking.php');
		}
	}
}

?>

<?php

include('podnozje.php');

?>