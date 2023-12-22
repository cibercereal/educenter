<?php
function pruebaREST_Materias_BuscarSolicitarImpartir_Acciones() {
    include_once './Testing/pruebaREST_class.php';

    $tests = new testRest();

    $type = 'Atributo';
    $emptyPost = NULL;

    //---------------------------------------------------------------------------------------------------------------------

	//login correcto con user profesor
	$POST = $emptyPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$tests->peticionLogin($POST);

	// Insertar materia_solicitud
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'add';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '1';
    $tests->peticionCurlNoTest($POST);

	//login correcto con user admin
	$POST = $emptyPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$tests->peticionLogin($POST);

    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO Materias
    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    //RECORDSET_DATOS
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'search';

    $test = 'Búsqueda sin parámetros correcta como admin.';
    $expectedCode = 'RECORDSET_DATOS';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_DATOS
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'search';
    $POST['dni'] = '14488423X';

    $test = 'Búsqueda por dni correcta como admin.';
    $expectedCode = 'RECORDSET_DATOS';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_DATOS
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'search';
    $POST['id_materia'] = '1';

    $test = 'Búsqueda por materia correcta como admin.';
    $expectedCode = 'RECORDSET_DATOS';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_VACIO
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'search';
    $POST['id_materia'] = '4';

    $test = 'Búsqueda por parámetros no existentes correcta como admin.';
    $expectedCode = 'RECORDSET_VACIO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //login correcto con user profesor
    $POST = $emptyPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '14488423X';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $tests->peticionLogin($POST);

    //RECORDSET_DATOS
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'search';

    $test = 'Búsqueda sin parámetros correcta como docente.';
    $expectedCode = 'RECORDSET_DATOS';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_DATOS
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'search';
    $POST['dni'] = '14488423X';

    $test = 'Búsqueda por dni correcta como docente.';
    $expectedCode = 'RECORDSET_DATOS';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_DATOS
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'search';
    $POST['id_materia'] = '1';

    $test = 'Búsqueda por materia correcta como docente.';
    $expectedCode = 'RECORDSET_DATOS';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_VACIO
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'search';
    $POST['id_materia'] = '4';

    $test = 'Búsqueda por parámetros no existentes correcta como docente.';
    $expectedCode = 'RECORDSET_VACIO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // Eliminar materia_solicitud
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'delete';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '1';
    $tests->peticionCurlNoTest($POST);

    $tests->desconectarCurl($tests->cliente);

    return $tests->resultadoTest;
}
?>