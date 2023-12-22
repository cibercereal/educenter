<?php

    class competenciasAtributos{
        function insertar(){
            include_once './Testing/GestionCompetencias/Atributos/pruebaREST_Competencias_Insertar_Atributos.php';
            $rest = pruebaREST_Competencias_Insertar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_INSERTAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_INSERTAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionCompetencias/Atributos/pruebaREST_Competencias_Borrar_Atributos.php';
            $rest = pruebaREST_Competencias_Borrar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_BORRAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_BORRAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionCompetencias/Atributos/pruebaREST_Competencias_Buscar_Atributos.php';
            $rest = pruebaREST_Competencias_Buscar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_BUSCAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_BUSCAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function editar(){
            include_once './Testing/GestionCompetencias/Atributos/pruebaREST_Competencias_Editar_Atributos.php';
            $rest = pruebaREST_Competencias_Editar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_EDITAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_EDITAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function asignar(){
            include_once './Testing/GestionCompetencias/Atributos/pruebaREST_Competencias_Asignar_Atributos.php';
            $rest = pruebaREST_Competencias_Asignar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_ASIGNAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_COMPETENCIAS_ASIGNAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>