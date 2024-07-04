<?php
/************************************************************************************
	File:		sales_report.php
	Purpose:	Reports
************************************************************************************/

// Start session
session_start();
if(!$_SESSION['uId'])
	header("Location:index.php");

// Include files
include 'db_functions.php';
include_once 'resource_'.$_SESSION['uLanguage'].'.php';
$thisResource = new myResource();

$myCustomers = dbQueryAllCustomers();
$mySuppliers = dbQueryAllSuppliers();
$myTypes = dbQueryTypes();
$active[6] = "active";
?>

<!doctype html>
<html lang="en">
<head>
    <?php include 'include/header.php' ?>
	<title>EUCWS - Report</title>
</head>
<style>
body {
	font-size: 14px;
}
thead th {
	font-size: 14px;
	padding: 1px !important;
}
tbody td {
	font-size: 14px;
	padding: 1px !important;
}
#modalSalesDetailsCust {
	z-index:9999;
}
#modalOrder {
	z-index:10000;
}
</style>
<body>
	<?php include 'include/nav.php' ?>	
	<?php include "include/modalSelTime.php" ?>
	<?php include "include/modalCustSrchNew.php" ?>
		
<!-- options -->
<div class="container" id="containerTabs">	
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
			<ul class="nav nav-tabs" id="myTabs">
				<li class="nav-item"><a class="nav-link active" id="tabMain" href="#mainTab" data-toggle="tab" style="font-size:14px" onclick="showMainTab()"><?php echo $thisResource->comProduct ?></a></li>
				<li class="nav-item"><a class="nav-link" id="tabCust" href="#custTab" data-toggle="tab" style="font-size:14px" onclick="showCustTab()"><?php echo $thisResource->comCustomer ?></a></li>
				<li class="nav-item"><a class="nav-link" id="tabSup" href="#supTab" data-toggle="tab" style="font-size:14px" onclick="showSupTab()"><?php echo $thisResource->comSupplier ?></a></li>
				<li class="nav-item"><a class="nav-link" id="tabType" href="#typeTab" data-toggle="tab" style="font-size:14px" onclick="showTypeTab()"><?php echo $thisResource->comType ?></a></li>
				<li class="nav-item"><a class="nav-link" id="tabPay" href="#payTab" data-toggle="tab" style="font-size:14px" onclick="showPayTab()"><?php echo $thisResource->comPayment ?></a></li>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class="container">	
<!-- tab content -->
	<div class="tab-content">
	
<!-- mainTab -->	
	<div class="tab-pane active" id="mainTab">
	<!-- options -->
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-4">
			<button type="button" class="btn btn-secondary" onclick="showTabs()"><span class='fa fa-bars'></button>
			<button type="button" class="ml-1 btn btn-secondary" onclick="searchInv()"><span class='fa fa-search'></button>			
			<button type="button" class="ml-1 btn btn-outline-secondary" id="selTime" onclick="selectTime()" style="font-size:14px;"></button>
			<div class="dropdown">
				<button type="button" class="ml-1 btn btn-outline-secondary dropdown-toggle" id="sortOption" data-toggle="dropdown" style="font-size:14px"><?php echo $thisResource->comSortSaleValueDesc ?></button>
				<div class="dropdown-menu">
				<a class="dropdown-item" href="#" onclick="doneSort(this)" style="font-size:14px"><?php echo $thisResource->comSortSaleCountDesc ?></a>
				<a class="dropdown-item" href="#" onclick="doneSort(this)" style="font-size:14px"><?php echo $thisResource->comSortSaleValueDesc ?></a>
				<a class="dropdown-item" href="#" onclick="doneSort(this)" style="font-size:14px"><?php echo $thisResource->comSortProfitDesc ?></a>
				<a class="dropdown-item" href="#" onclick="doneSort(this)" style="font-size:14px"><?php echo $thisResource->comSortInvDesc ?></a>
				<a class="dropdown-item" href="#" onclick="doneSort(this)" style="font-size:14px"><?php echo $thisResource->comSortInvAsc ?></a>
				<a class="dropdown-item" href="#" onclick="doneSort(this)" style="font-size:14px"><?php echo $thisResource->comSortPurchaseDate ?></a>
				<a class="dropdown-item" href="#" onclick="doneSort(this)" style="font-size:14px"><?php echo $thisResource->comSortCodeAZ ?></a>
				<a class="dropdown-item" href="#" onclick="doneSort(this)" style="font-size:14px"><?php echo $thisResource->comSortCodeZA ?></a>
				</div>
			</div>
		</div>
	</div>
	<!-- summary -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
			<table id="tableSum" class="table-sm" data-toggle="table">
				<thead class="thead-light">
					<tr>				
					<th data-field="idx_items" data-width="25" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProProductTotal ?></th>
					<th data-field="idx_count" data-width="25" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProCountTotal ?></th>
					<th data-field="idx_price" data-width="25" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProValueTotal ?></th>
					<th data-field="idx_prorate" data-width="25" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProProfitRate ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
		</div>		
	</div>	
	<!-- Search result table -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">	
			<table id="tableMain" class="table-sm" data-toggle="table">
				<thead class="thead-light">
					<tr>
					<th data-field="id" data-width="0" data-width-unit="%" data-visible="false">#</th>
					<th data-field="idx_image" data-width="10" data-width-unit="%" data-halign="center" data-align="center"></th>				
					<th data-field="idx_data" data-width="30" data-width-unit="%" data-halign="center" data-align="left"><?php echo $thisResource->rptProProduct ?></th>
					<th data-field="idx_units" data-width="15" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProInventory ?></th>
					<th data-field="idx_count" data-width="15" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProSales ?></th>
					<th data-field="idx_price" data-width="15" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProValue ?></th>
					<th data-field="idx_prorate" data-width="15" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProProfit ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
		</div>
	</div>
	</div> <!-- End of mainTab -->
		
<!-- custTab -->	
	<div class="tab-pane" id="custTab">
	<!-- options -->	
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
			<button type="button" class="btn btn-secondary" onclick="showTabs()"><span class='fa fa-bars'></button>
			<button type="button" class="ml-1 btn btn-secondary" onclick="searchCust()"><span class='fa fa-search'></button>			
			<button type="button" class="ml-1 btn btn-outline-secondary" id="selTimeCust" onclick="selectTime()" style="font-size:14px"></button>
			<div class="dropdown">
				<button type="button" class="ml-1 btn btn-outline-secondary dropdown-toggle" id="sortOptionCust" data-toggle="dropdown" style="font-size:14px"><?php echo $thisResource->comSortSaleValueDesc ?></button>
				<div class="dropdown-menu">
				<a class="dropdown-item" href="#" onclick="doneSortCust(this)" style="font-size:14px"><?php echo $thisResource->comSortSaleCountDesc ?></a>
				<a class="dropdown-item" href="#" onclick="doneSortCust(this)" style="font-size:14px"><?php echo $thisResource->comSortSaleValueDesc ?></a>
				<a class="dropdown-item" href="#" onclick="doneSortCust(this)" style="font-size:14px"><?php echo $thisResource->comSortCodeAZ ?></a>
				<a class="dropdown-item" href="#" onclick="doneSortCust(this)" style="font-size:14px"><?php echo $thisResource->comSortCodeZA ?></a>
				</div>
			</div>
		</div>
	</div>
	<!-- summary -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
			<table id="tableCustSum" class="table-sm" data-toggle="table">
				<thead class="thead-light">
					<tr>				
					<th data-field="idx_custs" data-width="30" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptCustTotal ?></th>
					<th data-field="idx_count" data-width="30" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProCountTotal ?></th>
					<th data-field="idx_price" data-width="40" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProValueTotal ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
		</div>		
	</div>
	<!-- Search result table -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">	
			<table id="tableCust" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true">
				<thead class="thead-light">
					<tr>
					<th data-field="id" data-width="0" data-width-unit="%" data-visible="false">#</th>
					<th data-field="idx_cust" data-width="60" data-width-unit="%"><?php echo $thisResource->comCustomer ?></th>				
					<th data-field="idx_count" data-width="20" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->comQuantity ?></th>
					<th data-field="idx_price" data-width="20" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->comValue ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
		</div>
	</div>
	</div> <!-- End of custTab -->
		
<!-- supTab -->	
	<div class="tab-pane" id="supTab">
	<!-- options -->	
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-8">
			<button type="button" class="btn btn-secondary" onclick="showTabs()"><span class='fa fa-bars'></button>		
			<button type="button" class="ml-1 btn btn-outline-secondary" id="selTimeSup" onclick="selectTime()" style="font-size:14px"></button>
			<div class="dropdown">
				<button type="button" class="ml-1 btn btn-outline-secondary dropdown-toggle" id="sortOptionSup" data-toggle="dropdown" style="font-size:14px"><?php echo $thisResource->comSort ?></button>
				<div class="dropdown-menu">
				<a class="dropdown-item" href="#" onclick="doneSortSup(this)" style="font-size:14px"><?php echo $thisResource->comSortInCountDesc ?></a>
				<a class="dropdown-item" href="#" onclick="doneSortSup(this)" style="font-size:14px"><?php echo $thisResource->comSortInValueDesc ?></a>
				<a class="dropdown-item" href="#" onclick="doneSortSup(this)" style="font-size:14px"><?php echo $thisResource->comSortSaleCountDesc ?></a>
				<a class="dropdown-item" href="#" onclick="doneSortSup(this)" style="font-size:14px"><?php echo $thisResource->comSortSaleValueDesc ?></a>
				<a class="dropdown-item" href="#" onclick="doneSortSup(this)" style="font-size:14px"><?php echo $thisResource->comSortCodeAZ ?></a>
				<a class="dropdown-item" href="#" onclick="doneSortSup(this)" style="font-size:14px"><?php echo $thisResource->comSortCodeZA ?></a>
				</div>
			</div>
		</div>
	</div>
	<!-- summary -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
			<table id="tableSupSum" class="table-sm" data-toggle="table">
				<thead class="thead-light">
					<tr>				
					<th data-field="idx_incount" data-width="20" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptSupInCount ?></th>
					<th data-field="idx_cost" data-width="30" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptSupInValue ?></th>
					<th data-field="idx_outcount" data-width="20" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptSupOutCount ?></th>
					<th data-field="idx_price" data-width="30" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptSupOutValue ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
		</div>		
	</div>
<!-- Search result table -->
			<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">	
			<table id="tableSup" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true" data-unique-id="id">
				<thead class="thead-light">
					<tr>
					<th data-field="id" data-width="0" data-width-unit="%" data-visible="false">#</th>
					<th data-field="idx_sup" data-width="20" data-width-unit="%"><?php echo $thisResource->comSupplier ?></th>				
					<th data-field="idx_incount" data-width="20" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->comPurchase ?></th>
					<th data-field="idx_cost" data-width="20" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->comValue ?></th>
					<th data-field="idx_outcount" data-width="20" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProSales ?></th>
					<th data-field="idx_price" data-width="20" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->comValue ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
			</div>
			</div>
		</div> <!-- End of supTab -->
		
<!-- typeTab -->	
	<div class="tab-pane" id="typeTab">
	<!-- options -->
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-4">
			<button type="button" class="btn btn-secondary" onclick="showTabs()"><span class='fa fa-bars'></button>		
			<button type="button" class="ml-1 btn btn-outline-secondary" id="selTimeType" onclick="selectTime()" style="font-size:14px"></button>
		</div>

		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-4" style="justify-content: flex-end;">
			<input type="text" class="form-control ml-2" style="max-width: 150px;" name="country" id="country" value="所有国家" readonly>
				<div class="dropdown dropleft">
					<button type="button" class="btn btn-secondary dropdown-toggle ml-2" data-toggle="dropdown" aria-expanded="false">更改国家</button>
					<ul class="dropdown-menu" style="">
						<li><a class="dropdown-item" href="#" onclick="changeCountry('')">所有国家</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Austria')">Austria</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Belgien')">Belgien</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Czechia')">Czechia</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Denmark')">Denmark</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Deutschland')">Deutschland</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Finland')">Finland</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('France')">France</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Italy')">Italy</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Luxemburg')">Luxemburg</a></li>						
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Nederland')">Nederland</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Schweiz')">Schweiz</a></li>
						<li><a class="dropdown-item" href="#" onclick="changeCountry('Spain')">Spain</a></li>
					</ul>
				</div>
		</div>
	</div>
	<!-- summary -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
			<table id="tableTypeSum" class="table-sm" data-toggle="table">
				<thead class="thead-light">
					<tr>				
					<th data-field="idx_types" data-width="30" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->comType ?></th>
					<th data-field="idx_count" data-width="30" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProCountTotal ?></th>
					<th data-field="idx_price" data-width="40" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProValueTotal ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
		</div>		
	</div>
	<!-- Search result table -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">	
			<table id="tableType" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true">
				<thead class="thead-light">
					<tr>
					<th data-field="id" data-width="0" data-width-unit="%" data-visible="false">#</th>				
					<th data-field="idx_type" data-width="40" data-width-unit="%" data-sortable="true"><?php echo $thisResource->comType ?></th>
					<th data-field="idx_tcount" data-width="20" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->rptProInventory ?></th>
					<th data-field="idx_count" data-width="20" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->rptProSales ?></th>
					<th data-field="idx_price" data-width="20" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->rptProValue ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
		</div>
	</div>
	</div> <!-- End of typeTab -->		

<!-- payTab -->	
	<div class="tab-pane" id="payTab">
	<!-- options -->
	<div class="row">
		<div class="p-1 input-group col-12 col-sm-12 col-md-12 col-lg-12">
			<button type="button" class="btn btn-secondary" onclick="showTabs()"><span class='fa fa-bars'></button>	
			<button type="button" class="ml-1 btn btn-outline-secondary" id="selTimePay" onclick="selectTime()" style="font-size:14px"></button>
		</div>
	</div>
	<!-- summary -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">
			<table id="tablePaySum" class="table-sm" data-toggle="table">
				<thead class="thead-light">
					<tr>				
					<th data-field="idx_pays" data-width="50" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->comPaymentArt ?></th>
					<th data-field="idx_price" data-width="50" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->rptProValueTotal ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
		</div>		
	</div>
<!-- Search result table -->
	<div class="row">
		<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-8">	
			<table id="tablePay" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true">
				<thead class="thead-light">
					<tr>
					<th data-field="id" data-width="0" data-width-unit="%" data-visible="false">#</th>				
					<th data-field="idx_pay" data-width="60" data-width-unit="%" data-sortable="true"><?php echo $thisResource->comPaymentArt ?></th>
					<th data-field="idx_price" data-width="40" data-width-unit="%" data-halign="center" data-align="right" data-sortable="true"><?php echo $thisResource->rptProValue ?></th>
					</tr>
				</thead>
				<tbody>
				<!-- load table by JS -->
				</tbody>
			</table>
		</div>
	</div>
	</div> <!-- End of payTab -->
	
	</div> <!-- End of tab content -->
	
<!-- Modal: modalSalesReportDetails -->
<div class="modal fade" id="modalSalesReportDetails" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"
	data-backdrop="static" data-keyboard="false" style="overflow-y:scroll">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<b class="modal-title" id="mdsrdTitle"></b>
			<button type="button" class="close" data-dismiss="modal"><span class='fa fa-times'></span></button>
		</div>
		<div class="modal-body">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12" align="center">
				<img id="mdsrd_img_x" width="320" height="320" style="object-fit: cover" onclick="mdsrdCloseImage()"></img>
			</div>
			<div class="row">
				<div class="p-1 mt-1 col-2 col-sm-2 col-md-2 col-lg-2" align="center">
					<img id="mdsrd_img" width="60" height="80" style="object-fit: cover" onclick="mdsrdEnlargeImage()"></img>
				</div>
				<div class="input-group p-1 col-10 col-sm-10 col-md-10 col-lg-10">
					<div class="input-group p-1">
						<div class="input-group-prepend"><span class="input-group-text" style="font-size:14px; width:100px;"><?php echo $thisResource->comProductNo ?></span></div>
						<input type="text" class="form-control" name="mdsrd_code" id="mdsrd_code" style="font-size:14px; background-color:white" readonly>
					</div>
					<div class="input-group p-1">
						<div class="input-group-prepend"><span class="input-group-text" style="font-size:14px; width:100px;"><?php echo $thisResource->comName ?></span></div>
						<input type="text" class="form-control" name="mdsrd_name" id="mdsrd_name"  style="font-size:14px; background-color:white"readonly>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-12">
						<div class="input-group-prepend"><span class="input-group-text" style="font-size:14px; width:80px;"><?php echo $thisResource->comProfit ?></span></div>
						<input type="text" class="form-control" name="mdsrd_profit" id="mdsrd_profit" style="font-size:14px; background-color:white" readonly>
						<div class="ml-1 input-group-prepend"><span class="input-group-text" style="font-size:14px; width:80px;"><?php echo $thisResource->comProfitRate ?></span></div>
						<input type="text" class="form-control" name="mdsrd_rate" id="mdsrd_rate" style="font-size:14px; background-color:white" readonly>
				</div>
			</div>
			<div class="row">
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">	
					<table id="mdsrdTableSum" class="table-sm" data-toggle="table">
					<thead class="thead-light">
						<tr>
						<th data-field="idx_type" data-width="20" data-width-unit="%"></th>
						<th data-field="idx_count" data-width="25" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->comQuantity ?></th>				
						<th data-field="idx_value" data-width="25" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->comPrice ?></th>
						<th data-field="idx_total" data-width="30" data-width-unit="%" data-halign="center" data-align="right"><?php echo $thisResource->comTotal ?></th>
						</tr>
					</thead>
					<tbody>
					<!-- load table by JS -->
					</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">	
					<table id="mdsrdTable1" class="table-sm" data-toggle="table">
					<thead class="thead-light">
						<tr>
						<th data-field="idx_date" data-width="40" data-width-unit="%"><?php echo $thisResource->comPurchase?></th>				
						<th data-field="idx_count" data-width="20" data-width-unit="%" data-align="right"><?php echo $thisResource->comQuantity ?></th>
						<th data-field="idx_cost" data-width="20" data-width-unit="%" data-align="right"><?php echo $thisResource->comCost ?></th>
						<th data-field="idx_total" data-width="20" data-width-unit="%" data-align="right"><?php echo $thisResource->comTotal ?></th>
						</tr>
					</thead>
					<tbody>
					<!-- load table by JS -->
					</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">	
					<table id="mdsrdTable" class="table-sm" data-toggle="table">
					<thead class="thead-light">
						<tr>
						<th data-field="idx_kname" data-width="60" data-width-unit="%" data-sortable="true"><?php echo $thisResource->comCustomer?></th>				
						<th data-field="idx_kcount" data-width="20" data-width-unit="%" data-align="right" data-sortable="true"><?php echo $thisResource->comQuantity ?></th>
						<th data-field="idx_kprice" data-width="20" data-width-unit="%" data-align="right" data-sortable="true"><?php echo $thisResource->comValue ?></th>
						</tr>
					</thead>
					<tbody>
					<!-- load table by JS -->
					</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="modal-footer">
		</div>
		</div>
	</div>
</div> <!-- End of modalSalesReportDetails -->

<!-- Modal: modalSalesDetailsCust -->
<div class="modal fade" id="modalSalesDetailsCust" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"
	data-backdrop="static" data-keyboard="false" style="overflow-y:scroll">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<b class="modal-title" id="mdsdcTitle"></b>
			<a id="mdsdc_time"></a>
			<button type="button" class="close" data-dismiss="modal"><span class='fa fa-times'></span></button>
		</div>
		<div class="modal-body">
			<ul class="nav nav-pills" id="custTabs">
				<li class="nav-item"><a class="nav-link active" href="#mdsdcTabProducts" data-toggle="tab" style="font-size:14px"><?php echo $thisResource->rptCustProductList ?></a></li>
				<li class="nav-item"><a class="nav-link" href="#mdsdcTabOrders" data-toggle="tab" style="font-size:14px"><?php echo $thisResource->rptCustOrderList ?></a></li>
			</ul>
			<div class="row">
				<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-12">
					<div class="input-group-prepend"><span class="input-group-text" style="font-size:14px; width:80px;"><?php echo $thisResource->rptProCountTotal ?></span></div>
					<input type="text" class="form-control" name="mdsdc_count" id="mdsdc_count"  style="font-size:14px; background-color:white" readonly>
					<div class="input-group-prepend"><span class="input-group-text" style="font-size:14px; width:80px;"><?php echo $thisResource->rptProValueTotal ?></span></div>
					<input type="text" class="form-control" name="mdsdc_price" id="mdsdc_price" style="font-size:14px; background-color:white" readonly>
				</div>
			</div>
			
			<div class="tab-content">
			
			<div class="tab-pane active" id="mdsdcTabProducts">
			<div class="row">
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">	
					<table id="mdsdcTable" class="table-sm" data-toggle="table">
					<thead class="thead-light">
						<tr>
						<th data-field="idx_cimg" data-width="20" data-width-unit="%"></th>				
						<th data-field="idx_cdata" data-width="40" data-width-unit="%" data-sortable="true"><?php echo $thisResource->comProduct ?></th>
						<th data-field="idx_ccount" data-width="20" data-width-unit="%" data-align="right" data-sortable="true"><?php echo $thisResource->comQuantity ?></th>
						<th data-field="idx_cprice" data-width="20" data-width-unit="%" data-align="right" data-sortable="true"><?php echo $thisResource->comValue ?></th>
						</tr>
					</thead>
					<tbody>
					<!-- load table by JS -->
					</tbody>
					</table>
				</div>
			</div>
			</div>
			
			<div class="tab-pane" id="mdsdcTabOrders">
			<div class="row">
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">	
					<table id="mdsdcTableOrders" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true" 
						data-detail-view="true" data-detail-formatter="orderFormatter">
					<thead class="thead-light">
						<tr>
						<th data-field="id" data-width="0" data-width-unit="%" data-visible="false"></th>
						<th data-field="idx_time" data-width="40" data-width-unit="%"><?php echo $thisResource->comTime ?></th>				
						<th data-field="idx_count" data-width="30" data-width-unit="%" data-align="right"><?php echo $thisResource->comQuantity ?></th>
						<th data-field="idx_price" data-width="30" data-width-unit="%" data-align="right"><?php echo $thisResource->comValue ?></th>
						</tr>
					</thead>
					<tbody>
					<!-- load table by JS -->
					</tbody>
					</table>
				</div>
			</div>
			</div>
			
			</div>
			
		</div>
		</div>
	</div>
</div> <!-- End of modalSalesDetailsCust -->

<!-- Modal: modalSalesSup -->
<div class="modal fade" id="modalSalesSup" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"
	data-backdrop="static" data-keyboard="false" style="overflow-y:scroll">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<b class="modal-title" id="mdssTitle"></b>
			<a id="mdss_time"></a>
			<button type="button" class="close" data-dismiss="modal"><span class='fa fa-times'></span></button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="input-group p-1 col-12 col-sm-12 col-md-12 col-lg-12">
					<div class="input-group-prepend"><span class="input-group-text" style="font-size:14px; width:100px;">进货件数</span></div>
					<input type="text" class="form-control" name="mdss_count" id="mdss_count"  style="font-size:14px; background-color:white" readonly>
					<div class="input-group-prepend"><span class="input-group-text" style="font-size:14px; width:100px;">总金额</span></div>
					<input type="text" class="form-control" name="mdss_cost" id="mdss_cost" style="font-size:14px; background-color:white" readonly>
				</div>
			</div>
			<div class="row">
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">	
					<table id="mdssTablePurs" class="table-sm" data-toggle="table" data-single-select="true" data-click-to-select="true"
						data-detail-view="true" data-detail-formatter="purFormatter">
					<thead class="thead-light">
						<tr>
						<th data-field="id" data-width="0" data-width-unit="%" data-visible="false"></th>
						<th data-field="idx_time" data-width="40" data-width-unit="%">时间</th>				
						<th data-field="idx_count" data-width="30" data-width-unit="%" data-align="right">件数</th>
						<th data-field="idx_cost" data-width="30" data-width-unit="%" data-align="right">金额</th>
						</tr>
					</thead>
					<tbody>
					<!-- load table by JS -->
					</tbody>
					</table>
				</div>
			</div>						
		</div>
		</div>
	</div>
</div> <!-- End of modalSalesSup -->

<!-- Modal: search product -->
<div class="modal fade" id="modalSearchInv" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"
	data-backdrop="static" data-keyboard="false" style="overflow-y:scroll">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<b class="modal-title" id="mdsiTitle"><?php echo $thisResource->comProductSearch ?></b>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">
					<div class="input-group p-1">
						<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comProductNo ?></span></div>
						<input type="text" class="form-control" name="mdsi_code" id="mdsi_code">
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
		</div>
		</div>
	</div>
</div> <!-- End of Modal: New item search -->

</div> <!-- End of container -->

</body>

<script src="js/ajax.js"></script>
<script src="js/autocomplete.js?202108130959"></script>
<script src="js/modalSelTime.js?v1"></script>
<script src="js/modalCustSearch.js?202109090946"></script>

<script>
var myRes = <?php echo json_encode($thisResource) ?>;
// General
var tabId = "main";
// Main
var invs = new Array(), invsCount = 0;
var countTotal = 0, priceTotal = 0, profitAvg = 0;
var $table = $("#tableMain");
var mainSearched = false;
var timeMain = "timeThisMonth";
var sortCol = "price_sum", sortOp = 1;
var $modalSalesReportDetails = $('#modalSalesReportDetails');
var $mdsrdTable = $("#mdsrdTable"), $mdsrdTableSum = $("#mdsrdTableSum"), $mdsrdTable1 = $("#mdsrdTable1");
// Cust
var custs = new Array(), custsCount = 0;
var custCountTotal = 0, custPriceTotal = 0;
var $tableCust = $("#tableCust");
var custSearched = false;
var timeCust = "timeThisMonth";
var sortColCust = "price_sum", sortOpCust = 1;
var $modalSalesDetailsCust = $('#modalSalesDetailsCust');
var $mdsdcTable = $("#mdsdcTable"), $mdsdcTableOrders = $("#mdsdcTableOrders");
// Sup
var sups = new Array(), supsCount = 0;
var supsOut = new Array(), supsCountOut = 0;
var supInCountTotal = 0, supCostTotal = 0, supOutCountTotal = 0, supPriceTotal = 0;
var $tableSup = $("#tableSup");
var supSearched = false;
var timeSup = "timeThisMonth";
var sortColSup = "s_name", sortOpSup = 0;
var $modalSalesSup = $('#modalSalesSup');
var $mdssTablePurs = $("#mdssTablePurs");
// Type
var types = new Array(), typesCount = 0;
var typeCountTotal = 0, typePriceTotal = 0;
var $tableType = $("#tableType");
var typeSearched = false;
var timeType = "timeThisMonth";
var typeSales = new Array();
// Pay
var pays = new Object();
var payPriceTotal = 0;
var $tablePay = $("#tablePay");
var paySearched = false;
var timePay = "timeThisMonth";
// autocpmplete
var a_icode = JSON.parse(localStorage.getItem("a_icode"));
var a_image = JSON.parse(localStorage.getItem("a_image"));
// Sys Options
var sysOptions = new Object();
sysOptions = JSON.parse(localStorage.getItem("sysOptions"));
/* Tabs init */
$('.nav-tabs').on('shown.bs.tab', 'a', function (e) {
    if (e.relatedTarget) {
        $(e.relatedTarget).removeClass('active');
    }
})
/* Load document */
$(document).ready(function(){	
	if (sysOptions != null && sysOptions['sysSearchLike'])
		autocomplete_like(document.getElementById("mdsi_code"), a_icode, a_image);
	else
		autocomplete(document.getElementById("mdsi_code"), a_icode, a_image);
	document.getElementById("myTitle").innerHTML = myRes['rptReport'];
	$('#containerTabs').hide();	
	showMainTab();
 });
var tabShow = false;
function showTabs(){
	if (tabShow) {
		tabShow = false;
		$('#containerTabs').hide();	
	} else {
		tabShow = true;
		$('#containerTabs').show();	
	}
		
}
/* Prevent 'enter' key for submission, only enabled for barcode input */
$('form input').keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
		return false;
    }
});
// Load customers
var a_custs = <?php echo json_encode($myCustomers) ?>;
function getCustNameById(kid) {
	for (var i=0; i<a_custs.length; i++) {
		if (a_custs[i]['k_id'] == kid)
			return a_custs[i]['k_name'];
	}	
	return "未知客户";
}
var a_sups = <?php echo json_encode($mySuppliers) ?>;
// Load suppliers
function getSupNameById(sid) {
	for (var i=0; i<a_sups.length; i++) {
		if (a_sups[i]['s_id'] == sid)
			return a_sups[i]['s_name'];
	}	
	return "未知厂家";
}
// Load types
var a_types = <?php echo json_encode($myTypes) ?>;
function getTypeNameById(tid) {
	for (var i=0; i<a_types.length; i++) {
		if (a_types[i]['t_id'] == tid)
			return a_types[i]['t_name'];
	}
	return "未分类";
}

/*************************************************** 
	MAIN TAB 
****************************************************/
$table.bootstrapTable({   
	formatNoMatches: function () {
         return "";
    }
});
$mdsrdTableSum.bootstrapTable({   
	formatNoMatches: function () {
         return "";
    }
});
$mdsrdTable.bootstrapTable({   
	formatNoMatches: function () {
         return "";
    }
});
$mdsrdTable1.bootstrapTable({   
	formatNoMatches: function () {
         return "";
    }
});
function searchReportMain(){
	timeMain = mdstGetChecked();
	var timeStr = mdstGetStr();	
	document.getElementById("selTime").innerText = timeStr;	
	var timeResult = mdstGetValue();
	
	var link = "getSalesReport.php?"+timeResult;	
	getRequest(link, afterSearchMain, afterSearchMainNo);
}
function afterSearchMain(result){
	mainSearched = true;
	invs = result;
	invsCount = invs.length;
	loadTable();
}
function afterSearchMainNo(result) {
	$table.bootstrapTable('removeAll');
	invs = null;
	invsCount = 0;
	countTotal = 0;
	priceTotal = 0;
	profitTotal = 0;
	displaySum();
}
function loadTable(){
	countTotal = 0;
	priceTotal = 0;
	profitTotal = 0;
	if (invsCount <= 0) {
		displaySum();
		return;
	}	
	$table.bootstrapTable('removeAll');
	invs.sort(sortTable(sortCol, sortOp));
	var profitTotal = 0;
	var rows = [];
	var dataStr, imgSrc, imgStr, countStr, saleStr, profit, profitRate;
	for(var i=0; i<invsCount; i++){
		if (invs[i]['i_name'] != null)
			dataStr = "<a style='font-weight:bold;'>"+invs[i]['i_code']+"</a><br>"+"<a >"+invs[i]['i_name']+"</a>";
		else
			dataStr = "<a style='font-weight:bold;'>"+invs[i]['i_code']+"</a>";
		imgSrc = invs[i]['path']+"/"+invs[i]['i_id']+"_"+invs[i]['m_no']+"_s.jpg";
		imgStr = "<img width='60' height='80' style='object-fit: cover' src='"+imgSrc+"' >";
		if (invs[i]['unit'] == "1") {
			countStr = invs[i]['count'];
			saleStr = invs[i]['count_sum'];
			invs[i]['real_count'] = invs[i]['count'];
			invs[i]['real_count_sum'] = invs[i]['count_sum'];
		} else {
			countStr = invs[i]['count']+"<br>(x"+invs[i]['unit']+")";
			saleStr = invs[i]['count_sum']+"<br>(x"+invs[i]['unit']+")";
			invs[i]['real_count'] = (parseInt(invs[i]['count'])*parseInt(invs[i]['unit'])).toString();
			invs[i]['real_count_sum'] = (parseInt(invs[i]['count_sum'])*parseInt(invs[i]['unit'])).toString();
		}
		profit = parseFloat(invs[i]['price_sum'])-parseFloat(invs[i]['cost'])*parseInt(invs[i]['real_count_sum']);
		profitRate = 100*profit/parseFloat(invs[i]['price_sum']);
		invs[i]['profit'] = profit.toFixed(2);
		invs[i]['profit_rate'] = profitRate.toFixed(2);
		rows.push({
			id: invs[i]['i_id'],
			idx_image: imgStr,
			idx_data: dataStr,
			idx_units: countStr,
			idx_count: saleStr,
			idx_price: parseFloat(invs[i]['price_sum']).toFixed(2),
			idx_prorate: parseFloat(invs[i]['profit_rate']).toFixed(0)+"%"
		})
		countTotal += parseInt(invs[i]['real_count_sum']);
		priceTotal += parseFloat(invs[i]['price_sum']);
		profitTotal += profit;
	}
	$table.bootstrapTable('append', rows);	
	profitAvg = 100*profitTotal/priceTotal;
	displaySum();
}
function displaySum(){
	$tableSum = $('#tableSum');
	$tableSum.bootstrapTable('removeAll');
	var rows = [];
	rows.push({
		idx_items: invsCount,
		idx_count: countTotal,
		idx_price: priceTotal.toFixed(2),
		idx_prorate: profitAvg.toFixed(2)+"%"
	});
	$tableSum.bootstrapTable('append', rows);	
}
// Sort main table
function doneSort(e){
	var x = $(e).text();
	document.getElementById("sortOption").innerText = x;
	switch(x) {
		case myRes['comSortSaleCountDesc']: sortCol = 'real_count_sum'; sortOp = 1; break;
		case myRes['comSortSaleValueDesc']: sortCol = 'price_sum'; sortOp = 1; break;
		case myRes['comSortProfitDesc']: sortCol = 'profit_rate'; sortOp = 1; break;
		case myRes['comSortInvDesc']: sortCol = 'real_count'; sortOp = 1; break;
		case myRes['comSortInvAsc']: sortCol = 'real_count'; sortOp = 0; break;
		case myRes['comSortPurchaseDate']: sortCol = 'time_updated'; sortOp = 1; break;
		case myRes['comSortCodeAZ']: sortCol = 'i_code'; sortOp = 0; break;
		case myRes['comSortCodeZA']: sortCol = 'i_code'; sortOp = 1; break;
		default: sortCol = "count_sum"; sortOp = 1;
	}
	loadTable();
}
// Click a row to view product
$table.on('click-row.bs.table', function (e, row, $element) {
	showReportDetails(row.id);
})
function getIndexById(id) {
	for (var i=0; i<invsCount; i++) {
		if (invs[i]['i_id'] == id)
			return i;
	}
	return -1;
}
function getIdByCode(code) { 
	for (var i=0; i<invsCount; i++) {
		if (invs[i]['i_code'] == code)
			return invs[i]['i_id'];
	}
	return -1;
}
function showReportDetails(id) {
	var idx = getIndexById(id); 
	if (idx < 0)
		return;
	var inv = invs[idx];
	
	var timeStr = document.getElementById("selTime").innerText;
	document.getElementById("mdsrdTitle").innerHTML = myRes['comTime']+":&nbsp;"+timeStr;	
	var imgSrc = inv['path']+"/"+inv['i_id']+"_"+inv['m_no']+".jpg";
	document.getElementById("mdsrd_img").src = imgSrc;
	document.getElementById("mdsrd_img_x").src = imgSrc;
	document.getElementById("mdsrd_img_x").style.display = "none";
	document.getElementById("mdsrd_code").value = inv['i_code'];
	document.getElementById("mdsrd_name").value = inv['i_name'];
	
	var mdsrd_count, mdsrd_s_count;
	if (inv['unit'] == "1") {
		mdsrd_count = inv['count'];
		mdsrd_s_count = inv['count_sum'];
	} else {
		mdsrd_count = inv['count']+" (x"+inv['unit']+")";
		mdsrd_s_count = inv['count_sum']+" (x"+inv['unit']+")";
	}
	$mdsrdTableSum.bootstrapTable('removeAll');	
	var rows = [];
	rows.push({
		idx_type: "库存",
		idx_count: mdsrd_count,
		idx_value: inv['cost'],
		idx_total: (parseFloat(inv['cost'])*parseInt(inv['count'])*parseInt(inv['unit'])).toFixed(2)
	});
	rows.push({
		idx_type: "售出",
		idx_count: mdsrd_s_count,
		idx_value: inv['price'],
		idx_total: parseFloat(inv['price_sum']).toFixed(2)
	});
	$mdsrdTableSum.bootstrapTable('append', rows);	

	document.getElementById("mdsrd_profit").value = (parseFloat(inv['price_sum'])-parseFloat(inv['cost'])*parseInt(inv['count_sum'])*parseInt(inv['unit'])).toFixed(2);
	document.getElementById("mdsrd_rate").value = inv['profit_rate']+"%";
	
	var timeResult = mdstGetValue();
	getRequest("getSalesReportById.php?id="+id+"&"+timeResult, reportByIdYes, reportByIdNo);
	getRequest("getSalesReportPurById.php?id="+id+"&"+timeResult, reportPurByIdYes, reportPurByIdNo);
	
	$modalSalesReportDetails.modal();
}
function reportByIdYes(result) {
	$mdsrdTable.bootstrapTable('removeAll');
	
	var rows = [];
	for(var i=0; i<result.length; i++){
		rows.push({
			idx_kname: getCustNameById(result[i]['k_id']),
			idx_kcount: result[i]['k_count_sum'],
			idx_kprice: parseFloat(result[i]['k_price_sum']).toFixed(2)
		});
	}
	$mdsrdTable.bootstrapTable('append', rows);	
}
function reportByIdNo(result) {
	$mdsrdTable.bootstrapTable('removeAll');
}
function reportPurByIdYes(result) {	
	var purReport = result;		
	var rows = [];
	var total = 0, sum = 0, count_sum = 0, cost_ave = 0.00;
	
	for(var i=0; i<result.length; i++){
		total = parseInt(result[i]['count'])*parseInt(result[i]['unit'])*parseFloat(result[i]['cost']);
		sum += total;
		count_sum += parseInt(result[i]['count'])*parseInt(result[i]['unit']);
		rows.push({
			idx_date: result[i]['p_date'].substr(0, 10),
			idx_count: result[i]['count'],
			idx_cost: result[i]['cost'],
			idx_total: total.toFixed(2)
		});
	}
	cost_ave = sum/count_sum;
	$mdsrdTable1.bootstrapTable('removeAll');
	$mdsrdTable1.bootstrapTable('append', rows);	
	
	var rows1 = [];
	rows1.push({
		idx_type: "进货",
		idx_count: count_sum,
		idx_value: cost_ave.toFixed(2),
		idx_total: sum.toFixed(2)
	});
	$mdsrdTableSum.bootstrapTable('append', rows1);	
}
function reportPurByIdNo(result) {
	var rows = [];
	rows.push({
		idx_type: "进货",
		idx_count: "-",
		idx_value: "-",
		idx_total: "-"
	});
	$mdsrdTableSum.bootstrapTable('append', rows);
	$mdsrdTable1.bootstrapTable('removeAll');
}
function mdsrdEnlargeImage() {
	document.getElementById("mdsrd_img_x").style.display = "block";
}
function mdsrdCloseImage() {
	document.getElementById("mdsrd_img_x").style.display = "none";
}
// Search
$modalSearchInv = $('#modalSearchInv');
function searchInv() {
	document.getElementById("mdsi_code").value = "";
	$modalSearchInv.modal();
}
$modalSearchInv.on('shown.bs.modal', function () {
	 $('#mdsi_code').trigger('focus');
})
function doneAutocomp() {
	if ($modalCustSearch.is(':visible'))
		doneAutocompCust();
	else
		doneAutocompInv();
}
function doneAutocompInv() {
	var code = document.getElementById("mdsi_code").value;
	if (code == "") {
		$('#mdsi_code').trigger('focus');
		return;
	}
	var id = getIdByCode(code);
	if (id == -1) {
		alert("没有找到该商品的销售记录. 请重新选择时间段或查找其他商品号");
		document.getElementById("mdsi_code").value = "";
		$('#mdsi_code').trigger('focus');
		return;
	}
	$modalSearchInv.modal("toggle");
	showReportDetails(id);	
}
/*************************************************** 
	CUST TAB 
****************************************************/
$tableCust.bootstrapTable({   
	formatNoMatches: function () {
         return "";
    }
});
$mdsdcTable.bootstrapTable({   
	formatNoMatches: function () {
         return "";
    }
});
$mdsdcTableOrders.bootstrapTable({   
	formatNoMatches: function () {
         return "";
    }
});
function searchReportCust(){
	timeCust = mdstGetChecked();
	var timeStr = mdstGetStr();	
	document.getElementById("selTimeCust").innerText = timeStr;	
	var timeResult = mdstGetValue();
	
	link = "getSalesReportByCust.php?"+timeResult;	
	getRequest(link, afterSearchCust, afterSearchCustNo);
}
function afterSearchCust(result){
	custSearched = true;
	custs = result;
	custsCount = custs.length;
	loadTableCust();
}
function afterSearchCustNo(result) {
	$tableCust.bootstrapTable('removeAll');
	custs = null;
	custsCount = 0;
	custCountTotal = 0;
	custPriceTotal = 0;
	displayCustSum();
}
function loadTableCust(){
	custCountTotal = 0;
	custPriceTotal = 0;
	if (custsCount <= 0) {
		displayCustSum();
		return;
	}	
	$tableCust.bootstrapTable('removeAll');
	custs.sort(sortTable(sortColCust, sortOpCust));
	var rows = [];
	for(var i=0; i<custsCount; i++){
		custs[i]['k_name'] = getCustNameById(custs[i]['k_id']); 
		rows.push({
			id: custs[i]['k_id'],
			idx_cust: custs[i]['k_name'],
			idx_count: custs[i]['count_sum'],
			idx_price: parseFloat(custs[i]['price_sum']).toFixed(2)
		});
		custCountTotal += parseInt(custs[i]['count_sum']);
		custPriceTotal += parseFloat(custs[i]['price_sum']);
	}
	$tableCust.bootstrapTable('append', rows);
	displayCustSum();	
}
function displayCustSum(){
	$tableCustSum = $('#tableCustSum');
	$tableCustSum.bootstrapTable('removeAll');
	var rows = [];
	rows.push({
		idx_custs: custsCount,
		idx_count: custCountTotal.toString(),
		idx_price: custPriceTotal.toFixed(2)
	});
	$tableCustSum.bootstrapTable('append', rows);	
}
// Sort cust table
function doneSortCust(e){
	var x = $(e).text();
	document.getElementById("sortOptionCust").innerText = x;
	switch(x) {
		case myRes['comSortSaleCountDesc']: sortColCust = 'count_sum'; sortOpCust = 1; break;
		case myRes['comSortSaleValueDesc']: sortColCust = 'price_sum'; sortOpCust = 1; break;
		case myRes['comSortCodeAZ']: sortColCust = 'k_name'; sortOpCust = 0; break;
		case myRes['comSortCodeZA']: sortColCust = 'k_name'; sortOpCust = 1; break;
		default: sortColCust = "count_sum"; sortOpCust = 1;
	}
	loadTableCust();
}
// Click a row to view sales details by cust
$tableCust.on('click-row.bs.table', function (e, row, $element) {
	showCustDetails(row.id);
})
function getCustIndexById(id) {
	for (var i=0; i<custsCount; i++) {
		if (custs[i]['k_id'] === id)
			return i;
	}
	return -1;
}
// Search customer
function searchCust() {
	mksInit(2);
	$modalCustSearch.modal();
}
// modalCustSearch
function mksDoneNext(customer) {
	id = customer['k_id'];
	var idx = getCustIndexById(id); 
	if (idx < 0) {
		alert(myRes['msgNoCustOrder']);
		return;
	}
	showCustDetails(id);
}
// Show customer details
function showCustDetails(id) {
	var idx = getCustIndexById(id); 
	if (idx < 0)
		return;
	var cust = custs[idx];
	
	var custName = getCustNameById(id);
	if (custName.length > 30)
		custName = custName.substr(0,30)+"..";
	var timeStr = document.getElementById("selTimeCust").innerText;
	document.getElementById("mdsdcTitle").innerHTML = custName;	
	document.getElementById("mdsdc_time").innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;"+myRes['comTime']+":&nbsp;"+timeStr;	
	document.getElementById("mdsdc_count").value = cust['count_sum'];
	document.getElementById("mdsdc_price").value = parseFloat(cust['price_sum']).toFixed(2);

	var timeResult = mdstGetValue();
	getRequest("getSalesDetailsByCust.php?id="+id+"&"+timeResult, reportByCustYes, reportByCustNo);
	getRequest("getOrderItemsByCus.php?k_id="+id+"&"+timeResult, reportByCustOrderYes, reportByCustOrderNo);
	
	$('#custTabs li:first-child a').tab('show');
	$modalSalesDetailsCust.modal();
}
function reportByCustYes(result) {
	$mdsdcTable.bootstrapTable('removeAll');
	
	var rows = [];
	var dataStr, imgSrc, imgStr, countStr;
	for(var i=0; i<result.length; i++){
		if (result[i]['i_name'] != null)
			dataStr = "<a style='font-weight:bold;'>"+result[i]['i_code']+"</a><br>"+"<a >"+result[i]['i_name']+"</a>";
		else
			dataStr = "<a style='font-weight:bold;'>"+result[i]['i_code']+"</a>";
		imgSrc = result[i]['path']+"/"+result[i]['i_id']+"_"+result[i]['m_no']+"_s.jpg";
		imgStr = "<img width='60' height='60' style='border:1px dotted; object-fit: cover' src='"+imgSrc+"' >";
		rows.push({
			idx_cimg: imgStr,
			idx_cdata: dataStr,
			idx_ccount: result[i]['count_sum'],
			idx_cprice: parseFloat(result[i]['price_sum']).toFixed(2)
		});
	}
	$mdsdcTable.bootstrapTable('append', rows);	
}
function reportByCustNo(result) {
	$mdsdcTable.bootstrapTable('removeAll');
}
var custOrders, custOrderCount, custOrderItems;
function reportByCustOrderYes(result) {
	custOrderItems = result;
	custOrderCount = 0;
	custOrders = new Array();
	for(var i=0; i<custOrderItems.length; i++){
		var orderExist = false;
		for (var j=0; j<custOrderCount; j++) {
			if  (custOrders[j]['o_id'] == custOrderItems[i]['o_id']) {
				orderExist = true;
				break;
			}
		}
		if (orderExist)
			continue;
		var order = new Object();
		order['o_id'] = custOrderItems[i]['o_id']; 
		order['date'] = custOrderItems[i]['date'];
		order['count_sum'] = custOrderItems[i]['count_sum'];
		order['price_sum'] = custOrderItems[i]['price_sum'];
		custOrders[custOrderCount] = order;
		custOrderCount++;
	}

	$mdsdcTableOrders.bootstrapTable('removeAll');
	var rows = [];
	for(var i=0; i<custOrderCount; i++){
		rows.push({
			id: custOrders[i]['o_id'],
			idx_time: custOrders[i]['date'].substring(0,16),
			idx_count: custOrders[i]['count_sum'],
			idx_price: custOrders[i]['price_sum']
		});
	}
	$mdsdcTableOrders.bootstrapTable('append', rows);	
}
function reportByCustOrderNo(result) {
	$mdsdcTableOrders.bootstrapTable('removeAll');
}
// View order
function orderFormatter(index, row) {
    var html = '<div class="p-1"> <table class="table" data-toggle="table">';
	html += '<thead><tr>';
	html += '<th data-field="idx_image"></th>';
	html += '<th data-field="idx_item">'+myRes['comProduct']+'</th>';
	html += '<th data-field="idx_count">'+myRes['comQuantity']+'</th>';
	html += '<th data-field="idx_price">'+myRes['comValue']+'</th>';
	html += '</tr></thead>';
	html += '<tbody>';
	var imgSrc, imgStr, countStr, subtotal;
	for (var i=0; i<custOrderItems.length; i++){
		if (custOrderItems[i]['o_id'] == custOrders[index]['o_id']) {
			imgSrc = custOrderItems[i]['path']+"/"+custOrderItems[i]['i_id']+"_"+custOrderItems[i]['m_no']+"_s.jpg";
			imgStr = "<img width='60' height='60' style='border:1px dotted; object-fit: cover' src='"+imgSrc+"' >";
			if (custOrderItems[i]['unit'] == 1) {
				countStr = custOrderItems[i]['count'];
				subtotal = parseFloat((custOrderItems[i]['price']*(100-custOrderItems[i]['discount']))/100)*parseInt(custOrderItems[i]['count']);
			} else {
				countStr = custOrderItems[i]['count']+" (x"+custOrderItems[i]['unit']+")";
				subtotal = parseFloat((custOrderItems[i]['price']*(100-custOrderItems[i]['discount']))/100)*parseInt(custOrderItems[i]['unit']);
			}			
			html += '<tr><td>'+imgStr+'</td><td>'+custOrderItems[i]['i_code']+'</td><td>'+countStr+'</td><td>'+subtotal.toFixed(2)+'</td></tr>';
		}
	}
	html += '</tbody>';
	html += '</table></div>'; 
	return html;
}
/*************************************************** 
	SUP TAB 
****************************************************/
$tableSup.bootstrapTable({   
	formatNoMatches: function () {
         return "没有符合条件的数据";
    }
});
$mdssTablePurs.bootstrapTable({   
	formatNoMatches: function () {
         return "没有符合条件的数据";
    }
});
function searchReportSup(){
	timeSup = mdstGetChecked();
	var timeStr = mdstGetStr();	
	document.getElementById("selTimeSup").innerText = timeStr;	
	var timeResult = mdstGetValue();
	
	$tableSup.bootstrapTable('removeAll');	
	supInCountTotal = 0;
	supCostTotal = 0;
	supOutCountTotal = 0;
	supPriceTotal = 0;
	sortColSup = "s_name";
	sortOpSup = 0;
	a_sups.sort(sortTable(sortColSup, sortOpSup));
	var rows = [];
	for (var i=0; i<a_sups.length; i++) {
		a_sups[i]['in_count'] = "0";
		a_sups[i]['cost_sum'] = "0.00";
		a_sups[i]['out_count'] = "0";
		a_sups[i]['price_sum'] = "0.00";
		rows.push({
			id: a_sups[i]['s_id'],
			idx_sup: a_sups[i]['s_name'],
			idx_incount: a_sups[i]['in_count'],
			idx_cost: a_sups[i]['cost_sum'],
			idx_outcount: a_sups[i]['out_count'],
			idx_price: a_sups[i]['price_sum']
		});
	}
	$tableSup.bootstrapTable('append', rows);
	document.getElementById("sortOptionSup").innerText = myRes['comSort'];
	
	link = "getSalesReportBySup.php?"+timeResult;	
	getRequest(link, afterSearchSup, afterSearchSupNo);
	
	link = "getSalesReportBySupOrders.php?"+timeResult;	
	getRequest(link, afterSearchSupOrders, afterSearchSupOrdersNo);
}
function afterSearchSup(result){
	supSearched = true;
	sups = result;
	supsCount = sups.length;
	loadTableSup();
}
function afterSearchSupNo(result) {
	sups = null;
	supsCount = 0;
	supInCountTotal = 0;
	supCostTotal = 0;
	displaySupSum();
}
function afterSearchSupOrders(result){
	supSearched = true;
	supsOut = result;
	supsCountOut = supsOut.length;
	loadTableSupOrders();
}
function afterSearchSupOrdersNo(result) {
	supsOut = null;
	supsCountOut = 0;
	supOutCountTotal = 0;
	supPriceTotal = 0;
	displaySupSum();
}
function loadTableSup(){	
	for (var i=0; i<a_sups.length; i++) {
		for ( var j=0; j<supsCount; j++) {
			if (sups[j]['s_id'] == a_sups[i]['s_id']) {
				a_sups[i]['in_count'] = sups[j]['count_sum'];
				a_sups[i]['cost_sum'] = sups[j]['cost_sum'];
				break;
			}
		}
		$tableSup.bootstrapTable('updateCellByUniqueId', {
			id: a_sups[i]['s_id'],
			field: 'idx_incount',
			value: a_sups[i]['in_count']
		})	
		$tableSup.bootstrapTable('updateCellByUniqueId', {
			id: a_sups[i]['s_id'],
			field: 'idx_cost',
			value: a_sups[i]['cost_sum']
		})	
		supInCountTotal += parseInt(a_sups[i]['in_count']);
		supCostTotal += parseFloat(a_sups[i]['cost_sum']);
	}
	
	displaySupSum();	
}
function loadTableSupOrders(){	
	for (var i=0; i<a_sups.length; i++) {
		for ( var j=0; j<supsCountOut; j++) {
			if (supsOut[j]['s_id'] == a_sups[i]['s_id']) {
				a_sups[i]['out_count'] = supsOut[j]['count_sum'];
				a_sups[i]['price_sum'] = supsOut[j]['price_sum'];
				break;
			}
		}
		$tableSup.bootstrapTable('updateCellByUniqueId', {
			id: a_sups[i]['s_id'],
			field: 'idx_outcount',
			value: a_sups[i]['out_count']
		})	
		$tableSup.bootstrapTable('updateCellByUniqueId', {
			id: a_sups[i]['s_id'],
			field: 'idx_price',
			value: parseFloat(a_sups[i]['price_sum']).toFixed(2)
		})	
		supOutCountTotal += parseInt(a_sups[i]['out_count']);
		supPriceTotal += parseFloat(a_sups[i]['price_sum']);
	}
	
	displaySupSum();	
}
function displaySupSum(){
	$tableSupSum = $('#tableSupSum');
	$tableSupSum.bootstrapTable('removeAll');
	var rows = [];
	rows.push({
		idx_incount: supInCountTotal.toString(),
		idx_cost: supCostTotal.toFixed(2),
		idx_outcount: supOutCountTotal.toString(),
		idx_price: supPriceTotal.toFixed(2)
	});
	$tableSupSum.bootstrapTable('append', rows);	
}
function reloadTableSup() {
	$tableSup.bootstrapTable('removeAll');
	a_sups.sort(sortTable(sortColSup, sortOpSup));
	var rows = [];
	for (var i=0; i<a_sups.length; i++) {
		rows.push({
			id: a_sups[i]['s_id'],
			idx_sup: a_sups[i]['s_name'],
			idx_incount: a_sups[i]['in_count'],
			idx_cost: parseFloat(a_sups[i]['cost_sum']).toFixed(2),
			idx_outcount: a_sups[i]['out_count'],
			idx_price: parseFloat(a_sups[i]['price_sum']).toFixed(2)
		});
	}
	$tableSup.bootstrapTable('append', rows);
}
// Sort sup table
function doneSortSup(e){ 
	var x = $(e).text();
	document.getElementById("sortOptionSup").innerText = x;
	switch(x) {
		case myRes['comSortInCountDesc']: sortColSup = 'in_count'; sortOpSup = 1; break;
		case myRes['comSortInValueDesc']: sortColSup = 'cost_sum'; sortOpSup = 1; break;
		case myRes['comSortSaleCountDesc']: sortColSup = 'out_count'; sortOpSup = 1; break;
		case myRes['comSortSaleValueDesc']: sortColSup = 'price_sum'; sortOpSup = 1; break;
		case myRes['comSortCodeAZ']: sortColSup = 's_name'; sortOpSup = 0; break;
		case myRes['comSortCodeZA']: sortColSup = 's_name'; sortOpSup = 1; break;
		default: sortColSup = "count_sum"; sortOpSup = 1;
	}
	reloadTableSup();
}
// Click a row to view sales details by sup
$tableSup.on('click-row.bs.table', function (e, row, $element) { 
	showSupDetails(row.id);
})
function getSupIndexById(id) {
	for (var i=0; i<a_sups.length; i++) {
		if (a_sups[i]['s_id'] === id)
			return i;
	}
	return -1;
}
function showSupDetails(id) {
	var idx = getSupIndexById(id); 
	if (idx < 0)
		return;
	var sup = a_sups[idx];

	var timeStr = document.getElementById("selTimeSup").innerText;
	document.getElementById("mdssTitle").innerHTML = "厂家:&nbsp;"+getSupNameById(id);	
	document.getElementById("mdss_time").innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;时间:&nbsp;"+timeStr;	
	document.getElementById("mdss_count").value = sup['in_count'];
	document.getElementById("mdss_cost").value = sup['cost_sum'];

	var timeResult = mdstGetValue();
	getRequest("getPurItemsBySup.php?s_id="+id+"&"+timeResult, reportBySupPursYes, reportBySupPursNo);
}
var supPurs, supPurCount, supPurItems;
function reportBySupPursYes(result) {
	supPurItems = result;
	supPurCount = 0;
	supPurs = new Array();
	for(var i=0; i<supPurItems.length; i++){
		var purExist = false;
		for (var j=0; j<supPurCount; j++) {
			if  (supPurs[j]['p_id'] == supPurItems[i]['p_id']) {
				purExist = true;
				break;
			}
		}
		if (purExist)
			continue;
		var pur = new Object();
		pur['p_id'] = supPurItems[i]['p_id']; 
		pur['p_date'] = supPurItems[i]['p_date'].substr(0,10);
		pur['count_sum'] = supPurItems[i]['count_sum'];
		pur['cost_sum'] = supPurItems[i]['cost_sum'];
		supPurs[supPurCount] = pur;
		supPurCount++;
	}

	$mdssTablePurs.bootstrapTable('removeAll');
	var rows = [];
	for(var i=0; i<supPurCount; i++){
		rows.push({
			id: supPurs[i]['p_id'],
			idx_time: supPurs[i]['p_date'].substring(0,16),
			idx_count: supPurs[i]['count_sum'],
			idx_cost: supPurs[i]['cost_sum']
		});
	}
	$mdssTablePurs.bootstrapTable('append', rows);	
	
	$modalSalesSup.modal();
}
function reportBySupPursNo(result) {
	$mdssTablePurs.bootstrapTable('removeAll');
}
// View purchase
function purFormatter(index, row) {
    var html = '<div class="p-1"> <table class="table" data-toggle="table">';
	html += '<thead><tr>';
	html += '<th data-field="idx_image">照片</th>';
	html += '<th data-field="idx_item">商品</th>';
	html += '<th data-field="idx_count">件数</th>';
	html += '<th data-field="idx_cost">金额</th>';
	html += '</tr></thead>';
	html += '<tbody>';
	var imgSrc, imgStr, countStr, subtotal;
	for (var i=0; i<supPurItems.length; i++){
		if (supPurItems[i]['p_id'] == supPurs[index]['p_id']) {
			imgSrc = supPurItems[i]['path']+"/"+supPurItems[i]['i_id']+"_"+supPurItems[i]['m_no']+"_s.jpg";
			imgStr = "<img width='60' height='60' style='border:1px dotted; object-fit: cover' src='"+imgSrc+"' >";
			if (supPurItems[i]['unit'] == "1") {
				countStr = supPurItems[i]['count'];
				subtotal = parseFloat(supPurItems[i]['cost'])*parseInt(supPurItems[i]['count']);
			} else {
				countStr = supPurItems[i]['count']+" (x"+supPurItems[i]['unit']+")";
				subtotal = parseFloat(supPurItems[i]['cost'])*parseInt(supPurItems[i]['count'])*parseInt(supPurItems[i]['unit']);
			}			
			html += '<tr><td>'+imgStr+'</td><td>'+supPurItems[i]['i_code']+'</td><td>'+countStr+'</td><td>'+subtotal.toFixed(2)+'</td></tr>';
		}
	}
	html += '</tbody>';
	html += '</table></div>'; 
	return html;
}
/*************************************************** 
	TYPE TAB 
****************************************************/
var country = "";
$tableType.bootstrapTable({   
	formatNoMatches: function () {
         return "没有符合条件的数据";
    }
});
function changeCountry(cty){
    country = cty;
	if(cty == "") $("#country").val("所有国家");
    else $("#country").val(country);
    searchReportType();
}
function searchReportType(){	
	getRequest("getSalesReportByTypeCount.php", afterSearchTypeCount, afterSearchTypeCountNo);
}
function afterSearchTypeCount(result){
	typeSearched = true;
	types = result;
	typesCount = types.length;
	
	timeType = mdstGetChecked();
	var timeStr = mdstGetStr();	
	document.getElementById("selTimeType").innerText = timeStr;	
	var timeResult = mdstGetValue();
	
	link = "getSalesReportByType.php?"+timeResult+"&country="+country;	
	getRequest(link, afterSearchType, afterSearchTypeNo);
}
function afterSearchTypeCountNo(result){
	typeSearched = false;
	types = null;
	typesCount = 0;
	typeCountTotal = 0;
	typePriceTotal = 0;
	displayTypeSum();
}
function afterSearchType(result){
	typeSearched = true;
	typeSales = result;
	loadTableType();
}
function afterSearchTypeNo(result) {
	$tableType.bootstrapTable('removeAll');
	types = null;
	typesCount = 0;
	typeCountTotal = 0;
	typePriceTotal = 0;
	displayTypeSum();
}
function loadTableType(){
	typeCountTotal = 0;
	typePriceTotal = 0;
	if (typeSales.length <= 0) {
		displayTypeSum();
		return;
	}	
	$tableType.bootstrapTable('removeAll');
	types.sort(sortTable(sortCol, sortOp));
	var rows = [];
	for(var i=0; i<typesCount; i++){
		types[i]['t_name'] = getTypeNameById(types[i]['t_id']);
		var count = "0";
		var price = "0.00";
		for ( var j=0; j<typeSales.length; j++) {
			if (typeSales[j]['t_id'] == types[i]['t_id']) {
				count = typeSales[j]['count_sum'];
				price = typeSales[j]['price_sum'];
				break;
			}
		}
		rows.push({
			id: types[i]['t_id'],
			idx_type: types[i]['t_name'],
			idx_tcount: types[i]['tcount'],
			idx_count: count,
			idx_price: parseFloat(price).toFixed(2)
		});
		typeCountTotal += parseInt(count);
		typePriceTotal += parseFloat(price);
	}
	$tableType.bootstrapTable('append', rows);	
	displayTypeSum();
}
function displayTypeSum(){
	$tableTypeSum = $('#tableTypeSum');
	$tableTypeSum.bootstrapTable('removeAll');
	var rows = [];
	rows.push({
		idx_types: typesCount,
		idx_count: typeCountTotal.toString(),
		idx_price: typePriceTotal.toFixed(2)
	});
	$tableTypeSum.bootstrapTable('append', rows);	
}
/*************************************************** 
	PAY TAB 
****************************************************/
$tablePay.bootstrapTable({   
	formatNoMatches: function () {
         return "";
    }
});
function searchReportPay(){
	timePay = mdstGetChecked();
	var timeStr = mdstGetStr();	
	document.getElementById("selTimePay").innerText = timeStr;	
	var timeResult = mdstGetValue();
	
	link = "getSalesReportByPay.php?"+timeResult;	
	getRequest(link, afterSearchPay, afterSearchPayNo);
}
function afterSearchPay(result){
	pays = result[0];
	loadTablePay();
}
function afterSearchPayNo(result){
	pays = null;
	payPriceTotal = 0;
	$tablePay.bootstrapTable('removeAll');
	displayPaySum();
}
function loadTablePay(){
	payPriceTotal = 0;
	$tablePay.bootstrapTable('removeAll');
	var pay_titles = ["1."+myRes['comPayCash'], "2."+myRes['comPayCard'], "3."+myRes['comPayTransfer'], "4."+myRes['comPayCheck'], "5."+myRes['comPayOther']];
	var pay_data = ["cash", "card", "bank", "scheck", "other"];
	var rows = [];
	for (var i=0; i<5; i++) {
		rows.push({
			id: i,
			idx_pay: pay_titles[i],
			idx_price: pays[pay_data[i]]
		});
		payPriceTotal += parseFloat(pays[pay_data[i]]);
	}	
	$tablePay.bootstrapTable('append', rows);
	displayPaySum();	
}
function displayPaySum(){
	$tablePaySum = $('#tablePaySum');
	$tablePaySum.bootstrapTable('removeAll');
	var rows = [];
	rows.push({
		idx_pays: 5,
		idx_price: payPriceTotal.toFixed(2)
	});
	$tablePaySum.bootstrapTable('append', rows);	
}
/* Sort table */
function sortTable(key, option){
    return function(a, b){ 
		var x = a[key]; var y = b[key];
if (key == "count" || key == "count_sum" || key == "in_count" || key == "out_count" || key == "real_count" || key == "real_count_sum") {
			x= parseInt(x); y = parseInt(y);
		}
		if (key == "price_sum" || key == "cost_sum" || key == "profit_rate") {
			x= parseFloat(x); y = parseFloat(y);
		}
		if(option == 1){
			return ((x < y) ? 1 : ((x > y) ? -1 : 0));
		}
		else {
			return ((x < y) ? -1 : ((x > y) ? 1 : 0));
		}  
    }    
}    
/* Show time selection (modalTime) */
function selectTime(){
	$modalSelTime.modal();	
}
function mdstDoneTime(){
	$modalSelTime.modal("toggle");	
	if (tabId == "cust")
		searchReportCust();
	else if (tabId == "type")
		searchReportType();
	else if (tabId == "pay")
		searchReportPay();
	else if (tabId == "sup")
		searchReportSup();
	else
		searchReportMain();
}
/* Print report */
function printReport() {
	
}
/* TAB actions */
function showMainTab() {
	document.getElementById("myTitle").innerHTML = myRes['rptReport']+" - "+myRes['comProduct'];
	tabShow = false;
	$('#containerTabs').hide();
	tabId = "main";
	mdstSetChecked(timeMain);
	if (!mainSearched)
		searchReportMain();
}
function showCustTab() {
	document.getElementById("myTitle").innerHTML = myRes['rptReport']+" - "+myRes['comCustomer'];
	tabShow = false;
	$('#containerTabs').hide();
	tabId = "cust";
	mdstSetChecked(timeCust);
	if (!custSearched)
		searchReportCust();
}
function showSupTab() {
	document.getElementById("myTitle").innerHTML = myRes['rptReport']+" - "+myRes['comSupplier'];
	tabShow = false;
	$('#containerTabs').hide();
	tabId = "sup";
	mdstSetChecked(timeSup);
	if (!supSearched)
		searchReportSup();
}
function showTypeTab() {
	document.getElementById("myTitle").innerHTML = myRes['rptReport']+" - "+myRes['comType'];
	tabShow = false;
	$('#containerTabs').hide();
	tabId = "type";
	mdstSetChecked(timeType);
	if (!typeSearched)
		searchReportType();
}
function showPayTab() {
	document.getElementById("myTitle").innerHTML = myRes['rptReport']+" - "+myRes['comPayment'];
	tabShow = false;
	$('#containerTabs').hide();
	tabId = "pay";
	mdstSetChecked(timePay);
	if (!paySearched)
		searchReportPay();
}
</script>

</html>
