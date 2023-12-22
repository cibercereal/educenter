<?php

function pruebaREST_NotasCriterio_Buscar_Atributos(){

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

	//ID_TRABAJO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeProject';
    $POST['action'] = 'search';
	$POST['id_trabajo'] = 'abc';

    $prueba = 'El id del trabajo tiene un formato incorrecto.';
    $codeEsperado = 'ID_TRABAJO_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_ENTREGA_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeProject';
    $POST['action'] = 'search';
	$POST['id_trabajo'] = '1';
    $POST['id_entrega'] = 'abc';

    $prueba = 'El formato del id de entrega es incorrecto.';
    $codeEsperado = 'ID_ENTREGA_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_MENOR_QUE_9
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeProject';
    $POST['action'] = 'search';
	$POST['id_trabajo'] = '1';
    $POST['id_entrega'] = '1';
    $POST['dni'] = 'abc';

    $prueba = 'El dni de la entrega no puede ser menor que 9.';
    $codeEsperado = 'DNI_MENOR_QUE_9';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------
	//DNI_MAYOR_QUE_9
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeProject';
    $POST['action'] = 'search';
    $POST['dni'] = 'aaaaaaaaaaaaaaa';
	$POST['id_trabajo'] = '1';
    $POST['id_entrega'] = '1';

    $prueba = 'El dni de la entrega no puede ser mayor que 9.';
    $codeEsperado = 'DNI_MAYOR_QUE_9';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_FORMATO_INCORRECTO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeProject';
    $POST['action'] = 'search';
    $POST['dni'] = 'aaaaaaaaa';
	$POST['id_trabajo'] = '1';
    $POST['id_entrega'] = '1';

    $prueba = 'El formato del dni es incorrecto.';
    $codeEsperado = 'DNI_FORMATO_INCORRECTO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_LETRA_INCORRECTA
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeProject';
    $POST['action'] = 'search';
    $POST['dni'] = '11111111Z';
	$POST['id_trabajo'] = '1';
    $POST['id_entrega'] = '1';

    $prueba = 'La letra del dni es incorrecta.';
    $codeEsperado = 'DNI_LETRA_INCORRECTA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//NOTA_TRABAJO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeProject';
    $POST['action'] = 'search';
	$POST['id_trabajo'] = '1';
    $POST['id_entrega'] = '1';
    $POST['dni'] = '11111111H';
    $POST['nota_trabajo'] = 'abc';

    $prueba = 'La nota del trabajo tiene un formato incorrecto.';
    $codeEsperado = 'NOTA_TRABAJO_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//NOTA_TRABAJO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeProject';
    $POST['action'] = 'search';
	$POST['id_trabajo'] = '1';
    $POST['id_entrega'] = '1';
    $POST['dni'] = '11111111H';
    $POST['nota_trabajo'] = '1';
    $POST['nota_correccion'] = 'abc';

    $prueba = 'La nota de la corrección tiene un formato incorrecto.';
    $codeEsperado = 'NOTA_CORRECCION_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>