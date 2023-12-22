<?php

function pruebaREST_NotasCompetencia_Editar_Acciones(){

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

    $idMateria = 2;
    $dni = '73972612N';
	try {
        $conn = new PDO('mysql:host='.host.';dbname='.BDTEST, user, pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "INSERT INTO nota_competencia (id_materia, id_trabajo, id_competencia, dni) VALUES (:idMateria, :idTrabajo, :idCompetencia, :dni)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':idMateria', $idMateria, PDO::PARAM_INT);
        $stmt->bindParam(':idTrabajo', $idTrabajo, PDO::PARAM_INT);
        $stmt->bindParam(':idCompetencia', $idCompetencia, PDO::PARAM_INT);
        $stmt->bindParam(':dni', $dni);

        $stmt->execute();
    } catch(PDOException $e) {
    }
    $conn = null;

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ACCION
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

 	//MATERIA_NO_EXISTE
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'edit';
	$POST['id_materia'] = '12345678901';

	$prueba = 'El id de la materia no existe.';
	$codeEsperado = 'MATERIA_NO_EXISTE';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

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
    $POST['id_accion'] = '3';
    $POST['id_funcionalidad'] = '19';
    $POST['checked'] = 'true';
    $pruebas->peticionCurlNoTest($POST);

 	//USUARIO_NO_ES_PROFESOR
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'edit';
	$POST['id_materia'] = $idMateria;

	$prueba = 'El usuario no es un profesor.';
	$codeEsperado = 'USUARIO_NO_ES_PROFESOR';
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
    $POST['action'] = 'edit';
	$POST['id_materia'] = $idMateria;

	$prueba = 'El usuario no es un profesor de la materia.';
	$codeEsperado = 'USUARIO_NO_ES_PROFESOR_MATERIA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto con usuario docente
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '22693548T';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

 	//PERMISOS_KO
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'edit';
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

 	//EDITAR_NOTA_COMPETENCIA_OK
	$POST = $vaciarPost;
    $POST['controller'] = 'gradeCompetence';
    $POST['action'] = 'edit';
	$POST['id_materia'] = $idMateria;

	$prueba = 'Nota de competencia editada correctamente.';
	$codeEsperado = 'EDITAR_NOTA_COMPETENCIA_OK';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

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
    $POST['id_accion'] = '3';
    $POST['id_funcionalidad'] = '19';
    $POST['checked'] = 'false';
    $pruebas->peticionCurlNoTest($POST);

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

        $query = "DELETE FROM nota_competencia WHERE id_materia = :idMateria AND id_trabajo = :idTrabajo AND id_competencia = :idCompetencia AND dni = :dni";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':idMateria', $idMateria, PDO::PARAM_INT);
        $stmt->bindParam(':idTrabajo', $idTrabajo, PDO::PARAM_INT);
        $stmt->bindParam(':idCompetencia', $idCompetencia, PDO::PARAM_INT);
        $stmt->bindParam(':dni', $dni);

        $stmt->execute();
    } catch(PDOException $e) {
    }
    $conn = null;

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