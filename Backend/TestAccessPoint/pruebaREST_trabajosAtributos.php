<?php

    class trabajosAtributos{
        function insertar(){
            include_once './Testing/GestionTrabajos/Atributos/pruebaREST_Trabajos_Insertar_Atributos.php';
            $rest = pruebaREST_Trabajos_Insertar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_INSERTAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_INSERTAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionTrabajos/Atributos/pruebaREST_Trabajos_Borrar_Atributos.php';
            $rest = pruebaREST_Trabajos_Borrar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_BORRAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_BORRAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionTrabajos/Atributos/pruebaREST_Trabajos_Buscar_Atributos.php';
            $rest = pruebaREST_Trabajos_Buscar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_BUSCAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_BUSCAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionTrabajos/Atributos/pruebaREST_Trabajos_Editar_Atributos.php';
            $rest = pruebaREST_Trabajos_Editar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_EDITAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_TRABAJOS_EDITAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>