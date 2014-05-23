<?php
Yii::import('ext.Utilities')

/* @var $this ContestController */
/* @var $rankList CActiveDataProvider */
/* @var $contestSubmissions contestSubmissions*/
?>

<h1>Peringkat</h1>
<div class="panel panel-primary">
	<div class="panel-heading">
		Grading
	</div>
	<table class="table">
	<tr><th>User Id</th><th>Jumlah Benar</th><th>Jumlah Salah</th><th>Skor</th><th></th></tr>
	<?php
		foreach($contestSubmissions as $key=>$contestSubmission):
			echo "<tr><td>$contestSubmission->user_id</td><td>$contestSubmission->correct</td><td>$contestSubmission->wrong</td><td>$contestSubmission->score</td><td>
				".CHtml::link('auto', array('grade/auto','contestSubmissionId'=>$contestSubmission->id,'contestId'=>$contestId))."</td></tr>";
		endforeach;
	?>
	</table>
</div>