<?php

include_once './Controller/ControllerBase.php';

class subject extends ControllerBase {

    function assignTeacher() {
        returnRest($this->checkPermission() ? $this->service->startRest() : $this->createNonPermissionMessage());
    }
}
?>