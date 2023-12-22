<?php

    class usuarioAtributos{
        function insertar(){
            include_once './Testing/GestionUsuarios/Atributos/pruebaREST_Usuario_Insertar_Atributos.php';
            $rest = pruebaREST_Usuario_Insertar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_INSERTAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_INSERTAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionUsuarios/Atributos/pruebaREST_Usuario_Borrar_Atributos.php';
            $rest = pruebaREST_Usuario_Borrar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_BORRAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_BORRAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionUsuarios/Atributos/pruebaREST_Usuario_Buscar_Atributos.php';
            $rest = pruebaREST_Usuario_Buscar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_BUSCAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_BUSCAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionUsuarios/Atributos/pruebaREST_Usuario_Editar_Atributos.php';
            $rest = pruebaREST_Usuario_Editar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_EDITAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_EDITAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editarContrasena(){
            include_once './Testing/GestionUsuarios/Atributos/pruebaREST_Usuario_EditarContrasena_Atributos.php';
            $rest = pruebaREST_Usuario_EditarContrasena_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_EDITARCONTRASENA_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_EDITARCONTRASENA_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function verEnDetalle(){
            include_once './Testing/GestionUsuarios/Atributos/pruebaREST_Usuario_VerEnDetalle_Atributos.php';
            $rest = pruebaREST_Usuario_VerEnDetalle_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_VERENDETALLE_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_VERENDETALLE_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function reactivar(){
            include_once './Testing/GestionUsuarios/Atributos/pruebaREST_Usuario_Reactivar_Atributos.php';
            $rest = pruebaREST_Usuario_Reactivar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_REACTIVAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_REACTIVAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>