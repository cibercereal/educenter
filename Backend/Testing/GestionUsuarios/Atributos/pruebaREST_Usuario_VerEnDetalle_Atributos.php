<?php

function pruebaREST_Usuario_VerEnDetalle_Atributos(){

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
												//ERRORES_ATRIBUTO DNI
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//DNI_VACIO
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'searchBy';
	$POST['dni'] = '';

	$prueba = 'El login de usuario es vacio.';
	$codeEsperado = 'DNI_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------
	//DNI_MENOR_QUE_9
	$POST['dni'] = '12';
	
	$prueba = 'El DNI no puede tener menos de 9 caracteres.';
	$codeEsperado = 'DNI_MENOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------
	//DNI_MAYOR_QUE_9
	$POST['dni'] = '1234567894';

	$prueba = 'El DNI no puede tener más de 9 caracteres.';
	$codeEsperado = 'DNI_MAYOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_FORMATO_INCORRECTO
	$POST['dni'] = '1234 5678';

	$prueba = 'El dni de usuario no puede contener más que letras y números, no se aceptan caracteres en blanco, ñ, acentos o carcateres especiales.';
	$codeEsperado = 'DNI_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_LETRA_INCORRECTA
	$POST['dni'] = '12345678A';

	$prueba = 'El dni de usuario debe ser real.';
	$codeEsperado = 'DNI_LETRA_INCORRECTA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);
	
//---------------------------------------------------------------------------------------------------------------------

	$pruebas->desconectarCurl($pruebas->cliente);

	return $pruebas->resultadoTest;

}

?>