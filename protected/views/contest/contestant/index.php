<?php
Yii::import('ext.Utilities')

/* @var $this ContestController */
/* @var $listContest array of contest model */
/* @var $bidang array of bidang (no.=>name) */
?>
	<h1>Daftar Kontes</h1>
		<form name="form1" class="form form-inline p-r-10" action="?" method="GET">
			<div class="col-xs-12">
				<div class="col-xs-8">
					<b>Bidang:</b><br>
					<?php
						//bagi 2 layout
						$countBidang = count($bidang); $iterator = 0;
						echo "<div class='col-xs-6'>";
						foreach($bidang as $id=>$name){
							echo CHtml::checkBox("Bidang[$id]")."$name<br>";
							$iterator++;
							if ($iterator == floor($countBidang/2))
								echo "</div><div class='col-xs-6'>";
						}
					echo "</div>";
					?>
				</div>
				<div class="col-xs-4 input-group">
					<input type="text" class="form-control" name="filter" value="<?php if(isset($_GET['filter'])) echo $_GET['filter']; ?>">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></button>
					</span>
				</div>
			</form>
			</div>
			<div class="clearfix"> </div>
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