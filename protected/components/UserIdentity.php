<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	public $correo;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */

	public function __construct($correo, $password)
	{
		$this->correo 	= $correo;
		$this->password = $password;
	}

	public function authenticate()
	{
		$correo = strtolower($this->correo);
		$usuario = Usuario::model()->find('LOWER(correo)=?',array($correo));
		if($usuario === null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if(!$usuario->validatePassword($this->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id 		= $usuario->id;
            $this->correo 	= $usuario->correo;
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
	}

	public function getId()
    {
        return $this->_id;
    }
}