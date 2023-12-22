<?php
function pruebaREST_Materias_AceptarSolicitarImpartir_Atributos() {
    include_once './Testing/pruebaREST_class.php';

    $tests = new testRest();

    $type = 'Atributo';
    $emptyPost = NULL;

    //---------------------------------------------------------------------------------------------------------------------

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

    //ID_MATERIA_VACIO
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'assignTeacher';
    $POST['id_materia'] = '';
    $POST['dni'] = '14488423X';

    $test = 'El id de la materia no puede estar vacío.';
    $expectedCode = 'ID_MATERIA_VACIO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //ID_MATERIA_ERROR_FORMATO
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'assignTeacher';
    $POST['id_materia'] = 'abc';
    $POST['dni'] = '14488423X';

    $test = 'El id de la materia tiene un formato erróneo.';
    $expectedCode = 'ID_MATERIA_ERROR_FORMATO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // DNI_VACIO
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'assignTeacher';
    $POST['id_materia'] = 1;
    $POST['dni'] = '';

    $test = 'El dni no puede estar vacío.';
    $expectedCode = 'DNI_VACIO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // DNI_MENOR_QUE_9
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'assignTeacher';
    $POST['id_materia'] = 1;
    $POST['dni'] = '14488423';

    $test = 'El dni no puede ser menor que 9.';
    $expectedCode = 'DNI_MENOR_QUE_9';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // DNI_MAYOR_QUE_9
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'assignTeacher';
    $POST['id_materia'] = 1;
    $POST['dni'] = '14488423XZ';

    $test = 'El dni no puede ser mayor que 9.';
    $expectedCode = 'DNI_MAYOR_QUE_9';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // DNI_FORMATO_INCORRECTO
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'assignTeacher';
    $POST['id_materia'] = 1;
    $POST['dni'] = 'abcdefghi';

    $test = 'El formato del dni no es correcto.';
    $expectedCode = 'DNI_FORMATO_INCORRECTO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // DNI_LETRA_INCORRECTA
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'assignTeacher';
    $POST['id_materia'] = 1;
    $POST['dni'] = '14488423Z';

    $test = 'La letra del dni no es correcta.';
    $expectedCode = 'DNI_LETRA_INCORRECTA';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------


    $tests->desconectarCurl($tests->cliente);

    return $tests->resultadoTest;
}
?>