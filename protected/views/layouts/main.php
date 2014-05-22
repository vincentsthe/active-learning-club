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
		<div class="branding">
			<div class="row">
				<div class="col-md-2">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/Banner.png" height="130px">
				</div>
				<h1 class="col-md-10">ALC Indonesia</h1>
				<h2 class="col-md-10">Active Learning Club Indonesia</h2>
			</div>
		</div>
	</div>
	<div class="navbar navbar-inverse" style="padding:0px;margin-bottom: 0px;">
		<div class="container navbar-menu">
			<ul class="nav navbar-nav">
				<?php if((!Yii::app()->user->isGuest) && (Yii::app()->user->name == 'admin')): ?>
					<li <?php if(isset($this->mainLayoutActive) && $this->mainLayoutActive=="admin"):?>class="active"<?php endif;?>><?php echo CHtml::link("Admin", array('admin/index'))?></li>
				<?php endif;?>
				<li <?php if(isset($this->mainLayoutActive) && $this->mainLayoutActive=="contest"):?>class="active"<?php endif;?>><?php echo CHtml::link("Kontes", array('contest/index'))?></li>
				<li <?php if(isset($this->mainLayoutActive) && $this->mainLayoutActive=="user"):?>class="active"<?php endif;?>><?php echo CHtml::link("User", array('user/index'))?></li>
				<li <?php if(isset($this->mainLayoutActive) && $this->mainLayoutActive=="image"):?>class="active"<?php endif;?>><?php echo CHtml::link("Image", array('image/index'))?></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php if(!Yii::app()->user->isGuest):?>
					<li><a><?php echo Yii::app()->user->name;?>, </a></li>
					<li><?php echo CHtml::link("Logout", array('site/logout'))?></li>
				<?php else:?>
					<form>
						<input type="text" class="form-control">
					</form>
				<?php endif;?>
			</ul>
		</div>
	</div>

	<div class="container content">
		<?php echo $content; ?>
	</div>

	<div class="clear"></div>

	<div class="modal-footer footer">
		<div class="container">
			<h4>&#169 2014 ALC Indonesia</h4>
		</div>
	</div><!-- footer -->

</body>
</html>