<?php

function pruebaREST_CorreccionDocente_Buscar_Atributos(){

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

	//DNI_MENOR_QUE_9
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'search';
	$POST['dni'] = '111';

	$prueba = 'El dni no puede ser menor que 9.';
	$codeEsperado = 'DNI_MENOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_MAYOR_QUE_9
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'search';
	$POST['dni'] = '11111111111';

	$prueba = 'El dni no puede ser mayor que 9.';
	$codeEsperado = 'DNI_MAYOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_FORMATO_INCORRECTO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'search';
	$POST['dni'] = 'abcabcabc';

	$prueba = 'El dni tiene un formato incorrecto.';
	$codeEsperado = 'DNI_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_LETRA_INCORRECTA
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'search';
	$POST['dni'] = '11111111L';

	$prueba = 'El dni tiene la letra incorrecta.';
	$codeEsperado = 'DNI_LETRA_INCORRECTA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_ENTREGA_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'search';
	$POST['dni'] = '11111111H';
	$POST['id_entrega'] = 'abc';

	$prueba = 'La entrega tiene un formato erróneo.';
	$codeEsperado = 'ID_ENTREGA_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_TRABAJO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'search';
	$POST['dni'] = '11111111H';
	$POST['id_entrega'] = '1';
	$POST['id_trabajo'] = 'abc';

	$prueba = 'El trabajo tiene un formato erróneo.';
	$codeEsperado = 'ID_TRABAJO_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_CRITERIO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'search';
	$POST['id_criterio'] = 'abc';

	$prueba = 'El criterio tiene un formato erróneo.';
	$codeEsperado = 'ID_CRITERIO_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//CORRECCION_DOCENTE_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'search';
	$POST['correccion_docente'] = 'abc';

	$prueba = 'La corrección del docente tiene un formato erróneo.';
	$codeEsperado = 'CORRECCION_DOCENTE_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>