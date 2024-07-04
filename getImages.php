<?php
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(!$_GET['id'])
	echo json_encode("NO");
else
{
	$images = dbGetInvImages($_GET['id']);
	if($images <= 0)
		echo json_encode("NO");
	else		
		echo json_encode($images);
}

?>
