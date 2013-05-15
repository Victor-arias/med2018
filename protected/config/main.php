<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Medellín 2018',
	'sourceLanguage' => '00',
	'language' => 'es',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.yii-mail.YiiMailMessage',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'asdf1234*',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'iniciar-sesion'	=>'site/login',
				'cerrar-sesion'		=>'site/logout',
				'registro'			=>'site/registro',
				'<controller:\w+>/<action:\w+>/<llave_activacion:\w+>'=>'<controller>/<action>',
				'<controller:\w\->/<id:\d+>'=>'<controller>/view',
				'<controller:\w\->/<action:\w\->/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w\->/<action:\w\->'=>'<controller>/<action>',
			),
		),
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=medellin2018',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			//'enableProfiling'=>true,
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		/*'request'=>array(
            'enableCsrfValidation'	=> true,
            'enableCookieValidation'=> true,
        ),*/
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType'=>'smtp',
            'transportOptions'=>array(
                    'host'=>'smtp.gmail.com',
                    'username'=>'victor.arias@telemedellin.tv',
                    'password'=>'BaSsWaHfUlL100%',
                    'port'=>'25',                       
            ),
            'viewPath' => 'application.views.mail',             
    	),
	),


	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'victor.arias@telemedellin.tv',
	),
);