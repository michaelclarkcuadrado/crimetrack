<!DOCTYPE HTML>
<?php
	include_once('api/config.php');
	//does this connect to database?

	//function found online at http://codepad.org/UL8k4aYK; works with program now
	function randomPassword() {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache 
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		//echo implode($pass);
		return implode($pass); //turn the array into a string
	}
	
	
	//code to send email to user

	$email   = $_POST['emailSend'];   
	$name    = $_POST['usernameSend'];    
	
	//code to check if user is in database
	
	$checkUname = "SELECT * FROM `crimetrack_users` WHERE username = '$name'";
	
	$unameResult = $db->query($checkUname);//!!!!!!!!!!!!This is where it breaks idk why its same as Ts!!!!!!!!!!!!!!!!!!!!

	if($unameResult == FALSE) {
		die("Database refused to respnse.");
	}
	if($unameResult->rowCount() == 0) {
		$msg = "Username does not exists.";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
	else{
		$getUser = "SELECT user_id, email FROM `crimetrack_users` WHERE username = '$name'";
		$result = $db->query($getUser);
		$result = $result->fetch(PDO::FETCH_ASSOC);
		$uemail = $result['email'];
		$uid = $result['user_id'];

		if($email == $uemail) {
			$to      = $uemail;
			$subject = "Password for $name";
			$password = randomPassword();
			$password_hash = MD5($password);
		
			$din = "UPDATE `crimetrack_users` SET password_hash = '$password_hash' WHERE user_id = '$uid'";
			$passResult = $db->query($din);
			if($passResult == FALSE) {
				die("Database refused to respnse.");
			}
		
			$content  = "Password for $name <$email> \r \n $password \r \n Reset your password here: http://cs.gettysburg.edu/~tangyi01/cs360/crimetrack/editProfile.php?op=$uid&p=$password_hash \n"; // update link to changePassword
			$result  = mail($to, $subject, $content);
		}
		else{
			$msg = "Please input the email address registered when signed up.";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
		
	}
	
?>

<HTML>
	<HEAD>
	<TITLE>Retrieve Password</TITLE>
	</HEAD>

	<BODY>
		<!--informs user that the process went through -->
		<P>An email has been sent. <br />Please follow the instruction in the email to reset your password.</P>
	</BODY>
</HTML>