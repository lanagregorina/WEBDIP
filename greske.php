<?php
    session_start();   
?>    
    <!DOCTYPE html>
<html>
    <head>
        <title>Greska</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel = "stylesheet" type="text/css" href="css/lgregori_2.css.css"/>
    </head>
    <body>
        <header id="header">
            <h2>ERROR!</h2>
        </header>
        
        <section id = "sadrzaj">
            <article id="greske">
                <?php echo $_SESSION['poruke']; 
 
                ?>
            </article>
        </section>
        <footer id="footer">
            <address>
                <b>Kontaktirajte me:</b><br/>
                <a href="mailto:lgregori@foi.hr">Lana Gregorina</a><br/>
                
            </address>          
        </footer>
        
    </body>
</html>
