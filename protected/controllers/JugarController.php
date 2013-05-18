<?php

class JugarController extends Controller
{
	public $layout 		= '//layouts/column2';
	/*private $_sal		= 'joj2018';
	private $_token 	= 0;*/
	private $_prexnivel = 4;
	private $_ronda 	= 0;
	private $_preguntan = 0;
	private $_preguntaid= 0;
	private $_nivel  	= 0;
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
				'actions'=>array('jugar', 'cargarpregunta', 'responder', 'control', 'test'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionTest()
	{
		//if($this->_situacion == 6 || $this->_situacion == 4) 
		//$this->limpiar_sesion();
		$this->verificar_sesion();
		print_r(Yii::app()->session['ronda']);

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
		$resultado = array_merge($resultado, array('pn' => $this->_preguntan) );

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
							'pt' => $this->_puntost, );
		header('Content-Type: application/json; charset="UTF-8"');
	    echo CJSON::encode( $respuesta );
	    if($this->_situacion == 6 || $this->_situacion == 4) $this->limpiar_sesion();
	    Yii::app()->end();
	}

	public function actionResponder()
	{
		$this->verificar_sesion();
		if (!Yii::app()->request->isAjaxRequest) throw new CHttpException('403', 'Forbidden access.');
		if( !isset($_POST['r']) && !is_int($_POST['r']) ) throw new CHttpException('403', 'Forbidden access.');
	    
		$respuesta 	= $_POST['r'];
	    
	    $r = Respuesta::model()->findByPk($respuesta);
	    
	    if($r->es_correcta)
	    {
	    	
	    	$nivel = Nivel::model()->findByPk($this->_nivel);
	    	$ronda = Ronda::model()->findByPk($this->_ronda);

	    	$puntosr = ($ronda->puntos + $nivel->puntos);

	    	$a = array(
					'tiempo' 	=> ($ronda->tiempo + $nivel->tiempo), 
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

	    	Yii::app()->session['preguntaid'] 	= $this->_preguntaid = 0;
	    	Yii::app()->session['puntosr'] 		= $this->_puntosr 	 = $puntosr;

			$pt = Jugador::model()->setPuntos( $nivel->puntos, Yii::app()->user->id );
	    	if($pt) Yii::app()->session['puntost'] = $this->_puntost = $pt;

	    	if( $this->_preguntan < ($this->_prexnivel * $this->_nivel) )
	    	{
	    		$tmpsituacion = 3; //3. Respuesta correcta
	    	}
	    	else
	    	{
	    		if($this->_nivel < 5){
	    			$tmpsituacion = 5; //5. Cambio de nivel	
	    			Yii::app()->session['nivel'] = $this->_nivel = $this->_nivel + 1;
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
		return $pregunta->obtener_pregunta($this->_nivel, $pregunta_id);
	}

	protected function verificar_sesion()
	{
		//1. Verifico la sesión para inicializar el juego
		if( !isset(Yii::app()->session['ronda']) || Yii::app()->session['ronda'] == 0 )
		{
			$pt = Jugador::model()->getPuntos( Yii::app()->user->id );

			$ronda = new Ronda;
			Yii::app()->session['ronda'] 		= $this->_ronda 	= $ronda->iniciarRonda( Yii::app()->user->id );
			Yii::app()->session['preguntan']	= $this->_preguntan = 0;
			Yii::app()->session['preguntaid']	= $this->_preguntaid= 0;
			Yii::app()->session['nivel'] 		= $this->_nivel 	= 1;
			Yii::app()->session['puntosr'] 		= $this->_puntosr 	= 0;
			Yii::app()->session['puntost'] 		= $this->_puntost 	= $pt;
			Yii::app()->session['situacion']	= $this->_situacion = 1; //1. inicio
		}else
		{
			$this->_ronda  	 	= Yii::app()->session['ronda'];
			$this->_preguntan 	= Yii::app()->session['preguntan'];
			$this->_preguntaid 	= Yii::app()->session['preguntaid'];
			$this->_nivel 	 	= Yii::app()->session['nivel'];
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
			Yii::app()->session['preguntaid']	= $this->_preguntaid= 0;
			Yii::app()->session['nivel'] 		= $this->_nivel 	= 0;
			Yii::app()->session['puntosr'] 		= $this->_puntosr 	= 0;
			Yii::app()->session['puntost'] 		= $this->_puntost 	= 0;
			Yii::app()->session['situacion']	= $this->_situacion = 0;
			/*Yii::app()->session->clear();
			Yii::app()->session->destroy();*/
			
		}
	}//limpiar_sesion

}