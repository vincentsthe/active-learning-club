<?php
/* @var $this ProblemController */
/* @var $model Problem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'problem-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'option_a'); ?>
		<?php echo $form->textArea($model,'option_a',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'option_a'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'option_b'); ?>
		<?php echo $form->textArea($model,'option_b',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'option_b'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'option_c'); ?>
		<?php echo $form->textArea($model,'option_c',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'option_c'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'option_d'); ?>
		<?php echo $form->textArea($model,'option_d',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'option_d'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'option_e'); ?>
		<?php echo $form->textArea($model,'option_e',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'option_e'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'answer'); ?>
		<?php echo $form->textField($model,'answer'); ?>
		<?php echo $form->error($model,'answer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contest_id'); ?>
		<?php echo $form->textField($model,'contest_id'); ?>
		<?php echo $form->error($model,'contest_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'anulir'); ?>
		<?php echo $form->textField($model,'anulir'); ?>
		<?php echo $form->error($model,'anulir'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->