<?php

abstract class ControllerBase {

	public function __construct() {
		include_once './Service/'.controller.'Service.php';

        $nameService = controller;
        $nameService = $nameService.'Service';
		$this->service = new $nameService();
	}

	function search() {
		returnRest($this->checkPermission() ? $this->service->startRest() : $this->createNonPermissionMessage());
	}

	function searchBy(){
		returnRest($this->service->startRest());
	}

	function add() {
		returnRest($this->checkPermission() ? $this->service->startRest() : $this->createNonPermissionMessage());
	}

	function edit() {
		returnRest($this->checkPermission() ? $this->service->startRest() : $this->createNonPermissionMessage());
	}

	function delete() {
		returnRest($this->checkPermission() ? $this->service->startRest() : $this->createNonPermissionMessage());
	}

	function finalDelete() {
		returnRest($this->service->startRest());
	}

	function createNonPermissionMessage() {
		$this->feedback['ok'] = false;
		$this->feedback['code'] = "PERMISOS_KO";
		return $this->feedback;
	}

	function checkPermission() {
		return $this->service->checkPermission();
	}
}
?>
