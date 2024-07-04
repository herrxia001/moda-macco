
<!-- Modal for all order items -->
<div class="modal fade" id="modalItems" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mdItemsTitle"><?php echo $thisResource->mdItemsTitle ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">
					<a><?php echo $thisResource->mdItemsSumCount ?></a><a style="color:blue" id="mdItemsSumCount"></a>
					<a><?php echo $thisResource->mdItemsSumPrice ?></a><a style="color:blue" id="mdItemsSumPrice"></a>
				</div>
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">
					<table id="mdItemsTable" data-toggle="table">
						<thead>
							<tr>
							<th data-field="idx_code" data-sortable="true" data-width="30" data-width-unit="%"><?php echo $thisResource->mdItemsThCode ?></th>
							<th data-field="idx_name" data-sortable="true" data-width="30" data-width-unit="%"><?php echo $thisResource->mdItemsThName ?></th>
							<th data-field="idx_count" data-sortable="true" data-width="20" data-width-unit="%"><?php echo $thisResource->mdItemsThCount ?></th>
							<th data-field="idx_price" data-sortable="true" data-width="20" data-width-unit="%"><?php echo $thisResource->mdItemsThPrice ?></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><span class='fa fa-times'></button>
			</div>
		</div>
	</div>
</div> <!-- End of Modal for all order items -->
