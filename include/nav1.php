<style>
.navbar-brand{
	font-size: 16px;
}
.nav-item{
	font-size: 16px;
}
</style>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<a class="navbar-brand" href="home.php">EUCWS</a>
	<label id="myTitle" style="font-size:16px; color:#fff" class="mt-2"></label>

<?php if ($_SESSION['uRole'] == 0) { ?>

	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsMain" >
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarsMain">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active">
				<a class="nav-link" href="home.php"><?php echo $thisResource->nvHome ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="inv_mgt.php"><?php echo $thisResource->nvInventory ?></a>
			</li>		
			<li class="nav-item">
				<a class="nav-link" href="pur_mgt.php"><?php echo $thisResource->nvPurchase ?></a>
			</li>			
			<li class="nav-item">
				<a class="nav-link" href="order_mgt.php"><?php echo $thisResource->nvSales ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="management.php"><?php echo $thisResource->nvManagement ?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="sales_report.php"><?php echo $thisResource->nvReports ?></a>
			</li>
<!--
			<li class="nav-item">
				<a class="nav-link" href="app_home.php"><?php echo $thisResource->nvApp ?></a>
			</li>
-->
			<li class="nav-item">
				<a class="nav-link" href="settings.php"><?php echo $thisResource->nvSettings ?></a>
			</li>			
		</ul>
	</div>
	
<?php } ?>

</nav>

