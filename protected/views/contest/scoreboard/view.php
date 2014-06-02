<?php
/* @var $this ContestController */
?>
<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'scoreboard')); ?>
<?php
	$rank = 0;
	$gridView = $this->widget('zii.widgets.grid.CGridView',array(
		'dataProvider'=>$dataProvider,
		'template'=>"{items}",
		'columns' => array(
			array(
				'name'=>'No',
				'value'=>function() use (&$rank){$rank++; return $rank;}
			),
			array(
				'name'=>'Nama',
				'value'=>function($data){return $data->user->fullname;}
				//'value'=>function($data){return $data->user->fullname;
			),
			array(
				'name'=>'sekolah',
				'value'=>function($data){
					return $data->user->school;
				}
			),
			array(
				'name'=>'Nilai',
				'value'=>function($data){
					return $data->total_score;
				}
			),
		),
		'itemsCssClass'=>'table table-striped'
	));
	// $gridView = $this->widget('zii.widgets.grid.CGridView', array(
	// 	'dataProvider'=>$dataProvider,
	// 	'template'=>"{items}",
	// 	'columns' => array (
	// 		'id',
	// 		'username',
	// 		'fullname',
	// 		array(
	// 			'name'=>'authorName',
	// 			'value'=>'$data->contestSubmissions->id'
	// 		)
	// 	)
	// ));

	?>
