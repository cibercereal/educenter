<?php

function pruebaREST_Usuario_Insertar_Acciones(){

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

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//INSERTAR
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//USUARIO_INSERTAR_OK
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
												//ERRORES_ACCION
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//USUARIO_YA_EXISTE
	$POST['dni'] = '76330419C';

	$prueba = 'Ya existe el usuario en el sistema.';
	$codeEsperado = 'USUARIO_YA_EXISTE';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------
	
	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '76330419C';
	$POST['password'] = '21232f297a57a5a7f3894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

	//PERMISOS_KO
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'add';
	$POST['dni'] = '09759742Z';
	$POST['nombre'] = 'jose manuel';
	$POST['apellidos_usuario'] = 'gil';
	$POST['email'] = 'usuario@hotmail.com';
	$POST['password'] = '21232f297a57a5a7f3894a0e4a801fc3';
	$POST['id_rol'] = '2';
	$POST['direccion'] = 'salvador Dalí portal 10º piso 6º A';
	$POST['telefono'] = '654456654';
	$POST['fecha_nac'] = '2021-12-06';

	$prueba = 'Solo el administrador puede insertar un nuevo usuario.';
	$codeEsperado = 'PERMISOS_KO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//-------------------------------------------------------------------------------------------------------------------

	//login correcto
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

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>