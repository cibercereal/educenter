<?php

include_once './Validation/validate.php';

class correctionCriteriaValidationAction extends Validate {

    function validateAdd() {
        if(!$this->dniIsStudent()){
            fillExceptionAction('USUARIO_NO_ES_ALUMNO');
		}
		if($this->isNotTeacher()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
		}
        if (!$this->userIsSubjectTeacher() && !$this->userIsSubjectStudent()) {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR_O_ALUMNO_MATERIA');
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

    function validateEdit() {
        if (rolUserSystem != '3') {
            fillExceptionAction('USUARIO_NO_ES_ALUMNO');
        }
        if ($this->isNotYourCorrection()) {
            fillExceptionAction('CORRECCION_NO_PERTENECE_ALUMNO');
        }
    }

    function validateEditTeacher() {
        if (rolUserSystem != '2') {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
        }
    }

    function isNotYourCorrection() {
        $correction = $this->model->getById(array($this->model->arrayDataValue['id_correccion_criterio']))['resource'];
        return userSystem != $correction['dni_alumno'];
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

    function userIsSubjectStudent() {
        $project = $this->project->getById(array($this->model->arrayDataValue['id_trabajo']))['resource'];
        if (!empty($project)) {
            $student = $this->subjectStudent->getById(array($project['id_materia'], userSystem))['resource'];
            return !empty($student) && $student['aceptado'] == '1';
        }
        return false;
    }

    function isNotTeacher() {
        return rolUserSystem != '2';
    }

    function dniIsStudent() {
        $student = $this->user->getById(array($this->model->arrayDataValue['dni_alumno']))['resource'];
        return !empty($student) && $student['id_rol'] == '3';
    }
}
?>