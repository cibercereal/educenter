<?php
function pruebaREST_Materias_InsertarSolicitarCursar_Acciones() {
    include_once './Testing/pruebaREST_class.php';

    $pruebas = new testRest();

    $tipo = 'Atributo';
    $vaciarPost = NULL;

    //---------------------------------------------------------------------------------------------------------------------

	//login correcto con user alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '22693548T';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);


    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO Materias
    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    //MATERIA_NO_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'add';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '120';

    $prueba = 'La materia no existe.';
    $codeEsperado = 'MATERIA_NO_EXISTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //ACCION_DENEGADA_SOLICITAR_MATERIA
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'add';
    $POST['dni'] = '05109923J';
    $POST['id_materia'] = '1';

    $prueba = 'El usuario no es un alumno.';
    $codeEsperado = 'ACCION_DENEGADA_SOLICITAR_MATERIA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

	//login correcto con user alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '73972612N';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    //USUARIO_NO_EN_SESION
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'add';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario que ha realizado la solicitud no es el usuario en sesión.';
    $codeEsperado = 'USUARIO_NO_EN_SESION';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

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
    $POST['action'] = 'add';
    $POST['dni'] = '12345678Z';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario no tiene permisos para realizar la acción.';
    $codeEsperado = 'PERMISOS_KO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //login correcto con user alumno
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '22693548T';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //ANADIR_USUARIO_MATERIA_OK
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'add';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '1';

    $prueba = 'El usuario ha hecho la solicitud correctamente.';
    $codeEsperado = 'ANADIR_USUARIO_MATERIA_OK';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //MATERIA_YA_SOLICITADA
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'add';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '1';

    $prueba = 'La materia ya ha sido solicitada por el alumno.';
    $codeEsperado = 'MATERIA_YA_SOLICITADA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //login correcto con user alumno
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '22693548T';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //borrado solitud
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'delete';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '1';
    $pruebas->peticionCurlNoTest($POST);

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;
}
?>