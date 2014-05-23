<?php
/* @var $this ContestController */
/* @var $model UpdateContestForm */
/* @var $contestId integer*/

Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.datetimepicker.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/jquery.datetimepicker.css');
?>

<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'contestant')); ?>
<div class="form">
	<table class="table table-striped">
		<tr>
			<th>Username</th>
			<th>Nama Lengkap</th>
			<th>Asal Sekolah</th>
			<th>Terima</th>
			<th></th>
		</tr>
		<?php foreach($contestUserList as $contestUser): ?>
			<tr>
				<td><?php echo $contestUser->user->username; ?></td>
				<td><?php echo $contestUser->user->fullname; ?></td>
				<td><?php echo $contestUser->user->school; ?></td>
				<td><?php $userId = $contestUser->user->id; echo CHtml::activeCheckBox($contestUser,"[$userId]approved",array('checked'=>$contestUser->approved)); ?></td>
				<td><?php echo CHtml::link('<span class="glyphicon glyphicon-remove"></span>', array(
					'contest/removeContestant',
					'id' => $model->id,
					'userId' => $contestUser->user->id,
				)); ?>
				</td>
			</tr>
		<?php endforeach;?>
		<center></center>
	</table>
	
	<h3>Tambah Peserta</h3>
	<div class="row">
		<form action="?" method="GET">
			<div class="col-md-2"><b>Cari:</b></div>
			<div class="col-md-4">
					<input type="text" class="form-control input-sm" name="userKey">
			</div>
			<input type="submit" value="cari" class="btn btn-primary">
		</form>
	</div>
	
	<?php 
		$gridView = $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider' => $userSearchList,
			'template' => "{items}",
			'columns' => array(
				'username',
				'fullname',
				'school',
				array(
					'name' => '',
					'type' => 'raw',
					'value' => function($data) use ($model){
						return CHtml::link('add', array(
							'contest/addContestant',
							'id' => $model->id,
							'userId' => $data->id,
						));
					}
				),
			),
			'itemsCssClass' => 'table table-striped',
			'pager' => array(
				'header' => '',
				'htmlOptions' => array (
					'class' => 'pagination',
				),
			)
		));

		$gridView->renderPager();
	?>

</div>