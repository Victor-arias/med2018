$(function() {
	var pregunta	= 0;
	var nivel		= 0;
	var estado 		= $('#estado');
	var dpregunta 	= $('#pregunta');

	var p  = $('#p');
	var ra = $('#ra');
	var rb = $('#rb');
	var rc = $('#rc');
	var rd = $('#rd');

	var mensaje = $('#mensaje');
	var mp 		= $('#mensaje p');
	var mb 		= $('#mensaje a');

	//Eventos
	$('.mb-cpu').on('click', cargar_pregunta);
	$('#pregunta a').on('click', responder);

	//0 Obtengo el token de control
	$.post('jugar/control', get_control);

	//Funciones
	function cargar_pregunta(event)
	{
		console.log('cargar_pregunta ' )
		//$.post('jugar/cargarpregunta', {p: pregunta, n: nivel}, mostrar_pregunta);
	}//cargar_pregunta

	function get_control(data)
	{
		console.log('control ' + data.n);
		nivel 		= data.n;
		pregunta 	= data.p;

		//1. Inicializo el juego
		inicializar();
	}//get_control

	function inicializar()
	{
		
		//1 Oculto la pregunta y dejo las opciones vacías por si las moscas
		ocultar_pregunta();
		
		//2 Muestro el mensaje seteado al inicio del juego
		if(pregunta == 1 && nivel == 1) var situacion = 'inicio';
		mostrar_mensaje(situacion);

	}//inicializar

	function mostrar_mensaje(situacion)
	{
		//1. Verifico la situación para definir como setear el mensaje
		switch(situacion)
		{
			case 'inicio':
				console.log('situacion: inicio');
				mp.text('inicio');
				mb.text('Ir a la primer pregunta');
				mb.addClass('mb-cpu');
				break;
			case 'correcto':
				console.log('situacion: correcto');
				break;
			case 'fallo':
				console.log('situacion: fallo');
				break;
			case 'nivel':
				console.log('situacion: nivel');
				break;
			case 'fin':
				console.log('situacion: fin');
				break;
		}//switch situacion

		mensaje.show('slow');

	}//mostrar_mensaje

	function mostrar_pregunta(data) {
	  console.log('Mostrar pregunta ');
	  console.log(data);
	  if(data['pregunta'] && data['respuestas'])
	  {
	  	tmp_pregunta 	= data['pregunta'];
	  	tmp_respuestas 	= data['respuestas'].sort(function() {return 0.5 - Math.random()});
	  	
	  	p.text(tmp_pregunta.pregunta);
	  	ra.text(tmp_respuestas[0].respuesta).addClass(tmp_respuestas[0].id);
	  	rb.text(tmp_respuestas[1].respuesta).addClass(tmp_respuestas[1].id);
	  	rc.text(tmp_respuestas[2].respuesta).addClass(tmp_respuestas[2].id);
	  	rd.text(tmp_respuestas[3].respuesta).addClass(tmp_respuestas[3].id);

	  	ocultar_mensaje();
	  	dpregunta.show('fast');
	  }
	  else
	  {
	  	console.log('nanai');
	  }
	}//mostrar_pregunta

	function ocultar_mensaje()
	{
		mensaje.hide();
		mp.empty();
		mb.empty().removeClass();
	}//ocultar_mensaje

	function ocultar_pregunta()
	{
		dpregunta.hide();
		p.empty();
		ra.empty();
		rb.empty();
		rc.empty();
		rd.empty();
	}//ocultar_pregunta

	function responder(event)
	{
		var id = event.target.id;
		var respuesta_id = $(id).attr('class');
		$.post('jugar/responder', {r: respuesta_id, p: pregunta, n: nivel}, mostrar_respuesta);
	}//responder
});