<?php
      include_once './Core/codes.php';
      include_once './Core/fillException.php';
      include_once './TestAccessPoint/funcionesComunes_TestAccessPoint.php';

      header('Access-Control-Allow-Origin: *');

      if (  ( !isset($_POST['controller']) and !isset($_POST['action']) ) or
            !isset($_POST['controller']) or !isset($_POST['action'])){
                  invalidRequest('PETICION_INVALIDA');
      }
      
      define('controller', $_POST['controller']);
      define('action', $_POST['action']);

      include_once './Controller/authController.php';
      $auth = new auth();
      $auth->tokenVerify();
      
      if(rolUserSystem == 1){
         $rest = controller;
         $action = action;
         
         if(file_exists('./TestAccessPoint/pruebaREST_'.$rest.'.php')){
               include_once './TestAccessPoint/pruebaREST_'.$rest.'.php';
               $restName = new $rest;	
         }else{
            invalidRequest('ACCION_NO_ENCONTRADA');
         }

         $controllerMethods = get_class_methods($restName);
         //var_dump($controllerMethods);
         //var_dump($action);
         if(in_array($action, $controllerMethods)){  
               $restName->$action();
         }
         else{
            invalidRequest('ACCION_NO_ENCONTRADA');
         }
      }
      else{
            invalidRequest('ACCION_DENEGADA_TEST');
      }

      function invalidRequest($mensaje){
            header('Content-type: application/json');
            echo(json_encode(array('ok' => 'false', 'code' => $mensaje))); 
            exit();
	}
   
?>