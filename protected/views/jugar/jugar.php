<?php
/* @var $this JuugarController */
Yii::app()->clientScript->registerCoreScript('jquery'); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/juego.js', CClientScript::POS_HEAD);
?>
<p id="estado">
	Nivel <span id="nivel">1</span> - <span id="numero_pregunta">1</span> de 4 preguntas - <span id="puntos">10</span> puntos
</p>
<div id="mensaje">
	<p>Mensaje</p>
	<a href="#">Botón</a>
</div>
<div id="pregunta">
	<p>Tiempo <span id="tiempo"></span></p>
	<p id="p">Pregunta</p>
	<a href="#" id="ra">Respuesta 1</a>
	<a href="#" id="rb">Respuesta 2</a>
	<a href="#" id="rc">Respuesta 3</a>
	<a href="#" id="rd">Respuesta 4</a>
</div>