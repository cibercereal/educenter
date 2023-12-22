<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/gradeCompetenceValidation.php';

class gradeCompetenceService extends ServiceBase {

    private $project;
    private $competence;
    private $subject;
    private $subjectAssignment;
    private $subjectStudent;
    private $criteriaCompetence;
    private $correctionTeacher;
    private $criteria;
    private $delivery;
    private $user;

    function startRest() {
        $this->listAttributesEqual = array();
        $this->validateDataAttributes();

        switch(action) {
            case 'edit':
                $this->attributeList = array('id_materia');
            break;
            case 'search':
                $this->attributeList = array('id_trabajo', 'id_materia', 'id_competencia', 'nota_competencia', 'dni', 'visible');
            break;
            case 'makeVisible':
                $this->attributeList = array('id_trabajo', 'id_materia', 'id_competencia', 'dni', 'id_criterio', 'visible');
            break;
        }

        $this->model = $this->createModelOne('gradeCompetence');
        $this->project = $this->createModelOne('project');
        $this->competence = $this->createModelOne('competence');
        $this->subject = $this->createModelOne('subject');
        $this->subjectStudent = $this->createModelOne('subjectStudent');
        $this->subjectAssignment = $this->createModelOne('subjectAssignment');
        $this->criteriaCompetence = $this->createModelOne('criteriaCompetence');
        $this->correctionTeacher = $this->createModelOne('correctionTeacher');
        $this->criteria = $this->createModelOne('criteria');
        $this->delivery = $this->createModelOne('delivery');
        $this->user = $this->createModelOne('user');
        $this->validationClass = $this->createValidationOne('gradeCompetence');
        $this->validationClass->model = $this->model;
        $this->validationClass->project = $this->project;
        $this->validationClass->competence = $this->competence;
        $this->validationClass->subject = $this->subject;
        $this->validationClass->subjectAssignment = $this->subjectAssignment;
        $this->validationClass->user = $this->user;
        return $this->returnRest(action);
    }

    function returnRest($action) {
        switch(action) {
            case 'edit':
                $this->validateEdit();
                $this->calculateGrades();
                return $this->createFeedback('EDITAR_NOTA_COMPETENCIA_OK');
            break;
            case 'search':
                $this->model->arrayDataValue['id_materia'] = isset($this->model->arrayDataValue['id_materia']) ? $this->model->arrayDataValue['id_materia'] : '';
                $this->model->arrayDataValue['id_trabajo'] = isset($this->model->arrayDataValue['id_trabajo']) ? $this->model->arrayDataValue['id_trabajo'] : '';
                $this->model->arrayDataValue['id_competencia'] = isset($this->model->arrayDataValue['id_competencia']) ? $this->model->arrayDataValue['id_competencia'] : '';
                $this->model->arrayDataValue['nota_competencia'] = isset($this->model->arrayDataValue['nota_competencia']) ? $this->model->arrayDataValue['nota_competencia'] : '';
                $this->model->arrayDataValue['dni'] = isset($this->model->arrayDataValue['dni']) ? $this->model->arrayDataValue['dni'] : '';
                $this->model->arrayDataValue['visible'] = isset($this->model->arrayDataValue['visible']) ? $this->model->arrayDataValue['visible'] : '';
                $this->validateSearch();
                return $this->search();
            break;
            case 'makeVisible':
                $this->validationClass->validateMakeVisible();
                return $this->makeVisible('PUBLICAR_NOTA_COMPETENCIA_OK');
            break;
        }
    }

    function makeVisible($msg) {
        $this->model->EDIT();
        return $this->createFeedback($msg);
    }

    function calculateGrades() {
        $criteriaMap = array();
        $subjectId = $this->model->arrayDataValue['id_materia'];
        $projects = $this->project->seek_multiple(array('id_materia'), array($subjectId))['resource'];
        $competences = $this->competence->seek_multiple(array('id_materia'), array($subjectId))['resource'];
        $students = $this->subjectStudent->seek_multiple(array('id_materia', 'aceptado'), array($subjectId, '1'))['resource'];

        $uniqueCriterias = array();

        foreach ($projects as $project) {
            $criterias = $this->criteria->seek_multiple(array('id_trabajo'), array($project['id_trabajo']))['resource'];
            foreach ($criterias as $criterium) {
                $criteriumId = $criterium['id_criterio'];
                foreach ($competences as $competence) {
                    $criteriaCompetence = $this->criteriaCompetence->seek(array('id_criterio', 'id_competencia'), array($criteriumId, $competence['id_competencia']))['resource'];
                    if (!empty($criteriaCompetence)) {
                        foreach ($students as $student) {
                            $delivery = $this->delivery->seek(array('id_trabajo', 'dni'), array($project['id_trabajo'], $student['dni']))['resource'];
                            if (!empty($delivery)) {
                                $correctionTeacher = $this->correctionTeacher->seek(array('id_criterio', 'id_trabajo', 'id_entrega'), array($criteriumId, $project['id_trabajo'], $delivery['id_entrega']))['resource'];
                                if (!empty($correctionTeacher)) {
                                    $this->model->arrayDataValue['nota_competencia'] = $correctionTeacher['correccion_docente'];
                                    $this->model->arrayDataValue['id_trabajo'] = $project['id_trabajo'];
                                    $this->model->arrayDataValue['id_materia'] = $subjectId;
                                    $this->model->arrayDataValue['id_competencia'] = $competence['id_competencia'];
                                    $this->model->arrayDataValue['dni'] = $student['dni'];
                                    $this->model->arrayDataValue['id_criterio'] = $criteriumId;
                                    $this->model->EDIT();
                                }
                            }
                        }
                    } else { // TODO
                        // No hay correspondencia criterio-competencia
                    }
                }
            }
        }
    }

    function createFeedback($message) {
        $this->feedback['code'] = $message;
        $this->feedback['ok'] = true;
        return $this->feedback;
    }
}
?>