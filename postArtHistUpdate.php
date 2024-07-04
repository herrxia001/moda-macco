<?php
/*
	File: postArtHistUpdate.php
	Purpose: Update record to the article
*/

session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_invoice.php';

if(isset($_POST['art'])) {
	$art = json_decode($_POST['art'], true);
	$result = dbUpdateArticleHist($art);
	if(!$result)
		echo json_encode("NO");
	else
		echo json_encode("OK");
} else {
	echo json_encode("NO");
}

?>
