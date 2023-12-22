<?php

function pruebaREST_CursoAcademico_Buscar_Acciones(){

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
												//ERRORES_ATRIBUTO
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//login correcto admin
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // RECORDSET_DATOS
	$POST = $vaciarPost;
	$POST['controller'] = 'academicCourse';
	$POST['action'] = 'search';
	$POST['nombre_curso_academico'] = '22/23';

	$prueba = 'El curso académico se busca correctamente.';
	$codeEsperado = 'RECORDSET_DATOS';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // RECORDSET_DATOS
	$POST = $vaciarPost;
	$POST['controller'] = 'academicCourse';
	$POST['action'] = 'search';
	$POST['nombre_curso_academico'] = '';

	$prueba = 'Todos los cursos académicos.';
	$codeEsperado = 'RECORDSET_DATOS';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // RECORDSET_VACIO
	$POST = $vaciarPost;
	$POST['controller'] = 'academicCourse';
	$POST['action'] = 'search';
	$POST['nombre_curso_academico'] = 'Nuevo';

	$prueba = 'El curso académico no existe.';
	$codeEsperado = 'RECORDSET_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // Eliminar permisos a usuario para buscar
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'delete';
    $POST['id_rol'] = '3';
    $POST['id_accion'] = '4';
    $POST['id_funcionalidad'] = '10';
    $pruebas->peticionCurlNoTest($POST);

    //login correcto profesor
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '22693548T';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // PERMISOS_KO
	$POST = $vaciarPost;
	$POST['controller'] = 'academicCourse';
	$POST['action'] = 'search';
	$POST['nombre_curso_academico'] = 'Nuevo curso académico';

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


    // Añadir permisos a usuario para buscar
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '3';
    $POST['id_accion'] = '4';
    $POST['id_funcionalidad'] = '10';
    $pruebas->peticionCurlNoTest($POST);

    $pruebas->desconectarCurl($pruebas->cliente);

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>