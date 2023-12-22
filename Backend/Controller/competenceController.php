<?php

include_once './Controller/ControllerBase.php';

class competence extends ControllerBase {

    function assignCompetence() {
        returnRest($this->checkPermission() ? $this->service->startRest() : $this->createNonPermissionMessage());
    }
}
?>