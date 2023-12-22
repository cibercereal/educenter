<?php

function pruebaREST_Criterio_Insertar_Atributos(){

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

	//DESCRIPCION_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'add';
	$POST['descripcion'] = '';

	$prueba = 'La descripción del criterio no puede ser vacío.';
	$codeEsperado = 'DESCRIPCION_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DESCRIPCION_MENOR_QUE_9
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'add';
	$POST['descripcion'] = 'prueba';

	$prueba = 'La descripción del criterio no puede ser menor de 9 caracteres.';
	$codeEsperado = 'DESCRIPCION_MENOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DESCRIPCION_MAYOR_QUE_200
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'add';
	$POST['descripcion'] = 'Hoy una estrella brillará más en el cielo, y desde Sevilla a Madrid mandará un gran beso a una princesa que seguro habrá tenido un día muy especial…Hoy una estrella brillará más en el cielo, y desde Sevilla a Madrid mandará un gran beso a una princesa que seguro habrá tenido un día muy especial…';

	$prueba = 'La descripción del criterio no puede ser mayor de 200 caracteres.';
	$codeEsperado = 'DESCRIPCION_MAYOR_QUE_200';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_TRABAJO_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'add';
	$POST['descripcion'] = 'criterio test';
	$POST['id_trabajo'] = '';

	$prueba = 'El id del trabajo no puede ser vacío.';
	$codeEsperado = 'ID_TRABAJO_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_TRABAJO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'add';
	$POST['descripcion'] = 'criterio test';
	$POST['id_trabajo'] = 'abc';

	$prueba = 'El id del trabajo no tiene un formato correcto.';
	$codeEsperado = 'ID_TRABAJO_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>