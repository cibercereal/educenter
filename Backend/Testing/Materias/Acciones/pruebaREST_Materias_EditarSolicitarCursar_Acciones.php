<?php

function pruebaREST_Materias_EditarSolicitarCursar_Acciones(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Acción';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto con user profesor
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

//---------------------------------------------------------------------------------------------------------------------

    //MATERIA_NO_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'edit';
    $POST['aceptado'] = '0';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '32';

    $prueba = 'La materia no existe.';
    $codeEsperado = 'MATERIA_NO_EXISTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto con user admin
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

	// Dar permisos a administrador para editar
	$POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '1';
    $POST['id_accion'] = '3';
    $POST['id_funcionalidad'] = '9';
    $POST['checked'] = 'true';
    $pruebas->peticionCurlNoTest($POST);

    //ACCION_DENEGADA_RESOLVER_SOLICITAR_MATERIA
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'edit';
    $POST['aceptado'] = '0';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario en sesión no es un profesor.';
    $codeEsperado = 'ACCION_DENEGADA_RESOLVER_SOLICITAR_MATERIA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    // Eliminar permisos a administrador para editar
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '1';
    $POST['id_accion'] = '3';
    $POST['id_funcionalidad'] = '9';
    $POST['checked'] = 'false';
    $pruebas->peticionCurlNoTest($POST);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto con user admin
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '12345678Z';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //PERMISOS_KO
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'edit';
    $POST['aceptado'] = '0';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario no tiene permisos para realizar la acción.';
    $codeEsperado = 'PERMISOS_KO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto con usuario docente
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '05109923J';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //USUARIO_NO_EN_SESION
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'edit';
    $POST['aceptado'] = '1';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario en sesión no es el profesor de la materia.';
    $codeEsperado = 'USUARIO_NO_EN_SESION';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto con user alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	// Añadir materia_solicitud
	$POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'add';
    $POST['id_materia'] = '2';
    $POST['dni'] = '14488423X';
    $pruebas->peticionCurlNoTest($POST);

    //login correcto con usuario docente
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '14488423X';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //EDITAR_USUARIO_MATERIA_OK
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'edit';
    $POST['dni'] = '22693548T';
    $POST['aceptado'] = '1';
    $POST['id_materia'] = '2';

    $prueba = 'Solicitud usuario modificada correctamente.';
    $codeEsperado = 'EDITAR_USUARIO_MATERIA_OK';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>