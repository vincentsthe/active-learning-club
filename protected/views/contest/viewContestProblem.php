<?php
/* @var $this ContestController Controller that render this page*/
/* @var $listProblemData 		Problem data (CActiveDataProvider*/
/* @var $contest 				Contest object*/
/* @var $page 					current Page*/
/* @var $pagination				pagination object*/

$number = $pagination->pageSize * $pagination->currentPage + 1;
Yii::app()->getClientScript()->registerScriptFile("http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML");
//Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl."/javascripts/mathjax.min.js");
?>

<?php if ($listProblem == null) throw new CHttpException(123,"listproblem kosong"); ?>
<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'viewContestProblem')); ?>

<div class="clear"></div>
Keterangan Poin: [Benar/Salah/Kosong]
<?php foreach($listProblem as $problem): ?>
	<hr>
	<div class="row">
		<div class="col-md-1" style="width:3%;padding-right:0;margin-right:0;">
			<b><?php echo $number++;?></b>
		</div>
		<div class="col-md-11" style="width:97%;margin-left:0">
			<?php echo "[$problem->correct_score/$problem->wrong_score/$problem->blank_score] $problem->content";?>
		</div>
	</div><br>
	
	<?php 
		# if the problem is a multiple choice 
		if($problem->isMultipleChoice()){ ?>
	<div class="row">
		<div class="col-md-1" style="width:5%;padding-right:0%;margin-right:0%">
			<b class="pull-right">A. </b>
		</div>
		<div class="col-md-11" style="width:95%;margin-left:0">
			<?php echo $problem->problemChoice->option_a; ?>
		</div>
	</div><br>
	
	<div class="row">
		<div class="col-md-1" style="width:5%;padding-right:0%;margin-right:0%">
			<b class="pull-right">B. </b>
		</div>
		<div class="col-md-11" style="width:95%;margin-left:0">
			<?php echo $problem->problemChoice->option_b; ?>
		</div>
	</div><br>
	
	<div class="row">
		<div class="col-md-1" style="width:5%;padding-right:0%;margin-right:0%">
			<b class="pull-right">C. </b>
		</div>
		<div class="col-md-11" style="width:95%;margin-left:0">
			<?php echo $problem->problemChoice->option_c; ?>
		</div>
	</div><br>
	
	<div class="row">
		<div class="col-md-1" style="width:5%;padding-right:0%;margin-right:0%">
			<b class="pull-right">D. </b>
		</div>
		<div class="col-md-11" style="width:95%;margin-left:0">
			<?php echo $problem->problemChoice->option_d; ?>
		</div>
	</div><br>
	
	<div class="row">
		<div class="col-md-1" style="width:5%;padding-right:0%;margin-right:0%">
			<b class="pull-right">E. </b>
		</div>
		<div class="col-md-11" style="width:95%;margin-left:0">
			<?php echo $problem->problemChoice->option_e; ?>
		</div>
	</div><br>
	
	<div class="row">
		<div class="col-md-12" style="width:95%;margin-left:0">
			Jawaban: <b><?php if($problem->answer != null) echo chr($problem->answer + 64); else echo "-";?></b>
		</div>
	</div><br>
	<?php
		}  #endif
		#problem is short answer
		else if ($problem->isShortAnswer()){
	?>
	<div class="row">
		<div class="col-md-1" style="width:5%;padding-right:0%;margin-right:0%">
			<b class="pull-right">ans</b>
		</div>
		<div class="col-md-11" style="width:95%;margin-left:0">
			<?php echo $problem->answer ?>
		</div>
	</div><br>

	<?php } ?>

	
<?php endforeach?>
<hr>

<ul class="pagination pull-right">
	<li <?php if($pagination->currentPage == 0): ?>class="disabled"<?php endif;?>><?php echo CHtml::link("<span class='glyphicon glyphicon-chevron-left'></span>", array('contest/viewContestProblem', 'id'=>$model->id, 'page'=>0), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
	<?php for($j=0 ; $j<$pagination->pageCount ; $j++): ?>
		<li <?php if($pagination->currentPage == $j): ?>class="active"<?php endif;?>><?php echo CHtml::link($j+1, array('contest/viewContestProblem', 'id'=>$model->id, 'page'=>$j), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
	<?php endfor;?>
	<li <?php if($pagination->currentPage == $pagination->pageCount-1): ?>class="disabled"<?php endif;?>><?php echo CHtml::link("<span class='glyphicon glyphicon-chevron-right'></span>", array('contest/viewContestProblem', 'id'=>$model->id, 'page'=>$pagination->pageCount-1), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
</ul>

<div class="clear"></div>

<br><br>

