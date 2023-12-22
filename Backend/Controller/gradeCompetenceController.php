<?php

include_once './Controller/ControllerBase.php';

class gradeCompetence extends ControllerBase {

    function makeVisible() {
        returnRest($this->checkPermission() ?  $this->service->startRest() : $this->createNonPermissionMessage());
    }
}
?>