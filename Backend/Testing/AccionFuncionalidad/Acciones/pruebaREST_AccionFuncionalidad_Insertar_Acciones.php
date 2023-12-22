<?php

function pruebaREST_AccionFuncionalidad_Insertar_Acciones(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Acción';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ACCION
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    // RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'actionFunctionality';
    $POST['action'] = 'add';
    $POST['checked'] = 'true';
    $POST['id_funcionalidad'] = '2';
    $POST['id_accion'] = '3';

    $prueba = 'Añadir acción-funcionalidad correctamente.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ACCION_FUNCIONALIDAD_EXISTE
	$POST = $vaciarPost;
	$POST['controller'] = 'actionFunctionality';
	$POST['action'] = 'add';
	$POST['checked'] = 'true';
	$POST['id_funcionalidad'] = '1';
	$POST['id_accion'] = '1';

	$prueba = 'La relación acción-funcionalidad ya existe.';
	$codeEsperado = 'ACCION_FUNCIONALIDAD_EXISTE';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // PERMISOS_KO
    $POST = $vaciarPost;
    $POST['controller'] = 'actionFunctionality';
    $POST['action'] = 'add';
    $POST['checked'] = 'true';
    $POST['id_funcionalidad'] = '2';
    $POST['id_accion'] = '3';

    $prueba = 'No tiene permisos para realizar la acción.';
    $codeEsperado = 'PERMISOS_KO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);    


    // Eliminar acción-funcionalidad añadida
    $POST = $vaciarPost;
	$POST['controller'] = 'actionFunctionality';
	$POST['action'] = 'add';
	$POST['checked'] = 'false';
	$POST['id_funcionalidad'] = '2';
	$POST['id_accion'] = '3';

	$pruebas->peticionCurlNoTest($POST);


    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>