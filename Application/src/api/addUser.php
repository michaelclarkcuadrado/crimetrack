<?php
	include_once('config.php');

	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

	$add = "INSERT INTO `crimetrack_users` (`username`, `email`, `password_hash`, `userType`) VALUE('$username', '$email', '$password', 'common');";

	$result = $db->query($add);

	if($result == FALSE) {
        die("An unknown error occurred.");
	}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../static/css/style_sign-up.css">

<title>Sign up successfully</title>
</head>
<body>
<h3>You have successfully signed up.</h3><br /><br />
      <a href="../index.html">Click here to login</a></h2>
</body>
</html>