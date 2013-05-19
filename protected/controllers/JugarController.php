<?php

class JugarController extends Controller
{
	public $layout 		= '//layouts/column2';
	private $_jugador_id= 0;
	private $_ronda 	= 0;
	private $_preguntas = array();
	private $_preguntan = 0;
	private $_preguntaid= 0;
	private $_nivel  	= 0;
	private $_tiempo 	= 10;
	private $_puntosr 	= 0;
	private $_puntost 	= 0;
	private $_situacion = 0;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public $defaultAction = 'jugar';

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('jugar', 'cargarpregunta', 'responder', 'control', 'tiempo', 'test'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionTest()
	{
		$this->verificar_sesion();
		$estadisticas = Ronda::model()->obtener_estadisticas($this->_jugador_id);
		echo '<pre>';
		print_r($estadisticas);
		echo '</pre>';
		echo gmdate('d-m-Y H:i:s', 29640);
	}

	public function actionJugar()
	{
		$this->verificar_sesion();

		$this->render('jugar');
	}

	public function actionCargarPregunta()
	{
		$this->verificar_sesion();
		if (!Yii::app()->request->isAjaxRequest) throw new CHttpException('403', 'Forbidden access.');
	    
	    if( $this->_situacion == 2 )
	    {
	    	$resultado = $this->cargar_pregunta($this->_preguntaid);
	    }
	    else
	    {
		    $resultado = $this->cargar_pregunta();
		    Yii::app()->session['situacion'] = $this->_situacion = 2; //2. pregunta  
		    Yii::app()->session['preguntan'] = $this->_preguntan = ($this->_preguntan + 1); 
		    Yii::app()->session['preguntaid']= $this->_preguntaid= $resultado['pregunta']->id;
		}
		$resultado = array_merge( $resultado, array('pn' => $this->_preguntan, 't' => $this->_tiempo) );

		header('Content-Type: application/json; charset="UTF-8"');
		echo CJSON::encode( $resultado );
	    Yii::app()->end();
	
	}

	public function actionControl()
	{
		$this->verificar_sesion();
		$respuesta = array( 's' => $this->_situacion,
							'n' => $this->_nivel,
							'pn' => $this->_preguntan,
							'pr' => $this->_puntosr,
							'pt' => $this->_puntost,
							't'  => $this->_tiempo, );
		header('Content-Type: application/json; charset="UTF-8"');
	    echo CJSON::encode( $respuesta );
	    if($this->_situacion == 6 || $this->_situacion == 4) $this->limpiar_sesion();
	    Yii::app()->end();
	}

	public function actionTiempo()
	{
		$this->verificar_sesion();
		$this->_situacion = 7;//7. Tiempo
		header('Content-Type: application/json; charset="UTF-8"');
	    echo CJSON::encode( array('s' => $this->_situacion,
								'n' => $this->_nivel,
								'pn' => $this->_preguntan,
								'pr' => $this->_puntosr,
								'pt' => $this->_puntost ) );
	    $this->limpiar_sesion();
	    Yii::app()->end();
	}

	public function actionResponder()
	{
		$this->verificar_sesion();
		if (!Yii::app()->request->isAjaxRequest) throw new CHttpException('403', 'Forbidden access.');
		if( !isset($_POST['r']) && !is_int($_POST['r']) ) throw new CHttpException('403', 'Forbidden access.');
	    
		$respuesta 	= $_POST['r'];
		$tiempo 	= $_POST['t'];
	    
	    $r = Respuesta::model()->findByPk($respuesta);
	    
	    if($r->es_correcta)
	    {
	    	
	    	$nivel = Nivel::model()->findByPk($this->_nivel);
	    	$ronda = Ronda::model()->findByPk($this->_ronda);

	    	$puntosr = ($ronda->puntos + $nivel->puntos);

	    	$a = array(
					'tiempo' 	=> ($ronda->tiempo + ($nivel->tiempo - $tiempo) ), 
					'preguntas' => $this->_preguntan, 
					'nivel' 	=> $this->_nivel, 
					'puntos' 	=> $puntosr
				);
	    	    	
	    	$ronda->updateByPk($this->_ronda, $a);

	    	//Agregar la pregunta a pregunta_x_ronda
	    	$pxr = new PreguntaXRonda;
	    	$pxr->ronda_id 		= $this->_ronda;
	    	$pxr->pregunta_id 	= $this->_preguntaid;
	    	$pxr->save();

	    	//Agrego la pregunta al array para no repetirla esta ronda
	    	$this->_preguntas[] = $this->_preguntaid;
	    	Yii::app()->session['preguntas'] = $this->_preguntas;

	    	Yii::app()->session['preguntaid'] 	= $this->_preguntaid = 0;
	    	Yii::app()->session['puntosr'] 		= $this->_puntosr 	 = $puntosr;

	    	//Sumo puntos
			$pt = Jugador::model()->setPuntos( $nivel->puntos, $this->_jugador_id );
	    	if($pt) Yii::app()->session['puntost'] = $this->_puntost = $pt;

	    	if( $this->_preguntan < (Yii::app()->params['preguntasxnivel'] * $this->_nivel) )
	    	{
	    		$tmpsituacion = 3; //3. Respuesta correcta
	    	}
	    	else
	    	{
	    		if($this->_nivel < 5){
	    			$tmpsituacion = 5; //5. Cambio de nivel	
	    			$newnivel = Nivel::model()->findByPk($this->_nivel + 1);
	    			Yii::app()->session['nivel'] = $this->_nivel = $this->_nivel + 1;
	    			Yii::app()->session['tiempo'] = $this->_tiempo = $newnivel->tiempo;
	    		}else{
	    			$tmpsituacion = 6; //6. Ronda completada
	    		}
	    			
	    	}
	    	
	    	$situacion = $tmpsituacion;
	    }
	    else
	    {
	    	$situacion = 4;//4. Respuesta mala
	    }

	    Yii::app()->session['situacion'] = $this->_situacion = $situacion;

	    header('Content-Type: application/json; charset="UTF-8"');
	    echo CJSON::encode( array('s' => $situacion,
								'n' => $this->_nivel,
								'pn' => $this->_preguntan,
								'pr' => $this->_puntosr,
								'pt' => $this->_puntost ) );
	    if($this->_situacion == 6 || $this->_situacion == 4) $this->limpiar_sesion();
	    Yii::app()->end();

	}

	protected function cargar_pregunta($pregunta_id = 0)
	{
		/*
		Obtengo una pregunta del nivel no resuelta
		Retorno un objeto con una pregunta y sus respuestas
		*/

		$pregunta = new Pregunta;
		$resultado = $pregunta->obtener_pregunta($this->_nivel, $pregunta_id);
		if( in_array($resultado['pregunta']->id, $this->_preguntas ) )
			$resultado = $this->cargar_pregunta($pregunta_id);
					
		return $resultado;
	}

	protected function verificar_sesion()
	{
		//1. Verifico la sesión para inicializar el juego
		if( !isset(Yii::app()->session['ronda']) || Yii::app()->session['ronda'] == 0 )
		{
			if($this->_jugador_id == 0)
			{
				//2. Obtengo el id del jugador
				$jugador = Jugador::model()->find('usuario_id = ' . Yii::app()->user->id);
				$jugador_id = $jugador->id;	
				Yii::app()->session['jugador_id']	= $this->_jugador_id = $jugador_id;
			}

			//3. Verifico el  número de rondas que ha jugado hoy para que no juegue más de la cuenta
			$rondasdia = Ronda::model()->getRondasDia( $this->_jugador_id );
			if($rondasdia >= Yii::app()->params['rondasxdia'])
			{
				Yii::app()->user->setFlash('error', "Ya has jugado más de " . Yii::app()->params['rondasxdia'] . ' veces el día de hoy, vuelve mañana para que sigas acumulando puntos.');
				$this->redirect('puntajes');
				Yii::app()->end();
			}

			//Verifico el nivel para actualizar el tiempo de cada pregunta

			$pt = Jugador::model()->getPuntos( $this->_jugador_id );

			$ronda = new Ronda;
			Yii::app()->session['ronda'] 		= $this->_ronda 	= $ronda->iniciarRonda( $this->_jugador_id );
			Yii::app()->session['preguntas']	= $this->_preguntas = array();
			Yii::app()->session['preguntan']	= $this->_preguntan = 0;
			Yii::app()->session['preguntaid']	= $this->_preguntaid= 0;
			Yii::app()->session['nivel'] 		= $this->_nivel 	= 1;
			Yii::app()->session['puntosr'] 		= $this->_puntosr 	= 0;
			Yii::app()->session['puntost'] 		= $this->_puntost 	= $pt;
			Yii::app()->session['situacion']	= $this->_situacion = 1; //1. inicio

			$nivel = Nivel::model()->findByPk($this->_nivel);
			Yii::app()->session['tiempo'] 		= $this->_tiempo 	= $nivel->tiempo;
		}else
		{
			$this->_ronda  	 	= Yii::app()->session['ronda'];
			$this->_jugador_id 	= Yii::app()->session['jugador_id'];
			$this->_preguntas 	= Yii::app()->session['preguntas'];
			$this->_preguntan 	= Yii::app()->session['preguntan'];
			$this->_preguntaid 	= Yii::app()->session['preguntaid'];
			$this->_nivel 	 	= Yii::app()->session['nivel'];
			$this->_tiempo 	 	= Yii::app()->session['tiempo'];
			$this->_puntosr	 	= Yii::app()->session['puntosr'];
			$this->_puntost	 	= Yii::app()->session['puntost'];
			$this->_situacion	= Yii::app()->session['situacion'];

		}
	}//verificar_sesion

	protected function limpiar_sesion()
	{
		//1. Verifico la sesión para inicializar el juego
		if( isset(Yii::app()->session['ronda']) && Yii::app()->session['ronda'] != 0 )
		{
			Yii::app()->session['ronda'] 		= $this->_ronda 	= 0;
			Yii::app()->session['preguntan']	= $this->_preguntan = 0;
			Yii::app()->session['preguntan']	= $this->_preguntan = 0;
			Yii::app()->session['preguntaid']	= $this->_preguntaid= 0;
			Yii::app()->session['nivel'] 		= $this->_nivel 	= 0;
			Yii::app()->session['tiempo'] 		= $this->_tiempo 	= 10;
			Yii::app()->session['puntosr'] 		= $this->_puntosr 	= 0;
			Yii::app()->session['puntost'] 		= $this->_puntost 	= 0;
			Yii::app()->session['situacion']	= $this->_situacion = 0;
			/*Yii::app()->session->clear();
			Yii::app()->session->destroy();*/
			
		}
	}//limpiar_sesion

}