<?php
/* @var $this ContestController */
/* @var $model UpdateContestForm */
/* @var $contestId integer*/

Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.datetimepicker.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascripts/common/alert-notif.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/jquery.datetimepicker.css');
?>

<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'contestant')); ?>
<?php /* accept or deny user */ ?>
<?php $form=$this->beginWidget('CActiveForm', array(
        //no need for validatidon
)); ?>
	<table class="table table-striped" id="c-table">
		<tr>
			<th>Username</th>
			<th>Nama Lengkap</th>
			<th>Asal Sekolah</th>
			<th>Terima</th>
			<th> </th>
		</tr>
		<?php foreach($contestUserList as $contestUser): ?>
			<tr class="c-row" rel="<?php echo $contestUser->user_id; ?>">
				<td><?php echo $contestUser->user->username; ?></td>
				<td><?php echo $contestUser->user->fullname; ?></td>
				<td><?php echo $contestUser->user->school; ?></td>
				<td><?php echo $form->checkBox($contestUser,"[$contestUser->user_id]approved",array('checked'=>$contestUser->approved)); 
				//$userId = $contestUser->user->id; echo CHtml::activeCheckBox($contestUser,"[$userId]approved",array('checked'=>$contestUser->approved)); ?></td>
				<td>
				<?php echo CHtml::ajaxLink(
					'<span class="glyphicon glyphicon-remove"></span>',
					CController::createUrl('teacher/contest/removeContestantWithAjax',
						array(
							'id'=>$contestUser->contest_id,
							'userId'=> $contestUser->user_id,
							)
						),
					array(
						'success'=>"function(){\$('.c-row[rel=$contestUser->user_id]').hide();}",
					),
					array(
						//'onclick'=>'javascript:void(0)',
					)); ?>
				</td>
			</tr>
		<?php endforeach;?>
	</table>
	<div class="alert" id="approve-info" style="text-align:center; display:none;"></div>
	<?php echo CHtml::ajaxSubmitButton(
							'Terima Kontestan',
							CController::createUrl('teacher/contest/approveContestantWithAjax',array('id'=>$model->id)),
							array(
								'success'=>"function(){notif('Data penerimaan berhasil disimpan.','approve-info','alert-success');}",
								'error'=>"function(){notif('ERROR : Silakan klik ulang atau refresh (tekan F5)','approve-info','alert-danger');}",
								 //kalo ditulis infoSend() doang gak jalan.
								),
							//array('success'=>'alert("ok")','error'=>'alert("gagal")'),
							array(
								'class'=>'btn btn-primary',
								'onclick'=>"notif('Menyimpan...','approve-info','alert-info')",
							)); ?>
<?php $this->endWidget(); ?>
<div class="form">
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
							'teacher/contest/addContestant',
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