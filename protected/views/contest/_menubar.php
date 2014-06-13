<ul class="nav nav-tabs">
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "news"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Pengumuman", array('contest/news','id'=>$_GET['id']))?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "problem"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Soal",array('contest/problem', 'id'=>$_GET['id']));?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "scoreboard"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Peringkat",array('contest/scoreboard', 'id'=>$_GET['id']));?></li>
	<li <?php if(isset($activeMenuBar) &&  $activeMenuBar == "viewDiscussion"):?>class="active"<?php endif;?> ><?php echo CHtml::link("Pembahasan",array('contest/viewDiscussion', 'id'=>$_GET['id']));?></li>
</ul>
<div class="container">
<?php
	if (Yii::app()->user->isAdmin || Yii::app()->user->isTeacher){
		if ($viewState == User::TEACHER) echo CHtml::link("Pindah ke mode kontestan",array('contest/news','id'=>$_GET['id']));
		else  echo CHtml::link("Pindah ke mode manager", array('contest/update','id'=>$_GET['id']));
	}
?>
</div>