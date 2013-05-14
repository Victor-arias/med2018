<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="author" content="telemedellin.tv">

	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css">

	<!-- blueprint CSS framework 
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />-->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<header>
		<div id="logo"><?php echo CHTML::link( CHtml::encode(Yii::app()->name), array('/') ); ?></div>
	</header>

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Cómo participar', 'url'=>array('/site/page', 'view'=>'instrucciones')),
				array('label'=>'Qué incluye el premio', 'url'=>array('/site/page', 'view'=>'premio')),
				array('label'=>'Así van los puntajes', 'url'=>array('/site/puntajes')),
			),
		)); ?>
	</div><!-- mainmenu -->
	<div id="usermenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Perfil', 'url'=>array('/jugador'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Cerrar sesion', 'url'=>array('/cerrar-sesion'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Iniciar sesion', 'url'=>array('/iniciar-sesion'), 'visible'=>Yii::app()->user->isGuest),
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php echo $content; ?>

	<div class="clear"></div>

	<footer>
		<ul>
			<li><a href="http://www.telemedellin.tv" target="_blank">Telemedellín</a></li>
			<li><a href="http://www.medellin2018.org" target="_blank">Olímpicos</a></li>
			<li><a href="http://www.telemedellin.tv" target="_blank">Secretaría de educación</a></li>
			<li><a href="http://www.medellin.gov.co" target="_blank">Alcaldía</a></li>
		</ul>
		<?php echo CHTML::link( 'Términos y condiciones', array('/site/page', 'view' => 'terminos-y-condiciones'), array('class' => 'terminos' ) ); ?>
	</footer>

</div><!-- page -->

</body>
</html>
