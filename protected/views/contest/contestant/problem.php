<?php
/* @var $this ContestController Controller that render this page*/
/* @var $listProblemData 		Problem data (CActiveDataProvider*/
/* @var $contest 				Contest object*/
/* @var $page 					current Page*/
/* @var $pagination				pagination object*/

$firstProblemId = ($problemList === null)?0:$problemList[0]->id;
Yii::app()->getClientScript()->registerScriptFile("http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML");

?>

<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'problem')); ?>

<div class="clear"></div>
<ul id="problem-nav" class="pagination pull-right">
	<?php $iterator = 0; foreach ($problemList as $problem): ?>
		<li><?php echo CHtml::ajaxLink(
					++$iterator,
					CController::createUrl('contest/LoadProblemWithAjax',
						//variabel yang akan dikirim
						array(
							'contestId'=>$model->id,
							'problemId'=>$problem->id,
							'indexNo'=>$iterator,
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
<div class="clear"></div>
<?php echo CHtml::beginForm(); ?>
<?php echo CHtml::ajaxSubmitButton('Simpan',CController::createUrl('contest/submitAnswer',array('contestId'=>$model->id)),array('success'=>'alert("ok")')); ?>
Keterangan Poin: [Benar/Salah/Kosong]<br><br>
<?php 
	$iterator = 0;
	foreach($problemList as $problem): 
	$iterator++;
?>

<div class="row problem-container" rel="<?php echo $problem->id; ?>">
	<div id="problem-<?php echo $problem->id?>" class="col-xs-12" style="width:95%;margin-left:0">
		<?php 
			//yang di render cuman first problem doang
			//sisanya dirender lewat click pagination.
			if ($problem->id == $firstProblemId)
				$this->renderPartial('contestant/_loadProblemGeneral',array('problem'=>$problem,'indexNo'=>$iterator));
		?>
	</div>

</div>
<?php echo CHtml::endForm(); ?>
<?php endforeach; ?>
<?php Yii::app()->clientScript->registerScript('koyek',"
function showProblem(problemId){
	$('.problem-container').hide();
	$('.problem-container[rel='+problemId+']').show();
}
"
,CClientScript::POS_READY);
