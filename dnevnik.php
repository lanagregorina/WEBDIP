<?php
include_once('baza.class.php');

function pisi($zapis) {
	$baza = new Baza();
	$mysqli = $baza->spojiDB();
	$sql = "INSERT INTO dnevnik VALUES (DEFAULT, '$zapis', DEFAULT)";
	$mysqli->query($sql);
}

?>