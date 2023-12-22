<?php

include_once './Validation/validate.php';

class academicCourseValidationAction extends Validate {

    function validateSearch() { /*Excepciones para buscar curso_academico*/ }

    function validateAdd( ) {
        if($this->isNotAdmin()) {
			fillExceptionAction('ACCION_DENEGADA_INSERTAR_CURSO_ACADEMICO');
        }
	}

    function validateEdit() {
        if (!$this->academicCourseExists()) {
            fillExceptionAction('CURSO_ACADEMICO_NO_EXISTE');
        }
        if($this->isNotAdmin()){
			fillExceptionAction('ACCION_DENEGADA_EDITAR_CURSO_ACADEMICO');
        }
    }

    function validateDelete() {
		if(!$this->academicCourseExists()){
			fillExceptionAction('CURSO_ACADEMICO_NO_EXISTE');
		}
        if($this->isNotAdmin()){
			fillExceptionAction('ACCION_DENEGADA_BORRAR_CURSO_ACADEMICO');
        }
    }

    function academicCourseExists() {
        $academicCourse = $this->model->getById(array($this->model->arrayDataValue['id_curso_academico']));
        return !empty($academicCourse['resource']);
    }

    function isNotAdmin() {
        return rolUserSystem != '1';
    }

}
?>