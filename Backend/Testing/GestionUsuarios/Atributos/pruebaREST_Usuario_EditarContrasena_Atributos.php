<?php

function pruebaREST_Usuario_EditarContrasena_Atributos(){

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

	//CONTRASENA_USUARIO_VACIA
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'editPass';
	$POST['password'] = '';

	$prueba = 'La contraseña no puede ser vacia.';
	$codeEsperado = 'CONTRASENA_USUARIO_VACIA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//CONTRASEÑA_USUARIO_LONGITUD_INCORRECTA 
	$POST['password'] = '21232f297a57a5a7f3894a0e4a801fc33';

	$prueba = 'Seguridad de la password comprometida. Longitud de password incorrecta.';
	$codeEsperado = 'CONTRASEÑA_USUARIO_LONGITUD_INCORRECTA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//CONTRASEÑA_USUARIO_ALFANUMERICO_INCORRECTO
	$POST['password'] = '21232f297a57a5a&f3894a0e4a801fc3';

	$prueba = 'La contraseña de usuario no puede contener más que letras y números, no se aceptan caracteres en blanco, ñ, acentos o carcateres especiales.';
	$codeEsperado = 'CONTRASEÑA_USUARIO_ALFANUMERICO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>