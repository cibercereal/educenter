<?php

class projectAttValidation extends Validate {

    function validateAddAttributes() {
        $this->checkName();
        $this->checkDescription();
        $this->checkPercent();
        $this->checkCorrectionPercent();
        $this->checkSubject();
        $this->checkDates();
    }

    function validateEditAttributes() {
        $this->checkProjectId();
        $this->checkName();
        $this->checkDescription();
        $this->checkPercent();
        $this->checkCorrectionPercent();
        $this->checkSubject();
        $this->checkDates();
    }

    function validateDeleteAttributes() {
        $this->checkProjectId();
    }

    function validateSearchAttributes() {
        $this->checkSearchProjectId();
        $this->checkSearchName();
        $this->checkSearchDescription();
        $this->checkSearchPercent();
        $this->checkSearchCorrectionPercent();
        $this->checkSearchNote();
        $this->checkSearchSubject();
        $this->checkSearchDates();
    }

    function checkSearchSubject() {
        if (!empty($this->id_materia)) {
              if(!$this->isNumeric($this->id_materia)===true){
                  fillAttributeException('ID_MATERIA_ERROR_FORMATO');
              }
        }
    }

    function checkDates() {
        if($this->isEmpty($this->fecha_ini) === true){
             fillAttributeException('FECHA_INICIAL_VACIO');
        }
        $this->validateDate($this->fecha_ini);
        if($this->isEmpty($this->fecha_fin) === true){
             fillAttributeException('FECHA_FIN_VACIO');
        }
        $this->validateDate($this->fecha_fin);
    }

    function checkSearchDates() {
        if (!empty($this->fecha_ini)) {
              $this->validateDate($this->fecha_ini);
        }
        if (!empty($this->fecha_fin)) {
              $this->validateDate($this->fecha_fin);
        }
    }

    function validateDate($date){

        switch ($this->checkDateNumbersSlash($date)) {
            case 'formatofechamal':
                fillAttributeException('FECHA_FORMATO_INCORRECTO');
                break;

            case 'tieneletras':
                fillAttributeException('FECHA_SOLO_NUMEROS_Y_GUIONES');
                break;

            case 'tamañomenor10':
                fillAttributeException('FECHA_MENOR_QUE_10');
                break;

            case 'tamañomayor10':
                fillAttributeException('FECHA_MAYOR_QUE_10');
                break;

            default:
                break;
        }
    }

    function checkSearchPercent() {
        if (!empty($this->porcentaje_nota)) {
              if($this->maxLength($this->porcentaje_nota, 3) === false){
                  fillAttributeException('PORCENTAJE_NOTA_MAYOR_QUE_3');
              }

              if(!$this->isNumeric($this->porcentaje_nota)===true){
                  fillAttributeException('PORCENTAJE_NOTA_ERROR_FORMATO');
              }
        }
    }

    function checkSearchCorrectionPercent() {
        if (!empty($this->correccion_nota)) {
              if($this->maxLength($this->correccion_nota, 3) === false){
                  fillAttributeException('CORRECCION_NOTA_MAYOR_QUE_3');
              }

              if(!$this->isNumeric($this->correccion_nota)===true){
                  fillAttributeException('CORRECCION_NOTA_ERROR_FORMATO');
              }
        }
    }

    function checkSearchName() {
        if (!empty($this->nombre_trabajo)) {
             if($this->minLength($this->nombre_trabajo, 3)=== false){
                 fillAttributeException('NOMBRE_MENOR_QUE_3');
             }

             if($this->maxLength($this->nombre_trabajo, 60) === false){
                 fillAttributeException('NOMBRE_MAYOR_QUE_60');
             }
        }
    }

    function checkSearchDescription() {
        if (!empty($this->descripcion_trabajo)) {
             if($this->minLength($this->descripcion_trabajo, 3)=== false){
                 fillAttributeException('DESCRIPCION_MENOR_QUE_3');
             }

             if($this->maxLength($this->descripcion_trabajo, 200) === false){
                 fillAttributeException('DESCRIPCION_MAYOR_QUE_200');
             }
        }
    }

    function checkSearchNote() {
        if (!empty($this->nota)) {
            if($this->minLength($this->nota, 1)=== false){
                fillAttributeException('NOTA_MENOR_QUE_1');
            }

            if($this->maxLength($this->nota, 2) === false){
                fillAttributeException('NOTA_MAYOR_QUE_2');
            }

            if(!$this->isNumeric($this->nota)===true || $this->nota > 10 || this->nota < 0){
                fillAttributeException('NOTA_ERROR_FORMATO');
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

    function checkProjectId() {
         if($this->isEmpty($this->id_trabajo)===true) {
             fillAttributeException('ID_TRABAJO_VACIO');
         }

         if(!$this->isNumeric($this->id_trabajo)===true){
             fillAttributeException('ID_TRABAJO_ERROR_FORMATO');
         }
    }

     function checkName(){
         if($this->isEmpty($this->nombre_trabajo) === true){
             fillAttributeException('NOMBRE_VACIO');
         }

         if($this->minLength($this->nombre_trabajo, 3)=== false){
             fillAttributeException('NOMBRE_MENOR_QUE_3');
         }

         if($this->maxLength($this->nombre_trabajo, 60) === false){
             fillAttributeException('NOMBRE_MAYOR_QUE_60');
         }
     }

     function checkDescription(){
         if($this->isEmpty($this->descripcion_trabajo) === true){
             fillAttributeException('DESCRIPCION_VACIO');
         }

         if($this->minLength($this->descripcion_trabajo, 3)=== false){
             fillAttributeException('DESCRIPCION_MENOR_QUE_3');
         }

         if($this->maxLength($this->descripcion_trabajo, 200) === false){
             fillAttributeException('DESCRIPCION_MAYOR_QUE_200');
         }
     }

     function checkPercent() {
         if($this->isEmpty($this->porcentaje_nota)===true) {
             fillAttributeException('PORCENTAJE_NOTA_VACIO');
         }

         if($this->maxLength($this->porcentaje_nota,3) === false){
             fillAttributeException('PORCENTAJE_NOTA_MAYOR_QUE_3');
         }

         if(!$this->isNumeric($this->porcentaje_nota)===true){
             fillAttributeException('PORCENTAJE_NOTA_ERROR_FORMATO');
         }

         if((int)$this->porcentaje_nota < 1 || (int)$this->porcentaje_nota > 100){
             fillAttributeException('PORCENTAJE_NOTA_MAYOR_100');
         }
     }

     function checkCorrectionPercent() {
         if($this->isEmpty($this->correccion_nota)===true) {
             fillAttributeException('CORRECCION_NOTA_VACIO');
         }

         if($this->maxLength($this->correccion_nota,3) === false){
             fillAttributeException('CORRECCION_NOTA_MAYOR_QUE_3');
         }

         if(!$this->isNumeric($this->correccion_nota)===true){
             fillAttributeException('CORRECCION_NOTA_ERROR_FORMATO');
         }

         if((int)$this->correccion_nota > 100){
             fillAttributeException('CORRECCION_NOTA_MAYOR_100');
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
}
?>