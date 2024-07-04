<?php
/*
	File:		postImageAdd.php	
	Purpose:	Upload image file and add inv_img record
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

if(isset($_POST['id']))
{
	// Compress image to save thumbnail
	$imgThumbName = dbGetImageFileName($_POST['id'], $_POST['path'], $_POST['imageNo'], 1);
	$image = imagecreatefromjpeg($_FILES['image']['tmp_name']);
	$image = imagescale($image, 80);
	imagejpeg($image, $imgThumbName, 50);
	
	// Save the image file
	$imgFileName = dbGetImageFileName($_POST['id'], $_POST['path'], $_POST['imageNo'], 0);
	move_uploaded_file($_FILES['image']['tmp_name'], $imgFileName);
	
	// Add inv_img
	dbAddInvImage($_POST['id'], $_POST['imageNo']);
	
	echo json_encode("OK");
}
else
	echo json_encode("NO");

?>
