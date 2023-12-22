<?php

class academicCourseAttValidation extends Validate {

    function validateSearchAttributes() {
		$this->checkSearchName();
	}

	function validateAddAttributes() {
		$this->checkName();
	}

	function validateEditAttributes() {
		$this->checkId();
		$this->checkName();
	}

	function validateDeleteAttributes() {
		$this->checkId();
	}

	function checkName(){

		if($this->isEmpty($this->nombre_curso_academico)===true){
			fillAttributeException('NOMBRE_VACIO');
		}

		if($this->minLength($this->nombre_curso_academico,3)===false){
			fillAttributeException('NOMBRE_MENOR_QUE_3');
		}

		if($this->maxLength($this->nombre_curso_academico,45)===false){
			fillAttributeException('NOMBRE_MAYOR_QUE_45');
		}
	}

	function checkId(){

		if($this->isEmpty($this->id_curso_academico)===true){
			fillAttributeException('ID_VACIO');
		}

		if($this->minLength($this->id_curso_academico,1)===false){
			fillAttributeException('ID_MENOR_QUE_1');
		}

		if($this->maxLength($this->id_curso_academico,11)===false){
			fillAttributeException('ID_MAYOR_QUE_11');
		}

		if(!$this->isNumeric($this->id_curso_academico)){
			fillAttributeException('ID_FORMATO_INCORRECTO');
		}
	}

    function checkSearchName() {
		if(!empty($this->nombre_curso_academico)){
		    if($this->minLength($this->nombre_curso_academico,3)===false){
			    fillAttributeException('NOMBRE_MENOR_QUE_3');
		    }

			if($this->maxLength($this->nombre_curso_academico,45)===false){
				fillAttributeException('NOMBRE_MAYOR_QUE_45');
			}
		}
	}
}
?>