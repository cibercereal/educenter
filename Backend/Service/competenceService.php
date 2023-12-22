<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/competenceValidation.php';

class competenceService extends ServiceBase {

    private $subjectModel;
    private $projectModel;

    function startRest() {
        $this->listAttributesEqual = array();
        $this->validateDataAttributes();

        switch(action) {
            case 'add':
                $this->attributeList = array('titulo', 'descripcion');
            break;
            case 'edit':
                $this->attributeList = array('id_competencia', 'titulo', 'descripcion', 'id_materia');
            break;
            case 'delete':
                $this->attributeList = array('id_competencia');
            break;
            case 'search':
                $this->attributeList = array('titulo', 'descripcion', 'id_materia');
                $this->listAttributesEqual = array('id_materia');
            break;
            case 'assignCompetence':
                $this->attributeList = array('id_competencia', 'id_materia');
            break;
        }

        $this->model = $this->createModelOne('competence');
        $this->subjectModel = $this->createModelOne('subject');
        $this->projectModel = $this->createModelOne('project');
        $this->validationClass = $this->createValidationOne('competence');
        $this->validationClass->model = $this->model;
        $this->validationClass->subjectModel = $this->subjectModel;
        $this->validationClass->projectModel = $this->projectModel;
        return $this->returnRest(action);
    }

    function returnRest($action) {
        switch(action) {
            case 'add':
                $this->validateAdd();
                return $this->addCompetence('ANADIR_COMPETENCIA_OK');
            break;
            case 'edit':
                $this->model->arrayDataValue['id_materia'] = !empty($this->model->arrayDataValue['id_materia']) ? $this->model->arrayDataValue['id_materia'] : NULL;
                $this->validateEdit();
                return $this->editCompetence('EDITAR_COMPETENCIA_OK');
            break;
            case 'delete':
                $this->validationClass->validateDelete();
                return $this->deleteCompetence('ELIMINAR_COMPETENCIA_OK');
            break;
            case 'search':
                $this->model->arrayDataValue['titulo'] = isset($this->model->arrayDataValue['titulo']) ? $this->model->arrayDataValue['titulo'] : '';
                $this->model->arrayDataValue['descripcion'] = isset($this->model->arrayDataValue['descripcion']) ? $this->model->arrayDataValue['descripcion'] : '';
                $this->model->arrayDataValue['id_materia'] = isset($this->model->arrayDataValue['id_materia']) ? $this->model->arrayDataValue['id_materia'] : '';
                $this->validateSearch();
                return $this->search();
            break;
            case 'assignCompetence':
               $this->model->arrayDataValue['id_materia'] = !empty($this->model->arrayDataValue['id_materia']) ? $this->model->arrayDataValue['id_materia'] : NULL;
               $this->validationClass->validateAssignCompetence();
               return $this->assignCompetence('ASIGNAR_COMPETENCIA_OK');
            break;
        }
    }

    function assignCompetence($msg) {
        $this->model->EDIT();
        return $this->createFeedback($msg);
    }

    function deleteCompetence($msg) {
        $this->model->DELETE();
        return $this->createFeedback($msg);
    }

    function editCompetence($msg) {
        $this->model->EDIT();
        return $this->createFeedback($msg);
    }

    function addCompetence($msg) {
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