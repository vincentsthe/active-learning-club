<div class="row">
	<div class="col-xs-1" style="width:5%;padding-right:0%;margin-right:0%">
		<b><?php echo $indexNo; ?></b>
	</div>
	<div class="col-xs-11" style="width:95%;margin-left:0">
		<?php echo "[$problem->correct_score/$problem->wrong_score/$problem->blank_score]<br>".$problem->content; ?>
	</div>
</div><br>
<?php
	if ($problem->type == Problem::MULTIPLE_CHOICE):
?>
<div class="row">
<div class="col-xs-1" style="width:5%;padding-right:0%;margin-right:0%">
		<b class="pull-right">A. </b>
	</div>
	<div class="col-xs-11" style="width:95%;margin-left:0">
		<?php echo $problem->problemChoice->option_a; ?>
	</div>
</div><br>

<div class="row">
	<div class="col-xs-1" style="width:5%;padding-right:0%;margin-right:0%">
		<b class="pull-right">B. </b>
	</div>
	<div class="col-xs-11" style="width:95%;margin-left:0">
		<?php echo $problem->problemChoice->option_b; ?>
	</div>
</div><br>

<div class="row">
	<div class="col-xs-1" style="width:5%;padding-right:0%;margin-right:0%">
		<b class="pull-right">C. </b>
	</div>
	<div class="col-xs-11" style="width:95%;margin-left:0">
		<?php echo $problem->problemChoice->option_c; ?>
	</div>
</div><br>

<div class="row">
	<div class="col-xs-1" style="width:5%;padding-right:0%;margin-right:0%">
		<b class="pull-right">D. </b>
	</div>
	<div class="col-xs-11" style="width:95%;margin-left:0">
		<?php echo $problem->problemChoice->option_d; ?>
	</div>
</div><br>

<div class="row">
	<div class="col-xs-1" style="width:5%;padding-right:0%;margin-right:0%">
		<b class="pull-right">E. </b>
	</div>
	<div class="col-xs-11" style="width:95%;margin-left:0">
		<?php echo $problem->problemChoice->option_e; ?>
	</div>
</div><br>
<?php elseif ($problem->type==Problem::SHORT_ANSWER): ?>
<div class="row">
	<div class="col-xs-1" style="width:5%;padding-right:0%;margin-right:0%"></div>
	<div class="col-xs-11" style="width:95%;margin-left:0">
		<?php echo CHtml::textArea("[$problem->id]answer",'',array('class'=>'form-control'));?>
	</div>
</div><br>
<?php endif; ?>