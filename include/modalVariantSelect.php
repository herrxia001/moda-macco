<!-- Modal: modalVariantSelect
		2021-02-04:	created file
-->
<div class="modal fade" id="modalVariantSelect" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"
	data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		
		<div class="modal-header">
			<div class="col-10"><b class="modal-title" id="mdvsTitle"></b></div>
			<div class="col-2"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
		</div>
		
		<div class="modal-body" style="overflow:auto; height:400px">
		<div class="row">
			<div class="input-group p-1">
				<button type="button" class="btn btn-secondary" id="mdvsBtnAdd" onclick="mdvsAdd()">新款色</button>
				<input type="text" class="ml-1 form-control" id="mdvs_new" name="mdvs_new">
				<div class="input-group-append">
					<div class="dropdown dropleft">
					<button type="button" id="mdvsBtnVList" class="ml-1 btn btn-secondary dropdown-toggle" data-toggle="dropdown"></button>
					<ul class="dropdown-menu">
					<?php for($i=0; $i<count($myVariants); $i++) 
					echo "<a class='dropdown-item' href='#' onclick='selVariants(this)'>".$myVariants[$i]['variant']."</a>";
					?>
					</ul>
					</div>
				</div>
				<button type="button" class="ml-1 btn btn-secondary" id="mdvsBtnNewCancel" onclick="mdvsNewCancel()">取消</button>
				<button type="button" class="ml-1 btn btn-primary" id="mdvsBtnNewOk" onclick="mdvsNewOk()">添加</button>
			</div>	
		</div>
		<?php for ($i=0; $i<100; $i++) { ?>			
		<div class="row" style="border-top:1px solid lightgray;" id="mdvsItem_<?php echo $i ?>">			
			<div class="p-1 col-2" align="center">
				<img class="mt-1" id="mdvs_image_<?php echo $i ?>" src="blank.jpg" style="object-fit: cover" width="60" onclick="mdvsShowImageView(this)">
			</div>
			<div class="p-1 col-4" style="border-right:1px solid lightgray;">
				<b class="ml-2" id="mdvs_text_<?php echo $i ?>" style="font-size:14px"></b>
				<br>
				<label class="ml-2" id="mdvs_old_count_<?php echo $i ?>" style="font-size:14px"></label>
			</div>
			<div class="p-1 col-6">
				<div class="input-group">				
					<input type="number" min="0" step="1" class="form-control" id="mdvs_count_<?php echo $i ?>">						
				</div>
				<div class="row">
					<div class="col">
						<button type="button" class="btn btn-outline-secondary btn-block mt-1 p-1" id="mdvsBtnCountMinus_<?php echo $i ?>" onclick="mdvsCountMinus(this)"
							style="touch-action: none"><span class='fa fa-minus'></span></button>
					</div>
					<div class="col">						
						<button type="button" class="btn btn-outline-secondary btn-block mt-1 p-1" id="mdvsBtnCountAdd_<?php echo $i ?>" onclick="mdvsCountAdd(this)"
							style="touch-action: none"><span class='fa fa-plus'></span></button>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		
		<div id="mdvs_imageView" class="w3-modal" onclick="this.style.display='none'">
			<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
				<div class="w3-modal-content w3-animate-zoom">
				<img id="mdvs_imageZoom" src="" style="width:100%">
			</div>
		</div>
			
		</div>
		
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" id="mvsBtnDone" onclick="mdvsDone()"><span class='fa fa-check'></span></button>
		</div>
		
		</div>
	</div>
</div> <!-- end of modalVariantSelect -->	