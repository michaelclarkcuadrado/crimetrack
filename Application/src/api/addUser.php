<?php
	include_once('config.php');

	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	$add = "INSERT INTO crimetrack_users VALUE(NULL, '$username', '$email', '$password', 'common');";

	$result = $db->query($add);

	if($result != FALSE) {
//		print "<p>new user named " . $username. " has been added.</p>";
	}
	else{
	}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../style_sign-up.css">

<title>Sign up successfully</title>
</head>
<body>
	<h3>You have successfully signed up.<br /><br />
      <a href="../index.html">Click here to login</a></h2>
</body>
</html>