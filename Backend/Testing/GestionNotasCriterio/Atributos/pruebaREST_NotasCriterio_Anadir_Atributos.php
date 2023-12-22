<?php

function pruebaREST_NotasCriterio_Anadir_Atributos(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Atributo';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto con usuario docente
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//ID_TRABAJO_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeProject';
    $POST['action'] = 'add';
	$POST['id_trabajo'] = '';

	$prueba = 'El id del trabajo no puede ser vacío.';
	$codeEsperado = 'ID_TRABAJO_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_TRABAJO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeProject';
    $POST['action'] = 'add';
	$POST['id_trabajo'] = 'abc';

    $prueba = 'El id del trabajo tiene un formato incorrecto.';
    $codeEsperado = 'ID_TRABAJO_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_ENTREGA_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeProject';
    $POST['action'] = 'add';
	$POST['id_trabajo'] = '1';
    $POST['id_entrega'] = '';

    $prueba = 'El id de entrega no puede ser vacío.';
    $codeEsperado = 'ID_ENTREGA_VACIO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_ENTREGA_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeProject';
    $POST['action'] = 'add';
	$POST['id_trabajo'] = '1';
    $POST['id_entrega'] = 'abc';

    $prueba = 'El formato del id de entrega es incorrecto.';
    $codeEsperado = 'ID_ENTREGA_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>