<?php
	include_once('config.php');

	print_r($_POST);

	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	$add = "INSERT INTO crimetrack_users VALUE('$username', '$email', '$password', 'common');";
	
	print $add;

	$result = $db->query($add);

	if($result != FALSE) {
		print "<p>new user named " . $username. " has been added.</p>";
	}
	else{
	}
?>