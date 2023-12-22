<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/authValidation.php';

class authService extends ServiceBase {

	private $user;

	function startRest() {
		$this->validateDataAttributes();		
		$this->listAttributesEqual = array();
		
		switch(action) {
			case 'login':
				$this->attributeList = array('dni', 'password');
				$this->user = $this->createModelOne('user');
				$this->validationClass = $this->createValidationOne('auth');
				$this->validationClass->user = $this->user;
				$this->checkLogin();
				$responseFront = $this->login('LOGIN_USUARIO_CORRECTO');
				break;
			case 'register':
				$this->attributeList = array('dni', 'nombre', 'apellidos_usuario', 'email', 'password', 'id_rol', 'direccion', 'telefono', 'fecha_nac');
				$this->user = $this->createModelOne('user');
				$this->validationClass = $this->createValidationOne('auth');
				$this->validationClass->user = $this->user;
				$this->validateRegister();
				$responseFront = $this->register('REGISTRAR_USUARIO_OK');
				break;
			case 'getPasswordEmail':
				include_once './correo/obtenerContrasenaCorreo.php';
				$this->model = new obtenerContrasenaCorreo();
				$this->attributeList = array('dni', 'email');
				$this->user = $this->createModelOne('user');
				$this->validationClass = $this->createValidationOne('auth');
				$this->validationClass->user = $this->user;
				$this->validateGetPasswordEmail();
				$responseFront = $this->getPasswordEmail('RECOVER_PASSWORD_EMAIL_OK');
				break;
		}

		return $responseFront;
	}

	function tokenVerify(){				
		include_once "./JWT/token.php";

		$tokenFront = $this->loadTokenHeader();
		$result = MiToken::devuelveToken($tokenFront);
        define('userSystem', $result->data->usuario);
		define('rolUserSystem', $result->data->rol);
	}

///////////////////////////////////////////////////////LOGIN///////////////////////////////////////////////////////

	function checkLogin() {
		$this->validationClass->checkLogin();
	}

	function validateRegister() {
		$this->validationClass->validateRegister();
	}

	function validateGetPasswordEmail(){
		$this->validationClass->validateGetPasswordEmail();
	}
	
	function login($message) {
		include_once './Model/roleModel.php';
		$roleModel = new roleModel;
		$role = $roleModel->getById(array($this->user->getById(array($this->user->arrayDataValue['dni']))['resource']['id_rol']))['resource']['id_rol'];

		$userData = [
			'user' => $this->user->arrayDataValue['dni'],
			'password' => $this->user->arrayDataValue['password'],
			'role' => $role
		];

		include_once "./JWT/token.php";
		$token = MiToken::generateToken($userData);

		$this->feedback['ok'] = true;
		$this->feedback['code'] = $message;
		$this->feedback['resource'] = $token;
		
        return $this->feedback;
	}

	function register($message){
		$this->user->ADD();
		$this->feedback['ok'] = true;
		$this->feedback['code'] = $message;
		return $this->feedback;
	}

	function getPasswordEmail($message){
		$contrasenaclaro = $this->model->obtenerContrasenaCorreo($this->user);
		$this->model->enviarCorreo($contrasenaclaro, $this->user);
		$this->feedback['ok'] = true;
		$this->feedback['code'] = $message;
		$this->feedback['resource'] = $contrasenaclaro;
		return $this->feedback;
	}

}
?>