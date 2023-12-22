<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/gradeProjectValidation.php';

class gradeProjectService extends ServiceBase {

    private $projectModel;
    private $deliveryModel;
    private $subject;
    private $subjectTeacher;
    private $subjectStudent;

    function startRest() {
        $this->listAttributesEqual = array();
        $this->validateDataAttributes();

        switch(action) {
            case 'add':
                $this->attributeList = array('id_trabajo', 'id_entrega');
            break;
            case 'edit':
                $this->attributeList = array('id_trabajo', 'id_entrega', 'nota_trabajo', 'nota_correccion', 'dni', 'visible');
            break;
            case 'search':
                $this->attributeList = array('id_trabajo', 'id_entrega', 'nota_trabajo', 'nota_correccion', 'dni', 'visible');
            break;
        }

        $this->model = $this->createModelOne('gradeProject');
        $this->projectModel = $this->createModelOne('project');
        $this->deliveryModel = $this->createModelOne('delivery');
        $this->subject = $this->createModelOne('subject');
        $this->subjectTeacher = $this->createModelOne('subjectAssignment');
        $this->subjectStudent = $this->createModelOne('subjectStudent');
        $this->validationClass = $this->createValidationOne('gradeProject');
        $this->validationClass->model = $this->model;
        $this->validationClass->project = $this->projectModel;
        $this->validationClass->delivery = $this->deliveryModel;
        $this->validationClass->subject = $this->subject;
        $this->validationClass->subjectTeacher = $this->subjectTeacher;
        $this->validationClass->subjectStudent = $this->subjectStudent;
        return $this->returnRest(action);
    }

    function returnRest($action) {
        switch(action) {
            case 'add':
                $this->validateAdd();
                return $this->addGradeProject('ANADIR_CALCULAR_NOTA_OK');
            break;
            case 'edit':
                $this->validateEdit();
                $this->calculateGrades();
                return $this->editGradeProject('EDITAR_CALCULAR_NOTA_OK');
            break;
            case 'search':
                $this->model->arrayDataValue['id_trabajo'] = isset($this->model->arrayDataValue['id_trabajo']) ? $this->model->arrayDataValue['id_trabajo'] : '';
                $this->model->arrayDataValue['id_entrega'] = isset($this->model->arrayDataValue['id_entrega']) ? $this->model->arrayDataValue['id_entrega'] : '';
                $this->model->arrayDataValue['nota_trabajo'] = isset($this->model->arrayDataValue['nota_trabajo']) ? $this->model->arrayDataValue['nota_trabajo'] : '';
                $this->model->arrayDataValue['nota_correccion'] = isset($this->model->arrayDataValue['nota_correccion']) ? $this->model->arrayDataValue['nota_correccion'] : '';
                $this->model->arrayDataValue['dni'] = isset($this->model->arrayDataValue['dni']) ? $this->model->arrayDataValue['dni'] : '';
                $this->model->arrayDataValue['visible'] = isset($this->model->arrayDataValue['visible']) ? $this->model->arrayDataValue['visible'] : '';
                $this->validateSearch();
                return $this->search();
            break;
        }
    }

    function editGradeProject($msg) {
        $this->model->EDIT();
        return $this->createFeedback($msg);
    }

    function addGradeProject($msg) {
        $this->model->ADD();
        return $this->createFeedback($msg);
    }

    function calculateGrades() {
        $projectId = $this->model->arrayDataValue['id_trabajo'];
        $deliveryId = $this->model->arrayDataValue['id_entrega'];
        $project = $this->projectModel->seek(array('id_trabajo'), array($projectId))['resource'];
        $delivery = $this->deliveryModel->seek(array('id_entrega'), array($deliveryId))['resource'];
        $correctionTeacher = $this->createModelOne('correctionTeacher')->seek_multiple(array('id_trabajo', 'id_entrega'), array($projectId, $deliveryId))['resource'];
        $numberOfElems = 0;
        $correct = 0;
        foreach ($correctionTeacher as $correction) {
            $numberOfElems++;
            if ($correction['correccion_docente'] == '1') {
                $correct++;
            }
        }
        $projectGrade = round($correct != 0 && $numberOfElems != 0 ? ($correct * 10) / $numberOfElems : 0, 2);
        $correctionStudent = $this->createModelOne('correctionCriteria')->seek_multiple(array('id_trabajo', 'dni_alumno'), array($projectId, $delivery['dni']))['resource'];
        $elems = 0;
        $correctionsOk = 0;
        foreach ($correctionStudent as $correction) {
            $elems++;
            if ($correction['correccion_alumno'] == $correction['correccion_docente'] || ($correction['comentario_docente'] != NULL && $correction['comentario_docente'] != "")) {
                $correctionsOk++;
            }
        }
        $correctionGrade = round($correctionsOk != 0 && $elems != 0 ? ($correctionsOk * 10) / $elems : 0, 2);
        $this->model->arrayDataValue['nota_trabajo'] = $projectGrade;
        $this->model->arrayDataValue['nota_correccion'] = $correctionGrade;
        $this->model->arrayDataValue['dni'] = $delivery['dni'];
    }

    function createFeedback($message) {
        $this->feedback['code'] = $message;
        $this->feedback['ok'] = true;
        return $this->feedback;
    }
}
?>