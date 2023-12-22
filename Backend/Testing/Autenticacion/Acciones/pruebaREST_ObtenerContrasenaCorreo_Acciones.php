<?php 

function pruebaREST_ObtenerContrasenaCorreo_Acciones(){


	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

//---------------------------------------------------------------------------------------------------------------------

	$accion = 'Accion';
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
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//CORREO
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//RECUPERAR_CONTRASENA_EMAIL_OK
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'getPasswordEmail';
	$POST['dni'] = '12345678Z';
	$POST['email'] = 'admin@admin.es';

	$prueba = 'La contraseña ha sido cambiada, revise su correo.';
	$codeEsperado = 'RECOVER_PASSWORD_EMAIL_OK';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $accion, $prueba, $codeEsperado);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ACCION
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    //USUARIO_NO_EXISTE
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'getPasswordEmail';
    $POST['dni'] = '89813482T';
    $POST['email'] = 'admin@admin.es';

    $prueba = 'El usuario no existe en el sistema.';
    $codeEsperado = 'USUARIO_NO_EXISTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $accion, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //EMAIL_NO_EXISTE
    $POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'getPasswordEmail';
	$POST['dni'] = '12345678Z';
    $POST['email'] = 'falso@falso.es';

    $prueba = 'El correo electrónico no existe.';
    $codeEsperado = 'EMAIL_NO_EXISTE';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $accion, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //USUARIO_EMAIL_NO_COINCIDEN
    $POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'getPasswordEmail';
	$POST['dni'] = '12345678Z';
    $POST['email'] = 'profesor@profesor.es';

    $prueba = 'El usuario y el correo electrónico no coinciden.';
    $codeEsperado = 'USUARIO_EMAIL_NO_COINCIDEN';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $accion, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //borrado usuario
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'editPass';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionCurlNoTest($POST);

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>
