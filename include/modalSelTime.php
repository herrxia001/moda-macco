
<!-- Modal for time selection -->
<div class="modal fade" id="modalSelTime" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mdstTitle"><?php echo $thisResource->mdstTitle ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="input-group p-1 col-12 col-sm-12 sol-md-12 col-lg-12">
					<label id="rd1"><input type="radio" class="mx-1" id="radio1" name="timeRadio" value="timeToday" checked><?php echo $thisResource->mdstRdToday ?></label>
					<label id="rd2"><input type="radio" class="mx-1" id="radio2" name="timeRadio" value="timeYesterday"><?php echo $thisResource->mdstRdYesterday ?></label>
				</div>
				<div class="input-group p-1 col-12 col-sm-12 sol-md-12 col-lg-12">
					<label id="rd3"><input type="radio" class="mx-1" id="radio3" name="timeRadio" value="timeThisMonth"><?php echo $thisResource->mdstRdThisMonth ?></label>
					<label id="rd4"><input type="radio" class="mx-1" id="radio4" name="timeRadio" value="timeLastMonth"><?php echo $thisResource->mdstRdLastMonth ?></label>
				</div>
				<div class="input-group p-1 col-12 col-sm-12 sol-md-12 col-lg-12">
					<label id="rd5"><input type="radio" class="mx-1" id="radio5" name="timeRadio" value="timeThisYear"><?php echo $thisResource->mdstRdThisYear ?></label>
					<label id="rd6"><input type="radio" class="mx-1" id="radio6" name="timeRadio" value="timeLastYear"><?php echo $thisResource->mdstRdLastYear ?></label>
				</div>
				<div class="input-group p-1 col-12 col-sm-12 sol-md-12 col-lg-12">
					<input type="radio" class="mx-1" id="radio7" name="timeRadio" value="timeMonth">
					<a>&nbsp;<?php echo $thisResource->mdstYear ?>&nbsp;&nbsp;</a>
					<div class="dropdown">
					<button type="button" class="mx-1 btn btn-secondary dropdown-toggle" id="mdstYear" data-toggle="dropdown"><?php echo Date("Y") ?></button>
					<div class="dropdown-menu">
						<?php for ($i=Date("Y"); $i>=2020; $i--) { ?>
						<a class="dropdown-item" href="#" onclick="mdstSelYear(this)"><?php echo $i ?></a>
						<?php } ?>
					</div>
					</div>
					<div class="dropdown">
					<a>&nbsp;<?php echo $thisResource->mdstMonth ?>&nbsp;&nbsp;</a>
					<button type="button" class="mx-1 btn btn-secondary dropdown-toggle" id="mdstMonth" data-toggle="dropdown"><?php echo Date("m") ?></button>
					<div class="dropdown-menu">
						<?php for ($i=1; $i<=12; $i++) { ?>
						<a class="dropdown-item" href="#" onclick="mdstSelMonth(this)"><?php echo $i ?></a>
						<?php } ?>
					</div>
					</div>
				</div>
				<div class="input-group p-1 col-12 col-sm-12 sol-md-12 col-lg-12">
					<input type="radio" class="mx-1" id="radio8" name="timeRadio" value="timePeriod">
					<a><?php echo $thisResource->mdstFrom ?>&nbsp;&nbsp;</a>
					<input type="date" class="form-control" id="mdstFrom" name="mdstFrom" onclick="checkRadio8()" value="<?php echo date('Y-m-d') ?>">
					<a>&nbsp;&nbsp;<?php echo $thisResource->mdstTo ?>&nbsp;&nbsp;</a>
					<input type="date" class="form-control" id="mdstTo" name="mdstTo" onclick="checkRadio8()" value="<?php echo date('Y-m-d') ?>">
				</div>
				<div class="input-group p-1 col-12 col-sm-12 sol-md-12 col-lg-12">
					<label id="rd9"><input type="radio" class="mx-1" id="radio9" name="timeRadio" value="timeAll"><?php echo $thisResource->mdstRdAll ?></label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><span class='fa fa-times'></button>
				<button type="button" class="btn btn-primary" onclick="mdstDoneTime()"><span class='fa fa-check'></button>
			</div>
		</div>
	</div>
</div> <!-- End of Modal for time selection -->
