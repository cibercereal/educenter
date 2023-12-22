<?php

function pruebaREST_Login_Acciones(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

	$accion = 'Accion';
	$vaciarPost = NULL;

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//LOGIN
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$prueba = 'Login realizado correctamente.';
	$codeEsperado = 'LOGIN_USUARIO_CORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $accion, $prueba, $codeEsperado);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ACCION
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//USUARIO_NO_EXISTE
	$POST['dni'] = '05014926Y';

	$prueba = 'El usuario no existe en el sistema.';
	$codeEsperado = 'USUARIO_NO_EXISTE';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $accion, $prueba, $codeEsperado);
	
//---------------------------------------------------------------------------------------------------------------------

	//CONTRASENA_INCORRECTO
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc4';

	$prueba = 'La contraseña no es correcta.';
	$codeEsperado = 'CONTRASENA_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $accion, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	$pruebas->desconectarCurl($pruebas->cliente);

	return $pruebas->resultadoTest;

}

?>