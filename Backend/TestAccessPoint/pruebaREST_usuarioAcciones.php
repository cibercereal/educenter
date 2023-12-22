<?php

    class usuarioAcciones{
        function insertar(){
            include_once './Testing/GestionUsuarios/Acciones/pruebaREST_Usuario_Insertar_Acciones.php';
            $rest = pruebaREST_Usuario_Insertar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_INSERTAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_INSERTAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionUsuarios/Acciones/pruebaREST_Usuario_Buscar_Acciones.php';
            $rest = pruebaREST_Usuario_Buscar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_BUSCAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_BUSCAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionUsuarios/Acciones/pruebaREST_Usuario_Borrar_Acciones.php';
            $rest = pruebaREST_Usuario_Borrar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_BORRAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_BORRAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionUsuarios/Acciones/pruebaREST_Usuario_Editar_Acciones.php';
            $rest = pruebaREST_Usuario_Editar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_EDITAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_EDITAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editarContrasena(){
            include_once './Testing/GestionUsuarios/Acciones/pruebaREST_Usuario_EditarContrasena_Acciones.php';
            $rest = pruebaREST_Usuario_EditarContrasena_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_EDITARCONTRASENA_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_EDITARCONTRASENA_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function verEnDetalle(){
            include_once './Testing/GestionUsuarios/Acciones/pruebaREST_Usuario_VerEnDetalle_Acciones.php';
            $rest = pruebaREST_Usuario_VerEnDetalle_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_VERENDETALLE_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_VERENDETALLE_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function reactivar(){
            include_once './Testing/GestionUsuarios/Acciones/pruebaREST_Usuario_Reactivar_Acciones.php';
            $rest = pruebaREST_Usuario_Reactivar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_USUARIO_REACTIVAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_USUARIO_REACTIVAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

    }
    
?>