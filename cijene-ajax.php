<?php
include_once('baza.class.php');

$baza = new Baza();
$mysqli = $baza->spojiDB();

$id = $_POST['id'];

$sql = "SELECT tip_karte_id, cijena FROM parking_cijena WHERE parking_id = $id";

if ($rs = $mysqli->query($sql)) {
	while ($row = $rs->fetch_assoc()){
		$cijene[] = array(
		    'id' => $row['tip_karte_id'],
		    'cijena' => $row['cijena'],
		  	);
	}
	echo json_encode($cijene);
}

?>