<?php
/* @var $this ContestController Controller that render this page*/
/* @var $listProblemData 		Problem data (CActiveDataProvider*/
/* @var $contest 				Contest object*/
/* @var $page 					current Page*/
/* @var $pagination				pagination object*/

$firstProblemId = ($problemList === null)?0:$problemList[0]->id;
$timeLeft = $contestSubModel->end_time - time(); if ($timeLeft < 0) $timeLeft = 0;
//Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseURL.'/javascripts/mathjax.min.js',CClientScript::POS_HEAD);
Yii::app()->getClientScript()->registerScriptFile("http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML");
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascripts/common/alert-notif.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseURL.'/javascripts/problem.js',CClientScript::POS_HEAD);
Yii::app()->session['view_as'] = User::CONTESTANT;
?>

<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'problem')); ?>
<div class="clear"></div><br>
<div id="server-info" style="display:none; text-align:center;"></div>
<?php echo CHtml::beginForm(); ?>
<div class="pull-left">
<br>
<?php
	if ($timeLeft > 0){
		echo CHtml::ajaxSubmitButton(
			'Simpan Jawaban',
			CController::createUrl('contest/submitAnswerWithAjax',array('contestSubId'=>$contestSubModel->id)),
			array(
				'success'=>"function(){notif('Jawaban berhasil disimpan.','server-info','alert-success');}",
				'error'=>"function(){notif('ERROR : Silakan klik ulang atau refresh (tekan F5)','server-info','alert-danger');}",
								 //kalo ditulis infoSend() doang gak jalan.
			),
			array(
				'class'=>'btn btn-success',
				'onclick'=>"notif('Menyimpan...','server-info','alert-info')",
			)
		);
	}
?>
</div>
<div class="clearfix"></div>
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
	<div class="p-container" rel="<?php echo $problem->id ?>">
	<?php 
			$this->renderPartial('contestant/_loadProblemGeneral',array('problem'=>$problem,'indexNo'=>$iterator));
			$this->renderPartial('contestant/_loadAnswerGeneral',array('problem'=>$problem,'indexNo'=>$iterator,'submission'=>(isset($submissions[$problem->id]))?$submissions[$problem->id]:null));
	?>
	</div>
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
$submitAnswerUrl = CController::createUrl('contest/submitAnswer');
if (true){
Yii::app()->clientScript->registerScript('koyek',"
createTimer($timeLeft);
var activeProblemId; //current active problem
var loadProblemUrl= '$loadProblemUrl';
var contestId = $model->id;
var submitAnswerUrl='$submitAnswerUrl';
"
,CClientScript::POS_END);}



