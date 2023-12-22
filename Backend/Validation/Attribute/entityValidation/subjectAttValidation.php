<?php

class subjectAttValidation extends Validate {

    function validateAddAttributes() {
        $this->checkName();
        $this->checkCredits();
        $this->checkSearchTeacher();
    }

    function validateEditAttributes() {
        $this->checkSubjectId();
        $this->checkName();
        $this->checkCredits();
        $this->checkSearchTeacher();
    }

    function validateDeleteAttributes() {
        $this->checkSubjectId();
    }

    function validateSearchAttributes() {
        $this->checkSearchName();
        $this->checkSearchCredits();
        $this->checkSearchTeacher();
        $this->checkSearchAcademicCourse();
    }

    function validateAssignTeacherAttributes() {
        $this->checkSubjectId();
        $this->checkTeacher();
    }

    function checkTeacher() {
        if($this->isEmpty($this->dni)===true) {
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

    function checkSearchAcademicCourse() {
        if (!empty($this->id_curso_academico)) {
            if(!$this->isNumeric($this->id_curso_academico)===true){
                fillAttributeException('ID_CURSO_ACADEMICO_ERROR_FORMATO');
            }
        }
    }

    function checkSearchName() {
        if (!empty($this->nombre_materia)) {
            if($this->minLength($this->nombre_materia, 3)=== false){
                fillAttributeException('NOMBRE_MENOR_QUE_3');
            }
            if($this->maxLength($this->nombre_materia, 200) === false){
                fillAttributeException('NOMBRE_MAYOR_QUE_200');
            }
        }
    }

    function checkSearchCredits() {
        if (!empty($this->creditos)) {
            if($this->maxLength($this->creditos, 4) === false){
                fillAttributeException('CREDITOS_MAYOR_QUE_4');
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

     function checkCredits(){
        if($this->isEmpty($this->creditos) === true){
            fillAttributeException('CREDITOS_VACIO');
        }

        if($this->maxLength($this->creditos, 4) === false){
            fillAttributeException('CREDITOS_MAYOR_QUE_4');
        }
     }

    function checkName(){
        if($this->isEmpty($this->nombre_materia) === true){
            fillAttributeException('NOMBRE_VACIO');
        }

        if($this->minLength($this->nombre_materia, 3)=== false){
            fillAttributeException('NOMBRE_MENOR_QUE_3');
        }

        if($this->maxLength($this->nombre_materia, 200) === false){
            fillAttributeException('NOMBRE_MAYOR_QUE_200');
        }
    }
}
?>