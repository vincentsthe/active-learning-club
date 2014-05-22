<?php
/* @var $this ProblemController */
/* @var $model Problem */

$this->breadcrumbs=array(
	'Problems'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Problem', 'url'=>array('index')),
	array('label'=>'Create Problem', 'url'=>array('create')),
	array('label'=>'Update Problem', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Problem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Problem', 'url'=>array('admin')),
);
?>

<h1>View Problem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'content',
		'option_a',
		'option_b',
		'option_c',
		'option_d',
		'option_e',
		'answer',
		'contest_id',
		'anulir',
	),
)); ?>
