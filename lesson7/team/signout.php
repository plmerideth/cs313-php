<?php
	session_start();

	$_SESSION = array(); //Wipe out all session variables
	session_destroy(); //Destroy the session

	$url='signin.php';
	header("Location: $url");
	exit();
?>