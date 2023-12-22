<?php

class criteriaAttValidation extends Validate {

    function validateAddAttributes() {
        $this->checkDescription();
        $this->checkProject();
    }

    function validateEditAttributes() {
        $this->checkCriteriaId();
        $this->checkDescription();
        $this->checkProject();
    }

    function validateDeleteAttributes() {
        $this->checkCriteriaId();
    }

    function validateSearchAttributes() {
         $this->checkSearchDescription();
         $this->checkSearchProject();
    }

    function checkCriteriaId() {
         if($this->isEmpty($this->id_criterio)===true) {
             fillAttributeException('ID_CRITERIO_VACIO');
         }

         if(!$this->isNumeric($this->id_criterio)===true){
             fillAttributeException('ID_CRITERIO_ERROR_FORMATO');
         }
    }

    function checkSearchDescription() {
        if (!empty($this->descripcion)) {
            if($this->minLength($this->descripcion,5)===false){
                fillAttributeException('DESCRIPCION_MENOR_QUE_9');
            }

            if($this->maxLength($this->descripcion,200)===false){
                fillAttributeException('DESCRIPCION_MAYOR_QUE_200');
            }
        }
    }

    function checkSearchProject() {
        if (!empty($this->id_trabajo)) {
              if(!$this->isNumeric($this->id_trabajo)===true){
                  fillAttributeException('ID_TRABAJO_ERROR_FORMATO');
              }
        }
    }

    function checkDescription() {
         if($this->isEmpty($this->descripcion)===true) {
             fillAttributeException('DESCRIPCION_VACIO');
         }

        if($this->minLength($this->descripcion,9)===false){
            fillAttributeException('DESCRIPCION_MENOR_QUE_9');
        }

        if($this->maxLength($this->descripcion,200)===false){
            fillAttributeException('DESCRIPCION_MAYOR_QUE_200');
        }
    }

    function checkProject() {
         if($this->isEmpty($this->id_trabajo)===true) {
             fillAttributeException('ID_TRABAJO_VACIO');
         }

         if(!$this->isNumeric($this->id_trabajo)===true){
             fillAttributeException('ID_TRABAJO_ERROR_FORMATO');
         }
    }
}
?>