<?php 

function pruebaREST_ObtenerContrasenaCorreo_Atributos(){


	include_once './Testing/pruebaREST_class.php';
	
	$pruebas = new testRest();
	
//---------------------------------------------------------------------------------------------------------------------

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
	$POST['action'] = 'getPasswordEmail';
	$POST['dni'] = '';
	$POST['email'] = 'email@gmail.com';

	$prueba = 'El login de usuario es vacio.';
	$codeEsperado = 'DNI_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_MENOR_QUE_9
	$POST['dni'] = 'us';

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

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO email
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//registrar EMAIL_VACIO
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'getPasswordEmail';
	$POST['dni'] = '12345678Z';
	$POST['email'] = '';

	$prueba = 'El email no puede ser vacío.';
	$codeEsperado = 'EMAIL_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//registrar EMAIL_LONGITUD_MINIMA
	
	$POST['email'] = 'gilbl';

	$prueba = 'El email debe tener por lo menos 6 caracteres.';
	$codeEsperado = 'EMAIL_LONGITUD_MINIMA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//registrar EMAIL_LONGITUD_MAXIMA
	$POST['email'] = 'emaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaail@gmail.com';

	$prueba = 'El email debe tener menos de 40 caracteres.';
	$codeEsperado = 'EMAIL_LONGITUD_MAXIMA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//registrar EMAIL_FORMATO_INCORRECTO
	$POST['email'] = 'email#gmail.com';

	$prueba = 'El formato del email no es correcto.';
	$codeEsperado = 'EMAIL_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	$pruebas->desconectarCurl($pruebas->cliente);

	return $pruebas->resultadoTest;

}
?>
