<?php

function pruebaREST_CorreccionCriterio_AsignarAleatorio_Atributos(){

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

	//NUMERO_ALUMNOS_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'assignRandom';
	$POST['numero_alumnos'] = '';

	$prueba = 'El número de alumnos no puede ser vacío.';
	$codeEsperado = 'NUMERO_ALUMNOS_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//NUMERO_ALUMNOS_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'assignRandom';
	$POST['numero_alumnos'] = 'abc';

	$prueba = 'El número de alumnos tiene un formato erróneo.';
	$codeEsperado = 'NUMERO_ALUMNOS_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_TRABAJO_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'assignRandom';
	$POST['numero_alumnos'] = '3';
	$POST['id_trabajo'] = '';

	$prueba = 'El trabajo no puede ser vacío.';
	$codeEsperado = 'ID_TRABAJO_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_TRABAJO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'assignRandom';
	$POST['numero_alumnos'] = '3';
	$POST['id_trabajo'] = 'abc';

	$prueba = 'El trabajo tiene un formato erróneo.';
	$codeEsperado = 'ID_TRABAJO_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_FIN_CORRECCION_VACIA
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'assignRandom';
	$POST['numero_alumnos'] = '3';
	$POST['id_trabajo'] = '1';
	$POST['fecha_fin_correccion'] = '';

	$prueba = 'La fecha de fin de corrección no puede ser vacía.';
	$codeEsperado = 'FECHA_FIN_CORRECCION_VACIA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_FIN_CORRECCION_FORMATO_INCORRECTO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'assignRandom';
	$POST['numero_alumnos'] = '3';
	$POST['id_trabajo'] = '1';
	$POST['fecha_fin_correccion'] = '19022023';

	$prueba = 'La fecha de fin de corrección tiene un formato incorrecto.';
	$codeEsperado = 'FECHA_FIN_CORRECCION_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_FIN_CORRECCION_SOLO_NUMEROS_Y_GUIONES
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'assignRandom';
	$POST['numero_alumnos'] = '3';
	$POST['id_trabajo'] = '1';
	$POST['fecha_fin_correccion'] = '2021-1$-06';

	$prueba = 'La fecha de fin de corrección tiene un formato incorrecto.';
	$codeEsperado = 'FECHA_FIN_CORRECCION_SOLO_NUMEROS_Y_GUIONES';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_FIN_CORRECCION_MENOR_QUE_10
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'assignRandom';
	$POST['numero_alumnos'] = '3';
	$POST['id_trabajo'] = '1';
	$POST['fecha_fin_correccion'] = '2021-1-06';

	$prueba = 'La fecha de fin de corrección no puede ser menor que 10.';
	$codeEsperado = 'FECHA_FIN_CORRECCION_MENOR_QUE_10';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_FIN_CORRECCION_MAYOR_QUE_10
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'assignRandom';
	$POST['numero_alumnos'] = '3';
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