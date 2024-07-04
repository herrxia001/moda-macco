<?php
include_once '../database.php';
include_once 'mail.php';

if(!isset($_POST['db']) || !isset($_POST['app_company'])){
	echo "-1";
	return;
}

$db = $_POST['db'];
$company = json_decode($_POST['app_company'], true);
	
$thisDb = new myDatabase($db);
if ($_FILES['file'] != NULL)
	$file = "1";
else
	$file = "0";
if (strtolower($company['apc_name']) == "testapp0323") {
	$status = "1";
	$kId = "3000";
} else {
	$status = "0";
	$kId = "0";
}
$sqlAdd = "INSERT INTO 
			app_company(apc_name,type,areacode,country,address,address1,post,city,contact,taxno,email,cell,whatsapp,memo,tel, status, message, 
			time_created, time_updated, file, k_id)
			VALUES('". 
			$company['apc_name']."','".$company['type']."','".$company['areacode']."','".$company['country']."','".$company['address']."','".
			$company['address1']."','".$company['post']."','".$company['city']."','".$company['contact']."','".$company['taxno']."','".
			$company['email']."','".$company['cell']."','".$company['whatsapp']."','".$company['memo']."','".$company['tel'].
			"','".$status."','".$company['message']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$file."','".$kId."')";
$result = $thisDb->dbInsertId($sqlAdd);	

writeLog("APP KUND: ".$result." ".$sqlAdd);

if ($_FILES['file'] != NULL) {
	$filePath = "../files/".$db."/app/".$result.".pdf";
	move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
}

$thisDb->dbClose();

sendEmail($db, $company);

if (!$result){
	echo "-2";
} else {
	echo $result;
}

function getEmailTo($db) {
	//if ($db == "reho")
		return "info@rehoboth-moda.de";
	//else
	//	return "herrxia@gmail.com";
}

function sendEmail($db, $company) {	

	$recipient = getEmailTo($db);
	$subject = "New Customer Application";
	$bodyText = "新的客户申请\r\n客户: ".$company['apc_name']."\r\n国家: ".$company['country'];
	$bodyHtml = "<h3>新的客户申请</h3>
				<p>客户: ".$company['apc_name']."</p><p>国家: ".$company['country']."</p>
				<a href='https://www.moda-macco.com'>点击登陆MODAS</a>
				<p>此邮件为系统自动发送，请勿回复</p>";
	
	sendEmailSmtp($recipient, $bodyHtml, $subject);
}

?>
