<div class="p-content" rel="<?php echo $problem->id; ?>"><?php if($indexNo == 1) echo $problem->content; //else echo later ?></div>
<?php
	if ($problem->type == Problem::MULTIPLE_CHOICE):
?>
<div class="row">
	<div class="col-xs-1" style="width:5%;padding-right:0%;margin-right:0%">
		<b class="pull-right">A. </b>
	</div>
	<div class="col-xs-11 p-option_a" rel="<?php echo $problem->id; ?>" style="width:95%;margin-left:0"><?php if($indexNo == 1) echo $problem->problemChoice->option_a; ?></div>
</div><br>

<div class="row">
	<div class="col-xs-1" style="width:5%;padding-right:0%;margin-right:0%">
		<b class="pull-right">B. </b>
	</div>
	<div class="col-xs-11 p-option_b" rel="<?php echo $problem->id; ?>" style="width:95%;margin-left:0"><?php if($indexNo == 1) echo $problem->problemChoice->option_b; ?></div>
</div><br>

<div class="row">
	<div class="col-xs-1" style="width:5%;padding-right:0%;margin-right:0%">
		<b class="pull-right">C. </b>
	</div>
	<div class="col-xs-11 p-option_c" rel="<?php echo $problem->id; ?>" style="width:95%;margin-left:0"><?php if($indexNo == 1) echo $problem->problemChoice->option_c; ?></div>
</div><br>

<div class="row">
	<div class="col-xs-1" style="width:5%;padding-right:0%;margin-right:0%">
		<b class="pull-right">D. </b>
	</div>
	<div class="col-xs-11 p-option_d" rel="<?php echo $problem->id; ?>"style="width:95%;margin-left:0"><?php if($indexNo == 1) echo $problem->problemChoice->option_d; ?></div>
</div><br>

<div class="row">
	<div class="col-xs-1" style="width:5%;padding-right:0%;margin-right:0%">
		<b class="pull-right">E. </b>
	</div>
	<div class="col-xs-11 p-option_e" rel="<?php echo $problem->id; ?>" style="width:95%;margin-left:0"><?php echo $problem->problemChoice->option_e; ?></div>
</div><br>
<?php elseif ($problem->type==Problem::SHORT_ANSWER): /* don't print anything */?>
<?php endif; ?>