<?php

function pruebaREST_Login_Atributos(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();


	$atributo = 'Atributo';
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
												//ERRORES_ATRIBUTO LOGIN
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//DNI_VACIO
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';
	
	$prueba = 'El dni de usuario es vacio.';
	$codeEsperado = 'DNI_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_MENOR_QUE_9
	$POST['dni'] = 'ad';

	$prueba = 'El tamaño del dni de usuario no puede ser menor que 9.';
	$codeEsperado = 'DNI_MENOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_MAYOR_QUE_9
	$POST['dni'] = 'adminadminadmina';

	$prueba = 'El tamaño del dni de usuario no puede ser mayor que 9.';
	$codeEsperado = 'DNI_MAYOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_FORMATO_INCORRECTO
	$POST['dni'] = '1234 5678';

	$prueba = 'El dni de usuario no puede contener más que letras y números, no se aceptan caracteres en blanco, ñ, acentos o carcateres especiales.';
	$codeEsperado = 'DNI_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_LETRA_INCORRECTA
	$POST['dni'] = '12345678A';

	$prueba = 'El dni de usuario debe ser real.';
	$codeEsperado = 'DNI_LETRA_INCORRECTA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO CONTRASEÑA
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//CONTRASENA_USUARIO_VACIA
	$POST['dni'] = '12345678Z';
	$POST['password'] = '';

	$prueba = 'La contraseña no puede ser vacia.';
	$codeEsperado = 'CONTRASENA_USUARIO_VACIA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);
//---------------------------------------------------------------------------------------------------------------------

	//CONTRASEÑA_USUARIO_LONGITUD_INCORRECTA
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc33';

	$prueba = 'Seguridad de la password comprometida. Longitud de password incorrecta.';
	$codeEsperado = 'CONTRASEÑA_USUARIO_LONGITUD_INCORRECTA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//CONTRASEÑA_USUARIO_ALFANUMERICO_INCORRECTO
	$POST['password'] = '21232f297a57a5a7#3894a0e4a801fc3';

	$prueba = 'La contraseña de usuario no puede contener más que letras y números, no se aceptan caracteres en blanco, ñ, acentos o carcateres especiales.';
	$codeEsperado = 'CONTRASEÑA_USUARIO_ALFANUMERICO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	$pruebas->desconectarCurl($pruebas->cliente);

	return $pruebas->resultadoTest;

}

?>