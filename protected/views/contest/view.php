<?php
/* @var $this ContestController */
/* @var $model Contest */
/* @var authenticated is the user have registered to the contest. */

Yii::import('ext.Utilities');
?>
<?php $this->renderPartial('_header',array('model'=>$model)); ?>

<hr>
<div class="row">
	<div class="col-md-9">
	<center><?php echo $model->contestStatusMessage($contestStatus);?> </center> 
	</div>
	<div class="col-md-3">
		<?php
			$tombolDaftar = CHtml::link("Daftar",array('contest/register','id'=>$model->id), array('class' => 'btn btn-primary pull-right','disabled'=>($model->isClosed())));
			$tombolMulai = CHtml::link('Start',array('contest/start','id'=>$model->id), array('class' => 'btn btn-primary pull-right','disabled'=>($contestStatus == Contest:: NOT_APPROVED || $contestStatus == Contest::NOT_STARTED)));
			$tombolLanjut = CHtml::link('Lanjutkan',array('contest/problem','id'=>$model->id), array('class' => 'btn btn-primary pull-right','disabled'=>(false)?'disabled':''));
			$tombolCek = CHtml::link('Evaluasi',array('contest/problem','id'=>$model->id), array('class' => 'btn btn-primary pull-right','disabled'=>(false)?'disabled':''));
			if($contestStatus == Contest::NOT_REGISTERED) {
				echo $tombolDaftar;
			} else if ($contestStatus == Contest::NOT_STARTED || $contestStatus == Contest::NOT_WORKED || $contestStatus == Contest::NOT_WORKED || $contestStatus == Contest::NOT_APPROVED){
				echo $tombolMulai;
			} else if ($contestStatus == Contest::WORKED){
				echo $tombolLanjut;
			} else if ($contestStatus == Contest::ENDED || $contestStatus == CONTEST::TIME_UP){
				echo $tombolCek;
			}
		?>
	</div>
</div>

<div class="row">
	<div class="col-md-3"><h5><b>Waktu Aktif</b></h5></div>
	<div class="col-md-9"><h5><?php echo Utilities::timestampToFormattedDate($model->start_time)." sampai ".Utilities::timestampToFormattedDate($model->end_time); ?></h5></div>
</div>
<div class="row">
	<div class="col-md-3"><h5><b>Durasi</b></h5></div>
	<div class="col-md-9"><h5><?php echo $model->duration; ?> menit</h5></div>
</div>
<div class="row">
	<div class="col-md-3"><h5><b>Sifat</b></h5></div>
	<div class="col-md-9"><h5><?php echo $model->sifat; ?></h5></div>
</div>

<?php if ($contestSubModel != null) :
?>
<div class="row">
	<div class="col-md-3"><h5><b>Waktu Kerja</b></h5></div>
	<div class="col-md-9"><h5><?php echo Utilities::timestampToFormattedDate($contestSubModel->start_time)." sampai ".Utilities::timestampToFormattedDate($contestSubModel->end_time);?></h5></div>
</div>
<div class="row">
	<div class="col-md-12"><?php echo $model->description; ?></div></div>
<?php endif;?>



<h3>Kontestan</h3>

<table class="table table-striped">
	<tr>
		<th>id</th>
		<th>Username</th>
		<th>Nama Lengkap</th>
		<th>Asal Sekolah</th>
		<th>Diterima</th>
	</tr>
	<?php foreach($contestantList as $contestant): ?>
		<tr>
			<td><?php echo $contestant->user->id; ?></td>
			<td><?php echo $contestant->user->username; ?></td>
			<td><?php echo $contestant->user->fullname; ?></td>
			<td><?php echo $contestant->user->school; ?></td>
			<td><?php echo ($contestant->approved)?'<span class="glyphicon glyphicon-ok"></span>':''; ?></td>
		</tr>
	<?php endforeach?>
</table>

