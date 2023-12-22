<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/userValidation.php';

class userService extends ServiceBase {

    function startRest(){
		$this->listAttributesEqual = array();
		if (action != 'finalDelete') {
			$this->validateDataAttributes();
		}
		
		switch(action){
			case 'search':
				$this->attributeList = array('dni', 'nombre', 'apellidos_usuario', 'email', 'password', 'id_rol', 'direccion', 'telefono', 'fecha_nac');
				$this->listAttributesEqual = array('id_rol'); //Si establezco que quiero buscar los id_rol = 1 no quiero que vengan usuarios con id_rol = 10...
				break;
			case 'searchBy':
				$this->attributeList = array('dni');
				$this->listAttributesEqual = array('dni');
			break;
			case 'add':
				$this->attributeList = array('dni', 'nombre', 'apellidos_usuario', 'email', 'password', 'id_rol', 'direccion', 'telefono', 'fecha_nac');
			break;
			case 'edit':
				$this->attributeList = array('dni', 'nombre', 'apellidos_usuario', 'email', 'id_rol', 'direccion', 'telefono', 'fecha_nac');
			break;
			case 'delete':
				$this->attributeList = array('dni');
			break;
			case 'finalDelete':
				$this->attributeList = array('dni');
			break;
			case 'editPass':
				$this->attributeList = array('dni', 'password');
			break;
		}
		
		if (!empty($responseFront)) {
			return $responseFront;
		}
		$this->model = $this->createModelOne('user');
		$this->validationClass = $this->createValidationOne('user');
		$this->validationClass->model = $this->model;
		return $this->returnRest(action);
	}

	function addUser($message, $ok){
		if ($ok) {
			$this->model->ADD();
		}
		
		return $this->createFeedback($message, $ok);
	}

	function editUser($message, $ok){
		if ($ok) {
			$this->model->EDIT();
		}

		return $this->createFeedback($message, $ok);
	}

	function deleteUser($message, $ok) {
		if ($ok) {
			$this->model->LOGIC_DELETE();
		} else {
			$this->model->DELETE();
		}

		return $this->createFeedback($message, $ok);
	}

	function editPass($message, $ok){
		if ($ok) {
			$this->model->EDIT();
		}
		
		return $this->createFeedback($message, $ok);
	}

	function createFeedback($message, $ok) {
		$this->feedback['ok'] = $ok;
		$this->feedback['code'] = $message;
		return $this->feedback;
	}

	function returnRest($action) {
		switch($action){
			case 'search':
				$this->validateSearch();
				$users = array();
				$elements = $this->search();
				foreach ($elements['resource'] as $elem) {
					if ($elem['borrado_logico'] === 0 && rolUserSystem == '1') {
						array_push($users, $elem);
					} else if ($elem['borrado_logico'] === 0 && (rolUserSystem == '2' || rolUserSystem == '3') && $elem['id_rol']['id_rol'] != '1') {
                        array_push($users, $elem);
					} else if ($elem['borrado_logico'] === 0 && $elem['dni'] == userSystem) {
					    array_push($users, $elem);
					}
				}
				$elements['resource'] = $users;
				$elements['total'] = count($users);
				$elements['filas'] = count($users);
				return $elements;
			break;
			case 'searchBy':
				$this->validateSearch();
				return $this->searchBy();
			break;
			case 'add':
				$this->validateAdd();
				return $this->addUser('ANADIR_USUARIO_OK', true);
			case 'edit':
				$this->validateEdit();
				return $this->editUser('EDITAR_USUARIO_OK', true);
			break;
			case 'delete':
				$this->validateDelete();
				return $this->deleteUser('ELIMINAR_USUARIO_OK', true);
			break;
			case 'finalDelete':
				return $this->deleteUser('ELIMINAR_USUARIO_OK', false);
			break;
			case 'editPass':
			    $this->model->arrayDataValue['dni'] = userSystem;
			    $this->validationClass->validateEditPass();
				return $this->editPass('USUARIO_EDITAR_CONTRASENA_OK', true);
			break;
		}
	}
}
?>