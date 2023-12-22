<?php

class actionFunctionalityAttValidation extends Validate {

    function validateSearchAttributes() {
        $this->checkSearchAction();
        $this->checkSearchFunctionality();
	}

    function validateAddAttributes() {
        $this->checkAction();
        $this->checkFunctionality();
    }

    function validateDeleteAttributes() {
        $this->checkAction();
        $this->checkFunctionality();
    }

    function checkSearchAction() {
        if(!empty($this->id_accion)){
			if(!$this->isNumeric($this->id_accion)===true){
				fillAttributeException('ID_ACCION_ERROR_FORMATO');
			}
		}
    }

    function checkSearchFunctionality() {
        if(!empty($this->id_funcionalidad)){
			if(!$this->isNumeric($this->id_funcionalidad)===true){
				fillAttributeException('ID_FUNCIONALIDAD_ERROR_FORMATO');
			}
		}
    }

    function checkAction() {
        if($this->isEmpty($this->id_accion)===true) {
			fillAttributeException('ACCION_VACIO');
		}

        if(!$this->isNumeric($this->id_accion)===true){
            fillAttributeException('ID_ACCION_ERROR_FORMATO');
        }
    }

    function checkFunctionality() {
        if($this->isEmpty($this->id_funcionalidad)===true){
			fillAttributeException('FUNCIONALIDAD_VACIO');
		}

        if(!$this->isNumeric($this->id_funcionalidad)===true){
            fillAttributeException('ID_FUNCIONALIDAD_ERROR_FORMATO');
        }
    }

}
?>