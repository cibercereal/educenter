<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/criteriaCompetenceValidation.php';

class criteriaCompetenceService extends ServiceBase {

    private $criteriaModel;
    private $competenceModel;
    private $gradeCompetenceModel;
    private $projectModel;

    function startRest() {
        $this->listAttributesEqual = array();
        $this->validateDataAttributes();

        switch(action) {
            case 'add':
                $this->attributeList = array('id_criterio', 'id_competencia');
            break;
            case 'delete':
                $this->attributeList = array('id_criterio', 'id_competencia');
            break;
            case 'search':
                $this->attributeList = array('id_criterio', 'id_competencia');
                $this->listAttributesEqual = array('id_criterio', 'id_competencia');
            break;
        }

        $this->model = $this->createModelOne('criteriaCompetence');
        $this->criteriaModel = $this->createModelOne('criteria');
        $this->competenceModel = $this->createModelOne('competence');
        $this->gradeCompetenceModel = $this->createModelOne('gradeCompetence');
        $this->projectModel = $this->createModelOne('project');
        $this->validationClass = $this->createValidationOne('criteriaCompetence');
        $this->validationClass->model = $this->model;
        $this->validationClass->criteria = $this->criteriaModel;
        $this->validationClass->competence = $this->competenceModel;
        return $this->returnRest(action);
    }

    function returnRest($action) {
        switch(action) {
            case 'add':
                $this->validateAdd();
                $this->gradeCompetenceModel->arrayDataValue = [];
                $criteria = $this->criteriaModel->seek(array("id_criterio"), array($this->model->arrayDataValue['id_criterio']))['resource'];
                $project = $this->projectModel->seek(array("id_trabajo"), array($criteria['id_trabajo']))['resource'];
                $subjectStudentModel = $this->createModelOne('subjectStudent');
                $students = $subjectStudentModel->seek_multiple(array('id_materia', 'aceptado'), array($project['id_materia'], '1'))['resource'];
                foreach($students as $student) {
                    $this->gradeCompetenceModel->arrayDataValue['id_trabajo'] = $criteria['id_trabajo'];
                    $this->gradeCompetenceModel->arrayDataValue['id_materia'] = $project['id_materia'];
                    $this->gradeCompetenceModel->arrayDataValue['id_competencia'] = $this->model->arrayDataValue['id_competencia'];
                    $this->gradeCompetenceModel->arrayDataValue['id_criterio'] = $this->model->arrayDataValue['id_criterio'];
                    $this->gradeCompetenceModel->arrayDataValue['dni'] = $student['dni'];
                    $this->gradeCompetenceModel->ADD();
                }
                return $this->addCriteriaCompetence('ANADIR_CRITERIO_COMPETENCIA_OK');
            break;
            case 'delete':
                $this->validationClass->validateDelete();
                $this->gradeCompetenceModel->arrayDataValue = [];
                $criteria = $this->criteriaModel->seek(array("id_criterio"), array($this->model->arrayDataValue['id_criterio']))['resource'];
                $project = $this->projectModel->seek(array("id_trabajo"), array($criteria['id_trabajo']))['resource'];
                $subjectStudentModel = $this->createModelOne('subjectStudent');
                $students = $subjectStudentModel->seek_multiple(array('id_materia', 'aceptado'), array($project['id_materia'], '1'))['resource'];
                foreach($students as $student) {
                    $this->gradeCompetenceModel->arrayDataValue['id_trabajo'] = $criteria['id_trabajo'];
                    $this->gradeCompetenceModel->arrayDataValue['id_materia'] = $project['id_materia'];
                    $this->gradeCompetenceModel->arrayDataValue['id_competencia'] = $this->model->arrayDataValue['id_competencia'];
                    $this->gradeCompetenceModel->arrayDataValue['dni'] = $student['dni'];
                    $this->gradeCompetenceModel->DELETE();
                }
                return $this->deleteCriteriaCompetence('ELIMINAR_CRITERIO_COMPETENCIA_OK');
            break;
            case 'search':
                $this->model->arrayDataValue['id_criterio'] = isset($this->model->arrayDataValue['id_criterio']) ? $this->model->arrayDataValue['id_criterio'] : '';
                $this->model->arrayDataValue['id_competencia'] = isset($this->model->arrayDataValue['id_competencia']) ? $this->model->arrayDataValue['id_competencia'] : '';
                $this->validateSearch();
                return $this->search();
            break;
        }
    }

    function deleteCriteriaCompetence($msg) {
        $this->model->DELETE();

        return $this->createFeedback($msg);
    }

    function addCriteriaCompetence($msg) {
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