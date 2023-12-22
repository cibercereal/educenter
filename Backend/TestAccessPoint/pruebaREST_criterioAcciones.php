<?php

    class criterioAcciones{
        function insertar(){
            include_once './Testing/GestionCriterio/Acciones/pruebaREST_Criterio_Insertar_Acciones.php';
            $rest = pruebaREST_Criterio_Insertar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_INSERTAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_INSERTAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionCriterio/Acciones/pruebaREST_Criterio_Buscar_Acciones.php';
            $rest = pruebaREST_Criterio_Buscar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_BUSCAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_BUSCAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionCriterio/Acciones/pruebaREST_Criterio_Borrar_Acciones.php';
            $rest = pruebaREST_Criterio_Borrar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_BORRAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_BORRAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionCriterio/Acciones/pruebaREST_Criterio_Editar_Acciones.php';
            $rest = pruebaREST_Criterio_Editar_Acciones();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_EDITAR_ACCIONES_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_EDITAR_ACCIONES_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
    
?>