<?php

include_once './Validation/validate.php';

class subjectAssignmentValidationAction extends Validate {

    function validateSearch() {
        // N/A
    }

    function validateAdd() {
        if (!$this->subjectExistsById()) {
            fillExceptionAction('MATERIA_NO_EXISTE');
        }
        if(!$this->userIsTeacher()) {
            fillExceptionAction('ACCION_DENEGADA_SOLICITAR_MATERIA');
        }
        // Comprobar que para los campos insertados no existe ya tupla
        if($this->checkSubjectAssignmentExists()) {
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
        if(!$this->userIsTeacher()) {
            fillExceptionAction('ACCION_DENEGADA_BORRAR_SOLICITAR_MATERIA');
        }
        if(!$this->checkSubjectAssignmentExists()) {
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
         if(!$this->userIsTeacher()) {
             fillExceptionAction('ACCION_DENEGADA_EDITAR_MATERIA');
         }
         // Comprobar que para los campos insertados existe ya tupla
         if(!$this->checkSubjectAssignmentExists()) {
             fillExceptionAction('MATERIA_NO_SOLICITADA');
         }
         if ($this->checkSubjectIsTeacherFree()) {
             fillAttributeException('MATERIA_NO_ASIGNADA');
         }
         if ($this->isNotPpalTeacher()) {
             fillAttributeException('USUARIO_NO_PROFESOR_PPAL');
         }
    }

    function isNotPpalTeacher() {
        $subject = $this->subject->getById(array($this->model->arrayDataValue['id_materia']));
        return !empty($subject['resource']) && userSystem != $subject['resource']['dni'];
    }

    function checkSubjectIsTeacherFree() {
        $subject = $this->subject->getById(array($this->model->arrayDataValue['id_materia']));
        return empty($subject['resource']['dni']);
    }

    function checkSubjectAssignmentExists() {
        $subjectAssignment = $this->model->seek(array("id_materia", 'dni'), array($this->model->arrayDataValue['id_materia'], $this->model->arrayDataValue['dni']));
        return !empty($subjectAssignment['resource']);
    }

    function userIsTeacher() {
        $user = $this->user->getById(array($this->model->arrayDataValue['dni']));
        return !empty($user['resource']) && $user['resource']['id_rol'] == '2';
    }

    function subjectExistsById() {
        $subject = $this->subject->getById(array($this->model->arrayDataValue['id_materia']));
        return !empty($subject['resource']);
    }
}
?>