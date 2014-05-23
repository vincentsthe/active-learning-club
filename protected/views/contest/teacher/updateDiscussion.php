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
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'updateDiscussion')); ?>
<ul class="pagination pull-right">
	<li <?php if($pagination->currentPage == 0): ?>class="disabled"<?php endif;?>><?php echo CHtml::link("<span class='glyphicon glyphicon-chevron-left'></span>", array('contest/updateContestProblem', 'id'=>$model->id, 'page'=>0), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
	<?php for($j=0 ; $j<$pagination->pageCount ; $j++): ?>
		<li <?php if($pagination->currentPage == $j): ?>class="active"<?php endif;?>><?php echo CHtml::link($j+1, array('contest/updateContestProblem', 'id'=>$model->id, 'page'=>$j), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
	<?php endfor;?>
	<li <?php if($pagination->currentPage == $pagination->pageCount-1): ?>class="disabled"<?php endif;?>><?php echo CHtml::link("<span class='glyphicon glyphicon-chevron-right'></span>", array('contest/updateContestProblem', 'id'=>$model->id, 'page'=>$pagination->pageCount-1), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
</ul>
<div class="clear"></div>
<div class="alert alert-warning">
	Untuk menambahkan gambar, pergi ke tab Image, lalu klik gambar yang ingin dimasukkan. Ambil link yang ditampilkan (misal: "?renderImage=25LnxmJqBNhLGiS627vsQWJXcrtYcN7JQptW2Y6LRfBLtTaByB7mJrKMyaPFueyi", lalu tekan tombol image pada editor, dan masukan link tadi ke URL.
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
			<b>Pembahasan:</b><br>
			<?php echo CHtml::activeTextArea($problem, "[$i]discussion", array('id'=>'editor1', 'class'=>'ckeditor'));?>
		</div>
	</div>
	<br>
<?php endforeach?>
<hr>
<?php echo CHtml::submitButton('Save', array('class'=>'btn btn-primary pull left'))?>

<ul class="pagination pull-right">
	<li <?php if($pagination->currentPage == 0): ?>class="disabled"<?php endif;?>><?php echo CHtml::link("<span class='glyphicon glyphicon-chevron-left'></span>", array('contest/updateContestProblem', 'id'=>$model->id, 'page'=>0), array('onclick'=>'return confirm("Pastikan anda sudah menyimpan data!")'))?></li>
	<?php for($j=0 ; $j<$pagination->pageCount ; $j++): ?>
		<li <?php if($pagination->currentPage == $j): ?>class="active"<?php endif;?>><?php echo CHtml::link($j+1, array('contest/updateDiscussion', 'id'=>$model->id, 'page'=>$j), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
	<?php endfor;?>
	<li <?php if($pagination->currentPage == $pagination->pageCount-1): ?>class="disabled"<?php endif;?>><?php echo CHtml::link("<span class='glyphicon glyphicon-chevron-right'></span>", array('contest/updateContestProblem', 'id'=>$model->id, 'page'=>$pagination->pageCount-1), array('onclick'=>'return confirm("Pastikan anda sudah mensave soal!")'))?></li>
</ul>

<div class="clear"></div>

<?php echo CHtml::endForm(); ?>

<br><br>

