<?php
/* @var $this ContestController */
/* @var $model Contest */

Yii::import('ext.Utilities');
?>

<div class="row">
	<div class="col-md-10">
		<h1><?php echo $model->title; ?></h1>
	</div>
	<div class="col-md-2">
		<br><br>
		<?php echo CHtml::link("Lihat Soal", array('contest/viewContestProblem', 'id'=>$model->id), array('class' => 'btn btn-primary')); ?>
	</div>
</div>
<hr>

<div class="row">
	<div class="col-md-3"><h5><b>Nama Kontes</b></h5></div>
	<div class="col-md-9"><h5><?php echo $model->title; ?></h5></div>
</div>
<div class="row">
	<div class="col-md-3"><h5><b>Start Time</b></h5></div>
	<div class="col-md-9"><h5><?php echo Utilities::timestampToFormattedDate($model->start_time); ?></h5></div>
</div>
<div class="row">
	<div class="col-md-3"><h5><b>End Time</b></h5></div>
	<div class="col-md-9"><h5><?php echo Utilities::timestampToFormattedDate($model->end_time); ?></h5></div>
</div>
<div class="row">
	<div class="col-md-3"><h5><b>Durasi</b></h5></div>
	<div class="col-md-9"><h5><?php echo $model->duration; ?> menit</h5></div>
</div>

<h3>Kontestan</h3>

<table class="table table-striped">
	<tr>
		<th>id</th>
		<th>Username</th>
		<th>Nama Lengkap</th>
		<th>Asal Sekolah</th>
	</tr>
	<?php foreach($contestantList as $contestant): ?>
		<tr>
			<td><?php echo $contestant->id; ?></td>
			<td><?php echo $contestant->username; ?></td>
			<td><?php echo $contestant->fullname; ?></td>
			<td><?php echo $contestant->school; ?></td>
		</tr>
	<?php endforeach?>
</table>

