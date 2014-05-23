<?php
	$this->beginContent('//layouts/contestLayout');

?>
<ul class="nav nav-pills nav-stacked">
	<li <?php if(isset($this->active) &&  $this->active == "index"):?>class="active"<?php endif;?>><?php echo CHtml::link("Daftar User", array('user/index'))?></li>
	<li <?php if(isset($this->active) &&  $this->active == "create"):?>class="active"<?php endif;?>><?php echo CHtml::link("Buat User Baru", array('user/create'))?></li>
</ul>