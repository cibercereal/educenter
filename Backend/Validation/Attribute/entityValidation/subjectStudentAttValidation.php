<?php

class subjectStudentAttValidation extends Validate {

    function validateSearchAttributes() {
        $this->checkSearchSubjectId();
        $this->checkSearchStudent();
        $this->checkSearchAccepted();
    }

    function validateAddAttributes() {
        $this->checkSubjectId();
        $this->checkStudent();
    }

    function validateDeleteAttributes() {
        $this->checkSubjectId();
        $this->checkStudent();
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

    function validateEditAttributes() {
        $this->checkSubjectId();
        $this->checkStudent();
        $this->checkAccepted();
    }

    function checkAccepted() {
        if($this->isEmpty($this->aceptado) === true){
            fillAttributeException('ACEPTADO_VACIO');
        }

        if($this->maxLength($this->aceptado,1) === false){
            fillAttributeException('ACEPTADO_MAYOR_QUE_1');
        }

        if(!$this->isNumeric($this->aceptado)===true){
            fillAttributeException('ACEPTADO_ERROR_FORMATO');
        }
    }

    function checkSearchAccepted() {
        if (!empty($this->aceptado)) {
            if($this->maxLength($this->aceptado,1) === false){
                fillAttributeException('ACEPTADO_MAYOR_QUE_1');
            }

            if(!$this->isNumeric($this->aceptado)===true){
                fillAttributeException('ACEPTADO_ERROR_FORMATO');
            }
        }
    }

    function checkSearchStudent() {
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

    function checkStudent() {
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