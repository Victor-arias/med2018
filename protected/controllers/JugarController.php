<?php

class JugarController extends Controller
{
	public $layout 		= '//layouts/column2';
	/*private $_sal		= 'joj2018';
	private $_token 	= 0;*/
	private $_ronda 	= 0;
	private $_pregunta  = 0;
	private $_nivel  	= 0;


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
				'actions'=>array('jugar', 'cargarpregunta', 'responder', 'control'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actionJugar()
	{
		/*//1. Verifico la sesión para inicializar el juego
		if( !isset(Yii::app()->session['ronda']) )
		{
			$ronda = new Ronda;
			
			Yii::app()->session['ronda'] 	= $this->_ronda 	= $ronda->setRonda( Yii::app()->user->id );
			Yii::app()->session['pregunta'] = $this->_pregunta 	= 1;
			Yii::app()->session['nivel'] 	= $this->_nivel 	= 1;
		}else
		{
			$this->_ronda  	 = Yii::app()->session['ronda'];
			$this->_pregunta = Yii::app()->session['pregunta'];
			$this->_nivel 	 = Yii::app()->session['nivel'];
		}*/

		$this->render('jugar');
	}

	public function actionCargarPregunta()
	{
		if( !isset(Yii::app()->session['ronda']) ) throw new CHttpException('403', 'Forbidden access.');
		if (!Yii::app()->request->isAjaxRequest) throw new CHttpException('403', 'Forbidden access.');
	    if( !isset($_POST['p']) && !isset($_POST['n']) ) throw new CHttpException('403', 'Forbidden access.');
	    
	    $pregunta 	= $_POST['p'];
	    $nivel  	= $_POST['n'];

	    $this->_pregunta = $pregunta;
	    $this->_nivel 	= $nivel;

	    header('Content-Type: application/json; charset="UTF-8"');
	    echo CJSON::encode( $this->cargar_pregunta() );
	    Yii::app()->end();
	
	}

	public function actionControl()
	{
		$respuesta = array( 'n' => $this->_nivel,
							'p' => $this->_pregunta,
						);
		header('Content-Type: application/json; charset="UTF-8"');
	    echo CJSON::encode( $respuesta );
	    Yii::app()->end();
	}

	public function actionResponder()
	{
		if( !isset(Yii::app()->session['ronda']) ) throw new CHttpException('403', 'Forbidden access.');
		if (!Yii::app()->request->isAjaxRequest) throw new CHttpException('403', 'Forbidden access.');
		if( !isset($_POST['r']) && !isset($_POST['p']) && !isset($_POST['n']) ) throw new CHttpException('403', 'Forbidden access.');
	    
		$respuesta 	= $_POST['r'];
	    $pregunta 	= $_POST['p'];
	    $nivel  	= $_POST['n'];

	    $r = Respuesta::model()->findByPk($respuesta);
	    
	    if($r->es_correcta)
	    {
	    	//Sumar puntos a la ronda
	    	//Sumar tiempo a la ronda
	    	//Sumar preguntas a la ronda
	    	//Actualizar nivel a la ronda
	    	$ronda = new Ronda;
	    	$ronda->id 			= $this->_ronda;
	    	$ronda->puntos		= 10;
	    	$ronda->tiempo		= 10;
	    	$ronda->preguntas 	= 1;
	    	$ronda->nivel		= 1;
	    	$ronda->update();

	    	//Agregar la pregunta a pregunta_x_ronda
	    	$pxr = new PreguntaXRonda;
	    	$pxr->ronda_id 		= $this->_ronda;
	    	$pxr->pregunta_id 	= $r->pregunta_id;
	    	$pxr->save();

	    	$respuesta = 2;
	    	
	    }
	    else
	    {
	    	$respuesta = 1;
	    }

	    header('Content-Type: application/json; charset="UTF-8"');
	    echo CJSON::encode( array('response' => $respuesta) );
	    Yii::app()->end();

	}

	protected function cargar_pregunta()
	{
		/*
		Obtengo una pregunta del nivel no resuelta
		Retorno un objeto con una pregunta y sus respuestas
		*/

		$pregunta = new Pregunta;
		return $pregunta->obtener_pregunta($this->_nivel);
	}

	protected function beforeAction($action)
	{
		//1. Verifico la sesión para inicializar el juego
		if( !isset(Yii::app()->session['ronda']) )
		{
			$ronda = new Ronda;
			
			Yii::app()->session['ronda'] 	= $this->_ronda 	= $ronda->setRonda( Yii::app()->user->id );
			Yii::app()->session['pregunta'] = $this->_pregunta 	= 1;
			Yii::app()->session['nivel'] 	= $this->_nivel 	= 1;
		}else
		{
			$this->_ronda  	 = Yii::app()->session['ronda'];
			$this->_pregunta = Yii::app()->session['pregunta'];
			$this->_nivel 	 = Yii::app()->session['nivel'];
		}
		return true;
	}

}