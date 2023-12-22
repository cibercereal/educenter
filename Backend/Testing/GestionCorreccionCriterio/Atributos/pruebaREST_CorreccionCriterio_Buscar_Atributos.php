<?php

function pruebaREST_CorreccionCriterio_Buscar_Atributos(){

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
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'search';
	$POST['dni_alumno'] = '111';

	$prueba = 'El dni del alumno no puede ser menor que 9.';
	$codeEsperado = 'DNI_MENOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_MAYOR_QUE_9
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'search';
	$POST['dni_alumno'] = '11111111111';

	$prueba = 'El dni del alumno no puede ser mayor que 9.';
	$codeEsperado = 'DNI_MAYOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_FORMATO_INCORRECTO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'search';
	$POST['dni_alumno'] = 'abcabcabc';

	$prueba = 'El dni del alumno tiene un formato incorrecto.';
	$codeEsperado = 'DNI_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_LETRA_INCORRECTA
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'search';
	$POST['dni_alumno'] = '11111111L';

	$prueba = 'El dni del alumno tiene la letra incorrecta.';
	$codeEsperado = 'DNI_LETRA_INCORRECTA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_ENTREGA_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'search';
	$POST['dni_alumno'] = '11111111H';
	$POST['id_entrega'] = 'abc';

	$prueba = 'La entrega tiene un formato erróneo.';
	$codeEsperado = 'ID_ENTREGA_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_TRABAJO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'search';
	$POST['dni_alumno'] = '11111111H';
	$POST['id_entrega'] = '1';
	$POST['id_trabajo'] = 'abc';

	$prueba = 'El trabajo tiene un formato erróneo.';
	$codeEsperado = 'ID_TRABAJO_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_FIN_CORRECCION_FORMATO_INCORRECTO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'search';
	$POST['dni_alumno'] = '11111111H';
	$POST['id_entrega'] = '1';
	$POST['id_trabajo'] = '1';
	$POST['fecha_fin_correccion'] = '19022023';

	$prueba = 'La fecha de fin de corrección tiene un formato incorrecto.';
	$codeEsperado = 'FECHA_FIN_CORRECCION_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_FIN_CORRECCION_SOLO_NUMEROS_Y_GUIONES
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'search';
	$POST['dni_alumno'] = '11111111H';
	$POST['id_entrega'] = '1';
	$POST['id_trabajo'] = '1';
	$POST['fecha_fin_correccion'] = '2021-1$-06';

	$prueba = 'La fecha de fin de corrección tiene un formato incorrecto.';
	$codeEsperado = 'FECHA_FIN_CORRECCION_SOLO_NUMEROS_Y_GUIONES';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_FIN_CORRECCION_MENOR_QUE_10
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'search';
	$POST['dni_alumno'] = '11111111H';
	$POST['id_entrega'] = '1';
	$POST['id_trabajo'] = '1';
	$POST['fecha_fin_correccion'] = '2021-1-06';

	$prueba = 'La fecha de fin de corrección no puede ser menor que 10.';
	$codeEsperado = 'FECHA_FIN_CORRECCION_MENOR_QUE_10';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_FIN_CORRECCION_MAYOR_QUE_10
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'search';
	$POST['dni_alumno'] = '11111111H';
	$POST['id_entrega'] = '1';
	$POST['id_trabajo'] = '1';
	$POST['fecha_fin_correccion'] = '2021-111-06';

	$prueba = 'La fecha de fin de corrección no puede ser mayor que 10.';
	$codeEsperado = 'FECHA_FIN_CORRECCION_MAYOR_QUE_10';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>