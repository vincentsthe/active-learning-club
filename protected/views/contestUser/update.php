<?php
/* @var $this ContestUserController */
/* @var $model ContestUser */

$this->breadcrumbs=array(
	'Contest Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ContestUser', 'url'=>array('index')),
	array('label'=>'Create ContestUser', 'url'=>array('create')),
	array('label'=>'View ContestUser', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ContestUser', 'url'=>array('admin')),
);
?>

<h1>Update ContestUser <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>