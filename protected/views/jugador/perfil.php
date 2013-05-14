<?php
/* @var $this JugadorController */
?>
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
<p>Teléfono celular: <?php echo $jugador->celular ?></p>
<p>Dirección: <?php echo $jugador->direccion ?></p>

