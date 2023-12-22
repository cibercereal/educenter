<?php

function pruebaREST_CorreccionCriterio_EditarDocente_Atributos(){

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

	//ID_CORRECCION_CRITERIO_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'editTeacher';
	$POST['id_correccion_criterio'] = '';

	$prueba = 'El id de la corrección del criterio no puede ser vacío.';
	$codeEsperado = 'ID_CORRECCION_CRITERIO_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_CORRECCION_CRITERIO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'editTeacher';
	$POST['id_correccion_criterio'] = 'abc';

	$prueba = 'El id de la corrección del criterio tiene un formato erróneo.';
	$codeEsperado = 'ID_CORRECCION_CRITERIO_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//CORRECCION_DOCENTE_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'editTeacher';
	$POST['id_correccion_criterio'] = '1';
	$POST['correccion_docente'] = 'abc';

	$prueba = 'La corrección del criterio tiene un error de formato.';
	$codeEsperado = 'CORRECCION_DOCENTE_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//COMENTARIO_DOCENTE_MAYOR_QUE_150
	$POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'editTeacher';
	$POST['id_correccion_criterio'] = '1';
	$POST['correccion_docente'] = '1';
	$POST['comentario_docente'] = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';

	$prueba = 'El comentario del docente no puede ser mayor de 150.';
	$codeEsperado = 'COMENTARIO_DOCENTE_MAYOR_QUE_150';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;
}
?>