<?php

class correctionCriteriaAttValidation extends Validate {

    function validateAddAttributes() {
        $this->checkDni();
        $this->checkDelivery();
        $this->checkProject();
        $this->checkCorrectionFinalDate();
    }

    function validateSearchAttributes() {
       $this->checkSearchDni();
       $this->checkSearchDelivery();
       $this->checkSearchProject();
       $this->checkSearchCorrectionFinalDate();
    }

    function validateEditAttributes() {
        $this->checkCorrectionCriteriaId();
        $this->checkCorrectionStudent();
        $this->checkCommentStudent();
    }

    function validateAssignRandom() {
        $this->checkStudentNumber();
        $this->checkProject();
        $this->checkCorrectionFinalDate();
    }

    function validateEditTeacherAttributes() {
         $this->checkCorrectionCriteriaId();
         $this->checkCorrectionTeacher();
         $this->checkCommentTeacher();
    }

    function checkStudentNumber() {
          if (empty($this->numero_alumnos)) {
              fillAttributeException('NUMERO_ALUMNOS_VACIO');
          }
          if(!$this->isNumeric($this->numero_alumnos)===true){
              fillAttributeException('NUMERO_ALUMNOS_ERROR_FORMATO');
          }
    }

    function checkCorrectionStudent() {
          if (!empty($this->correccion_alumno)) {
                if(!$this->isNumeric($this->correccion_alumno)===true){
                    fillAttributeException('CORRECCION_ALUMNO_ERROR_FORMATO');
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

    function checkCommentStudent() {
        if (!empty($this->comentario_alumno)) {
            if($this->maxLength($this->comentario_alumno,150) === false){
                fillAttributeException('COMENTARIO_ALUMNO_MAYOR_QUE_150');
            }
        }
    }

    function checkCommentTeacher() {
        if (!empty($this->comentario_docente)) {
            if($this->maxLength($this->comentario_docente,150) === false){
                fillAttributeException('COMENTARIO_DOCENTE_MAYOR_QUE_150');
            }
        }
    }

    function checkSearchCorrectionFinalDate() {
        if (!empty($this->fecha_fin_correccion)) {
			switch ($this->checkDateNumbersSlash($this->fecha_fin_correccion)) {
				case 'formatofechamal':
					fillAttributeException('FECHA_FIN_CORRECCION_FORMATO_INCORRECTO');
					break;
				case 'tieneletras':
					fillAttributeException('FECHA_FIN_CORRECCION_SOLO_NUMEROS_Y_GUIONES');
					break;
				case 'tamañomenor10':
					fillAttributeException('FECHA_FIN_CORRECCION_MENOR_QUE_10');
					break;
				case 'tamañomayor10':
					fillAttributeException('FECHA_FIN_CORRECCION_MAYOR_QUE_10');
					break;
				default:
					break;
			}
        }
    }

    function checkCorrectionFinalDate() {
        if($this->isEmpty($this->fecha_fin_correccion)===true){
            fillAttributeException('FECHA_FIN_CORRECCION_VACIA');
        }

        switch ($this->checkDateNumbersSlash($this->fecha_fin_correccion)) {
            case 'formatofechamal':
                fillAttributeException('FECHA_FIN_CORRECCION_FORMATO_INCORRECTO');
                break;
            case 'tieneletras':
                fillAttributeException('FECHA_FIN_CORRECCION_SOLO_NUMEROS_Y_GUIONES');
                break;
            case 'tamañomenor10':
                fillAttributeException('FECHA_FIN_CORRECCION_MENOR_QUE_10');
                break;
            case 'tamañomayor10':
                fillAttributeException('FECHA_FIN_CORRECCION_MAYOR_QUE_10');
                break;
            default:
                break;
        }
    }

    function checkSearchProject() {
         if (!empty($this->id_trabajo)) {
               if(!$this->isNumeric($this->id_trabajo)===true){
                   fillAttributeException('ID_TRABAJO_ERROR_FORMATO');
               }
         }
    }

    function checkCorrectionCriteriaId() {
         if (empty($this->id_correccion_criterio)) {
            fillAttributeException('ID_CORRECCION_CRITERIO_VACIO');
         }
         if(!$this->isNumeric($this->id_correccion_criterio)===true){
            fillAttributeException('ID_CORRECCION_CRITERIO_ERROR_FORMATO');
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
         if (!empty($this->dni_alumno)) {
            if($this->minLength($this->dni_alumno,9)===false){
                fillAttributeException('DNI_MENOR_QUE_9');
            }

            if($this->maxLength($this->dni_alumno,9)===false){
                fillAttributeException('DNI_MAYOR_QUE_9');
            }

            if(!$this->dniFormat($this->dni_alumno)){
                fillAttributeException('DNI_FORMATO_INCORRECTO');
            }

            if($this->nifLetter($this->dni_alumno)===false) {
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

    function checkCriteria() {
         if($this->isEmpty($this->id_criterio)===true) {
             fillAttributeException('ID_CRITERIO_VACIO');
         }

         if(!$this->isNumeric($this->id_criterio)===true){
             fillAttributeException('ID_CRITERIO_ERROR_FORMATO');
         }
    }

	function checkDni() {
		if($this->isEmpty($this->dni_alumno)===true){
			fillAttributeException('DNI_VACIO');
		}

		if($this->minLength($this->dni_alumno,9)===false){
			fillAttributeException('DNI_MENOR_QUE_9');
		}

		if($this->maxLength($this->dni_alumno,9)===false){
			fillAttributeException('DNI_MAYOR_QUE_9');
		}

		if(!$this->dniFormat($this->dni_alumno)){
			fillAttributeException('DNI_FORMATO_INCORRECTO');
		}

		if($this->nifLetter($this->dni_alumno)===false) {
			fillAttributeException('DNI_LETRA_INCORRECTA');
		}
	}
}
?>