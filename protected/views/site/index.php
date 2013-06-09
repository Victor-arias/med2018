<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>
<div id="content">
	<div id="intro-home">
		<p>¡Tú podrás ser uno de los niños que viaje hasta Suiza para conocer si la ciudad será la sede de los Juegos Olímpicos de la juventud Medellín 2018!  Gracias a la Alcaldía de Medellín,  la candidatura de los Juegos, la Secretaría de educación, Telemedellín y este entretenido juego.</p>
	</div>
	<div id="left-content">
		<p class="titulo-video">En este video puedes ver cómo ser uno de los ganadores</p>

		<iframe width="560" height="315" src="http://www.youtube.com/embed/ZE7CZzmlb1s?rel=0" frameborder="0" allowfullscreen></iframe>
	</div>
	<div id="right-content">
		<ul>
			<!--<li>
				<?php //echo CHtml::link('<span class="resaltado">Regístrate</span> y empieza a jugar', array('registro'), array('class' => 'registrate') )?>
			</li>-->
			<li>
				<?php echo CHtml::link('¡Estamos verificando <span class="resaltado">los resultados!</span>', array('/puntajes'), array('class' => 'juega'))?>
			</li>
		</ul>
	</div>
</div>