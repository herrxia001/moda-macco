<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

include_once 'database.php';

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
			"','".$status."','','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$file."','".$kId."')";
$result = $thisDb->dbInsertId($sqlAdd);	

writeLog("APP KUND: ".$result." ".$sqlAdd);

if ($_FILES['file'] != NULL) {
	$filePath = "files/".$db."/app/".$result.".pdf";
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
	if ($db == "reho")
		return "info@rehoboth-moda.de";
	else
		return "luhuieric@gmail.com";
}

function sendEmail($db, $company) {	
	$sender = 'info@eucws.com';
	$senderName = 'MODAS';	
	$recipient = getEmailTo($db);
	
	$usernameSmtp = 'AKIASXDKD3NXPUN3SQ4T';
	$passwordSmtp = 'BMCgXGAn499potwZ7+YnMK9GfHZtVu+2SaEVaCsbKj6p';
	$host = 'email-smtp.eu-central-1.amazonaws.com';
	$port = 587;
	
	$subject = "New Customer Application";
	$bodyText = "新的客户申请\r\n客户: ".$company['apc_name']."\r\n国家: ".$company['country'];
	$bodyHtml = "<h3>新的客户申请</h3>
				<p>客户: ".$company['apc_name']."</p><p>国家: ".$company['country']."</p>
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
