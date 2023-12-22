<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/subjectValidation.php';

class subjectService extends ServiceBase {

    private $user;
    private $subjectAssignmentModel;
    private $academicCourseModel;

    function startRest() {
        $this->listAttributesEqual = array();
        $this->validateDataAttributes();

        switch(action) {
            case 'add':
                $this->attributeList = array('nombre_materia', 'creditos', 'dni', 'id_curso_academico');
            break;
            case 'edit':
                $this->attributeList = array('id_materia', 'nombre_materia', 'creditos', 'dni');
            break;
            case 'delete':
                $this->attributeList = array('id_materia');
            break;
            case 'search':
                $this->attributeList = array('nombre_materia', 'creditos', 'dni', 'id_curso_academico');
                $this->listAttributesEqual = array('dni');
            break;
            case 'assignTeacher':
                $this->attributeList = array('id_materia', 'dni');
            break;
        }

        $this->model = $this->createModelOne('subject');
        $this->subjectAssignmentModel = $this->createModelOne('subjectAssignment');
        $this->user = $this->createModelOne('user');
        $this->academicCourseModel = $this->createModelOne('academicCourse');
        $this->validationClass = $this->createValidationOne('subject');
        $this->validationClass->model = $this->model;
        $this->validationClass->user = $this->user;
        return $this->returnRest(action);
    }

    function returnRest($action) {
        switch(action) {
            case 'add':
                $this->model->arrayDataValue['dni'] = !empty($this->model->arrayDataValue['dni']) ? $this->model->arrayDataValue['dni'] : NULL;
                $this->validateAdd();
                return $this->addSubject('ANADIR_MATERIA_OK');
            break;
            case 'edit':
                $this->model->arrayDataValue['dni'] = !empty($this->model->arrayDataValue['dni']) ? $this->model->arrayDataValue['dni'] : NULL;
                $this->validateEdit();
                return $this->editSubject('EDITAR_MATERIA_OK');
            break;
            case 'delete':
                $this->validationClass->validateDelete();
                return $this->deleteSubject('ELIMINAR_MATERIA_OK');
            break;
            case 'search':
                $this->model->arrayDataValue['nombre_materia'] = isset($this->model->arrayDataValue['nombre_materia']) ? $this->model->arrayDataValue['nombre_materia'] : '';
                $this->model->arrayDataValue['creditos'] = isset($this->model->arrayDataValue['creditos']) ? $this->model->arrayDataValue['creditos'] : '';
                $this->model->arrayDataValue['dni'] = isset($this->model->arrayDataValue['dni']) ? $this->model->arrayDataValue['dni'] : NULL;
                $this->model->arrayDataValue['id_curso_academico'] = isset($this->model->arrayDataValue['id_curso_academico']) ? $this->model->arrayDataValue['id_curso_academico'] : '';
                $this->validateSearch();
                return $this->search();
            break;
            case 'assignTeacher':
                $this->validationClass->validateAssignTeacher();
                return $this->assignTeacher('ASIGNAR_PROFESOR_OK');
            break;
        }
    }

    function assignTeacher($msg) {
        $this->model->EDIT();
        // Borrar la tupla de materia_asignacion
        $this->subjectAssignmentModel->DELETE();
        return $this->createFeedback($msg);
    }

    function deleteSubject($msg) {
        $this->model->DELETE();

        return $this->createFeedback($msg);
    }

    function editSubject($msg) {
        $this->model->EDIT();
        return $this->createFeedback($msg);
    }

    function addSubject($msg) {
        $this->model->arrayDataValue['id_curso_academico'] = $this->academicCourseModel->getLastId()['resource']['id_curso_academico'];
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