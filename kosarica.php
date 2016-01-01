<?php
include('zaglavlje.php');

if (!isset($_SESSION['username'])) {
    header('location:prijava.php');
}

if (isset($_SESSION['karte'])) {
  include_once('baza.class.php');

  $baza = new Baza();
  $mysqli = $baza->spojiDB();

  $karte = $_SESSION['karte'];
  $karteZaPrikaz = array();
  $id = $_SESSION['id'];

  $parkingZaPrikaz = array();
  for ($i = 0; $i <= count($karte); $i++) {
    $sql = "SELECT naziv, cijena FROM tip_karte JOIN parking_cijena ON id_tip_karte = tip_karte_id WHERE id_tip_karte = " . $_SESSION['karte'][$i]['tip'] . " AND parking_id = " . $_SESSION['karte'][$i]['parking'];
    if ($rs = $mysqli->query($sql)) {
      $karteZaPrikaz[] = $rs->fetch_assoc();
    }
  }
  for ($i = 0; $i <= count($karte); $i++) {
    $sql = "SELECT opis FROM parking WHERE id_parking = " . $_SESSION['karte'][$i]['parking'];
    if ($rs = $mysqli->query($sql)) {
      $parkingZaPrikaz[] = $rs->fetch_assoc();
    }
  }
}

if (isset($_GET['potvrda'])) {
  foreach($_SESSION['karte'] as $karta) {
    $sql = "INSERT INTO karta VALUES (DEFAULT, '" . $karta['datum'] . "', " . $karta['tip'] . ", " . $karta['parking'] . ", " . $id . ")";
    echo $sql;  
      if ($rs = $mysqli->query($sql)) {
        $poruka = "Karte uspješno kupljene!";
        unset($_SESSION['karte']);
        header('location:moj-racun.php');
      } else {
        $poruka = "Problem kod kupnje karata" . " " . mysqli_error($mysqli);
      }
    }
}

?>
  <table class='tablica'>
   <thead>
    <tr>
       <th>Karta</th>
       <th>Parking</th>
       <th>Datum</th>
       <th>Cijena</th>
       <th>Brisanje</th>
    </tr>
   </thead>
   <tbody>
      <?php
      if (isset($_SESSION['karte'])) {
        for ($i = 0; $i < count($karteZaPrikaz); $i++) {
          $iznos += $karteZaPrikaz[$i]['cijena'];
          echo "<tr>";
          echo "<td> " . $karteZaPrikaz[$i]['naziv'] . "</td>";
          echo "<td> " . $parkingZaPrikaz[$i]['opis'] . "</td>";
          echo "<td> " . $karte[$i]['datum'] . "</td>";
          echo "<td> " . $karteZaPrikaz[$i]['cijena'] . "</td>";
          echo "<td><a href='kosarica.php?brisi=" . $i . "'><input type='button' value='Briši' name='brisanje'></a></td>";
          echo "</tr>";
        }
      }
      ?>
   </tbody>
   <tfoot>
    <tr>
       <td colspan="3">Ukupno</td>
       <td><?php echo $iznos; ?></td>
       <td rowspan="2"><a href='kosarica.php?brisi-sve'><input type='button' value='Briši sve' name='brisanje'></a></td>
    </tr>
    <tr>
       <td colspan="3">Potvrda</td>
       <td><a href='kosarica.php?potvrda'><input type="button" value="Potvrdi" name="potvrda"></a></td>
    </tr>
   </tfoot>
  </table>
  <span id="kosarica-span"><?php echo $poruka; ?></span>

<?php

if (isset($_GET['brisi'])) {
  $id = intval($_GET['brisi']);
  unset($_SESSION['karte'][$id]);
  $_SESSION['karte'] = array_values($_SESSION['karte']);
  if (empty($_SESSION['karte'])) {
    unset($_SESSION['karte']);
  }
  header('location:kosarica.php');
}

if (isset($_GET['brisi-sve'])) {
  unset($_SESSION['karte']);
  header('location:kosarica.php');
}

?>

<?php
include('podnozje.php');
?>  