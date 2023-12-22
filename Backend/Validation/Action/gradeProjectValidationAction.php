<?php

include_once './Validation/validate.php';

class gradeProjectValidationAction extends Validate {

    function validateAdd() {
        if(!$this->projectExistsById()){
            fillExceptionAction('TRABAJO_NO_EXISTE');
		}
		if(!$this->deliveryExistsById()){
            fillExceptionAction('ENTREGA_NO_EXISTE');
		}
        if(!$this->userIsTeacher()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
        }
        if($this->isNotPpalTeacherBySession() && !$this->isSecondaryTeacher()) {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR_MATERIA');
        }
    }

    function validateEdit() {
        if(!$this->projectExistsById()){
            fillExceptionAction('TRABAJO_NO_EXISTE');
		}
		if(!$this->deliveryExistsById()){
            fillExceptionAction('ENTREGA_NO_EXISTE');
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
        if (!$this->userIsSubjectTeacher() && !$this->userIsSubjectStudent()) {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR_O_ALUMNO_MATERIA');
        }
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

    function projectExistsById() {
        $project = $this->project->getById(array($this->model->arrayDataValue['id_trabajo']));
        return !empty($project['resource']);
    }

    function deliveryExistsById() {
        $project = $this->delivery->getById(array($this->model->arrayDataValue['id_entrega']));
        return !empty($project['resource']);
    }

    function userIsTeacher() {
        return rolUserSystem == '2';
    }

    function isNotPpalTeacherBySession() {
        $subject = $this->subject->seek_multiple(array('dni'), array(userSystem));

        return empty($subject['resource']);
    }

    function isSecondaryTeacher() {
        $teachers = $this->subjectTeacher->seek_multiple(array('dni'), array(userSystem));
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
}
?>