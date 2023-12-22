<?php

class criteriaCompetenceAttValidation extends Validate {

    function validateAddAttributes() {
        $this->checkCriteria();
        $this->checkCompetence();
    }

    function validateDeleteAttributes() {
        $this->checkCriteriaId();
        $this->checkCompetenceId();
    }

    function validateSearchAttributes() {
         $this->checkSearchCriteria();
         $this->checkSearchCompetence();
    }

    function checkCriteriaId() {
         if($this->isEmpty($this->id_criterio)===true) {
             fillAttributeException('ID_CRITERIO_VACIO');
         }

         if(!$this->isNumeric($this->id_criterio)===true){
             fillAttributeException('ID_CRITERIO_ERROR_FORMATO');
         }
    }

    function checkCompetenceId() {
         if($this->isEmpty($this->id_competencia)===true) {
             fillAttributeException('ID_COMPETENCIA_VACIO');
         }

         if(!$this->isNumeric($this->id_competencia)===true){
             fillAttributeException('ID_COMPETENCIA_ERROR_FORMATO');
         }
    }

    function checkSearchCriteria() {
        if (!empty($this->id_criterio)) {
              if(!$this->isNumeric($this->id_criterio)===true){
                  fillAttributeException('ID_CRITERIO_ERROR_FORMATO');
              }
        }
    }

    function checkSearchCompetence() {
        if (!empty($this->id_competencia)) {
              if(!$this->isNumeric($this->id_competencia)===true){
                  fillAttributeException('ID_COMPETENCIA_ERROR_FORMATO');
              }
        }
    }

    function checkCriteria() {
         if($this->isEmpty($this->id_criterio)===true) {
             fillAttributeException('ID_CRITERIO_VACIO');
         }

         if(!$this->isNumeric($this->id_criterio)===true){
             fillAttributeException('ID_CRITERIO_ERROR_FORMATO');
         }
    }

    function checkCompetence() {
         if($this->isEmpty($this->id_competencia)===true) {
             fillAttributeException('ID_COMPETENCIA_VACIO');
         }

         if(!$this->isNumeric($this->id_competencia)===true){
             fillAttributeException('ID_COMPETENCIA_ERROR_FORMATO');
         }
    }
}
?>