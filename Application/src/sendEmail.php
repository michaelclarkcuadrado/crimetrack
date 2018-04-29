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
		$getUID = "SELECT user_id FROM `crimetrack_users` WHERE username = '$name'";
		$uid = $db->query($getUID);
	}
	

	$to      = $_POST['emailSend'];
	$subject = "Password for $name";
	$password = randomPassword();
	
	$din = "UPDATE crimetrack_users"."SET password_hash = $password WHERE user_id=$getUID";
	$db->query($din);
	
	
	$content  = "Password for $name <$email>. $password. \r \n http://cs.gettysburg.edu/~boucbe01/cs360_s18/crimeTest/changePassword.html \n"; // update link to changePassword
	$result  = mail($to, $subject, $content);
?>

<HTML>
	<HEAD>
	<TITLE>Retrieve Password</TITLE>
	</HEAD>

	<BODY>
		<!--informs user that the process went through -->
		<H2>Here is your password.  </H2> <?php echo $password?>
		<P>Your name: <?php echo $name;  ?></P>
		<P>Your mail: <?php echo $email; ?></P>
	</BODY>
</HTML>