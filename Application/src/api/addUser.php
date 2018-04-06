<?php
	/*
	 * Tracy Tang
	 * This file takes the user's input on the sign-up page and insert into the crimetrack_users table in the database.
	 */
	include_once('config.php');
	
	function addUser($data) {
		global $db;

		$username = $data['username'];
		$email = $data['email'];
		$password = MD5($data['password']);
	
		$msg = "";

		$checkUname = "SELECT * FROM `crimetrack_users` WHERE username = '$username'";
		$unameResult = $db->query($checkUname);
		if($unameResult == FALSE) {
			die("Database refused to respnse.")
		}
		if($unameResult->rowCount() != 0) {
			$msg = "Username already exists.";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
		else {
			$add = "INSERT INTO `crimetrack_users` (`username`, `email`, `password_hash`, `userType`) VALUE('$username', '$email', '$password', 'common');";
			$result = $db->query($add);
	
			if($result == FALSE) {
				die("An unknown error occurred.");
			}
			header("Location: sign-up-success.html");
		}
	}

?>


