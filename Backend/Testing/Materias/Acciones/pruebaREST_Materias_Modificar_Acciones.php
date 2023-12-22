<?php

function pruebaREST_Materias_Modificar_Acciones(){

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

    //MATERIA_YA_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'edit';
    $POST['nombre_materia'] = 'Bases de datos';
    $POST['creditos'] = '20';
    $POST['dni'] = '12345678Z';
    $POST['id_materia'] = '3';

    $prueba = 'La materia ya existe.';
    $codeEsperado = 'MATERIA_YA_EXISTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //USUARIO_NO_ES_PROFESOR
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'edit';
    $POST['nombre_materia'] = 'Bases de datos';
    $POST['creditos'] = '20';
    $POST['dni'] = '12345678Z';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario a impartir la materia no es un profesor.';
    $codeEsperado = 'USUARIO_NO_ES_PROFESOR';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //USUARIO_NO_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'edit';
    $POST['nombre_materia'] = 'Bases de datos';
    $POST['creditos'] = '20';
    $POST['dni'] = '11111111H';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario no existe.';
    $codeEsperado = 'USUARIO_NO_EXISTE';
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
    $POST['action'] = 'edit';
    $POST['nombre_materia'] = 'Bases de datos';
    $POST['creditos'] = '20';
    $POST['dni'] = '11111111H';
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

    // dar permisos
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '2';
    $POST['id_accion'] = '3';
    $POST['id_funcionalidad'] = '7';
    $POST['checked'] = 'true';

    $pruebas->peticionCurlNoTest($POST);

    //login correcto
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '14488423X';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //ACCION_DENEGADA_EDITAR_MATERIA
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'edit';
    $POST['nombre_materia'] = 'Bases de datos';
    $POST['creditos'] = '20';
    $POST['dni'] = '11111111H';
    $POST['id_materia'] = '2';

    $prueba = 'El usuario no tiene permisos para modificar la materia.';
    $codeEsperado = 'ACCION_DENEGADA_EDITAR_MATERIA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '12345678Z';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //EDITAR_MATERIA_OK
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'edit';
    $POST['nombre_materia'] = 'Bases de datos';
    $POST['creditos'] = '20';
    $POST['dni'] = '14488423X';
    $POST['id_materia'] = '2';

    $prueba = 'Materia modificada correctamente.';
    $codeEsperado = 'EDITAR_MATERIA_OK';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '12345678Z';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';
    $pruebas->peticionLogin($POST);

    //borrado permisos
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '2';
    $POST['id_accion'] = '3';
    $POST['id_funcionalidad'] = '7';
    $POST['checked'] = 'false';

    $pruebas->peticionCurlNoTest($POST);

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>