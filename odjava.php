<?php
include('zaglavlje.php');


	$_SESSION = array();
	session_destroy();


header('location:prijava.php');

?>