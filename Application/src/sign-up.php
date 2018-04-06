<?php
	include_once('config.php');
	include("api/addUser.php");

	$op = $_GET['op'];
	if ($op == 'add') {
		addUser($_POST);
	}
?>

<!DOCTYPE HTML>
<!--Tracy Tang-->
<!--This is the sign-up page which requires users to input username, email and password-->
<html>
<head>

<META name="viewport" content="width=device-width, initial-scale=1">

<LINK rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="static/css/signup.css">

<SCRIPT src="vendor/jquery.min.js"> </SCRIPT>
<SCRIPT src="vendor/bootstrap/js/bootstrap.min.js">     </SCRIPT>

<title>Sign up for CrimeTrack</title>
<!--
<script language="JavaScript">
    function validate() {
        var uemail = document.signUp.email.value;
        return true;
    }
</script>
-->
</head>

<body>
	<h2>Sign Up</h2>
    <form name="signUp" method='POST' action="sign-up.php?op=add">
            <div class="form-group">
                <label for="username">Username</label>
                <input type='text' class="form-control" required name="username" placeholder='Enter username' /><br />
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" required name="email" placeholder="Enter valid email"><br />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type='password' class="form-control" required name="password" placeholder=' Create your password' />
            </div>

                <br /><br />
                <input class="btn btn-default" type='submit' value='Create account' />
                <br /><br />
        <div>
            Already have an account? <br /><a href="index.html">Sign in</a>
        </div>
    </form>
</body>
</html>
