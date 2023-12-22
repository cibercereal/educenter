<?php

include_once './Validation/validate.php';

class userValidationAction extends Validate {

    function validateSearch() { /*Excepciones para buscar usuario*/ }

    function validateAdd( ) {
		if($this->userExists()){
			fillExceptionAction('USUARIO_YA_EXISTE');
		}
        if($this->isNotAdmin()) {
			fillExceptionAction('ACCION_DENEGADA_INSERTAR_USUARIO');
        }
	}

    function validateEdit() {
        if (!$this->userExists()) {
            fillExceptionAction('USUARIO_NO_EXISTE');
        }
        if(!$this->denyEditAction()){
			fillExceptionAction('ACCION_DENEGADA_EDITAR_USUARIO');
        }
    }

    function validateDelete($userRole) {
        if($userRole == '1'){
			fillExceptionAction('ADMIN_NO_SE_PUEDE_BORRAR');
		}
		if(!$this->userExists()){
			fillExceptionAction('USUARIO_NO_EXISTE');
		}
        if(!$this->denyDeleteAction()){
			fillExceptionAction('ACCION_DENEGADA_BORRAR_USUARIO');
        }
    }

    function validateEditPass() {
        if(!$this->userExists()) {
            fillExceptionAction('USUARIO_NO_EXISTE');
        }
    }

    function userExists() {
        $user = $this->model->getById(array($this->model->arrayDataValue['dni']));
        return !empty($user['resource']) && $user['resource']['borrado_logico'] == '0';
    }

    function isNotAdmin() {
        return rolUserSystem != '1';
    }

    function denyEditAction() {
        $row = $this->model->getById(array($this->model->arrayDataValue['dni']))['resource'];
        return !(rolUserSystem != '1' && userSystem != $row['dni']);
    }

    function denyDeleteAction() {
        $row = $this->model->getById(array($this->model->arrayDataValue['dni']))['resource'];
        return !(rolUserSystem != '1');
    }

}
?>