<?php
/* @var $this ProblemController */
/* @var $data Problem */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo CHtml::encode($data->content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('option_a')); ?>:</b>
	<?php echo CHtml::encode($data->option_a); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('option_b')); ?>:</b>
	<?php echo CHtml::encode($data->option_b); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('option_c')); ?>:</b>
	<?php echo CHtml::encode($data->option_c); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('option_d')); ?>:</b>
	<?php echo CHtml::encode($data->option_d); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('option_e')); ?>:</b>
	<?php echo CHtml::encode($data->option_e); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('answer')); ?>:</b>
	<?php echo CHtml::encode($data->answer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contest_id')); ?>:</b>
	<?php echo CHtml::encode($data->contest_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('anulir')); ?>:</b>
	<?php echo CHtml::encode($data->anulir); ?>
	<br />

	*/ ?>

</div>