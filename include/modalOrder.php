
<!-- Modal for order details -->
<div class="modal fade" id="modalOrder" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<b id="mdOrderTitle"></b>
				<a id="mdOrderTitleTime"></a>
				<button type="button" class="close" data-dismiss="modal"><span class='fa fa-times'></span></button>
			</div>
			<div class="modal-body">
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">
					<a>总件数:&nbsp;</a><a style="color:blue" id="mdOrderSumCount"></a>
					<a>&nbsp;&nbsp;&nbsp;&nbsp;总金额:&nbsp;</a><a style="color:blue" id="mdOrderSumPrice"></a>
				</div>
				<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">
					<table id="mdOrderTable" data-toggle="table">
						<thead>
							<tr>
							<th data-field="idx_image" data-width="20" data-width-unit="%">照片</th>	
							<th data-field="idx_code" data-width="30" data-width-unit="%">信息</th>
							<th data-field="idx_count" data-width="20" data-width-unit="%" data-halign="center" data-align="right">件数</th>
							<th data-field="idx_price" data-width="20" data-width-unit="%" data-halign="center" data-align="right">金额</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div> <!-- End of Modal order details -->
