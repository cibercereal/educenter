<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/subjectAssignmentValidation.php';

class subjectAssignmentService extends ServiceBase {

    private $user;
    private $subject;

    function startRest() {
        $this->listAttributesEqual = array();
        $this->validateDataAttributes();

        switch(action) {
            case 'add':
                $this->attributeList = array('id_materia', 'dni');
            break;
            case 'delete':
                $this->attributeList = array('id_materia', 'dni');
            break;
            case 'edit':
                $this->attributeList = array('id_materia', 'dni', 'secundario');
            break;
            case 'search':
                $this->attributeList = array('id_materia', 'dni', 'secundario');
            break;
        }

        $this->model = $this->createModelOne('subjectAssignment');
        $this->user = $this->createModelOne('user');
        $this->subject = $this->createModelOne('subject');
        $this->validationClass = $this->createValidationOne('subjectAssignment');
        $this->validationClass->model = $this->model;
        $this->validationClass->user = $this->user;
        $this->validationClass->subject = $this->subject;
        return $this->returnRest(action);
    }

    function returnRest($action) {
        switch(action) {
            case 'add':
                $this->validateAdd();
                return $this->addSubjectAssignment('SOLICITUD_ASIGNACION_OK');
            break;
            case 'delete':
                $this->validationClass->validateDelete();
                return $this->deleteSubjectAssignment('BORRAR_ASIGNACION_OK');
            break;
            case 'search':
                $this->model->arrayDataValue['id_materia'] = isset($this->model->arrayDataValue['id_materia']) ? $this->model->arrayDataValue['id_materia'] : NULL;
                $this->model->arrayDataValue['dni'] = isset($this->model->arrayDataValue['dni']) ? $this->model->arrayDataValue['dni'] : NULL;
                $this->model->arrayDataValue['secundario'] = isset($this->model->arrayDataValue['secundario']) ? $this->model->arrayDataValue['secundario'] : NULL;
                $this->validateSearch();
                return $this->search();
            break;
            case 'edit':
                $this->validateEdit();
                return $this->editSubjectAssignment('EDITAR_ASIGNACION_OK');
            break;
        }
    }

    function editSubjectAssignment($msg) {
        $this->model->EDIT();
        return $this->createFeedback($msg);
    }

    function deleteSubjectAssignment($msg) {
        $this->model->DELETE();
        return $this->createFeedback($msg);
    }

    function addSubjectAssignment($msg) {
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