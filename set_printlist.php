<?php
/************************************************************************************
	File:		set_printlist.php
	Purpose:	change pinter
************************************************************************************/
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();
include_once 'db_functions.php';

$thisDb = new myDatabase($_SESSION['uDb']);

if($_SERVER['REQUEST_METHOD'] == 'POST')
{	
	$del_id = $_POST['del_id'];
	$sql = "DELETE FROM print WHERE id = '".$del_id."'";
	$thisDb->dbUpdate($sql);
}

?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS - Printer</title>
</head>
<style>
body {
 padding-top: 0rem;
}
</style>
<body>
<?php include 'include/nav.php' ?>
<br><br>
<br>
    <div class="container">

	<div class="row mb-2">
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey">
			<a class="btn" href="settings.php" role="button"><span style="color:white" class='fa fa-arrow-left'></span></a>
		</div>
		<div class="p-1 col-8 col-sm-8 col-md-8 col-lg-4"  style="background-color: DarkSlateGrey" align="center"> 
			<a style="color: white; font-weight: bold">条码打印机队列管理</a>
		</div>
		<div class="p-1 col-2 col-sm-2 col-md-2 col-lg-2" style="background-color: DarkSlateGrey" align="right">
		</div>
	</div>

	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
	<table class="table-sm table table-bordered table-hover">
		<thead class="thead-light">
			<tr>
				<th class="p-1">
					第一行标签
				</th>
				<th class="p-1">
					第二行标签
				</th>
				<th class="p-1">
					二维码
				</th>
				<th class="p-1">
					数量
				</th>
				<th class="p-1">
					提交时间
				</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sqlQuery = "SELECT * FROM print ORDER BY datum DESC";
			$printData = $thisDb->dbQuery($sqlQuery);
			if(is_array($printData)) foreach($printData AS $data){ ?>
			<tr>
<td class="p-1">
	<?= $data['label'] ?>
				</td>
				<td class="p-1">
				<?= $data['label_2'] ?>
				</td>
				<td class="p-1">
				<?= $data['code'] ?>
				</td>
				<td class="p-1">
				<?= $data['amount'] ?>
				</td>
				<td class="p-1">
				<?= $data['datum'] ?>
				</td>
				<td>
					<a href="#" onclick="if(confirm('取消打印?')){$('#del_id').val('<?= $data['id'] ?>');$('form').submit();}">删除</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
</table>
	
</div>
</div>	



		
	</div>
	
	<form action="" method="post">
		<input type="hidden" id="del_id" value="" name="del_id" />
	</form>
	
<script>
 
</script>

</body>
</html>
