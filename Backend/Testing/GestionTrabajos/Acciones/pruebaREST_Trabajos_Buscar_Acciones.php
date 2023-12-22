<?php

function pruebaREST_Trabajos_Buscar_Acciones(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Acción';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto con user admin
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    // Pruebas rol admin
    //PERMISOS_KO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';

	$prueba = 'El usuario no tiene permisos.';
	$codeEsperado = 'PERMISOS_KO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto con user alumno sin materias
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '73972612N';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    //USUARIO_NO_ES_ALUMNO_MATERIA
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';

	$prueba = 'El usuario no es alumno de la materia.';
	$codeEsperado = 'USUARIO_NO_ES_ALUMNO_MATERIA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto con user profesor sin materias
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '05109923J';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    //USUARIO_NO_ES_PROFESOR_MATERIA
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';

	$prueba = 'El usuario no es profesor de la materia.';
	$codeEsperado = 'USUARIO_NO_ES_PROFESOR_MATERIA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto con user profesor
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	// Añadir trabajos
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'add';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción trabajo test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '80';
	$POST['id_materia'] = '2';
	$POST['fecha_ini'] = '2023-05-05';
	$POST['fecha_fin'] = '2023-07-05';
    $pruebas->peticionCurlNoTest($POST);

    // RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';

    $prueba = 'Búsqueda con user profesor sin datos.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';
    $POST['nombre_trabajo'] = 'Trabajo';

    $prueba = 'Búsqueda con user profesor por nombre trabajo.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';
    $POST['porcentaje_nota'] = '20';

    $prueba = 'Búsqueda con user profesor por porcentaje de nota.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';
    $POST['id_materia'] = '2';

    $prueba = 'Búsqueda con user profesor por materia.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // RECORDSET_VACIO
    $POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';
    $POST['id_materia'] = '1112';

    $prueba = 'Búsqueda con user profesor con datos que no existen.';
    $codeEsperado = 'RECORDSET_VACIO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto con user alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '22693548T';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	// Añadir alumno
	$POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'add';
	$POST['dni'] = '22693548T';
	$POST['id_materia'] = '2';
    $pruebas->peticionCurlNoTest($POST);

    //login correcto con user profesor
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '14488423X';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    // Añadir alumno
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'edit';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '2';
    $POST['aceptado'] = '1';
    $pruebas->peticionCurlNoTest($POST);

	//login correcto con user alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '22693548T';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';

    $prueba = 'Búsqueda con user alumno sin datos.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';
    $POST['nombre_trabajo'] = 'Trabajo';

    $prueba = 'Búsqueda con user alumno por nombre trabajo.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';
    $POST['porcentaje_nota'] = '20';

    $prueba = 'Búsqueda con user alumno por porcentaje de nota.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';
    $POST['id_materia'] = '2';

    $prueba = 'Búsqueda con user alumno por materia.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // RECORDSET_VACIO
    $POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';
    $POST['id_materia'] = '1112';

    $prueba = 'Búsqueda con user alumno con datos que no existen.';
    $codeEsperado = 'RECORDSET_VACIO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    // Eliminar datos
	//login correcto con user profesor
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

 	$POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'edit';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '2';
    $POST['aceptado'] = '0';
    $pruebas->peticionCurlNoTest($POST);

	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';
    $POST['nombre_trabajo'] = 'Trabajo test';
    $trabajo = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $trabajo ) , true);
    $idTrabajo = $arr['resource'][0]['id_trabajo'];

	// Eliminar trabajos
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'delete';
	$POST['id_trabajo'] = $idTrabajo;
    $pruebas->peticionCurlNoTest($POST);

 	//login correcto con user alumno
 	$POST = $vaciarPost;
 	$POST['controller'] = 'auth';
 	$POST['action'] = 'login';
 	$POST['dni'] = '22693548T';
 	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

 	$pruebas->peticionLogin($POST);

 	// Eliminar alumno
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'delete';
    $POST['dni'] = '22693548T';
    $POST['id_materia'] = '2';
    $pruebas->peticionCurlNoTest($POST);

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;
}
?>
