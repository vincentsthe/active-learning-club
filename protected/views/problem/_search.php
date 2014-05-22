<?php
/* @var $this ProblemController */
/* @var $model Problem */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'option_a'); ?>
		<?php echo $form->textArea($model,'option_a',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'option_b'); ?>
		<?php echo $form->textArea($model,'option_b',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'option_c'); ?>
		<?php echo $form->textArea($model,'option_c',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'option_d'); ?>
		<?php echo $form->textArea($model,'option_d',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'option_e'); ?>
		<?php echo $form->textArea($model,'option_e',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'answer'); ?>
		<?php echo $form->textField($model,'answer'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contest_id'); ?>
		<?php echo $form->textField($model,'contest_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'anulir'); ?>
		<?php echo $form->textField($model,'anulir'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->