<!-- Modal Customer -->
<div class="modal fade" id="modalCustomer" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"
	data-backdrop="static" data-keyboard="false" style="overflow-y:scroll">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-body">
<!-- menu -->
		<div class="row">
			<div class="p-1 col-4" align="left">
				<label class="ml-5 mt-2" style="font-weight: bold"><?php echo $thisResource->comCustomer ?></label>
			</div>
			<div class="p-1 col-8" align="right">
				<button type="button" class="btn btn-secondary" onclick="mkCancelCust()"><span class='fa fa-times'></span></button>
				<button type="button" class="mr-1 btn btn-primary" style="width:40px" onclick="mkDoneCust()"><span class='fa fa-check'></span></button>
			</div>
		</div>
		<div class="row">
			<hr style="border:1px solid lightgrey; margin:1px; width:100%">
		</div>
<!-- k_id hidden -->
		<input type="number" class="form-control" id="mk_k_id" name="mk_k_id" autocomplete="off" hidden>
<!-- k_code -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comID ?></span></div>
			<input type="text" class="form-control" id="mk_k_code" name="mk_k_code" oninput="mkSearchCode()">
			<button type="button" class="ml-1 btn btn-outline-secondary" id="mk_autocode" onclick="mkGetCustNo()">💻</button>
		</div>		
<!-- k_name -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comName ?></span></div>
			<input type="text" class="form-control autocomplete" id="mk_k_name" name="mk_k_name">
		</div>
<!-- name1 -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comName1 ?></span></div>
			<input type="text" class="form-control autocomplete" id="mk_name1" name="mk_name1">
		</div>		
<!-- address -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comAddress ?></span></div>
			<input type="text" class="form-control autocomplete" id="mk_address" name="mk_address">
		</div>
<!-- post -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comPost ?></span></div>
			<input type="text" class="form-control autocomplete" id="mk_post" name="mk_post">
		</div>
<!-- city -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comCity ?></span></div>
			<input type="text" class="form-control autocomplete" id="mk_city" name="mk_city">
		</div>
<!-- country -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comCountry ?></span></div>
			<input type="text" class="form-control" id="mk_country" name="mk_country">
			<div class="input-group-append">
				<div class="dropdown dropleft">
					<button type="button" class="btn btn-secondary dropdown-toggle ml-2" data-toggle="dropdown"></button>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="#" onclick="$('#mk_country').val('Austria')">Austria</a></li>
						<li><a class="dropdown-item" href="#" onclick="$('#mk_country').val('Belgien')">Belgien</a></li>
						<li><a class="dropdown-item" href="#" onclick="$('#mk_country').val('Czechia')">Czechia</a></li>
						<li><a class="dropdown-item" href="#" onclick="$('#mk_country').val('Denmark')">Denmark</a></li>
						<li><a class="dropdown-item" href="#" onclick="$('#mk_country').val('Deutschland')">Deutschland</a></li>
						<li><a class="dropdown-item" href="#" onclick="$('#mk_country').val('Finland')">Finland</a></li>
						<li><a class="dropdown-item" href="#" onclick="$('#mk_country').val('France')">France</a></li>
						<li><a class="dropdown-item" href="#" onclick="$('#mk_country').val('Italy')">Italy</a></li>
						<li><a class="dropdown-item" href="#" onclick="$('#mk_country').val('Luxemburg')">Luxemburg</a></li>						
						<li><a class="dropdown-item" href="#" onclick="$('#mk_country').val('Nederland')">Nederland</a></li>
						<li><a class="dropdown-item" href="#" onclick="$('#mk_country').val('Schweiz')">Schweiz</a></li>
						<li><a class="dropdown-item" href="#" onclick="$('#mk_country').val('Nederland')">Spain</a></li>
					</ul>
				</div>
			</div>
		</div>
<!-- tel -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comTel ?></span></div>
			<input type="text" class="form-control autocomplete" id="mk_tel" name="mk_tel">
		</div>
<!-- Ust-IdNo. -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comVat ?></span></div>
			<input type="text" class="form-control autocomplete" id="mk_ustno" name="mk_ustno">
			<div class="input-group-append">
			<button type="button" class="btn btn-secondary ml-2" onclick="validVIES()"><span class='fa fa-search'></span></button>
			<button type="button" class="btn btn-secondary ml-2" onclick="printVIES()"><span class='fa fa-print'></span></button>
			</div>
		</div>
<!-- email -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comEMail ?></span></div>
			<input type="text" class="form-control" id="mk_email" name="mk_email">
		</div>
<!-- WhatsApp -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comWhatsApp ?></span></div>
			<input type="text" class="form-control" id="mk_whatsapp" name="mk_whatsapp">
		</div>
<!-- WeChat -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comWeChat ?></span></div>
			<input type="text" class="form-control" id="mk_wechat" name="mk_wechat">
		</div>
<!-- contact -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comContact ?></span></div>
			<input type="text" class="form-control" id="mk_contact" name="mk_contact">
		</div>
<!-- Tax No. -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comTaxNo ?></span></div>
			<input type="text" class="form-control" id="mk_taxno" name="mk_taxno">
		</div>
<!-- discount -->
		<div class="input-group p-1"> 
			<div class="input-group-prepend"><span class="input-group-text" style="width:100px;"><?php echo $thisResource->comDiscount ?></span></div>
			<input type="number" min="0" max="100" step="0.01" class="form-control" id="mk_discount" name="mk_discount">
		</div>
<!-- foot -->
		<div class="row">
			<hr style="border:1px solid lightgrey; margin:1px; width:100%">
		</div>
		<div class="row">
			<div class="p-1 col" align="right">
				<button type="button" class="btn btn-secondary" onclick="mkCancelCust()"><span class='fa fa-times'></span></button>
				<button type="button" class="mr-1 btn btn-primary" style="width:40px" onclick="mkDoneCust()"><span class='fa fa-check'></span></button>
			</div>
		</div>
		
		</div> <!-- end of modal body -->	
		</div> <!-- end of modal-content -->
	</div> <!-- end of modal-dialog -->
</div> <!-- end of modal -->
