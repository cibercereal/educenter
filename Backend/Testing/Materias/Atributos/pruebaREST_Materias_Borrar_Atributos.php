<?php
function pruebaREST_Materias_Borrar_Atributos() {
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
    $POST['action'] = 'delete';
    $POST['id_materia'] = '';

    $test = 'El id de la materia no puede estar vacío.';
    $expectedCode = 'ID_MATERIA_VACIO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    //ID_MATERIA_ERROR_FORMATO
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'delete';
    $POST['id_materia'] = 'abc';

    $test = 'El id de la materia no tiene un formato correcto.';
    $expectedCode = 'ID_MATERIA_ERROR_FORMATO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    $tests->desconectarCurl($tests->cliente);

    return $tests->resultadoTest;
}
?>