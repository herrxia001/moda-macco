
<!-- Modal for customer search -->
<div class="modal fade" id="modalCustSearch" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mksTitle"><?php echo $thisResource->fmCustSrchTitle ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			
			<div class="modal-body">
<!-- fields -->
			<div class="row"><div class="input-group p-1">
					<div class="input-group-prepend"><span class="input-group-text" style="width:80px;"><?php echo $thisResource->fmCustSrchCapId ?></span></div>
					<input type="text" class="form-control" id="mks_k_code" name="mks_k_code" oninput="mdsSearchCode()">		
			</div></div>
			<div class="row"><div class="input-group p-1">
				<div class="input-group-prepend"><span class="input-group-text" style="width:80px;"><?php echo $thisResource->fmCustSrchCapName ?></span></div>
				<input type="text" class="form-control autocomplete" id="mks_k_name" name="mks_k_name">		
			</div></div>
			<div class="row"><div class="input-group p-1">
				<div class="input-group-prepend"><span class="input-group-text" style="width:80px;"><?php echo $thisResource->fmCustSrchCapName1 ?></span></div>
				<input type="text" class="form-control autocomplete" id="mks_name1" name="mks_name1">		
			</div></div>
			<div class="row"><div class="input-group p-1">
				<div class="input-group-prepend"><span class="input-group-text" style="width:80px;"><?php echo $thisResource->fmCustSrchCapPost ?></span></div>
				<input type="text" class="form-control autocomplete" id="mks_post" name="mks_post">		
			</div></div>
			<div class="row"><div class="input-group p-1">
				<div class="input-group-prepend"><span class="input-group-text" style="width:80px;"><?php echo $thisResource->fmCustSrchCapUst ?></span></div>
				<input type="text" class="form-control autocomplete" id="mks_ustno" name="mks_ustno">
			</div></div>
<!-- End of fields -->
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" id="mksBtnNew" onclick="mksNewCust()"><?php echo $thisResource->fmCustSrchBtnNew ?></button>
				<button type="button" class="btn btn-primary" onclick="mksNext()"><?php echo $thisResource->fmCustSrchBtnNext ?></button>
			</div>
		</div>
	</div>
</div> <!-- End of Modal customer search -->
