<?php
/* @var $this ContestController */
/* @var $model Contest */
/* @var $form CActiveForm */
/* WARNING : pastikan filter['xxx']  xxx sesuai nama attribut database */
?>
<?php echo CHtml::beginForm(); ?>
<div class="col-xs-12">
	<div class="col-xs-4">
		<?php
			echo "<b>Bidang:</b><br>";
			$listBidang[0] = 'semua'; //tambahan
			echo CHtml::dropDownList('filter[bidang]',isset($filter['bidang'])?$filter['bidang']:0,$listBidang,array('class'=>'form-control'));
		?>
	</div>
	<div class="col-xs-4">
		<?php echo "<b>Judul:</b>"; ?>
		<?php echo CHtml::textField("filter[title]",(isset($filter['title']))?$filter['title']:'',array('class'=>'form-control')); ?>
			<br>		
	</div>
	<div class="col-xs-4">
		<br>
		<?php echo CHtml::submitButton("Cari",array('class'=>'btn btn-primary')); ?>	
	</div>
<?php echo CHtml::endForm(); ?>

</div>
<div class="clearfix"> </div><!-- search-form -->