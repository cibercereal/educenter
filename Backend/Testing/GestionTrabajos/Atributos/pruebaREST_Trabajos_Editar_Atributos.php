<?php

function pruebaREST_Trabajos_Editar_Atributos(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();

    $tipo = 'Atributo';
	$vaciarPost = NULL;

//---------------------------------------------------------------------------------------------------------------------

	//login correcto
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'login';
	$POST['dni'] = '14488423X';
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc3';

	$pruebas->peticionLogin($POST);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO contraseña
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//ID_TRABAJO_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['id_trabajo'] = '';

	$prueba = 'El id del trabajo no puede ser vacío.';
	$codeEsperado = 'ID_TRABAJO_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_TRABAJO_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['id_trabajo'] = 'abc';

	$prueba = 'El id de la materia tiene un formato erróneo.';
	$codeEsperado = 'ID_TRABAJO_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//NOMBRE_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = '';
	$POST['id_trabajo'] = '1';
	
	$prueba = 'El nombre del trabajo no puede ser vacío.';
	$codeEsperado = 'NOMBRE_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);
	
//---------------------------------------------------------------------------------------------------------------------

	//NOMBRE_MENOR_QUE_3
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'ab';
	$POST['id_trabajo'] = '1';

	$prueba = 'El nombre de la materia no puede ser menor que 3.';
	$codeEsperado = 'NOMBRE_MENOR_QUE_3';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);
	
//---------------------------------------------------------------------------------------------------------------------

	//NOMBRE_MENOR_QUE_3
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['id_trabajo'] = '1';
	$POST['nombre_trabajo'] = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';

	$prueba = 'El nombre de la materia no puede ser mayor que 60.';
	$codeEsperado = 'NOMBRE_MAYOR_QUE_60';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DESCRIPCION_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Nombre test';
	$POST['descripcion_trabajo'] = '';
	$POST['id_trabajo'] = '1';

	$prueba = 'La descripción del trabajo no puede ser vacío.';
	$codeEsperado = 'DESCRIPCION_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DESCRIPCION_MENOR_QUE_3
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Nombre test';
	$POST['descripcion_trabajo'] = 'ab';
	$POST['id_trabajo'] = '1';

	$prueba = 'La descripción del trabajo no puede ser menor que 3.';
	$codeEsperado = 'DESCRIPCION_MENOR_QUE_3';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DESCRIPCION_MAYOR_QUE_200
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['id_trabajo'] = '1';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';

	$prueba = 'La descripción del trabajo no puede ser mayor que 200.';
	$codeEsperado = 'DESCRIPCION_MAYOR_QUE_200';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//PORCENTAJE_NOTA_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '';
	$POST['id_trabajo'] = '1';

	$prueba = 'El porcentaje de la nota no puede ser vacío.';
	$codeEsperado = 'PORCENTAJE_NOTA_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//PORCENTAJE_NOTA_MAYOR_QUE_3
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '1234';
	$POST['id_trabajo'] = '1';

	$prueba = 'El porcentaje de la nota no puede ser mayor que 3.';
	$codeEsperado = 'PORCENTAJE_NOTA_MAYOR_QUE_3';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//PORCENTAJE_NOTA_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = 'abc';
	$POST['id_trabajo'] = '1';

	$prueba = 'El formato del porcentaje de la nota es erróneo.';
	$codeEsperado = 'PORCENTAJE_NOTA_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//PORCENTAJE_NOTA_MAYOR_100
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '101';
	$POST['id_trabajo'] = '1';

	$prueba = 'El porcentaje de la nota no puede ser mayor que 100.';
	$codeEsperado = 'PORCENTAJE_NOTA_MAYOR_100';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------


	//CORRECCION_NOTA_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '';
	$POST['id_trabajo'] = '1';

	$prueba = 'El porcentaje de corrección de la nota no puede ser vacío.';
	$codeEsperado = 'CORRECCION_NOTA_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//CORRECCION_NOTA_MAYOR_QUE_3
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '1234';
	$POST['id_trabajo'] = '1';

	$prueba = 'El porcentaje de corrección de la nota no puede ser mayor que 3.';
	$codeEsperado = 'CORRECCION_NOTA_MAYOR_QUE_3';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//CORRECCION_NOTA_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = 'abc';
	$POST['id_trabajo'] = '1';

	$prueba = 'El formato del porcentaje de corrección de la nota es erróneo.';
	$codeEsperado = 'CORRECCION_NOTA_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//CORRECCION_NOTA_MAYOR_100
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '101';
	$POST['id_trabajo'] = '1';

	$prueba = 'El porcentaje de corrección de la nota no puede ser mayor que 100.';
	$codeEsperado = 'CORRECCION_NOTA_MAYOR_100';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_MATERIA_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '80';
	$POST['id_materia'] = '';
	$POST['id_trabajo'] = '1';

	$prueba = 'El id de la materia no puede ser vacío.';
	$codeEsperado = 'ID_MATERIA_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//ID_MATERIA_ERROR_FORMATO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '80';
	$POST['id_materia'] = 'ab';
	$POST['id_trabajo'] = '1';

	$prueba = 'El id de la materia tiene un formato erróneo.';
	$codeEsperado = 'ID_MATERIA_ERROR_FORMATO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_INICIAL_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '80';
	$POST['id_materia'] = '1';
	$POST['id_trabajo'] = '1';

	$prueba = 'La fecha inicial del trabajo es vacía.';
	$codeEsperado = 'FECHA_INICIAL_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_FORMATO_INCORRECTO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '80';
	$POST['id_materia'] = '1';
	$POST['id_trabajo'] = '1';
	$POST['fecha_ini'] = '19022023';

	$prueba = 'La fecha inicial tiene un formato incorrecto.';
	$codeEsperado = 'FECHA_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_SOLO_NUMEROS_Y_GUIONES
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '80';
	$POST['id_materia'] = '1';
	$POST['id_trabajo'] = '1';
	$POST['fecha_ini'] = '2021-1$-06';

	$prueba = 'La fecha inicial del trabajo tiene letras.';
	$codeEsperado = 'FECHA_SOLO_NUMEROS_Y_GUIONES';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_MENOR_QUE_10
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '80';
	$POST['id_materia'] = '1';
	$POST['id_trabajo'] = '1';
	$POST['fecha_ini'] = '2023-5-2';

	$prueba = 'La fecha inicial del trabajo tiene un tamaño menor que 10.';
	$codeEsperado = 'FECHA_MENOR_QUE_10';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_MAYOR_QUE_10
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '80';
	$POST['id_materia'] = '1';
	$POST['id_trabajo'] = '1';
	$POST['fecha_ini'] = '2023-05-002';

	$prueba = 'La fecha inicial del trabajo tiene un tamaño mayor que 10.';
	$codeEsperado = 'FECHA_MAYOR_QUE_10';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_FIN_VACIO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '80';
	$POST['id_materia'] = '1';
	$POST['id_trabajo'] = '1';
	$POST['fecha_ini'] = '2023-02-05';

	$prueba = 'La fecha fin del trabajo es vacía.';
	$codeEsperado = 'FECHA_FIN_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_FORMATO_INCORRECTO
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '80';
	$POST['id_materia'] = '1';
	$POST['id_trabajo'] = '1';
	$POST['fecha_ini'] = '2023-02-05';
	$POST['fecha_fin'] = '19022023';

	$prueba = 'La fecha fin tiene un formato incorrecto.';
	$codeEsperado = 'FECHA_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_SOLO_NUMEROS_Y_GUIONES
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '80';
	$POST['id_materia'] = '1';
	$POST['id_trabajo'] = '1';
	$POST['fecha_ini'] = '2023-02-05';
	$POST['fecha_fin'] = '2021-1$-06';

	$prueba = 'La fecha fin del trabajo tiene letras.';
	$codeEsperado = 'FECHA_SOLO_NUMEROS_Y_GUIONES';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_MENOR_QUE_10
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '80';
	$POST['id_materia'] = '1';
	$POST['id_trabajo'] = '1';
	$POST['fecha_ini'] = '2023-02-05';
	$POST['fecha_fin'] = '2023-5-2';

	$prueba = 'La fecha fin del trabajo tiene un tamaño menor que 10.';
	$codeEsperado = 'FECHA_MENOR_QUE_10';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_MAYOR_QUE_10
	$POST = $vaciarPost;
    $POST['controller'] = 'project';
    $POST['action'] = 'edit';
	$POST['nombre_trabajo'] = 'Trabajo test';
	$POST['descripcion_trabajo'] = 'Descripción test';
	$POST['porcentaje_nota'] = '20';
	$POST['correccion_nota'] = '80';
	$POST['id_materia'] = '1';
	$POST['id_trabajo'] = '1';
	$POST['fecha_ini'] = '2023-02-05';
	$POST['fecha_fin'] = '2023-05-002';

	$prueba = 'La fecha fin del trabajo tiene un tamaño mayor que 10.';
	$codeEsperado = 'FECHA_MAYOR_QUE_10';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>