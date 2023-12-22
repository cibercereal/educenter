<?php

    class criterioAtributos{
        function insertar(){
            include_once './Testing/GestionCriterio/Atributos/pruebaREST_Criterio_Insertar_Atributos.php';
            $rest = pruebaREST_Criterio_Insertar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_INSERTAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_INSERTAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionCriterio/Atributos/pruebaREST_Criterio_Borrar_Atributos.php';
            $rest = pruebaREST_Criterio_Borrar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_BORRAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_BORRAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionCriterio/Atributos/pruebaREST_Criterio_Buscar_Atributos.php';
            $rest = pruebaREST_Criterio_Buscar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_BUSCAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_BUSCAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionCriterio/Atributos/pruebaREST_Criterio_Editar_Atributos.php';
            $rest = pruebaREST_Criterio_Editar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_EDITAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIO_EDITAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>