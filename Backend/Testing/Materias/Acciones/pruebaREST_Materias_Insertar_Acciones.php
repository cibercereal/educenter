<?php

function pruebaREST_Materias_Insertar_Acciones(){

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

    //ANADIR_MATERIA_OK
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['dni'] = '14488423X';
    $POST['nombre_materia'] = 'Sistemas Dixitais';
    $POST['creditos'] = '20';

    $prueba = 'Materia insertada con éxito.';
    $codeEsperado = 'ANADIR_MATERIA_OK';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //ANADIR_MATERIA_OK_SIN_PROFESOR
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sistemas Operativos I';
    $POST['creditos'] = '20';

    $prueba = 'Materia insertada con éxito sin introducir profesor.';
    $codeEsperado = 'ANADIR_MATERIA_OK';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //MATERIA_YA_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sistemas Operativos I';
    $POST['creditos'] = '20';

    $prueba = 'La materia ya existe.';
    $codeEsperado = 'MATERIA_YA_EXISTE';
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
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sistemas Operativos II';
    $POST['creditos'] = '20';
    $POST['dni'] = '12345678Z';

    $prueba = 'El usuario no tiene permisos para realizar la acción.';
    $codeEsperado = 'PERMISOS_KO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '14488423X';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //ACCION_DENEGADA_INSERTAR_MATERIA
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sistemas Operativos II';
    $POST['creditos'] = '20';

    $prueba = 'La materia solo puede ser insertada por un usuario administrador.';
    $codeEsperado = 'ACCION_DENEGADA_INSERTAR_MATERIA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '12345678Z';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //USUARIO_NO_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sistemas Operativos II';
    $POST['creditos'] = '20';
    $POST['dni'] = '11111111H';

    $prueba = 'El profesor no existe.';
    $codeEsperado = 'USUARIO_NO_EXISTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //USUARIO_NO_ES_PROFESOR
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'add';
    $POST['nombre_materia'] = 'Sistemas Operativos II';
    $POST['creditos'] = '20';
    $POST['dni'] = '12345678Z';

    $prueba = 'El usuario a impartir la materia no es un profesor.';
    $codeEsperado = 'USUARIO_NO_ES_PROFESOR';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // Eliminamos los datos añadidos.
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '12345678Z';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'search';

    $materias = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $materias ) , true);
    foreach ($arr["resource"] as $materia) {
        if ($materia["id_materia"] != 1 && $materia['id_materia'] != 2) {
            $POST = $vaciarPost;
            $POST['controller'] = 'subject';
            $POST['action'] = 'delete';
            $POST['id_materia'] = $materia["id_materia"];

            $pruebas->peticionCurlNoTest($POST);
        }
    }

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>