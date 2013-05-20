<?php
/* @var $this JuugarController */
Yii::app()->clientScript->registerCoreScript('jquery'); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/storage.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/juego.js', CClientScript::POS_HEAD);
?>
<p id="estado">
	<span class="nivel">Nivel <span id="nivel">2</span> </span> <span class="pregunta">Pregunta <span id="numero_pregunta">5</span></span> <span id="puntos">40</span> <span class="puntos">puntos</span>
</p>
<p class="puntaje-general">Puntaje general </br><span id="total_puntos">11450</span></p>
<div id="mensaje">
	<p></p>
	<a href="#" class=""></a>
</div>
<div id="pregunta">
	<p class="tiempo">Tiempo <span id="tiempo"></span></p>
	<p id="p"></p>
	<a href="#" id="ra"></a>
	<a href="#" id="rb"></a>
	<a href="#" id="rc"></a>
	<a href="#" id="rd"></a>
</div>
<div id="sidebar">
	<p>Ayudas</p>
	<p></p>
</div>