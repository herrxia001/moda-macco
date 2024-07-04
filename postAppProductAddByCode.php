<?php
/*
	File: postAppProductAddByCode.php
	Purpose: add a new record to the app_product
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['i_code']))
{
	$iCode = $_POST['i_code'];
	$result = dbAppProductCreate($iCode);
	if($result <= 0)
		echo json_encode("NO");
	else
		echo json_encode($result);
}
else
	echo json_encode("NO");

?>
