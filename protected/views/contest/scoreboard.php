<?php
/* @var $this ContestController */
?>
<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'scoreboard')); ?>
<?php
	$gridView = $this->widget('zii.widgets.grid.CGridView',array(
		'dataProvider'=>$dataProvider,
		'template'=>"{items}",
		'columns' => array(
			array(
				'name'=>'user_id',
				'value'=>'$data->user->id',
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
			'score'
		),
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
