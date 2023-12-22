<?php

function pruebaREST_CorreccionDocente_MostrarCorreccion_Acciones(){

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
    $POST['id_trabajo'] = $idTrabajo;
    $entrega = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $entrega ) , true);
    $idEntrega = $arr['resource'][0]['id_entrega'];

 	//login correcto profesor
 	$POST = $vaciarPost;
 	$POST['controller'] = 'auth';
 	$POST['action'] = 'login';
 	$POST['dni'] = '14488423X';
 	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';
 	$pruebas->peticionLogin($POST);

    // Añadir corrección
    $POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'add';
    $POST['dni_alumno'] = '73972612N';
    $POST['id_entrega'] = $idEntrega;
    $POST['id_trabajo'] = $idTrabajo;
    $POST['fecha_fin_correccion'] = '2025-11-06';
    $pruebas->peticionCurlNoTest($POST);

    // Buscar corrección
    $POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'search';
    $POST['id_entrega'] = $idEntrega;
    $POST['id_trabajo'] = $idTrabajo;
    $POST['id_criterio'] = $idCriterio;
    $correccion = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $correccion ) , true);
    $idCorreccion = $arr['resource'][0]['id_correccion_profesor'];


//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//login correcto profesor
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';
	$pruebas->peticionLogin($POST);

    // Editar corrección
    $POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'edit';
    $POST['id_correccion_profesor'] = $idCorreccion;
    $POST['correccion_docente'] = '1';
    $POST['comentario_docente'] = 'Comentario test';
    $pruebas->peticionCurlNoTest($POST);

    // CORRECCION_PROFESOR_NO_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'showCorrection';
    $POST['id_correccion_profesor'] = '1500';
    $POST['visible'] = 'true';

    $prueba = 'Corrección no existe.';
    $codeEsperado = 'CORRECCION_PROFESOR_NO_EXISTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto admin
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
    $POST['id_accion'] = '15';
    $POST['id_funcionalidad'] = '17';
    $POST['checked'] = 'true';
    $pruebas->peticionCurlNoTest($POST);

    // USUARIO_NO_ES_PROFESOR
    $POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'showCorrection';
    $POST['id_correccion_profesor'] = $idCorreccion;
    $POST['visible'] = 'true';

    $prueba = 'El usuario no es profesor.';
    $codeEsperado = 'USUARIO_NO_ES_PROFESOR';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto profesor
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '05109923J';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';
	$pruebas->peticionLogin($POST);

    // CORRECCION_NO_PERTENECE_DOCENTE
    $POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'showCorrection';
    $POST['id_correccion_profesor'] = $idCorreccion;
    $POST['visible'] = 'true';

    $prueba = 'Corrección no pertenece al docente logueado.';
    $codeEsperado = 'CORRECCION_NO_PERTENECE_DOCENTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto profesor
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';
	$pruebas->peticionLogin($POST);

    // MOSTRAR_CORRECCION_DOCENTE_OK
    $POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'showCorrection';
    $POST['id_correccion_profesor'] = $idCorreccion;
    $POST['visible'] = 'true';

    $prueba = 'Corrección visible correctamente.';
    $codeEsperado = 'MOSTRAR_CORRECCION_DOCENTE_OK';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto admin
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
    $POST['id_accion'] = '15';
    $POST['id_funcionalidad'] = '17';
    $POST['checked'] = 'false';
    $pruebas->peticionCurlNoTest($POST);

    // PERMISOS_KO
    $POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'showCorrection';
    $POST['id_correccion_profesor'] = $idCorreccion;
    $POST['visible'] = 'true';

    $prueba = 'El usuario no tiene permisos para realizar la acción.';
    $codeEsperado = 'PERMISOS_KO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto profesor
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

    // Eliminar corrección profesor
    $POST = $vaciarPost;
    $POST['controller'] = 'correctionTeacher';
    $POST['action'] = 'search';
    $POST['id_entrega'] = $idEntrega;
    $POST['id_trabajo'] = $idTrabajo;
    $correccionProf = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $correccionProf ) , true);

    foreach ($arr["resource"] as $correctionTeacher) {
        $POST = $vaciarPost;
        $POST['controller'] = 'correctionTeacher';
        $POST['action'] = 'delete';
        $POST['id_correccion_profesor'] = $correctionTeacher["id_correccion_profesor"];

        $pruebas->peticionCurlNoTest($POST);
    }

	// Eliminar corrección criterio
    $POST = $vaciarPost;
    $POST['controller'] = 'correctionCriteria';
    $POST['action'] = 'search';
    $POST['id_entrega'] = $idEntrega;
    $POST['id_trabajo'] = $idTrabajo;
    $correccionCriterio = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $correccionCriterio ) , true);

    foreach ($arr["resource"] as $correctionCriteria) {
        $POST = $vaciarPost;
        $POST['controller'] = 'correctionCriteria';
        $POST['action'] = 'delete';
        $POST['id_correccion_criterio'] = $correctionCriteria["id_correccion_criterio"];

        $pruebas->peticionCurlNoTest($POST);
    }

    // Eliminar nota criterio
    try {
        $conn = new PDO('mysql:host='.host.';dbname='.BDTEST, user, pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "DELETE FROM nota_trabajo WHERE id_entrega = :idEntrega AND id_trabajo = :idTrabajo";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':idEntrega', $idEntrega, PDO::PARAM_INT);
        $stmt->bindParam(':idTrabajo', $idTrabajo, PDO::PARAM_INT);

        $stmt->execute();
    } catch(PDOException $e) {
    }
    $conn = null;

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