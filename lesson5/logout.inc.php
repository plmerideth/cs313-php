<?php
	session_start();

	$_SESSION = array(); //Wipe out all session variables
	session_destroy(); //Destroy the session

	$url='index.php';
	header("Location: $url");
	exit();

?>