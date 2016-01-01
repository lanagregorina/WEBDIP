<?PHP
ob_start();
session_start();

include_once 'baza.class.php';
include_once('dnevnik.php');
require_once('recaptcha/recaptchalib.php');
$privatekey = "6LeqgvMSAAAAAMtOK6EXjscaKZcCNHxSrOceylf9";
$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

if (!$resp->is_valid) {
    $_SESSION['captcha'] = $resp->error;
}
$baza = new Baza();
$greske = "";
$pass = 1;


if (isset($_POST['registracija'])) {
    $kor_ime = $_POST['ime'];
    $kor_prezime = $_POST['prezime'];
    $kor_slika = (!empty($_POST['query_age']) ? $_POST['query_age'] : null);
    $kor_adresa = $_POST['adresa'];
    $kor_grad = $_POST['grad'];
    $kor_e_mail = $_POST['e_mail'];
    $kor_korisnicko_ime = $_POST['korisnicko_ime'];
    $kor_lozinka = $_POST['lozinka'];
	$kor_ponovi_lozinka = $_POST['ponovi_lozinka'];
    $kor_datum_rodenja = $_POST['datum_rodenja'];
    $kor_spol = $_POST['spol'];
    $kor_obavijest = $_POST['obavjest'];
    $kor_uvijet = $_POST['uvijet'];
	$marka_automobila = $_POST['marka-automobila'];
	$reg_oznaka = $_POST['reg-oznaka'];
    
    
    if(empty($kor_ime)){
        $greske .= "Obavezno unesite ime!<br>";
    }  else {
       $provjera = "/^[A-Za-zčČćĆžŽđĐšŠ]+$/";
        if(strcspn($kor_ime,'0123456789') != strlen($kor_ime)){
            $greske .= "Ime ne smije sadrzavati brojeve!<br>";
        }
        $pocetno_slovo = substr($kor_ime, 0, 1);
        if($pocetno_slovo != strtoupper($pocetno_slovo)){
                $greske .= "Ime mora poceti vlikim slovom!<br>";
        }
    }
    
    if(empty($kor_prezime)){
        $greske .= "Obavezno unesite ime!<br>";
    }  else {
       $provjera = "/^[A-Za-zčČćĆžŽĐđšŠ]+$/";
        if (strcspn($kor_prezime,'0123456789') != strlen($kor_prezime)){
            $greske .= "Ime ne smije sadrzavati brojeve!<br>";
        }
        $pocetno_slovo = substr($kor_prezime, 0, 1);
        if($pocetno_slovo != strtoupper($pocetno_slovo)){
                $greske .= "Ime mora poceti vlikim slovom!<br>";
        }
    }
   
        
    if(empty($kor_adresa)) {
            $greske .= "Morate unijeti adresu!<br>";
        }
        if(empty($kor_grad)) {
            $greske .= "Morate unijeti grad!<br>";
        }
        if(empty($kor_e_mail)) {
            $greske .= "Morate unijeti e-mail adresu!<br>";
        }
        else {
            if(!filter_var($kor_e_mail, FILTER_VALIDATE_EMAIL))
            {
                $greske .= "E-mail nije u foi.hr domeni!<br>";
            }
        }
        if(empty($kor_korisnicko_ime)) {
            $greske .= "Morate unijeti korisnicko ime!<br>";
        }
        if(empty($kor_lozinka)) {
            $greske .= "Morate unijeti lozinku!<br>";
        }
        if (!preg_match("/.{6}/", $kor_lozinka)){
            $greske .= "Krivo strukturirana lozinka! <br>";
        }   
        if(empty($kor_ponovi_lozinka)) {
            $greske .= "Morate unijeti ponovljenu lozinku!<br>";
        }
        if (!preg_match("/.{6}/", $kor_ponovi_lozinka)){
            $greske .= "Krivo strukturirana ponovljena lozinka! <br>";
        }   
        if(!empty($kor_lozinka) && !empty($kor_ponovi_lozinka) && ($kor_lozinka !== $kor_ponovi_lozinka)) 
        { $greske .= "Lozinke moraju biti jednake!<br>";}
        
       
        if(empty($kor_datum_rodenja)) {
            $greske .= "Morate unijeti datum rođenja!<br>";
        }
        if(empty($kor_obavijest)) {
            $greske .= "Morate odabrati zelite li primati obavijesti!<br>";
        }
        if(empty($kor_uvijet)) {
            $greske .= "Potrebno je prihvatiti uvjete koristenja!<br>";
        }
		if(empty($marka_automobila)) {
            $greske .= "Potrebno je unijeti marku automobila!<br>";
        }
		if(empty($reg_oznaka)) {
            $greske .= "Potrebno je unijeti registracijsku oznaku!<br>";
        }
        
        $time=date('Y-m-d H:i:s');
        
        if(empty($greske) && $resp->is_valid){
         $path = "img/$email/";
         $directory = $path . $_FILES['slika']['name'];
		 $kljuc = md5($kor_e_mail);
         $upit = "insert into korisnik(ime, prezime, adresa, grad, email,"
                . "korisnicko_ime, lozinka, datum_rodenja, spol, marka_automobila, reg_oznaka, last_update, aktivacijski_kljuc)"
                . "VALUES('$kor_ime','$kor_prezime', '$kor_adresa', '$kor_grad', '$kor_e_mail',"
                . "'$kor_korisnicko_ime','$kor_lozinka','$kor_datum_rodenja', '$kor_spol', '$marka_automobila', '$reg_oznaka',"
                . "'$time', '$kljuc');";
        if ($baza->updateDB($upit)) {
            $primatelj = $kor_e_mail;
            $naslov = "Aktivacija korisničkog računa";
            $poruka = "Postovani <br><br> Molimo vas da aktivirte svoj korisnicki racun klikom na "
                    . "http://arka.foi.hr/WebDiP/2013_projekti/WebDiP2013_019/aktivacija.php?email=$primatelj&kljuc=$kljuc>Aktivacijskom linku</a>"
                    . "ovaj link</a>";
            mail($primatelj, $naslov, $poruka);
			pisi("Registracija novog korisnika: " . $kor_ime . " " . $kor_prezime);
            header("Location: korisnici.php");
        } else {
            $greske .= "Greska pri radu baze podataka: <br/>";
        }
        } else if(!$resp->is_vaild) {
			$greske .= "Neispravno unesena CAPTCHA!";
		}
}




include('zaglavlje.php');
?>

    <body>
  
        <section id="sadrzaj">
            <form action="" method="POST" enctype="multipart/form-data" >
                    <label for="ime" class="ime">Ime</label>
                    <input type="text" name="ime" id="ime" required class="unos"/><br/>
                    <p id="ime_greska" class="ime_greska"></p><br/>
                    
                    <label for="prezime">Prezime</label>
                    <input type="text" name="prezime" id="prezime" required /><br/>
                    <p id="prezime_greska" class="prezime_greska"></p><br/>
                     
                    <label for="adresa">Adresa</label>
                    <input type="text" name="adresa" id="adresa" /><br/>
                    
                    <label for="grad">Grad</label>
                    <input type="text" name="grad" id="grad"/><br/>
                
                    <label for="e_mail">E-mail</label>
                    <input type="email" name="e_mail" id="e_mail" pattern=".+@foi.hr" required placeholder="ime.prezime@foi.hr"/><br/>
                    
					
                    <label for="korisnicko_ime">Korisničko ime</label>
                    <input type="text" name="korisnicko_ime" id="korisnicko_ime" pattern=".{6,}" required placeholder="Najmanje 6 znakova"/><br/>
					
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
                    <input type="password" name="lozinka" id="lozinka" pattern=".{6,}" required placeholder="Najmanje 6 znakova"></div>
                    <div class="za_lozinku">
                    <label for="ponovi_lozinka">Ponovi lozinku:</label>
                    <input type="password" name="ponovi_lozinka" id="ponovi_lozinka" onkeyup="provjeraLozinke(); return false;" pattern=".{6,}" required placeholder="Najmanje 6 znakova" ><br/>
                    <span id="potvrdna_poruka" class="potvrdna poruka"><br/></span></div>

                    <label for="datum_rodenja">Datum rođenja</label>
                    <input type="text" name="datum_rodenja" id="datum_rodenja" required/><br/>
                    
                    <label for="spol">Odaberite spol</label>
                    <select id="spol" name="spol">
                    <option value="none" selected disabled>Odaberi</option>
                    <option value="female">Ženski</option>
                    <option value="male">Muški</option>
                    </select><br/>
					
					<label for="marka-automobila">Marka automobila</label>
                    <input type="text" name="marka-automobila" id="marka-automobila" required/><br/>
					
					<label for="reg-oznaka">Registracijska oznaka</label>
                    <input type="text" name="reg-oznaka" id="reg-oznaka" required/><br/>
                    
                    <label>Želite li primati obavjesti putem e-maila?</label><br/>
                    
                    <label for="zelim" class="zelim">Želim</label> 
                    <input type="radio" name="obavjest" class="da" id="zelim" value="da"/><br/>
                    
                    <label for="ne_zelim" class="ne_zelim">Ne želim</label>
                    <input type="radio" name="obavjest" class="ne" id="ne_zelim" value="ne"/><br/>
                    
					<?php
					require_once('recaptcha/recaptchalib.php');
					$publickey = "6LeqgvMSAAAAAOObRUlS62z80K3VorhLirUCrTuL";
					echo recaptcha_get_html($publickey);
					?>
                    
                    <label for="uvijet" class="txt_uvijet">Pročitao sam i prihvaćam uvjete upotrebe aplikacije (terms and conditions)</label>
                    <input type="checkbox" name="uvijet" id="uvijet" class="uvijet" ><br/>
                    
                    <input type="submit" name="registracija" id="registracija" class="gumb_reg" value="Registriraj se"/>
					
					<span><?php echo $greske;?></span>
                    
                                                            
                </form>
				<script>
			  $(function() {
				$('#datum_rodenja').datepicker({ dateFormat: 'yy-mm-dd' });
			  });
			  </script>
            
        </section>
		<script type="text/javascript" src="JS/lgregori.js"></script>
<?php
include('podnozje.php');
?>  
