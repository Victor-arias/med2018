<?php
/* @var $this SiteController */
$this->pageTitle = 'Ranking - '.Yii::app()->name;
?>
<div id="ranking">
	<?php if( Yii::app()->user->hasFlash('error') ):?>
		<div><?php echo Yii::app()->user->getFlash('error'); ?></div>
	<?php endif;?>
	<div id="ninos">
		<h2>Niños</h2>
		<ul>
		<?php foreach($ranking['ninos'] as $nino): ?>
			<li><?php echo $nino->nombre ?> <?php echo $nino->puntaje ?></li>
		<?php endforeach; ?>
		</ul>
	</div>
	<div id="ninas">
		<h2>Niñas</h2>
		<ul>
		<?php foreach($ranking['ninas'] as $nina): ?>
			<li><?php echo $nina->nombre ?> <?php echo $nina->puntaje ?></li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>