<?php
/* @var $this ContestController */
/* @var $model UpdateContestForm */
/* @var $contestId integer*/

Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.datetimepicker.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/jquery.datetimepicker.css');
?>

<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'update')); ?>
<?php $this->renderPartial('_form', array('model'=>$model,'controllerAction'=>$controllerAction)); ?>
	
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
