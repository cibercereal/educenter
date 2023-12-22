<?php

include_once './Controller/ControllerBase.php';

class correctionCriteria extends ControllerBase {

    function assignRandom() {
        returnRest($this->checkPermission() ?  $this->service->startRest() : $this->createNonPermissionMessage());
    }

    function editTeacher() {
        returnRest($this->checkPermission() ?  $this->service->startRest() : $this->createNonPermissionMessage());
    }
}
?>