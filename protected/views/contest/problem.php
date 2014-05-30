<?php
/* @var $this ContestController Controller that render this page*/
/* @var $contest 				Contest object*/
/* @var $page 					current Page*/
/* @var $pagination				pagination object*/
/* Yii::app()->getClientScript()->registerScriptFile("http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"); */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseURL.'/javascripts/problem.js',CClientScript::POS_HEAD);
$problemCount = count($problemIdList);
$isEnded = (bool) ($endTime < time());
?>

<script>
	var contestSubId = <?php echo $contestSubId;?> ;
	var contestId = <?php echo $model->id; ?>;
	var contestUrl = "<?php echo Yii::app()->baseURL;?>/index.php/contest";
	var firstProblemId =<?php echo $problemIdList[0]->id;?>;
</script>
<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'problem')); ?>
<?php $this->renderPartial('_timer',array('timeLeft'=>$endTime-time())); ?>
<div class="clearfix"></div>
<span id="con-status" class="row" style="pull-left"></span>
<div class="number-box">
<div class="container">
<ul class="simple-pagination light-theme problem-selector">
	<li><a>Prev</a></li>
	<?php 
		//generate pagination
		$i = 1;
		foreach($problemIdList as $problem) {echo "<li class='p-no' rel='$problem->id'><a class='p-no ".(($problem->answer!=null)?'answered':'')."' rel='$problem->id'>$i</a></li>"; $i++;}
	?>
	<li><a>Next</a></li>
</ul>
</div>
</div>
<div id="contest-end" class="highlight red" style="<?php if ($endTime) echo "display:none;";?> text-align: center">Kontes ini telah berakhir</div><br>

<div class="clearfix"></div>
<?php $i = 1; foreach($problemIdList as $key=>$problem) : ?>
<!--startofproblem-->
<div class="problem-container" rel="<?php echo $problem->id;?>">

	<div>
		<span class="col-md-1"><?php echo "<b>$i</b>"; $i++;?></span>
		<span class="question" rel="<?php echo $problem->id;?>"></span>
	</div>
	<?php 
	// line ini ntar diganti
	//  if tipe soal == pilihan ganda
	echo "asd";
	if ($problem->isMultipleChoice()){
		for($opt='a',$answerValue = 1;$opt <= 'e';$opt++,$answerValue++){
			echo "<div>";
			echo "<span class='col-md-1'>";
			$status = ($answerValue==$problem->answer)?"checked":"";
			echo "<input type='radio' name='answer-$problem->id' class='answer-pilgan' rel='$problem->id' value=".$answerValue." ".$status."></span>";
			echo "<span class='answer-$opt-content' rel=$problem->id></span>";
			echo "</div>";
		}
		echo "<div>";
		echo "<span class='col-md-1'><input type='radio' name='answer-$problem->id' class='answer-pilgan' rel='$problem->id' value=''></span>";
		echo "<span class='answer-$opt-content' rel=$problem->id><i>Kosongkan/Blank</i></span>";
		echo "</div>";
	} else if ($problem->isShortAnswer()){
		echo "<div>";
		echo "<span class='col-md-1'>Answer</span>";
		echo "<span class='col-md-9'><input type='text' name='answer-$problem->id' class='form-control' rel='$problem->id' value='$problem->answer'><span>";
		echo "</div>";
	} else if($problem->isEssay()) {
		echo "asdf";
		echo "<div>";
			echo "<form enctype='multipart/form-data' method='post'>";
				echo "<div>";
					echo "<input type='file' name='answerFile'>";
				echo "</div>";
			echo "</form>";
		echo "</div>";
	}
	?>
<div class="clearfix"></div>
</div>
<?php endforeach; ?>
<div class="clear"></div>

<!-- timer-->


<br><br>

