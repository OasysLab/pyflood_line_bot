<?php 
header('Access-Control-Allow-Origin: *');
require "vendor/autoload.php";
$access_token = '1I5RZ2iW6AsJqPSvEq/OvKrg3teJNAO14prZtCTeZ93Rl2hObcjKTACLea73vhwLFecf+t7lslA8yq8QO7vqoIt9K7t1mq0oTQT36KCuBBt8axdP96o4nKx1gqyHGtnjFCfnB2OaGY/C/EM2zmM0/gdB04t89/1O/w1cDnyilFU=';
$channelSecret = '0a575a53f09199ad86f7f716dc58b431';
///.....................

$servername = "14352ea7-f919-468c-9792-a7ee00f56295.mysql.sequelizer.com";
$username = "uvztmuqbiecydfhy";
$password = "5cVopczqmvb844238yTXSQTuQFWuirWbQUKsbVtVyMGhUPjysk8QBConrzFQnfg4";
$dbname = "db14352ea7f919468c9792a7ee00f56295";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


// Get POST body content
$content = file_get_contents('php://input');
$events = json_decode($content, true);
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
$respone = "ไม่เจอคำสั่ง";
if($events["events"][0]["message"]["text"]=="รับแจ้งเตือน อ.เมือง"){
	$respone = "รับแจ้งเตือน อ.เมือง แล้ว";
	$sql = "INSERT INTO pyflood_user (user_id, area, status,uq_code ) VALUES ('".$events["events"][0]["source"]["userId"]."', '1', '1','".$events["events"][0]["source"]["userId"]."1');";
	$result = $conn->query($sql);
	if(!$result){
		$sql2 = "UPDATE pyflood_user SET status=1 WHERE user_id='".$events["events"][0]["source"]["userId"]."' and area='1';";
		$result2 = $conn->query($sql2);
		if(!$result2){
			$respone ="ท่านรับแจ้งเตือนสถาณการณ์ อ.เมือง อยู่แล้ว";
		}
	}
}
elseif ($events["events"][0]["message"]["text"]=="รับแจ้งเตือน อ.เชียงดอกคำใต้"){
	$respone = "รับแจ้งเตือน อ.เชียงดอกคำใต้ แล้ว";
	$sql = "INSERT INTO pyflood_user (user_id, area, status,uq_code ) VALUES ('".$events["events"][0]["source"]["userId"]."', '2', '1','".$events["events"][0]["source"]["userId"]."2');";
	$result = $conn->query($sql);
	if(!$result){
		$sql2 = "UPDATE pyflood_user SET status=1 WHERE user_id='".$events["events"][0]["source"]["userId"]."' and area='2';";
		$result2 = $conn->query($sql2);
		if(!$result2){
			$respone ="ท่านรับแจ้งเตือนสถาณการณ์ อ.เชียงดอกคำใต้ อยู่แล้ว";
		}	
	}
}
elseif ($events["events"][0]["message"]["text"]=="ยกเลิกการแจ้งเตือนทั้งหมด"){
	$respone = "ยกเลิกการรับแจ้งเตือนทั้งหมดแล้ว";
	$sql = "UPDATE pyflood_user SET status=0 WHERE user_id='".$events["events"][0]["source"]["userId"]."';";
	$result = $conn->query($sql);
	if(!$result){
		$respone ="ไม่สามารถยกเลิกได้";
	}
}
$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($respone);
$response = $bot->pushMessage($events["events"][0]["source"]["userId"], $textMessageBuilder);
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
$conn->close();
?>
