<?php

class Baza {

    const server = "localhost";
    const baza = "WebDiP2013_019";
    const korisnik = "WebDiP2013_019";
    const lozinka = "admin_xSK2";

    function spojiDB() {
        $mysqli = new mysqli(self::server, self::korisnik, self::lozinka, self::baza);
        if ($mysqli->connect_errno) {
            echo "Neuspješno spajanje na bazu: " . $mysqli->connect_errno . ", " . $mysqli->connect_error;
               
    set_error_handler('greskaDB');
            }
            mysqli_set_charset($mysqli, "utf8");
       
        return $mysqli;
        
        
        }

    function selectDB($upit) {
        
        $veza = $this->spojiDB();
        
        $rezultat = $veza->query($upit) or trigger_error("Greška kod upita {$upit} - "
                        . "Greška: " . $veza->error . " " . E_USER_ERROR);
        if (!$rezultat) {
            $rezultat = null;
        }
        $veza->close();
        return $rezultat;
    }
   
    function updateDB($upit, $skripta = '') {
        $veza = self::spojiDB();
        if ($rezultat = $veza->query($upit)) {
            $veza->close();
            
            if ($skripta != '') {
                header("Location: $skripta");
            } else {
                return $rezultat;
            }
        } else {
            
            $veza->close();
            return null;
        }
    }
    function zatvoriDB($veza) 
        {
            if(!($veza->close())){
                trigger_error('Greska pri zatvaranju veze: '.$veza->error, E_USER_ERROR);
            }
        }
}   

    


?>