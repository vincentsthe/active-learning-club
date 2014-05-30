<?php
	$viewState = User::CONTESTANT;
	if (Yii::app()->session['view_as'] !== null){
		$viewState = Yii::app()->session['view_as'];
	}
	if ($viewState == User::CONTESTANT){ ?>
<ul class="nav nav-tabs">
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "news"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Pengumuman", array('contest/news','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "problem"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Soal",array('contest/problem', 'id'=>$_GET['id']));?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "scoreboard"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Peringkat",array('contest/scoreboard', 'id'=>$_GET['id']));?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "viewDiscussion"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Pembahasan",array('contest/viewDiscussion', 'id'=>$_GET['id']));?></li>
</ul>
<?php } else if ($viewState == User::TEACHER){ ?>
<ul class="nav nav-tabs">
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "update"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Properti", array('contest/update','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "contestant"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Kontestan", array('contest/contestant','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "updateContestProblem"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Edit Soal",array('contest/updateContestProblem', 'id'=>$_GET['id']));?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "scoring"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Penilaian", array('contest/scoring','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "updateDiscussion"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Pembahasan", array('contest/updateDiscussion','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "viewContestProblem"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Review",array('contest/viewContestProblem', 'id'=>$_GET['id']));?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "grading"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Submission", array('contest/grading','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "image"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Image", array('contest/image','id'=>$_GET['id']))?></li>
</ul>
<?php } ?>
<div class="container">
<?php
	if (Yii::app()->user->isAdmin || Yii::app()->user->isTeacher){
		if ($viewState == User::TEACHER) echo CHtml::link("Pindah ke mode kontestan",array('contest/news','id'=>$_GET['id']));
		else  echo CHtml::link("Pindah ke mode manager", array('contest/update','id'=>$_GET['id']));
	}
?>
</div>