<?php

include_once './Validation/validate.php';

class competenceValidationAction extends Validate {

    function validateAdd() {
        if($this->competenceExists()){
            fillExceptionAction('COMPETENCIA_YA_EXISTE');
		}
		if($this->isNotAdminOrTeacher()){
            fillExceptionAction('USUARIO_NO_ES_ADMINISTRADOR_O_PROFESOR');
		}
    }

    function validateEdit() {
        if (!$this->competenceExistsById()) {
            fillExceptionAction('COMPETENCIA_NO_EXISTE');
        }
		if($this->isNotAdminOrTeacher()){
            fillExceptionAction('USUARIO_NO_ES_ADMINISTRADOR_O_PROFESOR');
		}
		if (!empty($this->model->arrayDataValue['id_materia'])) {
            if (!$this->subjectExistsById()) {
                fillExceptionAction('MATERIA_NO_EXISTE');
            }
		} else if (!empty($this->model->arrayDataValue['id_trabajo'])) {
            if (!$this->projectExistsById()) {
                fillExceptionAction('TRABAJO_NO_EXISTE');
            }
		}
    }

    function validateDelete() {
        if (!$this->competenceExistsById()) {
            fillExceptionAction('COMPETENCIA_NO_EXISTE');
        }
		if($this->isNotAdminOrTeacher()){
            fillExceptionAction('USUARIO_NO_ES_ADMINISTRADOR_O_PROFESOR');
		}
    }

    function validateSearch() {
		if($this->isAdmin()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR_O_ALUMNO');
		}
    }

    function validateAssignCompetence() {
        if (!$this->competenceExistsById()) {
            fillExceptionAction('COMPETENCIA_NO_EXISTE');
        }
		if($this->isNotAdminOrTeacher()){
            fillExceptionAction('USUARIO_NO_ES_ADMINISTRADOR_O_PROFESOR');
		}
		if (!empty($this->model->arrayDataValue['id_materia'])) {
            if (!$this->subjectExistsById()) {
                fillExceptionAction('MATERIA_NO_EXISTE');
            }
		} else {
            if (!$this->projectExistsById()) {
                fillExceptionAction('TRABAJO_NO_EXISTE');
            }
		}
    }

    function competenceExists()  {
        $competence = $this->model->seek(array("titulo"), array($this->model->arrayDataValue['titulo']))['resource'];
        return !empty($competence);
    }

    function competenceExistsById() {
        $competence = $this->model->getById(array($this->model->arrayDataValue['id_competencia']));
        return !empty($competence['resource']);
    }

    function subjectExistsById() {
        $subject = $this->subjectModel->getById(array($this->model->arrayDataValue['id_materia']));
        return !empty($subject['resource']);
    }

    function projectExistsById() {
        $project = $this->projectModel->getById(array($this->model->arrayDataValue['id_trabajo']));
        return !empty($project['resource']);
    }

    function isNotAdminOrTeacher() {
        return rolUserSystem != '1' && rolUserSystem != '2';
    }

    function isAdmin() {
        return rolUserSystem == '1';
    }

}
?>