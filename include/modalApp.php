<!-- modalApp -->
<div class="modal fade" id="modalApp" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"
	data-backdrop="static" data-keyboard="false" style="overflow-y:scroll">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-body">
<!-- top menu -->		
		<div class="row">
			<div class="p-1 col-6" align="center">
				<label id="mdapTitle" class="modalTitle"></label>
			</div>
			<div class="p-1 col-6" align="right">
				<button type="button" class="btn btn-outline-secondary button-s" onclick="cancelApp()"><?php echo $thisResource->comCancel ?></button>
				<button type="button" class="btn btn-primary button-s" onclick="saveApp()"><?php echo $thisResource->comSave ?></button>
			</div>
		</div>
		<div class="row">
			<hr class="modalSepLine">
		</div>
<!-- status -->
		<div class="row">
			<div class="p-1 col input-group">
				<div class="input-group-prepend"><span class="input-group-text caption"><?php echo $thisResource->appStatus ?></span></div>
				<button type="button" class="p-1 ml-1 btn btn-outline-secondary button-l dropdown-toggle" id="mdap_status_str" data-toggle="dropdown"></button>
				<input type='hidden' id="mdap_status">
				<div class="dropdown-menu">
					<div class="dropdown-item" href="#" onclick="mdapSelStatus(this)"><?php echo $thisResource->appStatusNormal ?>
						<input type='hidden' value='0'></div>
					<div class="dropdown-item" href="#" onclick="mdapSelStatus(this)"><?php echo $thisResource->appStatusOffline ?>
						<input type='hidden' value='1'></div>
					<div class="dropdown-item" href="#" onclick="mdapSelStatus(this)"><?php echo $thisResource->appStatusRestock ?>
						<input type='hidden' value='2'></div>
				</div>
			</div>
		</div>
<!-- type (collection) -->
		<div class="row">			
			<div class="p-1 col input-group">
				<div class="input-group-prepend"><span class="input-group-text caption"><?php echo $thisResource->comAppTypes ?></span></div>			
				<button type="button" class="p-1 ml-1 btn btn-outline-secondary button-l dropdown-toggle" id="mdap_t_name" data-toggle="dropdown"></button>	
				<input type='hidden' id="mdap_t_id">
				<div class="dropdown-menu">
					<?php if(is_array($myAppTypes)) for($i=0; $i<count($myAppTypes); $i++) 
					echo "<div class='dropdown-item' href='#' onclick='mdapSelType(this)'>".$myAppTypes[$i]['t_name'].
					"<input type='hidden' value='".$myAppTypes[$i]['ap_t_id']."'></div>";
					?>
				</div>
			</div>
		</div>
<!-- discount -->
		<div class="row">		
			<div class="p-1 col">
				<div class="ml-2 form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="mdap_discount" onclick="mdapSelDiscount()"><?php echo $thisResource->appDiscount ?> 
				</label>
				</div>
			</div>
		</div>
<!-- price -->
		<div class="container" id="mdapPriceSec">
		<div class="row">
			<div class="p-1 col-6 input-group">
				<div class="input-group-prepend"><span class="input-group-text caption"><?php echo $thisResource->comPrice ?></span></div>
				<input inputmode="text" class="form-control" id="mdap_price" readonly>
			</div>
			<div class="p-1 col-6 input-group">
				<div class="input-group-prepend"><span class="input-group-text caption"><?php echo $thisResource->appOldPrice ?></span></div>
				<input inputmode="decimal" class="form-control" id="mdap_old_price">
			</div>
		</div>
		</div>
<!-- hot -->
		<div class="row">		
			<div class="p-1 col">
				<div class="ml-2 form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="mdap_hot"><?php echo $thisResource->appHot ?> 
				</label>
				</div>
			</div>
		</div>
<!-- new -->
		<div class="row">	
			<div class="p-1 col">			
				<div class="ml-2 form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="mdap_new"><?php echo $thisResource->appNew ?>
				</label>
				</div>	
			</div>
		</div>
<!-- zero to sale -->
		<div class="row">	
			<div class="p-1 col">			
				<div class="ml-2 form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input" id="mdap_zero"><?php echo $thisResource->appZeroSale ?>
				</label>
				</div>	
			</div>
		</div>
<!-- note -->	
		<div class="row">		
			<div class="p-1 col input-group"> 
				<div class="input-group-prepend"><span class="input-group-text caption"><?php echo $thisResource->appNote ?></span></div>
				<textarea class="form-control" id="mdap_note" rows="4"></textarea>
			</div>
		</div>	
<!-- images -->
		<div class="row">		
			<div class="p-1 col input-group">
				<?php for($i=0; $i<30; $i++){ ?>
				<div class="mx-1" id="mdap_div_<?php echo $i ?>" ondrop="drop(event)" ondragover="allowDrop(event)">
					<img id="mdap_img_<?php echo $i ?>" draggable="true" ondragstart="drag(event)" style="object-fit: cover" width="60" height="80">
				</div>
				<?php } ?>
			</div>
		</div>
	
		</div>
		</div>
	</div>
</div> <!-- End of modalApp -->