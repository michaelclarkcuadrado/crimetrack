<?php
    include_once('config.php');
	session_start();

    function changePass($data) {
		echo "What's wrong??";
        $uid = $_SESSION['uid'];
        global $db;
        
        $oldPass = MD5($data['oldPassword']);
        $newPass = MD5($data['newPassword']);
        
        $msg = "";

        if(isset($oldPass) && isset($newPass)) {
            $getPass = "SELECT password_hash FROM `crimetrack_users` WHERE user_id = '$uid'";
            $passResult = $db->query($getPass);
            if($passResult == FALSE) {
                die("Database refused to respond.");
            }
            $pass = $passResult->fetch(PDO::FETCH_ASSOC); 
            $pass = $pass['password_hash'];
            if($oldPass == $pass) {
                $changePass = "UPDATE `crimetrack_users` SET password_hash = '$newPass' WHERE user_id = '$uid'";
	    	    $changeResult = $db->query($changePass);
		        if($changeResult == FALSE) {
			        die("Database refused to respnse.");
                }
                header("Location: api/logout.php");
            }
            else {
                $msg = "Incorrect password.";
			    echo "<script type='text/javascript'>alert('$msg');</script>";
            }
         } else {
            die("<script>location.href = '/'</script>");
        }
    }
?>
