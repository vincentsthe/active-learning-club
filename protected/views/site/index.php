<?php
/* @var $this SiteController */
/* @var $model Registerorm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="col-xs-12">
<h2>Register</h2>
<div class="col-xs-7">

<h3>Snack gratis</h3>
<p>The clusters of criteria are the five main personality dimensions 
considered to be essential in the professional world: Communicate, 
Manage, Dare, Adapt, Excel. For each dimension, Talentoday gives you the 
opportunity to discover the behaviors you tend to adopt, that is to say the 
way you prefer to act in the professional realm.</p>
<h3>Snack gratis</h3>
<p>The clusters of criteria are the five main personality dimensions 
considered to be essential in the professional world: Communicate, 
Manage, Dare, Adapt, Excel. For each dimension, Talentoday gives you the 
opportunity to discover the behaviors you tend to adopt, that is to say the 
way you prefer to act in the professional realm.</p>
<h3>Snack gratis</h3>
<p>The clusters of criteria are the five main personality dimensions 
considered to be essential in the professional world: Communicate, 
Manage, Dare, Adapt, Excel. For each dimension, Talentoday gives you the 
opportunity to discover the behaviors you tend to adopt, that is to say the 
way you prefer to act in the professional realm.</p>
</div>
<div class="col-xs-5">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'register-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->textField($model,'username',array('class'=>'form-control','placeholder'=>'username')); ?>
		<?php echo $form->error($model,'username',array('style'=>'color:red')); ?>
	<br>

		<?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'password')); ?>
		<?php echo $form->error($model,'password',array('style'=>'color:red')); ?>
	<br>

		<?php echo $form->passwordField($model,'repeat_password',array('class'=>'form-control','placeholder'=>'ulangi password')); ?>
		<?php echo $form->error($model,'repeat_password',array('style'=>'color:red')); ?>
	<br>
		<?php echo $form->emailField($model,'email',array('class'=>'form-control','placeholder'=>'email')); ?>
		<?php echo $form->error($model,'email',array('style'=>'color:red')); ?>
	<br>
		<?php echo $form->textField($model,'fullname',array('class'=>'form-control','placeholder'=>'nama lengkap')); ?>
		<?php echo $form->error($model,'password',array('style'=>'color:red')); ?>
	<br>
		<?php echo $form->textField($model,'school',array('class'=>'form-control','placeholder'=>'asal sekolah')); ?>
		<?php echo $form->error($model,'school',array('style'=>'color:red')); ?>
	<br>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Register',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
</div>