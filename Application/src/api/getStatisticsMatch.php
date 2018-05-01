<?php
/**
 *
 * FileName: getStatisticsMatch.php
 * User: Michael Clark-Cuadrado
 * Date: 4/29/18
 * Time: 3:12 PM
 */
//Store state to database as user's state, then return various statistics on the selected range
require_once 'config.php';

if(isset($_POST['jsonBlob'])){
    $data = json_decode($_POST['jsonBlob'], true);
    $neighborhoodSelection = $data['neighborhoods'];
    $IUCRSelection = $data['IUCRs'];
    //TODO store user state

    //Compute statistics for selection
        //Neighborhood stats
    $neighborhoodString = "(";
    foreach($neighborhoodSelection as $i){
        $neighborhoodString .= $i . ",";
    }
    $neighborhoodQuerySubString = substr($neighborhoodString, 0,strlen($neighborhoodString) - 1);
    $neighborhoodQuerySubString .= ")";
    $neighborhoodQuery = "SELECT population, income, race_percent_latino, race_percent_black, race_percent_white, race_percent_asian, race_percent_other FROM crimetrack_chicago_community_areas WHERE area_id IN $neighborhoodQuerySubString";
    $neighborhoodQueryResult = $db->query($neighborhoodQuery);
    $totalPopulation = 0;
    $individualPopulationAndIncome = array();
    $total_latino_population = 0;
    $total_black_population = 0;
    $total_white_population = 0;
    $total_asian_population = 0;
    $total_other_population = 0;
    while($neighborhood = $neighborhoodQueryResult->fetch(PDO::FETCH_ASSOC)){
        $totalPopulation += $neighborhood['population'];
        $incomePopObj = array('population' => $neighborhood['population'], 'income' => $neighborhood['income']);
        array_push($individualPopulationAndIncome, $incomePopObj);

        $total_latino_population += $neighborhood['population'] * $neighborhood['race_percent_latino'] ;
        $total_black_population += $neighborhood['population'] * $neighborhood['race_percent_black'] ;
        $total_white_population += $neighborhood['population'] * $neighborhood['race_percent_white'] ;
        $total_asian_population += $neighborhood['population'] * $neighborhood['race_percent_asian'] ;
        $total_other_population += $neighborhood['population'] * $neighborhood['race_percent_other'] ;
    }
    $averageIncome = 0;
    foreach($individualPopulationAndIncome as $popIncomeObj){ //do weighted average of income by population
        $neighborhoodWeight = $popIncomeObj['population'] / $totalPopulation;
        $averageIncome += $neighborhoodWeight * $popIncomeObj['income'];
    }
    $neighborhoodObj = array(
        'totalPopulation' => $totalPopulation,
        'averageIncome' => round($averageIncome, 2),
        'racialBreakdown' => array(
                intval($total_latino_population),
                intval($total_black_population),
                intval($total_asian_population),
                intval($total_white_population),
                intval($total_other_population))
        );


        //Crime Statistics
    $IUCRQuerySubString = "(";
    foreach($IUCRSelection as $IUCR){
        $IUCRQuerySubString .= "'" . $IUCR . "',";
    }
    $IUCRQuerySubString = substr($IUCRQuerySubString, 0, strlen($IUCRQuerySubString) - 1); // strip last comma
    $IUCRQuerySubString .= ")";

    //counts by IUCR
    $IUCRCountQuery = "SELECT CONCAT(crime_type, ' - ', crime_description) as crime_type, COUNT(*) as TOTAL FROM crimetrack_crimes JOIN crimetrack_crime_type t on crimetrack_crimes.IUCR = t.IUCR_PK WHERE IUCR IN $IUCRQuerySubString AND COMMUNITY_AREA IN $neighborhoodQuerySubString GROUP BY IUCR ORDER BY Total DESC ";
    $IUCRCountResult = $db->query($IUCRCountQuery);
    $top10IUCRs = array();
    $rowLoopCount = 0;
    $totalCrimes = 0;
    while($row = $IUCRCountResult->fetch(PDO::FETCH_ASSOC)){
        $totalCrimes += intval($row['TOTAL']);
        if($rowLoopCount++ < 10){
            array_push($top10IUCRs, $row);
        }
    }
    $neighborhoodObj['totalCrimes'] = $totalCrimes;
    $neighborhoodObj['crimesPerHundredThousand'] = (($totalCrimes / $totalPopulation)  * 100000) / (date('Y') - 2001);

    //counts by arrest
    $arrestCountsQuery = "SELECT SUM(CASE WHEN ARREST = 'true' THEN 1 ELSE 0 END) AS `true`, SUM(CASE WHEN ARREST = 'false' THEN 1 ELSE 0 END) AS `false` FROM crimetrack_crimes WHERE IUCR IN $IUCRQuerySubString AND COMMUNITY_AREA IN $neighborhoodQuerySubString";
    $arrestCountResult = $db->query($arrestCountsQuery);
    $arrests = $arrestCountResult->fetch(PDO::FETCH_ASSOC);

    //counts by domestic
    $domesticCountsQuery = "SELECT SUM(CASE WHEN DOMESTIC = 'true' THEN 1 ELSE 0 END) AS 'true', SUM(CASE WHEN DOMESTIC = 'false' THEN 1 ELSE 0 END) as `false` FROM crimetrack_crimes WHERE IUCR IN $IUCRQuerySubString AND COMMUNITY_AREA IN $neighborhoodQuerySubString";
    $domesticCountsResult = $db->query($domesticCountsQuery);
    $domestics = $domesticCountsResult->fetch(PDO::FETCH_ASSOC);

    //counts by location description
    $locationDescCountsQuery = "SELECT LOCATION_DESCRIPTION, COUNT(*) AS TOTAL FROM crimetrack_crimes WHERE IUCR IN $IUCRQuerySubString AND COMMUNITY_AREA IN $neighborhoodQuerySubString GROUP BY LOCATION_DESCRIPTION ORDER BY TOTAL DESC LIMIT 10";
    $locationDescCountsResult = $db->query($locationDescCountsQuery);
    $locationDescs = array();
    while($row = $locationDescCountsResult->fetch(PDO::FETCH_ASSOC)){
        array_push($locationDescs, $row);
    }

    $crimeObj = array('top10IUCR' => $top10IUCRs, 'arrestCount' => $arrests, 'domesticCount' => $domestics, 'locationDescs' => $locationDescs);

    //dump as JSON
    echo json_encode(array('neighborhoodStats' => $neighborhoodObj, 'crimeStats' => $crimeObj));
}
?>