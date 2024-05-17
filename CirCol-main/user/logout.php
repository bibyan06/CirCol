<?php
	session_start();
	unset($_SESSION['user']); // Unset or remove the user session variable
	//session_destroy();
	header('location: index.php'); // Redirect to index page after logout
	exit();
?>

