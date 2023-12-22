<?php

function pruebaREST_CursoAcademico_Insertar_Acciones(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Atributo';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);


//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO contraseña
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    // dar permisos
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '2';
    $POST['id_accion'] = '1';
    $POST['id_funcionalidad'] = '10';
    $POST['checked'] = 'true';
    $pruebas->peticionCurlNoTest($POST);

    //login correcto profesor
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '05109923J';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';
    $pruebas->peticionLogin($POST);

	$POST = $vaciarPost;
	$POST['controller'] = 'academicCourse';
	$POST['action'] = 'add';
	$POST['nombre_curso_academico'] = 'Nuevo curso académico';

	$prueba = 'El usuario a insertar el curso académico debe ser un administrador.';
	$codeEsperado = 'ACCION_DENEGADA_INSERTAR_CURSO_ACADEMICO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto admin
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // ANADIR_CURSO_ACADEMICO_OK
	$POST = $vaciarPost;
	$POST['controller'] = 'academicCourse';
	$POST['action'] = 'add';
	$POST['nombre_curso_academico'] = 'Nuevo curso académico';

	$prueba = 'El curso académico se inserta correctamente.';
	$codeEsperado = 'ANADIR_CURSO_ACADEMICO_OK';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto admin
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '22693548T';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // PERMISOS_KO
	$POST = $vaciarPost;
	$POST['controller'] = 'academicCourse';
	$POST['action'] = 'add';
	$POST['nombre_curso_academico'] = 'Nuevo curso académico';

	$prueba = 'El usuario no tiene permisos para realizar la acción.';
	$codeEsperado = 'PERMISOS_KO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);


//---------------------------------------------------------------------------------------------------------------------

    //login correcto admin
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);


    // quitar permisos
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '2';
    $POST['id_accion'] = '1';
    $POST['id_funcionalidad'] = '10';
    $POST['checked'] = 'false';
    $pruebas->peticionCurlNoTest($POST);

    $POST = $vaciarPost;
    $POST['controller'] = 'academicCourse';
    $POST['action'] = 'search';
    $POST['nombre_curso_academico'] = 'Nuevo curso académico';
    $curso = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $curso ) , true);

    // eliminar curso académico
    foreach ($arr["resource"] as $cursoAcademico) {
        if ($cursoAcademico["id_curso_academico"] != 1) {
            $POST['controller'] = 'academicCourse';
            $POST['action'] = 'delete';
            $POST['id_curso_academico'] = $cursoAcademico["id_curso_academico"];

            $pruebas->peticionCurlNoTest($POST);
        }
    }

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>