<?php

require "vendor/autoload.php";
header('Access-Control-Allow-Origin: *');
if (isset($_GET['stationid'])) {
	$stationid = $_GET['stationid'];
	$modeold = $_GET['modeold'];
	$modenew = $_GET['modenew'];
	$date = $_GET['date'];
	$water = $_GET['water'];
	$time = $_GET['time'];
	$data = $date." เวลา ".$time." สถานี ".$stationid." ระดับน้ำ ".$water." ม. ";
	echo $data;
	$sql="";
	switch ($stationid) {
		case "STI15":
		case "STI16":
		case "STI23":
		case "STI24":
		case "STI25":
		case "STI26":
			$sql = "SELECT user_id FROM pyflood_user WHERE status=1 and area='1'";
			break;
		case "STI19":
		case "STI20":
		case "STI21":
		case "STI22":
			$sql = "SELECT user_id FROM pyflood_user WHERE status=1 and area='2'";
			break;
		default:
			$sql = "SELECT user_id FROM pyflood_user WHERE status=1";
			break;
	}
	switch ($modenew){
		case "normal":
			$data = $data." สถานการณ์เข้าสู้สถาวะปกติ";
			break;
		case "warning":
			$data = $data." โปรดเฝ้าระวัง";
			break;
		case "critical":
			$data = $data." สถานการณ์วิกฤติอาจเกิดน้ำท่วมบางพื้นที่";
			break;
	}
	$access_token = '1I5RZ2iW6AsJqPSvEq/OvKrg3teJNAO14prZtCTeZ93Rl2hObcjKTACLea73vhwLFecf+t7lslA8yq8QO7vqoIt9K7t1mq0oTQT36KCuBBt8axdP96o4nKx1gqyHGtnjFCfnB2OaGY/C/EM2zmM0/gdB04t89/1O/w1cDnyilFU=';
	$channelSecret = '0a575a53f09199ad86f7f716dc58b431';
	$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
	$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($data);
	$members = array();
	$servername = "14352ea7-f919-468c-9792-a7ee00f56295.mysql.sequelizer.com";
	$username = "uvztmuqbiecydfhy";
	$password = "5cVopczqmvb844238yTXSQTuQFWuirWbQUKsbVtVyMGhUPjysk8QBConrzFQnfg4";
	$dbname = "db14352ea7f919468c9792a7ee00f56295";
	$conn = new mysqli($servername, $username, $password,$dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

$result = $conn->query($sql);
$userformdb;
if ($result->num_rows > 0) {
    // output data of each row
	$i = 0;
    while($row = $result->fetch_assoc()) {
		echo "id: " . $row["user_id"];
		$userformdb[$i] = $row["user_id"];
		$i = $i+1;
	}
} else {
    echo "0 results";
}
	$userid = $userformdb;
	for($i=0;$i<count($userid);$i++){
		echo "|inloop|";
		$response = $bot->pushMessage($userid[$i], $textMessageBuilder);
		
	}
	echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
}






