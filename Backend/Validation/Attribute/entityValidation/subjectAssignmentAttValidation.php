<?php

class subjectAssignmentAttValidation extends Validate {

    function validateSearchAttributes() {
        $this->checkSearchSubjectId();
        $this->checkSearchTeacher();
        $this->checkSearchSecundario();
    }

    function validateAdd() {
        $this->checkSubjectId();
        $this->checkTeacher();
    }

    function validateDelete() {
        $this->checkSubjectId();
        $this->checkTeacher();
    }

    function validateEdit() {
        $this->checkSubjectId();
        $this->checkTeacher();
        $this->checkSecundario();
    }

    function checkSearchSecundario() {
        if (!empty($this->secundario)) {
            if($this->maxLength($this->secundario,1) === false){
                fillAttributeException('SECUNDARIO_MAYOR_QUE_1');
            }

            if(!$this->isNumeric($this->secundario)===true || ($this->secundario != '0' && $this->secundario != '1')){
                fillAttributeException('SECUNDARIO_ERROR_FORMATO');
            }
        }
    }

    function checkSecundario() {
        if($this->isEmpty($this->secundario)===true) {
            fillAttributeException('SECUNDARIO_VACIO');
        }

        if($this->maxLength($this->secundario,1) === false){
            fillAttributeException('SECUNDARIO_MAYOR_QUE_1');
        }

        if(!$this->isNumeric($this->secundario)===true || ($this->secundario != '0' && $this->secundario != '1')){
            fillAttributeException('SECUNDARIO_ERROR_FORMATO');
        }
    }

    function checkSearchSubjectId() {
        if (!empty($this->id_materia)) {
            if($this->isEmpty($this->id_materia)===true) {
                fillAttributeException('ID_MATERIA_VACIO');
            }

            if(!$this->isNumeric($this->id_materia)===true){
                fillAttributeException('ID_MATERIA_ERROR_FORMATO');
            }
        }
    }

    function checkSearchTeacher() {
        if (!empty($this->dni)) {
            if($this->minLength($this->dni,9) === false){
                fillAttributeException('DNI_MENOR_QUE_9');
            }

            if($this->maxLength($this->dni,9) === false){
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

    function checkSubjectId() {
        if($this->isEmpty($this->id_materia)===true) {
            fillAttributeException('ID_MATERIA_VACIO');
        }

        if(!$this->isNumeric($this->id_materia)===true){
            fillAttributeException('ID_MATERIA_ERROR_FORMATO');
        }
    }

    function checkTeacher() {
        if($this->isEmpty($this->dni) === true){
            fillAttributeException('DNI_VACIO');
        }

        if($this->minLength($this->dni,9) === false){
            fillAttributeException('DNI_MENOR_QUE_9');
        }

        if($this->maxLength($this->dni,9) === false){
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
?>