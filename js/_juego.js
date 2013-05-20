$(function() {
	var situacion 	= 0;
	var nivel		= 1;
	var puntosr		= 0;
	var puntost		= 0;
	var preguntan	= 0;
	var tiempo		= 10;

	var Timer;
	var TotalSeconds;
	var TimeO;

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
	$(document).on('click', '.mb-cp', cargar_pregunta);
	$(document).on('click', '#pregunta a', responder);

	//0 Obtengo el token de control
	$.post('jugar/control', get_control);

	//Funciones
	function actualizar_datos()
	{
		$('#nivel').text(nivel);
		$('#numero_pregunta').text(preguntan);
		$('#puntos').text(puntosr);
		$('#total_puntos').text(puntost);
	}//actualizar_datos
	function cargar_pregunta(e)
	{
		$.post('jugar/cargarpregunta', mostrar_pregunta);
		e.preventDefault();
	}//cargar_pregunta

	function error()
	{
		
	}

	function get_control(data)
	{
		situacion = data.s;
		nivel	  = data.n;
		preguntan = data.pn;
		puntosr	  = data.pr;
		puntost	  = data.pt;
		tiempo	  = parseInt(data.t);
		//1. Inicializo el juego
		inicializar();
	}//get_control

	function inicializar()
	{
		actualizar_datos();
		switch(situacion)
		{
			case 1://inicio
				mostrar_mensaje(1);
				break;
			case 2:
				cargar_pregunta();
				break;
			case 3:
				mostrar_mensaje(3);
				break;
			case 4:
				mostrar_mensaje(4);
				break;
			case 5:
				mostrar_mensaje(5);
				break;
			case 6:
				mostrar_mensaje(6);
				break;
			case 7:
				mostrar_mensaje(7);
				break;
		}//switch situacion

	}//inicializar

	
	function mostrar_mensaje(caso)
	{
		//1 Oculto la pregunta y dejo las opciones vacías por si las moscas
		ocultar_pregunta();
		//2. Verifico el caso para definir como setear el mensaje
		switch(caso)
		{
			case 1://inicio
				mp.html('<p>Para poder iniciar el juego necesitas recordar esto:</p><ul><li>Tienes solo dos oportunidades para jugar diariamente.</li><li>Acumulas puntos por cada respuesta correcta que tengas.</li><li>Las preguntas son sobre: Medellín, los deportes de los Juegos Olímpicos Juveniles y la importancia de la convivencia.</li><!--<li>Si la pregunta está muy difícil puedes utilizar 3 ayudas: cambiar la pregunta, pedir 10 segundos más para responderla o eliminar dos de las posibles respuestas.</li>--><li>El tiempo de la primera pregunta empieza a correr cuando presiones el botón “jugar”.</li></ul>');
				mb.text('Jugar');
				mb.addClass('mb-cp');
				break;
			case 3: //correcto
				mp.text('Respuesta correcta');
				mb.text('Ir a la siguiente pregunta');
				mb.addClass('mb-cp');
				break;
			case 4: //incorrecto
				mp.text('Respuesta equivocada');
				mb.text('Salir del juego');
				mb.attr('href', 'puntajes');
				break;
			case 5:
				mp.text('Respuesta correcta, avanzas al siguiente nivel');
				mb.text('Ir a la pregunta del siguiente nivel');
				mb.addClass('mb-cp');
				break;
			case 6:
				mp.text('Has terminado esta ronda');
				mb.text('Ver la tabla de puntajes');
				mb.attr('href', 'puntajes').removeAttr('class');
				break;
			case 7:
				mp.text('Se agotó el tiempo, ha finalizado esta ronda');
				mb.text('Ver la tabla de puntajes');
				mb.attr('href', 'puntajes').removeAttr('class');
				break;
		}//switch situacion

		mensaje.show('slow');

	}//mostrar_mensaje

	function mostrar_pregunta(data) {
		if(!data.s){

			if(data.pregunta && data.respuestas)
			{
				tiempo = parseInt(data.t);
				tmp_pregunta 	= data.pregunta;
				tmp_respuestas 	= data.respuestas.sort(function() {return 0.5 - Math.random()});
				
				p.text(tmp_pregunta.pregunta);
				ra.text(tmp_respuestas[0].respuesta).addClass(tmp_respuestas[0].id);
				rb.text(tmp_respuestas[1].respuesta).addClass(tmp_respuestas[1].id);
				rc.text(tmp_respuestas[2].respuesta).addClass(tmp_respuestas[2].id);
				rd.text(tmp_respuestas[3].respuesta).addClass(tmp_respuestas[3].id);

				ocultar_mensaje();
				preguntan = data.pn;
				$('#numero_pregunta').text(preguntan);
				dpregunta.show('fast');
				if( localStorage.getItem('t') == null )
				{
					CreateTimer('tiempo', tiempo);	
				}
				else
				{
					CreateTimer('tiempo', localStorage.getItem('t'));	
				}
				
			}
			else
			{
				inicializar();
			}

		}
		else
		{
			situacion = data.s;
			inicializar();
		}//data.s
	}//mostrar_pregunta

	function mostrar_respuesta(data)
	{
		situacion = data.s;
		nivel	  = data.n;
		preguntan = data.pn;
		puntosr	  = data.pr;
		puntost	  = data.pt;
		inicializar();
	}//mostrar_respuesta

	function ocultar_mensaje()
	{
		mensaje.hide();
		mp.empty();
		mb.empty().attr('href', '#').removeClass();
	}//ocultar_mensaje

	function ocultar_pregunta()
	{
		dpregunta.hide();
		p.empty();
		ra.empty().removeAttr('class');
		rb.empty().removeAttr('class');
		rc.empty().removeAttr('class');
		rd.empty().removeAttr('class');
	}//ocultar_pregunta

	function responder(e)
	{
		var id = e.target.id;
		var respuesta_id = $('#'+id).attr('class');
		$.post('jugar/responder', {r: respuesta_id, t: TotalSeconds}, mostrar_respuesta);
		localStorage.removeItem('t');
		clearTimeout(TimeO);
		ra.text('').removeAttr('class');
		rb.text('').removeAttr('class');
		rc.text('').removeAttr('class');
		rd.text('').removeAttr('class');
		e.preventDefault();
	}//responder

	/*******CONTADOR**********/

	function CreateTimer(TimerID, Time) {
		Timer = document.getElementById(TimerID);
		TotalSeconds = Time;
		UpdateTimer();
		TimeO = setTimeout(Tick, 1000);
	}

	function Tick() {
		if (TotalSeconds <= 0) {
			localStorage.removeItem('t');
			$.post('jugar/tiempo', get_control);
			ra.text('').removeAttr('class');
			rb.text('').removeAttr('class');
			rc.text('').removeAttr('class');
			rd.text('').removeAttr('class');
			//pilas
			return;
		}

		TotalSeconds -= 1;
		UpdateTimer();
		TimeO = setTimeout(Tick, 1000);
	}

	function UpdateTimer() {
		localStorage.setItem('t', TotalSeconds);
		var Seconds = TotalSeconds;
		var TimeStr = LeadingZero(Seconds);
		Timer.innerHTML = TimeStr + ' segundos';
	}

	function LeadingZero(Time) {
		return (Time < 10) ? "0" + Time : + Time;
	}
	

});