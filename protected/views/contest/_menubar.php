<ul class="nav nav-tabs">
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "update"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Properti", array('contest/update','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "viewContestProblem"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Lihat Soal",array('contest/viewContestProblem', 'id'=>$_GET['id']));?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "updateContestProblem"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Edit Soal",array('contest/updateContestProblem', 'id'=>$_GET['id']));?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "contestant"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Kontestan", array('contest/contestant','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "scoring"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Penilaian", array('contest/scoring','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "grading"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Jawaban", array('contest/grading','id'=>$_GET['id']))?></li>
</ul>