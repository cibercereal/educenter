<?php

function pruebaREST_NotasCompetencia_Buscar_Atributos(){

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

	//ID_MATERIA_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
	$POST['id_materia'] = 'abc';

    $prueba = 'El id de la materia tiene un formato incorrecto.';
    $codeEsperado = 'ID_MATERIA_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_TRABAJO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
	$POST['id_trabajo'] = 'abc';

    $prueba = 'El id del trabajo tiene un formato incorrecto.';
    $codeEsperado = 'ID_TRABAJO_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_COMPETENCIA_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
	$POST['id_competencia'] = 'abc';

    $prueba = 'El formato del id de competencia es incorrecto.';
    $codeEsperado = 'ID_COMPETENCIA_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//NOTA_COMPETENCIA_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
	$POST['nota_competencia'] = 'abc';

    $prueba = 'El formato de la nota de competencia es erróneo.';
    $codeEsperado = 'NOTA_COMPETENCIA_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_MENOR_QUE_9
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
    $POST['dni'] = 'abc';

    $prueba = 'El dni no puede ser menor que 9.';
    $codeEsperado = 'DNI_MENOR_QUE_9';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------
	//DNI_MAYOR_QUE_9
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
    $POST['dni'] = 'aaaaaaaaaaaaaaa';

    $prueba = 'El dni no puede ser mayor que 9.';
    $codeEsperado = 'DNI_MAYOR_QUE_9';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_FORMATO_INCORRECTO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
    $POST['dni'] = 'aaaaaaaaa';

    $prueba = 'El formato del dni es incorrecto.';
    $codeEsperado = 'DNI_FORMATO_INCORRECTO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_LETRA_INCORRECTA
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
    $POST['dni'] = '11111111Z';

    $prueba = 'La letra del dni es incorrecta.';
    $codeEsperado = 'DNI_LETRA_INCORRECTA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//VISIBLE_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
    $POST['visible'] = 'abc';

    $prueba = 'El campo visible tiene un formato incorrecto.';
    $codeEsperado = 'VISIBLE_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>