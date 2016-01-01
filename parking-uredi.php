<?php
include('zaglavlje.php');
include_once('baza.class.php');

if (!isset($_SESSION['username'])) {
    header('location:prijava.php');
}

if (isset($_GET['id'])) {
	$id = intval($_GET['id']);
	
	$baza = new Baza();
	$mysqli = $baza->spojiDB();
	
	$sql = "SELECT * FROM parking WHERE id_parking = $id";
	if ($rs = $mysqli->query($sql)) {
		$parking = $rs->fetch_assoc();

		if ($_SESSION['tip'] == 1) {
			$sql = "SELECT cijena FROM parking_cijena WHERE parking_id = $id";
			if ($rs = $mysqli->query($sql)) {
				$cijene = array();
				while ($cijena = $rs->fetch_assoc()) {
					$cijene[] = $cijena;
				}
			}
		}
		else if ($_SESSION['tip'] != 1 && $_SESSION['tip'] != 2 || $_SESSION['id'] != $parking['zaposlenik']) {
		    header('location:index.php');
		}
	}
}

if (isset($_POST['uredi'])) {
	$opis = $_POST['opis'];
	$brojMjesta = $_POST['broj-mjesta'];
	$cijenaDan = $_POST['cijena-dan'];
	$cijenaMjesec = $_POST['cijena-mjesec'];
	$cijenaSat = $_POST['cijena-sat'];
	$zaposlenik = $_POST['zaposlenik'];

	$sql = "UPDATE parking SET opis = '$opis', broj_mjesta = $brojMjesta, cijena_sat = '$cijenaSat', zaposlenik = $zaposlenik WHERE id_parking = $id";
	if ($rs = $mysqli->query($sql)) {
		$sql = "UPDATE parking_cijena SET cijena = $cijenaDan WHERE tip_karte_id = 1 AND parking_id = $id";
		$mysqli->query($sql);
		$sql = "UPDATE parking_cijena SET cijena = $cijenaMjesec WHERE tip_karte_id = 2 AND parking_id = $id";
		$mysqli->query($sql);
		
		header('location:parking.php');
		
	} else {
		$poruka = "Greška kod ažuriranja parkinga!";
	}
}
?>

<section id="sadrzaj">
            <article id="prijava">
                <form action="" method="POST">
                    
                    <label for="opis">Opis</label>
                    <input type="text" name="opis" value="<?php echo $parking['opis'];?>"><br/>
                    
                    <label for="broj-mjesta">Broj mjesta</label>
                    <input type="text" name="broj-mjesta" value=<?php echo $parking['broj_mjesta'];?>><br/>

                    <label for="cijena-dan">Cijena - dan</label>
                    <input type="text" name="cijena-dan" value=<?php echo $cijene[0]["cijena"];?>><br/>

                    <label for="cijena-mjesec">Cijena - mjesec</label>
                    <input type="text" name="cijena-mjesec" value=<?php echo $cijene[1]["cijena"];?>><br/>
					
					<label for="cijena-sat">Cijena - sat (kazna)</label>
                    <input type="text" name="cijena-sat" value=<?php echo $parking['cijena_sat'];?>><br/>
					
					<label for="zaposlenik">Zaposlenik</label>
					<select name="zaposlenik" id="zaposlenik">
					<?php
					$sql = "SELECT id_korisnik, ime, prezime FROM korisnik WHERE tip_korisnika_id_tip_korisnika = 2";
					if ($rs = $mysqli->query($sql)) {
						while ($korisnik = $rs->fetch_assoc()) {
							echo '<option value="' . $korisnik['id_korisnik'] . '"';
							if($korisnik['id_korisnik'] == $parking['zaposlenik']) { 
								echo 'selected'; 
							}
							echo '>' . $korisnik['ime'] . ' ' . $korisnik['prezime'];
							echo '</option>';
						}
					}
					?>
					</select>
					<br>
					
                    <input type="submit" name="uredi" value="Uredi" class="gumb"/><br/>

                    <span><?php echo $poruka;?></span>
                </form>
            </article>
        </section>
		
<?php
include('podnozje.php');
?>  