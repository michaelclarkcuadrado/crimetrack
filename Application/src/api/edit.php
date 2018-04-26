<?php
    include_once('config.php');
    
    function editUname($data) {
        $uid = $_SESSION['uid'];

        global $db;

        $newUsername = $data['username'];
        
        if(isset($newUsername)) {
    		$updateUname = "UPDATE `crimetrack_users` SET username = '$newUsername' WHERE user_id = '$uid'";
            $updateResult = $db->query($updateUname);
            
		    if($updateResult == FALSE) {
			    die("Database refused to respnse.");
            }
            $_SESSION['username'] = $newUsername;
            header("Location: ./home.php");
        } else {
            die("<script>location.href = '/'</script>");
        }
    }

    function changePass($data) {
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