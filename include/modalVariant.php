
<div class="modal fade" id="modalVariant" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"
	data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		
		<div class="modal-header">
			<b class="modal-title" id="mdvTitle"></b>
			<button type="button" class="btn btn-success" id="mdvBtnAdd" onclick="mdvAdd()"><?php echo $thisResource->comAdd ?></button>
			<button type="button" class="btn btn-primary" id="mvBtnDone" onclick="mdvDone()"><span class='fa fa-check'></button>
		</div>
		
		<div class="modal-body">
			<div class="container" id="mdvDataContainer" style="border:1px solid lightgray;">
				<div class="row">
					<div class="p-1 col-6">
						<b id="mdvDataTitle"></b>
					</div>
					<div class="p-1 input-group col-6">					
						<button type="button" class="ml-1 btn btn-secondary" id="mdvBtnCancelItem" onclick="mdvCancelItem()"><span class='fa fa-times'></button>
						<button type="button" class="ml-1 btn btn-danger" id="mdvBtnDelItem" onclick="mdvDelItem()"><span class='fa fa-trash'></button>
						<button type="button" class="ml-1 btn btn-primary" id="mdvBtnAddItem" onclick="mdvAddItem()"><span class='fa fa-check'></button>
						<button type="button" class="ml-1 btn btn-primary" id="mdvBtnUpdateItem" onclick="mdvUpdateItem()"><span class='fa fa-check'></button>
						<button type="button" class="ml-1 btn btn-success" onclick="showPrintModal()"><span class='fa fa-print'></span> 打印</button>
					</div>
				</div>
				<div class="row">
					<div class="p-1 col-12 col-sm-12 col-md-12 col-lg-12">
					<div class="p-1 input-group">	
						<div class="input-group-prepend"><span class="input-group-text" style="width:80px;"><?php echo $thisResource->comVariant ?></span></div>				
						<input type="text" class="form-control" id="mdv_variant" name="mdv_variant">
						<div class="input-group-append">
							<div class="dropdown dropleft">
							<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"></button>
							<ul class="dropdown-menu">
							<?php for($i=0; $i<count($myVariants); $i++) 
							echo "<a class='dropdown-item' href='#' onclick='selVariants(this)'>".$myVariants[$i]['variant']."</a>";
							?>
							</ul>
							</div>
						</div>
					</div>


                    <div class="p-1 input-group <?php if(!in_array($_SESSION['uId'], array(1))) echo "display_none"; ?>">
                        <div class="input-group-prepend"><span class="input-group-text" style="width:80px;"><?php echo $thisResource->comVariantSize ?></span></div>
                        <input type="text" class="form-control" id="mdv_variant_size" name="mdv_variant_size" readonly>
                        <div class="input-group-append">
                            <div class="dropdown dropleft">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"></button>
                                <ul class="dropdown-menu">
                                    <?php foreach($sizeArr AS $index => $value)
                                        echo "<a class='dropdown-item' href='#' onclick='selVariantSize(this)'>".$value."</a>";
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>


					<div class="p-1 input-group">	
						<div class="input-group-prepend"><span class="input-group-text" style="width:80px;"><?php echo $thisResource->comQuantity ?></span></div>				
						<input type="number" min="0" step="1" class="form-control" id="mdv_amount" name="mdv_amount">
					</div>
					<div class="p-1 input-group">	
						<div class="input-group-prepend"><span class="input-group-text" style="width:80px;"><?php echo $thisResource->comBarcode ?></span></div>				
						<input type="text" class="form-control" id="mdv_code" name="mdv_code">
					</div>
					</div>
				</div>
				<div class="row">
					<div class="p-1 col-10" style="border:1px solid lightgray" >
						<div class="container" id="mdvImageContainer" style="overflow:auto; height:160px">
						<?php for($i=0; $i<100; $i++){ ?>
						<img id="mdsi_image_<?php echo $i ?>" src="blank.jpg" 
							style="object-fit: cover" width="60" height="80" onclick="mdvSelImage(this)">
						<?php } ?>
						</div>
					</div>
					<div class="p-1 col-2">
						<img id="mdsi_selimage" src="blank.jpg" style="object-fit:cover;" width="60" height="80">
						<label for="mdvNewImage" class="btn btn-primary mt-2" style="width:100%"><span class="fa fa-camera"></label>
							<input type="file" id="mdvNewImage" name="mdvNewImage" accept="image/*" hidden>
						<button type="button" class="btn btn-secondary" style="width:100%" onclick="mdvNoImage()()"><span class="fa fa-ban"></button>
					</div>
				</div>
			</div>
			<br>
			<div class="container" id="mdvListContainer" style="border:1px solid lightgray; overflow:auto;"> 
			<?php for ($i=0; $i<100; $i++) { ?>			
			<div class="row" style="border-bottom:1px solid lightgray;" id="mdv_item_<?php echo $i ?>" onclick="mdvSelectItem(this)">			
				<div class="p-1 col-2" align="center">
					<img class="mt-1" id="mdv_image_<?php echo $i ?>" src="blank.jpg" style="border:1px dotted; object-fit: cover" width="60">
				</div>
				<div class="p-1 col-10">
					<div class="row">
						<div class="p-1 col-7">
							<b class="ml-4" id="mdv_textv_<?php echo $i ?>"></b>
                            <b class="ml-4 <?php if(!in_array($_SESSION['uId'], array(1))) echo "display_none"; ?>" id="mdv_texts_<?php echo $i ?>"></b>
						</div>
						<div class="p-1 col-3">
							<label id="mdv_texta_<?php echo $i ?>"></label>
						</div>
					</div>
					<div class="row">
						<div class="p-1 col-10">
							<label class="ml-4" id="mdv_textc_<?php echo $i ?>"></label>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			</div> 
		</div>
		
		<div class="modal-footer">
		</div>
		
		</div>
	</div>
</div> <!-- end of modalVariant -->	


