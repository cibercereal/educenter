<?php
function pruebaREST_Materias_AceptarSolicitarImpartirSecundario_Atributos() {
    include_once './Testing/pruebaREST_class.php';

    $pruebas = new testRest();

    $tipo = 'Atributo';
    $vaciarPost = NULL;

    //---------------------------------------------------------------------------------------------------------------------

	//login correcto con user alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);


    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO Materias
    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    //ID_MATERIA_VACIO
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '';

    $prueba = 'La materia no puede ir vacía.';
    $codeEsperado = 'ID_MATERIA_VACIO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //ID_MATERIA_ERROR_FORMATO
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = 'abc';

    $prueba = 'El formato de la materia no es correcto.';
    $codeEsperado = 'ID_MATERIA_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //DNI_VACIO
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '';
    $POST['id_materia'] = '1';

    $prueba = 'El dni del alumno no puede ser vacío.';
    $codeEsperado = 'DNI_VACIO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //DNI_MENOR_QUE_9
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '123456';
    $POST['id_materia'] = '1';

    $prueba = 'El tamaño del dni no puede ser menor que 9.';
    $codeEsperado = 'DNI_MENOR_QUE_9';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //DNI_MAYOR_QUE_9
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '1234567890';
    $POST['id_materia'] = '1';

    $prueba = 'El tamaño del dni no puede ser mayor que 9.';
    $codeEsperado = 'DNI_MAYOR_QUE_9';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //DNI_FORMATO_INCORRECTO
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = 'abcdefghi';
    $POST['id_materia'] = '1';

    $prueba = 'El formato del dni no es el correcto.';
    $codeEsperado = 'DNI_FORMATO_INCORRECTO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);


    //---------------------------------------------------------------------------------------------------------------------

    //DNI_LETRA_INCORRECTA
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '12345678V';
    $POST['id_materia'] = '1';

    $prueba = 'La letra del dni no es correcta.';
    $codeEsperado = 'DNI_LETRA_INCORRECTA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //SECUNDARIO_VACIO
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '1';
    $POST['secundario'] = '';

    $prueba = 'La indicación de secundario no puede ser vacío.';
    $codeEsperado = 'SECUNDARIO_VACIO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //SECUNDARIO_MAYOR_QUE_1
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '1';
    $POST['secundario'] = '12';

    $prueba = 'La indicación de secundario no puede ser mayor que 1.';
    $codeEsperado = 'SECUNDARIO_MAYOR_QUE_1';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //SECUNDARIO_ERROR_FORMATO
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '1';
    $POST['secundario'] = 'n';

    $prueba = 'La indicación de secundario tiene un formato erróneo.';
    $codeEsperado = 'SECUNDARIO_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //SECUNDARIO_ERROR_FORMATO
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'edit';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '1';
    $POST['secundario'] = '2';

    $prueba = 'La indicación de secundario tiene un formato erróneo.';
    $codeEsperado = 'SECUNDARIO_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;
}
?>