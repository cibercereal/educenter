<?php
function pruebaREST_Materias_Insertar_Atributos() {
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

    //NOMBRE_VACIO
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = '';
    $POST['dni'] = '14488423X';
    $POST['creditos'] = 20;

    $test = 'El nombre no puede estar vací0.';
    $expectedCode = 'NOMBRE_VACIO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // NOMBRE_MENOR_QUE_3
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'ab';
    $POST['dni'] = '14488423X';
    $POST['creditos'] = 20;

    $test = 'El nombre no puede ser menor que 3.';
    $expectedCode = 'NOMBRE_MENOR_QUE_3';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // NOMBRE_MAYOR_QUE_200
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?';
    $POST['dni'] = '14488423X';
    $POST['creditos'] = 20;

    $test = 'El nombre no puede ser mayor que 200.';
    $expectedCode = 'NOMBRE_MAYOR_QUE_200';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // CREDITOS_VACIO
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sistemas Inteligentes';
    $POST['dni'] = '14488423X';
    $POST['creditos'] = '';

    $test = 'Los créditos no pueden estar vacíos.';
    $expectedCode = 'CREDITOS_VACIO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // CREDITOS_MAYOR_QUE_4
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sistemas Inteligentes';
    $POST['dni'] = '14488423X';
    $POST['creditos'] = 44444;

    $test = 'Los créditos no pueden ser mayor que 4.';
    $expectedCode = 'CREDITOS_MAYOR_QUE_4';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // CREDITOS_MAYOR_QUE_4
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sistemas Inteligentes';
    $POST['dni'] = '14488423X';
    $POST['creditos'] = 44444;

    $test = 'Los créditos no pueden ser mayor que 4.';
    $expectedCode = 'CREDITOS_MAYOR_QUE_4';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // DNI_MENOR_QUE_9
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sistemas Inteligentes';
    $POST['dni'] = '14488423';
    $POST['creditos'] = 20;

    $test = 'El dni no puede ser menor que 9.';
    $expectedCode = 'DNI_MENOR_QUE_9';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // DNI_MAYOR_QUE_9
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sistemas Inteligentes';
    $POST['dni'] = '14488423XZ';
    $POST['creditos'] = 20;

    $test = 'El dni no puede ser mayor que 9.';
    $expectedCode = 'DNI_MAYOR_QUE_9';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // DNI_FORMATO_INCORRECTO
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sistemas Inteligentes';
    $POST['dni'] = 'abcdefghi';
    $POST['creditos'] = 20;

    $test = 'El formato del dni no es correcto.';
    $expectedCode = 'DNI_FORMATO_INCORRECTO';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------

    // DNI_LETRA_INCORRECTA
    $POST = $emptyPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sistemas Inteligentes';
    $POST['dni'] = '14488423Z';
    $POST['creditos'] = 20;

    $test = 'La letra del dni no es correcta.';
    $expectedCode = 'DNI_LETRA_INCORRECTA';
    $tests->hacerPrueba($POST, $POST['controller'], $POST['action'], $type, $test, $expectedCode);

    //---------------------------------------------------------------------------------------------------------------------


    $tests->desconectarCurl($tests->cliente);

    return $tests->resultadoTest;
}
?>