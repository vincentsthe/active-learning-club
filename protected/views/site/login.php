<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>



<div class="col-xs-12">
<div class="col-xs-4"></div>
<div class="col-xs-4">

<center>
<h1>Login</h1>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'login-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
			'htmlOptions'=>array(
				'class'=>'form-group')
		)); ?>

	<!--p class="note">Fields with <span class="required">*</span> are required.</p-->

		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'username',array('style'=>'color:red')); ?>

		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'password',array('style'=>'color:red')); ?>
		<div style="padding:10px">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe',array('class'=>'rememberMe')); ?>
		<?php echo $form->error($model,'rememberMe'); ?><br>
		<?php echo CHtml::submitButton('Login',array('class'=>'btn btn-primary')); ?>
		</div>
Belum punya akun? Silakan <b><?php echo CHtml::Link('daftar di sini',array('site/register'));?></b>. Gratis!
<?php $this->endWidget(); ?>
</div><div class="col-xs-4"></div></center></div>