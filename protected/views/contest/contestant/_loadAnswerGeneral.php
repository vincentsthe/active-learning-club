<div class="a-content" rel="<?php echo $problem->id; ?>">
<?php
$answer = ($submission !== null)?$submission:'';
if ($problem->type == Problem::MULTIPLE_CHOICE){
	for($i = 1; $i <= 5; $i++){
		$chr = chr($i - 1 + ord('A'));
		echo "<input type=radio name=Answer[$problem->id][answer] value='$i' ".($answer===$i)?"checked":""."/>$chr  &nbsp";
	}
	echo "<input type=radio name=Answer[$problem->id][answer] value=''".($answer==='')?'checked':''."/><i>kosong</i>";
?>

<?php } else if ($problem->type == Problem::SHORT_ANSWER){
	echo CHtml::textArea("Answer[$problem->id][answer]",$answer,array('class'=>'form-control'));
?>

<?php } ?>
</div>