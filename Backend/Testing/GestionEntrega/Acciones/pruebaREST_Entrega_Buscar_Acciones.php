<?php

function pruebaREST_Entrega_Buscar_Acciones(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Acción';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	// Insertar nuevo trabajo
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

    // Buscar trabajo añadido
    $POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';
    $POST['nombre_trabajo'] = 'Trabajo test';
    $trabajo = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $trabajo ) , true);
    $idTrabajo = $arr['resource'][0]['id_trabajo'];

	//login correcto alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '73972612N';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	// Solicitar cursar
	$POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'add';
	$POST['id_materia'] = '2';
	$POST['dni'] = '73972612N';
    $pruebas->peticionCurlNoTest($POST);

 	//login correcto profesor
 	$POST = $vaciarPost;
 	$POST['controller'] = 'auth';
 	$POST['action'] = 'login';
 	$POST['dni'] = '14488423X';
 	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';
 	$pruebas->peticionLogin($POST);

 	// Aceptar en materia
 	$POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'edit';
 	$POST['id_materia'] = '2';
 	$POST['dni'] = '73972612N';
 	$POST['aceptado'] = '1';
    $pruebas->peticionCurlNoTest($POST);

	//login correcto alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '73972612N';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // Añadir entrega
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'add';
    $POST['dni'] = '73972612N';
    $POST['id_trabajo'] = $idTrabajo;
    $POST['datos'] = 'dGV4dG9kZXBydWViYXBhcmF0ZXN0cw';
    $pruebas->peticionCurlNoTest($POST);

    // Buscar entrega añadida
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['dni'] = '73972612N';
    $entrega = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $entrega ) , true);
    $idEntrega = $arr['resource'][0]['id_entrega'];

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    // USUARIO_NO_ES_ALUMNO_MATERIA
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['id_trabajo'] = '1';
    $POST['datos'] = 'dGV4dG9kZXBydWViYXBhcmF0ZXN0cw';

    $prueba = 'El usuario no es un alumno perteneciente a la materia.';
    $codeEsperado = 'USUARIO_NO_ES_ALUMNO_MATERIA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto admin
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '12345678Z';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    // Dar permisos eliminar entrega a admin
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '1';
    $POST['id_accion'] = '4';
    $POST['id_funcionalidad'] = '13';
    $POST['checked'] = 'true';
    $pruebas->peticionCurlNoTest($POST);

    // USUARIO_NO_ES_ALUMNO
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['id_entrega'] = $idEntrega;

    $prueba = 'El usuario no es un alumno ni un profesor.';
    $codeEsperado = 'USUARIO_NO_ES_PROFESOR_O_ALUMNO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    // Quitar permisos eliminar entrega a admin
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '1';
    $POST['id_accion'] = '4';
    $POST['id_funcionalidad'] = '13';
    $POST['checked'] = 'false';
    $pruebas->peticionCurlNoTest($POST);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '73972612N';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['id_trabajo'] = $idTrabajo;

    $prueba = 'Búsqueda sin parámetros.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '73972612N';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // RECORDSET_DATOS
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['id_trabajo'] = $idTrabajo;
    $POST['dni'] = '73972612N';

    $prueba = 'Búsqueda con parámetros.';
    $codeEsperado = 'RECORDSET_DATOS';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);


//---------------------------------------------------------------------------------------------------------------------
    //login correcto profesor
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '05109923J';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    // USUARIO_NO_ES_PROFESOR_MATERIA
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['id_trabajo'] = $idTrabajo;

    $prueba = 'El usuario no es profesor de la materia.';
    $codeEsperado = 'USUARIO_NO_ES_PROFESOR_MATERIA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);


//---------------------------------------------------------------------------------------------------------------------

    //login correcto admin
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '12345678Z';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    // PERMISOS_KO
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['id_entrega'] = $idEntrega;
    $POST['datos'] = 'dGV4dG9kZXBydWViYXBhcmF0ZXN0cw';

    $prueba = 'El usuario no tiene permisos para realizar la acción.';
    $codeEsperado = 'PERMISOS_KO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '73972612N';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // Eliminar entrega
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'delete';
    $POST['id_entrega'] = $idEntrega;
    $pruebas->peticionCurlNoTest($POST);

    //login correcto profesor
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '14488423X';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    // Eliminar trabajo
    $POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'delete';
    $POST['id_trabajo'] = $idTrabajo;
    $pruebas->peticionCurlNoTest($POST);

    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'edit';
    $POST['id_materia'] = '2';
    $POST['dni'] = '73972612N';
    $POST['aceptado'] = '0';
    $pruebas->peticionCurlNoTest($POST);

	//login correcto alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '73972612N';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // Eliminar solicitud cursar
    $POST = $vaciarPost;
    $POST['controller'] = 'subjectStudent';
    $POST['action'] = 'delete';
    $POST['dni'] = '73972612N';
    $POST['id_materia'] = '2';
    $pruebas->peticionCurlNoTest($POST);

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;
}
?>