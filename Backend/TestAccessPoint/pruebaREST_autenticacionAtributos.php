<?php

    class autenticacionAtributos{
        function login(){
            include_once './Testing/Autenticacion/Atributos/pruebaREST_Login_Atributos.php';
            $rest = pruebaREST_Login_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_LOGIN_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_LOGIN_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function registrar(){
            include_once './Testing/Autenticacion/Atributos/pruebaREST_Registro_Atributos.php';
            $rest = pruebaREST_Registro_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_REGISTRO_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_REGISTRO_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function obtenerContrasenaCorreo(){
            include_once './Testing/Autenticacion/Atributos/pruebaREST_ObtenerContrasenaCorreo_Atributos.php';
            $rest = pruebaREST_ObtenerContrasenaCorreo_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_OBTENER_CONTRASENA_CORREO_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_OBTENER_CONTRASENA_CORREO_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }

?>