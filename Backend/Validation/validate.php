<?php

class Validate {

    var $validation = array();
	public $arrayDataValue;
	public $searchCriteria;

    function maxLength($string, $value) {
		return strlen($string)<=$value;
	}

    function minLength($string, $value) {
		return strlen($string)>=$value;
	}

	function exactLength($string, $value) {
		return strlen($string)==$value;
	}

	function isEmptyObject($object) {
	    return empty($object);
	}

    function isEmpty($string) {
		return (($string=='') || (strlen($string) == 0));
	}

    function checkLoginPassFormat($string) {
	    return preg_match('/^[a-zA-Z0-9]+$/s',$string);
	}

    function dniFormat($dni) {
        return preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $dni);
  	}

  	function nifLetter($dni) {
		$letter = substr($dni, -1);
		$dni = intval($dni);
		$position= intval($dni%23);
		$letters= "TRWAGMYFPDXBNJZSQVHLCKE";
		$letterNif= substr ($letters, $position, 1);

		return ($letter === $letterNif);
	}

	function isNumeric($string) {
		return preg_match('/(^[0-9]+$)/', $string);
	}

	function checkSpaceLetters($string) {
		return preg_match('/^[a-zA-ZÀ-ÿÃ±Ã‘ ]+$/s', $string);
	}

	function checkDateNumbersSlash($date){
		
		$slides = explode('-', $date);
		
		if (count($slides) != 3){
			$error = 'formatofechamal';
			return $error;
		}

		if ((!ctype_digit($slides[0])) || (!ctype_digit($slides[1])) || (!ctype_digit($slides[2]))){
			$error = 'tieneletras';
			return $error;
		}

		if (strlen($date) < 10) {
			$error = 'tamañomenor10';
			return $error;
		}

		if (strlen($date) > 10) {
			$error = 'tamañomayor10';
			return $error;
		}

		if (((strlen($slides[0]) != 4)) || ((strlen($slides[1]) != 2)) || ((strlen($slides[2]) != 2))) {
			$error = 'formatofechamal';
			return $error;
		}

		if (intval($slides[1])>12){
			$error = 'formatofechamal';
			return $error;
		}
		
		if (intval($slides[2])>31) {
			$error = 'formatofechamal';
			return $error;
		}

		date_default_timezone_set('Europe/Madrid');
		$date = $slides[2].'-'.$slides[1].'-'.$slides[0].' 00:00:00';
		$date = date(strtotime($date));
		$actualDate = strtotime(date("d-m-Y H:i:00",time()));
				
		if ($date >= $actualDate && (action != 'search')) {
			$error = 'fechafutura';
			return $error;
		}
	}

	function emailFormat($string){
		return filter_var($string, FILTER_VALIDATE_EMAIL);
   }

   function isFlag($string){
	return !($string != 0 && $string != 1);
   }

   function addressFormat($string){
	return !preg_match('/[^a-zA-Z0-9À-ÿºª,.\/\\s]/',$string);
   }

   function isAlphanumeric($string){
		return !preg_match('/[^a-zA-ZÀ-ÿ0-9]/',$string);
   }
}
?>