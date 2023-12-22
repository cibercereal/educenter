<?php

include_once './Validation/validate.php';

class gradeCompetenceValidationAction extends Validate {

    function validateEdit() {
		if(!$this->subjectExistsById()){
            fillExceptionAction('MATERIA_NO_EXISTE');
		}
        if(!$this->userIsTeacher()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
        }
        if($this->isNotPpalTeacherBySession() && !$this->isSecondaryTeacher()) {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR_MATERIA');
        }
    }

    function validateSearch() {
 		if($this->isAdmin()) {
             fillExceptionAction('USUARIO_NO_ES_PROFESOR_O_ALUMNO');
 		}
        if($this->isTeacher()) {
            if($this->isNotPpalTeacherBySession() && !$this->isSecondaryTeacher()) {
                fillExceptionAction('USUARIO_NO_ES_PROFESOR_MATERIA');
            }
        }
    }

    function validateMakeVisible() {
		if(!$this->subjectExistsById()){
            fillExceptionAction('MATERIA_NO_EXISTE');
		}
		if(!$this->projectExistsById()){
            fillExceptionAction('TRABAJO_NO_EXISTE');
		}
		if(!$this->competenceExistsById()){
            fillExceptionAction('COMPETENCIA_NO_EXISTE');
		}
	    if(!$this->dniExists()){
            fillExceptionAction('USUARIO_NO_EXISTE');
		}
        if(!$this->userIsTeacher()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
        }
        if($this->isNotPpalTeacherBySession() && !$this->isSecondaryTeacher()) {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR_MATERIA');
        }
    }

    function dniExists() {
        $user = $this->user->getById(array($this->model->arrayDataValue['dni']));
        return !empty($user['resource']) && $user['resource']['borrado_logico'] == '0';
    }

    function projectExistsById() {
        $project = $this->project->getById(array($this->model->arrayDataValue['id_trabajo']));
        return !empty($project['resource']);
    }

    function subjectExistsById() {
        $subject = $this->subject->getById(array($this->model->arrayDataValue['id_materia']));
        return !empty($subject['resource']);
    }

    function competenceExistsById() {
        $competence = $this->competence->getById(array($this->model->arrayDataValue['id_competencia']));
        return !empty($competence['resource']);
    }

    function userIsTeacher() {
        return rolUserSystem == '2';
    }

    function isNotPpalTeacherBySession() {
        $subject = $this->subject->seek_multiple(array('dni'), array(userSystem));

        return empty($subject['resource']);
    }

    function isSecondaryTeacher() {
        $teachers = $this->subjectAssignment->seek_multiple(array('dni'), array(userSystem));
        $isSecondaryTeacher = false;
        foreach ($teachers['resource'] as $teacher) {
            if ($teacher['secundario'] == '1') {
                $isSecondaryTeacher = true;
                break;
            }
        }

        return $isSecondaryTeacher;
    }

    function isAdmin() {
        return rolUserSystem == '1';
    }

    function isTeacher() {
        return rolUserSystem == '2';
    }
}
?>