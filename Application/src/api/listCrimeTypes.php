<?php
/**
 *
 * FileName: listCrimeTypes.php
 * User: Michael Clark-Cuadrado
 * Date: 4/11/18
 * Time: 10:35 AM
 */
require_once 'config.php';
$sql = "SELECT IUCR_PK, crime_type, crime_description FROM `crimetrack_crime_type`";
$result = $db->query($sql);

$output = array();
while($row = $result->fetch(PDO::FETCH_ASSOC)){
    if(!isset($output[$row['crime_type']])){
        $output[$row['crime_type']] = array();
    }
    $output[$row['crime_type']][$row['crime_description']] = $row['IUCR_PK'];
}

echo json_encode($output);