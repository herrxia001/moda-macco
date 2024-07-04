<?php
/*
	File:		postImageDel.php	
	Purpose:	Delete image file and delete inv_img record
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['id']))
{
	// Del inv_img
	$path = dbDelInvImage($_POST['id'], $_POST['imageNo']);
	
	// Delete the image file
	$imgFileName = dbGetImageFilename($_POST['id'], $_POST['path'], $_POST['imageNo'], 0);
	unlink($imgFileName);
	$imgFileName = dbGetImageFilename($_POST['id'], $_POST['path'], $_POST['imageNo'], 1);
	unlink($imgFileName);	
	
	echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
