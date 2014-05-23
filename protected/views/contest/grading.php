
<?php
Yii::import('ext.Utilities')
/* @var $this ContestController */
/* @var $dataProvider CActiveDataProvider */
?>
<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'grading')); ?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Daftar User</h4>
		<form name="form1" class="form form-inline pull-right p-r-10" action="?" method="GET">
			<div class="input-group" style="width: 300px">
				<input type="text" class="form-control" name="filter" value="<?php if(isset($_GET['filter'])) echo $_GET['filter']; ?>">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="document.form1.submit()"><span class="glyphicon glyphicon-search"></span></button>
				</span>
			</div>
		</form>

		<div class="clearfix"></div>
	</div>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contest-submission-form',
)); ?>
	<?php $gridView = $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'template'=>"{items}",
		'columns' => array (
			array(
				'name'=>'id',
				'value'=>'$data->id',
				'sortable'=>true,
				),
			array(
				'name'=>'Pengumpul',
				'value'=>'$data->user->username',
				'sortable'=>1,
				),
			'score',
			'correct',
			'wrong',
			'blank',
			array(
				'name'=>'ceklist',
				'type'=>'raw',
				'value'=>function($data)
						{return CHtml::checkBox("CheckList[$data->id]",false);},
				),
			array(
				'type'=>'raw',
				'value'=>function($data)
						{return CHtml::link(
							'<span class="glyphicon glyphicon-remove"></span>',
							CController::createUrl('contest/removeContestSubmission',array(
								'id'=>$data->contest_id,
								'contestSubId'=>$data->id,
							)),
							array('onclick'=>'return confirm("Anda yakin ingin menghapus jawaban ini?")'));}
				),
		),
		'itemsCssClass' => 'table',
		'pager' => array (
			'header'=>'',
			'internalPageCssClass'=>'sds',
			'htmlOptions' => array (
				'class'=>'pagination',
			)
		)
	)); ?>
</div>
<?php echo CHtml::submitButton('Grade', array('class'=>'btn btn-primary')); ?>
<?php $this->endWidget(); ?>

<?php $gridView->renderPager(); ?>