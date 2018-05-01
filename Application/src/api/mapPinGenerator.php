<?php
/**
 *
 * FileName: mapPinGenerator.php
 * User: Michael Clark-Cuadrado
 * Date: 5/1/18
 * Time: 4:36 PM
 */
require_once 'config.php';

$neighborhoods = array();
if(isset($_GET['neighborhoods'])){
    $neighborhoods = json_decode($_GET['neighborhoods']);
} else {
    die();
}

$map = new Imagick('neighborhoods_map.jpg');
$pin = new Imagick('pin.png');

$neighborhoodQuerySubString = "(";
foreach($neighborhoods as $neighborhood){
    $neighborhoodQuerySubString .= $neighborhood . ",";
}
$neighborhoodQuerySubString = substr($neighborhoodQuerySubString, 0, strlen($neighborhoodQuerySubString) -1);
$neighborhoodQuerySubString .= ")";

$neighborhoodQueryString = "SELECT centerX, centerY FROM crimetrack_chicago_community_areas WHERE area_id IN $neighborhoodQuerySubString";
$queryResult = $db->query($neighborhoodQueryString);
while($row = $queryResult->fetch(PDO::FETCH_ASSOC)){
    $row['centerX'] -= 32;
    $row['centerY'] -= 64;
    $test = $map->compositeImage($pin, imagick::COMPOSITE_DEFAULT, $row['centerX'], $row['centerY']);
}

header('Content-type: image/jpeg');
$map->setImageFormat("jpg");
echo $map->getImageBlob();

?>