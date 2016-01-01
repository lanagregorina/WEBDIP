function provjeraLozinke(e)
{
    var lozinka = document.getElementById('lozinka');
    var ponovi_lozinka = document.getElementById('ponovi_lozinka');
    var message = document.getElementById('potvrdna_poruka');
    
    var dobro = "#66cc66";
    var  lose = "#ff6666";
    
    if(lozinka.value === ponovi_lozinka.value){
        ponovi_lozinka.style.backgroundColor = dobro;
        message.style.color = dobro;
        message.innerHTML = "Lozinka se poklapa!";
    }else{
        ponovi_lozinka.style.backgroundColor = lose;
        message.style.color = lose;
        message.innerHTML = "Lozinka se ne poklapa!";
    }
}



if (ime !== null){
    ime.addEventListener("blur", function(e) {
        var ime1 = ime.value;
        var greska = document.getElementById("ime_greska");
        ime.className = 'dobro';
        greska.innerHTML = "";
        
        if (ime1[0] === ime1[0].toLowerCase()){
            ime.className = 'greska';
            greska.innerHTML += "Pocetno slovo mora biti veliko! ";
        } 
        for (var i = 0; i < ime1.length; i++){
            if (!isNaN(ime1[i])){ 
                ime.className = 'greska';
                greska.innerHTML += "Ime ne smije sadrzavati broj!";
            }
        }
    });}



if (prezime !== null){
    prezime.addEventListener("blur", function(e) {
        var prezime1 = prezime.value;
        var greska = document.getElementById("prezime_greska");
        prezime.className = 'dobro';
        greska.innerHTML = "";
        
        
        if (prezime1[0] === prezime1[0].toLowerCase()){
            prezime.className = 'greska';
            greska.innerHTML += "Pocetno slovo mora biti veliko! ";
        }
        
        for (var i = 0; i < prezime1.length; i++){
            if (!isNaN(prezime1[i])){ 
                prezime.className = 'greska';
                greska.innerHTML += "Ime ne smije sadrzavati broj!";
            }
        }
    });}


