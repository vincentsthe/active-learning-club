<?php
/* @var $this ContestController */
/* @var $model ContestModel */
?>
<?php if ($listProblem == null) throw new CHttpException(123,"listproblem kosong"); ?>
<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'scoring')); ?>
<?php echo CHtml::beginForm(); ?>
<br>

<table class="table table-striped">
<tr>
	<th>No. Soal</th>
	<th>Nilai benar</th>
	<th>Nilai salah</th>
	<th>Nilai kosong</th>
	</tr>
	<?php foreach($listProblem as $i=>$problem): ?>
		<tr>
			<td><?php echo $i+1; ?></td>
			<td><?php echo CHtml::activeNumberField($problem, "[$i]correct_score");?></td>
			<td><?php echo CHtml::activeNumberField($problem, "[$i]wrong_score");?></td>
			<td><?php echo CHtml::activeNumberField($problem, "[$i]blank_score");?></td>
		</tr>
	<?php endforeach;?>
</table>
<br>
<?php echo CHtml::submitButton('Save', array('class'=>'btn btn-primary pull-right'))?>
<?php echo CHtml::endForm(); ?>