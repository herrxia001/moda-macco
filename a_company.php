<?php
/* INVOICE Company */
session_start();
if(!$_SESSION['uId'])
	header("Location:alogin.php");

include_once 'resource.php';
include_once 'db_functions.php';

$thisResource = new myResource($_SESSION['uLanguage']);

$column = dbGetCompanyColumns();
$column_no = dbGetCompanyColumnNo();
$myCompany = dbQueryCompany();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{	
	$myCompany = array();
	for($i=0; $i<$column_no; $i++)
	{
		if (isset($_POST[$column[$i]]))
			$myCompany[$column[$i]] = $_POST[$column[$i]];
	}
	dbUpdateCompany($myCompany);
	header("Location:a_neword.php");
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUIMS - Company</title>
</head>

<body>
	<?php include 'include/a_nav.php' ?>
	
	<form action="" method="post">

    <div class="container">
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6" align="left">
				<b>公司资料</b>
			</div>
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-6" align="right">
				<a class="btn btn-secondary" href="a_neword.php" role="button">返回</a>		
				<button type="submit" name="ok" class="btn btn-primary">保存</button>
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="input-group-prepend"><span class="input-group-text" style="width:120px;">公司名称</span></div>
				<input type="text" class="form-control" id="c_name" name="c_name" value="<?php echo $myCompany['c_name'] ?>"
					required autofocus>
				<div class="ml-2 input-group-prepend"><span class="input-group-text" style="width:120px;">MwSt.</span></div>
				<input type="number" min="0" step="0.01" class="form-control" id="tax" name="tax" value="<?php echo $myCompany['tax'] ?>"
					required autofocus>
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="input-group-prepend"><span class="input-group-text" style="width:120px;">地址</span></div>
				<input type="text" class="form-control" id="address" name="address" value="<?php echo $myCompany['address'] ?>">					
				<div class="ml-2 input-group-prepend"><span class="input-group-text" style="width:120px;">邮编</span></div>
				<input type="text" class="form-control" id="post" name="post" value="<?php echo $myCompany['post'] ?>">
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="input-group-prepend"><span class="input-group-text" style="width:120px;">城市</span></div>
				<input type="text"class="form-control" id="city" name="city" value="<?php echo $myCompany['city'] ?>">
				<div class="ml-2 input-group-prepend"><span class="input-group-text" style="width:120px;">国家</span></div>
				<input type="text"class="form-control" id="country" name="country" value="<?php echo $myCompany['country'] ?>">
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="input-group-prepend"><span class="input-group-text" style="width:120px;">电话</span></div>
				<input type="text" class="form-control" id="tel" name="tel" value="<?php echo $myCompany['tel'] ?>">					
				<div class="ml-2 input-group-prepend"><span class="input-group-text" style="width:120px;">手机</span></div>
				<input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $myCompany['mobile'] ?>">
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="input-group-prepend"><span class="input-group-text" style="width:120px;">WhatsApp</span></div>
				<input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo $myCompany['whatsapp'] ?>">					
				<div class="ml-2 input-group-prepend"><span class="input-group-text" style="width:120px;">E-Mail</span></div>
				<input type="text" class="form-control" id="email" name="email" value="<?php echo $myCompany['email'] ?>">
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="input-group-prepend"><span class="input-group-text" style="width:120px;">Steuer No.</span></div>
				<input type="text" class="form-control" id="tax_no" name="tax_no" value="<?php echo $myCompany['tax_no'] ?>">					
				<div class="ml-2 input-group-prepend"><span class="input-group-text" style="width:120px;">Ust-IdNr.</span></div>
				<input type="text" class="form-control" id="uid_no" name="uid_no" value="<?php echo $myCompany['uid_no'] ?>">
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="input-group-prepend"><span class="input-group-text" style="width:120px;">IBAN</span></div>
				<input type="text" class="form-control" id="iban" name="iban" value="<?php echo $myCompany['iban'] ?>">					
				<div class="ml-2 input-group-prepend"><span class="input-group-text" style="width:120px;">BIC</span></div>
				<input type="text" class="form-control" id="bic" name="bic" value="<?php echo $myCompany['bic'] ?>">
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="input-group-prepend"><span class="input-group-text" style="width:120px;">HRB</span></div>
				<input type="text" class="form-control" id="hrb" name="hrb" value="<?php echo $myCompany['hrb'] ?>">					
				<div class="ml-2 input-group-prepend"><span class="input-group-text" style="width:120px;">法人代表</span></div>
				<input type="text" class="form-control" id="geschaeftsfuehrer" name="geschaeftsfuehrer" value="<?php echo $myCompany['geschaeftsfuehrer'] ?>">
			</div>
		</div>
		<div class="row">
			<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-12">
				<div class="input-group-prepend"><span class="input-group-text" style="width:120px;">网址</span></div>
				<input type="text" class="form-control" id="website" name="website" value="<?php echo $myCompany['website'] ?>">
			</div>
		</div>
	</div>
	
	</form>
</body>
</html>
