<?php

function pruebaREST_Materias_AceptarSolicitarImpartir_Acciones(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Acción';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

//---------------------------------------------------------------------------------------------------------------------

    //MATERIA_NO_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'assignTeacher';
    $POST['dni'] = '12345678Z';
    $POST['id_materia'] = '1223';

    $prueba = 'La materia no existe.';
    $codeEsperado = 'MATERIA_NO_EXISTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //USUARIO_NO_ES_PROFESOR
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'assignTeacher';
    $POST['dni'] = '12345678Z';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario a impartir la materia no es un profesor.';
    $codeEsperado = 'USUARIO_NO_ES_PROFESOR';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //USUARIO_NO_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'assignTeacher';
    $POST['dni'] = '11111111H';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario no existe.';
    $codeEsperado = 'USUARIO_NO_EXISTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto como alumno
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '22693548T';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //PERMISOS_KO
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'assignTeacher';
    $POST['dni'] = '11111111H';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario no tiene permisos para realizar la acción.';
    $codeEsperado = 'PERMISOS_KO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto profesor
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '14488423X';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //ACCION_DENEGADA_ASIGNAR_MATERIA
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'assignTeacher';
    $POST['dni'] = '11111111H';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario no tiene permisos para asignar la materia.';
    $codeEsperado = 'ACCION_DENEGADA_ASIGNAR_MATERIA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '12345678Z';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //ASIGNAR_PROFESOR_OK
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'assignTeacher';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '2';

    $prueba = 'Profesor asignado correctamente.';
    $codeEsperado = 'ASIGNAR_PROFESOR_OK';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>