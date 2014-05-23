<?php
Yii::import('ext.Utilities')

/* @var $this ContestController */
/* @var $rankList CActiveDataProvider */
/* @var $contest Contest*/
?>

<h1>Peringkat</h1>

<div class="panel panel-primary">
	<div class="panel-heading">
		Peringkat Kontes 
	</div>
	<?php $gridView = $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$rankList,
		'template'=>"{items}",
		'columns' => array (
			array(
				'name'=>'Nama',
				'value'=>'$data->user->fullname'
			),
			array(
				'name'=>'Asal Sekolah',
				'value'=>'$data->user->school',
			),
			array(
				'name'=>'Nilai',
				'value'=> '$data->score'
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

<?php $gridView->renderPager(); ?>