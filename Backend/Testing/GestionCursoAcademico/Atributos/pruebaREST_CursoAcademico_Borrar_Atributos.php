<?php

function pruebaREST_CursoAcademico_Borrar_Atributos(){

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

	//ID_VACIO
	$POST = $vaciarPost;
	$POST['controller'] = 'academicCourse';
	$POST['action'] = 'delete';
	$POST['id_curso_academico'] = '';

	$prueba = 'El id del curso académico no puede estar vacío.';
	$codeEsperado = 'ID_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_MAYOR_QUE_11
	$POST = $vaciarPost;
	$POST['controller'] = 'academicCourse';
	$POST['action'] = 'delete';
	$POST['id_curso_academico'] = '1234567890123';

	$prueba = 'El id del curso académico no puede ser mayor que 11.';
	$codeEsperado = 'ID_MAYOR_QUE_11';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_FORMATO_INCORRECTO
	$POST = $vaciarPost;
	$POST['controller'] = 'academicCourse';
	$POST['action'] = 'delete';
	$POST['id_curso_academico'] = 'abcd';

	$prueba = 'El id del curso académico no tiene un formato correcto.';
	$codeEsperado = 'ID_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>