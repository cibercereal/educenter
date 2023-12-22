<?php

class gradeCompetenceAttValidation extends Validate {

    function validateEditAttributes() {
        $this->checkSubjectId();
    }

    function validateSearchAttributes() {
        $this->checkSearchSubjectId();
        $this->checkSearchProjectId();
        $this->checkSearchCompetenceId();
        $this->checkSearchCompetenceGrade();
        $this->checkSearchDni();
        $this->checkSearchVisible();
    }

    function validateMakeVisibleAttributes() {
        $this->checkSubjectId();
        $this->checkProjectId();
        $this->checkCompetenceId();
        $this->checkDni();
        $this->checkVisible();
    }

    function checkSearchVisible() {
         if (!empty($this->visible)) {
             if(!$this->isNumeric($this->visible)===true || ($this->visible != '0' && $this->visible != '1')) {
                 fillAttributeException('VISIBLE_ERROR_FORMATO');
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

    function checkSearchCompetenceGrade() {
         if (!empty($this->nota_competencia)) {
             if(!$this->isNumeric($this->nota_competencia)===true){
                 fillAttributeException('NOTA_COMPETENCIA_ERROR_FORMATO');
             }
         }
    }

    function checkSearchCompetenceId() {
         if (!empty($this->id_competencia)) {
             if(!$this->isNumeric($this->id_competencia)===true){
                 fillAttributeException('ID_COMPETENCIA_ERROR_FORMATO');
             }
         }
    }

    function checkSearchProjectId() {
         if (!empty($this->id_trabajo)) {
             if(!$this->isNumeric($this->id_trabajo)===true){
                 fillAttributeException('ID_TRABAJO_ERROR_FORMATO');
             }
         }
    }

    function checkSearchSubjectId() {
         if (!empty($this->id_materia)) {
             if(!$this->isNumeric($this->id_materia)===true){
                 fillAttributeException('ID_MATERIA_ERROR_FORMATO');
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

    function checkSubjectId() {
         if($this->isEmpty($this->id_materia)===true) {
             fillAttributeException('ID_MATERIA_VACIO');
         }

         if(!$this->isNumeric($this->id_materia)===true){
             fillAttributeException('ID_MATERIA_ERROR_FORMATO');
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

    function checkDni() {
        if($this->isEmpty($this->dni)===true){
            fillAttributeException('DNI_VACIO');
        }

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

    function checkVisible() {
        if($this->isEmpty($this->visible)===true) {
            fillAttributeException('VISIBLE_VACIO');
        }

        if($this->visible != '1' && $this->visible != '0') {
            fillAttributeException('VISIBLE_ERROR_FORMATO');
        }
    }
}
?>