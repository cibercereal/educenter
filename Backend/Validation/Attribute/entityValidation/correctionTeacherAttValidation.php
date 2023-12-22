<?php

class correctionTeacherAttValidation extends Validate {

    function validateAddAttributes() {
        $this->checkDelivery();
        $this->checkProject();
    }

    function validateEditAttributes() {
        $this->checkCorrectionTeacherId();
        $this->checkCorrectionTeacher();
        $this->checkCommentTeacher();
    }

    function validateSearchAttributes() {
       $this->checkSearchDni();
       $this->checkSearchDelivery();
       $this->checkSearchProject();
       $this->checkSearchCriteria();
       $this->checkCorrectionTeacher();
    }

    function validateShowCorrectionAttributes() {
        $this->checkCorrectionTeacherId();
        $this->checkVisible();
    }

    function validateDeleteCorrectionAttributes() {
        $this->checkCorrectionTeacherId();
    }

    function checkVisible() {
        if($this->isEmpty($this->visible)===true) {
            fillAttributeException('VISIBLE_VACIO');
        }

        if($this->visible != 'true' && $this->visible != 'false') {
            fillAttributeException('VISIBLE_ERROR_FORMATO');
        }
    }

    function checkCommentTeacher() {
        if (!empty($this->comentario_docente)) {
            if($this->maxLength($this->comentario_docente,150)===false){
                fillAttributeException('COMENTARIO_DOCENTE_MAYOR_QUE_150');
            }
        }
    }

    function checkCorrectionTeacher() {
          if (!empty($this->correccion_docente)) {
                if(!$this->isNumeric($this->correccion_docente)===true){
                    fillAttributeException('CORRECCION_DOCENTE_ERROR_FORMATO');
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

    function checkSearchDelivery() {
         if (!empty($this->id_entrega)) {
               if(!$this->isNumeric($this->id_entrega)===true){
                   fillAttributeException('ID_ENTREGA_ERROR_FORMATO');
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

    function checkDelivery() {
         if($this->isEmpty($this->id_entrega)===true) {
             fillAttributeException('ID_ENTREGA_VACIO');
         }

         if(!$this->isNumeric($this->id_entrega)===true){
             fillAttributeException('ID_ENTREGA_ERROR_FORMATO');
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

    function checkCorrectionTeacherId() {
         if($this->isEmpty($this->id_correccion_profesor)===true) {
             fillAttributeException('ID_CORRECCION_PROFESOR_VACIO');
         }

         if(!$this->isNumeric($this->id_correccion_profesor)===true){
             fillAttributeException('ID_CORRECCION_PROFESOR_ERROR_FORMATO');
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

    function checkSearchCriteria() {
        if (!empty($this->id_criterio)) {
            if(!$this->isNumeric($this->id_criterio)===true){
                fillAttributeException('ID_CRITERIO_ERROR_FORMATO');
            }
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
}
?>