<?php

    class criterioCompetenciaAtributos{
        function insertar(){
            include_once './Testing/GestionCriterioCompetencia/Atributos/pruebaREST_CriterioCompetencia_Insertar_Atributos.php';
            $rest = pruebaREST_CriterioCompetencia_Insertar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIOCOMPETENCIA_INSERTAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIOCOMPETENCIA_INSERTAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function borrar(){
            include_once './Testing/GestionCriterioCompetencia/Atributos/pruebaREST_CriterioCompetencia_Borrar_Atributos.php';
            $rest = pruebaREST_CriterioCompetencia_Borrar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIOCOMPETENCIA_BORRAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIOCOMPETENCIA_BORRAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }

        function buscar(){
            include_once './Testing/GestionCriterioCompetencia/Atributos/pruebaREST_CriterioCompetencia_Buscar_Atributos.php';
            $rest = pruebaREST_CriterioCompetencia_Buscar_Atributos();
            $respuesta['datos'] = $rest;
            if(calcularCodeExito($respuesta['datos'])){
                $respuesta['code'] = 'PETICION_TEST_CRITERIOCOMPETENCIA_BUSCAR_ATRIBUTOS_EXITO';
            }
            else{
                $respuesta['code'] = 'PETICION_TEST_CRITERIOCOMPETENCIA_BUSCAR_ATRIBUTOS_FRACASO';
            }
            devolverRespuestaTest($respuesta);
        }
    }
?>