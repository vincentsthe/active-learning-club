<?php
Yii::import('ext.Utilities')

/* @var $this ContestController */
/* @var $listContest array of contest model */
/* @var $bidang array of bidang (no.=>name) */
?>

	<h1>Daftar Kontes</h1>
		<?php $this->renderPartial('_search',array(
		'listBidang'=>$listBidang,
		'filter'=>$filter,
	));  //die();?> 
	<br>
	<?php foreach ($listContest as $key => $contest): ?>
	<div class="panel panel-default">
		<div class="panel-heading"><span><?php echo $contest->title;?></span><span class="pull-right"><?php echo Bidang::namaBidang($contest->bidang); ?></span></div>
		<div class="panel-body" style="margin: 10px">
		
		
		<?php echo Utilities::timestampToFormattedDate($contest->start_time)." sampai ".Utilities::timestampToFormattedDate($contest->end_time)?>
		<?php echo $contest->description;?>
		</div>
		<div class="panel-footer" style="text-align:center"><?php echo CHtml::link("<spanclass=\"glyphicon glyphicon-search\">Masuk</span>",array('contest/view','id'=>$contest->id)); ?></div>
	</div>
	<?php endforeach;?>
	

	
</div>
	<?php /*$gridView = $this->widget('zii.widgets.grid.CGridView', array(
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
				'value'=> 'Utilities::timestampToFormattedDate($data->start_time)'
			),
			array(
				'name'=>'',
				'type'=>'raw',
				'value'=>function($data) {
					return 	CHtml::link('<span class="glyphicon glyphicon-search"></span>', array('contest/view', 'id'=>$data->id))." ".
							CHtml::link('<span class="glyphicon glyphicon-edit"></span>', array('contest/update', 'id'=>$data->id))." ".
							CHtml::link('<span class="glyphicon glyphicon-th-list"></span>', array('contest/updateContestProblem', 'id'=>$data->id))." ".
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
	)); */?>
</div>