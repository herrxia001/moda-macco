<!-- modalPrice -->
<div class="modal fade" id="modalPrice" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"
	data-backdrop="static" data-keyboard="false" style="overflow-y:scroll">
	<div class="modal-dialog">
		<div class="modal-content">

		<div class="modal-body">
<!-- top menu -->		
		<div class="row">
			<div class="p-1 col-6">
				<label id="mdprTitle" class="modalTitle"><?php echo $thisResource->comPriceSystem ?></label>
			</div>
			<div class="p-1 col-6" align="right">
				<button type="button" class="btn btn-outline" onclick="cancelPrice()"><span class='fa fa-times'></span></button>
			</div>
		</div>
		<div class="row">
			<hr class="modalSepLine">
		</div>
<!-- data -->
		<div class="row">
			<div class="p-1 col input-group">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comPrice ?> 1</span></div>
				<input type="number" min="0" step="0.01" class="form-control" id="mdpr_price1">
				<div class="ml-1 input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comRemark ?></span></div>
				<input type="text" class="form-control" id="mdpr_note1">
			</div>
		</div>
		<div class="row">
			<div class="p-1 col input-group">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comPrice ?> 2</span></div>
				<input type="number" min="0" step="0.01" class="form-control" id="mdpr_price2">
				<div class="ml-1 input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comRemark ?></span></div>
				<input type="text" class="form-control" id="mdpr_note2">
			</div>
		</div>
		<div class="row">
			<div class="p-1 col input-group">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comPrice ?> 3</span></div>
				<input type="number" min="0" step="0.01" class="form-control" id="mdpr_price3">
				<div class="ml-1 input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comRemark ?></span></div>
				<input type="text" class="form-control" id="mdpr_note3">
			</div>
		</div>
		<div class="row">
			<div class="p-1 col input-group">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comPrice ?> 4</span></div>
				<input type="number" min="0" step="0.01" class="form-control" id="mdpr_price4">
				<div class="ml-1 input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comRemark ?></span></div>
				<input type="text" class="form-control" id="mdpr_note4">
			</div>
		</div>
		<div class="row">
			<div class="p-1 col input-group">
				<div class="input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comPrice ?> 5</span></div>
				<input type="number" min="0" step="0.01" class="form-control" id="mdpr_price5">
				<div class="ml-1 input-group-prepend"><span class="input-group-text"><?php echo $thisResource->comRemark ?></span></div>
				<input type="text" class="form-control" id="mdpr_note5">
			</div>
		</div>
<!-- bottom menu -->
		<div class="row">
			<hr class="modalSepLine">
		</div>
		<div class="row">
			<div class="col p-1" align="right">				
				<button type="button" class="btn btn-outline-secondary button-m" onclick="cancelPrice()" ><?php echo $thisResource->comBack ?></button>
				<button type="button" class="mr-1 btn btn-primary button-m" onclick="donePrice()"><?php echo $thisResource->comSave ?></button>
			</div>
		</div>
		
		</div>
		</div>
	</div>
</div> <!-- modalPrice -->