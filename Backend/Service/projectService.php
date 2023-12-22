<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/projectValidation.php';

class projectService extends ServiceBase {

    private $subjectModel;
    private $subjectStudentModel;
    private $subjectAssignmentModel;

    function startRest() {
        $this->listAttributesEqual = array();
        $this->validateDataAttributes();

        switch(action) {
            case 'add':
                $this->attributeList = array('nombre_trabajo', 'descripcion_trabajo', 'porcentaje_nota', 'correccion_nota', 'id_materia', 'fecha_ini', 'fecha_fin');
            break;
            case 'edit':
                $this->attributeList = array('id_trabajo', 'nombre_trabajo', 'descripcion_trabajo', 'porcentaje_nota', 'correccion_nota', 'id_materia', 'fecha_ini', 'fecha_fin');
            break;
            case 'delete':
                $this->attributeList = array('id_trabajo');
            break;
            case 'search':
                $this->attributeList = array('id_trabajo', 'nombre_trabajo', 'descripcion_trabajo', 'porcentaje_nota', 'correccion_nota', 'nota', 'id_materia', 'fecha_ini', 'fecha_fin');
                $this->listAttributesEqual = array('id_materia');
            break;
        }

        $this->model = $this->createModelOne('project');
        $this->subjectModel = $this->createModelOne('subject');
        $this->subjectStudentModel = $this->createModelOne('subjectStudent');
        $this->subjectAssignmentModel = $this->createModelOne('subjectAssignment');
        $this->validationClass = $this->createValidationOne('project');
        $this->validationClass->model = $this->model;
        $this->validationClass->subject = $this->subjectModel;
        $this->validationClass->subjectStudent = $this->subjectStudentModel;
        $this->validationClass->subjectAssignment = $this->subjectAssignmentModel;
        return $this->returnRest(action);
    }

    function returnRest($action) {
        switch(action) {
            case 'add':
                $this->validateAdd();
                return $this->addProject('ANADIR_TRABAJO_OK');
            break;
            case 'edit':
                $this->validateEdit();
                return $this->editProject('EDITAR_TRABAJO_OK');
            break;
            case 'delete':
                $this->validationClass->validateDelete();
                return $this->deleteProject('ELIMINAR_TRABAJO_OK');
            break;
            case 'search':
                $this->model->arrayDataValue['id_trabajo'] = isset($this->model->arrayDataValue['id_trabajo']) ? $this->model->arrayDataValue['id_trabajo'] : '';
                $this->model->arrayDataValue['nombre_trabajo'] = isset($this->model->arrayDataValue['nombre_trabajo']) ? $this->model->arrayDataValue['nombre_trabajo'] : '';
                $this->model->arrayDataValue['porcentaje_nota'] = isset($this->model->arrayDataValue['porcentaje_nota']) ? $this->model->arrayDataValue['porcentaje_nota'] : '';
                $this->model->arrayDataValue['correccion_nota'] = isset($this->model->arrayDataValue['correccion_nota']) ? $this->model->arrayDataValue['correccion_nota'] : '';
                $this->model->arrayDataValue['nota'] = isset($this->model->arrayDataValue['nota']) ? $this->model->arrayDataValue['nota'] : NULL;
                $this->model->arrayDataValue['id_materia'] = isset($this->model->arrayDataValue['id_materia']) ? $this->model->arrayDataValue['id_materia'] : '';
                $this->model->arrayDataValue['fecha_ini'] = isset($this->model->arrayDataValue['fecha_ini']) ? $this->model->arrayDataValue['fecha_ini'] : '';
                $this->model->arrayDataValue['fecha_fin'] = isset($this->model->arrayDataValue['fecha_fin']) ? $this->model->arrayDataValue['fecha_fin'] : '';
                $this->model->arrayDataValue['descripcion_trabajo'] = isset($this->model->arrayDataValue['descripcion_trabajo']) ? $this->model->arrayDataValue['descripcion_trabajo'] : '';
                $this->validateSearch();
                return $this->search();
            break;
        }
    }

    function deleteProject($msg) {
        $this->model->DELETE();

        return $this->createFeedback($msg);
    }

    function editProject($msg) {
        $this->model->EDIT();
        return $this->createFeedback($msg);
    }

    function addProject($msg) {
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