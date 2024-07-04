<?php
/************************************************************************************
	File:		supplier.php
	Purpose:	supplier
************************************************************************************/

// Start session; If session expired, load the login page.
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

// Include files
include_once 'db_functions.php';
include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();

// back URL
$backPhp = $_GET['back'].'.php';
$myUrl = "Location: ".$_GET['back'].'.php';

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
	if(isset($_GET['id']))
	{
		$mySupplier = dbQuerySupplier($_GET['id']);
		if($mySupplier <= 0)
			exit($thisResource->msgDatabaseError);
		else
		{
			$myId = $mySupplier['s_id'];
			$_SESSION['supType'] = 1;
		}
	}
	else
	{
		$myId = '';
		$_SESSION['supType'] = 0;
	}
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{	
	$myId = $_POST['s_id'];
	$column = dbGetSupColumns();
	$column_no = dbGetSupColumnNo();
	$mySupplier = array();
	for($i=0; $i<$column_no; $i++)
		$mySupplier[$column[$i]] = $_POST[$column[$i]];

	if($_SESSION['supType']==1)
		$result = dbUpdateSupplier($myId, $mySupplier);
	else
		$result = dbAddSupplier($mySupplier);

	if($result)
		header($myUrl);
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS - Supplier</title>
</head>

<body>
	<?php include 'include/nav.php' ?>
	
	<form action="" method="post">
	
    <div class="container">
		<div class="row">
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3" align="left">
				<a class="btn btn-secondary" href=<?php echo $backPhp ?> role="button"><span class='fa fa-arrow-left'></a>		
			</div>
			<div class="p-1 col-6 col-sm-6 col-md-6 col-lg-3" align="right">	
				<button type="submit" id="ok" name="ok" class="btn btn-primary"><span class='fa fa-check'></button>
			</div>
		</div>
		<!-- fields -->
		<input type="text" class="form-control" id="s_id" name="s_id" value="<?php echo $mySupplier['s_id'] ?>" hidden>
		<div class="row"><div class="input-group p-1 col-md-6 col-lg-4"> <!-- s_code -->
			<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->fmSupVCapId ?></span></div>
			<input type="text" class="form-control" id="s_code" name="s_code" value="<?php echo $mySupplier['s_code'] ?>" readonly>
		</div></div>
		<div class="row"><div class="input-group p-1 col-md-6 col-lg-4"> <!-- s_name -->
			<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->fmSupVCapName ?></span></div>
			<input type="text" class="form-control" id="s_name" name="s_name" value="<?php echo $mySupplier['s_name'] ?>" autofocus required>
		</div></div>	
		<div class="row"><div class="input-group p-1 col-md-12 col-lg-6"> <!-- address -->
			<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->fmSupVCapAddr ?></span></div>
			<input type="text" class="form-control" id="address" name="address" value="<?php echo $mySupplier['address'] ?>">
		</div></div>
		<div class="row"><div class="input-group p-1 col-md-6 col-lg-4"> <!-- post -->
			<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->fmSupVCapPost ?></span></div>
			<input type="text" class="form-control" id="post" name="post" value="<?php echo $mySupplier['post'] ?>">
		</div></div>
		<div class="row"><div class="input-group p-1 col-md-6 col-lg-4"> <!-- city -->
			<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->fmSupVCapCity ?></span></div>
			<input type="text" class="form-control" id="city" name="city" value="<?php echo $mySupplier['city'] ?>">
		</div></div>
		<div class="row"><div class="input-group p-1 col-md-6 col-lg-4"> <!-- country -->
			<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->fmSupVCapCountry ?></span></div>
			<input type="text" class="form-control" id="country" name="country" value="<?php echo $mySupplier['country'] ?>">
		</div></div>
		<div class="row"><div class="input-group p-1 col-md-12 col-lg-6"> <!-- tel -->
			<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->fmSupVCapTel ?></span></div>
			<input type="text" class="form-control" id="tel" name="tel" value="<?php echo $mySupplier['tel'] ?>">
		</div></div>
		<div class="row"><div class="input-group p-1 col-md-12 col-lg-6"> <!-- contact -->
			<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->fmSupVCapContact ?></span></div>
			<input type="text" class="form-control" id="contact" name="contact" value="<?php echo $mySupplier['contact'] ?>">
		</div></div>
		<div class="row"><div class="input-group p-1 col-md-12 col-lg-6"> <!-- email -->
			<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->fmSupVCapEmail ?></span></div>
			<input type="text" class="form-control" id="email" name="email" value="<?php echo $mySupplier['email'] ?>">
		</div></div>
		<div class="row"><div class="input-group p-1 col-md-12 col-lg-6"> <!-- whatsapp -->
			<div class="input-group-prepend"><span class="input-group-text">WhatsApp</span></div>
			<input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo $mySupplier['whatsapp'] ?>">
		</div></div>
		<div class="row"><div class="input-group p-1 col-md-12 col-lg-6"> <!-- wechat -->
			<div class="input-group-prepend"><span class="input-group-text">微信号</span></div>
			<input type="text" class="form-control" id="wechat" name="wechat" value="<?php echo $mySupplier['wechat'] ?>">
		</div></div>
	</div> <!-- end of container -->
	
	</form>
	
<script>

// Display Title
$(document).ready(function(){
	 document.getElementById("myTitle").innerHTML = '<?php echo $thisResource->fmSupVTitle ?>';
 });
 
// Prevent 'enter' key for submission, only enabled for barcode input
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});

</script>

</body>
</html>

