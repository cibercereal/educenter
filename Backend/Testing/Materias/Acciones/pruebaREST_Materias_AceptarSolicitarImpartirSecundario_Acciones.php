<?php
function pruebaREST_Materias_AceptarSolicitarImpartirSecundario_Acciones() {
    include_once './Testing/pruebaREST_class.php';

    $pruebas = new testRest();

    $tipo = 'Atributo';
    $vaciarPost = NULL;

    //---------------------------------------------------------------------------------------------------------------------

	//login correcto con user profesor
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '05109923J';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);


    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO Materias
    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    //MATERIA_NO_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '05109923J';
    $POST['id_materia'] = '1111';
    $POST['secundario'] = '1';

    $prueba = 'La materia no existe.';
    $codeEsperado = 'MATERIA_NO_EXISTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //ACCION_DENEGADA_EDITAR_MATERIA
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '73972612N';
    $POST['id_materia'] = '1';
    $POST['secundario'] = '1';

    $prueba = 'El usuario no es un profesor.';
    $codeEsperado = 'ACCION_DENEGADA_EDITAR_MATERIA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

	//login correcto con user profesor
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    //MATERIA_NO_SOLICITADA
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '1';
    $POST['secundario'] = '1';

    $prueba = 'El usuario no ha realizado la solicitud.';
    $codeEsperado = 'MATERIA_NO_SOLICITADA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------
   
   	//login correcto con user profesor
   	$POST = $vaciarPost;
   	$POST['controller'] = 'auth';
   	$POST['action'] = 'login';
   	$POST['dni'] = '14488423X';
   	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

   	$pruebas->peticionLogin($POST);
   	
    //Realizar solicitud
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'add';
    $POST['id_materia'] = '1';
    $POST['dni'] = '14488423X';

    $pruebas->peticionCurlNoTest($POST);
    
   	//login correcto con user profesor
   	$POST = $vaciarPost;
   	$POST['controller'] = 'auth';
   	$POST['action'] = 'login';
   	$POST['dni'] = '14488423X';
   	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

   	$pruebas->peticionLogin($POST);

    //MATERIA_NO_ASIGNADA
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '1';
    $POST['secundario'] = '1';

    $prueba = 'La materia no tiene profesor ppal.';
    $codeEsperado = 'MATERIA_NO_ASIGNADA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //login correcto con user alumno
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '73972612N';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //PERMISOS_KO
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '05109923J';
    $POST['id_materia'] = '1';
    $POST['secundario'] = '1';

    $prueba = 'El usuario en sesión no tiene permisos.';
    $codeEsperado = 'PERMISOS_KO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

   	//login correcto con user profesor
   	$POST = $vaciarPost;
   	$POST['controller'] = 'auth';
   	$POST['action'] = 'login';
   	$POST['dni'] = '05109923J';
   	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

   	$pruebas->peticionLogin($POST);

    //Añadir solicitud
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'add';
    $POST['id_materia'] = '2';
    $POST['dni'] = '05109923J';
    $pruebas->peticionCurlNoTest($POST);

    //login correcto con user profesor
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '14488423X';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //EDITAR_ASIGNACION_OK
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '05109923J';
    $POST['id_materia'] = '2';
    $POST['secundario'] = '1';

    $prueba = 'La asignación se ha realizado correctamente.';
    $codeEsperado = 'EDITAR_ASIGNACION_OK';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

   	//login correcto con user profesor
   	$POST = $vaciarPost;
   	$POST['controller'] = 'auth';
   	$POST['action'] = 'login';
   	$POST['dni'] = '14488423X';
   	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

   	$pruebas->peticionLogin($POST);

    //Eliminar solicitud
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'delete';
    $POST['id_materia'] = '1';
    $POST['dni'] = '14488423X';
    $pruebas->peticionCurlNoTest($POST);

    //Eliminar solicitud
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'delete';
    $POST['id_materia'] = '2';
    $POST['dni'] = '14488423X';
    $pruebas->peticionCurlNoTest($POST);

   	//login correcto con user profesor
   	$POST = $vaciarPost;
   	$POST['controller'] = 'auth';
   	$POST['action'] = 'login';
   	$POST['dni'] = '05109923J';
   	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

   	$pruebas->peticionLogin($POST);

    //Eliminar solicitud
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'delete';
    $POST['id_materia'] = '2';
    $POST['dni'] = '05109923J';
    $pruebas->peticionCurlNoTest($POST);

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;
}
?>