<?php

include_once './Controller/ControllerBase.php';

class user extends ControllerBase {
    function editPass(){
        returnRest($this->checkPermission() ? $this->service->startRest() : $this->createNonPermissionMessage());
	}
}
?>