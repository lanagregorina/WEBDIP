<?php
include('zaglavlje.php');

if (!isset($_SESSION['username'])) {
    header('location:prijava.php');
}

if ($_SESSION['tip'] != 1) {
	header('location:index.php');
}

include('baza.class.php');

$baza = new Baza();
$mysqli = $baza->spojiDB();

$opis = $_POST['opis'];
$brojMjesta = $_POST['broj-mjesta'];
$cijenaDan = $_POST['cijena-dan'];
$cijenaMjesec = $_POST['cijena-mjesec'];
$cijenaSat = $_POST['cijena-sat'];
$zaposlenik = $_POST['zaposlenik'];

if (isset($_POST['dodaj'])) {

	if (empty($opis)) {
		$poruka .= "Morate unijeti opis!<br>";
	}

	if (empty($brojMjesta)) {
		$poruka .= "Morate unijeti broj mjesta!<br>";
	}

	if (empty($cijenaDan)) {
		$poruka .= "Morate unijeti dnevnu cijenu!<br>";
	}

	if (empty($cijenaMjesec)) {
		$poruka .= "Morate unijeti mjesečnu cijenu!<br>";
	}
	
	if (empty($cijenaSat)) {
		$poruka .= "Morate unijeti cijenu za sat (kaznu)!<br>";
	}
	
	if (empty($zaposlenik)) {
		$poruka .= "Morate odabrati zaposlenika!<br>";
	}

	if (empty($poruka)) {
		$id;
		$sql = "INSERT INTO parking VALUES (DEFAULT, '$opis', $brojMjesta, $cijenaSat, $zaposlenik)";
		echo $sql;
		if ($rs = $mysqli->query($sql)) {
			$id = mysqli_insert_id($mysqli);

			$sql = "INSERT INTO parking_cijena VALUES ($id, 1, '$cijenaDan'), ($id, 2, '$cijenaMjesec')";
			if ($rs = $mysqli->query($sql)) {
				$poruka = "Uspješan unos parkinga!";
			} else {
				$poruka = "Greška kod unosa parkinga!" . mysqli_error($mysqli);
			}
		} else {
			$poruka = "Greška kod unosa parkinga!" . mysqli_error($mysqli);
		}
	}
}

?>

<section id="sadrzaj">
            <article id="prijava">
                <form action="" method="POST">
                    
                    <label for="opis">Opis</label>
                    <input type="text" name="opis" value="<?php echo $opis;?>"><br/>
                    
                    <label for="broj-mjesta">Broj mjesta</label>
                    <input type="text" name="broj-mjesta" value=<?php echo $brojMjesta;?>><br/>

                    <label for="cijena-dan">Cijena - dan</label>
                    <input type="text" name="cijena-dan" value=<?php echo $cijenaDan;?>><br/>

                    <label for="cijena-mjesec">Cijena - mjesec</label>
                    <input type="text" name="cijena-mjesec" value=<?php echo $cijenaMjesec;?>><br/>
					
					<label for="cijena-sat">Cijena - sat (kazna)</label>
                    <input type="text" name="cijena-sat" value=<?php echo $cijenaSat;?>><br/>
					
					<label for="zaposlenik">Zaposlenik</label>
					<select name="zaposlenik" id="zaposlenik">
						<option selected disabled>Odaberi</option>
					<?php
					$sql = "SELECT id_korisnik, ime, prezime FROM korisnik WHERE tip_korisnika_id_tip_korisnika = 2";
					if ($rs = $mysqli->query($sql)) {
						while ($korisnik = $rs->fetch_assoc()) {
							echo '<option value="' . $korisnik['id_korisnik'] . '">' . $korisnik['ime'] . ' ' . $korisnik['prezime'] . '</option>';
						}
					}
					?>
					</select>
					<br>
					
                    <input type="submit" name="dodaj" value="Dodaj" class="gumb"/><br/>

                    <span><?php echo $poruka;?></span>
                </form>
            </article>
        </section>
<?php
include('podnozje.php');
?>  