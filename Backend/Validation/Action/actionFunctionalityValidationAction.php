<?php

include_once './Validation/validate.php';

class actionFunctionalityValidationAction extends Validate {

    function validateSearch() { /*Excepciones para buscar funccionalidadAcción*/ }

    function validateAdd() {
        if($this->actionFunctionalityExists()) {
            fillExceptionAction('ACCION_FUNCIONALIDAD_EXISTE');
        }
    }

    function validateDelete() {
        if (!$this->actionFunctionalityExists()) {
            fillExceptionAction('ACCION_FUNCIONALIDAD_NO_EXISTE');
        }
    }
    
    function actionFunctionalityExists() {
        $actionFunc = $this->model->getById(array($this->model->arrayDataValue['id_accion'], $this->model->arrayDataValue['id_funcionalidad']));
        return !empty($actionFunc['resource']);
    }
}
?>