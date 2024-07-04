
<!-- Modal for order items -->
<div class="modal fade" id="modalOrderItems" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

		<div class="modal-body">
<!-- top menu -->		
		<div class="row">
			<div class="p-1 col-6">
				<a><?php echo $thisResource->comQuantity ?>: </a><a id="mdoiSumCount"></a>
				<a><?php echo $thisResource->comTotal ?>: </a><a id="mdoiSumValue"></a>
			</div>
			<div class="p-1 col-6" align="right">
				<button type="button" class="btn btn-outline" onclick="mdoiCancel()"><span class='fa fa-times'></span></button>
			</div>
		</div>
		<div class="row">
			<hr class="modalSepLine">
		</div>
		<div class="row">
			<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">
				<table id="mdoiTable" data-toggle="table">
					<thead>
						<tr>
						<th data-field="idx_image" data-width="10" data-width-unit="%"></th>
						<th data-field="idx_code" data-sortable="true" data-width="30" data-width-unit="%"><?php echo $thisResource->comProductNo ?></th>
						<th data-field="idx_count" data-sortable="true" data-width="30" data-width-unit="%"><?php echo $thisResource->comQuantity ?></th>
						<th data-field="idx_price" data-sortable="true" data-width="30" data-width-unit="%"><?php echo $thisResource->comPrice ?></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
<!-- bottom menu -->
		<div class="row">
			<hr class="modalSepLine">
		</div>
		<div class="row">
			<div class="col p-1" align="right">				
				<button type="button" class="btn btn-outline-secondary button-m" onclick="mdoiCancel()" ><?php echo $thisResource->comBack ?></button>
			</div>
		</div>
		
		</div>
		</div>
	</div>
</div> <!-- End of Modal for order items -->
