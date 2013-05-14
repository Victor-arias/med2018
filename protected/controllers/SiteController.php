<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model = new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes = $_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionRegistro()
	{
		$usuario = new Usuario;
		$jugador = new Jugador;

		if(isset($_POST['Usuario'], $_POST['Jugador']))
		{
			$usuario->attributes = $_POST['Usuario'];
        	$jugador->attributes = $_POST['Jugador'];

        	$valid = false;
        	if($usuario->validate() && $jugador->validate())
        		$valid = true;

        	if($valid)
	        {
	            $usuario->save(false);
	            $jugador->usuario_id = $usuario->id;
	            $jugador->save(false);

	            $datos = array(	'nombre' 			=> $jugador->nombre,
	            				'correo' 			=> $usuario->correo,
	            				'llave_activacion' 	=> $usuario->llave_activacion
	            				);

	            $this->verificarCorreo($datos);


	        }
		}


		$this->render('registro', array(
				'usuario' => $usuario,
				'jugador' => $jugador,
			)
		);
	}

	public function actionVerificar($llave_activacion)
	{
		$verificar = Usuario::model()->verificarLlave($llave_activacion);
		if($verificar)
		{
			$usuario = new Usuario;
			$loginForm = new LoginForm;
			$usuario->updateByPk($verificar->id, array('llave_activacion' => '', 'estado' => 1));
			$mensaje = 'Verificación exitosa';
		}else
			$mensaje = 'Verificación fallida'; 
		$this->render('verificar', array('mensaje' => $mensaje));
	}

	private function verificarCorreo($datos)
    {   
        $this->layout = '//layouts/mail';
        $this->render('verificar_correo', array('datos' => $datos) );
        Yii::app()->end();
        /*$message             = new YiiMailMessage;
        $message->view 		 = "verificar-correo";
        

        $params              = array('datos' => $datos);
        $message->subject    = 'Verifica tu correo en ---';
        $message->setBody($params, 'text/html');                
        $message->addTo($datos['correo']);
        $message->from = 'admin@telemedellin.tv';   
        if( Yii::app()->mail->send($message) )
        {
        	return true;
        }*/
    }
}