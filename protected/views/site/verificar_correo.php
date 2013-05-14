<?php
	echo 'Hola ' . $datos['nombre'] . 
	'<br> por favor confirma que te has registrado en el concurso _____________ haciendo clic en este enlace 
    <a href="' . $this->createUrl('site/verificar', array('llave_activacion' => $datos['llave_activacion'])) . '">Verificar correo</a>';
?>