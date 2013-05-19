<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="">
	<meta name="author" content="telemedellin.tv">

	<meta name="viewport" content="width=device-width">

	<!--<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css">-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link href='http://fonts.googleapis.com/css?family=Gochi+Hand' rel='stylesheet' type='text/css'>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<header>
	<div id="header-content">
		<div id="logo"><?php echo CHtml::link( CHtml::encode('Viaja a Suiza con Medellín 2018'), array('/') ); ?></div>
		<div id="mainmenu">
			<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'¿Cómo jugar?', 'url'=>array('/como-jugar'), 'linkOptions' => array('class' => 'item1')),
					array('label'=>'¿Qué te puedes ganar?', 'url'=>array('/premio'), 'linkOptions' => array('class' => 'item1')),
					array('label'=>'Así van los puntajes', 'url'=>array('/puntajes'), 'linkOptions' => array('class' => 'item1')),
				),
			)); ?>
		</div>
		<div id="share">
			<ul>
				<li><div class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-action="recommend"></div></li>
				<li><a href="https://twitter.com/share" class="twitter-share-button" data-text="Estoy concursando por un viaje a Suiza con @Medellin2018yog ¡y tú también puedes participar!" data-hashtags="Medellìn2018" data-dnt="true">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li>
			</ul>
		</div>
		<div id="usermenu">
			<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'Comienza a jugar', 'url'=>array('/jugar'), 'linkOptions' => array('class' => 'perfil')),
					array('label'=>'Perfil', 'url'=>array('/perfil'), 'linkOptions' => array('class' => 'sesion'), 'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'Salir', 'url'=>array('/cerrar-sesion'), 'linkOptions' => array('class' => 'sesion'), 'visible'=>!Yii::app()->user->isGuest),
				),
			)); ?>
		</div>
	</div>
</header>
<div class="container" id="page">
	<?php echo $content; ?>
	<div class="clear"></div>
</div>
<footer>
	<div id="footer-content">
	<ul>
		<li><a class="tm" href="http://www.telemedellin.tv" target="_blank">Telemedellín</a></li>
		<li><a class="ol" href="http://www.medellin2018.org" target="_blank">Olímpicos</a></li>
		<li><a class="al" href="http://www.medellin.gov.co" target="_blank">Alcaldía</a></li>
	</ul>
	<?php echo CHtml::link( 'Términos y condiciones', array('/terminos-y-condiciones'), array('class' => 'terminos' ) ); ?>
	</div>
</footer>
</body>
</html>
