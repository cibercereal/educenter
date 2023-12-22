<?php

function pruebaREST_NotasCompetencia_Buscar_Acciones(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Atributo';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto con usuario docente
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

    //Añadir competencia
    $POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'add';
    $POST['titulo'] = 'Competencia test';
    $POST['descripcion'] = 'Competencia para pruebas de test';
    $pruebas->peticionCurlNoTest($POST);

    // Buscar competencia añadida
    $POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'search';
    $POST['descripcion'] = 'Competencia para pruebas de test';
    $competence = $pruebas->peticionCurlNoTestRespuesta($POST);
    $arr = json_decode(json_encode ( $competence ) , true);
    $idCompetencia = $arr['resource'][0]['id_competencia'];

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


    $idMateria = 2;
    $dni = '73972612N';
	try {
        $conn = new PDO('mysql:host='.host.';dbname='.BDTEST, user, pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "INSERT INTO nota_competencia (id_materia, id_trabajo, id_competencia, dni, id_criterio) VALUES (:idMateria, :idTrabajo, :idCompetencia, :dni, :id_criterio)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':idMateria', $idMateria, PDO::PARAM_INT);
        $stmt->bindParam(':idTrabajo', $idTrabajo, PDO::PARAM_INT);
        $stmt->bindParam(':idCompetencia', $idCompetencia, PDO::PARAM_INT);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':id_criterio', $idCriterio);

        $stmt->execute();
    } catch(PDOException $e) {
    }
    $conn = null;

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ACCION
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	// Añadir permisos
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '1';
    $POST['id_accion'] = '4';
    $POST['id_funcionalidad'] = '19';
    $POST['checked'] = 'true';
    $pruebas->peticionCurlNoTest($POST);

 	//USUARIO_NO_ES_PROFESOR_O_ALUMNO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
	$POST['id_materia'] = $idMateria;

	$prueba = 'El usuario no es un profesor o un alumno.';
	$codeEsperado = 'USUARIO_NO_ES_PROFESOR_O_ALUMNO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto con usuario docente
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '05109923J';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

 	//USUARIO_NO_ES_PROFESOR_MATERIA
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
	$POST['id_materia'] = $idMateria;

	$prueba = 'El usuario no es un profesor de la materia.';
	$codeEsperado = 'USUARIO_NO_ES_PROFESOR_MATERIA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	// Eliminar permisos
    $POST = $vaciarPost;
    $POST['controller'] = 'roleActionFunctionality';
    $POST['action'] = 'add';
    $POST['id_rol'] = '1';
    $POST['id_accion'] = '4';
    $POST['id_funcionalidad'] = '19';
    $POST['checked'] = 'false';
    $pruebas->peticionCurlNoTest($POST);

 	//PERMISOS_KO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
	$POST['id_materia'] = $idMateria;

	$prueba = 'El usuario no tiene permisos para realizar la acción.';
	$codeEsperado = 'PERMISOS_KO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto con usuario docente
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

 	//RECORDSET_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
	$POST['id_materia'] = '123';

	$prueba = 'Nota de competencia buscada correctamente sin obtener resultados.';
	$codeEsperado = 'RECORDSET_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto con usuario docente
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

 	//RECORDSET_DATOS
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'search';
	$POST['id_trabajo'] = $idTrabajo;
	$POST['id_materia'] = $idMateria;
	$POST['dni'] = $dni;

	$prueba = 'Nota de competencia buscada correctamente.';
	$codeEsperado = 'RECORDSET_DATOS';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto profesor
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	// Eliminar nota criterio
    try {
        $conn = new PDO('mysql:host='.host.';dbname='.BDTEST, user, pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "DELETE FROM nota_competencia WHERE id_materia = :idMateria AND id_trabajo = :idTrabajo AND id_competencia = :idCompetencia AND dni = :dni AND id_criterio = :id_criterio";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':idMateria', $idMateria, PDO::PARAM_INT);
        $stmt->bindParam(':idTrabajo', $idTrabajo, PDO::PARAM_INT);
        $stmt->bindParam(':idCompetencia', $idCompetencia, PDO::PARAM_INT);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':id_criterio', $idCriterio);

        $stmt->execute();
    } catch(PDOException $e) {
    }
    $conn = null;

    // Eliminar criterio
	$POST = $vaciarPost;
    $POST['controller'] = 'criteria';
    $POST['action'] = 'delete';
	$POST['id_criterio'] = $idCriterio;
	$pruebas->peticionCurlNoTest($POST);

    // Eliminar competencia
    $POST = $vaciarPost;
    $POST['controller'] = 'competence';
    $POST['action'] = 'delete';
    $POST['id_competencia'] = $idCompetencia;
    $pruebas->peticionCurlNoTest($POST);

    // Eliminar trabajo
 	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'delete';
 	$POST['id_trabajo'] = $idTrabajo;
 	$pruebas->peticionCurlNoTest($POST);


    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>