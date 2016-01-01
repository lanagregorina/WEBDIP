<?php
include('zaglavlje.php');
include_once('baza.class.php');
include_once('dnevnik.php');
?>
        <section id="sadrzaj">
            <article id="prijava">
                <form action="" method="POST">
                    
                    <label for="korisnicko_ime">Korisničko ime</label>
                    <input type="text" name="korisnicko_ime" class="korisnicko_ime" id="korisnicko_ime" autofocus required pattern=".{6,}" placeholder="korisničko ime"
						   value="<?php echo $_COOKIE['username'];?>"/><br/>
                    
                    <label for="lozinka">Lozinka</label>
                    <input type="password" name="lozinka" id="lozinka" class="lozinka" required pattern=".{6,}" placeholder="lozinka"/><br/>
                    
					<a id="zaboravljena_lozinka" href="zaboravljena_lozinka.php">Zaboravili ste lozinku?</a>
					
                    <input type="submit" name="prijava" value="Prijavi se" class="gumb"/><br/>
                    
                </form>
            </article>
            <article>
                <p> <b>Registriraj se</b> <a href="registracija.php">ovdje</a></p>
            </article>
        </section>
		
		<?php
		if (isset($_POST['korisnicko_ime']) && isset($_POST['lozinka'])) {
			$username = $_POST['korisnicko_ime'];
			$password = $_POST['lozinka'];
			
			$baza = new Baza();
			$mysqli = $baza->spojiDB();
			
			$sql = "SELECT id_korisnik, korisnicko_ime, lozinka, neuspjele_prijave, status, tip_korisnika_id_tip_korisnika FROM korisnik WHERE korisnicko_ime = '$username' AND lozinka = '$password'";
			if ($rs = $mysqli->query($sql)) {
				if ($rs->num_rows == 1) {
					$korisnik = $rs->fetch_assoc();
					if ($korisnik['status'] == 1) {
						$sql = "UPDATE korisnik SET neuspjele_prijave = 0 WHERE id_korisnik = " . $korisnik['id_korisnik'];
						$mysqli->query($sql);
						$_SESSION['username'] = $username;
						$_SESSION['id'] = $korisnik['id_korisnik'];
						$_SESSION['tip'] = $korisnik['tip_korisnika_id_tip_korisnika'];
						setcookie('username', $_POST['korisnicko_ime']);
						
						pisi("Uspješna prijava korisnika: " . $username . " s lozinkom: " . $password);
						
						header('location:index.php');
					} else if ($korisnik['status'] == 2) {
						echo "Vaš korisnički račun je zaključan.";
					} else if ($korisnik['status'] == 0) {
						echo "Morate potvrditi Vaš korisnički račun!";
					}
				} else {
					$sqlKor = "SELECT * FROM korisnik WHERE korisnicko_ime = '$username'";
					$rsKor = $mysqli->query($sqlKor);
					$kor = $rsKor->fetch_assoc();
					
					if ($kor['neuspjele_prijave'] >= 2) {
						$sql = "UPDATE korisnik SET status = 2 WHERE id_korisnik = " . $kor['id_korisnik'];
						$mysqli->query($sql);
						echo "Vaš korisnički račun je zaključan.";
						pisi("Zaključavanje korisničkog računa: " . $username);
						exit();
					}
					
					echo "Korisničko ime i/ili lozinka nisu ispravni!";
					pisi("Neuspješna prijava korisnika: " . $username . " s lozinkom: " . $password);
					
					$sql = "UPDATE korisnik SET neuspjele_prijave = neuspjele_prijave + 1 WHERE id_korisnik = " . $kor['id_korisnik'];
					$mysqli->query($sql);
				}
			}
		}
		
		
		?>
		
 <?php
include('podnozje.php');
?>  