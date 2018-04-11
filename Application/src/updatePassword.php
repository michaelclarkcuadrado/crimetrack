update password .php

<!DOCTYPE HTML>
<?php
	//code to send email to user

	$email   = $_POST['email'];   
	$name    = $_POST['username'];    


    $oldP = $_POST['oldPassword'];
    $newP = $_POST['newPassword'];
    $newP2 = $_POST['newPassword2'];
	
?>
<!--Check if newP and newP2 match -->
<!--Check if oldP matchs database -->
<!--Update database with new password if that's true -->
<HTML>
	<HEAD>
    <TITLE>Retrieve Password</TITLE>
    <!-- 
        <SCRIPT>
            if(newP!=newP2)
            {
                return "Error";
            }
        </SCRIPT>
        </HEAD>
    -->
	<BODY>
		<!--informs user that the process went through, MAYBE I should automatically send back to landing page if it works -->
        <H2>Your password has been reset.</H2>
        
        Return Home <br /><a href="index.html">Landing Page</a> <!--Need to change href off of index.html; also do i need <div> tags? -->
        
	</BODY>
</HTML>