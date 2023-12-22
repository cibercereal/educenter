<?php

function pruebaREST_Entrega_Insertar_Acciones(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Acción';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------
	//login correcto profesor
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

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

//---------------------------------------------------------------------------------------------------------------------

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

    // ANADIR_ENTREGA_OK
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'add';
    $POST['dni'] = '73972612N';
    $POST['id_trabajo'] = $idTrabajo;
    $POST['datos'] = 'dGV4dG9kZXBydWViYXBhcmF0ZXN0cw';

    $prueba = 'Entrega añadida correctamente.';
    $codeEsperado = 'ANADIR_ENTREGA_OK';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);


//---------------------------------------------------------------------------------------------------------------------

    // ENTREGA_YA_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'add';
    $POST['dni'] = '73972612N';
    $POST['id_trabajo'] = $idTrabajo;
    $POST['datos'] = 'dGV4dG9kZXBydWViYXBhcmF0ZXN0cw';

    $prueba = 'La entrega ya existe en el sistema.';
    $codeEsperado = 'ENTREGA_YA_EXISTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto admin
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // Dar permisos añadir entrega a admin
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '1';
    $POST['id_accion'] = '1';
    $POST['id_funcionalidad'] = '13';
    $POST['checked'] = 'true';
    $pruebas->peticionCurlNoTest($POST);

    // USUARIO_NO_ES_ALUMNO
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'add';
    $POST['dni'] = '22693548T';
    $POST['id_trabajo'] = $idTrabajo;
    $POST['datos'] = 'dGV4dG9kZXBydWViYXBhcmF0ZXN0cw';

    $prueba = 'El usuario no es un alumno.';
    $codeEsperado = 'USUARIO_NO_ES_ALUMNO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

    // Quitar permisos añadir entrega a admin
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '1';
    $POST['id_accion'] = '1';
    $POST['id_funcionalidad'] = '13';
    $POST['checked'] = 'false';
    $pruebas->peticionCurlNoTest($POST);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '22693548T';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // USUARIO_NO_ES_ALUMNO_MATERIA
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'add';
    $POST['dni'] = '22693548T';
    $POST['id_trabajo'] = $idTrabajo;
    $POST['datos'] = 'dGV4dG9kZXBydWViYXBhcmF0ZXN0cw';

    $prueba = 'El usuario no es alumno de la materia.';
    $codeEsperado = 'USUARIO_NO_ES_ALUMNO_MATERIA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login correcto profesor
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '14488423X';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    // PERMISOS_KO
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'add';
    $POST['dni'] = '22693548T';
    $POST['id_trabajo'] = $idTrabajo;
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

    // Buscar entrega añadida
    $POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['dni'] = '73972612N';
    $POST['id_trabajo'] = $idTrabajo;
    $entrega = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $entrega ) , true);
    $idEntrega = $arr['resource'][0]['id_entrega'];

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