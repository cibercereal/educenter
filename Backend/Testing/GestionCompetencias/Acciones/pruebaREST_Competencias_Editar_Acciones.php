<?php

function pruebaREST_Competencias_Editar_Acciones(){

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

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//COMPETENCIA_NO_EXISTE
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'edit';
 	$POST['id_competencia'] = '1111';
    $POST['titulo'] = 'Competencia test';
    $POST['descripcion'] = 'Competencia para test';
    $POST['id_materia'] = '5';

	$prueba = 'Competencia no existe.';
	$codeEsperado = 'COMPETENCIA_NO_EXISTE';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // Buscar competencia añadida
    $POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'search';
    $POST['titulo'] = 'Competencia test';
    $competence = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode( $competence ), true);
    $idCompetence = $arr['resource'][0]['id_competencia'];

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
    $POST['id_rol'] = '3';
    $POST['id_accion'] = '3';
    $POST['id_funcionalidad'] = '11';
    $POST['checked'] = 'true';
    $pruebas->peticionCurlNoTest($POST);

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '73972612N';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	//USUARIO_NO_ES_ADMINISTRADOR_O_PROFESOR
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'edit';
 	$POST['id_competencia'] = $idCompetence;
    $POST['titulo'] = 'Competencia test';
    $POST['descripcion'] = 'Competencia para test';
    $POST['id_materia'] = '5';

	$prueba = 'El usuario en sesión no es un administrador o un profesor.';
	$codeEsperado = 'USUARIO_NO_ES_ADMINISTRADOR_O_PROFESOR';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto profesor
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	//MATERIA_NO_EXISTE
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'edit';
 	$POST['id_competencia'] = $idCompetence;
    $POST['titulo'] = 'Competencia test';
    $POST['descripcion'] = 'Competencia para test';
    $POST['id_materia'] = '11111';

	$prueba = 'La materia no existe.';
	$codeEsperado = 'MATERIA_NO_EXISTE';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//COMPETENCIA_MODIFICADO_OK
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'edit';
 	$POST['id_competencia'] = $idCompetence;
    $POST['titulo'] = 'Competencia test';
    $POST['descripcion'] = 'Competencia para test';
    $POST['id_materia'] = '1';

	$prueba = 'Competencia modificada correctamente.';
	$codeEsperado = 'EDITAR_COMPETENCIA_OK';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // Eliminar trabajo
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'delete';
	$POST['id_competencia'] = $idCompetence;
	$pruebas->peticionCurlNoTest($POST);

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	// Quitar permisos a admin
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '3';
    $POST['id_accion'] = '3';
    $POST['id_funcionalidad'] = '11';
    $POST['checked'] = 'false';
    $pruebas->peticionCurlNoTest($POST);

	//login correcto alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '73972612N';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	//PERMISOS_KO
	$POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'add';
    $POST['titulo'] = 'Competencia test';
    $POST['descripcion'] = 'Competencia para pruebas de test';

	$prueba = 'El usuario no tiene permisos para realizar la acción.';
	$codeEsperado = 'PERMISOS_KO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;
}
?>