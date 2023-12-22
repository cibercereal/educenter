<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/correctionTeacherValidation.php';

class correctionTeacherService extends ServiceBase {

    private $userModel;
    private $projectModel;
    private $subjectModel;
    private $subjectTeacherModel;
    private $deliveryModel;
    private $subjectStudentModel;

    function startRest() {
        $this->listAttributesEqual = array();
        $this->validateDataAttributes();

        switch(action) {
            case 'edit':
                $this->attributeList = array('id_correccion_profesor', 'correccion_docente', 'comentario_docente');
            break;
            case 'search':
                $this->attributeList = array('id_criterio', 'id_trabajo', 'id_entrega', 'dni', 'correccion_docente');
                $this->listAttributesEqual = array('id_criterio', 'id_trabajo', 'id_entrega', 'dni', 'correccion_docente');
            break;
            case 'delete':
                $this->attributeList = array('id_correccion_profesor');
            break;
            case 'showCorrection':
                $this->attributeList = array('id_correccion_profesor', 'visible');
            break;
        }

        $this->model = $this->createModelOne('correctionTeacher');
        $this->userModel = $this->createModelOne('user');
        $this->projectModel = $this->createModelOne('project');
        $this->subjectModel = $this->createModelOne('subject');
        $this->deliveryModel = $this->createModelOne('delivery');
        $this->subjectStudentModel = $this->createModelOne('subjectStudent');
        $this->subjectTeacherModel = $this->createModelOne('subjectAssignment');
        $this->validationClass = $this->createValidationOne('correctionTeacher');
        $this->validationClass->model = $this->model;
        $this->validationClass->user = $this->userModel;
        $this->validationClass->subject = $this->subjectModel;
        $this->validationClass->delivery = $this->deliveryModel;
        $this->validationClass->project = $this->projectModel;
        $this->validationClass->subjectTeacher = $this->subjectTeacherModel;
        $this->validationClass->subjectStudent = $this->subjectStudentModel;
        return $this->returnRest(action);
    }

    function returnRest($action) {
        switch(action) {
            case 'edit':
                $this->validateEdit();
                return $this->editCorrectionTeacher('EDITAR_CORRECCION_DOCENTE_OK');
            break;
            case 'search':
                $this->model->arrayDataValue['id_criterio'] = isset($this->model->arrayDataValue['id_criterio']) ? $this->model->arrayDataValue['id_criterio'] : '';
                $this->model->arrayDataValue['id_entrega'] = isset($this->model->arrayDataValue['id_entrega']) ? $this->model->arrayDataValue['id_entrega'] : '';
                $this->model->arrayDataValue['id_trabajo'] = isset($this->model->arrayDataValue['id_trabajo']) ? $this->model->arrayDataValue['id_trabajo'] : '';
                $this->model->arrayDataValue['dni'] = isset($this->model->arrayDataValue['dni']) ? $this->model->arrayDataValue['dni'] : '';
                $this->model->arrayDataValue['correccion_docente'] = isset($this->model->arrayDataValue['correccion_docente']) ? $this->model->arrayDataValue['correccion_docente'] : '';
                $this->validateSearch();
                return $this->search();
            break;
            case 'delete':
                $this->validationClass->validateDelete();
                return $this->deleteCorrectionTeacher('ELIMINAR_CORRECCION_DOCENTE_OK');
            break;
            case 'showCorrection':
                $this->validationClass->validateShowCorrection();
                return $this->showCorrectionTeacher('MOSTRAR_CORRECCION_DOCENTE_OK');
            break;
        }
    }

    function deleteCorrectionTeacher($msg) {
        $this->model->DELETE();
        return $this->createFeedback($msg);
    }

    function editCorrectionTeacher($msg) {
        $this->model->arrayDataValue['dni'] = userSystem;
        $this->model->EDIT();
        return $this->createFeedback($msg);
    }

    function showCorrectionTeacher($msg) {
        $this->model->arrayDataValue['visible'] = $this->model->arrayDataValue['visible'] == 'true' ? 1 : 0;
        $this->model->EDIT();
        return $this->createFeedback($msg);
    }

    function createFeedback($message) {
        $this->feedback['code'] = $message;
        $this->feedback['ok'] = true;
        return $this->feedback;
    }
}
?>