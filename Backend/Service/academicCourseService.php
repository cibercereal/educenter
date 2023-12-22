<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/academicCourseValidation.php';

class academicCourseService extends ServiceBase {

    function startRest(){
		$this->listAttributesEqual = array();
	    $this->validateDataAttributes();

		switch(action){
			case 'search':
				$this->attributeList = array('nombre_curso_academico');
			break;
			case 'add':
				$this->attributeList = array('nombre_curso_academico');
			break;
			case 'edit':
				$this->attributeList = array('id_curso_academico', 'nombre_curso_academico');
			break;
			case 'delete':
				$this->attributeList = array('id_curso_academico');
			break;
		}

		if (!empty($responseFront)) {
			return $responseFront;
		}
		$this->model = $this->createModelOne('academicCourse');
		$this->validationClass = $this->createValidationOne('academicCourse');
		$this->validationClass->model = $this->model;
		return $this->returnRest(action);
	}

	function addAcademicCourse($message) {
		$this->model->ADD();
		return $this->createFeedback($message);
	}

	function editAcademicCourse($message){
		$this->model->EDIT();
		return $this->createFeedback($message);
	}

	function deleteAcademicCourse($message) {
        $this->model->DELETE();
		return $this->createFeedback($message);
	}

	function createFeedback($message) {
		$this->feedback['ok'] = true;
		$this->feedback['code'] = $message;
		return $this->feedback;
	}

	function returnRest($action) {
		switch($action){
			case 'search':
				$this->validateSearch();
				$users = array();
				return $this->search();
			break;
			case 'add':
				$this->validateAdd();
				return $this->addAcademicCourse('ANADIR_CURSO_ACADEMICO_OK');
			case 'edit':
				$this->validateEdit();
				return $this->editAcademicCourse('EDITAR_CURSO_ACADEMICO_OK');
			break;
			case 'delete':
				$this->validationClass->validateDelete();
				return $this->deleteAcademicCourse('ELIMINAR_CURSO_ACADEMICO_OK');
			break;
		}
	}
}
?>