<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/criteriaValidation.php';

class criteriaService extends ServiceBase {

    private $projectModel;
    private $subjectTeacherModel;
    private $subjectModel;
    private $subjectStudentModel;

    function startRest() {
        $this->listAttributesEqual = array();
        $this->validateDataAttributes();

        switch(action) {
            case 'add':
                $this->attributeList = array('descripcion', 'id_trabajo');
            break;
            case 'edit':
                $this->attributeList = array('id_criterio', 'descripcion', 'id_trabajo');
            break;
            case 'delete':
                $this->attributeList = array('id_criterio');
            break;
            case 'search':
                $this->attributeList = array('descripcion', 'id_trabajo');
                $this->listAttributesEqual = array('descripcion', 'id_trabajo');
            break;
        }

        $this->model = $this->createModelOne('criteria');
        $this->subjectTeacherModel = $this->createModelOne('subjectAssignment');
        $this->subjectModel = $this->createModelOne('subject');
        $this->projectModel = $this->createModelOne('project');
        $this->subjectStudentModel = $this->createModelOne('subjectStudent');
        $this->validationClass = $this->createValidationOne('criteria');
        $this->validationClass->model = $this->model;
        $this->validationClass->project = $this->projectModel;
        $this->validationClass->subjectTeacher = $this->subjectTeacherModel;
        $this->validationClass->subject = $this->subjectModel;
        $this->validationClass->subjectStudent = $this->subjectStudentModel;
        return $this->returnRest(action);
    }

    function returnRest($action) {
        switch(action) {
            case 'add':
                $this->validateAdd();
                return $this->addDelivery('ANADIR_CRITERIO_OK');
            break;
            case 'edit':
                $this->validateEdit();
                return $this->editDelivery('EDITAR_CRITERIO_OK');
            break;
            case 'delete':
                $this->validationClass->validateDelete();
                return $this->deleteDelivery('ELIMINAR_CRITERIO_OK');
            break;
            case 'search':
                $this->model->arrayDataValue['descripcion'] = isset($this->model->arrayDataValue['descripcion']) ? $this->model->arrayDataValue['descripcion'] : '';
                $this->model->arrayDataValue['id_trabajo'] = isset($this->model->arrayDataValue['id_trabajo']) ? $this->model->arrayDataValue['id_trabajo'] : '';
                $this->validateSearch();
                return $this->search();
            break;
        }
    }

    function editDelivery($msg) {
        $this->model->EDIT();
        return $this->createFeedback($msg);
    }

    function deleteDelivery($msg) {
        $this->model->DELETE();

        return $this->createFeedback($msg);
    }

    function addDelivery($msg) {
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