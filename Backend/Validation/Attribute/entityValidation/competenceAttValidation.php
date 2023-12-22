<?php

class competenceAttValidation extends Validate {
    function validateAddAttributes() {
        $this->checkTitle();
        $this->checkDescription();
    }

    function validateEditAttributes() {
        $this->checkCompetenceId();
        $this->checkTitle();
        $this->checkDescription();
        $this->checkSubjectId();
    }

    function validateDeleteAttributes() {
        $this->checkCompetenceId();
    }

    function validateSearchAttributes() {
        $this->checkSearchTitle();
        $this->checkSearchDescription();
        $this->checkSearchSubject();
    }

    function validateAssignCompetenceAttributes() {
        $this->checkCompetenceId();
        $this->checkSubjectId();
    }

    function checkSubjectId() {
        if (!empty($this->id_materia)) {
            if(!$this->isNumeric($this->id_materia)===true){
                fillAttributeException('ID_MATERIA_ERROR_FORMATO');
            }
        } else {
            fillAttributeException('ID_MATERIA_VACIO');
        }
    }

    function checkSearchTitle() {
        if (!empty($this->titulo)) {
             if($this->minLength($this->titulo, 3)=== false){
                 fillAttributeException('TITULO_MENOR_QUE_3');
             }

             if($this->maxLength($this->titulo, 200) === false){
                 fillAttributeException('TITULO_MAYOR_QUE_200');
             }
        }
    }

    function checkSearchDescription() {
        if (!empty($this->descripcion)) {
             if($this->minLength($this->descripcion, 3)=== false){
                 fillAttributeException('DESCRIPCION_MENOR_QUE_3');
             }

             if($this->maxLength($this->descripcion, 40) === false){
                 fillAttributeException('DESCRIPCION_MAYOR_QUE_40');
             }
        }
    }
    
    function checkSearchSubject() {
        if (!empty($this->id_materia)) {
              if(!$this->isNumeric($this->id_materia)===true){
                  fillAttributeException('ID_MATERIA_ERROR_FORMATO');
              }
        }
    }
    
     function checkSubject() {
         if($this->isEmpty($this->id_materia)===true) {
             fillAttributeException('ID_MATERIA_VACIO');
         }

         if(!$this->isNumeric($this->id_materia)===true){
             fillAttributeException('ID_MATERIA_ERROR_FORMATO');
         }
     }
     
     function checkTitle(){
         if($this->isEmpty($this->titulo) === true){
             fillAttributeException('TITULO_VACIO');
         }

         if($this->minLength($this->titulo, 3)=== false){
             fillAttributeException('TITULO_MENOR_QUE_3');
         }

         if($this->maxLength($this->titulo, 40) === false){
             fillAttributeException('TITULO_MAYOR_QUE_40');
         }
     }

     function checkDescription(){
         if($this->isEmpty($this->descripcion) === true){
             fillAttributeException('DESCRIPCION_VACIO');
         }

         if($this->minLength($this->descripcion, 3)=== false){
             fillAttributeException('DESCRIPCION_MENOR_QUE_3');
         }

         if($this->maxLength($this->descripcion, 200) === false){
             fillAttributeException('DESCRIPCION_MAYOR_QUE_200');
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
}
?>