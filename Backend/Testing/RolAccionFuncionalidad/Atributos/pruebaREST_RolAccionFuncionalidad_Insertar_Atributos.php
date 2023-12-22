<?php

function pruebaREST_RolAccionFuncionalidad_Insertar_Atributos() {
    include_once './Testing/pruebaREST_class.php';

    $tests = new testRest();

    $type = 'Atributo';
    $emptyPost = NULL;

    //---------------------------------------------------------------------------------------------------------------------

	//login correcto con user admin
	$POST = $emptyPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$tests->peticionLogin($POST); 
	

    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO accionFuncionalidad
    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//ACCION_VACIO
	$POST = $emptyPost;
    $POST['controller'] = 'roleActionFunctionality';
	$POST['action'] = 'add';
    $POST['checked'] = 'true';
	$POST['id_funcionalidad'] = 1;
    $POST['id_rol'] = 1;
	
	$test = 'La acción no puede estar vacía.';
	$expectedCode = 'ACCION_VACIO';
	$tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);
	
//---------------------------------------------------------------------------------------------------------------------

	//ID_ACCION_ERROR_FORMATO
	$POST = $emptyPost;
	$POST['controller'] = 'roleActionFunctionality';
	$POST['action'] = 'add';
	$POST['checked'] = 'true';
	$POST['id_accion'] = 'abc';
	$POST['id_funcionalidad'] = 1;
    $POST['id_rol'] = 1;

	$test = 'La acción no tiene el formato esperado.';
	$expectedCode = 'ID_ACCION_ERROR_FORMATO';
	$tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

//---------------------------------------------------------------------------------------------------------------------

	//FUNCIONALIDAD_VACIO
	$POST = $emptyPost;
    $POST['controller'] = 'roleActionFunctionality';
	$POST['action'] = 'add';
    $POST['checked'] = 'true';
	$POST['id_accion'] = 1;
    $POST['id_rol'] = 1;
	
	$test = 'La funcionalidad no puede estar vacía.';
	$expectedCode = 'FUNCIONALIDAD_VACIO';
	$tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);
	
//---------------------------------------------------------------------------------------------------------------------

	//ID_FUNCIONALIDAD_ERROR_FORMATO
	$POST = $emptyPost;
	$POST['controller'] = 'roleActionFunctionality';
	$POST['action'] = 'add';
	$POST['checked'] = 'true';
	$POST['id_accion'] = 1;
    $POST['id_rol'] = 1;
	$POST['id_funcionalidad'] = 'abc';

	$test = 'La funcionalidad no tiene el formato esperado.';
	$expectedCode = 'ID_FUNCIONALIDAD_ERROR_FORMATO';
	$tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

//---------------------------------------------------------------------------------------------------------------------

	//ROL_VACIO
	$POST = $emptyPost;
    $POST['controller'] = 'roleActionFunctionality';
	$POST['action'] = 'add';
    $POST['checked'] = 'true';
	$POST['id_accion'] = 1;
    $POST['id_funcionalidad'] = 1;
	
	$test = 'El rol no puede estar vacía.';
	$expectedCode = 'ROL_VACIO';
	$tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);
	
//---------------------------------------------------------------------------------------------------------------------

	//ID_ROL_ERROR_FORMATO
	$POST = $emptyPost;
	$POST['controller'] = 'roleActionFunctionality';
	$POST['action'] = 'add';
	$POST['checked'] = 'true';
	$POST['id_accion'] = 1;
    $POST['id_rol'] = 'abc';
	$POST['id_funcionalidad'] = 1;

	$test = 'El rol no tiene el formato esperado.';
	$expectedCode = 'ID_ROL_ERROR_FORMATO';
	$tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);


//---------------------------------------------------------------------------------------------------------------------

	$tests->desconectarCurl($tests->cliente);

	return $tests->resultadoTest;
}

?>