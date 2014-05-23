<?php
/* @var $this SiteController */
/* @var $model Registerorm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="col-xs-12"><br>
<div class="col-xs-8">
<h3>
<center>ALC learning center adalah tempat untuk mempersiapkan diri kamu untuk mengikuti olimpiade sains nasional</center>
</h3>
<hr>
<div class="col-xs-4"><center><h5>Tryout Gratis</h5><img src="<?php echo Yii::app()->baseUrl?>/images/monitor.png"></center></div>
<div class="col-xs-4"><center><h5>Ranking Skala Nasional</h5><img src="<?php echo Yii::app()->baseUrl?>/images/trophy.png"></center></div>
<div class="col-xs-4"><center><h5>Buat Tryout Sendiri!</h5><img src="<?php echo Yii::app()->baseUrl?>/images/setting.png"></center></div>
<hr>
</div>
<div class="col-xs-4">

<?php if(Yii::app()->user->hasFlash('error')): ?>
	<div class="alert alert-danger">
		<?php echo Yii::app()->user->getFlash('error'); ?>
	</div>
<?php endif; ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'register-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'enableAjaxValidation'=>true,
)); ?>
<center>
	Sudah punya akun? <?php echo CHtml::link('Login',array('site/login')); ?>
</center><br>
	<p class="note">Daftarkan diri anda. Gratis!. </p>
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('class'=>'form-control','placeholder'=>'username')); ?>
		<?php echo $form->error($model,'username',array('style'=>'color:red')); ?>
	<!-- <br> -->	
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'password')); ?>
		<?php echo $form->error($model,'password',array('style'=>'color:red')); ?>
	<!-- <br> -->	
		<?php echo $form->labelEx($model,'repeat_password'); ?>
		<?php echo $form->passwordField($model,'repeat_password',array('class'=>'form-control','placeholder'=>'ulangi password')); ?>
		<?php echo $form->error($model,'repeat_password',array('style'=>'color:red')); ?>
	<!-- <br> -->
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->emailField($model,'email',array('class'=>'form-control','placeholder'=>'email')); ?>
		<?php echo $form->error($model,'email',array('style'=>'color:red')); ?>
	<!-- <br> -->
		<?php echo $form->labelEx($model,'fullname'); ?>
		<?php echo $form->textField($model,'fullname',array('class'=>'form-control','placeholder'=>'nama lengkap')); ?>
		<?php echo $form->error($model,'fullname',array('style'=>'color:red')); ?>
	<!-- <br> -->
		<?php echo $form->labelEx($model,'school'); ?>
		<?php echo $form->textField($model,'school',array('class'=>'form-control','placeholder'=>'asal sekolah')); ?>
		<?php echo $form->error($model,'school',array('style'=>'color:red')); ?>
	<!-- <br> -->
	<br>
	<div class="row buttons">
		<center><?php echo CHtml::submitButton('Register',array('class'=>'btn btn-primary')); ?></center>
	</div>
	<br>

<?php $this->endWidget(); ?>
</div><!-- form -->
</div>