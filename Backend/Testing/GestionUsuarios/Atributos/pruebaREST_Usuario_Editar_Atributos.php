<?php

function pruebaREST_Usuario_Editar_Atributos(){

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

	$POST = $vaciarPost;
	$POST['controller'] = 'user';
	$POST['action'] = 'edit';
	$POST['id_rol'] = '4';
	$POST['nombre'] = 'Javier';
	$POST['apellidos_usuario'] = 'Cruz Dominguez';
	$POST['fecha_nac'] = '2021-12-06';
	$POST['direccion'] = 'salvador Dalí portal 10º piso 6º A ';
	$POST['telefono'] = '696696696';
	$POST['email'] = 'usuario1Registro@gmail.com';


//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO nombre
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//NOMBRE_VACIO
	$POST['usuario'] = 'usuario';
	$POST['nombre'] = '';

	$prueba = 'El nombre no puede ser vacio.';
	$codeEsperado = 'NOMBRE_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//NOMBRE_FORMATO_INCORRECTO
	$POST['nombre'] = 'M@rtin';

	$prueba = 'El nombre del usuario no puede contener más que letras.';
	$codeEsperado = 'NOMBRE_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//NOMBRE_MENOR_QUE_3
	$POST['nombre'] = 'Ma';

	$prueba = 'El nombre del usuario no puede se menor que 3.';
	$codeEsperado = 'NOMBRE_MENOR_QUE_3';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//NOMBRE_MAYOR_QUE_45
	$POST['nombre'] = 'Maaaaaaaaaaaaa
	aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
	aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaartin';

	$prueba = 'El nombre del usuario no puede ser mayor que 45.';
	$codeEsperado = 'NOMBRE_MAYOR_QUE_45';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO apellidos
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//APELLIDOS_VACIO
	$POST['nombre'] = 'Javier';
	$POST['apellidos_usuario'] = '';

	$prueba = 'Los apellidos no pueden ser vacios.';
	$codeEsperado = 'APELLIDOS_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//APELLIDOS_FORMATO_INCORRECTO
	$POST['apellidos_usuario'] = 'G|l Bl@nco';

	$prueba = 'Los apellidos del usuario no pueden contener más que letras.';
	$codeEsperado = 'APELLIDOS_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//APELLIDOS_MENOR_QUE_3
	$POST['apellidos_usuario'] = 'Gi';
	
	$prueba = 'Los apellidos del usuario no pueden se menores que 3.';
	$codeEsperado = 'APELLIDOS_MENOR_QUE_3';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//APELLIDOS_MAYOR_QUE_45
	$POST['apellidos_usuario'] = 'Giiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiil Blanco';

	$prueba = 'Los apellidos del usuario no pueden ser mayores que 45.';
	$codeEsperado = 'APELLIDOS_MAYOR_QUE_45';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO fecha
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//FECHA_NACIMIENTO_VACIA
	$POST['apellidos_usuario'] = 'Cruz Dominguez';
	$POST['fecha_nac'] = '';

	$prueba = 'La fecha no puede ser vacia.';
	$codeEsperado = 'FECHA_NACIMIENTO_VACIA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_NACIMIENTO_FORMATO_INCORRECTO
	$POST['fecha_nac'] = '12-2021-06';

	$prueba = 'El formato de la fecha no es correcto: aaaa-mm-dd.';
	$codeEsperado = 'FECHA_NACIMIENTO_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_NACIMIENTO_SOLO_NUMEROS_Y_GUIONES
	$POST['fecha_nac'] = '2021-1$-06';

	$prueba = 'La fecha solo puede contener números y -.';
	$codeEsperado = 'FECHA_NACIMIENTO_SOLO_NUMEROS_Y_GUIONES';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_NACIMIENTO_MENOR_QUE_10
	$POST['fecha_nac'] = '2021-12-6';

	$prueba = 'La fecha de nacimiento no puede ser menor que 10 dígitos.';
	$codeEsperado = 'FECHA_NACIMIENTO_MENOR_QUE_10';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_NACIMIENTO_MAYOR_QUE_10
	$POST['fecha_nac'] = '202121212121-12-06';
	
	$prueba = 'La fecha de nacimiento no puede ser mayor que 10 dígitos.';
	$codeEsperado = 'FECHA_NACIMIENTO_MAYOR_QUE_10';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_NACIMIENTO_IMPOSIBLE
	$POST['fecha_nac'] = '3000-12-06';

	$prueba = 'La fecha de nacimiento no puede ser mayor a la fecha actual.';
	$codeEsperado = 'FECHA_NACIMIENTO_IMPOSIBLE';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO direccion
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//DIRECCION_VACIA
	$POST['fecha_nac'] = '2021-12-06';
	$POST['direccion'] = '';

	$prueba = 'La longitud de la direccion no debe ser vacia.';
	$codeEsperado = 'DIRECCION_VACIA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DIRECCION_FORMATO_INCORRECTO
	$POST['direccion'] = '#########';

	$prueba = 'La direccion solo debe contener letras, números º y ª.';
	$codeEsperado = 'DIRECCION_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DIRECCION_MENOR_5
	$POST['direccion'] = 'salv';

	$prueba = 'La longitud de la direccion no debe ser manor de 5 caracteres.';
	$codeEsperado = 'DIRECCION_MENOR_5';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DIRECCION_MAYOR_200
	$POST['direccion'] = 'salvadorrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
										rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
										rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
										rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
										rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
										rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
										rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
										rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr';

	$prueba = 'La longitud de la direccion no debe ser mayor de 200 caracteres.';
	$codeEsperado = 'DIRECCION_MAYOR_200';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO telefono
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//TELEFONO_VACIO
	$POST['direccion'] = 'salvador Dalí portal 10º piso 6º A ';
	$POST['telefono'] = '';

	$prueba = 'El número de teléfono no puede ser vacio.';
	$codeEsperado = 'TELEFONO_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//TELEFONO_FORMATO_INCORRECTO
	$POST['telefono'] = '669|48687';

	$prueba = 'El formato del teléfono no es el correcto, deben ser 9 números.';
	$codeEsperado = 'TELEFONO_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------
	
	//TELEFONO_MENOR_QUE_9
	$POST['telefono'] = '66934868';

	$prueba = 'El tamaño del número de teléfono no puede ser menor que 9.';
	$codeEsperado = 'TELEFONO_MENOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//TELEFONO_MAYOR_QUE_9
	$POST['telefono'] = '6693486877';

	$prueba = 'El tamaño del número de teléfono no puede ser mayor que 9.';
	$codeEsperado = 'TELEFONO_MAYOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO email
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//EMAIL_VACIO
	$POST['telefono'] = '696696696';
	$POST['email'] = '';

	$prueba = 'El email no puede ser vacío.';
	$codeEsperado = 'EMAIL_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------


	//EMAIL_LONGITUD_MINIMA
	$POST['email'] = 'u';

	$prueba = 'El email debe tener por lo menos 6 caracteres.';
	$codeEsperado = 'EMAIL_LONGITUD_MINIMA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//EMAIL_LONGITUD_MAXIMA
	$POST['email'] = 'usuario1Registroooo
	ooooooooooooooooooooooooooooooooooooooooooooo
	ooooooooo@gmail.com';

	$prueba = 'El email debe tener menos de 40 caracteres.';
	$codeEsperado = 'EMAIL_LONGITUD_MAXIMA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//EMAIL_FORMATO_INCORRECTO
	$POST['email'] = 'usuario1Registro#gmail.com';

	$prueba = 'El formato del email no es correcto.';
	$codeEsperado = 'EMAIL_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $tipo, $prueba, $codeEsperado);
	
//---------------------------------------------------------------------------------------------------------------------

    $pruebas->desconectarCurl($pruebas->cliente);

    return $pruebas->resultadoTest;

}
?>