<?php

function pruebaREST_Materias_Buscar_Acciones(){

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

    //RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'search';

    $prueba = 'Buscar materias sin criterios de búsqueda.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'search';
    $POST['creditos'] = '20';

    $prueba = 'Buscar materias por número de créditos.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'search';
    $POST['nombre_materia'] = 'Int';

    $prueba = 'Buscar materias por nombre de materia.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'subject';
    $POST['action'] = 'search';
    $POST['dni'] = '14488423X';

    $prueba = 'Buscar materias por dni de profesor.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//RECORDSET_VACIO
	$POST = $vaciarPost;
	$POST['controller'] = 'subject';
	$POST['action'] = 'search';
    $POST['dni'] = '11111111H';

	$prueba = 'Buscar materias que no existen.';
	$codeEsperado = 'RECORDSET_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // Eliminar permisos a usuario para buscar
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'delete';
    $POST['id_rol'] = '3';
    $POST['id_accion'] = '4';
    $POST['id_funcionalidad'] = '7';
    $pruebas->peticionCurlNoTest($POST);

    //login correcto
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '73972612N';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

	//PERMISOS_KO
	$POST = $vaciarPost;
	$POST['controller'] = 'subject';
	$POST['action'] = 'search';
    $POST['dni'] = '11111111H';

	$prueba = 'Buscar sin permisos.';
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
    $POST['id_funcionalidad'] = '7';
    $pruebas->peticionCurlNoTest($POST);

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>