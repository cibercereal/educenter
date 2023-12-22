<?php

include_once './Controller/ControllerBase.php';

class correctionTeacher extends ControllerBase {

    function showCorrection() {
        returnRest($this->checkPermission() ?  $this->service->startRest() : $this->createNonPermissionMessage());
    }
}
?>