<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/actionFunctionalityValidation.php';

class actionFunctionalityService extends ServiceBase {

    function startRest() {
		$this->listAttributesEqual = array();
		$this->validateDataAttributes();

		switch(action){
			case 'search':
				$this->attributeList = array('id_accion', 'id_funcionalidad');
				$this->listAttributesEqual = array('id_accion', 'id_funcionalidad');
			break;
            case 'add':
                $this->attributeList = array('id_accion', 'id_funcionalidad', 'checked');
            break;
		}
		
		if (!empty($responseFront)) {
			return $responseFront;
		}
		$this->model = $this->createModelOne('actionFunctionality');
		$this->validationClass = $this->createValidationOne('actionFunctionality');
		$this->validationClass->model = $this->model;
		return $this->returnRest(action);
	}

    function returnRest($action) {
		switch($action){
			case 'search':
				$this->validateSearch();
				$elements = $this->search();
                // Action and functionality models.
                $actionModel = $this->createModelOne("action");
                $functionalityModel = $this->createModelOne("functionality");

                // Obtains the actions
				$actionModel->arrayDataValue = array('id_accion' => isset($this->model->arrayDataValue['id_accion']) ? $this->model->arrayDataValue['id_accion'] : '');
                $actions = $actionModel->SEARCH();

                // Obtains the functionalities
				$functionalityModel->arrayDataValue = array('id_funcionalidad' => isset($this->model->arrayDataValue['id_funcionalidad']) ? $this->model->arrayDataValue['id_funcionalidad'] : '');
                $functionalities = $functionalityModel->SEARCH();
				$elements['resource'] = array('actionFunctionality' => $elements['resource'], 'actions' => $actions['resource'], 'functionalities' => $functionalities['resource']);
				$elements['total'] = array('actionFunctionality' => $elements['total'], 'actions' => $actions['total'], 'functionalities' => $functionalities['total']);
				return $elements;
			break;
            case 'add':
				return $this->addActionFunctionality('RECORDSET_DATOS');
            break;
		}
	}

    function addActionFunctionality($message) {
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