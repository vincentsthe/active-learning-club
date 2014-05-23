<div class="col-xs-1">
</div>
<div class="col-xs-11">
<?php
$answer = $submission->answer();
if ($problem->type == Problem::MULTIPLE_CHOICE){
	echo CHtml::radioButtonList("Answer[$problem->id]",'1',array('1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'E','6'=>'F'));
?>

<?php } else if ($problem->type == Problem::SHORT_ANSWER){
	echo CHtml::textArea("Answer[$problem->id][answer]",$answer,array('class'=>'form-control'));
?>

<?php } ?>
</div>