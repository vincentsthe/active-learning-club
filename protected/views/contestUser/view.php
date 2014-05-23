<?php
/* @var $this ContestUserController */
/* @var $model ContestUser */

$this->breadcrumbs=array(
	'Contest Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ContestUser', 'url'=>array('index')),
	array('label'=>'Create ContestUser', 'url'=>array('create')),
	array('label'=>'Update ContestUser', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ContestUser', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ContestUser', 'url'=>array('admin')),
);
?>

<h1>View ContestUser #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'contest_id',
		'user_id',
	),
)); ?>
