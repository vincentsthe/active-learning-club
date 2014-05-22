<?php
	/* @var $this Controller */
	/* @var $active string */
?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="col-md-3 sidebar">
	<div class="panel panel-primary">
		<div class="panel-heading">
			Menu Super Admin
		</div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				<li <?php if(isset($this->active) &&  $this->active == "index"):?>class="active"<?php endif;?>><?php echo CHtml::link("Daftar User", array('user/index'))?></li>
				<li <?php if(isset($this->active) &&  $this->active == "create"):?>class="active"<?php endif;?>><?php echo CHtml::link("Buat User Baru", array('user/create'))?></li>
			</ul>
		</div>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			Menu Admin
		</div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				<li <?php if(isset($this->active) && $this->active == "index"):?>class="active"<?php endif;?>><?php echo CHtml::link("Daftar Kontes", array('contest/index'))?></li>
				<li <?php if(isset($this->active) && $this->active == "create"):?>class="active"<?php endif;?>><?php echo CHtml::link("Buat Kontes Baru", array('contest/create'))?></li>
				
			</ul>
		</div>
	</div>
</div>
<div class="col-md-9 main-content">
	<?php echo $content;?>
</div>

<?php $this->endContent();?>