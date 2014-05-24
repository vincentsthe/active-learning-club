<?php
/* @var $this ContestController Controller that render this page*/
/* @var $listProblemData 		Problem data (CActiveDataProvider*/
/* @var $contest 				Contest object*/
/* @var $page 					current Page*/
/* @var $pagination				pagination object*/

$firstProblemId = ($problemList === null)?0:$problemList[0]->id;
$timeLeft = $contestSubModel->end_time - time(); if ($timeLeft < 0) $timeLeft = 0;
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseURL.'/javascripts/mathjax.min.js',CClientScript::POS_READY);
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseURL.'/javascripts/problem_backup_2.js',CClientScript::POS_END);
?>

<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'problem')); ?>

<div class="clear"></div>
<?php
/**
 * bagian ini kalo mau pake ajax versi 1.
 * ajax versi 1 : tiap ngeklik pagination, reload soal
 * ganti false jadi true kalo mau pake.
 */
if (false) {
?>
<ul id="problem-nav" class="pagination pull-right">
	<?php $iterator = 0; foreach ($problemList as $problem): ?>
		<li><?php echo CHtml::ajaxLink(
					++$iterator,
					CController::createUrl('contest/LoadProblemWithAjax',
						//variabel yang akan dikirim
						array(
							'c'=>$model->id, //contest id
							'p'=>$problem->id, //problem id
							'i'=>$iterator, //index no
							)
					),
					//ajax options
					array(
						'cache'=>true,
						'update'=>"#problem-$problem->id",
						
					),
					array(
						'onclick'=>"showProblem($problem->id)",
					)
					//html options
					);
			?>
		</li>
	<?php endforeach;?>
</ul>
<?php
/**
 * bagian ini ajax versi 2.
 * ajax versi 2 : kalo dah pernah load, gak akan reload (kecuali tekan tombol refresh)
 * tiap problem-nav-no diklik, fungsi loadProblem akan aktif
 * @see problem.js buat keterangan yang lebih gak jelas.
 */
} else {
?>
<ul id="problem-nav" class="pagination pull-right">
	<?php $iterator = 0; foreach ($problemList as $problem): ?>
		<li><a href="#" class="problem-nav-no" rel="<?php echo $problem->id;?>"><?php echo ++$iterator; ?></a>
		</li>
	<?php endforeach;?>
</ul>
<?php } ?>
<?php echo CHtml::beginForm(); ?>

<div class="pull-left">
<br>
<?php

	echo CHtml::ajaxSubmitButton(
		'Simpan',
		CController::createUrl('contest/submitAnswerWithAjax',array('contestSubId'=>$contestSubModel->id)),
		array('success'=>'alert("ganteng")'),
		array('class'=>'btn btn-success','onclick'=>'nSS()')
	);
/*
	echo CHtml::submitButton(
		'Simpan',
		CController::createUrl('contest/submitAnswerWithAjax',array('contestSubId'=>$contestSubModel->id)),
		array('success'=>'alert("ganteng")'),
		array('class'=>'btn btn-success','onclick'=>'nSS()')
	);
*/
?>
</div>

<div class="clear"></div>
<div id="server-info"></div>
<div class="pull-left">Sisa : <span id="timer"></span></div><div class="pull-right">Keterangan Poin: [Benar/Salah/Kosong]</div><br><br>
<?php 
	$iterator = 0;
	foreach($problemList as $problem): 
	$iterator++;
?>
<?php
	/**
	 * each problem is inside div with 'problem-container' class html.
	 */
?>
<div class="row">
	<div class="col-xs-1">
		<center><?php echo "<b>$iterator</b>"; ?></center>
	</div>
	<div class="col-xs-11">
		<?php 
			echo CHtml::link('show','javascript:void(0)',array('class'=>'p-show','rel'=>$problem->id)); echo " | ";
			echo CHtml::link('hide','javascript:void(0)',array('class'=>'p-hide','rel'=>$problem->id)); echo " | ";
			echo CHtml::link('reload','javascript:void(0)',array('class'=>'p-load','rel'=>$problem->id)); echo "<br>";
			//echo "[$problem->correct_score/$problem->wrong_score/$problem->blank_score]<br>".$problem->content; 
		?>
	<?php 
			//yang di render cuman first problem doang
			//sisanya dirender lewat click pagination.
			if ($problem->id == $firstProblemId)
				$this->renderPartial('contestant/_loadProblemGeneral',array('problem'=>$problem,'indexNo'=>$iterator));
			$this->renderPartial('contestant/_loadAnswerGeneral',array('problem'=>$problem,'indexNo'=>$iterator,'submission'=>(isset($submissions[$problem->id]))?$submissions[$problem->id]:null));
	?>
	</div>
</div>
<hr>
<?php endforeach; ?>
<?php echo CHtml::endForm(); ?>
<script>var firstProblemId = <?php echo $firstProblemId; ?></script>
<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseURL.'/javascripts/timer.js',CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseURL.'/javascripts/problem.js',CClientScript::POS_END);?>
<?php
/* nSS : notify submit status : memberikan informasi bahwa client sedang mengirim data ke server */
$loadProblemUrl = CController::createUrl('contest/loadProblem'); 
Yii::app()->clientScript->registerScript('koyek',"
createTimer($timeLeft);
var loadProblemUrl= '$loadProblemUrl';
var contestId = $model->id;
"
,CClientScript::POS_END); ?>


