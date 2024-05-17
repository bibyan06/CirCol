<?php
	session_start();
	unset($_SESSION['seller']); // Unset or remove the seller session variable
	//session_destroy();
	header('location: login.php'); // Redirect to login page after logout
	exit();
?>

