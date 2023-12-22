<?php

include_once './Validation/validate.php';

class correctionTeacherValidationAction extends Validate {

    function validateAdd() {
		if($this->isNotTeacher()) {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
		}
    }

    function validateEdit() {
        if(!$this->correctionTeacherExistsById()){
            fillExceptionAction('CORRECCION_PROFESOR_NO_EXISTE');
        }
		if($this->isNotTeacher()) {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
		}
        if ($this->isNotYourCorrection()) {
            fillExceptionAction('CORRECCION_NO_PERTENECE_DOCENTE');
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

    function validateDelete() {
         if(!$this->correctionTeacherExistsById()){
             fillExceptionAction('CORRECCION_PROFESOR_NO_EXISTE');
         }
		if($this->isNotTeacher()) {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
		}
        if ($this->isNotYourCorrection()) {
            fillExceptionAction('CORRECCION_NO_PERTENECE_DOCENTE');
        }
    }

    function validateShowCorrection() {
        if(!$this->correctionTeacherExistsById()){
            fillExceptionAction('CORRECCION_PROFESOR_NO_EXISTE');
        }
		if($this->isNotTeacher()) {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
		}
        if ($this->isNotYourCorrection()) {
            fillExceptionAction('CORRECCION_NO_PERTENECE_DOCENTE');
        }
    }

    function isNotYourCorrection() {
        $correction = $this->model->getById(array($this->model->arrayDataValue['id_correccion_profesor']))['resource'];
        return $correction['dni'] != NULL && userSystem != $correction['dni'];
    }

    function correctionTeacherExistsById()  {
        $correctionTeacher = $this->model->getById(array($this->model->arrayDataValue['id_correccion_profesor']))['resource'];
        return !empty($correctionTeacher);
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

    function dniIsTeacher() {
        $student = $this->user->getById(array($this->model->arrayDataValue['dni']))['resource'];
        return !empty($student) && $student['id_rol'] == '2';
    }
}
?>