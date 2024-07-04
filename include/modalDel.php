<!-- modalPrint -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"
	data-backdrop="static" data-keyboard="false" style="overflow-y:scroll">
	<div class="modal-dialog">
		<div class="modal-content">

		<div class="modal-body">
<!-- top menu -->		
		<div class="row">
			<div class="p-1 col-6">
				<label class="modalTitle">删除?</label>
			</div>
			<div class="p-1 col-6" align="right">
				<button type="button" class="btn btn-outline" onclick="cancelDel()"><span class='fa fa-times'></span></button>
			</div>
		</div>
		<div class="row">
			<hr class="modalSepLine">
		</div>
<!-- data -->
		<div class="row">
			<div class="p-1 col input-group">
				<div class="input-group-prepend"><span class="input-group-text">登入密码</span></div>
				<input type="password" class="form-control" id="pwd">
			</div>
		</div>
<!-- bottom menu -->
		<div class="row">
			<hr class="modalSepLine">
		</div>
		<div class="row">
			<div class="col p-1" align="right">				
				<button type="button" class="btn btn-outline-secondary button-m" onclick="cancelDel()" >关闭</button>
				<button type="button" class="mr-1 btn btn-danger button-m" onclick="delItemModal()">删除</button>
			</div>
		</div>
		
		</div>
		</div>
	</div>
</div> <!-- modalPrint -->