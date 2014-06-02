<?php
/* @var $this ContestController Controller that render this page*/
/* @var $listProblemData 		Problem data (CActiveDataProvider*/
/* @var $contest 				Contest object*/
/* @var $page 					current Page*/
/* @var $pagination				pagination object*/

Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/ckeditor/ckeditor.js');
$number = $pagination->pageSize * $pagination->currentPage + 1;

?>

<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'updateContestProblem')); ?>
<ul class="pagination pull-right">
	<li <?php if($pagination->currentPage == 0): ?>class="disabled"<?php endif;?>><?php echo CHtml::link("<span class='glyphicon glyphicon-chevron-left'></span>", array('contest/updateContestProblem', 'id'=>$model->id, 'page'=>0), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
	<?php for($j=0 ; $j<$pagination->pageCount ; $j++): ?>
		<li <?php if($pagination->currentPage == $j): ?>class="active"<?php endif;?>><?php echo CHtml::link($j+1, array('contest/updateContestProblem', 'id'=>$model->id, 'page'=>$j), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
	<?php endfor;?>
	<li <?php if($pagination->currentPage == $pagination->pageCount-1): ?>class="disabled"<?php endif;?>><?php echo CHtml::link("<span class='glyphicon glyphicon-chevron-right'></span>", array('contest/updateContestProblem', 'id'=>$model->id, 'page'=>$pagination->pageCount-1), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
</ul>
<div class="clear"></div>
<div class="alert alert-warning">
	Untuk menambahkan gambar pada soal, pergi ke tab Image, lalu klik gambar yang ingin dimasukkan. Ambil link yang ditampilkan (misal: "?renderImage=25LnxmJqBNhLGiS627vsQWJXcrtYcN7JQptW2Y6LRfBLtTaByB7mJrKMyaPFueyi", lalu tekan tombol image pada editor, dan masukan link tadi ke URL.
</div>
<?php echo CHtml::beginForm(); ?>
<?php foreach($listProblemData as $i=>$problem): 
//break;
?>

	<hr>
	<div class="row">
		<div class="col-md-1" style="width:3%;padding-right:0;margin-right:0;">
			<b><?php echo $number++;?></b>
		</div>
		<div class="col-md-11" style="width:97%;margin-left:0">
			<?php echo CHtml::activeTextArea($problem, "[$i]content", array('id'=>'editor1', 'class'=>'ckeditor'));?>
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
			<?php echo CHtml::activeTextArea($problem->problemChoice, "[$i]option_a", array('id'=>'editor1', 'class'=>'ckeditor'));?>
		</div>
	</div><br>
	
	<div class="row">
		<div class="col-md-1" style="width:5%;padding-right:0%;margin-right:0%">
			<b class="pull-right">B. </b>
		</div>
		<div class="col-md-11" style="width:95%;margin-left:0">
			<?php echo CHtml::activeTextArea($problem->problemChoice, "[$i]option_b", array('id'=>'editor1', 'class'=>'ckeditor'));?>
		</div>
	</div><br>
	
	<div class="row">
		<div class="col-md-1" style="width:5%;padding-right:0%;margin-right:0%">
			<b class="pull-right">C. </b>
		</div>
		<div class="col-md-11" style="width:95%;margin-left:0">
			<?php echo CHtml::activeTextArea($problem->problemChoice, "[$i]option_c", array('id'=>'editor1', 'class'=>'ckeditor'));?>
		</div>
	</div><br>
	
	<div class="row">
		<div class="col-md-1" style="width:5%;padding-right:0%;margin-right:0%">
			<b class="pull-right">D. </b>
		</div>
		<div class="col-md-11" style="width:95%;margin-left:0">
			<?php echo CHtml::activeTextArea($problem->problemChoice, "[$i]option_d", array('id'=>'editor1', 'class'=>'ckeditor'));?>
		</div>
	</div><br>
	
	<div class="row">
		<div class="col-md-1" style="width:5%;padding-right:0%;margin-right:0%">
			<b class="pull-right">E. </b>
		</div>
		<div class="col-md-11" style="width:95%;margin-left:0">
			<?php echo CHtml::activeTextArea($problem->problemChoice, "[$i]option_e", array('id'=>'editor1', 'class'=>'ckeditor'));?>
		</div>
	</div><br>
	<div style="margin-right:0%;margin-left:5%;">
		<?php echo CHtml::activeDropDownList($problem, "[$i]answer", array('1'=>'A', '2'=>'B', '3'=>'C', '4'=>'D', '5'=>'E'), array('empty'=>'Pilih Jawaban', 'class'=>'form-control')); ?>
	</div>

	<?php } #endif
		#problem is short answer
		else if ($problem->isShortAnswer()){
	?>
	<div class="row">
		<div class="col-md-1" style="width:5%;padding-right:0%;margin-right:0%">
			<b class="pull-right">ans</b>
		</div>
		<div class="col-md-11" style="width:95%;margin-left:0">
			<?php echo CHtml::activeTextArea($problem, "[$i]answer",array('class'=>'form-control'));?>
		</div>
	</div><br>

	<?php } ?>

<?php endforeach?>
<hr>
<?php echo CHtml::submitButton('Save', array('class'=>'btn btn-primary pull left'))?>

<ul class="pagination pull-right">
	<li <?php if($pagination->currentPage == 0): ?>class="disabled"<?php endif;?>><?php echo CHtml::link("<span class='glyphicon glyphicon-chevron-left'></span>", array('contest/updateContestProblem', 'id'=>$model->id, 'page'=>0), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
	<?php for($j=0 ; $j<$pagination->pageCount ; $j++): ?>
		<li <?php if($pagination->currentPage == $j): ?>class="active"<?php endif;?>><?php echo CHtml::link($j+1, array('contest/updateContestProblem', 'id'=>$model->id, 'page'=>$j), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
	<?php endfor;?>
	<li <?php if($pagination->currentPage == $pagination->pageCount-1): ?>class="disabled"<?php endif;?>><?php echo CHtml::link("<span class='glyphicon glyphicon-chevron-right'></span>", array('contest/updateContestProblem', 'id'=>$model->id, 'page'=>$pagination->pageCount-1), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
</ul>

<div class="clear"></div>

<?php echo CHtml::endForm(); ?>

<br><br>

