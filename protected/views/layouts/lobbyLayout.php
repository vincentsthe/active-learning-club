<?php
	/* @var $this Controller */
	/* @var $active string */
?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="col-xs-3 sidebar">
	<!-- Menu admin -->
	<?php if (Yii::app()->user->isAdmin) : ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			Menu Admin
		</div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				<li <?php if(isset($this->active) &&  $this->active == "user/index"):?>class="active"<?php endif;?>><?php echo CHtml::link("Daftar User", array('//admin/user/index'))?></li>
				<li <?php if(isset($this->active) &&  $this->active == "user/create"):?>class="active"<?php endif;?>><?php echo CHtml::link("Buat User Baru", array('//admin/user/create'))?></li>
			</ul>
		</div>
	</div>
	<?php endif; ?>
	<?php if (Yii::app()->user->isAdmin || Yii::app()->user->isTeacher) : ?>
	<!-- Menu guru -->
	<div class="panel panel-primary">
		<div class="panel-heading">
			Menu Teacher
		</div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				<li <?php if(isset($this->active) && $this->active == "contest/index"):?>class="active"<?php endif;?>><?php echo CHtml::link("Atur Kontes", array('teacher/contest/index'))?></li>
				<li <?php if(isset($this->active) && $this->active == "contest/create"):?>class="active"<?php endif;?>><?php echo CHtml::link("Buat Kontes Baru", array('teacher/contest/create'))?></li>
			</ul>
		</div>
	</div>
	<?php endif; ?>
	<!-- Menu peserta -->
	<div class="panel panel-primary">
		<div class="panel-heading">
			Menu Peserta
		</div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				<li <?php if(isset($this->active) && $this->active == "contest/index"):?>class="active"<?php endif;?>><?php echo CHtml::link("Ikuti Kontes", array('contest/index'))?></li>				
			</ul>
		</div>
	</div>
</div>
<div class="col-xs-9 main-content">
	<?php echo $content;?>
</div>

<?php $this->endContent();?>