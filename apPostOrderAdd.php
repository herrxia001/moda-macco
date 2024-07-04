<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

include_once 'database.php';

if(!isset($_POST['order']) || !isset($_POST['db'])) {
	echo "-1";
	return;
}

$db = $_POST['db'];
$order = json_decode($_POST['order'], true);
$orderItems = $order['orderitems'];
if (count($orderItems) <= 0) {
	echo "-1";
	return;
}
$orderVariants = $order['ordervariants'];

$countSum = 0;
$priceSum = 0;
$totalSum = 0;
for ($i=0; $i<count($orderItems); $i++) {
	$countSum += intval($orderItems[$i]['count']);
	$priceSum += intval($orderItems[$i]['count'])*floatval($orderItems[$i]['price']);
}
$totalSum = $priceSum;
$oId = getOrderId($db);
if ($oId <= 0) {
	echo "-2";
	return;	
}

$thisDb = new myDatabase($db);
$sqlAdd = "INSERT INTO orders(o_id, k_id, date, count_sum, price_sum, total_sum, due, status) VALUES('". 
			$oId."','".$order['k_id']."','".date('Y-m-d H:i:s')."','".$countSum."','".$priceSum."','".$totalSum."','".$totalSum."','10')";
$result = $thisDb->dbInsert($sqlAdd);	
if (!$result) {
	echo "-2";
	return;
}

for ($i=0; $i<count($orderItems); $i++) {
	$sqlAddItem = "INSERT INTO order_items(o_id, i_id, count, cost, price, unit) VALUES('".
					$oId."','".$orderItems[$i]['i_id']."','".$orderItems[$i]['count']."','".$orderItems[$i]['cost']."','".$orderItems[$i]['price']."','1')";
	$result = $thisDb->dbInsertId($sqlAddItem);
}

for ($i=0; $i<count($orderVariants); $i++) {
	$sqlAddVar = "INSERT INTO order_variant(o_id, i_id, iv_id, count) VALUES('".
					$oId."','".$orderVariants[$i]['i_id']."','".$orderVariants[$i]['iv_id']."','".$orderVariants[$i]['count']."')";
	$result = $thisDb->dbInsertId($sqlAddVar);
}

$thisDb->dbClose();

sendEmail($db, $order['k_id'], $countSum, $totalSum);

echo $oId;

function getOrderId($db)
{	
	$thisDb = new myDatabase($db);
	$sqlQuery = "SELECT code_num FROM code_gen WHERE code_type ='o'";
    $thisQuery = $thisDb->dbQuery($sqlQuery);	
	if($thisQuery <= 0){
		$thisDb->dbClose();
		return -1;
	}
	$thisNum = $thisQuery[0]['code_num'];
	$newNum = intval($thisNum);
	$newNum++;
	$sqlUpdate = "UPDATE code_gen SET code_num = '".$newNum."' WHERE code_type ='o'";
    $thisQuery = $thisDb->dbUpdate($sqlUpdate);
	$thisDb->dbClose();
	
	return $thisNum;
}

function getCustName($db, $kId) {
	$thisDb = new myDatabase($db);
	$sqlQuery = "SELECT * FROM customer WHERE k_id='".$kId."'";
    $thisQuery = $thisDb->dbQuery($sqlQuery);
	$thisDb->dbClose();
	
	return $thisQuery[0]['k_name'];
}

function getEmailTo($db) {
	if ($db == "reho")
		return "info@rehoboth-moda.de";
	else
		return "luhuieric@gmail.com";
}

function sendEmail($db, $kId, $count, $total) {	
	$kName = getCustName($db, $kId);
	$sender = 'info@eucws.com';
	$senderName = 'MODAS';	
	$recipient = getEmailTo($db);
	
	$usernameSmtp = 'AKIASXDKD3NXPUN3SQ4T';
	$passwordSmtp = 'BMCgXGAn499potwZ7+YnMK9GfHZtVu+2SaEVaCsbKj6p';
	$host = 'email-smtp.eu-central-1.amazonaws.com';
	$port = 587;
	
	$subject = "You have a new order from APP";
	$bodyText = "新的订单\r\n客户: ".$kName."\r\n件数: ".$count."\r\n金额: ".$total;
	$bodyHtml = "<h3>新的订单</h3>
				<p>客户: ".$kName."</p><p>件数: ".$count."</p><p>金额: ".$total."</p>
				<a href='http://eucws.com'>点击登陆MODAS</a>
				<p>此邮件为系统自动发送，请勿回复</p>";
	
	$mail = new PHPMailer(true);

    // Specify the SMTP settings.
    $mail->isSMTP();
    $mail->setFrom($sender, $senderName);
    $mail->Username   = $usernameSmtp;
    $mail->Password   = $passwordSmtp;
    $mail->Host       = $host;
    $mail->Port       = $port;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
//    $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

    // Specify the message recipients.
    $mail->addAddress($recipient);
    // You can also add CC, BCC, and additional To recipients here.

    // Specify the content of the message.
    $mail->isHTML(true);
    $mail->Subject    = $subject;
    $mail->Body       = $bodyHtml;
    $mail->AltBody    = $bodyText;
    $mail->Send();

}

?>
