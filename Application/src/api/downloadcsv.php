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

$getCrime = "SELECT `DATE`, STREET, crime_type, crime_description, community_name, LOCATION_DESCRIPTION, ARREST, DOMESTIC, LATITUDE, LONGITUDE
                FROM (`crimetrack_crimes` JOIN `crimetrack_chicago_community_areas` ON COMMUNITY_AREA = area_id)
                                          JOIN `crimetrack_crime_type` ON  IUCR = IUCR_PK 
                WHERE IUCR IN $typeString AND area_id IN $neighborhoodString
                      AND MONTH(`DATE`) = '$month' AND YEAR(`DATE`) = '$year'";

$crimeResult = $db->query($getCrime);

$filename = "Chicago_Crime_Selection_" . $month . "_" . $year . ".csv";
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');

// open the "output" stream
// see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
$f = fopen('php://output', 'w');
$headers = array("Date", "Street Address", "Crime Type", "Crime Description", "Community", "Location Type", "Arrested", "Domestic", "Latitude", "Longitude");
fputcsv($f, $headers);
while ($row = $crimeResult->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($f, $row);
}

?>