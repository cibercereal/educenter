<?php

include_once './Validation/validate.php';

class criteriaCompetenceValidationAction extends Validate {

    function validateAdd() {
		if($this->isNotTeacher()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
		}
    }

    function validateDelete() {
        if(!$this->criteriaExistsById()){
            fillExceptionAction('CRITERIO_NO_EXISTE');
		}
        if(!$this->competenceExistsById()){
            fillExceptionAction('COMPETENCIA_NO_EXISTE');
        }
        if($this->isNotTeacher()){
            fillExceptionAction('USUARIO_NO_ES_PROFESOR');
        }
    }

    function validateSearch() {
         if (rolUserSystem != '2') {
             fillExceptionAction('USUARIO_NO_ES_PROFESOR');
         }
    }

    function criteriaExistsById()  {
        $criteria = $this->criteria->getById(array($this->model->arrayDataValue['id_criterio']))['resource'];
        return !empty($criteria);
    }

    function competenceExistsById()  {
        $competence = $this->competence->getById(array($this->model->arrayDataValue['id_competencia']))['resource'];
        return !empty($competence);
    }

    function isNotTeacher() {
        return rolUserSystem != '2';
    }
}
?>