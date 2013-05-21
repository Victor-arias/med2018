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
	var mp 		= $('#mensaje div');
	var mb 		= $('#mensaje a');

	var erradas = $('.erradas');

	$("#cargando").on("ajaxStart", function(){
	    $(this).show(); // this hace referencia a la div con la imagen.
	}).on("ajaxStop", function(){
	    $(this).hide();
	});

	//Eventos
	$(document).on('click', '.mb-cp', cargar_pregunta);
	$(document).on('click', '#pregunta a', responder);
	$(document).on('click', '.segundos', ayuda_segundos);
	$(document).on('click', '.avanza', ayuda_avanza);
	$(document).on('click', '.erradas', ayuda_erradas);
	$(document).on('click', '.nd', function(e){e.preventDefault()});

	//0 Obtengo el token de control
	control();
	
	//Funciones
	function actualizar_datos()
	{
		$('#nivel').text(nivel);
		$('#numero_pregunta').text(preguntan);
		$('#puntos').text(puntosr);
		$('#total_puntos').text(puntost);
	}//actualizar_datos

	function ayuda_avanza(e)
	{
		$.post('jugar/ayuda', {a:3}, usar_ayuda);
		e.preventDefault();
	}//ayuda_avanza

	function ayuda_erradas(e)
	{
		$.post('jugar/ayuda', {a:2}, usar_ayuda);
		e.preventDefault();
	}//ayuda_erradas

	function ayuda_segundos(e)
	{
		$.post('jugar/ayuda', {a:1}, usar_ayuda);
		e.preventDefault();
	}//ayuda_segundos

	function cargar_pregunta(e)
	{
		$.post('jugar/cargarpregunta', mostrar_pregunta);
		e.preventDefault();
	}//cargar_pregunta

	function control()
	{
		$.post('jugar/control', get_control);
	}

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
		ayudas 	  = data.a;
		setear_ayudas();
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
				mp.html('<h3>Para poder iniciar el juego necesitas recordar esto:</h3><ul><li>Tienes solo dos oportunidades para jugar diariamente.</li><li>Acumulas puntos por cada respuesta correcta que tengas.</li><li>Las preguntas son sobre: Medellín, los deportes de los Juegos Olímpicos Juveniles y la importancia de la convivencia.</li><!--<li>Si la pregunta está muy difícil puedes utilizar 3 ayudas: cambiar la pregunta, pedir 10 segundos más para responderla o eliminar dos de las posibles respuestas.</li>--><li>El tiempo de la primera pregunta empieza a correr cuando presiones el botón “jugar”.</li></ul>');
				mb.text('Jugar');
				mb.addClass('mb-cp');
				break;
			case 3: //correcto
				mp.html('<h3>¡La respuesta es correcta!</h3>');
				mb.text('Ir a la siguiente pregunta');
				mb.addClass('mb-cp');
				break;
			case 4: //incorrecto
				mp.html('<h3>¡Esta no era la respuesta!</h3><p>Ha terminado esta ronda</p>');
				mb.text('Salir de esta ronda');
				mb.attr('href', 'puntajes');
				break;
			case 5:
				mp.html('<h3>¡La respuesta es correcta, además avanzas al siguiente nivel!</h3>');
				mb.text('Ir a la pregunta del siguiente nivel');
				mb.addClass('mb-cp');
				break;
			case 6:
				mp.html('<h3>¡Felicitaciones, has terminado esta ronda!</h3>');
				mb.text('Ver la tabla de puntajes');
				mb.attr('href', 'puntajes').removeAttr('class');
				break;
			case 7:
				mp.html('<h3>Se agotó el tiempo, ha finalizado esta ronda</h3>');
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
				situacion = 2;
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
		ayudas 	  = data.a;
		setear_ayudas();
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
		if( parseInt(respuesta_id) == respuesta_id )
		{
			$.post('jugar/responder', {r: respuesta_id, t: TotalSeconds}, mostrar_respuesta);
			localStorage.removeItem('t');
			clearTimeout(TimeO);
			ra.removeAttr('class');
			rb.removeAttr('class');
			rc.removeAttr('class');
			rd.removeAttr('class');
			$('#'+id).addClass('active');
		}
		e.preventDefault();
	}//responder

	function setear_ayudas()
	{
		for(ayuda in ayudas){
			var c;
			switch(ayudas[ayuda])
			{
				case '1':
					c = '.segundos';
					$(document).off('click', c, ayuda_segundos);
					break;
				case '2':
					c = '.erradas';
					$(document).off('click', c, ayuda_erradas);
					break;
				case '3':
					c = '.avanza';
					$(document).off('click', c , ayuda_avanza);
					break;
			}
			$(c).addClass('nd');
		}
	}//setear_ayudas

	function usar_ayuda(data)
	{
		if(data.d == 's')
		{
			switch(data.a)
			{
				case '1':
					clearTimeout(TimeO);
					TotalSeconds += 10;
					CreateTimer('tiempo', TotalSeconds);
					break;
				case '2':
					malas = data.malas;
					for(mala in malas)
					{
						$('.' + malas[mala].id).empty().removeAttr('class');
					}
					break;
				case '3':
					clearTimeout(TimeO);
					localStorage.removeItem('t');
					p.empty();
					ra.empty().removeAttr('class');
					rb.empty().removeAttr('class');
					rc.empty().removeAttr('class');
					rd.empty().removeAttr('class');
					inicializar();
					break;
			}
		}
	}//cargar_ayuda

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
		Timer.innerHTML = TimeStr;
	}

	function LeadingZero(Time) {
		return (Time < 10) ? "0" + Time : + Time;
	}
	

});