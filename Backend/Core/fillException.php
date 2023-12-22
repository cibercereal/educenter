<?php

function fillExceptionAction($message) {
    $feedback['ok'] = false;
    $feedback['code'] = $message;
    
    if(!isset($_POST['test'])){
        //logExceptionsAction($feedback);
    }
    
    header('Content-type: application/json');
    echo(json_encode($feedback)); 
    exit();
}

function fillAttributeException($message){
    $feedback['ok'] = false;
    $feedback['code'] = $message;
    /* if(!isset($_POST['test'])) {
        logAttributeException($feedback);
    } */
    header('Content-type: application/json');
    echo(json_encode($feedback)); 
    exit();
}

function logAttributeException($feedback){
    include_once './Model/logAttributeExceptionModel.php';
    
    $log = new logAttributeExceptionModel();
    date_default_timezone_set('Europe/Madrid');
    if(action == 'login') {
        define('userSystem', 'DESCONOCIDO');
    }

    $log->arrayDataValue = array( 
        'usuario' => userSystem, 
        'funcionalidad' => controller,
        'accion' => action,
        'codigo' => $feedback['code'],
        'mensaje' => constant($feedback['code']),
        'tiempo' => (string)date("Y-m-d H:i:s", time()));
            
    $log->ADD();
    
}

function logExceptionsAction($feedback){
    include_once './Model/logExceptionActionsModel.php';

    $log = new logExceptionActionsModel();
    date_default_timezone_set('Europe/Madrid');
    
    if(action == 'login' || action == 'register' || action == 'getPasswordEmail'){
        define('userSystem', 'DESCONOCIDO');
    }

    $cod = substr($feedback['code'], 0, 5);
    if($cod == 'TOKEN'){
        // Don't save errors from action like TOKEN_CADUCADO...
    }else{
        $log->arrayDataValue = array( 
            'usuario' => userSystem, 
            'funcionalidad' => controller,
            'accion' => action,
            'codigo' => $feedback['code'],
            'mensaje' => constant($feedback['code']),
            'tiempo' => (string)date("Y-m-d H:i:s", time()));
        $log->ADD();
    }
}

function returnRest($feedback){
    header('Content-type: application/json');
    echo(json_encode($feedback));
}

?>