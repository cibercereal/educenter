<?php

function pruebaREST_Usuario_EditarContrasena_Acciones(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Acción';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST); 

//---------------------------------------------------------------------------------------------------------------------

	//insertar usuario
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'add';
	$POST['dni'] = '76330419C';
	$POST['nombre'] = 'jose manuel';
	$POST['apellidos_usuario'] = 'gil';
	$POST['email'] = 'usuario@hotmail.com';
	$POST['password'] = '21232f297a57a5a7f3894a0e4a801fc3';
	$POST['id_rol'] = '2';
	$POST['direccion'] = 'salvador Dalí portal 10º piso 6º A';
	$POST['telefono'] = '654456654';
	$POST['fecha_nac'] = '2021-12-06';

	$prueba = 'Usuario insertado con éxito.';
	$codeEsperado = 'ANADIR_USUARIO_OK';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//MODIFICAR
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '76330419C';
	$POST['password'] = '21232f297a57a5a7f3894a0e4a801fc3';

	$pruebas->peticionLogin($POST); 

	//USUARIO_EDITAR_CONTRASENA_OK
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'editPass';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc4';

	$prueba = 'Contraseña editada con éxito.';
	$codeEsperado = 'USUARIO_EDITAR_CONTRASENA_OK';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    //login admin
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '12345678Z';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

    //borrado usuario
    $POST = $vaciarPost;
    $POST['controller'] = 'user';
    $POST['action'] = 'finalDelete';
    $POST['dni'] = '76330419C';

    $pruebas->peticionCurlNoTest($POST);

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>