<?php
Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/i18n/jquery.ui.datepicker-es.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerScript('datepicker', 
	'$(".datepicker").datepicker({dateFormat: "yy-mm-dd", yearRange: "1998:2003", minDate: new Date(1998, 5, 1), maxDate: new Date(2003, 5, 31), changeMonth: true, changeYear: true}, $.datepicker.regional[ "es" ]);', 
	CClientScript::POS_READY);
?>

<h1>Registro</h1>

<div class="form">
<?php 
$activeform = $this->beginWidget('CActiveForm', array(
	'id'=>'registro-form',
	'enableAjaxValidation'=>true,
	'focus'=>array($usuario,'correo'),
));
?>

<p class="note">Para participar debes llenar el siguiente formulario con todos tus datos, además, debes contar con la aprobación de un adulto responsable, que puede ser tu papá o tu mamá</p>

<?php echo $activeform->errorSummary(array($usuario, $jugador)); ?>

<p>Datos de acceso</p>
<p>Recuerda muy bien estos datos, porque los necesitarás para poder comenzar a jugar</p>

<div class="row">
	<?php echo $activeform->labelEx($usuario,'correo'); ?>
	<?php echo $activeform->emailField($usuario,'correo',array('size'=>60, 'maxlength'=>100)); ?> 
</div>

<div class="row">
	<?php echo $activeform->labelEx($usuario,'password'); ?>
	<?php echo $activeform->passwordField($usuario,'password',array('size'=>60,'maxlength'=>255)); ?> 
</div>
<div class="row">
		<?php echo $activeform->labelEx($jugador,'nombre'); ?>
		<?php echo $activeform->textField($jugador,'nombre',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $activeform->error($jugador,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $activeform->labelEx($jugador,'documento'); ?>
		<?php echo $activeform->textField($jugador,'documento',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $activeform->error($jugador,'documento'); ?>
	</div>

	<div class="row">
		<?php echo $activeform->labelEx($jugador,'fecha_nacimiento'); ?>
		<?php echo $activeform->textField($jugador,'fecha_nacimiento', array('class' => 'datepicker')); ?>
		<?php echo $activeform->error($jugador,'fecha_nacimiento'); ?>
	</div>
	<div class="row">
		<?php echo $activeform->labelEx($jugador,'colegio'); ?>
		<?php echo $activeform->textField($jugador,'colegio', array('size'=>45,'maxlength'=>255)); ?>
		<?php echo $activeform->error($jugador,'colegio'); ?>
	</div>
	<div class="row">
		<?php echo $activeform->labelEx($jugador,'sexo'); ?>
		<?php echo $activeform->radioButtonList($jugador,'sexo', array('M' => 'Niño', 'F' => 'Niña')); ?>
		<?php echo $activeform->error($jugador,'sexo'); ?>
	</div>

	<p>Información del adulto responsable</p>
	<p>Ingresa estos datos con mucho cuidado, porque serán utilizados si resultas ganador</p>

	<div class="row">
		<?php echo $activeform->labelEx($jugador,'nombre_adulto'); ?>
		<?php echo $activeform->textField($jugador,'nombre_adulto',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $activeform->error($jugador,'nombre_adulto'); ?>
	</div>

	<div class="row">
		<?php echo $activeform->labelEx($jugador,'documento_adulto'); ?>
		<?php echo $activeform->textField($jugador,'documento_adulto',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $activeform->error($jugador,'documento_adulto'); ?>
	</div>

	<div class="row">
		<?php echo $activeform->labelEx($jugador,'parentesco_id'); ?>
		<?php echo $activeform->dropDownList($jugador,'parentesco_id', CHtml::listData(Parentesco::model()->findAll(), 'id', 'nombre')/*, array('empty'=>'select Type')*/); ?>
		<?php echo $activeform->error($jugador,'parentesco_id'); ?>
	</div>

	<div class="row">
		<?php echo $activeform->labelEx($jugador,'correo_adulto'); ?>
		<?php echo $activeform->emailField($jugador,'correo_adulto',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $activeform->error($jugador,'correo_adulto'); ?>
	</div>

	<div class="row">
		<?php echo $activeform->labelEx($jugador,'telefono'); ?>
		<?php echo $activeform->textField($jugador,'telefono',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $activeform->error($jugador,'telefono'); ?>
	</div>

	<div class="row buttons submit">
		<?php echo CHtml::submitButton('Registro', array('class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
