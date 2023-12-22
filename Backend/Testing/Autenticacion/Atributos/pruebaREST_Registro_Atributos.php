<?php

function pruebaREST_Registro_Atributos(){

	include_once './Testing/pruebaREST_class.php';

	$pruebas = new testRest();


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
												//ERRORES_ATRIBUTO usuario
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//registrar DNI_VACIO
	$POST = $vaciarPost;
	$POST['controller'] = 'auth';
	$POST['action'] = 'register';
	$POST['dni'] = '';
	$POST['nombre'] = 'Javier';
	$POST['apellidos_usuario'] = 'Cruz Domínguez';
	$POST['email'] = 'usuario1Registro@gmail.com';
	$POST['password'] = '21232f297a57a5a7f3894a0e4a801fc3';
	$POST['id_rol'] = '2';
	$POST['direccion'] = 'salvador Dalí portal 10º piso 6º A ';
	$POST['telefono'] = '696696696';
	$POST['fecha_nac'] = '2021-12-06';
	$POST['borrado_logico'] = '0';
	
	$prueba = 'El dni de usuario es vacio.';
	$codeEsperado = 'DNI_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------
	//registrar DNI_MENOR_QUE_9
	$POST['dni'] = '123';
	
	$prueba = 'El DNI no puede tener menos de 9 caracteres.';
	$codeEsperado = 'DNI_MENOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------
	//registrar DNI_MAYOR_QUE_9
	$POST['dni'] = '12345678901';

	$prueba = 'El DNI no puede tener más de 9 caracteres.';
	$codeEsperado = 'DNI_MAYOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

	//DNI_FORMATO_INCORRECTO
	$POST['dni'] = '1234 5678';

	$prueba = 'El dni de usuario no puede contener más que letras y números, no se aceptan caracteres en blanco, ñ, acentos o carcateres especiales.';
	$codeEsperado = 'DNI_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

	//---------------------------------------------------------------------------------------------------------------------

	//DNI_LETRA_INCORRECTA
	$POST['dni'] = '12345678A';

	$prueba = 'El dni de usuario debe ser real.';
	$codeEsperado = 'DNI_LETRA_INCORRECTA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);
	
	//---------------------------------------------------------------------------------------------------------------------
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO CONTRASEÑA
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

	//CONTRASENA_USUARIO_VACIA
	$POST['dni'] = '12345678Z';
	$POST['password'] = '';

	$prueba = 'La contraseña no puede ser vacia.';
	$codeEsperado = 'CONTRASENA_USUARIO_VACIA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);
//---------------------------------------------------------------------------------------------------------------------

	//CONTRASEÑA_USUARIO_LONGITUD_INCORRECTA
	$POST['password'] = '21232f297a57a5a743894a0e4a801fc33';

	$prueba = 'Seguridad de la password comprometida. Longitud de password incorrecta.';
	$codeEsperado = 'CONTRASEÑA_USUARIO_LONGITUD_INCORRECTA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//CONTRASEÑA_USUARIO_ALFANUMERICO_INCORRECTO
	$POST['password'] = '21232f297a57a5a7#3894a0e4a801fc3';

	$prueba = 'La contraseña de usuario no puede contener más que letras y números, no se aceptan caracteres en blanco, ñ, acentos o carcateres especiales.';
	$codeEsperado = 'CONTRASEÑA_USUARIO_ALFANUMERICO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO NOMBRE
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

//---------------------------------------------------------------------------------------------------------------------

	//NOMBRE_VACIO
	$POST['password'] = '21232f297a57a5a7f3894a0e4a801fc3';
	$POST['nombre'] = '';

	$prueba = 'El nombre no puede ser vacio.';
	$codeEsperado = 'NOMBRE_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//NOMBRE_MENOR_QUE_3
	$POST['nombre'] = 'Ja';

	$prueba = 'El nombre del usuario no puede se menor que 3.';
	$codeEsperado = 'NOMBRE_MENOR_QUE_3';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//NOMBRE_MAYOR_QUE_45
	$POST['nombre'] = 'JavierJavierJavierJavierJavierJavierJavierJavier';

	$prueba = 'El nombre del usuario no puede ser mayor que 45.';
	$codeEsperado = 'NOMBRE_MAYOR_QUE_45';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//NOMBRE_MAYOR_QUE_45
	$POST['nombre'] = 'J4vi3r';

	$prueba = 'El nombre del usuario no puede contener más que letras.';
	$codeEsperado = 'NOMBRE_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO APELLIDOS
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&


	//APELLIDOS_VACIO
	$POST['nombre'] = 'Javier';
	$POST['apellidos_usuario'] = '';

	$prueba = 'Los apellidos no pueden ser vacíos.';
	$codeEsperado = 'APELLIDOS_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//APELLIDOS_MENOR_QUE_3
	$POST['apellidos_usuario'] = 'Cr';

	$prueba = 'Los apellidos del usuario no pueden se menores que 3.';
	$codeEsperado = 'APELLIDOS_MENOR_QUE_3';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);
	
//---------------------------------------------------------------------------------------------------------------------

	//APELLIDOS_MAYOR_QUE_45
	$POST['apellidos_usuario'] = 'JavierJavierJavierJavierJavierJavierJavierJavier';

	$prueba = 'Los apellidos del usuario no pueden ser mayores que 45.';
	$codeEsperado = 'APELLIDOS_MAYOR_QUE_45';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);
	
//---------------------------------------------------------------------------------------------------------------------

	//APELLIDOS_FORMATO_INCORRECTO
	$POST['apellidos_usuario'] = 'Cruz D0míngu3z';

	$prueba = 'Los apellidos del usuario no pueden contener más que letras.';
	$codeEsperado = 'APELLIDOS_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO FECHA NACIMIENTO
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&


	//FECHA_NACIMIENTO_VACIA
	$POST['apellidos_usuario'] = 'Cruz Domínguez';
	$POST['fecha_nac'] = '';

	$prueba = 'La fecha no puede ser vacia.';
	$codeEsperado = 'FECHA_NACIMIENTO_VACIA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_NACIMIENTO_FORMATO_INCORRECTO
	$POST['fecha_nac'] = 'Lunes 5 de diciembre';

	$prueba = 'El formato de la fecha no es correcto: aaaa-mm-dd.';
	$codeEsperado = 'FECHA_NACIMIENTO_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

	//---------------------------------------------------------------------------------------------------------------------

	//FECHA_NACIMIENTO_SOLO_NUMEROS_Y_GUIONES
	$POST['fecha_nac'] = 'abcd-11-21';

	$prueba = 'La fecha solo puede contener números y -.';
	$codeEsperado = 'FECHA_NACIMIENTO_SOLO_NUMEROS_Y_GUIONES';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_NACIMIENTO_MENOR_QUE_10
	$POST['fecha_nac'] = '1996-5-2';

	$prueba = 'La fecha de nacimiento no puede ser menor que 10 dígitos.';
	$codeEsperado = 'FECHA_NACIMIENTO_MENOR_QUE_10';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_NACIMIENTO_MAYOR_QUE_10
	$POST['fecha_nac'] = '19999-06-15';

	$prueba = 'La fecha de nacimiento no puede ser mayor que 10 dígitos.';
	$codeEsperado = 'FECHA_NACIMIENTO_MAYOR_QUE_10';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//FECHA_NACIMIENTO_IMPOSIBLE
	$POST['fecha_nac'] = '2300-05-05';

	$prueba = 'La fecha de nacimiento no puede ser mayor a la fecha actual.';
	$codeEsperado = 'FECHA_NACIMIENTO_IMPOSIBLE';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);
	

//---------------------------------------------------------------------------------------------------------------------
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO DIRECCIÓN
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//---------------------------------------------------------------------------------------------------------------------

	//DIRECCION_VACIA
	$POST['fecha_nac'] = '2021-12-06';
	$POST['direccion'] = '';

	$prueba = 'La longitud de la direccion no debe ser vacia.';
	$codeEsperado = 'DIRECCION_VACIA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DIRECCION_MENOR_5
	$POST['direccion'] = 'Dir';

	$prueba = 'La longitud de la direccion no debe ser manor de 5 caracteres.';
	$codeEsperado = 'DIRECCION_MENOR_5';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DIRECCION_MAYOR_200
	$POST['direccion'] = 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum';

	$prueba = 'La longitud de la direccion no debe ser mayor de 200 caracteres.';
	$codeEsperado = 'DIRECCION_MAYOR_200';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//DIRECCION_FORMATO_INCORRECTO
	$POST['direccion'] = '@@@@@';

	$prueba = 'La direccion solo debe contener letras, números º y ª.';
	$codeEsperado = 'DIRECCION_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO TELÉFONO
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//---------------------------------------------------------------------------------------------------------------------

	//TELEFONO_VACIO
	$POST['direccion'] = 'salvador Dalí portal 10º piso 6º A ';
	$POST['telefono'] = '';

	$prueba = 'El número de teléfono no puede ser vacio.';
	$codeEsperado = 'TELEFONO_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//TELEFONO_MENOR_QUE_9
	$POST['telefono'] = '9882545';

	$prueba = 'El tamaño del número de teléfono no puede ser menor que 9.';
	$codeEsperado = 'TELEFONO_MENOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//TELEFONO_MAYOR_QUE_9
	$POST['telefono'] = '98825457895';

	$prueba = 'El tamaño del número de teléfono no puede ser mayor que 9.';
	$codeEsperado = 'TELEFONO_MAYOR_QUE_9';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//TELEFONO_FORMATO_INCORRECTO
	$POST['telefono'] = 'abcdefghi';

	$prueba = 'El formato del teléfono no es el correcto, deben ser 9 números.';
	$codeEsperado = 'TELEFONO_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
												//ERRORES_ATRIBUTO EMAIL
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//---------------------------------------------------------------------------------------------------------------------

	//EMAIL_VACIO
	$POST['telefono'] = '696696696';
	$POST['email'] = '';

	$prueba = 'El email no puede ser vacío.';
	$codeEsperado = 'EMAIL_VACIO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//EMAIL_LONGITUD_MAXIMA
	$POST['email'] = 'testtesttesttesttesttesttesttesttesttesttesttest@test.test';

	$prueba = 'El email debe tener menos de 40 caracteres.';
	$codeEsperado = 'EMAIL_LONGITUD_MAXIMA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//EMAIL_LONGITUD_MINIMA
	$POST['email'] = 't@t.t';

	$prueba = 'El email debe tener por lo menos 6 caracteres.';
	$codeEsperado = 'EMAIL_LONGITUD_MINIMA';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);

//---------------------------------------------------------------------------------------------------------------------

	//EMAIL_FORMATO_INCORRECTO
	$POST['email'] = 'test.com';

	$prueba = 'El formato del email no es correcto.';
	$codeEsperado = 'EMAIL_FORMATO_INCORRECTO';
	$pruebas->hacerPrueba($POST, $POST['controller'], $POST['action'], $atributo, $prueba, $codeEsperado);



	$pruebas->desconectarCurl($pruebas->cliente);

	return $pruebas->resultadoTest;
}

?>