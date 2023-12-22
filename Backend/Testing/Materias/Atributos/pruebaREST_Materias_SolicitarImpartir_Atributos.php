<?php
function pruebaREST_Materias_SolicitarImpartir_Atributos() {
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


    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO Materias
    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&


    //---------------------------------------------------------------------------------------------------------------------

    //ID_MATERIA_VACIO
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'add';
    $POST['id_materia'] = '';
    $POST['dni'] = '14488423X';

    $test = 'El id de la materia no puede estar vacío.';
    $expectedCode = 'ID_MATERIA_VACIO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //ID_MATERIA_ERROR_FORMATO
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'add';
    $POST['id_materia'] = 'abc';
    $POST['dni'] = '14488423X';

    $test = 'El id de la materia debe ser numérico.';
    $expectedCode = 'ID_MATERIA_ERROR_FORMATO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //DNI_VACIO
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'add';
    $POST['id_materia'] = '1';
    $POST['dni'] = '';

    $test = 'El dni no puede estar vacío.';
    $expectedCode = 'DNI_VACIO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //DNI_MAYOR_QUE_9
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'add';
    $POST['id_materia'] = '1';
    $POST['dni'] = '111111111111';

    $test = 'El dni no puede ser mayor que 9.';
    $expectedCode = 'DNI_MAYOR_QUE_9';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //DNI_MENOR_QUE_9
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'add';
    $POST['id_materia'] = '1';
    $POST['dni'] = '1111';

    $test = 'El dni no puede ser menor que 9.';
    $expectedCode = 'DNI_MENOR_QUE_9';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //DNI_FORMATO_INCORRECTO
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'add';
    $POST['id_materia'] = '1';
    $POST['dni'] = '111111111';

    $test = 'El dni no tiene un formato correcto.';
    $expectedCode = 'DNI_FORMATO_INCORRECTO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //DNI_LETRA_INCORRECTA
    $POST = $emptyPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'add';
    $POST['id_materia'] = '1';
    $POST['dni'] = '11111111Z';

    $test = 'El dni no tiene una letra correcta.';
    $expectedCode = 'DNI_LETRA_INCORRECTA';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    $tests->desconectarCurl($tests->cliente);

    return $tests->resultadoTest;
}
?>