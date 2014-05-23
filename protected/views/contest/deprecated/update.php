<?php
/* @var $this ContestController */
/* @var $model UpdateContestForm */
/* @var $contestId integer*/

Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.datetimepicker.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/jquery.datetimepicker.css');
?>

<div class="row">
	<div class="col-md-10">
		<h1><?php echo $model->title; ?></h1>
	</div>
	<div class="col-md-2">
		<br>
		<br>
		<?php echo CHtml::link("Edit Soal", array('contest/updateContestProblem', 'id'=>$contestId), array('class' => 'btn btn-primary')); ?>
	</div>
</div>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'contest-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>true,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'title'); ?>
			<?php echo $form->textField($model,'title', array('class'=>'form-control'));?>
			<?php echo $form->error($model,'title'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'start_time'); ?>
			<?php echo $form->textField($model,'start_time', array('class'=>'form-control', 'id'=>'datetimepicker'));?>
			<?php echo $form->error($model,'start_time'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'end_time'); ?>
			<?php echo $form->textField($model,'end_time', array('class'=>'form-control', 'id'=>'datetimepicker1'));?>
			<?php echo $form->error($model,'end_time'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'duration'); ?>
			<?php echo $form->textField($model,'duration', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'duration'); ?>
		</div>
	
		<div class="row buttons">
			<?php echo CHtml::submitButton('Update', array('class'=>'btn btn-primary')); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	<hr>
	<h2>Peserta</h2>
	
	<table class="table table-striped">
		<tr>
			<th>Username</th>
			<th>Nama Lengkap</th>
			<th>Asal Sekolah</th>
			<th></th>
		</tr>
		<?php foreach($userList as $user): ?>
			<tr>
				<td><?php echo $user->username; ?></td>
				<td><?php echo $user->fullname; ?></td>
				<td><?php echo $user->school; ?></td>
				<td><?php echo CHtml::link('<span class="glyphicon glyphicon-remove"></span>', array(
					'contest/removeContestant',
					'userId' => $user->id,
					'contestId' => $contestId,
				)); ?>
				</td>
			</tr>
		<?php endforeach;?>
	</table>
	
	<h3>Tambah Peserta</h3>
	<div class="row">
		<form action="?" method="GET">
			<div class="col-md-2"><b>Cari:</b></div>
			<div class="col-md-4">
					<input type="text" class="form-control input-sm" name="userKey">
			</div>
			<input type="submit" value="cari" class="btn btn-primary">
		</form>
	</div>
	
	<?php 
		$gridView = $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider' => $userSearchList,
			'template' => "{items}",
			'columns' => array(
				'username',
				'fullname',
				'school',
				array(
					'name' => '',
					'type' => 'raw',
					'value' => function($data) use ($contestId) {
						return CHtml::link('add', array(
							'contest/addContestant',
							'userId' => $data->id,
							'contestId' => $contestId,
						));
					}
				),
			),
			'itemsCssClass' => 'table table-striped',
			'pager' => array(
				'header' => '',
				'htmlOptions' => array (
					'class' => 'pagination',
				),
			)
		));

		$gridView->renderPager();
	?>
	
	<script type="text/javascript">
	$('#datetimepicker').datetimepicker({
		  format:'d-m-Y H:i',
		  mask:true,
		  lang:'en'
		});
		$('#datetimepicker1').datetimepicker({
		  format:'d-m-Y H:i',
		  mask:true,
		  lang:'en'
		});
	</script>

</div>