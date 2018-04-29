<?php
include_once("config.php");

$crimeType = json_decode($_GET['crimeType']);
$neighborhood = json_decode($_GET['neighborhood']);
$month = $_GET['month'];
$year = $_GET['year'];

$typeString = "(";
foreach ($crimeType as $type) {
    $typeString .= "'" . $type . "',";
}
$strlen = strlen($typeString);
$typeString = substr($typeString, 0, $strlen - 1);
$typeString .= ")";

$neighborhoodString = "(";
foreach ($neighborhood as $n) {
    $neighborhoodString .= "'" . $n . "',";
}
$strlen = strlen($neighborhoodString);
$neighborhoodString = substr($neighborhoodString, 0, $strlen - 1);
$neighborhoodString .= ")";

$getCrime = "SELECT COUNT(*)
                FROM (`crimetrack_crimes` JOIN `crimetrack_chicago_community_areas` ON COMMUNITY_AREA = area_id)
                                          JOIN `crimetrack_crime_type` ON  IUCR = IUCR_PK 
                WHERE IUCR IN $typeString AND area_id IN $neighborhoodString
                      AND MONTH(`DATE`) = '$month' AND YEAR(`DATE`) = '$year'";

$crimeResult = $db->query($getCrime);
$count = $crimeResult->fetch(PDO::FETCH_ASSOC);
$count = $count['COUNT(*)'];

echo $count;

?>