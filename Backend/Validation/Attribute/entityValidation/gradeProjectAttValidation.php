<?php

class gradeProjectAttValidation extends Validate {

    function validateAddAttributes() {
        $this->checkProjectId();
        $this->checkDeliveryId();
    }

    function validateEditAttributes() {
        $this->checkProjectId();
        $this->checkDeliveryId();
        $this->checkSearchVisible();
    }

    function validateSearchAttributes() {
        $this->checkSearchProjectId();
        $this->checkSearchDeliveryId();
        $this->checkSearchDni();
        $this->checkSearchGradeProject();
        $this->checkSearchGradeCorrection();
        $this->checkSearchVisible();
    }

    function checkSearchVisible() {
         if (!empty($this->visible)) {
             if(!$this->isNumeric($this->visible)===true || ($this->visible != '0' && $this->visible != '1')) {
                 fillAttributeException('VISIBLE_ERROR_FORMATO');
             }
         }
    }

    function checkSearchGradeCorrection() {
        if (!empty($this->nota_correccion)) {
            if(!$this->isNumeric($this->nota_correccion)===true){
                fillAttributeException('NOTA_CORRECCION_ERROR_FORMATO');
            }
        }
    }

    function checkSearchGradeProject() {
        if (!empty($this->nota_trabajo)) {
            if(!$this->isNumeric($this->nota_trabajo)===true){
                fillAttributeException('NOTA_TRABAJO_ERROR_FORMATO');
            }
        }
    }

    function checkSearchDni() {
         if (!empty($this->dni)) {
            if($this->minLength($this->dni,9)===false){
                fillAttributeException('DNI_MENOR_QUE_9');
            }
            if($this->maxLength($this->dni,9)===false){
                fillAttributeException('DNI_MAYOR_QUE_9');
            }
            if(!$this->dniFormat($this->dni)){
                fillAttributeException('DNI_FORMATO_INCORRECTO');
            }
            if($this->nifLetter($this->dni)===false) {
                fillAttributeException('DNI_LETRA_INCORRECTA');
            }
         }
    }

    function checkSearchDeliveryId() {
        if(!empty($this->id_entrega)) {
            if(!$this->isNumeric($this->id_entrega)===true){
                fillAttributeException('ID_ENTREGA_ERROR_FORMATO');
            }
        }
    }

    function checkSearchProjectId() {
        if(!empty($this->id_trabajo)) {
            if(!$this->isNumeric($this->id_trabajo)===true){
                fillAttributeException('ID_TRABAJO_ERROR_FORMATO');
            }
        }
    }

    function checkProjectId() {
         if($this->isEmpty($this->id_trabajo)===true) {
             fillAttributeException('ID_TRABAJO_VACIO');
         }

         if(!$this->isNumeric($this->id_trabajo)===true){
             fillAttributeException('ID_TRABAJO_ERROR_FORMATO');
         }
    }

    function checkDeliveryId() {
         if($this->isEmpty($this->id_entrega)===true) {
             fillAttributeException('ID_ENTREGA_VACIO');
         }

         if(!$this->isNumeric($this->id_entrega)===true){
             fillAttributeException('ID_ENTREGA_ERROR_FORMATO');
         }
    }
}
?>