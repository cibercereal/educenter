<?php
function pruebaREST_Materias_BuscarSolicitarCursar_Acciones() {
    include_once './Testing/pruebaREST_class.php';

    $tests = new testRest();

    $type = 'Atributo';
    $emptyPost = NULL;

    //---------------------------------------------------------------------------------------------------------------------

	//login correcto con user alumno
	$POST = $emptyPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '22693548T';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$tests->peticionLogin($POST);

	// Insertar materia_alumno
    $POST = $emptyPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'add';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '1';
    $tests->peticionCurlNoTest($POST);

	//login correcto con user profesor
	$POST = $emptyPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$tests->peticionLogin($POST);

    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO Materias
    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    //RECORDSET_DATOS
    $POST = $emptyPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'search';

    $test = 'Búsqueda sin parámetros correcta como profesor.';
    $expectedCode = 'RECORDSET_DATOS';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_DATOS
    $POST = $emptyPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'search';
    $POST['dni'] = '22693548T';

    $test = 'Búsqueda por dni correcta como profesor.';
    $expectedCode = 'RECORDSET_DATOS';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_DATOS
    $POST = $emptyPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'search';
    $POST['id_materia'] = '1';

    $test = 'Búsqueda por materia correcta como profesor.';
    $expectedCode = 'RECORDSET_DATOS';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_VACIO
    $POST = $emptyPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'search';
    $POST['id_materia'] = '4';

    $test = 'Búsqueda por parámetros no existentes correcta como profesor.';
    $expectedCode = 'RECORDSET_VACIO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //login correcto con user alumno
    $POST = $emptyPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '22693548T';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $tests->peticionLogin($POST);

    //RECORDSET_DATOS
    $POST = $emptyPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'search';

    $test = 'Búsqueda sin parámetros correcta como alumno.';
    $expectedCode = 'RECORDSET_DATOS';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_DATOS
    $POST = $emptyPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'search';
    $POST['dni'] = '22693548T';

    $test = 'Búsqueda por dni correcta como alumno.';
    $expectedCode = 'RECORDSET_DATOS';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_DATOS
    $POST = $emptyPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'search';
    $POST['id_materia'] = '1';

    $test = 'Búsqueda por materia correcta como alumno.';
    $expectedCode = 'RECORDSET_DATOS';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_VACIO
    $POST = $emptyPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'search';
    $POST['id_materia'] = '4';

    $test = 'Búsqueda por parámetros no existentes correcta como alumno.';
    $expectedCode = 'RECORDSET_VACIO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // Eliminar materia_alumno
    $POST = $emptyPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'delete';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '1';
    $tests->peticionCurlNoTest($POST);

    $tests->desconectarCurl($tests->cliente);

    return $tests->resultadoTest;
}
?>