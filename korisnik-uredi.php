<?php
include('zaglavlje.php');
include_once('baza.class.php');
include('dnevnik.php');

if (!isset($_SESSION['username'])) {
    header('location:prijava.php');
}

$baza = new Baza();
$mysqli = $baza->spojiDB();

$id = intval($_GET['id']);

if ($id != $_SESSION['id'] && $_SESSION['tip'] != 1) {
     header('location:index.php');
}

$sql = "SELECT * FROM korisnik WHERE id_korisnik = $id";
if ($rs = $mysqli->query($sql)) {
	$korisnik = $rs->fetch_assoc();
}

if (isset($_POST['registracija'])) {
	$ime = $_POST['ime'];
	$prezime = $_POST['prezime'];
	$adresa = $_POST['adresa'];
	$grad = $_POST['grad'];
	$email = $_POST['e_mail'];
	$korIme = $_POST['korisnicko_ime'];
	$lozinka = $_POST['lozinka'];
	$datumRodjenja = $_POST['datum_rodenja'];
	$spol = $_POST['spol'];
	$markaAutomobila = $_POST['marka-automobila'];
	$regOznaka = $_POST['reg-oznaka'];
     $tipKor = $_POST['tip'];

	$sql = "UPDATE korisnik SET ime = '$ime', prezime = '$prezime', adresa = '$adresa', grad = '$grad', email = '$email',
			korisnicko_ime = '$korIme', lozinka = '$lozinka', datum_rodenja = '$datumRodjenja', spol = '$spol', 
			marka_automobila = '$markaAutomobila', reg_oznaka = '$regOznaka', tip_korisnika_id_tip_korisnika = $tipKor WHERE id_korisnik = $id";
	if ($rs = $mysqli->query($sql)) {
		pisi("Ažuriranje podataka, korisnik: " . $korIme);
		header('location: korisnik-detalji.php?id=' . $id);
	} else {
		echo "Greška: " . mysqli_error($mysqli) . " Tip: " . $_POST['tip'];
	}
}

?>

<section id="sadrzaj">
            <form action="" method="POST">
                    <label for="ime" class="ime">Ime</label>
                    <input type="text" name="ime" id="ime" required class="unos" value=<?php echo $korisnik['ime'];?>><br/>
                    <p id="ime_greska" class="ime_greska"></p><br/>
                    
                    <label for="prezime">Prezime</label>
                    <input type="text" name="prezime" id="prezime" required value=<?php echo $korisnik['prezime'];?>><br/>
                    <p id="prezime_greska" class="prezime_greska"></p><br/>
                     
                    <label for="adresa">Adresa</label>
                    <input type="text" name="adresa" id="adresa" value="<?php echo $korisnik['adresa'];?>"><br/>
                    
                    <label for="grad">Grad</label>
                    <input type="text" name="grad" id="grad" value="<?php echo $korisnik['grad'];?>"><br/>
                
                    <label for="e_mail">E-mail</label>
                    <input type="email" name="e_mail" id="e_mail" pattern=".+@foi.hr" required placeholder="ime.prezime@foi.hr" value=<?php echo $korisnik['email'];?>><br/>
                    
					
                    <label for="korisnicko_ime">Korisničko ime</label>
                    <input type="text" name="korisnicko_ime" id="korisnicko_ime" pattern=".{6,}" required placeholder="Najmanje 6 znakova" value=<?php echo $korisnik['korisnicko_ime'];?>><br/>
					
					<span id="username-span" class="username-span"></span>
                    
                    <script type="text/javascript">
						$( "#korisnicko_ime" ).blur(function() {
							if ($("#korisnicko_ime").val().length >= 6) {
							  $.ajax({
								type: "POST",
								url: "korisnicko-ime-ajax.php",
								data: "korisnicko-ime=" + $("#korisnicko_ime").val(),
								cache: false,
								processData: false,
								success:  function(data){
									if (data == '0') {
										$("#username-span").html("Korisničko ime je zauzeto!");
										$("#username-span").attr('class', 'username-span');
									} else if (data == '1') {
										$("#username-span").html("Korisničko ime je slobodno!");
										$("#username-span").attr('class', 'username-span-2');
									}
								}
							});
							} else {
								$("#username-span").html("");
							}
						});
					</script>
                    
                    <div class="za_lozinku">
                    <label for="lozinka">Lozinka:</label>
                    <input type="password" name="lozinka" id="lozinka" pattern=".{6,}" required placeholder="Najmanje 6 znakova" value=<?php echo $korisnik['lozinka'];?>><br/></div>
                    <div class="za_lozinku">
                    <label for="ponovi_lozinka">Ponovi lozinku:</label>
                    <input type="password" name="ponovi_lozinka" id="ponovi_lozinka" onkeyup="provjeraLozinke(); return false;" pattern=".{6,}" required placeholder="Najmanje 6 znakova" value=<?php echo $korisnik['lozinka'];?>><br/>
                    <span id="potvrdna_poruka" class="potvrdna poruka"><br/></span></div>

                    <label for="datum_rodenja">Datum rođenja</label>
                    <input type="text" name="datum_rodenja" id="datum_rodenja" required value=<?php echo $korisnik['datum_rodenja'];?>><br/>
                    
                    <label for="spol">Odaberite spol</label>
                    <select id="spol" name="spol">
                    <option value="none" selected disabled>Odaberi</option>
                    <option value="female" <?php if ($korisnik['spol'] == 'female') echo "selected";?>>Ženski</option>
                    <option value="male" <?php if ($korisnik['spol'] == 'male') echo "selected";?>>Muški</option>
                    </select><br/>
					
				<label for="marka-automobila">Marka automobila</label>
                    <input type="text" name="marka-automobila" id="marka-automobila" required value=<?php echo $korisnik['marka_automobila'];?>><br/>
					
				<label for="reg-oznaka">Registracijska oznaka</label>
                    <input type="text" name="reg-oznaka" id="reg-oznaka" required value=<?php echo $korisnik['reg_oznaka'];?>><br/>
                    
                    <?php
                    $sql = "SELECT id_tip_korisnika, naziv FROM tip_korisnika";
                    if ($rs = $mysqli->query($sql)) {
                    	$tipovi = array();
                    	while ($tip = $rs->fetch_assoc()) {
                    		$tipovi[] = $tip;
                    	}
                    }

                    if ($_SESSION['tip'] != 1) {
                    	$hidden = "hidden";
                    } else {
                    	$hidden = "";
                         echo '<label for="tip">Tip korisnika</label>';
                    }

                    echo '<select style="visibility: ' . $hidden . '" id="tip" name="tip"' . $disabled . '>';
                    foreach ($tipovi as $tip) {
                    	if ($korisnik['tip_korisnika_id_tip_korisnika'] == $tip['id_tip_korisnika']) {
                    		$selected = "selected";
                    	} else {
                    		$selected = "";
                    	}
                    	echo '<option value="' . $tip['id_tip_korisnika'] . '"' . $selected . '>' . $tip['naziv'] . '</option>';
                    }
                    echo "</select>";
                    echo "<br>";

                    ?>

                    <input type="submit" name="registracija" id="registracija" class="gumb_reg" value="Ažuriraj"/>
					
				<span><?php echo $greske;?></span>
                    
                                                            
                </form>
				<script>
			  $(function() {
				$('#datum_rodenja').datepicker({ dateFormat: 'yy-mm-dd' });
			  });
			  </script>
			  <script type="text/javascript" src="JS/lgregori.js"></script>
            
        </section>