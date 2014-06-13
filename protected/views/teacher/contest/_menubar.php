
<ul class="nav nav-tabs">
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "update"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Properti", array('teacher/contest/update','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "contestant"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Kontestan", array('teacher/contest/contestant','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "updateContestProblem"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Edit Soal",array('teacher/contest/updateContestProblem', 'id'=>$_GET['id']));?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "scoring"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Penilaian", array('teacher/contest/scoring','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "updateDiscussion"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Pembahasan", array('teacher/contest/updateDiscussion','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "viewContestProblem"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Review",array('teacher/contest/viewContestProblem', 'id'=>$_GET['id']));?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "grading"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Submission", array('teacher/contest/grading','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "image"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Image", array('teacher/contest/image','id'=>$_GET['id']))?></li>
</ul>
<div class="container">
<?php
	echo CHtml::link("Pindah ke mode kontestan",array('contest/news','id'=>$_GET['id']));
?>
</div>