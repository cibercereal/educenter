<?php

function pruebaREST_Competencias_Buscar_Acciones(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Acción';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	//Añadir competencia
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'add';
    $POST['titulo'] = 'Competencia test';
    $POST['descripcion'] = 'Competencia para pruebas de test';
	$pruebas->peticionCurlNoTest($POST);

    // Buscar competencia añadida
    $POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'search';
    $POST['titulo'] = 'Competencia test';
    $competence = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode( $competence ), true);
    $idCompetence = $arr['resource'][0]['id_competencia'];

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	// Añadir permisos
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '1';
    $POST['id_accion'] = '4';
    $POST['id_funcionalidad'] = '11';
    $POST['checked'] = 'true';
    $pruebas->peticionCurlNoTest($POST);

	//USUARIO_NO_ES_PROFESOR_O_ALUMNO
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'search';
    $POST['titulo'] = 'abcde';

	$prueba = 'El usuario en sesión no es un profesor o un alumno.';
	$codeEsperado = 'USUARIO_NO_ES_PROFESOR_O_ALUMNO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	// Quitar permisos a alumno
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '1';
    $POST['id_accion'] = '4';
    $POST['id_funcionalidad'] = '11';
    $POST['checked'] = 'false';
    $pruebas->peticionCurlNoTest($POST);

	//PERMISOS_KO
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'search';
    $POST['titulo'] = 'abcde';

	$prueba = 'El usuario no tiene permisos para realizar la acción.';
	$codeEsperado = 'PERMISOS_KO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	//RECORDSET_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'search';
    $POST['titulo'] = 'abcde';

	$prueba = 'No se han encontrado los datos buscados.';
	$codeEsperado = 'RECORDSET_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	//RECORDSET_DATOS
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'search';
    $POST['titulo'] = 'Competencia test';
    $POST['descripcion'] = '';
    $POST['id_materia'] = '';
    $POST['id_trabajo'] = '';

	$prueba = 'Buscar por título.';
	$codeEsperado = 'RECORDSET_DATOS';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//RECORDSET_DATOS
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'search';
    $POST['descripcion'] = 'Competencia para pruebas de test';

	$prueba = 'Buscar por descripcion.';
	$codeEsperado = 'RECORDSET_DATOS';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	// Eliminar competencia
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'delete';
    $POST['id_competencia'] = $idCompetence;
    $pruebas->peticionCurlNoTest($POST);

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;
}
?>