<?php
include_once '../database.php';
include_once 'mail.php';


if(!isset($_POST['db']) || !isset($_POST['order'])){
	echo json_encode("NO");
	return;
}
$db = $_POST['db'];

//$db = "n6tj5gv6_yola_test";

$thisDb = new myDatabase($db);
$order = json_decode($_POST['order'], true);

$oId = getOrderId($db);

$countSum = 0;
$totalSum = 0;
$priceSum = 0;
foreach($order AS $i_id => $element){
    $countSum += intval($element['amount']);
    $priceSum += intval($element['amount'])*floatval($element['info'][0]['price']);



    $sqlAddItem = "INSERT INTO order_items(o_id, i_id, count, cost, price, unit) VALUES('".
					$oId."','".$i_id."','".$element['amount']."','".$element['info'][0]['cost']."','".$element['info'][0]['price']."','1')";
	$result = $thisDb->dbInsertId($sqlAddItem);
    $erg['sqlAddItem'][] = $sqlAddItem;

	if(is_array($element['variant'])){
		foreach($element['variant'] AS $variant){
			$sqlAddVar = "INSERT INTO order_variant(o_id, i_id, iv_id, count) VALUES('".
			$oId."','".$i_id."','".$variant['iv_id']."','".$variant['amount']."')";
			$result = $thisDb->dbInsertId($sqlAddVar);

			$erg['sqlAddVar'][] = $sqlAddVar;
		}
	}
    /*if($element['variant'][0]['iv_id'] != ""){
        $sqlAddVar = "INSERT INTO order_variant(o_id, i_id, iv_id, count) VALUES('".
        $oId."','".$i_id."','".$element['variant'][0]['iv_id']."','".$element['amount']."')";
        $result = $thisDb->dbInsertId($sqlAddVar);

        $erg['sqlAddVar'][] = $sqlAddVar;
    }*/
}
$totalSum = $priceSum;

$k_id = $_POST['c_id'];

$thisDb = new myDatabase($db);
$sqlAdd = "INSERT INTO orders(o_id, k_id, date, count_sum, price_sum, total_sum, due, status) VALUES('". 
			$oId."','".$k_id."','".date('Y-m-d H:i:s')."','".$countSum."','".$priceSum."','".$totalSum."','".$totalSum."','10')";
$result = $thisDb->dbInsert($sqlAdd);	


sendEmail($db, $k_id, $countSum, $totalSum);


$erg['oId'] = $oId;
$erg['countSum'] = $countSum;
$erg['totalSum'] = $totalSum;
$erg['sqlAdd'] = $sqlAdd;
echo json_encode($erg);




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






/*

require 'vendor/autoload.php';

*/



function getEmailTo($db) {
	//if ($db == "reho")
		return "info@rehoboth-moda.de";
	//else
	//	return "herrxia@gmail.com";
}

function sendEmail($db, $kId, $count, $total) {	
	$kName = getCustName($db, $kId);
	$recipient = getEmailTo($db);
	
	$subject = "You have a new order from APP";
	$bodyText = "新的订单\r\n客户: ".$kName."\r\n件数: ".$count."\r\n金额: ".$total;
	$bodyHtml = "<h3>新的订单</h3>
				<p>客户: ".$kName."</p><p>件数: ".$count."</p><p>金额: ".$total."</p>
				<a href='https://www.moda-macco.com'>点击登陆MODAS</a>
				<p>此邮件为系统自动发送，请勿回复</p>";
	
    sendEmailSmtp($recipient, $bodyHtml, $subject);
}

?>
