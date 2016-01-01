$(document).ready(function(){ 
    $("#korisnicko_ime").focusout(function(event){
        var korIme = $("#korisnicko_ime").val();
        //alert("Vrijednost korisnièkog unosa: " + korIme);
        console.log("Vrijednost korisnièkog unosa: " + korIme);
        
        $.ajax({
            type: 'GET',
            url: 'http://arka.foi.hr/WebDiP/2013/materijali/dz3_dio2/korisnik.php',
            dataType: 'xml',
            data: {
                'korisnik':korIme
            },
            
            success: function(data){
                var zauzeto ="";
                $(data).find('korisnici').each(function(){
                    zauzeto = $(this).find('korisnik').text();
                });
                
                
                console.log(zauzeto);
                if(zauzeto === 1){
                    $("#korisnicko_ime").css("background-color", "red");
                    $("#korisnicko_ime").focus();
                    $("#greske").html("<p>Korisnicko ime je zuzeto!<p>");
                }else{
                    console.log("Korisnièko ime je slobodno!");
                    $("#greske").html("");
                }
            },
            
            error: function(data){
                console.log("Greška kod prijenosa podataka!");
            }
            
        });
    });
});

//________________________________________________________________________________________________________________

$(document).ready(function(){ 
    $("#e_mail").focusout(function(event){
        var mail = $("#e_mail").val();
        //alert("Vrijednost korisnièkog unosa: " + mail);
        console.log("Vrijednost korisnièkog unosa: " + mail);
        
        $.ajax({
            type: 'GET',
            url: 'http://arka.foi.hr/WebDiP/2013/materijali/dz3_dio2/korisnikEmail.php',
            dataType: 'xml',
            data: {
                'korisnik':mail
            },
            
            success: function(data){
                var zauzeto ="";
                $(data).find('korisnici').each(function(){
                    zauzeto = $(this).find('korisnik').text();
                });
                
                console.log(zauzeto);
                if(zauzeto == 1){
                    $("#e_mail").css("background-color", "#FF4040");
                    $("#e_mail").focus();
                    $("#greske").html("<p>E-mail je zauzet!<p>");
                    
                }else{
                    console.log("E-mail je slobodan!");
                    $("#greske").html("");
                }
            },
            
            error: function(data){
                console.log("Greška kod prijenosa podataka!");
            }
            
        });
    });
});

//_______________________________________________________________________________________

$(document).ready(function(){
    if(document.getElementById("grad")) {
        var gradovi = new Array();

        $.getJSON("http://arka.foi.hr/WebDiP/2013/materijali/dz3_dio2/gradovi.json",
        function (data){
            $.each(data,function(key,val){
                console.log(key + " " + val); 
                gradovi.push(val);
            });
        });
        $("#grad").autocomplete({
            source:gradovi 
        });
    }
});

//_______________________________________________________________________________________

$('#korisnici').dataTable({
"bJQueryUI": true,
"sPaginationType": "full_numbers",
"bAutoWidth": true,
"bPaginate": true,
"bFilter": true,
"bSort": true,
"aaSorting": [
[0, 'asc'],
[1, 'asc']]});


//___________________________________________________________________________________

$(function() {
    $('#json').click(function() {
        $('#content').empty();
        var tablica = $('<table id="tablica">');
        tablica.append('<thead><tr><th>Ime</th><th>Prezime</th><th>Email</th></tr></thead>');
        $.getJSON('http://arka.foi.hr/WebDiP/2013/materijali/dz3_dio2/korisnici.json', function(data) {
            var tbody = $("<tbody>");
            for (i = 0; i < data.length; i++) {
                var red = "<tr>";
                red += "<td>" + data[i].ime + "</td>";
                red += "<td>" + data[i].prezime + "</td>";
                red += "<td>" + data[i].email + "</td>";
                red += "</tr>";
                //console.log(red);
                tbody.append(red);
            }
            tablica.append(tbody);
            $('#content').html(tablica);
            $('#tablica').dataTable();

        });




    });

    $('#xml').click(function() {
        $('#content').empty();
        var tablica = $('<table id="tablica">');
        tablica.append('<thead><tr><th>Ime</th><th>Prezime</th><th>Email</th></tr></thead>');
        
        $.get('http://arka.foi.hr/WebDiP/2013/materijali/dz3_dio2/korisnici.xml', function(data) {
            var tbody = $("<tbody>");
            $(data).children().children().each(function() {
                var red = "<tr>";
                red += "<td>" + this.getAttribute('ime') + "</td>";
                red += "<td>" + this.getAttribute('prezime') + "</td>";
                red += "<td>" + this.getAttribute('email') + "</td>";
                red += "</tr>";
                tbody.append(red);
            });
            tablica.append(tbody);
            $('#content').html(tablica);
            $('#tablica').dataTable();
        });
    });
});