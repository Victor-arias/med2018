<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<p>LA ALCALDÍA DE MEDELLÍN, LA CANDIDATURA DE LOS JUEGOS OLÍMPICOS MEDELLÍN 2018, LA SECRETARÍA DE EDUCACIÓN Y TELEMEDELLÍN, LLEVARÁN UN NINO Y UNA NINA A SUIZA A CONOCER SI LA CIUDAD SERÁ LA SEDE DE ESTE IMPORTANTE EVENTO PARA COLOMBIA Y ¡TÚ PODRÁS SER UNO DE ELLOS!</p>

<p>MIRA ESTE VIDEO Y ENTERATE CÓMO PUEDES SER UNO DE LOS GANADORES</p>

<iframe width="560" height="315" src="http://www.youtube.com/embed/yDJos8Kfank?rel=0" frameborder="0" allowfullscreen></iframe>

<p><?php echo CHtml::link('Regístrate para comenzar', array('registro'))?></p>
<p><?php echo CHtml::link('Si ya estás registrado, ¡Comienza a jugar!', array('/jugar'))?></p>