<?php

function pruebaREST_Materias_Borrar_Acciones(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Acción';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

//---------------------------------------------------------------------------------------------------------------------

    //MATERIA_NO_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'delete';
    $POST['id_materia'] = '7';

    $prueba = 'La materia no existe.';
    $codeEsperado = 'MATERIA_NO_EXISTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '14488423X';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //ACCION_DENEGADA_ELIMINAR_MATERIA
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'delete';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario que ha intentado eliminar la materia no es un administrador.';
    $codeEsperado = 'ACCION_DENEGADA_ELIMINAR_MATERIA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '22693548T';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //PERMISOS_KO
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'delete';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario no tiene permisos para realizar la acción.';
    $codeEsperado = 'PERMISOS_KO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '12345678Z';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //Añadir una materia
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['dni'] = '14488423X';
    $POST['nombre_materia'] = 'Sistemas Dixitais II';
    $POST['creditos'] = '60';

    $pruebas->peticionCurlNoTest($POST);

    //Buscar materia añadida
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'search';
    $POST['dni'] = '14488423X';
    $POST['nombre_materia'] = 'Sistemas Dixitais II';
    $POST['creditos'] = '60';

    $materia = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $materia ) , true);

    //ELIMINAR_MATERIA_OK
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'delete';
    $POST['id_materia'] = $arr["resource"][0]["id_materia"];

    $prueba = 'Materia eliminada correctamente.';
    $codeEsperado = 'ELIMINAR_MATERIA_OK';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>