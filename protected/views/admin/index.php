<?php
/* @var $this AdminController */
/* @var $dataProvider CActiveDataProvider */
?>

<h1>Admin</h1>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="pull-left">Daftar Admin</h4>
		<form name="form1" class="form form-inline pull-right p-r-10" action="?">
			<div class="input-group" style="width: 300px">
				<input type="text" class="form-control" name="filter" value="<?php if(isset($_GET['filter'])) echo $_GET['filter']; ?>">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="document.form1.submit()"><span class="glyphicon glyphicon-search"></span></button>
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
			'username',
			'fullname',
			array(
				'name'=>'Bidang',
				'value'=> '$data->getBidangName()'
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