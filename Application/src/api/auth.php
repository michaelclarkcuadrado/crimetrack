<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 3/4/18
 * Time: 2:50 PM
 */
require_once 'config.php';

function auth($data) {
	session_start();
	global $db;

	$username = $data['login_username'];
	$password = MD5($data['login_password']);

	$msg = "";

	$checkUname = "SELECT * FROM `crimetrack_users` WHERE username = '$username'";
	$unameResult = $db->query($checkUname); //This is where it breaks,cant figure out why i copied trishs code	!!!!!!!!!!!!!!!!!!!!!!!!!!!
	if($unameResult == FALSE) {
		die("Database refused to respnse.");
	}
	if($unameResult->rowCount() == 0) {
		$msg = "Username does not exists.";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
	else{
		$checkPass = "SELECT * FROM `crimetrack_users` WHERE password_hash = '$password'";
		$passResult = $db->query($checkPass);

		if($passResult == FALSE) {
			die("Database refused to respond.");
		}
		if($passResult->rowCount() == 0) {
			$msg = "Incorrect password.";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
		else{
			if(isset($username) && isset($password)){
				$getUID = "SELECT user_id FROM `crimetrack_users` WHERE username = '$username'"; 
				$uid = $db->query($getUID); 
				$uid = $uid->fetch(PDO::FETCH_ASSOC); 
				$uid = $uid['user_id'];
				$_SESSION["uid"] = $uid; 
				header("Location: home.php?username=$username");
			} else {
    			die("<script>location.href = '/'</script>");
			}
		}
	}
}
?>
