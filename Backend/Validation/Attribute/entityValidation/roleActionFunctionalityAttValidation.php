<?php

class roleActionFunctionalityAttValidation extends Validate {

    function validateSearchAttributes() {
        $this->checkSearchAction();
        $this->checkSearchFunctionality();
        $this->checkSearchRole();
	}

    function validateAddAttributes() {
        $this->checkAction();
        $this->checkFunctionality();
        $this->checkRole();
    }

    function validateDeleteAttributes() {
        $this->checkAction();
        $this->checkFunctionality();
        $this->checkRole();
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

    function checkSearchRole() {
        if(!empty($this->id_rol)){
			if(!$this->isNumeric($this->id_rol)===true){
				fillAttributeException('ID_ROL_ERROR_FORMATO');
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

    function checkRole() {
        if($this->isEmpty($this->id_rol)===true){
			fillAttributeException('ROL_VACIO');
		}

        if(!$this->isNumeric($this->id_rol)===true){
            fillAttributeException('ID_ROL_ERROR_FORMATO');
        }
    }

}
?>