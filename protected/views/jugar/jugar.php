<?php
/* @var $this JuugarController */
Yii::app()->clientScript->registerCoreScript('jquery'); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/juego.js', CClientScript::POS_HEAD);
?>
<p id="estado">
	Nivel <span id="nivel">1</span> - Pregunta <span id="numero_pregunta">1</span> - <span id="puntos">0</span> puntos
</p>
<div id="mensaje">
	<p></p>
	<a href="#"></a>
</div>
<div id="pregunta">
	<p>Tiempo <span id="tiempo"></span></p>
	<p id="p"></p>
	<a href="#" id="ra"></a>
	<a href="#" id="rb"></a>
	<a href="#" id="rc"></a>
	<a href="#" id="rd"></a>
</div>
<div id="sidebar">
	<p>Puntaje general <span id="total_puntos">0</span></p>
	<p>Ayudas</p>
	<p></p>
</div>