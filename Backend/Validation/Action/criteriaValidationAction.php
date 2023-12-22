<?php

include_once './Validation/validate.php';

class criteriaValidationAction extends Validate {

    function validateAdd() {
		if(!$this->projectExistsById()){
            fillExceptionAction('TRABAJO_NO_EXISTE');
		}
		if($this->isNotTeacher()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
		}
    }

    function validateEdit() {
        if(!$this->criteriaExistsById()){
            fillExceptionAction('CRITERIO_NO_EXISTE');
		}
		if(!$this->projectExistsById()){
            fillExceptionAction('TRABAJO_NO_EXISTE');
		}
        if($this->isNotTeacher()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
        }
        if(!$this->userIsSubjectTeacher()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR_MATERIA');
        }
    }

    function validateDelete() {
        if(!$this->criteriaExistsById()){
            fillExceptionAction('CRITERIO_NO_EXISTE');
		}
        if($this->isNotTeacher()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
        }
    }

    function validateSearch() {
         if (rolUserSystem != '2' && rolUserSystem != '3') {
             fillExceptionAction('USUARIO_NO_ES_PROFESOR_O_ALUMNO');
         }
         if (!$this->userIsSubjectTeacher() && !$this->userIsSubjectStudent()) {
             fillExceptionAction('USUARIO_NO_ES_PROFESOR_O_ALUMNO_MATERIA');
         }
    }

    function criteriaExistsById()  {
        $criteria = $this->model->getById(array($this->model->arrayDataValue['id_criterio']))['resource'];
        return !empty($criteria);
    }

    function projectExistsById()  {
        $project = $this->project->getById(array($this->model->arrayDataValue['id_trabajo']))['resource'];
        return !empty($project);
    }

    function userIsSubjectStudent() {
        $project = $this->project->getById(array($this->model->arrayDataValue['id_trabajo']))['resource'];
        if (!empty($project)) {
            $student = $this->subjectStudent->getById(array($project['id_materia'], userSystem))['resource'];
            return !empty($student) && $student['aceptado'] == '1';
        }
        return false;
    }

    function userIsSubjectTeacher() {
        $project = $this->project->getById(array($this->model->arrayDataValue['id_trabajo']))['resource'];
        if (!empty($project)) {
            $subjectTeacher = $this->subjectTeacher->getById(array($project['id_materia'], userSystem))['resource'];
            if (!empty($subjectTeacher) && $subjectTeacher['secundario'] == '1') {
                return true;
            } else {
                $subject = $this->subject->getById(array($project['id_materia']))['resource'];
                return !empty($subject) && $subject['dni'] == userSystem;
            }
        }
        return false;
    }

    function isNotTeacher() {
        return rolUserSystem != '2';
    }
}
?>