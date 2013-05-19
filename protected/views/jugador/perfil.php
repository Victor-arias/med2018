<?php
/* @var $this JugadorController */
?>
<p>Aquí podrás cambiar algunos de los datos con los que te registraste</p>

<p>Datos de acceso</p>
<p>Correo: <?php echo $jugador->usuario->correo ?></p>

<p>Datos personales</p>
<p><?php echo $jugador->nombre ?></p>
<p>Tarjeta de identidad número: <?php echo $jugador->documento ?></p>
<p>Edad: <?php echo $jugador->edad ?> años</p>
<p>Niñ<?php echo ($jugador->sexo == 'M')? 'o': 'a'; ?></p>
<p>Colegio: <?php echo $jugador->colegio ?></p>

<p>Información del adulto responsable</p>
<p>Nombre: <?php echo $jugador->nombre_adulto ?></p>
<p>Parentesco: <?php echo $jugador->parentesco->nombre ?></p>
<p>Correo: <?php echo $jugador->correo_adulto ?></p>
<p>Documento: <?php echo $jugador->documento_adulto ?></p>
<p>Teléfono fijo: <?php echo $jugador->telefono ?></p>

<p>
<?php echo CHtml::link( '¿Listo para ser uno de los niños que irá a Suiza? ¡Vamos a jugar!', array('/jugar'), array('class' => 'btn-jugar' ) ); ?>
</p>

<p>Estadísticas</p>
<p>Posición general </p>
<p>Puntaje total <?php echo $jugador->puntaje ?></p>
<p>Rondas jugadas <?php echo $estadisticas['rondas'] ?></p>
<p>Tiempo total de juego <?php echo $estadisticas['tiempo'] ?> horas</p>
<p>Total de preguntas resueltas <?php echo $estadisticas['preguntas'] ?></p>

<p>Fecha última ronda <?php echo $estadisticas['fecha_ultima'] ?></p>
<p>Puntaje última ronda <?php echo $estadisticas['puntos_ultima'] ?></p>
<p>Tiempo última ronda <?php echo $estadisticas['tiempo_ultima'] ?> minutos</p>
<p>Preguntas resueltas última ronda <?php echo $estadisticas['preguntas_ultima'] ?></p>
