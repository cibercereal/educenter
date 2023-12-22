<?php

    class trabajosAcciones{
        function insertar(){
            include_once './Testing/GestionTrabajos/Acciones/pruebaREST_Trabajos_Insertar_Acciones.php';
            $rest = pruebaREST_Trabajos_Insertar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_INSERTAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_INSERTAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionTrabajos/Acciones/pruebaREST_Trabajos_Buscar_Acciones.php';
            $rest = pruebaREST_Trabajos_Buscar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_BUSCAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_BUSCAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionTrabajos/Acciones/pruebaREST_Trabajos_Borrar_Acciones.php';
            $rest = pruebaREST_Trabajos_Borrar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_BORRAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_BORRAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionTrabajos/Acciones/pruebaREST_Trabajos_Editar_Acciones.php';
            $rest = pruebaREST_Trabajos_Editar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_EDITAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_EDITAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

    }
    
?>