<?php
function pruebaREST_Materias_EliminarSolicitarImpartir_Acciones() {
    include_once './Testing/pruebaREST_class.php';

    $pruebas = new testRest();

    $tipo = 'Atributo';
    $vaciarPost = NULL;

    //---------------------------------------------------------------------------------------------------------------------

	//login correcto con user profesor
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	$POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'add';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '1';
    $pruebas->peticionCurlNoTest($POST);

    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO Materias
    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    //MATERIA_NO_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'delete';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '120';

    $prueba = 'La materia no existe.';
    $codeEsperado = 'MATERIA_NO_EXISTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //ACCION_DENEGADA_BORRAR_SOLICITAR_MATERIA
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'delete';
    $POST['dni'] = '12345678Z';
    $POST['id_materia'] = '1';

    $prueba = 'El usuario no es un profesor.';
    $codeEsperado = 'ACCION_DENEGADA_BORRAR_SOLICITAR_MATERIA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //BORRAR_ASIGNACION_OK
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'delete';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '1';

    $prueba = 'La materia ha sido solicitada correctamente.';
    $codeEsperado = 'BORRAR_ASIGNACION_OK';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    //MATERIA_NO_SOLICITADA
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'delete';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '1';

    $prueba = 'La materia no ha sido solicitada por el profesor.';
    $codeEsperado = 'MATERIA_NO_SOLICITADA';
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
    $POST['controller'] = 'subjectAssignment';
    $POST['action'] = 'delete';
    $POST['dni'] = '12345678Z';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario no tiene permisos para realizar la acción.';
    $codeEsperado = 'PERMISOS_KO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    //---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;
}
?>