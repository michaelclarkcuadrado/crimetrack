<?php
/**
 *
 * FileName: getStatisticsMatch.php
 * User: Michael Clark-Cuadrado
 * Date: 4/29/18
 * Time: 3:12 PM
 */
$neighborhoodSelection= array();
$IUCRSelection = array();

if(isset($_POST['jsonBlob'])){
    $data = json_decode($_POST['jsonBlob']);
    $neighborhoodSelection = $data['neighborhoods'];
} else {
    die();
}