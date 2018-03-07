<!DOCTYPE HTML>
<?php


	$email   = $_POST['emailSend'];   
	$name    = $_POST['usernameSend'];    

	$content = $_POST['taContent']; //this should be deleted if possible, might need it for the mail function though

	$to      = "boucbe01@gettysburg.edu";
	$subject = "Comment from $name";

	$header  = "From: $name <$email>\r\n";

	$result  = mail($to, $subject, $content, $header);
?>

<HTML>
	<HEAD>
	<TITLE>Retrieve Password</TITLE>
	</HEAD>

	<BODY>

		<H2>Here is your password.</H2>
		<P>Your name: <?php echo $name;  ?></P>
		<P>Your mail: <?php echo $email; ?></P>
		<!--Retrieve password from database or generate temporary password and update password in database -->
	</BODY>
</HTML>