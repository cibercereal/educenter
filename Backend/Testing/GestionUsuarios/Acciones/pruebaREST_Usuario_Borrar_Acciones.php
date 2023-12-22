<?php

function pruebaREST_Usuario_Borrar_Acciones(){

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
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';
	$POST['id_rol'] = '2';
	$POST['dni'] = '76330419C';
	$POST['nombre'] = 'jose manuel';
	$POST['apellidos_usuario'] = 'gil';
	$POST['fecha_nac'] = '2021-12-06';
	$POST['direccion'] = 'salvador Dalí portal 10º piso 6º A';
	$POST['telefono'] = '654456654';
	$POST['email'] = 'usuario@hotmail.com';
    
    $pruebas->peticionCurlNoTest($POST);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//BORRADO
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//ELIMINAR_USUARIO_OK
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'delete';
	$POST['dni'] = '76330419C';

	$prueba = 'Usuario eliminado con éxito.';
	$codeEsperado = 'ELIMINAR_USUARIO_OK';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ACCION
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//ADMIN_NO_SE_PUEDE_BORRAR
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'delete';
	$POST['dni'] = '12345678Z';

	$prueba = 'No se puede borrar el administrador del sistema.';
	$codeEsperado = 'ADMIN_NO_SE_PUEDE_BORRAR';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//USUARIO_NO_EXISTE
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'delete';
	$POST['dni'] = '76330419C';

	$prueba = 'El usuario no existe en el sistema.';
	$codeEsperado = 'USUARIO_NO_EXISTE';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------
	
	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST); 

	//PERMISOS_KO
	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'delete';
	$POST['dni'] = '08792320H';

	$prueba = 'El usuario no existe en el sistema.';
	$codeEsperado = 'PERMISOS_KO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

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