<?php
/* @var $this ImageController */
/* @var $data Image */
?>

<div class="col-md-3" style="margin-bottom: 10px;">
	<div class="box">
		<a href="?renderImage=<?php echo $data->token; ?>"  data-lightbox="image-<?php echo $data->token; ?>" data-title='link untuk src image: "?renderImage=<?php echo $data->token; ?>"'>
			<img src="?renderImage=<?php echo $data->token; ?>" style="width:100%">
		</a>
		<div class="text-center">"<?php echo $data->name; ?>"</div>
		<div class="text-center"><?php echo CHtml::link('Remove', array('image/delete', 'id'=>$data->id), array('onclick'=>"return confirm('Yakin ingin menghapus gambar ini?')")); ?></div>
	</div>
</div>