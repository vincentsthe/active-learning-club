<?php
/* @var $this ContestUserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Contest Users',
);

$this->menu=array(
	array('label'=>'Create ContestUser', 'url'=>array('create')),
	array('label'=>'Manage ContestUser', 'url'=>array('admin')),
);
?>

<h1>Contest Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
