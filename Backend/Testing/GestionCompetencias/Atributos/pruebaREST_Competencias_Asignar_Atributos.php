<?php

function pruebaREST_Competencias_Asignar_Atributos(){

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
												//ERRORES_ATRIBUTO contraseña
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//ID_TRABAJO_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'assignCompetence';
	$POST['id_competencia'] = '';

	$prueba = 'El id de la competencia no puede ser vacío.';
	$codeEsperado = 'ID_COMPETENCIA_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_COMPETENCIA_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'assignCompetence';
	$POST['id_competencia'] = 'abc';

	$prueba = 'El id de la competencia tiene un formato erróneo.';
	$codeEsperado = 'ID_COMPETENCIA_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_MATERIA_O_ID_TRABAJO_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'assignCompetence';
	$POST['id_competencia'] = '1';
    $POST['id_materia'] = '';

    $prueba = 'La materia de la competencia no puede ser vacía.';
    $codeEsperado = 'ID_MATERIA_VACIO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_MATERIA_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'assignCompetence';
	$POST['id_competencia'] = '1';
    $POST['id_materia'] = 'ab';

    $prueba = 'El id de la materia tiene un formato erróneo.';
    $codeEsperado = 'ID_MATERIA_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>