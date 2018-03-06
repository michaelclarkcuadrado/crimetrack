<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 3/4/18
 * Time: 4:59 PM
 */
$host = "ada.cc.gettysburg.edu";
$dbase = "crime_s18";
$user = "";
$pass = "";

try{
	$db = new PDO("mysql:host=$host;dbname=$dbase", $user, $pass);
}
catch(PDOException $e){
	die("Error connecting to MySQL server: " . $e->getMessage());
}
?>