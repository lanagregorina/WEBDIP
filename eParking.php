<?php
include('zaglavlje.php');

?>

<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Navigacijski dijagram i era model</a></li>
    <li><a href="#tabs-2">Opis projektnog zadatka</a></li>
    <li><a href="#tabs-3">Opis projektnog rješenja</a></li>
	<li><a href="#tabs-4">Popis skripti, biblioteka i tehnologija</a></li>
  </ul>
  <div id="tabs-1">
		<img class="dijagram" src="img/navigacijski.png" alt="navigacijski_dijagram"><br/>
		<img class="dijagram" src="img/era.png" alt="era_dijagram"><br/>
   </div>
  <div id="tabs-2">
    <p>eParking</br></br> 
		Kratak opis projekta:</br> 
		Sustav služi za organizaciju, evidenciju i naplatu parkinga na organiziranom parkingu (npr. Podzemna garaža). 
		Uloge koje projekt treba imati su neregistrirani korisnik, vlasnik vozila (registrirani korisnik), zaposlenik parkirališta (Moderator) te administrator.</br></br>
		Detaljne upute: </br></br>
		Administrator </br>
		Kreira parkirališta i svakom parkiralištu dodjeljuje zaposlenike. Administrator vidi statistiku korištenja sustava, pogrešnih/ispravnih prijava, po korisnicima i vremenskom periodu (od - do). Da bi se postalo zaposlenikom parkirališta administrator mora korisniku dodijeliti tu ulogu. Administrator vidi dali ima karata koje ističu za 3 dana i može okinuti slanje e-maila korisnicima sa obavijesti da im ističe mjesečna karta.</br></br>
		Zaposlenik </br>
		Svako parkiralište opisuje sa opisnim podacima (ime parkirališta, broj parkirnih mjesta, vrijeme naplate, cijene parkiranja (jedan sat, cjelodnevna karta, mjesečna karta)). Na njemu dodijeljenom parkiralištu evidentira automobile koji nemaju važeću kartu za parkiranje (provjerom registracijske tablice u slučaju vozila sa plaćenom mjesečnom parkirnom kartom) te ispostavlja kaznu za parkiranje. Opis kazne sadrži registraciju vozila u prekršaju, datumom evidencije. Podaci o veličini kazne se popunjavaju automatski nakon unosa vremena evidentiranog prekršaja. Iznos kazne se obračunava od punog tekućeg sata do kraja naplate parkinga na dan evidentiranja. Obavezno mora dokumentirati kaznu galerijom slika automobila u prekršaju (min 3 slike). Zaposlenik vidi statistiku parkiranja po kategorijama parkiralište, zaposlenik parkirališta te vlasnik vozila. I svi pregledi se baziraju na vremenskom periodu (od - do).</br></br> 
		Vlasnik</br> 
		Prilikom registracije na sustav se unose podaci o vlasniku vozila (ime, prezime) te podaci o automobilu (marka automobila, registracijska oznaka).  Ima mogućnost plaćanja dnevne parkirne karte na odabranom parkiralištu na odabrani dan te plaćanja mjesečne parkirne karte na odabranom parkiralištu od odabranog datuma. Ima uvid u sve neplaćene kazne za registriranu registraciju, koje može platiti putem sustava. I može vidjeti popis svih plaćenih parkirnih kazni i popis svih važećih dnevnih/mjesečnih karata.</br></br>
		Neregistrirani korisnik</br>
		Može vidjeti popis parkirališta i njihovih opisnih podataka.</br>
</p>
</div>
  <div id="tabs-3">
  
	<p>
	Postoje tri tipa korisnika. Administrator može sve što i zaposlenik te konfiguriranje sustava. Zaposlenik može uređivati parking, pregladavati parking te naplačivati kazne. Običan registrirani korisnik može kupiti kartu, mijenjati svoje podatke te plačati kazne. Neregistrirani korisnik može samo vidjeti početnu stranicu, može se registrirati i može vidjeti popis parkirališta te dokumentaciju.
	</p>
  
  </div>
	<div id="tabs-4">
	<p>
		aktivacija.php</br>
		baza.class.php</br>
		cijene-ajax.php</br>
		dnevnik-pregled.php</br>
		dnevnik.php</br>
		eParking.php</br>
		greske.php</br>
		index.php</br>
		kazna-placanje.php</br>
		kazna-upload.php</br>
		kazna.php</br>
		konfiguracija.php</br>
		korisnici-evidencija.php</br>
		korisnici.php</br>
		korisnicko-ime-ajax.php</br>
		korisnik-detalji.php</br>
		korisnik-uredi.php</br>
		kosarica.php</br>
		moj-racun.php</br>
		odjava.php</br>
		parking-dodaj.php</br>
		parking-notifikacije.php</br>
		parking-placanje.php</br>
		parking-provjera.php</br>
		parking-uredi.php</br>
		parking.php</br>
		parkiranje.php</br>
		podnozje.php</br>
		pomak.php</br>
		prijava.php</br>
		registracija.php</br>
		zaboravljena_lozinka.php</br>
		zaglavlje.php</br>
	</p>
	
  </div>
</div>

<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>
  
  <?php
include('podnozje.php');

?>
  