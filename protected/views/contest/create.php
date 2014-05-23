<?php
/* @var $this ContestController */
/* @var $model Contest */

Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.datetimepicker.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/jquery.datetimepicker.css');
?>

<h1>Create Contest</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'controllerAction'=>$controllerAction)); ?>