<?php
include('zaglavlje.php');

if (!isset($_SESSION['username'])) {
    header('location:prijava.php');
} else {
    if ($_SESSION['tip'] != 1) {
        header('location:index.php');
    }
}

include_once("baza.class.php");
?>

<link rel="stylesheet" type="text/css" href="datatables/jquery.dataTables.css">

<?php
$baza = new Baza();
$mysqli = $baza->spojiDB();
$zapisi = array();

$sql = "SELECT * FROM dnevnik";
if ($rs = $mysqli->query($sql)) {
    while ($zapis = $rs->fetch_assoc()) {
        $zapisi[] = $zapis;
    }
} else {
    echo $mysqli->error;
}

echo "<div id='holder-datatables'>";
echo "<table id='tablica' class='display'>";
echo "<thead>";
echo "<tr>";
echo "<th>Zapis</th>";
echo "<th>Vrijeme</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach ($zapisi as $zapis) {
                echo "<tr>";
                echo "<td>" . $zapis['zapis'] . "</td>";
                echo "<td>" . $zapis['vrijeme'] . "</td>";
				echo "</tr>";
            }
echo "</tbody>";
echo "</table>";
echo "</div>";
echo "</div>";

?>



<script type="text/javascript" src="datatables/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
    $('#tablica').dataTable();
});

</script>

<?php

include('podnozje.php');

?>