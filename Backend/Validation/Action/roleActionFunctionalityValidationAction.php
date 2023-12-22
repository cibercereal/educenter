<?php

include_once './Validation/validate.php';

class roleActionFunctionalityValidationAction extends Validate {

    function validateSearch() { /*Excepciones para buscar rolAcciónFunccionalidad*/ }

    function validateAdd() {
        if($this->roleActionFunctionalityExists()) {
            fillExceptionAction('ROL_ACCION_FUNCIONALIDAD_EXISTE');
        }
    }

    function validateDelete() {
        if (!$this->roleActionFunctionalityExists()) {
            fillExceptionAction('ROL_ACCION_FUNCIONALIDAD_NO_EXISTE');
        }
    }

    function roleActionFunctionalityExists() {
        $roleActionFunc = $this->model->getById(array($this->model->arrayDataValue['id_rol'], $this->model->arrayDataValue['id_accion'], $this->model->arrayDataValue['id_funcionalidad']));
        return !empty($roleActionFunc['resource']);
    }

    function isEmpty($elem) {
        return empty($elem);
    }
}
?>