<?php
    include_once('config.php');
    include('api/edit.php');
    session_start();
    $uid = $_SESSION['uid'];

	$op = $_GET['op'];
	if ($op == 'username') {
		editUname($_POST);
    }
    elseif ($op == 'password') {
        changePass($_POST);
    }
?>

<html>
<head>

<META name="viewport" content="width=device-width, initial-scale=1">

<LINK rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="static/css/signup.css">

<SCRIPT src="vendor/jquery.min.js"> </SCRIPT>
<SCRIPT src="vendor/bootstrap/js/bootstrap.min.js">     </SCRIPT>

<title>Edit Profile</title>

<script language="JavaScript">
    function confirm() {
        var newPass = document.changePassword.newPassword.value;
        var confirmPass = document.changePassword.confirmPassword.value;
        if (newPass == confirmPass) {
            return true;
        }
        else {
            alert("Please input the same password.");
            return false;
        }
    }
</script>

</head>

<body>
	<h2>Edit Username</h2>
    <form name="editUsername" method='POST' action="editProfile.php?op=username">
        <div class="form-group">
            <label for="username">Username</label>
            <input type='text' class="form-control" required name="username" placeholder='Enter new username' /><br />
        </div>
        <input class="btn btn-default" type='submit' value='Save New Username' />
    </form>
    <br /><br />
    <h2>Change Password</h2>
    <form name="changePassword" method='POST' action="editProfile.php?op=password" onSubmit="return confirm()">
        <div class="form-group">
            <label for="password">Old Password</label>
            <input type="password" class="form-control" required name="oldPassword" placeholder="Enter your old password"><br /><br/>
        </div>
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" class="form-control" required name="newPassword" placeholder="Enter your new password"><br /><br/>
        </div>
        <div class="form-group">
            <label for="password">Confirm New Password</label>
            <input type="password" class="form-control" required name="confirmPassword" placeholder="Confirm your new password"><br />
        </div>
        <br />
        <input class="btn btn-default" type='submit' value='Change Password' />
        <br /><br />
        <div>
            <a href="home.php">Go back to Home Page</a>
        </div>
    </form>
</body>
</html>