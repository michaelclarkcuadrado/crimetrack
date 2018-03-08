<!DOCTYPE HTML>
<?php
	//code to send email to user

	$email   = $_POST['emailSend'];   
	$name    = $_POST['usernameSend'];    


	$to      = $_POST['emailSend'];
	$subject = "Comment from $name";

	$header  = "From: $name <$email>\r\n";
	//need a field content which will hold the users password or a system generated password
	$result  = mail($to, $subject, $header);
?>

<HTML>
	<HEAD>
	<TITLE>Retrieve Password</TITLE>
	</HEAD>

	<BODY>
		<!--informs user that the process went through -->
		<H2>Here is your password.</H2>
		<P>Your name: <?php echo $name;  ?></P>
		<P>Your mail: <?php echo $email; ?></P>
		<!--Retrieve password from database or generate temporary password and update password in database -->
	</BODY>
</HTML>