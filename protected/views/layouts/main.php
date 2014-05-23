<?php /* @var $this Controller */ ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	
	<!-- Bootstrap Stylesheet -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-theme.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.min.css">
	
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
	
	<!-- Javascript -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascripts/jquery.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascripts/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascripts/jquery-ui.min.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<!-- Header -->
	<div class="header container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-xs-1">
					<!--img src="<?php echo Yii::app()->request->baseUrl; ?>/images/Banner.png" height="130px"-->
				</div>
				<div class="col-xs-10">
					<h3>ALC Learning Center</h3>
					<h5>Tempat berlatih menghadapi OSN</h5>
				</div>
				
			</div>
		</div>
	</div>
	<div class="navbar navbar-inverse" style="padding:0px;margin-bottom: 0px;">
		<div class="container navbar-menu">
			<ul class="nav navbar-nav">
				<li <?php if(isset($this->topBarActive) && $this->topBarActive=="home"):?>class="active" <?php endif;?> >
				<?php
					if (Yii::app()->user->isGuest)
						echo CHtml::link("Home", array('site/index'));
					else
						echo CHtml::link("Home", array('contest/index'));
				?>
				</li>
				<li <?php if(isset($this->topBarActive) && $this->topBarActive=="about"):?>class="active"<?php endif;?>><?php echo CHtml::link("About Us", array('site/page','view'=>'about'))?></li>
				<li <?php if(isset($this->topBarActive) && $this->topBarActive=="contact"):?>class="active"<?php endif;?>><?php echo CHtml::link("Kontak", array('site/page','view'=>'contact'))?></li>
				<li <?php if(isset($this->topBarActive) && $this->topBarActive=="image"):?>class="active"<?php endif;?>><?php echo CHtml::link("Image", array('image/index'))?></li>
				<li <?php if(isset($this->topBarActive) && $this->topBarActive=="career"):?>class="active"<?php endif;?>><?php echo CHtml::link("Karir", array('site/page','view'=>'career'))?></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php if(!Yii::app()->user->isGuest):?>
					<li><a><?php echo Yii::app()->user->name;?>, </a></li>
					<li><?php echo CHtml::link("Logout", array('site/logout'))?></li>
				<?php endif; ?>
			</ul>
		</div>
	</div>

	<div class="container content">
		<?php echo $content; ?>
	</div>

	<div class="clear"></div>

	<div class="modal-footer footer">
		<div class="container">
				&#169 2014 ALC Indonesia<br>
			Designed with bootstrap. Powered by Yii framework
		</div>
	</div><!-- footer -->

</body>
</html>