<?php

include_once './Validation/validate.php';

class subjectValidationAction extends Validate {

    function validateAdd() {
        if($this->subjectExists()){
            fillExceptionAction('MATERIA_YA_EXISTE');
		}
        if($this->isNotAdmin()) {
            fillExceptionAction('ACCION_DENEGADA_INSERTAR_MATERIA');
        }
        if (!empty($this->model->arrayDataValue['dni'])) {
            if(!$this->userExists()){
                fillExceptionAction('USUARIO_NO_EXISTE');
            }
            if(!$this->userIsTeacher()){
                fillExceptionAction('USUARIO_NO_ES_PROFESOR');
            }
        }
    }

    function validateEdit() {
        if(!$this->subjectIdIsSame()){
            fillExceptionAction('MATERIA_YA_EXISTE');
        }
        if($this->isNotAdmin()) {
            fillExceptionAction('ACCION_DENEGADA_EDITAR_MATERIA');
        }
        if(!empty($this->model->arrayDataValue['dni']) && !$this->userExists()){
            fillExceptionAction('USUARIO_NO_EXISTE');
        }
        if(!empty($this->model->arrayDataValue['dni']) && !$this->userIsTeacher()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
        }
    }

    function validateDelete() {
        if (!$this->subjectExistsById()) {
            fillExceptionAction('MATERIA_NO_EXISTE');
        }
        if($this->isNotAdmin()) {
            fillExceptionAction('ACCION_DENEGADA_ELIMINAR_MATERIA');
        }
    }

    function validateSearch() {
        // N/A
    }

    function validateAssignTeacher() {
        if(!$this->subjectExistsById()){
            fillExceptionAction('MATERIA_NO_EXISTE');
        }
        if($this->isNotAdmin()) {
            fillExceptionAction('ACCION_DENEGADA_ASIGNAR_MATERIA');
        }
        if(!$this->userExists()){
            fillExceptionAction('USUARIO_NO_EXISTE');
        }
        if(!$this->userIsTeacher()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
        }
    }

    function userIsTeacher() {
        $user = $this->user->getById(array($this->model->arrayDataValue['dni']));
        return !empty($user['resource']) && $user['resource']['id_rol'] == '2';
    }

    function userExists() {
        $user = $this->user->getById(array($this->model->arrayDataValue['dni']));
        return !empty($user['resource']) && $user['resource']['borrado_logico'] == '0';
    }

    function subjectIdIsSame() {
        $subject = $this->model->seek(array("nombre_materia"), array($this->model->arrayDataValue['nombre_materia']));
        return $subject['resource']['id_materia'] == $this->model->arrayDataValue['id_materia'];
    }

    function subjectExists() {
        $subject = $this->model->seek(array("nombre_materia"), array($this->model->arrayDataValue['nombre_materia']));
        return !empty($subject['resource']);
    }

    function subjectExistsById() {
        $subject = $this->model->getById(array($this->model->arrayDataValue['id_materia']));
        return !empty($subject['resource']);
    }

    function isNotAdmin() {
        return rolUserSystem != '1';
    }
}
?>