<?php
include_once './Core/codes.php';
include_once './Core/fillException.php';

header('Access-Control-Allow-Origin: *');

if ((!isset($_POST['controller']) and !isset($_POST['action']) ) or
	!isset($_POST['controller']) or !isset($_POST['action'])){
	$jsonDataString = file_get_contents('php://input');
    $jsonData = json_decode($jsonDataString, true);
	if(isset($jsonData['document']) && !empty($jsonData['document'])
	    && !empty($jsonData['document']['action']) && !empty($jsonData['document']['controller'])){
	    $_POST['controller'] = $jsonData['document']['controller'];
	    $_POST['action'] = $jsonData['document']['action'];
	    $_POST['data'] = $jsonData;
	} else {
	    invalidRequest('PETICION_INVALIDA');
	}
}

define('controller', $_POST['controller']);
define('action', $_POST['action']);

$rest = controller;
$action = action;
	
if ($rest != 'auth') {
	include_once './Controller/authController.php';
	$auth = new auth();
	$auth->tokenVerify();
}

if(file_exists('./Controller/'.$rest.'Controller.php')){
	include_once './Controller/'.$rest.'Controller.php';
	$restName = new $rest;	
} else {
	invalidRequest('CONTROLADOR_NO_ENCONTRADO');
}

$controllerMethods = get_class_methods($restName);

if (in_array($action, $controllerMethods)) {
	$restName->$action();
} else {
	invalidRequest('ACCION_NO_ENCONTRADA');
}

function invalidRequest($mensaje){
	header('Content-type: application/json');
	echo(json_encode(array('ok' => 'false', 'code' => $mensaje))); 
	exit();
}
   
?>