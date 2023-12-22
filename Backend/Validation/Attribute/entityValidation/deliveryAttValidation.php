<?php

class deliveryAttValidation extends Validate {

    function validateAddAttributes() {
        $this->checkUser();
        $this->checkProject();
        $this->checkData();
    }

    function validateEditAttributes() {
        $this->checkDeliveryId();
        $this->checkData();
    }

    function validateDeleteAttributes() {
        $this->checkDeliveryId();
    }

    function validateSearchAttributes() {
        $this->checkSearchUser();
        $this->checkSearchProject();
        $this->checkSearchDeliveryDate();
    }

    function checkSearchProject() {
        if (!empty($this->id_trabajo)) {
              if(!$this->isNumeric($this->id_trabajo)===true){
                  fillAttributeException('ID_TRABAJO_ERROR_FORMATO');
              }
        }
    }

    function checkSearchUser() {
		if(!empty($this->dni)){
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

    function checkSearchDeliveryDate() {
		if(!empty($this->fecha_entrega)){
			switch ($this->checkDateNumbersSlash($this->fecha_entrega)) {
				case 'formatofechamal':
					fillAttributeException('FECHA_ENTREGA_FORMATO_INCORRECTO');
					break;

				case 'tieneletras':
					fillAttributeException('FECHA_ENTREGA_SOLO_NUMEROS_Y_GUIONES');
					break;

				case 'tamañomenor10':
					fillAttributeException('FECHA_ENTREGA_MENOR_QUE_10');
					break;

				case 'tamañomayor10':
					fillAttributeException('FECHA_ENTREGA_MAYOR_QUE_10');
					break;

				default:
					break;
			}
		}
    }

    function checkUser() {
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

    function checkProject() {
         if($this->isEmpty($this->id_trabajo)===true) {
             fillAttributeException('ID_TRABAJO_VACIO');
         }

         if(!$this->isNumeric($this->id_trabajo)===true){
             fillAttributeException('ID_TRABAJO_ERROR_FORMATO');
         }
    }

     function checkData() {
          if($this->isEmptyObject($this->datos)===true) {
              fillAttributeException('DATOS_VACIO');
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