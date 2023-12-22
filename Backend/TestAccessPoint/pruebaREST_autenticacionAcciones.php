<?php

    class autenticacionAcciones{
        function login(){
            include_once './Testing/Autenticacion/Acciones/pruebaREST_Login_Acciones.php';
            $rest = pruebaREST_Login_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_LOGIN_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_LOGIN_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function registrar(){
            include_once './Testing/Autenticacion/Acciones/pruebaREST_Registro_Acciones.php';
            $rest = pruebaREST_Registro_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_REGISTRO_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_REGISTRO_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function obtenerContrasenaCorreo(){
            include_once './Testing/Autenticacion/Acciones/pruebaREST_ObtenerContrasenaCorreo_Acciones.php';
            $rest = pruebaREST_ObtenerContrasenaCorreo_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_OBTENER_CONTRASENA_CORREO_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_OBTENER_CONTRASENA_CORREO_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
    
?>