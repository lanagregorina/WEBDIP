<?php
ob_start();
session_start();

include_once("baza.class.php");

$baza = new Baza();
$mysqli = $baza->spojiDB();

$sql = "SELECT pomak FROM pomak";
$rs = $mysqli->query($sql);
$pomak = $rs->fetch_assoc();

$vrijemeServera = time();
$vrijemeSustava = $vrijemeServera + ($pomak['pomak'] * 60 * 60);

if (isset ($_SESSION['username']) && isset($_SESSION['LAST_ACTIVITY']) && ($vrijemeSustava - $_SESSION['LAST_ACTIVITY'] > 1800) && $_SESSION['tip'] != 1) {
    session_unset();
    session_destroy();
	
	header('Location:prijava.php');
}

$_SESSION['LAST_ACTIVITY'] = $vrijemeSustava;
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/lgregori_2.css" />
		
		<!-- jQuery lib -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    </head>
    <body>
   <header id="zaglavlje">
            <nav id="meni">
                <ul>
					<li><a href="index.php"><b>Početna stranica</b></a></li>
					<?php
					if(!isset($_SESSION['username'])) {
						echo '
                    <li><a href="prijava.php"><b>Prijava</b></a></li>
                    <li><a href="registracija.php"><b>Registracija</b></a></li>
					';
					}
					?>
					<li><a href="parking.php"><b>Parking</b></a> </li>
					<?php
					if($_SESSION['tip'] == 3) {
							echo '<li><a href="parking-placanje.php"><b>Plaćanje parkinga</b></a></li>';
						}
					?>
                    <li><a href="eParking.php"><b>Dokumentacija</b></a></li>
					<?php
						if($_SESSION['tip'] == 3) {
							echo '<li><a href="moj-racun.php"><b>Moj račun</b></a></li>';
							echo '<li><a href="kosarica.php"><b>Košarica</b></a></li>';
						}
						if($_SESSION['tip'] == 1) {
							echo '<li><a href="korisnici.php"><b>Korisnici</b></a></li>';
							echo '<li><a href="dnevnik-pregled.php"><b>Dnevnik rada</b></a></li>';
							echo '<li><a href="konfiguracija.php"><b>Konfiguracija sustava</b></a></li>';
						}
						if(isset($_SESSION['username'])) {
							?>
							<li><a href="odjava.php"<?if (isset($_SESSION['karte'])) { ?> onclick="return confirm('Jeste li sigurni? Još uvijek postoje stavke u Vašoj košarici!')" <?php } ?>><b>Odjava</b></a></li>
							<?php
						}
						if (isset($_SESSION['username'])) {
							echo "<div id='login-div'>";
							echo "Prijavljeni korisnik: <a id='login-div-a' href='korisnik-detalji.php?id=" . $_SESSION['id'] . "'>" . $_SESSION['username'] . "</a>";
							echo "</div>";
						}
					?> 
					

                </ul>
            </nav>
        </header> 
        