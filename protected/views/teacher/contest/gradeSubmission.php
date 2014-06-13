<?php
/* @var $this ContestController Controller that render this page*/
/* @var $listProblemData 		Problem data (CActiveDataProvider*/
/* @var $listSubmission			Submission data*/
/* @var $contest 				Contest object*/

Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/ckeditor/ckeditor.js');
$number = 1;

?>

<?php $this->renderPartial('_header',array('model'=>$contest)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'grading')); ?>
<div class="clear"></div>
<br>
<?php echo CHtml::beginForm(); ?>
	<?php foreach($listSubmission as $i=>$submission): ?>
		<div class="row">
			<div class="col-md-1" style="width:3%;padding-right:0;margin-right:0;">
				<b><?php echo $number++;?></b>
			</div>
			<div class="col-md-11" style="width:97%;margin-left:0">
				<div>Jawaban:</div>
				
				<?php if($submission->answer != null): ?>
					<br>
					<p>
						<?php echo CHtml::link($submission->answer, array('contest/downloadAnswer', 'contestId'=>$contest->id, 'userId'=>Yii::app()->user->id, 'problemId'=>$submission->problem_id)); ?>
					</p>
				<?php else: ?>
					<p>Tidak ada jawaban.</p>
				<?php endif; ?>
				
				<div class="col-md-9"></div>
				<div class="col-md-1"><h4>Nilai</h4></div>
				<div class="col-md-2">
					<?php echo CHtml::activeTextField($submission, "[$i]score", array('class'=>'form-control'));?>
				</div>
			</div>
		</div><br>
		<hr>
	
	<?php endforeach; ?>
	<?php echo CHtml::submitButton('Save', array('class'=>'btn btn-primary pull left'))?>
	
	<div class="clear"></div>

<?php echo CHtml::endForm(); ?>

<br><br>

