<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle= 'Iniciar sesión - ' .Yii::app()->name;
?>

<h1>Iniciar sesión</h1>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->label($model,'correo'); ?>
		<?php echo $form->emailField($model,'correo'); ?>
		<?php echo $form->error($model,'correo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Iniciar sesión'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<div id="right-content">
	<?php echo CHtml::link('<span class="resaltado">Regístrate</span> y empieza a jugar', array('registro'), array('class' => 'registrate') )?>
</div>