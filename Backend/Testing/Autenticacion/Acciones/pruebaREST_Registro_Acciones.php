<?php

function pruebaREST_Registro_Acciones(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

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
												//REGISTRAR
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//registrar correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'register';
	$POST['dni'] = '05014926Y';
	$POST['password'] = '21232f297a57a5a7f3894a0e4a801fc3';
	$POST['nombre'] = 'Javier';
	$POST['apellidos_usuario'] = 'Gil Blanco';
	$POST['fecha_nac'] = '2021-12-06';
	$POST['direccion'] = 'salvador Dalí portal 10º piso 6º A ';
	$POST['telefono'] = '696696696';
	$POST['email'] = 'dniRegistro3@gmail.com';
	$POST['id_rol'] = '2';

	$prueba = 'Usuario registrado correctamente.';
	$codeEsperado = 'REGISTRAR_USUARIO_OK';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $accion, $prueba, $codeEsperado);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ACCION
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//USUARIO_YA_EXISTE
	$POST['dni'] = '12345678Z';

	$prueba = 'Ya existe el dni en el sistema.';
	$codeEsperado = 'USUARIO_YA_EXISTE';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $accion, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//EMAIL_YA_EXISTE
	$POST['dni'] = '21983139S';
	$POST['email'] = 'admin@admin.es';

	$prueba = 'Ya existe un dni con ese email.';
	$codeEsperado = 'EMAIL_YA_EXISTE';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $accion, $prueba, $codeEsperado);
	
//---------------------------------------------------------------------------------------------------------------------

    //borrado usuario
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'finalDelete';
	$POST['dni'] = '05014926Y';

	$pruebas->peticionCurlNoTest($POST);

    //borrado usuario
    $POST = $vaciarPost;
    $POST['controller'] = 'user';
    $POST['action'] = 'finalDelete';
    $POST['dni'] = '21983139S';

    $pruebas->peticionCurlNoTest($POST);

	$pruebas->desconectarCurl($pruebas->cliente);

	return $pruebas->resultadoTest;

}

?>