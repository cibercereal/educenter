<?php

function pruebaREST_Criterio_Buscar_Acciones(){

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

	// Añadir un trabajo
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

    $POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'search';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$trabajo = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $trabajo ) , true);
    $idTrabajo = $arr['resource'][0]['id_trabajo'];

    //Añadir criterio
    $POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'add';
    $POST['id_trabajo'] = $idTrabajo;
    $POST['descripcion'] = 'Criterio para pruebas de test';

    $prueba = 'Criterio añadido correctamente.';
    $codeEsperado = 'ANADIR_CRITERIO_OK';
    $pruebas->peticionCurlNoTest($POST);

    // Buscar id criterio añadido
    $POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'search';
    $POST['id_trabajo'] = $idTrabajo;
    $criterio = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $criterio ) , true);
    $idCriterio = $arr['resource'][0]['id_criterio'];

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	// RECORDSET_DATOS
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'search';
    $POST['id_trabajo'] = $idTrabajo;
    $POST['descripcion'] = 'Criterio para pruebas de test';

	$prueba = 'Criterio buscado correctamente.';
	$codeEsperado = 'RECORDSET_DATOS';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//RECORDSET_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'search';
    $POST['descripcion'] = '12342';
    $POST['id_trabajo'] = $idTrabajo;

	$prueba = 'No se encuentran datos para el criterio buscado.';
	$codeEsperado = 'RECORDSET_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto administrador
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	// Dar permisos a admin
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '1';
    $POST['id_accion'] = '4';
    $POST['id_funcionalidad'] = '14';
    $POST['checked'] = 'true';
    $pruebas->peticionCurlNoTest($POST);

	//USUARIO_NO_ES_PROFESOR_O_ALUMNO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'search';
    $POST['id_trabajo'] = $idTrabajo;

	$prueba = 'El usuario debe ser un profesor  o alumno.';
	$codeEsperado = 'USUARIO_NO_ES_PROFESOR_O_ALUMNO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto profesor no materia
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '05109923J';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	//USUARIO_NO_ES_PROFESOR_O_ALUMNO_MATERIA
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'search';
    $POST['id_trabajo'] = $idTrabajo;

	$prueba = 'El usuario no es profesor o alumno de la materia.';
	$codeEsperado = 'USUARIO_NO_ES_PROFESOR_O_ALUMNO_MATERIA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto profesor no materia
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	// Quitar permisos a admin
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '1';
    $POST['id_accion'] = '4';
    $POST['id_funcionalidad'] = '14';
    $POST['checked'] = 'false';
    $pruebas->peticionCurlNoTest($POST);

	//PERMISOS_KO
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'search';
    $POST['id_trabajo'] = $idTrabajo;

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

	// Eliminar criterio
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'delete';
	$POST['id_criterio'] = $idCriterio;
	$pruebas->peticionCurlNoTest($POST);

	// Eliminar trabajo
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'delete';
	$POST['id_trabajo'] = $idTrabajo;
	$pruebas->peticionCurlNoTest($POST);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;
}
?>