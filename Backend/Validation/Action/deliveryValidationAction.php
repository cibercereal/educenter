<?php

include_once './Validation/validate.php';

class deliveryValidationAction extends Validate {

    function validateAdd() {
        if($this->deliveryExists()){
            fillExceptionAction('ENTREGA_YA_EXISTE');
		}
        if(!$this->userIsStudent()){
            fillExceptionAction('USUARIO_NO_ES_ALUMNO');
        }
        if(!$this->userIsSubjectStudent()){
            fillExceptionAction('USUARIO_NO_ES_ALUMNO_MATERIA');
        }
    }

    function validateEdit() {
        if(!$this->deliveryExistsById()){
            fillExceptionAction('ENTREGA_NO_EXISTE');
		}
        if(!$this->userIsStudent()){
            fillExceptionAction('USUARIO_NO_ES_ALUMNO');
        }
        if(!$this->isDeliveryUser()){
            fillExceptionAction('USUARIO_NO_ES_ALUMNO_ENTREGA');
        }
    }

    function validateDelete() {
        if(!$this->deliveryExistsById()){
            fillExceptionAction('ENTREGA_NO_EXISTE');
		}
        if(!$this->userIsStudent()){
            fillExceptionAction('USUARIO_NO_ES_ALUMNO');
        }
        if(!$this->isDeliveryUser()){
            fillExceptionAction('USUARIO_NO_ES_ALUMNO_ENTREGA');
        }
    }

    function validateSearch() {
        if($this->isAdmin()) {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR_O_ALUMNO');
        }
        if (rolUserSystem == '3' && !$this->userIsSubjectStudent()) {
            fillExceptionAction('USUARIO_NO_ES_ALUMNO_MATERIA');
        }
        if (rolUserSystem == '2' && !$this->userIsSubjectTeacher()) {
            fillExceptionAction('USUARIO_NO_ES_PROFESOR_MATERIA');
        }
    }

    function userIsSubjectTeacher() {
        $project = $this->project->getById(array($this->model->arrayDataValue['id_trabajo']))['resource'];
        if (!empty($project)) {
            $subjectTeacher = $this->subjectTeacher->getById(array($project['id_materia'], userSystem))['resource'];
            if (!empty($subjectTeacher) && $subjectTeacher['secundario'] == '1') {
                return true;
            } else {
                $subject = $this->subject->getById(array($project['id_materia']))['resource'];
                return !empty($subject) && $subject['dni'] == userSystem;
            }
        }
        return false;
    }

    function isAdmin() {
        return rolUserSystem == '1';
    }

    function deliveryExistsById()  {
        $delivery = $this->model->getById(array($this->model->arrayDataValue['id_entrega']))['resource'];
        return !empty($delivery);
    }

    function isDeliveryUser() {
        $delivery = $this->model->getById(array($this->model->arrayDataValue['id_entrega']))['resource'];
        return !empty($delivery) && $delivery['dni'] == userSystem;
    }

    function userIsSubjectStudent() {
        $project = $this->project->getById(array($this->model->arrayDataValue['id_trabajo']))['resource'];
        if (!empty($project)) {
            $student = $this->subjectStudent->getById(array($project['id_materia'], userSystem))['resource'];
            return !empty($student) && $student['aceptado'] == '1';
        }
        return false;
    }

    function userIsStudent() {
        return rolUserSystem == '3';
    }

    function deliveryExists()  {
        $deliveries = $this->model->seek_multiple(array("id_trabajo", "dni"), array($this->model->arrayDataValue['id_trabajo'], userSystem))['resource'];
        return !empty($deliveries);
    }
}
?>