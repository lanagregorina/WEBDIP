<?php
include_once('baza.class.php');

function virtualnoVrijeme () {

	$url = "http://arka.foi.hr/PzaWeb/PzaWeb2004/config/pomak.xml";
	if (!($fp = fopen($url, 'r'))) {
		echo "Problem: nije moguće otvoriti url: " . $url;
		exit;
	}

	$xml_string = fread($fp, 10000);
	fclose($fp);

	$domdoc = new DOMDocument;
	$domdoc->loadXML($xml_string);
	$params = $domdoc->getElementsByTagName('pomak');
	$sati = 0;
	foreach ($params as $param) {
		$attributes = $param->attributes;
		foreach ($attributes as $attr => $val) {
			if ($attr == "brojSati") {
				$sati = $val->value;
			}
		}
	}
	$vrijeme_servera = time();
	$vrijeme_sustava = $vrijeme_servera + ($sati * 60 * 60);

	echo "<div id='pomak'>";
	echo "Stvarno vrijeme servera: " . date('d.m.Y H:i:s', $vrijeme_servera) . "<br>";
	echo "Virtualno vrijeme sustava: " . date('d.m.Y H:i:s', $vrijeme_sustava) . "<br>";
	echo "</div>";

	$baza = new Baza();
	$mysqli = $baza->spojiDB();

	$sql = "UPDATE pomak SET pomak = $sati";
	$mysqli->query($sql);

	return $vrijeme_sustava;
}
?>