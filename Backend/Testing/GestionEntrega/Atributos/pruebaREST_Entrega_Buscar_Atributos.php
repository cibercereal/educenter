<?php

function pruebaREST_Entrega_Buscar_Atributos(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Atributo';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto con usuario alumno
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '73972612N';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//DNI_MENOR_QUE_9
	$POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['dni'] = 'ab';
	$POST['id_trabajo'] = '';

    $prueba = 'El dni de la entrega no puede ser menor que 9.';
    $codeEsperado = 'DNI_MENOR_QUE_9';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_MAYOR_QUE_9
	$POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['dni'] = 'aaaaaaaaaaaaaaa';
	$POST['id_trabajo'] = '';

    $prueba = 'El dni de la entrega no puede ser mayor que 9.';
    $codeEsperado = 'DNI_MAYOR_QUE_9';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_FORMATO_INCORRECTO
	$POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['dni'] = 'aaaaaaaaa';
	$POST['id_trabajo'] = '';

    $prueba = 'El formato del dni es incorrecto.';
    $codeEsperado = 'DNI_FORMATO_INCORRECTO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DNI_LETRA_INCORRECTA
	$POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['dni'] = '11111111Z';
	$POST['id_trabajo'] = '';

    $prueba = 'La letra del dni es incorrecta.';
    $codeEsperado = 'DNI_LETRA_INCORRECTA';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_TRABAJO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['dni'] = '11111111H';
    $POST['id_trabajo'] = 'ab';

    $prueba = 'El id del trabajo tiene un error de formato.';
    $codeEsperado = 'ID_TRABAJO_ERROR_FORMATO';
    $pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_ENTREGA_FORMATO_INCORRECTO
	$POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['dni'] = '11111111H';
    $POST['id_trabajo'] = '1';
    $POST['fecha_entrega'] = 'Lunes 5 de diciembre';

	$prueba = 'El formato de la fecha no es correcto: aaaa-mm-dd.';
	$codeEsperado = 'FECHA_ENTREGA_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_ENTREGA_SOLO_NUMEROS_Y_GUIONES
	$POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['dni'] = '11111111H';
    $POST['id_trabajo'] = '1';
	$POST['fecha_entrega'] = 'abcd-11-21';

	$prueba = 'La fecha solo puede contener números y -.';
	$codeEsperado = 'FECHA_ENTREGA_SOLO_NUMEROS_Y_GUIONES';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_ENTREGA_MENOR_QUE_10
	$POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['dni'] = '11111111H';
    $POST['id_trabajo'] = '1';
	$POST['fecha_entrega'] = '1996-5-2';

	$prueba = 'La fecha no puede ser menor que 10 dígitos.';
	$codeEsperado = 'FECHA_ENTREGA_MENOR_QUE_10';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_ENTREGA_MAYOR_QUE_10
	$POST = $vaciarPost;
    $POST['controller'] = 'delivery';
    $POST['action'] = 'search';
    $POST['dni'] = '11111111H';
    $POST['id_trabajo'] = '1';
	$POST['fecha_entrega'] = '19999-06-15';

	$prueba = 'La fecha no puede ser mayor que 10 dígitos.';
	$codeEsperado = 'FECHA_ENTREGA_MAYOR_QUE_10';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>