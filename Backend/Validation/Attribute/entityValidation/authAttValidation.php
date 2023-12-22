<?php

class authAttValidation extends Validate {
	
	function validate_data_login(){
		$this->validateUser();
		$this->validatePass();		
	}

	function validateUser(){
		
		if($this->isEmpty($this->dni)===true) {
			fillAttributeException('DNI_VACIO');
		}

		if($this->minLength($this->dni, 9)===false) {
			fillAttributeException('DNI_MENOR_QUE_9');
		}

		if($this->maxLength($this->dni, 9)===false) {
			fillAttributeException('DNI_MAYOR_QUE_9');
		}

		if(!$this->dniFormat($this->dni)) {
			fillAttributeException('DNI_FORMATO_INCORRECTO');
		}
			
		if($this->nifLetter($this->dni)===false) {
			fillAttributeException('DNI_LETRA_INCORRECTA');
		}
	}

    function validatePass(){

		if($this->isEmpty($this->password)===true) {
			fillAttributeException('CONTRASENA_USUARIO_VACIA');
		}

		if($this->exactLength($this->password,32)===false) {
			fillAttributeException('CONTRASEÑA_USUARIO_LONGITUD_INCORRECTA');
		}	

		if(!$this->checkLoginPassFormat($this->password)) {
			fillAttributeException('CONTRASEÑA_USUARIO_ALFANUMERICO_INCORRECTO');
		}	
	}

	function validate_data_register(){
		$this->validateUser();
		$this->validatePass();
		$this->validateName();
		$this->validateSurname();
		$this->validteBirthdate();
		$this->validateAddress();
		$this->validatePhone();
		$this->validateEmail();
		$this->validateRole();
	}

	function validate_data_getPasswordEmail() {
		$this->validateUser();
		$this->validateEmail();
	}

	function validateAddress(){
		
		if($this->isEmpty($this->direccion)===true){
			fillAttributeException('DIRECCION_VACIA');
		}

		if($this->minLength($this->direccion,5)===false){
			fillAttributeException('DIRECCION_MENOR_5');
		}

		if($this->maxLength($this->direccion,200)===false){
			fillAttributeException('DIRECCION_MAYOR_200');
		}

		if($this->addressFormat($this->direccion)===false){
			fillAttributeException('DIRECCION_FORMATO_INCORRECTO');
		}
	}

	function validatePhone(){

		if($this->isEmpty($this->telefono)===true){
			fillAttributeException('TELEFONO_VACIO');
		}

		if($this->minLength($this->telefono,9)===false){
			fillAttributeException('TELEFONO_MENOR_QUE_9');
		}

		if($this->maxLength($this->telefono,9)===false){
			fillAttributeException('TELEFONO_MAYOR_QUE_9');
		}

		if(!$this->isNumeric($this->telefono)){
			fillAttributeException('TELEFONO_FORMATO_INCORRECTO');
		}
	}

	function validateEmail(){

		if($this->isEmpty($this->email)===true){
			fillAttributeException('EMAIL_VACIO');
		}

		if($this->minLength($this->email,6)===false){
			fillAttributeException('EMAIL_LONGITUD_MINIMA');
		}

		if($this->maxLength($this->email,40)===false){
			fillAttributeException('EMAIL_LONGITUD_MAXIMA');
		}

		if($this->emailFormat($this->email)===false){
			fillAttributeException('EMAIL_FORMATO_INCORRECTO');
		}
	}

	function validateRole(){
		if($this->isEmpty($this->id_rol)===true){
			fillAttributeException('ROL_VACIO');
		}

        if(!$this->isNumeric($this->id_rol)===true){
            fillAttributeException('ID_ROL_ERROR_FORMATO');
        }
	}

	function checkAddress(){
		
		if($this->isEmpty($this->direccion)===true){
			fillAttributeException('DIRECCION_VACIA');
		}

		if($this->minLength($this->direccion,5)===false){
			fillAttributeException('DIRECCION_MENOR_5');
		}

		if($this->maxLength($this->direccion,200)===false){
			fillAttributeException('DIRECCION_MAYOR_200');
		}

		if($this->addressFormat($this->direccion)===false){
			fillAttributeException('DIRECCION_FORMATO_INCORRECTO');
		}
	}

	function validateName(){

		if($this->isEmpty($this->nombre)===true){
			fillAttributeException('NOMBRE_VACIO');
		}

		if($this->minLength($this->nombre,3)===false){
			fillAttributeException('NOMBRE_MENOR_QUE_3');
		}

		if($this->maxLength($this->nombre,45)===false){
			fillAttributeException('NOMBRE_MAYOR_QUE_45');
		}

		if(!$this->checkSpaceLetters($this->nombre)){
			fillAttributeException('NOMBRE_FORMATO_INCORRECTO');
		}
	}

	function validateSurname(){

		if($this->isEmpty($this->apellidos_usuario)===true){
			fillAttributeException('APELLIDOS_VACIO');
		}

		if($this->minLength($this->apellidos_usuario,3)===false){
			fillAttributeException('APELLIDOS_MENOR_QUE_3');
		}

		if($this->maxLength($this->apellidos_usuario,45)===false){
			fillAttributeException('APELLIDOS_MAYOR_QUE_45');
		}	

		if(!$this->checkSpaceLetters($this->apellidos_usuario)){
			fillAttributeException('APELLIDOS_FORMATO_INCORRECTO');
		}
	}

	function validteBirthdate(){
		if($this->isEmpty($this->fecha_nac)===true){
			fillAttributeException('FECHA_NACIMIENTO_VACIA');
		}

		switch ($this->checkDateNumbersSlash($this->fecha_nac)) {
			case 'formatofechamal':
				fillAttributeException('FECHA_NACIMIENTO_FORMATO_INCORRECTO');
				break;

			case 'tieneletras':
				fillAttributeException('FECHA_NACIMIENTO_SOLO_NUMEROS_Y_GUIONES');
				break;

			case 'tamañomenor10':
				fillAttributeException('FECHA_NACIMIENTO_MENOR_QUE_10');
				break;			

			case 'tamañomayor10':
				fillAttributeException('FECHA_NACIMIENTO_MAYOR_QUE_10');
				break;
				
			case 'fechafutura':
				fillAttributeException('FECHA_NACIMIENTO_IMPOSIBLE');
				break;

			default:
				break;
		}
	}
}
?>