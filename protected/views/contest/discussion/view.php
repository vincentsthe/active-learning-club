<?php
/* @var $this ContestController Controller that render this page*/
/* @var $listProblemData 		Problem data (CActiveDataProvider*/
/* @var $contest 				Contest object*/
/* @var $page 					current Page*/
/* @var $pagination				pagination object*/

$firstProblemId = ($problemIdList === null)?0:$problemIdList[0]->content;
//Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseURL.'/javascripts/mathjax.min.js',CClientScript::POS_HEAD);
Yii::app()->getClientScript()->registerScriptFile("http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML");
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascripts/common/alert-notif.js');
Yii::app()->session['view_as'] = User::CONTESTANT;
?>

<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'viewDiscussion')); ?>
<div class="clear"></div><br>
<div id="server-info" style="display:none; text-align:center;"></div>
<?php echo CHtml::beginForm(); ?>
<?php 
	$iterator = 0;
	foreach($problemIdList as $problem): 
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
			echo CHtml::link('show','javascript:void(0)',array('class'=>'d-show','rel'=>$problem->id)); echo " | ";
			echo CHtml::link('hide','javascript:void(0)',array('class'=>'d-hide','rel'=>$problem->id)); echo " | ";
			echo CHtml::ajaxLink(
				'reload',
				CController::createUrl('contest/loadDiscussionWithAjax',array('pId'=>$problem->id,'id'=>$model->id)),
				array(
					'success'=>"function(data){\$('.d-ans[rel=$problem->id]').html(data); \$('#server-info').hide(); }",
					),
				array(
					'onclick'=>"notif('Loading...','server-info','alert-info')"
					)
                );
			//echo "[$problem->correct_score/$problem->wrong_score/$problem->blank_score]<br>".$problem->content; 
		?>
	<div class="d-ans" rel="<?php echo $problem->id; ?>"></div>
		<?php $this->renderPartial('discussion/_view',array('problemIndex'=>$iterator)); ?>
	</div>
</div>
<hr>
<?php endforeach; ?>
<?php echo CHtml::endForm(); ?>
<script>
var firstPid = <?php echo $firstProblemId; ?>
$('.d-show').click(function(){ var pId = $(this).attr('rel'); $('.d-ans[rel='+pId+']').show();});
$('.d-hide').click(function(){ var pId = $(this).attr('rel'); $('.d-ans[rel='+pId+']').hide();});
</script>



