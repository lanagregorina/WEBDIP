<?php
include('zaglavlje.php');

if (!isset($_SESSION['username'])) {
    header('location:prijava.php');
}

include_once('baza.class.php');

$baza = new Baza();
$mysqli = $baza->spojiDB();

$id = intval($_GET['id']);

if ($id != $_SESSION['id']) {
    header('location:index.php');
}

$sql = "SELECT * FROM korisnik WHERE id_korisnik = $id";
if ($rs = $mysqli->query($sql)) {
	$korisnik = $rs->fetch_assoc();
}

?>

<section id="sadrzaj">
            <form action="" method="POST">
                    <label for="ime" class="ime">Ime</label>
                    <input type="text" name="ime" id="ime" readonly class="unos" value=<?php echo $korisnik['ime'];?>><br/>
                    <p id="ime_greska" class="ime_greska"></p><br/>
                    
                    <label for="prezime">Prezime</label>
                    <input type="text" name="prezime" id="prezime" readonly value=<?php echo $korisnik['prezime'];?>><br/>
                    <p id="prezime_greska" class="prezime_greska"></p><br/>
                     
                    <label for="adresa">Adresa</label>
                    <input type="text" name="adresa" id="adresa" readonly value="<?php echo $korisnik['adresa'];?>"><br/>
                    
                    <label for="grad">Grad</label>
                    <input type="text" name="grad" id="grad" readonly value="<?php echo $korisnik['grad'];?>"><br/>
                
                    <label for="e_mail">E-mail</label>
                    <input type="email" name="e_mail" id="e_mail" pattern=".+@foi.hr" readonly  placeholder="ime.prezime@foi.hr" value=<?php echo $korisnik['email'];?>><br/>
                    
					
                    <label for="korisnicko_ime">Korisničko ime</label>
                    <input type="text" name="korisnicko_ime" id="korisnicko_ime" pattern=".{6,}" readonly placeholder="Najmanje 6 znakova" value=<?php echo $korisnik['korisnicko_ime'];?>><br/>
					
					<span id="username-span" class="username-span"></span>

                    <div class="za_lozinku">
                    <label for="lozinka">Lozinka:</label>
                    <input type="password" name="lozinka" id="lozinka" pattern=".{6,}" readonly placeholder="Najmanje 6 znakova" value=<?php echo $korisnik['lozinka'];?>><br/></div>
                    <div class="za_lozinku">
                    <label for="ponovi_lozinka">Ponovi lozinku:</label>
                    <input type="password" name="ponovi_lozinka" id="ponovi_lozinka" onkeyup="provjeraLozinke(); return false;" pattern=".{6,}" readonly placeholder="Najmanje 6 znakova" value=<?php echo $korisnik['lozinka'];?>><br/>
                    <span id="potvrdna_poruka" class="potvrdna poruka"><br/></span></div>

                    <label for="datum_rodenja">Datum rođenja</label>
                    <input type="text" name="datum_rodenja" id="datum_rodenja" readonly value=<?php echo $korisnik['datum_rodenja'];?>><br/>
                    
                    <label for="spol">Odaberite spol</label>
                    <select id="spol" name="spol" disabled>
                    <option value="female" <?php if ($korisnik['spol'] == 'female') echo "selected";?>>Ženski</option>
                    <option value="male" <?php if ($korisnik['spol'] == 'male') echo "selected";?>>Muški</option>
                    </select><br/>
					
					<label for="marka-automobila">Marka automobila</label>
                    <input type="text" name="marka-automobila" id="marka-automobila" readonly value=<?php echo $korisnik['marka_automobila'];?>><br/>
					
					<label for="reg-oznaka">Registracijska oznaka</label>
                    <input type="text" name="reg-oznaka" id="reg-oznaka" readonly value=<?php echo $korisnik['reg_oznaka'];?>><br/>
                    
                    <a href="korisnik-uredi.php?id=<?php echo $id;?>"><input type="button" name="registracija" id="registracija" class="gumb_reg" value="Uredi"/>
					
					<span><?php echo $greske;?></span>                                                                            
                </form>            
        </section>
		
<?php
include('podnozje.php');
?>  