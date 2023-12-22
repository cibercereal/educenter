<?php

include_once './Validation/validate.php';

class projectValidationAction extends Validate {

    function validateAdd() {
        if($this->projectExists()){
            fillExceptionAction('TRABAJO_YA_EXISTE');
		}
        if(!$this->userIsTeacher()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
        }
        if($this->isNotPpalTeacher()) {
            fillExceptionAction('USUARIO_NO_PROFESOR_PPAL');
        }
    }

    function validateEdit() {
        if (!$this->projectExistsById()) {
            fillExceptionAction('TRABAJO_NO_EXISTE');
        }
        if(!$this->userIsTeacher()) {
            fillExceptionAction('ACCION_DENEGADA_MODIFICAR_TRABAJO');
        }
        if($this->isNotPpalTeacher() && !$this->isSecondaryTeacher()) {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR_MATERIA');
        }
    }

    function validateDelete() {
        if (!$this->projectExistsById()) {
            fillExceptionAction('TRABAJO_NO_EXISTE');
        }
        if(!$this->userIsTeacher()) {
            fillExceptionAction('ACCION_DENEGADA_ELIMINAR_TRABAJO');
        }
        if($this->isNotPpalTeacherByProjectId() && !$this->isSecondaryTeacher()) {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR_MATERIA');
        }
    }

    function validateSearch() {
        if (rolUserSystem == '2') {
             if($this->isNotPpalTeacherBySession() && !$this->isSecondaryTeacher()) {
                 fillExceptionAction('USUARIO_NO_ES_PROFESOR_MATERIA');
             }
        }
        if (rolUserSystem == '3') {
             if(!$this->isNotSubjectStudent()) {
                 fillExceptionAction('USUARIO_NO_ES_ALUMNO_MATERIA');
             }
        }
    }

    function isNotSubjectStudent() {
        $students = $this->subjectStudent->seek_multiple(array('dni'), array(userSystem));
        $isSubjectStudent = false;
        foreach ($students['resource'] as $student) {
            if ($student['aceptado'] == '1') {
                $isSubjectStudent = true;
                break;
            }
        }

        return $isSubjectStudent;
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

    function isNotPpalTeacher() {
        $subject = $this->subject->getById(array($this->model->arrayDataValue['id_materia']));
        return !empty($subject['resource']) && userSystem != $subject['resource']['dni'];
    }

    function isNotPpalTeacherByProjectId() {
        $project = $this->model->getById(array($this->model->arrayDataValue['id_trabajo']));
        $subject = $this->subject->getById(array($project['resource']['id_materia']));
        return !empty($subject['resource']) && userSystem != $subject['resource']['dni'];
    }

    function isNotPpalTeacherBySession() {
        $subject = $this->subject->seek_multiple(array('dni'), array(userSystem));

        return empty($subject['resource']);
    }

    function userIsTeacher() {
        return rolUserSystem == '2';
    }

    function projectExistsById() {
        $project = $this->model->getById(array($this->model->arrayDataValue['id_trabajo']));
        return !empty($project['resource']);
    }

    function projectExists()  {
        $projects = $this->model->seek_multiple(array("nombre_trabajo"), array($this->model->arrayDataValue['nombre_trabajo']))['resource'];
        $projectExists = false;
        foreach ($projects as $project) {
            if ($project['id_materia'] == $this->model->arrayDataValue['id_materia']) {
                $projectExists = true;
                break;
            }
        }
        return $projectExists;
    }
}
?>