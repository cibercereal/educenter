<?php

function pruebaREST_RolAccionFuncionalidad_Buscar_Atributos() {

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
												//ERRORES_ATRIBUTO RolAccionFuncionalidad buscar
    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//ID_ACCION_ERROR_FORMATO
	$POST = $emptyPost;
	$POST['controller'] = 'roleActionFunctionality';
	$POST['action'] = 'search';
	$POST['id_accion'] = 'abc';
	$POST['id_rol'] = 1;
	$POST['id_funcionalidad'] = 1;

	$test = 'La acción no tiene el formato esperado.';
	$expectedCode = 'ID_ACCION_ERROR_FORMATO';
	$tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

//---------------------------------------------------------------------------------------------------------------------

	//ID_FUNCIONALIDAD_ERROR_FORMATO
	$POST = $emptyPost;
	$POST['controller'] = 'roleActionFunctionality';
	$POST['action'] = 'search';
	$POST['id_accion'] = 1;
	$POST['id_rol'] = 1;
	$POST['id_funcionalidad'] = 'abc';

	$test = 'La funcionalidad no tiene el formato esperado.';
	$expectedCode = 'ID_FUNCIONALIDAD_ERROR_FORMATO';
	$tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

//---------------------------------------------------------------------------------------------------------------------

	//ID_ROL_ERROR_FORMATO
	$POST = $emptyPost;
	$POST['controller'] = 'roleActionFunctionality';
	$POST['action'] = 'search';
	$POST['id_accion'] = 1;
	$POST['id_funcionalidad'] = 1;
	$POST['id_rol'] = 'abc';

	$test = 'El rol no tiene el formato esperado.';
	$expectedCode = 'ID_ROL_ERROR_FORMATO';
	$tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

//---------------------------------------------------------------------------------------------------------------------

	$tests->desconectarCurl($tests->cliente);

	return $tests->resultadoTest;

}

?>