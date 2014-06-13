<?php
/* @var $this ContestController */
/* @var $model Contest */
/* @var $contestId integer*//* @var $dataProvider CActiveDataProvider */
/* @var $imageForm ImageForm */

Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascripts/lightbox.min.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/lightbox.css');
?>

<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'image')); ?>
	
<h1>Images</h1>
<hr>
<?php if(Yii::app()->user->hasFlash('error')): ?>
	<div class="alert alert-danger">
		<?php echo Yii::app()->user->getFlash('error'); ?>
	</div>
<?php endif;?>

<?php if(Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success">
		<?php echo Yii::app()->user->getFlash('success'); ?>
	</div>
<?php endif;?>
<?php $form = $this->beginWidget(
    'CActiveForm',
    array(
        'id' => 'upload-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )
);?>

<div class="row">
	<div class="col-md-1"></div>
	<div class="box col-md-5">
		<div class="col-md-3">
			<?php echo $form->labelEx($imageForm, 'image'); ?>
		</div>
		
		<div class="col-md-9">
			<?php
				echo $form->fileField($imageForm, 'image');
				echo $form->error($imageForm, 'image');
			?>
		
			<br>
			<?php echo CHtml::submitButton('Upload', array('class'=>'btn btn-default btn-sm')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>
<hr>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_viewImage',
	'template'=>'{summary}<br>{pager}<br><div style="width:100%">{items}</div><div class="clear"></div><br>{pager}',
)); ?>

<script>
	function popup(token) {
		alert("Untuk menggunakan ini sebagai image, copy \n '?renderImage=" + token + "' \n ke src. (termasuk tanda tanya di depan)");
	}
</script>