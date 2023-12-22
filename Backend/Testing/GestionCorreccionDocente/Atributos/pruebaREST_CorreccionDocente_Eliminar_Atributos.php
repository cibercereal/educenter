<?php

function pruebaREST_CorreccionDocente_Eliminar_Atributos(){

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

	//ID_CORRECCION_PROFESOR_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'delete';
	$POST['id_correccion_profesor'] = '';

	$prueba = 'El id de la corrección no puede ser vacío.';
	$codeEsperado = 'ID_CORRECCION_PROFESOR_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_CORRECCION_PROFESOR_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'delete';
	$POST['id_correccion_profesor'] = 'abc';

	$prueba = 'El id de la corrección tiene un formato erróneo.';
	$codeEsperado = 'ID_CORRECCION_PROFESOR_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>