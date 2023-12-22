<?php

include_once './Service/authService.php';

class auth {

	private $service;

	public function __construct() {
		$this->service = new authService();
	}

	function tokenVerify() {	
		$this->service->tokenVerify();
	}

	function login() {
		returnRest($this->service->startRest());
	}

	function register() {
		returnRest($this->service->startRest());
	}

	function getPasswordEmail() {
		returnRest($this->service->startRest());
	}
}
?>