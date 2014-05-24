<div class="a-content" rel="<?php echo $problem->id; ?>">
<?php

$answer = ($submission !== null)?$submission->answer:'';
if ($problem->type == Problem::MULTIPLE_CHOICE){
	for($i = 1; $i <= 5; $i++){
		$chr = chr($i - 1 + ord('A'));
		$checked = ($i == $answer)?'checked':'';
		echo "<input type=radio name=Answer[$problem->id][answer] value='$i' $checked/>$chr  &nbsp";
	}
	echo "<input type=radio name=Answer[$problem->id][answer] value=''/><i>kosong</i>";
?>

<?php } else if ($problem->type == Problem::SHORT_ANSWER){
	echo CHtml::textArea("Answer[$problem->id][answer]",$answer,array('class'=>'form-control'));
?>

<?php } ?>
</div>