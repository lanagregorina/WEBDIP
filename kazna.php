<?php
include('zaglavlje.php');

if (!isset($_SESSION['username'])) {
    header('location:prijava.php');
} else {
    if ($_SESSION['tip'] != 1 || $_SESSION['tip'] != 2) {
        header('location:index.php');
    }
}


include_once('baza.class.php');
include('dnevnik.php');

if (isset($_POST['kazna'])) {
	$baza = new Baza();
	$mysqli = $baza->spojiDB();
	
	$sql = "SELECT reg_oznaka, ime, prezime, korisnik.parking, opis FROM korisnik JOIN parking ON korisnik.parking = parking.id_parking WHERE id_parking = " . $_POST['idPar'] . " AND id_korisnik = " . $_POST['idKor'];
	if ($rs = $mysqli->query($sql)) {
		$row = $rs->fetch_assoc();
	}
}

if (isset($_POST['isporuci'])) {
	$idKor = $_POST['idKor'];
	$idPar = $_POST['idPar'];
	$idKar = $_POST['idKar'];
	$iznosKazne = $_POST['kazna'];

	if (count($_FILES['slike']['tmp_name']) < 3) {
		$poruka = "Morate uploadati barem 3 slike!";
	} else {
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
		} else {
			echo "Greška: " . mysqli_error($mysqli);
		}
	}
}

?>

<section id="sadrzaj">
            <article id="prijava">
                <form enctype="multipart/form-data" action="" method="POST">
                    
					<input type='hidden' name='idKor' value='<?php echo $_POST['idKor'];?>'>
					<input type='hidden' name='idPar' value='<?php echo $_POST['idPar'];?>'>
					<input type='hidden' name='idKar' value='<?php echo $_POST['idKar'];?>'>

                    <label for="reg-oznaka">Registracija</label>
                    <input type="text" name="reg-oznaka" readonly value="<?php echo $row['reg_oznaka'];?>"><br/>
                    
                    <label for="ime">Ime vlasnika</label>
                    <input type="text" name="ime" readonly value=<?php echo $row['ime'];?>><br/>

                    <label for="prezime">Prezime vlasnika</label>
                    <input type="text" name="prezime" readonly value=<?php echo $row['prezime'];?>><br/>

                    <label for="parkiraliste">Parkiralište</label>
                    <input type="text" name="parkiraliste" readonly value="<?php echo $row['opis'];?>"><br/>
					
					<label for="kazna">Iznos kazne (kn)</label>
                    <input type="text" name="kazna" readonly value=<?php echo $_POST['kazna'];?>><br/>
					
					<label for="slike">Slike automobila</label>
					<input type="file" name="slike[]" multiple><br/>

					<br>
					
                    <input type="submit" name="isporuci" value="Isporuči" class="gumb"/><br/>

                    <span><?php echo $poruka;?></span>
                </form>
            </article>
        </section>
<?php

include('podnozje.php');

?>