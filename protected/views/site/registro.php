<?php
Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/i18n/jquery.ui.datepicker-es.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerScript('datepicker', 
	'$(".datepicker").datepicker({dateFormat: "yy-mm-dd", yearRange: "1999:2003", minDate: new Date(1999, 4, 21), maxDate: new Date(2003, 5, 11), changeMonth: true, changeYear: true}, $.datepicker.regional[ "es" ]);', 
	CClientScript::POS_READY);
?>
<div id="content">
	<div id="titulo-registro">
		<h1>Registro</h1>
		<p class="note">Para participar debes llenar el siguiente formulario con todos tus datos, y contar con el permiso de un adulto responsable que puede ser tu papá o tu mamá</p>
	</div>

	<div class="form">
	<?php 
	$activeform = $this->beginWidget('CActiveForm', array(
		'id'=>'registro-form',
		'enableAjaxValidation'=>true,
		'focus'=>array($usuario,'correo'),
	));
	?>
	<?php echo $activeform->errorSummary(array($usuario, $jugador), '', '', array('class' => 'flash-notice')); ?>

	<div id="subtitulo">
		<h2>Datos de acceso</h2>
		<p>Recuerda muy bien estos datos, porque los necesitarás para poder comenzar a jugar</p>
	</div>

	<div class="row">
		<?php echo $activeform->label($usuario,'correo'); ?>
		<?php echo $activeform->emailField($usuario,'correo',array('size'=>60, 'maxlength'=>100)); ?> 
	</div>

	<div class="row">
		<?php echo $activeform->label($usuario,'password', array('label' => 'Contraseña <small> diferente a la de tu correo</small>') ); ?>
		<?php echo $activeform->passwordField($usuario,'password',array('size'=>60,'maxlength'=>255)); ?> 
	</div>
	<div id="subtitulo">
		<h2>Datos personales</h2>
		<p>Estos son los datos que vamos a usar si resultas ganador, ingrésalos con cuidado</p>
	</div>
	<div class="row">
			<?php echo $activeform->label($jugador,'nombre'); ?>
			<?php echo $activeform->textField($jugador,'nombre',array('size'=>60,'maxlength'=>255)); ?>
		</div>

		<div class="row">
			<?php echo $activeform->label($jugador,'documento'); ?>
			<?php echo $activeform->textField($jugador,'documento',array('size'=>45,'maxlength'=>45)); ?>
		</div>

		<div class="row">
			<?php echo $activeform->label($jugador,'fecha_nacimiento'); ?>
			<?php echo $activeform->textField($jugador,'fecha_nacimiento', array('class' => 'datepicker')); ?>
		</div>
		<div class="row">
			<?php echo $activeform->label($jugador,'colegio'); ?>
			<?php echo $activeform->textField($jugador,'colegio', array('size'=>45,'maxlength'=>255)); ?>
		</div>
		<div class="row">
			<?php echo $activeform->label($jugador,'sexo'); ?>
			<?php echo $activeform->radioButtonList($jugador,'sexo', array('M' => 'Niño', 'F' => 'Niña'), array('labelOptions' => array('class' => 'nino-pic'), 'separator'=>'' ) ); ?>
		</div>

		<div id="subtitulo">
			<h2>Información del adulto responsable</h2>
			<p>Ingresa estos datos con mucho cuidado, porque serán utilizados si resultas ganador</p>
		</div>

		<div class="row">
			<?php echo $activeform->label($jugador,'nombre_adulto'); ?>
			<?php echo $activeform->textField($jugador,'nombre_adulto',array('size'=>60,'maxlength'=>255)); ?>
		</div>

		<div class="row">
			<?php echo $activeform->label($jugador,'documento_adulto'); ?>
			<?php echo $activeform->textField($jugador,'documento_adulto',array('size'=>45,'maxlength'=>45)); ?>
		</div>

		<div class="row">
			<?php echo $activeform->label($jugador,'parentesco_id'); ?>
			<?php echo $activeform->dropDownList($jugador,'parentesco_id', CHtml::listData(Parentesco::model()->findAll(), 'id', 'nombre')/*, array('empty'=>'select Type')*/); ?>
		</div>

		<div class="row">
			<?php echo $activeform->label($jugador,'correo_adulto'); ?>
			<?php echo $activeform->emailField($jugador,'correo_adulto',array('size'=>60,'maxlength'=>100)); ?>
		</div>

		<div class="row">
			<?php echo $activeform->label($jugador,'telefono'); ?>
			<?php echo $activeform->textField($jugador,'telefono',array('size'=>45,'maxlength'=>45)); ?>
		</div>
		<div class="row">
			<p>Antes de registrarte asegúrate de haber leído y estar de acuerdo con los <?php echo CHtml::link('términos y condiciones del concurso', array('/terminos-y-condiciones'), array('target' => '_blank'));?>.</p>
		</div>
		<div class="row buttons submit">
			<?php echo CHtml::submitButton('Registro', array('class'=>'btn')); ?>
		</div>

	<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>
