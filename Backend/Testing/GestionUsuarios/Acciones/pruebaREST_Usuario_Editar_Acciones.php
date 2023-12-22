<?php

function pruebaREST_Usuario_Editar_Acciones(){

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
	$POST['dni'] = '85537205K';
	$POST['nombre'] = 'jose manuel';
	$POST['apellidos_usuario'] = 'gil';
	$POST['email'] = 'usuario@hotmail.com';
	$POST['password'] = '21232f297a57a5a7f3894a0e4a801fc3';
	$POST['id_rol'] = '2';
	$POST['direccion'] = 'salvador Dalí portal 10º piso 6º A';
	$POST['telefono'] = '654456654';
	$POST['fecha_nac'] = '2021-12-06';

    $pruebas->peticionCurlNoTest($POST);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//MODIFICAR
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    //login correcto
    $POST = $vaciarPost;
    $POST['controller'] = 'auth';
    $POST['action'] = 'login';
    $POST['dni'] = '85537205K';
    $POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

    $pruebas->peticionLogin($POST);

	//USUARIO_EDITAR_OK
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'edit';
	$POST['dni'] = '85537205K';
	$POST['nombre'] = 'jose manuel';
	$POST['apellidos_usuario'] = 'gil';
	$POST['email'] = 'usuario@hotmail.com';
	$POST['password'] = '21232f297a57a5a7f3894a0e4a801fc3';
	$POST['id_rol'] = '2';
	$POST['direccion'] = 'salvador Dalí portal 10º piso 6º A';
	$POST['fecha_nac'] = '2021-12-06';
	$POST['telefono'] = '696696699';

	$prueba = 'Usuario editado con éxito.';
	$codeEsperado = 'EDITAR_USUARIO_OK';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ACCION
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//USUARIO_NO_EXISTE
	$POST['dni'] = '18818190G';

	$prueba = 'El usuario no existe en el sistema';
	$codeEsperado = 'USUARIO_NO_EXISTE';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '85537205K';
	$POST['password'] = '21232f297a57a5a7f3894a0e4a801fc3';

	$pruebas->peticionLogin($POST); 

	//ACCION_DENEGADA_EDITAR_USUARIO
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'edit';
	$POST['password'] = '21232f297a57a5a7f3894a0e4a801fc3';
	$POST['id_rol'] = '3';
	$POST['dni'] = '12345678Z';
	$POST['nombre'] = 'Javier';
	$POST['apellidos_usuario'] = 'Cruz Dominguez';
	$POST['fecha_nac'] = '2021-12-06';
	$POST['direccion'] = 'salvador Dalí portal 10º piso 6º A ';
	$POST['telefono'] = '696696696';
	$POST['email'] = 'correoAdmin@gmail.com';

	$prueba = 'Solo el administrador puede edit los datos de un usuario y un usuario los suyos propios.';
	$codeEsperado = 'ACCION_DENEGADA_EDITAR_USUARIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//------------------------------------------------BORRADO--------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '12345678Z';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST); 

	//eliminar usuario
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'finalDelete';
	$POST['dni'] = '85537205K';

	$pruebas->peticionCurlNoTest($POST);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>