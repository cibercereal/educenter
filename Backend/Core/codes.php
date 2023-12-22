<?php

    define('LOGIN_USUARIO_OK', 'Usuario logueado correctamente.');
	define('REGISTRAR_USUARIO_OK', 'Usuario registrado correctamente.');
	define('RECUPERAR_CONTRASENA_EMAIL_OK', 'La contraseña ha sido cambiada, revise su correo.');

    define('PETICION_INVALIDA', 'Petición invalida.');
	define('ACCION_NO_ENCONTRADA', 'Acción no encontrada.');
	define('ACCION_DENEGADA_TEST', 'Solo el administrador tiene permitido ejecutar el test.');

	define('DNI_VACIO', 'El DNI es vacio.');
	define('DNI_MENOR_QUE_9', 'El DNI no puede tener menos de 9 caracteres.');
	define('DNI_MAYOR_QUE_9', 'El DNI no puede tener mayor de 9 caracteres.');
	define('DNI_FORMATO_INCORRECTO', 'El formato del DNI es incorrecto, deben ser 8 números y una letra.');
	define('DNI_LETRA_INCORRECTA', 'La letra introducida en el DNI no es la correcta.');

	define('USUARIO_NO_EXISTE', 'El usuario no existe en el sistema.');
	define('CONTRASENA_INCORRECTO', 'La contraseña no es correcta.');
	define('USUARIO_ELIMINADO', 'El usuario está eliminado.');
	define('USUARIO_YA_EXISTE', 'Ya existe el usuario en el sistema.');
	define('EMAIL_YA_EXISTE', 'Ya existe un usuario con ese email.');
	define('EMAIL_NO_EXISTE', 'No existe el email.');
	define('USUARIO_EMAIL_NO_COINCIDEN', 'El usuario y el email no coinciden.');

	define('LOGIN_USUARIO_VACIO', 'El login de usuario es vacio.');
	define('LOGIN_USUARIO_MENOR_QUE_3', 'El tamaño del nombre de usuario no puede ser menor que 3.');
	define('LOGIN_USUARIO_MAYOR_QUE_15', 'El tamaño del nombre de usuario no puede ser mayor que 15.');
	define('LOGIN_USUARIO_ALFANUMERICO_INCORRECTO', 'El nombre de usuario no puede contener más que letras y números, no se aceptan caracteres en blanco, ñ, acentos o carcateres especiales.');

	//contrasena
	define('CONTRASENA_USUARIO_VACIA', 'La contraseña no puede ser vacia.');
	define('CONTRASEÑA_USUARIO_LONGITUD_INCORRECTA', 'Seguridad de la password comprometida. Longitud de password incorrecta.');
	define('CONTRASEÑA_USUARIO_ALFANUMERICO_INCORRECTO', 'La contraseña de usuario no puede contener más que letras y números, no se aceptan caracteres en blanco, ñ, acentos o carcateres especiales.'); 


	//nombre
	define('NOMBRE_VACIO', 'El nombre no puede ser vacio.');
	define('NOMBRE_FORMATO_INCORRECTO', 'El nombre del usuario no puede contener más que letras.');	
	define('NOMBRE_MENOR_QUE_3', 'El nombre del usuario no puede se menor que 3.');
	define('NOMBRE_MAYOR_QUE_45', 'El nombre del usuario no puede ser mayor que 45.');	

	//apellidos
	define('APELLIDOS_VACIO', 'Los apellidos no pueden ser vacios.');
	define('APELLIDOS_FORMATO_INCORRECTO', 'Los apellidos del usuario no pueden contener más que letras.');
	define('APELLIDOS_MENOR_QUE_3', 'Los apellidos del usuario no pueden se menores que 3.');	
	define('APELLIDOS_MAYOR_QUE_45', 'Los apellidos del usuario no pueden ser mayores que 45.');	

	//fechaNacimiento
	define('FECHA_NACIMIENTO_VACIA', 'La fecha no puede ser vacia.');
	define('FECHA_NACIMIENTO_FORMATO_INCORRECTO', 'El formato de la fecha no es correcto: aaaa-mm-dd.');
	define('FECHA_NACIMIENTO_SOLO_NUMEROS_Y_GUIONES', 'La fecha solo puede contener números y -.');
	define('FECHA_NACIMIENTO_MENOR_QUE_10', 'La fecha de nacimiento no puede ser menor que 10 dígitos.');
	define('FECHA_NACIMIENTO_MAYOR_QUE_10', 'La fecha de nacimiento no puede ser mayor que 10 dígitos.');
	define('FECHA_NACIMIENTO_IMPOSIBLE', 'La fecha de nacimiento no puede ser mayor a la fecha actual.');

	//direccion
	define('DIRECCION_VACIA', 'La longitud de la direccion no debe ser vacia.');
	define('DIRECCION_FORMATO_INCORRECTO', 'La direccion solo debe contener letras, números º y ª.');
	define('DIRECCION_MENOR_5', 'La longitud de la direccion no debe ser manor de 5 caracteres.');
	define('DIRECCION_MAYOR_200', 'La longitud de la direccion no debe ser mayor de 200 caracteres.');

	//telefono
	define('TELEFONO_VACIO', 'El número de teléfono no puede ser vacio.');
	define('TELEFONO_FORMATO_INCORRECTO', 'El formato del teléfono no es el correcto, deben ser 9 números.');
	define('TELEFONO_MENOR_QUE_9', 'El tamaño del número de teléfono no puede ser menor que 9.');
	define('TELEFONO_MAYOR_QUE_9', 'El tamaño del número de teléfono no puede ser mayor que 9.');

	//email
	define('EMAIL_VACIO', 'El email no puede ser vacío.');
	define('EMAIL_LONGITUD_MINIMA', 'El email debe tener por lo menos 6 caracteres.');
	define('EMAIL_LONGITUD_MAXIMA', 'El email debe tener menos de 40 caracteres.');
	define('EMAIL_FORMATO_INCORRECTO', 'El formato del email no es correcto.');

	define('ROL_VACIO', 'El id del rol está vacío');
	define('ID_ROL_ERROR_FORMATO', 'El formato del id del rol es incorrecto');

	define('ADMIN_NO_SE_PUEDE_BORRAR', 'No se puede borrar el administrador del sistema.');
	define('ACCION_DENEGADA_BORRAR_USUARIO', 'Solo el administrador puede borrar un usuario.');
	
	define('ACCION_ES_VACIO', 'La acción no puede estar vacía.');
	define('FUNCIONALIDAD_ES_VACIO', 'La funcionalidad no puede estar vacía.');
	define('ROL_ES_VACIO', 'El rol no puede estar vacío.');
	define('ACCION_VACIO', 'La acción no puede estar vacía.');

	define('MATERIA_YA_EXISTE', 'La materia ya existe en el sistema.');
	define('MATERIA_NO_EXISTE', 'La materia no existe en el sistema.');
	define('ACCION_DENEGADA_INSERTAR_MATERIA', 'La materia solo puede ser añadida por un administrador.');
	define('ACCION_DENEGADA_EDITAR_MATERIA', 'La materia solo puede ser modificada por un administrador.');
	define('ACCION_DENEGADA_ELIMINAR_MATERIA', 'La materia solo puede ser eliminada por un administrador.');
	define('USUARIO_NO_ES_PROFESOR', 'El usuario debe ser un profesor.');
	define('ID_MATERIA_ERROR_FORMATO', 'El formato del id de la materia es erróneo.');
	define('MATERIA_YA_SOLICITADA', 'La materia ya ha sido solicitada por el profesor.');
	define('MATERIA_NO_SOLICITADA', 'La materia no ha sido solicitada por el profesor.');
	define('ACCION_DENEGADA_BORRAR_SOLICITAR_MATERIA', 'La solicitud de borrado de asignación a la materia solo puede ser solicitada por el profesor.');
	define('MATERIA_YA_ASIGNADA', 'La solicitud de materia no se puede realizar puesto a que ya existe profesor para la materia.');
	define('ANADIR_USUARIO_MATERIA_OK', 'El alumno realiza la solicitud de inscripción a una materia correctamente.');

	define('ANADIR_TRABAJO_OK', 'El trabajo ha sido añadido correctamente.');
?>