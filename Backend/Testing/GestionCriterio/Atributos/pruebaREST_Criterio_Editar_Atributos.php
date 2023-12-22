<?php

function pruebaREST_Criterio_Editar_Atributos(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Atributo';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//ID_CRITERIO_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'edit';
	$POST['id_criterio'] = '';

	$prueba = 'El id del criterio no puede ser vacío.';
	$codeEsperado = 'ID_CRITERIO_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_CRITERIO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'edit';
	$POST['id_criterio'] = 'abc';

	$prueba = 'El id del criterio tiene un formato erróneo.';
	$codeEsperado = 'ID_CRITERIO_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------
	//DESCRIPCION_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'edit';
	$POST['id_criterio'] = '1';
	$POST['descripcion'] = '';
	
	$prueba = 'La descripción del criterio no puede ser vacía.';
	$codeEsperado = 'DESCRIPCION_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);
	
//---------------------------------------------------------------------------------------------------------------------

	//DESCRIPCION_MENOR_QUE_9
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'edit';
	$POST['id_criterio'] = '1';
    $POST['descripcion'] = 'ab';

    $prueba = 'La descripción del criterio no puede ser menor que 9.';
    $codeEsperado = 'DESCRIPCION_MENOR_QUE_9';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DESCRIPCION_MAYOR_QUE_200
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'edit';
	$POST['id_criterio'] = '1';
    $POST['descripcion'] = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';

    $prueba = 'La descripción del criterio no puede ser mayor que 200.';
    $codeEsperado = 'DESCRIPCION_MAYOR_QUE_200';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_TRABAJO_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'edit';
	$POST['id_criterio'] = '1';
    $POST['descripcion'] = 'Competencia test';
    $POST['id_trabajo'] = '';

    $prueba = 'El id del trabajo no puede ser vacío.';
    $codeEsperado = 'ID_TRABAJO_VACIO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_TRABAJO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'edit';
	$POST['id_criterio'] = '1';
    $POST['descripcion'] = 'Competencia test';
    $POST['id_trabajo'] = 'abc';

    $prueba = 'El id del trabajo tiene un formato incorrecto.';
    $codeEsperado = 'ID_TRABAJO_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>