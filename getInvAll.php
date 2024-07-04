<?php
/* 	
	File:		getInvAll.php
	Purpose: 	Query all inventories using $_GET.
	Return: 	All inventories.
*/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'db_functions.php';

$sql = "SELECT * FROM inventory";
if(isset($_GET['s_id']))
{
	$sql = $sql." WHERE s_id='".$_GET['s_id']."'";
	$ok = 1;
}
if(isset($_GET['t_id']))
{
	if($ok)
		$sql = $sql." AND t_id='".$_GET['t_id']."'";
	else
		$sql = $sql." WHERE t_id='".$_GET['t_id']."'";
}

$inv = dbGetAllInvs($sql);
if($inv < 0)
	echo json_encode("NO");
else		
	echo json_encode($inv);

?>
