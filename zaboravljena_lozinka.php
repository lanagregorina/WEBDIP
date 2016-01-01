<?php
include('zaglavlje.php');
include('baza.class.php');
include_once('dnevnik.php');
?>
<section id="sadrzaj">
            <article id="prijava">
                <form action="" method="POST">
                    
                    <label for="email">Email adresa</label>
                    <input type="email" name="email" id="email" autofocus required placeholder="Unesite email adresu"
						   value="<?php echo $_COOKIE['username'];?>"/><br/>
		
                    <input type="submit" name="posalji" value="Pošalji" class="gumb"/><br/>
                    
                </form>
            </article>
        </section>
		
<?php
if (isset($_POST['email'])) {
	$email = $_POST['email'];
	
	$baza = new Baza();
	$mysqli = $baza->spojiDB();
	
	$sql = "SELECT id_korisnik, korisnicko_ime FROM korisnik WHERE email = '$email'";
	if ($rs = $mysqli->query($sql)) {
		if ($rs->num_rows == 1) {
			$random = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,50 ) ,1 ) .substr( md5( time() ), 1);
			$novaLozinka = substr($random, 0, 6);
			
			$kor = $rs->fetch_assoc();
			$id = $kor['id_korisnik'];
			$korIme = $kor['korisnicko_ime'];
			
			$primatelj = $email;
            $naslov = "Zaboravljena lozinka";
            $poruka = "Postovani, 
					   šaljemo Vam ovaj mail s obzirom na Vaš zahtjev za generiranjem nove lozinke. \n
					   Nova lozinka: '$novaLozinka'";
            mail($primatelj, $naslov, $poruka);
			
			$sql = "UPDATE korisnik SET lozinka = '$novaLozinka' WHERE id_korisnik = '$id'";
			if ($rs = $mysqli->query($sql)) {
				pisi("Zahtjev za novom lozinkom, korisnik: " . $korIme);
				header("Location: prijava.php");
			} else {
				echo "Dogodila se pogreška.";
			}
            
		} else {
			echo $rs->num_rows();
		}
	}
}
?>

<?php
include('podnozje.php');
?>  