<?php
header('Content-Type: application/json');
$result = json_decode(file_get_contents("http://www.pyflood.com/scripts/jsonfile/get-data-map-home.php"));
$json="[";
foreach($result as $station){
    //echo $station->Station_id;
    $json = $json.'{';
    $json = $json.'"station_id":"'.$station->Station_id.'",';
    $json = $json.'"station_code":"'.$station->Station_code.'",';
    $json = $json.'"station_name":"'.$station->Station_name.'",';
    $json = $json.'"water":"'.$station->water_level.'",';
    $json = $json.'"time_water":"'.$station->time_water.'",';
    $status;
    if($station->water_sea < $station->water_warning){
        $status="normal";
    }
    if($station->water_sea >= $station->water_warning){
        $status="warning";
    }
    if($station->water_sea >= $station->water_critical){
        $status="critical";
    }
    $json = $json.'"status":"'.$status.'"';
    $json = $json.'},';
}
$json=rtrim($json,", ");
$json=$json."]";
echo $json;
?>