<?php

function pruebaREST_CriterioCompetencia_Insertar_Atributos(){

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
    $POST['controller'] = 'criteriaCompetence';
    $POST['action'] = 'add';
	$POST['id_criterio'] = '';

	$prueba = 'El criterio no puede ser vacío.';
	$codeEsperado = 'ID_CRITERIO_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_CRITERIO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteriaCompetence';
    $POST['action'] = 'add';
	$POST['id_criterio'] = 'abc';

	$prueba = 'El criterio no tiene un formato válido.';
	$codeEsperado = 'ID_CRITERIO_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_COMPETENCIA_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteriaCompetence';
    $POST['action'] = 'add';
	$POST['id_criterio'] = '1';
	$POST['id_competencia'] = '';

	$prueba = 'La competencia no puede ser vacía.';
	$codeEsperado = 'ID_COMPETENCIA_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_COMPETENCIA_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteriaCompetence';
    $POST['action'] = 'add';
	$POST['id_criterio'] = '1';
	$POST['id_competencia'] = 'abc';

	$prueba = 'La competencia no tiene un formato correcto.';
	$codeEsperado = 'ID_COMPETENCIA_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>