<?php
/**
 *
 * FileName: listNeighborhoods.php
 * User: Michael Clark-Cuadrado
 * Date: 4/11/18
 * Time: 10:17 AM
 */
require_once 'config.php';
$sql = "SELECT area_id, community_name FROM `crimetrack_chicago_community_areas`";
$result = $db->query($sql);

$output = array();
while($row = $result->fetch(PDO::FETCH_ASSOC)){
    $row['isSelected'] = false;
    $row['area_id'] = intval($row['area_id']);
    $output[$row['area_id']] = $row;
}

echo json_encode($output);