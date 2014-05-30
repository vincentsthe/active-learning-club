<?php
Yii::import('ext.Utilities')

/* @var $this ContestController */
/* @var $dataProvider CActiveDataProvider */
?>

<h1>Kontes</h1>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Daftar Kontes</h4>
		<form name="form1" class="form form-inline pull-right p-r-10" action="?" method="GET">
			<div class="input-group">
				<input type="text" class="form-control" name="filter" value="<?php if(isset($_GET['filter'])) echo $_GET['filter']; ?>">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
				</span>
			</div>
		</form>
		<div class="clearfix"></div>
	</div>
	<?php $gridView = $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'template'=>"{items}",
		'columns' => array (
			'id',
			array(
				'name'=>'Nama',
				'value'=>'$data->title'
			),
			array(
				'name'=>'Waktu Mulai',
				'value'=>'Utilities::timestampToFormattedDate($data->start_time)',
			),
			array(
				'name'=>'Waktu Selesai',
				'value'=> 'Utilities::timestampToFormattedDate($data->end_time)'
			),
			array(
				'name'=>'',
				'type'=>'raw',
				'value'=>function($data) {
					return 	CHtml::link('<span class="glyphicon glyphicon-search"></span>', array('contest/view', 'id'=>$data->id))." ".
							CHtml::link('<span class="glyphicon glyphicon-edit"></span>', array('contest/update', 'id'=>$data->id))." ".
							CHtml::link('<span class="glyphicon glyphicon-th-list"></span>', array('contest/updateContestProblem', 'id'=>$data->id))." ".
							CHtml::link('<span class="glyphicon glyphicon-bookmark"></span>', array('contest/rank', 'id'=>$data->id))." ".
							CHtml::link('<span class="glyphicon glyphicon-remove"></span>', array('contest/delete', 'id'=>$data->id), array('onclick'=>'return confirm("Anda yakin ingin menghapus kontes ini?")'));
				},
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