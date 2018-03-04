<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 3/4/18
 * Time: 2:50 PM
 */
require_once 'config.php';

if(isset($_POST['login_username']) && isset($_POST['login_password'])){

} else {
    die("<script>location.href = '/'</script>");
}