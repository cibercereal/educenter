<?php

include_once './Validation/validate.php';

class authValidationAction extends Validate {

	function checkLogin() {
		if(!$this->userExists()){
			fillExceptionAction('USUARIO_NO_EXISTE');
		}
		if(!$this->userPassCorrect()){
			fillExceptionAction('CONTRASENA_INCORRECTO');
		}
	}

    function validateRegister() {
        if($this->userExists()) {
			fillExceptionAction('USUARIO_YA_EXISTE');
		}
		if($this->emailExists()) {
			fillExceptionAction('EMAIL_YA_EXISTE');
		}
    }

    function validateGetPasswordEmail(){
		if(!$this->userExists()){
			fillExceptionAction('USUARIO_NO_EXISTE');
		}
		if(!$this->emailExists()){
			fillExceptionAction('EMAIL_NO_EXISTE');
		}
		if(!$this->userEmailSameUser()){
			fillExceptionAction('USUARIO_EMAIL_NO_COINCIDEN');
		}
	}

    function emailExists() {	
        return !empty($this->user->seek(array('email'), array($this->user->arrayDataValue['email']))['resource']);
    }

    function userExists(){
        $user = $this->user->getById(array($this->user->arrayDataValue['dni']));
        return !empty($user['resource']) && $user['resource']['borrado_logico'] == '0';
    }

    function userPassCorrect(){
        $raw = $this->user->getById(array($this->user->arrayDataValue['dni']))['resource'];

        return !(empty($raw) || $raw['password'] != $this->user->arrayDataValue['password']);
    }

    function userEmailSameUser(){
        $row = $this->user->seek(array('dni', 'email'), (array($this->arrayDataValue['dni'], $this->arrayDataValue['email'])))['resource'];
        if (empty($row)){ return false; }
        else{ return true; }
    }
}
?>