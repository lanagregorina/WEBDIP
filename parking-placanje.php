<?php
include('zaglavlje.php');

if (!isset($_SESSION['username'])) {
    header('location:prijava.php');
}

include_once('baza.class.php');
$baza = new Baza();
$mysqli = $baza->spojiDB();

$parking = $_POST['parking'];
$karta = $_POST['karta'];
$datum = $_POST['datum'];
$id = $_SESSION['id'];

if (isset($_POST['kupnja'])) {

	if (empty($parking)) {
		$greske .= "Morate odabrati parking!<br>";
	}

	if (empty($karta)) {
		$greske .= "Morate odabrati kartu!<br>";
	}

	if (empty($datum)) {
		$greske .= "Morate odabrati datum!<br>";
	}

	if (empty($greske)) {
		$karta = array('tip' => $karta, 'parking' => $parking, 'datum' => $datum);

		$_SESSION['karte'][] = $karta;
	}
}
?>

<section id="sadrzaj">
            <form action="" method="POST" enctype="multipart/form-data" >
                    <label for="parking">Parking</label>
                    <select id="parking" name="parking" required>><br/>
						<option selected disabled>Odaberi</option>
						<?php			
						$sql = "SELECT id_parking, opis FROM parking";
						if ($rs = $mysqli->query($sql)) {
							while ($parking = $rs->fetch_assoc()) {
								echo "<option value=" . $parking['id_parking'] . "> " . $parking['opis'] . " </option>";
							}
						}
						?>
					</select><br>

					<script type="text/javascript">
						$( "#parking" ).change(function() {
						  $.ajax({
								type: "POST",
								url: "cijene-ajax.php",
								data: "id=" + $("#parking").val(),
								dataType: "json",
								cache: false,
								processData: false,
								success:  function(data){
									var select = $("#karta");
								    select.empty();
								    for (var i = 0; i < data.length; i++) {
								      select.append('<option value="' + data[i].id + '">' + data[i].cijena + '</option>');
								    }
								}
							});
						});
					</script>
					
					<label for="karta">Karta</label>
					<select id="karta" name="karta" required><br/>
						<option selected disabled>Odaberi</option>
					</select><br>
					
                    <label for="slika">Datum</label>
                    <input type="text" id="datum" name="datum"/><br/>
                    
                    <input type="submit" name="kupnja" id="kupnja" class="gumb_reg" value="Dodaj u košaricu"/>
					
					<span><?php echo $greske;?></span>
                </form>
				<script>
			  $(function() {
				$('#datum').datepicker({ dateFormat: 'yy-mm-dd' });
			  });
			  </script>
            
        </section>
		
<?php
include('podnozje.php');
?>  