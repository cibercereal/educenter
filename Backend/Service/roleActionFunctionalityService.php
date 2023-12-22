<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/roleActionFunctionalityValidation.php';

class roleActionFunctionalityService extends ServiceBase {

    function startRest() {
		$this->listAttributesEqual = array();
		$this->validateDataAttributes();

		switch(action){
			case 'search':
				$this->attributeList = array('id_rol', 'id_accion', 'id_funcionalidad');
				$this->listAttributesEqual = array('id_rol', 'id_accion', 'id_funcionalidad');
			break;
            case 'add':
                $this->attributeList = array('id_rol', 'id_accion', 'id_funcionalidad', 'checked');
            break;
		}
		
		if (!empty($responseFront)) {
			return $responseFront;
		}
		$this->model = $this->createModelOne('rolActionFunctionality');
		$this->validationClass = $this->createValidationOne('roleActionFunctionality');
		$this->validationClass->model = $this->model;
		return $this->returnRest(action);
	}

    function returnRest($action) {
		switch($action){
			case 'search':
				$this->validateSearch();
				$elements = $this->search();
                // Action and functionality models.
                $roleModel = $this->createModelOne("role");
                $actionFunctModel = $this->createModelOne("actionFunctionality");

                // Obtains the roles
				$roleModel->arrayDataValue = array('id_rol' => isset($this->model->arrayDataValue['id_rol']) ? $this->model->arrayDataValue['id_rol'] : '');
                $roles = $roleModel->SEARCH();

                // Obtains the action-functionality
				$actionFunctModel->arrayDataValue = array('id_accion' => isset($this->model->arrayDataValue['id_accion']) ? $this->model->arrayDataValue['id_accion'] : '', 'id_funcionalidad' => isset($this->model->arrayDataValue['id_funcionalidad']) ? $this->model->arrayDataValue['id_funcionalidad'] : '');
                $actionFuncts = $actionFunctModel->SEARCH()['resource'];

				$elements['resource'] = array('roleActionFunctionality' => $elements['resource'], 'actionFunctionality' => $actionFuncts, 'roles' => $roles['resource']);
				$elements['total'] = array('roleActionFunctionality' => $elements['total'], 'actionFunctionality' => count($actionFuncts), 'roles' => $roles['total']);
				return $elements;
			break;
            case 'add':
				return $this->addRoleActionFunctionality('RECORDSET_DATOS');
            break;
		}
	}

    function addRoleActionFunctionality($message) {
        if ($this->model->arrayDataValue['checked'] === 'true') {
			$this->validateAdd();
            unset($this->model->arrayDataValue['checked']);
            $this->model->ADD();
        } else {
			$this->validationClass->validateDelete();
            unset($this->model->arrayDataValue['checked']);
            $this->model->DELETE();
        }
		return $this->createFeedback($message);
	}

    function createFeedback($message) {
		$this->feedback['code'] = $message;
		return $this->feedback;
	}
}
?>