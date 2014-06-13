<?php
/* @var $this ContestController */
/* @var $model ContestForm */
/* @var $form CActiveForm */
?>

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
		<?php echo $form->numberField($model,'duration',array('class'=>'form-control','value'=>ContestForm::DEFAULT_DURATION)); ?>
		<?php echo $form->error($model,'duration'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'problemCount'); ?>
		<?php echo $form->numberField($model,'problemCount',array('class'=>'form-control','value'=>ContestForm::DEFAULT_PROBLEM_COUNT));?>
		<?php echo $form->error($model,'problemCount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'correct_score'); ?>
		<?php echo $form->numberField($model,'correct_score', array('class'=>'form-control','value'=>ContestForm::DEFAULT_CORRECT_SCORE)); ?>
		<?php echo $form->error($model,'correct_score'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'wrong_score'); ?>
		<?php echo $form->numberField($model,'wrong_score',array('class'=>'form-control','value'=>ContestForm::DEFAULT_WRONG_SCORE)); ?>
		<?php echo $form->error($model,'wrong_score'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'blank_score'); ?>
		<?php echo $form->numberField($model,'blank_score', array('class'=>'form-control','value'=>ContestForm::DEFAULT_BLANK_SCORE)); ?>
		<?php echo $form->error($model,'blank_score'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',array('choice'=>'Pilihan Ganda','short'=>'Isian Singkat','essay'=>'Essay'),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description', array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bidang'); ?>
		<?php $list = Bidang::model()->findAll(); ?>
		<?php $result = array(); foreach ($list as $element){ $result[$element->id] = $element->nama; } ?> 
		<?php echo $form->dropDownList($model,'bidang',$result,array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'bidang'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sifat'); ?>
		<?php echo $form->dropDownList($model,'sifat',array('open'=>'terbuka','closed'=>'tertutup','conditional'=>'terkondisi'),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'sifat'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($controllerAction, array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

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

</div><!-- form -->