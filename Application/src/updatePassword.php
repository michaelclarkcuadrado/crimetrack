<!DOCTYPE HTML>
<?php
	//code to update password in the database and produce an error if submission is incorrect

    /*To do
        <!--Check if newP and newP2 match -->
        <!--Check if oldP matchs database -->
        <!--Update database with new password if that's true -->
    */
	$email   = $_POST['email'];   
	$name    = $_POST['username'];    


    $oldP = $_POST['oldPassword'];
    $newP = $_POST['newPassword'];
    $newP2 = $_POST['newPassword2'];
    //Need to get old password from data base to compare
    /*
    if($oldP != oldPassword)
    {
        $msg = "Error, this does not match your current password"
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
    */
    if($newP != $newP2)
    {
        $msg = "Error, new password does not match confirmation."
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
    //do i need to do something on top of these messages if it fails?
?>

<HTML>
	<HEAD>
    <TITLE>Retrieve Password</TITLE>
    
	<BODY>
		<!--informs user that the process went through, MAYBE I should automatically send back to landing page if it works -->
        <H2>Your password has been reset.</H2>
        
        Return Home <br /><a href="index.html">Landing Page</a> <!--Need to change href off of index.html; also do i need <div> tags? -->
        
	</BODY>
</HTML>