<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/subjectStudentValidation.php';

class subjectStudentService extends ServiceBase {

    private $user;
    private $subject;

    function startRest() {
        $this->listAttributesEqual = array();
        $this->validateDataAttributes();

        switch(action) {
            case 'add':
                $this->attributeList = array('id_materia', 'dni');
            break;
            case 'edit':
                $this->attributeList = array('id_materia', 'dni', 'aceptado');
            break;
            case 'delete':
                $this->attributeList = array('id_materia', 'dni');
            break;
            case 'search':
                $this->attributeList = array('id_materia', 'dni', 'aceptado');
            break;
        }

        $this->model = $this->createModelOne('subjectStudent');
        $this->user = $this->createModelOne('user');
        $this->subject = $this->createModelOne('subject');
        $this->validationClass = $this->createValidationOne('subjectStudent');
        $this->validationClass->model = $this->model;
        $this->validationClass->subject = $this->subject;
        $this->validationClass->user = $this->user;
        return $this->returnRest(action);
    }

    function returnRest($action) {
        switch(action) {
            case 'add':
                $this->validateAdd();
                return $this->addSubjectStudent('ANADIR_USUARIO_MATERIA_OK');
            break;
            case 'edit':
                $this->validateEdit();
                return $this->editSubjectStudent('EDITAR_USUARIO_MATERIA_OK');
            break;
            case 'delete':
                $this->validationClass->validateDelete();
                return $this->deleteSubjectStudent('ELIMINAR_USUARIO_MATERIA_OK');
            break;
            case 'search':
                $this->model->arrayDataValue['id_materia'] = isset($this->model->arrayDataValue['id_materia']) ? $this->model->arrayDataValue['id_materia'] : '';
                $this->model->arrayDataValue['dni'] = isset($this->model->arrayDataValue['dni']) ? $this->model->arrayDataValue['dni'] : '';
                $this->model->arrayDataValue['aceptado'] = isset($this->model->arrayDataValue['aceptado']) ? $this->model->arrayDataValue['aceptado'] : '';
                $this->validateSearch();
                return $this->search();
            break;
        }
    }

    function deleteSubjectStudent($msg) {
        $this->model->DELETE();

        return $this->createFeedback($msg);
    }

    function editSubjectStudent($msg) {
        $this->model->EDIT();
        return $this->createFeedback($msg);
    }

    function addSubjectStudent($msg) {
        $this->model->ADD();
        return $this->createFeedback($msg);
    }

    function createFeedback($message) {
        $this->feedback['code'] = $message;
        $this->feedback['ok'] = true;
        return $this->feedback;
    }
}
?>