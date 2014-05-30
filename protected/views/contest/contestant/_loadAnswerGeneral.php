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

<?php } else if ($problem->type == Problem::ESSAY): ?>
	
	<?php $form = $this->beginWidget(
	    'CActiveForm',
	    array(
	        'id' => 'upload-form',
	        'enableAjaxValidation' => false,
	        'htmlOptions' => array('enctype' => 'multipart/form-data'),
			'action'=> Yii::app()->createUrl('contest/submitEssay', array(
				'contestId'=>$contest->id,
				'userId'=>Yii::app()->user->id,
				'problemId'=>$problem->id,
			))
	    )
	);?>
	
	<div class="row">
		<div class="col-md-1"></div>
		<div class="box col-md-5">
			<div class="col-md-3">
				<?php echo $form->labelEx($fileForm, 'file'); ?>
			</div>
			
			<div class="col-md-9">
				<?php
					echo $form->fileField($fileForm, 'file');
					echo $form->error($fileForm, 'file');
				?>
			
				<br>
				<div class="font-light">Maksimal 2.5 MB</div>
				<?php echo CHtml::submitButton('Upload', array('class'=>'btn btn-default btn-sm')); ?>
			</div>
		</div>
	</div>
	<?php $this->endWidget(); ?>
	
	<?php if($submission->answer != null): ?>
		<br>
		<p>
			Jawaban: <?php echo CHtml::link($submission->answer, array('contest/downloadAnswer', 'contestId'=>$contest->id, 'userId'=>Yii::app()->user->id, 'problemId'=>$problem->id)); ?>
		</p>
	<?php endif; ?>
<?php endif; ?>

</div>