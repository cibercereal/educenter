<?php

include_once './Validation/validate.php';

class subjectStudentValidationAction extends Validate {

    function validateSearch() {
        // N/A
    }

    function validateAdd() {
        if (!$this->subjectExistsById()) {
            fillExceptionAction('MATERIA_NO_EXISTE');
        }
        if(!$this->userIsStudent()) {
            fillExceptionAction('ACCION_DENEGADA_SOLICITAR_MATERIA');
        }
        // Comprobar que para los campos insertados no existe ya tupla
        if($this->checkSubjectStudentExists()) {
            fillExceptionAction('MATERIA_YA_SOLICITADA');
        }
        if ($this->model->arrayDataValue['dni'] !== userSystem) {
            fillAttributeException('USUARIO_NO_EN_SESION');
        }
    }

    function validateDelete() {
        if (!$this->subjectExistsById()) {
            fillExceptionAction('MATERIA_NO_EXISTE');
        }
        if(!$this->userIsStudent()) {
            fillExceptionAction('ACCION_DENEGADA_BORRAR_SOLICITAR_MATERIA');
        }
        if(!$this->checkSubjectStudentExists()) {
            fillExceptionAction('MATERIA_NO_SOLICITADA');
        }
        if ($this->model->arrayDataValue['dni'] !== userSystem) {
            fillAttributeException('USUARIO_NO_EN_SESION');
        }
    }

    function validateEdit() {
        if (!$this->subjectExistsById()) {
            fillExceptionAction('MATERIA_NO_EXISTE');
        }
        if(!$this->userIsStudent() && !$this->userIsTeacher() ) {
            fillExceptionAction('ACCION_DENEGADA_RESOLVER_SOLICITAR_MATERIA');
        }
        if (!$this->checkIsTeacherSubject()) {
            fillAttributeException('USUARIO_NO_EN_SESION');
        }
    }

    function checkIsTeacherSubject() {
        $subject = $this->subject->getById(array($this->model->arrayDataValue['id_materia']));
        return !empty($subject['resource']) && $subject['resource']['dni'] == userSystem;
    }

    function checkSubjectStudentExists() {
        $subjectStudent = $this->model->seek(array("id_materia", 'dni'), array($this->model->arrayDataValue['id_materia'], $this->model->arrayDataValue['dni']));
        return !empty($subjectStudent['resource']) && $subjectStudent['resource']['aceptado'] == NULL;
    }

    function userIsStudent() {
        $user = $this->user->getById(array($this->model->arrayDataValue['dni']));
        return !empty($user['resource']) && $user['resource']['id_rol'] == '3';
    }

    function userIsTeacher() {
        $user = $this->user->getById(array(userSystem));
        return !empty($user['resource']) && $user['resource']['id_rol'] == '2';
    }

    function subjectExistsById() {
        $subject = $this->subject->getById(array($this->model->arrayDataValue['id_materia']));
        return !empty($subject['resource']);
    }
}
?>